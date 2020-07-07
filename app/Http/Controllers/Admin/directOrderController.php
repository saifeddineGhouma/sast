<?php

namespace App\Http\Controllers\Admin;


use App\Admin;
use App\Http\Controllers\Controller;


use App\Notifications\OrderCreated;
use App\Order;
use App\OrderOnlinepayment;
use App\OrderProduct;
use App\OrderproductStudent;
use App\Student;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\NewsletterSubscriber;
use Notification;
use App\Notifications\UserRegistered;
use App\Notifications\UserConfirm;

use Carbon\Carbon;



class directOrderController extends Controller
{

    public function __construct() {

    }

    private function generatePassword($length = 8) {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $count = mb_strlen($chars);

        for ($i = 0, $result = ''; $i < $length; $i++) {
            $index = rand(0, $count - 1);
            $result .= mb_substr($chars, $index, 1);
        }

        return $result;
    }


    public function index(){
        $courses = DB::table('courses')
            ->leftJoin('course_types', 'courses.id', 'course_types.course_id')
            ->leftJoin('coursetype_variations', 'course_types.id', 'coursetype_variations.coursetype_id')
            ->leftJoin('course_translations', 'courses.id', 'course_translations.course_id')
            ->select(
                'courses.*',
                'course_types.*',
                'coursetype_variations.*',
                'course_translations.*',
                'coursetype_variations.id as coursetype_variations_id')
            ->where('courses.active', 1)
            ->where('coursetype_variations.date_from', '>', Carbon::now())
            ->where('course_types.type', 'classroom')
            ->where('course_translations.lang', 'ar')
            ->where('coursetype_variations.teacher_id', 8077)->get()->toArray();

        $setting = App('setting');
        $tva = $setting->vat;

        return view("admin.direct-order.index",compact('courses', 'tva'));
    }


    public function create(Request $request)
    {
        $rules = array(
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
            );
        $validator = Validator::make(Input::all(),$rules);

        if($validator->fails()){
            return response()->json(array('errors'=>$validator->getMessageBag()->toarray()));
        }
        else{

            $password = $this->generatePassword(6);

            $user = new User();
            $user->username = $request->get('username');
            $user->full_name_en = $request->get('username');
            $user->email = $request->get('email');
            $user->mobile = $request->get('mobile');

            if (App::environment('production'))
                $user->password = bcrypt($password);
            else
                $user->password = bcrypt('123456');

            $user->gender = $request->get('gender');
            $user->nationality = $request->get('nationality');
            $user->address = $request->get('address');
            $user->date_of_birth = $request->get('date_of_birth');
            $user->email_verified = 1;
            $user->save();


            $subscriber = NewsletterSubscriber::where('email',$request->get('email'))->first();
            if(!empty($subscriber)){
                $subscriber->user_id = $user->id;
                $subscriber->save();
            }



            if (App::environment('production')) {
                $admins = Admin::get();
                Notification::send($admins, new UserRegistered($user->id,$user->username));
                $status = \App\Setting::sendSms($user);
                $status = $this->sendEmail($user);
                //$user->notify(new UserConfirm($user));



                $mime_boundary = "----MSA Shipping----" . md5(time());
                $subject = "Swedish Academy: Hi ".$request->get('username').", your credentials are :";
                $headers = "from: Swedish Academy<info@swedish-academy.se>\n";
                $headers .= "MIME-Version: 1.0\n";
                $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
                $message1 = "--$mime_boundary\n";
                $message1 .= "Content-Type: text/html; charset=UTF-8\n";
                $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
                $message1 .= "<html>\n";
                $message1 .= "<body>";
                $message1 .= "<table width='800'>";
                $message1 .= "<tr>";
                $message1 .= "<td>";
                $message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
                $message1 .= "</td>";
                $message1 .= "</tr>";
                $message1 .= "<br> Your credentials are : <br> Email : ".$request->get('email')."<br> Password : ".$password;
                $message1 .= '</body>';
                $message1 .= '</html>';
                mail('sbenhassine098@gmail.com', $subject, $message1, $headers);
            }


            return response()->json(['msg' => 'User successfully created', 'user' => $user], 201);

        }
    }


    public function edit(Request $request) {
        $user = User::find($request->user_id);
        $rules = array(
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'mobile' => 'required',
            'gender' => 'required',
            'nationality' => 'required',
            'address' => 'required',
            'date_of_birth' => 'required',
        );
        $validator = Validator::make(Input::all(),$rules);
        if($validator->fails()){
            return response()->json(array('errors'=>$validator->getMessageBag()->toarray()));
        }
        else{
            $user->username = $request->get('username');
            $user->full_name_en = $request->get('username');
            $user->email = $request->get('email');
            $user->mobile = $request->get('mobile');
            $user->gender = $request->get('gender');
            $user->nationality = $request->get('nationality');
            $user->address = $request->get('address');
            $user->date_of_birth = $request->get('date_of_birth');
            $user->email_verified = 1;
            $user->save();
        }
        return response()->json(['msg' => 'User successfully edited', 'user' => $user]);
    }



    public function createOrder(Request $request) {

        $course_exist = false;

        $user = User::find($request->userInfos['id']);

        $orders_products = DB::table('order_products')
            ->leftJoin('orderproducts_students', 'order_products.id', 'orderproducts_students.orderproduct_id')
            ->where('orderproducts_students.student_id', $request->userInfos['id'])->get()->toArray();

        if ($orders_products) {
            foreach ($orders_products as $order_product){
                if($order_product->course_id == $request->courseInfos['course_id']) {
                    $course_exist = true;
                }
            }
        }


        if(!$course_exist){
            // we create the student
            $studentVerify = Student::find($request->userInfos['id']);
            if(!$studentVerify)
                $student = $this->requestStudent($request->userInfos['id']);
            else
                $student = $studentVerify;

            // we create the order
            $order = $this->requestOrder(
                $request->userInfos['id'],
                $request->courseInfos['totalTVA'],
                $request->courseInfos['total_with_tva']);

            //we create the order online payment
            $order_online_payement = $this->requestOrderOnlinePayement(
                $order->id,
                $request->courseInfos['total_with_tva']
            );

            // we create the order products
            $order_product = $this->requestOrderProduct(
                $order->id,
                $request->courseInfos['course_type_variation_id'],
                $request->courseInfos['course_id'],
                $request->courseInfos['course_price']
            );

            // we create the order_product student
            $order_product_student = $this->requestOrderProductStudent(
                $order_product->id,
                $student->id
            );


            if (App::environment('production')) {
                $user->notify(new OrderCreated($order->id,$order->total,$user->username,$order));
            }

            return response()->json(['msg' => 'Order successfully created'], 201);
        }

        return response()->json(['error' => 'fail','msg' => 'User already registered in this course']);

    }


    public function searchUser(Request $request) {
        if($request->action == 1){
            $users = User::where('email', 'like', '%'.$request->char.'%')->get();
            $rendu = "";
            foreach($users as $user){
                $rendu .= '<li class="list-group-item"><a href="javascript:void(0)" class="email-click" data-user-id="'. $user->id .'">' . $user->email . '</a></li>';
            }
            return $rendu;
        }
        if($request->action == 2){
            $user = User::find($request->user_id);
            return response()->json(['user' => $user]);
        }
    }




    // creation requests :

    private function requestStudent($user_id){
        $student = new Student();
        $student->id = $user_id;
        $student->save();

        return $student;
    }

    private function requestOrder($user_id, $totalTVA, $total_with_tva){
        $order = new Order();
        $order->user_id = $user_id;
        $order->payment_method = "cash";
        $order->vat = $totalTVA;
        $order->total = $total_with_tva;
        $order->save();

        return $order;
    }

    private function requestOrderOnlinePayement($order_id,
                                                $total_with_tva){
        $order_online_payement = new OrderOnlinepayment();
        $order_online_payement->order_id = $order_id;
        $order_online_payement->payment_status = "paid";
        $order_online_payement->total = $total_with_tva;
        $order_online_payement->save();

        return $order_online_payement;
    }


    private function requestOrderProduct($order_id,
                                         $course_type_variation_id,
                                         $course_id,
                                         $course_price){
        $order_product = new OrderProduct();
        $order_product->order_id = $order_id;
        $order_product->coursetypevariation_id = $course_type_variation_id;
        $order_product->course_id = $course_id;
        $order_product->price = $course_price;
        $order_product->total = $course_price;
        $order_product->save();

        return $order_product;
    }

    private function requestOrderProductStudent($order_product_id,
                                                $student_id){
        $order_product_student = new OrderproductStudent();
        $order_product_student->orderproduct_id = $order_product_id;
        $order_product_student->student_id = $student_id;
        $order_product_student->save();

        return $order_product_student;
    }

    // fin creation requests

    private function sendEmail($user){
        $email = $user->email;
        $subject = App("setting")->settings_trans(App("lang"))->site_name;
        $message1 = "";
        $status = 0;
        try {
            $status = Mail::send('emails.user_registered', ['subject'=>$subject,'message1'=>$message1,'email'=>$email,'user'=>$user]
                , function($message) use ($email,$subject)
                {
                    $message->to($email)->subject($subject);
                });

//            return "<div class='alert alert-success'>لقد تمت اعادة ارسال البريد الإلكتروني بنجاح.</div>";
        }catch(\Exception $e){
            return "<div class='alert alert-danger'>".$e->getMessage()."</div>";
        }
    }

}