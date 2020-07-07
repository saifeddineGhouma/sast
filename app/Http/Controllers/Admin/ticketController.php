<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;
use App\Ticket;

use App\AdminHistory;
use File;
use DB;

class ticketController extends Controller
{

	public function __construct() {

    }
	
    public function index(){
   	  $tickets = Ticket::where("parent", "0")->get();
	  
      return view('admin.ticket.index',array(
          "tickets"=>$tickets
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
        $ticket = Ticket::findOrFail($id);
        $tickets = Ticket::where('parent',$id)->get();

        return view('admin.ticket.edit', [
            'ticket' => $ticket,
			'tickets' => $tickets
        ]);
    }
	
	
	
	public function createTicket(Request $request){
		
		$ticket = new Ticket();
        $ticket->user_id = 0;
        $ticket->parent = $request->ticket_id;
        $ticket->titre = '';
        $ticket->message = $request->message;
        $ticket->save();
		
		if ($ticket->save()) {
				$request->session()->flash('alert-success', 'Ticket updated successfully...');
			}
		return redirect()->action('Admin\ticketController@index');
	}
	
	public function closeTicket(Request $request, $id){
		$ticket = Ticket::find($id);
		$ticket->resolu = 3;
		$ticket->save();
		return redirect()->action('Admin\ticketController@index');
	}
}
