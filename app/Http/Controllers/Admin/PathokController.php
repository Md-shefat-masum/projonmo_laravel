<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerReview;
use App\Models\PhotoGraphp;
use App\Models\Poribeshok;
use App\Models\VideoGraph;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image as interImage;

class PathokController extends Controller
{
    public function review()
    {
        return view('admin.review.index');
    }

    public function review_json()
    {
        $reviews = CustomerReview::orderBy('id','DESC')->where('status',1)->paginate(10);
        return response($reviews);
    }

    public function review_create(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $path = 'avatar.png';
        if ($request->hasFile('image')) {
            // $path = Storage::put('uploads/file_manager',$request->file('image'));
            $file = $request->file('image');
            // dd($file);
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . time();

            $image = interImage::make($file);

            // rectangle
            $image->fit(120, 120, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'uploads/review/review_image_120x120_' . $temp_name . '.' . $extension;
            $image->save($path);
        }

        $review = CustomerReview::create($request->all());
        $review->image = $path;
        $review->save();

        return response($review);
    }

    public function review_update(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $review = CustomerReview::find($request->id);
        $path = $review->image;
        if ($request->hasFile('image')) {
            if(file_exists(public_path().'/'.$review->image)){
                unlink(public_path().'/'.$review->image);
            }
            // $path = Storage::put('uploads/file_manager',$request->file('image'));
            $file = $request->file('image');
            // dd($file);
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . time();

            $image = interImage::make($file);

            // rectangle
            $image->fit(720, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'uploads/photograph/review_image_720x600_' . $temp_name . '.' . $extension;
            $image->save($path);

        }
        $review->fill($request->all());
        $review->image = $path;
        $review->save();

        return response($review);
    }

    public function review_delete(Request $request)
    {
        $review = CustomerReview::find($request->id);
        $review->delete();
        return response('success');
    }


    // photograph

    public function photograph()
    {
        return view('admin.photograph.index');
    }

    public function photograph_json()
    {
        $reviews = PhotoGraphp::orderBy('id','DESC')->where('status',1)->paginate(10);
        return response($reviews);
    }

    public function photograph_create(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $path = 'avatar.png';
        if ($request->hasFile('image')) {
            // $path = Storage::put('uploads/file_manager',$request->file('image'));
            $file = $request->file('image');
            // dd($file);
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . time();

            $image = interImage::make($file);

            // rectangle
            $image->fit(720, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'uploads/photograph/review_image_720x600_' . $temp_name . '.' . $extension;
            $image->save($path);
        }

        $review = PhotoGraphp::create($request->all());
        $review->image = $path;
        $review->save();

        return response($review);
    }

    public function photograph_update(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $review = PhotoGraphp::find($request->id);
        $path = $review->image;
        if ($request->hasFile('image')) {
            if(file_exists(public_path().'/'.$review->image)){
                unlink(public_path().'/'.$review->image);
            }
            // $path = Storage::put('uploads/file_manager',$request->file('image'));
            $file = $request->file('image');
            // dd($file);
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . time();

            $image = interImage::make($file);

            // rectangle
            $image->fit(720, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'uploads/photograph/review_image_720x600_' . $temp_name . '.' . $extension;
            $image->save($path);

        }
        $review->fill($request->all());
        $review->image = $path;
        $review->save();

        return response($review);
    }

    public function photograph_delete(Request $request)
    {
        $review = PhotoGraphp::find($request->id);
        $review->delete();
        return response('success');
    }

    // videograph

    public function videograph()
    {
        return view('admin.videograph.index');
    }

    public function videograph_json()
    {
        $reviews = VideoGraph::orderBy('id','DESC')->where('status',1)->paginate(10);
        return response($reviews);
    }

    public function videograph_create(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $path = 'avatar.png';
        if ($request->hasFile('image')) {
            // $path = Storage::put('uploads/file_manager',$request->file('image'));
            $file = $request->file('image');
            // dd($file);
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . time();

            $image = interImage::make($file);

            // rectangle
            $image->fit(720, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'uploads/videograph/review_image_720x600_' . $temp_name . '.' . $extension;
            $image->save($path);
        }

        $review = VideoGraph::create($request->all());
        $review->image = $path;
        $review->save();

        return response($review);
    }

    public function videograph_update(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $review = VideoGraph::find($request->id);
        $path = $review->image;
        if ($request->hasFile('image')) {
            if(file_exists(public_path().'/'.$review->image)){
                unlink(public_path().'/'.$review->image);
            }
            // $path = Storage::put('uploads/file_manager',$request->file('image'));
            $file = $request->file('image');
            // dd($file);
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . time();

            $image = interImage::make($file);

            // rectangle
            $image->fit(720, 600, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'uploads/videograph/review_image_720x600_' . $temp_name . '.' . $extension;
            $image->save($path);

        }
        $review->fill($request->all());
        $review->image = $path;
        $review->save();

        return response($review);
    }

    public function videograph_delete(Request $request)
    {
        $review = VideoGraph::find($request->id);
        $review->delete();
        return response('success');
    }

    // poribeshok
    public function poribeshok()
    {
        return view('admin.poribeshok.index');
    }

    public function poribeshok_json()
    {
        $reviews = Poribeshok::orderBy('id','DESC')->where('status',1)->paginate(10);
        return response($reviews);
    }

    public function poribeshok_create(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $path = 'avatar.png';
        if ($request->hasFile('image')) {
            // $path = Storage::put('uploads/file_manager',$request->file('image'));
            $file = $request->file('image');
            // dd($file);
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . time();

            $image = interImage::make($file);

            // rectangle
            $image->resize(190, 50, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'uploads/poribeshok/review_image_720x600_' . $temp_name . '.' . $extension;
            $image->save($path);
        }

        $review = Poribeshok::create($request->all());
        $review->image = $path;
        $review->save();

        return response($review);
    }

    public function poribeshok_update(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'description' => ['required'],
        ]);

        $review = Poribeshok::find($request->id);
        $path = $review->image;
        if ($request->hasFile('image')) {
            if(file_exists(public_path().'/'.$review->image)){
                unlink(public_path().'/'.$review->image);
            }
            // $path = Storage::put('uploads/file_manager',$request->file('image'));
            $file = $request->file('image');
            // dd($file);
            $extension = $file->getClientOriginalExtension();
            $temp_name  = uniqid(10) . time();

            $image = interImage::make($file);

            // rectangle
            $image->resize(190, 50, function ($constraint) {
                $constraint->aspectRatio();
            });
            $path = 'uploads/poribeshok/review_image_720x600_' . $temp_name . '.' . $extension;
            $image->save($path);

        }
        $review->fill($request->all());
        $review->image = $path;
        $review->save();

        return response($review);
    }

    public function poribeshok_delete(Request $request)
    {
        $review = Poribeshok::find($request->id);
        $review->delete();
        return response('success');
    }
}
