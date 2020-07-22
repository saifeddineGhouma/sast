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

class barcodesController extends Controller
{
    private $table_name = "barcodes";
    private $record_name = "barcode";

    public function __construct()
    {
    }

    public function index(Request $request)
    {

        return view('admin.barcodes.index', array(
            "table_name" => $this->table_name, "record_name" => $this->record_name
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

        $students = Student::NotBlocked()->pluck('id');

        $recordsTotal = StudentCertificate::whereIn('student_id', $students)->count();


        $studentsCertificates = StudentCertificate::search($request)->whereIn('student_id', $students);

        $recordsFiltered = $studentsCertificates->count();

        $studentsCertificates = $studentsCertificates->skip($request->start)
            ->take($request->length)->get();

        $data = array();
        foreach ($studentsCertificates as $key => $item) {
            $course_name = $item->course_name;
            if (!is_null($item->course))
                $course_name = $item->course->course_trans('ar')->name;
            $exam_name = $item->exam_name;
            if (!is_null($item->exam))
                $exam_name = $item->exam->quiz_trans('ar')->name;
            $student_name = '';
            if (!is_null($item->student))
                $student_name = $item->student->user->full_name_ar;

            $image = '<a href="' . asset('uploads/kcfinder/upload/image/barcodes/' . $item->serialnumber . "-code.png") . '" target="_blank">
                        <img src="' . asset('uploads/kcfinder/upload/image/barcodes/' . $item->serialnumber . "-code.png") . '" alt="no image" width="70px"/></a>';

            $row = array(
                '<input type="checkbox" class="checkbox" data-id="' . $item->id . '">',
                $image,
                $student_name,
                $course_name,
                $item->serialnumber,
                date("Y-m-d", strtotime($item->created_at))
            );

            array_push($data, $row);
        }
        $result = array("recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => array_values($data));
        return json_encode($result);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete(Request $request)
    {
        $ids = $request->ids;
        $studentCertificates = StudentCertificate::whereIn("id", $ids)->get();
        foreach ($studentCertificates as $studentCertificate) {
            File::delete('uploads/kcfinder/upload/image/barcodes/' . $studentCertificate->serialnumber . "-code.png");
        }

        $adminhistory = new AdminHistory;
        $adminhistory->admin_id = Auth::guard("admins")->user()->id;
        $adminhistory->entree = date('Y-m-d H:i:s');
        $adminhistory->description = "Delete Barcodes";
        $adminhistory->save();
    }
}
