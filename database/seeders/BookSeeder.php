<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'deskripsi' => 'Kisah inspiratif anak-anak dari Belitung yang penuh semangat belajar.',
                'stock' => 5,
                'image' => 'books/laskar-pelangi.jpg',
            ],
            [
                'judul' => 'Negeri 5 Menara',
                'penulis' => 'Ahmad Fuadi',
                'deskripsi' => 'Perjalanan hidup di pesantren dengan semangat man jadda wajada.',
                'stock' => 3,
                'image' => 'books/negeri-5-menara.jpg',
            ],
            [
                'judul' => 'Bumi',
                'penulis' => 'Tere Liye',
                'deskripsi' => 'Petualangan remaja dengan kekuatan luar biasa di dunia paralel.',
                'stock' => 4,
                'image' => 'books/bumi.jpg',
            ],
            [
                'judul' => 'Dilan 1990',
                'penulis' => 'Pidi Baiq',
                'deskripsi' => 'Kisah cinta remaja Bandung yang lucu dan romantis.',
                'stock' => 6,
                'image' => 'books/dilan-1990.jpg',
            ],
            [
                'judul' => 'Atomic Habits',
                'penulis' => 'James Clear',
                'deskripsi' => 'Panduan membangun kebiasaan kecil untuk perubahan besar.',
                'stock' => 2,
                'image' => 'books/atomic-habits.jpg',
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}

