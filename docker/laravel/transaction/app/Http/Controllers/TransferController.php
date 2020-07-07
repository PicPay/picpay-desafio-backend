<?php

namespace App\Http\Controllers;

use App\Events\Transfer\TransferSave;;
use App\Http\Requests\Transfer\StoreTransfer;
use App\Repositories\PersonRepository;
use App\Repositories\TransferRepository;
use Exception;
use Illuminate\Http\Response;

class TransferController extends Controller
{
    const RECORD_NOT_FOUND = 'Registro não encontrado.';
    const PAYER_NOT_FOUND = 'Pagador não encontrado.';
    const PAYEE_NOT_FOUND = 'Recebedor não encontrado.';
    const COUNDT_SAVE_RECORD = 'Não foi possível salvar o registro.';
    const OK = 'ok';

    protected $transferRepository;
    protected $personRepository;

    public function __construct(TransferRepository $transferRepository, PersonRepository $personRepository)
    {
        $this->transferRepository = $transferRepository;
        $this->personRepository = $personRepository;
    }

    public function show($id)
    {
        try {
            $transfer = $this->transferRepository->getById($id);

            if (!$transfer) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($transfer, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreTransfer $request)
    {
        try {
            $transferData = $request->all();
            $payer = $this->personRepository->getById($transferData['payer']);

            if (!$payer) {
                return response()->json([
                    'message' => self::PAYER_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $payerIsPerson = $this->personRepository->payerIsPerson($payer);

            if (!$payerIsPerson) {
                return response()->json([
                    'message' => self::PAYER_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $payee = $this->personRepository->getById($transferData['payer']);

            if (!$payee) {
                return response()->json([
                    'message' => self::PAYEE_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            dd('fim');
            $transfer = $this->transferRepository->create($request->all());
            event(new TransferSave($transfer->toJson()));
            return response()->json($transfer, Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
