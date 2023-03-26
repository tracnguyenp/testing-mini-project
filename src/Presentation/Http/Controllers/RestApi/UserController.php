<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Http\Controllers\RestApi;

use Illuminate\Http\Request;
use TestingAspire\Application\Facades\Json;
use TestingAspire\Domain\User\Models\User;
use TestingAspire\Infra\Http\Controllers\BaseRestApiV1Controller;

class UserController extends BaseRestApiV1Controller
{
    public function register(Request $request)
    {
        $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => bcrypt($request->password),
        ]);

        if (empty($user)) {
            return Json::buildFailedResponse();
        }

        return Json::buildResponse(['user_id' => $user->id]);
    }

    public function login(Request $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (!auth()->guard('client')->attempt($credentials)) {
            return Json::buildFailedResponse();
        }

        $user = auth()->guard('client')->user();
        if (!$this->validateUserRole($user->role)) {
            return Json::buildFailedResponse();
        }

        $token = $user->createToken(env('APP_NAME'))->accessToken;

        return Json::buildResponse([
            'access_token' => $token,
        ]);
    }

    protected function validateUserRole($role)
    {
        return $role === User::USER_ROLE_CUSTOMER;
    }
}
