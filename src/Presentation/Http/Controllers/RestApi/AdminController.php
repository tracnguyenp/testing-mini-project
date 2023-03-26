<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Http\Controllers\RestApi;

use TestingAspire\Domain\User\Models\User;
use TestingAspire\Presentation\Http\Controllers\RestApi\UserController;

class AdminController extends UserController
{
    protected function validateUserRole($role)
    {
        return $role === User::USER_ROLE_ADMIN;
    }
}
