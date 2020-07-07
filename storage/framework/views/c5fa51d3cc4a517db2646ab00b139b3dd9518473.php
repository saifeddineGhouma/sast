<?php $counter = 0;?>
<?php $__currentLoopData = $courseTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $courseType): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo $__env->make("front.courses._course2",["courseType"=>$courseType,'loop'=>$loop], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>