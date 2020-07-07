@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
<div class="table-responsive">
    <table class="table-bordered text-center graduates-table" style="width: 100%;" dir = "{{ $dir }}">

        <thead>
        <tr role="row">
            <th class="text-center">@lang('navbar.certifnum')</th>
            <th class="text-center">@lang('navbar.nom')</th>
            <th class="text-center">@lang('navbar.nation')</th>
            <th class="text-center">@lang('navbar.datecertif') </th>
            <th class="text-center">@lang('navbar.more')</th>
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
                $student_name = ucwords(strtolower($studentCertificate->student->user->full_name_en));
            ?>
            <tr>
                <td class="sorting_1">{{ $studentCertificate->serialnumber }}</td>
                <td> {{$student_name}}</td>
                <td>
                    
                    {{ $studentCertificate->student->user->nationality }}
                   
                </td>
                <td>{{ $studentCertificate->date }}</td>
                <td><a href="{{ url(App('urlLang').'certificates/'.$studentCertificate->serialnumber) }}" class="btn btn-primary btn-sm"> @lang('navbar.more') </a></td>
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