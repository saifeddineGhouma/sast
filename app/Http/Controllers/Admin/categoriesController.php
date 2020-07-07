<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Category;
use App\CategoryTranslation;

use App\AdminHistory;
use File;
use DB;

class categoriesController extends Controller
{
    private $table_name = "categories";
    private $record_name = "category";

	public function __construct() {

    }
	
    public function index(Request $request){
   	  $categories = Category::search($request)->get();
	  
      return view('admin.categories.index',array(
          "categories"=>$categories,
          "table_name"=>$this->table_name,"record_name"=>$this->record_name
      ));
    }

    public function listingAjax(Request $request)
    {
        //var_dump($request->toArray());
        $categories = Category::search($request)->get();
        $data =array();
        foreach($categories as $category){
            $row = array($category->id,
                $category->category_trans("ar")->name,
                $category->category_trans("ar")->slug,
                $category->category_trans("ar")->short_description,
                date("Y-m-d",strtotime($category->created_at)),
                "");
            array_push($data,$row);
            array_push($data,$row);
        }
        $result = array("recordsTotal"=>16,"recordsFiltered"=>16,"data"=>array_values($data));
        return json_encode($result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $category = new Category();
        $category_trans_en = new CategoryTranslation();
        $category_trans_ar = new CategoryTranslation();
        //$currency->status = 'active';
        if (!empty($request->old())) {
            $category->fill($request->old());
            $category_trans_en->fillByLang($request->old(),"en");
            $category_trans_ar->fillByLang($request->old(),"en");
        }

        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        return view('admin.categories.create', [
            'category' => $category,'category_trans_en'=>$category_trans_en,
            'category_trans_ar'=>$category_trans_ar,
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
                $category = new Category();

                $rules = $category->rules();
                $this->validate($request, $rules);

                $category->fill($request->all());
                $category->save();

                $category_trans = new CategoryTranslation();
                $category_trans->category_id = $category->id;
                $category_trans->fillByLang($request,"en");
                $category_trans->save();

                $category_trans = new CategoryTranslation();
                $category_trans->category_id = $category->id;
                $category_trans->fillByLang($request,"ar");
                $category_trans->save();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Add new category: ".$request->ar_name; 
				$adminhistory->save(); 

                if ($category->save()) {
                    $request->session()->flash('alert-success', 'category has been Inserted Successfully...');
                }
            }
        });
        return redirect()->action('Admin\categoriesController@create');
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
        $category = Category::findOrFail($id);
        $category_trans_en = $category->category_trans("en");
        $category_trans_ar = $category->category_trans("ar");

        if (!empty($request->old())) {
            $category->fill($request->old());
            $category_trans_en->fillByLang($request->old(),"en");
            $category_trans_ar->fillByLang($request->old(),"ar");
        }

        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        return view('admin.categories.edit', [
            'category' => $category,'category_trans_en'=>$category_trans_en,
            'category_trans_ar'=>$category_trans_ar,
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
            $category = Category::findOrFail($id);
			$category_trans_en = $category->category_trans("en");
			$category_trans_ar = $category->category_trans("ar");
           

            // save posted data
            if ($request->isMethod('patch')) {
                $rules = $category->rules();

                $this->validate($request, $rules);

				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				if($category_trans_ar->name!=$request->ar_name) $nomar="<br><strong>Name Arabic:</strong> ".$category_trans_ar->name." -> ".$request->ar_name; else $nomar="";
				if($category_trans_ar->slug!=$request->ar_slug) $slugar="<br><strong>Slug Arabic:</strong> ".$category_trans_ar->slug." -> ".$request->ar_slug; else $slugar="";
				if($category_trans_ar->short_description!=$request->ar_short_description) $ar_short_description="<br><strong>Short description Arabic:</strong> ".$category_trans_ar->short_description." -> ".$request->ar_short_description; else $ar_short_description="";
				if($category_trans_ar->content!=$request->ar_content) $ar_content="<br><strong>Content Arabic:</strong> ".$category_trans_ar->content." -> ".$request->ar_content; else $ar_content="";
				if($category_trans_ar->meta_title!=$request->ar_meta_title) $ar_meta_title="<br><strong>Meta title Arabic:</strong> ".$category_trans_ar->meta_title." -> ".$request->ar_meta_title; else $ar_meta_title="";
				if($category_trans_ar->meta_keyword!=$request->ar_meta_keyword) $ar_meta_keyword="<br><strong>Meta keyword Arabic:</strong> ".$category_trans_ar->meta_keyword." -> ".$request->ar_meta_keyword; else $ar_meta_keyword="";
				if($category_trans_ar->meta_description!=$request->ar_meta_description) $ar_meta_description="<br><strong>Meta description Arabic:</strong> ".$category_trans_ar->meta_description." -> ".$request->ar_meta_description; else $ar_meta_description="";
				
				if($category_trans_en->name!=$request->en_name) $nomen="<br><strong>Name English:</strong> ".$category_trans_en->name." -> ".$request->en_name; else $nomen="";
				if($category_trans_en->slug!=$request->en_slug) $slugen="<br><strong>Slug English:</strong> ".$category_trans_en->slug." -> ".$request->en_slug; else $slugen="";
				if($category_trans_en->short_description!=$request->en_short_description) $en_short_description="<br><strong>Short description English:</strong> ".$category_trans_en->short_description." -> ".$request->en_short_description; else $en_short_description="";
				if($category_trans_en->content!=$request->en_content) $en_content="<br><strong>Content English:</strong> ".$category_trans_en->content." -> ".$request->en_content; else $en_content="";
				if($category_trans_en->meta_title!=$request->en_meta_title) $en_meta_title="<br><strong>Meta title English:</strong> ".$category_trans_en->meta_title." -> ".$request->en_meta_title; else $en_meta_title="";
				if($category_trans_en->meta_keyword!=$request->en_meta_keyword) $en_meta_keyword="<br><strong>Meta keyword English:</strong> ".$category_trans_en->meta_keyword." -> ".$request->en_meta_keyword; else $en_meta_keyword="";
				if($category_trans_en->meta_description!=$request->en_meta_description) $en_meta_description="<br><strong>Meta description English:</strong> ".$category_trans_en->meta_description." -> ".$request->en_meta_description; else $en_meta_description="";
				
				$adminhistory->description="Update category:
											".$nomar."
											".$slugar."
											".$ar_short_description."
											".$ar_content."
											".$ar_meta_title."
											".$ar_meta_keyword."
											".$ar_meta_description."
											".$nomen."
											".$slugen."
											".$en_short_description."
											".$en_content."
											".$en_meta_title."
											".$en_meta_keyword."
											".$en_meta_description."
										   "; 
				$adminhistory->save();
				
                // Save category
                $category->fill($request->all());
                $category->save();

                $category_trans = $category->category_trans("en");
                if(empty($category_trans))
                    $category_trans = new CategoryTranslation();
                $category_trans->category_id = $category->id;
                $category_trans->fillByLang($request, "en");
                $category_trans->save();

                $category_trans = $category->category_trans("ar");
                if(empty($category_trans))
                    $category_trans = new CategoryTranslation();
                $category_trans->category_id = $category->id;
                $category_trans->fillByLang($request, "ar");
                $category_trans->save();

                if ($category->save()) {
                    $request->session()->flash('alert-success', 'category updated successfully...');
                }
            }
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
