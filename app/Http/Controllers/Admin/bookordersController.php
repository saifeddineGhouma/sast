<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\BookOrder;
use App\User;
use App\Book;

use DB;

class bookordersController extends Controller
{
	public function __construct() {
		
    }
	
    public function getIndex(){
	  $users = User::get();
	  $books = Book::get();

      return view('admin.bookorders.index',array(
      		"users"=>$users,"books"=>$books
		));
    }
   
	
	public function getSearchresults(Request $request)
    {
    	$id = $request->order_id;
		$created_at = $request->created_at;
		$user_id = $request->user_id;
		$book_id = $request->book_id;

    	$orders = BookOrder::with("book");
		if($id!="")
			$orders = $orders->where('id',$id);
		if($book_id != "0"){
			$orders = $orders->where('book_id',$book_id);
		}
        if($user_id != "0")
            $orders = $orders->where('user_id',$user_id);
		if($created_at != ""){
			$created_at =  date("y-m-d",strtotime($created_at));
			$orders = $orders->where(DB::raw("DATE(created_at)"),$created_at);
		}
		
		$orders = $orders->distinct()->get(["book_orders.*"]);
		
        
		$view =  view('admin.bookorders._search_results',	array(
        			'orders'=>$orders
		));
		
		$result = array();
		$result[0] = str_replace('"', '\"', $view);
		
		return json_encode($result);
		
    }
   
   public function getEdit($id){
		$order = BookOrder::findOrFail($id);

	    return view("admin.bookorders.edit",array(
	    	'order'=>$order
		));
		
   }
   public function postEdit(Request $request,$id){
		$order = BookOrder::find($id);
        if($request->paid)
            $order->payment_status = "paid";
        else
            $order->payment_status = "not_paid";
        $order->save();

		Session::flash('alert-success', 'Book Order has been updated succussfully ..');
		return redirect("admin/book-orders/edit/".$id);
   }

   
   public function postDelete($id){
		$order = BookOrder::findOrFail( $id );
		$order->delete();
   }
   

	
	public function getReport($id){
		$order = BookOrder::findOrFail($id);

	    return view("admin.bookorders.report",array("order"=>$order));

	}
	
	


}
