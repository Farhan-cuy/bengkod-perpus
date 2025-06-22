<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;

class LoanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $batas = $this->batas_waktu ? Carbon::parse($this->batas_waktu) : null;
        $today = Carbon::today();

        return [
            'id_peminjaman' => $this->id,
            'user' => $this->user ? $this->user->name : null,
            'buku' => $this->book ? $this->book->judul : null,
            'batas_tanggal' => $this->batas_waktu,
            // Waktu pesan (saat request dibuat)
            'tanggal_pesan' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'waktu_pesan' => $this->created_at ? $this->created_at->format('H:i:s') : null,
            // Waktu dipinjam (saat dikonfirmasi)
            'tanggal_dipinjam' => $this->waktu_dipinjam ? Carbon::parse($this->waktu_dipinjam)->format('Y-m-d') : null,
            'waktu_dipinjam' => $this->waktu_dipinjam ? Carbon::parse($this->waktu_dipinjam)->format('H:i:s') : null,
            'tanggal_dikembalikan' => $this->waktu_dikembalikan ? Carbon::parse($this->waktu_dikembalikan)->format('Y-m-d') : null,
            'sisa_hari' => ($this->status === 'dipinjam') ? ($batas ? $today->diffInDays($batas, false) : null): null,
            'status' => $this->status,
        ];
    }
}
