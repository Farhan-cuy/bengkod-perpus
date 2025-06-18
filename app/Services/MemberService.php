<?php

namespace App\Services;

use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Exception;

class MemberService
{
    public function borrowBook($bookId)
    {
        $book = Book::findOrFail($bookId);

        if ($book->stock < 1) {
            throw new Exception('Buku tidak tersedia');
        }

        $loan = Loan::create([
            'id_user' => Auth::id(),
            'id_buku' => $book->id,
            'status' => 'dipesan',
        ]);

        $book->decrement('stock');

        return $loan;
    }

    public function cancelBorrow($loanId)
    {
        $loan = Loan::where('id', $loanId)
            ->where('id_user', Auth::id())
            ->where('status', 'dipesan')
            ->first();

        if (!$loan) {
            throw new Exception('Peminjaman tidak ditemukan atau sudah divalidasi');
        }

        $loan->book->increment('stock');
        $loan->status = 'dibatalkan';
        $loan->save();

        return $loan;
    }

    public function getActiveLoans()
    {
        return Loan::with(['book'])
            ->where('id_user', auth()->id())
            ->whereIn('status', ['dipinjam'])
            ->orderByDesc('created_at')
            ->get();
    }

    public function getBorrowHistory()
    {
        return Loan::with(['book'])
            ->where('id_user', auth()->id())
            ->whereIn('status', ['dikembalikan', 'dikembalikan_terlambat'])
            ->orderByDesc('created_at')
            ->get();
    }
}
