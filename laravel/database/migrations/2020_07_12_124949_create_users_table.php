<?php

use App\Enums\UserIdentityTypeEnum;
use App\Enums\UserStatusEnum;
use App\Enums\UserTypeEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string("name", 45);
            $table->string("email", 45)->unique();
            $table->string("password");
            $table->string("identity", 20)->unique();
            $table->enum(
                "identity_type",
                UserIdentityTypeEnum::getConstants()
            )->default(UserIdentityTypeEnum::CPF);
            $table->enum(
                "status",
                UserStatusEnum::getConstants()
            )->default(UserStatusEnum::ACTIVE);
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
        Schema::dropIfExists('users');
    }
}
