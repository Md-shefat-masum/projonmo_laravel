<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function replies()
    {
        return $this->hasMany(BlogComment::class,'parent','id');
    }

    public function blog()
    {
        return $this->belongsTo(Blog::class,'blog_id');
    }
}
