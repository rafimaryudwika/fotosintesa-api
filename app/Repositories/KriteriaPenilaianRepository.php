<?php

namespace App\Repositories;

use Exception;
use App\Traits\ResponseAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\TahapPenilaian;
use Illuminate\Support\Carbon;
use App\Models\DetailPenilaian;
use App\Models\KegiatanPenilaian;
use App\Models\KriteriaPenilaian;
use App\Http\Resources\SingleKriteriaResource;
use App\Http\Requests\KriteriaPenilaianRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KriteriaPenilaianRepository
{
    use ResponseAPI;
    public function __construct(
        protected KriteriaPenilaian $kriteriaPenilaian,
        protected KegiatanPenilaian $kegiatanPenilaian,
        protected TahapPenilaian $tahapanPenilaian,
        protected Arr $array
    ) {
    }

    public function getAllData(string $periodeId, string $tahapId)
    {
        $kriteria = $this->kegiatanPenilaian
            ->with('KriteriaPenilaian')
            ->whereHas('TahapPenilaian', fn ($query)
            => $query->where(['periode' => $periodeId, 'tahap_penilaian' => $tahapId]))
            ->get();

        return $kriteria;
    }

    public function getDataByID(string $periodeId, string $tahapId, string $id)
    {
        $kriteria = $this->kriteriaPenilaian
            ->with(['KegiatanPenilaian.TahapPenilaian' => fn ($q)
            =>  $q->where(['id' => $tahapId, 'periode' => $periodeId])])
            ->whereHas('KegiatanPenilaian.TahapPenilaian', fn ($q)
            => $q->where(['id' => $tahapId, 'periode' => $periodeId]))
            ->findOrFail($id);

        return new SingleKriteriaResource($kriteria);
    }

    public function requestData(string $periodeId, string $tahapId, string $id = null, KriteriaPenilaianRequest $request)
    {
        $a = 1;

        $latestKegiatanId = $this->kegiatanPenilaian
            ->whereHas('TahapPenilaian', fn ($q)
            => $q->where(['periode' => $periodeId]))
            ->where(['tahap_penilaian' => $tahapId, 'id' => $request->kegiatan])
            ->first()->nomor;

        $countKriteria = $this->kriteriaPenilaian
            ->where('kegiatan', $request->kegiatan)
            ->whereHas('KegiatanPenilaian', fn ($q)
            => $q->where('tahap_penilaian', $tahapId))
            ->orderByDesc('id')->count();

        $num = !$countKriteria ? $latestKegiatanId . $a : (int) $latestKegiatanId . $countKriteria + $a;

        $params = [
            'id' => Str::ulid(),
            'nomor' => $num,
            'kegiatan' => $request->kegiatan,
            'name' => $request->name,
            'kode' => $request->kode,
            'snakecase_name' => Str::snake($request->name),
            'bobot' => $request->bobot,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        if (!$id) return $this->kriteriaPenilaian->create($params);

        $subkriteria = $this->kriteriaPenilaian
            ->whereHas(
                'KegiatanPenilaian.TahapPenilaian',
                fn ($q) => $q
                    ->where(['id' => $tahapId, 'periode' => $periodeId])
            )->findOrFail($id);

        $subkriteria->update($this->array->except($params, ['id', 'nomor', 'kegiatan', 'created_at']));

        return $subkriteria;
    }

    public function deleteData(string $periodeId, string $tahapId, string $id = null)
    {
        $kriteria = $this->kriteriaPenilaian
            ->whereHas('KegiatanPenilaian.TahapPenilaian', fn ($q) => $q
            ->where(['id' => $tahapId, 'periode' => $periodeId]))
            ->findOrFail($id);

        if (DetailPenilaian::where('kriteria', $id)->count() >= 1) {
            throw new Exception('Subkriteria tidak bisa dihapus karena sedang proses penilaian', 422);
        }

        $kriteria->delete();
        return $kriteria;
    }
}
