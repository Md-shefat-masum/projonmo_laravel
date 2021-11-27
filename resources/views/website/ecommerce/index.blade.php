@extends('website.ecommerce.layouts.ecommerce')

@push('css')
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css">
@endpush
@push('js_plugin')
    <script src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
@endpush

@section('content')
        <section>
            <div class="container">
                <div class="banner">
                    @foreach (App\Models\Banner::get() as $item)
                        <div>
                            <img class="w-100" src="/{{ $item->icon }}" alt="" srcset="">
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="common-heading">
                            <h2>
                                <span>সর্বশেষ প্রকাশিত বই</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="latest_books" class="product_section">
            <div class="container">
                <div class="next_prev">
                    <pagination :data="latest_products" :show-disabled="true" :align="'right'" :limit="-1" @pagination-change-page="get_latest_products"></pagination>
                </div>
                <div class="row justify-content-center">
                    <div class="five_col" v-for="item in latest_products.data" :key="item.id">
                        <div class="product_body preloader">
                            <div class="top">
                                <span v-if="item.discount">-@{{item.discount}}%</span>
                                <a :href="`/product-details/${item.id}`">
                                    <img :src="`/${item.thumb_image}`" alt="image">
                                </a>
                            </div>
                            <div class="bottom">
                                <a :href="`/product-details/${item.id}`">
                                    <h4>@{{ item.name }}</h4>
                                </a>
                                <ul>
                                    <li v-if="item.discount_price"><del>৳ @{{item.price}}</del></li>
                                    <li v-if="item.discount_price">৳ @{{ item.discount_price }}</li>
                                    <li v-else>৳ @{{ item.price }}</li>
                                </ul>
                                <a href="#" @click.prevent="add_to_cart(item)" class="custom_btn1 flex_btn">এখনই কিনুন</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="common-heading">
                            <h2>
                                <span>সকল বই</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="wanted_product" class="product_section">
            <div class="container">
                <div class="next_prev">
                    <pagination :data="wanted_products" :show-disabled="true" :align="'right'" :limit="-1" @pagination-change-page="get_wanted_products"></pagination>
                </div>

                <div class="row justify-content-center">
                    <div class="five_col " v-for="item in wanted_products.data" :key="item.id">
                        <div class="product_body preloader">
                            <div class="top">
                                <span v-if="item.discount">-@{{item.discount}}%</span>
                                <a :href="`/product-details/${item.id}`">
                                    <img :src="`/${item.thumb_image}`" alt="image">
                                </a>
                            </div>
                            <div class="bottom">
                                <a :href="`/product-details/${item.id}`">
                                    <h4>@{{ item.name }}</h4>
                                </a>
                                <ul>
                                    <li v-if="item.discount_price"><del>৳ @{{item.price}}</del></li>
                                    <li v-if="item.discount_price">৳ @{{ item.discount_price }}</li>
                                    <li v-else>৳ @{{ item.price }}</li>
                                </ul>
                                <a href="#" @click.prevent="add_to_cart(item)" class="custom_btn1 flex_btn">এখনই কিনুন</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section>
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        <div class="common-heading">
                            <h2>
                                <span>নির্বাচিত প্রবন্ধ</span>
                            </h2>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="blog">
            <div class="container">
                <div class="row">
                    @php
                        $blogs = App\Models\Blog::where('status',1)
                                        ->select('id','title','url','image','created_at','short_description')
                                        ->take(4)->orderBy('id','DESC')->get();
                    @endphp
                    @foreach ( $blogs as $item)
                        <div class="col-md-4 col-lg-3">
                            <a href="{{ route('website_blog_details',str_replace('/','',$item->url)) }}">
                                <div class="blog_body">
                                    <div class="top">
                                        <span class="d-none">
                                            {{ $item->created_at->format('d') }} <br> {{ $item->created_at->format('M') }}
                                        </span>
                                        <img src="/{{ $item->image }}">
                                    </div>
                                    <div class="bottom">
                                        <h4 style="font-weight:bold;">{{ $item->title }}</h4>
                                        <p>
                                            {{ $item->short_description }}
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        </section>

        @push('cjs')
            <script>
                $(function(){

                    $('.banner').slick({
                        slidesToShow: 1,
                        autoplay: true,
                        dots: false,
                        arrows: false,
                        draggable: true,
                        loop: true,
                    });
                })
            </script>
        @endpush

@endsection
