<?php

namespace App\Http\Controllers;

use App\Enums\UserStatusEnum;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\Wallet;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Throwable;

class UserController extends Controller
{
    private const ITEM_PER_PAGE = 15;

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchParams = $request->all();
        $query = User::query();
        $limit = Arr::get($searchParams, 'limit', static::ITEM_PER_PAGE);
        $keyword = Arr::get($searchParams, 'keyword', '');

        if (!empty($role)) {
            $query->whereHas('roles', function ($q) use ($role) {
                $q->where('name', $role);
            });
        }

        if (!empty($keyword)) {
            $query->where(function ($query) use ($keyword) {
                $query->where('name', 'LIKE', '%' . $keyword . '%')
                    ->orWhere('email', 'LIKE', '%' . $keyword . '%');
            });
        }

        $query->orderByDesc('id');
        return UserResource::collection($query->paginate($limit));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateUserRequest $request
     * @return UserResource|JsonResponse
     */
    public function store(CreateUserRequest $request)
    {
        try {
            $user = new User([
                "name" => $request->get("name"),
                "email" => $request->get("email"),
                "password" => Hash::make($request->get("password")),
                "identity_type" => $request->get("identity_type"),
                "identity" => $request->get("identity"),
                "status" => UserStatusEnum::ACTIVE,
            ]);

            DB::transaction(function () use ($user, $request) {
                $user->saveOrFail();

                $wallet = new Wallet();
                $wallet->type = $request->get("wallet_type");
                $wallet->user_id = $user->id;
                $wallet->saveOrFail();
            });
        } catch (Throwable $error) {
            return response()->json(["message" => $error->getMessage()], 500);
        }
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @return UserResource|JsonResponse
     */
    public function show(User $user)
    {
        try {
            $resource = new UserResource($user);
        } catch (Throwable $error) {
            return response()->json(["message" => $error->getMessage()], 500);
        }
        return $resource;
    }

    /**
     * @param UpdateUserRequest $request
     * @param User $user
     * @return UserResource|JsonResponse
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            $user->name = $request->get('name');
            $user->email = $request->get('email');

            if ($request->exists("status")) {
                $user->status = $request->get("status");
            }

            if ($request->exists('password')) {
                $user->password = Hash::make($request->get('password'));
            }

            $user->saveOrFail();
        } catch (Throwable $error) {
            return response()->json(["message" => $error->getMessage()], 500);
        }
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return response()->json(["message" => "Usuário excluído com sucesso."], 204);
        } catch (Exception $e) {
            return response()->json(["message" => "Ocorreu uma falha inesperada ao tentar excluir o usuário."], 500);
        }
    }
}
