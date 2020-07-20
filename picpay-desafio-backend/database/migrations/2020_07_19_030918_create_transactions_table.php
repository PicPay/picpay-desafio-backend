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
            $table->bigInteger('payer_wallet_id')->unsigned();
            $table->bigInteger('payee_wallet_id')->unsigned();
            $table->decimal('value', 6, 2);
            $table->timestamps();

            $table->foreign('payer_wallet_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('CASCADE')
                ->onDelete('NO ACTION');

            $table->foreign('payee_wallet_id')
                ->references('id')
                ->on('wallets')
                ->onUpdate('CASCADE')
                ->onDelete('NO ACTION');
        });
    }

    public function down()
    {
        Schema::table('transactions', function(Blueprint $table) {
           $table->dropForeign(['payer_wallet_id']);
           $table->dropColumn(['payee_wallet_id']);
           $table->dropForeign(['payer_wallet_id']);
           $table->dropColumn(['payee_wallet_id']);
        });
        Schema::dropIfExists('transactions');
    }
}
