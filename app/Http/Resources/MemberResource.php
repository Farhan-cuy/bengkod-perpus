<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MemberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id_peminjaman' => $this->id,
            'judul' => $this->book ? $this->book->judul : null,
            'tanggal_peminjaman' => $this->created_at ? $this->created_at->format('Y-m-d') : null,
            'waktu_peminjaman' => $this->created_at ? $this->created_at->format('H:i:s') : null,
            'tanggal_konfirm' => $this->waktu_dipinjam ? \Carbon\Carbon::parse($this->waktu_dipinjam)->format('Y-m-d') : null,
            'tanggal_dikembalikan' => $this->waktu_dikembalikan ? \Carbon\Carbon::parse($this->waktu_dikembalikan)->format('Y-m-d') : null,
            'status' => $this->status,
        ];
    }
}
