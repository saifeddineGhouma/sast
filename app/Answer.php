<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name_ar',
        'name_en'
    ];


    public function question(){
        return $this->belongsTo("App\Question","question_id");
    }

	

}
   
