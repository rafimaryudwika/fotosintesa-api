<?php

namespace App\Repositories;

use Exception;
use App\Models\Periode;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Http\Requests\PeriodeRequest;
use App\Models\TahapPenilaian;
use Illuminate\Database\Eloquent\ModelNotFoundException;


class PeriodeRepository
{
    public function __construct(
        protected Periode $periode,
        protected TahapPenilaian $tahap,
        protected Arr $array
    ) {}

    public function getData(string $id = null)
    {
        $users = $this->periode
            ->all();

        if (!$id) return $users;

        return $users
            ->where('id', $id)
            ->first();
    }

    public function requestData(PeriodeRequest $request, string $id = null)
    {
        $params = [
            'id' => Str::ulid(),
            'name' => $request->name,
            'alias' => $request->alias,
            'slogan' => $request->slogan,
            'minimum_bp' => $request->min_bp, //angkatan bawah untuk S1/D3
            'maksimum_bp' => $request->max_bp, //angkatan atas untuk S1
            'tanggal_mulai' => Carbon::parse($request->tgl_mulai),
            'tanggal_selesai' => !$request->tgl_selesai ? null : Carbon::parse($request->tgl_selesai),
            'sedang_berlangsung' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];

        if (!$id) return $this->periode->insert($params);

        $find = $this->periode->findOrFail($id);

        if(!$find) {
            throw new ModelNotFoundException('ID Not Found!', 404);
        }

        $start_date_past = Carbon::now()->startOfDay()->gte($find->start_date); //Cek apakah tanggal mulainya sudah melewati tanggal sekarang
        if(!$start_date_past) return $find->update($this->array->except($params, ['id', 'created_at']));

        return $find->update($this->array->only($params, ['tanggal_selesai']));
    }

    public function deleteData(string $id)
    {
        $periode = $this->periode->
        where('id',$id)
        ->firstOrFail();

        $tahapanCount = $this->tahap
        ->where('periode', $periode)
        ->count();

        if ($tahapanCount > 1) {
            $errMsg = 'Periode Penilaian gagal dihapus karena periode
             tersebut sudah dipakai lebih dari 1 tahapan,
             mohon hapus tahapan terlebih dahulu';
            throw new Exception($errMsg, 422);
        }

        $startDate = Carbon::now()->startOfDay()->gte($periode->tanggal_mulai);

        if (!$startDate) $periode->delete();

        throw new Exception('Periode Fotosintesa tersebut sudah dimulai, tidak dapat menghapus periode ini', 403);
    }

}
