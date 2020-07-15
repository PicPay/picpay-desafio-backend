<?php

use App\Models\User;
use Laravel\Lumen\Testing\DatabaseMigrations;

class TransferControllerTest extends TestCase
{
    use DatabaseMigrations;
    private const URI = 'api/transaction';

    protected User $payer;
    protected User $payee;
    protected User $company;
    protected float $amount = 10.00;

    public function setUp(): void
    {
        parent::setUp();
        $this->payer = factory('App\Models\User')->create();
        $this->payee = factory('App\Models\User')->create();
        $this->company = factory('App\Models\User')->states('company')->create();
    }

    /**
     * Should return validation errors
     *
     * @return void
     */
    public function testInvalidBody()
    {
        $this->post(self::URI, [])
            ->seeJsonEquals([
                "payee" => ["The payee field is required."],
                "payer" => ["The payer field is required."],
                "value" => ["The value field is required."],
            ]);
    }

    /**
     * Should return 201 with status succeeded
     *
     * @return void
     */
    public function testValidExample()
    {
        $response = $this->post(
            self::URI,
            ["payer" => $this->payer->id, "payee" => $this->payee->id, "value" => $this->amount]
        );
        $response->assertResponseStatus(201);
        $response->seeJsonContains(['status' => 'succeeded']);
        $response->seeJsonContains(['payer_id' => $this->payer->id]);
        $response->seeJsonContains(['payee_id' => $this->payee->id]);
        $response->seeJsonContains(['amount' => (int)($this->amount * 100)]);
    }

    /**
     * Should return 400 transaction not allowed
     *
     * @return void
     */
    public function testSamePayeeAndPayer()
    {
        $response = $this->post(
            self::URI,
            ["payer" => $this->payer->id, "payee" => $this->payer->id, "value" => $this->amount]
        );
        $response->assertResponseStatus(400);
        $response->seeJsonEquals(['message' => 'Transaction not allowed, payee and payer can not be the same.']);
    }

    /**
     * Should return 201 with status invalid for company
     *
     * @return void
     */
    public function testCompanyPayerTransaction()
    {
        $response = $this->post(
            self::URI,
            ["payer" => $this->company->id, "payee" => $this->payee->id, "value" => $this->amount]
        );
        $response->assertResponseStatus(201);
        $response->seeJsonContains(['status' => 'invalid']);
        $response->seeJsonContains(['message' => 'Company user is not allowed to transfer']);
    }


    /**
     * Should return 201 with status succeeded
     *
     * @return void
     */
    public function testCompanyPayeeTransaction()
    {
        $response = $this->post(
            self::URI,
            ["payer" => $this->payer->id, "payee" => $this->company->id, "value" => $this->amount]
        );
        $response->assertResponseStatus(201);
        $response->seeJsonContains(['status' => 'succeeded']);
    }

    /**
     * Should return 201 with status invalid insuficient balance
     *
     * @return void
     */
    public function testInsuficientBalanceTransaction()
    {
        $payerWithZeroBalance = factory('App\Models\User')->create(['balance' => 0]);
        $response = $this->post(
            self::URI,
            ["payer" => $payerWithZeroBalance->id, "payee" => $this->payee->id, "value" => $this->amount]
        );
        $response->assertResponseStatus(201);
        $response->seeJsonContains(['status' => 'invalid']);
        $response->seeJsonContains(['message' => 'Insufficient balance']);
    }

    /**
     * Should return invalid value
     *
     * @return void
     */
    public function testInvalidAmoumt()
    {
        $response = $this->post(
            self::URI,
            ["payer" => $this->payer->id, "payee" => $this->payee->id, "value" => 'invalid']
        );
        $response->seeJsonEquals([
            "value" => ["The value must be a number."]
        ]);
    }

    /**
     * Should return 405
     *
     * @return void
     */
    public function testInvalidMethod()
    {
        $response = $this->put(
            self::URI,
            ["payer" => $this->payer->id, "payee" => $this->payee->id, "value" => 1]
        );
        $response->assertResponseStatus(405);
    }
}
