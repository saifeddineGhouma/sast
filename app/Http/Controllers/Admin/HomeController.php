<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\NewsletterSubscriber;
use App\User;
use App\Log;
use App\Order;
use App\OrderProduct;
use App\OrderOnlinepayment;
use App\Course;
use App\CourseTranslation;
use App\CourseTypeVariation;
use App\CourseType;

use App\AdminHistory;
use DB;

class HomeController extends Controller
{
	public function getIndex()
	{
		if (Auth::guard("admins")->check()) {

			/*$users = User::get();
			foreach ($users as $user) {
				$Ordersp = Order::where("user_id", $user->id)->get();
				foreach ($Ordersp as $Ordersps) {
					$tot = 0;
					$totp = 0;
					$Orderspayment = OrderOnlinepayment::where("order_id", $Ordersps["id"])->get();
					foreach ($Orderspayment as $Orderspayments) {
						if ($Orderspayments["payment_status"] == "not_paid") {
							$tot = $Orderspayments["total"];
						}
						if ($Orderspayments["payment_status"] == "paid") {
							$totp += $Orderspayments["total"];
						}
					}
					if ($totp >= $tot and $tot != 0) {
						$OrderProduct = OrderProduct::where("order_id", $Ordersps["id"])->first();
						if ($OrderProduct["course_id"] != NULL) {
							$coursetypevariation = CourseTypeVariation::where("id", $OrderProduct->coursetypevariation_id)->first();
							if (empty($coursetypevariation)) {
								continue;
							}
							//dd(CourseType::where("id", $coursetypevariation['coursetype_id'])->first());
							$coursetype = CourseType::where("id", $coursetypevariation['coursetype_id'])->first();
							if ($coursetype['type'] == "online") {
								//print_r($OrderProduct);

								$StudentQuiz = DB::table('students_quizzes')
									->where('course_id', $OrderProduct["course_id"])
									->where('student_id', $user->id)
									->orderBy('created_at', 'desc')->get();
								//echo $OrderProduct["course_id"];
								$course = Course::findOrFail($OrderProduct["course_id"]);
								//print_r($course);
								$course_trans_ar = $course->course_trans("ar");

								//echo $Ordersps["id"]."<br>";
								if (sizeof($StudentQuiz) == 0) {
									//echo "Date paiement:".$Orderspayments["created_at"]."<br>";
									$date1 = strtotime(date_format($Orderspayments["created_at"], "Y-m-d"));
									$date2 = strtotime(date('Y-m-d'));
									$nbJoursTimestamp = $date2 - $date1;
									$nbJours = $nbJoursTimestamp / 86400; // 86 400 = 60*60*24
									//echo "Nombre de jours : ".$nbJours."<br>";
									if ($nbJours >= 90 and $Ordersps["0jour"] == 0) {
										$mime_boundary = "----MSA Shipping----" . md5(time());
										$subject = "Swedish Academy: Course";
										$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
										$headers .= "MIME-Version: 1.0\n";
										$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
										$message1 = "--$mime_boundary\n";
										$message1 .= "Content-Type: text/html; charset=UTF-8\n";
										$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
										$message1 .= "<html>\n";
										$message1 .= "<body>";
										$message1 .= "<table width='800'>";
										$message1 .= "<tr>";
										$message1 .= "<td>";
										$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
										$message1 .= "</td>";
										$message1 .= "</tr>";
										$message1 .= "مرحبا بكم <br>
														نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ") قد انتهت المدة المحددة لاجتياز الاختبارات بها.
														نتمنى لكم التوفيق و النجاح<br><br>
														مع تحيات فريق العمل

														";
										$message1 .= '</body>';
										$message1 .= '</html>';
										mail($user->email, $subject, $message1, $headers);
										DB::table('orders')
											->where('id', $Ordersps["id"])
											->update(['0jour' => 1]);
									} elseif ($nbJours >= 89 and $Ordersps["1jour"] == 0) {
										$mime_boundary = "----MSA Shipping----" . md5(time());
										$subject = "Swedish Academy: Course";
										$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
										$headers .= "MIME-Version: 1.0\n";
										$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
										$message1 = "--$mime_boundary\n";
										$message1 .= "Content-Type: text/html; charset=UTF-8\n";
										$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
										$message1 .= "<html>\n";
										$message1 .= "<body>";
										$message1 .= "<table width='800'>";
										$message1 .= "<tr>";
										$message1 .= "<td>";
										$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
										$message1 .= "</td>";
										$message1 .= "</tr>";
										$message1 .= "مرحبا بكم <br>
											نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 1 يوم.
											نتمنى لكم التوفيق و النجاح<br><br>
											مع تحيات فريق العمل
														";
										$message1 .= '</body>';
										$message1 .= '</html>';
										mail($user->email, $subject, $message1, $headers);
										//echo "1 jour<br><br>";
										DB::table('orders')
											->where('id', $Ordersps["id"])
											->update(['1jour' => 1]);
									} elseif ($nbJours >= 85 and $Ordersps["5jours"] == 0) {
										$mime_boundary = "----MSA Shipping----" . md5(time());
										$subject = "Swedish Academy: Course";
										$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
										$headers .= "MIME-Version: 1.0\n";
										$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
										$message1 = "--$mime_boundary\n";
										$message1 .= "Content-Type: text/html; charset=UTF-8\n";
										$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
										$message1 .= "<html>\n";
										$message1 .= "<body>";
										$message1 .= "<table width='800'>";
										$message1 .= "<tr>";
										$message1 .= "<td>";
										$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
										$message1 .= "</td>";
										$message1 .= "</tr>";
										$message1 .= "مرحبا بكم <br>
											نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 5 يوم.
											نتمنى لكم التوفيق و النجاح<br><br>
											مع تحيات فريق العمل
														";
										$message1 .= '</body>';
										$message1 .= '</html>';
										mail($user->email, $subject, $message1, $headers);
										//echo "5 jour<br><br>";
										DB::table('orders')
											->where('id', $Ordersps["id"])
											->update(['5jours' => 1]);
									} elseif ($nbJours >= 80 and $Ordersps["10jours"] == 0) {
										$mime_boundary = "----MSA Shipping----" . md5(time());
										$subject = "Swedish Academy: Course";
										$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
										$headers .= "MIME-Version: 1.0\n";
										$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
										$message1 = "--$mime_boundary\n";
										$message1 .= "Content-Type: text/html; charset=UTF-8\n";
										$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
										$message1 .= "<html>\n";
										$message1 .= "<body>";
										$message1 .= "<table width='800'>";
										$message1 .= "<tr>";
										$message1 .= "<td>";
										$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
										$message1 .= "</td>";
										$message1 .= "</tr>";
										$message1 .= "مرحبا بكم <br>
											نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 10 يوم.
											نتمنى لكم التوفيق و النجاح<br><br>
											مع تحيات فريق العمل
														";
										$message1 .= '</body>';
										$message1 .= '</html>';
										mail($user->email, $subject, $message1, $headers);
										//echo "10 jour<br><br>";
										DB::table('orders')
											->where('id', $Ordersps["id"])
											->update(['10jours' => 1]);
									} elseif ($nbJours >= 75 and $Ordersps["15jours"] == 0) {
										$mime_boundary = "----MSA Shipping----" . md5(time());
										$subject = "Swedish Academy: Course";
										$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
										$headers .= "MIME-Version: 1.0\n";
										$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
										$message1 = "--$mime_boundary\n";
										$message1 .= "Content-Type: text/html; charset=UTF-8\n";
										$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
										$message1 .= "<html>\n";
										$message1 .= "<body>";
										$message1 .= "<table width='800'>";
										$message1 .= "<tr>";
										$message1 .= "<td>";
										$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
										$message1 .= "</td>";
										$message1 .= "</tr>";
										$message1 .= "مرحبا بكم <br>
											نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 15 يوم.
											نتمنى لكم التوفيق و النجاح<br><br>
											مع تحيات فريق العمل
														";
										$message1 .= '</body>';
										$message1 .= '</html>';
										mail($user->email, $subject, $message1, $headers);
										//echo "15 jour<br><br>";
										DB::table('orders')
											->where('id', $Ordersps["id"])
											->update(['15jours' => 1]);
									} elseif ($nbJours >= 60 and $Ordersps["30jours"] == 0) {
										$mime_boundary = "----MSA Shipping----" . md5(time());
										$subject = "Swedish Academy: Course";
										$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
										$headers .= "MIME-Version: 1.0\n";
										$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
										$message1 = "--$mime_boundary\n";
										$message1 .= "Content-Type: text/html; charset=UTF-8\n";
										$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
										$message1 .= "<html>\n";
										$message1 .= "<body>";
										$message1 .= "<table width='800'>";
										$message1 .= "<tr>";
										$message1 .= "<td>";
										$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
										$message1 .= "</td>";
										$message1 .= "</tr>";
										$message1 .= "مرحبا بكم <br>
											نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 30 يوم.
											نتمنى لكم التوفيق و النجاح<br><br>
											مع تحيات فريق العمل
														";
										$message1 .= '</body>';
										$message1 .= '</html>';
										mail($user->email, $subject, $message1, $headers);
										//echo "1 mois<br><br>";
										DB::table('orders')
											->where('id', $Ordersps["id"])
											->update(['30jours' => 1]);
									}
								} else {
									$i = 0;
									$datee = "";
									$nbJours = 0;
									foreach ($StudentQuiz as $StudentQuizs) {
										$i++;
										if ($i == 1) {
											if ($StudentQuizs->is_exam == 1 and $StudentQuizs->successfull == 1) {
											} else {
												$datee = $StudentQuizs->created_at;
											}
										}
									}
									if ($datee != "") {
										//echo $datee;
										$date1 = strtotime($datee);
										//echo $date1;
										$date2 = strtotime(date('Y-m-d'));
										$nbJoursTimestamp = $date2 - $date1;
										$nbJours = $nbJoursTimestamp / 86400; // 86 400 = 60*60*24
										//echo $nbJours;
										if ($nbJours >= 90 and $Ordersps["0jour"] == 0) {
											$mime_boundary = "----MSA Shipping----" . md5(time());
											$subject = "Swedish Academy: Course";
											$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
											$headers .= "MIME-Version: 1.0\n";
											$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
											$message1 = "--$mime_boundary\n";
											$message1 .= "Content-Type: text/html; charset=UTF-8\n";
											$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
											$message1 .= "<html>\n";
											$message1 .= "<body>";
											$message1 .= "<table width='800'>";
											$message1 .= "<tr>";
											$message1 .= "<td>";
											$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
											$message1 .= "</td>";
											$message1 .= "</tr>";
											$message1 .= "مرحبا بكم <br>
															نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ") قد انتهت المدة المحددة لاجتياز الاختبارات بها.
															نتمنى لكم التوفيق و النجاح<br><br>
															مع تحيات فريق العمل

															";
											$message1 .= '</body>';
											$message1 .= '</html>';
											mail($user->email, $subject, $message1, $headers);
											DB::table('orders')
												->where('id', $Ordersps["id"])
												->update(['0jour' => 1]);
										} elseif ($nbJours >= 89 and $Ordersps["1jour"] == 0) {
											$mime_boundary = "----MSA Shipping----" . md5(time());
											$subject = "Swedish Academy: Course";
											$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
											$headers .= "MIME-Version: 1.0\n";
											$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
											$message1 = "--$mime_boundary\n";
											$message1 .= "Content-Type: text/html; charset=UTF-8\n";
											$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
											$message1 .= "<html>\n";
											$message1 .= "<body>";
											$message1 .= "<table width='800'>";
											$message1 .= "<tr>";
											$message1 .= "<td>";
											$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
											$message1 .= "</td>";
											$message1 .= "</tr>";
											$message1 .= "مرحبا بكم <br>
												نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 1 يوم.
												نتمنى لكم التوفيق و النجاح<br><br>
												مع تحيات فريق العمل
															";
											$message1 .= '</body>';
											$message1 .= '</html>';
											mail($user->email, $subject, $message1, $headers);
											//echo "1 jour<br><br>";
											DB::table('orders')
												->where('id', $Ordersps["id"])
												->update(['1jour' => 1]);
										} elseif ($nbJours >= 85 and $Ordersps["5jours"] == 0) {
											$mime_boundary = "----MSA Shipping----" . md5(time());
											$subject = "Swedish Academy: Course";
											$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
											$headers .= "MIME-Version: 1.0\n";
											$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
											$message1 = "--$mime_boundary\n";
											$message1 .= "Content-Type: text/html; charset=UTF-8\n";
											$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
											$message1 .= "<html>\n";
											$message1 .= "<body>";
											$message1 .= "<table width='800'>";
											$message1 .= "<tr>";
											$message1 .= "<td>";
											$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
											$message1 .= "</td>";
											$message1 .= "</tr>";
											$message1 .= "مرحبا بكم <br>
												نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 5 يوم.
												نتمنى لكم التوفيق و النجاح<br><br>
												مع تحيات فريق العمل
															";
											$message1 .= '</body>';
											$message1 .= '</html>';
											mail($user->email, $subject, $message1, $headers);
											//echo "5 jour<br><br>";
											DB::table('orders')
												->where('id', $Ordersps["id"])
												->update(['5jours' => 1]);
										} elseif ($nbJours >= 80 and $Ordersps["10jours"] == 0) {
											$mime_boundary = "----MSA Shipping----" . md5(time());
											$subject = "Swedish Academy: Course";
											$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
											$headers .= "MIME-Version: 1.0\n";
											$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
											$message1 = "--$mime_boundary\n";
											$message1 .= "Content-Type: text/html; charset=UTF-8\n";
											$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
											$message1 .= "<html>\n";
											$message1 .= "<body>";
											$message1 .= "<table width='800'>";
											$message1 .= "<tr>";
											$message1 .= "<td>";
											$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
											$message1 .= "</td>";
											$message1 .= "</tr>";
											$message1 .= "مرحبا بكم <br>
												نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 10 يوم.
												نتمنى لكم التوفيق و النجاح<br><br>
												مع تحيات فريق العمل
															";
											$message1 .= '</body>';
											$message1 .= '</html>';
											mail($user->email, $subject, $message1, $headers);
											//echo "10 jour<br><br>";
											DB::table('orders')
												->where('id', $Ordersps["id"])
												->update(['10jours' => 1]);
										} elseif ($nbJours >= 75 and $Ordersps["15jours"] == 0) {
											$mime_boundary = "----MSA Shipping----" . md5(time());
											$subject = "Swedish Academy: Course";
											$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
											$headers .= "MIME-Version: 1.0\n";
											$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
											$message1 = "--$mime_boundary\n";
											$message1 .= "Content-Type: text/html; charset=UTF-8\n";
											$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
											$message1 .= "<html>\n";
											$message1 .= "<body>";
											$message1 .= "<table width='800'>";
											$message1 .= "<tr>";
											$message1 .= "<td>";
											$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
											$message1 .= "</td>";
											$message1 .= "</tr>";
											$message1 .= "مرحبا بكم <br>
												نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 15 يوم.
												نتمنى لكم التوفيق و النجاح<br><br>
												مع تحيات فريق العمل
															";
											$message1 .= '</body>';
											$message1 .= '</html>';
											mail($user->email, $subject, $message1, $headers);
											//echo "15 jour<br><br>";
											DB::table('orders')
												->where('id', $Ordersps["id"])
												->update(['15jours' => 1]);
										} elseif ($nbJours >= 60 and $Ordersps["30jours"] == 0) {
											$mime_boundary = "----MSA Shipping----" . md5(time());
											$subject = "Swedish Academy: Course";
											$headers = "from: Swedish Academy<info@swedish-academy.se>\n";
											$headers .= "MIME-Version: 1.0\n";
											$headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
											$message1 = "--$mime_boundary\n";
											$message1 .= "Content-Type: text/html; charset=UTF-8\n";
											$message1 .= "Content-Transfer-Encoding: 8bit\n\n";
											$message1 .= "<html>\n";
											$message1 .= "<body>";
											$message1 .= "<table width='800'>";
											$message1 .= "<tr>";
											$message1 .= "<td>";
											$message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
											$message1 .= "</td>";
											$message1 .= "</tr>";
											$message1 .= "مرحبا بكم <br>
												نريد اعلامك أن الدورة التي قمتم بالتسجيل بها (" . $course_trans_ar["name"] . ")  ستنتهي المدة المحددة لاجتياز الاختبارات بها بعد 30 يوم.
												نتمنى لكم التوفيق و النجاح<br><br>
												مع تحيات فريق العمل
															";
											$message1 .= '</body>';
											$message1 .= '</html>';
											mail($user->email, $subject, $message1, $headers);
											//echo "1 mois<br><br>";
											DB::table('orders')
												->where('id', $Ordersps["id"])
												->update(['30jours' => 1]);
										}
									}
								}
							}
						}
					}
				}
			}*/

			$date = date("Y-m-d");
			$previous_week = strtotime("-1 week +1 day");
			$start_week = strtotime("last sunday midnight", $previous_week);
			$end_week = strtotime("next saturday", $start_week);
			$start_week = date("Y-m-d", $start_week);
			$end_week = date("Y-m-d", $end_week);
			$startMonth = date("Y-m-d", strtotime("first day of previous month"));
			$endMonth = date("Y-m-d", strtotime("last day of previous month"));

			/*$auctionsToday = Auction::where(DB::raw("DATE(created_at)"),"=",$date)
					->select(DB::raw('count(auctions.id) as countAuctions'));
			$auctionsToday = $auctionsToday->first()->countAuctions;			
			
			$auctionslastweak = $this->auctionsCount($start_week,$end_week);
				
			
			$auctionslastmonth = $this->auctionsCount($startMonth,$endMonth);
			*/

			$auctionsToday = 0;
			$auctionslastweak = 0;
			$auctionslastmonth = 0;

			$totalNumbers = 0;
			$totalNumberslastWeak = 0;
			$totalNumberslastMonth = 0;

			$countSubscriberToday = $this->countSubscribers(null, null, $date);
			$countSubscriberWeak = $this->countSubscribers($start_week, $end_week, null);
			$countSubscriberMonth = $this->countSubscribers($startMonth, $endMonth, null);

			$countUsersToday = $this->countUsers(null, null, $date);
			$countUsersWeak = $this->countUsers($start_week, $end_week, null);
			$countUsersMonth = $this->countUsers($startMonth, $endMonth, null);

			/*$orders = Order::orderBy("created_at","desc")->take(10)->get();*/
			return view("admin.welcome", array(
				"auctionsToday" => $auctionsToday, "auctionslastweak" => $auctionslastweak,
				"auctionslastmonth" => $auctionslastmonth, "totalNumbers" => $totalNumbers,
				"totalNumberslastWeak" => $totalNumberslastWeak, "totalNumberslastMonth" => $totalNumberslastMonth,
				"countSubscriberToday" => $countSubscriberToday, "countSubscriberWeak" => $countSubscriberWeak,
				"countSubscriberMonth" => $countSubscriberMonth, "countUsersToday" => $countUsersToday,
				"countUsersWeak" => $countUsersWeak, "countUsersMonth" => $countUsersMonth
			));
		}
	}

	function countSubscribers($start, $end, $thisDay)
	{
		$subscriberCount = NewsletterSubscriber::with("user");

		if ($thisDay) {
			$subscriberCount = $subscriberCount->where(DB::raw("DATE(created_at)"), "=", $thisDay);
		} else {
			$subscriberCount = $subscriberCount->where(DB::raw("DATE(created_at)"), ">=", $start)
				->where(DB::raw("DATE(created_at)"), "<=", $end);
		}

		$subscriberCount = $subscriberCount->select(DB::raw('count(id) as countSubs'));
		return $subscriberCount->first()->countSubs;
	}
	function countUsers($start, $end, $thisDay)
	{
		$userCount = User::with("newsletter_subscibers");

		if ($thisDay) {
			$userCount = $userCount->where(DB::raw("DATE(created_at)"), "=", $thisDay);
		} else {
			$userCount = $userCount->where(DB::raw("DATE(created_at)"), ">=", $start)
				->where(DB::raw("DATE(created_at)"), "<=", $end);
		}

		$userCount = $userCount->select(DB::raw('count(id) as countUsers'));
		return $userCount->first()->countUsers;
	}

	public function getLock()
	{
		if (Auth::guard("admins")->check()) {
			Session::put('locked', true);

			return view('admin.auth.lock');
		} else {
			return redirect('/admin');
		}
	}

	public function postLock(Request $request)
	{
		// if user in not logged in 
		if (!Auth::guard("admins")->check())
			return "autherror";

		$password = $request->get('password');

		if (\Hash::check($password, Auth::guard("admins")->user()->password)) {
			Session::forget('locked');
			return "success";
		}

		return "passwordIncorrect"; //redirect("admin/home/lock");
	}

	public function loginUser($user_id)
	{
		$log = new Log();
		$log->user_id = Auth::guard("admins")->user()->id;
		$log->action = "Admin Logged in in place of user with id " . $user_id;
		$log->save();
		Auth::loginUsingId($user_id, true);
		return redirect('/');
	}

	public function getLogout1()
	{
		$adminhistory = new AdminHistory;
		$adminhistory->admin_id = Auth::guard("admins")->user()->id;
		$adminhistory->entree = date('Y-m-d H:i:s');
		$adminhistory->description = "Log Out";
		$adminhistory->save();

		Auth::guard("admins")->logout();
		\Session::forget('locked');
		return redirect('/admin');
	}

	public function postSendemail(Request $request)
	{
		$email = $request->get("quick_email");
		$subject = $request->get("quick_subject");
		$message1 = $request->get("quick_message");
		$status = 0;
		try {
			$status = Mail::send('emails.testmail', ['subject' => $subject, 'message1' => $message1, 'email' => $email], function ($message) use ($email, $subject) {
				$message->to($email)->subject($subject);
			});
			if ($status)
				echo "<div class='alert alert-success'>Message has been sent successfully...</div>";
		} catch (\Exception $e) {
			echo "<div class='alert alert-danger'>" . $e->getMessage() . "</div>";
		}
	}

	public function getUnique(Request $request)
	{
		$columnfield = $request->columnfield;
		$value = $request->value;
		$id = $request->id;
		$idcolumn = $request->idcolumn;

		//$field1arr = explode("_", $field);

		$tableCount =  DB::table($request->table)->where($idcolumn, "!=", $id)->where($columnfield, $value)->count();
		return $tableCount;
	}
}
