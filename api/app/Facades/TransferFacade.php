<?php

namespace App\Facades;

use App\Models\Transfer;
use App\Models\User;
use App\Services\TransferService;
use Illuminate\Support\Facades\Facade;

/**
 * Class TransferFacade
 * @package App\Facades
 * @see TransferService
 * @method static Transfer transfer(User $payer, User $payer, int $amount)
 */
class TransferFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'TransferFacade';
    }
}
