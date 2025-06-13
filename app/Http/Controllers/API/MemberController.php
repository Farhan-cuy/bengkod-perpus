<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
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

    public function borrowBook(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:books,id',
        ]);

        try {
            $loan = $this->memberService->borrowBook($request->id_buku);
            return $this->successResponse($loan, 'Buku berhasil dipesan', 201);
        } catch (Exception $e) {
            return $this->exceptionError($e, null, 400);
        }
    }

    public function cancelBorrow($id)
    {
        try {
            $loan = $this->memberService->cancelBorrow($id);
            return $this->successResponse($loan, 'Peminjaman berhasil dibatalkan');
        } catch (Exception $e) {
            return $this->exceptionError($e, null, 404);
        }
    }
}
