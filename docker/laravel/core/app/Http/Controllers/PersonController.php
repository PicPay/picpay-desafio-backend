<?php

namespace App\Http\Controllers;

use App\Http\Requests\Person\StorePerson;
use App\Http\Requests\Person\UpdatePerson;
use App\Repositories\PersonRepository;
use Exception;
use Illuminate\Http\Response;

class PersonController extends Controller
{
    const RECORD_NOT_FOUND = 'Registro não encontrado.';
    const COUNDT_SAVE_RECORD = 'Não foi possível salvar o registro.';
    const COUNDT_DELETE_RECORD = 'Não foi possível excluir o registro.';
    const OK = 'ok';

    protected $personRepository;

    public function __construct(PersonRepository $personRepository)
    {
        $this->personRepository = $personRepository;
    }

    public function index()
    {
        try {
            $person = $this->personRepository->getAll();
            return response()->json($person, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $person = $this->personRepository->getById($id);

            if (!$person) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($person, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StorePerson $request)
    {
        try {
            $person = $this->personRepository->create($request->all());
            return response()->json($person, Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdatePerson $request, $id)
    {
        try {
            $person = $this->personRepository->getById($id);

            if (!$person) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $updated = $this->personRepository->update($request->all(), $id);

            if (!$updated){
                throw new Exception(self::COUNDT_SAVE_RECORD);
            }

            $person = $this->personRepository->getById($id);
            return response()->json($person, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $person = $this->personRepository->getById($id);

            if (!$person) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->personRepository->delete($id);

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
