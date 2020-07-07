<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\StudentCertificate;

use App\AdminHistory;
use File;
use DB;

class studentscertificatesController extends Controller
{
    private $table_name = "students-certificates";
    private $record_name = "student_certificate";

	public function __construct() {

    }
	
    public function index(Request $request){
        $StudentCertificate = StudentCertificate::where('manual', $request->manual)
                                                ->orderBy('date','DESC')  
                                                ->get();
           
        return view('admin.students-certificates.index',compact('StudentCertificate'),array(
            "table_name"=>$this->table_name,"record_name"=>$this->record_name
         ));
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listingAjax(Request $request)
    {
        $parts = parse_url($request->extra);
        parse_str($parts['path'], $request1);

        $recordsTotal = StudentCertificate::where("manual",$request1['manual'])->count();

        $studentsCertificates = StudentCertificate::search($request)
                            ->where("manual",$request1['manual']);
        $recordsFiltered = $studentsCertificates->count();

        $studentsCertificates = $studentsCertificates->skip($request->start)
                    ->take($request->length)->get();

        $data =array();
        foreach($studentsCertificates as $key=>$item){
            $course_name = $item->course_name;
            if(!is_null($item->course))
                $course_name = $item->course->course_trans('ar')->name;
            $exam_name = $item->exam_name;
            if(!is_null($item->exam))
                $exam_name = $item->exam->quiz_trans('ar')->name;
            $student_name = '';
            if(!is_null($item->student))
                $student_name = $item->student->user->full_name_ar;

            $image = '<a href="'. asset('uploads/kcfinder/upload/image/'.$item->image) .'" target="_blank">
                        <img src="'.asset('uploads/kcfinder/upload/image/'.$item->image).'" alt="no image" width="70px"/></a>';
            if($request1['manual']){
                $row = array(
                    '<input type="checkbox" class="checkbox" data-id="'.$item->id.'">',
                    $image,
                    $student_name,
                    $course_name,
                    $item->serialnumber,
                    $item->getStatus($item->active,$item->id) ,
                    $item->date
                );
            }else{
                $row = array(
                    '<input type="checkbox" class="checkbox" data-id="'.$item->id.'">',
                    $image,
                    $student_name,
                    $course_name,
                    $exam_name,
                    $item->serialnumber,
                    $item->date
                );
            }
            array_push($data,$row);
        }
        $result = array("recordsTotal"=>$recordsTotal,"recordsFiltered"=>$recordsFiltered,"data"=>array_values($data));
        return json_encode($result);
    }
	
    public function envmail(Request $request){
		$studentCertificates = StudentCertificate::where("id",$request->id)->get();
		foreach($studentCertificates as $item){
			//echo "<img src='https://swedish-academy.se/uploads/kcfinder/upload/image/".$item->image."' />";
			$mime_boundary = "----MSA Shipping----" . md5(time());
			$subject = "Swedish Academy : Certificate";
			$headers = "From:Swedish Academy<info@swedish-academy.se> \n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
			$message1 = "--$mime_boundary\n";
			$message1 .= "Content-Type: text/html; charset=UTF-8\n";
			$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
			$message1 .= "<html>\n";
			$message1 .= "<body>";
			$message1 .= "<table width='800'>";
			$message1 .= "<tr>";
			$message1 .= "<td align='right'>";
			$message1 .= "<img src='https://swedish-academy.se/uploads/kcfinder/upload/image/".$item->image."' style'max-width:100%;' />";
			$message1 .= "</td>";
			$message1 .= "</tr>";
			$message1 .= '</table>';
			$message1 .= '</body>';
			$message1 .= '</html>';
					
			mail($item->student->user->email, $subject, $message1, $headers);
		}
		return redirect("admin/students-certificates");
	}
	
    public function sendmail(Request $request){
		$studentCertificates = StudentCertificate::where("id",$request->id)->get();

		foreach($studentCertificates as $item){
			$mime_boundary = "----MSA Shipping----" . md5(time());
			$subject = "Swedish Academy : Certificate";
			$headers = "From:Swedish Academy<noreply@swedish-academy.se> \n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
			$message1 = "--$mime_boundary\n";
			$message1 .= "Content-Type: text/html; charset=UTF-8\n";
			$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
			$message1 .= "<html>\n";
			$message1 .= "<body>";
			$message1 .= "<table width='500'>";
			$message1 .= "<tr>";
			$message1 .= "<td align='right'>";
			$message1 .= "
			مرحبا بكم
			.تعلمكم الاكاديمية السويدية للتدريب الرياضي أنكم أتممتم الدورة بنجاح و نحن نتمنى لكم الموفقية في حياتكم العملية.و قد أرفقنا لكم الشهادة 
			<a href='https://swedish-academy.se/uploads/kcfinder/upload/image/".$item->image."'>انقر هنا</a><br>
			مع تمنياتنا لكم بالنجاح و التوفيق في قادم الأيام";
			$message1 .= "</td>";
			$message1 .= "</tr>";
			$message1 .= '</table>';
			$message1 .= '</body>';
			$message1 .= '</html>';
			mail($item->student->user->email, $subject, $message1, $headers);
		}
		
		return redirect("admin/students-certificates?manual=1");
	}


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete(Request $request){

        foreach($request->delStudent as $certificat){
            $studentCertificate = StudentCertificate::find($certificat);
            $studentCertificate->delete();
        }
        
				
		$adminhistory = new AdminHistory; 
		$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
		$adminhistory->entree=date('Y-m-d H:i:s'); 
		$adminhistory->description="Delete student Certificates"; 
        $adminhistory->save(); 
        return redirect()->back();

    }

    public  function del(){
        
        $post_ids = $_POST['post_id'];
        return redirect('/home');
        foreach($post_ids as $id){ 

            $student = StudentCertificate::find($id);

            $student->delete();
       
        }
				
    }

    public function postUpdatestateajax(Request $request){
        $ID = $request->get("sp");
        $newsate =$request->get("newsate");
        $field = $request->get("field");

        if($newsate=='true'){
            $newsate = 1;
        }else{
            $newsate = 0;
        }

        $studentCertificate = StudentCertificate::find($ID);
        $studentCertificate->$field=$newsate;
        $studentCertificate->update();
    }
    public function changedate(request $request)
    {
        StudentCertificate::where('id', $request['user'])
          ->update(['date' => $request['date']]);
        return redirect()->back();
    }

    public function changestatus(request $request)
    {
       
        if( $request['val'] == null){
            $this->changedate( $request) ;
        }else{
            $val = $request['val'];
            $studentCertificate = StudentCertificate::find($request['id']);
            if($val == '1'){
                $studentCertificate->active = 0;
            }else{
                $studentCertificate->active = 1;
            }
            $studentCertificate->save();
           
        }
         return redirect()->back();
    }

}
