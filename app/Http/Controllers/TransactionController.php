<?php

namespace App\Http\Controllers;

use App\Repositories\ApiRepository;
use App\Transaction;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    protected $apiRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(ApiRepository $apiRepository)
    {
        $this->middleware('auth');

        $this->apiRepository = $apiRepository;
    }

    /**
     * Display a listing of the users for pay.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $balance = auth()->user()->balance();

        $users = User::where('id', '!=', auth()->id())->paginate(10);

        return view('transactions.index', compact('balance', 'users'));
    }

    /**
     * Store a newly created transaction in storage.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $value = money_to_float($request->value);

            $can_pay = auth()->user()->canPay($value);

            if (!$can_pay) {
                return response()->json(['message' => 'Operação não permitada'], 401);
            }

            $params = [
                'payer_id' => auth()->id(),
                'payee_id' => $request->payee_id,
                'message' => $request->message,
                'value' => $value,
            ];

            if(!$this->authorizationService($params)) {
                return response()->json(['message' => 'Operação não permitada'], 401);
            }

            $this->notificationService($params);

            Transaction::create($params);

            DB::commit();

            return response()->json(['message' => 'Transferência realizada com sucesso'], 200);
        } catch (\Exception $e) {
            DB::rollback();
            logger()->error((string)$e);

            return response()->json(['message' => 'Houve um erro na solicitação'], 500);
        }
    }

    /**
     * @param $params
     * @return bool
     */
    public function authorizationService($params)
    {
        $uri = 'https://run.mocky.io/v3/8fafdd68-a090-496f-8c9a-3442cf30dae6';

        $response_api = $this->apiRepository->connect($uri, $params);

        if (
            isset($response_api['success']) &&
            $response_api['success']
        ) {
            return true;
        }

        return false;
    }

    /**
     * @param $params
     * @return bool
     */
    public function notificationService($params)
    {
        $uri = 'https://run.mocky.io/v3/b19f7b9f-9cbf-4fc6-ad22-dc30601aec04';

        $response_api = $this->apiRepository->connect($uri, $params);

        if (
            isset($response_api['success']) &&
            $response_api['success']
        ) {
            return true;
        }

        return false;
    }
}
