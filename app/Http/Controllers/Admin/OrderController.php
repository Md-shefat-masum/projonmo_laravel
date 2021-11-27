<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function orders()
    {
        return view('admin.order.index');
    }

    public function all_orders(Request $request)
    {
        if($request->has('type') && $request->type == "pending"){
            $orders = Order::where('status','<=',2)->orderBy('id','DESC')->paginate(10);
        }
        else if($request->has('type') && $request->type == "accepted"){
            $orders = Order::where('status',3)->orderBy('id','DESC')->paginate(10);
        }
        else if($request->has('type') && $request->type == "processing"){
            $orders = Order::where('status',4)->orderBy('id','DESC')->paginate(10);
        }
        else if($request->has('type') && $request->type == "delivered"){
            $orders = Order::where('status',5)->orderBy('id','DESC')->paginate(10);
        }
        else if($request->has('type') && $request->type == "canceled"){
            $orders = Order::where('status',6)->orderBy('id','DESC')->paginate(10);
        }
        else if($request->has('search')){
            $key = $request->search;
            $orders = Order::where('email',$key)
                            ->orWhere('phone',$key)
                            ->orWhere('full_name',$key)
                            ->orWhere('payment_number',$key)
                            ->orWhere('payment_code',$key)
                            ->orWhere('invoice_id',$key)
                            ->orWhere('subtotal',$key)
                            ->orWhere('total',$key)

                            ->orWhere('email','LIKE','%'.$key.'%')
                            ->orWhere('phone','LIKE','%'.$key.'%')
                            ->orWhere('full_name','LIKE','%'.$key.'%')
                            ->orWhere('payment_number','LIKE','%'.$key.'%')
                            ->orWhere('payment_code','LIKE','%'.$key.'%')
                            ->orWhere('invoice_id','LIKE','%'.$key.'%')
                            ->orWhere('subtotal','LIKE','%'.$key.'%')
                            ->orWhere('total','LIKE','%'.$key.'%')

                            ->orderBy('id','DESC')->paginate(10);
        }
        else{
            $orders = Order::orderBy('id','DESC')->paginate(10);
        }
        return $orders;
    }

    public function show($slug,Request $request)
    {
        $order = Order::where('slug',$slug)->first();
        return view('admin.order.show',compact('order'));
    }

    public function change_status(Request $request)
    {
        $order = Order::find($request->id);
        if($order){
            $order->status = $request->status;
            $order->save();
            return response()->json([
                'status' => $request->status,
                'index' => $request->index,
            ]);
        }else{
            return response()->json([
                'status' => 0,
                'index' => 0,
            ]);
        }
    }
}
