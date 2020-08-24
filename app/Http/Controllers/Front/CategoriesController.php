<?php

namespace App\Http\Controllers\Front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Course;
use App\Category;
use App\CourseType;
use App\CourseTypeVariation;

use DB;

class CategoriesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $start_at = 0;
	private $numCourses = 12;
	
	public function getView($slug){
        $type="category";
        $category=null;
        if($slug=='all-courses'){
            $type = "all-courses";
        }else{
            $category = Category::join("categories_translations","categories_translations.category_id","=","categories.id")
                ->where("categories_translations.slug",$slug)
                ->first(["categories.*"]);
            if(empty($category))
                abort(404);
            else{
                $category_trans = $category->category_trans(App('lang'));
                if($category_trans->slug != $slug)
                    return redirect(App('urlLang').$category_trans->slug,301);
            }
        }

		$maxProduct = CourseTypeVariation::orderBy("price","desc")->take(1)->first();
		$minProduct = CourseTypeVariation::orderBy("price","asc")->take(1)->first();
		
		$minPrice = 0;
		$maxPrice = 700;
		if(!empty($minProduct)){
			$minPrice = $minProduct->price;					
			if($minPrice>2)
				$minPrice -= 2;
		}
		if(!empty($maxProduct))
			$maxPrice = $maxProduct->price+10;


        $countCourses = CourseType::join("courses","courses.id","=","course_types.course_id")
            ->leftJoin("courses_categories","courses_categories.course_id","=","courses.id")
            ->where("courses.active",1)
            ->where(function($query) {
                $query->whereHas('couseType_variations', function ($query1) {
                    $query1->where('course_types.type', '=', 'online');
                })->orWhereHas('couseType_variations', function ($query1) {
                    $now = date("Y-m-d");
                    $query1->where('course_types.type', '=', 'classroom')
                        ->where('coursetype_variations.date_from', '>=', $now);
                });
            });
        if($slug!='all-courses') {
            $countCourses = $countCourses->where('courses_categories.category_id', $category->id);
            if($category->id==1){
                $countCourses = $countCourses->whereHas('couseType_variations', function ($query2) {
                    $query2->where('course_types.type', '=', 'online');
                });
            }
            if($category->id==2){
                $countCourses = $countCourses->whereHas('couseType_variations', function ($query2) {
                    $query2->where('course_types.type', '=', 'classroom');
                });
            }
        }
        $countCourses = $countCourses->distinct()->get(["course_types.*"])->count();

        $courseTypes = CourseType::orderBy('created_at', 'desc')->join("courses","courses.id","=","course_types.course_id")
            ->leftJoin("courses_categories","courses_categories.course_id","=","courses.id")
            ->where("courses.active",1)
            ->where(function($query) {
                $query->whereHas('couseType_variations', function ($query1) {
                    $query1->where('course_types.type', '=', 'online');
                })->orWhereHas('couseType_variations', function ($query1) {
                        $now = date("Y-m-d");
                        $query1->where('course_types.type', '=', 'classroom')
                            ->where('coursetype_variations.date_from', '>=', $now);
                    });
            });

        if($slug!='all-courses') {
            $courseTypes = $courseTypes->where('courses_categories.category_id', $category->id);
            if($category->id==1){
                $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query2) {
                    $query2->where('course_types.type', '=', 'online');
                });
            }
            if($category->id==2){
                $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query2) {
                    $query2->where('course_types.type', '=', 'classroom');
                });
            }
        }
        $courseTypes = $courseTypes->distinct()->take($this->numCourses)->get(["course_types.*"]);


        return view('front.categories.view',array(
			"category"=>$category,"minPrice"=>$minPrice,"maxPrice"=>$maxPrice,
            "countCourses"=>$countCourses,"courseTypes"=>$courseTypes,
			"start_at"=>$this->start_at+$this->numCourses,"step"=>$this->numCourses,
			"type"=>$type
		));
		
	}

	public function getProductsmore(Request $request){
		
		$start_at = $request->start_at;
		$cat_id = $request->cat_id;
		$type= $request->type;		
		$catIds = json_decode($request->catIds);
		$category_ids=array_filter($catIds);
        $types = json_decode($request->types);
		$containerType = $request->containerType;
		$more    = $request->more;

		$price_from = $request->price_from;
		$price_to = $request->price_to;

        $sort_courses = $request->sort_courses;

		$totalResultsTxt = "";
        if($type=="category"){
            $category = Category::find($cat_id);
            $cat_trans = $category->category_trans(App('lang'));
            if(empty($cat_trans))
                $cat_trans = $category->category_trans("en");
            $totalResultsTxt = $cat_trans->name." ";
        }else{
            $category = null;
            $cat_trans = null;
            $totalResultsTxt = trans('home.all_courses')." ";
        }

        $courseTypes = $this->load_courses($start_at,$category,$category_ids,$types,$sort_courses,$totalResultsTxt,$price_from,$price_to,$type);


        $result = array();
        $result[0] = str_replace('"', '\"', view('front.courses._courses',array("courseTypes"=>$courseTypes,"containerType"=>$containerType, "more"=>$more))->render());
		return json_encode($result);
	}
	
	public function getReloadProducts(Request $request){
		$catIds = json_decode($request->catIds);
		$type= $request->type;
		$types = json_decode($request->types);
		$category_ids=array_filter($catIds);
		$containerType = $request->containerType;
		
		$price_from = $request->price_from;
		$price_to = $request->price_to;
		
		$sort_courses = $request->sort_courses;
		$cat_id = $request->cat_id;
		
		$totalResultsTxt = "";

        if($type=="category"){
            $category = Category::find($cat_id);
            $cat_trans = $category->category_trans(App('lang'));
            if(empty($cat_trans))
                $cat_trans = $category->category_trans("en");
            $totalResultsTxt = $cat_trans->name." ";
        }else{
            $category = null;
            $cat_trans = null;
            $totalResultsTxt = trans('home.all_courses')." ";
        }

        $courseTypes = $this->load_courses($this->start_at,$category,$category_ids,$types,$sort_courses,$totalResultsTxt,$price_from,$price_to,$type);
        $countCourses = $this->count_courses($category,$category_ids,$types,$price_from,$price_to,$type);

		
		
		$result = array();
		$result[0] = str_replace('"', '\"', view('front.courses._courses',array("courseTypes"=>$courseTypes,"containerType"=>$containerType))->render());
		$result[1] = $countCourses;

        $result[2] = $countCourses.trans('home.results_found_for')." ".$totalResultsTxt;

		return json_encode($result);
	}
	
	public function load_courses($start_at, $table,$category_ids,$types,$sort_courses,&$totalResultsTxt="",$price_from=0,$price_to=0,$type){
        $courseTypes = CourseType::join("courses","courses.id","=","course_types.course_id")
            ->leftJoin("courses_categories","courses_categories.course_id","=","courses.id")
            ->where("courses.active",1);

        if($type=="all-courses"){
            if(!empty($category_ids)){
                $courseTypes->where(function($query1) use ($category_ids,&$totalResultsTxt){
                    $i=0;
                    foreach ($category_ids as $category_id ) {
                        if($i == 0)
                            $query1 = $query1->where('courses_categories.category_id',$category_id);
                        else {
                            $totalResultsTxt .= " ".trans('home.or');
                            $query1 = $query1->orWhere('courses_categories.category_id',$category_id);
                        }
                        $i++;
                        $categoryTemp = Category::find($category_id);
                        $categoryTempTrans = $categoryTemp->category_trans(App("lang"));
                        if(empty($categoryTempTrans))
                            $categoryTempTrans = $categoryTemp->category_trans("en");

                        $totalResultsTxt .= " <strong>" . $categoryTempTrans->name."</strong>";
                    }
                    return $query1;
                });
            }
        }else{
            $courseTypes = $courseTypes->where('courses_categories.category_id',$table->id);
            if($table->id==1){
                $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query2) {
                    $query2->where('course_types.type', '=', 'online');
                });
            }
            if($table->id==2){
                $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query2) {
                    $query2->where('course_types.type', '=', 'classroom');
                });
            }
        }

        if(!empty($types)&&count($types)==1){
            $courseTypes->where(function($query1) use ($types,&$totalResultsTxt){
                $i=0;
                foreach ($types as $type1 ) {
                    if($i == 0){
                        if($type1=="online")
                            $query1 = $query1->whereHas('couseType_variations', function ($query2) {
                                $query2->where('course_types.type', '=', 'online');
                            });
                        else{
                            $query1 = $query1->whereHas('couseType_variations', function ($query2) {
                                $now = date("Y-m-d");
                                $query2->where('course_types.type', '=', 'classroom')
                                    ->where('coursetype_variations.date_from', '>=', $now);
                            });
                        }
                        $totalResultsTxt .=" ". trans('home.and')." ".trans('home.type')." : (<strong>" . trans('home.'.$type1)."</strong>";
                    }else {
                        if($type1=="online")
                            $query1 = $query1->orWhereHas('couseType_variations', function ($query2) {
                                $query2->where('course_types.type', '=', 'online');
                            });
                        else{
                            $query1 = $query1->orWhereHas('couseType_variations', function ($query1) {
                                $now = date("Y-m-d");
                                $query1->where('course_types.type', '=', 'classroom')
                                    ->where('coursetype_variations.date_from', '>=', $now);
                            });
                        }
                        $totalResultsTxt .=" ". trans('home.or')." "." <strong>" . trans('home.'.$type1)."</strong>";
                    }
                    $i++;
                }
                $totalResultsTxt.=")";
                return $query1;
            });
        }else{
            $courseTypes = $courseTypes->where(function($query) {
                $query->whereHas('couseType_variations', function ($query1) {
                    $query1->where('course_types.type', '=', 'online');
                })->orWhereHas('couseType_variations', function ($query1) {
                        $now = date("Y-m-d");
                        $query1->where('course_types.type', '=', 'classroom')
                            ->where('coursetype_variations.date_from', '>=', $now);
                    });
            });
        }

        if($price_from!=0 || $price_to!=0){
            $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query1) use($price_from,$price_to){
                $query1->whereBetween("coursetype_variations.price",array($price_from,$price_to));
            });
            $totalResultsTxt .= trans('home.price_from')." <strong>".$price_from." </strong> ".trans('home.to')." <strong>".$price_to." </strong>";
        }
        if($sort_courses){
            $totalResultsTxt .= " ".trans('home.sort_by')." <strong>" . $sort_courses."</strong>";
            if($sort_courses == "newest")
                $courseTypes = $courseTypes->orderBy('courses.created_at','desc');
            else if($sort_courses == "toprated"){
                $courseTypes = $courseTypes->leftJoin("course_rating","course_rating.course_id","=","courses.id")
                    ->select(DB::raw('CEILING(sum(course_rating.value)/count(course_rating.value)) as rating,course_types.*'))
                    ->groupBy("course_types.id","course_types.course_id","course_types.type","course_types.online_exam_period","course_types.points");
                $courseTypes = $courseTypes->orderBy('rating','desc');
            }else if($sort_courses == "largest"){
                $courseTypes = $courseTypes->orderBy('coursetype_variations.price','desc');
            }else if($sort_courses == "lowest"){
                $courseTypes = $courseTypes->orderBy('coursetype_variations.price','asc');
            }
        }
        $courseTypes = $courseTypes->skip($start_at);
        $courseTypes = $courseTypes->distinct()->take($this->numCourses)->get(['course_types.*']);

        return $courseTypes;
		

	}

	public function count_courses($table,$category_ids,$types,$price_from=0,$price_to=0,$type){
        $courseTypes = CourseType::join("courses","courses.id","=","course_types.course_id")
            ->leftJoin("courses_categories","courses_categories.course_id","=","courses.id")
            ->where("courses.active",1);

        if($type=="all-courses"){
            if(!empty($category_ids)){
                $courseTypes->where(function($query1) use ($category_ids){
                    $i=0;
                    foreach ($category_ids as $category_id ) {
                        if($i == 0)
                            $query1 = $query1->where('courses_categories.category_id',$category_id);
                        else {
                            $query1 = $query1->orWhere('courses_categories.category_id',$category_id);
                        }
                        $i++;
                    }
                    return $query1;
                });
            }
        }else{
            $courseTypes = $courseTypes->where('courses_categories.category_id',$table->id);
            if($table->id==1){
                $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query2) {
                    $query2->where('course_types.type', '=', 'online');
                });
            }
            if($table->id==2){
                $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query2) {
                    $query2->where('course_types.type', '=', 'classroom');
                });
            }
        }

        if(!empty($types)&&count($types)==1){
            $courseTypes->where(function($query1) use ($types){
                $i=0;
                foreach ($types as $type1 ) {
                    if($i == 0){
                        if($type1=="online")
                            $query1 = $query1->where('course_types.type',$type1);
                        else{
                            $query1 = $query1->whereHas('couseType_variations', function ($query2) {
                                $now = date("Y-m-d");
                                $query2->where('course_types.type', '=', 'classroom')
                                    ->where('coursetype_variations.date_from', '>=', $now);
                            });
                        }
                    }else {
                        if($type1=="online")
                            $query1 = $query1->orWhere('course_types.type',$type1);
                        else{
                            $query1 = $query1->orWhereHas('couseType_variations', function ($query1) {
                                $now = date("Y-m-d");
                                $query1->where('course_types.type', '=', 'classroom')
                                    ->where('coursetype_variations.date_from', '>=', $now);
                            });
                        }
                    }
                    $i++;
                }

                return $query1;
            });
        }else{
            $courseTypes = $courseTypes->where(function($query) {
                $query->where('course_types.type', '=', 'online')
                    ->orWhereHas('couseType_variations', function ($query1) {
                        $now = date("Y-m-d");
                        $query1->where('course_types.type', '=', 'classroom')
                            ->where('coursetype_variations.date_from', '>=', $now);
                    });
            });
        }

        if($price_from!=0 || $price_to!=0){
            $courseTypes = $courseTypes->whereHas('couseType_variations', function ($query1) use($price_from,$price_to){
                $query1->whereBetween("coursetype_variations.price",array($price_from,$price_to));
            });
        }
		
		return $courseTypes->distinct()->get(["course_types.*"])->count();
	}


	
	
}
