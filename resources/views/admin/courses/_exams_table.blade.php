<div class="table-responsive">
    <table id="{{$from_section}}_table" class="table table-striped table-bordered table-hover">
        <thead>
        <tr>
            <td>{{ucfirst($from_section)}}</td>
            <td>active</td>
            @if($from_section=="exam")
                <td>attempts <br/>(zero no limits)</td>
            @endif
            <td></td>
        </tr>
        </thead>
        <tbody>
        @php
            $name = "course";
            if($from_section == "video")
                $name = "video";
        @endphp
        @foreach($course_quizzes as $course_quiz)
            <tr id="{{$from_section}}-row{{$course_quiz->id}}" data-id="{{$course_quiz->id}}">
                <td class="text-left">
                    @if($from_section == "video")
                        <select  name="video_videoexam_id_{{$course_quiz->id}}" class="form-control select2">
                            @foreach($videoExams as $videoExam)
                                <option value="{{$videoExam->id}}" {{$course_quiz->videoexam_id == $videoExam->id?"selected":null}}>
                                    {{ $videoExam->videoexam_trans("ar")->name }}
                                </option>
                            @endforeach
                        </select>
                    @else
                        <select  name="course_quiz_id_{{$course_quiz->id}}" class="form-control select2">
                            @foreach($examData as $quiz)
                                <option value="{{$quiz->id}}" {{$course_quiz->quiz_id == $quiz->id?"selected":null}}>
                                    {{ $quiz->quiz_trans("ar")->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                </td>
                <td>
                    <input type="checkbox" name="{{$name}}_active_{{$course_quiz->id}}" {{ $course_quiz->active?"checked":null }}>
                </td>
                @if($from_section=="exam")
                    <td>
                        <input type="number" class="form-control" name="{{$name}}_attempts_{{$course_quiz->id}}" value="{{$course_quiz->attempts}}">
                    </td>
                @endif

                <td class="text-left"><button type="button" onclick="$('#{{$from_section}}-row{{$course_quiz->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="{{$from_section=="exam"?3:2}}"></td>
            <td class="text-left"><button type="button"
                 @if($from_section=="quiz")
                         <?php $action_name = "addQuiz" ?>
                 @elseif($from_section=="exam")
                        <?php $action_name = "addExam" ?>
                  @else
                        <?php $action_name = "addVideo" ?>
                  @endif
                 onclick = 'x_{{  $action_name }}()'
            data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
        </tfoot>
    </table>
</div>
<script>
    function x_{{  $action_name }}(){
        var id =  1;
        var increment = 1;

        var from_section = '{{$from_section}}';
        if(from_section=='exam'){
            id=31;
            increment = 30;
        }

        var lastRow = $('#{{$from_section}}_table > tbody');

        if($('#{{$from_section}}_table tbody>tr:last').data("id")){
            id = parseInt($('#{{$from_section}}_table tbody>tr:last').data("id"))+increment;
        }

        htmlResult = '<tr id="{{$from_section}}-row'+id+'" data-id="'+id+'">'+
            '<td class="text-left">';
                @if($from_section == "video")
                    htmlResult +=   '<select  name="videos['+id+'][videoexam_id]" class="form-control select2">'+
                        @foreach($videoExams as $videoExam)
                            '<option value="{{$videoExam->id}}">'+
                                '{{ $videoExam->videoexam_trans("ar")->name }}'+
                                '</option>'+
                        @endforeach
                            '</select>';
                 @else
                     htmlResult += '<select name="courses['+id+'][quiz_id]" class="form-control select2">'+
                        @foreach($examData as $quiz)
                            '<option value="{{$quiz->id}}">'+
                    '{{ $quiz->quiz_trans("ar")->name }}'+
                    '</option>'+
                        @endforeach
                            '</select>';
                 @endif
                     htmlResult +='</td>'+
            '<td>'+
            '<input type="checkbox" name="{{$name}}s['+id+'][active]">'+
            '</td>'+
            @if($from_section=="exam")
                '<td>'+
                    '<input type="number" class="form-control" name="{{$name}}s['+id+'][attempts]">'+
                ' </td>'+
            @endif

            '<td class="text-left"><button type="button" onclick="$(\'#{{$from_section}}-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
            '</tr> ';
        lastRow.append(htmlResult);
        $(".select2").select2({
            theme:"bootstrap",
            placeholder:"",
            width: '100%'
        });
        $('.date-picker').datepicker({
            orientation: "left",
            autoclose: true
        });
    }
</script>