<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewController extends Controller
{
    public function AllReview()
    {
        $review = Review::latest()->get();

        return view('admin.backend.review.all_review', compact('review'));
    }

    public function AddReview()
    {
        return view('admin.backend.review.add_review');
    }
    public function StoreReview(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $saveUrl = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nameGen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/review'), $nameGen);

            $saveUrl = 'upload/review/'.$nameGen;
        }

        Review::create([
            'name' => $validated['name'],
            'message' => $validated['message'] ?? null,
            'image' => $saveUrl,
            'position' => $validated['position'],
        ]);

        $notification = [
            'message' => 'Review Added Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.review')->with($notification);
    }
    public function EditReview(int $id){

    $review =Review::find($id);
    return view('admin.backend.review.edit_review',compact('review'));
    }
    public function UpdateReview(request $request){
        
        $review_id= $request->id;
        
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'message' => ['nullable', 'string'],
            'image' => ['nullable', 'image', 'max:2048'],
        ]);

        $saveUrl = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $nameGen = hexdec(uniqid()).'.'.$image->getClientOriginalExtension();
            $image->move(public_path('upload/review'), $nameGen);

            $saveUrl = 'upload/review/'.$nameGen;
        

        Review::find($review_id)->update([
            'name' => $validated['name'],
            'message' => $validated['message'] ?? null,
            'image' => $saveUrl,
            'position' => $validated['position'],
        ]);

        $notification = [
            'message' => 'Review with image updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.review')->with($notification);
    }
    else {
        Review::find($review_id)->update([
            'name' => $validated['name'],
            'message' => $validated['message'] ?? null,
        
            'position' => $validated['position'],
        ]);

        $notification = [
            'message' => 'Review updated without image Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.review')->with($notification);
    }
    }
}
