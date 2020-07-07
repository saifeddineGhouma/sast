<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoExam extends Model
{

    protected $table="video_exams";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [

    ];

    /**
     * The rules for validation.
     *
     * @var array
     */
    public function rules()
    {
        $id = $this->id;
        if(empty($id))
            $id=0;
        return array(
            'ar_slug' => 'required|unique:videoexams_translations,slug,'.$id.',videoexam_id',
            'en_slug' => 'required|unique:videoexams_translations,slug,'.$id.',videoexam_id',
        );
    }

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
        $query = self::select('video_exams.*');
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

        if (!empty($request->sort_order)) {
            $query = $query->orderBy($request->sort_order);
        }

        return $query;
    }

	public function videoexam_trans($lang){
		return $this->hasMany("App\VideoExamTranslation","videoexam_id")->where("lang",$lang)->first();
	}

    public function courses(){
        return $this->belongsToMany("App\Course","courses_videoexams","videoexam_id","course_id");
    }

    public function courses_exams(){
        return $this->hasMany("App\CourseVideoExam","videoexam_id");
    }

    public static function showVideo($video){
        if (strpos($video, 'youtube') !== false) {
            $videoId = preg_replace("#.*youtube\.com/watch\?v=#","",$video);
            return '<iframe width="560" height="315" src="https://www.youtube.com/embed/'.$videoId.'" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>';
        }elseif(strpos($video, 'http') !== false){
            return $video;
        }else{
            return '<embed src="'.asset("uploads/kcfinder/upload/file/".$video).'" width="600" height="400" scale="aspect" controller="true">';
        }
    }
}
   
