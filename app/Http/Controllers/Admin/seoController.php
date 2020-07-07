<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Seo;

use App\AdminHistory;
use File;
use DB;
 
class seoController extends Controller
{
    private $table_name = "seo";

	public function __construct() {

    }
	
    public function index(){
   	  $seo = Seo::get();
	  
      return view('admin.seo.index',array(
          "seo"=>$seo
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
        $seo = Seo::findOrFail($id);

        return view('admin.seo.edit', [
            'seo' => $seo
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
            $seo = seo::findOrFail($id);
   		
			DB::transaction(function() use($request,$id){

				$seo = Seo::find($id); 
				$seo->title_seo = $request->title_seo;		   
				$seo->description_seo = $request->description_seo;
				$seo->keyword_seo = $request->keyword_seo;
				$seo->save();
					
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update coupons"; 
				$adminhistory->save();
				
				Session::flash('alert-success', 'SEO Updated Successfully...');
            });
        });
        return redirect()->action('Admin\categoriesController@edit',[$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete($id){
       Category::findOrFail($id)->delete();
    }
   
   public function uniqueName(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'name' => '|unique:categories_translations,name,'.$id.',category_id',      
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}
 	
	public function uniqueSlug(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'slug' => '|unique:categories_translations,slug,'.$id.',category_id',      
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}

}
