<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TestingAspire\Domain\Loan\Models\Loan;

class CreateLoansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id();
            $table->float('amount');
            $table->integer('term')->unsigned();
            $table->timestamp('request_date');
            $table->unsignedBigInteger('customer_id');
            $table->enum('state', [Loan::STATE_PENDING, Loan::STATE_APPROVED, Loan::STATE_PAID]);
            $table->unsignedBigInteger('approved_by_admin_id')->nullable();
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('users');
            $table->foreign('approved_by_admin_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('loans');
    }
}
