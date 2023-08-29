<?php

namespace App\Http\Controllers;

use App\Models\KriteriaPenilaian;

class KegiatanPenilaianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(string $periodeId, string $tahapanId)
    {
        return [$periodeId, $tahapanId];
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(string $periodeId, string $tahapanId, $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $periodeId, string $tahapanId, string $id)
    {
        return [$periodeId, $tahapanId, $id];
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $periodeId, string $tahapanId, string $id, $request)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $periodeId, string $tahapanId, string $id)
    {
        //
    }
}
