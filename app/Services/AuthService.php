<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AuthService
{
    public function login($email, $password)
    {
        $user = User::where('email', $email)->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            throw new \Exception('Email atau password salah');
        }

        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return [
            'token' => $token,
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user' => $user
        ];
    }

    public function register($email, $password, $name)
    {
        $user = User::create([
            'email' => $email,
            'password' => Hash::make($password),
            'name' => $name
        ]);

        Role::findOrCreate('member', 'web');
        $user->assignRole('member');

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user
        ];
    }

    public function logout($user)
    {
        $user->tokens()->delete();
        return true;
    }
}
