<?php

namespace App\Repositories;

use Exception;
use App\Traits\ResponseAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\DetailPenilaian;
use App\Models\KegiatanPenilaian;
use App\Models\KriteriaPenilaian;
use App\Models\SubKriteriaPenilaian;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KegiatanPenilaianRepository
{
    use ResponseAPI;

    public function __construct(
        protected KegiatanPenilaian $kriteriaPenilaian,
        protected KriteriaPenilaian $subKriteriaPenilaian,
        protected DetailPenilaian $detailPenilaian,
        protected Arr $array
    ) {
    }

    /**
    *getData() menggabungkan query mengambil semua data
    *dengan mengambil satu data agar kodingan terlihat lebih ringkas
     */
    public function getData(int $periodeId, string $id = null)
    {
        $query = $this->kriteriaPenilaian
            ->whereHas('TahapanPenilaian', fn ($q) => $q->where('periode', $periodeId))
            ->when($id, fn ($query) => $query->where('nomor', $id))
            ->get();

        return $query;
    }

    public function requestData($request, int $periodeId, int $tahapId, string $id = null)
    {
        try {
            $a = 1;

            $latestKriteriaId = optional($this->kriteriaPenilaian
                ->whereHas('TahapPenilaian', fn ($q) => $q->where(['periode' => $periodeId]))
                ->where('tahap_penilaian', $tahapId)
                ->latest('nomor')->first())->nomor ?: $a;

            $params = [
                'name' => $request->kriteria,
                'kode' => $request->kode,
                'snakecase_name' => Str::snake($request->kriteria),
                'bobot' => $request->bobot,
            ];

            if (!$id) {
                $nomor = $latestKriteriaId + $a;
                $kriteriaParams = ['nomor' => $nomor] + $params;
                $subKriteriaParams = [
                    'nomor' => $nomor,
                    'kegiatan' => $latestKriteriaId
                ] + $params;

                $kriteria = $this->kriteriaPenilaian
                    ->create($kriteriaParams);
                $this->subKriteriaPenilaian
                    ->create($subKriteriaParams);
            } else {
                $kriteria = $this->kriteriaPenilaian
                    ->where('nomor', $id)
                    ->firstOrFail();
                $kriteria->update($params);
            }

            return $this->success(
                !$id
                    ? 'Data kriteria berhasil dibuat'
                    : 'Data kriteria berhasil diupdate',
                $kriteria,
                !$id ? 201 : 200
            );
        } catch (ModelNotFoundException $e) {
            return $this->error(
                $e->getMessage(),
                $e->getCode()
            );
        } catch (Exception $e) {
            return $this->error(
                $e->getMessage(),
                $e->getCode()
            );
        }
    }

    public function deleteData(int $periodeId, int $tahapId, string $id)
    {
        $kriteria = $this->kriteriaPenilaian
            ->whereHas('TahapPenilaian', fn ($q) => $q->where(['periode' => $periodeId]))
            ->where(['nomor' => $id, 'tahap_penilaian' => $tahapId])
            ->firstOrFail();
        try {
            $subKriteriaCount = $this->subKriteriaPenilaian
                ->where('kegiatan', $id)
                ->count();

            $subKriteriaIds = $this->subKriteriaPenilaian
                ->where('kegiatan', $id)
                ->pluck('nomor');

            if ($subKriteriaCount > 1) {
                $errMsg = 'Kriteria gagal dihapus karena kriteria
                 tersebut sudah dipakai lebih dari 1 sub-kriteria,
                 mohon hapus sub-kriteria terlebih dahulu';
                throw new Exception($errMsg, 422);
            }
            $penilaianCount = $this->detailPenilaian
                ->whereIn('subkriteria_id', $subKriteriaIds)->count();

            if ($penilaianCount >= 1) {
                $errMsg = 'Kriteria gagal dihapus karena
                 salah satu sub-kriteria sudah dipakai untuk penilaian';
                throw new Exception($errMsg, 422);
            }

            $this->subKriteriaPenilaian
                ->whereIn('nomor', $subKriteriaIds)
                ->delete();

            $kriteria->delete();

            return $this->success(
                'Kriteria and its subkriteria deleted',
                compact(
                    'subKriteriaCount',
                    'kriteria'
                ),
                200
            );
        } catch (Exception $e) {
            return $this->error(
                $e->getMessage(),
                $e->getCode()
            );
        }
    }
}
