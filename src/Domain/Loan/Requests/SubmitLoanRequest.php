<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Loan\Requests;

use Carbon\CarbonImmutable;
use Illuminate\Foundation\Http\FormRequest;

class SubmitLoanRequest extends FormRequest {
    public function rules()
    {
        return [
            'amount' => 'required|numeric|min:100|max:900000',
            'term' => 'required|integer|min:0|max:6',
            'request_date' => 'required|date_format:Y-m-d|after:today',
        ];
    }

    public function toArray()
    {
        return [
            'amount' => $this->input('amount'),
            'term' => $this->input('term'),
            'request_date' => CarbonImmutable::createFromTimestamp(strtotime($this->input('request_date')))->toDateTimeString(),
            'customer_id' => $this->user()->id,
        ];
    }
}
