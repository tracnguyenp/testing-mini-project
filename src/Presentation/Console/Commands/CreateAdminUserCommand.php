<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Console\Commands;

use Illuminate\Console\Command;
use TestingAspire\Domain\User\Models\User;

class CreateAdminUserCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-admin-user {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the Admin User with {email} {password}';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return bool
     */
    public function handle()
    {
        try {
            $user = User::create([
                'name' => $this->argument('email'),
                'email' => $this->argument('email'),
                'password' => $this->argument('password'),
                'role' => User::USER_ROLE_ADMIN,
            ]);
            $this->info(sprintf('A user with the email %s has been created', $this->argument('email')));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
