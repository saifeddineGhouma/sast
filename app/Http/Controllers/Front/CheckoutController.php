<?php

namespace App\Http\Controllers\front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Admin;

use App\Order;
use App\OrderProduct;
use App\OrderproductVariation;
use App\OrderOnlinepayment;
use App\OrderproductStudent;
use App\OrderproductUnStudent;

use App\Country;
use App\Government;
use App\UserPoint;
use App\Course;
use App\Book;
use App\Coupon;
use App\Student;
use App\Packs;

use App\Notifications\OrderCreated;
use App\Notifications\OrderCreatedCartPay;
use App\Notifications\OrderBookCreated;
use App\Notifications\OrderCreatedTransfer;
use Notification;

/** All Paypal Details class **/

use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\ExecutePayment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Transaction;
use PayPal\Exception\PayPalConnectionException;

/** Stripe Payment **/

use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;

use Clickatell\Api\ClickatellHttp;
use Illuminate\Support\Facades\Mail;
use SoapClient;

use Validator;
use Session;
use Auth;
use File;
use DB;

class CheckoutController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getIndex()
    {
        $user = Auth::user();
        $countries = Country::orderBy("sort_order")->get();
        /*$governments = null;
        if(!empty($user->government)){
            $governments = Government::where("country_id",$user->government->country_id)->get();
        }*/

        /*get User Points for Paid Orders Only*/
        $paidOrder_ids = Order::join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->where("order_onlinepayments.payment_status", "paid")
            ->groupBy("orders.id", "orders.total")
            ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
            ->pluck("orders.id")->all();

        $userpoints = $user->Points()
            ->join("order_products", "order_products.id", "=", "user_points.orderproduct_id")
            ->join("orders", "orders.id", "=", "order_products.order_id")
            ->whereIn("orders.id", $paidOrder_ids)
            ->select(DB::raw('sum(user_points.points) as sumPoints'))->first()->sumPoints;

        $orderspoints = $user->orders()->whereIn("orders.id", $paidOrder_ids)
            ->select(DB::raw('sum(points) as sumPoints'))->first()->sumPoints;
        $userpoints -= $orderspoints;




        //print_r($user);
        return view('front.checkout.info', array(
            "user" => $user, "countries" => $countries,
            "userpoints" => $userpoints
        ));
    }

    public function postInfo(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'passport' => '|mimes:jpeg,bmp,png|max:5120',
            'email' => 'required|unique:users,email,' . $user->id,
            'mobile' => 'required|unique:users,mobile,' . $user->id,
        ]);
        $user->full_name_ar = $request->full_name_ar;
        $user->full_name_en = $request->full_name_en;
        $user->email = $request->email;
        $user->gender = $request->gender;
        $user->date_of_birth = $request->date_of_birth;
        $user->government = $request->government_id;
        $user->address = $request->address;
        $user->streat           = $request->streat;
        $user->house_number     = $request->house_number;
        $user->clothing_size    = $request->clothing_size;
        $user->mobile           = $request->mobile;
        $user->nationality      = Country::findOrFail($request->country_id)->country_trans("en")->name;
        if (Input::hasFile('passport')) {
            $image = $request->file('passport');
            $imageName = $image->getClientOriginalName();
            if (!empty($user->passport)) {   //delete old image
                File::delete('uploads/kcfinder/upload/image/users/' . $user->passport);
            }
            $rnd = str_random(2);
            $imageName = $rnd . $imageName;
            $image->move('uploads/kcfinder/upload/image/users/', $imageName);
            $user->passport = $imageName;
        }
        $user->save();

        $checkout = array();
        if (session()->has("checkout")) {
            $checkout = session()->get("checkout");
        } else {
            $checkout["address"] = true;
        }
        $cart = session()->get('cart');
        $totalPrice = 0;
        foreach ($cart as $key => $cart_pro) {
            $totalPrice += $cart_pro["total"];
        }



        $setting = App('setting');
        if ($request->points_check && $request->points != "" && $request->points != 0) {
            $paidOrder_ids = Order::join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
                ->where("order_onlinepayments.payment_status", "paid")
                ->groupBy("orders.id", "orders.total")
                ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
                ->pluck("orders.id")->all();

            $userpoints = Auth::user()->Points()->join("order_products", "order_products.id", "=", "user_points.orderproduct_id")
                ->join("orders", "orders.id", "=", "order_products.order_id")
                ->whereIn("orders.id", $paidOrder_ids)
                ->select(DB::raw('sum(user_points.points) as sumPoints'))->first()->sumPoints;
            $orderspoints = Auth::user()->orders()->whereIn("orders.id", $paidOrder_ids)
                ->select(DB::raw('sum(points) as sumPoints'))->first()->sumPoints;
            $userpoints -= $orderspoints;


            $max_points_replace = $setting->max_points_replace;
            $points = $request->points;
            if ($points <= $max_points_replace && $points <= $userpoints) {
                $stepPoints = $setting->points;
                $stepPointsValue = $setting->points_value;

                $checkout["points"] = $points;
                $checkout["points_value"] = $points * $stepPointsValue / $stepPoints;
                if (isset($checkout["points_value"])) {
                    $totalPrice -= $checkout["points_value"];
                    $checkout["totalPrice"] = $totalPrice;
                }
            }
        }


        $checkout["totalPrice"] = $totalPrice;
        if ($request->coupon_check && $request->coupon_number != "") {
            $today = date("Y-m-d");
            $coupon = Coupon::where("coupon_number", $request->coupon_number)
                ->where(DB::raw("date_from"), "<=", $today)
                ->where(DB::raw("date_to"), ">=", $today)
                ->first();
            if (!empty($coupon)) {
                $userExist = false;
                $userCount = 1;
                if ($coupon->users()->count() > 0)
                    $userCount = $coupon->users()->where("users.id", Auth::user()->id)->count();

                if ($userCount > 0) {
                    $orderCount = Order::where("user_id", Auth::user()->id)
                        ->where("coupon_id", $coupon->id)->count();
                    $orderLimits = Order::where("coupon_id", $coupon->id)->count();
                    if ($coupon->limits != 0 && $orderLimits >= $coupon->limits) {
                        session()->flash("alert-danger", trans('home.coupon_expire_limits'));
                        return redirect(App("urlLang") . '/checkout');
                    }
                    if ($orderCount == 0) {
                        if ($coupon->ordertotal_greater < $totalPrice) {
                            $checkout["coupon_id"] = $coupon->id;
                            $checkout["coupon_value"] = $coupon->discount;

                            if (isset($checkout["coupon_value"])) {
                                $valuec = ($totalPrice / 100) * $checkout["coupon_value"];
                                $totalPrice -= $valuec;
                            }
                            $checkout["totalPrice"] = $totalPrice;
                            session()->put('checkout', $checkout);
                        } else {
                            session()->flash("alert-danger", trans('home.your_purchased_products_greater') . $coupon->ordertotal_greater . " $");

                            return redirect(App("urlLang") . '/checkout');
                        }
                    } else {
                        session()->flash("alert-danger", trans('home.you_used_coupon'));
                        return redirect(App("urlLang") . '/checkout');
                    }
                } else {
                    session()->flash("alert-danger", trans('home.coupon_not_valid'));
                    return redirect(App("urlLang") . '/checkout');
                }
            } else {
                session()->flash("alert-danger", trans('home.coupon_not_valid'));
                return redirect(App("urlLang") . '/checkout');
            }
        }


        //echo $totalPrice;
        $setting = App('setting');
        $vat = $setting->vat * $totalPrice / 100;
        $totalPrice += $vat;
        $checkout["totalPrice"] = $totalPrice;
        $checkout["vat"] = $vat;

        //echo $vat;

        if ($totalPrice <= 0) {
            $checkout["payment_method"] = "cash";
            $checkout["totalPrice"] = 0;
        }


        session()->put('checkout', $checkout);
        if ($totalPrice <= 0)
            return redirect(App("urlLang") . 'checkout/details');
        else
            return redirect(App("urlLang") . 'checkout/payment');
    }

    public function getPayment()
    {

        if (session()->has('checkout')) {
            $checkout = session()->get('checkout');
            $cart = session()->get('cart');
            $user = Auth::user();
            $agent = null;
            $agentData = null;
            if (isset($checkout["agent_id"])) {
                $agent = \App\Agent::find($checkout["agent_id"]);
                $agentData = \App\Agent::where("country_id", $agent->country_id)->get();
            }

            $countries = Country::whereHas('agents')->get();
            $country = 0;

            foreach ($cart as $cartt) {
                if (isset($cartt["quiz_id"])) {
                    $queryquiz = "select * from `courses_quizzes` where `quiz_id`=" . $cartt["quiz_id"];
                    $idcourse = DB::select($queryquiz);

                    foreach ($idcourse as $idcourses) {
                        $idcoursee = $idcourses->course_id;
                        break;
                    }

                    $query = "select * from `course_types`, `coursetype_variations` where `course_types`.`course_id`=" . $idcoursee . " and  `course_types`.`id`=`coursetype_variations`.`coursetype_id`";
                    $gouvrcourse = DB::select($query);
                } elseif (isset($cartt["pack_id"])) {
                    $packs = Packs::findOrFail($cartt["pack_id"]);
                    $cour1 = $packs->cours_id1;
                    $cour2 = $packs->cours_id2;
                    //echo $cour1."-".$cour2;
                    $query = "select * from `course_types`, `coursetype_variations` where `course_types`.`course_id`=" . $cour1 . " or `course_types`.`course_id`=" . $cour2 . " and  `course_types`.`id`=`coursetype_variations`.`coursetype_id`";
                    $gouvrcourse = DB::select($query);
                } elseif (isset($cartt["book_id"])) {
                    $books = Book::findOrFail($cartt["book_id"]);
                    $querybooks = "select * from `books` where `id`=" . $cartt["book_id"];

                    $gouvrcourse = DB::select($querybooks);
                    // return $gouvrcourse;
                } else {
                    $query = "select * from `course_types`, `coursetype_variations` where `course_types`.`course_id`=" . $cartt["course_id"] . " and  `course_types`.`id`=`coursetype_variations`.`coursetype_id`";
                    $gouvrcourse = DB::select($query);
                }

                foreach ($gouvrcourse as $gouvrcourses) {
                    if (isset($cartt["book_id"])) {
                    } elseif ($gouvrcourses->govern_id != "") {
                        $queryy = "select * from `governments` where `id`=" . $gouvrcourses->govern_id . "";
                        $countcourse = DB::select($queryy);
                        foreach ($countcourse as $countcourses) {
                            if ($countcourses->country_id == 220) {
                                $country = 1;
                            }
                        }
                    }
                }
            }


            return view('front.checkout.payment', array(
                "checkout" => $checkout, "user" => $user, "countries" => $countries,
                "agent" => $agent, "agentData" => $agentData, "cart" => $cart, "country" => $country
            ));
        } else
            return redirect(App("urlLang") . '/checkout');
    }

    public function postPayment(Request $request)
    {

        $this->validate($request, [
            'banktransfer_image' => '|mimes:jpeg,bmp,png,pdf|max:5120',
            'agent_banktransfer_image' => '|mimes:jpeg,bmp,png|max:5120',
        ], [
            'banktransfer_image.max' => 'صورة الإيداع البنكي لابد أن تكون أقل من 5 ميجا'
        ]);

        if (session()->has('checkout') && session()->has('cart')) {
            $checkout = session()->get('checkout');
            $banktransfer_image = null;
            if (Input::hasFile('banktransfer_image')) {
                $image = $request->file('banktransfer_image');
                $imageName = $image->getClientOriginalName();
                $rnd = str_random(2);
                $imageName = $rnd . $imageName;
                $image->move('uploads/kcfinder/upload/image/bank_transfers/', $imageName);
                $banktransfer_image = $imageName;
            }
            if (Input::hasFile('agent_banktransfer_image')) {
                $image = $request->file('agent_banktransfer_image');
                $imageName = $image->getClientOriginalName();
                $rnd = str_random(2);
                $imageName = $rnd . $imageName;
                $image->move('uploads/kcfinder/upload/image/bank_transfers/', $imageName);
                $banktransfer_image = $imageName;
            }
            $checkout["payment_method"] = $request->payment_method;
            if (!empty($banktransfer_image))
                $checkout["banktransfer_image"] = $banktransfer_image;
            if ($request->payment_method == "agent") {
                $checkout["agent_id"] = $request->agent_id;
            }

            $cart = session()->get('cart');

            session()->put('checkout', $checkout);
            return redirect(App("urlLang") . 'checkout/details');
        } else
            return redirect(App("urlLang") . '/checkout');
    }


    public function getDetails()
    {

        if (session()->has('checkout') && session()->has('cart')) {
            $checkout = session()->get('checkout');

            if (isset($checkout["payment_method"])) {
                $user = Auth::user();
                $cart = session()->get('cart');
                $agent = null;
                if (isset($checkout["agent_id"])) {
                    $agent = \App\Agent::find($checkout["agent_id"]);
                }

                return view('front.checkout.details', array(
                    "user" => $user, "checkout" => $checkout,
                    "cart" => $cart, "agent" => $agent
                ));
            } else
                return redirect(App("urlLang") . '/checkout/payment');
        } else
            return redirect(App("urlLang") . '/checkout');
    }

    public function getConfirm(Request $request)
    {
        $bankAccount = "";
        $msg =  null;
        if(isset($request->error))
            $msg = $request->error;
        return view('front.checkout.confirm', array(
            "bankAccount" => $bankAccount, 'msg' => $msg
        ));
    }

    public function postCheckout(Request $request)
    {
        $message = array();
        $message[0] = "error";
        $message[1] = "لا  يمكن اتمام عملية الدفع";
        $checkout = session()->get('checkout');
        if(empty($checkout))
            return redirect(App('urlLang') . 'checkout/confirm?error=Cart is empty');
        $orderid = 0;
        $orderPaymentId = 0;

        if ($request->payment_method == "stripe") {
            //\Stripe\Stripe::setApiKey("sk_test_PSfjbglO18BoOVT7woXUsXvW");
            \Stripe\Stripe::setApiKey("sk_live_Tt6pEvhlDm3q3BVyd35Rk2tF");
            $this->validate($request, [
                'card_no' => 'required',
                'ccExpiryMonth' => 'required',
                'ccExpiryYear' => 'required',
                'cvvNumber' => 'required',
            ]);
        }


        DB::transaction(function () use ($checkout, $request, &$orderid, &$orderPaymentId) {
            $user = Auth::user();
            $student = $user->student;
            if (empty($student)) {
                $student = new Student();
                $student->id = $user->id;
                $student->save();
            }
            $order = new Order();
            $order->user_id = $user->id;
            $order->payment_method = $checkout["payment_method"];
            if (isset($checkout["points"])) {
                $order->points = $checkout["points"];
                $order->points_value = $checkout["points_value"];
            }
            if (isset($checkout["coupon_id"])) {
                $order->coupon_id = $checkout["coupon_id"];
                $order->coupon_value = $checkout["coupon_value"];
            }
            if (isset($checkout["vat"])) {
                $order->vat = $checkout["vat"];
            }
            $order->total = $checkout["totalPrice"];
            $order->save();
            $orderid = $order->id;



            $orderPayment = new OrderOnlinepayment();
            $orderPayment->order_id = $orderid;
            if ($order->total == 0)
                $orderPayment->payment_status = "paid";
            else
                $orderPayment->payment_status = "not_paid";
            $orderPayment->payment_method = $checkout["payment_method"];
            if (isset($checkout["agent_id"])) {
                $orderPayment->agent_id = $checkout["agent_id"];
            }
            if (isset($checkout["banktransfer_image"]) && ($checkout["payment_method"] == "banktransfer" ||
                $checkout["payment_method"] == "agent"))
                $orderPayment->banktransfer_image = $checkout["banktransfer_image"];
            $orderPayment->total = $order->total;
            $orderPayment->save();
            $orderPaymentId = $orderPayment->id;

            $cart = session()->get('cart');
            foreach ($cart as $key => $cart_pro) {
                $orderProduct = new OrderProduct();
                $orderProduct->order_id = $orderid;
                $promoPoints = 0;
                $product_id = 0;
                if (isset($cart_pro['coursetypevariation_id'])) {
                    $orderProduct->coursetypevariation_id = $cart_pro["coursetypevariation_id"];
                    $orderProduct->course_id = $cart_pro["course_id"];
                    $course = Course::find($cart_pro["course_id"]);
                    if ($cart_pro['need_experience'] == "yes" && !empty(session()->get('files'))) {
                        $orderProduct->files = implode(",", session()->get('files'));
                    }
                    if (!empty($course))
                        $promoPoints = $course->promo_points;
                    $product_id = $cart_pro['coursetypevariation_id'];
                } elseif (isset($cart_pro['quiz_id'])) {
                    if (isset($cart_pro["course_id"])) {
                        $orderProduct->course_id = $cart_pro["course_id"];
                    } else {
                        $orderProduct->quiz_id = $cart_pro["quiz_id"];
                    }
                    $quiz = Quiz::find($cart_pro["quiz_id"]);
                    $product_id = $cart_pro['quiz_id'];
                } elseif (isset($cart_pro['pack_id'])) {
                    $orderProduct->pack_id = $cart_pro["pack_id"];
                    $packs = Packs::find($cart_pro["pack_id"]);
                    $product_id = $cart_pro['pack_id'];
                } else {
                    $orderProduct->book_id = $cart_pro["book_id"];
                    $book = Book::find($cart_pro["book_id"]);
                    if (!empty($book))
                        $promoPoints = $book->promo_points;
                    $product_id = $cart_pro['book_id'];
                }
                $orderProduct->num_students = $cart_pro["quantity"];
                $orderProduct->price = $cart_pro["price"];
                $orderProduct->total = $cart_pro["total"];
                
                $orderProduct->save();

                $orderProductStudent = new OrderproductStudent();
                $orderProductStudent->orderproduct_id = $orderProduct->id;
                $orderProductStudent->student_id = $student->id;
                $orderProductStudent->save();
                for ($i = 2; $i <= $cart_pro['quantity']; $i++) {
                    if ($request->get("std_usernames_" . $product_id . "_" . $i) != "" || $request->get("std_fullNames_" . $product_id . "_" . $i) != "") {
                        $orderProductUnStudent = new OrderproductUnStudent();
                        $orderProductUnStudent->orderproduct_id = $orderProduct->id;
                        $orderProductUnStudent->username = $request->get("std_usernames_" . $product_id . "_" . $i);
                        $orderProductUnStudent->full_name = $request->get("std_fullNames_" . $product_id . "_" . $i);
                        $orderProductUnStudent->email = $request->get("std_emails_" . $product_id . "_" . $i);
                        $orderProductUnStudent->mobile = $request->get("std_mobiles_" . $product_id . "_" . $i);
                        $orderProductUnStudent->save();
                    }
                }


                if ($cart_pro["points"] > 0) {
                    $userpoint = new UserPoint();
                    $userpoint->user_id = Auth::user()->id;
                    $userpoint->orderproduct_id = $orderProduct->id;
                    $userpoint->points = $cart_pro["points"];
                    $userpoint->save();
                }
                if (session()->has('promo') && $promoPoints > 0) {
                    $promoUserId = session()->get('promo');
                    $userpoint = new UserPoint();
                    $userpoint->user_id = $promoUserId;
                    $userpoint->orderproduct_id = $orderProduct->id;
                    $userpoint->points = $promoPoints;
                    $userpoint->save();
                }
            }
        });

        $order = Order::findOrFail($orderid);
        $orderProduct = OrderProduct::where("order_id", $order->id)->first();
        $user = Auth::user();

        $admins = \App\Admin::get();
        if ($order->total != 0.00) {
            //Notification::send($admins, new OrderCreated($order->id,$order->total,$user->username,$order));

            if (isset($orderProduct->book_id)) {
                if ($order->payment_method == "cash" || $order->payment_method == "banktransfer") {
                    $user->notify(new OrderCreated($order->id, $order->total, $user->username, $order));
                    Notification::send($admins, new OrderCreatedTransfer($order->id, $order->total, $user->username, $order));
                } else {
                    $book =  Book::findOrFail($orderProduct->book_id);
                    $user->notify(new OrderBookCreated($order->id, $order->total, $user->username, $order, $book->pdf_book));
                }
            } else {
                if ($order->payment_method == "cash" || $order->payment_method == "banktransfer") {
                    $user->notify(new OrderCreated($order->id, $order->total, $user->username, $order));
                    Notification::send($admins, new OrderCreatedTransfer($order->id, $order->total, $user->username, $order));
                } else {
                    //$user->notify(new OrderCreatedCartPay($order->id, $order->total, $user->username, $order, $orderProduct->coursetype_variation->coursetype_id));
                }
            }
        } else {
            $user->notify(new OrderCreatedCartPay($order->id, $order->total, $user->username, $order, isset($orderProduct->coursetype_variation) ? $orderProduct->coursetype_variation->coursetype_id : null));
        } 

        // 09 06 2020 
        // $user->notify(new CourseStudy($order->id, $order->total, $user->username, $order));

        session()->forget('cart');
        session()->forget('checkout');

        if (
            $order->payment_method == "cash" || $order->payment_method == "banktransfer" ||
            $order->payment_method == "agent"
        ) {
            $message[0] = "success";
            $message[1] = url(App('urlLang') . 'checkout/confirm');
        } else if ($order->payment_method == "paypal") {
            $orderPayment = OrderOnlinepayment::findOrFail($orderPaymentId);
            $total = $orderPayment->total;

            $this->payPaypalOrder($total, $order, $orderPayment, "ajax", $message);
        } else if ($order->payment_method == "stripe") {
            $orderPayment = OrderOnlinepayment::findOrFail($orderPaymentId);
            $total = $orderPayment->total;

            $this->payStripeOrder($total, $order, $orderPayment, "ajax", $message, $request);
            if ($message[0] == "success"){
                return redirect(App('urlLang') . 'checkout/confirm');
            }else{
                return redirect(App('urlLang') . 'checkout/confirm?error='.$message[1]);
            }
        }
        if ($order->hasFiles()) {
            $orderPayment = OrderOnlinepayment::findOrFail($orderPaymentId);
            $orderPayment->payment_status = "for_approval";
        }
        return $message;
    }

    public function payPaypalOrder($total, $order, $orderPayment, $method = null, &$message)
    {
        $client_id = 'AVzRzicnujkHVspY-bH3v9yichRiL8wrRbvD8SzMEnCkzcpUkk6VWO7rAyS58Tpf7XFglc-mu_C9zeJh';


        $secret = 'EMBegLRYjsWlOC-Lyk-q1-nhg0glPnrOgP7Y7zqynTjOPcRuc9NijGPefatq4dKTOJCUnw2V56Xf-70K';


        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($client_id, $secret));
        $this->_api_context->setConfig($paypal_conf['settings']);

        $payer = new Payer();
        $payer->setPaymentMethod('paypal');
        $item_1 = new Item();
        $item_1->setName('order #' . $order->id)
            /** item name **/
            ->setCurrency("USD")
            ->setQuantity(1)
            ->setPrice($total);
        /** unit price **/
        $item_list = new ItemList();
        $item_list->setItems(array($item_1));
        $amount = new Amount();
        $amount->setCurrency("USD")
            ->setTotal($total);
        $transaction = new Transaction();
        $transaction->setAmount($amount)
            ->setItemList($item_list);
        $redirect_urls = new RedirectUrls();
        $urlStr = "";

        $redirect_urls->setReturnUrl(url(App("urlLang") . '/checkout/return'))
            /** Specify return URL **/
            ->setCancelUrl(url('/account/view/' . $order->id));
        $urlStr = url(App("urlLang") . '/checkout/details');


        $payment = new Payment();
        $payment->setIntent('Sale')
            ->setPayer($payer)
            ->setRedirectUrls($redirect_urls)
            ->setTransactions(array($transaction));
        /** dd($payment->create($this->_api_context));exit; **/
        try {
            $payment->create($this->_api_context);
        } catch (\PayPal\Exception\PPConnectionException $ex) {
            if (\Config::get('app.debug')) {
                $message[0] = "error";
                $message[1] = "انتهى وقت محاولة الاتصال";
                if ($method == "ajax") {
                    return;
                } else {
                    return redirect($urlStr);
                }

                /** echo "Exception: " . $ex->getMessage() . PHP_EOL; **/
                /** $err_data = json_decode($ex->getData(), true); **/
                /** exit; **/
            } else {
                $message[0] = "error";
                $message[1] = "Some error occur, sorry for inconvenient";

                if ($method == "ajax") {
                    return;
                } else {
                    return redirect($urlStr);
                }
                /** die('Some error occur, sorry for inconvenient'); **/
            }
        }

        foreach ($payment->getLinks() as $link) {
            if ($link->getRel() == 'approval_url') {
                $redirect_url = $link->getHref();
                break;
            }
        }

        /** add payment ID to session **/
        Session::put('paypal_payment_id', $payment->getId());
        Session::put('order_payment_id', $orderPayment->id);

        if (isset($redirect_url)) {

            /** redirect to paypal **/
            if ($method == "ajax") {
                $message[0] = "success";
                $message[1] = $redirect_url;
                return;
            } else {
                return redirect()->away($redirect_url);
            }
        }
        $message[0] = "error";
        $message[1] = "Unknown error occurred";

        if ($method == "ajax") {
            return;
        } else {
            return redirect($urlStr);
        }
    }

    public function getReturn()
    {
        $client_id = App("setting")->paypal_client_id;
        $secret = App("setting")->paypal_secret;
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($client_id, $secret));
        $this->_api_context->setConfig($paypal_conf['settings']);


        /** Get the payment ID before session clear **/
        $payment_id = empty(Session::get('paypal_payment_id')) ? Input::get('paymentId') : Session::get('paypal_payment_id') ;
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            $result = "<div class='alert alert-danger'>حذف فشل أثناء عملية الدفع</div>";
            Session::flash('payment_status', $result);
            return view("front.site.response");
        }
        try{
            $payment = Payment::get($payment_id, $this->_api_context);
            /** PaymentExecution object includes information necessary **/
            /** to execute a PayPal account payment. **/
            /** The payer_id is added to the request query parameters **/
            /** when the user is redirected from paypal back to your site **/
            $execution = new PaymentExecution();
            $execution->setPayerId(Input::get('PayerID'));
            /**Execute the payment **/
            $result = $payment->execute($execution, $this->_api_context);



            /** dd($result);exit; /** DEBUG RESULT, remove it later **/
            if ($result->getState() == 'approved') {

                /** it's all right **/
                /** Here Write your database logic like that insert record or value in database if you want **/
                $order_payment_id = Session::get('order_payment_id');
                Session::forget('order_payment_id');

                $orderPayment = OrderOnlinepayment::findOrFail($order_payment_id);
                $orderPayment->payment_status = "paid";
                $orderPayment->ref = Input::get('PayerID');
                $orderPayment->payid = $payment_id;
                $orderPayment->save();

                /*Here we may send mail to admins to verify payment validity */
                $admins = \App\Admin::get();
                $order  = Order::find($orderPayment->order_id);
                Notification::send($admins, new OrderCreatedTransfer($order->id,$order->total,$order->user->username,$order, 'Paypal', $payment_id));
                $result = "<div class='alert alert-success'>تمت عملية الدفع بنجاح</div>";
                Session::flash('payment_status', $result);
                return view("front.site.response");
            }
        }catch (PayPalConnectionException $ex) {
            $errors = $ex;        
        }catch(Exception $e){
            $errors = $e;
        }
        $result = "<div class='alert alert-danger'>حذف فشل أثناء عملية الدفع</div>";
        Session::flash('payment_status', $result);
        return view("front.site.response");
    }

    public function payStripeOrder($total, $order, $orderPayment, $method = null, &$message, $request)
    {

        \Stripe\Stripe::setApiKey("sk_live_Tt6pEvhlDm3q3BVyd35Rk2tF");

        // Token is created using Checkout or Elements!
        // Get the payment token ID submitted by the form:

        try {
            $token = $request->get('stripeToken');
            // Charge the user's card:
            $charge = \Stripe\Charge::create(array(
                "amount" => round($total * 100, 0),
                "currency" => "usd",
                "description" => "order #" . $order->id,
                "source" => $token,
            ));
            if ($charge['status'] == 'succeeded') {
                /**
                 * Write Here Your Database insert logic.
                 */
                $orderPayment->payment_status = "paid";
                $orderPayment->ref = $charge["id"];
                $orderPayment->payid = $charge["id"];
                $orderPayment->save();

                $admins = \App\Admin::get();
                Notification::send($admins, new OrderCreatedTransfer($order->id,$order->total,$order->user->username,$order, 'Credit Card', $orderPayment->payid));

                $result = "<div class='alert alert-success'>تمت عملية الدفع بنجاح</div>";
                Session::flash('payment_status', $result);
                $message[0] = "success";
                return;
            } else {
                $message[0] = "error";
                $message[1] = "Money not add in wallet!!";
                return;
            }
        } catch (Exception $e) {
            $message[0] = "error";
            $message[1] = $e->getMessage();
            return;
        } catch (\Cartalyst\Stripe\Exception\CardErrorException $e) {
            $message[0] = "error";
            $message[1] = $e->getMessage();
            return;
        } catch (\Cartalyst\Stripe\Exception\MissingParameterException $e) {
            $message[0] = "error";
            $message[1] = $e->getMessage();
            return;
        } catch (\Stripe\Error\Card $e) {
            $message[0] = "error";
            $message[1] = $e->getMessage();
            return;
        }
    }

    public function postPay(Request $request)
    {
        $orderpayment_id = $request->orderpayment_id;
        $orderPayment = OrderOnlinepayment::findOrFail($orderpayment_id);
        $total = $orderPayment->total;

        return $this->payPaypalOrder($total, $orderPayment->order, $orderPayment, "ajax");
    }


    public function sendEmail($name, $email, $message1, $shop, $order)
    {


        $subject = App("setting")->settings_trans(App("lang"))->site_name . " Order #" . $order->id;
        $status = 0;
        try {
            $status = Mail::send(
                'emails.new_order',
                ['subject' => $subject, 'shop' => $shop, 'message1' => $message1, 'email' => $email, 'name' => $name, 'order' => $order],
                function ($message) use ($email, $subject) {
                    $message->to($email)->subject($subject);
                }
            );
        } catch (\Exception $e) {
            return "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
        return $status;
    }




    /*public function redirectToKnet($data){
		ob_start();
		ini_set("display_errors", "1");
		error_reporting(E_ALL);
			
			require_once "assets/front/knet/com/aciworldwide/commerce/gateway/plugins/e24PaymentPipe.inc.php" ;
			$Pipe = new e24PaymentPipe;
		
		   $Pipe->setAction(1);
		   $Pipe->setCurrency(414);
		   $Pipe->setLanguage("ARA"); //change it to "ARA" for arabic language
		   $Pipe->setResponseURL(url(App('urlLang').'response')); // set your respone page URL
		   $Pipe->setErrorURL(url(App('urlLang').'error')); //set your error page URL
		   $Pipe->setAmt($data["amt"]); //set the amount for the transaction
		   //$Pipe->setResourcePath("/Applications/MAMP/htdocs/php-toolkit/resource/");
		   $Pipe->setResourcePath("assets/front/knet/resource/"); //change the path where your resource file is
		   $Pipe->setAlias("emo"); //set your alias name here
		   $Pipe->setTrackId(rand(1111,9999));//generate the random number here
		 
		   $Pipe->setUdf1("UDF 1"); //set User defined value
		   $Pipe->setUdf2("UDF 2"); //set User defined value
		   $Pipe->setUdf3("UDF 3"); //set User defined value
		   $Pipe->setUdf4("UDF 4"); //set User defined value
		   $Pipe->setUdf5("UDF 5"); //set User defined value
		
		            //get results
				if($Pipe->performPaymentInitialization()!=$Pipe->SUCCESS){
						echo "failed";
						echo "Result=".$Pipe->SUCCESS;
						echo "<br>".$Pipe->getErrorMsg();
						echo "<br>".$Pipe->getDebugMsg();
					//header("location: https://www.yourURL.com/error.php");
				}else {
					echo "success";
					$payID = $Pipe->getPaymentId();
		            $payURL = $Pipe->getPaymentPage();
					echo $Pipe->getDebugMsg();			
					echo $payURL."?PaymentID=".$payID;
					//return redirect()->away($payURL."?PaymentID=".$payID);
					header("location:".$payURL."?PaymentID=".$payID);
				}
		
	}*/
}
