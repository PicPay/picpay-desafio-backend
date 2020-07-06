<?php

namespace App\Services;

use App\Repositories\Contracts\UserRepositoryInterface;

class UserService
{
    /**
     * @var \App\Repositories\Contracts\UserRepositoryInterface
     */
    private $repository;

    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function auth($request)
    {
        try {
            return $this->repository->findWhere('email', $request->email);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function allByFilterPaginate(array $filter)
    {
        try {
            return $this->repository->allByFilterPaginate($filter);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function create(array $data)
    {
        try {
            return $this->repository->create($data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function findById(int $id)
    {
        try {
            return $this->repository->findById($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function update(int $id, array $data)
    {
        try {
            return $this->repository->update($id, $data);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    public function delete(int $id)
    {
        try {
            return $this->repository->delete($id);
        } catch (\Exception $e) {
            throw $e;
        }
    }
}