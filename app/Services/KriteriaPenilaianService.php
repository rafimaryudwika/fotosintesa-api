<?php

namespace App\Services;

use App\Http\Requests\KegiatanPenilaianRequest;
use App\Http\Requests\KriteriaPenilaianRequest;
use App\Repositories\KriteriaPenilaianRepository;

/**
 * Di Service, kita harus fokus ke business logic seperti manipulasi data dan kalkulasi
 */
class KriteriaPenilaianService
{
    public function __construct(
        private KriteriaPenilaianRepository $kriteria_penilaianRepo) {}

        public function getAllData(string $periodeId, string $tahapanId)
        {
            $data = $this->kriteria_penilaianRepo->getAllData($periodeId, $tahapanId);

            return $data;
        }

        public function getDataById(string $periodeId, string $tahapanId, string $id)
        {
            return $this->kriteria_penilaianRepo->getDataByID($periodeId, $tahapanId, $id);
        }

        public function requestData(string $periodeId, string $tahapanId, KriteriaPenilaianRequest $request, string $id = null)
        {
            return $this->kriteria_penilaianRepo->requestData( $periodeId, $tahapanId, !$id ? null : $id,  $request);
        }

        public function deleteData(string $periodeId, string $tahapanId, string $id)
        {
            return $this->kriteria_penilaianRepo->deleteData($periodeId, $tahapanId, $id);
        }
}
