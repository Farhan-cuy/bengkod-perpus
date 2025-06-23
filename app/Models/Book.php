<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [ 'judul', 'penulis', 'deskripsi', 'stock','stock_awal', 'image','penerbit', 'tahun_terbit', 'kategori'];

    public function loan(): HasMany {
        return $this->hasMany(Loan::class,'id_buku','id',);
    }

}
