<?php $counter = 0;?>
@foreach($courseTypes as $courseType)
    @include("front.courses._course2",["courseType"=>$courseType,'loop'=>$loop])
@endforeach