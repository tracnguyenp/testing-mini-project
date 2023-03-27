<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Loan\Services;

use Carbon\Carbon;
use InvalidArgumentException;
use TestingAspire\Domain\Loan\Models\Loan;
use TestingAspire\Domain\Loan\Repositories\LoanEloquentModelRepository;
use TestingAspire\Domain\Loan\Repositories\LoanRepositoryInterface;
use TestingAspire\Domain\Repayment\Services\RepaymentService;
use TestingAspire\Domain\User\Models\User;

class LoanService
{
    private RepaymentService $repaymentService;
    private LoanRepositoryInterface $loanRepository;

    public function __construct(
        RepaymentService $repaymentService,
        LoanRepositoryInterface $loanRepository
    )
    {
        $this->repaymentService = $repaymentService;
        $this->loanRepository = $loanRepository;
    }

    public function createLoanForCustomer(array $data): Loan
    {
        $loan = $this->loanRepository->createLoanFromData($data);
        $this->repaymentService->createRepaymentsForLoan($loan);

        return $loan;
    }

    public function listLoansFromCustomer(User $user): array
    {
        $loans = Loan::where([
            'customer_id' => $user->id,
        ])->with('repayments')->get()->toArray();

        return $loans;
    }

    public function getLoanOfCustomer(User $user, $loanId): Loan
    {
        // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        /** @var \TestingAspire\Domain\Loan\Models\Loan $loan */
        $loan = Loan::with('repayments')->findOrFail($loanId);
        if ((int) $loan->customer_id !== (int) $user->id) {
            throw new InvalidArgumentException('Wrong customer');
        }

        return $loan;
    }

    public function approveLoanFromAdmin(User $user, $loanId): bool
    {
        if (!$this->isUserAdmin($user)) {
            throw new InvalidArgumentException('Bad Request');
        }

        // phpcs:ignore Generic.Commenting.DocComment.MissingShort
        /** @var \TestingAspire\Domain\Loan\Models\Loan $loan */
        $loan = Loan::with('repayments')->findOrFail($loanId);

        return $this->getLoanApproved($user, $loan);
    }

    public function markLoanPaid(Loan $loan): bool
    {
        $loan->state = Loan::STATE_PAID;

        return $loan->save();
    }

    private function isUserAdmin(User $user): bool
    {
        return $user->role === User::USER_ROLE_ADMIN;
    }

    private function getLoanApproved(User $user, Loan $loan): bool
    {
        if ($loan->state === Loan::STATE_PENDING) {
            $loan->state = Loan::STATE_APPROVED;
            $loan->approved_by_admin_id = $user->id;
            $loan->approved_at = (new Carbon('now'))->toDateTimeString();
            return $loan->save();
        }

        if ($loan->state === Loan::STATE_PAID) {
            throw new InvalidArgumentException('Loan already PAID');
        }

        return true;
    }
}
