<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Periode;
use App\Services\PeriodeService;
use App\Http\Requests\PeriodeRequest;
use App\Http\Requests\StorePeriodeRequest;
use App\Http\Requests\UpdatePeriodeRequest;
use App\Traits\ResponseAPI;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PeriodeController extends Controller
{
    use ResponseAPI;

    public function __construct(
        protected PeriodeService $periode
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $req = $this->periode->getAllData();
            return $this->success('Data periode', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PeriodeRequest $request)
    {
        try {
            $store = $this->periode->requestData($request);
            return $this->success('Periode berhasil disimpan',$store, 201);
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
            $req = $this->periode->getAllData($id);
            return $this->success('Data periode', $req);
        } catch (Exception $e) {
            if (!$e->getCode() || $e->getCode() === 0) return response()->json($e->__toString(), 500);
            return $this->error($e->getMessage(), 500);
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(PeriodeRequest $request,string $id)
    {
        try {
            $store = $this->periode->requestData($request, $id);
            return $this->success('Periode berhasil diupdate',$store, 200);
        } catch (ModelNotFoundException $e) {
            return $this->error("Periode tidak ditemukan!", 404);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $store = $this->periode->deleteData($id);
            return $this->success('Periode berhasil diupdate',$store, 200);
        } catch (ModelNotFoundException $e) {
            return $this->error("Periode tidak ditemukan!", 404);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
