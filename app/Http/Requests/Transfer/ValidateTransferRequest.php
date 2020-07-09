<?php

namespace App\Http\Requests\Transfer;

use App\Repositories\Eloquent\Users\UsersRepository;
use App\Rules\Transfer\IsCommonUser;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\Transfer\HasBalance;

class ValidateTransferRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $userRepository = new UsersRepository();
        return [
            'payer_id' => ['required','exists:users,id', new IsCommonUser($userRepository)],
            'payee_id' => ['required','exists:users,id'],
            'value' => ['required','numeric','min:0.01', new HasBalance($userRepository, $this->input('payer_id'))],
        ];
    }
}
