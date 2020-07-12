<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommonAndShopkeeperUsers extends Migration
{
    const USER_TABLE = 'users';
    const COMMON_USER_TABLE = 'common_users';
    const SHOPKEEPER_USER_TABLE = 'shopkeeper_users';

    const USER_COLUMN = "user_id";
    const PRIMARY_COLUMN = "id";
    
    const COMMON_USER_FOREIGN_KEY = 'common_users_user_id_foreign';
    const SHOPKEEPER_USER_FOREIGN_KEY = 'shopkeeper_users_user_id_foreign';
    
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->createUser();
        
        $this->createCommonUser();

        $this->createShopkeeperUser();
    }

    public function createUser()
    {
        Schema::create(self::USER_TABLE, function (Blueprint $table) {
            $table->increments(self::PRIMARY_COLUMN);
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->enum("type", ["Common", "Shopkeeper"])->default("Common");
            $table->timestamps();
        });
    }

    public function createCommonUser()
    {
        Schema::create(self::COMMON_USER_TABLE, function (Blueprint $table) {
            $table->increments(self::PRIMARY_COLUMN);
            $table->string('cpf', 15);
            $table->integer(self::USER_COLUMN)->unsigned();
            $table->foreign(self::USER_COLUMN, self::COMMON_USER_FOREIGN_KEY)
                ->on(self::USER_TABLE)
                ->references(self::PRIMARY_COLUMN);
            $table->timestamps();
        });
    }

    public function createShopkeeperUser()
    {
        Schema::create(self::SHOPKEEPER_USER_TABLE, function (Blueprint $table) {
            $table->increments(self::PRIMARY_COLUMN);
            $table->string('cnpj', 17);
            $table->integer(self::USER_COLUMN)->unsigned();
            $table->foreign(self::USER_COLUMN, self::SHOPKEEPER_USER_FOREIGN_KEY)
                ->on(self::USER_TABLE)
                ->references(self::PRIMARY_COLUMN);
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
        Schema::dropIfExists(self::COMMON_USER_TABLE);
        Schema::dropIfExists(self::SHOPKEEPER_USER_TABLE);
        Schema::dropIfExists(self::USER_TABLE);
    }
}
