<?php

namespace App\Repositories;

use App\Models\DetailPenilaian;
use Exception;
use App\Traits\ResponseAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\KriteriaPenilaian;
use App\Models\PenilaianPeserta;
use App\Models\Peserta;
use App\Models\SubKriteriaPenilaian;
use Illuminate\Support\Facades\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PenilaianPesertaRepository
{
    use ResponseAPI;

    public function __construct(
        protected KriteriaPenilaian $kriteriaPenilaian,
        protected SubKriteriaPenilaian $subKriteriaPenilaian,
        protected PenilaianPeserta $penilaianPeserta,
        protected DetailPenilaian $detailPenilaian,
        protected Arr $array,
        protected Peserta $peserta,
    ) {
    }

    public function getAllPenilaian(int $tahapID, int $periodeId)
    {
        $this->penilaianPeserta
            ->withWhereHas(['Peserta' => [
                'Pendaftar', fn ($q) => $q->where(['periode' => $periodeId]) => [
                    'DetailPendaftar' => [
                        'JenisKelamin:name',
                        'Jurusan:name' => [
                            'Fakultas:name' => [
                                'BidangFakultas:name'
                            ]
                        ]
                    ]
                ],
                'Periode:name',
                'User:email,no_hp'
            ]])
            ->where(['tahap_penilaian' => $tahapID])
            ->get();

        // $this->penilaianPeserta
        //     ->withWhereHas('Peserta.Pendaftar', fn ($q) => $q->where('periode', $periodeId)
        //         ->with('DetailPendaftar.JenisKelamin', 'DetailPendaftar.Jurusan.Fakultas.BidangFakultas'))
        //     ->with(['Peserta.Pendaftar.Periode', 'Peserta.User'])
        //     ->where('tahap_penilaian', $tahapID)
        //     ->get();
    }

    public function requestData($data, int $tahapID, int $periodeId, int $nim = null)
    {
        try {
            $nimColumn = $nim ?? $data->nim; //Jika $nim kosong, maka diarahkan ke $data->nim untuk insert

            //Variabel untuk memastikan NIM ada atau tidak
            $check = $this->peserta
                ->whereHas('Pendaftar', fn ($q) => $q->where(['nim' => $nimColumn, 'periode' => $periodeId]))
                ->firstOrFail();

            $penilaian_id = $this->penilaianPeserta
                ->where(['peserta_id' => $check->id, 'tahap' => $tahapID])
                ->firstOrFail()
                ->id;

            $kriteria = $this->kriteriaPenilaian->all();
            $subkriteria = $this->subKriteriaPenilaian;

            $data_subkriteria = [];
            $nilai_sk = [];

            foreach ($kriteria as $k) {
                $data_subkriteria['kriteria_' . $k->id] = $subkriteria
                    ->where('kegiatan', $k->id)
                    ->pluck('id')
                    ->toArray();

                $multi_sub = $subkriteria
                    ->with('Kriteria')
                    ->where('kegiatan', $k->id)
                    ->get();

                foreach ($multi_sub as $sk) {
                    $count = count($data_subkriteria['kriteria_' . $k->id]); //menghitung jumlah sub-kriteria per kriteria
                    $nilai_sk[] = $count > 1
                    ? $k->snakecase_name . '-' . $sk->snakecase_name
                    : $k->snakecase_name; //variabel untuk menghasilkan input penilaian di REST API
                }
            }
            $combined = array_combine($subkriteria->pluck('id')->toArray(), $nilai_sk);

            if (!$nim) {
                //Untuk insert
                $bulk_insert = [];
                // $combined = array_combine($subkriteria->pluck('id'), $nilai_sk); //menggabungkan ID subkriteria sebagai key dan $nilai_sk sebagai nilai yang diinputkan
                foreach ($combined as $sk => $ns) {
                    $bulk_insert[] = [
                        'penilaian_id' => $penilaian_id,
                        'subkriteria_id' => $sk,
                        'nilai' => $data->$ns
                    ];
                }
                $penilaian = $this->detailPenilaian->insert($bulk_insert);
                //--------------------------
            } else {
                //Untuk update
                $bulk_update = [];
                foreach ($nilai_sk as $ns) {
                    $bulk_update[] = [
                        'nilai' => $data->$ns
                    ];
                }
                // $combined = array_combine($subkriteria->pluck('id'), $bulk_update);
                foreach ($combined as $sk => $bulk) {
                    $penilaian = $this->detailPenilaian
                        ->where([
                            'subkriteria_id' => $sk,
                            'penilaian_id' => $penilaian_id
                            ])
                        ->update($bulk);
                }
                //--------------------------
            }
            return $this->success(
                !$nim ? 'Data berhasil disimpan' : 'Data berhasil diupdate',
                $penilaian,
                !$nim ? 201 : 200);
        } catch (ModelNotFoundException $e) {
            return $this->error(
                'NIM tidak ada di data peserta! Pastikan NIM tersebut terdaftar di data peserta!',
                 404);
        } catch (Exception $e) {
            return $this->error(
                $e->getMessage(),
                $e->getCode());
        }
    }
}
