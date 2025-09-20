<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    // Đăng ký
    public function register(Request $request)
    {

        //kiểm tra dữ liệu nhập vào
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|min:6',
        ]);

        //tạo người dùng
        $user = User::created([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
        ]);

        return response()->json(
            [
                'message' => 'Đăng ký thành công',
                'user' => $user,
            ],
            201 // mã trạng thái 201 (created)
        );
    }

    // Đăng nhập
    public function login(Request $request)
    {
        if (!Auth::attempt($request->only('email', 'password'))) { //thử email, pass trong request có trùng với email, pass trong db hay ko
            return response()->json(['message' => 'Sai thông tin đăng nhập'], 401); //nếu không trả về lỗi 401
        }
        //lấy thông tin người dùng hiện tại
        /** @var \App\Models\User $user */
        // Dòng @var cho IDE biết:
        //$user chính xác là instance của App\Models\User.
        //Mà User đã use HasApiTokens, nên có method createToken()

        $user = Auth::user();
        //tạo token cho người dùng
        //auth_token là tên token, có thể đặt tùy ý
        //createToken() trả về một object NewAccessToken, bên trong chứa 2 thứ:
        //model token (thông tin lưu trong DB)
        //plainTextToken (chuỗi token để gửi cho client)
        //plainTextToken chính là chuỗi thô mà bạn gửi về cho frontend để lưu trữ và gửi kèm trong các request sau.
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Đăng nhập thành công',
            'access_token' => $token, //access_token: chuỗi thông báo truy cập
            'token_type' => 'Bearer', //token_type: loại token,
            'user' => $user, //thông tin người dùng
        ], 200);
    }

    // Đăng xuất
    public function logout(Request $request)
    {
        //lấy token hiện tại của user trong request → xóa nó khỏi DB
        $request()->user()->currentAccessToken()->delete();
        return response()->json(['message' => "Đăng xuất thành công!"], 200);
    }
}
