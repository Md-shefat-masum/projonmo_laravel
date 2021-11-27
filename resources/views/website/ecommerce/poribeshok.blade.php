@extends('website.ecommerce.layouts.ecommerce')
@section('content')

    <section class="py-2 my-lg-5">
        <div class="container">
            <div class="row justify-content-start fimages">
                @php
                    $photos = App\Models\Poribeshok::orderBy('id','DESC')->get();
                @endphp
                @foreach ($photos as $item)
                    <div class="col-md-3 text-center">
                        <div class="card">
                            <div class="card-body">
                                <img href="/{{ $item->image }}" src="/{{ $item->image }}" class="img-fluid" alt="{{ $item->title }}">
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

