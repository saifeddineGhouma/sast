<?php
	 $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" ;
$sumRatings = 0;
if(!is_null($course->ratings()->where("approved",1))){
    $countRatings = $course->ratings()->where("approved",1)->count();
    $sumRatings = $course->ratings()->where("approved",1)
        ->select(DB::raw('sum(value) as sumRating'))->groupBy("course_id")->first();
    if(!empty($sumRatings))
        $sumRatings = $sumRatings->sumRating;
    else
        $sumRatings = 0;
}
?>
<div class="courses_info">
    <div class="row">
        <div class="col-lg-6 video_show">
            <video class="video" id="video1" src="<?php echo e(asset('uploads/kcfinder/upload/file/'.$course->video)); ?>" poster="<?php echo e(asset('uploads/kcfinder/upload/image/'.$course->image)); ?>" loop>
            </video>
            <div class="video_control_poster">
                <a class="video-control js-video-control paused" href="#" data-video="video1"></a>
            </div>
        </div>
    <div class="col-lg-6 video_info" style="direction: <?php echo e($dir); ?>">
            <h3><?php echo e($course_trans->name ." ". trans('home.'.$courseType->type)); ?></h3>
            <p><?php echo e($course_trans->short_description); ?></p>

            <div class="rate">
                <span><?php echo app('translator')->getFromJson('navbar.evaluation'); ?>   :</span>
                <?php echo $course->rating(($countRatings!=0)?$sumRatings/$countRatings:0); ?>

                <span>(<?php echo e($countRatings); ?> <?php echo app('translator')->getFromJson('navbar.evaluate'); ?>)</span>
            </div>
            <div class="row course_rate_info">
                <div class="col-6 rate_align">
                    <div class="rate_info" style="direction: <?php echo e($dir); ?>; text-align: <?php echo e($textalign); ?>">
                        <i class="fa fa-globe" aria-hidden="true"></i>
                        <p><?php echo app('translator')->getFromJson('navbar.langue'); ?> :</p>
                        <span><?php echo e(trans('home.'.$course->language)); ?></span>
                    </div>
                    <div class="rate_info" style="direction: <?php echo e($dir); ?>; text-align: <?php echo e($textalign); ?>" >
                        <i class="fa fa-check-square-o" aria-hidden="true"></i>
                        <p><?php echo app('translator')->getFromJson('navbar.exams'); ?> :</p>
                        <span><?php echo e($course->courses_quizzes()->where("active",1)->count()+
                         $course->courses_videoexams()->where("active",1)->count()); ?> <?php echo app('translator')->getFromJson('navbar.exams'); ?></span>
                    </div>
                </div>
                <div class="col-6 rate_align">
                    <div class="rate_info" style="direction: <?php echo e($dir); ?>; text-align: <?php echo e($textalign); ?>" >
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        <p><?php echo app('translator')->getFromJson('navbar.dure'); ?> :</p>
                        <span><?php echo e($course->period); ?></span>
                    </div>


                </div>
            </div>
            <!--<div>
                <i class="fa fa-file"></i> 
                <i class="fa fa-video"></i> 
                <i class="fa fa-html5"></i> 
            </div>-->
        </div>
    </div>
</div>
<?php if(Lang::locale()=="en"): ?>
                    <style type="text/css">
								   p,ul>li,ol>li{
									   text-align:left;
									   padding-left:15px;
									   
										direction: ltr;

									   
								   }
								   
								   
								  
								   
					</style>    
<?php endif; ?>					

<?php echo $course_trans->{'content_'. $courseType->type }; ?>

