<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersWalletTable extends Migration
{
    const TABLE = "users_wallet";
    const USERS_TABLE = "users";
    const USER_COLUMN = "user_id";
    const USER_FOREIGN_KEY = "users_id_foreign";

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->decimal("amount");
            $table->integer(self::USER_COLUMN)->unsigned();
            $table
                ->foreign(self::USER_COLUMN, self::USER_FOREIGN_KEY)
                ->on(self::USERS_TABLE)
                ->references("id");
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
        Schema::dropIfExists(self::TABLE);
    }
}
