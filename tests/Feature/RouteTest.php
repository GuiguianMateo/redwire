<?php

namespace Tests\Feature;

use Tests\TestCase;

class RouteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_without_login_cant_access_at_dashboard(): void
    {
        $response = $this->get('/motif');

        $response->assertRedirect('/login');
    }

    public function test_user_without_login_cant_access_at_user(): void
    {
        $response = $this->get('/motif');

        $response->assertRedirect('/login');
    }

    public function test_user_without_login_cant_access_at_absence(): void
    {
        $response = $this->get('/motif');

        $response->assertRedirect('/login');
    }

    public function test_user_without_login_cant_access_at_motif(): void
    {
        $response = $this->get('/motif');

        $response->assertRedirect('/login');
    }

    public function test_user_without_login_cant_access_at_demande(): void
    {
        $response = $this->get('/demande');

        $response->assertRedirect('/login');
    }

    public function test_user_without_login_cant_restore_motif(): void
    {
        $response = $this->get('/motif/{motif}/restore');

        $response->assertRedirect('/login');
    }

    public function test_user_without_login_cant_restore_absence(): void
    {
        $response = $this->get('/absence/{absence}/restore');

        $response->assertRedirect('/login');
    }

    public function test_user_without_login_cant_restore_user(): void
    {
        $response = $this->get('/user/{user}/restore');

        $response->assertRedirect('/login');
    }

    public function test_user_without_login_cant_change_absence_status(): void
    {
        $response = $this->get('/status/{absence}/status');

        $response->assertRedirect('/login');
    }
}
