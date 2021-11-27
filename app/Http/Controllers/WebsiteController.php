<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogComment;
use App\Models\Category;
use App\Models\Color;
use App\Models\ContactMessage;
use App\Models\MainCategory;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\Size;
use App\Models\SubCategory;
use App\Models\Subscriber;
use App\Models\User;
use App\Models\Writer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class WebsiteController extends Controller
{
    public $size;
    public $color;
    public $main_category_id;
    public $category_id;
    public $sub_category_id;

    public function auth_login(Request $request)
    {
        $this->validate($request,[
            'email' => ['required','exists:users,email'],
            'password' => ['required'],
        ]);
        Auth::attempt(['email' => $request->email, 'password' => $request->password]);
        return Auth::user();
    }

    public function user_registration(Request $request)
    {
        $this->validate($request,[
            'email' => ['required','unique:users'],
            'first_name' => ['required'],
            'last_name' => ['required'],
            'phone' => ['required','unique:users'],
            'password' => ['required','confirmed','min:8'],
        ]);

        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->first_name.' '.$request->last_name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();

        Auth::attempt(['email' => $user->email, 'password' => $request->password]);

        return Auth::user();
    }

    public function index()
    {
        return view('website.ecommerce.index');
    }

    public function products()
    {
        return view('website.ecommerce.products');
    }

    public function writer_books($slug)
    {
        $writer = Writer::where('slug',$slug)->first();
        return view('website.ecommerce.writer_products',compact('writer'));
    }

    public function offers()
    {
        return view('website.ecommerce.offers');
    }

    public function writers()
    {
        return view('website.ecommerce.writers');
    }

    public function blogs()
    {
        return view('website.blog.blog_list');
    }

    public function get_blogs_json()
    {
        $blog = Blog::where('status',1)
                    ->orderBy('id','DESC')
                    ->select(['id','title','slug','url','image','created_at','short_description'])
                    ->with([
                        'categories' => function ($query) {
                            $query->select([
                                'blog_categories.id',
                                'name'
                            ]);
                        }
                    ])
                    ->paginate(6);
        return  $blog;
    }

    public function blog_details($url)
    {
        $blog = Blog::where('url','/'.$url)
                    ->where('status',1)
                    ->with([
                        'categories' => function ($query) {
                            $query->select([
                                'blog_categories.id',
                                'name'
                            ]);
                        }
                    ])
                    ->first();
        return view('website.blog.blog_read',compact('blog'));
    }

    public function store_blog_comment(Request $request)
    {
        $this->validate($request,[
            'description' => ['required', 'min:10'],
            'email' => ['required'],
            'name' => ['required'],
        ]);

        $comment = BlogComment::create($request->all());
        return response($comment,200);
    }

    public function main_category_products($main_category)
    {
        return view('website.ecommerce.products');
    }

    public function category_products($main_category)
    {
        return view('website.ecommerce.products');
    }

    public function sub_category_products($main_category)
    {
        return view('website.ecommerce.products');
    }

    public function store_subscriber(Request $request)
    {
        $this->validate($request, [
            'email' => ['required','unique:subscribers'],
        ]);

        Subscriber::create($request->all());
        return response()->json('success',200);
    }

    public function get_comments($id)
    {
        return ProductComment::where('product_id',$id)->where('status',1)->orderBy('id','DESC')->paginate(10);
    }
    public function store_comment(Request $request)
    {
        $this->validate($request,[
            'ratting' => ['required','min:1','max:5'],
            'comment' => ['required','min:5'],
        ]);

        $comment = ProductComment::create($request->all());
        $comment->user_id = Auth::user()->id;
        $comment->user_name = Auth::user()->username;
        $comment->user_email = Auth::user()->email;
        $comment->save();
        return $comment;
    }

    public function main_category_products_json(Request $request, $main_category)
    {
        $main_category = MainCategory::where('id', $main_category)->first();

        if ($main_category) {
            $this->main_category_id = $main_category->id;
            if ($request->has('range')) {
                $range = str_replace('$', '', $request->range);
                $range = explode('-', $range);
                $min = (int) $range[0];
                $max = (int) $range[1];
                $products = $main_category->related_products()->whereBetween('price', [$min, $max])->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->orderBy('price', 'DESC')->paginate(16);
            } else if ($request->has('size')) {
                $this->size = (int) $request->size;
                $products = $main_category->related_products()->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('product_size')
                        ->whereRaw('product_size.product_id = products.id')
                        ->where('product_size.size_id', $this->size);
                })->orderBy('id', 'DESC')->paginate(16);
            } else if ($request->has('color')) {
                $this->color = (int) $request->color;
                $products = $main_category->related_products()->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('color_product')
                        ->whereRaw('color_product.product_id = products.id')
                        ->where('color_product.color_id', $this->color);
                })->orderBy('id', 'DESC')->paginate(16);
            } else {
                $products = $main_category->related_products()->with([
                    'category',
                    'sub_category',
                    'main_category',
                    // 'color',
                    'image',
                    'publication',
                    // 'size',
                    // 'unit',
                    // 'writer',
                ])->orderBy('id', 'DESC')->paginate(16);

                return response()->json([
                    'products' => $products,
                ]);
            }
        } else {
            return [];
        }
    }

    public function category_products_json(Request $request, $main_category, $category)
    {
        $main_category = MainCategory::where('slug', $main_category)->first();
        $category = Category::where('slug', $category)->first();
        // dd($category->related_products()->get());


        if ($category) {
            $this->category_id = $category->id;

            if ($request->has('range')) {
                $range = str_replace('$', '', $request->range);
                $range = explode('-', $range);
                $min = (int) $range[0];
                $max = (int) $range[1];
                $products = $category->related_products()->whereBetween('price', [$min, $max])->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->orderBy('price', 'DESC')->paginate(16);
            } else if ($request->has('size')) {
                $this->size = (int) $request->size;
                $products = $category->related_products()->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('product_size')
                        ->whereRaw('product_size.product_id = products.id')
                        ->where('product_size.size_id', $this->size);
                })->orderBy('id', 'DESC')->paginate(16);
            } else if ($request->has('color')) {
                $this->color = (int) $request->color;
                $products = $category->related_products()->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('color_product')
                        ->whereRaw('color_product.product_id = products.id')
                        ->where('color_product.color_id', $this->color);
                })->orderBy('id', 'DESC')->paginate(16);
            } else {
                $products = $category->related_products()->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->orderBy('id', 'DESC')->paginate(16);

                $sizes = Size::where('status', 1)->select(['name', 'id'])->get();
                foreach ($sizes as $key => $item) {
                    $count = $item->related_products()->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('category_product')
                            ->whereRaw('category_product.product_id = products.id')
                            ->where('category_product.category_id', $this->category_id);
                    })->count();
                    $item->product_amount = $count;
                }

                $colors = Color::where('status', 1)->select(['name', 'id'])->get();
                foreach ($colors as $key => $item) {
                    $count = $item->related_products()->whereExists(function ($query) {
                        $query->select(DB::raw(1))
                            ->from('category_product')
                            ->whereRaw('category_product.product_id = products.id')
                            ->where('category_product.category_id', $this->category_id);
                    })->count();
                    $item->product_amount = $count;
                }

                return response()->json([
                    'products' => $products,
                    'sizes' => $sizes,
                    'colors' => $colors,
                ]);
            }

            return $products;
        } else {
            return [];
        }
    }

    public function sub_category_products_json(Request $request, $main_category, $category, $sub_category)
    {
        $main_category = MainCategory::where('slug', $main_category)->first();
        $category = Category::where('slug', $category)->first();
        $sub_category = SubCategory::where('slug', $sub_category)->first();
        // dd($category->related_products()->get());
        if ($sub_category) {
            if ($request->has('range')) {
                $range = str_replace('$', '', $request->range);
                $range = explode('-', $range);
                $min = (int) $range[0];
                $max = (int) $range[1];
                $products = $sub_category->related_products()->whereBetween('price', [$min, $max])->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->orderBy('price', 'DESC')->paginate(16);
            } else if ($request->has('size')) {
                $this->size = (int) $request->size;
                $products = $main_category->related_products()->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->whereExists(function ($query) {
                    $query->select(DB::raw(1))
                        ->from('product_size')
                        ->whereRaw('product_size.product_id = products.id')
                        ->where('product_size.size_id', $this->size);
                })->orderBy('id', 'DESC')->paginate(16);
            } else {
                $products = $sub_category->related_products()->with([
                    'category',
                    'sub_category',
                    'main_category',
                    'color',
                    'image',
                    'publication',
                    'size',
                    'unit',
                    'writer',
                ])->orderBy('id', 'DESC')->paginate(16);
            }
            return $products;
        } else {
            return (object)[];
        }
    }

    public function latest_product_json($paginate)
    {
        $collection = Product::active()
            ->with([
                'category',
                'sub_category',
                'main_category',
                'color',
                'image',
                'publication',
                'size',
                'unit',
                'vendor',
                'writer',
            ])
            ->orderBy('id', 'DESC')->paginate($paginate);
        return $collection;
    }

    public function wanted_product_json($paginate)
    {
        $collection = Product::active()
            ->with([
                'category',
                'sub_category',
                'main_category',
                'color',
                'image',
                'publication',
                'size',
                'unit',
                'vendor',
                'writer',
            ])
            // ->orderBy('id', 'DESC')
            ->orderBy(DB::raw('RAND()'))
            ->paginate($paginate);
        return $collection;
    }

    public function latest_deals_product_json(Request $request)
    {
        $today_date = Carbon::now()->format('Y-m-d');
        $collection = Product::active()
            ->where('expiration_date', '>=', $today_date)
            ->with([
                'category',
                'sub_category',
                'main_category',
                'color',
                'image',
                'publication',
                'size',
                'unit',
                'vendor',
                'writer',
            ])
            ->orderBy('id', 'DESC')->paginate(1);
        return $collection;
    }

    public function category_product_json(MainCategory $main_category_id, $category_id)
    {
        if ($category_id == 'unset') {
            $collection = $main_category_id->related_products()->with([
                'category',
                'sub_category',
                'main_category',
                'color',
                'image',
                'publication',
                'size',
                'unit',
                'vendor',
                'writer',
            ])
                ->orderBy('id', 'DESC')->paginate(8);
        } else {
            $category = Category::find($category_id);
            $collection = $category->related_products()->with([
                'category',
                'sub_category',
                'main_category',
                'color',
                'image',
                'publication',
                'size',
                'unit',
                'vendor',
                'writer',
            ])
                ->orderBy('id', 'DESC')->paginate(8);
        }

        return response()->json([
            'collection' => $collection,
            'main_category' => $main_category_id
        ]);
    }

    public function show_product_json(Product $product)
    {
        $product['discount_price'] = HelperController::discount_price($product->price, $product->discount, $product->expiration_date);
        $product['image'] = $product->image()->get();
        $product['category'] = $product->category()->get();
        $product['sub_category'] = $product->sub_category()->get();
        $product['main_category'] = $product->main_category()->get();
        $product['color'] = $product->color()->get();
        $product['publication'] = $product->publication()->get();
        $product['size'] = $product->size()->get();
        $product['unit'] = $product->unit()->get();
        $product['vendor'] = $product->vendor()->get();
        $product['writer'] = $product->writer()->get();

        // echo $product->discount_price;
        return $product;
    }

    public function get_all_category_json()
    {
        $category = MainCategory::where('status', 1)->with('related_categories')->withCount('related_products')->get();
        return $category;
    }

    public function get_all_size_json()
    {
        $sizes = Size::where('status', 1)->withCount('related_products')->get();
        return $sizes;
    }

    public function get_all_color_json()
    {
        $colors = Color::where('status', 1)->withCount('related_products')->get();
        return $colors;
    }

    public function get_product_related_info_json($product)
    {
        $product = Product::where('id', $product)->select('id', 'price', 'discount', 'expiration_date')->first();
        $product['discount_price'] = HelperController::discount_price($product->price, $product->discount, $product->expiration_date);

        return $product;
    }

    public function details(Product $product)
    {
        $product['discount_price'] = HelperController::discount_price($product->price, $product->discount, $product->expiration_date);
        $product['image'] = $product->image()->get();
        $product['category'] = $product->category()->get();
        $product['sub_category'] = $product->sub_category()->get();
        $product['main_category'] = $product->main_category()->get();
        $product['color'] = $product->color()->get();
        $product['publication'] = $product->publication()->get();
        $product['size'] = $product->size()->get();
        $product['unit'] = $product->unit()->get();
        $product['vendor'] = $product->vendor()->get();
        $product['writer'] = $product->writer()->get();
        // dd($product->toArray());

        return view('website.ecommerce.product_details', compact('product'));
    }

    public function search_product(Request $request)
    {
        $key = $request->key;
        $products = Product::where('name', $key)
            ->orWhere('price', $key)
            ->orWhere('name', 'LIKE', '%' . $key . '%')
            ->orWhere('price', 'LIKE', '%' . $key . '%')
            ->get();
        return $products;
    }

    public function get_min_max_price_json()
    {
        $max_price = Product::orderBy('price', 'DESC')->first();
        $min_price = Product::orderBy('price', 'ASC')->first();
        return response()->json([
            'max_price' => $max_price->price,
            'min_price' => $min_price->price,
        ]);
    }

    public function get_comment_list($product_id)
    {
        $comments = ProductComment::where('product_id', $product_id)->with('user_info')->latest()->get();
        return $comments;
    }

    public function submit_comment(Request $request)
    {
        $this->validate($request, [
            'comment' => ['required'],
        ]);

        $comment = new ProductComment();
        $comment->product_id = $request->product_id;
        $comment->ratting = $request->ratting;
        $comment->comment = $request->comment;
        $comment->user_id = Auth::user()->id;
        $comment->user_email = Auth::user()->email;
        $comment->user_name = Auth::user()->username;
        $comment->creator = Auth::user()->id;
        $comment->slug = uniqid(10) . time();
        $comment->created_at = Carbon::now()->toDateTimeString();
        $comment->save();

        $comment->user_info = $comment->user_info()->first();
        return $comment;
    }

    public function cart()
    {
        return view('website.ecommerce.cart');
    }

    public function checkout()
    {
        return view('website.ecommerce.checkout');
    }

    public function checkout_submit(Request $request)
    {
        $this->validate($request, [
            'full_name' => ['required'],
            'phone' => ['required'],
            // 'email' => ['required'],
            'delivery_method' => ['required'],
            'payment_method' => ['required'],
            'street_address' => ['required'],
            'district' => ['required'],
            'cart_product' => ['required', 'min:10'],
        ]);

        if ($request->payment_method != 'cash_on') {
            $this->validate($request, [
                'payment_method_number' => ['required'],
                'payment_method_transaction_id' => ['required'],
            ]);
        }

        $order = new Order();
        $order->full_name = $request->full_name;
        $order->phone = $request->phone;
        $order->email = $request->email;
        $order->billing_details = json_encode([
            'street_address' => $request->street_address,
            'district' => $request->district,
            'order_note' => $request->order_note,
        ]);
        $order->order_details = $request->cart_product;
        $order->subtotal = $request->get_sub_total;
        $order->total = $request->get_total;
        $order->payment_method = $request->payment_method;
        $order->delivery_method = $request->delivery_method;
        if ($request->payment_method != 'cash_on') {
            $order->payment_number = $request->payment_method_number;
            $order->payment_code = $request->payment_method_transaction_id;
        }
        $order->status = 2;
        $order->save();
        $order->slug = explode('@', $request->email)[0].$order->id.uniqid(4);
        $order->invoice_id = 'PR-'.(Carbon::now()->year).(Carbon::now()->month).$order->id.rand(10,99);
        $order->save();


        return $order;
    }

    public function print_invoice()
    {
        $order_id = request()->order;
        if ($order_id && Order::where('slug', $order_id)->exists()) {
            $order = Order::where('slug', $order_id)->first();
        }
        // dd($order);
        return view('website.ecommerce.invoice',compact('order'));
    }

    public function checkout_confirm()
    {
        \Stripe\Stripe::setApiKey('sk_test_51ImMYLL8CFL5l5Nj8ABACoXjon8HlNVSWRL2LiTNSCw2QBQeDusGYoskA0895tgPd8zVPwg2Y0jFxsZkYSjqCivj003dUkfPMc');
        header('Content-Type: application/json');
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $checkout_session = \Stripe\Checkout\Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => 2000,
                    'product_data' => [
                        'name' => 'Stubborn Attachments',
                        'images' => ["https://i.imgur.com/EHyR2nP.png"]
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => $YOUR_DOMAIN . '/checkout_success',
            'cancel_url' => $YOUR_DOMAIN . '/checkout',
        ]);
        echo json_encode(['id' => $checkout_session->id]);
    }

    public function checkout_success()
    {
        return view('website.ecommerce.invoice');
    }

    public function account()
    {
        return view('website.ecommerce.account');
    }

    public function wishlist()
    {
        return view('website.ecommerce.wishlist');
    }

    public function contact()
    {
        return view('website.ecommerce.contact');
    }

    public function review()
    {
        return view('website.ecommerce.review');
    }

    public function photograph()
    {
        return view('website.ecommerce.photograph');
    }
    public function photograph_details($id)
    {
        return view('website.ecommerce.photograph_details',compact('id'));
    }

    public function poribeshok()
    {
        return view('website.ecommerce.poribeshok');
    }

    public function videograph()
    {
        return view('website.ecommerce.videograph');
    }

    public function sumbit_contact(Request $request)
    {
        $this->validate($request,[
            'name' => ['required'],
            'email' => ['required'],
            'message' => ['required'],
            'subject' => ['required'],
        ]);

        ContactMessage::create($request->all());

        return 'success';

    }

    public function vue()
    {
        return view('learn-vue');
    }

    public function get_auth_information()
    {
        $check_auth = Auth::check();
        $auth_info = null;
        if ($check_auth) {
            $auth_info = Auth::user();
        }

        return response()->json([
            'check_auth' => $check_auth,
            'auth_info' => $auth_info,
        ]);
    }
}
