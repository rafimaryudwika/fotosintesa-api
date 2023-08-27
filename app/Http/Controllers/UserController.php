<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Services\UsersService;
use App\Traits\ResponseAPI;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class UserController extends Controller
{
    use ResponseAPI;

    public function __construct(
        protected UsersService $user
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $req = $this->user->getAllData();
            return $this->success('Data pengguna yang terdaftar', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Show current logged on user
     */
    public function currentUser()
    {
        try {
            $req = $this->user->getCurrentUser();
            return $this->success('Data pengguna yang terdaftar', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $store = $this->user->requestData($request);
            return $this->success('User berhasil disimpan', compact($store), 201);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $req = $this->user->getDataByID($id);
            return $this->success('Data salah satu pengguna', $req);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Update the specified resource in storage.
     * Bikin fungsi update akun dengan atribut input data yang berbeda setiap role
     */
    public function update(Request $request, int $id)
    {
        try {
            $update = $this->user->requestData($request, $id);
            return $this->success('User berhasil diubah', compact($update), 200);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $store = $this->user->deleteData($id);
            return $this->success('User berhasil disimpan', compact($store), 201);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
