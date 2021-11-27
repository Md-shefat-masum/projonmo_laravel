<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        'discount_price',
        'formated_date',
        'reviews',
        'review_count'
    ];

    public function getFormatedDateAttribute()
    {
        if (isset($this->created_at)) {
            $formated_date = [
                'date' => Carbon::parse($this->created_at)->format('d M, Y'),
                'date_time' => Carbon::parse($this->created_at)->format('d,M Y h:i:s'),
                'date_time2' => Carbon::parse($this->created_at)->format('d,M Y h:i:s a'),
                'date_time3' => Carbon::parse($this->created_at)->format('d,F Y h:i:s a'),
                'date_time4' => Carbon::parse($this->created_at)->format('F Y'),
                'date_time5' => Carbon::parse($this->created_at)->diffForHumans(),
                'date_time6' => Carbon::parse($this->created_at)->format('Y/m/d'),
            ];
        } else {
            $formated_date = [
                'date' => null,
                'date_time' => null,
                'date_time2' => null,
                'date_time3' => null,
                'date_time4' => null,
                'date_time5' => null,
            ];
        }

        return $formated_date;
    }

    public function getDiscountPriceAttribute()
    {
        $today_date = Carbon::now()->format('Y-m-d');
        if ($this->expiration_date >= $today_date) {
            $discount_price = $this->price - ($this->price * ($this->discount / 100));
            return $this->attributes['discount_price'] = ceil($discount_price);
        } else {
            return 0;
        }
    }

    public function getReviewsAttribute()
    {
        $avg_sum = 0;
        $one_star = (int)ProductComment::where('product_id', $this->id)->where('ratting', 1)->sum('ratting');
        $avg_sum += $one_star * 1;

        $two_star = (int)ProductComment::where('product_id', $this->id)->where('ratting', 2)->sum('ratting');
        $avg_sum += $two_star * 2;

        $three_star = (int)ProductComment::where('product_id', $this->id)->where('ratting', 3)->sum('ratting');
        $avg_sum += $three_star * 3;

        $four_star = (int)ProductComment::where('product_id', $this->id)->where('ratting', 4)->sum('ratting');
        $avg_sum += $four_star * 4;

        $five_star = (int)ProductComment::where('product_id', $this->id)->where('ratting', 5)->sum('ratting');
        $avg_sum += $five_star * 5;

        $review_sum = $one_star + $two_star + $three_star + $four_star + $five_star;
        // $review_count = ProductComment::where('product_id',$this->id)->count();
        // dd($avg_sum , $review_sum,  $avg_sum / (int)$review_sum);

        if ($avg_sum > 0 && $review_sum > 0)
            return [
                'total_review' => round($avg_sum / (int)$review_sum, 1),
                'one_star' => (int) ProductComment::where('product_id', $this->id)->where('ratting', 1)->count(),
                'two_star' => (int) ProductComment::where('product_id', $this->id)->where('ratting', 2)->count(),
                'three_star' => (int) ProductComment::where('product_id', $this->id)->where('ratting', 3)->count(),
                'four_star' => (int) ProductComment::where('product_id', $this->id)->where('ratting', 4)->count(),
                'five_star' => (int) ProductComment::where('product_id', $this->id)->where('ratting', 5)->count(),
                'total_count' => (int) ProductComment::where('product_id', $this->id)->count(),
            ];
        else
            return [
                'total_review' => 0,
                'one_star' => 0,
                'two_star' => 0,
                'three_star' => 0,
                'four_star' => 0,
                'five_star' => 0,
            ];
    }
    public function getReviewCountAttribute()
    {
        $review_count = ProductComment::where('product_id', $this->id)->count();
        return $review_count;
    }

    // public function getDiscountAttribute($value)
    // {
    //     dd($value);
    //     $this->attributes['discount'] = 500;
    //     // $this->attributes['first_name'] = strtolower($value);
    // }

    public static function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    public function status()
    {
        return $this->belongsTo('App\Models\Status', 'status', 'serial');
    }

    public function brand_info()
    {
        return $this->belongsTo('App\Models\Brand', 'brand_id');
    }

    public function creator_info()
    {
        return $this->belongsTo('App\Models\User', 'creator');
    }

    public function category()
    {
        return $this->belongsToMany('App\Models\Category')->withTimestamps();
    }

    public function sub_category()
    {
        return $this->belongsToMany('App\Models\SubCategory')->withTimestamps();
    }

    public function main_category()
    {
        return $this->belongsToMany('App\Models\MainCategory')->withTimestamps();
    }

    public function color()
    {
        return $this->belongsToMany('App\Models\Color')->withTimestamps();
    }

    public function image()
    {
        return $this->belongsToMany('App\Models\Image')->withTimestamps();
    }

    public function publication()
    {
        return $this->belongsToMany('App\Models\Publication')->withTimestamps();
    }

    public function size()
    {
        return $this->belongsToMany('App\Models\Size')->withTimestamps();
    }

    public function filter_by_size()
    {
        return $this->belongsToMany('App\Models\Size')->wherePivot('size_id', 1);
    }

    public function unit()
    {
        return $this->belongsToMany('App\Models\Unit')->withTimestamps();
    }

    public function vendor()
    {
        return $this->belongsToMany('App\Models\Vendor')->withTimestamps();
    }

    public function writer()
    {
        return $this->belongsToMany('App\Models\Writer')->withTimestamps();
    }

    public function translator()
    {
        return $this->belongsToMany('App\Models\Translator')->withTimestamps();
    }
}
