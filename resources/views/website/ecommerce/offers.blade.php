@extends('website.ecommerce.layouts.ecommerce')
@section('content')
{{--
    @push('css')
        <link rel="stylesheet" href="/contents/website/css/nouislider.css">
        <link rel="stylesheet" href="/contents/website/css/prism.css">
    @endpush --}}

    {{-- <section>
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <a href="#" class="filter_trigger">
                        <i class="fas fa-list-ul"></i>
                        FILTER
                    </a>
                    <div class="side_nav side_nav2" id="side_nav2">
                        <div class="overlay"></div>
                        @include('website.ecommerce.components.filter_side_nav')
                    </div>
                </div>
            </div>
        </div>
    </section> --}}

    <section class="py-2 my-lg-5" id="offer_product_lists" style="min-height: 975px;">
        <div class="container">
            <div class="row">
                {{-- <div class="five_col mb-5" v-for="item in all_products.data" :key="item.id"> --}}
                <div class="five_col mb-5" v-for="item in products" :key="item.id">
                    <div class="product_body preloader">
                        <div class="top">
                            <span v-if="item.discount>0">@{{item.discount}}%</span>
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
                            @pagination-change-page="get_offer_products">
                    </pagination>
                    {{-- <div id="demo"></div> --}}
                    <div style="clear: both;margin-bottom: 25px;"></div>

                </div>
            </div>
        </div>
    </section>
{{--
    @push('js_plugin')

        <script src="/contents/website/js/wNumb.js"></script>
        <script src="/contents/website/js/nouislider.js"></script>
    @endpush

    @push('cjs')
        <script>
            $(window).on('load',function(){
                var stepsSlider = document.getElementById('steps-slider');
                var input0 = document.getElementById('input-with-keypress-0');
                var input1 = document.getElementById('input-with-keypress-1');
                var inputs = [input0, input1];

                noUiSlider.create(stepsSlider, {
                    start: [20, 80],
                    connect: true,
                    tooltips: [true, wNumb({ decimals: 1 })],
                    range: {
                        'min': [0],
                        '10%': [10, 10],
                        '50%': [80, 50],
                        '80%': 150,
                        'max': 200
                    }
                });

                stepsSlider.noUiSlider.on('update', function (values, handle) {
                    inputs[handle].value = values[handle];
                });
                // Listen to keydown events on the input field.
                inputs.forEach(function (input, handle) {

                    input.addEventListener('change', function () {
                        stepsSlider.noUiSlider.setHandle(handle, this.value);
                    });

                    input.addEventListener('keydown', function (e) {

                        var values = stepsSlider.noUiSlider.get();
                        var value = Number(values[handle]);

                        // [[handle0_down, handle0_up], [handle1_down, handle1_up]]
                        var steps = stepsSlider.noUiSlider.steps();

                        // [down, up]
                        var step = steps[handle];

                        var position;

                        // 13 is enter,
                        // 38 is key up,
                        // 40 is key down.
                        switch (e.which) {

                            case 13:
                                stepsSlider.noUiSlider.setHandle(handle, this.value);
                                break;

                            case 38:

                                // Get step to go increase slider value (up)
                                position = step[1];

                                // false = no step is set
                                if (position === false) {
                                    position = 1;
                                }

                                // null = edge of slider
                                if (position !== null) {
                                    stepsSlider.noUiSlider.setHandle(handle, value + position);
                                }

                                break;

                            case 40:

                                position = step[0];

                                if (position === false) {
                                    position = 1;
                                }

                                if (position !== null) {
                                    stepsSlider.noUiSlider.setHandle(handle, value - position);
                                }

                                break;
                        }
                    });
                });
            })
        </script>
    @endpush --}}

@endsection

