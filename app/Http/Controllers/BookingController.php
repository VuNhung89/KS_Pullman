<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BookingController extends Controller
{
    // Khách tạo bookings
    public function store(Request $request)
    {
        //sử dụng phương thức validate trong Laravel để xác thực dữ liệu đầu vào từ một request
        $request->validate([
            'room_id' => 'required|exists:rooms,id', //required: Trường room_id phải có giá trị, không được để trống. exists:rooms,id: Giá trị của room_id phải tồn tại trong cột id của bảng rooms trong cơ sở dữ liệu.
            'checkin_date' => 'required|date|after_or_equal:today', //date: Giá trị phải là định dạng ngày hợp lệ. after_or_equal:today: Ngày nhận phòng phải từ hôm nay trở đi.
            'checkout_date' => 'required|date|after: checkin+date', //after:checkin_date: Ngày trả phòng phải sau ngày nhận phòng.
        ]);

        $bookings = Booking::create(
            [
                'user_id' => auth()->id(),
                'room_id' => $request->room_id,
                'checkin_date' => $request->checkin_date,
                'checkout_date' => $request->checkout_date,
                'status' => 'pending', // mặc định ban đầu
            ]
        );
        return response()->json([
            'data' => $bookings,
            'message' => 'Tạo bookings thành công!'
        ], 201);
    }

    // Khách xem lại danh sách bookings của mình
    public function myBookings()
    {
        $bookings = Booking::with('room') // Lấy tất cả bản ghi từ bảng bookings và đồng thời lấy dữ liệu từ bảng rooms dựa trên mối quan hệ được định nghĩa (thường qua khóa ngoại như room_id trong bảng bookings, trong with('room') thì room là tên hàm public function room có trong model Booking
            ->where('user_id', auth()->id()) // Lọc các bản ghi bookings thuộc về người dùng hiện tại (dựa trên ID của người dùng đã đăng nhập)
            ->get();
        return response()->json([
            'data' => $bookings,
            'message' => 'Lấy danh sách bookings thành công!'
        ], 200);
    }

    // Admin xem toàn bộ danh sách bookings
    public function index()
    {
        $bookings = Booking::with('room', 'user')->get();
        return response()->json([
            'data' => $bookings,
            'message' => 'Lấy danh sách bookings thành công!',
        ], 200);
    }

    // Admin chỉnh sửa trạng thái bookings
    public function update(Request $request, $id)
    {
        Log::info('Request data:', $request->all());
        // Lấy ID từ $request->id():
        // Trong Laravel, để lấy id từ request, bạn không gọi $request->id() như một phương thức. Đúng cách là $request->id (truy cập thuộc tính) hoặc $request->input('id').
        // Hơn nữa, trong route API, id thường được truyền qua URL (ví dụ: PUT /bookings/{id}), nên bạn cần khai báo $id làm tham số trong phương thức update thay vì lấy từ $request.
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled', //các giá trị phải nằm trong in: pending, confirmed, cancelled
        ]);

        $booking = Booking::findOrFail($id);
        $booking->update(
            [
                'status' => $request->status,
            ]
        );
        return response()->json([
            'data' => $booking,
            'message' => 'Sửa trạng thái thành công!'
        ], 201);
    }
}
