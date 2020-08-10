<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageQueueTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_queue', function (Blueprint $table) {
            $table->integer('message_id', true);
            $table->integer('user_id')->index('fk_message_queue_user_id_idx');
            $table->string('content', 256);
            $table->boolean('sent')->default(0);
            $table->string('send_date', 45)->nullable();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('message_queue');
    }
}
