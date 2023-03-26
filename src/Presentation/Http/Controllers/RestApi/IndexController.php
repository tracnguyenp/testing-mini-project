<?php

declare(strict_types=1);

namespace TestingAspire\Presentation\Http\Controllers\RestApi;

use Illuminate\Http\JsonResponse;
use TestingAspire\Application\Facades\Json;
use TestingAspire\Infra\Http\Controllers\BaseRestApiV1Controller;

class IndexController extends BaseRestApiV1Controller
{
    public function home(): JsonResponse
    {
        return Json::buildItems([
            'message' => 'Welcome to Testing Aspire fron npbtrac@gmail Rest API',
        ]);
    }
}
