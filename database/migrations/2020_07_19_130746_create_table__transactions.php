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
            $table->string('status', 30);

            $table->bigInteger('payer_id')->unsigned();
            $table->foreign('payer_id')->references('id')->on('users')->onDelete('cascade');

            $table->bigInteger('payee_id')->unsigned();
            $table->foreign('payee_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();

            $table->index(['payer_id', 'status'], 'payer_id_status');
            $table->index(['payee_id', 'status'], 'payee_id_status');
            $table->index(['payer_id', 'payee_id', 'status'], 'payer_id_payee_id_status');
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
