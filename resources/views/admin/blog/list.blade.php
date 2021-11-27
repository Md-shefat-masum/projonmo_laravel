@extends('admin.layouts.admin')

@section('content')

    <div class="content-wrapper" id="blog_list">
        <div class="container-fluid" >
            @include('admin.includes.bread_cumb',['title'=>'Blog Management'])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="filter_nav d-flex flex-wrap">
                                <li><a href="{{ route('admin_blog_create') }}" class="custom_white_btn">Create New</a></li>
                                {{-- <li class="border_right_white">
                                    <a href="#" class="custom_white_btn custom_white_btn_square"><i class="fa fa-trash"></i></a>
                                </li> --}}
                                {{-- <li>
                                    <select name="" class="custom_input custom_input_select">
                                        <option value="">--Chose an Action--</option>
                                        <option value="">Bulk Edit</option>
                                        <option value="">Export These Product</option>
                                    </select>
                                </li> --}}
                                {{-- <li class="border_right_white"><a href="#" class="custom_white_btn">confirm</a></li> --}}
                                <li>
                                    <input type="text" name="" placeholder="Filter by keyword" class="custom_input" />
                                    <button class="custom_white_btn">Search</button>
                                </li>
                                <li style="align-self: center;">
                                    <pagination :data="blogs" :limit="-1" :size="'small'" :show-disabled="true" :align="'center'" @pagination-change-page="get_blogs">
                                        <span slot="prev-nav"><i class="fa fa-angle-left"></i> Previous</span>
                                        <span slot="next-nav">Next <i class="fa fa-angle-right"></i></span>
                                    </pagination>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="padding-bottom: 20px;">
                                <table class="table text-left">
                                    <thead>
                                        <tr>
                                            <th scope="col"><input type="checkbox" /></th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th scope="col">Category</th>
                                            <th scope="col">Info</th>
                                            <th scope="col" class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="blog in blogs.data" :key="blog.id">
                                            <th scope="row"><input type="checkbox" /></th>
                                            <td><img :src="`/${blog.image}`" alt="test product 5" style="height: 70px;" /></td>
                                            <td style="white-space: initial;">
                                                <div style="width: 150px">
                                                    @{{ blog.title }}
                                                </div>
                                            </td>
                                            <td style="white-space: initial;">
                                                <div style="width: 300px;">
                                                    @{{ blog.short_description }}
                                                </div>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li v-for="(cat,index) in blog.categories" :key="index">@{{ cat.name }}</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul>
                                                    <li><i class="fa fa-eye"></i> views: 800</li>
                                                    <li><i class="fa fa-eye"></i> comments: 600</li>
                                                </ul>
                                            </td>
                                            <td>
                                                <ul class="d-flex justify-content-end table_actions">
                                                    <li>
                                                        <a href="#"><i class="fa fa-eye"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="fa fa-star-o"></i></a>
                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="fa fa-list-ul"></i></a>
                                                        <ul>
                                                            <li><a href="#">view</a></li>
                                                            <li><a :href="`/admin/blog/edit/${blog.id}`">edit</a></li>
                                                            <li><a :href="`/admin/blog/destroy/${blog.id}`" @click.prevent="deletes(blog.id)">delete</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="card-footer">
                                    <pagination :data="blogs" :show-disabled="true" :align="'center'" @pagination-change-page="get_blogs"></pagination>
                                </div>
                            </div>
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
        <link rel="stylesheet" href="{{ asset('contents/admin') }}/custom_2.css">
    @endpush

    @push('cjs')
        <script>
            if (document.getElementById('blog_list')) {
                const app = new Vue({
                    el: '#blog_list',
                    // store: store,
                    data: function(){
                        return {
                            blogs: {},
                        }
                    },
                    created: function(){
                        this.get_blogs();
                    },
                    methods:{
                        get_blogs: function(page=1){
                            axios.get('/admin/blog/list/json?page='+page)
                                .then((res)=>{
                                    this.blogs = res.data;
                                })
                        },
                        deletes: function(id){
                            let cofirms = confirm('sure want to delete');
                            if(cofirms){
                                axios.get(`/admin/blog/destroy/${id}`)
                                    .then(res=>this.get_blogs());
                            }
                        }
                    }
                });
            }


        </script>
    @endpush
@endsection

