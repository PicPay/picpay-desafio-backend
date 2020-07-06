<?php

namespace Tests\Unit;

use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TransferApiTest extends TestCase
{
    protected $postLink = 'api/transfers';

    public function setUp(): void
    {
        parent::setUp();
        DB::beginTransaction();
    }

    protected function tearDown(): void
    {
        DB::rollback();
        parent::tearDown();
    }

    public function testTransferUserCommonToUserCommon()
    {
        $payer = User::where('user_type', 'common')->first();
        $payee = User::where('user_type', 'common')->get()->last();

        $walletPayer = $payer->wallet()->first();
        $walletPayee = $payee->wallet()->first();

        $payerBalance = $walletPayer->balance;
        $payeeBalance = $walletPayee->balance;

        $data = [
            "payer_id" => $payer->id,
            'payee_id' => $payee->id,
            'value' => $payerBalance,
            'fieldIgnore' => 'ignored'
        ];

        $response = $this->postJson($this->postLink, $data);

        unset($data['fieldIgnore']);

        $response->assertJson([
            'data' => $data,
            'message' => __('messages.transferCreateSuccess'),
            'success' => true,
            'statusCode' => 200
        ]);

        $payer = User::where('user_type', 'common')->first();
        $payee = User::where('user_type', 'common')->get()->last();

        $walletPayer = $payer->wallet()->first();
        $walletPayee = $payee->wallet()->first();

        $payerBalanceUpdated = $walletPayer->balance;
        $payeeBalanceUpdated = $walletPayee->balance;

        $this->assertEquals(0, $payerBalanceUpdated);
        $this->assertEquals(($payerBalance + $payeeBalance), $payeeBalanceUpdated);
    }

    public function testTransferUserCommonToUserShopkeeper()
    {
        $payer = User::where('user_type', 'common')->first();
        $payee = User::where('user_type', 'shopkeeper')->first();

        $walletPayer = $payer->wallet()->first();
        $walletPayee = $payee->wallet()->first();

        $payerBalance = $walletPayer->balance;
        $payeeBalance = $walletPayee->balance;

        $data = [
            "payer_id" => $payer->id,
            'payee_id' => $payee->id,
            'value' => $payerBalance,
            'fieldIgnore' => 'ignored'
        ];

        $response = $this->postJson($this->postLink, $data);

        unset($data['fieldIgnore']);

        $response->assertJson([
            'data' => $data,
            'message' => __('messages.transferCreateSuccess'),
            'success' => true,
            'statusCode' => 200
        ]);

        $payer = User::where('user_type', 'common')->first();
        $payee = User::where('user_type', 'shopkeeper')->first();

        $walletPayer = $payer->wallet()->first();
        $walletPayee = $payee->wallet()->first();

        $payerBalanceUpdated = $walletPayer->balance;
        $payeeBalanceUpdated = $walletPayee->balance;

        $this->assertEquals(0, $payerBalanceUpdated);
        $this->assertEquals(($payerBalance + $payeeBalance), $payeeBalanceUpdated);
    }

    public function testTransferUserShopkeeperToUserCommonError()
    {
        $payer = User::where('user_type', 'shopkeeper')->first();
        $payee = User::where('user_type', 'common')->first();

        $wallet = $payer->wallet()->first();

        $data = [
            "payer_id" => $payer->id,
            'payee_id' => $payee->id,
            'value' => $wallet->balance,
        ];

        $response = $this->postJson($this->postLink, $data);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'payer_id' => ['The Payer must be an ordinary user.'],
            ]
        ]);
    }

    public function testTransferHigherValueError()
    {
        $payer = User::where('user_type', 'common')->first();
        $payee = User::where('user_type', 'shopkeeper')->first();

        $wallet = $payer->wallet()->first();

        $higherValue = $wallet->balance + 100;

        $data = [
            "payer_id" => $payer->id,
            'payee_id' => $payee->id,
            'value' => $higherValue,
        ];

        $response = $this->postJson($this->postLink, $data);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'value' => ['The balance is less than ' . $higherValue . '.'],
            ]
        ]);
    }

    public function testTransferRequireValidationError()
    {
        $data = [
            "payer_id" => '',
            'payee_id' => '',
            'value' => '',
        ];

        $response = $this->postJson($this->postLink, $data);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'payer_id' => ['The Payer field is required.'],
                'payee_id' => ['The Payee field is required.'],
                'value' => ['The Value field is required.'],
            ]
        ]);
    }

    public function testTransferNumericValidationError()
    {
        $data = [
            "payer_id" => 'a',
            'payee_id' => 'b',
            'value' => 'c',
        ];

        $response = $this->postJson($this->postLink, $data);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'payer_id' => [
                    'The Payer must be a number.',
                    'The Payer does not exist.',
                ],
                'payee_id' => [
                    'The Payee must be a number.',
                    'The Payee does not exist.',
                ],
                'value' => [
                    'The Value must be a number.',
                    'The balance is less than c.',
                ],
            ]
        ]);
    }

    public function testTransferYourselfError()
    {
        $payer = User::where('user_type', 'common')->first();
        $payee = User::where('user_type', 'common')->first();

        $wallet = $payer->wallet()->first();

        $data = [
            "payer_id" => $payer->id,
            'payee_id' => $payee->id,
            'value' => $wallet->balance,
        ];

        $response = $this->postJson($this->postLink, $data);
        $response->assertJson([
            'message' => 'The given data was invalid.',
            'errors' => [
                'payer_id' => ['It is not possible to transfer to yourself.'],
            ]
        ]);
    }
}
