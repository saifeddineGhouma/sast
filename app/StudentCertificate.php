<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentCertificate extends Model
{
    protected $table = "students_certificates";


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
        $query = self::select('students_certificates.*');
        return $query;
    }

    /**
     * Search items.
     *
     * @return collect
     */
    public static function search($request)
    {
        $parts = parse_url($request->extra);
        parse_str($parts['path'], $request1);

        //for order the table
        if(isset($request1['manual'])){
            if($request1['manual']) {
                $columns = array("", "", "", "","serialnumber","", "created_at");
            }else{
                $columns = array("", "", "", "", "", "serialnumber", "created_at");
            }
        }else{
            $columns = array("", "", "", "","serialnumber", "created_at");
        }

        $query = self::filter($request);

        $order = $request->get("order");
        $column1 = $columns[$order[0]['column']];
        if($column1 !="")
            $studentExams = $query->orderBy($columns[$order[0]['column']],$order[0]['dir']);

        return $query;
    }

    public function exam(){
        return $this->belongsTo("App\Quiz","exam_id");
    }

    public function course(){
        return $this->belongsTo("App\Course","course_id");
    }

    public function student(){
        return $this->belongsTo("App\Student","student_id");
    }

    function getStatus($datafiled,$dataid){
        $span = '';
        $id = '';
        if ($datafiled==1) {
            $span = '<span class="label label-sm label-success"> active </span>';
            $id = 'on-'.$dataid;
			$linksend="<a href='/admin/students-certificates/sendmail/".$dataid."'><span class='label label-sm label-primary'>Send certificate</a>";
        } else {
            $span = '<span class="label label-sm label-danger"> inactive </span>';
            $id = 'off-'.$dataid;
			$linksend="";
        }

        return '<a style="cursor: pointer;" class="activeIcon" data-id="'.$id.'"> '.$span.' </a> &nbsp;&nbsp; '.$linksend;
    }

}
   
