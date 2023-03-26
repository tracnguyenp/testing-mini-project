<?php

declare(strict_types=1);

namespace TestingAspire\Application\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Response;

class JsonService
{
    /**
     * @param mixed $data
     * @param int $httpStatusCode
     * @param array $extraHeaders
     * @return JsonResponse
     */
    public function buildItems(
        $data,
        $httpStatusCode = 200,
        $extraHeaders = []
    ) {
        $arrHeaders = [
            'Content-Type' => 'application/json; charset=utf-8',
            'Accept-Encoding' => 'gzip, deflate'
        ];

        if ($extraHeaders) {
            $arrHeaders = array_merge($arrHeaders, $extraHeaders);
        }

        return Response::json($data, $httpStatusCode, $arrHeaders, JSON_UNESCAPED_UNICODE);
    }
}
