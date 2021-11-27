@extends('admin.layouts.admin')

@section('content')

    <div class="content-wrapper">
        <div class="container" >
            @include('admin.includes.bread_cumb',['title'=>'Edit Blog'])
            <div class="row">
                <div class="col-lg-12" id="blog" >

                    <form action="#" id="blog_form" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="card">
                            <div class="card-header d-inline-flex justify-content-md-between">
                                <h4>Blog Details</h4>
                                <a href="{{ route('admin_blog_list') }}" class="btn btn-warning mt-sm-3 mt-md-0" type="button">
                                    <i class="fa fa-angle-left"></i> Back
                                </a>
                            </div>
                            <div class="card-body">
                                <div class="from-group row mb-4 justify-contents-center">
                                    <label for="name" class="col-lg-3 text-lg-right">Title : </label>
                                    <div class="col-lg-7">
                                        <input name="title" @keyup="make_url" v-model="form_data.title" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="from-group row mb-4">
                                    <label for="url" class="col-lg-3 text-lg-right">URL : </label>
                                    <div class="col-lg-7">
                                        <input name="url" @keyup="change_url" v-model="form_data.url" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="from-group row mb-4">
                                    <label for="url" class="col-lg-3 text-lg-right">Categories : </label>
                                    <div class="col-lg-7">
                                        <div class="card category_card_dropdown">
                                            <div class="card-header">
                                                <label for="" class=" col-form-label">Categories</label>
                                                <input type="hidden" name="selected_categories">
                                            </div>
                                            <div class="card-body overflow-hidden category_block" v-html="category_html">

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="from-group row mb-4">
                                    <label for="description" class="col-lg-3 text-lg-right">Description : </label>
                                    <div class="col-lg-7">
                                        <textarea name="description" v-model="form_data.description" id="mytextarea1" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="from-group row mb-4">
                                    <label for="description" class="col-lg-3 text-lg-right">Short Description : </label>
                                    <div class="col-lg-7">
                                        <div class="text-right">
                                            @{{ form_data.short_description.length }}
                                            <span class="text-warning pl-4">max(200)</span>
                                        </div>
                                        <textarea name="short_description" maxlength="200" v-model="form_data.short_description" style="height: 140px;" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="from-group row mb-4">
                                    <label for="category_image" class="col-lg-3 text-right">Image: (740x400px) </label>
                                    <div class="col-lg-7">
                                        <input name="image" id="upload_image" type="file" class="form-control">
                                        <div class="gallery mt-2"></div>
                                        <img :src="`/${form_data.image}`" alt="blog image" style="height: 100px;margin-top: 10px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header">
                                <h5>Search Engine Optimization</h5>
                            </div>
                            <div class="card-body">
                                <div class="from-group row mb-4">
                                    <label for="seo_title" class="col-lg-3 text-lg-right">Page Title : (optional)</label>
                                    <div class="col-lg-7">
                                        <input name="seo_title" v-model="form_data.seo_title" type="text" class="form-control">
                                    </div>
                                </div>
                                <div class="from-group row mb-4">
                                    <label for="seo_keywords" class="col-lg-3 text-lg-right">Meta Keywords : (optional)</label>
                                    <div class="col-lg-7">
                                        <textarea name="seo_keywords" v-model="form_data.seo_keywords" type="text" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="from-group row mb-4">
                                    <label for="seo_description" class="col-lg-3 text-lg-right">Meta Description : (optional)</label>
                                    <div class="col-lg-7">
                                        <textarea name="seo_description" v-model="form_data.seo_description" type="text" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="from-group row mb-4">
                                    <label for="search_keywords" class="col-lg-3 text-lg-right">Search Keywords : (optional)</label>
                                    <div class="col-lg-7">
                                        <textarea name="search_keywords" v-model="form_data.search_keywords" type="text" class="form-control"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer d-flex justify-content-center">
                                <a href="{{ route('admin_blog_list') }}" class="btn btn-warning mr-3" type="button">
                                    <i class="fa fa-angle-left"></i> Back
                                </a>
                                <button @click.prevent="update_product" class="btn btn-info" type="button">
                                    <i class="fa fa-upload"></i> Submit
                                </button>
                            </div>
                        </div>

                    </form>

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
        <link rel="stylesheet" href="{{ asset('contents/admin') }}/plugins/summernote/dist/summernote-bs4.css" />
        <link rel="stylesheet" href="{{ asset('contents/admin') }}/custom_2.css">
    @endpush

    @push('cjs')
        <script src="{{ asset('contents/admin') }}/plugins/summernote/dist/summernote-bs4.min.js"></script>
        <script>
            $(function(){
                $('#mytextarea1').summernote({
                    height: 200,
                    tabsize: 2
                });
            })
        </script>
        <script src="/contents/admin/blog_vue.js"></script>

    @endpush
@endsection

