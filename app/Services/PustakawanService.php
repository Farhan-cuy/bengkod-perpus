<?php

namespace App\Services;
use App\Models\Loan;

class PustakawanService
{
    public function validateBorrow($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'dipesan') {
            throw new \Exception('Peminjaman tidak dapat divalidasi');
        }

        $loan->status = 'dipinjam';
        $loan->batas_waktu = now()->addDays(7);
        $loan->waktu_dipinjam = now();
        $loan->save();

        return $loan;
    }

    public function validateReturn($id)
    {
        $loan = Loan::findOrFail($id);

        if ($loan->status !== 'dipinjam') {
            throw new \Exception('Buku belum dipinjam atau sudah dikembalikan');
        }

        if (now()->gt($loan->batas_waktu)) {
            $loan->status = 'dikembalikan_terlambat';
        } else {
            $loan->status = 'dikembalikan';
        }

        $loan->waktu_dikembalikan = now();
        $loan->save();

        // Tambah stok buku kembali
        $loan->book->increment('stock');

        return $loan;
    }
}
