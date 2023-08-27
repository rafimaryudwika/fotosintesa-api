<?php

namespace App\Services;

use App\Http\Requests\TahapPenilaianRequest;
use App\Repositories\TahapPenilaianRepository;

class TahapPenilaianService
{
    public function __construct(protected TahapPenilaianRepository $tpRepo)
    {

    }

    public function getAllData(int $periodeId)
    {
        return $this->tpRepo->getData($periodeId);
    }

    public function getDataByID(int $periodeId, int $id)
    {
        return $this->tpRepo->getData($periodeId, $id);
    }

    public function requestData(TahapPenilaianRequest $request, int $periodeId, int $id = null)
    {
        // if(!$id) {
        //     return $this->tpRepo->requestData($request, $periodeId);
        // }

        return $this->tpRepo->requestData($request, $periodeId, !$id ? null : $id);
    }

    public function deleteData(int $periodeId, int $id)
    {
        return $this->tpRepo->deleteData($periodeId, $id);
    }
}
