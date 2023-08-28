<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $user = Auth::user()->role;
        return $user === 1; //Artinya, hanya role 1 yang bisa mengakses
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => ['required',Rule::unique('users', 'email')->ignore($this->user)],
            'no_hp' => ['required', Rule::unique('users', 'no_hp')->ignore($this->user)],
            'password' =>  'required|confirmed',
            'role' => 'required',
            'peserta' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Nama wajib diisi!',
            'email.required' => 'E-mail wajib diisi!',
            'email.unique' => 'E-mail sudah digunakan, mohon gunakan e-mail lain!',
            'no_hp.required' => 'Nomor HP wajib diisi!',
            'no_hp.unique' => 'Nomor HP sudah digunakan, mohon gunakan nomor HP lain!',
            'password.required' => 'Password wajib diisi!',
            'passowrd.confirmed' => 'Password yang diisi tidak sama!',
            'role.required' => 'Role wajib diisi!',
            'peserta.required' => 'Status peserta wajib diisi!'
        ];
    }
}
