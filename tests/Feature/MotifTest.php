<?php

namespace Tests\Unit;

use App\Models\Absence;
use App\Models\Motif;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;
use Bouncer;

class MotifTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Bouncer::allow('admin')->to('motif-create');
        Bouncer::allow('admin')->to('motif-edit');
        Bouncer::allow('admin')->to('motif-delete');
        Bouncer::allow('admin')->to('motif-restore');
    }

    /*
    |--------------------------------------------------------------------------
    | Tests pour MotifController
    |--------------------------------------------------------------------------
    */


    public function test_non_connected_user_cannot_access_motif_index()
    {
        $response = $this->get(route('motif.index'));
        $response->assertRedirect(route('login'));
    }


    public function test_user_without_role_cannot_access_motif_index()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('motif.index'));
        $response->assertStatus(200);
    }


    public function test_user_without_role_cannot_access_motif_create()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->get(route('motif.create'));
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_store_motif()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $data = [
            'titre' => 'Nouveau Motif',
            'is_accessible' => true
        ];

        $response = $this->post(route('motif.store'), $data);
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_access_motif_edit()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $motif = Motif::factory()->create();

        $response = $this->get(route('motif.edit', $motif->id));
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_update_motif()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $motif = Motif::factory()->create();

        $data = [
            'titre' => 'Titre Modifié',
            'is_accessible' => false
        ];

        $response = $this->put(route('motif.update', $motif->id), $data);
        $response->assertStatus(403);
    }


    public function test_user_without_role_cannot_destroy_motif()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $motif = Motif::factory()->create();

        $response = $this->delete(route('motif.destroy', $motif->id));
        $response->assertStatus(403);
    }


    public function user_without_role_cannot_access_restore()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $motif = Motif::factory()->create();
        $motif->delete();

        $response = $this->get(route('motif.restore', $motif->id));
        $response->assertStatus(403);
    }


    public function test_user_with_role_can_access_motif_create()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $response = $this->get(route('motif.create'));
        $response->assertStatus(200);
        $response->assertViewIs('motif.create');
    }


    public function test_user_with_role_can_store_motif()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $data = [
            'titre' => 'Nouveau Motif',
            'is_accessible' => true
        ];

        $response = $this->post(route('motif.store'), $data);
        $response->assertRedirect(route('motif.index'));

        $this->assertDatabaseHas('motifs', [
            'titre' => 'Nouveau Motif',
            'is_accessible_salarie' => true,
        ]);
    }


    public function test_user_with_role_can_access_motif_edit()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $motif = Motif::factory()->create();

        $response = $this->get(route('motif.edit', $motif->id));
        $response->assertStatus(200);
        $response->assertViewIs('motif.edit');
        $response->assertViewHas('motif');
    }


    public function test_user_with_role_can_update_motif()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $motif = Motif::factory()->create();

        $data = [
            'titre' => 'Titre Modifié',
            'is_accessible' => false
        ];

        $response = $this->put(route('motif.update', $motif->id), $data);
        $response->assertRedirect(route('motif.index'));

        $this->assertDatabaseHas('motifs', [
            'id' => $motif->id,
            'titre' => 'Titre Modifié',
            'is_accessible_salarie' => false,
        ]);
    }


    public function test_user_with_role_can_destroy_motif()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $motif = Motif::factory()->create();

        $response = $this->delete(route('motif.destroy', $motif->id));
        $response->assertRedirect(route('motif.index'));

        $this->assertSoftDeleted('motifs', [
            'id' => $motif->id,
        ]);
    }


    public function test_user_with_role_can_restore_motif()
    {
        $user = User::factory()->create();
        Bouncer::assign('admin')->to($user);
        Bouncer::refresh();

        $this->actingAs($user);

        $motif = Motif::factory()->create();
        $motif->delete();

        $response = $this->get(route('motif.restore', $motif->id)); // Assuming you have a restore route
        $response->assertRedirect(route('motif.index'));
        $this->assertDatabaseHas('motifs', [
            'id' => $motif->id,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Tests pour le modèle Motif
    |--------------------------------------------------------------------------
    */


    public function test_motif_has_many_absences()
    {
        $motif = Motif::factory()->create();
        $absences = Absence::factory()->count(3)->create(['motif_id' => $motif->id]);

        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $motif->absence);
        $this->assertCount(3, $motif->absence);
    }
}
