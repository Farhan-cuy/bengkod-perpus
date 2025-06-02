<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;

class BookController extends Controller
{
    public function searchBookByJudul(Request $request)
    {
        $keyword = $request->input('keyword');
        $books = Book::where('judul', 'like', "%$keyword%")->get();
        return $this->successResponse($books, 'Pencarian buku berhasil');
    }

    public function showBook()
    {
        $books = Book::all();
        return $this->successResponse($books, 'Daftar buku berhasil diambil');
    }

    public function showDetailBook($id)
    {
        $book = Book::findOrFail($id);
        return $this->successResponse($book, 'Detail buku berhasil ditemukan');
    }

    public function createBook(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'deskripsi' => 'required|string',
            'stock' => 'required|integer|min:1'
        ]);
        $book = Book::create($request->all());
        return $this->successResponse($book, 'Buku telah ditambahkan', 201);
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $book->update($request->only(['judul', 'penulis', 'deskripsi', 'stock']));
        return $this->successResponse($book, 'Buku berhasil diperbarui');
    }

    public function deleteBook($id)
    {
        $book = Book::findOrFail($id);
        $book->delete();
        return $this->successResponse(null, 'Buku berhasil dihapus');
    }
}
