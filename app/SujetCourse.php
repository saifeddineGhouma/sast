<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SujetCourse extends Model
{
   
    protected $table = "sujets_courses";

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
        $query = self::filter($request);
        return $query;
    }

    public function student()
    {
        return $this->belongsTo("App\Student");
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
