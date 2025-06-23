<?php

namespace App\Services;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoanService
{
    public function showDataLoan()
    {
        return Loan::with(['user', 'book'])->get();
    }

    public function showDetailLoan($id)
    {
        return Loan::with(['user', 'book'])->findOrFail($id);
    }

    public function showLoanDipesan()
    {
        return Loan::with(['user', 'book'])
            ->where('status', 'dipesan')
            ->get();
    }

    public function showLoanDipinjam()
    {
        return Loan::with(['user', 'book'])
            ->where('status', 'dipinjam')
            ->get();
    }

    public function showLoanDikembalikan()
    {
        return Loan::with(['user', 'book'])
            ->whereIn('status', ['dikembalikan', 'dikembalikan_terlambat'])
            ->get();
    }

    public function rekapPeminjamanPerBulan()
    {
        return Loan::selectRaw('
            DATE_FORMAT(waktu_dikembalikan, "%Y-%m") as bulan,
            SUM(status = "dikembalikan") as total_berhasil,
            SUM(status = "dikembalikan_terlambat") as total_terlambat
        ')
            ->whereIn('status', ['dikembalikan', 'dikembalikan_terlambat'])
            ->whereNotNull('waktu_dikembalikan')
            ->groupBy('bulan')
            ->orderBy('bulan', 'desc')
            ->get();
    }
}

