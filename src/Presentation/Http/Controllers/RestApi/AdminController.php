<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Http\Controllers\RestApi;

use Illuminate\Http\Request;
use TestingAspire\Application\Facades\Json;
use TestingAspire\Domain\Loan\Services\LoanService;
use TestingAspire\Domain\User\Models\User;
use TestingAspire\Presentation\Http\Controllers\RestApi\UserController;

class AdminController extends UserController
{
    public function approveLoan(Request $request, LoanService $loanService)
    {
        $success = $loanService->approveLoanFromAdmin($request->user(), $request->route('loanId'));

        return $success ? Json::buildSuccessfulResponse() : Json::buildFailedResponse();
    }

    protected function validateUserRole($role)
    {
        return $role === User::USER_ROLE_ADMIN;
    }
}
