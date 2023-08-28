<?php

namespace App\Repositories;

use Exception;
use App\Traits\ResponseAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\TahapPenilaian;
use App\Models\DetailPenilaian;
use App\Models\KegiatanPenilaian;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class TahapPenilaianRepository
{
    use ResponseAPI;

    public function __construct(
        protected TahapPenilaian $tahapPenilaian,
        protected KegiatanPenilaian $kriteriaPenilaian,
        protected DetailPenilaian $detailPenilaian,
        protected Arr $array
    ) {
    }

    public function getData(int $periodeId, string $id = null)
    {
        $query = $this->tahapPenilaian
            ->where('periode', $periodeId)
            ->when($id, fn ($query)
            => $query->where('nomor', $id))
            ->get();

        return $query;
    }

    public function getAllData(int $periodeId)
    {
        return $this->tahapPenilaian
            ->where('periode', $periodeId)
            ->get();
    }

    public function getDataByID(int $periodeId, string $id)
    {
        // try {
        return $this->getAllData($periodeId)
            ->findOrFail($id);
        // } catch (ModelNotFoundException $e) {
        //     return $this->error(
        //         'Data tidak ditemukan',
        //         404
        //     );
        // }
    }

    public function requestData($request, int $periodeId, $id = null)
    {
        $a = 1;
        // try {
        $latestTahapId = $this->tahapPenilaian->max('nomor') ?: $a;

        $params = [
            'nomor' => $latestTahapId + $a,
            'periode' => $periodeId,
            'name' => $request->kriteria,
            'kode' => $request->kode,
            'snakecase_name' => Str::snake($request->kriteria),
        ];

        if (!$id) {
            $tahap = $this->tahapPenilaian->create($params);
            // return $this->success('Berhasil menambahkan tahap penilaian', $tahap, 201);
        }

        $tahap = $this->tahapPenilaian->where('periode', $periodeId)->findOrFail($id);
        return $tahap->update($this->array->except($params, ['nomor', 'periode']));

        // return $this->success('Berhasil mengupdate tahap penilaian', $tahap);
        // } catch (Exception $e) {
        //     return $this->error($e->getMessage(), $e->getCode());
        // }
    }

    public function deleteData(int $periodeId, string $id)
    {
        $tahapPenilaian = $this->tahapPenilaian
            ->where('periode', $periodeId)
            ->firstOrFail();

        $kriteriaCount = $this->kriteriaPenilaian
            ->where('tahap_penilaian', $id)
            ->count();

        $kriteriaIds = $this->kriteriaPenilaian
            ->where('tahap_penilaian', $id)
            ->pluck('nomor');

        if ($kriteriaCount > 1) {
            $errMsg = 'Tahapan Penilaian gagal dihapus karena tahapan
             tersebut sudah dipakai lebih dari 1 kriteria,
             mohon hapus sub-kriteria terlebih dahulu';
            throw new Exception($errMsg, 422);
        }

        $penilaianCount = $this->detailPenilaian
            ->whereHas('SubkriteriaPenilaian', fn ($q) => $q->whereIn('subkriteria_id', $kriteriaIds))
            ->count();

        if ($penilaianCount >= 1) {
            $errMsg = 'Tahap penilaian gagal dihapus karena
             salah satu kriteria sudah dipakai untuk penilaian';
            throw new Exception($errMsg, 422);
        }

        $this->kriteriaPenilaian
            ->whereIn('nomor', $kriteriaIds)
            ->delete();

        $tahapPenilaian->delete();
    }
}
