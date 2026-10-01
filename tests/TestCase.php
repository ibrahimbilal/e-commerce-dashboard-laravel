<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        $configCache = dirname(__DIR__).'/bootstrap/cache/config.php';
        $routeCache = dirname(__DIR__).'/bootstrap/cache/routes-v7.php';

        if (file_exists($configCache)) {
            $this->fail(
                'Configuration is cached (bootstrap/cache/config.php). Run `php artisan config:clear` before tests.'
            );
        }

        if (file_exists($routeCache)) {
            @unlink($routeCache);
        }

        parent::setUp();

        if ($this->app->configurationIsCached()) {
            $this->fail(
                'Application configuration is cached. Run `php artisan config:clear` before tests.'
            );
        }
    }
}
