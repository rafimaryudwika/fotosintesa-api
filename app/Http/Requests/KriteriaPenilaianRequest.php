<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;

class KriteriaPenilaianRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user()->role;
        return $user === 1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $array = [
            'name' => 'required',
            'kode' =>  'required',
            'bobot' => 'required'
        ];

        if ($this->isMethod('POST')) Arr::add($array, 'kegiatan', 'required');
        return $array;
    }
}
