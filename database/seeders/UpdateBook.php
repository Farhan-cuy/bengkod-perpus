<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class UpdateBook extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data lama (opsional, hati-hati di production)
        // Book::truncate();

        $books = [
            [
                'judul' => 'Detektif Conan Vol. 1',
                'penulis' => 'Gosho Aoyama',
                'deskripsi' => 'Kasus pertama Shinichi Kudo sebagai Conan Edogawa.',
                'stock' => 10,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 1998,
                'kategori' => 'Komik',
                'image' => 'books/conan1.jpg',
            ],
            [
                'judul' => 'Detektif Conan Vol. 2',
                'penulis' => 'Gosho Aoyama',
                'deskripsi' => 'Kasus lanjutan Conan Edogawa.',
                'stock' => 8,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 1998,
                'kategori' => 'Komik',
                'image' => 'books/conan2.jpg',
            ],
            [
                'judul' => 'Naruto Vol. 1',
                'penulis' => 'Masashi Kishimoto',
                'deskripsi' => 'Awal petualangan ninja Naruto Uzumaki.',
                'stock' => 12,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 2000,
                'kategori' => 'Komik',
                'image' => 'books/naruto1.jpg',
            ],
            [
                'judul' => 'Naruto Vol. 2',
                'penulis' => 'Masashi Kishimoto',
                'deskripsi' => 'Ujian Chuunin dimulai!',
                'stock' => 10,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 2000,
                'kategori' => 'Komik',
                'image' => 'books/naruto2.jpg',
            ],
            [
                'judul' => 'Sailor Moon Vol. 1',
                'penulis' => 'Naoko Takeuchi',
                'deskripsi' => 'Awal petualangan Usagi sebagai Sailor Moon.',
                'stock' => 9,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 1996,
                'kategori' => 'Komik',
                'image' => 'books/sailormoon1.jpg',
            ],
            [
                'judul' => 'Sailor Moon Vol. 2',
                'penulis' => 'Naoko Takeuchi',
                'deskripsi' => 'Pertemuan dengan Sailor Mercury.',
                'stock' => 8,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 1996,
                'kategori' => 'Komik',
                'image' => 'books/sailormoon2.jpg',
            ],
            [
                'judul' => 'One Piece Vol. 1',
                'penulis' => 'Eiichiro Oda',
                'deskripsi' => 'Awal petualangan Luffy mencari One Piece.',
                'stock' => 11,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 2002,
                'kategori' => 'Komik',
                'image' => 'books/onepiece1.jpg',
            ],
            [
                'judul' => 'One Piece Vol. 2',
                'penulis' => 'Eiichiro Oda',
                'deskripsi' => 'Luffy bertemu Zoro.',
                'stock' => 10,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 2002,
                'kategori' => 'Komik',
                'image' => 'books/onepiece2.jpg',
            ],
            [
                'judul' => 'Doraemon Vol. 1',
                'penulis' => 'Fujiko F. Fujio',
                'deskripsi' => 'Petualangan pertama Doraemon dan Nobita.',
                'stock' => 13,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 1991,
                'kategori' => 'Komik',
                'image' => 'books/doraemon1.jpg',
            ],
            [
                'judul' => 'Doraemon Vol. 2',
                'penulis' => 'Fujiko F. Fujio',
                'deskripsi' => 'Alat-alat ajaib Doraemon kembali beraksi.',
                'stock' => 12,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 1991,
                'kategori' => 'Komik',
                'image' => 'books/doraemon2.jpg',
            ],
            [
                'judul' => 'Dragon Ball Vol. 1',
                'penulis' => 'Akira Toriyama',
                'deskripsi' => 'Goku memulai petualangan mencari Dragon Ball.',
                'stock' => 10,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 1995,
                'kategori' => 'Komik',
                'image' => 'books/dragonball1.jpg',
            ],
            [
                'judul' => 'Dragon Ball Vol. 2',
                'penulis' => 'Akira Toriyama',
                'deskripsi' => 'Pertarungan Goku dan Bulma berlanjut.',
                'stock' => 9,
                'penerbit' => 'Elex Media Komputindo',
                'tahun_terbit' => 1995,
                'kategori' => 'Komik',
                'image' => 'books/dragonball2.jpg',
            ],
        ];

        foreach ($books as $book) {
            Book::updateOrCreate(
                ['judul' => $book['judul']],
                $book
            );
        }
    }
}
