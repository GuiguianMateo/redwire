<?php

namespace Tests\Feature;

use Tests\TestCase;

class AbsenceTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
}
