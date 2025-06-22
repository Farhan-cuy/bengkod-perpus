<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\AuthResource;
use Illuminate\Http\Request;
use App\Services\AuthService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\UpdateProfileRequest;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function register(RegisterRequest $request)
    {
        try {
            $result = $this->authService->register($request->email, $request->password, $request->name);
            return $this->successResponse([
                'token' => $result['token'],
                'user' => new AuthResource($result['user'])
            ], 'Registrasi berhasil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Registrasi gagal', 400);
        }
    }

    public function login(LoginRequest $request)
    {
        try {
            $result = $this->authService->login($request->email, $request->password);
            return $this->successResponse([
                'token' => $result['token'],
                'user' => new AuthResource($result['user'])
            ], 'Login berhasil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Login gagal', 401);
        }
    }

    public function logout(Request $request)
    {
        try {
            $this->authService->logout($request->user());
            return $this->successResponse(null, 'Logout berhasil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Logout gagal', 400);
        }
    }

    public function showProfile(Request $request)
    {
        try {
            return $this->successResponse(new AuthResource($request->user()), 'Profil user berhasil diambil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil profil', 400);
        }
    }


    public function updateProfile(UpdateProfileRequest $request)
    {
        try {
            $user = auth()->user();
            $user->name = $request->name;
            if ($request->filled('password')) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            return $this->successResponse(new AuthResource($user), 'Profil berhasil diperbarui');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal memperbarui profil', 400);
        }
    }
}
