<?php

namespace App\Http\Controllers\API\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index()
    {
        return BookResource::collection(Book::paginate(10));
    }

    public function store(BookRequest $request)
    {
        $book = Book::create($request->validated());
        return new BookResource($book, Response::HTTP_CREATED);
    }

    public function show(Book $book)
    {
        return new BookResource($book);
    }

    public function update(BookRequest $request, Book $book)
    {
        $book->update($request->all());
        return new BookResource($book);
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function uploadImage(Request $request)
    {
        // Validate file upload
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate ảnh
        ]);

        // Kiểm tra và lưu ảnh
        if (!$request->hasFile('image')) {
            // Trả lỗi nếu không có file nào được upload
            return response()->json([
                'message' => 'No image uploaded'
            ], 422);
        }

        $imagePath = $request->file('image')->store('books', 'public'); // Upload vào thư mục 'books'

        // Trả về đường dẫn ảnh vừa upload
        return response()->json([
            'message' => 'Image uploaded successfully',
            'image_path' => $imagePath
        ], 201);
    }

    public function uploadImageBase64(Request $request)
    {
        // Validate đầu vào
        $request->validate([
            'image' => 'required|string', // Base64 string của ảnh
        ]);

        try {
            // Lấy base64 string từ request
            $base64Image = $request->input('image');

            // Tách phần header base64 (nếu có)
            if (str_contains($base64Image, ';base64,')) {
                [$type, $base64Image] = explode(';base64,', $base64Image);
            }

            // Decode base64 thành binary
            $binaryData = base64_decode($base64Image);

            // Tạo tên file ngẫu nhiên
            $fileName = 'book_' . uniqid() . '.png';

            // Lưu file vào thư mục public/storage/books
            $filePath = 'books/' . $fileName;
            Storage::disk('public')->put($filePath, $binaryData);

            // Trả kết quả
            return response()->json([
                'message' => 'Image uploaded successfully',
                'image_path' => asset('storage/' . $filePath),
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to upload image',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}
