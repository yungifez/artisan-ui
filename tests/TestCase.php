<?php

namespace Yungifez\AprilUI\Tests;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ViewErrorBag;
use Orchestra\Testbench\TestCase as Orchestra;
use TalesFromADev\TailwindMerge\Support\Config;
use Yungifez\AprilUI\AprilUIServiceProvider;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Laravel shares this bag through session middleware. Components that
        // read $errors need it when they render outside a request.
        View::share('errors', new ViewErrorBag);
    }

    protected function tearDown(): void
    {
        // TailwindMerge keeps its merged configuration in a static property.
        // Reset it so a test that uses custom config cannot affect the next test.
        Config::reset();

        parent::tearDown();
    }

    protected function getPackageProviders($app)
    {
        return [
            AprilUIServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('app.debug', false);
    }
}
