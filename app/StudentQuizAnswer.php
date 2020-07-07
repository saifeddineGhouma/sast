<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentQuizAnswer extends Model
{
    protected $table="studentquiz_answers";
    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'question',
        'given_answer',
        'correct_answer'
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
        $query = self::select('studentquiz_answers.*');
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

    public function studentquiz(){
        return $this->belongsTo("App\StudentQuiz","studentquiz_id");
    }

}
   
