<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class TahapPenilaianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user()->id;
        $peserta = Auth::user()->peserta;
        return $user === 4 || $peserta === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nomor' => 'required|unique:tahap_penilaians,nomor',
            'periode' => 'required|integer',
            'name' => 'required',
            'singkatan' =>  'required'
        ];
    }
}
