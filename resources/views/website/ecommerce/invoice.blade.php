@extends('website.ecommerce.layouts.ecommerce')
@section('content')

<section class="py-2 my-lg-5" id="product_lists">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h4 style="font-size: 25px;text-align: center;margin-bottom: 30px;">জাযাকাল্লাহ খাইরান, আপনার অর্ডার'টি সম্পূর্ণ হয়েছে</h4>
            </div>
        </div>
        <div class="card card-body printableArea" style="border: 1px solid rgb(241, 241, 241); padding: 15px;">
            <h3><b>INVOICE</b> <span class="pull-right">#{{$order->invoice_id}}</span></h3>
            <hr />
            <div class="row">
                <div class="col-md-12 d-flex justify-content-between">
                    <div class="float-left">
                        <address>
                            <h3>&nbsp;<b style=" font-size: 44px;color: var(--brand2);">প্রচ্ছদ প্রকাশন</b></h3>
                            <p class="text-muted m-l-5">
                                <br />
                                মাদরাসা মার্কেট (২য় তলা),  <br>
                                ৩৪, নর্থব্রুক হল রোড, বাংলাবাজার, ঢাকা-১১০০ <br />
                                +880 1781172026 <br />
                                prossodprokashon@gmail.com
                            </p>
                        </address>
                    </div>
                    <div class="float-right text-end">
                        <address>
                            <h3>To,</h3>
                            <h4 class="font-bold">{{ $order->full_name }}</h4>
                            <p class="text-muted m-l-30">
                                {{ $order->email }}<br />
                                {{ $order->phone }}<br />
                                {!! $order->billing_details_json->street_address !!}<br />
                                {{ $order->billing_details_json->district }}
                            </p>
                            <p class="m-t-30">
                                <b>Invoice Date : </b><br />
                                <i class="fa fa-calendar"></i> {{ $order->created_at->format('d M,Y') }}
                            </p>
                        </address>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive m-t-40" style="clear: both;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Description</th>
                                    <th class="text-center">Quantity</th>
                                    <th class="text-center">Unit Cost</th>
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($order->order_details_json as $key=>$item)
                                    <tr>
                                        <td class="text-center">{{ $key+1 }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td class="text-center">{{ $item->qty }}</td>
                                        <td class="text-center">৳ {{ number_format($item->price) }}</td>
                                        <td class="text-end">৳ {{ number_format($item->qty * $item->price) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="pull-right m-t-30 text-end">
                        <p style="padding-right: 7px;"><b>Subtotal Amount: ৳ {{ number_format($order->subtotal) }}</b></p>
                        <hr />
                        <h3><b>Total :</b> ৳ {{ number_format($order->total) }}</h3>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-end pt-4">
                <button id="print" class="btn btn-success" type="button">
                    <span><i class="fa fa-print"></i> Print</span>
                </button>
            </div>
        </div>

    </div>
</section>

@push('cjs')
    <script src="/contents/admin/js/print.js" type="text/JavaScript"></script>
    <script>
        $(document).ready(function() {
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printableArea").printArea(options);
            });
        });
    </script>
@endpush
@endsection
