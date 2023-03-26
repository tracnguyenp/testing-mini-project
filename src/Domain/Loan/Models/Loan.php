<?php

declare(strict_types=1);

namespace TestingAspire\Domain\Loan\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use TestingAspire\Domain\Repayment\Models\Repayment;

/**
 * Model for `loans` data
 *
 * @package TestingAspire\Domain\Loan\Models
 * @property int $term
 * @property float $amount
 * @property date $request_date
 * @property int $customer_id
 * @property string $state
 * @property int $approve_by_admin_id
 * @property date $approve_at
 */
class Loan extends Model
{
    use HasFactory;

    const STATE_PENDING = 'PENDING';
    const STATE_APPROVED = 'APPROVED';
    const STATE_PAID = 'PAID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'amount',
        'term',
        'request_date',
        'customer_id',
    ];

    /**
     * Get the Repayments for the loan.
     */
    public function repayments(): HasMany
    {
        return $this->hasMany(Repayment::class);
    }
}
