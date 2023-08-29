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
use App\Http\Requests\KegiatanPenilaianRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KegiatanPenilaianRepository
{
    use ResponseAPI;

    public function __construct(
        protected TahapPenilaian $tahapanPenilaian,
        protected KegiatanPenilaian $kegiatanPenilaian,
        protected KriteriaPenilaian $kriteriaPenilaian,
        protected DetailPenilaian $detailPenilaian,
        protected Arr $array
    ) {
    }

    /**
     *getData() menggabungkan query mengambil semua data
     *dengan mengambil satu data agar kodingan terlihat lebih ringkas
     */
    public function getData(string $periodeId, string $tahapanId, string $id = null)
    {
        $query = $this->kegiatanPenilaian
            ->whereHas('TahapPenilaian', fn ($q) => $q->where('periode', $periodeId))
            ->where('tahap_penilaian', $tahapanId)
            ->get();

        $count = $query->count();
        $sum = round($query->sum('bobot'), 2);
        $balance = 100 - $sum < 0.1 ? 'Seimbang' : 'TIDAK SEIMBANG!!';


        $additionalInfo = [
            'jumlah_kegiatan' => $count,
            'rata-rata bobot' =>$sum,
            'keseimbangan' => $balance
        ];

        if (!$id) return [$query, $additionalInfo];

        return $query->where('id', $id);
    }

    public function requestData(KegiatanPenilaianRequest $request, string $periodeId, string $tahapId, string $id = null)
    {
        $a = 1;

        $latestTahapanId = $this->tahapanPenilaian
            ->where('periode', $periodeId)
            ->first()->nomor;

        $latestKegiatanId = $this->kegiatanPenilaian
            ->whereHas('TahapPenilaian', fn ($q) => $q->where(['periode' => $periodeId]))
            ->where('tahap_penilaian', $tahapId)
            ->latest('nomor')->count();

        $params = [
            'name' => $request->name,
            'kode' => $request->kode,
            'snakecase_name' => Str::snake($request->name),
            'bobot' => $request->bobot,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        if (!$id) {
            $kegiatanUlid = Str::ulid();

            $nomor = $latestTahapanId . (!$latestKegiatanId ? $a : $latestKegiatanId + $a) ;
            $kegiatanParams = [
                'id' => $kegiatanUlid,
                'nomor' => $nomor,
                'tahap_penilaian' => $tahapId,
            ] + $params;
            $kriteriaParams = [
                'id' => Str::ulid(),
                'nomor' => $nomor . $a,
                'kegiatan' => $kegiatanUlid
            ] + $params;

            $kegiatan = $this->kegiatanPenilaian
                ->create($kegiatanParams);
            $this->kriteriaPenilaian
                ->create($kriteriaParams);
        } else {
            $kegiatan = $this->kegiatanPenilaian
                ->where('id', $id)
                ->firstOrFail();
            $kegiatan->update($this->array
                ->except($params, ['created_at']));
        }

        return $kegiatan;
    }

    public function deleteData(string $periodeId, string $tahapId, string $id)
    {
        $kegiatan = $this->kegiatanPenilaian
            ->whereHas('TahapPenilaian', fn ($q) => $q->where(['periode' => $periodeId]))
            ->where(['id' => $id, 'tahap_penilaian' => $tahapId])
            ->firstOrFail();

            $kriteriaCount = $this->kriteriaPenilaian
                ->where('kegiatan', $id)
                ->count();

            $kriteriaIds = $this->kriteriaPenilaian
                ->where('kegiatan', $id)
                ->pluck('id');

            if ($kriteriaCount > 1) {
                $errMsg = 'Kriteria gagal dihapus karena kriteria tersebut sudah dipakai lebih dari 1 sub-kriteria, mohon hapus sub-kriteria terlebih dahulu';
                throw new Exception($errMsg, 422);
            }
            $penilaianCount = $this->detailPenilaian
                ->whereIn('kriteria', $kriteriaIds)->count();

            if ($penilaianCount >= 1) {
                $errMsg = 'Kriteria gagal dihapus karena salah satu sub-kriteria sudah dipakai untuk penilaian';
                throw new Exception($errMsg, 422);
            }

            $this->kriteriaPenilaian
                ->whereIn('id', $kriteriaIds)
                ->delete();

            $kegiatan->delete();

            return $kegiatan;


    }
}
