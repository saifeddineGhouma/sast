<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryTranslation extends Model
{
    protected $table="categories_translations";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'slug',
        'short_description',
        'content',
        'meta_title',
        'meta_keyword',
        'meta_description',
    ];

    public function fillByLang($request,$lang){

        foreach(self::getFillable() as $property){
            if($request->has($lang."_".$property))
                $this->$property = $request->get($lang."_".$property);
        }
        $this->lang = $lang;
    }
}
   
