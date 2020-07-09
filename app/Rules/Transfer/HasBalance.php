<?php

namespace App\Rules\Transfer;

use App\Repositories\Contracts\Users\UsersRepositoryContract;
use Illuminate\Contracts\Validation\Rule;

class HasBalance implements Rule
{
    /**
     * @var UsersRepositoryContract
     */
    private $userRepository;
    private $payer_id;

    /**
     * Create a new rule instance.
     *
     * @param  UsersRepositoryContract  $userRepository
     * @param $payer_id
     */
    public function __construct(UsersRepositoryContract $userRepository, $payer_id)
    {
        $this->userRepository = $userRepository;
        $this->payer_id = $payer_id;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $value <= $this->userRepository->getAvailableWalletAmount($this->payer_id);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Saldo insuficiente.';
    }
}
