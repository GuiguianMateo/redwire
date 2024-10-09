<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Bouncer;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        // Définition des autorisations
        Bouncer::allow('admin')->to('user-create');
        Bouncer::allow('admin')->to('user-edit');
        Bouncer::allow('admin')->to('user-delete');
        Bouncer::allow('admin')->to('user-restore');
    }

    /*
    |--------------------------------------------------------------------------
    | Tests pour UserController
    |--------------------------------------------------------------------------
    */

    // Non connecté
    /** @test */
    public function test_non_connected_user_cannot_access_user_index()
    {
        $response = $this->get(route('user.index'));
        $response->assertRedirect(route('login'));
    }

    // Utilisateur sans rôle
    /** @test */
    public function test_user_without_role_can_access_user_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('user.index'));
        $response->assertStatus(200);
        $response->assertViewIs('user.index');
    }


    /** @test */
    public function test_user_without_role_cannot_access_user_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userToEdit = User::factory()->create();

        $response = $this->get(route('user.edit', $userToEdit->id));
        $response->assertStatus(403); // Accès interdit
    }

    /** @test */
    public function test_user_without_role_cannot_update_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userToUpdate = User::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->put(route('user.update', $userToUpdate->id), $data);
        $response->assertStatus(403); // Accès interdit
    }

    /** @test */
    public function test_user_without_role_cannot_destroy_user()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userToDelete = User::factory()->create();

        $response = $this->delete(route('user.destroy', $userToDelete->id));
        $response->assertStatus(403); // Accès interdit
    }

    /** @test */
    public function user_without_role_cannot_access_user_restore()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userToRestore = User::factory()->create();
        $userToRestore->delete();

        $response = $this->get(route('user.restore', $userToRestore->id));
        $response->assertStatus(403); // Accès interdit
    }


    /** @test */
    public function test_user_with_role_can_access_user_edit()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $userToEdit = User::factory()->create();

        $response = $this->get(route('user.edit', $userToEdit->id));
        $response->assertStatus(200);
        $response->assertViewIs('user.edit');
        $response->assertViewHas('user');
    }

    /** @test */
    public function test_user_with_role_can_update_user()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $userToUpdate = User::factory()->create();

        $data = [
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
        ];

        $response = $this->put(route('user.update', $userToUpdate->id), $data);
        $response->assertRedirect(route('user.index'));

        $this->assertDatabaseHas('users', [
            'id' => $userToUpdate->id,
            'name' => $data['name'],
        ]);
    }

    /** @test */
    public function test_user_with_role_can_destroy_user()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $userToDelete = User::factory()->create();

        $response = $this->delete(route('user.destroy', $userToDelete->id));
        $response->assertRedirect(route('user.index'));

        $this->assertSoftDeleted('users', [
            'id' => $userToDelete->id,
        ]);
    }

    /** @test */
    public function user_with_role_can_restore_user()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $userToRestore = User::factory()->create();
        $userToRestore->delete();

        $response = $this->get(route('user.restore', $userToRestore->id)); // Route de restauration
        $response->assertRedirect(route('user.index'));
        $this->assertDatabaseHas('users', [
            'id' => $userToRestore->id,
        ]);
    }
}
