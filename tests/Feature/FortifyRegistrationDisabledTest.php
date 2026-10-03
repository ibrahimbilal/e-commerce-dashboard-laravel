<?php

namespace Tests\Feature;

use Tests\TestCase;

class FortifyRegistrationDisabledTest extends TestCase
{
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
