<?php

namespace Tests;

use Illuminate\Support\Facades\Notification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    const DASHBOARD = 'dashboard';

    /**
     * Set up the test case.
     */
    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }

    protected function loginGetRoute()
    {
        return route('login');
    }

    protected function dashboardRoute()
    {
        return route('dashboard');
    }    
}
