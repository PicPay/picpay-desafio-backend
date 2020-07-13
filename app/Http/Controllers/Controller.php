<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    /**
    * Enforce challenge rules
    *
    * @param Request $request
    * @return void
    */
   public function validateRequest(Request $request, string $requestValidationClass)
   {
       $transactionRequest = new $requestValidationClass;

       $this->validate(
           $request,
           $transactionRequest->getRules(),
           $transactionRequest->getMessages()
       );
   }
}
