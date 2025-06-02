<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Loan;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class MemberController extends Controller
{

    // Pinjam (booking) buku oleh anggota
    public function borrowBook(Request $request)
    {
        $request->validate([
            'id_buku' => 'required|exists:books,id',
        ]);

        $book = Book::findOrFail($request->id_buku);

        if ($book->stock < 1) {
            return $this->exceptionError(
                new \Exception('Buku tidak tersedia'),
                null,
                400
            );
        }

        $loan = Loan::create([
            'id_user' => Auth::id(),
            'id_buku' => $book->id,
            'status' => 'dipesan',
        ]);

        $book->stock -= 1;
        $book->save();

        return $this->successResponse($loan, 'Buku berhasil dipesan', 201);
    }

    public function cancelBorrow($id)
    {
        $loan = Loan::where('id', $id)
            ->where('id_user', Auth::id())
            ->where('status', 'dipesan')
            ->first();

        if (!$loan) {
            return $this->exceptionError(
                new \Exception('Peminjaman tidak ditemukan atau sudah divalidasi'),
                null,
                404
            );
        }

        $loan->book->increment('stock');
        $loan->status = 'dibatalkan';
        $loan->save();

        return $this->successResponse($loan, 'Peminjaman berhasil dibatalkan');
    }
}
