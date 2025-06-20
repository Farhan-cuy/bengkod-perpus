<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Resources\AdminResource;
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
        try {
            $users = $this->adminService->showUser();
            return $this->successResponse([
                'total' => $users->count(),
                'data' => AdminResource::collection($users)
            ], 'Daftar user berhasil diambil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil daftar user', 500);
        }
    }

    public function showMembers()
    {
        try {
            $users = $this->adminService->getAllMembers();
            if ($users->isEmpty()) {
                return $this->successResponse([], 'Tidak ada member ditemukan');
            }
            return $this->successResponse(AdminResource::collection($users), 'Daftar member berhasil diambil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil daftar member', 500);
        }
    }

    public function showPustakawans()
    {
        try {
            $users = $this->adminService->getAllPustakawans();
            if ($users->isEmpty()) {
                return $this->successResponse([], 'Tidak ada pustakawan ditemukan');
            }
            return $this->successResponse(AdminResource::collection($users), 'Daftar pustakawan berhasil diambil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil daftar pustakawan', 500);
        }
    }

    public function showIdUser($id)
    {
        try {
            $user = $this->adminService->showIdUser($id);
            return $this->successResponse(new AdminResource($user), 'Detail user berhasil diambil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'User tidak ditemukan', 404);
        }
    }

    public function createUser(CreateUserRequest $request)
    {
        try {
            Role::firstOrCreate(['name' => $request->role, 'guard_name' => 'web']);
            $data = $request->only(['name', 'email']);
            $data['password'] = 'password123'; // password default

            $user = $this->adminService->createUser($data);
            $user->assignRole($request->role);

            return $this->successResponse(new AdminResource($user), 'User telah ditambahkan', 201);
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal menambah user', 400);
        }
    }

    public function updateUser(UpdateUserRequest $request, $id)
    {
        try {
            $data = $request->only(['name', 'email']);
            $user = $this->adminService->updateUser($id, $data);

            if ($request->filled('role')) {
                $user->syncRoles([$request->role]);
            }

            return $this->successResponse(new AdminResource($user), 'User telah diperbarui');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal memperbarui user', 400);
        }
    }

    public function deleteUser($id)
    {
        try {
            $user = $this->adminService->deleteUser($id);
            return $this->successResponse(new AdminResource($user), 'User telah dihapus');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal menghapus user', 400);
        }
    }

}
