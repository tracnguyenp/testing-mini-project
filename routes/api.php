<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/admins/login', [\TestingAspire\Presentation\Http\Controllers\RestApi\AdminController::class, 'login']);
Route::put('/admins/loans/{loanId}/approve', [\TestingAspire\Presentation\Http\Controllers\RestApi\AdminController::class, 'approveLoan']);

Route::get('/', [\TestingAspire\Presentation\Http\Controllers\RestApi\IndexController::class, 'home']);
Route::post('/customers/register', [\TestingAspire\Presentation\Http\Controllers\RestApi\CustomerController::class, 'register']);
Route::post('/customers/login', [\TestingAspire\Presentation\Http\Controllers\RestApi\CustomerController::class, 'login']);

Route::post('/customers/loans/submit-loan', [\TestingAspire\Presentation\Http\Controllers\RestApi\LoanController::class, 'submitLoan']);
Route::get('/customers/loans', [\TestingAspire\Presentation\Http\Controllers\RestApi\LoanController::class, 'listLoans']);
Route::get('/customers/loans/{loanId}', [\TestingAspire\Presentation\Http\Controllers\RestApi\LoanController::class, 'viewLoan']);

Route::put('/customers/repayments/{repaymentId}/pay', [\TestingAspire\Presentation\Http\Controllers\RestApi\LoanController::class, 'payRepayment']);
