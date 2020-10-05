<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


use App\User;
use App\Course;
use App\StudentStage;
use App\StudentStudyCase ;
use Image;
use Illuminate\Support\Facades\Input;
use App\Notifications\StageFinished;
use Notification;

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
        $admins = \App\Admin::get();
        Notification::send($admins, new StageFinished($user->username, $studentStage));

        if ($studentStage->save()) {
            session()->flash('message', 'لقد تم رفع الملفات ');
           // $request->session()->flash('alert-success', 'course updated successfully...');
            return redirect()->back();
        } else {

            return redirect()->back()->withErrors("يجب عليك تحميل الملفين");
        }
    }
    public function deleteStage($id)
    {
        $path = 'uploads/kcfinder/upload/image/stage/';
        $studentstage = StudentStage::findOrFail($id);
        if(!empty($studentstage->demande_stage))
            unlink($path.$studentstage->demande_stage);
        if(!empty($studentstage->evaluation_stage))
            unlink($path.$studentstage->evaluation_stage);
        $studentstage->delete();
       // $request->session()->flash('alert-success', 'course updated successfully...');
       session()->flash('message', 'لقد تم مسح  الملفات ') ;
        return back() ;
    }
     public function deleteStudycase($id)
    {
        $path = 'uploads/kcfinder/upload/image/studycase/';
        $studenttudycase = StudentStudyCase::findOrFail($id);
        if(!empty($studenttudycase->document))
            unlink($path.$studenttudycase->document);
       
        $studenttudycase->document='';
        $studenttudycase->update() ;
       // $request->session()->flash('alert-success', 'course updated successfully...');
       session()->flash('message', 'لقد تم مسح  الملفات ') ;
        return back() ;
    }
}
// /test.swedish-academy.se/uploads/kcfinder/upload/image/stage
// '/uploads/kcfinder/upload/image/stage/'
