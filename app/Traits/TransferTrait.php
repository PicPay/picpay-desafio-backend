<?php

namespace App\Traits;

use App\Rules\TransferYourselfRule;
use App\Rules\UserCommonRule;
use App\Rules\UserExistRule;
use App\Rules\UserHasBalanceRule;

trait TransferTrait
{
    public function getFillables()
    {
        return ['payer_id', 'payee_id', 'value'];
    }

    public function getRules()
    {
        return [
            'payer_id' => ['required', 'numeric', new UserCommonRule(), new TransferYourselfRule()],
            'payee_id' => ['required', 'numeric', new UserExistRule()],
            'value' => ['required', 'numeric', new UserHasBalanceRule()]
        ];
    }

    public function getMessages()
    {
        return [];
    }

    public function getAttributes()
    {
        return [
            'payer_id' => __('fields.payer_id'),
            'payee_id' => __('fields.payee_id'),
            'value' => __('fields.value')
        ];
    }

    public function getMessageSuccess()
    {
        return __('messages.transferCreateSuccess');
    }
}
