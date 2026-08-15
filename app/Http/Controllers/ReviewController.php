<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ReviewController extends Controller
{
    public function store(StoreReviewRequest $request)
    {
        $nguoidung = Session::get('nguoidung');

        if (!$nguoidung) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập để đánh giá.');
        }

        Review::create([
            'user_id' => $nguoidung->id,
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 0,
        ]);

        return back()->with('success', 'Đánh giá của bạn đã được gửi và đang chờ duyệt.');
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 1]);

        return back()->with('success', 'Đã duyệt đánh giá.');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 2]);

        return back()->with('success', 'Đã từ chối đánh giá.');
    }
}
