<?php

namespace App\Rules\Transfer;

use App\Repositories\Contracts\Users\UsersRepositoryContract;
use Illuminate\Contracts\Validation\Rule;

class IsCommonUser implements Rule
{
    /**
     * @var UsersRepositoryContract
     */
    private $userRepository;

    /**
     * Create a new rule instance.
     *
     * @param  UsersRepositoryContract  $userRepository
     */
    public function __construct(UsersRepositoryContract $userRepository)
    {
        $this->userRepository = $userRepository;
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
        return $this->userRepository->isCommonUser($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Lojistas não podem realizar transferências.';
    }
}
