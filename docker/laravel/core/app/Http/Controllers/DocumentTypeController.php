<?php

namespace App\Http\Controllers;

use App\Events\DocumentType\DocumentTypeSave;
use App\Http\Requests\DocumentType\StoreDocumentType;
use App\Http\Requests\DocumentType\UpdateDocumentType;
use App\Repositories\DocumentTypeRepository;
use Exception;
use Illuminate\Http\Response;

class DocumentTypeController extends Controller
{
    const RECORD_NOT_FOUND = 'Registro não encontrado.';
    const COUNDT_SAVE_RECORD = 'Não foi possível salvar o registro.';
    const COUNDT_DELETE_RECORD = 'Não foi possível excluir o registro.';
    const OK = 'ok';

    protected $documentTypeRepository;

    public function __construct(DocumentTypeRepository $documentTypeRepository)
    {
        $this->documentTypeRepository = $documentTypeRepository;
    }

    public function index()
    {
        try {
            $documentType = $this->documentTypeRepository->getAll();
            return response()->json($documentType, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        try {
            $documentType = $this->documentTypeRepository->getById($id);

            if (!$documentType) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            return response()->json($documentType, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function store(StoredocumentType $request)
    {
        try {
            $documentType = $this->documentTypeRepository->create($request->all());
            event(new DocumentTypeSave($documentType->toJson()));
            return response()->json($documentType, Response::HTTP_CREATED);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function update(UpdatedocumentType $request, $id)
    {
        try {
            $documentType = $this->documentTypeRepository->getById($id);

            if (!$documentType) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $updated = $this->documentTypeRepository->update($request->all(), $id);

            if (!$updated){
                throw new Exception(self::COUNDT_SAVE_RECORD);
            }

            event(new DocumentTypeSave($documentType->toJson()));
            $documentType = $this->documentTypeRepository->getById($id);
            return response()->json($documentType, Response::HTTP_OK);
        } catch(\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function delete($id)
    {
        try {
            $documentType = $this->documentTypeRepository->getById($id);

            if (!$documentType) {
                return response()->json([
                    'message' => self::RECORD_NOT_FOUND,
                ], Response::HTTP_NOT_FOUND);
            }

            $deleted = $this->documentTypeRepository->delete($id);

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
