<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsView extends Model
{
     protected $table="news_views";
	 public $timestamps=false;
	 
	 public static function boot()
     {
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
     }
}
