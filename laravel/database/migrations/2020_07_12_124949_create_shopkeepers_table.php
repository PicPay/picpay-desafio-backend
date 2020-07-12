<?php

use App\Enums\PersonIdentityTypeEnum;
use App\Enums\PersonStatusEnum;
use App\Enums\PersonTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopkeepersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable("persons")) {
            Schema::create('persons', function (Blueprint $table) {
                $table->bigIncrements('id');
                $table->string("name", 45);
                $table->string("email", 45)->unique();
                $table->string("password");
                $table->string("identity", 20)->unique();
                $table->enum(
                    "identity_type",
                    PersonIdentityTypeEnum::getConstants()
                )->default(PersonIdentityTypeEnum::CPF);
                $table->enum(
                    "status",
                    PersonStatusEnum::getConstants()
                )->default(PersonStatusEnum::ACTIVE);
                $table->enum(
                    "type",
                    PersonTypeEnum::getConstants()
                )->default(PersonTypeEnum::USER);
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('persons');
    }
}
