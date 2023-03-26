<?php

declare(strict_types=1);

namespace TestingAspire\Application\Services;

use Illuminate\Http\JsonResponse;

class JsonService
{
    /**
     * @param mixed $data
     * @param int $httpStatusCode
     * @param array $extraHeaders
     * @return JsonResponse
     */
    public function buildResponse(
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

        return response()->json($data, $httpStatusCode, $arrHeaders, JSON_UNESCAPED_UNICODE);
    }

    public function buildSuccessfulResponse() {
        return $this->buildResponse([
            'status' => 'success'
        ], 200);
    }

    public function buildFailedResponse() {
        return $this->buildResponse([
            'status' => 'failure'
        ], 400);
    }
}
