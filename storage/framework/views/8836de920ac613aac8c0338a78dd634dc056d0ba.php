<?php $__env->startSection('meta'); ?>
	<title>step 2</title>

<?php $__env->stopSection(); ?>
<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
<?php $textalign = session()->get('locale') === "ar" ? "right" : "left" ?>
<?php $__env->startSection("styles"); ?>
<style>
    .has-error{
        color: red;
    }
    .display-none{
        display:none;
    }
</style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction: <?php echo e($dir); ?>"> 
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="<?php echo e(url(App('urlLang'))); ?>"><span><?php echo e(trans('home.home')); ?></span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span><?php echo app('translator')->getFromJson('navbar.purchasepage'); ?></span>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span><?php echo app('translator')->getFromJson('navbar.purchaseway'); ?></span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="row setup-content" id="step-2">
                    <div class="col-xs-12">
                        <div class="col-xs-12 well text-center">
                            <h1 class="text-center"><?php echo app('translator')->getFromJson('navbar.purchaseway'); ?></h1>

                        <form  id="payment_form" method="post" action="<?php echo e(url(App('urlLang').'checkout/payment')); ?>" enctype="multipart/form-data" style="direction: <?php echo e($dir); ?>">
                                <?php echo csrf_field(); ?>

                            <div class="col-md-12">

                                <?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                <div class="mb-20">
									<?php echo app('translator')->getFromJson('navbar.chooseyourwaytopay'); ?>
                                </div>
                                <div id="accordion" class="acc-head pymnpymn">
                                    <div class="card">
										<?php if( $country === 1 ): ?>
											<?php //print_r($cart); ?>
											<div class="card-header col-md-3 form-group" id="headingOne">
												<h5 class="mb-0" class="btn btn-link" data-toggle="collapse" data-target="#collapsepaypal" aria-expanded="true" aria-controls="collapseOne">
													<input type="radio" class="paymentTypeRadios" id="paypal" name="payment_method" value="paypal"
														<?php echo e(isset($checkout["payment_method"])&&$checkout["payment_method"]=="paypal"?'checked':null); ?>>
													<label for="paypal" > <?php echo app('translator')->getFromJson('navbar.pay'); ?> PayPal</label>
												</h5>
											</div>
											<div class="card-header col-md-3 form-group" id="headingFour">
												<h5 class="mb-0" class="btn btn-link" data-toggle="collapse" data-target="#collapsestripe" aria-expanded="true" aria-controls="collapseFour">
													<input type="radio" class="paymentTypeRadios" id="Stripe" name="payment_method" value="stripe"
															<?php echo e(isset($checkout["payment_method"])&&$checkout["payment_method"]=="stripe"?'checked':null); ?>>
													<label for="Stripe" > <?php echo app('translator')->getFromJson('navbar.pay'); ?> Credit Card </label>
												</h5>
											</div>
											<div class="card-header col-md-3 form-group" id="headingTwo">
												<h5 class="mb-0" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsebank" aria-expanded="false" aria-controls="collapseTwo">
													<input type="radio" class="paymentTypeRadios" id="bank" name="payment_method" value="banktransfer"
															<?php echo e(isset($checkout["payment_method"])&&$checkout["payment_method"]=="banktransfer"?'checked':null); ?>>
													<label for="bank" > <?php echo app('translator')->getFromJson('navbar.paytransfertbank'); ?></label>
												</h5>
											</div>
											<div class="card-header col-md-3 form-group" id="headingTwoo">
												<h5 class="mb-0" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseespece" aria-expanded="false" aria-controls="collapseTwoo">
													<input type="radio" class="paymentTypeRadios" id="cash" name="payment_method" value="cash"
															<?php echo e(isset($checkout["payment_method"])&&$checkout["payment_method"]=="cash"?'checked':null); ?>>
													<label for="cash" > <?php echo app('translator')->getFromJson('navbar.payespece'); ?>  </label>
												</h5>
											</div>
										<?php else: ?>
											<div class="card-header col-md-4 form-group" id="headingOne">
												<h5 class="mb-0" class="btn btn-link" data-toggle="collapse" data-target="#collapsepaypal" aria-expanded="true" aria-controls="collapseOne">
													<input type="radio" class="paymentTypeRadios" id="paypal" name="payment_method" value="paypal"
														<?php echo e(isset($checkout["payment_method"])&&$checkout["payment_method"]=="paypal"?'checked':null); ?>>
													<label for="paypal" > <?php echo app('translator')->getFromJson('navbar.pay'); ?> PayPal</label>
												</h5>
											</div>
											<div class="card-header col-md-4 form-group" id="headingFour">
												<h5 class="mb-0" class="btn btn-link" data-toggle="collapse" data-target="#collapsestripe" aria-expanded="true" aria-controls="collapseFour">
													<input type="radio" class="paymentTypeRadios" id="Stripe" name="payment_method" value="stripe"
															<?php echo e(isset($checkout["payment_method"])&&$checkout["payment_method"]=="stripe"?'checked':null); ?>>
													<label for="Stripe" ><?php echo app('translator')->getFromJson('navbar.pay'); ?> Credit Card </label>
												</h5>
											</div>
											<div class="card-header col-md-4 form-group" id="headingTwo">
												<h5 class="mb-0" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapsebank" aria-expanded="false" aria-controls="collapseTwo">
													<input type="radio" class="paymentTypeRadios" id="bank" name="payment_method" value="banktransfer"
															<?php echo e(isset($checkout["payment_method"])&&$checkout["payment_method"]=="banktransfer"?'checked':null); ?>>
													<label for="bank" > <?php echo app('translator')->getFromJson('navbar.paytransfertbank'); ?></label>
												</h5>
											</div>
										<?php endif; ?>
                                   <!--      <div class="card-header col-md-3 form-group" id="headingThree">
                                            <h5 class="mb-0" class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapselocal" aria-expanded="false" aria-controls="collapseThree">
                                                <input type="radio" class="paymentTypeRadios" id="local" name="payment_method" value="agent"
                                                        <?php echo e(isset($checkout["payment_method"])&&$checkout["payment_method"]=="agent"?'checked':null); ?>>
                                                <label for="local" > دفع لوكيل محلي</label>
                                            </h5>
                                        </div> -->
                                    </div>

                                <div id="collapsepaypal" class="collapse" aria-labelledby="headingOne" data-parent="#accordion" style="text-align: <?php echo e($textalign); ?>">
                                <div class="card-body text-center">
                                        <h3 ><?php echo app('translator')->getFromJson('navbar.pay'); ?> PayPal</h3>
                                            <hr class="hr-contact" >
                                            <p ><?php echo app('translator')->getFromJson('navbar.paypalredirectiontopay'); ?></p>
                                        </div>
                                    </div>
                                    <div id="collapsestripe" class="collapse" aria-labelledby="headingFour" data-parent="#accordion">
                                        <div class="card-body text-center">
                                            <h3 ><?php echo app('translator')->getFromJson('navbar.pay'); ?> Credit Card</h3>
                                            <hr class="hr-contact" >
                                            <p ><?php echo app('translator')->getFromJson('navbar.stripepayement'); ?></p>
                                        </div>
                                    </div>
                                    <div id="collapseespece" class="collapse" aria-labelledby="headingTwoo" data-parent="#accordion">
                                        <div class="card-body text-center">
                                            <h3><?php echo app('translator')->getFromJson('navbar.payespece'); ?></h3>
                                            <hr class="hr-contact" >
                                        </div>
                                    </div>

                                    <div id="collapsebank" class="collapse" aria-labelledby="headingTwo" data-parent="#accordion">
                                        <div id="accordion" >
                                            <div class="card-body text-center">
                                                <h3><?php echo app('translator')->getFromJson('navbar.paytransfertbank'); ?></h3>
                                                <hr class="hr-contact" >
                                                <div id="accordion" class="payment">
                                                    <div class="card text-center">
                                                        <div class="card-header" id="headingOne">
                                                            <h5 class="mb-0" class="collapsed text-center" data-toggle="collapse" data-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                                <input type="radio" class="paymentTypeRadios" id="input_3_paymentType_credit" name="banktransfer_time" value="later"><label for="input_3_paymentType_credit" > <?php echo app('translator')->getFromJson('navbar.gonnapurchasenow'); ?> </label>
                                                            </h5>
                                                        </div>
                                                        <div id="collapse1" class="collapse" aria-labelledby="headingOne" data-parent="#accordion2">
                                                            <div class="card-body text-center">
                                                                <p><?php echo app('translator')->getFromJson('navbar.detailbanktransfertpaement'); ?>:</p>
                                                                <div class="alert alert-success text-left">
                                                                    Beneficiary's name: Global Council of Sport Science <br>
                                                                    Beneficiary address: Svärmaregatan 3 60361 Norrköping Sweden <br>
                                                                    Beneficiary Bank: Swedbank <br>
                                                                    Swift code: SWEDSESS <br>
                                                                    Account number: 8214-9,943 535 694-5 <br>
                                                                    Iban no: SE28 8000 0821 4994 3535 6945
                                                                </div>
                                                                <p class="text-center"><?php echo app('translator')->getFromJson('navbar.uploadpictureofteransfert'); ?></p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card text-center">
                                                        <div class="card-header" id="headingTwo">
                                                            <h5 class="mb-0" class="collapsed text-center" data-toggle="collapse" data-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                                <input type="radio" class="paymentTypeRadios" id="input_4_paymentType_credit" name="banktransfer_time" value="now"><label for="input_4_paymentType_credit" > <?php echo app('translator')->getFromJson('navbar.uploadtrasnferphoto'); ?> </label>
                                                            </h5>
                                                        </div>
                                                        <div id="collapse2" class="collapse text-center" aria-labelledby="headingTwo" data-parent="#accordion2">
                                                            <div class="card-body">
                                                                <p><?php echo app('translator')->getFromJson('navbar.accompanetransfertphoto'); ?></p>

                                                                <div class="form-group">
                                                                    <input type="file" name="banktransfer_image" <!--accept="image/x-png,image/gif,image/jpeg,image/jpg"!--> />
                                                                </div>
                                                                <p><?php echo app('translator')->getFromJson('navbar.accepttrasfertafterverification'); ?></p>

                                                                <?php if(isset($checkout["banktransfer_image"])&&$checkout["payment_method"]=="banktransfer"): ?>
                                                                    <img src="<?php echo e(asset('uploads/kcfinder/upload/image/bank_transfers/'.$checkout["banktransfer_image"])); ?>" width="200px"/>
                                                                <?php endif; ?>
                                                                <div class="alert alert-danger">
                                                                    <strong><?php echo app('translator')->getFromJson('navbar.remarque'); ?></strong> <?php echo app('translator')->getFromJson('navbar.maxsizephoto'); ?>.
                                                                </div>
                                                                <div class="alert alert-danger">
                                                                    <strong><?php echo app('translator')->getFromJson('navbar.remarque'); ?></strong> <?php echo app('translator')->getFromJson('navbar.accaptedtypeofphoto'); ?> ( jpg , jpeg , png ,gif ,pdf)
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <br/><br/>

                                            </div>
                                        </div>
                                    </div>

                                    <div id="collapselocal" class="collapse text-center" aria-labelledby="headingThree" data-parent="#accordion">
                                        <div class="card-body text-center">
                                            <h3><?php echo app('translator')->getFromJson('navbar.paywakillocal'); ?></h3>
                                            <hr class="hr-contact" >
                                            <div class="col-md-6 text-right">
                                                <label class="form-label"><?php echo app('translator')->getFromJson('navbar.selectcountry'); ?> </label>

                                                <select class="form-control country_id" name="country_id">
                                                    <option value="" selected></option>
                                                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($country->id); ?>" <?php echo e((!empty($agent)
                                                                && $agent->country_id == $country->id)?'selected':null); ?>>
                                                            <?php echo e(isset($country->country_trans(session()->get('locale'))->name) ? $country->country_trans(session()->get('locale'))->name : $country->country_trans("en")->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>

                                            </div>
                                            <div class="col-md-6 text-right">
                                                <label class="form-label"><?php echo app('translator')->getFromJson('navbar.selectwakil'); ?> </label>
                                                <select class="form-control agent_id"  name="agent_id" id="agent_id" >
                                                     <option value=""></option>
                                                    <?php if(!empty($agentData)): ?>
                                                        <?php $__currentLoopData = $agentData; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agent1): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($agent1->id); ?>" <?php echo e(!empty($agent)&&$agent1->id==$agent->id?"selected":null); ?>><?php echo e($agent1->name); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    <?php endif; ?>
                                                </select>

                                            </div>
                                            <div class="col-md-12 text-right">
                                                <div id="agents_table"></div>
                                                <p><?php echo app('translator')->getFromJson('navbar.uploadpayementcoupon'); ?></p>
                                                <div class="form-group">
                                                    <input type="file" name="agent_banktransfer_image" accept="image/x-png,image/gif,image/jpeg,image/jpg" /><br/><br/>
                                                </div>

                                                <?php if(isset($checkout["banktransfer_image"])&&$checkout["payment_method"]=="agent"): ?>
                                                    <img src="<?php echo e(asset('uploads/kcfinder/upload/image/bank_transfers/'.$checkout["banktransfer_image"])); ?>" width="200px"/>
                                                <?php endif; ?>
                                                <div class="alert alert-danger">
                                                    <strong><?php echo app('translator')->getFromJson('navbar.remarque'); ?></strong> <?php echo app('translator')->getFromJson('navbar.maxsizephoto'); ?>.
                                                </div>
                                                <div class="alert alert-danger">
                                                    <strong><?php echo app('translator')->getFromJson('navbar.remarque'); ?></strong> <?php echo app('translator')->getFromJson('navbar.accaptedtypeofphoto'); ?> ( jpg , jpeg , png ,gif )
                                                </div>

                                                <p><?php echo app('translator')->getFromJson('navbar.uploadcouponlater'); ?></p>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                            </div>
                                

                            <div class="clearfix"></div>

                            <br/><br/>
                                <div class="col-sm-12 btnsnex">
                                     <input type="submit" class="btn btn-md btn-success"  style="width:100px," value="<?php echo app('translator')->getFromJson('navbar.next'); ?>">
                                     <input onclick="js:location.href='<?php echo e(url(App('urlLang').'checkout')); ?>'" class="btn btn-warning" value="<?php echo app('translator')->getFromJson('navbar.previous'); ?>">
                               
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

    <script src="<?php echo e(asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')); ?>" type="text/javascript"></script>

    <script>


        $(".country_id").change(country_select);
        function country_select(e){
            var countryId = $(this).val();
            var country = $(this);
            var main_div = $(this).closest(".collapse");

            if(countryId!=""){
                $.ajax({
                    url: "<?php echo e(url('/home/agents')); ?>",
                    data: {countryId: countryId},
                    type: "get",
                    beforeSend: function(){
                        country.closest(".form-group").append("<img src='<?php echo e(asset('assets/admin/img/input-spinner.gif')); ?>' width='20' />");
                    },
                    success: function(result){
                       $("#agent_id").html(result["agents"]);
                       $("#agents_table").html(result["table_agents"]);
                    },
                    complete: function(){
                        country.closest(".form-group").children('img').remove();
                    }
                });
            }
        }

        $("#payment_form").bootstrapValidator({
            excluded: [':disabled'],
            fields: {
                payment_method: {
                    validators: {
                        notEmpty: {
                            message: '<?php echo e(trans("home.this_field_required")); ?>'
                        }
                    },
                    required: true
                },
                banktransfer_time: {
                    validators: {
                        callback: {
                            message: 'من فضلك اختار التحويل البنكي',
                            callback: function(value, validator, $field) {
                                var payment_method = $('#payment_form').find('[name="payment_method"]:checked').val();
                                value = $('#payment_form').find('[name="banktransfer_time"]:checked').val();
                                return (payment_method !== 'banktransfer') ? true : (value !== undefined);
                            }
                        }
                    }
                },
                banktransfer_image: {
                    validators: {
                        callback: {
                            message: 'من فضلك ارفق صورة التحويل ',
                                callback: function(value, validator, $field) {
                                var banktransfer_time = $('#payment_form').find('[name="banktransfer_time"]:checked').val();

                                return (banktransfer_time !== 'now') ? true : (value !== '');
                            }
                        }
                    }
                },
            }
        }).on('change', '[name="payment_method"]', function(e) {
            $('#payment_form').bootstrapValidator('revalidateField', 'banktransfer_time');
        }).on('change', '[name="banktransfer_time"]', function(e) {
            $('#payment_form').bootstrapValidator('revalidateField', 'banktransfer_image');
        }).on('success.form.bv', function(e,data) {


            if($('input[name="payment_method"]:checked').val()=="agent"){
                if($("#agent_id").val()==""){
                    $("#agent_id").parent().addClass("has-error");
                    $("#agent_id").parent().append("<span class='help-block'>العميل مطلوب</span>");
                    var offset = $("#agent_id").parent().offset();
                    offset.left -= 20;
                    offset.top -= 80;
                    jQuery('html, body').animate({
                        scrollTop: offset.top,
                        scrollLeft: offset.left
                    });
                    e.preventDefault();
                    $("input[type='submit']").prop('disabled',false);
                }
                var agent_banktransfer_image= $('#payment_form').find('[name="agent_banktransfer_image"]');
                if(agent_banktransfer_image.val()==""){
                    agent_banktransfer_image.parent().addClass("has-error");
                    agent_banktransfer_image.parent().append("<span class='help-block'>العميل مطلوب</span>");
                    var offset = agent_banktransfer_image.parent().offset();
                    offset.left -= 20;
                    offset.top -= 80;
                    jQuery('html, body').animate({
                        scrollTop: offset.top,
                        scrollLeft: offset.left
                    });
                    e.preventDefault();
                    $("input[type='submit']").prop('disabled',false);
                }
            }

        });
    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>