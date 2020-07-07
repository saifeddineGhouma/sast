<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class StudentQuiz extends Model
{
    protected $table="students_quizzes";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'student_id',
        'quiz_id',
        'course_id',
        'quiz_name',
        'course_name'
    ];



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
        $currentTime = date("Y-m-d H:i:s");
        $query = self::where("stoptime","<=",$currentTime)->select('id','student_id','course_id',DB::raw("IF(is_exam, 'exam', 'quiz') as type"),'quiz_id as exam_id'
            ,'quiz_name as exam_name','course_name','status','created_at');

        $parts = parse_url($request->extra);
        parse_str($parts['path'], $request1);

        if($request1['student_id']!=0){
            $query = $query->where("student_id",$request1['student_id']);
        }

        if($request1['course_id']!=0){
            $query = $query->where("course_id",$request1['course_id']);
        }
        if(isset($request1['types'])){
            $types = $request1['types'];
                if(!empty($types)) {
                    if(in_array("video",$types) && count($types)==1){
                        $query->where('is_exam',-1);
                    }else{
                        $query->where(function($query1) use ($types){
                            $i=0;
                            foreach ($types as $type ) {
                                if($type != "video"){
                                    $is_exam = 0;
                                    if($type=="exam")
                                        $is_exam = 1;
                                    if($i == 0)
                                        $query1 = $query1->where('is_exam',$is_exam);
                                    else
                                        $query1 = $query1->orWhere('is_exam',$is_exam);
                                    $i++;
                                }
                            }
                            return $query1;
                        });
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

    /**
     * Search items.
     *
     * @return collect
     */
    public static function search($request)
    {
        $query = self::filter($request);

        return $query;
    }

    public function student(){
        return $this->belongsTo("App\Student");
    }

    public function quiz(){
        return $this->belongsTo("App\Quiz","quiz_id")->withDefault();
    }

    public function course(){
        return $this->belongsTo("App\Course","course_id")->withDefault();
    }

    public function answers(){
        return $this->hasMany("App\StudentQuizAnswer","studentquiz_id");
    }

}
   
