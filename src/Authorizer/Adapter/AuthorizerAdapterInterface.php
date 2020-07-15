<?php


namespace App\Authorizer\Adapter;


interface AuthorizerAdapterInterface
{
    public function allow(): bool;
}