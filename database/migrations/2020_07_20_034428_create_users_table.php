<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->integer('user_id', true);
            $table->string('name', 90);
            $table->string('email', 80)->unique('email_UNIQUE');
            $table->string('password');
            $table->string('document', 14)->unique('document_UNIQUE');
            $table->boolean('is_shopkeeper')->default(0);
            $table->decimal('credit_balance', 12)->default(0.00);
            $table->timestamp('creation_date')->default(DB::raw('CURRENT_TIMESTAMP'));
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('users');
    }
}
