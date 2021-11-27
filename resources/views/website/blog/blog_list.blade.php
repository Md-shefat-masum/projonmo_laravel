@extends('website.ecommerce.layouts.ecommerce')
@section('content')

        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-lg-9 pe-lg-4" style="border-right: 1px solid rgba(119, 119, 119, 0.281);">
                        <div class="row" id="blog_list_section" v-if="bloglist && bloglist.data && bloglist.data.length">
                            <div class="col-sm-6 col-md-6 col-lg-12 col-xl-6 px-xl-4" v-for="blog in bloglist.data" :key="blog.id">
                                <div class="blog_list_body" >
                                    <h5>
                                        @{{ blog.title }}
                                    </h5>
                                    <h6>
                                        <span v-for="(item,index) in blog.categories">@{{ item.name }}@{{ index < blog.categories.length-1?',':'' }}</span>
                                    </h6>
                                    {{-- <p class="date">POSTED ON MAY 23, 2021 BY ADMIN</p> --}}
                                    <p class="date" v-if="blog.formated_date">POSTED ON @{{ blog.formated_date.date_time7 }}</p>
                                    <div class="img">
                                        <span class="date d-none">
                                            <!--<span>@{{ blog.formated_date.day }}</span>-->
                                            <!--<span>@{{ blog.formated_date.month }}</span>-->
                                        </span>
                                        <img :src="`/${blog.image}`" alt="image">
                                    </div>
                                    <p class="description">
                                        @{{ blog.short_description }}
                                    </p>
                                    <a :href="`/blog-details/${blog.url.replace('/','')}`" class="readmore">
                                        Continue reading
                                        <i class="fas fa-long-arrow-alt-right"></i>
                                    </a>
                                    <ul class="bottom_link">
                                        <li>
                                            <a :href="`/blog-details/${blog.url.replace('/','')}`">
                                                Posted in
                                                <span v-for="(item,index) in blog.categories">@{{ item.name }}@{{ index < blog.categories.length-1?',':'' }}</span>
                                            </a>
                                        </li>
                                        <li><a :href="`/blog-details/${blog.url.replace('/','')}`">Leave a comment</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <pagination
                            :data="bloglist"
                            :show-disabled="true"
                            :limit="4"
                            :align="'center'"
                            @pagination-change-page="get_blog_json">
                        </pagination>

                    </div>
                    <div class="col-lg-3 ps-lg-4">
                        <h3 class="published_book">প্রকাশিত বই</h3>
                        <ul class="recent_view">
                            @foreach (App\Models\Product::where('status',1)
                                                ->select(['id','thumb_image','name','price','created_at'])
                                                ->orderBy('id','DESC')->limit(10)->get() as $item)
                                <li>
                                    <div class="left">
                                        <img src="/{{ $item->thumb_image }}" class="img-thumbnail" alt="">
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
