<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Size extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function related_products()
    {
        return $this->belongsToMany('App\Models\Product');
    }

}
