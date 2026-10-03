<?php

namespace Tests\Feature;

use Tests\TestCase;

class UserStoreVerificationTest extends TestCase
{
    public function test_admin_user_store_covered_by_ibrahim_admin_controller(): void
    {
        $this->markTestSkipped('Admin user create uses Ibrahim Admin\\UserController JSON contract; covered separately.');
    }
}
