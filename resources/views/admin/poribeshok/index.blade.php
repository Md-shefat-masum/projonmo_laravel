@extends('admin.layouts.admin')

@section('content')

    <div class="content-wrapper" id="poribeshok">
        <div class="container-fluid">
            @include('admin.includes.bread_cumb',['title'=>'Poribeshok management'])
            <div class="row">
                <div class="col-lg-12">
                    <div class="card" v-if="show_form">
                        <div class="card-header">
                            Poribshok Form
                        </div>
                        <div class="card-body">
                            <form action="" id="create_poribeshok" @submit.prevent="create()" enctype="multipart/form-data">
                                <div class="form-group">
                                    <label for="title">Title</label>
                                    <input type="text" name="title" id="title" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="image">Image  (size: 190 x 500px)</label>
                                    <input type="file" name="image" id="image" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="description">Description</label>
                                    <input type="text" name="description" id="description" class="form-control">
                                </div>
                                <div class="form-group">
                                    <button v-if="type == 'create'" class="btn btn-success">Create</button>
                                    <button v-if="type == 'edit'" class="btn btn-success">Update</button>
                                    <button @click.prevent="close_form()" type="btn" class="btn btn-success">Close</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header d-flex justify-content-between">
                            <h5 class="card-title"> All poribeshoks</h5>
                            <button class="btn btn-success" @click.prevent="show_forms()"> Create</button>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Image</th>
                                            <th scope="col">Title</th>
                                            <th scope="col">Description</th>
                                            <th class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item,index) in data.data" :key="item.id">
                                            <th scope="row">@{{ index+1 }}</th>
                                            <td>
                                                <img v-if="item.image" :src="`/${item.image}`" class="border border-1" style="height: 80px; border-radius: 5px; padding: 5px;">
                                            </td>
                                            <td>@{{ item.title }}</td>
                                            <td>@{{ item.description }}</td>
                                            <td>
                                                <div class="d-flex justify-content-end">
                                                    <a href="#" @click.prevent="select_poribeshok(item)" class="btn btn-warning m-1">Edit</a>
                                                    <a href="#" @click.prevent="delete_poribeshok(item)" class="btn btn-danger m-1">Delete</a>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <pagination :data="data" :show-disabled="true" :align="'center'" @pagination-change-page="get_all"></pagination>
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

    @push('cjs')
        <script>
            new Vue({
                el: '#poribeshok',
                data: function(){
                    return {
                        data: {},
                        id: '',
                        type: 'create',
                        show_form: false,
                    }
                },
                created: function(){
                    this.get_all();
                },
                methods: {
                    show_forms: function(){
                        this.show_form = true;
                    },
                    close_form: function(){
                        $('#create_poribeshok').trigger('reset');
                        this.show_form = false;
                        this.type = 'create';
                    },
                    get_all: function(page=1){
                        axios.get('/pathok/poribeshok-json?page='+page)
                            .then((res)=>{
                                this.data = res.data;
                            })
                    },
                    create: function(){
                        let form_data = new FormData($('#create_poribeshok')[0]);
                        if(this.type == 'create'){
                            axios.post('/pathok/poribeshok-create',form_data)
                                .then((res)=>{
                                    console.log(res.data);
                                    $('#create_poribeshok').trigger('reset');
                                    this.get_all();
                                    this.show_form = false;
                                })
                        }
                        if(this.type == 'edit'){
                            form_data.append('id',this.id);
                            axios.post('/pathok/poribeshok-update',form_data)
                                .then((res)=>{
                                    console.log(res.data);
                                    $('#create_poribeshok').trigger('reset');
                                    this.type = 'create';
                                    this.id = '';
                                    this.get_all();
                                    this.show_form = false;
                                })
                        }
                    },
                    select_poribeshok: function(poribeshok){
                        this.show_forms();
                        setTimeout(() => {
                            this.id = poribeshok.id;
                            this.type = 'edit';
                            for (const key in poribeshok) {
                                if (Object.hasOwnProperty.call(poribeshok, key)) {
                                    const element = poribeshok[key];
                                    key != 'image' &&
                                    $(`input[name="${key}"]`).val(element);
                                }
                            }
                        }, 1000);

                    },
                    delete_poribeshok: function(poribeshok){
                        if(confirm('sure wanth to delete')){
                            axios.post('/pathok/poribeshok-delete',{id:poribeshok.id})
                                .then((res)=>{
                                    this.get_all();
                                })
                        }
                    }
                }
            })
        </script>
    @endpush

@endsection



