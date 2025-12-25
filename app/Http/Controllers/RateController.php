<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use Illuminate\Http\Request;
use App\Models\Rating;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class RateController extends Controller
{
    public function showRateForm($docid)
    {
        $doctor = Doctor::with('reviews')->find($docid);

        $existing = Review::where('doctor_id', $docid)
            ->where('patient_id', Auth::guard('patient')->user()->pid)->first();
        return view('client.ratingscreen.rating', compact('doctor', 'existing'));
    }

    public function storeReview(Request $request)
    {

        $request->validate([
            'doctor_id' => 'required|exists:doctors,docid',
            'rating' => 'required|integer|between:1,5',
            'review' => 'nullable|string',
        ]);
        $review = new Review();
        $review->doctor_id = $request->input('doctor_id');
        $review->patient_id = Auth::guard('patient')->user()->pid;
        $review->rating = $request->input('rating');
        $review->review = $request->input('review');
        $review->save();

    
        $doctorRating = Rating::where('doctor_id', $request->input('doctor_id'))->first();
        if (!$doctorRating) {
            $doctorRating = new Rating();
            $doctorRating->doctor_id = $request->input('doctor_id');
            $doctorRating->average_rating = 0;
            $doctorRating->review_count = 0;
        }
        $doctorRating->average_rating = (($doctorRating->average_rating * $doctorRating->review_count) + $request->input('rating')) / ($doctorRating->review_count + 1);
        $doctorRating->review_count++;
        $doctorRating->save();

        return redirect()->back()->with('success', 'Review submitted successfully');
    }


    public function updateReview(Request $request, $id)
    {
        $review = Review::find($id);
        if (!$review) {
            return redirect()->back()->with('error', 'Review not found');
        }

        if ($review->patient_id != Auth::guard('patient')->user()->pid) {
            return redirect()->back()->with('error', 'You are not authorized to update this review');
        }

        $review->rating = $request->input('rating');
        $review->review = $request->input('review');
        $review->save();

        return redirect()->back()->with('success', 'Review updated successfully');
    }

    public function deleteReview($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return redirect()->back()->with('error', 'Review not found');
        }

        if ($review->patient_id != Auth::guard('patient')->user()->pid) {
            return redirect()->back()->with('error', 'You are not authorized to delete this review');
        }

        $review->delete();

        return redirect()->back()->with('success', 'Review deleted successfully');
    }
}
