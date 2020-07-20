<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PayeeService
{
    private $accountService;

    public function __construct(AccountService $accountService)
    {
        $this->accountService = $accountService;
    }

    public function getById(int $id): User
    {
        try {
            return $this->accountService->getUserById($id);
        } catch (ModelNotFoundException $exception) {
            throw new ModelNotFoundException('Could not find beneficiary');
        }

        Log::error('ERROR_FIND_PAYEE', [$exception]);
    }
}
