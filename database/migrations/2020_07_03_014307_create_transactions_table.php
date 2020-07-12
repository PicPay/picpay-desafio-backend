<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{

    const TABLE = "transactions";
    const USERS_TABLE = "users";
    const USERS_PRIMARY_COLUMN = "id";
    const PAYER_COLUMN = "payer";
    const PAYEE_COLUMN = "payee";
    const PAYER_FOREIGN_KEY = "users_payer_id_foreign";
    const PAYEE_FOREIGN_KEY = "users_payee_id_foreign";


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->increments('id');
            $table->integer(self::PAYER_COLUMN)->unsigned();
            $table->integer(self::PAYEE_COLUMN)->unsigned();
            $table->decimal("value");
            $table->enum("status", ['pending', 'authorized', 'approved', 'inconsistency']);
            $table
                ->foreign(self::PAYER_COLUMN, self::PAYER_FOREIGN_KEY)
                ->on(self::USERS_TABLE)
                ->references(self::USERS_PRIMARY_COLUMN);
            $table
                ->foreign(self::PAYEE_COLUMN, self::PAYEE_FOREIGN_KEY)
                ->on(self::USERS_TABLE)
                ->references(self::USERS_PRIMARY_COLUMN);

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
