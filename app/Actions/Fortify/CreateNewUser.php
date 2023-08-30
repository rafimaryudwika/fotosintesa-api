<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Rules\NIMRules;
use App\Models\Pendaftar;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\DetailPendaftar;
use App\Traits\PeriodeParams;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules, PeriodeParams;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'nim' => [
                'required',
                'integer',
                'min:10',
                Rule::unique(Pendaftar::class, 'nim'),
                new NIMRules
            ],
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class, 'email'),
            ],
            'no_hp' => [
                'required',
                'string',
                'max:14',
                Rule::unique(User::class, 'no_hp'),
            ],
            'password' => $this->passwordRules(),
            'panggilan' => 'required',
            'jenis_kelamin' => 'required',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'jurusan' => 'required',
            'provinsi_asal' => 'required',
            'kab_kota_asal' => 'required',
            'kec_asal' => 'required',
            'kel_nag_asal' => 'required',
            'alamat_pdg' => 'required',
            'kelurahan_pdg' => 'required',
            'kec_pdg' => 'required',
            'kota_tempat_tinggal' => 'required',
        ])->validate();

        $userUlid = Str::ulid();
        $pendaftarUlid = Str::ulid();
        $detailPendaftarUlid = Str::ulid();

        User::create([
            'id' => $userUlid,
            'name' => $input['name'],
            'email' => $input['email'],
            'no_hp' => $input['no_hp'],
            'password' => Hash::make($input['password']),
            'role' => 4,
            'peserta' => true
        ]);

        Pendaftar::create([
            'id' => $pendaftarUlid,
            'user_id' => $userUlid,
            'tgl_daftar' => Carbon::now(),
            'nim' => $input['nim'],
            'name' => $input['name'],
            'periode' => $this->GetPeriodeID(),
            'daftar_ulang' => false
        ]);

        DetailPendaftar::create([
            'id' => $detailPendaftarUlid,
            'pendaftar_id' => $pendaftarUlid,
            'panggilan' => $input['panggilan'],
            'gender_id' => $input['jenis_kelamin'],
            'tempat_lahir' => $input['tempat_lahir'],
            'tgl_lahir' => $input['tanggal_lahir'],
            'jurusan_id' => $input['jurusan'],
            'provinsi_asal' => $input['provinsi_asal'],
            'kab_kota_asal' => $input['kab_kota_asal'],
            'kecamatan_asal' => $input['kec_asal'],
            'kelurahan_nagari_asal' => $input['kel_nag_asal'],
            'alamat_pdg' => $input['alamat_pdg'],
            'kelurahan_pdg' => $input['kelurahan_pdg'],
            'kecamatan_pdg' => $input['kec_pdg'],
            'kota_tempat_tinggal' => $input['kota_tempat_tinggal'],
        ]);

        return User::find($userUlid)->get();
    }
}
