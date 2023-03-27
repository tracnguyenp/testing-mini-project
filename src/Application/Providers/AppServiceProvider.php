<?php

declare(strict_types=1);

namespace TestingAspire\Application\Providers;

use Illuminate\Support\ServiceProvider;
use TestingAspire\Domain\Loan\Repositories\LoanEloquentModelRepository;
use TestingAspire\Domain\Loan\Repositories\LoanRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            LoanRepositoryInterface::class,
            LoanEloquentModelRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
