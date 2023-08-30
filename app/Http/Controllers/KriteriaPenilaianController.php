<?php

namespace App\Http\Controllers;

use App\Http\Requests\KriteriaPenilaianRequest;
use Exception;
use App\Traits\ResponseAPI;
use App\Services\KriteriaPenilaianService;

class KriteriaPenilaianController extends Controller
{
    use ResponseAPI;

    public function __construct(protected KriteriaPenilaianService $kpService)
    {

    }
    /**
     * Display a listing of the resource.
     */
    public function index(string $periodeId, string $tahapanId)
    {
        try {
            $req = $this->kpService->getAllData($periodeId, $tahapanId);
            return $this->success('Data kegiatan penilaian', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || !is_int($e->getCode())) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $periodeId, string $tahapanId, KriteriaPenilaianRequest $request)
    {
        try {
            $req = $this->kpService->requestData($periodeId, $tahapanId, $request);
            return $this->success('Kegiatan penilaian berhasil dibuat', $req, 201);
        } catch (Exception $e) {
            if (!$e->getCode() || !is_int($e->getCode())) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $periodeId, string $tahapanId, string $id)
    {
        try {
            $req = $this->kpService->getDataById($periodeId, $tahapanId, $id);
            return $this->success('Data kegiatan penilaian', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || !is_int($e->getCode())) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $periodeId, string $tahapanId, KriteriaPenilaianRequest $request, string $id)
    {
        try {
            $req = $this->kpService->requestData($periodeId, $tahapanId, $request, $id);
            return $this->success('Kegiatan penilaian berhasil diupdate', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || !is_int($e->getCode())) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $periodeId, string $tahapanId, string $id)
    {
        try {
            $req = $this->kpService->deleteData($periodeId, $tahapanId, $id);
            return $this->success('Kegiatan penilaian berhasil dihapus', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || !is_int($e->getCode())) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }
}
