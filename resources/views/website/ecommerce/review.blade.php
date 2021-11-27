@extends('website.ecommerce.layouts.ecommerce')
@section('content')

    <section class="py-2 my-lg-5">
        <div class="container">
            <div class="row justify-content-lg-center">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <ul class="comment-list">
                                @php
                                    $reviews = App\Models\CustomerReview::where('status',1)->latest()->get();
                                @endphp
                                @foreach ($reviews as $item)
                                    <li>
                                        <div class="commentsp">
                                            <div class="img">
                                                <img src="/{{ $item->image }}" alt="">
                                            </div>
                                            <div class="content">
                                                <h4><cite>{{ $item->title }}</cite> <span>says:</span></h4>
                                                <p>{{ $item->description }}</p>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

