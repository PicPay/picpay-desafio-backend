<?php

namespace App\Http\Controllers;

use Closure;
use Exception;
use Illuminate\Support\Facades\DB;
use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    public function tryCacthTransaction(Closure $closure)
    {
        try {
            DB::beginTransaction();

            $result = $closure();

            DB::commit();

            return $result;
        } catch (Exception $exception) {
            DB::rollBack();
            throw $exception;
        }
    }
}
