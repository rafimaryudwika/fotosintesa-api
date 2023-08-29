<?php

namespace App\Services;

use App\Http\Requests\PeriodeRequest;
use App\Repositories\PeriodeRepository;

/**
 * Di Service, kita harus fokus ke business logic seperti manipulasi data dan kalkulasi
 */
class PeriodeService
{
    public function __construct(
        protected PeriodeRepository $periodeRepo
    ) {}

    public function getAllData()
    {
        return $this->periodeRepo->getData();
    }

    public function getDataByID( string $id)
    {
        return $this->periodeRepo->getData( $id);
    }

    public function requestData(PeriodeRequest $request, string $id = null)
    {
        // if(!$id) {
        //     return $this->tpRepo->requestData($request, $periodeId);
        // }

        return $this->periodeRepo->requestData($request, !$id ? null : $id);
    }

    public function deleteData(string $id)
    {
        return $this->periodeRepo->deleteData($id);
    }
}
