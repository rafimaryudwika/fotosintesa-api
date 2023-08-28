<?php

namespace App\Actions\Fortify;

use App\Models\Pendaftar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

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
                'max:10',
                Rule::unique(Pendaftar::class, 'nim'),
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
                'int',
                'max:14',
                Rule::unique(User::class, 'no_hp'),
            ],
            'password' => $this->passwordRules(),
        ])->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'no_hp' => $input['no_hp'],
            'password' => Hash::make($input['password']),
            'role' => 4,
            'peserta' => true
        ]);
    }
}