<?php $__env->startSection('meta'); ?>
	<title><?php echo app('translator')->getFromJson('navbar.cart'); ?>   </title>
	<meta name="keywords" content="<?php echo e($metaData->keyword); ?>" />
	<meta name="description" content="<?php echo e($metaData->description); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('styles'); ?>

<?php $__env->stopSection(); ?>
<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
<?php $__env->startSection('content'); ?>
	<div class="training_purchasing">
		<div class="container training_container">
			<div class="media" style="direction: <?php echo e($dir); ?> ">
				<nav aria-label="breadcrumb">
					<ol class="breadcrumb">
						<li class="breadcrumb-item">
							<i class="fa fa-home" aria-hidden="true"></i>
							<a href="<?php echo e(url(App('urlLang'))); ?>"><span><?php echo e(trans('home.home')); ?></span></a>
						</li>
						<li class="breadcrumb-item active" aria-current="page">
							<span><?php echo app('translator')->getFromJson('navbar.cart'); ?></span>
						</li>
					</ol>
				</nav>
			</div>
		</div>
	</div>

<div class="container" id="shopping-cart-page">
<h1 style =" direction :<?php echo e($dir); ?>" ><i class="fa fa-shopping-basket" style="margin-left:5px;margin-right: 5px"></i><?php echo app('translator')->getFromJson('navbar.cart'); ?></h1>
	<?php if(!is_null($cart)&&!empty($cart)): ?>
       <?php echo $__env->make("front.cart._cart",["fromPage"=>"cart"], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
	<?php else: ?>
		<h3><?php echo e(trans('home.shopping_cart_empty')); ?>     <br/> <span class="sub-header"><?php echo e(trans('home.no_items_shopping_cart')); ?></span></h3>
		<a href="<?php echo e(URL::previous()); ?>" class="button backtoshop"><?php echo e(trans('home.back_previous_page')); ?></a>
	<?php endif; ?>
</div>




<?php $__env->stopSection(); ?>



<?php $__env->startSection('scripts'); ?>
	<script>

        jQuery(".product_delete").click(productDelete);
        function productDelete(){
            var type =$(this).data("type");
            var data = null;
            if(type=="course"){
                var coursetypevariation_id = jQuery(this).data("coursetypevariation_id");
                data = {coursetypevariation_id: coursetypevariation_id};
			}else if(type=="quiz"){
                var quiz_id = jQuery(this).data("quiz_id");
                data = {quiz_id: quiz_id};
            }else{
                var book_id = jQuery(this).data("book_id");
                data = {book_id: book_id};
			}
            jQuery.ajax({
                url:'<?php echo e(url(App("urlLang")."cart/deletefromcart/")); ?>',
                type: 'post',
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                },
                data: data,
                beforeSend: function(){
					$("#content_loading").modal("show");
                },
                success: function( result ) {
                    if(result[0]=="success"){
                        $("span.bskt").html(result[1]);
                    }

                    jQuery('#shopping-cart-page').load(document.URL +  ' #shopping-cart-page',function(responseText, textStatus, XMLHttpRequest){
                        jQuery(".product_delete").click(productDelete);
                        jQuery(".btn_update").click(productUpdate);
                    });

                },
                complete: function(  ) {
                    $("#content_loading").modal("hide");
                }
            });
        }



        jQuery(".btn_update").click(productUpdate);
        function productUpdate(){
            var btn = jQuery(this);
            var type =$(this).data("type");
            var data = null;
            var quantity1 = 0;
            if(type=="course"){
                var coursetypevariation_id = jQuery(this).data("coursetypevariation_id");
                var quantity = $("#quantity_"+coursetypevariation_id).val();
                data = {coursetypevariation_id: coursetypevariation_id,quantity: quantity};
                quantity1 = quantity;
            }else if(type=="quiz"){
                var quiz_id = jQuery(this).data("quiz_id");
                var quantity = $("#quantity_"+quiz_id).val();
                data = {quiz_id: quiz_id,quantity: quantity};
                quantity1 = quantity;
            }else{
                var book_id = jQuery(this).data("book_id");
                var quantity = $("#quantity_"+book_id).val();
                data = {book_id: book_id,quantity: quantity};
                quantity1 = quantity;
            }
			if(quantity1>0){
                jQuery.ajax({
                    url: '<?php echo e(url(App("urlLang")."cart/updatecart/")); ?>',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                    },
                    data: data,
                    beforeSend: function(){
                        $("#content_loading").modal("show");
                    },
                    success: function( result ) {
                        if(result[0]=="success"){
                            $("span.bskt").html(result[1]);
                        }

                        jQuery('#shopping-cart-page').load(document.URL +  ' #shopping-cart-page',function(responseText, textStatus, XMLHttpRequest){
                            jQuery(".product_delete").click(productDelete);
                            jQuery(".btn_update").click(productUpdate);
                        });
                    },
                    complete: function(  ) {
                        $("#content_loading").modal("hide");
                    }
                });
			}

        }

	</script>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>