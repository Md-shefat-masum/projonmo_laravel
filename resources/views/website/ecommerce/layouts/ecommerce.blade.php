<!DOCTYPE html>
<html lang="en">

<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="/ficon.png" sizes="32x32" />
    <link rel="icon" href="/ficon.png" sizes="192x192" />
    <link rel="apple-touch-icon" href="/ficon.png" />

    <meta charset="UTF-8">
    <meta name="robots" content="index, follow">

    {{-- <meta http-equiv="cache-control" content="no-cache"> --}}
    {{-- <meta http-equiv="expires" content="5000000"> --}}
    <!-- <meta http-equiv="refresh" content="5"> -->

    <meta name="Classification" content="Religion">
    <meta name="identifier-URL" content="http://upokul.net">
    <meta name="directory" content="submission">
    <meta name="category" content="Internet">
    <meta name="coverage" content="Worldwide">
    <meta name="distribution" content="Global">
    <meta name="rating" content="General">
    <meta name="target" content="all">
    <meta name="HandheldFriendly" content="True">
    <meta name="author" content="prossod prokashon">
    <meta name="developer" content="shefat ullah masum">
    <meta name="developer-email" content="mshefat924@gmail.com">
    <meta name="developer-company" content="hungrycoder">
    <meta name="copyright" content="https://prossodprokashon.com">
    <meta name="revisit" content="1 days">

    @section('meta')
        <title>Prossod Prokashon</title>
        <meta name="keywords" content="Prossod Publication, book publication, book shop, islamic books, ecommerce">
        <meta name="description" content="মননে ঐতিহ্যিক, প্রকাশে নতুনত্ব"  > 

        <meta property="og:title" content="prossod prokashon" />
        <meta property="og:site_name" content="prossod prokashon" />
        <meta property="og:description" content="মননে ঐতিহ্যিক, প্রকাশে নতুনত্ব" />
        <meta property="og:type" content="Ecommerce" />
        <meta property="og:url" content="https://prossodprokashon.com" />
        <meta property="og:image" content="https://prossodprokashon.com/logo.png" />
        <meta property="og:image:width" content="600" />
        <meta property="og:image:height" content="315" />

        <meta name="twitter:title" content="prossod prokashon">
        <meta name="twitter:description" content="মননে ঐতিহ্যিক, প্রকাশে নতুনত্ব">
        <meta name="twitter:image" content="https://prossodprokashon.com/logo.png">
        <meta name="twitter:card" content="summary_large_image">
    @endsection

    @yield('meta')

    <link rel="stylesheet" href="/contents/website/css/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/contents/website/css/fontawesome-free-5.15.3-web/css/all.min.css">
    @stack('css')

    <link rel="stylesheet" href="/contents/website/css/style.css">
    <link rel="stylesheet" href="/contents/website/css/responsive.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="https://cdn.jsdelivr.net/npm/pace-js@latest/pace.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/pace-js@latest/pace-theme-default.min.css">
    <script>
        Pace.start();
        Pace.options = {
            restartOnRequestAfter: true
        }
        const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });
        window.toaster = function toaster(icon, message){
            Toast.fire({
                icon: icon,
                title: message,
            })
        }
    </script>

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
</head>

<body>
    <div id="ecommerce">
        <header>
            <div class="container">
                <ul class="header_menu_list">
                    <li><a href="/">হোম</a></li>
                    <li><a href="{{ route('website_products') }}">সকল বই</a></li>
                    {{-- <li><a href="#">বুক কভার</a></li> --}}
                    {{-- <li><a href="#">লেখক</a></li> --}}
                    <li><a href="{{ route('website_writers') }}">লেখক / অনুবাদক</a></li>
                    <li><a href="{{ route('website_blogs') }}">নির্বাচিত প্রবন্ধ</a></li>
                    <li><a href="{{ route('website_poribeshok') }}">পরিবেশক</a></li>
                    <li>
                        <a href="#">পাঠক</a>
                        <ul>
                            <li><a href="{{ route('website_review') }}">রিভিউ</a></li>
                            <li><a href="{{ route('website_photograph') }}">ফটোগ্রাফি</a></li>
                            <li><a href="{{ route('website_contact') }}">মতামত</a></li>
                        </ul>
                    </li>
                    <li><a href="{{ route('website_videograph') }}">ভিডিও</a></li>
                    <li><a href="#">বিবিধ</a></li>
                </ul>
            </div>
        </header>

        <nav>
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="side_nav" id="side_nav">
                            <div class="overlay"></div>
                            <div class="side_nav_body">
                                {{-- <form action="#">
                                    <input placeholder="search" type="text">
                                    <button><i class="fas fa-search"></i></button>
                                </form> --}}
                                <ul>
                                    <li>
                                        <a href="/">হোম</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('website_products') }}">সকল বই</a>
                                    </li>
                                    {{-- <li>
                                        <a href="#">প্যাকেজ</a>
                                    </li> --}}
                                    <li>
                                        <a href="{{ route('website_offers') }}">অফার</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('website_blogs') }}">প্রবন্ধ</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="left">
                            <i class="fas fa-align-left triger_btn"></i>
                            {{-- <ul>
                                <li>
                                    <a href="#">সকল বই</a>
                                    <a href="#">প্যাকেজ</a>
                                </li>
                            </ul> --}}
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-5">
                        <div class="mid">
                            <a href="/">
                                <img src="/logo.png"  alt="logo">
                            </a>
                            <p>মননে ঐতিহ্যিক, প্রকাশে নতুনত্ব</p>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-7">
                        <div class="right">
                            <ul>
                                <li>
                                    <a href="#cartList" data-bs-toggle="offcanvas" data-bs-target="#cartList" aria-controls="cartList">
                                        <span>ক্রয় তালিকা @{{ get_carts.length }} / ৳ @{{ get_sub_total }}</span>
                                        <i class="fas fa-shopping-cart"></i>
                                    </a>
                                </li>
                                {{-- @auth
                                    <li><a href="{{ route('admin_index') }}">Profile</a></li>
                                @endauth
                                @guest
                                    <li><a href="/login">Login</a></li>
                                @endguest --}}
                                <li>
                                    <div href="#" class="search_btn">
                                        <i class="fas fa-search" v-if="!show_search" @click.prevent="show_search=!show_search"></i>
                                        <i class="fas fa-search-minus" v-else @click.prevent="show_search=!show_search"></i>

                                        <div class="search_body" v-if="show_search">
                                            <input type="text" @keyup="live_search($event.target.value)" placeholder="search..">
                                            <ul>
                                                <li v-for="item in search_products">
                                                    <a :href="`/product-details/${item.id}`">
                                                        <img :src="`/${item.thumb_image}`" alt="">
                                                        <h5>@{{ item.name }}</h5>
                                                    </a>
                                                </li>
                                            </ul>
                                            <ul>
                                                <li v-for="item in search_writers">
                                                    <a :href="`/writer-books/${item.slug}`">
                                                        <img v-if="item.image" :src="`/${item.image}`" alt="">
                                                        <img v-else :src="`/avatar.png`" alt="">
                                                        <h5>@{{ item.name }}</h5>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="cartList" aria-labelledby="cartListLabel">
            <div class="offcanvas-header">
                <h5 id="cartListLabel">ক্রয় তালিকা</h5>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="mini_cart carts_design">
                    <div id="mini_cart">
                        <div class="cart_item" v-for="item in get_carts" :key="item.id">
                            <div class="cart_img">
                                <a href="#">
                                    <img class="img-fluid" :src="`/${item.product.thumb_image}`" alt="product" />
                                </a>
                            </div>
                            <div class="cart_info">
                                <a :href="`/product-details/${item.id}`">@{{ item.name }}</a>
                                <p>Qty: @{{ item.qty }} X <span> ৳ @{{item.discount_price?item.discount_price:item.price}} </span></p>
                            </div>
                            <div class="cart_remove">
                                <a href="#" @click.prevent="remove_from_carts(item)"><i class="btn-close"></i></a>
                            </div>
                        </div>
                        <div class="mini_cart_table">
                            <div class="cart_total"><span>Sub total:</span> <span class="price">৳ @{{get_sub_total}}</span></div>
                            {{-- <div class="cart_total mt-10"><span>total:</span> <span class="price">$ 243</span></div> --}}
                        </div>
                    </div>
                    <div class="mini_cart_footer">
                        <div class="cart_button">
                            <a href="/cart">ক্রয় তালিকা দেখুন</a>
                        </div>
                        <div class="cart_button">
                            <a class="active" href="/checkout">এখনই কিনুন</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <main>
            @yield('content')
        </main>

        <footer>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8">
                        <h3>যোগাযোগ</h3> <br>
                        <a href="/" class="footer_logo">
                            <img style="background: white;" src="/logo.png" alt="logo">
                        </a>
                        <ul>
                            <li>
                                <span>বিক্রয়কেন্দ্র :</span>
                                 মাদরাসা মার্কেট (২য় তলা), ৩৪, নর্থব্রুক হল রোড, বাংলাবাজার, ঢাকা-১১০০
                            </li>
                            <li>
                                <span>মোবাইল :</span>  +880 1781172026
                            </li>
                            <li>
                                <span>ইমেইল :</span> prossodprokashon@gmail.com
                            </li>
                            <li>
                                <span>ফেসবুক :</span> <a style="color:#ffca0a;" href="https://www.facebook.com/prossodprokashon/" target="_blank">prossodprokashon</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 d-none">
                        <h3>প্রবন্ধ</h3>
                        <ul class="mid_part">
                            @php
                                $blogs = App\Models\Blog::where('status',1)
                                                ->select('id','title','url','image','created_at','short_description')
                                                ->take(4)->orderBy('id','DESC')->get();
                            @endphp
                            @foreach ( $blogs as $item)
                                <li >
                                    <div class="left">
                                        <img src="/{{ $item->image }}" alt="">
                                        <span class="date">
                                            <span>{{ $item->created_at->format('d') }}</span>
                                            <span>{{ $item->created_at->format('M') }}</span>
                                        </span>
                                    </div>
                                    <a href="{{ route('website_blog_details',str_replace('/','',$item->url)) }}">
                                        {{ $item->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <h3>সাবস্ক্রাইব করুন</h3>
                        <ul class="right">
                            <li>
                                প্রচ্ছদ প্রকাশনের সকল খবরাখবর ইমেইলের মাধ্যমে আপডেট পেতে সাবস্ক্রাইব করুন
                            </li>
                            <li>
                                <form action="#" id="subscription_form">
                                    @csrf
                                    <div>
                                        <input type="text" name="email" placeholder="Your Email (required) ">
                                    </div>
                                    <button @click.prevent="store_subscriber()" class="custom_btn2">Sign Up</button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>

        <section class="lower_footer">
            <div class="container">
                <ul class="top_ul">
                    <li><a href="{{ route('website_poribeshok') }}">পরিবেশক</a></li>
                    <li><a href="{{ route('website_products') }}">সকল বই</a></li>
                    <li><a href="#subscription_form">SMS SUBSCRIPTION</a></li>
                </ul>
                <div class="row">
                    <div class="col-md-6">
                        <p>
                            Copyright 2021 © <span>PROSSOD PROKASHON</span>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <p>
                            Website Design & Developed by <span>Md Shefat ( Team Hungry Coders )</span>
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </div>


    <script src="/contents/website/js/bootstrap/bootstrap.min.js"></script>
    <script src="/js/app.js"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/vue@2.6.8/dist/vue.js"></script> -->
    @stack('js_plugin')
    <script>
        axios.interceptors.request.use(function (config) {
            // Do something before request is sent
            Pace.restart();
            return config;
        }, function (error) {
            // Do something with request error
            return Promise.reject(error);
        });
    </script>
    <script type="module" src="/contents/website/js/custom.js"></script>

    @stack('cjs')

</body>

</html>
