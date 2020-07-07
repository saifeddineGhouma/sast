<?php $counter = 0;?>
@foreach($courseTypes as $courseType)
    @include("front.courses._course",["courseType"=>$courseType,'loop'=>$loop])
@endforeach