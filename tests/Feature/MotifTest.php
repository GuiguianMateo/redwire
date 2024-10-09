<?php

namespace Tests\Feature;

use Tests\TestCase;

class MotifTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_user_without_login_cant_access_at_motif(): void
    {
        $response = $this->get('/motif');

        $response->assertRedirect('/login');
    }

    public function test_user_without_ability_cant_access_at_motif(): void
    {
        $response = $this->get('/motif');

        $response->assertRedirect('/login');
    }
}
