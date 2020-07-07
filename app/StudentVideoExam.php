<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class StudentVideoExam extends Model
{
    protected $table="students_videoexams";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

        'status',
        'manager_message',
        'user_message',
        'website_message'
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
        $query = self::select('id','student_id','course_id',DB::raw("'video' as type"),'videoexam_id as exam_id'
            ,'video_exam_name as exam_name','course_name','status','created_at');

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
                if (!in_array("video", $types)) {
                    $query->where('videoexam_id', -1);
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

    public function videoexam(){
        return $this->belongsTo("App\VideoExam","videoexam_id")->withDefault();
    }

    public function course(){
        return $this->belongsTo("App\Course","course_id")->withDefault();
    }

}
   
