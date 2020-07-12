<?php

use App\Enums\WalletTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->bigInteger("user_id");
            $table->foreign("user_id")
                ->references("id")
                ->on("users")
                ->onUpdate("CASCADE")
                ->onDelete("NO ACTION");
            $table->float("balance");
            $table->enum(
                "type",
                WalletTypeEnum::getConstants()
            )->default(WalletTypeEnum::USER_WALLET);
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
        Schema::table("wallets", function(Blueprint $table) {
            $table->dropForeign(["user_id"]);
            $table->dropColumn(["user_id"]);
        });
        Schema::dropIfExists('wallets');
    }
}
