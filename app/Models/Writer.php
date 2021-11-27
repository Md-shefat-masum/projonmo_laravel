<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Writer extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $appends = [
        'total_book',
    ];

    public function getTotalBookAttribute()
    {
        $writer = Writer::where('id',$this->id)->first();
        // $writer_total_book = DB::table('product_writer')->where('writer_id',$this->id)->count();
        return $writer->products()->where('status',1)->count();
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
