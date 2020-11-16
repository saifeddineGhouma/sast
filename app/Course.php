<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Auth;
use DB;

class Course extends Model
{
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'exam_period', 'period', 'parent_id', 'promo_points', 'language', 'image', 'video'
    ];

    /**
     * The rules for validation.
     *
     * @var array
     */
    public function rules()
    {
        $id = $this->id;
        if (empty($id))
            $id = 0;
        return array(
            'ar_name' => 'required',
            'en_name' => 'required',
            'ar_slug' => 'required|unique:course_translations,slug,' . $id . ',course_id',
            'en_slug' => 'required|unique:course_translations,slug,' . $id . ',course_id',
            'period' => 'required',
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
        $query = self::select('courses.*');

        // Keyword
        //        if (!empty(trim($request->keyword))) {
        //            foreach (explode(' ', trim($request->keyword)) as $keyword) {
        //                $query = $query->where(function ($q) use ($keyword) {
        //                    $q->orwhere('currencies.name', 'like', '%'.$keyword.'%')
        //                        ->orWhere('currencies.code', 'like', '%'.$keyword.'%');
        //                });
        //            }
        //        }
        //
        if (!empty($request->name)) {
            $query = $query->whereHas("translations", function ($query1) use ($request) {
                $query1->where('name', 'like', '%' . $request->name . '%');
            });
        }
        if (!empty($request->created_at_1)) {
             if(!(empty($request->created_at_2)))
             {
                $created_at_1 =  date("y-m-d", strtotime($request->created_at_1));
                $created_at_2 =  date("y-m-d", strtotime($request->created_at_2));

                $query = $query->whereBetween(DB::raw("DATE(created_at)"), [$created_at_1,$created_at_2]);
                

             }else{
                $created_at =  date("y-m-d", strtotime($request->created_at_1));
                $query = $query->where(DB::raw("DATE(created_at)"), $created_at);
              
             }
            
        }
        if ($request->trashed) {
            $query = $query->onlyTrashed();
        }
        $category_ids = $request->category_id;
        if (!empty($category_ids)) {
            $query = $query->join("courses_categories", "courses_categories.course_id", "=", "courses.id");
            $query->where(function ($query1) use ($category_ids) {
                $i = 0;

                foreach ($category_ids as $category_id) {
                    if ($i == 0)
                        $query1 = $query1->where('courses_categories.category_id', $category_id);
                    else
                        $query1 = $query1->orWhere('courses_categories.category_id', $category_id);
                    $i++;
                }
                return $query1;
            });
        }
        if (isset($request->price)) {
            if ($request->price == 'free') {
                $query = $query->join("course_types", "course_types.course_id", "=", "courses.id");
                $query = $query->join("coursetype_variations", "coursetype_variations.coursetype_id", "=", "course_types.id");
                $query->where("coursetype_variations.price", "=", 0.00);
            }
            if ($request->price == 'paid') {
                $query = $query->join("course_types", "course_types.course_id", "=", "courses.id");
                $query = $query->join("coursetype_variations", "coursetype_variations.coursetype_id", "=", "course_types.id");
                $query->where("coursetype_variations.price", ">", 0.00);
            }
        }
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

    public static function notReqisteredVideos()
    {
        $query = self::doesntHave("courses_videoexams");
        $query = $query->whereDoesntHave("quizzes", function ($query1) {
            $query1->where("quizzes.is_exam", 1);
        });
        return $query;
    }
    public function userVerify()
    {
        return $this->hasOne("App\UserVerify", "course_id");
    }
    public function stage()
    {
        return $this->hasOne("App\CourseStage", "course_id");
    }
    public function course_questions()
    {
        return $this->hasMany("App\CourseQuestion");
    }

    public function courses_videoexams()
    {
        return $this->hasMany("App\CourseVideoExam");
    }
     public function courses_stage()
     {
           return $this->hasMany("App\CourseStage");

     }

      public function courses_study_case()
     {
           return $this->hasOne("App\CourseStudyCase");

     }


    public function videoexams()
    {
        return $this->belongsToMany("App\VideoExam", "courses_videoexams", "course_id", "videoexam_id");
    }

    public function courses_quizzes()
    {
        return $this->hasMany("App\CourseQuiz");
    }

    public function quizzes()
    {
        return $this->belongsToMany("App\Quiz", "courses_quizzes", "course_id", "quiz_id")->where("active", 1);
    }
    ///*all quizzes**/
    public function quizzesAll()
    {
        return $this->belongsToMany("App\Quiz", "courses_quizzes", "course_id", "quiz_id");
    }

    public function course_trans($lang)
    {
        return $this->hasMany("App\CourseTranslation", "course_id")->where("lang", $lang)->first();
    }

    public function translations()
    {
        return $this->hasMany("App\CourseTranslation", "course_id");
    }

    public function categories()
    {
        return $this->belongsToMany("App\Category", "courses_categories", "course_id", "category_id");
    }

    public function courseTypes()
    {
        return $this->hasMany("App\CourseType");
    }

    public function courseDiscounts()
    {
        return $this->hasMany("App\CourseDiscount");
    }

    public function courseStudies()
    {
        return $this->hasMany("App\CourseStudy")->where('lang', Auth::check() ? ( $this->is_lang ? Auth::user()->lang() : 'Ar' ) : 'Ar');
    }
     public function Studies()
    {
        return $this->hasMany("App\CourseStudy");
    }
    public function views()
    {
        return $this->hasMany("App\CourseView");
    }

    public function orders()
    {
        return $this->belongsToMany("App\Order", "order_products", "course_id", "order_id");
    }

    public function order_products()
    {
        return $this->hasMany("App\OrderProduct");
    }

    public function ratings()
    {
        return $this->hasMany("App\CourseRating", "course_id");
    }

    public function parent_course()
    {
        return $this->belongsTo("App\Course", "parent_id");
    }

    public function students_certificates()
    {
        return $this->hasMany("App\StudentCertificate", "course_id");
    }
 public function students_stage()
    {
        return $this->hasMany("App\StudentStage", "course_id");
    }
    ///  many ot many   students and  studycase
    public function students_study_case()
    {
        return $this->hasMany("App\SujetCourse", "course_id");
    }

    public static function numStudents()
    {
        return [
            1, 2, 3, 4, 5
        ];
    }
 /*open course*/
    public function isRegistered($user = null)
    {
        $isRegistered = false;
        if (is_null($user)) {
            $user = Auth::user();
        }
        if ($user) {
            $countOrders = $this->order_products()
                ->whereHas('orderproducts_students', function ($query) use ($user) {
                    $query->where("student_id", $user->id);
                })->join("orders", "order_products.order_id", "=", "orders.id")
                ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
                ->where(function ($query) {
                     $query->where("order_onlinepayments.payment_status", "paid")
                           ->orWhere("order_onlinepayments.engaged", "engaged");
                })
                ->having(DB::raw("sum(order_onlinepayments.total)"), ">=", 0)
                ->groupBy("orders.id")->count();

            if ($countOrders > 0)
                $isRegistered = true;
            else {
                $countOrderss = DB::table('order_products')
                    ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                    ->join("orders", "order_products.order_id", "=", "orders.id")
                    ->join("packs", "order_products.pack_id", "=", "packs.id")
                    ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                    ->where(function ($query) {
                          $query->where("order_onlinepayments.payment_status", "paid")
                                ->orWhere("order_onlinepayments.engaged", "engaged");
                      })
                    ->where("packs.cours_id1", $this->id)
                    ->where("orderproducts_students.student_id", $user->id)
                    ->having(DB::raw("sum(order_onlinepayments.total)"), ">=", 0)
                    ->groupBy("order_products.order_id")->count();

                //if($countOrderss==1) echo $this->id." - ".$countOrderss;
                if ($countOrderss == 1) {
                    $isRegistered = true;
                } else {
                    $countOrdersss = DB::table('order_products')
                        ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                        ->join("orders", "order_products.order_id", "=", "orders.id")
                        ->join("packs", "order_products.pack_id", "=", "packs.id")
                        ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                        ->where(function ($query) {
                              $query->where("order_onlinepayments.payment_status", "paid")
                                    ->orWhere("order_onlinepayments.engaged", "engaged");
                          })
                        ->where("packs.cours_id2", $this->id)
                        ->where("orderproducts_students.student_id", $user->id)
                        ->having(DB::raw("sum(order_onlinepayments.total)"), ">=", 0)
                        ->groupBy("order_products.order_id")->count();

                    $countOrderssss = DB::table('order_products')
                        ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                        ->join("orders", "order_products.order_id", "=", "orders.id")
                        ->join("packs", "order_products.pack_id", "=", "packs.id")
                        ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                        ->where(function ($query) {
                              $query->where("order_onlinepayments.payment_status", "paid")
                                    ->orWhere("order_onlinepayments.engaged", "engaged");
                          })
                        ->where("packs.cours_id2", $this->id)
                        ->where("orderproducts_students.student_id", $user->id)->first();
                    if ($countOrdersss == 1) {
                        $coursprec = DB::table('students_certificates')
                            ->where("course_id", $countOrderssss->cours_id1)
                            ->where("student_id", $user->id)
                            ->where("active", "1")->count();
                        //echo $coursprec;
                        if ($coursprec > 0) {
                            $isRegistered = true;
                        }
                    }
                }
            }
        }
        //echo $isRegistered;
        return $isRegistered;
    }

    public function isTotalyPaid($user = null){
        $isTotalyPaid = false;
        if (is_null($user)) {
            $user = Auth::user();
        }
        if ($user) {
            $countOrders = $this->order_products()
                ->whereHas('orderproducts_students', function ($query) use ($user) {
                    $query->where("student_id", $user->id);
                })->join("orders", "order_products.order_id", "=", "orders.id")
                ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
                ->where(function ($query) {
                     $query->where("order_onlinepayments.payment_status", "paid");
                })
                ->having(DB::raw("sum(order_onlinepayments.total)"), ">=", 0)
                ->groupBy("orders.id")->count();

            if ($countOrders > 0)
                $isTotalyPaid = true;
            else {
                $countOrderss = DB::table('order_products')
                    ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                    ->join("orders", "order_products.order_id", "=", "orders.id")
                    ->join("packs", "order_products.pack_id", "=", "packs.id")
                    ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                    ->where(function ($query) {
                          $query->where("order_onlinepayments.payment_status", "paid");
                      })
                    ->where("packs.cours_id1", $this->id)
                    ->where("orderproducts_students.student_id", $user->id)
                    ->having(DB::raw("sum(order_onlinepayments.total)"), ">=", 0)
                    ->groupBy("order_products.order_id")->count();

                //if($countOrderss==1) echo $this->id." - ".$countOrderss;
                if ($countOrderss == 1) {
                    $isTotalyPaid = true;
                } else {
                    $countOrdersss = DB::table('order_products')
                        ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                        ->join("orders", "order_products.order_id", "=", "orders.id")
                        ->join("packs", "order_products.pack_id", "=", "packs.id")
                        ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                        ->where(function ($query) {
                              $query->where("order_onlinepayments.payment_status", "paid");
                          })
                        ->where("packs.cours_id2", $this->id)
                        ->where("orderproducts_students.student_id", $user->id)
                        ->having(DB::raw("sum(order_onlinepayments.total)"), ">=", 0)
                        ->groupBy("order_products.order_id")->count();

                    $countOrderssss = DB::table('order_products')
                        ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                        ->join("orders", "order_products.order_id", "=", "orders.id")
                        ->join("packs", "order_products.pack_id", "=", "packs.id")
                        ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                        ->where(function ($query) {
                              $query->where("order_onlinepayments.payment_status", "paid");
                          })
                        ->where("packs.cours_id2", $this->id)
                        ->where("orderproducts_students.student_id", $user->id)->first();
                    if ($countOrdersss == 1) {
                        $coursprec = DB::table('students_certificates')
                            ->where("course_id", $countOrderssss->cours_id1)
                            ->where("student_id", $user->id)
                            ->where("active", "1")->count();
                        //echo $coursprec;
                        if ($coursprec > 0) {
                            $isTotalyPaid = true;
                        }
                    }
                }
            }
        }
        return $isTotalyPaid;
    }

    public function isPayCourse($user = null)
    {
        $isPayCourse = false;
        if (is_null($user)) {
            $user = Auth::user();
        }
        if ($user) {
            $countOrderss = DB::table('orders')
                ->where("orders.user_id", $user->id)
                ->join("order_products", "order_products.order_id", "=", "orders.id")
                ->where("order_products.course_id", $this->id)
                ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                ->where("order_onlinepayments.payment_status", "paid")
                ->orWhere("order_onlinepayments.engaged", "engaged")
                ->whereIn("order_onlinepayments.total", ['0.00', '150.00', '250.00', '200.00', '300.00', '480.00'])
                ->count();
               
            // ->groupBy("order_products.order_id")
            // $countOrderss =    $this->order_products()
            //     ->whereHas('orderproducts_students', function ($query) use ($user) {
            //         $query->where("student_id", $user->id);
            //     })->join("orders", "order_products.order_id", "=", "orders.id")
            //     ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            //     ->where("order_onlinepayments.payment_status", "paid")
            //     ->where("order_onlinepayments.total", '=', '150.00')
            //     ->groupBy("orders.id")->count();
            if ($countOrderss > 0)
                $isPayCourse = true;
            //echo $isRegistered;
            return $isPayCourse;
        }
    }
    public function isPayCourseLevel2($user = null)
    {
        $isPayCourse = false;
        if (is_null($user)) {
            $user = Auth::user();
        }
        if ($user) {
            $countOrderss = DB::table('orders')
                ->join("order_products", "order_products.order_id", "=", "orders.id")
                ->where("order_products.course_id", 20)
                ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                ->where("orderproducts_students.student_id", $user->id)
                ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                ->where("order_onlinepayments.payment_status", "paid")
               //  ->orWhere("order_onlinepayments.engaged", "engaged")
                ->where("order_onlinepayments.total", '=', '150.00')
                // ->orWhere("order_onlinepayments.total", '=', '200.00')
                ->count();

            if ($countOrderss > 0)
                $isPayCourse = true;
            //echo $isRegistered;
            return $isPayCourse;
        }
    }

    public function isPayPackThree($user = null)
    {
        $isPayCourse = false;
        if (is_null($user)) {
            $user = Auth::user();
        }
        if ($user) {
            $countOrderss = DB::table('orders')
                ->join("order_products", "order_products.order_id", "=", "orders.id")
                ->where("order_products.pack_id", 3)
                ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                ->where("orderproducts_students.student_id", $user->id)
                ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                ->where("order_onlinepayments.payment_status", "paid")
                ->where("order_onlinepayments.total", '=', '250.00')
                // ->orWhere("order_onlinepayments.total", '=', '200.00')
                ->count();

            if ($countOrderss > 0)
                $isPayCourse = true;
            //echo $isRegistered;
            return $isPayCourse;
        }
    }

    public function isRegisteredParent()
    {
        $isRegistered = true;
        $parent = $this->parent_course;
        if (!empty($parent)) {
            $isRegistered = $parent->isRegistered();
        }

        return $isRegistered;
    }

    public function isSuccess($user = null)
    {
        $isSuccess = false;
        if (is_null($user)) {
            $user = Auth::user();
        }
        if ($user) {
            $student = $user->student;
            $quizzes = $this->quizzes()->where("quizzes.is_exam", 1)->get();
            if ($quizzes->count() > 0) {
                foreach ($quizzes as $quiz) {
                    if (!empty($student)) {
                        $studentQuizCount = $student->student_quizzes()->where("quiz_id", $quiz->id)
                            ->where("status", "!=", "not_completed")->where("successfull", 1)->count();
                        if ($studentQuizCount > 0)
                            $isSuccess = true;
                    }
                }
            } else {
                $isSuccess = true;
            }
        }
        return $isSuccess;
    }
    public function isSuccessParent()
    {
        $isSuccess = true;
        $parent = $this->parent_course;
        if (!empty($parent)) {
            $isSuccess = $parent->isSuccess();
        }

        return $isSuccess;
    }

    public function isTotalPaid($user = null)
    {
        $isPaid = false;
        if (is_null($user)) {
            $user = Auth::user();
        }
        if ($user) {
            $countOrders = $this->order_products()
                ->whereHas('orderproducts_students', function ($query) use ($user) {
                    $query->where("student_id", $user->id);
                })->join("orders", "order_products.order_id", "=", "orders.id")
                ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
                ->where("order_onlinepayments.payment_status", "paid")
               // ->orWhere("order_onlinepayments.engaged", "engaged")

                ->select(DB::raw("sum(order_onlinepayments.total) as sumPayments"), "orders.id", "orders.total")
                ->groupBy("orders.id", "orders.total")
                ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
                ->count();

            if ($countOrders > 0) {
                $isPaid = true;
            } else {
                //echo $this->id;
                $countOrdersss = DB::table('order_products')
                    ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                    ->join("orders", "order_products.order_id", "=", "orders.id")
                    ->join("packs", "order_products.pack_id", "=", "packs.id")
                    ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                    ->where("order_onlinepayments.payment_status", "paid")
                   // ->orWhere("order_onlinepayments.engaged", "engaged")
                    ->where("packs.cours_id1", $this->id)
                    ->where("orderproducts_students.student_id", $user->id)
                    ->having(DB::raw("sum(order_onlinepayments.total)"), ">=", 0)
                    ->groupBy("order_products.order_id")->count();
                if ($countOrdersss > 0) {
                    $isPaid = true;
                } else {
                    $countOrderssss = DB::table('order_products')
                        ->join("orderproducts_students", "order_products.id", "=", "orderproducts_students.orderproduct_id")
                        ->join("orders", "order_products.order_id", "=", "orders.id")
                        ->join("packs", "order_products.pack_id", "=", "packs.id")
                        ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "order_products.order_id")
                        ->where("order_onlinepayments.payment_status", "paid")
                      //  ->orWhere("order_onlinepayments.engaged", "engaged")
                        ->where("packs.cours_id2", $this->id)
                        ->where("orderproducts_students.student_id", $user->id)
                        ->having(DB::raw("sum(order_onlinepayments.total)"), ">=", 0)
                        ->groupBy("order_products.order_id")->count();

                    if ($countOrderssss > 0) {
                        $isPaid = true;
                    }
                }
            }
        }
        return $isPaid;
    }

    // fitness assistant 
    public function isCompleteQuizzesExam()
    {
        $isComplete = true;
        if (Auth::check()) {
            $student = Auth::user()->student;

           $lang= ($this->is_lang) ? Auth::user()->lang() : 'Ar' ;
            $quizzes = $this->quizzes()->where("quizzes.is_exam", 0)->Langue($lang)->where("active", 1)->get();
            //print_r($quizzes);
            foreach ($quizzes as $quiz) {
                if (!empty($student)) {
                    $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)
                        ->where("status", "=", "completed")->where('successfull',1)->first();

                    if (empty($studentQuiz))
                        $isComplete = false;
                }
            }

            $exams = $this->quizzes()->Langue($lang)->where("quizzes.is_exam", 1)->get();
              foreach ($exams as $exam) {
                if (!empty($student)) {
                    $studentExam = $student->student_quizzes()->where("quiz_id", $exam->id)
                        ->where("status", "=", "completed")->where('successfull',1)->first();

                    if (empty($studentExam))
                        $isComplete = false;
                            }
                       }
        } else {
            $isComplete = false;
        }
        return $isComplete;
    }

    public function isFinishedFinalExam($student=null){
        if (Auth::check() || !empty($student)) {

             if(empty($student))
            {
                $student = Auth::user()->student;
                $lang= ($this->is_lang) ? Auth::user()->lang() : 'Ar' ;

            } else{
                $lang= ($this->is_lang) ? $student->user->lang() : 'Ar' ;
            } 


         

            $quizzes = $this->quizzes()->where("quizzes.is_exam", 1)->Langue($lang)->where("active", 1)->get();
            
            // condition valid quiz

            foreach ($quizzes as $quiz) {
                if (!empty($student)) {
                     $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)
                        ->where("status", "=", "completed")->where('successfull',1)->first();

                    if (empty($studentQuiz) || !$studentQuiz->successfull)
                    { 
                       return  false;
                    }
                }
            }
        }else{
            return false;
        }
        return true;
    }
   
    public function isFinishedQuizzes($student=null){
         if (Auth::check() || !empty($student)) {

             if(empty($student))
            {
                $student = Auth::user()->student;
                $lang= ($this->is_lang) ? Auth::user()->lang() : 'Ar' ;

            } else{
                $lang= ($this->is_lang) ? $student->user->lang() : 'Ar' ;
            } 



            $quizzes = $this->quizzes()->where("quizzes.is_exam", 0)->Langue($lang)->where("active", 1)->get();
            
        // condition valid quiz

            foreach ($quizzes as $quiz) {
                if (!empty($student)) {
                     $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)
                        ->where("status", "=", "completed")->where('successfull',1)->first();

                    if (empty($studentQuiz) || !$studentQuiz->successfull)
                    { 
                       return  false;
                    }
                }
            }
        }else{
            return false;
        }
        return true;
    }

 

    public function isCompleteQuizzes($student=null)
    {
       

    
		
        if (Auth::check() || !empty($student)) {

            if(empty($student))
            {
                $student = Auth::user()->student;
                $lang= ($this->is_lang) ? Auth::user()->lang() : 'Ar' ;

            } else{
                $lang= ($this->is_lang) ? $student->user->lang() : 'Ar' ;
            } 

            /*Quizzes*/
           

			$quizzes = $this->quizzes()->where("quizzes.is_exam", 0)->Langue($lang)->where("active", 1)->get();
			
            // condition valid quiz

            foreach ($quizzes as $quiz) {
                if (!empty($student)) {
                     $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)
                        ->where("status", "=", "completed")->where('successfull',1)->first();


                    if (empty($studentQuiz)  )
					{ 
                        

				       return  false;
					}
                       
                }
            }

            /* Final exam */
            $quizzes = $this->quizzes()->Langue($lang)->where("quizzes.is_exam", 1)->where("active", 1)->get();
            
            // condition valid quiz*/

            foreach ($quizzes as $quiz) {
                if (!empty($student)) {
                     $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)
                        ->where("status", "=", "completed")->first();

                    if (empty($studentQuiz))
                    { 
                       return  false;
                    }
                       
                }
            }

            /* Video exam */

            $videoExams = $this->videoexams()->get();
           
            foreach ($videoExams as $videoExam) {
                if (!empty($videoExam)) {
                    $studentVideo = $student->student_videoexams()->where("videoexam_id", $videoExam->id)
                        ->where("status", "=", "completed")->where("successfull", 1)->first();

                    if (empty($studentVideo))
                        return  false;
                }
            }

        
            /*Stage*/


            if(!$this->ValidStage())
            {
                return false ;
                 
            }
           
           /* study case */

             if(!$this->ValidStudycase())
            {
                return false ;
                 
            }


        } else {
           return  false;
        }

        return true ;
    }


    public function isCompleteQuizzesWithoutVdo()
    {
        $isComplete = true;
        if (Auth::check()) {
            $student = Auth::user()->student;
            $lang= ($this->is_lang) ? Auth::user()->is_lang : 'Ar' ;
            $quizzes = $this->quizzes()->Langue($lang)->where("quizzes.is_exam", 0)->get();
            //print_r($quizzes);
            foreach ($quizzes as $quiz) {
                if (!empty($student)) {
                    $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)
                        ->where("status", "=", "completed")->first();

                    if (empty($studentQuiz))
                        return false;
                }
            }
        } else {
            return  false;
        }
        return true;
    }


    public function isCompleteQuizWithoutVideo()
    {
        $isComplete = true;
        if (Auth::check()) {
            $student = Auth::user()->student;

            $quizzesFr = $this->quizzes()->Langue('Fr')->where("quizzes.is_exam", 0)->get();
            $quizzesAr  = $this->quizzes()->whereIn('quizzes.id', [312, 366, 367, 368, 369, 370])->where("quizzes.is_exam", 0)->get();
            //print_r($quizzes);
            if ($student->user->user_lang()->exists()) {
                if ($student->user->user_lang->lang_stud == "fr") {
                    foreach ($quizzesFr as $quiz) {
                        if (!empty($student)) {
                            $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)
                                ->where("status", "=", "completed")->first();

                            if (empty($studentQuiz))
                                $isComplete = false;
                        }
                    }
                } else {
                    foreach ($quizzesAr as $quiz) {
                        if (!empty($student)) {
                            $studentQuiz = $student->student_quizzes()->where("quiz_id", $quiz->id)
                                ->where("status", "=", "completed")->first();

                            if (empty($studentQuiz))
                                $isComplete = false;
                        }
                    }
                }
            }
        } else {
            $isComplete = false;
        }
        return $isComplete;
    }



    public function isFree()
    {
        return $this->courseTypes()->first()->couseType_variations()->orderBy("price", "asc")->first()->price == 0;
    }
    /**nbr tentative in exam 50question */
    public function gettentative()
    {
        if(Auth::check())
        { 
                $count = $this->student_quizzes()->where('is_exam',1)
                                                 ->where('student_id',Auth::id())
                                                 ->count();
                                                 return $count;
        }
           return null;
    }

    public function validQuizAttempts($quiz)
    {
        $isValid = true;
        if (Auth::check()) {
            //            $quizzesCount = $this->quizzes()->where("quizzes.is_exam",1)->where("active",1)->count();
            $student = Auth::user()->student;
            if (!empty($student)) {
                if ($this->isFree()) {
                    $isValid = true;
                } else {

                    $courseQuiz = $this->courses_quizzes()->where("quiz_id", $quiz->id)->first();
					if(isset($courseQuiz))
                    {
					$quizzesCount = $courseQuiz->attempts;}
				else {
					$quizzesCount ='';
				}
					
				
                    $successQuizzesCount = $student->student_quizzes()->where("quiz_id", $quiz->id)->where("successfull", 1)->count();
                    $studentQuizzesCount = $student->student_quizzes()->where("quiz_id", $quiz->id)->count();

                    if ($studentQuizzesCount >= $quizzesCount && $quizzesCount > 0 && $successQuizzesCount == 0) {
                        $paidOrder_ids = \App\Order::join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
                            ->where("order_onlinepayments.payment_status", "paid")
                            ->groupBy("orders.id", "orders.total")
                            ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
                            ->pluck("orders.id")->all();

                        $quizOrder = \App\Order::join("order_products", "order_products.order_id", "=", "orders.id")
                            ->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
                            ->where("student_id", Auth::user()->id)
                            ->where("order_products.quiz_id", $quiz->id)
                            ->whereIn("orders.id", $paidOrder_ids)->first();
                        if (empty($quizOrder))
                            $isValid = false;
                    }
                }
            }
        } else {
            $isValid = false;
        }
        return $isValid;
    }

    public function validateQuizWithoutVideo($type, &$messageValid)
    {
        $isValid = false;
        $isRegistered = $this->isRegistered();
        //echo $isRegistered;
        if ($isRegistered) {
            if ($type != "exam" || ($type == "exam" && $this->isTotalPaid())) {
                if ($type != "exam" || ($type == "exam" && $this->isCompleteQuizWithoutVideo())) {
                    $isValid = true;
                } else {
                    $messageValid = ' <p class="failed">لابد من إتمام جميع الكويزات </p>';
                }
            } else {
                $messageValid = '<p class="failed">برجاء إكمال باقي الأقساط لأداء الاختبار النهائي</p>';
            }
        } else {
            $messageValid = '<p     >أنت غير مشترك في هذه الدورة</p>';
        }
        return $isValid;
    }

    // fitness assistant 
    public function validateExam($type, &$messageValid)
    {
        $isValid = false;
        $isValidQuiz = false;
        $isRegistered = $this->isRegistered();
        //echo $isRegistered;
        if ($isRegistered) {
            if ($type != "exam" || ($type == "exam" && $this->isTotalPaid())) {
                if ($type != "video" || ($type == "video" && $this->isCompleteQuizzesExam())) {
                    $isValid = true;
                } else {
                    $messageValid = '<p class="failed">لابد من إتمام جميع الكويزات والاختبار النهائي لإتمام الفيديو</p>';
                }
                if ($type != "exam" || ($type == "exam" && $this->isCompleteQuizzesWithoutVdo())) {
                    $isValidQuiz = true;
                } else {
                    $messageValid = ' <p class="failed">لابد من إتمام جميع الكويزات </p>';
                }
            } else {
                $messageValid = '<p class="failed">برجاء إكمال باقي الأقساط لأداء الاختبار النهائي</p>';
            }
        } else {
            $messageValid = '<p class="failed">أنت غير مشترك في هذه الدورة</p>';
        }

        return ['isValid' => $isValid, 'isValidQuiz' => $isValidQuiz];
    }

    /////// valid 50 quiz 

    public function validateQuiz($type, &$messageValid)
    {
       
        $isValid = false;
        $isRegistered = $this->isRegistered();
        //echo $isRegistered;
        if ($isRegistered) {
            if ($type != "exam" || ($type == "exam" && $this->isTotalPaid())) {

                if ($type != "exam" || ($type == "exam" && $this->isFinishedQuizzes())) {
                    $isValid = true;
                } else {
                    $messageValid = ' <p class="failed">للابد من إتمام جميع الكويزات لإتمام الاختبار النهائي  </p>';
                }
            } else {
                $messageValid = '<p class="failed">برجاء إكمال باقي الأقساط لأداء الاختبار النهائي</p>';
            }
        } else {
            $messageValid = '<p class="failed">أنت غير مشترك في هذه الدورة</p>';
        }
        return $isValid;
    }

    function getStatus($datafiled, $dataid)
    {
        $span = '';
        $id = '';
        if ($datafiled == 1) {
            $span = '<span class="label label-sm label-success"> active </span>';
            $id = 'on-' . $dataid;
        } else {
            $span = '<span class="label label-sm label-danger"> not active </span>';
            $id = 'off-' . $dataid;
        }

        return '<a style="cursor: pointer;" class="activeIcon" data-id="' . $id . '"> ' . $span . ' </a>';
    }

    function rating($value)
    {
        if ($value == 0)
            echo '<i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i>';
        elseif ($value <= 1)
            echo '<i class="fa fa-star checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i>';
        elseif ($value <= 2)
            echo '<i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i>';
        elseif ($value <= 3)
            echo '<i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star-o checked"></i> <i class="fa fa-star-o checked"></i>';
        elseif ($value <= 4)
            echo '<i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star-o checked"></i>';
        elseif ($value <= 5)
            echo '<i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i> <i class="fa fa-star checked"></i>';
    }

    function sumRating($rating)
    {
        return $this->ratings()->where("approved", 1)
            ->whereBetween("value", [$rating - 1, $rating])
            ->count();
    }

    public function offer($user, $courseTypeVariation)
    {
        $order = new Order();
        $order->user_id = $user->id;
        $order->payment_method = "cash";
        $total = $courseTypeVariation->price;
        $setting = App('setting');
        $order->vat = $setting->vat * $total / 100;
        $order->total = $total + $setting->vat * $total / 100;
        $order->save();

        $orderPayment = new OrderOnlinepayment();
        $orderPayment->order_id = $order->id;
        $orderPayment->payment_status = "paid";
        $orderPayment->payment_method = $order->payment_method;

        $orderPayment->total = $order->total;
        $orderPayment->save();

        $orderProduct = new OrderProduct();
        $orderProduct->order_id = $order->id;
        $promoPoints = 0;
        $courseType = $courseTypeVariation->courseType;
        $orderProduct->coursetypevariation_id = $courseTypeVariation->id;
        $orderProduct->course_id = $courseType->course_id;
        $orderProduct->num_students = 1;
        $orderProduct->price = $courseTypeVariation->price;
        $orderProduct->total = $courseTypeVariation->price;
        $orderProduct->save();

        $orderProductStudent = new OrderproductStudent();
        $orderProductStudent->orderproduct_id = $orderProduct->id;
        $orderProductStudent->student_id = $user->student->id;
        $orderProductStudent->save();
    }
    public function finalExam(){

       return $this->quizzes()->Langue('Ar')->where("quizzes.is_exam", 1)->where("active", 1)->get();

     }

    private function ValidStage()
     {

        if(isset($this->CourseStage) && $this->CourseStage->active)
        {
            $query=  $this->students_stage()->where('user_id',Auth::user()->id)->first() ;

              if(isset($query) && $query->valider==1)
           
               return true ;
               
            return false ;
        }
        return true ;
           
        
     }

    private function ValidStudycase()
     {
        if( isset($this->courses_study_case) && $this->courses_study_case->active)
        {
            $query = $this->students_study_case()->where('user_id',Auth::user()->id)->first() ;
           if(isset($query) && $query->successful)
           
                 return true ;
             return false ;
        }else
           {
            return true ;
           }
     }
}
