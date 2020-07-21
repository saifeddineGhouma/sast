<?php

namespace App\Http\Controllers\front;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;

use Auth;
use App\Order;
use App\OrderProduct;
use App\OrderOnlinepayment;
use App\Country;
use App\Government;
use App\User;
use App\Book;
use App\Ticket;
use App\Course;
use App\Log;

use App\Notifications\UserInfos;
use App\Notifications\UserPassword;
use Notification;

use Hash;

use File;
use DB;

class AccountController extends Controller
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
        
        $countOrders = Order::where("user_id", $user->id)
            ->count();

        $countPaidCourses = OrderProduct::whereHas('orderproducts_students', function ($query) {
            $query->where("student_id", Auth::user()->id);
        })->join("orders", "order_products.order_id", "=", "orders.id")
            ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->where("order_onlinepayments.payment_status", "paid")
            ->select(DB::raw("sum(order_onlinepayments.total) as sumPayments"), "orders.id", "orders.total")
            ->groupBy("orders.id", "orders.total")
            ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
            ->count();

        $countCertificates = 0;
        $student = $user->student;


        if (!empty($student))
            $countCertificates = $student->students_certificates()->where("active", 1)->count();

        $ordersProducts = OrderProduct::whereHas('orderproducts_students', function ($query) {
            $query->where("student_id", Auth::user()->id);
        })->orderBy("id", "desc")->paginate(5);

        return view("front.account.index", array(
            "countOrders" => $countOrders, "user" => $user, "countPaidCourses" => $countPaidCourses,
            "countCertificates" => $countCertificates, "ordersProducts" => $ordersProducts
        ));
    }

    public function getInfo()
    {
        $user = Auth::user();
        $countries = Country::orderBy("sort_order")->get();
        /*$governments = null;
        if(!empty($user->government)){
            $governments = Government::where("country_id",$user->government->country_id)->get();
        }*/

        return view("front.account.info", array(
            "user" => $user, "countries" => $countries
        ));
    }

    public function getDes(Request $request)
    {
        $user = Auth::user();
        $countries = Country::orderBy("sort_order")->get();

        return view("front.account.desactive", array(
            "user" => $user, "countries" => $countries
        ));
    }

    public function postDes(Request $request)
    {
        $user = Auth::user();

        if ($request->cause == 0) {
            $cause = $request->cause;
        } else {
            $cause = $request->causeautre;
        }
        $mime_boundary = "----MSA Shipping----" . md5(time());
        $subject = "Swedish Academy : Deactivate account";
        $headers = "From:Swedish Academy<info@swedish-academy.se> \n";
        $headers .= "MIME-Version: 1.0\n";
        $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
        $message1 = "--$mime_boundary\n";
        $message1 .= "Content-Type: text/html; charset=UTF-8\n";
        $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
        $message1 .= "<html>\n";
        $message1 .= "<body>";
        $message1 .= "<table width='400'>";
        $message1 .= "<tr>";
        $message1 .= "<td align='right'>";
        $message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'><br>";
        $message1 .= "</td>";
        $message1 .= "</tr>";
        $message1 .= "<tr>";
        $message1 .= "<td align='right'>";
        $message1 .= "مرحبا بكم<br>
						" . $user->username . " قام بغلق حسابه<br>
						السبب: " . $cause . "
					 ";
        $message1 .= "</td>";
        $message1 .= "</tr>";
        $message1 .= '</table>';
        $message1 .= '</body>';
        $message1 .= '</html>';
        mail("info@swedish-academy.se", $subject, $message1, $headers);

        $user->active = 0;
        $user->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action = "User Logged out";
        $log->save();
        Auth::logout();
        return redirect('/');
    }

    public function postInfo(Request $request)
    {
        $user = Auth::user();
        $this->validate($request, [
            'passport' => '|mimes:jpeg,bmp,png|max:5120',
            'image' => '|mimes:jpeg,bmp,png|max:5120',
            'email' => 'required|unique:users,email,' . $user->id,
            'mobile' => 'required|unique:users,mobile,' . $user->id,
        ]);

        $user->full_name_ar     = $request->full_name_ar;
        $user->full_name_en     = $request->full_name_en;
        $user->email            = $request->email;
        $user->gender           = $request->gender;
        $user->date_of_birth    = $request->date_of_birth;
        $user->government       = $request->government_id;
        $user->address          = $request->address;
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
        if (Input::hasFile('image')) {
            $image = $request->file('image');
            $imageName = $image->getClientOriginalName();
            if (!empty($user->image)) {   //delete old image
                File::delete('uploads/kcfinder/upload/image/users/' . $user->image);
            }
            $rnd = str_random(2);
            $imageName = $rnd . $imageName;
            $image->move('uploads/kcfinder/upload/image/users/', $imageName);
            $user->image = $imageName;
        }
        $admins = \App\Admin::get();
        $user->save();
        $log = new Log();
        $log->user_id = $user->id;
        $log->action = "User updated his infos";
        $log->save();
        Notification::send($admins, new UserInfos($user->id, $user->username));

        $request->session()->flash('alert-success', trans('home.succes_update_profil_etudiant'));
        return redirect(App("urlLang") . 'account/info');
    }

    public function getChangePassword()
    {
        $user = Auth::user();

        return view("front.account.password", array(
            "user" => $user
        ));
    }

    public function postSavePassword(Request $request)
    {
        if (Hash::check($request->get('old_password'), Auth::user()->password)) {
            $user = User::find(Auth::user()->id);
            $user->password = bcrypt($request->password);
            $user->save();

            $admins = \App\Admin::get();
            $user->save();
            $log = new Log();
            $log->user_id = $user->id;
            $log->action = "User change password";
            $log->save();
            Notification::send($admins, new UserPassword($user->id, $user->username));
            return trans('home.password_changed_successfully');
            //echo 'success';
        } else {
            return trans('home.old_password_incorrect');
            // echo "old password is incorrect";
        }
    }

    public function getPoints()
    {
        $user =  Auth::user();

        $paidOrder_ids = Order::join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->where("order_onlinepayments.payment_status", "paid")
            ->groupBy("orders.id", "orders.total")
            ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
            ->pluck("orders.id")->all();

        $points = $user->Points()->join("order_products", "order_products.id", "=", "user_points.orderproduct_id")
            ->join("orders", "orders.id", "=", "order_products.order_id")
            ->whereIn("orders.id", $paidOrder_ids)
            ->get(["user_points.*"]);

        return view("front.account.points", array(
            "user" => $user, "points" => $points, "paidOrder_ids" => $paidOrder_ids
        ));
    }

    public function getCoupons()
    {
        $user =  Auth::user();
        $now = date("Y-m-d");
        $usedCoupons = $user->allCoupons()
            ->join("orders", "orders.coupon_id", "=", "coupons.id")
            ->where("orders.user_id", $user->id)
            ->get(["coupons.*"]);
        $usedCouponIds = $user->allCoupons()
            ->join("orders", "orders.coupon_id", "=", "coupons.id")
            ->where("orders.user_id", $user->id)
            ->pluck("coupons.id")->all();

        $expiredCoupons = $user->allCoupons()->where("coupons.date_to", "<", $now)
            ->whereNotIn("coupons.id", $usedCouponIds)
            ->get(["coupons.*"]);

        $nonUsedCoupons = $user->allCoupons()->where("coupons.date_to", ">=", $now)
            ->whereNotIn("coupons.id", $usedCouponIds)
            ->get(["coupons.*"]);

        return view("front.account.mycoupons", array(
            "user" => $user, "expiredCoupons" => $expiredCoupons,
            "usedCoupons" => $usedCoupons, "nonUsedCoupons" => $nonUsedCoupons
        ));
    }

    public function getOrders()
    {
        $myorders = Order::where("user_id", Auth::user()->id)
            ->orderBy("id", "desc")->paginate(20);

        $user =  Auth::user();
        return view("front.account.orders", array(
            "myorders" => $myorders, "user" => $user
        ));
    }

    public function getView($id)
    {
        $order = Order::where("user_id", Auth::user()->id)
            ->where("id", $id)->first();
        if (!empty($order)) {
            $user =  Auth::user();

            return view("front.account.view", array(
                "order" => $order, "user" => $user
            ));
        } else
            abort(404);
    }

    public function postBanktransfer(Request $request)
    {
        $this->validate($request, [
            'banktransfer_image' => '|mimes:jpeg,bmp,png|max:1024'
        ]);
        $orderPayment = OrderOnlinepayment::findOrFail($request->orderpayment_id);
        if (Input::hasFile('banktransfer_image')) {
            $image = $request->file('banktransfer_image');
            $imageName = $image->getClientOriginalName();

            $rnd = str_random(2);
            $imageName = $rnd . $imageName;
            $image->move('uploads/kcfinder/upload/image/bank_transfers/', $imageName);
            $orderPayment->banktransfer_image = $imageName;
            $orderPayment->save();
        }
        return redirect(App('urlLang') . 'account/view/' . $request->order_id);
    }

    public function getCertificates()
    {
        $user =  Auth::user();
        $studentCertificates = null;
        $student = $user->student;
        $course = Course::whereIn('id', [496, 502])->get();
        if (!empty($student))
            $studentCertificates = $student->students_certificates()->where("active", 1)->get();

        return view("front.account.certificates", array(
            "studentCertificates" => $studentCertificates, "user" => $user, "course" => $course
        ));
    }

    public function getBooks()
    {
        $user =  Auth::user();
        $book_ids = Book::join("order_products", "order_products.book_id", "=", "books.id")
            ->join("orderproducts_students", "orderproducts_students.orderproduct_id", "=", "order_products.id")
            ->where("student_id", Auth::user()->id)
            ->join("orders", "order_products.order_id", "=", "orders.id")
            ->join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")
            ->whereNotNull("order_products.book_id")
            ->where("order_onlinepayments.payment_status", "paid")
            ->select(DB::raw("sum(order_onlinepayments.total) as sumPayments"), "orders.total", "books.id")
            ->groupBy("orders.total", "books.id")
            ->havingRaw("sum(order_onlinepayments.total)>=orders.total")
            ->pluck("books.id")->all();
        $books = Book::whereIn("books.id", $book_ids)->get();

        return view("front.account.books", array(
            "books" => $books, "user" => $user
        ));
    }

    public function getEmailVerification()
    {
        $user = Auth::user();
        return view("front.account.verifyform", array("user" => $user));
    }

    public function getMobileVerification()
    {
        $user = Auth::user();
        return view("front.account.verifymobileform", array("user" => $user));
    }

    public function postSendVerifyMessage(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $status = $this->sendEmail($user);

        Session::flash('alert-success', $status);

        return redirect()->back();
    }

    public function postSendVerifyMessageMobile(Request $request)
    {
        $user = User::find(Auth::user()->id);
        $status = \App\Setting::sendSms($user);
        Session::flash('alert-success', "لقد تم إرسال رسالة التأكيد بنجاح...");

        return redirect()->back();
    }



    public function sendEmail($user)
    {
        $email = $user->email;
        $subject = App("setting")->settings_trans(App("lang"))->site_name;
        $message1 = "";
        $status = 0;
        try {
            $status = Mail::send(
                'emails.user_confirm',
                ['subject' => $subject, 'message1' => $message1, 'email' => $email, 'user' => $user],
                function ($message) use ($email, $subject) {
                    $message->to($email)->subject($subject);
                }
            );

            return "<div class='alert alert-success'>لقد تمت اعادة ارسال البريد الإلكتروني بنجاح.</div>";
        } catch (\Exception $e) {
            return "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
        }
    }

    public function getTicket()
    {
        $user = Auth::user();
        $tickets = Ticket::where("user_id", Auth::user()->id)
            ->where("parent", "0")->get();

        return view("front.account.ticket", array(
            "user" => $user, "tickets" => $tickets
        ));
    }

    public function addTicket()
    {
        $user = Auth::user();

        return view("front.account.addticket", array(
            "user" => $user
        ));
    }

    public function createTicket(Request $request)
    {

        $ticket = new Ticket();
        $ticket->user_id = Auth::user()->id;
        $ticket->parent = 0;
        $ticket->titre = $request->titre;
        $ticket->message = $request->message;
        $ticket->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action = "User sent ticket";
        $log->save();
        return redirect(App('urlLang') . 'account/ticket');
    }

    public function add2Ticket(Request $request, $id)
    {
        $user = Auth::user();
        $ticket = Ticket::findOrFail($id);
        $tickets = Ticket::where('parent', $id)
            ->orderby("created_at", "desc")
            ->get();

        return view("front.account.add2ticket", array(
            "user" => $user,
            'ticket' => $ticket,
            'tickets' => $tickets
        ));
    }

    public function create2Ticket(Request $request)
    {

        $ticket = new Ticket();
        $ticket->user_id = Auth::user()->id;
        $ticket->parent = $request->ticket_id;
        $ticket->titre = "";
        $ticket->message = $request->message;
        $ticket->save();

        $log = new Log();
        $log->user_id = Auth::user()->id;
        $log->action = "User update ticket";
        $log->save();
        return redirect(App('urlLang') . 'account/ticket/add/' . $request->ticket_id);
    }

    public function successTicket(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->resolu = 1;
        $ticket->save();
        return redirect(App('urlLang') . 'account/ticket');
    }

    public function warningTicket(Request $request, $id)
    {
        $ticket = Ticket::find($id);
        $ticket->resolu = 2;
        $ticket->save();
        return redirect(App('urlLang') . 'account/ticket');
    }
}
