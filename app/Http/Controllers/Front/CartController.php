<?php

namespace App\Http\Controllers\front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Course;
use App\CourseTypeVariation;
use App\MetaData;
use App\Book;
use App\Quiz;
use App\Packs;

use Session;
use Redirect;
use DB;
use Auth;

class CartController extends Controller
{
    public function getIndex()
    {
        //session()->forget('cart');
        $cart = session()->get('cart');
        //print_r($cart);

        $metaData = MetaData::where("lang", App("lang"))->where("page", "cart")->first();
        $coursediscounts = DB::table('course_discounts')->get();

        return view('front.cart.index', array("cart" => $cart, "metaData" => $metaData, "coursediscounts" => $coursediscounts));
    }

    /*public function getCart(){
		$cart = session()->get('cart');	
		var_dump($cart[0]["products"]);
	}*/

    public function postAddToCart(Request $request)
    {

        if (!($request->exists("book_id") || $request->exists("quiz_id"))) {
            if (isset($request->pack_id)) {
                //echo "afef";
            } else {
                $this->validate($request, [
                    'quantity' => 'required',
                    'coursetypevariation_id' => 'required',
                ], [
                    'coursetypevariation_id.required' => 'لابد من اختيار المدرب...'
                ]);
            }
        }

        $error = 0;
        $message = array();
        $message[1] = "";
        //$error = $this->hasErrorRequest($request);
        //dd($request);

        if ($error == 0) {
            if (session()->has("cart")) {

                $cart = session()->get('cart');
                //print_r($cart);
        
                if ($this->hasproduct($cart, $request)) {
                    /**/
                    $this->updateproduct($cart, $request);
                } else {
                    array_push($cart, $this->newcartpro($request));
                      $course = Course::where('course_lie_id',$cart[0]['course_id'])->first();

                       if(!empty($course))
                         array_push($cart, $this->CoureLie($course));
                    
                }
                session()->put('cart', $cart);
            } else {
                
                $this->initCart($request);
            }
            /****** add files to cart */
            if ($request->hasFile('experience_files')) {
                $a = array();
                foreach ($request->experience_files as $file) {
                    $fileName = $file->getClientOriginalName();
                    $rnd = str_random(4);
                    $fileName = $rnd . $fileName;
                    $file->move('uploads/kcfinder/upload/files/experience/', $fileName);
                    array_push($a, $fileName);
                }
                session()->put('files', $a);
            }
            /****** add certif to cart  */

            if ($request->hasFile('certif_file_296')) {
                $a = array();
                $fileName = $file->getClientOriginalName();
                $rnd = str_random(4);
                $fileName = $rnd . $fileName;
                $file->move('uploads/kcfinder/upload/files/experience/', $fileName);

                array_push($a, $fileName);

                session()->put('files', $a);
            }

            $message[1] = "تم تحديث سلة المشتريات بنجاح...";
        } else {
            $message[1] = trans('home.error_update_cart');
        }

        Session::flash('alert-success', $message[1]);
        return redirect(App('urlLang') . "cart");
    }

    public function postDeletefromcart(Request $request)
    {

        $message = array();
        $message[0] = "success";
        $message[1] = "";
        $cart = session()->get('cart');
        $user = Auth::user();
        foreach ($cart as $key => $cart_pro) {
            if ($request->has("coursetypevariation_id")) {
                if (isset($cart_pro["coursetypevariation_id"]) && $cart_pro["coursetypevariation_id"] == $request->coursetypevariation_id) {
                    if ( $cart_pro["need_experience"] == "yes") {
                        $files = session()->get('files');
                        foreach ($files as $key => $fileName) {
                            $path = 'uploads/kcfinder/upload/files/experience/' . $fileName;
                            unlink($path);
                        }
                        session()->forget('files');
                    }
                    unset($cart[$key]);
                }
            } elseif ($request->has("quiz_id")) {
                if (isset($cart_pro["quiz_id"]) && $cart_pro["quiz_id"] == $request->quiz_id) {
                    unset($cart[$key]);
                }
            } else {
                if (
                    isset($cart_pro["book_id"]) &&
                    $cart_pro["book_id"] == $request->book_id
                ) {
                    unset($cart[$key]);
                }
            }
        }
        session()->put('cart', $cart);
        if (empty($cart)) {
            session()->forget('cart');
            $message[1] = "0";
        } else {
            $quantity = 0;
            foreach ($cart as $key => $cart_pro) {
                $quantity += $cart_pro["quantity"];
            }
            $message[1] = $quantity;
        }
        return $message;
    }

    public function getClear()
    {
        session()->forget('cart');
        return redirect()->back();
    }
    public function postUpdatecart(Request $request)
    {
        $message = array();
        $message[0] = "success";
        $message[1] = "";
        $cart = session()->get('cart');
        foreach ($cart as $key => $cart_pro) {
            $totalProductPrice = $cart_pro["price"];
            $price = 0;
            $total = 0;
            $points = 0;
            if ($request->has("coursetypevariation_id")) {
                if (
                    isset($cart_pro["coursetypevariation_id"]) &&
                    $cart_pro["coursetypevariation_id"] == $request->coursetypevariation_id
                ) {
                    $cart[$key]["quantity"] = $request->quantity;
                    $courseTypeVariation = CourseTypeVariation::findOrFail($request->coursetypevariation_id);


                    if ($courseTypeVariation->courseType->id == 296) {
                        if ($courseTypeVariation->courseType->course->isPayCourse()) {
                            $price = $courseTypeVariation->price / 2;
                        } else {
                            if ($courseTypeVariation->courseType->course->isPayCourseLevel2()) {
                                $price = $courseTypeVariation->price / 2;
                            }
                            if ($courseTypeVariation->courseType->course->isPayPackThree()) {
                                $price = $courseTypeVariation->price / 2;
                            } else {
                                $price = $courseTypeVariation->price;
                            }
                        }
                    } else {
                        $price = $courseTypeVariation->price;
                    }


                    $discount = $courseTypeVariation->courseType->getDiscount($cart[$key]["quantity"]);
                    $total = $cart[$key]["quantity"] * $price;
                    $total = $total - $discount * $total / 100;
                    $points = $courseTypeVariation->courseType->points;

                    $cart[$key]["price"] = $price;
                    $cart[$key]["total"] = $total;
                    $cart[$key]["points"] = $points;
                }
            } elseif ($request->has("quiz_id")) {
                if (
                    isset($cart_pro["quiz_id"]) &&
                    $cart_pro["quiz_id"] == $request->quiz_id
                ) {
                    $cart[$key]["quantity"] = 1;
                }
            } elseif ($request->has("pack_id")) {
                if (
                    isset($cart_pro["pack_id"]) &&
                    $cart_pro["pack_id"] == $request->pack_id
                ) {
                    $cart[$key]["quantity"] = 1;
                }
            } else {
                if (
                    isset($cart_pro["book_id"]) &&
                    $cart_pro["book_id"] == $request->book_id
                ) {
                    $cart[$key]["quantity"] = $request->quantity;
                    $book = Book::findOrFail($request->book_id);
                    $cart_pro["book_id"] = $request->book_id;
                    $price = $book->price;
                    $total = $cart[$key]["quantity"] * $price;
                    $points = $book->points;

                    $cart[$key]["price"] = $price;
                    $cart[$key]["total"] = $total;
                    $cart[$key]["points"] = $points;
                }
            }
        }
        session()->put('cart', $cart);
        $quantity = 0;
        foreach ($cart as $key => $cart_pro) {
            $quantity += $cart_pro["quantity"];
        }
        $message[1] = $quantity;
        return $message;
    }

    public function initCart($request)
    {
        $cart = array();
        array_push($cart, $this->newcartpro($request));
            
            if(isset($cart[0]['course_id']))
        {    $course_lie_id = Course::where('id',$cart[0]['course_id'])->pluck('course_lie_id')->first() ;

            $course = Course::find($course_lie_id);
             
              if(!empty($course))
               array_push($cart, $this->CoureLie($course));
        }

        session()->put('cart', $cart);
    }
    public function hasproduct($cart, $request)
    {
        foreach ($cart as $cart_pro) {

            if (
                isset($cart_pro["coursetypevariation_id"]) &&
                $cart_pro["coursetypevariation_id"] == $request->coursetypevariation_id
            ) {
                return true;
            }
            if (
                isset($cart_pro["quiz_id"]) &&
                $cart_pro["quiz_id"] == $request->quiz_id
            ) {
                return true;
            }
            if (
                isset($cart_pro["book_id"]) &&
                $cart_pro["book_id"] == $request->book_id
            ) {
                return true;
            }
        }
        return false;
    }

    public function updateproduct(&$cartarr, $request)
    {

        foreach ($cartarr as $key => $cart_pro) {
            $totalProductPrice = $cart_pro["price"];
            $price = 0;
            $total = 0;
            $points = 0;
            if ($request->has("coursetypevariation_id")) {
                if (
                    isset($cart_pro["coursetypevariation_id"]) &&
                    $cart_pro["coursetypevariation_id"] == $request->coursetypevariation_id
                ) {
                    $cartarr[$key]["quantity"] += $request->quantity;
                    $courseTypeVariation = CourseTypeVariation::findOrFail($request->coursetypevariation_id);




                    if ($courseTypeVariation->courseType->id == 296) {
                        if ($courseTypeVariation->courseType->course->isPayCourse()) {
                            $price = $courseTypeVariation->price / 2;
                        } else {
                            if ($courseTypeVariation->courseType->course->isPayCourseLevel2()) {
                                $price = $courseTypeVariation->price / 2;
                            }
                            if ($courseTypeVariation->courseType->course->isPayPackThree()) {
                                $price = $courseTypeVariation->price / 2;
                            } else {
                                $price = $courseTypeVariation->price;
                            }
                        }
                    } else {
                        $price = $courseTypeVariation->price;
                    }


                    $discount = $courseTypeVariation->courseType->getDiscount($cartarr[$key]["quantity"]);
                    $total = $cartarr[$key]["quantity"] * $price;
                    $total = $total - $discount * $total / 100;
                    $points = $courseTypeVariation->courseType->points;

                    $cartarr[$key]["price"] = $price;
                    $cartarr[$key]["total"] = $total;
                    $cartarr[$key]["points"] = $points;
                    if ($request->hasFile('experience_files')) {
                        $cartarr[$key]["need_experience"] = "yes";
                    } else {
                        $cartarr[$key]["need_experience"] = "no";
                    }
                    return;
                }
            } elseif ($request->has("quiz_id")) {
                if (
                    isset($cart_pro["quiz_id"]) &&
                    $cart_pro["quiz_id"] == $request->quiz_id
                ) {
                    $cartarr[$key]["quantity"] = 1;

                    return;
                }
            } elseif ($request->has("pack_id")) {
                if (
                    isset($cart_pro["pack_id"]) &&
                    $cart_pro["pack_id"] == $request->pack_id
                ) {
                    $cartarr[$key]["quantity"] = 1;

                    return;
                }
            } else {
                if (
                    isset($cart_pro["book_id"]) &&
                    $cart_pro["book_id"] == $request->book_id
                ) {
                    $cartarr[$key]["quantity"] += $request->quantity;
                    $book = Book::findOrFail($request->book_id);
                    $cart_pro["book_id"] = $request->book_id;
                    $price = $book->price;
                    $total = $cartarr[$key]["quantity"] * $price;
                    $points = $book->points;

                    $cartarr[$key]["price"] = $price;
                    $cartarr[$key]["total"] = $total;
                    $cartarr[$key]["points"] = $points;
                    return;
                }
            }
        }
    }

    public function newcartpro(&$request)
    {
        $cart_pro = array();
        $price = 0;
        $total = 0;
        $points = 0;
        if ($request->has("coursetypevariation_id")) {
            $courseTypeVariation = CourseTypeVariation::findOrFail($request->coursetypevariation_id);
            $cart_pro["course_id"] = $courseTypeVariation->courseType->course_id;
            $cart_pro["coursetypevariation_id"] = $request->coursetypevariation_id;

            if ($courseTypeVariation->courseType->id == 296) {
                if ($courseTypeVariation->courseType->course->isPayCourse()) {
                    $price = $courseTypeVariation->price / 2;
                } else {
                    if ($courseTypeVariation->courseType->course->isPayCourseLevel2()) {
                        $price = $courseTypeVariation->price / 2;
                    }
                    if ($courseTypeVariation->courseType->course->isPayPackThree()) {
                        $price = $courseTypeVariation->price / 2;
                    } else {
                        $price = $courseTypeVariation->price;
                    }
                }
            } else {
                $price = $courseTypeVariation->price;
            }





            $discount = $courseTypeVariation->courseType->getDiscount($request->quantity);
            $total = $request->quantity * $price;
            $total = $total - $discount * $total / 100;
            $points = $courseTypeVariation->courseType->points;
        } elseif ($request->has("quiz_id")) {
            $quiz = Quiz::findOrFail($request->quiz_id);
            if (isset($request->course_id)) {
                $cart_pro["course_id"] = $request->course_id;
            }
            $cart_pro["quiz_id"] = $request->quiz_id;
            $price = $quiz->price;
            $total = 1 * $price;
            $points = 0;
        } elseif ($request->has("pack_id")) {
            $packs = Packs::findOrFail($request->pack_id);
            $cart_pro["pack_id"] = $request->pack_id;
            $price = $packs->prix;
            $total = 1 * $price;
            $points = 0;
        } else {
            $book = Book::findOrFail($request->book_id);
            $cart_pro["book_id"] = $request->book_id;
            $price = $book->price;
            $total = $request->quantity * $price;
            $points = $book->points;
        }

        $cart_pro["quantity"] = $request->quantity;
        $cart_pro["price"] = $price;
        $cart_pro["points"] = $points;
        $cart_pro["total"] = $total;
        /**/
         

        
        if ($request->hasFile('experience_files')) {
            $cart_pro["need_experience"] = "yes";
        } else {
            $cart_pro["need_experience"] = "no";
        }
        return $cart_pro;
    }

    private function CoureLie($course)
    {
      
        $course->courseTypes()->first()->couseType_variations()->first();
       // dd($course->id,$course->courseTypes()->first()->couseType_variations()->first());
        $cart_pro = array();
        $cart_pro["course_id"] = $course->id;
        $cart_pro["coursetypevariation_id"] = $course->courseTypes()->first()->couseType_variations()->first()->id;
        $cart_pro["quantity"] = 1;
        $cart_pro["price"] = $course->courseTypes()->first()->couseType_variations()->first()->price;
        $cart_pro["points"] = 0;
        $cart_pro["need_experience"] = "no";
        $cart_pro["total"] = $course->courseTypes()->first()->couseType_variations()->first()->price;

        return $cart_pro;

    }
}
