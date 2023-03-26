<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Http\Controllers\RestApi;

use Illuminate\Http\Request;
use TestingAspire\Infra\Http\Controllers\BaseRestApiV1Controller;

class LoanController extends BaseRestApiV1Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function submitLoan(Request $request)
    {
        die($request->user()->email);
    }
}
