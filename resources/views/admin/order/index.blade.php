@extends('admin.layouts.admin')

@section('content')

    <div class="content-wrapper" id="order_list">
        <div class="container-fluid">
            @include('admin.includes.bread_cumb',['title'=>'All'])
            <div class="row">
                <div class="col-12">
                    <ul class="admin_product_list_nav">
                        <li><a href="#" :class="{ active: type === 'all' }" @click.prevent="get_by_type('all')">All</a></li>
                        <li><a href="#" :class="{ active: type === 'pending' }" @click.prevent="get_by_type('pending')">Pending</a></li>
                        <li><a href="#" :class="{ active: type === 'accepted' }" @click.prevent="get_by_type('accepted')">Accepted</a></li>
                        <li><a href="#" :class="{ active: type === 'processing' }" @click.prevent="get_by_type('processing')">Processed</a></li>
                        <li><a href="#" :class="{ active: type === 'delivered' }" @click.prevent="get_by_type('delivered')">Delivered</a></li>
                        <li><a href="#" :class="{ active: type === 'canceled' }" @click.prevent="get_by_type('canceled')">Canceled</a></li>
                    </ul>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <ul class="filter_nav d-flex flex-wrap">
                                {{-- <li><a href="#" class="custom_white_btn">add</a></li>
                                <li class="border_right_white"><a href="#" class="custom_white_btn custom_white_btn_square"><i class="fa fa-trash"></i></a></li> --}}

                                {{-- <li>
                                    <select name="" class="custom_input custom_input_select">
                                        <option value="">--Chose an Action--</option>
                                        <option value="">Accept All</option>
                                        <option value="">Export</option>
                                    </select>
                                </li>
                                <li class="border_right_white">
                                    <a href="#" class="custom_white_btn">confirm</a>
                                </li> --}}

                                <li>
                                    <form action="#" @submit.prevent="search_orders(1)">
                                        <input type="text" v-model="search_key" class="custom_input" name="search_key" placeholder="Filter by keyword">
                                        <button class="custom_white_btn" type="submit">Search</button>
                                    </form>
                                </li>
                                <li style="align-self: center;">
                                    <pagination :data="orders" :limit="-1" :size="'small'" :show-disabled="true" :align="'center'" @pagination-change-page="get_orders">
                                        <span slot="prev-nav"><i class="fa fa-angle-left"></i> Previous</span>
                                        <span slot="next-nav">Next <i class="fa fa-angle-right"></i></span>
                                    </pagination>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive" style="padding-bottom: 80px;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">User Name</th>
                                            <th scope="col">Phone</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">D-Method</th>
                                            <th scope="col">P-Method</th>
                                            <th scope="col">Invoice-no</th>
                                            <th scope="col">Subtotal</th>
                                            <th scope="col">Total</th>
                                            <th scope="col">Status</th>
                                            <th scope="col" class="text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(order,index) in orders.data" :key="order.id">
                                            <th scope="row">@{{ order.id }}</th>
                                            <td>@{{ order.full_name }}</td>
                                            <td>@{{ order.phone }}</td>
                                            <td>@{{ order.email }}</td>
                                            <td>@{{ order.delivery_method.replace('_',' ').toUpperCase() }}</td>
                                            <td>
                                                @{{ order.payment_method.replace('_',' ').toUpperCase() }}
                                                <br>
                                                <span v-if="order.payment_method.replace('_',' ').toUpperCase() == 'CASH ON'">
                                                    ref: <span class="badge bg-primary">@{{ order.payment_code }}</span>
                                                </span>
                                            </td>
                                            <td>@{{ order.invoice_id }}</td>
                                            <td>৳ @{{ order.subtotal }}</td>
                                            <td>৳ @{{ order.total }}</td>
                                            <td>
                                                <span v-html="get_order_status(order.status)"></span>
                                            </td>
                                            <td>
                                                <ul class="d-flex justify-content-end table_actions">
                                                    <li><a :href="`/orders/show/${order.slug}`"><i class="fa fa-eye"></i></a></li>
                                                    <li v-html="get_change_status(order.status,order.id,index)">

                                                    </li>
                                                    <li>
                                                        <a href="#"><i class="fa fa-list-ul"></i></a>
                                                        <ul>
                                                            {{-- <li><a href="#">view</a></li> --}}
                                                            <li><a target="blank" :href="`/print-invoice?order=${order.slug}`">print</a></li>
                                                            <li><a href="#" @click.prevent="change_status(order.id,6,index)">Cancel</a></li>
                                                        </ul>
                                                    </li>
                                                </ul>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card-footer">
                            <pagination :data="orders" :show-disabled="true" :align="'center'" @pagination-change-page="get_orders"></pagination>
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
        <link rel="stylesheet" href="/contents/admin/custom_2.css">
        <script src="/contents/admin/order_vue.js"></script>
    @endpush

@endsection



