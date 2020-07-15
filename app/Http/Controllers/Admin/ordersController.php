<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Controller;

use App\Order;
use App\User;
use App\Student;
use App\Course;
use App\OrderOnlinepayment;
use App\OrderProduct;
use App\Packs;
use App\Category;
use App\Book;

use App\AdminHistory;
use DB;

use Image;
use File;

include "./assets/I18N/Arabic.php";

use I18N_Arabic;

class ordersController extends Controller
{
	public function __construct()
	{
	}

	public function getIndex()
	{
		$users = User::orderBy("created_at", "desc")->get();
		$courses = Course::get();
		$categoris = Category::all();

		return view('admin.orders.index', array(
			"users" => $users, "courses" => $courses, "categories" => $categoris
		));
	}


	public function getSearchresults(Request $request)
	{
		//for order the table
		$columns = array("id", "", "total", "", "created_at", "");
		$recordsTotal = Order::count();
		$orders = Order::search($request);
		$recordsFiltered = $orders->count();

		$order = $request->get("order");
		$column1 = $columns[$order[0]['column']];
		if ($column1 != "")
			$orders = $orders->orderBy($columns[$order[0]['column']], $order[0]['dir']);
		$orders = $orders->skip($request->start)->take($request->length)->get();

		$data = array();
		foreach ($orders as $key => $item) {
			$id = $item->id;
			$id .= "<br/>";
			$total_price = 0;
			$product_details = '';
			$url = "";
			foreach ($item->orderproducts as $orderproduct) {
				if (!empty($orderproduct->course_id) && !empty($orderproduct->course)) {
					$product_details = $orderproduct->course->course_trans(App("lang"))->name;
					if (!empty($orderproduct->coursetype_variation)) {
						$courseTypeVairiation = $orderproduct->coursetype_variation;
						$type = "online";
						if ($courseTypeVairiation->courseType->type == "presence")
							$type = "classroom";
						$product_details .= "<br/>" . $type;
						if (!empty($courseTypeVairiation->teacher))
							$product_details .= " " . $courseTypeVairiation->teacher->teacher_trans(App('lang'))->name;
						$url = url(App('urlLang') . 'courses/' . $courseTypeVairiation->coursetype_id);
					}
				} elseif (!empty($orderproduct->quiz_id) && !empty($orderproduct->quiz)) {
					$quiz_trans = $orderproduct->quiz->quiz_trans(App("lang"));
					if (!empty($quiz_trans)) {
						$product_details = $quiz_trans->name;
						$url = "";
					}
				} elseif ($orderproduct->pack_id != 0) {
					$packs = Packs::findOrFail($orderproduct->pack_id);
					$product_details = $packs->titre;
					$url = url(App('urlLang') . 'packs/' . $packs->id);
				} elseif (!empty($orderproduct->book_id) && !empty($orderproduct->book)) {
					$book_trans = $orderproduct->book->book_trans(App("lang"));
					if (!empty($book_trans)) {
						$product_details = $book_trans->name;
						$url = url(App('urlLang') . 'books/' . $book_trans->slug);
					}
				}
			}
			$id .= '<a href="' . $url . '"> 
						' . $product_details . '
					</a>';
			$username = "";
			if (!empty($item->user)) {
				$username = $item->user->username . "<br/>";
				$username .= $item->user->full_name_ar;
			}

			$total = $item->total . "$<br/>";
			$total .= "Total Paid: $" . $item->totalPaid();

			$facture = "<a href='https://swedish-academy.se/PDF/" . md5($item->id)  . "/" .  md5($item->user->id) . "'> facture </a><br>";

			//	url('admin/orders/edit/' . $item->id)

			$row = array(
				$id,
				$username,
				$total,
				$facture,
				date("Y-m-d", strtotime($item->created_at)),
				'<a href="' . url('admin/orders/edit/' . $item->id) . '">
                        <i class="livicon" data-name="edit" data-size="18" data-loop="true" data-c="#428BCA" data-hc="#428BCA" title="edit order"></i>
					</a>
					<a data-toggle="modal" class="deleteorder" elementId="' . $item->id . '" data-type="' . $item->type . '">
						<i class="livicon" data-name="remove-circle" data-size="18" data-loop="true" data-c="#f56954" data-hc="#f56954" title="delete order"></i>
					</a>
                    '
			);



			array_push($data, $row);
		}
		$result = array("recordsTotal" => $recordsTotal, "recordsFiltered" => $recordsFiltered, "data" => array_values($data));
		return json_encode($result);
	}

	public function getEdit($id)
	{

		$order = Order::findOrFail($id);
		$Arabic = new I18N_Arabic('Glyphs');
		$students = Student::get();


		// foreach (Auth::guard("admins")->user()->unreadnotifications as $notification) {

		// 	if (isset($notification->data['ordercreated']) && $notification->data['ordercreated']['id'] == $id) {
		// 		$notification->markAsRead();
		// 	}
		// }

		$dir = '/assets/admin/img/';
		$image_path = asset($dir . "sast_facture.jpg");
		$img = Image::make("assets/admin/img/sast_facture.jpg");

		$img->text($order->id, 1360, 420, function ($font) {
			$font->file('assets/admin/fonts/arial.ttf');
			$font->size(52);
			$font->color('#000');
			$font->align('center');
			$font->valign('top');
		});
		$img->text(date("d/m/Y"), 2150, 270, function ($font) {
			$font->file('assets/admin/fonts/arial.ttf');
			$font->size(52);
			$font->color('#000');
			$font->align('center');
			$font->valign('top');
		});
		$img->text($order->user->full_name_en, 1600, 750, function ($font) {
			$font->file('assets/admin/fonts/arial.ttf');
			$font->size(32);
			$font->color('#5a5a5a');
			$font->align('left');
			$font->valign('top');
		});
		$img->text($order->user->address, 1600, 910, function ($font) {
			$font->file('assets/admin/fonts/arial.ttf');
			$font->size(32);
			$font->color('#5a5a5a');
			$font->align('left');
			$font->valign('top');
		});
		$img->text($order->user->email, 1600, 1038, function ($font) {
			$font->file('assets/admin/fonts/arial.ttf');
			$font->size(32);
			$font->color('#5a5a5a');
			$font->align('left');
			$font->valign('top');
		});
		$img->text($order->user->mobile, 1600, 1125, function ($font) {
			$font->file('assets/admin/fonts/arial.ttf');
			$font->size(32);
			$font->color('#5a5a5a');
			$font->align('left');
			$font->valign('top');
		});


		$yf = 0;
		$price = 0;
		$total_price = 0;
		foreach ($order->orderproducts as $orderproduct) {
			$img->text($orderproduct->num_students, 125, 1555 + $yf, function ($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			if (!empty($orderproduct->course_id) && !empty($orderproduct->course)) {
				$product_details = $Arabic->utf8Glyphs($orderproduct->course->course_trans(App("lang"))->name);
				if (!empty($orderproduct->coursetype_variation)) {
					$courseTypeVairiation = $orderproduct->coursetype_variation;
					$product_details .= " - " . $courseTypeVairiation->courseType->type;
					if (!empty($courseTypeVairiation->teacher))
						$product_details .= " " . $courseTypeVairiation->teacher->teacher_trans(App('lang'))->name;
				}
			} elseif (!empty($orderproduct->quiz_id) && !empty($orderproduct->quiz)) {
				//	$quiz_trans = $Arabic->utf8Glyphs($orderproduct->quiz->quiz_trans(App("lang")));
				$quiz_trans = $orderproduct->quiz->quiz_trans(App("lang"));
				if (!empty($quiz_trans)) {
					$product_details = $quiz_trans['name'];
				}
			} elseif (!empty($orderproduct->pack_id)) {
				$packs = \App\Packs::findOrFail($orderproduct->pack_id);
				$product_details = $packs->titre;
			} elseif (!empty($orderproduct->book_id) && !empty($orderproduct->book)) {
				$book_trans = $orderproduct->book->book_trans(App("lang"));
				if (!empty($book_trans)) {
					$product_details = $book_trans->name;
				}
			}

			$img->text($product_details, 520, 1555 + $yf, function ($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($orderproduct->total / $orderproduct->num_students, 1315, 1555 + $yf, function ($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$img->text($orderproduct->total, 2085, 1555 + $yf, function ($font) {
				$font->file('assets/admin/fonts/arial.ttf');
				$font->size(32);
				$font->color('#5a5a5a');
				$font->align('left');
				$font->valign('top');
			});
			$yf = $yf + 105;
			$total_price += $orderproduct->total;
		}

		$img->text($order->vat, 2000, 2575, function ($font) {
			$font->file('assets/admin/fonts/arial.ttf');
			$font->size(32);
			$font->color('#5a5a5a');
			$font->align('left');
			$font->valign('top');
		});
		$img->text($order->total, 2000, 2695, function ($font) {
			$font->file('assets/admin/fonts/arial.ttf');
			$font->size(32);
			$font->color('#5a5a5a');
			$font->align('left');
			$font->valign('top');
		});

		$img->save('uploads/kcfinder/upload/image/orders/orders' . $id . '.jpg', 100);

		return view("admin.orders.edit", array(
			'order' => $order, 'students' => $students
		));
	}
	public function postEdit(Request $request, $id)
	{
		$order = Order::find($id);
		foreach ($order->orderproducts as $orderproduct) {
			$orderproduct->students()->sync((array) $request->get("student_ids_" . $orderproduct->id));
		}

		$adminhistory = new AdminHistory;
		$adminhistory->admin_id = Auth::guard("admins")->user()->id;
		$adminhistory->entree = date('Y-m-d H:i:s');
		$adminhistory->description = "Update order N°: " . $id;
		$adminhistory->save();

		Session::flash('alert-success', 'Order has been updated succussfully ..');
		return redirect("admin/orders/edit/" . $id);
	}


	public function postDelete($id)
	{
		$order = Order::findOrFail($id);

		$adminhistory = new AdminHistory;
		$adminhistory->admin_id = Auth::guard("admins")->user()->id;
		$adminhistory->entree = date('Y-m-d H:i:s');
		$adminhistory->description = "Delete order N°: " . $id;
		$adminhistory->save();
		$order->delete();
	}

	public function deletePayment($id)
	{

		$adminhistory = new AdminHistory;
		$adminhistory->admin_id = Auth::guard("admins")->user()->id;
		$adminhistory->entree = date('Y-m-d H:i:s');
		$adminhistory->description = "Delete payment N°: " . $id;
		$adminhistory->save();

		OrderOnlinepayment::findOrFail($id)->delete();
	}
	public function createPayment(Request $request)
	{
		$orderOnlinePayment = new OrderOnlinepayment();
		$orderOnlinePayment->order_id = $request->order_id;
		$orderproduct = OrderProduct::where("order_id", $request->order_id)->first();

		$emailSast = App('setting')->email;
		if ($request->paid) {
			$orderOnlinePayment->payment_status = "paid";
			$order = Order::findOrFail($request->order_id);

			/*if($order_onlinepay->payment_method=="cash"){*/
			$mime_boundary = "----MSA Shipping----" . md5(time());
			$subject = "Swedish Academy : Payment receipt";
			$headers = "From:Swedish Academy<info@swedish-academy.se> \n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
			$message1 = "--$mime_boundary\n";
			$message1 .= "Content-Type: text/html; charset=UTF-8\n";
			$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
			$message1 .= "<html>\n";
			$message1 .= "<body>";
			$message1 .= "<table width='602'>";
			$message1 .= "<tr>";
			$message1 .= "<td align='center'>";
			$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
			$message1 .= "</td>";
			$message1 .= "</tr>";
			$message1 .= "<tr>";
			$message1 .= "<td align='right'>";

			if (isset($orderproduct->book_id)) {
				$book =  Book::findOrFail($orderproduct->book_id);
				$message1 .= "<strong>
				<div style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px'>

					نرحب بكم في الاكاديمية السويدية للتدريب الرياضي ونعلمكم ان طلبك بالرقم <b style='color:#31b7e9;border-bottom:1px dotted #eee' >$request->order_id</b>
					<span style='margin:0px 7px;'>تم بنجاح     </span>
				</div>
				<div  style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:justify;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px'>
				<div style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;'>
				
				<br>
				<strong>
				يمكنك تحميل دليل الطالب  <a href='https://www.swedish-academy.se/uploads/kcfinder/upload/file/%D8%AF%D9%84%D9%8A%D9%84%20%D8%A7%D9%84%D8%B7%D8%A7%D9%84%D8%A8.pdf'> من هنا </a><br>

				يمكنك تحميل كتاب   <a href='https://swedish-academy.se/telecharge.php?pdf=$book->pdf_book' style ='color: red;'> من هنا </a><br>
			</strong>
				</div>
				
				<br>
				<div  style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;'>
					<b>لديك سؤال؟</b>
					لا تتردد فقط <a style='color:#31b7e9;text-decoration:underline' href='mailto:$emailSast' target='_blank'> إتصل بنا </a> 
			<br/>
			حظا موفقا
				</div>
				<br><br>
				</div></strong> ";
			} else {
				$message1 .= "<strong>
				<div style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px'>

				نرحب بكم في الاكاديمية السويدية للتدريب الرياضي ونعلمكم ان طلبك بالرقم <b style='color:#31b7e9;border-bottom:1px dotted #eee' >$request->order_id</b>
				<span style='margin:0px 7px;'>تم بنجاح . وتم فتح الدورة لكم</span>
   			 </div>
			يمكنك تحميل دليل الطالب  <a href='https://www.swedish-academy.se/uploads/kcfinder/upload/file/%D8%AF%D9%84%D9%8A%D9%84%20%D8%A7%D9%84%D8%B7%D8%A7%D9%84%D8%A8.pdf'> من هنا </a><br>
			يمكنك تحميل كتاب الدورة  <a href='https://swedish-academy.se/courses/' .$order->courseTypeVariation['coursetype_id'] > من هنا </a><br>

			يمكنك تحميل فاتورة الدفع  <a href='https://swedish-academy.se/PDF/" . md5($request->order_id) . "/" . md5($order->user_id) . "' style ='color: red;'> من هنا </a><br>
			<b>لديك سؤال؟</b>
			لا تتردد فقط <a style='color:#31b7e9;text-decoration:underline' href='mailto:$emailSast' target='_blank'> إتصل بنا   
									<br/>
									حظا موفقا
									</strong>";
			}
			$message1 .= "</td>";
			// $message1 .= "<td align='center'>";
			// $message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
			// $message1 .= "</td>";
			$message1 .= "</tr>";
			$message1 .= '</table>';
			$message1 .= '</body>';
			$message1 .= '</html>';
			mail($order->user->email, $subject, $message1, $headers);
			/*}
				$mime_boundary = "----MSA Shipping----" . md5(time());
				$subject = "Swedish Academy : Paiement";
				$headers = "From:Swedish Academy<info@swedish-academy.se> \n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
				$message1 = "--$mime_boundary\n";
				$message1 .= "Content-Type: text/html; charset=UTF-8\n";
				$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
				$message1 .= "<html>\n";
				$message1 .= "<body>";
				$message1 .= "<table width='602'>";
				$message1 .= "<tr>";
				$message1 .= "<td>";
				$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
				$message1 .= "</td>";
				$message1 .= "</tr>";
				$message1 .= "<tr>"; 
				$message1 .= "<td'>";
				$message1 .= "<strong> 
								<br>
								The student ".$order->user->full_name_en." purchased a course
							  </strong>";
				$message1 .= "</td>";
				$message1 .= "</tr>";
				$message1 .= '</table>';
				$message1 .= '</body>';
				$message1 .= '</html>';
				mail("abadlia.nessrine@gmail.com", $subject, $message1, $headers);*/
		} else {
			$orderOnlinePayment->payment_status = "not_paid";
		}
		$orderOnlinePayment->payment_method = "cash";
		$orderOnlinePayment->total = $request->total;
		$orderOnlinePayment->save();

		$adminhistory = new AdminHistory;
		$adminhistory->admin_id = Auth::guard("admins")->user()->id;
		$adminhistory->entree = date('Y-m-d H:i:s');
		$adminhistory->description = "Add payment";
		$adminhistory->save();
	}
	public function editPayment(Request $request, $id)
	{
		$orderOnlinePayment = OrderOnlinepayment::findOrFail($id);
		if ($request->paid) {
			$orderOnlinePayment->payment_status = "paid";
			$order = Order::findOrFail($request->order_id);
			$orderProduct = OrderProduct::where("order_id", $request->order_id)->first();
			$emailSast = App('setting')->email;


			/*if($order_onlinepay->payment_method=="cash"){*/
			$mime_boundary = "----MSA Shipping----" . md5(time());
			$subject = "Swedish Academy : Payment receipt";
			$headers = "From:Swedish Academy<info@swedish-academy.se> \n";
			$headers .= "MIME-Version: 1.0\n";
			$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
			$message1 = "--$mime_boundary\n";
			$message1 .= "Content-Type: text/html; charset=UTF-8\n";
			$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
			$message1 .= "<html>\n";
			$message1 .= "<body>";
			$message1 .= "<table width='602'>";
			$message1 .= "<tr>";
			$message1 .= "<td align='center'>";
			$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
			$message1 .= "</td>";
			$message1 .= "</tr>";
			$message1 .= "<tr>";
			$message1 .= "<td align='right'>";

			if (isset($orderProduct->book_id)) {
				$book =  Book::findOrFail($orderProduct->book_id);
				$message1 .= "<strong>
							<div style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px'>

							نرحب بكم في الاكاديمية السويدية للتدريب الرياضي ونعلمكم ان طلبك بالرقم <b style='color:#31b7e9;border-bottom:1px dotted #eee' >$request->order_id</b>
							<span style='margin:0px 7px;'>تم بنجاح     </span>
							</div>
							<div  style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:justify;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px'>
							<div style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;'>

							<br>
							<strong>
							يمكنك تحميل دليل الطالب  <a href='https://www.swedish-academy.se/uploads/kcfinder/upload/file/%D8%AF%D9%84%D9%8A%D9%84%20%D8%A7%D9%84%D8%B7%D8%A7%D9%84%D8%A8.pdf'> من هنا </a><br>

							يمكنك تحميل كتاب   <a href='https://swedish-academy.se/telecharge.php?pdf=$book->pdf_book' style ='color: red;'> من هنا </a><br>
							</strong>
							</div>

							<br>
							<div  style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;'>
							<b>لديك سؤال؟</b>
							لا تتردد فقط <a style='color:#31b7e9;text-decoration:underline' href='mailto:$emailSast' target='_blank'> إتصل بنا </a> 
							<br/>
							حظا موفقا
							</div>
							<br><br>
							</div></strong> ";
			} else {
				$courseType_id = $orderProduct->coursetype_variation->coursetype_id;
				$message1 .= "<strong>
						<div style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px'>

						نرحب بكم في الاكاديمية السويدية للتدريب الرياضي ونعلمكم ان طلبك بالرقم <b style='color:#31b7e9;border-bottom:1px dotted #eee' >$request->order_id</b>
						<span style='margin:0px 7px;'>تم بنجاح . وتم فتح الدورة لكم</span>
						</div>
						<div  style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:justify;font-size:16px;min-height:16px;vertical-align:top;padding:10px 30px'>
						<div style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;'>

						<br>
						<strong>
						يمكنك تحميل دليل الطالب  <a href='https://www.swedish-academy.se/uploads/kcfinder/upload/file/%D8%AF%D9%84%D9%8A%D9%84%20%D8%A7%D9%84%D8%B7%D8%A7%D9%84%D8%A8.pdf'> من هنا </a><br>
						يمكنك تحميل كتاب الدورة  <a href='https://swedish-academy.se/courses/" . $courseType_id . "' style ='color: red;'>  من هنا </a><br>

						يمكنك تحميل فاتورة الدفع <a href='https://swedish-academy.se/PDF/" . md5($request->order_id) . "/" . md5($order->user_id) . "'> من هنا </a>
						</div><br>
						<div  style='line-height:1.5;font-family:arial,helvetica,sans-serif;color:#4e4e4e;text-align:right;font-size:16px;min-height:16px;vertical-align:top;'>

						<b>لديك سؤال؟</b>
						لا تتردد فقط <a style='color:#31b7e9;text-decoration:underline' href='mailto:$emailSast' target='_blank'> إتصل بنا </a> 
						<br/>
						حظا موفقا
						</div>
						</strong>";
			}
			$message1 .= "</td>";
			$message1 .= "</tr>";
			// $message1 .= "<tr>";
			// $message1 .= "<td align='center'>";
			// $message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
			// $message1 .= "</td>";
			// $message1 .= "</tr>";
			$message1 .= '</table>';
			$message1 .= '</body>';
			$message1 .= '</html>';
			mail($order->user->email, $subject, $message1, $headers);
			/*}
				$mime_boundary = "----MSA Shipping----" . md5(time());
				$subject = "Swedish Academy : Paiement";
				$headers = "From:Swedish Academy<info@swedish-academy.se> \n";
				$headers .= "MIME-Version: 1.0\n";
				$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
				$message1 = "--$mime_boundary\n";
				$message1 .= "Content-Type: text/html; charset=UTF-8\n";
				$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
				$message1 .= "<html>\n";
				$message1 .= "<body>";
				$message1 .= "<table width='602'>";
				$message1 .= "<tr>";
				$message1 .= "<td>";
				$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
				$message1 .= "</td>";
				$message1 .= "</tr>";
				$message1 .= "<tr>"; 
				$message1 .= "<td'>";
				$message1 .= "<strong>
								<br>
								The student ".$order->user->full_name_en." purchased a course
							  </strong>";
				$message1 .= "</td>";
				$message1 .= "</tr>";
				$message1 .= '</table>';
				$message1 .= '</body>';
				$message1 .= '</html>';
				mail("abadlia.nessrine@gmail.com", $subject, $message1, $headers);*/
		} else
			$orderOnlinePayment->payment_status = "not_paid";

		echo $request->total;
		$orderOnlinePayment->total = $request->total;
		$orderOnlinePayment->save();
	}



	public function getReport($id)
	{
		$order = Order::findOrFail($id);

		return view("admin.orders.report", array("order" => $order));
	}

	public function moveCourses(Request $request)
	{
		DB::transaction(function () use ($request) {
			$orders = Order::get();
			foreach ($orders as $order) {
				if ($order->orderproducts()->count() == 0) {
					$orderProduct = new OrderProduct();
					$orderProduct->order_id = $order->id;
					$orderProduct->course_id = $order->course_id;
					$orderProduct->coursetypevariation_id = $order->coursetypevariation_id;
					$orderProduct->num_students = $order->num_students;
					$orderProduct->price = $order->total;
					$orderProduct->total = $order->total;
					$orderProduct->save();

					$order->course_id = null;
					$order->num_students = 0;
					$order->save();
				}
			}
		});
		echo "done";
	}

	public function moveOrderProductsStudents(Request $request)
	{
		DB::transaction(function () use ($request) {
			$ordersStudents = \App\OrderStudent::get();
			foreach ($ordersStudents as $orderStudent) {
				$order = $orderStudent->order;
				if (!empty($order)) {
					$orderProduct = $order->orderproducts()->first();
					if (!empty($orderProduct)) {
						$orderproductStudent = new \App\OrderproductStudent();
						$orderproductStudent->orderproduct_id = $orderProduct->id;
						$orderproductStudent->student_id = $orderStudent->student_id;
						$orderproductStudent->save();
					}
				}
			}
		});
		echo "done";
	}
}
