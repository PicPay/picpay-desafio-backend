<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UpdateProfileFormRequest;

class ProfileController extends Controller
{
    public function edit()
    {
        return view('profile.edit');
    }

    public function update(UpdateProfileFormRequest $request)
    {
        $user = auth()->user();

        $data = $request->all();

        // para não alterar a senha se estiver vazia
        if (is_null($data['password'])) {
            unset($data['password']);
        }

        $update = $user->update($data);
        if ($update) {
            return redirect()
                    ->route('profile.edit')
                    ->with('success', 'Perfil atualizado com sucesso.');
        }

        return redirect()
                ->back()
                ->with('error', 'Falha ao atualizar o perfil...');
    }
}
