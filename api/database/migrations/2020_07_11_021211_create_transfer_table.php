<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransferTable extends Migration
{
    private const STATUS_NEW = 'new';
    private const STATUS_INVALID = 'invalid';
    private const STATUS_FAIL = 'fail';
    private const STATUS_SUCCEEDED = 'succeeded';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfer', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignId('payer_id')->constrained('user');
            $table->foreignId('payee_id')->constrained('user');
            $table->integer('amount');
            $table->text('message')->nullable();
            $table->enum('status', [
                self::STATUS_NEW,
                self::STATUS_INVALID,
                self::STATUS_FAIL,
                self::STATUS_SUCCEEDED
            ])->default(self::STATUS_NEW);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transfer');
    }
}
