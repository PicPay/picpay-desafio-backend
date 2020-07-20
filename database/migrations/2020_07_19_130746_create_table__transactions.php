<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTransactions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();

            $table->decimal('value');
            $table->decimal('status', 30);

            $table->bigInteger('payer_id')->unsigned();
            $table->foreign('payer_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('payee_id')->unsigned();
            $table->foreign('payee_id')->references('id')->on('users')->onDelete('cascade');

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
        Schema::dropIfExists('transactions');
    }
}
