<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionTranslation extends Model
{
    protected $table="questions_translations";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question'
    ];

    public function fillByLang($request,$lang){

        foreach(self::getFillable() as $property){
            if($request->has($lang."_".$property))
                $this->$property = $request->get($lang."_".$property);
        }
        $this->lang = $lang;
    }
}
   
