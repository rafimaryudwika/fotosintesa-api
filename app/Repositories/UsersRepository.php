<?php

namespace App\Repositories;

use Exception;
use App\Models\User;
use Carbon\Traits\Date;
use App\Traits\ResponseAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
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
        protected User $users,
        protected Arr $array
    ) {}

    public function getCurrentUser()
    {
        $res = $this->users
        ->with('Roles')
        ->findOrFail(Auth::user()->id);

        return new UserResource($res);
        // return $res;
    }

    public function getData(string $id = null)
    {
        $users = $this->users
            ->with('Roles')
            ->get();

        if (!$id) return UserResource::collection($users);

        return new UserResource(
            $users
            ->where('id', $id)
            ->first());
    }

    public function requestData(UserRequest $request, string $id = null)
    {
        $params = [
            'id' => Str::ulid(),
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'peserta' => $request->peserta,
        ];

        if (!$id) return $this->users->insert($params);

        $find = $this->users->findOrFail($id);

        return $find->update($this->array->except($params, ['id']));
    }

    public function deleteData(string $id)
    {
        $currentUser = Auth::user()->id;

        $msg = 'Anda tidak dapat menghapus diri anda sendiri';
        if ($currentUser === $this->users->id) throw new Exception($msg, 403);

        return $this->users->findOrFail($id)->delete();
    }
}
