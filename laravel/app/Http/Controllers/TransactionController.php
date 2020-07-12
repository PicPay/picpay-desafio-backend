<?php

namespace App\Http\Controllers;

use App\Enums\WalletTypeEnum;
use App\Http\Requests\TransactionRequest;
use App\Http\Resources\TransactionResource;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class TransactionController extends Controller
{
    private const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $query = Transaction::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $query->orderByDesc('id');
        return TransactionResource::collection($query->paginate($limit));
    }

    /**
     * @param User $user
     * @return Wallet
     * @throws Throwable
     */
    private function getNewWallet(User $user): Wallet
    {
        $wallet = new Wallet();
        $wallet->type = WalletTypeEnum::SHOPKEEPER_WALLET;
        $wallet->user_id = $user->id;
        $wallet->saveOrFail();
        return $wallet;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param TransactionRequest $request
     * @return TransactionResource|JsonResponse
     */
    public function store(TransactionRequest $request)
    {
        try {
            $transaction = new Transaction();
            DB::transaction(function () use ($request, $transaction) {
                $value = floatval($request->get("value"));
                $payer = User::findOrFail(intval($request->get("payer")));
                $payee = User::findOrFail(intval($request->get("payee")));

                $payerWallet = $payer->wallet ?? $this->getNewWallet($payer);
                $payeeWallet = $payee->wallet ?? $this->getNewWallet($payee);

                $payerWallet->subtract($value);
                $payerWallet->saveOrFail();

                $payeeWallet->add($value);
                $payeeWallet->saveOrFail();

                $transaction->value = $value;
                $transaction->payer_wallet_id = $payerWallet->id;
                $transaction->payee_wallet_id = $payeeWallet->id;
                $transaction->saveOrFail();
            });
        } catch (Throwable $error) {
            return response()->json(["message" => $error->getMessage()], 500);
        }
        return new TransactionResource($transaction);
    }

    /**
     * Display the specified resource.
     *
     * @param Transaction $transaction
     * @return TransactionResource|JsonResponse
     */
    public function show(Transaction $transaction)
    {
        try {
            $resource = new TransactionResource($transaction);
        } catch (Throwable $error) {
            return response()->json(["message" => $error->getMessage()], 500);
        }
        return $resource;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Transaction $transaction
     * @return JsonResponse
     */
    public function destroy(Transaction $transaction)
    {
        try {
            $transaction->delete();
            return response()->json(["message" => "Transação excluída com sucesso."], 204);
        } catch (Exception $e) {
            return response()->json(["message" => "Ocorreu uma falha inesperada ao tentar excluir a transação."], 500);
        }
    }
}
