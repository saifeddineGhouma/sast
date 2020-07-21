

<?php $__env->startSection('meta'); ?>
	<title><?php echo e(trans('home.mon_compte_header')); ?></title>
<?php $__env->stopSection(); ?>
<?php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ?>
<?php $alignText = session()->get('locale') === "ar" ? "right" : "left" ?>

<?php $__env->startSection('content'); ?>
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction:<?php echo e($dir); ?>">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="<?php echo e(url(App('urlLang'))); ?>"><span><?php echo e(trans('home.home')); ?></span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span><?php echo e(trans('home.mon_compte_header')); ?></span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="account-area" >
        <div class="container filter_container" style="direction:<?php echo e($dir); ?>" >
            <div class="row justify-content-between">
                <?php echo $__env->make("front.account._sidebar", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <div class="col-lg-9  filteration">
                    <div class="row justify-content-between row-account" style="text-align: justify;">
                        <div class="col-md-3">
                          <!--   <?php if(!empty($user->image)): ?>
                                 <img src="<?php echo e(asset("uploads/kcfinder/upload/image/users/".$user->image)); ?>"
                                     class="user-img mx-auto d-block" alt="<?php echo e($user->{'full_name_'.Session::get('locale')}); ?>"/>
                            <?php else: ?>
                                <img src="<?php echo e(asset('assets/front/img/user1.jpg')); ?>"  alt="<?php echo e(Auth::user()->{'full_name_'.Session::get('locale')}); ?>"  style="width: 30px;border-radius: 20px;"/>
                            <?php endif; ?> -->
                            <?php if(empty($user->image)): ?>
                                <?php if($user->gender =='male'): ?>
                                    <img src="<?php echo e(asset('assets/front/img/user_m.png')); ?>" class="user-img mx-auto d-block"
                                     alt="<?php echo e($user->{'full_name_'.Session::get('locale')}); ?>">
                                <?php elseif($user->gender =='female'): ?>
                                      <img src="<?php echo e(asset('assets/front/img/user_f.png')); ?>" class="user-img mx-auto d-block"
                                     alt="<?php echo e($user->{'full_name_'.Session::get('locale')}); ?>">
                                <?php endif; ?>      

                            <?php else: ?>

                                <img src="<?php echo e(asset("uploads/kcfinder/upload/image/users/".$user->image)); ?>"
                                     class="user-img mx-auto d-block" alt="<?php echo e($user->{'full_name_'.Session::get('locale')}); ?>"/>
                               
                            <?php endif; ?>
                        </div>
                        <div class="col-md-6 user-name">
                            <h4><?php echo e($user->{'full_name_'.Session::get('locale')}); ?></h4>
                            <?php if(!empty($user->student)): ?>
                                <p><?php echo e(trans('home.etudiant')); ?></p>
                            <?php endif; ?>
                            <p>                       <?php echo e(trans('home.your_link_promotional')); ?>

                                <span class="procode"><?php echo e(url(App('urlLang').'promo/'.$user->id)); ?></span>
                                <span class="help-inline procode2"><?php echo e(trans('home.give_link_to_student')); ?>  </span>
                            </p>
                        </div>
                        <div class="col-md-3 text-center">
                            <a href="<?php echo e(url(App('urlLang').'logout')); ?>">
                                <div class="logout-icon">
                                    <i class="fa fa-power-off"></i>
                                </div>
                                <h6 class="logout-link"><?php echo e(trans('home.logout')); ?> </h6>
                            </a>
                        </div>
                    </div>


                    <div class="row justify-content-between row-account" >
                        <div class="col text-center">
                            <div class="card bg-dark card_style_one text-white">
                                <img class="card-img" src="<?php echo e(asset('assets/front/img/Layer%205.png')); ?>" alt="Card image">
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-right"><i class="fa fa-shopping-cart"></i></h5>
                                    <p class="card-text"><?php echo e($countOrders); ?></p>
                                </div>
                            </div>
                            <h5><?php echo e(trans('home.total_orde')); ?></h5>
                        </div>
                        <div class="col text-center">
                            <div class="card bg-dark card_style_two text-white">
                                <img class="card-img" src="<?php echo e(asset('assets/front/img/Layer%205.png')); ?>" alt="Card image">
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-right"><i class="fa fa-certificate"></i></h5>
                                    <p class="card-text">0</p>
                                </div>
                            </div>
                            <h5><?php echo e(trans('home.free_cours')); ?></h5>
                        </div>
                        <div class="col text-center">
                            <div class="card bg-dark card_style_three text-white">
                                <img class="card-img" src="<?php echo e(asset('assets/front/img/Layer%205.png')); ?>" alt="Card image">
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-right"><i class="fa fa-certificate"></i></h5>
                                    <p class="card-text"><?php echo e($countPaidCourses); ?></p>
                                </div>
                            </div>
                            <h5><?php echo e(trans('home.paid_cours')); ?></h5>
                        </div>
                        <div class="col text-center">
                            <div class="card bg-dark card_style_four text-white">
                                <img class="card-img" src="<?php echo e(asset('assets/front/img/Layer%205.png')); ?>" alt="Card image">
                                <div class="card-img-overlay">
                                    <h5 class="card-title text-right"><i class="fa fa-graduation-cap"></i></h5>
                                    <p class="card-text"><?php echo e($countCertificates); ?></p>
                                </div>
                            </div>
                            <h5><?php echo e(trans('home.certif_delivre')); ?></h5>
                        </div>
                    </div>

                    <div class="filteration_content">
                        <div class="row justify-content-between content_head">
                            <div class="table-responsive">
                                <table class="table table_striped_col">
                                <thead>
                                <tr>
                                    <th scope="col" class="head_col" style="text-align: <?php echo e($alignText); ?>" width="5%">#</th>
                                    <th scope="col" class="head_col" style="text-align: <?php echo e($alignText); ?>;"><?php echo e(trans('home.product')); ?></th>
                                    <th scope="col" class="head_col" style="text-align: <?php echo e($alignText); ?>;"><?php echo e(trans('home.product_type')); ?></th>
                                    <th scope="col" class="head_col" style="text-align: <?php echo e($alignText); ?>;" width ="15%"><?php echo e(trans('home.statut')); ?></th>
                                    <th scope="col" class="head_col" style="text-align: <?php echo e($alignText); ?>;"><?php echo e(trans('home.nbr_student')); ?></th>
                                    <th scope="col" class="head_col" style="text-align: <?php echo e($alignText); ?>;"><?php echo e(trans('home.total_withou_tva')); ?></th>
                                    <th scope="col " class="head_col" style="text-align: <?php echo e($alignText); ?>;" width="14%"><?php echo e(trans('home.date')); ?></th>
                                </tr>
                                </thead>
                                <tbody>

                                <?php $__currentLoopData = $ordersProducts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $orderproduct): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <?php 
                                            $page = empty(Request::get('page')) ?  1 : Request::get('page');
                                            $i = (($page-1) * 5) + $loop->iteration ; 
                                        ?>
                                         
                                         
                                        <td class="row_head"><?php echo e($i); ?></td>
                                        <?php $page++; ?>
                                        <td>
                                            <?php
                                                $url = "";
                                            $product_details="";
                                            if(!empty($orderproduct->course_id)&&!empty($orderproduct->course)){
                                                $product_details = $orderproduct->course->course_trans(Session::get('locale'))->name;
                                                if(!empty($orderproduct->coursetype_variation)){
                                                    $courseTypeVairiation = $orderproduct->coursetype_variation;
                                                    $product_details .= "<br/>".$courseTypeVairiation->courseType->type;
                                                    if(!empty($courseTypeVairiation->teacher))
                                                        $product_details .= " ".$courseTypeVairiation->teacher->teacher_trans(Session::get('locale'))->name;
                                                    $url = url(App('urlLang').'courses/'.$courseTypeVairiation->coursetype_id);
                                                }elseif(!empty($orderproduct->course)){
                                                    $courseType = $orderproduct->course->courseTypes()->first();
                                                    $url = url(App('urlLang').'courses/'.$courseType['id']);
                                                }
                                            }elseif(!empty($orderproduct->quiz_id)&&!empty($orderproduct->quiz)){
                                                $quiz_trans = $orderproduct->quiz->quiz_trans(Session::get('locale'));
                                                if(!empty($quiz_trans)){
                                                    $product_details = $quiz_trans->name;
                                                    $url = "";
                                                }
                                            }elseif(!empty($orderproduct->pack_id)){
												$packs = \App\Packs::findOrFail($orderproduct->pack_id);
												$product_details = $packs->titre;
												$url = url(App('urlLang').'packs/'.$packs->id);
                                            }elseif(!empty($orderproduct->book_id)&&!empty($orderproduct->book)){
                                                $book_trans = $orderproduct->book->book_trans(Session::get('locale'));
                                                if(!empty($book_trans)){
                                                    $product_details = $book_trans->name;
                                                    $url = url(App('urlLang').'books/'.$book_trans->slug);
                                                }
                                            }
                                            ?>
                                            <a href="<?php echo e($url); ?>"> 
                                                <?php echo $product_details; ?>

                                            </a> 
                                        </td>
                                        <td>
                                            <?php if(!empty($orderproduct->course_id)): ?>
                                            <?php echo e(trans('home.cours_compte')); ?>

                                            <?php elseif(!empty($orderproduct->quiz_id)): ?>
                                            <?php echo e(trans('home.exam_compte')); ?>

                                            <?php elseif(!empty($orderproduct->book_id)): ?>
                                             <?php echo e(trans('home.livre_compte')); ?>

                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($orderproduct->isTotalPaid()): ?>
                                                <span class="btn btn-confirm"><?php echo e(trans('home.paiement_confirmer')); ?></span>
                                            <?php elseif($orderproduct->payment_method=="banktransfer"||$orderproduct->payment_method=="agent"): ?>
                                                <span class="btn btn-not-confirm"><?php echo e(trans('home.paiement_en_attente')); ?></span>
                                            <?php else: ?>
                                                <span class="btn btn-not-confirm"><?php echo e(trans('home.paiment_unpaid')); ?></span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php echo e($orderproduct->num_students); ?>

                                        </td>
                                        <td><?php echo e($orderproduct->total); ?> $</td>
                                        <td><?php echo e(date("Y-m-d",strtotime($orderproduct->order->created_at))); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </tbody>
                            </table>
                            </div>
                            <?php echo e($ordersProducts->links()); ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <?php echo $__env->make("front.account.js.active_link_js", array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php $__env->stopSection(); ?>



<?php echo $__env->make('front/layouts/master', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>