<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        try {
            $result = $this->authService->login($request->email, $request->password);
            return $this->successResponse($result, 'Login berhasil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, null, 401);
        }
    }

    public function logout(Request $request)
    {
        $this->authService->logout($request->user());
        return $this->successResponse(null, 'Logout berhasil');
    }

    public function showProfile(Request $request)
    {
        return $this->successResponse($request->user(), 'Profil user berhasil diambil');
    }
}
