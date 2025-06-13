<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AdminService;
use Spatie\Permission\Models\Role;

class AdminController extends Controller
{
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }

    public function showUser()
    {
        $users = $this->adminService->showUser();
        return $this->successResponse($users, 'Daftar user berhasil diambil');
    }

    public function showIdUser($id)
    {
        $user = $this->adminService->showIdUser($id);
        return $this->successResponse($user, 'Detail user berhasil diambil');
    }

    public function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6',
            'role' => 'required|in:admin,pustakawan,member' // masih divalidasi, tapi gak disimpan langsung di DB
        ]);

        Role::firstOrCreate(['name' => $request->role, 'guard_name' => 'web']);
        // Buat user tanpa menyimpan role ke database langsung
        $user = $this->adminService->createUser($request->only(['name', 'email', 'password']));

        // Assign role pakai Spatie
        $user->assignRole($request->role);

        return $this->successResponse($user, 'User telah ditambahkan', 201);
    }


    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:users,email,' . $id,
            'password' => 'nullable|string|min:6',
            'role' => 'sometimes|required|in:admin,pustakawan,member'
        ]);

        // Pisahkan role supaya tidak dikirim ke service
        $data = $request->only(['name', 'email', 'password']);
        $user = $this->adminService->updateUser($id, $data);

        // Kalau ada input role, update pakai Spatie
        if ($request->filled('role')) {
            $user->syncRoles([$request->role]); // Ganti semua role dengan yang baru
        }

        return $this->successResponse($user, 'User telah diperbarui');
    }


    public function deleteUser($id)
    {
        $user = $this->adminService->deleteUser($id);
        return $this->successResponse($user, 'User telah dihapus');
    }
}
