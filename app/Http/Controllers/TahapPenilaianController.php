<?php

namespace App\Http\Controllers;

use App\Http\Requests\TahapPenilaianRequest;
use Exception;
use App\Services\TahapPenilaianService;
use App\Traits\ResponseAPI;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TahapPenilaianController extends Controller
{
    use ResponseAPI;
    public function __construct(
        protected TahapPenilaianService $tpService
    ) {}
    /**
     * Display a listing of the resource.
     */
    public function index(string $periodeId)
    {
        try {
            $req = $this->tpService->getAllData($periodeId);
            return $this->success('Data tahapan penilaian', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $periodeId, TahapPenilaianRequest $request)
    {
        try {
            $store = $this->tpService->requestData($request, $periodeId);
            return $this->success('Tahapan penilaian berhasil disimpan',$store, 201);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $periodeId, string $id)
    {
        try {
            $req = $this->tpService->getDataByID($periodeId, $id);
            return $this->success('Data salah satu tahapan penilaian', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $periodeId,  string $id, TahapPenilaianRequest $request)
    {
        try {
            $store = $this->tpService->requestData($request, $periodeId, $id);
            return $this->success('Tahapan penilaian berhasil diupdate',$store, 200);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $periodeId, string $id)
    {
        try {
            $store = $this->tpService->deleteData($periodeId, $id);
            return $this->success('Tahapan penilaian berhasil dihapus',$store, 200);
        } catch (ModelNotFoundException $e) {
            return $this->error("Data tidak ditemukan!", 404);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
