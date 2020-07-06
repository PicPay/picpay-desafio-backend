<?php

namespace App\Repositories;

use App\Exceptions\TransferErrorException;
use App\Exceptions\UnauthorizedServiceException;
use App\Models\Transfer;
use App\Models\Wallet;
use App\Traits\TransferTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class TransferRepository extends Repository
{
    use TransferTrait;

    protected $data;
    protected $model;
    protected $walletModel;

    public function __construct(Request $request)
    {
        $this->data = $request->only($this->getFillables());
        $this->model = new Transfer();
        $this->walletModel = new Wallet();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     * @throws TransferErrorException
     * @throws UnauthorizedServiceException
     */
    public function create()
    {
        $this->validateUser();
        $this->authorize();
        $this->executeTransfer();
        $this->sendMessageSuccess();
        return $this->returnResponseJson($this->data, $this->getMessageSuccess());
    }

    private function validateUser()
    {
        parent::validate($this->data, $this->getRules(), $this->getMessages(), $this->getAttributes());
    }

    /**
     * @throws UnauthorizedServiceException
     */
    private function authorize()
    {
        $response = Http::get('https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6');
        if ($response->json()['message'] !== 'Autorizado') {
            throw new UnauthorizedServiceException();
        }
    }

    /**
     * @throws TransferErrorException
     */
    private function executeTransfer()
    {
        DB::beginTransaction();
        try {
            $payerWallet = $this->walletModel->where('user_id', $this->data['payer_id'])->first();
            $payerWallet->update(['balance' => ($payerWallet->balance - $this->data['value'])]);

            $payeeWallet = $this->walletModel->where('user_id', $this->data['payee_id'])->first();
            $payeeWallet->update(['balance' => ($payeeWallet->balance + $this->data['value'])]);

            $this->model->create($this->data);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new TransferErrorException();
        }
    }

    private function sendMessageSuccess()
    {
        $response = Http::get('https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04');
        if ($response->json()['message'] !== 'Enviado') {
            return false;
            // enviar para uma fila onde um job irá tentar enviar a mensagem novamente.
        }
    }
}
