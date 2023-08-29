<?php

namespace App\Services;

use App\Http\Requests\TahapPenilaianRequest;
use App\Repositories\TahapPenilaianRepository;

/**
 * Di Service, kita harus fokus ke business logic seperti manipulasi data dan kalkulasi
 */
class TahapPenilaianService
{
    public function __construct(
        protected TahapPenilaianRepository $tpRepo
    ) {}

    public function getAllData(string $periodeId)
    {
        return $this->tpRepo->getData($periodeId);
    }

    public function getDataByID(string $periodeId, string $id)
    {
        return $this->tpRepo->getData($periodeId, $id);
    }

    public function requestData(TahapPenilaianRequest $request, string $periodeId, string $id = null)
    {
        // if(!$id) {
        //     return $this->tpRepo->requestData($request, $periodeId);
        // }

        return $this->tpRepo->requestData($request, $periodeId, !$id ? null : $id);
    }

    public function deleteData(string $periodeId, string $id)
    {
        return $this->tpRepo->deleteData($periodeId, $id);
    }
}
