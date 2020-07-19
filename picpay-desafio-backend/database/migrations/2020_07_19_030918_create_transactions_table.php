<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('payer_id')->unsigned();
            $table->bigInteger('payee_id')->unsigned();
            $table->decimal('value', 6, 2);
            $table->timestamps();

            $table->foreign('payer_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('CASCADE')
                ->onDelete('NO ACTION');

            $table->foreign('payee_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('CASCADE')
                ->onDelete('NO ACTION');
        });
    }

    public function down()
    {
        Schema::table('transactions', function(Blueprint $table) {
           $table->dropForeign(['payer_id']);
           $table->dropColumn(['payee_id']);
           $table->dropForeign(['payer_id']);
           $table->dropColumn(['payee_id']);
        });
        Schema::dropIfExists('transactions');
    }
}
