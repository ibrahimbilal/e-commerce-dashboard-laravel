<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FortifyRegistrationDisabledTest extends TestCase
{
    use RefreshDatabase;
    public function test_public_register_route_is_not_available(): void
    {
        $this->get('/register')->assertNotFound();
        $this->post('/register', [])->assertNotFound();
    }

    public function test_register_post_is_under_admin_prefix(): void
    {
        $this->post('/admin/register', [])->assertStatus(302);
    }
}
