<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    // Xem danh sách phòng
    public function index(Request $request)
    {
        $rooms = Room::filter($request->only(['type', 'min_price', 'max_price']))->get();
        return response()->json(['data' => $rooms, 'message' => 'Lấy danh sách phòng thành công!'], 201); //convert sang json
    }

    // Xem chi tiết phòng
    public function show($id)
    {
        $room = Room::findOrFail($id); //tìm kiếm thì trả về, còn không thì báo lỗi
        return response()->json(['data' => $room, 'message' => 'Lấy chi tiết phòng thành công!'], 201);
    }

    //CRUD của admin
    // Thêm phòng
    public function store(Request $request)
    {
        $room = Room::create($request->all());
        return response()->json(['data' => $room, 'message' => 'Thêm phòng thành công!'], 201);
    }

    // Sửa phòng
    public function update(Request $request, $id)
    {
        $room = Room::findOrFail($id);
        $room->update($request->all());
        return response()->json(['data' => $room, 'message' => 'Sửa phòng thành công!'], 201);
    }

    // Xóa phòng
    public function destroy($id)
    {
        $room = Room::findOrFail($id);
        $room->delete();
        return response(['message' => 'Xóa phòng thành công!'], 204);
    }
}
