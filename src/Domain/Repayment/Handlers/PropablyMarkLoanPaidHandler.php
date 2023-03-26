<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Repayment\Handlers;

use TestingAspire\Domain\Loan\Services\LoanService;
use TestingAspire\Domain\Repayment\Events\RepaymentPaidEvent;
use TestingAspire\Domain\Repayment\Models\Repayment;

class PropablyMarkLoanPaidHandler
{
    private LoanService $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function handle(RepaymentPaidEvent $event)
    {
        // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        /** @var \TestingAspire\Domain\Repayment\Models\Repayment $repayment */
        $repayment = $event->getRepayment();
        $allRelatedRepayments = $repayment->loan->repayments;

        $loanPaid = true;
        foreach ($allRelatedRepayments as $relatedRepayment) {
            // phpcs:ignore Generic.Commenting.DocComment.MissingShort
            /** @var \TestingAspire\Domain\Repayment\Models\Repayment $relatedRepayment */
            if ($relatedRepayment->state !== Repayment::STATE_PAID) {
                $loanPaid = false;
                break;
            }
        }

        if ($loanPaid) {
            $this->loanService->markLoanPaid($repayment->loan);
        }
    }
}
