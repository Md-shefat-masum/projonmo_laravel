@extends('admin.layouts.admin')

@section('content')

    <div class="content-wrapper">
        <div class="container">
            @include('admin.includes.bread_cumb',['title'=>'Product Mangement'])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" id="create_product">
                        <div class="card-body">
                            <div class="card-title">Edit Product</div>
                            <hr />
                            <form class="update_form product_insert_form row" id="edit_form" method="POST" action="{{route('product.update',$product->id)}}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="preloader"></div>
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <div class="col-6 form-group">
                                    <label for="type_of_product" class=" col-form-label">Product Type</label>
                                    <select id="type_of_product" @change="on_type_of_product_change($event)"
                                            name="type_of_product" v-model="type_of_product" class="form-control">
                                        <option value="book">Book</option>
                                        <option value="product">Product</option>
                                    </select>
                                </div>
                                <div class="col-12 p-0"></div>
                                <div class="form-group col-md-6 col-xl-4">
                                    <label for="" class=" col-form-label">Name</label>
                                    @include('admin.product.components.input',[
                                        'name' => 'product_name',
                                        'type' => 'text',
                                        'value' => $product->name,
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4" v-if="type_of_product == 'product'">
                                    <label for="" class="col-form-label">Brand</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'brand',
                                        'attributes' => '',
                                        'class' => 'multiple-select',
                                        'collection' => $brands,
                                        'action' => route('brand.store'),
                                        'value' => $product->brand_id,
                                        'fields' => [
                                            ['name' => 'name','type' => 'text'],
                                            ['name' => 'icon','type' => 'file'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4">
                                    <label for="" class="col-form-label">Main Category</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'product_main_category_id',
                                        'attributes' => '',
                                        'class' => 'multiple-select product_main_category',
                                        'collection' => $maincategories,
                                        'action' => route('main_category.store'),
                                        'value' => $product->main_category()->first() ? $product->main_category()->first()->id : '',
                                        'fields' => [
                                            ['name' => 'name','type' => 'text'],
                                            ['name' => 'icon','type' => 'file'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4">
                                    <label for="" class="col-form-label">Category</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'product_category_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select product_category',
                                        'collection' => $categories,
                                        'action' => route('category.store'),
                                        'fields' => [
                                            ['name' => 'main_category_id','type' => 'select','option_route'=>route('get_main_category_json')],
                                            ['name' => 'name','type' => 'text'],
                                            ['name' => 'icon','type' => 'file'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4">
                                    <label for="" class="col-form-label">Sub Category</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'product_sub_category_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select product_sub_category',
                                        'collection' => $sub_categories,
                                        'value' => $product->sub_category,
                                        'action' => route('sub_category.store'),
                                        'fields' => [
                                            [
                                                'name' => 'main_category_id',
                                                'type' => 'select',
                                                'option_route'=>route('get_main_category_json'),
                                                'class' => 'component_modal_main_category parent_select',
                                                'this_field_will_contorl' => 'component_modal_category',
                                                'this_field_control_route' => route('get_all_cateogory_selected_by_main_category',''),
                                                // 'this_field_control_route' => '',
                                            ],
                                            [
                                                'name' => 'category_id',
                                                'class' => 'component_modal_category',
                                                'type' => 'select',
                                                'option_route'=>''
                                            ],
                                            ['name' => 'name','type' => 'text'],
                                            ['name' => 'icon','type' => 'file'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4" v-if="type_of_product == 'book'">
                                    <label for="" class="col-form-label">Writer</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'writer_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select',
                                        'collection' => $writers,
                                        'value' => $product->writer,
                                        'action' => route('writer.store'),
                                        'fields' => [
                                            ['name' => 'name','type' => 'text'],
                                            ['name' => 'description','type' => 'textarea'],
                                            ['name' => 'image','type' => 'file'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4" v-if="type_of_product == 'book'">
                                    <label for="" class="col-form-label">Translator</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'translator_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select',
                                        'collection' => $translators,
                                        'action' => route('translator.store'),
                                        'value' => $product->translator,
                                        'fields' => [
                                            ['name' => 'name','type' => 'text'],
                                            ['name' => 'description','type' => 'textarea'],
                                            ['name' => 'image','type' => 'file'],
                                        ]
                                    ])
                                </div>

                                {{-- <div class="form-group col-md-6  col-xl-4" v-if="type_of_product == 'book'">
                                    <label for="" class="col-form-label">Publication</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'publication_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select',
                                        'collection' => $publications,
                                        'value' => $product->publication,
                                        'action' => route('publication.store'),
                                        'fields' => [
                                            ['name' => 'name','type' => 'text'],
                                            ['name' => 'image','type' => 'file'],
                                            ['name' => 'description','type' => 'textarea'],
                                        ]
                                    ])
                                </div> --}}

                                <div class="form-group col-md-6  col-xl-4" v-if="type_of_product == 'product'">
                                    <label for="" class="col-form-label">Color</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'color_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select',
                                        'collection' => $colors,
                                        'action' => route('color.store'),
                                        'value' => $product->color,
                                        'fields' => [
                                            ['name' => 'name', 'type' => 'text'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4" v-if="type_of_product == 'product'">
                                    <label for="" class="col-form-label">Size</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'size_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select',
                                        'collection' => $sizes,
                                        'action' => route('size.store'),
                                        'value' => $product->size,
                                        'fields' => [
                                            ['name' => 'name', 'type' => 'text'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4" v-if="type_of_product == 'product'">
                                    <label for="" class="col-form-label">Unit</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'unit_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select',
                                        'collection' => $units,
                                        'action' => route('unit.store'),
                                        'value' => $product->unit,
                                        'fields' => [
                                            ['name' => 'name', 'type' => 'text'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6  col-xl-4">
                                    <label for="" class="col-form-label">Vendor</label>
                                    @include('admin.product.components.select',[
                                        'name' => 'vendor_id',
                                        'attributes' => 'multiple',
                                        'class' => 'multiple-select',
                                        'collection' => $vendors,
                                        'action' => route('vendor.store'),
                                        'value' => $product->vendor,
                                        'fields' => [
                                            ['name' => 'name', 'type' => 'text'],
                                            ['name' => 'email', 'type' => 'email'],
                                            ['name' => 'mobile_no', 'type' => 'text'],
                                            ['name' => 'image', 'type' => 'file'],
                                            ['name' => 'address', 'type' => 'textarea'],
                                            ['name' => 'description', 'type' => 'textarea'],
                                        ]
                                    ])
                                </div>

                                <div class="form-group col-md-6 col-xl-4">
                                    <label for="" class=" col-form-label">Price</label>
                                    @include('admin.product.components.input',[
                                        'name' => 'price',
                                        'type' => 'number',
                                        'attr' => "step='0.01'",
                                        'value' => $product->price,
                                    ])
                                </div>

                                <div class="form-group col-md-6 col-xl-4">
                                    <label for="" class=" col-form-label">Tax</label>
                                    @include('admin.product.components.input',[
                                        'name' => 'tax',
                                        'value' => $product->tax,
                                        'type' => 'number'
                                    ])
                                </div>

                                <div class="form-group col-md-6 col-xl-4">
                                    <label for="" class=" col-form-label">Discount</label>
                                    @include('admin.product.components.input',[
                                        'name' => 'discount',
                                        'value' => $product->discount,
                                        'type' => 'text'
                                    ])
                                </div>

                                <div class="form-group col-md-6 col-xl-4">
                                    <label for="" class=" col-form-label">Expiration Date</label>
                                    @include('admin.product.components.input',[
                                        'name' => 'expiration_date',
                                        'value' => $product->expiration_date,
                                        'type' => 'date'
                                    ])
                                </div>

                                <div class="form-group col-md-6 col-xl-4">
                                    <label for="" class=" col-form-label">Stock</label>
                                    @include('admin.product.components.input',[
                                        'name' => 'stock',
                                        'value' => $product->stock,
                                        'type' => 'number'
                                    ])
                                </div>

                                <div class="form-group col-md-6 col-xl-4">
                                    <label for="" class=" col-form-label">Alert Quantity</label>
                                    @include('admin.product.components.input',[
                                        'name' => 'alert_quantity',
                                        'value' => $product->minimum_amount,
                                        'type' => 'number'
                                    ])
                                </div>

                                <div class="col-12">
                                    <label for="" class=" col-form-label">Search and SEO keywords ( separate by comma , )</label>
                                    @include('admin.product.components.input',[
                                        'name' => 'search_name',
                                        'value' => $product->search_name,
                                        'type' => 'text'
                                    ])
                                </div>

                                <div class="col-12"><br></div>

                                <div class="form-group col-md-6 col-xl-6">
                                    <label for="" class=" col-form-label">Description</label>
                                    <div class="">
                                        {{-- <input type="number" class="form-control"  placeholder="Alert" /> --}}
                                        <textarea name="description" class="form-control" id="mytextarea1" cols="30" rows="10">{!! $product->description !!}</textarea>
                                        <span class="text-danger description"></span>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-xl-6">
                                    <label for="" class=" col-form-label">Features</label>
                                    <div class="">
                                        {{-- <input type="number" class="form-control"  placeholder="Alert" /> --}}
                                        <textarea name="features" class="form-control" id="mytextarea2" cols="30" rows="10">{!! $product->features !!}</textarea>
                                        <span class="text-danger features"></span>
                                    </div>
                                </div>

                                <div class="form-group col-md-6 col-xl-6">
                                    <label for="" class=" col-form-label">Thumb Image<sub>(350*500px)</sub></label>
                                    @include('admin.product.components.input',[
                                        'name' => 'thumb_image',
                                        'type' => 'file',
                                        'value' => $product->thumb_image,
                                        'attr' => ''
                                    ])
                                </div>

                                <div class="form-group col-md-6 col-xl-6">
                                    <label for="" class=" col-form-label">Related Image<sub>(350*500px)</sub></label>
                                    @php
                                        $value_ids = [];
                                        $value_names = [];
                                        foreach ($product->image as $key => $item) {
                                            array_push($value_ids,$item->id);
                                            array_push($value_names,$item->name);
                                        }
                                    @endphp
                                    @include('admin.product.components.input',[
                                        'name' => 'related_images',
                                        'type' => 'file',
                                        'value' => json_encode($value_ids),
                                        'value_names' => $value_names,
                                        'attr' => 'multiple'
                                    ])
                                </div>


                                <div class="form-group col-md-6  col-xl-4">
                                    <label for="" class="col-form-label">Staus</label>
                                    <div class="">
                                        <select name="status"  class="form-control">
                                            @foreach ($status as $item)
                                                <option {{ $item->id == $product->status ? 'selected' : '' }} value="{{ $item->serial }}">{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                        <span class="text-danger status"></span>
                                    </div>
                                </div>
                                <div class="form-group col-md-6  col-xl-4">
                                    <label for="" class="col-form-label">Free Delivery</label>
                                    <div class="">
                                        <select name="free_delivery"  class="form-control">
                                            <option {{ $product->free_delivery == 'false' ? 'selected' : '' }} value="false">Off</option>
                                            <option {{ $product->free_delivery == 'true' ? 'selected' : '' }}  value="true">On</option>
                                        </select>
                                        <span class="text-danger status"></span>
                                    </div>
                                </div>

                                <div class="form-group col-12">
                                    <label class="col-form-label"></label>
                                    <div class="">
                                        <button type="submit" class="btn btn-white px-5"><i class="icon-lock"></i> Upload</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
            <!--start overlay-->
            <div class="overlay"></div>
            <!--end overlay-->
        </div>
        <!-- End container-fluid-->
    </div>
    <!--End content-wrapper-->

    @push('ccss')
        <link href="/contents/admin/plugins/select2/css/select2.min.css" rel="stylesheet" />
        <link href="/contents/admin/plugins/select2/css/select2-bootstrap4.css" rel="stylesheet" />
        <link rel="stylesheet" href="{{ asset('contents/admin') }}/plugins/summernote/dist/summernote-bs4.css" />
    @endpush

    @push('cjs')
        <script src="/contents/admin/plugins/select2/js/select2.min.js"></script>
        <script src="{{ asset('contents/admin') }}/plugins/summernote/dist/summernote-bs4.min.js"></script>
        {{-- <script src='https://cdn.tiny.cloud/1/vdqx2klew412up5bcbpwivg1th6nrh3murc6maz8bukgos4v/tinymce/5/tinymce.min.js' referrerpolicy="origin"></script> --}}
        <script src="/contents/admin/custom_add_product_vue.js"></script>

    @endpush


@endsection



