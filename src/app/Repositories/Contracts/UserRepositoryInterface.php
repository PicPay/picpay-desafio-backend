<?php

namespace App\Repositories\Contracts;

interface UserRepositoryInterface
{
    public function findWhere(string $column, string $parameter);
    public function allByFilterPaginate(array $filter);
    public function create(array $data);
    public function findById(int $id);
    public function update(int $id, array $data);
    public function delete(int $id);
    public function transactionsByUserFilterPaginate(int $user_id, array $filter);
    public function createTransaction(array $data);
}