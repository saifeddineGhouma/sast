<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
	public $incrementing = false;
	
	public function teacher_trans($lang){
		return $this->hasMany("App\TeacherTranslation","teacher_id")->where("lang",$lang)->first();
	}
	
	public function user(){
		return $this->hasOne("App\User","id","id");
	}
	
	public function socials(){
		return $this->hasMany("App\TeacherSocial","teacher_id");
	}

    public function coursetype_variations(){
        return $this->hasMany("App\CourseTypeVariation","teacher_id");
    }

    public function students_ids(){
        $studentIds = $this->coursetype_variations()->join("order_products","order_products.coursetypevariation_id","=","coursetype_variations.id")
            ->join("orderproducts_students","orderproducts_students.orderproduct_id","=","order_products.id")
            ->join("orders", "order_products.order_id", "=", "orders.id")
            ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->where("order_onlinepayments.payment_status", "paid")

            ->pluck("student_id")->all();
        return $studentIds;
    }

    public function courses_ids(){
        $course_ids = $this->coursetype_variations()->join("course_types","course_types.id","=","coursetype_variations.coursetype_id")

            ->pluck("course_types.course_id")->all();

        return $course_ids;
    }

    public function certificates(){
        $certificates = \App\Certificate::join("coursetype_variations","coursetype_variations.certificate_id","=","certificates.id")
            ->where("coursetype_variations.teacher_id",$this->id);

        return $certificates;
    }
   
}
   
