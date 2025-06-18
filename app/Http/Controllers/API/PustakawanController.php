<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PustakawanResource;
use Illuminate\Http\Request;
use App\Services\PustakawanService;
use Illuminate\Support\Facades\Auth;

class PustakawanController extends Controller
{
    protected $pustakawanService;

    public function __construct(PustakawanService $pustakawanService)
    {
        $this->pustakawanService = $pustakawanService;
    }

    public function validateBorrow($id)
    {
        try {
            $loan = $this->pustakawanService->validateBorrow($id);
            return $this->successResponse(new PustakawanResource($loan), 'Peminjaman telah divalidasi');
        } catch (\Exception $e) {
            return $this->exceptionError($e, $e->getMessage(), 400);
        }
    }

    public function validateReturn($id)
    {
        try {
            $loan = $this->pustakawanService->validateReturn($id);
            return $this->successResponse(new PustakawanResource($loan), 'Pengembalian berhasil divalidasi');
        } catch (\Exception $e) {
            return $this->exceptionError($e, $e->getMessage(), 400);
        }
    }
}
