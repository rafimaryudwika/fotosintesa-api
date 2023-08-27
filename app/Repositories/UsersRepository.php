<?php

namespace App\Repositories;

use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use Exception;
use App\Models\User;
use App\Traits\ResponseAPI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Request;

/**
 * Di Repository, kita fokuskan kepada data fetching
 */
class UsersRepository
{
    use ResponseAPI;


    public function __construct(
        protected User $users
    ) {
    }

    public function getCurrentUser(Request $request = null)
    {
        $res = $this->users->with('Roles')->findOrFail(Auth::user()->id);

        // return UserResource::collection($res);
        return $res;
    }

    public function getData(int $id = null)
    {
        $users = $this->users
            ->with('Roles')
            ->when($id, fn ($q) => $q->findOrFail($id))
            ->get();

        if (!$id) {
            return UserResource::collection($users);
        }

        return new UserResource($users->first());
    }

    public function requestData(UserRequest $request, int $id = null)
    {
            $params = [
                'name' => $request->name,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'password' => Hash::make($request->password),
                'role' => $request->role,
                'peserta' => $request->peserta,
            ];

            if(!$id) {
                return $this->users->insert($params);
            }

            $find = $this->users->findOrFail($id);

            return $find->update($params);
    }

    public function deleteData($id)
    {
        $currentUser = Auth::user()->id;

        if ($currentUser->id === $this->users->id) {
            throw new Exception('Anda tidak dapat menghapus diri anda sendiri', 403);
        }

        return $this->users->findOrFail($id)->delete();
    }
}
