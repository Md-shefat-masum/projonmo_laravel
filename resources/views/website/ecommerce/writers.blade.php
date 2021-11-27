@extends('website.ecommerce.layouts.ecommerce')
@section('content')

    <section class="py-2 my-lg-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <ul class="website_subject_list">
                        <?php
                            $writers = App\Models\Writer::orderBy("name",'ASC')->select(['id','name','slug'])->get();
                        ?>
                        @foreach ($writers as $item)
                            <li>
                                <a href="{{ route('website_writer_books',$item->slug) }}">
                                    <span>{{ $item->name }}</span>
                                    <span>{{ $item->total_book }}</span>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </section>
@endsection

