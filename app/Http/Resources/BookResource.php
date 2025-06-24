<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id'        => $this->id,
            'judul'     => $this->judul,
            'penulis'   => $this->penulis,
            'penerbit'  => $this->penerbit,
            'tahun_terbit' => $this->tahun_terbit,
            'kategori'  => $this->kategori,
            'sinopsis' => $this->deskripsi,
            'stock'     => $this->stock,
            'stock_awal' => $this->stock_awal,
            'image'     => $this->image ? asset('storage/' . $this->image) : null,
        ];
    }
}
