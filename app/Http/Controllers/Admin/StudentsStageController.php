<?php

namespace App\Http\Controllers\Admin;

use App\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\StudentStage;
use App\Course;
use App\User;
use File;
use DB;

class StudentsStageController extends Controller
{
    public function __construct()
    {
    }
    public function getStudentStage()
    {
        $stages = StudentStage::all();
        $courses = Course::all();
        $users = User::all();


        return view('admin.stage.index', [
            "stages" => $stages, "courses" => $courses, 'users' => $users
        ]);
    }
    public function UpdateStage($valid, StudentStage $stage)
    {
        $stage->valider = $valid;
        $stage->update();
        return redirect()->back();
    }
    public function ViewDemandeStage(StudentStage $stage)
    {
        return response()->file('uploads/kcfinder/upload/image/stage/' . $stage->demande_stage);
        //	return redirect()->back();
    }

    public function ViewFileStage(StudentStage $stage)
    {
        return response()->file('uploads/kcfinder/upload/image/stage/' . $stage->evaluation_stage);
        //	return redirect()->back();
    }
}
