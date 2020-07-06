<?php

namespace App\Repositories;

use App\Models\User;
use App\Traits\UserTrait;
use Illuminate\Http\Request;

class UserRepository extends Repository
{
    use UserTrait;

    protected $data;
    protected $model;

    public function __construct(Request $request)
    {
        $this->data = $request->only($this->getFillables());
        $this->model = new User();
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function create()
    {
        $this->validateUser();
        $this->createUser();
        return $this->returnResponseJson($this->data, $this->getMessageSuccess());
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update($id)
    {
        $this->validateUser($id);
        $this->updateUser($id);
        return $this->returnResponseJson($this->data, $this->getMessageSuccess(true));
    }

    private function validateUser($id = null)
    {
        parent::validate($this->data, $this->getRules($id), $this->getMessages(), $this->getAttributes());
    }

    private function createUser()
    {
        $this->model->create($this->data);
    }

    private function updateUser($id)
    {
        $this->model = $this->model->findOrFail($id);
        $this->model->update($this->data);
    }
}
