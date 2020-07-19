<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

abstract class BaseController extends Controller
{
    protected $classModel;

    public function index(Request $request)
    {
        return $this->classModel::paginate($request->per_page);
    }

    public function show(int $id)
    {
        $resource = $this->classModel::find($id);
        if(is_null($resource)){
            return response()->json('',204);
        }
        return response()->json($resource,200);
    }

    public function update(int $id, Request $request)
    {
        $resource = $this->classModel::find($id);
        if(is_null($resource)){
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }
        $resource->fill($request->all());
        $resource->save();
    }

    public function destroy(int $id)
    {
        $returnedValue = $this->classModel::destroy($id);
        if($returnedValue === 0){
            return response()->json([
                'erro' => 'Recurso não encontrado'
            ], 404);
        }
        return response()->json('', 204);
    }
}
