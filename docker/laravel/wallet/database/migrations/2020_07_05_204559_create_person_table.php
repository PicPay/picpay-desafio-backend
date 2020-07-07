<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('person', function (Blueprint $table) {
            $table->unsignedBigInteger('id');
            $table->string('name', 100)->nullable(false);
            $table->string('document', 40)->nullable(false)->unique();
            $table->unsignedBigInteger('document_type_id')->nullable(false);
            $table->unsignedBigInteger('person_type_id')->nullable(false);
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
        Schema::dropIfExists('person');
    }
}
