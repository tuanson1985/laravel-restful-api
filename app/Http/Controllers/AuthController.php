<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),
        ]);

        return response()->json(['message' => 'User registered successfully'], 201);
    }

    public function login(Request $request)
    {
        // Xác thực dữ liệu đầu vào
        $credentials = $request->only('email', 'password');

        // Kiểm tra xem có thể tạo token JWT không
        try {
            // Nếu không thể tạo token thì trả về lỗi Unauthorized
            if (!$token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // Nếu có lỗi trong quá trình tạo token thì trả về lỗi server
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // Trả về token cho client
        return response()->json(['token' => $token]);
    }

    public function profile()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        // Hủy token hiện tại
        JWTAuth::invalidate(JWTAuth::getToken());

        // Trả về thông báo thành công
        return response()->json(['message' => 'Successfully logged out']);
    }
}
