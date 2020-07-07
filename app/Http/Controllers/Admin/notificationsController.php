<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\DepartmentCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use Notification;
use File;
use DB;

class notificationsController extends Controller
{
    private $table_name = "notifications";
    private $record_name = "notification";
    private $link_name = "notifications";

	public function __construct() {

    }
	 
    public function index(Request $request){
   	  $notifications = Auth::guard("admins")->user()->notifications;
	  
      return view('admin.notifications.index',array(
          "notifications"=>$notifications,
          "table_name"=>$this->table_name,"record_name"=>$this->record_name,
          "link_name"=>$this->link_name,
      ));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function postDelete($id){
        Auth::guard("admins")->user()->notifications()->where("id",$id)->first()->delete();
    }
   

}
