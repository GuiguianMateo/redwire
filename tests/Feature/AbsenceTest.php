<?php

namespace Tests\Unit;

use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Bouncer;

class AbsenceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Bouncer::allow('admin')->to('absence-create');
        Bouncer::allow('admin')->to('absence-edit');
        Bouncer::allow('admin')->to('absence-show');
        Bouncer::allow('admin')->to('absence-delete');
        Bouncer::allow('admin')->to('absence-restore');
    }

    /*
    |--------------------------------------------------------------------------
    | Tests pour AbsenceController
    |--------------------------------------------------------------------------
    */

    // Non connecté

    public function test_non_connected_user_cannot_access_absence_index()
    {
        $response = $this->get(route('absence.index'));
        $response->assertRedirect(route('login'));
    }

    // Utilisateur sans rôle

    public function test_user_without_role_can_access_absence_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('absence.index'));
        $response->assertStatus(200);
    }


    public function test_user_without_role_can_access_absence_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('absence.create'));
        $response->assertStatus(200);
        $response->assertViewIs('absence.create');
    }


    public function test_user_without_role_can_store_absence()
    {
        $usertest = User::factory()->create();
        $motif = Motif::factory()->create();

        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'user_id' => $usertest->id,
            'motif_id' => $motif->id,
            'debut' => now(),
            'fin' => now()->addDays(2),
            'status' => 'pending',
        ];

        $response = $this->post(route('absence.store'), $data);
        $response->assertRedirect('absence.index');
    }


    public function test_user_without_role_cannot_access_absence_show()
    {
        $user = User::factory()->create();
        $absence = Absence::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route("absence.show", $absence->id));
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_access_absence_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $absence = Absence::factory()->create();

        $response = $this->get(route('absence.edit', $absence->id));
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_update_absence()
    {
        $usertest = User::factory()->create();
        $user = User::factory()->create();
        $motif = Motif::factory()->create();

        $this->actingAs($user);

        $absence = Absence::factory()->create();

        $data = [
            'user_id' => 1,
            'motif_id' => 1,
            'debut' => now(),
            'fin' => now()->addDays(3),
        ];

        $response = $this->put(route('absence.update', $absence->id), $data);
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_destroy_absence()
    {
        $user = User::factory()->create();
        $absence = Absence::factory()->create();
        $this->actingAs($user);

        $response = $this->delete(route('absence.destroy', $absence->id));
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_access_absence_restore()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $absence = Absence::factory()->create();
        $absence->delete();

        $response = $this->get(route('absence.restore', $absence->id));
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_access_absence_demande()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('absence.demande'));
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_change_absence_status()
    {
        $admin = User::factory()->create();
        $this->actingAs($admin);

        $absence = Absence::factory()->create(['status' => 'pending']);

        $data = [
            'status' => 'validate',
        ];

        $response = $this->get(route('absence.status', array_merge(['absence' => $absence->id], $data)));

        $response->assertStatus(403);
        $this->assertDatabaseHas('absences', [
            'id' => $absence->id,
            'status' => 'pending',
        ]);
    }


    /////////////////////////////////////////////////////////////////////

    public function test_user_with_role_can_access_absence_create()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $response = $this->get(route('absence.create'));
        $response->assertStatus(200);
        $response->assertViewIs('absence.create');
    }


    public function test_user_with_role_can_store_absence()
    {
        $user = User::factory()->create();
        $motif = Motif::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $data = [
            'user_id' => $user->id,
            'motif_id' => $motif->id,
            'debut' => now(),
            'fin' => now()->addDays(2),
        ];

        $response = $this->post(route('absence.store'), $data);
        $response->assertRedirect(route('absence.index'));

        $this->assertDatabaseHas('absences', [
            'user_id' => $user->id,
            'motif_id' => $motif->id,
            'debut' => $data['debut'],
            'fin' => $data['fin'],
        ]);
    }


    public function test_user_with_role_can_access_absence_show()
    {
        $user = User::factory()->create();
        $absence = Absence::factory()->create();
        Bouncer::assign('admin')->to($user);
        $this->actingAs($user);

        $response = $this->get(route('absence.show', $absence->id));
        $response->assertStatus(200);
        $response->assertViewIs('absence.show');
    }


    public function test_user_with_role_can_access_absence_edit()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $absence = Absence::factory()->create();

        $response = $this->get(route('absence.edit', $absence->id));
        $response->assertStatus(200);
        $response->assertViewIs('absence.edit');
        $response->assertViewHas('absence');
    }


    public function test_user_with_role_can_update_absence()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $absence = Absence::factory()->create();

        $data = [
            'user_id' => 1,
            'motif_id' => 1,
            'debut' => now(),
            'fin' => now()->addDays(3),
        ];

        $response = $this->put(route('absence.update', $absence->id), $data);
        $response->assertRedirect(route('absence.index'));

        $this->assertDatabaseHas('absences', [
            'id' => $absence->id,
            'fin' => $data['fin'],
        ]);
    }


    public function test_user_with_role_can_destroy_absence()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $absence = Absence::factory()->create();

        $response = $this->delete(route('absence.destroy', $absence->id));
        $response->assertRedirect(route('absence.index'));

        $this->assertSoftDeleted('absences', [
            'id' => $absence->id,
        ]);
    }


    public function test_user_with_role_can_restore_absence()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $absence = Absence::factory()->create();
        $absence->delete();

        $response = $this->get(route('absence.restore', $absence->id));
        $response->assertRedirect(route('absence.index'));
        $this->assertDatabaseHas('absences', [
            'id' => $absence->id,
        ]);
    }


    public function test_user_with_role_can_access_absence_demande()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        $this->actingAs($user);

        $response = $this->get(route('absence.demande'));
        $response->assertStatus(200);
        $response->assertViewIs('absence.demande');
    }


    public function test_user_with_role_can_change_absence_status()
    {
        $admin = User::factory()->create();
        Bouncer::assign('admin')->to($admin);
        $this->actingAs($admin);

        $absence = Absence::factory()->create(['status' => 'pending']);

        $data = [
            'status' => 'validate',
        ];

        $response = $this->get(route('absence.status', array_merge(['absence' => $absence->id], $data)));

        $response->assertRedirect('demande');

        $this->assertDatabaseHas('absences', [
            'id' => $absence->id,
            'status' => 'validate',
        ]);
    }
}
