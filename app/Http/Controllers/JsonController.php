<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\MainCategory;
use App\Models\Product;
use App\Models\Writer;
use Carbon\Carbon;
use Illuminate\Http\Request;

class JsonController extends Controller
{
    public $skip = 0;
    public $take = 0;

    public function writer_products_json($slug)
    {
        $writer = Writer::where('slug', $slug)->first();
        // dd($writer->products()->paginate(10));
        $products = $writer->products()->where('status', 1)->paginate(10);
        return response($products);
    }

    public function product_search_json(Request $request)
    {
        $products = [];
        $writers = [];
        if ($request->key != '') {
            $products = Product::where('name', $request->key)
                ->orWhere('name', 'LIKE', '%' . $request->key . '%')
                ->orWhere('search_name', 'LIKE', '%' . $request->key . '%')
                ->where('status', 1)
                ->select([
                    'id',
                    'name',
                    'code',
                    'slug',
                    'thumb_image'
                ])
                ->get();

            $writers = Writer::where('name', $request->key)
                ->orWhere('name', 'LIKE', '%' . $request->key . '%')
                ->where('status', 1)
                ->select([
                    'id',
                    'name',
                    'slug',
                    'image'
                ])
                ->get();
        }

        return response()->json([
            'products' => $products,
            'writers' => $writers
        ]);
    }

    public function offer_products_json(Request $request)
    {
        $products = Product::where('expiration_date', '>=', Carbon::today())
            ->where('discount', '>', 0)
            ->where('status', 1)
            ->select([
                'id',
                'discount',
                'name',
                'thumb_image',
                'price'

            ])
            ->orderBy('id', 'DESC')
            ->paginate(10);

        return response()->json($products);
    }

    public function get_single_product_json($id)
    {
        $category_products = Product::where('status', 1)
            ->where('id', $id)
            ->select([
                'id',
                'name',
                'thumb_image',
                'price'
            ])->first();
        return response()->json($category_products);
    }

    public function get_product($chunk_size, $chunk_no)
    {
        $skip = $chunk_size * ($chunk_no - 1);
        $this->skip = $skip;
        $this->take = $chunk_size;

        $category_products = Product::where('status', 1)
            ->select([
                'products.id',
                'name',
                'thumb_image',
                'price',
                'discount'
            ])
            ->skip($this->skip)
            ->take($this->take)
            ->orderBy('id', 'DESC')
            ->get();

        $result = [
            'currentPage' => $chunk_no,
            'current_page' => $chunk_no,
            'data' => [],
            'first_page_url' => '',
            'from' => 1,
            'lastPage' => 0,
            'last_page_url' => '',
            'links' => '',
            'next_page_url' => '',
            'path' => '',
            'per_page' => '',
            'prev_page_url' => '',
            'to' => '',
            'total' => 0,
            'perPage' => $chunk_size,
            'nextPageUrl' => '',
            'prevPageUrl' => '',
        ];

        // dd($category_products->count());

        if ($category_products->count() > 0) {
            $chunks_count = Product::where('status', 1)->get()->chunk($chunk_size)->count();
            $route_name = 'get_product_json';

            if ($chunk_no <= $chunks_count && $chunk_no > 0) {
                $items = $category_products;
                $total = $chunks_count;
                $nextPageUrl = '';
                $prevPageUrl = '';
                $firstPageUrl = route($route_name, [
                    $chunk_size,
                    1,
                ]);
                $lastPageUrl = route($route_name, [
                    $chunk_size,
                    (int) $chunks_count,
                ]);
                $path = $firstPageUrl;

                // dd($chunks_count);

                if ($chunk_no < $total) {
                    $nextPageUrl = route($route_name, [
                        $chunk_size,
                        $chunk_no + 1,
                    ]);
                    $nextPageUrl .= '?page=' . ($chunk_no + 1);
                }

                if ($chunk_no > 1) {
                    $prevPageUrl = route($route_name, [
                        $chunk_size,
                        $chunk_no - 1,
                    ]);
                    $prevPageUrl .= '?page=' . ($chunk_no - 1);
                }

                $result = [
                    'currentPage' => (int) $chunk_no,
                    'current_page' => (int) $chunk_no,
                    'data' => $items->toArray(),
                    'first_page_url' => $firstPageUrl,
                    'from' => $this->skip,
                    'lastPage' => (int) $chunks_count,
                    'last_page' => (int) $chunks_count,
                    'last_page_url' => $lastPageUrl,
                    'links' => '',
                    'next_page_url' => $nextPageUrl,
                    'path' => $path,
                    'per_page' => (int) $chunk_size,
                    'prev_page_url' => $prevPageUrl,
                    'to' => (int) $this->skip + (int) $chunk_size,
                    'total' => $chunks_count * $chunk_size,
                    'perPage' => (int) $chunk_size,
                    'nextPageUrl' => $nextPageUrl,
                    'prevPageUrl' => $prevPageUrl,
                ];
            }
        }

        return response()->json((object)$result);
        // dd($result, $this->skip, $this->take);
    }

    public function get_main_category_product($category_id, $chunk_size, $chunk_no)
    {

        $category = MainCategory::where('id', $category_id)->first();

        $skip = $chunk_size * ($chunk_no - 1);
        $this->skip = $skip;
        $this->take = $chunk_size;

        // dd($chunk_size, $chunk_no,['skip'=>$skip] , $category->products()->get()->chunk($chunk_size)->count());

        $category_products = MainCategory::where('id', $category_id)
            ->with([
                // 'products:id,product_name,default_price,selected_categories',
                'products' => function ($query) {
                    $query->select([
                        'products.id',
                        'name',
                        'thumb_image',
                        'price'
                    ])
                        ->skip($this->skip)
                        ->take($this->take)
                        ->orderBy('id', 'DESC')
                        ->get();
                }
            ])
            ->first();

        $result = [
            'currentPage' => $chunk_no,
            'current_page' => $chunk_no,
            'data' => [],
            'first_page_url' => '',
            'from' => 1,
            'lastPage' => 0,
            'last_page_url' => '',
            'links' => '',
            'next_page_url' => '',
            'path' => '',
            'per_page' => '',
            'prev_page_url' => '',
            'to' => '',
            'total' => 0,
            'perPage' => $chunk_size,
            'nextPageUrl' => '',
            'prevPageUrl' => '',
        ];

        if ($category_products) {
            $chunks_count = $category->products->chunk($chunk_size)->count();
            $route_name = 'get_main_category_product_json';
            if ($chunk_no <= $chunks_count && $chunk_no > 0) {
                $items = $category_products->products;
                $total = $chunks_count;
                $nextPageUrl = '';
                $prevPageUrl = '';
                $firstPageUrl = route($route_name, [
                    $category_id,
                    $chunk_size,
                    1,
                ]);
                $lastPageUrl = route($route_name, [
                    $category_id,
                    $chunk_size,
                    (int) $chunks_count,
                ]);
                $path = $firstPageUrl;

                if ($chunk_no < $total) {
                    $nextPageUrl = route($route_name, [
                        $category_id,
                        $chunk_size,
                        $chunk_no + 1,
                    ]);
                    $nextPageUrl .= '?page=' . ($chunk_no + 1);
                }

                if ($chunk_no > 1) {
                    $prevPageUrl = route($route_name, [
                        $category_id,
                        $chunk_size,
                        $chunk_no - 1,
                    ]);
                    $prevPageUrl .= '?page=' . ($chunk_no - 1);
                }

                $result = [
                    'currentPage' => (int) $chunk_no,
                    'current_page' => (int) $chunk_no,
                    'data' => $items->toArray(),
                    'first_page_url' => $firstPageUrl,
                    'from' => $this->skip,
                    'lastPage' => (int) $chunks_count,
                    'last_page' => (int) $chunks_count,
                    'last_page_url' => $lastPageUrl,
                    'links' => '',
                    'next_page_url' => $nextPageUrl,
                    'path' => $path,
                    'per_page' => (int) $chunk_size,
                    'prev_page_url' => $prevPageUrl,
                    'to' => (int) $this->skip + (int) $chunk_size,
                    'total' => $chunks_count * $chunk_size,
                    'perPage' => (int) $chunk_size,
                    'nextPageUrl' => $nextPageUrl,
                    'prevPageUrl' => $prevPageUrl,
                ];
            }
        }
        return response()->json((object)$result);
        dd($result, $this->skip, $this->take);
    }

    public function get_category_product($category_id, $chunk_size, $chunk_no)
    {

        $category = Category::where('id', $category_id)->first();

        $skip = $chunk_size * ($chunk_no - 1);
        $this->skip = $skip;
        $this->take = $chunk_size;

        // dd($chunk_size, $chunk_no,['skip'=>$skip] , $category->products()->get()->chunk($chunk_size)->count());

        $category_products = Category::where('id', $category_id)
            ->with([
                // 'products:id,product_name,default_price,selected_categories',
                'products' => function ($query) {
                    $query->select([
                        'products.id',
                        'name',
                        'thumb_image',
                        'price',
                    ])
                        ->skip($this->skip)
                        ->take($this->take)
                        ->orderBy('id', 'DESC')
                        ->get();
                }
            ])
            ->first();

        $result = [
            'currentPage' => $chunk_no,
            'current_page' => $chunk_no,
            'data' => [],
            'first_page_url' => '',
            'from' => 1,
            'lastPage' => 0,
            'last_page_url' => '',
            'links' => '',
            'next_page_url' => '',
            'path' => '',
            'per_page' => '',
            'prev_page_url' => '',
            'to' => '',
            'total' => 0,
            'perPage' => $chunk_size,
            'nextPageUrl' => '',
            'prevPageUrl' => '',
        ];

        if ($category_products) {
            $chunks_count = $category->products->chunk($chunk_size)->count();
            $route_name = 'get_category_product_json';

            if ($chunk_no <= $chunks_count && $chunk_no > 0) {
                $items = $category_products->products;
                $total = $chunks_count;
                $nextPageUrl = '';
                $prevPageUrl = '';
                $firstPageUrl = route($route_name, [
                    $category_id,
                    $chunk_size,
                    1,
                ]);
                $lastPageUrl = route($route_name, [
                    $category_id,
                    $chunk_size,
                    (int) $chunks_count,
                ]);
                $path = $firstPageUrl;

                if ($chunk_no < $total) {
                    $nextPageUrl = route($route_name, [
                        $category_id,
                        $chunk_size,
                        $chunk_no + 1,
                    ]);
                    $nextPageUrl .= '?page=' . ($chunk_no + 1);
                }

                if ($chunk_no > 1) {
                    $prevPageUrl = route($route_name, [
                        $category_id,
                        $chunk_size,
                        $chunk_no - 1,
                    ]);
                    $prevPageUrl .= '?page=' . ($chunk_no - 1);
                }

                $result = [
                    'currentPage' => (int) $chunk_no,
                    'current_page' => (int) $chunk_no,
                    'data' => $items->toArray(),
                    'first_page_url' => $firstPageUrl,
                    'from' => $this->skip,
                    'lastPage' => (int) $chunks_count,
                    'last_page' => (int) $chunks_count,
                    'last_page_url' => $lastPageUrl,
                    'links' => '',
                    'next_page_url' => $nextPageUrl,
                    'path' => $path,
                    'per_page' => (int) $chunk_size,
                    'prev_page_url' => $prevPageUrl,
                    'to' => (int) $this->skip + (int) $chunk_size,
                    'total' => $chunks_count * $chunk_size,
                    'perPage' => (int) $chunk_size,
                    'nextPageUrl' => $nextPageUrl,
                    'prevPageUrl' => $prevPageUrl,
                ];
            }
        }
        return response()->json((object)$result);
        dd($result, $this->skip, $this->take);
    }

    public function make_chunk($data, $chunk_size, $chunk_no, $route_name, $extra_info)
    {
        $chunks = $data->chunk($chunk_size);
        $result = [
            'total' => 0,
            'lastPage' => 0,
            'data' => [],
            'perPage' => $chunk_size,
            'currentPage' => $chunk_no,
            'nextPageUrl' => '',
            'prevPageUrl' => '',
        ];

        if ($chunk_no <= count($chunks)) {
            $chunk_results = $data->chunk($chunk_size)[$chunk_no];
            $total = count($chunk_results);
            $id = $extra_info['url_id'];
            $nextPageUrl = '';
            $prevPageUrl = '';

            if ($chunk_no <= $total) {
                $nextPageUrl = route($route_name, [
                    $id,
                    $chunk_size,
                    $chunk_no + 1,
                ]);
            }

            if ($chunk_no > 0) {
                $nextPageUrl = route($route_name, [
                    $id,
                    $chunk_size,
                    $chunk_no - 1,
                ]);
            }

            $result = [
                'total' => $total,
                'lastPage' => count($chunk_results) - 1,
                'items' => $chunk_results,
                'perPage' => $chunk_size,
                'currentPage' => $chunk_no,
                'nextPageUrl' => $nextPageUrl,
                'prevPageUrl' => $prevPageUrl,
            ];
        }

        // return $result;
        dd([$data, $chunk_size, $chunk_no, $route_name, $result, Product::paginate(2)]);
    }
}
