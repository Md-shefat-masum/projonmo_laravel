@extends('website.ecommerce.layouts.ecommerce')
@section('meta')
    <title>{{ $blog->title }}</title>
    <meta name="keywords" content="{{ $blog->title }},Prossod Publication, book publication, book shop, islamic books, ecommerce">
    <meta name="description" content="{!! $blog->short_description !!}">

    <meta property="og:title" content="{{ $blog->title }}" />
    <meta property="og:site_name" content="prossod prokashon" />
    <meta property="og:description" content="{!! $blog->short_description !!}" />
    <meta property="og:type" content="Blog" />
    <meta property="og:image" content="{{ asset($blog->image) }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />

    <meta name="twitter:title" content="{{ $blog->title }}">
    <meta name="twitter:description" content="{!! $blog->short_description !!}">
    <meta name="twitter:image" content="{{ asset($blog->image) }}">
    <meta name="twitter:card" content="summary_large_image">
@endsection
@section('content')
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 pe-lg-4" style="border-right: 1px solid rgba(119, 119, 119, 0.281);">
                    <div class="blog_list_body">
                        <h6>
                            @foreach ($blog->categories as $key=>$item)
                                <span>{{ $item->name }}{{ $key < count($blog->categories)-1?',':'' }}</span>
                            @endforeach
                        </h6>
                        <h5>
                            {{ $blog->title }}
                        </h5>
                        <p class="date">
                            POSTED ON {{ $blog->created_at->format('M d, Y') }}
                            <!--BY {{ $blog->author->username }}-->
                        </p>
                        <div class="img">
                            <span class="date d-none">
                                <!--<span>23</span>-->
                                <!--<span>May</span>-->
                            </span>
                            <img src="/{{ $blog->image }}" alt="image">
                        </div>
                        <div class="description w-100">
                            {!! $blog->description !!}
                        </div>
                        @push('cjs')
                            <style>
                                .blog_list_body .description p {
                                    width: 100% !important;
                                    padding:0;
                                    margin:7px 0px;
                                }
                            </style>
                        @endpush

                        <ul class="social_links">
                            <li><a target="_blank" href="https://www.facebook.com/sharer.php?u={{url()->full()}}"><i class="fab fa-facebook-f"></i></a></li>
                            <li><a target="_blank" href="https://twitter.com/intent/tweet?url={{url()->full()}}"><i class="fab fa-twitter"></i></a></li>
                            <!--<li><a target="_blank" href="#"><i class="fas fa-envelope"></i></a></li>-->
                            <!--<li><a target="_blank" href="#"><i class="fab fa-pinterest-p"></i></a></li>-->
                            <!--<li><a target="_blank" href="#"><i class="fab fa-linkedin-in"></i></a></li>-->
                        </ul>
                    </div>
                    <div class="card">
                        <div class="card-body">
                            <ul class="comment-list">
                                @php
                                    $comments = App\Models\BlogComment::where('blog_id',$blog->id)->where('status',1)->latest()->get();
                                @endphp
                                @foreach ($comments as $item)
                                    <li>
                                        <div class="commentsp">
                                            <div class="img">
                                                <img src="/avatar.png" alt="">
                                            </div>
                                            <div class="content">
                                                <h4><cite>{{ $item->name }}</cite> <span>says:</span></h4>
                                                <p>{{ $item->description }}</p>
                                                <p class="footer">
                                                    <span>{{ $item->created_at->format('F d, Y h:i a') }}</span>
                                                    <span class="reply" @click="show_reply($event)">REPLY</span>
                                                </p>
                                            </div>
                                        </div>
                                        @if ($item->replies()->get()->count() > 0)
                                            <ul>
                                                @foreach ($item->replies()->get() as $comment)
                                                    <li>
                                                        <div class="commentsp">
                                                            <div class="img">
                                                                <img src="/avatar.png" alt="">
                                                            </div>
                                                            <div class="content">
                                                                <h4><cite>{{ $comment->name }}</cite> <span>says:</span></h4>
                                                                <p>{{ $comment->description }}</p>
                                                                <p class="footer">
                                                                    <span>{{ $comment->created_at->format('F d, Y h:i a') }}</span>
                                                                    {{-- <span class="reply">REPLY</span> --}}
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                        <div class="comment_body d-none" style="margin-left: 85px;">
                                            <h5>Leave a Reply</h5>
                                            <p>Your email address will not be published. Required fields are marked *</p>

                                            <form action="" id="comment_form" @submit.prevent="store_blog_comment($event)">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="description">Comment *</label>
                                                        <textarea name="description" id="description"></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                                    <input type="hidden" name="parent" value="{{ $item->id }}">
                                                    <div class="col-md-4">
                                                        <label for="name">Name *</label>
                                                        <input name="name" id="name" type="text">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="name">Email *</label>
                                                        <input name="email" id="email" type="email">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label for="website">Websiete</label>
                                                        <input name="website" id="website" type="text">
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <button class="custom_btn2 mt-0 mb-4 d-inline-block">Post Reply</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="comment_body">
                        <h5>Leave a Reply</h5>
                        <p>Your email address will not be published. Required fields are marked *</p>

                        <form action="" id="comment_form" @submit.prevent="store_blog_comment($event)">
                            <div class="row">
                                <div class="col-12">
                                    <label for="description">Comment *</label>
                                    <textarea name="description" id="description"></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                <div class="col-md-4">
                                    <label for="name">Name *</label>
                                    <input name="name" id="name" type="text">
                                </div>
                                <div class="col-md-4">
                                    <label for="name">Email *</label>
                                    <input name="email" id="email" type="email">
                                </div>
                                <div class="col-md-4">
                                    <label for="website">Websiete</label>
                                    <input name="website" id="website" type="text">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button class="custom_btn2 mt-0 mb-4 d-inline-block">Post Comment</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 ps-lg-4">
                    <h3 class="published_book">প্রকাশিত বই</h3>
                    <ul class="recent_view">
                        @foreach (App\Models\Product::where('status',1)->select(['id','thumb_image','name','price','created_at'])->orderBy('id','DESC')->limit(10)->get() as $item)

                            <li>
                                <div class="left">
                                    <img src="/{{ $item->thumb_image }}" alt="">
                                </div>
                                <div class="right">
                                    <a href="/product-details/{{ $item->id }}">
                                        <h3>{{ $item->name }}</h3>
                                    </a>
                                    <span class="price">
                                        @if ($item->discount_price)
                                            <del>৳ {{ $item->price }}</del>
                                            <span>৳ {{ $item->discount_price }}</span>
                                        @else
                                            <span class="m-0">৳ {{ $item->price }}</span>
                                        @endif

                                    </span>
                                </div>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection
