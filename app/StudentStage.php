<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB ;
use App\User ;
class StudentStage extends Model
{
    protected $table = "students_stage";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'course_id',
        'user_id',
        'demande_stage',
        'evaluation_stage',
        'valider'
    ];
     public static function getAll()
    {
        return self::select('*');
    }
    public static function filter($request)
    {
        $query = self::select('id','user_id','course_id',DB::raw("'stage' as type")
          , 'id','id','id','id','created_at');

        $parts = parse_url($request->extra);
        parse_str($parts['path'], $request1);

        if($request1['student_id']!=0){
            $query = $query->where("student_id",$request1['student_id']);
        }

        if($request1['course_id']!=0){
            $query = $query->where("course_id",$request1['course_id']);
        }

        if(isset($request1['types'])) {
            
            $types = $request1['types'];
            if (!empty($types)) {
                if (!in_array("stage", $types)) {
                    $query->where('stage_id', -1);
                }
            }
        }



        if(isset($request1['status'])) {
            $statusData = $request1['status'];
            if (!empty($statusData)) {
                $query->where(function ($query1) use ($statusData) {
                    $i = 0;
                    foreach ($statusData as $status) {
                        if ($i == 0)
                            $query1 = $query1->where('status', $status);
                        else
                            $query1 = $query1->orWhere('status', $status);
                        $i++;
                    }
                    return $query1;
                });

            }
        }

        if(!empty($request1['created_at'])){
            $created_at =  date("y-m-d",strtotime($request1['created_at']));
            $query = $query->where(DB::raw("DATE(created_at)"),$created_at);
        }
        return $query;
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
            $query=  $query->whereIn('user_id',$IDstudents)    ; 
          } 
       
        return $query;
    }

    public function course()
    {
        return $this->belongsTo("App\Course",'course_id');
    }
    public function user()
    {
        return $this->belongsTo( "App\User" , 'user_id' );
    }
  
    public function downloadDemandeStage($file)
    {
            //return response()->download('uploads/kcfinder/upload/image/stage/جدول تقييم المتدرب.pdf');


        return response()->download($file);
      
    }
}
