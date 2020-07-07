<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'points',
        'image',
        'sort_order'
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
            'ar_question' => 'required',
            'en_question' => 'required'
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
        $query = self::select('questions.*');
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

	public function question_trans($lang){
		return $this->hasMany("App\QuestionTranslation","question_id")->where("lang",$lang)->first();
	}

	public function quiz(){
	    return $this->belongsTo("App\Quiz","quiz_id");
    }

    public function answers(){
	    return $this->hasMany("App\Answer","question_id");
    }

}
   
