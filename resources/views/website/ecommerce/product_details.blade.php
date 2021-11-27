@extends('website.ecommerce.layouts.ecommerce')
@section('meta')
    <title>{{ $product->name }}</title>
    <meta name="keywords" content="{{ $product->name }}, {{$product->search_name}},
    @foreach ($product->writer as $writer){{ $writer->name }}, &nbsp;@endforeach,
    @foreach ($product->publication as $publication) {{ $publication->name }}, &nbsp; @endforeach,
    @foreach ($product->category as $category) {{ $category->name }}, &nbsp; @endforeach,
    Prossod Publication, book publication, book shop, islamic books, ecommerce">
    <meta name="description" content="{!! substr(strip_tags($product->description),0,150) !!}">

    <meta property="og:title" content="{{ $product->name }}" />
    <meta property="og:site_name" content="prossod prokashon" />
    <meta property="og:description" content="{!! substr(strip_tags($product->description),0,150) !!}" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:image" content="{{ asset('/'.$product->thumb_image) }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />

    <meta name="twitter:title" content="{{ $product->name }}">
    <meta name="twitter:description" content="{!! substr(strip_tags($product->description),0,150) !!}">
    <meta name="twitter:image" content="{{ asset('/'.$product->thumb_image) }}">
    <meta name="twitter:card" content="summary_large_image">
    <style>
        .cspan{
            position: absolute;
            top: -5px;
            left: -5px;
            background: var(--brand);
            color: white;
            font-size: 14px;
            height: 40px;
            width: 40px;
            text-align: center;
            line-height: 40px;
            border-radius: 50%;
        }
    </style>
@endsection

@push('cjs')
    .product_review p{
        margin:0 !important;
    }
@endpush

@section('content')

        <section class="my-5" id="product_details_body">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <img src="https://upokul.net/look-inside.png" class="img-fluid"/>
                        <div class="product_image position-relative">
                            @if($product->discount)
                            <span class="cspan">
                                -{{$product->discount}}%
                            </span>
                            @endif
                            <img class="img-fluid"
                                src="{{ asset('/'.$product->thumb_image) }}" alt="image">
                        </div>
                    </div>

                    <div class="col-md-7">
                        <div class="product_info">
                            <h3>{{ $product->name }}</h3>
                            <span class="price">
                                @if ($product->discount)
                                    <del>৳ {{ $product->price }}</del>
                                    <span>৳ {{ $product->discount_price }}</span>
                                @else
                                    <span>৳ {{ $product->price }}</span>
                                @endif
                            </span>

                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td>Book Name</td>
                                        <td>&nbsp;{{ $product->name }}</td>
                                    </tr>
                                    <tr>
                                        <td>Page</td>
                                        <td>&nbsp; {{rand(200,500)}} </td>
                                    </tr>
                                    <tr>
                                        <td>Author</td>
                                        <td class="author-link">&nbsp;
                                            @foreach ($product->writer as $writer)
                                                <a href="{{ route('website_writer_books',$writer->slug) }}">{{ $writer->name }},</a> &nbsp;
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Translator</td>
                                        <td class="author-link">&nbsp;
                                            @foreach ($product->translator as $writer)
                                                {{ $writer->name }}, &nbsp;
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Binding</td>
                                        <td>&nbsp;হার্ড কভার</td>
                                    </tr>
                                    <tr>
                                        <td>Categories</td>
                                        <td>&nbsp;
                                            @foreach ($product->category as $category)
                                                {{ $category->name }}, &nbsp;
                                            @endforeach
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Product Code</td>
                                        <td>&nbsp; {{$product->code}} </td>
                                    </tr>


                                    {{-- <tr>
                                        <td>Editor</td>
                                        <td class="author-link">&nbsp;আহমদ মুসা</td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Publisher</td>
                                        <td class="publisher-link">&nbsp;
                                            @foreach ($product->publication as $publication)
                                                {{ $publication->name }}, &nbsp;
                                            @endforeach
                                        </td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>ISBN</td>
                                        <td>&nbsp;978-984-95187-9-2</td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Edition</td>
                                        <td>&nbsp;1st Published, 2021</td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Number of Pages</td>
                                        <td>&nbsp;176</td>
                                    </tr> --}}
                                    {{-- <tr>
                                        <td>Country</td>
                                        <td>&nbsp;বাংলাদেশ</td>
                                    </tr> --}}
                                    {{--  --}}
                                    {{-- <tr>
                                        <td>Weight</td>
                                        <td>&nbsp;0.00 KG</td>
                                    </tr> --}}
                                </tbody>
                            </table>

                            <form action="#" class="cart_form">
                                <input type="hidden" name="product_id" v-model="product_id" value="{{ $product->id }}">
                                <div class="cart_amount">
                                    <label for="cart_amt" @click="cart_qty--">-</label>
                                    <input value="1" v-model="cart_qty" type="number">
                                    <label for="cart_amt" @click="cart_qty++">+</label>
                                </div>
                                <button class="custom_btn2" @click.prevent="add_to_cart({{ $product }})">Buy Now</button>
                            </form>

                            <ul class="bottom_info">
                                {{--
                                    <li>
                                        <span>SKU: </span> #{{$product->code}}
                                    </li>

                                    <li>
                                        @php
                                            dd($product->category()->get());
                                        @endphp
                                    </li>
                                    @if ($product->category->count())
                                        <li>
                                            <span>Categories: </span>
                                            @foreach ($product->category as $category)
                                            {{ $category->name }}, &nbsp;
                                            @endforeach
                                        </li>
                                    @endif
                                    <li>
                                        <span>Author: </span>
                                        @foreach ($product->writer as $writer)
                                            {{ $writer->name }}, &nbsp;
                                        @endforeach
                                    </li>
                                --}}
                            </ul>

                            <ul class="social_links">
                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                <li><a href="#"><i class="fas fa-envelope"></i></a></li>
                                <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                            </ul>

                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="product_review">
            <div class="container" style="border-top: 1px solid silver;">
                <div class="row">
                    <div class="col-12">
                        <ul class="d-flex justify-content-center flex-wrap nav_btns mt-5">
                            <li><a href="#" :class="{ active : show_btn == 'description' }" @click.prevent="change_show_btn('description')" class="custom_btn2">Description</a></li>
                            <li><a href="#" :class="{ active : show_btn == 'review' }" @click.prevent="change_show_btn('review')" class="custom_btn2">Reviews</a></li>
                            <li><a href="#" :class="{ active : show_btn == 'how_to_buy' }" @click.prevent="change_show_btn('how_to_buy')" class="custom_btn2">কিভাবে কিনবেন?</a></li>
                        </ul>
                    </div>
                    <div class="col-12" v-if="show_btn == 'description'">
                        {!! $product->description !!}
                    </div>
                    <div class="col-12" v-if="show_btn == 'review'">
                        <div class="card mt-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-body user_rating">
                                        <span class="heading">User Rating</span>

                                        <span v-for="i in parseInt(product_info.reviews.total_review)" class="fas fa-star checked"></span>
                                        <span v-for="i in 5-parseInt(product_info.reviews.total_review)" class="far fa-star"></span>

                                        <p>@{{ product_info.reviews.total_review }} average based on @{{ product_info.reviews.total_count }} reviews.</p>
                                        <hr style="border: 3px solid #f1f1f1;" />

                                        <div class="row">
                                            <div class="side">
                                                <div>5 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                    <div :style="`width: ${product_info.reviews.five_star > 0 ? 100*product_info.reviews.five_star/product_info.reviews.total_count : 0}%;`" class="bar-5"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div> @{{ product_info.reviews.five_star }}</div>
                                            </div>
                                            <div class="side">
                                                <div>4 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                    <div :style="`width: ${product_info.reviews.four_star > 0 ? 100*product_info.reviews.four_star/product_info.reviews.total_count : 0}%;`" class="bar-4"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>@{{ product_info.reviews.four_star }}</div>
                                            </div>
                                            <div class="side">
                                                <div>3 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                    <div :style="`width: ${product_info.reviews.three_star > 0 ? 100*product_info.reviews.three_star/product_info.reviews.total_count : 0}%;`" class="bar-3"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>@{{ product_info.reviews.three_star }}</div>
                                            </div>
                                            <div class="side">
                                                <div>2 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                    <div :style="`width: ${product_info.reviews.two_star > 0 ? 100*product_info.reviews.two_star/product_info.reviews.total_count : 0}%;`" class="bar-2"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>@{{ product_info.reviews.two_star }}</div>
                                            </div>
                                            <div class="side">
                                                <div>1 star</div>
                                            </div>
                                            <div class="middle">
                                                <div class="bar-container">
                                                    <div :style="`width: ${product_info.reviews.one_star > 0 ? 100*product_info.reviews.one_star/product_info.reviews.total_count : 0}%;`" class="bar-1"></div>
                                                </div>
                                            </div>
                                            <div class="side right">
                                                <div>@{{ product_info.reviews.one_star }}</div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div v-if="auth_check" class="card-body comment_box">
                                        <div class="card-box">
                                            <div class="wrapper">
                                                <div class="master">
                                                    <h1>Add a review</h1>

                                                    <div class="rating-component">
                                                        <label for="review">Your Rating</label>
                                                        <div class="stars-box">
                                                            <i class="star fa fa-star" title="1 star" data-message="Poor" data-value="1"></i>
                                                            <i class="star fa fa-star" title="2 stars" data-message="Too bad" data-value="2"></i>
                                                            <i class="star fa fa-star" title="3 stars" data-message="Average quality" data-value="3"></i>
                                                            <i class="star fa fa-star" title="4 stars" data-message="Nice" data-value="4"></i>
                                                            <i class="star fa fa-star" title="5 stars" data-message="very good qality" data-value="5"></i>
                                                        </div>
                                                        <form action="" id="product_comment_form">
                                                            @csrf
                                                            <div class="starrate">
                                                                <input  class="ratevalue" type="hidden" name="ratting" value=""/>
                                                                <input  class="ratevalue" type="hidden" name="product_id" value=""/>
                                                            </div>
                                                            <div class="from-group">
                                                                <label for="review">Your review</label>
                                                                <textarea name="comment" id="reveiw" style="height: 85px; width: 320px;" class="form-control"></textarea>
                                                            </div>
                                                            <div class="form-group">
                                                                <button class="btn btn-success" @click.prevent="store_comment">Submit</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="card-body mx-auto" v-else>
                                        <form action="" class="border border-1 shadow-sm p-4 my-3" id="login_form">
                                            <p>
                                                Only logged in customers who have purchased this product may leave a review.
                                            </p>
                                            <div class="from-group">
                                                <label for="email">email</label>
                                                <input type="email" name="email" id="email" class="form-control">
                                            </div>
                                            <div class="from-group">
                                                <label for="password">Password</label>
                                                <input type="password" name="password" id="password" class="form-control">
                                            </div>
                                            <div class="form-group">
                                                <button @click.prevent="auth_login()" class="btn btn-outline-info">Login</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body rating_list" v-if="product_comments && product_comments.data">
                                <div id="wrap">
                                    <div class="container">
                                        <div class="col-lg-12">
                                            <h3 class="review-title text-center">Customer Ratings</h3>

                                            <div class="review" v-for="comment in product_comments.data" :key="comment.id">
                                                <div class="row">
                                                    <div style="width: 120px;">
                                                        <div class="review__head text-center">
                                                            <img src="https://unsplash.it/200" alt="" class="profile-img img-thumbnail center-block" />
                                                        </div>
                                                    </div>
                                                    <div style="width: calc(100% - 136px);">
                                                        <div class="review__body">
                                                            <span class="author-name">@{{ comment.user_name }}</span>
                                                            <ul class="rating d-inline-flex">
                                                                <li v-for="i in parseInt(comment.ratting)"><i class="fas fa-star"></i></li>
                                                            </ul>
                                                            <ul class="rating d-inline-flex" v-if="parseInt(comment.ratting) < 5">
                                                                <li v-for="i in (5 - parseInt(comment.ratting))"><i class="far fa-star"></i></li>
                                                            </ul>
                                                            <p>
                                                                @{{ comment.comment }}
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12" v-if="show_btn == 'how_to_buy'">
                        <div class="row justify-content-center mt-5">
                            <div class="col-md-6">
                                1. Add To Cart এ ক্লিক করুন। <br>
                                2. চেক আউট পেজে যান। যতো গুলো বই কিনতে চান সবগুলোতেই add to cart এ ক্লিক করতে হবে। <br>
                                3. চেক আউট পেজে শিপিং ইনফরমেশন দিন। <br>
                                4. এরপর place order করুন। <br>
                                5. আমরা ফোন করে অর্ডারটি কনফার্ম করব।
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="mt-5">
            <div class="container" style="border-top: 1px solid silver;">
                <h2 style="font-size: 22px;" class="mt-5">RELATED PRODUCTS</h2>
            </div>
        </section>

        <section class="my-5" id="latest_books">
            <div class="container">
                <div class="next_prev">
                    <pagination :data="latest_products" :show-disabled="true" :align="'right'" :limit="-1" @pagination-change-page="get_latest_products"></pagination>
                </div>
                <div class="row">
                    <div class="five_col" v-for="item in latest_products.data" :key="item.id">
                        <div class="product_body preloader">
                            <div class="top">
                                <span v-if="item.discount">-@{{item.discount}}%</span>
                                <img :src="`/${item.thumb_image}`" alt="image">
                            </div>
                            <div class="bottom">
                                <a :href="`/product-details/${item.id}`">
                                    <h4>@{{item.name}}</h4>
                                </a>
                                <ul>
                                    <li v-if="item.discount_price"><del>৳ @{{item.price}}</del></li>
                                    <li v-if="item.discount_price">৳ @{{ item.discount_price }}</li>
                                    <li v-else>৳ @{{ item.price }}</li>
                                </ul>
                                <a href="#" @click.prevent="add_to_cart(item)" class="custom_btn1">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

@endsection
