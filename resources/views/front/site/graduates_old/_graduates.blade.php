<div class="table-responsive">
    <table class="table-bordered text-right graduates-table" style="width: 100%;">

        <thead>
        <tr role="row">
            <th>#</th>
            <th>الدورة</th>
            <th>الأسم</th>
            <th>الامتحان </th>
            <th>تاريخ أصدار الشهادة </th>
            <th>المزيد</th>
        </tr>
        </thead>
        <tbody>
        @foreach($studentCertificates as $studentCertificate)
            <?php
                $course_name = $studentCertificate->course_name;
                if(!is_null($studentCertificate->course))
                $course_name = $studentCertificate->course->course_trans('ar')->name;
                $exam_name = $studentCertificate->exam_name;
                if(!is_null($studentCertificate->exam))
                $exam_name = $studentCertificate->exam->quiz_trans('ar')->name;
                $student_name = '';
                if(!is_null($studentCertificate->student))
                $student_name = $studentCertificate->student->user->full_name_ar;
            ?>
            <tr>
                <td class="sorting_1">{{ $studentCertificate->serialnumber }}</td>
                <td>{{ $course_name }} </td>
                <td>{{ $student_name }}</td>
                <td>{{ $exam_name }}</td>
                <td>{{ date("Y-m-d",strtotime($studentCertificate->created_at)) }}</td>
                <td><a href="{{ url(App('urlLang').'certificates/'.$studentCertificate->id) }}" class="btn btn-primary btn-sm"> المزيد </a></td>
            </tr>
        @endforeach

        </tbody>

    </table>
</div>
<div class="dataTables_paginate">

    <a class="paginate_button first disabled" data-start="0" onclick="paginate(this)">الاول</a>
    <?php

        $currentPage = $current/40+1;
        $from = $currentPage;
        if($numPages>$currentPage+4)
            $to = $currentPage+4;
        else
            $to = $numPages;
        if($from-2>0){
            $from = $from-2;
            if($to!=$numPages){
                $to = $to-2;
            }

        }elseif($from-1>0){
            $from = $from-1;
            if($to!=$numPages-1)
                $to = $to-1;

        }
    ?>
    @for($i=$from;$i<=$to;$i++)
        <span><a class="paginate_button {{ $current==($i-1)*40?'current':null }}" data-start="{{ ($i-1)*40 }}" onclick="paginate(this)">{{$i}}</a></span>
    @endfor
    <a class="paginate_button last disabled" data-start="{{ $numPages*40-40 }}" onclick="paginate(this)">الاخير</a>
</div>