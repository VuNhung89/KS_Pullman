<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    // 👉 Tại sao có $fillable?

    // Để tránh lỗi MassAssignmentException khi bạn dùng Room::create($request->all()).

    // Nó như một whitelist: chỉ các cột được liệt kê mới có thể gán tự động.
    protected $fillable = [
        'name',
        'type',
        'price',
        'description',
        'image',
        'status'
    ];

    // Một phòng có nhiều booking
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // Lọc
    public function scopeFilter($query, $filters)
    {
        return $query
            ->when($filters['type'] ?? null, function ($q, $type) {
                return $q->where('type', $type);
            })
            ->when($filters['min_price'] ?? null, function ($q, $min_price) {
                return $q->where('price', '>=', $min_price);
            })
            ->when($filters['max_price'] ?? null, function ($q, $max_price) {
                return $q->where('price', '<=', $max_price);
            });

        // Scope filter: nhận $filters từ request và áp dụng điều kiện vào $query.
        // - $query: query builder gốc. (Nó đại diện cho câu truy vấn đang xây dựng, ví dụ SELECT * FROM rooms.)
        // - $filters['type']: dữ liệu lấy từ request, khi nhận key A thì query tới cột B thế này
        // - $filters['min_price'] và $filters['max_price']: là tham số lọc do người dùng gửi từ request, là key, không phải cột cố định trong bảng
        // - $q trong callback chính là query builder được tiếp tục chain để thêm điều kiện, cần so sánh với cột price (có thật trong DB), còn min_price và max_price chỉ là tham số lọc từ request.
    }
}
