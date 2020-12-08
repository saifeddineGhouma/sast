<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentStudyCase extends Model
{
   
    protected $table = "students_study_case";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    /*    protected $fillable = [

        'status',
        'manager_message',
        'user_message',
        'website_message'
    ]; */



    /**
     * Get all items.
     *
     * @return collect
     */
    public static function getAll()
    {
        return self::select('*');
    }

    /**
     * Filter items.
     *
     * @return collect
     */
    public static function filter($request)
    {
        
    }

    /**
     * Search items.
     *
     * @return collect
     */
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
            $query=  $query->whereIn('students_id',$IDstudents)    ; 
          } 
       
        return $query;

    }
  public function user()
    {
        return $this->belongsTo("App\User");
    }
    public function student()
    {
        return $this->belongsTo("App\Student",'students_id');
    }

    public function Sujet()
    {
        return $this->belongsTo("App\Sujet", "sujets_id")->withDefault();
    }

    public function course()
    {
        return $this->belongsTo("App\Course", "courses_id")->withDefault();
    }


}
