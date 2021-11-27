<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CommonController extends Controller
{
    public static function get_order_status($status)
    {
        if($status <= 2 ){
            return '<span class="badge bg-primary">pending</span>';
        }
        else if($status == 3){
            return '<span class="badge bg-secondary">accepted</span>';
        }
        else if($status == 4){
            return '<span class="badge bg-success">processing</span>';
        }
        else if($status == 5){
            return '<span class="badge bg-warning">delivered</span>';
        }
        else if($status == 6){
            return '<span class="badge bg-danger">canceled</span>';
        }else{
            return '';
        }
    }
}
