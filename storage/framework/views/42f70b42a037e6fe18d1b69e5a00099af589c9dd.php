<?php $__env->startSection('meta'); ?>
    <title><?php echo e(!empty($book_trans->meta_title)?$book_trans->meta_title:$book_trans->name); ?></title>
    <meta name="keywords" content="<?php echo e($book_trans->meta_keyword); ?> " />
    <meta name="description" content="<?php echo e($book_trans->meta_description); ?> ">
<?php $__env->stopSection(); ?>

<?php $dir = Session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
<?php $alignText = session()->get('locale') === "ar" ? "right" : "left" ?>

<?php $__env->startSection('content'); ?>
    <!-- Start book -->
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:<?php echo e($dir); ?>">
                <img class="align-self-center ml-3" src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$book->image)); ?>" alt="<?php echo e($book_trans->name); ?>">
                <div class="media-body align-self-center">
                    <a href="#" onclick="return false;" class="training_link" style="display: flex;"><?php echo e($book_trans->name); ?></a>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <i class="fa fa-home" aria-hidden="true"></i>
                                <a href="<?php echo e(url(App('urlLang'))); ?>"><span><?php echo e(trans('home.home')); ?></span></a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="<?php echo e(url(App('urlLang').'books')); ?>"> <?php echo e(trans('home.books_compte')); ?></a> 
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">
                                <span><?php echo e($book_trans->name); ?></span>
                            </li>
                        </ol>
                    </nav>

                </div>
 
            </div>
        </div>  
    </div>
    <!-- End book -->
    <?php echo $__env->make('common.errors', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

    <div class="book-body text-center">
        <div class="container">
            <div class="row book-intro"> 
                <div class="col-md-6 book-details">
                    <h3><?php echo e($book_trans->name); ?></h3>
                    <p><?php echo e($book_trans->short_description); ?></p>
                    <div class="row book-price">
 
                        <div class="col-6">
                            <?php if($book->price>0): ?>  
                                <div class="book_info">
                                    <?php if(!$isPaid): ?>
                                        <form id="cart-form" class="search_form incourse" method="post" action="<?php echo e(url(App('urlLang').'cart/add-to-cart')); ?>">
                                            <?php echo e(csrf_field()); ?>

                                            <input type="hidden" name="quantity" value="1">
                                            <input type="hidden" name="book_id" value="<?php echo e($book->id); ?>">
                                            <p>
                                                <button type="submit" class="buy_book_now"> إضافة إلى السلة</button>
                                            </p>
                                        </form>
                                    <?php else: ?>
                                        <div class="alert alert-success alertweb"><i class="fa fa-exclamation-circle"></i>
                                        <p>
                                            
                                            <strong> لقد تم دفع ثمن الكتاب بنجاح </strong>
                                            
                                            
                                            </form>
                                        </p>
                                        </div>
                                    <?php endif; ?>
                                    <a href="/uploads/kcfinder/upload/file/<?php echo e($book->pdf_book_summary); ?>" target="_blank">
                                        <i class="fa fa-file-pdf-o" aria-hidden="true"></i>
                                        <p>تحميل الملخص</p>
                                    </a> 
                                    <?php if(!$isPaid): ?>
                                        <span>$ <?php echo e($book->price+App('setting')->vat*$book->price/100); ?></span>
                                    <?php else: ?>
                                        <a href="/uploads/kcfinder/upload/file/<?php echo e($book->pdf_book); ?>" target="_blank">
                                            <i class="fa fa-file-pdf-o" aria-hidden="true" style="color: red;"></i>
                                            <p>تحميل الكتاب</p>
                                        </a> 
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-6">
                            <?php if($book->indicative_price>0): ?>
                                <div class="book_info">
                                    <p><a href="<?php echo e($book->buy_link); ?>" target="_blank" class="buy_book_now">اشتري الأن</a></p>
                                    <i class="fa fa-book" aria-hidden="true"></i>
                                    <p>النسخة الورقية</p>
                                    <span><?php echo e($book->indicative_price); ?> $</span>
                                </div>
                            <?php endif; ?>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
                            <div class="meta-price media-body align-self-center">
                                <?php if($book->points >0&&!($book->indicative_price>0)): ?>
                                    <span class="points-on-course"><span><i class="fa fa-gift"></i> <?php echo e($book->points); ?> نقطة مجانية على هذا الكتاب</span>
                                    <i class="repls">يمكنك إستبدال النقاط المجمعة والحصول على كوبون خصم</i>
                                    <a href="" target="_blank">تعرف على برنامج النقاط والمكافئات</a>
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-md-6 book-images">
                    <img src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$book->image)); ?>"/>
                </div>
            </div>

            <div class="courses_more_info">
                <div class="row more_info_one justify-content-between">
                    <div class="col-lg-12 courses_more_info_content">
                        <div class="content_header_one">
                            <p><?php echo e($book_trans->name); ?></p>
                        </div>
                        <?php echo $book_trans->content; ?>

                    </div>


                </div>
            </div>
        </div>
    </div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>

<?php $__env->stopSection(); ?>



<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>