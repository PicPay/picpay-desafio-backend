<?php

namespace App\Http\Requests\Transaction;

class TransactionRequest {

    /**
     * Rules for validation
     *
     * @return array
     */
    public function getRules(): array
    {
        return [
            'payer' => 'required|exists:common_users,user_id',
            'payee' => 'required|exists:users,id',
            'value' => 'required|regex:/^\d+(\.\d{1,2})?$/'
        ];
    }

    /**
     * Message to help users problem solving
     *
     * @return array
     */
    public function getMessages(): array
    {
        return [
            'payer' => 'The :payer must be a Common user',
            'payee' => 'The :payee must be registered in our database.',
            'value' => 'Value must be unsigned numeric.'
        ];
    }

}