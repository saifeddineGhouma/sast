<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Book;
use App\BookTranslation;

use App\AdminHistory;
use File;
use DB;

class booksController extends Controller
{
    private $table_name = "books";
    private $record_name = "book";

	public function __construct() {

    }
	
    public function index(Request $request){
   	  $books = Book::search($request)->get();
	  
      return view('admin.books.index',array(
          "books"=>$books,
          "table_name"=>$this->table_name,"record_name"=>$this->record_name
      ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $book = new Book();
        $book_trans_en = new BookTranslation();
        $book_trans_ar = new BookTranslation();
        //$currency->status = 'active';
        if (!empty($request->old())) {
            $book->fill($request->old());
            $book_trans_en->fillByLang($request->old(),"en");
            $book_trans_ar->fillByLang($request->old(),"en");
        }

        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        return view('admin.books.create', [
            'book' => $book,'book_trans_en'=>$book_trans_en,
            'book_trans_ar'=>$book_trans_ar,
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
                $book = new Book();

                $rules = $book->rules();
                $this->validate($request, $rules);

                $book->fill($request->all());
                $book->save();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Insert new Book"; 
				$adminhistory->save(); 

                $book_trans = new BookTranslation();
                $book_trans->book_id = $book->id;
                $book_trans->fillByLang($request,"en");
                $book_trans->save();

                $book_trans = new BookTranslation();
                $book_trans->book_id = $book->id;
                $book_trans->fillByLang($request,"ar");
                $book_trans->save();

                if ($book->save()) {
                    $request->session()->flash('alert-success', 'book has been Inserted Successfully...');
                }
            }
        });
        return redirect()->action('Admin\booksController@create');
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
        $book = Book::findOrFail($id);
        $book_trans_en = $book->book_trans("en");
        $book_trans_ar = $book->book_trans("ar");

        if (!empty($request->old())) {
            $book->fill($request->old());
            $book_trans_en->fillByLang($request->old(),"en");
            $book_trans_ar->fillByLang($request->old(),"ar");
        }

        //enable kcfinder for authenticated users
        session_start();
        $_SESSION['KCFINDER'] = array();
        $_SESSION['KCFINDER']['disabled'] = false;

        return view('admin.books.edit', [
            'book' => $book,'book_trans_en'=>$book_trans_en,
            'book_trans_ar'=>$book_trans_ar,
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
            $book = Book::findOrFail($id);

            // save posted data
            if ($request->isMethod('patch')) {
                $rules = $book->rules();

                $this->validate($request, $rules);

                // Save book
                $book->fill($request->all());
                $book->save();
		
				$adminhistory = new AdminHistory; 
				$adminhistory->admin_id=Auth::guard("admins")->user()->id; 
				$adminhistory->entree=date('Y-m-d H:i:s'); 
				$adminhistory->description="Update Book: ".$book->book_trans("en")->name; 
				$adminhistory->save(); 

                $book_trans = $book->book_trans("en");
                if(empty($book_trans))
                    $book_trans = new BookTranslation();
                $book_trans->book_id = $book->id;
                $book_trans->fillByLang($request, "en");
                $book_trans->save();

                $book_trans = $book->book_trans("ar");
                if(empty($book_trans))
                    $book_trans = new BookTranslation();
                $book_trans->book_id = $book->id;
                $book_trans->fillByLang($request, "ar");
                $book_trans->save();

                if ($book->save()) {
                    $request->session()->flash('alert-success', 'book updated successfully...');
                }
            }
        });
        return redirect()->action('Admin\booksController@edit',[$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public  function Delete($id){
       Book::findOrFail($id)->delete();
    }
   
   public function uniqueName(Request $request){
		$id =  $request->id;
		$validator=Validator::make($request->toArray(),
					 array(
		            	'name' => '|unique:book_translations,name,'.$id.',book_id',      
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
		            	'slug' => '|unique:book_translations,slug,'.$id.',book_id',      
		            ));		

		// Finally, return a JSON
		echo json_encode(array(
		    'valid' => !$validator->fails(),
		));
	}

}
