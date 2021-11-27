@extends('admin.layouts.admin') @section('content')

<div class="content-wrapper" id="order_list">
    <div class="container-fluid">
        @include('admin.includes.bread_cumb',['title'=>'All'])
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div id="invoice">
                            <div class="toolbar hidden-print">
                                <div class="text-end">
                                    <button type="button" id="print" class="btn btn-dark"><i class="fa fa-print"></i> Print</button>
                                </div>
                                <hr />
                            </div>
                            <div class="invoice overflow-auto printableArea" >
                                <div style="min-width: 600px;">
                                    <header>
                                        <div class="row">
                                            <div class="col">
                                                <a href="javascript:;">
                                                    <img src="/logo.png" height="80" alt="logo" />
                                                </a>
                                            </div>
                                            <div class="col company-details">
                                                <h2 class="name">
                                                    <a target="_blank" href="javascript:;">
                                                        প্রচ্ছদ প্রকাশনী
                                                    </a>
                                                </h2>
                                                <div>মাদ্রাসা মার্কেট (২য় তলা</div>
                                                <div>৩৪ নর্থব্রুক হল রোড, বাংলাবাজার, ঢাকা।</div>
                                                <div>01781172026</div>
                                                <div>proccodprokashon@gmail.com</div>
                                            </div>
                                        </div>
                                    </header>
                                    <main>
                                        <div class="row contacts">
                                            <div class="col invoice-to">
                                                <div class="text-gray-light">INVOICE TO:</div>
                                                <div class="address">{{ $order->full_name }}</div>
                                                <div class="address">{{ $order->phone }}</div>
                                                <div class="address">{{ $order->email }}</div>
                                                <div class="address">{{ $order->billing_details_json->street_address }}</div>
                                                <div class="address">{{ $order->billing_details_json->district }}</div>
                                            </div>
                                            <div class="col invoice-details">
                                                <h4 class="invoice-id">INVOICE {{ $order->invoice_id }}</h4>
                                                <div class="date">Date of Invoice: {{ $order->created_at->format('d-M-Y') }}</div>
                                            </div>
                                        </div>
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th class="text-left">DESCRIPTION</th>
                                                    <th class="text-right">PRICE</th>
                                                    <th class="text-right">QTY</th>
                                                    <th class="text-right">TOTAL</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($order->order_details_json as $key=>$item)
                                                    <tr>
                                                        <td class="no">{{ $key+1 }}</td>
                                                        <td class="text-left">
                                                            <h3>{{ $item->name }}</h3>
                                                        </td>
                                                        <td class="unit">৳ {{ $item->price }}</td>
                                                        <td class="qty">{{ $item->qty }}</td>
                                                        <td class="total">৳ {{ $item->price * $item->qty }}</td>
                                                    </tr>
                                                @endforeach


                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2">SUBTOTAL</td>
                                                    <td>৳ {{ $order->subtotal }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2">GRAND TOTAL</td>
                                                    <td>৳ {{ $order->total }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2">Delivery Method</td>
                                                    <td>{{ $order->delivery_method }}</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2"></td>
                                                    <td colspan="2">Payment Method</td>
                                                    <td>{{ $order->payment_method }}</td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        {{-- <div class="thanks">Thank you!</div> --}}
                                        <div class="notices">
                                            <table class="w-25">
                                                <tr>
                                                    <th>Delivery Method</th>
                                                    <td style="width: 3px">:</td>
                                                    <td>{{ $order->delivery_method }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Method</th>
                                                    <td>:</td>
                                                    <td>{{ $order->payment_method }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Number</th>
                                                    <td>:</td>
                                                    <td>{{ $order->payment_number }}</td>
                                                </tr>
                                                <tr>
                                                    <th>Payment Code</th>
                                                    <td>:</td>
                                                    <td>{{ $order->payment_code }}</td>
                                                </tr>
                                            </table>
                                        </div>
                                        <div class="notices">
                                            {!! nl2br($order->billing_details_json->order_note)  !!}
                                        </div>
                                    </main>
                                    {{-- <footer>Invoice was created on a computer and is valid without the signature and seal.</footer> --}}
                                </div>
                                <!--DO NOT DELETE THIS div. IT is responsible for showing footer always at the bottom-->
                                <div></div>
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
