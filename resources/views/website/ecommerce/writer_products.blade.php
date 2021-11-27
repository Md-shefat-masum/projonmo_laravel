@extends('website.ecommerce.layouts.ecommerce')
@section('content')

    <section>
        <div class="container">
            <div class="card mt-5 mb-5">
                <div class="card-header">
                    <h5>লেখকের বিস্তারিত</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            @if ($writer->image)
                                <img src="/{{ $writer->image }}" class="img-fluid" alt="{{ $writer->name }}">
                            @else
                                <img src="/avatar.png" class="img-fluid" alt="">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <b style="font-size:30px;">{!! $writer->name !!}</b>
                            <br>
                            <br>
                            {!! $writer->description !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section>
        <div class="container">
            <h1 class="text-center">লেখকের বই সমূহ</h1>
        </div>
    </section>
    <section class="py-2 my-lg-5" id="writer_product_lists" style="min-height: 975px;">
        <div class="container">
            <div class="row" :style="`justify-content:center;`">
                {{-- <div class="five_col mb-5" v-for="item in all_products.data" :key="item.id"> --}}
                <div class="five_col mb-5" v-for="item in products" :key="item.id">
                    <div class="product_body preloader">
                        <div class="top">
                            <span v-if="item.discount>0">-@{{item.discount}}%</span>
                            <img :src="`/${item.thumb_image}`" alt="image">
                        </div>
                        <div class="bottom">
                            <a :href="`/product-details/${item.id}`">
                                <h4>@{{ item.name }}</h4>
                            </a>
                            <ul>
                                <span v-if="item.discount_price">
                                    <li ><del>৳ @{{item.price}}</del></li>
                                    <li >৳ @{{ item.discount_price }}</li>
                                </span>

                                <li v-else>৳ @{{ item.price }}</li>
                            </ul>
                            <a href="#" @click.prevent="add_to_cart(item)" class="custom_btn1 flex_btn ">Buy Now</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <pagination
                            :data="all_products"
                            :show-disabled="true"
                            :limit="4"
                            :align="'center'"
                            @pagination-change-page="writer_product_lists">
                    </pagination>
                    {{-- <div id="demo"></div> --}}
                    <div style="clear: both;margin-bottom: 25px;"></div>

                </div>
            </div>
        </div>
    </section>
@endsection

