<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('fullname', 100)->nullable(false);
            $table->string('email', 70)->nullable(false)->unique();
            $table->string('cpf', 11)->nullable(true)->unique();
            $table->string('cnpj', 14)->nullable(true)->unique();
            $table->string('password')->nullable(false);
            $table->enum('type', ['user', 'store']);
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
