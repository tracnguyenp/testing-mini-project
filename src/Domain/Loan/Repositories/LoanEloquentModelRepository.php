<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Loan\Repositories;

use TestingAspire\Domain\Loan\Models\Loan;

class LoanEloquentModelRepository implements LoanRepositoryInterface
{
    private Loan $loanModel;

    public function __construct(Loan $loanModel)
    {
        $this->loanModel = $loanModel;
    }

    public function createLoanFromData(array $data)
    {
        return $this->loanModel->create($data);
    }
}
