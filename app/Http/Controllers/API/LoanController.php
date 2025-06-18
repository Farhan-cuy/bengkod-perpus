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
            return $this->successResponse(LoanResource::collection($loan), 'Data peminjaman berhasil ditemukan.');
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
}
