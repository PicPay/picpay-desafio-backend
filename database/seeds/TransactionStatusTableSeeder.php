<?php

use Illuminate\Database\Seeder;

class TransactionStatusTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('transaction_status')->delete();
        
        \DB::table('transaction_status')->insert(array (
            0 => 
            array (
                'transaction_status_id' => 1,
                'description' => 'Pending',
            ),
            1 => 
            array (
                'transaction_status_id' => 2,
                'description' => 'OK',
            ),
            2 => 
            array (
                'transaction_status_id' => 3,
                'description' => 'Cancelled',
            ),
        ));
        
        
    }
}