<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;

class PustakawanController extends Controller
{
    public function showProfile()
    {
        return $this->successResponse(Auth::user(), 'Profil pustakawan berhasil diambil');
    }

    public function validateBorrow($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'dipesan') {
            return $this->exceptionError(
                new \Exception('Peminjaman tidak dapat divalidasi'),
                null,
                400
            );
        }

        $loan->status = 'dipinjam';
        $loan->batas_waktu = now()->addDays(7); // Set batas waktu peminjaman 7 hari
        $loan->waktu_dipinjam = now();
        $loan->save();

        return $this->successResponse($loan, 'Peminjaman telah divalidasi');
    }

    public function validateReturn($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'dipinjam') {
            return $this->exceptionError(
                new \Exception('Buku belum dipinjam atau sudah dikembalikan'),
                null,
                400
            );
        }

        $loan->status = 'dikembalikan';
        $loan->waktu_dikembalikan = now();
        $loan->save();

        // Tambah stok buku kembali
        $loan->book->increment('stock');

        return $this->successResponse($loan, 'Pengembalian berhasil divalidasi');
    }
}
