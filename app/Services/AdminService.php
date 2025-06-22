<?php

namespace App\Services;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminService
{
    public function showUser()
    {
        return User::all();
    }

    public function showIdUser($id)
    {
        return User::findOrFail($id);
    }
public function getAllPustakawans()
{
    return User::role('pustakawan')->get();
}

public function getAllMembers()
{
    return User::role('member')->get();
}

    public function createUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']); // Biar password lama tetap
        }

        $user->update($data);
        return $user;
    }


    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return $user;
    }
    public function resetPassword($id, $newPassword = 'password123')
    {
        $user = User::findOrFail($id);
        $user->password = bcrypt($newPassword);
        $user->save();
        return $user;
    }
}
