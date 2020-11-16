 
@php 

$totalPrice = 0;
@endphp
<!doctype html>
<html>
<head>
   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <title>{{$user->full_name_en}} - facture swedish academy </title>
    
    <style>
	body{
	direction: rtl; text-align: right;
	
	
	
	}
    .invoice-box {
        max-width: 800px;
        margin: auto;
        padding: 30px;
        border: 1px solid #eee;
        box-shadow: 0 0 10px rgba(0, 0, 0, .15);
        font-size: 16px;
        line-height: 24px;
        font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
        color: #555;
    }
    
    .invoice-box table {
        width: 100%;
        line-height: inherit;
        text-align: left;
    }
    
    .invoice-box table td {
        padding: 5px;
        vertical-align: top;
    }
    
    .invoice-box table tr td:nth-child(2) {
        text-align: right;
    }
    
    .invoice-box table tr.top table td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.top table td.title {
        font-size: 45px;
        line-height: 45px;
        color: #333;
    }
    
    .invoice-box table tr.information table td {
        padding-bottom: 40px;
    }
    
    .invoice-box table tr.heading td {
        background: #eee;
        border-bottom: 1px solid #ddd;
        font-weight: bold;
    }
    
    .invoice-box table tr.details td {
        padding-bottom: 20px;
    }
    
    .invoice-box table tr.item td{
        border-bottom: 1px solid #eee;
    }
    
    .invoice-box table tr.item.last td {
        border-bottom: none;
    }
    
    .invoice-box table tr.total td:nth-child(2) {
        border-top: 2px solid #eee;
        font-weight: bold;
    }
    
    @media only screen and (max-width: 600px) {
        .invoice-box table tr.top table td {
            width: 100%;
            display: block;
            text-align: center;
        }
        
        .invoice-box table tr.information table td {
            width: 100%;
            display: block;
            text-align: center;
        }
    }
    
    /** RTL **/
    .rtl {
        direction: rtl;
        font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
    }
    
    .rtl table {
        text-align: right;
    }
    
    .rtl table tr td:nth-child(2) {
        text-align: right;
    }
    
    </style>
	
<script src="{{asset('assets/front/js/pdf.js')}}"></script>
	<script src="{{asset('assets/front/js/jquery.js')}}"></script>

</head>

<body>
    <div class="invoice-box"  >
        <table cellpadding="0" cellspacing="0">
            <tr class="top">
                <td colspan="2">
                    <table>
                        <tr>
                            <td class="title">
                              
								<img src="https://swedish-academy.se/uploads/kcfinder/upload/image/admins/logo.png" alt="Swedish" title="Swedish">
                            </td>
                            
                                                       <td style="display:none">

                                Invoice #: 123<br>
                                Created:  date("Y-m-d")<br>
                                Due: February 1, 2015
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="information">
                <td colspan="2">
                    <table>
                        <tr>
                            <td style="display:none">
                                Sparksuite, Inc.<br>
                                12345 Sunny Road<br>
                                Sunnyville, CA 12345
                            </td>
                            
                            <td>
                               
                                {{ $user->full_name_en }}<br>
                                {{$user->email}}<br/>
                                {{$user->mobile}}

                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            
            <tr class="heading">
                
                
                <td>
                      @lang('navbar.purchaseway') : {{ (isset($checkout["payment_method"]))? $checkout["payment_method"] : '' }} 
                </td>
            </tr>
            
            <tr class="details">
                <td>
                    
                </td>
                
                <td>
                
                </td>
            </tr>
            
            <tr class="heading">
                <td style="text-align:right">
                   @lang('navbar.product')  
                </td>
                
                <td style="text-align:left">
                   @lang('navbar.price')
                </td>
            </tr>
            @foreach($cart as $key=>$cart_pro)
     
                 @php
            $type = "book";
            $product_id = 0;
            if(isset($cart_pro['coursetypevariation_id'])){
                $type = "course";
                $courseTypeVariation = \App\CourseTypeVariation::findOrFail($cart_pro['coursetypevariation_id']);
                $courseType = $courseTypeVariation->courseType;
                $course = $courseType->course;
                $course_trans = $course->course_trans(session()->get('locale'));
                if(empty($course_trans))
                    $course_trans = $course->course_trans("ar");
                $product_id = $cart_pro['coursetypevariation_id'];
            }elseif(isset($cart_pro['quiz_id'])){
                $type = "quiz";
                $quiz = \App\Quiz::findOrFail($cart_pro['quiz_id']);
                $quiz_trans = $quiz->quiz_trans(App('lang'));
                if(empty($quiz_trans))
                    $quiz_trans = $quiz->quiz_trans("ar");
                $product_id = $cart_pro['quiz_id'];
            }elseif(isset($cart_pro['pack_id'])){
                $type = "packs";
                $packs = \App\Packs::findOrFail($cart_pro['pack_id']);
                $product_id = $cart_pro['pack_id'];
            }else{
                $book = \App\Book::findOrFail($cart_pro['book_id']);
                $book_trans = $book->book_trans(App('lang'));
                if(empty($book_trans))
                    $book_trans = $book->book_trans("ar");
                $product_id = $cart_pro['book_id'];
            }
            @endphp
          
              <tr class="item">
              	 
                <td style="text-align:right">
                    @if($type=="course")
                    <h4>{{ $course_trans->name }} - {{ trans('home.'.$courseType->type) }}</h4></a>
                                <p>{{ $course_trans->short_description }}</p>
                    @elseif($type=="quiz")
                      <p>{{ $quiz_trans->name }}</p>
                    @elseif($type=="packs")
                     <p>{{ $packs->titre }}</p>
                    @else
                     <a href="{{ url(App('urlLang').'books/'.$book_trans->slug) }}"><h4>{{ $book_trans->name }}</h4></a>
                                <p>{{ $book_trans->short_description }}</p>
                    @endif
                </td>
                <td  style="text-align:left">
                    ${{$cart_pro["total"]}} 
                    <?php
                        $totalPrice+=$cart_pro["total"];
                    ?>

                </td>
               
              </tr> 
            @endforeach
           @if(isset($checkout["points_value"]))
             @php ($totalPrice = $totalPrice - $checkout["points_value"])
           @endif
            @if(isset($checkout["coupon_value"]))
                    
                            {{trans('home.coupon')}}:
                            <?php
                                $coupon = App\Coupon::find($checkout["coupon_id"]);
                                $coupon_number = "";
                                if(!empty($coupon))
                                    $coupon_number = $coupon->coupon_number;
                                
                            ?>
                            {{$coupon_number}}
                       
                            {{$checkout["coupon_value"]}}%-
                            
                            @php ($coup = ($totalPrice/100)*$checkout["coupon_value"])
             
                @endif
            <tr class="total">
                
                
                <td>
                	<?php 
                            if(isset($coup)){
                                $totalPrice = $totalPrice - $coup;
                            }
                        ?>
                         $<?php echo $totalPrice; ?>
                </td>
                <td> {{trans('home.total_sans_vat')}}:</td>
            </tr>
            <tr class="total">
              
                
                <td>
                	<?php 
                            
                            $setting = App('setting');
                            $vat = $setting->vat*($cart_pro["price"]/100);
                            echo $setting->vat." %";
                        ?>
                </td>
                  <td>  {{trans('home.vat')}}:</td>
            </tr>

             <tr class="total">
                
                
                <td>
                	${{$checkout['vat']}}
                </td>
                <td> {{trans('home.total_vat')}}:</td>
            </tr>


            <tr class="total">
                
                
                <td>
                   Total:  ${{$checkout["totalPrice"]}}
                </td>
                <td></td>
            </tr>
        </table>
    </div>



    <script type="text/javascript">
    	window.print();
		
		
			

    </script>
</body>
</html>