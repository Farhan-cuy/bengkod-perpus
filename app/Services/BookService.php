<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function searchBook($keyword)
    {
        return Book::where(function ($query) use ($keyword) {
            $query->where('judul', 'like', "%$keyword%")
                ->orWhere('penulis', 'like', "%$keyword%")
                ->orWhere('penerbit', 'like', "%$keyword%")
                ->orWhere('tahun_terbit', 'like', "%$keyword%")
                ->orWhere('kategori', 'like', "%$keyword%");
        })->get();
    }

    public function showBook()
    {
        return Book::all();
    }

    public function showDetailBook($id)
    {
        return Book::findOrFail($id);
    }

    public function createBook($data)
    {
        return Book::create($data);
    }

    public function updateBook($id, $data)
    {
        $book = Book::findOrFail($id);
        $book->update($data);
        return $book;
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return $book;
    }
}
