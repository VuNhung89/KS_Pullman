<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    // User gửi liên hệ
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'message' => 'nullable|min:10'
        ]);
        $contacts = Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'message' => $request->message
        ]);
        return response()->json([
            'data' => $contacts,
            'message' => 'Tạo liên hệ thành công!'
        ], 201);
    }

    // Hiển thị danh sách liên hệ
    public function index()
    {
        $contacts = Contact::orderBy('created_at', 'desc');
        return response()->json([
            'data' => $contacts,
            'message' => 'Lấy danh sách liên hệ thành công!'
        ], 200);
    }

    // Xóa liên hệ
    public function destroy($id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();
        return response()->json(['message' => 'Xóa thành công!'], null);
    }
}
