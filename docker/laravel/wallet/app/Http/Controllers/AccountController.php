<?php

namespace App\Http\Controllers;

use App\Http\Requests\Account\StoreAccount;
use App\Http\Requests\Account\UpdateAccount;
use App\Repositories\AccountRepository;
use Exception;
use Illuminate\Http\Response;

class AccountController extends Controller
{
    const RECORD_NOT_FOUND = 'Registro não encontrado.';
    const COUNDT_SAVE_RECORD = 'Não foi possível salvar o registro.';
    const COUNDT_DELETE_RECORD = 'Não foi possível excluir o registro.';
    const OK = 'ok';

    protected $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function index()
    {
        try {
            $account = $this->accountRepository->getAll();
            return response()->json($account, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $account = $this->accountRepository->getById($id);

            if (!$account) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($account, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoreAccount $request)
    {
        try {
            $account = $this->accountRepository->create($request->all());
            return response()->json($account, Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdateAccount $request, $id)
    {
        try {
            $account = $this->accountRepository->getById($id);

            if (!$account) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $updated = $this->accountRepository->update($request->all(), $id);

            if (!$updated){
                throw new Exception(self::COUNDT_SAVE_RECORD);
            }

            $account = $this->accountRepository->getById($id);
            return response()->json($account, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $account = $this->accountRepository->getById($id);

            if (!$account) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->accountRepository->delete($id);

            if (!$deleted) {
                throw new Exception(self::COUNDT_DELETE_RECORD);
            }

            return response()->json([
                'message' => self::OK
            ], Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
