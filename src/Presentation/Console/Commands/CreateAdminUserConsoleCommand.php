<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Console\Commands;

use Illuminate\Console\Command;
use TestingAspire\Domain\User\Models\User;

class CreateAdminUserConsoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:create-admin-user {email} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create the Admin User with {email} {password}';

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
                'password' => bcrypt($this->argument('password')),
                'role' => User::USER_ROLE_ADMIN,
            ]);
            $this->info(sprintf(
                'A user with the email %s has been created, id: %s',
                $this->argument('email'),
                $user->id
            ));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
