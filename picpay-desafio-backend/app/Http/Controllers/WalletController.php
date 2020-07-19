<?php

namespace App\Http\Controllers;

use App\Models\Wallet;

class WalletController extends BaseController
{
    public function __construct()
    {
        $this->classe = Wallet::class;
    }
}
