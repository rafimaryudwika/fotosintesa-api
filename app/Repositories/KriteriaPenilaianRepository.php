<?php

namespace App\Repositories;

use App\Models\DetailPenilaian;
use App\Models\KegiatanPenilaian;
use Exception;
use App\Traits\ResponseAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use App\Models\KriteriaPenilaian;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class KriteriaPenilaianRepository
{
    use ResponseAPI;
    public function __construct(
        protected KriteriaPenilaian $subKriteriaPenilaian,
        protected KegiatanPenilaian $kriteriaPenilaian,
        protected Arr $array
        ) {}

    public function getAllData($tahapID)
    {
        $sub_kriteria = $this->kriteriaPenilaian->with('SubKriteria')->where('tahap_penilaian', $tahapID)->get();

        $data = $sub_kriteria->map(function ($item) {
            $transposedData = $item->SubKriteria->map(fn ($value) => [
                'id' => $value->id,
                'sub_kriteria' => $value->name,
                'kode' => $value->kode,
                'sk_sc' => $value->snakecase_name,
                'bobot' => $value->bobot,
            ])->all();

            if ($item->SubKriteria->count() > 1) {
                $item->subkriteria = $transposedData;
            } elseif ($item->SubKriteria->count() == 1) {
                $item->id_sk1 = $transposedData[0]['sub_kriteria'];
                $item->bobot_sk = $transposedData[0]['bobot'];
            }

            return $item->makeHidden('SubKriteria', 'created_at', 'updated_at');
        });

        return $data;
    }

    public function getDataByID($tahapID, $id)
    {
        try {
            $sub_kriteria = $this->subKriteriaPenilaian
                ->with('Kriteria')
                ->whereHas('Kriteria', fn ($q) => $q->where('tahap_penilaian', $tahapID))
                ->findOrFail($id);

            //TODO: Coba kodingannya dulu, kalo relationship 'Kriteria' tidak muncul, maka gunakan map untuk mengatasinya
            /*
            $transposedData = $sub_kriteria->map(fn($value)=> [
                'kriteria' => $value->Kriteria->name,
                'sub_kriteria' => $value->name,
                'kode' => $value->kode,
                'bobot' => $value->bobot
            ]);
            */
            $transposedData =  [
                'kriteria' => $sub_kriteria->Kriteria->name,
                'sub_kriteria' => $sub_kriteria->name,
                'kode' => $sub_kriteria->kode,
                'bobot' => $sub_kriteria->bobot
            ];

            return $transposedData;
        } catch (ModelNotFoundException $e) {
            return $this->error($e->getMessage(), $e->getCode());
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function requestData($request, $tahapID, $id = null)
    {
        $a = 1;

        try {
            $params = [
                'kegiatan' => $request->kriteria_id,
                'name' => $request->sub_kriteria,
                'kode' => $request->kode,
                'snakecase_name' => Str::snake($request->sub_kriteria),
                'bobot' => $request->bobot,
            ];

            if (!$id) {
                $detect = $this->subKriteriaPenilaian
                    ->where('kegiatan', $request->kriteria_id)
                    ->whereHas('Kriteria', fn ($q) => $q->where('tahap_penilaian', $tahapID))
                    ->orderByDesc('id')->first();

                $num = $detect ? $detect->id + $a : (int) $request->kriteria_id . $a;

                $subkriteria = $this->subKriteriaPenilaian->create($this->array->add($params, ['id'], $num));
            }

            $find_subkriteria = $this->subKriteriaPenilaian
                ->whereHas('Kriteria', fn ($q) => $q->where('tahap_penilaian', $tahapID))
                ->findOrFail($id);

            $subkriteria = $find_subkriteria->update($this->array->except($params, ['kegiatan']));

            return $this->success('Data berhasil disimpan', $subkriteria);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }

    public function deleteData($tahapID, $id)
    {
        try {
            $sub_kriteria = $this->subKriteriaPenilaian
                ->whereHas('Kriteria', fn ($q) => $q->where('tahap_penilaian', $tahapID))
                ->findOrFail($id);

            if (DetailPenilaian::where('subkriteria_id', $id)->count() >= 1) {
                throw new Exception('Subkriteria tidak bisa dihapus karena sedang proses penilaian', 422);
            }

            $sub_kriteria->delete();
            return $this->success('Data berhasil dihapus', $sub_kriteria);
        } catch (ModelNotFoundException $e) {
            return $this->error('Data not found', 404);
        } catch (Exception $e) {
            return $this->error($e->getMessage(), $e->getCode());
        }
    }
}
