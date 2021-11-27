<div class="side_nav_body">
    <h2>BROWSE</h2>
    <ul>
        @foreach (App\Models\MainCategory::where('status',1)->get() as $main_category)
            @if ($main_category->related_products()->count() > 0)
                <li>
                    <a href="/books/{{$main_category->name}}/{{ $main_category->id }}?type=main-category"
                        @click.prevent="get_widget_category_product({
                            category_name: '{{str_replace(' ','-',$main_category->name)}}',
                            id: {{ $main_category->id }},
                            type: 'main_category',
                        },
                        `/books/{{str_replace(' ','-',$main_category->name)}}/{{ $main_category->id }}`,
                        `/get-main-category-product`)">
                        {{ $main_category->name }}
                    </a>
                    @if ($main_category->related_categories()->count() > 0)
                        <ul>
                            @foreach ($main_category->related_categories()->get() as $category)
                                @if ($category->related_products)
                                    <li>
                                        {{-- <a href="/books/category/{{$category->name}}/{{ $category->id }}"
                                            @click.prevent="get_products(`/get-category-product/{{$category->id}}/${perPage}/1/json`)">
                                            {{ $category->name }}
                                        </a> --}}
                                        <a href="/books/category/{{$category->name}}/{{ $category->id }}?type=category"
                                            @click.prevent="get_widget_category_product({
                                                category_name: '{{str_replace(' ','-',$category->name)}}',
                                                id: {{ $category->id }},
                                                type: 'category',
                                            },
                                            `/books/category/{{str_replace(' ','-',$category->name)}}/{{ $category->id }}`,
                                            `/get-category-product`)">
                                            {{ $category->name }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                </li>
            @endif
        @endforeach
    </ul>

    {{-- <h2 class="heading_two">FILTER BY PRICE</h2>
    <div id="steps-slider"></div>
    <div class="slider_output">
        <input type="text" id="input-with-keypress-1">
        <input type="text" id="input-with-keypress-0">
    </div>

    <button class="custom_btn2" style="padding: 5px 20px;">Filter</button>
    <br> --}}

    <h2 class="mt-5">RECENTLY VIEWED</h2>
    <ul class="recent_view">
        <li v-for="item in get_recent_views" :key="item.id">
            <div class="left">
                <img :src="`/${item.details.thumb_image}`" alt="">
            </div>
            <div class="right">
                <a :href="`/product-details/${item.id}`">
                    <h3>@{{ item.details.name }}</h3>
                </a>
                <span v-if="item.details.discount_price">
                    <del>৳ @{{item.details.price}}</del>
                    <span >৳ @{{ item.details.discount_price }}</span>
                </span>
                <span v-else>৳ @{{ item.details.price }}</sp>
            </div>
        </li>
    </ul>
</div>
