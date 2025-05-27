<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\PreregisteredUserValidator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use App\Models\Siswa; 
use Illuminate\Validation\ValidationException; 

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
        // Validasi dasar
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ])->validate();

        // Beri tahu PreregisteredUserValidator (kosong, hanya untuk formalitas)
        PreregisteredUserValidator::validate($input);

        if (!Siswa::where('email', $input['email'])->exists()) {
            throw ValidationException::withMessages([
                'email' => 'Email ini tidak terdaftar sebagai siswa.', 
            ]);
        }

        // Buat user baru tanpa role
        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
