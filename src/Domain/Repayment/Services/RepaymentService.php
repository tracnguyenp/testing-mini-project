<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Repayment\Services;

use Carbon\CarbonImmutable;
use InvalidArgumentException;
use TestingAspire\Domain\Loan\Models\Loan;
use TestingAspire\Domain\Repayment\Models\Repayment;
use TestingAspire\Domain\User\Models\User;

class RepaymentService
{
    public function createRepaymentsForLoan(Loan $loan)
    {
        $term = (int) $loan->term;

        for ($i = 0; $i < $term; $i++) {
            $amount = $loan->amount / $term;

            $amount = (float) number_format(floor($amount * 100) / 100, 2, '.', '');
            if ($i === $term - 1) {
                $amount += $loan->amount - ($amount * $term);
            }
            Repayment::create([
                'amount' => $amount,
                'scheduled_date' => CarbonImmutable::createFromDate($loan->request_date)
                    ->addDays(($i + 1) * 7)
                    ->toDateTimeString(),
                'loan_id' => $loan->id,
                'state' => Repayment::STATE_PENDING,
            ]);
        }
    }

    public function payRepayment(User $user, $repaymentId, $amount): bool
    {
        // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        /** @var \TestingAspire\Domain\Repayment\Models\Repayment $repayment */
        $repayment = Repayment::with('loan')->findOrFail($repaymentId);

        if ($repayment->loan->customer_id !== $user->id) {
            throw new InvalidArgumentException('Wrong Customer');
        }

        if ((double) $amount < $repayment->amount) {
            throw new InvalidArgumentException('Invalid repayment amount');
        }

        return $this->getRepaymentPaid($repayment);
    }

    private function getRepaymentPaid(Repayment $repayment): bool
    {
        $loan = $repayment->loan;
        if ($loan->state !== Loan::STATE_APPROVED) {
            throw new InvalidArgumentException('Wrong Loan state');
        }

        if (($repayment->state === Repayment::STATE_PENDING)) {
            $repayment->state = Repayment::STATE_PAID;
            return $repayment->save();
        }

        return false;
    }
}
