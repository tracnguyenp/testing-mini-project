<?php

declare(strict_types=1);

namespace TestingAspire\Infra\Tests\Databases\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use TestingAspire\Domain\Loan\Models\Loan;

class LoanFactory extends Factory
{
    protected $model = Loan::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => 10000,
            'term' => 3,
            'request_date' => '2024-03-04 00:00:00',
            'customer_id' => 2,
        ];
    }
}
