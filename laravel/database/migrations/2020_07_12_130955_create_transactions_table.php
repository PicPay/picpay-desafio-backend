<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->bigInteger("payer_wallet_id");
            $table->foreign("payer_wallet_id")
                ->references("id")
                ->on("wallets")
                ->onUpdate("CASCADE")
                ->onDelete("NO ACTION");
            $table->bigInteger("payee_wallet_id");
            $table->foreign("payee_wallet_id")
                ->references("id")
                ->on("wallets")
                ->onUpdate("CASCADE")
                ->onDelete("NO ACTION");
            $table->float("value");
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
        Schema::table("transactions", function(Blueprint $table) {
            $table->dropForeign(["payer_wallet_id"]);
            $table->dropForeign(["payee_wallet_id"]);
            $table->dropColumn(["payer_wallet_id"]);
            $table->dropColumn(["payee_wallet_id"]);
        });
        Schema::dropIfExists('transactions');
    }
}
