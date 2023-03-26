<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Http\Controllers\RestApi;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use TestingAspire\Application\Facades\Json;
use TestingAspire\Domain\Loan\Services\LoanService;
use TestingAspire\Domain\Loan\Requests\SubmitLoanRequest;
use TestingAspire\Domain\Repayment\Requests\PayRepaymentRequest;
use TestingAspire\Domain\Repayment\Services\RepaymentService;
use TestingAspire\Infra\Http\Controllers\BaseRestApiV1Controller;

class LoanController extends BaseRestApiV1Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function submitLoan(SubmitLoanRequest $request, LoanService $loanService)
    {
        $loan = $loanService->createLoanForCustomer($request->toArray());
        if (empty($loan)) {
            return Json::buildFailedResponse();
        }

        return Json::buildResponse([
            'id' => $loan->id,
        ]);
    }

    public function listLoans(Request $request, LoanService $loanService)
    {
        $loans = $loanService->listLoansFromCustomer($request->user());

        return Json::buildResponse([
            'data' => $loans,
        ]);
    }

    public function viewLoan(Request $request, LoanService $loanService)
    {
        $loan = $loanService->getLoanOfCustomer($request->user(), $request->route('loanId'));

        return Json::buildResponse([
            'data' => $loan,
        ]);
    }

    public function payRepayment(PayRepaymentRequest $request, RepaymentService $repaymentService)
    {
        $success = $repaymentService->payRepayment(
            $request->user(),
            $request->route('repaymentId'),
            $request->input('amount')
        );

        return $success ? Json::buildSuccessfulResponse() : Json::buildFailedResponse();
    }
}
