<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class AddForeignKeysToTransactionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			$table->foreign('payee_id', 'fk_transactions_payee_id')->references('user_id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('payer_id', 'fk_transactions_payer_id')->references('user_id')->on('users')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('transaction_status_id', 'fk_transactions_transaction_status_id')->references('transaction_status_id')->on('transaction_status')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('transactions', function(Blueprint $table)
		{
			$table->dropForeign('fk_transactions_payee_id');
			$table->dropForeign('fk_transactions_payer_id');
			$table->dropForeign('fk_transactions_transaction_status_id');
		});
	}

}
