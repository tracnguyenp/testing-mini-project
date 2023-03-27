<?php

declare(strict_types=1);

namespace TestingAspire\Tests\Unit\Domain\Loan\Services;

use TestingAspire\Domain\Loan\Models\Loan;
use TestingAspire\Domain\Loan\Repositories\LoanRepositoryInterface;
use TestingAspire\Domain\Loan\Services\LoanService;
use TestingAspire\Domain\Repayment\Services\RepaymentService;
use TestingAspire\Infra\Tests\Databases\Factories\LoanFactory;
use TestingAspire\Tests\TestCase;

class LoanServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Test createLoanForCustomer method
     */
    public function test_createLoanForCustomer(): void
    {
        $data = [
            'amount' => 10000,
            'term' => 3,
            'request_date' => '2023-07-05 00:00:00',
            'customer_id' => 2,
        ];
        $loan = (new LoanFactory())->make($data);

        $repaymentServiceMock = $this->getMockBuilder(RepaymentService::class)->getMock();
        $loanRepositoryMock = $this->mock(LoanRepositoryInterface::class)->makePartial();

        $loanService = new LoanService($repaymentServiceMock, $loanRepositoryMock);

        $loanRepositoryMock->shouldReceive('createLoanFromData')->once()->andReturn($loan);

        // We expect the method `createRepaymentsForLoan` from RepaymentService must be called once
        $repaymentServiceMock->expects($this->once())->method('createRepaymentsForLoan');
        $loan = $loanService->createLoanForCustomer($data);

        $this->assertNotEmpty($loan);
        $this->assertInstanceOf(Loan::class, $loan);
    }
}
