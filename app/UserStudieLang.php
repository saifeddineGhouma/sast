<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserStudieLang extends Model
{
    protected $table = "users_studiesLang";
    protected $fillable = [
        'user_id',
        'lang_stud'
    ];

    public function user()
    {
        return $this->belongsTo("App\User");
    }
}
