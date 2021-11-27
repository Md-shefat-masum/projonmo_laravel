@extends('website.ecommerce.layouts.ecommerce')
@php
    $item = App\Models\PhotoGraphp::find($id);
@endphp
@section('meta')
    <title>Photography</title>
    <meta name="keywords" content="photography, Prossod Publication, book publication, book shop, islamic books, ecommerce">

    <meta property="og:title" content="Photography" />
    <meta property="og:site_name" content="prossod prokashon" />
    <meta property="og:type" content="Ecommerce" />
    <meta property="og:image" content="{{ asset('/'.$item->image) }}" />
    <meta property="og:image:width" content="600" />
    <meta property="og:image:height" content="315" />

    <meta name="twitter:title" content="Photography">
    <meta name="twitter:image" content="{{ asset('/'.$item->image) }}">
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
@section('content')

    <section class="py-2 my-lg-5">
        <div class="container">
            <div class="row justify-content-center fimages">

                <div class="col-md-6 mb-3">
                    <div class="card">
                        <div class="card-body">
                            <img href="/{{ $item->image }}" src="/{{ $item->image }}" class="img-fluid" alt="{{ $item->title }}">
                        </div>
                        <div class="card-footer">
                            <h4>{{ $item->title }}</h4>
                            <p>
                                {{ $item->description }}
                            </p>
                            <ul class="social_links">
                                <li style="line-height: 35px;padding-right: 10px;">Share: </li>
                                <li><a target="_blank" href="https://www.facebook.com/sharer.php?u={{url()->full()}}"><i class="fab fa-facebook-f"></i></a></li>
                                <li><a target="_blank" href="https://twitter.com/intent/tweet?url={{url()->full()}}"><i class="fab fa-twitter"></i></a></li>
                                <!--<li><a target="_blank" href="#"><i class="fas fa-envelope"></i></a></li>-->
                                <!--<li><a target="_blank" href="#"><i class="fab fa-pinterest-p"></i></a></li>-->
                                <!--<li><a target="_blank" href="#"><i class="fab fa-linkedin-in"></i></a></li>-->
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @push('cjs')
        <link rel="stylesheet" href="/css/magnify.css">
        <script src="/js/magnifi.js"></script>
        <script>
            $(function(){
                $('.fimages').magnificPopup({
                    delegate: 'img', // child items selector, by clicking on it popup will open
                    type: 'image',
                    gallery: {
                        enabled: true
                    }
                    // other options
                });
            })
        </script>
    @endpush
@endsection

