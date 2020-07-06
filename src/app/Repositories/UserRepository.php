<?php

namespace App\Repositories;

use App\Entities\User;
use App\Repositories\Contracts\UserRepositoryInterface;

class UserRepository implements UserRepositoryInterface
{
    protected $entity;

    public function __construct(User $user)
    {
        $this->entity = $user;
    }

    public function findWhere(string $column, string $parameter)
    {
        return $this->entity->where($column, $parameter)->firstOrFail();
    }

    public function allByFilterPaginate(array $filter)
    {
        return $this->entity->filter($filter);
    }

    public function create(array $data)
    {
        return $this->entity->firstOrCreate($data);
    }

    public function findById(int $id)
    {
        return $this->entity->findOrFail($id);
    }

    public function update(int $id, array $data)
    {
        $user = $this->entity->findOrFail($id);
        $user->update($data);

        return $user;
    }

    public function delete(int $id)
    {
        $user = $this->entity->findOrFail($id);
        $user->delete();

        return $user;
    }

    public function transactionsByUserFilterPaginate(int $user_id, array $filter)
    {
        $user = $this->findById($user_id);
        return $user->transactions()->latest()->paginate();
    }

    public function createTransaction(array $data)
    {
        $user = $this->findById($data['payer']);
        $user->transactions()->attach($data['payee'], [
            'value' => $data['value'],
            'created_at' => date('Y-m-d h:i:s'),
            'updated_at' => date('Y-m-d h:i:s'),
        ]);
        return $user;
    }
}
