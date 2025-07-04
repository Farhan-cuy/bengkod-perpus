<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreateBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Services\BookService;
use Illuminate\Http\Request;
use App\Http\Resources\BookResource;

class BookController extends Controller
{
    protected $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function searchBook(Request $request)
    {
        try {
            $keyword = $request->input('keyword');
            $books = $this->bookService->searchBook($keyword);
            return $this->successResponse(BookResource::collection($books), 'Pencarian buku berhasil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal mencari buku', 500);
        }
    }

    public function showBook()
    {
        try {
            $books = $this->bookService->showBook();
            $total = $books->count();
            $bukuTersedia = $books->sum('stock');
            return $this->successResponse([
                'total' => $total,
                'buku_tersedia' => $bukuTersedia,
                'data' => BookResource::collection($books)
            ], 'Daftar buku berhasil diambil');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal mengambil daftar buku', 500);
        }
    }

    public function showDetailBook($id)
    {
        try {
            $book = $this->bookService->showDetailBook($id);
            return $this->successResponse(new BookResource($book), 'Detail buku berhasil ditemukan');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Buku tidak ditemukan', 404);
        }
    }

    public function createBook(CreateBookRequest $request)
    {
        try {
            $data = $request->only(['judul', 'penulis', 'deskripsi', 'stock','stock_awal', 'penerbit', 'tahun_terbit', 'kategori']);

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('books', 'public');
            }

            $data['stock_awal'] = $data['stock'];
            $book = $this->bookService->createBook($data);
            return $this->successResponse(new BookResource($book), 'Buku telah ditambahkan', 201);
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal menambah buku', 400);
        }
    }

    public function updateBook(UpdateBookRequest $request, $id)
    {
        try {
            $data = $request->only(['judul', 'penulis', 'deskripsi', 'stock', 'stock_awal', 'penerbit', 'tahun_terbit', 'kategori']);

            $book = $this->bookService->ShowDetailBook($id);

            // Jika stock_awal diupdate, sesuaikan stock juga
            if (isset($data['stock_awal'])) {
                $selisih = $data['stock_awal'] - $book->stock_awal;
                $data['stock'] = $book->stock + $selisih;
                // Pastikan stock tidak minus
                if ($data['stock'] < 0) {
                    $data['stock'] = 0;
                }
            }

            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('books', 'public');
            }

            $book = $this->bookService->updateBook($id, $data);
            return $this->successResponse(new BookResource($book), 'Buku berhasil diperbarui');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal memperbarui buku', 400);
        }
    }

    public function deleteBook($id)
    {
        try {
            $this->bookService->deleteBook($id);
            return $this->successResponse(null, 'Buku berhasil dihapus');
        } catch (\Exception $e) {
            return $this->exceptionError($e, 'Gagal menghapus buku', 400);
        }
    }
}
