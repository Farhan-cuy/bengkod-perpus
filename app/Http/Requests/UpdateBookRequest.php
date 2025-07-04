<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => 'sometimes|required|string',
            'penulis' => 'sometimes|required|string',
            'deskripsi' => 'sometimes|required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'penerbit' => 'nullable|string',
            'tahun_terbit' => 'nullable|digits:4|integer',
            'kategori' => 'nullable|string',
            'stock_awal' => 'nullable|integer|min:0',
        ];
    }
}
