<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Repayment\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Kleemans\AttributeEvents;
use TestingAspire\Domain\Loan\Models\Loan;
use TestingAspire\Domain\Repayment\Events\RepaymentPaidEvent;

/**
 *
 * @package TestingAspire\Domain\Repayment\Models
 * @property double $amount
 */
class Repayment extends Model
{
    use HasFactory, AttributeEvents;

    const STATE_PENDING = 'PENDING';
    const STATE_PAID = 'PAID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'scheduled_date',
        'state',
        'loan_id',
    ];

    protected $dispatchesEvents = [
        'state:'.self::STATE_PAID => RepaymentPaidEvent::class,
    ];

    /**
     * The Loan that this Repayment belongs to
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }
}
