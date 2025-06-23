<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Loan;

class UpdateLoanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [6, 7, 12, 15];
        $books = range(1, 18);
        $months = [
            '01' => 'Januari',
            '02' => 'Februari',
            '03' => 'Maret',
            '04' => 'April',
            '05' => 'Mei',
        ];

        $statuses = ['dikembalikan', 'dikembalikan_terlambat'];

        foreach ($months as $month => $namaBulan) {
            for ($i = 0; $i < 4; $i++) { // 4 data per bulan
                $userId = $users[array_rand($users)];
                $bookId = $books[array_rand($books)];
                $status = $statuses[array_rand($statuses)];

                $tglPinjam = "2025-$month-0" . rand(1, 5);
                $tglBatas = "2025-$month-15";
                $tglKembali = $status === 'dikembalikan'
                    ? "2025-$month-" . rand(8, 14)
                    : "2025-$month-" . rand(16, 22);

                Loan::create([
                    'id_user' => $userId,
                    'id_buku' => $bookId,
                    'status' => $status,
                    'batas_waktu' => $tglBatas,
                    'waktu_dipinjam' => $tglPinjam,
                    'waktu_dikembalikan' => $tglKembali,
                    'created_at' => $tglPinjam,
                    'updated_at' => $tglKembali,
                ]);
            }
        }
    }
}
