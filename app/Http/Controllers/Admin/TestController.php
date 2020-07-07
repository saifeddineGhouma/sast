<?php

namespace App\Http\Controllers\Admin;

use App\Certificate;
use App\Course;
use App\CourseCategory;
use App\CourseTypeVariation;
use App\Http\Controllers\Controller;
use App\OrderProduct;
use App\OrderproductStudent;
use App\Student;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use Intervention\Image\Facades\Image;
use QRcode;
use Validator;

use App\Order;
use App\Packs;
use DB;
use Auth;
use Illuminate\Support\Facades\App;

use App\StudentCertificate;

include "assets/I18N/Arabic.php";
use I18N_Arabic;

use Barryvdh\DomPDF\Facade as PDF;



class TestController extends Controller
{

    public function __construct() {
    }

    public function index() {

        $columns = array("id","","total","created_at","");
        $recordsTotal = Order::count();

        $query = DB::table('orders')
            ->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id')
            ->select(DB::raw('order_products.course_id, (select * from courses_categories where category_id = 1)'));

        $parts = parse_url("course_cat=0&order_id=&course_id=0&user_id=&created_at=");

        parse_str($parts['path'], $request1);

        if(isset($request1['course_cat']) && $request1['course_cat']!=0){
            $query = $query->where("courses_categories.category_id",$request1['course_cat']);
        }

        if(isset($request1['course_id']) && $request1['course_id']!=0){
            $query = $query->where("order_products.course_id",$request1['course_id']);
        }

        if(isset($request1['order_id']) && $request1['order_id']!=""){
            $query = $query->where("orders.id",$request1['order_id']);
        }

        if(isset($request1['user_id']) && $request1['user_id']!=0){
            $query = $query->where("orders.user_id",$request1['user_id']);
        }

        if(!empty($request1['created_at'])){
            $created_at =  date("y-m-d",strtotime($request1['created_at']));
            $query = $query->where(DB::raw("DATE(created_at)"),$created_at);
        }


        $orders = $query;
        $recordsFiltered = $orders->count();


        var_dump($recordsTotal);
        var_dump($recordsFiltered);

    }


    public function quer() {
        $query = Order::select('orders.*')
            ->leftJoin('order_products', 'orders.id', '=', 'order_products.order_id')
            ->where('order_products.course_id', '=', 11)
            ->count();

        //var_dump($query);





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
            //->where('coursetype_variations.date_from', '>', Carbon::now())
            ->where('course_types.type', 'classroom')
            ->where('course_translations.lang', 'ar')
            ->where('coursetype_variations.teacher_id', 8077)->get()->toArray();


        $setting = App('setting');
        $tva = $setting->vat;

        var_dump($courses);

        //var_dump($query);

        //var_dump($query);



        /*
        $mime_boundary = "----MSA Shipping----" . md5(time());
        $subject = "Swedish Academy: Hi Sami Ben Hassine, your credentials are :";
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
        $message1 .= "<br> Your credentials are : <br> Email : sbenhassine098@gmail.com<br> Password : 4587JD*";
        $message1 .= '</body>';
        $message1 .= '</html>';
        mail('sbenhassine098@gmail.com', $subject, $message1, $headers);
        */


        /*
        $data = ['name' => 'sami'];
        $pdf = PDF::loadView('admin.direct-order.pdf', $data);
        return $pdf->download('invoice.pdf');  */

        //return view('admin.direct-order.photo');




    }


    public function certificate() {


        $student = Auth::user()->student;

        $Arabic = new I18N_Arabic('Glyphs');
        $serialnumber = "";
        $new_image_name="";
        $date = date("Y-m-d");





        include_once "C:/wamp64/www/backup_sast/assets/phpqrcode/qrlib.php";
        if(!isset($date)) {
            $date = Certificate::find(355)->date;
        }
        $dir = 'uploads/kcfinder/upload/image/';
        $image_path = asset($dir . Certificate::find(355)->image);
        //$file_temp = $_SERVER['DOCUMENT_ROOT']."/".$dir.$this->image;
        $file_temp = "C:/wamp64/www/backup_sast/uploads/kcfinder/upload/image/".Certificate::find(355)->image;   // TODO badel el path hne


        if(file_exists($file_temp)){
            $img = Image::make($image_path);
            $x = pathinfo(Certificate::find(355)->image);

            $serialnumber = rand(1000000, 9999999).rand(10000,99999);
            //$new_image_name = 'students certificates/' . $serialnumber . '.' . $x['extension'];
            $new_image_name = 'students certificates/' . $serialnumber . ' - ' . $student->user->full_name_en . '.' . $x['extension'];  //TODO badalt nom certificat
            foreach (Certificate::find(355)->certificate_contents()->where("showoncertificate", 1)->get() as $certificate_content) {
                $value = "";
                if ($certificate_content->fieldcolumn == "serialnumber") {
                    $value = $serialnumber;
                } elseif ($certificate_content->fieldcolumn == "fullnameen") {
                    $value = strtoupper($student->user->full_name_en);
                } elseif ($certificate_content->fieldcolumn == "date") {
                    $value = $date;
                }
                $y_extra = 0;
                $x_extra = $certificate_content->fontsize * 3;
                if($certificate_content->fontsize<=20 && $certificate_content->fontsize>=16){
                    $y_extra = -5;
                    $x_extra = $certificate_content->fontsize * 2;
                }


                if($certificate_content->fontsize<16 && $certificate_content->fontsize>=10){
                    $x_extra = $certificate_content->fontsize * 1.2;
                    $y_extra = -10;
                    if ($certificate_content->fieldcolumn == "serialnumber"&&Certificate::find(355)->image_width==1000) {
                        $x_extra += 30;
                    }
                    if ($certificate_content->fieldcolumn == "serialnumber"&&Certificate::find(355)->image_width!=1000) {
                        $y_extra -= 40;
                    }
                }


                $xposition = Certificate::find(355)->x_output($certificate_content->xposition+$x_extra,Certificate::find(355)->image_width);
                $yposition = Certificate::find(355)->y_output($certificate_content->yposition+$y_extra,Certificate::find(355)->image_real_height,Certificate::find(355)->image_height)+5;

                $img->text($value, $xposition, $yposition,
                    function ($font) use ($certificate_content) {
                        $font->file('C:/wamp64/www/backup_sast/assets/admin/fonts/arial.ttf');
                        $font->size($certificate_content->fontsize);
                        $font->color($certificate_content->fontcolors);
                        $font->align('center');
                        $font->valign('middle');
                    });
            }
            $img->save($dir . $new_image_name,100);


            //writing barcode image

            if (!is_null(Certificate::find(355)->qrcodex) && !is_null(Certificate::find(355)->qrcodey)) {
                //$barcodeImg = QRcode::png($serialnumber);
                $barcodeImg = $dir."barcodes/".$serialnumber." ".$student->user->full_name_en." -code.png";
                $barcodeText = url(App('urlLang').'certificates/'.$serialnumber);
                $test = QRcode::png($barcodeText,$barcodeImg, QR_ECLEVEL_L,4,2);
                $QRcode = imagecreatefrompng($barcodeImg);

                $qrcodex = Certificate::find(355)->x_output(Certificate::find(355)->qrcodex,Certificate::find(355)->image_width);
                $qrcodey = Certificate::find(355)->y_output(Certificate::find(355)->qrcodey,Certificate::find(355)->image_real_height,Certificate::find(355)->image_height)+5;

                $sourceImage = imagecreatefromjpeg ($dir.$new_image_name);
                imagecopy($sourceImage,$QRcode, $qrcodex,$qrcodey,0,0,imagesx($QRcode), imagesy($QRcode));
                imagejpeg($sourceImage,$dir.$new_image_name,100);
            }

        }


















        $studentCertificate = new StudentCertificate();
        $studentCertificate->student_id = $student->id;
        $studentCertificate->course_id = 24;
        $studentCertificate->course_name = "دورة دليل الاصابات الرياضية الاساسي";

        $studentCertificate->exam_id = 11;
        $studentCertificate->exam_name = "الفصل السادس";

        $teacherName = "Ali Faleh Salman";
        $studentCertificate->teacher_name = $teacherName;

        $studentCertificate->serialnumber = $serialnumber;
        $studentCertificate->image = $new_image_name;
        $studentCertificate->date = date("Y-m-d");
        $studentCertificate->manual = 0;

        $studentCertificate->save();

    }

    public function registerImage(Request $request) {

        $img = $request->get('image');
        $folderPath = "uploads/";

        //$image->move( 'uploads/kcfinder/upload/image/users/' , $imageName );

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];

        $image_base64 = base64_decode($image_parts[1]);
        $fileName = uniqid() . '.png';

        $file = $folderPath . $fileName;
        file_put_contents($file, $image_base64);

        //print_r($fileName);

        return $fileName;

    }

    public function hihi2() {
        return view('admin.direct-order.form');
    }

    public function testEmail() {
        if (App::environment('production')) {
            Mail::send('admin.direct-order.form',['name'=>'sami ben hassine'],function($message) {
                $message->to('sbenhassine098@gmail.com')->subject("استمارة التسجيل");
            });
        }

        return view("admin.direct-order.form");
    }

}
