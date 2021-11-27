@extends('website.ecommerce.layouts.ecommerce')
@section('content')

    <section class="py-2 my-lg-5">
        <div class="container">
            <div class="row justify-content-start fimages">
                @php
                    $photos = App\Models\PhotoGraphp::orderBy('id','DESC')->get();
                @endphp
                @foreach ($photos as $item)
                    <div class="col-md-4 mb-3">
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
                                    <li><a target="_blank" href="https://www.facebook.com/sharer.php?u={{route('website_photograph_details',$item->id)}}"><i class="fab fa-facebook-f"></i></a></li>
                                    <li><a target="_blank" href="https://twitter.com/intent/tweet?url={{route('website_photograph_details',$item->id)}}"><i class="fab fa-twitter"></i></a></li>
                                    <!--<li><a target="_blank" href="#"><i class="fas fa-envelope"></i></a></li>-->
                                    <!--<li><a target="_blank" href="#"><i class="fab fa-pinterest-p"></i></a></li>-->
                                    <!--<li><a target="_blank" href="#"><i class="fab fa-linkedin-in"></i></a></li>-->
                                </ul>
                            </div>
                        </div>
                    </div>
                @endforeach
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

