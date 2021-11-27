<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = [
        'formated_date',
    ];

    public function getFormatedDateAttribute()
    {
        if (isset($this->created_at)) {
            $formated_date = [
                'date' => Carbon::parse($this->created_at)->format('d M, Y'),
                'day' => Carbon::parse($this->created_at)->format('d'),
                'month' => Carbon::parse($this->created_at)->format('M'),
                'date_time' => Carbon::parse($this->created_at)->format('d,M Y h:i:s'),
                'date_time2' => Carbon::parse($this->created_at)->format('d,M Y h:i:s a'),
                'date_time3' => Carbon::parse($this->created_at)->format('d,F Y h:i:s a'),
                'date_time4' => Carbon::parse($this->created_at)->format('F Y'),
                'date_time5' => Carbon::parse($this->created_at)->diffForHumans(),
                'date_time6' => Carbon::parse($this->created_at)->format('Y/m/d'),
                'date_time7' => Carbon::parse($this->created_at)->format('M d, Y'),
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

    public function categories()
    {
        return $this->belongsToMany(BlogCategory::class)->withTimestamps();
    }
    public function author()
    {
        return $this->belongsTo(User::class,'creator');
    }
}
