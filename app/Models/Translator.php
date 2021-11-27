<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Translator extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'total_book',
    ];

    public function getTotalBookAttribute()
    {
        $writer_total_book = DB::table('product_translator')->where('translator_id',$this->id)->count();
        return $writer_total_book;
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }
}
