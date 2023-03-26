<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Repayment\Events;

use TestingAspire\Domain\Repayment\Models\Repayment;

class RepaymentPaidEvent
{
    private Repayment $repayment;

    public function __construct(Repayment $repayment)
    {
        $this->repayment = $repayment;
    }

    public function getRepayment(): Repayment
    {
        return $this->repayment;
    }
}
