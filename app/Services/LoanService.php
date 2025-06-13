<?php

namespace App\Services;
use App\Models\Loan;
use Illuminate\Support\Facades\Auth;
use Exception;

class LoanService
{
    public function showDataLoan()
    {
        $loans = Loan::with(['user', 'book'])->get();

        $formattedLoans = $loans->map(function ($loan) {
            return [
                'id_peminjaman' => $loan->id,
                'user' => [
                    'id_user' => $loan->user->id,
                    'name' => $loan->user->name,
                    'email' => $loan->user->email,
                ],
                'book' => [
                    'id_buku' => $loan->book->id,
                    'judul' => $loan->book->judul,
                    'penulis' => $loan->book->penulis,
                ],
                'batas_waktu' => $loan->batas_waktu,
                'waktu_dipinjam' => $loan->waktu_dipinjam,
                'waktu_dikembalikan' => $loan->waktu_dikembalikan,
                'status' => $loan->status,
            ];
        });

        return $loans;
    }

    public function showDetailLoan($id)
    {
        $loan = Loan::with(['user', 'book'])->findOrFail($id);

        $formattedLoan = [
            'id_peminjaman' => $loan->id,
            'user' => [
                'id_user' => $loan->user->id,
                'name' => $loan->user->name,
                'email' => $loan->user->email,
            ],
            'book' => [
                'id_buku' => $loan->book->id,
                'judul' => $loan->book->judul,
                'penulis' => $loan->book->penulis,
            ],
            'batas_waktu' => $loan->batas_waktu,
            'waktu_dipinjam' => $loan->waktu_dipinjam,
            'waktu_dikembalikan' => $loan->waktu_dikembalikan,
            'status' => $loan->status,
        ];

        return $loan;
    }
}

