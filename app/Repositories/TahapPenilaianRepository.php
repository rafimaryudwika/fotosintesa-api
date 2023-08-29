<?php

namespace App\Repositories;

use App\Http\Resources\TahapPenilaianResource;
use Exception;
use App\Traits\ResponseAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\TahapPenilaian;
use Illuminate\Support\Carbon;
use App\Models\DetailPenilaian;
use App\Models\KegiatanPenilaian;

class TahapPenilaianRepository
{
    public function __construct(
        protected TahapPenilaian $tahapPenilaian,
        protected KegiatanPenilaian $kriteriaPenilaian,
        protected DetailPenilaian $detailPenilaian,
        protected Arr $array
    ) {
    }

    public function getData(string $periodeId, string $id = null)
    {
        $query = $this->tahapPenilaian
            ->where('periode', $periodeId)
            ->get();

        if (!$id) return TahapPenilaianResource::collection($query);

        $single = $query
        ->where('id', $id)
        ->first();

        return new TahapPenilaianResource($single);
    }

    public function requestData($request, string $periodeId, $id = null)
    {
        $a = 1;
        $latestTahapId = $this->tahapPenilaian->max('nomor');

        $params = [
            'id' => Str::ulid(),
            'nomor' => (!$latestTahapId ? $a : $latestTahapId + $a),
            'periode' => $periodeId,
            'name' => $request->name,
            'singkatan' => $request->singkatan,
            'snakecase_name' => Str::snake($request->name),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        if (!$id) return $tahap = $this->tahapPenilaian->insert($params);

        $tahap = $this->tahapPenilaian->where('periode', $periodeId)->findOrFail($id);
        return $tahap->update(
            $this->array
                ->except(
                    $params,
                    [
                        'id',
                        'nomor',
                        'periode',
                        'created_at'
                    ]
                )
        );
    }

    public function deleteData(string $periodeId, string $id)
    {
        $tahapPenilaian = $this->tahapPenilaian
            ->where('periode', $periodeId)
            ->firstOrFail();

        $kriteriaCount = $this->kriteriaPenilaian
            ->where('tahap_penilaian', $id)
            ->count();

        $kriteriaIds = $this->kriteriaPenilaian
            ->where('tahap_penilaian', $id)
            ->pluck('tahap_penilaian');

        if ($kriteriaCount > 1) {
            $errMsg = 'Tahapan Penilaian gagal dihapus karena tahapan
             tersebut sudah dipakai lebih dari 1 kriteria,
             mohon hapus kriteria terlebih dahulu';
            throw new Exception($errMsg, 422);
        }

        $penilaianCount = $this->detailPenilaian
            ->whereHas('KriteriaPenilaian', fn ($q) => $q->whereIn('kegiatan', $kriteriaIds))
            ->count();

        if ($penilaianCount >= 1) {
            $errMsg = 'Tahap penilaian gagal dihapus karena
             salah satu kriteria sudah dipakai untuk penilaian';
            throw new Exception($errMsg, 422);
        }

        $tahapPenilaian->delete();
    }
}
