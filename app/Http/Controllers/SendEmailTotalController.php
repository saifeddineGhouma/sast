<?php

namespace App\Http\Controllers;



use App\Http\Requests;
use App\Http\Controllers\Controller;


use App\User;
use App\OrderProduct;

class SendEmailTotalController extends Controller
{
    public function sendMailTest()
    {
        $orderProducts = OrderProduct::where("course_id", 18)->whereIn("price", 147258)->get();

        foreach ($orderProducts as $orderProd) {
            $mime_boundary = "----MSA Shipping----" . md5(time());
            $subject = "Swedish Academy : Big news";
            $headers = "From:Swedish Academy<info@swedish-academy.se> \n";
            $headers .= "MIME-Version: 1.0\n";
            $headers .= "Content-Type: multipart/alternative; boundary=\"$mime_boundary\"\n";
            $message1 = "--$mime_boundary\n";
            $message1 .= "Content-Type: text/html; charset=UTF-8\n";
            $message1 .= "Content-Transfer-Encoding: 8bit\n\n";
            $message1 .= "<html>\n";
            $message1 .= "<body>";
            $message1 .= "<table cellpadding='0' cellspacing='0' border='0' style='table-layout: fixed;' align='center'>";
            $message1 .= "<tr>";
            $message1 .= "<td align='center'>";
            $message1 .= "<img src='https://swedish-academy.se/assets/front/img/logo-mail.png'>";
            $message1 .= "</td>";
            $message1 .= "</tr>";
            $message1 .= "<tr>";
            $message1 .=  "<td align='center'>";
            $message1 .= "<br>أعزاءنا طلبة التغذية الرياضية.

            في البداية نود أن نقدم تهانينا لحصولكم على شهادة التغذية الرياضية الخاصة بكم ونشكركم على اختيار أكاديميتنا.
            وبعد، نود أن نبلغكم أن برنامجنا للتغذية الرياضية قد تم تعديله ليتوافق مع المعايير الدولية لتعليم التغذية الرياضية والتي لطالما سعى المجلس العالمي للعلوم الرياضية والأكاديمية السويدية للتدريب الرياضي إلى تحقيقها.
            لهذا الغرض، سنقوم بإستبدال جميع مستويات التغذية الرياضية بدورة تدريبية واحدة أكثر اكتمالا وحداثة. في الواقع، ستكون هناك دورة مدرب تغذية رياضية واحدة فقط ستكون متوفرة. لذلك، يسعدنا ابلاغ طلبتنا الأعزاء الراغبين في مواصلة تعليمهم انهم سيستفيدون من خصم 50 ٪ على هذه الدورة الجديدة.
            <br /> طموحكم هو أولويتنا";
            $message1 .= "</td>";
            $message1 .= "</tr>";
            $message1 .= '</table>';
            $message1 .= '</body>';
            $message1 .= '</html>';
            mail($orderProd->order->user->email, $subject, $message1, $headers);
        }

        return $orderProducts;
    }
}
