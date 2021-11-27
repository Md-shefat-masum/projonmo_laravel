<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image as interImage;
use Throwable;

class BlogController extends Controller
{
    public function list()
    {
        return view('admin.blog.list');
    }

    public function blog_comment()
    {
        return view('admin.blog.blog_comment');
    }

    public function get_commentjson(Request $request)
    {
        $comment = BlogComment::orderBy('id','DESC')->with([
            'blog' => function ($query) {
                $query->select([
                    'id',
                    'title',
                    'image',
                    'slug',
                    'short_description',
                ]);
            }
        ])
        ->whereExists(function ($query) {
            $query->select(DB::raw(1))
                  ->from('blogs')
                  ->whereColumn('blogs.id', 'blog_comments.blog_id');
        })
        ->paginate(10);

        return response($comment);
    }

    public function comment_accept(Request $request)
    {
        $comment = BlogComment::find($request->id);
        $comment->status == 0?$comment->status = 1: $comment->status = 0;
        $comment->save();
        return response('success');
    }

    public function comment_delete($id)
    {
        $comment = BlogComment::find($id);
        BlogComment::where('parent',$comment->id)->delete();
        $comment->delete();
        return response('success');
    }

    public function list_json()
    {
        $blog = Blog::where('status',1)
                    ->select(['id','title','image','short_description'])
                    ->with([
                        'categories' => function ($query) {
                            $query->select([
                                'blog_categories.id',
                                'name'
                            ]);
                        }
                    ])
                    ->paginate(5);

        return response()->json($blog,200);
    }

    public function get_json($id)
    {
        $blog = Blog::where('status',1)
                    ->where('id',$id)
                    ->with([
                        'categories' => function ($query) {
                            $query->select([
                                'blog_categories.id',
                                'name'
                            ]);
                        }
                    ])
                    ->first();

        return response()->json($blog,200);
    }

    public function create()
    {
        return view('admin.blog.create');
    }
    public function edit($id)
    {
        return view('admin.blog.edit');
    }

    public function url_check(Request $request)
    {
        if (Blog::where('url', $request->url)->exists()) {
            if ($request->has('id') && Blog::where('url', $request->url)->where('id', $request->id)->exists()) {
                return response()->json(false);
            } elseif ($request->has('id') && Blog::where('url', $request->url)->exists()) {
                return response()->json(true . '2nd');
            } else {
                return response()->json(false);
            }
        }
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'url' => ['required', 'unique:blogs'],
            'selected_categories' => ['required', "min:3"],
            'description' => ['required', 'min:100'],
            'short_description' => ['required'],
            'image' => ['required', 'mimes:jpg,jpeg,png'],
        ], [
            'selected_categories.min' => "No category selected.",
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            // $path = Storage::put('uploads/file_manager',$request->file('fm_file'));
            try {
                $file = $request->file('image');
                // dd($file);
                $extension = $file->getClientOriginalExtension();
                $temp_name  = uniqid(10) . time();

                $image = interImage::make($file);

                // book size
                $canvas = interImage::canvas(740, 400);
                $image->resize(740, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $canvas->insert($image, 'center-center');
                $canvas->insert(interImage::make(public_path('logo.png'))->opacity(50), 'bottom-right');

                $path = 'uploads/blog/blog_740x400_' . $temp_name . '.' . $extension;
                $canvas->save($path);
            } catch (Throwable $e) {
                report($e);
                return response()->json($e, 500);
            }
        }

        $data = $request->except(['image', 'selected_categories']);
        $blog = Blog::create($data);
        $blog->category_list = $request->selected_categories;
        $blog->image = $path;
        $blog->creator = Auth::user()->id;
        $blog->slug = $blog->url;
        $blog->save();

        try{
            $blog->categories()->attach(json_decode($blog->category_list));
        }catch (Throwable $e) {
            report($e);
            return response()->json($e, 500);
        }

        return response()->json($blog,200);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'title' => ['required'],
            'selected_categories' => ['required', "min:3"],
            'description' => ['required', 'min:100'],
            'short_description' => ['required'],
            // 'image' => ['required', 'mimes:jpg,jpeg,png'],
        ], [
            'selected_categories.min' => "No category selected.",
        ]);

        $blog = Blog::find($request->id);

        if($blog->url != $request->url){
            $this->validate($request,[
                'url' => ['required', 'unique:blogs'],
            ]);
        }

        $path = null;
        if ($request->hasFile('image')) {
            // $path = Storage::put('uploads/file_manager',$request->file('fm_file'));
            if(file_exists(public_path($blog->image))){
                unlink(public_path($blog->image));
            }
            try {
                $file = $request->file('image');
                // dd($file);
                $extension = $file->getClientOriginalExtension();
                $temp_name  = uniqid(10) . time();

                $image = interImage::make($file);

                // book size
                $canvas = interImage::canvas(740, 400);
                $image->resize(740, null, function ($constraint) {
                    $constraint->aspectRatio();
                });
                $canvas->insert($image, 'center-center');
                $canvas->insert(interImage::make(public_path('logo.png'))->opacity(50), 'bottom-right');

                $path = 'uploads/blog/blog_740x400_' . $temp_name . '.' . $extension;
                $canvas->save($path);
                $blog->image = $path;
            } catch (Throwable $e) {
                report($e);
                return response()->json($e, 500);
            }
        }

        $data = $request->except(['image', 'selected_categories']);
        $blog->fill($data);
        $blog->category_list = $request->selected_categories;
        $blog->creator = Auth::user()->id;
        $blog->slug = $blog->url;
        $blog->save();

        try{
            $blog->categories()->sync(json_decode($blog->category_list));
        }catch (Throwable $e) {
            report($e);
            return response()->json($e, 500);
        }

        return response()->json($blog,200);
    }

    public function destroy($id)
    {
        $blog = Blog::find($id);
        $blog->status = 0;
        $blog->save();

        return response()->json('success');
    }
}
