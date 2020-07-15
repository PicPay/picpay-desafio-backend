<?php


namespace App\Authorizer;


use App\Authorizer\Adapter\AuthorizerAdapterInterface;

class TransactionAuthorizer
{
    protected AuthorizerAdapterInterface $authorizerAdapter;

    public function __construct(AuthorizerAdapterInterface $authorizerAdapter)
    {
        $this->authorizerAdapter = $authorizerAdapter;
    }

    public function authorize() :bool
    {
        return $this->authorizerAdapter->allow();
    }
}