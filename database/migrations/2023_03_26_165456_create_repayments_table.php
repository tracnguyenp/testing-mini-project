<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TestingAspire\Domain\Repayment\Models\Repayment;

class CreateRepaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('repayments', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->timestamp('scheduled_date');
            $table->unsignedBigInteger('loan_id');
            $table->enum('state', [Repayment::STATE_PENDING, Repayment::STATE_PAID]);
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->foreign('loan_id')->references('id')->on('loans');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repayments');
    }
}
