<?php

namespace Tests\Feature\Transaction;

use Tests\TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Symfony\Component\HttpFoundation\Response;
use Laravel\Lumen\Testing\DatabaseTransactions;

class RequestTest extends TestCase
{
    use DatabaseMigrations;

    const TRANSACTION_API_URL = '/api/v1/transaction';

    const DEFAULT_METHOD = "POST";

    private $payload;

    /**
     *  Setup for payload initialize.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $this->payload = [
            'payer' => 0,
            'payee' => 0,
            'value' => 1
        ];
    }

    /**
     * Sending an prohibited method.
     *
     * @return void
     */
    public function testProhibitedMethodValidation(): void
    {
        $response = $this->call("PUT",self::TRANSACTION_API_URL, $this->payload);

        $this->assertEquals(Response::HTTP_METHOD_NOT_ALLOWED, $response->status());
    }

    /**
     * A basic validation test.
     *
     * @return void
     */
    public function testGeneralValidation(): void
    {
        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->status());
    }

    /**
     * Validating Payer beein Common user
     *
     * @return void
     */
    public function testOnlyCommonUserPayer(): void
    {
        $this->payload["payer"] = $this->createShopkeeper()->id;
        $this->payload["payee"] = $this->createCommonUser()->id;

        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->status());
    }

    /**
     * Verifiyng user register
     * 
     * @return void
     */
    public function testExistsPayeeId(): void
    {
        $this->payload["payer"] = $this->createCommonUser()->id;
        $this->payload["payee"] = 0;

        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->status());
    }

    /**
     * Validate negative numbers
     * 
     * @return void
     */
    public function testNegativeValue(): void
    {
        $this->payload["payer"] = $this->createCommonUser()->id;
        $this->payload["payee"] = $this->createShopkeeper()->id;
        $this->payload["value"] = -1;

        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->status());
    }

    /**
     * Validating values not numeric
     * 
     * @return void
     */
    public function testNotNumberValue(): void
    {
        $this->payload["payer"] = $this->createCommonUser()->id;
        $this->payload["payee"] = $this->createCommonUser()->id;
        $this->payload["value"] = "picpay";

        $response = $this->call(self::DEFAULT_METHOD,self::TRANSACTION_API_URL, $this->payload);

        $this->assertEquals(Response::HTTP_UNPROCESSABLE_ENTITY, $response->status());
    }
}
