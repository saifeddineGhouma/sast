<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

use App\Currency;
use App\NewsletterSubscriber;
use App\User;
use App\Shop;
use App\Country;
use App\Government;
use App\Agent;
use App\Order;


include "assets/I18N/Arabic.php";

use I18N_Arabic;

use DB;
use PDF;
use Auth;
use Validator;
use Closure;
use App;
use App\MetaData;



class HomeController extends Controller
{
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	public function getCheckemail()
	{
		$email = Input::get('email');
		$flag = NewsletterSubscriber::where('email', $email)->count();
		if ($flag == 0) {
			return  1;
		} else {
			return 0;
		}
	}

	public function getUniqueUsername(Request $request)
	{
		$id =  $request->id;
		$validator = Validator::make(
			$request->toArray(),
			array(
				'username' => '|unique:users,username,' . $id,
			)
		);

		// Finally, return a JSON
		echo json_encode(array(
			'valid' => !$validator->fails(),
		));
	}

	public function getUniqueEmail(Request $request)
	{
		$id =  $request->id;
		$validator = Validator::make(
			$request->toArray(),
			array(
				'email' => '|unique:users,email,' . $id,
			)
		);

		// Finally, return a JSON
		echo json_encode(array(
			'valid' => !$validator->fails(),
		));
	}
	public function getUniqueMobile(Request $request)
	{
		$id =  $request->id;
		$validator = Validator::make(
			$request->toArray(),
			array(
				'mobile' => '|unique:users,mobile,' . $id,
			)
		);

		// Finally, return a JSON
		echo json_encode(array(
			'valid' => !$validator->fails(),
		));
	}

	public function getGovernments(Request $request)
	{
		$result = array();
		$nonzipCountries = array(1, 3, 61, 64, 100, 106, 107, 112, 126, 136, 176, 186, 192, 195, 209);

		$countryId = $request->get("countryId");

		$governments = Government::where('country_id', $countryId)->get();

		$result["governments"] = '<option value="">--- Please Select ---</option>';

		if (!$governments->isEmpty()) {
			foreach ($governments as $government) {
				if (isset($government->government_trans(App("lang"))->name))
					$name = $government->government_trans(App("lang"))->name;
				else {
					$name = $government->government_trans("en")->name;
				}
				$result["governments"] .= '<option value="' . $government->id . '">' . $name . '</option>';
			}
		}
		$result["nonzip"] = false;
		if (in_array($countryId, $nonzipCountries)) {
			$result["nonzip"] = true;
		}

		return $result;
	}

	public function getAgents(Request $request)
	{
		$result = array();
		$countryId = $request->get("countryId");

		$agents = Agent::where('country_id', $countryId)->get();


		$result["agents"] = '<option value="">--- Please Select ---</option>';
		if (!$agents->isEmpty()) {
			$result['table_agents'] = '<table class="table table-bordered ">
                                    <thead>
                                    <tr>
                                        <th>اسم الوكيل</th>
                                        <th>الهاتف</th>
                                        <th>الايميل</th>
                                    </tr>
                                    </thead>
                                    <tbody>';
			foreach ($agents as $agent) {
				$result["agents"] .= '<option value="' . $agent->id . '">' . $agent->name . '</option>';
				$result['table_agents'] .= '<tr>';
				$result['table_agents'] .= '<td>' . $agent->name . '</td>';
				$result['table_agents'] .= '<td>' . $agent->mobile . '</td>';
				$result['table_agents'] .= '<td>' . $agent->email . '</td>';
				$result['table_agents'] .= '</tr>';
			}
			$result['table_agents'] .= '</tbody></table>';
		}
		return $result;
	}

	public function getGovernmentsOptions(Request $request)
	{
		$countryId = $request->get("countryId");

		$governments = Government::where('country_id', $countryId)->get();

		echo '<option value="0">All</option>';

		if (!$governments->isEmpty()) {
			foreach ($governments as $government) {
				$govern_trans = $government->government_trans(App("lang"));
				if (!empty($govern_trans))
					$govern_trans = $government->government_trans("en");
				echo '<option value="' . $government->id . '">' . $govern_trans->name . '</option>';
			}
		}
	}



	public function savenewsletter(Request $request)
	{
		$email = $request->email;
		$flag = NewsletterSubscriber::where('email', $email)->count();
		if ($flag == 0) {
		} else {
			echo "<div class='alert alert-danger'>هذا الايميل مشترك من قبل في النشرة البريدية</div>";
			return;
		}

		DB::transaction(function () use ($request) {
			$subscriber = new NewsletterSubscriber();
			$user_id = 0;
			if (Auth::check()) {
				$user_id = Auth::user()->id;
			} else {
				$user = User::where('email', $request->email)->first();
				if (!empty($user))
					$user_id = $user->id;
			}

			if ($user_id != 0)
				$subscriber->user_id = $user_id;
			$subscriber->email = $request->email;
			$subscriber->auth_key = str_random(40);
			$subscriber->save();


			$email = $request->email;
			$subject = App("setting")->settings_trans(App('lang'))->site_name;
			$message1 = "";
			$status = 0;
			try {

				$status = Mail::send(
					'emails.newsletter_confirm',
					['subject' => $subject, 'message1' => $message1, 'email' => $email, 'auth_key' => $subscriber->auth_key],
					function ($message) use ($email, $subject) {
						$message->to($email)->subject($subject);
					}
				);

				echo "<div class='alert alert-success'>" . trans('home.success_subscribe_newsletter_activate') . "</div>";
			} catch (\Exception $e) {
				echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
			}
		});
	}

	public function getReport($id)
	{
		$order = Order::findOrFail($id);

		return view("front.home.report", array("order" => $order));
	}

	public function getPDF($idd, $client)
	{

		// id client
		$users = User::get();
		foreach ($users as $userss) {
			if ($client == md5($userss->id)) {
				$idclient = $userss->id;
			}
		}
		// id orders
		$Orders = Order::get();
		foreach ($Orders as $orderss) {
			if ($idd == md5($orderss->id)) {
				$idorder = $orderss->id;
			}
		}

		$user = user::findOrFail($idclient);
		$order = Order::findOrFail($idorder);


		return view("front.home.pdf", array("order" => $order, "user" => $user));
	}

	public function convertToPDF($idd, $client)
	{

		$users = User::get();
		foreach ($users as $userss) {
			if ($client == md5($userss->id)) {
				$idclient = $userss->id;
			}
		}
		// id orders 
		$Orders = Order::get();
		foreach ($Orders as $orderss) {
			if ($idd == md5($orderss->id)) {
				$idorder = $orderss->id;
			}
		}

		$user = user::findOrFail($client);
		$order = Order::findOrFail($idd);

		$pdf = PDF::loadView('front.home.pdfPrint', compact('users', 'Orders', 'user', 'order'));

		$path = public_path('pdfFile');
		$fileName =  $order['id'] . '.' . 'pdf';
		$pdf->save($path . '/' . $fileName);
		return $pdf->stream();
	}
	public function getDescriptionCourse()
	{
 
		return view("front.home.description_course");
	}


	public function downloadDemandeStage()
	{
       // return response()->download('uploads/kcfinder/upload/image/stage/Demande de stage SAST.pdf');

		return response()->download('uploads/kcfinder/upload/image/stage/Demande de stage SAST.pdf');
      
	}
	public function downloadDemandeStageArab()
	{
		//return $user;

		return response()->download('uploads/kcfinder/upload/image/stage/مطلب تربص.pdf');
       // return response()->download('uploads/kcfinder/upload/image/stage/fileEdit1.pdf');
	}
	public function downloadEvaluation()
	{
	    
		return response()->download('uploads/kcfinder/upload/image/stage/GRILLE D EVATUATION DE STAGE DASH.pdf');
	}
	public function downloadEvaluationArab()
	{
       
		return response()->download('uploads/kcfinder/upload/image/stage/جدول تقييم المتدرب.pdf');
	}


	

	public function getPayment(){        
            $checkout = session()->get('checkout'); 
			$user = Auth::user();
			
            return view('front.home.payment_plus',array(
                "checkout"=>$checkout,"user"=>$user
            ));
    }







	/*uasyow*/
	/* 23/10 */
	/* fonction pour manupiler les langue et les traduction */
	public function lang($locale)
	{
		App::setLocale($locale);
		session()->put('locale', $locale);
		return redirect()->back();
	}

}
