<?php

declare(strict_types=1);

namespace TestingAspire\Application\Providers;

use Illuminate\Support\ServiceProvider;

class JsonServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('json', function () {
            return new \TestingAspire\Application\Services\JsonService();
        });
    }
}
