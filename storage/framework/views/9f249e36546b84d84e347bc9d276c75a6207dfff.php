<div class="search_website">

    <i class="fa fa-times-circle exit" aria-hidden="true"></i>

    <form>

        <div class="form-group">

            <label>ابحث في الموقع</label>

            <input class="form-control search_input form-control-lg" type="text" placeholder="ادخل كلمة البحث">

        </div>

        <button type="submit" class="btn btn-dark submit_search">بحث</button>

        <button type="button" class="btn btn-light submit_search">الغاء</button>

    </form>

</div>

<div class="container-fluid navbar-info">

    <div class="row top-bar">

        <div class="col-sm-6">

            <ul class="nav cstulnv">

                <!--<li class="nav-item">

                    <a class="nav-link" href="#"><i class="fa fa-search"></i></a>

                </li>-->

                <?php

                $menuPos = App\MenuPos::find(2);

                $menu = $menuPos->menus()->first();

                ?>

                <?php if(!empty($menu)): ?>

                    <?php echo $menu->links("header"); ?>


                <?php endif; ?>

            </ul>
            <ul class="social-icons ulnvhdr">
                <?php $__currentLoopData = App('setting')->socials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $social): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <a href="<?php echo e($social->link); ?>" target="_blank">
                        <i id="social-fb" class="<?php echo e($social->font); ?> fa-2x social"></i>
                    </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>

        <div class="col-sm-6 locaion">

            <ul class="nav">

                <li class="nav-item">

                    <a class="nav-link" href="tel:+46767045506" style="direction:ltr"><i class="fa fa-whatsapp"></i>&ensp;<?php echo e(App('setting')->mobile); ?></a>

                </li>

                <li class="nav-item">

                    <a class="nav-link" href="https://goo.gl/maps/nYFFMKJEp392" target="_blank" style="direction:ltr"><i class="fa fa-map-marker"></i>&ensp;<?php echo e(App('setting')->settings_trans(session()->get('locale'))->address); ?></a>

                </li>

            </ul>

        </div>
 


    </div>

</div>

<!----  nav    --->

<div class="container-fluid">

<nav class="navbar navbar-expand-md main-nav " dir="<?php echo e($dir); ?>">


        <button class="navbar-toggler col-xs-1" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">

            <span class="fa fa-bars"></span>

        </button>

        <div class="col-md-2 col-xs-6"><a class="navbar-brand" href="<?php echo e(url(App('urlLang'))); ?>">

                <img src="<?php echo e(asset('uploads/kcfinder/upload/image/'.App("setting")->settings_trans(App('lang'))->logo)); ?>" alt="Swedish" title="Swedish">

            </a>

        </div>



        <div class="collapse navbar-collapse n-menu col-md-6" id="navbarSupportedContent">

            <ul class="navbar-nav ml-auto" >

                <?php

                $menuPos = App\MenuPos::find(1);
    
                $menu = $menuPos->menus()->first();
                ?>

                <!-- Souhir multi langauge base de données  -->
 
                <?php if(!empty($menu)): ?>

                    <?php echo $menu->links("mainmenu"); ?>


                <?php endif; ?>

            </ul>



        </div>

        

        <div class="col-md-2 col-xs-4" >

            <ul class="navbar-nav shop-ul">
                <?php if(Auth::check()): ?>
                    <li class="nav-item p-3 dropdown">
                        <a class="nav-link " id="navbarDropdown" href="#" onclick="return false;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                       <!--      <?php if(!empty(Auth::user()->image)): ?>
                                <img src="<?php echo e(asset('uploads/kcfinder/upload/image/users/'.Auth::user()->image)); ?>" style="width:30px;border-radius: 20px;"/>
                            <?php else: ?>
                                <img src="<?php echo e(asset('assets/front/img/user1.jpg')); ?>"  alt="<?php echo e(Auth::user()->{'full_name_'.App('lang')}); ?>"  style="width: 30px;border-radius: 20px;"/>
                            <?php endif; ?>
 -->
                             <?php if(empty(Auth::user()->image)): ?>
                                <?php if(Auth::user()->gender =='male'): ?>
                                <img src="<?php echo e(asset('assets/front/img/user_m.png')); ?>"  alt="<?php echo e(Auth::user()->{'full_name_'.App('lang')}); ?>"  style="width: 30px;"/>
                           
                                <?php elseif(Auth::user()->gender =='female'): ?>
                                    <img src="<?php echo e(asset('assets/front/img/user_f.png')); ?>"  alt="<?php echo e(Auth::user()->{'full_name_'.App('lang')}); ?>"  style="width: 30px;"/>
                                <?php endif; ?>     

                            <?php else: ?>

                                <img src="<?php echo e(asset('uploads/kcfinder/upload/image/users/'.Auth::user()->image)); ?>" style="width: 30px;border-radius: 20px;"/>
                               
                            <?php endif; ?>

                            </i><span class="acct">   <?php echo e(trans('sentence.bienvenu')); ?> <?php echo e(Auth::user()->username); ?><span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="<?php echo e(url(App('urlLang').'account')); ?>"> <?php echo e(trans('home.mon_compte_header')); ?>   </a>
                            <a class="dropdown-item" href="<?php echo e(url(App('urlLang').'logout')); ?>"> <?php echo e(trans('home.logout')); ?>  </a>
                        </div>
                    </li>

                <?php else: ?>
                    <li class="nav-item p-3">

                        <a class="nav-ico" href="<?php echo e(url(App('urlLang').'account')); ?>"><i class="fa fa-user"></i><span class="acct"><?php echo e(trans('home.login')); ?> </span></a>

                    </li>

                <?php endif; ?> 
                <li class="nav-item p-3"> 

                    <?php

                    $cart = session()->get('cart');

                    $countProducts = 0;

                    $total = 0;

                    if(!is_null($cart)){

                        foreach ($cart as $key=>$cart_pro){

                            $countProducts+=$cart_pro["quantity"];

                            $total+=$cart_pro["total"];

                        }

                        session()->put('cart', $cart);

                    }

                    ?>

                    <a class="nav-ico" href="<?php echo e(url(App('urlLang').'cart')); ?>">

                        <i class="fa fa-shopping-basket"></i><span class="badge bskt"><?php echo e($countProducts); ?></span>

                    </a>
                    

                </li>
                
           </ul>

        </div>
        <div class="col-md-2 col-xs-4">

            <ul class="navbar-nav shop-ul">
                    
                <li class="nav-item p-3 dropdown">
                    <a class="nav-link " id="navbarDropdown" href="#" onclick="return false;" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

                        <span class="acct"> 
                                <?php switch($locale):
                                case ('en'): ?>
                                <img src="https://lipis.github.io/flag-icon-css/flags/4x3/gb.svg" alt="United kingdom" class="img-size-50 mr-3 img-circle" style="width: 25px">
                                <?php break; ?>
                                
                               
                                <?php default: ?>
                                <img src="https://lipis.github.io/flag-icon-css/flags/4x3/tn.svg" alt="Arabe" class="img-size-50 mr-3 img-circle" style="width: 25px">
                                <?php endswitch; ?>
                            
                            
                            
                            
                                <?php echo e(trans('sentence.langue')); ?><span>
                    </a>
                    <div class="dropdown-menu " aria-labelledby="navbarDropdown" style="text-align: <?php echo e($locale === "ar" ? "right" : "left"); ?>" >
                        <a class="dropdown-item" href="/lang/en">
                            <img src="https://lipis.github.io/flag-icon-css/flags/4x3/gb.svg" alt="United kingdom" class="img-size-50 mr-3" style="width: 25%">
                            <?php echo e(trans('sentence.english')); ?>

                        </a>
                        <a class="dropdown-item" href="/lang/ar">
                            <img src="https://lipis.github.io/flag-icon-css/flags/4x3/tn.svg" alt="Arabe" class="img-size-50 mr-3 " style="width: 25%">
                            <?php echo e(trans('sentence.arabe')); ?>

                        </a>
                        <!--
                        <a class="dropdown-item" href="/lang/fr">
                            <img src="https://lipis.github.io/flag-icon-css/flags/4x3/fr.svg" alt="Frensh" class="img-size-50 mr-3" style="width: 25%">
                            <?php echo app('translator')->getFromJson('frensh'); ?>
                        </a>-->
                        
                    </div>
                </li>   
            </ul>
    
        </div>

    </nav> 

</div>

