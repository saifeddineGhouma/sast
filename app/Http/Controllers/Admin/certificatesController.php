<?php



namespace App\Http\Controllers\Admin;



use App\CourseTypeVariation;

use App\StudentQuiz;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Auth;

use Validator;

use App\Http\Controllers\Controller;

use App\Certificate;

use App\CertificateContent;

use App\Student;

use App\StudentCertificate;

use App\Course;

use App\Order;



include "assets/I18N/Arabic.php";

use I18N_Arabic;



use App\AdminHistory;

use Image;

use File;

use DB;



class certificatesController extends Controller

{

    private $table_name = "certificates";

    private $record_name = "certificate";



	public function __construct() {



    }

	

    public function index(Request $request){

         $certificates = Certificate::search($request)->get();
      //   $certificates = Certificate::search($request)->paginate(10);


	  
  //dd($certificates->count()) ;
      return view('admin.certificates.index',array(

          "certificates"=>$certificates,

          "table_name"=>$this->table_name,"record_name"=>$this->record_name

      ));

    }



    public function test(){

        $serialnumber = rand(100000000, 999999999);

        $barcodeImg = QRcode::png($serialnumber,"test.png", QR_ECLEVEL_L, 3,2);

        echo $barcodeImg;

        die;

       $certificate = Certificate::find(188);

        $image_path = asset('uploads/kcfinder/upload/image/'.$certificate->image);

        $img = Image::make($image_path);

        $img->text('This is a example ', 120, 100);



    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create(Request $request)

    {

        $certificate = new Certificate();

        //$currency->status = 'active';

        if (!empty($request->old())) {

            $certificate->fill($request->old());

        }

        $infoCategory = array("fullnamear"=>"الاسم الثلاثي بالعربية",

            "fullnameen"=>"Full Name English",

            "date"=>date("Y-m-d"),

            "serialnumber"=>"54654545465465"

        );

        //enable kcfinder for authenticated users

        session_start();

        $_SESSION['KCFINDER'] = array();

        $_SESSION['KCFINDER']['disabled'] = false;



        return view('admin.certificates.create', [

            'certificate' => $certificate,'infoCategory'=>$infoCategory,

            "table_name"=>$this->table_name,"record_name"=>$this->record_name

        ]);

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param \Illuminate\Http\Request $request

     *

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {



        DB::transaction(function() use($request){



            // save posted data

            if ($request->isMethod('post')) {

                $certificate = new Certificate();



                $rules = $certificate->rules();

                $this->validate($request, $rules);

                $certificate->fill($request->all());



                $this->saveContent($request,$certificate);

				

				$adminhistory = new AdminHistory; 

				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 

				$adminhistory->entree=date('Y-m-d H:i:s'); 

				$adminhistory->description="Insert new certificate"; 

				$adminhistory->save();



//                    $img->text('This is a example ', 120, 100, function($font) {

//                        $font->size(28);

//                        $font->color('#e1e1e1');

//                        $font->align('center');

//                    });



                $request->session()->flash('alert-success', 'Certificate has been Inserted Successfully...');

            }

        });

        return redirect()->action('Admin\certificatesController@index');

    }



    /**

     * Display the specified resource.

     *

     * @param int $id

     *

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param int $id

     *

     * @return \Illuminate\Http\Response

     */

    public function edit(Request $request, $id)

    {

        $certificate = Certificate::findOrFail($id);



        if (!empty($request->old())) {

            $certificate->fill($request->old());

        }

        $infoCategory = array("fullnamear"=>"الاسم الثلاثي بالعربية",

            "fullnameen"=>"Full Name English",

            "date"=>date("Y-m-d"),

            "serialnumber"=>"54654545465465"

        );



        //enable kcfinder for authenticated users

        session_start();

        $_SESSION['KCFINDER'] = array();

        $_SESSION['KCFINDER']['disabled'] = false;



        return view('admin.certificates.edit', [

            'certificate' => $certificate,'infoCategory'=>$infoCategory,

            "table_name"=>$this->table_name,"record_name"=>$this->record_name

        ]);

    }



    /**

     * Update the specified resource in storage.

     *

     * @param \Illuminate\Http\Request $request

     * @param int                      $id

     *

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        DB::transaction(function() use($request,$id) {

            $certificate = Certificate::findOrFail($id);

            $oldImage = $certificate->image;

            // save posted data

            if ($request->isMethod('patch')) {

                $rules = $certificate->rules();



                $this->validate($request, $rules);



                // Save certificate

                $certificate->fill($request->all());

                $this->saveContent($request,$certificate);

				

				$adminhistory = new AdminHistory; 

				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 

				$adminhistory->entree=date('Y-m-d H:i:s'); 

				$adminhistory->description="Update certificate"; 

				$adminhistory->save();

				

                if(!empty($oldImage)&& $certificate->image != $oldImage){

                    File::delete('uploads/kcfinder/upload/image/'. $oldImage);

                }

                $request->session()->flash('alert-success', 'Certificate updated successfully...');

            }

        });

        return redirect()->action('Admin\certificatesController@edit',[$id]);

    }



    public function saveContent($request,$certificate){



        if($request->has("image")){

            $image_path = asset('uploads/kcfinder/upload/image/'.$request->image);



        }else{

            $image_path = asset('uploads/kcfinder/upload/image/'.$certificate->image);

        }

        $img = Image::make($image_path);



        $width = $img->width();

        $image_height = $img->height();

        $new_width = $request->image_width;

        $height = 800 * $image_height /$width;

        $new_height = $new_width * $image_height /$width;



        if($request->image_width != $width){

            $x = pathinfo($request->image);

            $new_image_name = 'certificates/'.$certificate->id."_".str_random(2).'.'.$x['extension'];

            $img->resize($new_width, $new_height);

            $img->save('uploads/kcfinder/upload/image/'.$new_image_name,100);

            $certificate->image = $new_image_name;

        }

        $certificate->image_height = $height;

        $certificate->image_real_height = $new_height;

        $certificate->image_width = $new_width;

//        $certificate->qrcodex = $certificate->x_output($request->qrcodex,$new_width);

//        $certificate->qrcodey = $certificate->y_output($request->qrcodey,$new_height,$height)+5;

        $certificate->qrcodex = $request->qrcodex;

        $certificate->qrcodey = $request->qrcodey;

        $certificate->save();





        $infoCategory = array("fullnamear","fullnameen","date","serialnumber");

        foreach($infoCategory as $category){

            if(!empty($request->get($category."X"))){

                $certificate_content = $certificate->certificate_contents()

                    ->where("fieldcolumn",$category)->first();

                if(empty($certificate_content))

                    $certificate_content = new CertificateContent();

                $certificate_content->certificate_id = $certificate->id;

                $certificate_content->fieldcolumn = $category;

                $certificate_content->fontsize = $request->get($category."Font");

                $certificate_content->fontcolors = $request->get($category."Color");

//                $certificate_content->xposition = $certificate->x_output($request->get($category . "X"), $new_width);

//                $certificate_content->yposition = $certificate->y_output($request->get($category . "Y"), $new_height, $height) + 5;



                $certificate_content->xposition = $request->get($category . "X");

                $certificate_content->yposition = $request->get($category . "Y");



                $certificate_content->xalign = "center";



                if($request->get($category."Checked"))

                    $certificate_content->showoncertificate = 1;

                else

                    $certificate_content->showoncertificate = 0;



                $certificate_content->save();

            }else{

                $certificate_content = $certificate->certificate_contents()

                    ->where("fieldcolumn",$category)->first();

                if(!empty($certificate_content)){

                    $certificate_content->delete();

                }

            }

        }

		

				

		$adminhistory = new AdminHistory; 

		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 

		$adminhistory->entree=date('Y-m-d H:i:s'); 

		$adminhistory->description="Insert new content certificate"; 

		$adminhistory->save();

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param int $id

     *

     * @return \Illuminate\Http\Response

     */

    public  function Delete($id){

       $certificate = Certificate::findOrFail($id);

        if(!empty($certificate->image)){

            File::delete('uploads/kcfinder/upload/image/'. $certificate->image);

        }

        $certificate->delete();

    }



    public function getExport(Request $request,$id){

        $certificate = Certificate::findOrFail($id);



        $courseTypeVariations = CourseTypeVariation::where("coursetype_variations.certificate_id",$id)

            ->get();

//        $courses = Course::join("course_types","course_types.course_id","=","courses.id")

//            ->join("coursetype_variations","coursetype_variations.coursetype_id","=","course_types.id")

//            ->where("coursetype_variations.certificate_id",$id)->get(["courses.*"]);



        return view("admin.certificates.export",[

           "courseTypeVariations"=>$courseTypeVariations,"certificate"=>$certificate,

            "table_name"=>$this->table_name,"record_name"=>$this->record_name

        ]);

    }

    public function getStudents(Request $request){

        $result = array();

        $coursetypevariationId = $request->get("coursetypevariationId");

        $paidOrder_ids = Order::join("order_onlinepayments", "order_onlinepayments.order_id", "=", "orders.id")

            ->where("order_onlinepayments.payment_status", "paid")

            ->groupBy("orders.id","orders.total")

            ->havingRaw("sum(order_onlinepayments.total)>=orders.total")

            ->pluck("orders.id")->all();



        $students = Student::join("orderproducts_students","orderproducts_students.student_id","=","students.id")

            ->join("order_products","order_products.id","=","orderproducts_students.orderproduct_id")

            ->where("order_products.coursetypevariation_id",$coursetypevariationId)

            ->whereIn("order_products.order_id",$paidOrder_ids)->get(["students.*"]);



        $result["students"] = '';



        if(!$students->isEmpty()){

            foreach($students as $student){

                $result["students"] .= '<option value="'.$student->id.'">'.$student->user->full_name_en.'</option>';

            }

        }



        return $result;

    }



    public function postExport(Request $request, $id)

    {

        if(!empty($request->student_ids)||$request->test){   

			DB::transaction(function() use($request,$id) {                

				$dir = 'uploads/kcfinder/upload/image/';                

				$Arabic = new I18N_Arabic('Glyphs');				

				

				if($request->test){    

					$students = Student::where("id", 1)->get(); 

				}else{                    

					$students = Student::whereIn("id", $request->student_ids)->get();                

				}                

				$certificate = Certificate::findOrFail($id);                

				foreach ($students as $student) {                    

					$serialNumber = "";                    

					$image_name="";					                    

					$certificate->export($student,$Arabic,$serialNumber,$image_name);



					if($serialNumber!=""){ 

						$studentCertificate = new StudentCertificate();                        

						$studentCertificate->student_id = $student->id;                       

						$courseTypeVariation = CourseTypeVariation::find($request->coursetypevariation_id);

                        $teacherName ="";                        

						if(!empty($courseTypeVariation)){           

							$studentCertificate->course_id = $courseTypeVariation->courseType->course_id;  

							$studentCertificate->course_name = $courseTypeVariation->courseType->course->course_trans("ar")->name; 

							$teacherName = $courseTypeVariation->teacher->user->full_name_en;   

						}                        

						$studentCertificate->teacher_name = $teacherName;

                        $studentCertificate->serialnumber = $serialNumber;

                        $studentCertificate->image  = $image_name;

                        $studentCertificate->manual = 1;              

						$studentCertificate->active = 0;          

						$studentCertificate->date   = $certificate-> date;      

						$studentCertificate->save();     

					}                

				} 

				

				$adminhistory = new AdminHistory; 

				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 

				$adminhistory->entree=date('Y-m-d H:i:s'); 

				$adminhistory->description="Update content certificate"; 

				$adminhistory->save();           

			});            

			return redirect()->action('Admin\studentscertificatesController@index',["manual"=>1]);        

		}else{            

			session()->flash("alert-danger","plz choose at least one student");        

		}        

		return redirect()->back();



    }



}

