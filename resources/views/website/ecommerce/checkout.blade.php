@extends('website.ecommerce.layouts.ecommerce')
@section('content')

<section class="py-2 my-lg-5" id="product_lists">
    <div class="container">
        <form action="#" id="checkout_form" @submit.prevent="checkout_submit" autocomplete="off">
            <div class="row">

                <div class="col-md-6 col-lg-7">
                    <div class="card">
                        <div class="card-body" v-if="get_billing_info">
                            <h4>আপনার ঠিকানা</h4>
                            <br>
                            <div class="form-group">
                                <label for="full_name">Full Name <span class="text-danger">*</span></label>
                                <input type="text" v-model="get_billing_info.full_name" class="form-control" id="full_name" name="full_name">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone  <span class="text-danger">*</span></label>
                                <input type="text" v-model="get_billing_info.phone" class="form-control" id="phone" name="phone">
                            </div>
                            <div class="form-group">
                                <label for="email">Email  <span class="text-danger">*</span></label>
                                <input type="email" v-model="get_billing_info.email" class="form-control" id="email" name="email">
                            </div>
                            <div class="form-group">
                                <label for="street_address">Street address  <span class="text-danger">*</span></label>
                                <textarea style="height: 70px" v-model="get_billing_info.street_address" type="text" class="form-control" id="street_address" name="street_address"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="district">District <span class="text-danger">*</span></label>
                                <input type="text" class="form-control" v-model="get_billing_info.district" id="district" name="district">
                            </div>
                            <div class="form-group">
                                <label for="order_note">Order Notes (optional)</label>
                                <textarea style="height: 70px" type="text" v-model="get_billing_info.order_note" class="form-control" id="order_note" name="order_note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <h4>Your Order</h4>
                            <br>
                            <div class="text-danger" id="cart_product"></div>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Product</th>
                                        <th class="text-end">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="item in get_carts" :key="item.id">
                                        <td>@{{ item.name }} * @{{ item.qty }}</td>
                                        <td class="text-end">৳ @{{ item.discount_price>0?item.discount_price*item.qty:item.price*item.qty }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>Subtotal</th>
                                        <th class="text-end">৳ @{{ get_sub_total }}</th>
                                    </tr>
                                </tfoot>
                            </table>
                            <br>
                            <h4>Delivery</h4>
                            <br>
                            <div>
                                <ul>
                                    <li>
                                        <label for="delivery_method" class="d-flex" style="line-height: 37px;">
                                            <input type="radio" value="from_office" checked @change="set_delivery_charge(0)" id="delivery_method" name="delivery_method" style="width: 20px;margin:0; margin-right: 10px;">
                                            বিক্রয় কেন্দ্র থেকে গ্রহন করব
                                        </label>
                                    </li>
                                    <li>
                                        <label for="delivery_method2" class="d-flex" style="line-height: 37px;">
                                            <input type="radio" value="home_delivery" @change="set_delivery_charge(60)" id="delivery_method2" name="delivery_method" style="width: 20px;margin:0; margin-right: 10px;">
                                            হোম ডেলিভারীঃ ৳ ৬০
                                        </label>
                                    </li>
                                    <li>
                                        <label for="delivery_method3" class="d-flex" style="line-height: 37px;">
                                            <input type="radio" value="sundorbon" @change="set_delivery_charge(40)" id="delivery_method3" name="delivery_method" style="width: 20px;margin:0; margin-right: 10px;">
                                            সুন্দরবনঃ  ৳ ৪০
                                        </label>
                                    </li>
                                    <li>
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>Total</th>
                                                    <th class="text-end">৳ @{{ get_total }}</th>
                                                </tr>
                                            </thead>
                                        </table>
                                    </li>
                                </ul>
                            </div>
                            <br>
                            <div>
                                <ul>
                                    <li>
                                        <label for="payment_method" class="d-flex" style="line-height: 37px;">
                                            <input type="radio" checked id="payment_method" value="bkash" @change="chech_delivery_method('bkash')" name="payment_method" style="width: 20px;margin:0; margin-right: 10px;">
                                            বিকাশ
                                            <img src="/bkash.png" alt="bikahs" style="height: 31px; margin-left: 9px;">
                                        </label>
                                        <div v-if="payment_method.name == 'bkash'">
                                            <p>
                                                প্রথমে বিকাশ payment করুন, এরপর নিচের ফরম পূরণ করুন। বিকাশ মার্চেন্ট নাম্বার: 01315373025
                                            </p>
                                            <table class="table align-middle">
                                                <tr>
                                                    <td>bKash Number</td>
                                                    <td>
                                                        <div>
                                                            <input type="text" name="payment_method_number" class="form-control mb-0" placeholder="017XXXXXXXX">
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>bKash Transaction ID</td>
                                                    <td>
                                                        <div>
                                                            <input type="text" name="payment_method_transaction_id" class="form-control mb-0" placeholder="8N7A6D5EE7M">
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </li>
                                    <li>
                                        <label for="payment_method2" class="d-flex" style="line-height: 37px;">
                                            <input type="radio" id="payment_method2" value="cash_on" @change="chech_delivery_method('cash_on')" name="payment_method" style="width: 20px;margin:0; margin-right: 10px;">
                                            ক্যাশ অন ডেলিভারি
                                        </label>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <br>
                                <button class="btn btn-success">Confirm Order</button>
                                <p>
                                    <br>
                                    Your personal data will be used to process your order, support your experience
                                    throughout this website, and for other purposes described in our privacy policy.
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </form>
    </div>
</section>

@push('cjs')
    <style>
        .form-control{
            margin-bottom: 0;
        }
        .form-group{
            margin-bottom: 20px;
        }
    </style>
@endpush
@endsection
