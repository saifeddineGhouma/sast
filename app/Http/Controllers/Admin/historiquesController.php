<?php

namespace App\Http\Controllers\Admin;

use App\AdminHistory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use Historiques;
use File;
use DB;

class historiquesController extends Controller
{
    private $table_name = "admin_history";
    private $record_name = "historiques";
    private $link_name = "historiques";

	public function __construct() {

    }
	
    public function index(){
   	  $historiques = AdminHistory::orderBy("id","desc")->get();
	  //print_r($historiques);
	  
      return view('admin.historiques.index',array(
          "historiques"=>$historiques,
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
		$historiques = AdminHistory::findOrFail( $id );
		//handle related records don't forget to handle
		$historiques->delete();
    }
   

}
