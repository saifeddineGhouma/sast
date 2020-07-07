<?php $__env->startSection('meta'); ?>
	<title>step 3</title>

<?php $__env->stopSection(); ?>
<?php $__env->startSection("styles"); ?>

<?php $__env->stopSection(); ?>
<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
<?php $textalign = session()->get('locale') === "ar" ? "right" : "left" ?>

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
                            <span><?php echo app('translator')->getFromJson('navbar.reviewdemande'); ?></span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="contact-area">
        <div class="container">
            <div class="row">
                <div class="row setup-content" id="step-3">
                    <div class="col-xs-12">
                        <div class="col-md-12 well text-center" style="direction: <?php echo e($dir); ?>">
                            <h1 class="text-center"><?php echo app('translator')->getFromJson('navbar.reviewdemande'); ?></h1>
                            <div class="col-md-8 col-md-offset-2">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th class="info" style="text-align: <?php echo e($textalign); ?>"><?php echo app('translator')->getFromJson('navbar.name'); ?></th>
                                            <td><?php echo e($user->full_name_en); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: <?php echo e($textalign); ?>"><?php echo app('translator')->getFromJson('navbar.country'); ?></th>
                                            <td><?php echo e($user->nationality); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: <?php echo e($textalign); ?>" ><?php echo app('translator')->getFromJson('navbar.mail'); ?></th>
                                            <td><?php echo e($user->email); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: <?php echo e($textalign); ?>" ><?php echo app('translator')->getFromJson('navbar.phonenumber'); ?></th>
                                            <td><?php echo e($user->mobile); ?></td>
                                        </tr>
                                        <tr>
                                            <th style="text-align: <?php echo e($textalign); ?>" ><?php echo app('translator')->getFromJson('navbar.purchaseway'); ?></th>
                                            <td>
                                                <?php echo e(trans('home.'.$checkout['payment_method'])); ?>

                                                <?php if(!empty($agent)): ?>
                                                    <br/><?php echo e($agent->name); ?>

                                                <?php endif; ?>
                                                <?php if(isset($checkout["banktransfer_image"])&&($checkout["payment_method"]=="banktransfer"||
                                                    $checkout["payment_method"]=="agent")): ?>
                                                    <img src="<?php echo e(asset('uploads/kcfinder/upload/image/bank_transfers/'.$checkout["banktransfer_image"])); ?>" width="200px"/>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div class="col-md-12 nnnn table-responsive">
                                <?php echo $__env->make('front.checkout._cart', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                            </div>

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

       $("#pay_form").bootstrapValidator({
           excluded: [':disabled'],
           fields: {

           }
       }).on('success.form.bv', function(e,data) {

		e.preventDefault();
           $.ajax({
               url: $(this).attr("action"),
               type: 'post',
               headers: {
                   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
               },
               data: $(this).serialize(),
               beforeSend: function(){
                   $("#content_loading").modal("show");
               },
               success: function( message ) {
                   //var indexhttp = message.search("http");
                   //console.log("ss "+message);
                   if(message[0]=="success")
                       location.href = message[1];
                   else{
                       $("#error_message").html("<div class='alert alert-danger'>"+json.parse(message[1])+"</div>");
                   }
               },
               error: function(message){
					$("#error_message").html("<div class='alert alert-danger'>An error occured please try again later or <a href='/contact'>contact us</a></div>");
               },
               complete: function() {
                   $("#content_loading").modal("hide");
               }
           });
       });

    </script>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>