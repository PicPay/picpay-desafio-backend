<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->char('first_name', 100);
            $table->char('last_name', 200);
            $table->bigInteger('document_identifier')->unique();
            $table->char('email', 45)->unique();
            $table->char('password', 100);
            $table->float('wallet_amount', 30, 2);
            $table->boolean('status')->default(true);
            $table->boolean('is_common')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
