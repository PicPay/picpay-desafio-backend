<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class User extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string('name', 54);
            $table->string('document', 15)->unique();
            $table->boolean('is_merchant')->default(false);
            $table->string('email', 90)->unique();
            $table->decimal('balance', 10, 2 )->default(0);
            $table->string('password', 128);
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
        Schema::drop('user');
        
    }
}
