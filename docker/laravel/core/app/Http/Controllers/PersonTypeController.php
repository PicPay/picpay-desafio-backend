<?php

namespace App\Http\Controllers;

use App\Events\PersonType\PersonTypeSave;
use App\Http\Requests\PersonType\StorePersonType;
use App\Http\Requests\PersonType\UpdatePersonType;
use App\Repositories\PersonTypeRepository;
use Exception;
use Illuminate\Http\Response;

class PersonTypeController extends Controller
{
    const RECORD_NOT_FOUND = 'Registro não encontrado.';
    const COUNDT_SAVE_RECORD = 'Não foi possível salvar o registro.';
    const COUNDT_DELETE_RECORD = 'Não foi possível excluir o registro.';
    const OK = 'ok';

    protected $personTypeRepository;

    public function __construct(PersonTypeRepository $personTypeRepository)
    {
        $this->personTypeRepository = $personTypeRepository;
    }

    public function index()
    {
        try {
            $personType = $this->personTypeRepository->getAll();
            return response()->json($personType, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $personType = $this->personTypeRepository->getById($id);

            if (!$personType) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($personType, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StorePersonType $request)
    {
        try {
            $personType = $this->personTypeRepository->create($request->all());
            event(new PersonTypeSave($personType->toJson()));
            return response()->json($personType, Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdatePersonType $request, $id)
    {
        try {
            $personType = $this->personTypeRepository->getById($id);

            if (!$personType) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $updated = $this->personTypeRepository->update($request->all(), $id);

            if (!$updated){
                throw new Exception(self::COUNDT_SAVE_RECORD);
            }

            event(new PersonTypeSave($personType->toJson()));
            $personType = $this->personTypeRepository->getById($id);
            return response()->json($personType, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $personType = $this->personTypeRepository->getById($id);

            if (!$personType) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->personTypeRepository->delete($id);

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
