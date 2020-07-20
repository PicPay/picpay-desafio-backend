<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('transactions', function(Blueprint $table)
		{
			$table->integer('transaction_id', true);
			$table->integer('payer_id')->index('fk_transactions_payer_id_idx');
			$table->integer('payee_id')->index('fk_transactions_payee_id_idx');
			$table->decimal('amount', 12);
			$table->timestamp('requested_date')->default(DB::raw('CURRENT_TIMESTAMP'));
			$table->boolean('authorized')->default(0);
			$table->integer('transaction_status_id')->default(1)->index('fk_transactions_transaction_id_idx');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('transactions');
	}

}
