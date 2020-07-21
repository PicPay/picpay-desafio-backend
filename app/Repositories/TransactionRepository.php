<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Pagination\AbstractPaginator;

class TransactionRepository extends BaseRepository
{
    protected $model;

    public function __construct()
    {
        $this->model = Transaction::class;
    }

    public function listPaginate(User $user, array $status = [], $pearPage = 15): AbstractPaginator
    {
        return $this->newQuery()->where('payer_id', $user->id)->whereIn('status', $status)->paginate($pearPage);
    }

    public function findByUserAndId(User $user, int $id): Transaction
    {
        return $this->newQuery()->where([
            ['payer_id', $user->id],
            ['id', $id],
        ])->firstOrFail();
    }
}
