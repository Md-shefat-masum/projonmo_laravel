<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogCategory extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function child()
    {
        return $this->hasMany(BlogCategory::class,'parent_id','id');
    }

    public function blogs()
    {
        return $this->belongsToMany(Blog::class)->withTimestamps();
    }
}
