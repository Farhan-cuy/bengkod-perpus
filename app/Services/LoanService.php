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
}

