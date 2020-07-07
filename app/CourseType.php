<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseType extends Model
{
    protected $table="course_types";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type',
        'online_exam_period',
        'points',
    ];

    public function course(){
        return $this->belongsTo("App\Course");
    }

    public function couseType_variations(){
        return $this->hasMany("App\CourseTypeVariation","coursetype_id");
    }

    public function getDiscount($quantity){
        $discount = $this->course->courseDiscounts()->where('type', 'like', '%'.$this->type.'%')
            ->where("num_students",$quantity)->first();
        if(!empty($discount))
            return $discount->discount;
        else
            return 0;
    }

}
   
