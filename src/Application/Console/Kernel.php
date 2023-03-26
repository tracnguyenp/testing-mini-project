<?php

declare(strict_types=1);

namespace TestingAspire\Application\Http;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    protected $commands = [
        \TestingAspire\Presentation\Console\Commands\CreateAdminUserConsoleCommand::class,
    ];
}
