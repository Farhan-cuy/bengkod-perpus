<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function searchBookByJudul(Request $request)
    {
        $keyword = $request->input('keyword');
        $books = $this->bookService->searchBookByJudul($keyword);
        return $this->successResponse($books, 'Pencarian buku berhasil');
    }

    public function showBook()
    {
        $books = $this->bookService->showBook();
        return $this->successResponse($books, 'Daftar buku berhasil diambil');
    }

    public function showDetailBook($id)
    {
        $book = $this->bookService->showDetailBook($id);
        return $this->successResponse($book, 'Detail buku berhasil ditemukan');
    }

    public function createBook(Request $request)
    {
        $request->validate([
            'judul' => 'required|string',
            'penulis' => 'required|string',
            'deskripsi' => 'required|string',
            'stock' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['judul', 'penulis', 'deskripsi', 'stock']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book = $this->bookService->createBook($data);
        return $this->successResponse($book, 'Buku telah ditambahkan', 201);
    }

    public function updateBook(Request $request, $id)
    {
        $request->validate([
            'judul' => 'sometimes|required|string',
            'penulis' => 'sometimes|required|string',
            'deskripsi' => 'sometimes|required|string',
            'stock' => 'sometimes|required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $data = $request->only(['judul', 'penulis', 'deskripsi', 'stock']);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('books', 'public');
        }

        $book = $this->bookService->updateBook($id, $data);
        return $this->successResponse($book, 'Buku berhasil diperbarui');
    }

    public function deleteBook($id)
    {
        $this->bookService->deleteBook($id);
        return $this->successResponse(null, 'Buku berhasil dihapus');
    }
}
