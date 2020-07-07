<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use DB;
use App\User;
use App\Course;
use Carbon\Carbon;
use App\Notifications\CourseNotification;
use App\Notifications\Birthday;

class SendCourseEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SendCourseEmail:execute';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send email notification for students';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $users = User::all();
        foreach ($users as $user) {
            if($user->date_of_birth == Carbon::today()->toDateString()){
                //$user->notify(new Birthday($user->full_name_ar));
            }
        }
        foreach ($users as $user) {
            $query = "select order_products.course_id from `order_products` inner join `orders` on `order_products`.`order_id` = `orders`.`id` inner join `order_onlinepayments` on `order_onlinepayments`.`order_id` = `orders`.`id` where exists (select * from `orderproducts_students` where `order_products`.`id` = `orderproducts_students`.`orderproduct_id` and `student_id` = ".$user->id.") and `order_onlinepayments`.`payment_status` = 'paid' and `orders`.`created_at` = '".Carbon::today()->subDays(89)->toDateString()."' and `order_products`.`course_id` is not null";
            $paidCourses = DB::select($query);
            foreach ($paidCourses as $course_id) {
                $course = Course::find($course->course_id);
                //$user->notify(new CourseNotification($course->name,$user->username,"1"));
            }                
            $query = "select order_products.course_id from `order_products` inner join `orders` on `order_products`.`order_id` = `orders`.`id` inner join `order_onlinepayments` on `order_onlinepayments`.`order_id` = `orders`.`id` where exists (select * from `orderproducts_students` where `order_products`.`id` = `orderproducts_students`.`orderproduct_id` and `student_id` = ".$user->id.") and `order_onlinepayments`.`payment_status` = 'paid' and `orders`.`created_at` = '".Carbon::today()->subDays(30)->toDateString()."' and `order_products`.`course_id` is not null";
            $paidCourses = DB::select($query);
            foreach ($paidCourses as $course_id) {
                $course = Course::find($course->course_id);
                //$user->notify(new CourseNotification($course->name,$user->username,"75"));
            }                
        }
        
    }
}











