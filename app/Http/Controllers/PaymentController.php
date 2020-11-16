<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Input;
use PayPal\Api\Amount;
use PayPal\Api\Details;
use PayPal\Api\Item;

/** All Paypal Details class **/
use PayPal\Api\ItemList;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Rest\ApiContext;
use Redirect;
use Session;
use URL;
use Validator;

use App\User;
use Stripe\Error\Card;
use Cartalyst\Stripe\Stripe;

class PaymentController extends Controller
{
   public function __construct()
    {
/** PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential(
             'Acbr4b1xev_zsdGEB0iGj6MHfZGUuxBHI-_dE2_q4x5gbek6B2H5kf-vAbq1neQRFdiVjniUcukNnB3z',
            'EN1DLiBTypPhlvyK-r2yEOpkJ6oIwktWVOMzI7OcAhglQ47zio0lkJPJaOoLCy-b3LIZD7oxo7u1zvRA')
        );
        $this->_api_context->setConfig($paypal_conf['settings']);
}
public function showform()
{
	return view('front.specialPayment.paypal');
}


    public function payWithstripe(Request $request)
    {
             if($request->method=="stripe")
             {


                \Stripe\Stripe::setApiKey("sk_live_Tt6pEvhlDm3q3BVyd35Rk2tF");

           

          
                 $token = $request->get('stripeToken');
                // Charge the user's card:
              
                  \Stripe\Stripe::setApiKey("sk_live_Tt6pEvhlDm3q3BVyd35Rk2tF");
                    $charge = \Stripe\Charge::create(array(
                "amount" => round($total * 100, 0),
                "currency" => "usd",
                "description" => "order #" . $order->id,
                "source" => $token
                ));


             }else{
                dd("paypal method");

             }

         
    }
    public function payWithpaypal(Request $request)
    {
               $payer = new Payer();
                $payer->setPaymentMethod('paypal');

                $item_1 = new Item();

                $item_1->setName('Item 1') 
                    ->setCurrency('USD')
                    ->setQuantity(1)
                    ->setPrice($request->get('amount')); 

                $item_list = new ItemList();
                $item_list->setItems(array($item_1));

                $amount = new Amount();
                $amount->setCurrency('USD')
                    ->setTotal($request->get('amount'));

                $transaction = new Transaction();
                $transaction->setAmount($amount)
                    ->setItemList($item_list)
                    ->setDescription('Your transaction description');

                $redirect_urls = new RedirectUrls();
                $redirect_urls->setReturnUrl(URL::to('status')) 
                    ->setCancelUrl(URL::to('status'));

                $payment = new Payment();
                $payment->setIntent('Sale')
                    ->setPayer($payer)
                    ->setRedirectUrls($redirect_urls)
                    ->setTransactions(array($transaction));
                
                try {

                   // dd($payment);

                    $payment->create($this->_api_context);

                } catch (\PayPal\Exception\PPConnectionException $ex) {

                    if (\Config::get('app.debug')) {

                        \Session::put('error', 'Connection timeout');
                        return Redirect::to('/');

                    } else {

                        \Session::put('error', 'Some error occur, sorry for inconvenient');
                        return Redirect::to('/');

                    }

                }

                foreach ($payment->getLinks() as $link) {

                    if ($link->getRel() == 'approval_url') {

                        $redirect_url = $link->getHref();
                        break;

                    }

                }

               
                Session::put('paypal_payment_id', $payment->getId());

                if (isset($redirect_url)) {

                    
                    return Redirect::away($redirect_url);

                }

                \Session::put('error', 'Unknown error occurred');
                return Redirect::to('/');
    }
    public function getPaymentStatus()
     {
                /** Get the payment ID before session clear **/
                $payment_id = Session::get('paypal_payment_id');
                /** clear the session payment ID **/
                Session::forget('paypal_payment_id');
                if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
                \Session::put('error', 'Payment failed');
                            return Redirect::route('/');
                }
                $payment = Payment::get($payment_id, $this->_api_context);
                        $execution = new PaymentExecution();
                        $execution->setPayerId(Input::get('PayerID'));
                /**Execute the payment **/
                        $result = $payment->execute($execution, $this->_api_context);
                if ($result->getState() == 'approved') {
                \Session::put('success', 'Payment success');
                            return Redirect::route('/');
                }
                \Session::put('error', 'Payment failed');
                        return Redirect::route('/');
    }

}
