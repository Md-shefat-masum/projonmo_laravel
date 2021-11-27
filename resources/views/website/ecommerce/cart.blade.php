@extends('website.ecommerce.layouts.ecommerce')
@section('content')

<section class="py-2 my-lg-5" id="product_lists">
    <div class="container">
        <div class="row">
            <div class="cart-table table-responsive">
                <table class="table-bordered table text-center align-middle">
                    <thead>
                        <tr>
                            <th class="p-action" style="text-align: center;width: 115px;">বাতিল করুন</th>
                            <th class="p-image" style="text-align: center;width: 115px;">পণ্য</th>
                            <th class="p-name" style="text-align: center;">নাম</th>
                            <th class="p-amount" style="text-align: center;width: 135px;">মূল্য</th>
                            <th class="p-quantity" style="text-align: center;width:120px;">পরিমাণ</th>
                            <th class="p-total" style="text-align: right;width: 150px;">সর্বমোট</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="item in get_carts" :key="item.id">
                            <td class="p-action">
                                <a href="#" @click.prevent="remove_from_carts(item)"><i class="fa fa-times"></i></a>
                            </td>
                            <td class="p-image">
                                <a :href="`/product-details/${item.id}`">
                                    <img alt="" style="height: 80px;" :src="`/${item.product.thumb_image}`" />
                                </a>
                            </td>
                            <td class="p-name">
                                <a :href="`/product-details/${item.id}`" style="font-size: 18px;">@{{ item.name }}</a>
                            </td>
                            <td class="p-amount">
                                <span class="amount">৳ @{{ item.discount_price>0?item.discount_price:item.price }}</span>
                            </td>
                            <td class="p-quantity">
                                <form action="#" method="get">
                                    <input min="1" name="qty" class="text-end mb-0"
                                    @keyup="change_cart_qty({
                                            product_id: item.id,
                                            qty: parseInt($event.target.value),
                                        })"
                                    @change="change_cart_qty({
                                            product_id: item.id,
                                            qty: parseInt($event.target.value),
                                        })"
                                    :value="item.qty" type="number" />
                                </form>
                            </td>
                            <td class="p-total text-end">৳ @{{ item.discount_price>0?item.discount_price*item.qty:item.price*item.qty }}</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr style="border-bottom: 0;">
                            <td colspan="4" class="border-0"></td>
                            <td class="text-end border-0"><b>Subtotal</b></td>
                            <td class="text-end border-0"><b>৳ @{{ get_sub_total }}</b></td>
                        </tr>
                        <tr class="border-0">
                            <td colspan="6" class="border-0 bottom-0 py-3"></td>
                        </tr>
                        <tr class="border-bottom-0">
                            <td colspan="6" class="text-end border-0">
                                <a href="{{ route('website_checkout') }}" class="btn btn-success">Proceed to checkout</a>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                {{-- cashon
                home delivery = 70 /-
                sundorbon = 40/-

                bikash:
                cashon: --}}
            </div>
        </div>
    </div>
</section>

@endsection
