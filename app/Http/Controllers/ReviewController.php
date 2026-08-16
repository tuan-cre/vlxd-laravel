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
            return redirect()->route('login')->with('error', 'Please log in to submit a review.');
        }

        Review::create([
            'user_id' => $nguoidung['id'],
            'product_id' => $request->product_id,
            'rating' => $request->rating,
            'comment' => $request->comment,
            'status' => 0,
        ]);

        return back()->with('success', 'Your review has been submitted and is pending approval.');
    }

    public function approve($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 1]);

        return back()->with('success', 'Review approved.');
    }

    public function reject($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['status' => 2]);

        return back()->with('success', 'Review rejected.');
    }
}
