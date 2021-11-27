<?php

namespace App\Http\Controllers\Blog;

use App\Http\Controllers\Controller;
use App\Models\BlogCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class BlogCategoryController extends Controller
{
    public function categories()
    {

        $categories = BlogCategory::where("status", 1)
            ->where('parent_id', 0)
            ->get();

        $all_category = [];

        foreach ($categories as $key => $item) {
            $module = $item->name . '_' . $item->id;
            if (BlogCategory::where('parent_id', $item->id)->where('status', 1)->exists()) {
                $children = BlogCategory::where('parent_id', $item->id)->where("status", 1)->get();
                $temp_category = [];
                $temp_category['id'] = $item->id;
                $temp_category['name'] = $item->name;
                $temp_category['child'] = $this->buildCategories($children, $item->id);
                $all_category[] = $temp_category;
            } else {
                $temp_category['id'] = $item->id;
                $temp_category['name'] = $item->name;
                $temp_category['child'] = [];
                $all_category[] = $temp_category;
            }
        }
        $categories = $all_category;
        return view('admin.blog.categories.categories', compact('categories'));
    }

    public static function static_categories_tree_json()
    {
        return (new self)->make_category_tree_array();
    }

    public function categories_tree_json()
    {
        return $this->make_category_tree_array();
    }

    private function buildCategories($children, $parent_id)
    {
        $result = array();
        foreach ($children as $row) {
            if ($row->parent_id == $parent_id) {
                if (BlogCategory::where('parent_id', $row->id)->where('status', 1)->exists()) {
                    $children = BlogCategory::where('parent_id', $row->id)->where("status", 1)->get();
                    $temp_category = [];
                    $temp_category['id'] = $row->id;
                    $temp_category['name'] = $row->name;
                    $temp_category['parent'] = $parent_id;
                    $temp_category['child'] = $this->buildCategories($children, $row->id);
                    $result[] = $temp_category;
                } else {
                    $temp_category['id'] = $row->id;
                    $temp_category['name'] = $row->name;
                    $temp_category['parent'] = $parent_id;
                    $temp_category['child'] = [];
                    $result[] = $temp_category;
                }
            }
        }
        return $result;
    }

    public function create_category()
    {
        $categories = $this->make_category_tree_array();
        $category_tree_view = $this->make_category_tree($categories, []);
        /*$categories = [
            [
                'id' => 11,
                'name' => 'child',
                'child' => [
                    [
                        'id' => 12,
                        'name' => 'child t-shirt',
                        'child' => [
                            [
                                'id' => 13,
                                'name' => 'child xxl'
                            ],
                        ]
                    ]
                ],
            ]
        ];*/
        return view('admin.blog.categories.create', compact('categories', 'category_tree_view'));
    }

    public function edit_category($id, $category_name)
    {
        $category = BlogCategory::find($id);
        $categories = $this->make_category_tree_array();
        $category_tree_view = $this->make_category_tree($categories, $category);
        return view('admin.blog.categories.edit', compact('category', 'categories', 'category_tree_view'));
    }

    public function category_data($id)
    {
        return BlogCategory::find($id);
    }

    public function make_category_tree_array()
    {
        $categories = BlogCategory::where("status", 1)
            ->where('parent_id', 0)
            ->get();

        $all_category = [];

        foreach ($categories as $key => $item) {
            $module = $item->name . '_' . $item->id;
            if (BlogCategory::where('parent_id', $item->id)->where('status', 1)->exists()) {
                $children = BlogCategory::where('parent_id', $item->id)->where("status", 1)->get();
                $temp_category = [];
                $temp_category['id'] = $item->id;
                $temp_category['name'] = $item->name;
                $temp_category['parent'] = null;
                $temp_category['child'] = $this->buildCategories($children, $item->id);
                $all_category[] = $temp_category;
            } else {
                $temp_category['id'] = $item->id;
                $temp_category['name'] = $item->name;
                $temp_category['parent'] = null;
                $temp_category['child'] = [];
                $all_category[] = $temp_category;
            }
        }

        return $all_category;
    }
    public function make_category_tree($categories, $default_category)
    {
        return view('admin.blog.categories.category_tree_view', compact('categories', 'default_category'))->render();
    }

    public function store_category(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'url' => ['required', 'unique:blog_categories', 'min:3'],
            // 'description' => ['required'],
            // 'parent_id' => ['required'],
            // 'template_layout_file' => ['required'],
            // 'sort_order' => ['required'],
            // 'default_product_sort' => ['required'],
            // 'category_image' => ['required'],
            // 'page_title' => ['required'],
            // 'meta_keywords' => ['required'],
            // 'meta_description' => ['required'],
            // 'search_keywords' => ['required'],
        ], [
            // 'url.min' => ['url is not valid'],
        ]);


        $category = BlogCategory::create($request->except('category_image'));
        $category->creator = Auth::user()->id;
        $category->save();
        $category->slug = $category->id . rand(1111, 9999) . Str::slug($request->name);
        $category->save();

        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $path = Storage::put('/uploads/category_image', $file);
            $category->category_image = $path;
            $category->save();
        }

        $categories = $this->make_category_tree_array();
        $category_tree_view = $this->make_category_tree($categories, []);

        return response()->json([
            'categories' => $categories,
            'category_tree_view' => $category_tree_view,
        ]);
    }

    public function store_category_from_blog_create(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
        ]);
        $category = new BlogCategory();
        $category->name = $request->name;
        $category->parent_id = $request->parent;
        $category->creator = Auth::user()->id;
        $category->save();
        $category->slug = $category->id . uniqid(5);
        $category->url = Str::slug($request->name) . $category->id . rand(1111, 9999);
        $category->save();

        return $category;
    }

    public function update_category(Request $request)
    {
        $this->validate($request, [
            'name' => ['required'],
            'url' => ['required', 'min:3'],
            // 'description' => ['required'],
            // 'parent_id' => ['required'],
            // 'template_layout_file' => ['required'],
            // 'sort_order' => ['required'],
            // 'default_product_sort' => ['required'],
            // 'category_image' => ['required'],
            // 'page_title' => ['required'],
            // 'meta_keywords' => ['required'],
            // 'meta_description' => ['required'],
            // 'search_keywords' => ['required'],
        ], [
            // 'url.min' => ['url is not valid'],
        ]);

        // return dd($request->all());
        $category = BlogCategory::find($request->id);
        $category->fill($request->except('category_image'));
        $category->creator = Auth::user()->id;
        $category->save();

        if ($request->hasFile('category_image')) {
            $file = $request->file('category_image');
            $path = Storage::put('/uploads/category_image', $file);
            $category->category_image = $path;
            $category->save();
        }

        $categories = $this->make_category_tree_array();
        $category_tree_view = $this->make_category_tree($categories, $category);

        return response()->json([
            'categories' => $categories,
            'category_tree_view' => $category_tree_view,
        ]);
    }

    public function rearenge_category(Request $request)
    {
        if (!$request->parent_id) {
            $parent_id = 0;
        } else {
            $parent_id = $request->parent_id;
        }
        BlogCategory::where('id', $request->id)->update([
            'parent_id' => $parent_id,
        ]);
        return $request->all();
    }

    public function categorie_url_check(Request $request)
    {
        if (BlogCategory::where('url', $request->url)->exists()) {
            if ($request->has('id') && BlogCategory::where('url', $request->url)->where('id', $request->id)->exists()) {
                return response()->json(false);
            } elseif ($request->has('id') && BlogCategory::where('url', $request->url)->exists()) {
                return response()->json(true . '2nd');
            } else {
                return response()->json(false);
            }
        }
    }
}
