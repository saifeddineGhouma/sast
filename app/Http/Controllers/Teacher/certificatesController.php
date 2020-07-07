<?php

namespace App\Http\Controllers\Teacher;

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
        $teacher = Auth::guard("teachers")->user()->teacher;

   	  $certificates = $teacher->certificates()->get(["certificates.*"]);
	  
      return view('teachers.certificates.index',array(
          "certificates"=>$certificates,
          "table_name"=>$this->table_name,"record_name"=>$this->record_name
      ));
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
        $teacher = Auth::guard("teachers")->user()->teacher;

        $certificate = $teacher->certificates()->where("certificates.id",$id)->firstOrFail(["certificates.*"]);

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

        return view('teachers.certificates.edit', [
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
                if(!empty($oldImage)&& $certificate->image != $oldImage){
                    File::delete('uploads/kcfinder/upload/image/'. $oldImage);
                }
                $request->session()->flash('alert-success', 'Certificate updated successfully...');
            }
        });
        return redirect()->action('Teacher\certificatesController@edit',[$id]);
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



}
