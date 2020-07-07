<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use App\Course;
use App\StudentStage;

use Image;
use Illuminate\Support\Facades\Input;

class StudentStageController extends Controller
{
    public function addStage(Request $request, Course $course, User $user)
    {
        $studentStage = new StudentStage;
        $studentStage->course_id = $course->id;
        $studentStage->user_id = $user->id;
        $file = $request->demande_stage;
        if ($request->has('demande_stage')) {
            $name = time() . '_' . $file->getClientOriginalName();
            $path = 'uploads/kcfinder/upload/image/stage/';
            //  Image::make($file->getRealPath())->save($path);
            Input::file('demande_stage')->move($path, $name);
            $studentStage->demande_stage = $name;
        }
        //file evaluation stage 
        $fileEvaluation = $request->evaluation_stage;
        if ($request->has('evaluation_stage')) {
            $name = time() . '_' . $fileEvaluation->getClientOriginalName();
            $path = 'uploads/kcfinder/upload/image/stage/';
            //  Image::make($file->getRealPath())->save($path);
            Input::file('evaluation_stage')->move($path, $name);
            $studentStage->evaluation_stage = $name;
        }

        if ($studentStage->save()) {
            return redirect()->back();
        } else {

            return redirect()->back()->withErrors("يجب عليك تحميل الملفين");
        }
    }
}
// /test.swedish-academy.se/uploads/kcfinder/upload/image/stage
// '/uploads/kcfinder/upload/image/stage/'
