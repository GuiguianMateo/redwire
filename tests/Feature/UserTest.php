<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Absence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Bouncer;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Bouncer::allow('admin')->to('user-create');
        Bouncer::allow('admin')->to('user-edit');
        Bouncer::allow('admin')->to('user-delete');
        Bouncer::allow('admin')->to('user-restore');
    }


    //Tests pour UserController


    public function test_non_connected_user_cannot_access_user_index()
    {
        $response = $this->get(route('user.index'));
        $response->assertRedirect(route('login'));
    }


    //Tests utilisateur sans role

    public function test_user_without_role_can_access_user_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('user.index'));
        $response->assertStatus(200);
        $response->assertViewIs('user.index');
    }


    public function test_user_without_role_cannot_access_other_user_show()
    {
        $user = User::factory()->create();
        $usertest = User::factory()->create();
        Bouncer::refresh();

        $this->actingAs($user);

        $response = $this->get(route("user.show", $usertest->id));
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_access_user_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $usertest = User::factory()->create();

        $response = $this->get(route('user.edit', $usertest->id));
        $response->assertStatus(403);
    }

    public function test_user_without_role_cannot_update_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $usertest = User::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->put(route('user.update', $usertest->id), $data);
        $response->assertStatus(403);
    }

    public function test_user_without_role_cannot_destroy_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $usertest = User::factory()->create();

        $response = $this->delete(route('user.destroy', $usertest->id));
        $response->assertStatus(403);
    }

    public function test_user_without_role_cannot_restore_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $usertest = User::factory()->create();
        $usertest->delete();

        $response = $this->get(route('user.restore', $usertest->id));
        $response->assertStatus(403);
    }


    //Tests utilisateur avec role

    public function test_connected_user_can_access_other_user_show()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);
        $usertest = User::factory()->create();

        $response = $this->get(route("user.show", $usertest->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.show');
    }


    public function test_user_with_role_can_access_user_edit()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $usertest = User::factory()->create();

        $response = $this->get(route('user.edit', $usertest->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user');
    }

    public function test_user_with_role_can_update_user()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $usertest = User::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->put(route('user.update', $usertest->id), $data);
        $response->assertRedirect(route('user.index'));

        $this->assertDatabaseHas('users', [
            'id' => $usertest->id,
            'name' => $data['name'],
        ]);
    }

    public function test_user_with_role_can_destroy_user()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $usertest = User::factory()->create();

        $response = $this->delete(route('user.destroy', $usertest->id));
        $response->assertRedirect(route('user.index'));

        $this->assertSoftDeleted('users', [
            'id' => $usertest->id,
        ]);
    }


    public function test_user_with_role_cannot_destroy_user_has_ForeightKey()
    {
        $user = User::factory()->create();
        $usertest = User::factory()->create();
        $absence = Absence::factory()->create(['user_id' => $usertest->id]);

        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();
        $this->actingAs($user);

        $response = $this->delete(route('user.destroy', $usertest->id));
        $response->assertRedirect(route('user.index'));

        $this->assertNull($usertest->deleted_at);
    }


    public function test_user_with_role_can_restore_user()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $usertest = User::factory()->create();
        $usertest->delete();

        $response = $this->get(route('user.restore', $usertest->id));
        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseHas('users', [
            'id' => $usertest->id,
        ]);
    }

        //Tests pour UserModel

        public function test_user_has_many_absences()
        {
            $user = User::factory()->create();
            $absences = Absence::factory()->count(3)->create(['user_id' => $user->id]);

            $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $user->absence);
            $this->assertCount(3, $user->absence);
        }
}
