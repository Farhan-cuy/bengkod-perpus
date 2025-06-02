<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;
use Illuminate\Support\Carbon;

class LoanSeeder extends Seeder
{
    public function run(): void
    {
        Loan::create([
            'id_user' => 1,
            'id_buku' => 4,
            'status' => 'dipinjam',
            'batas_waktu' => Carbon::now()->addDays(7),
        ]);
    }
}
