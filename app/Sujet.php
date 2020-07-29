<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sujet extends Model
{

    protected $table="sujets";
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
        $query = self::select('sujets.*');
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

	

    public function courses(){
        return $this->belongsToMany("App\Course","sujtes_courses","sujets_id","course_id");
    }

  


}
   
