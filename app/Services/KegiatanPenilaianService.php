<?php

namespace App\Services;

use App\Http\Requests\KegiatanPenilaianRequest;
use App\Repositories\KegiatanPenilaianRepository;

/**
 * Di Service, kita harus fokus ke business logic seperti manipulasi data dan kalkulasi
 */
class KegiatanPenilaianService
{
    public function __construct(
        private KegiatanPenilaianRepository $kegiatan_penilaianRepo) {}

        public function getAllData(string $periodeId, string $tahapanId)
        {
            $data = $this->kegiatan_penilaianRepo->getData($periodeId, $tahapanId);

            return $data;
        }

        public function getDataById(string $periodeId, string $tahapanId, string $id)
        {
            return $this->kegiatan_penilaianRepo->getData($periodeId, $tahapanId, $id);
        }

        public function requestData(string $periodeId, string $tahapanId, KegiatanPenilaianRequest $request, string $id = null)
        {
            return $this->kegiatan_penilaianRepo->requestData($request, $periodeId, $tahapanId, !$id ? null : $id );
        }

        public function deleteData(string $periodeId, string $tahapanId, string $id)
        {
            return $this->kegiatan_penilaianRepo->deleteData($periodeId, $tahapanId, $id);
        }
}
