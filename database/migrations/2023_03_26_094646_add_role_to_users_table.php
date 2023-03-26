<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use TestingAspire\Domain\User\Models\User;

class AddRoleToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });

        if (Schema::hasColumn('users', 'role')) {
            return null;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->enum('role', [User::USER_ROLE_ADMIN, User::USER_ROLE_CUSTOMER])->default('customer');
            $table->index('role', 'role_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
}
