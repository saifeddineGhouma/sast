<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User ;
class CourseSpecial extends Model
{
	protected $table = "courses_special";

	public function course(){
        return $this->belongsTo("App\Course","course_id");
    }

    public function student(){
        return $this->belongsTo("App\Student","student_id");
    }

    public static function search($request)
    {
        $query = self::select('*');

        if(isset($request->course_id))
          $query=  $query->where('course_id',$request->course_id);
        if(isset($request->student_id))
          {
            $IDstudents = User::where('full_name_ar','like','%'.$request->student_id.'%')
                                ->orWhere('full_name_en','like','%'.$request->student_id.'%')
                                ->orWhere('username','like','%'.$request->student_id.'%')
                                ->orWhere('email','like','%'.$request->student_id.'%')
                                ->pluck('id');
            $query=  $query->whereIn('student_id',$IDstudents)  ; 
          } 
       
        return $query;
    }

   
}
   
