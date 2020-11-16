<div class="container">

    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label"><?php echo e(trans('home.full_name')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="full_name_en" value="<?php echo e($user->full_name_en); ?>"  required>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label"><?php echo e(trans('home.email')); ?> <span>*</span></label>
                <input type="text" class="form-control" name="email" value="<?php echo e($user->email); ?>" required>
            </div>
        </div>
    </div>



    <?php $pull = session()->get('locale') === "ar" ? "pull-right" : "pull-left" ?>

    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label "><?php echo e(trans('home.username')); ?></label>
                <input type="text" class="form-control" value="<?php echo e($user->username); ?>" disabled>
            </div>
        </div>
       
        <div class="col-md-6">
            <div class="form-group">
                <label class="control-label col-md-3 <?php echo e($pull); ?> "><?php echo e(trans('navbar.sexe')); ?>   <span>*</span></label>
                <div class="col-md-9">
                    <div class="radio-list">
                        <label>
                            <input type="radio" name="gender" required value="male" <?php echo e((isset($user->gender) && $user->gender=="male")?"checked":null); ?>  />
                            <?php echo e(trans('home.man')); ?>   </label>
                        <label>
                            <input type="radio" name="gender" required value="female" <?php echo e((isset($user->gender) && $user->gender=="female")?"checked":null); ?> />
                            <?php echo e(trans('home.woman')); ?> </label>
                    </div>
                </div>
            </div>
        </div>
    </div>





    <div class="row userlogedin">
                <div clas="col-md-4">
                    <div class="form-group">
                          <label class="form-label"> <span><?php echo e(trans('home.date_birth')); ?> *</span> : اليوم<span></span></label>
                        <select name="day" ><?php for($i= 01;$i<=31;$i++) { ?>
                         <option value="<?php echo e($i); ?>" <?php echo e(((date("d", strtotime($user->date_of_birth)))==$i) ? 'selected' :'null'); ?> ><?php echo e($i); ?></option>
                         <?php }?>
                        </select>
                    </div>
                </div>
                <div clas="col-md-4">
                    <div class="form-group">
                          <label class="form-label"> الشهر     <span style="margin-left: 2px"></span></label>
                        <select name="month"><?php for($i= 01;$i<=12;$i++) { ?>
                         <option value="<?php echo e($i); ?>" <?php echo e(((date("m", strtotime($user->date_of_birth)))==$i) ? 'selected' :'null'); ?> ><?php echo e($i); ?></option>
                         <?php }?>
                        </select>
                    </div>
                </div>
                <div clas="col-md-4">
                    <div class="form-group">
                         <label class="form-label">  السنة      <span style="margin-left: 2px"></span></label>
                        <select name="years"><?php for($i= 2020;$i>=1900;$i--) { ?>
                         <option value="<?php echo e($i); ?>" <?php echo e(((date("Y", strtotime($user->date_of_birth)))==$i) ? 'selected' :'null'); ?> ><?php echo e($i); ?></option>
                         <?php }?>
                        </select>
                    </div>
                </div>
            <div class="col-md-6" style="display: none;">
            <div class="form-group">
                <label class="form-label"><?php echo e(trans('home.date_birth')); ?>  <span></span></label>
                <input class="form-control date-picker" name="date_of_birth" placeholder="yyyy-m-d" value="<?php echo e($user->date_of_birth); ?>" type="text"/>
            </div>
        </div>
     
        <div class="col-md-12">
            <div class="form-group">
                <label class="form-label"><?php echo e(trans('home.country_info')); ?> <span>*</span></label>
                <select class="form-control country_id" name="country_id">
                    <option value=""></option>
                    <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $country): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($country->id); ?>" <?php echo e($user->nationality==$country->country_trans("en")->name?"selected":null); ?> >
                            <?php echo e(isset($country->country_trans(Session()->get('locale'))->name) ? $country->country_trans(Session()->get('locale'))->name : $country->country_trans("en")->name); ?> 
                        </option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
        </div>
    </div>




    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label"><?php echo e(trans('home.adress_info')); ?>  <span>*</span></label>
                <input type="text" class="form-control" name="address" value="<?php echo e($user->address); ?>" >
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label"> <?php echo e(trans('home.num_tel')); ?><span>*</span></label>
                <input type="text" class="form-control"  dir="ltr" name="mobile" id="mobile"  value="<?php echo e($user->mobile); ?>" style="direction: ltr !important;text-align: right;">
            </div>
        </div>

      

    </div>







    <div class="row userlogedin">
        <div class="col-md-6">
            <div class="form-group">
                <label class="form-label"><?php echo e(trans('home.photo_personnel')); ?>  </label>
                <input type="file" class="form-control" name="image">
                <img src="<?php echo e(asset('uploads/kcfinder/upload/image/users/'.$user->image)); ?>" alt="" width="100px;"/>
                <span class="help-inline maxflsize"><?php echo e(trans('home.max_size')); ?> </span>
            </div>
        </div>



        <div class="col-md-6">
            <div class="form-group">
                
            </div>
        </div>
    </div>

</div>



