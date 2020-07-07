<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    protected $table="course_questions";

    public function course(){
        return $this->belongsTo("App\Course");
    }
    
    public function replies(){
        return $this->hasMany("\App\CourseQuestion","parent_id");
    }

    public function user(){
        return $this->belongsTo("App\User");
    }

    public function admin(){
        return $this->belongsTo("App\Admin");
    }

    function getStatus($datafiled,$dataid){
        $span = '';
        $id = '';
        if ($datafiled==1) {
            $span = '<span class="label label-sm label-success"> active </span>';
            $id = 'on-'.$dataid;
        } else {
            $span = '<span class="label label-sm label-danger"> inactive </span>';
            $id = 'off-'.$dataid;
        }

        return '<a style="cursor: pointer;" class="activeIcon" data-id="'.$id.'"> '.$span.' </a>';
    }
}
   
