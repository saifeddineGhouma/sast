<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Auth;

class Quiz extends Model
{


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'duration',
        'pass_mark',
        'num_questions',
        'price'
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
            'ar_name' => 'required',
            'ar_slug' => 'required|unique:quizzes_translations,slug,'.$id.',quiz_id',
            'en_slug' => 'required|unique:quizzes_translations,slug,'.$id.',quiz_id',
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
        $query = self::select('quizzes.*');
        if(!empty($request->exam))
            $query->where("is_exam",$request->exam);
        else
            $query->where("is_exam",0);
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

	public function quiz_trans($lang){
		return $this->hasMany("App\QuizTranslation","quiz_id")->where("lang",$lang)->first();
	}

	public function quiz_transes(){
        return $this->hasMany("App\QuizTranslation","quiz_id");
    }

	public function questions(){
	    return $this->hasMany("App\Question","quiz_id");
    }

    public function students_quizzes(){
        return $this->hasMany("App\StudentQuiz","quiz_id");
    }

    public function totalQuestionMarks(){
	    $total = 0;
	    $finalMark = $this->questions()->select(DB::raw("sum(questions.points) as sumPoints"),"questions.quiz_id")
            ->groupBy("questions.quiz_id")->first();
	    if(!empty($finalMark))
            $total = $finalMark->sumPoints;
	    return $total;
    }

    public function isExpired($course){
        $expired = false;
        if(Auth::check()){
            $user = Auth::user();
            $student = $user->student;
            $isRegistered = $course->isRegistered();
            if($isRegistered) {
				
                $paidOrder_ids = \App\Order::join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
                    ->where(function ($query) {
                     $query->where("order_onlinepayments.payment_status", "paid")
                           ->orWhere("order_onlinepayments.engaged", "engaged");
                })
                    ->groupBy("orders.id", "orders.total")
                    ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
                    ->pluck("orders.id")->all();
                $period = $course->exam_period;
                if ($period > 0) {
                    $now = date("Y-m-d");
                    $before = date("Y-m-d", strtotime('-' . $period . ' day', strtotime($now)));
					$beforePack = date("Y-m-d", strtotime("- 6 months" . "+1 day", strtotime($now)));

					$orders = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
                        ->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
						->join("packs", "order_products.pack_id", "=", "packs.id")
                        ->where("student_id", Auth::user()->id)
                        ->where("packs.cours_id1", $course->id)
                        ->whereIn("orders.id", $paidOrder_ids)
                        ->where(DB::raw("DATE(orders.created_at)"), ">=", $beforePack)->first();
					if (isset($orders)) {
				
						$order = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
							->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
							->where("student_id", Auth::user()->id)
							->where("order_products.pack_id", $orders->pack_id)
							->whereIn("orders.id", $paidOrder_ids)
							->where(DB::raw("DATE(created_at)"), ">=", $beforePack)->first();

						if (empty($order)) {
							//echo "Afeff";
							$expired = true;
							$successFinal_ids = $student->student_quizzes()->where("course_id", $orders->cours_id1)
								->where("is_exam", 1)->where("successfull", 1)->pluck("quiz_id")->all();
								
							$quizOrder = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
								->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
								->where("student_id", Auth::user()->id)
								->where("order_products.quiz_id", $this->id)
								->whereIn("orders.id", $paidOrder_ids)->first();
							if (!empty($quizOrder))
								$expired = false;

							if (in_array($this->id, $successFinal_ids))
								$expired = false;


						}
					
					}else{	
						$orders = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
							->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
							->join("packs", "order_products.pack_id", "=", "packs.id")
							->where("student_id", Auth::user()->id)
							->where("packs.cours_id2", $course->id)
							->whereIn("orders.id", $paidOrder_ids)
							->where(DB::raw("DATE(orders.created_at)"), ">=", $beforePack)->first();
							
						if (isset($orders)) {
							//echo "afef".$orders->pack_id;		
					
							$order = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
								->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
								->where("student_id", Auth::user()->id)
								->where("order_products.pack_id", $orders->pack_id)
								->whereIn("orders.id", $paidOrder_ids)
								->where(DB::raw("DATE(created_at)"), ">=", $beforePack)->first();

							if (empty($order)) {
								//echo "Afeff";
								$expired = true;
								$successFinal_ids = $student->student_quizzes()->where("course_id", $orders->cours_id1)
									->where("is_exam", 1)->where("successfull", 1)->pluck("quiz_id")->all();
									
								$quizOrder = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
									->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
									->where("student_id", Auth::user()->id)
									->where("order_products.quiz_id", $this->id)
									->whereIn("orders.id", $paidOrder_ids)->first();
								if (!empty($quizOrder))
									$expired = false;

								if (in_array($this->id, $successFinal_ids))
									$expired = false;


							}
						}else{
				
							$order = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
								->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
								->where("student_id", Auth::user()->id)
								->where("order_products.course_id", $course->id)
								->whereIn("orders.id", $paidOrder_ids)
								->where(DB::raw("DATE(created_at)"), ">=", $before)->first();
							if (empty($order)) {
								$expired = true;
								$successFinal_ids = $student->student_quizzes()->where("course_id", $course->id)
									->where("is_exam", 1)->where("successfull", 1)->pluck("quiz_id")->all();
								
								$quizOrder = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
									->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
									->where("student_id", Auth::user()->id)
									->where("order_products.quiz_id", $this->id)
									->whereIn("orders.id", $paidOrder_ids)->first();
								
								if (!empty($quizOrder))
									$expired = false;

								if (in_array($this->id, $successFinal_ids))
									$expired = false;


							}
						}
					}
                }
            }
        }
        if($course->isFree()){
            $expired = false;
        }
        return $expired;
    }

    public function courses(){
		return $this->belongsToMany("App\Course","courses_quizzes","quiz_id","course_id");
	}

    public function courses_exams(){
        return $this->hasMany("App\CourseQuiz","quiz_id");
    }

    static function datediff($interval, $datefrom, $dateto, $using_timestamps = false)
    {
        /*
        $interval can be:
        yyyy - Number of full years
        q    - Number of full quarters
        m    - Number of full months
        y    - Difference between day numbers
               (eg 1st Jan 2004 is "1", the first day. 2nd Feb 2003 is "33". The datediff is "-32".)
        d    - Number of full days
        w    - Number of full weekdays
        ww   - Number of full weeks
        h    - Number of full hours
        n    - Number of full minutes
        s    - Number of full seconds (default)
        */

        if (!$using_timestamps) {
            $datefrom = strtotime($datefrom, 0);
            $dateto   = strtotime($dateto, 0);
        }

        $difference        = $dateto - $datefrom; // Difference in seconds
        $months_difference = 0;

        switch ($interval) {
            case 'yyyy': // Number of full years
                $years_difference = floor($difference / 31536000);
                if (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom), date("j", $datefrom), date("Y", $datefrom)+$years_difference) > $dateto) {
                    $years_difference--;
                }

                if (mktime(date("H", $dateto), date("i", $dateto), date("s", $dateto), date("n", $dateto), date("j", $dateto), date("Y", $dateto)-($years_difference+1)) > $datefrom) {
                    $years_difference++;
                }

                $datediff = $years_difference;
                break;

            case "q": // Number of full quarters
                $quarters_difference = floor($difference / 8035200);

                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($quarters_difference*3), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }

                $quarters_difference--;
                $datediff = $quarters_difference;
                break;

            case "m": // Number of full months
                $months_difference = floor($difference / 2678400);

                while (mktime(date("H", $datefrom), date("i", $datefrom), date("s", $datefrom), date("n", $datefrom)+($months_difference), date("j", $dateto), date("Y", $datefrom)) < $dateto) {
                    $months_difference++;
                }

                $months_difference--;

                $datediff = $months_difference;
                break;

            case 'y': // Difference between day numbers
                $datediff = date("z", $dateto) - date("z", $datefrom);
                break;

            case "d": // Number of full days
                $datediff = floor($difference / 86400);
                break;

            case "w": // Number of full weekdays
                $days_difference  = floor($difference / 86400);
                $weeks_difference = floor($days_difference / 7); // Complete weeks
                $first_day        = date("w", $datefrom);
                $days_remainder   = floor($days_difference % 7);
                $odd_days         = $first_day + $days_remainder; // Do we have a Saturday or Sunday in the remainder?

                if ($odd_days > 7) { // Sunday
                    $days_remainder--;
                }

                if ($odd_days > 6) { // Saturday
                    $days_remainder--;
                }

                $datediff = ($weeks_difference * 5) + $days_remainder;
                break;

            case "ww": // Number of full weeks
                $datediff = floor($difference / 604800);
                break;

            case "h": // Number of full hours
                $datediff = floor($difference / 3600);
                break;

            case "n": // Number of full minutes
                $datediff = floor($difference / 60);
                break;

            default: // Number of full seconds (default)
                $datediff = $difference;
                break;
        }

        return $datediff;
    }

    public function scopeLangue($query, $lang)
    {
        return $query->where('lang', $lang);
    }


}
   
