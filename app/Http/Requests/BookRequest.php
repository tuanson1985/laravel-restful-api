<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function rules()
    {
        // Lấy ID của book từ route
        $bookId = $this->route('book')?->id;

        // Kiểm tra phương thức HTTP (PATCH hoặc PUT)
        $isPatch = $this->isMethod('patch');

        return [
            // Các trường chỉ cần nullable khi là PATCH
            'title' => $isPatch ? 'nullable|string|max:255' : 'required|string|max:255',
            'author' => $isPatch ? 'nullable|string|max:255' : 'required|string|max:255',
            'isbn' => $isPatch ? 'nullable|string|unique:books,isbn,' . $bookId : 'required|string|unique:books,isbn,' . $bookId,
            'published_at' => $isPatch ? 'nullable|date' : 'required|date', // Giảm bớt yêu cầu đối với PATCH
            'image' => 'nullable|string',
            'image_banner' => 'nullable|string', // Quy tắc cho image_banner
        ];
    }
}
