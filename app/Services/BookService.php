<?php

namespace App\Services;

use App\Models\Book;

class BookService
{
    public function searchBookByJudul($keyword)
    {
        return Book::where('judul', 'like', "%$keyword%")->get();
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
