<?php

namespace App\Http\Requests;

use Carbon\Carbon;
use App\Models\Periode;
use App\Traits\ResponseAPI;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\UnauthorizedException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PeriodeRequest extends FormRequest
{
    use ResponseAPI;
    public function __construct(protected Periode $periodeDb)
    {}
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user()->role; //cek role dari user yang digunakan sekarang

        if (!$this->periode) {
            return $user === 1;
        }

        try {
            $db = $this->periodeDb->findOrFail($this->periode); //Cek tanggal selesai dari periode yang akan diedit
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('ID Periode tidak ditemukan!', 404); // Throw authorization exception
        }

        $end_date = Carbon::now()->startOfDay()->gte(($db->tanggal_selesai)); //Cek apakah tanggal selesai sudah melewati tanggal sekarang
        $selesai = $db->sedang_berlangsung;

        if (!$end_date && $selesai) {
            return $user === 1; //Jika tanggal selesai belum lewat, maka masih bisa diedit dan hanya role 1/admin yang bisa mengedit
        }

        return false; //Jika tanggal selesai sudah lewat, maka tidak bisa diedit lagi
    }
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $request_array = [ //Form yang bisa diisi sebelum memasuki tanggal mulainya periode yang akan diedit
            'name' => 'required|string|max:10',
            'alias' => 'required|string',
            'slogan' => 'string',
            'min_bp' => 'required|integer',
            'max_bp' => 'required|integer',
            'tgl_mulai' => 'required|date',
            'tgl_selesai' => 'date',
        ];
        if (!$this->periode) return $request_array; //Jika id periode tidak ada, maka langsung dibikin, biasanya untuk Create

        try {
            $db = $this->periodeDb->findOrFail($this->periode); //Cek tanggal selesai dari periode yang akan diedit
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException('ID Periode tidak ditemukan!', 404); // Throw authorization exception
        }

        $start_date = Carbon::now()->startOfDay()->gte($db->tanggal_mulai); //Cek apakah tanggal mulainya sudah melewati tanggal sekarang

        if (!$start_date) return $request_array; //Jika tanggal sekarang belum memasuki tanggal mulainya, maka bisa diedit semuanya

        $end_date = Carbon::now()->startOfDay()->gte($db->tanggal_selesai);

        if (!$end_date) return Arr::only($request_array, ['tgl_selesai']); //Jika tanggal sekarang sudah memasuki tanggal mulainya, maka hanya bisa diedit sebagiannya saja

        return [
            'tgl_selesai' => 'date',
            'sedang_berlangsung' => 'boolean'
        ];
    }
}
