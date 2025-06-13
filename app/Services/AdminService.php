<?php

namespace App\Services;
use App\Models\User;

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

    public function createUser($data)
    {
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function updateUser($id, array $data)
    {
        $user = User::findOrFail($id);

        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
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
}
