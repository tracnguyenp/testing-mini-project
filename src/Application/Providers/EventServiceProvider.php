<?php

declare(strict_types=1);

namespace TestingAspire\Application\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use TestingAspire\Domain\Repayment\Handlers\PropablyMarkLoanPaidHandler;
use TestingAspire\Domain\Repayment\Events\RepaymentPaidEvent;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
        RepaymentPaidEvent::class => [
            PropablyMarkLoanPaidHandler::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
