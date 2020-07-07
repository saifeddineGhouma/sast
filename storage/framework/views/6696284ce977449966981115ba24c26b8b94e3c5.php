<?php
$book_trans = $book->book_trans(App('lang'));
if(empty($book_trans))
    $book_trans = $book->book_trans("ar");
?>
<div class="col-lg-3 col-md-4 col-sm-6 col-sm-12 ">
    <div class="card books_item  deactive ">
        <div class="card  card_style_one">
            <img class="card-img-top" src="<?php echo e(asset('uploads/kcfinder/upload/image/'.$book->image)); ?>" alt="<?php echo e($book_trans->name); ?>">
        </div>
        <div class="row"> 
            <div class="col">
                <div class="card-body books_body">
                    <p class="card-text"><a href="<?php echo e(url(App('urlLang').'books/'.$book_trans->slug)); ?>"><?php echo e($book_trans->name); ?></a></p>
                </div>
            </div>
        </div>
        <a href="<?php echo e(url(App('urlLang').'books/'.$book_trans->slug)); ?>" class="badge badge-primary pdf_sallary">
            <i class="far fa-file-pdf" ></i>
            <?php
                $setting = App('setting');
                $vat = $setting->vat*$book->price/100;
            ?>
            <?php echo e(floor($book->price+$vat)); ?>$  <sup>PDF</sup>
        </a>
        <?php if(!empty($book->indicative_price)): ?>
            <?php if($book->indicative_price == 0): ?>
                <a href="<?php echo e(url(App('urlLang').'books/'.$book_trans->slug)); ?>" target="_blank" class="badge badge-warning book_sallary">
                    <i class="fa fa-book" ></i>
                </a>

            <?php else: ?>
                <a href="<?php echo e($book->buy_link); ?>" target="_blank" class="badge badge-warning book_sallary">
                    <i class="fa fa-book" ></i>
                </a>
                  <?php echo e(floor($book->indicative_price)); ?>$
            <?php endif; ?>
            
        <?php endif; ?>
    </div>
</div>