<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Loan\Repositories;

interface LoanRepositoryInterface
{
    public function createLoanFromData(array $data);
}
