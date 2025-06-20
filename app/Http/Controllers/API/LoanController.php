<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\LoanResource;
use App\Services\LoanService;
use Illuminate\Http\Request;
use App\Models\Loan;
use App\Models\Book;
use App\Models\User;

class LoanController extends Controller
{
    protected $loanService;

    public function __construct(LoanService $loanService)
    {
        $this->loanService = $loanService;
    }

    public function showDataLoan()
    {
        try {
            $loan = $this->loanService->showDataLoan();

            $totalDipinjam = $loan->where('status', 'dipinjam')->count();
            $totalTerlambat = $loan->where('status', 'dikembalikan_terlambat')->count();

            return $this->successResponse([
                'total_buku_dipinjam' => $totalDipinjam,
                'total_buku_terlambat' => $totalTerlambat,
                'data' => LoanResource::collection($loan)
            ], 'Data peminjaman berhasil ditemukan.');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil data peminjaman', 500);
        }
    }

    public function showDetailLoan($id)
    {
        try {
            $loan = $this->loanService->showDetailLoan($id);
            return $this->successResponse(new LoanResource($loan), 'Detail peminjaman berhasil ditemukan.');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Detail peminjaman tidak ditemukan', 404);
        }
    }

    public function showLoanDipesan()
    {
        try {
            $loans = $this->loanService->showLoanDipesan();
            return $this->successResponse(
                LoanResource::collection($loans),
                'Data peminjaman dengan status dipesan berhasil ditemukan.'
            );
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil data peminjaman dipesan', 500);
        }
    }
}
