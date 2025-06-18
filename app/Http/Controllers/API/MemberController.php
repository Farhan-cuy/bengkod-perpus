<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\BorrowBookRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\MemberResource;
use Illuminate\Http\Request;
use App\Services\MemberService;
use Exception;

class MemberController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function borrowBook(BorrowBookRequest $request)
    {
        try {
            $loan = $this->memberService->borrowBook($request->id_buku);
            return $this->successResponse(new MemberResource($loan), 'Buku berhasil dipesan', 201);
        } catch (Exception $e) {
            return $this->exceptionError($e, null, 400);
        }
    }

    public function cancelBorrow($id)
    {
        try {
            $loan = $this->memberService->cancelBorrow($id);
            return $this->successResponse(new MemberResource($loan), 'Peminjaman berhasil dibatalkan');
        } catch (Exception $e) {
            return $this->exceptionError($e, null, 404);
        }
    }

    public function activeLoans()
    {
        try {
            $loans = $this->memberService->getActiveLoans();
            return $this->successResponse(MemberResource::collection($loans), 'Daftar buku yang sedang dipinjam');
        } catch (Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil data', 400);
        }
    }

    public function borrowHistory()
    {
        try {
            $loans = $this->memberService->getBorrowHistory();
            return $this->successResponse(MemberResource::collection($loans), 'Riwayat peminjaman berhasil diambil');
        } catch (Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil riwayat', 400);
        }
    }
}
