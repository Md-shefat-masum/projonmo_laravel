<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;

    protected $appends=[
        // 'formated_date',
    ];

    protected $guarded = [];

    public function user_info()
    {
        return $this->belongsTo('App\Models\User','user_id','id');
    }
}
