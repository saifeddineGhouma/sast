










































<!DOCTYPE html>
<html>
  <head>
  <title>HTML5 Skeleton</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="description" content="HTML5 skeleton index.html">
  <meta name="keywords" content="html5,skeleton,index,homepage,jquery,bootstrap">
  <meta name="author" content="Arul John">
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" rel="stylesheet">
  <style type="text/css">
    .stripe-button-el{
      display: none ;
    }
  </style>
  </head>
<body>
<header class="navbar navbar-default">
  <nav>
   <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
    <span class="sr-only">Toggle navigation</span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
    <span class="icon-bar"></span>
   </button>
   <a class="navbar-brand" href="/">HTML5 Skeleton</a>
  </nav>
  <div class="container">
    <div class="navbar-collapse collapse">
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/help"><span class="fa fa-help-o"></span> Help</a></li>
        
      </ul>
    </div>
  </div>
</header>
<main role="main">
  <div class="container">
    <div class="row">
   <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="{{route('paypal.payment.post')}}">
  {{ csrf_field() }}  
  <div class="form-group">
    <label for="exampleInputPassword1">Montant </label>
    <input type="text" class="form-control w3-input w3-border" id="amount" name="amount" type="text">
  </div>

    <div class="radio">
    <label><input type="radio" name="method" value="paypal" >PayPal</label>
  </div>
  <div class="radio">
    <label><input type="radio" name="method" value="stripe" >stripe</label>
  </div>

  <button type="submit" class="btn  btn-block disabled " id="paypal">Pay with PayPal</button>
  <br/>

    

</form>

   <form class="w3-container w3-display-middle w3-card-4 " method="POST" id="payment-form"  action="{{route('stripe.payment.post')}}">
  {{ csrf_field() }}  
 

  <input type="hidden" class="form-control w3-input w3-border" id="amount_stripe" name="amount_stripe" type="text">

 
    <button type="submit" class="btn btn-block disabled " id="stripe">Pay with stripe</button>
 <script
                                src="https://checkout.stripe.com/checkout.js" class="stripe-button"
                                data-key="pk_live_7G2dGhC0acfWlKTRGUZOXOMK"
                                data-amount=""
                                data-name="{{ App("setting")->settings_trans(App('lang'))->site_name }}"
                                data-description="Widget"
                                data-currency="USD"
                                data-image="https://stripe.com/img/documentation/checkout/marketplace.png"
                                data-locale="auto">
                        </script>
</form>


    </div>
  </div>
</main>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>

<script type='text/javascript'>
//jQuery(document).ready(function(){
$('.stripe-button-el').css('display','none')
$('input:radio[name="method"]').change(function(){
  var amount = $('#amount').val();
    if($(this).val() == 'paypal'){
      
        $('#paypal').removeClass('disabled ')
        $('#paypal').addClass('btn-success')

        $('#stripe').addClass('disabled')
        $('#stripe').removeClass('btn-success')


    }else{
      $('#paypal').addClass('disabled')
      $('#paypal').removeClass('btn-success')

      $('#amount_stripe').val(amount);
      $('#stripe').addClass('btn-success')
      $('#stripe').removeClass('disabled')
            

    
    }
});

//});

</script>
<script>
//<![CDATA[
window.jQuery || document.write(unescape('%3Cscript src="/jquery.min.js">%3C/script>'))
//]]>
</script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<script>
//<![CDATA[
typeof $().modal == 'function'  || document.write(unescape('%3Cscript src="/bootstrap.min.js">%3C/script>'))
//]]>
</script>

</body>
</html>