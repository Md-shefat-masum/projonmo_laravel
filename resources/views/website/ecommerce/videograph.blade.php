@extends('website.ecommerce.layouts.ecommerce')
@section('content')

    <section class="py-2 my-lg-5">
        <div class="container">
            <div class="row justify-content-start fimages myGallery">
                @php
                    $photos = App\Models\VideoGraph::orderBy('id','DESC')->get();
                @endphp
                @foreach ($photos as $item)
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body video_card">
                                <div class="over_lay">
                                    <a class="venobox vbox-item" data-vbtype="iframe" data-gall="myGallery" href="{{ $item->link }}">
                                        <i class="fab fa-youtube"></i>
                                    </a>
                                </div>
                                    <img href="/{{ $item->image }}" src="/{{ $item->image }}" class="img-fluid" alt="{{ $item->title }}">
                            </div>
                            <div class="card-footer">
                                <h4>{{ $item->title }}</h4>
                                <p>
                                    {{ $item->description }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @push('cjs')
        {{-- <link rel="stylesheet" href="/css/magnify.css"> --}}
        <link rel="stylesheet" type="text/css" href="/css/venu.css">
        <script src="/js/venu.js"></script>
        <script>
            $(function(){
                $('.venobox').venobox({
                    // framewidth: '400px',        // default: ''
                    // frameheight: '300px',       // default: ''
                    border: '10px',             // default: '0'
                    bgcolor: 'rgba(0,0,0,.3)',         // default: '#fff'
                    titleattr: 'data-title',    // default: 'title'
                    numeratio: true,            // default: false
                    infinigall: true
                });
            })
        </script>
    @endpush
@endsection

