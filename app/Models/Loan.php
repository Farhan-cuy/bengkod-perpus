<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Loan extends Model
{
    protected $fillable = [
    'id_user',
    'id_buku',
    'status',
    'batas_waktu',];
    public function user(): BelongsTo{
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
    public function book(): BelongsTo{
        return $this->belongsTo(Book::class, 'id_buku', 'id');
    }

}
