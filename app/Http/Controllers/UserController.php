<?php

namespace App\Http\Controllers;

use Exception;
use App\Traits\ResponseAPI;
use App\Services\UsersService;
use App\Http\Requests\UserRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class UserController extends Controller
{
    use ResponseAPI;

    public function __construct(
        protected UsersService $users
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $req = $this->users->getAllData();
            return $this->success('Data pengguna yang terdaftar', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Show current logged on user
     */
    public function currentUser()
    {
        try {
            $req = $this->users->getCurrentUser();
            return $this->success('Data pengguna yang terdaftar', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRequest $request)
    {
        try {
            $store = $this->users->requestData($request);
            return $this->success('User berhasil disimpan',$store, 201);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $req = $this->users->getDataByID($id);
            return $this->success('Data salah satu pengguna', $req);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     * TODO:Bikin fungsi update akun dengan atribut input data yang berbeda setiap role
     */
    public function update(UserRequest $request, string $id)
    {
        try {
            $update = $this->users->requestData($request, $id);
            return $this->success('User berhasil diubah', $update, 200);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $store = $this->users->deleteData($id);
            return $this->success('User berhasil dihapus', $store, 200);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }
}
