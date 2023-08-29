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

        }

        public function getDataById(string $periodeId, string $tahapanId, string $id)
        {

        }

        public function requestData(string $periodeId, string $tahapanId, string $id, KegiatanPenilaianRequest $request)
        {

        }

        public function deleteData(string $periodeId, string $tahapanId, string $id)
        {

        }
}
