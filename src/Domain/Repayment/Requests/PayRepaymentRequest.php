<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Repayment\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class PayRepaymentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'amount' => 'required|numeric',
        ];
    }
}
