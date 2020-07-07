<?php

namespace App\Http\Controllers\Front\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use App\NewsletterSubscriber;
use App\Notifications\UserConfirm;
use App\Notifications\UserRegistered;
use Notification;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void 
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'mobile',
        'password',
        'auth_key',
        'auth_mobile_key'
    ];

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required|string|max:255|unique:users',
            'username' => array('Regex:/^[A-Za-z0-9 ]+$/'),
            'email' => 'required|string|email|max:255|unique:users',
            'mobile' => 'required|unique:users',
        ],[
            'mobile.unique'=>'رقم الجوال مسجل من قبل...'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'password' => bcrypt($data['password']),
            'auth_key'         =>  str_random(40),
            'auth_mobile_key'   =>  rand(1111,9999)
        ]);
        $subscriber = NewsletterSubscriber::where('email',$data['email'])->first();
        if(!empty($subscriber)){
            $subscriber->user_id = $user->id;
            $subscriber->save();
        }

        $admins = \App\Admin::get();
        Notification::send($admins, new UserRegistered($user->id,$user->username));

        $status = \App\Setting::sendSms($user);
        $status = $this->sendEmail($user);
        $user->notify(new UserConfirm($user));
        return $user;
    }

    public function sendEmail($user){
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
