<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class CourseTypeDevise extends Model
{
    protected $table="coursetype_devise";
    public $timestamps = false;


    public function courseType(){
        return $this->belongsTo("App\CourseType","coursetype_id");
    }
}
   
