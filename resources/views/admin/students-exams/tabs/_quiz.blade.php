<div class="panel">
    <div class="form-group">
        <label class="col-md-2 control-label">Student Full Name</label>
        <div class="col-md-10">
            <input  type="text"  name="student_name" class="form-control" value="{{ $studentQuiz->student->user->full_name_ar }}" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Student UserName</label>
        <div class="col-md-10">
            <input  type="text"  name="student_username" class="form-control" value="{{ $studentQuiz->student->user->username }}" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">{{ $title }} Name</label>
        <div class="col-md-10">
            <input  type="text"  name="video_exam_name" class="form-control" value="{{ $exam_name }}" readonly>
        </div>
    </div>
    <div class="form-group">
        <label class="col-md-2 control-label">Course Name</label>
        <div class="col-md-10">
            <input  type="text"  name="course_name" class="form-control" value="{{ $studentQuiz->course->course_trans("ar")->name or  $studentQuiz->course_name}}" readonly>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Result</label>
        <div class="col-sm-10">
            <input type="text" value="{{ $studentQuiz->result }} / {{ $studentQuiz->final_mark }}" readonly/>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Status</label>
        <div class="col-sm-10">
            <select name="status" class="form-control">
                @foreach($statusData as $key=>$status)
                    <option value="{{$key}}" {{ $studentQuiz->status == $key?"selected":null }}>{{ $status }}</option>
                @endforeach
            </select>
            <div class="help alert alert-info">
                to retest change status to not completed
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">Result</label>
        <div class="col-sm-10">
            <div class="radio-list">
                <label>
                    <input type="radio" name="successfull" value="1"  {{($studentQuiz->successfull)?"checked":null}}/>
                    Successfull  </label>
                <label>
                    <input type="radio" name="successfull" value="0" {{(!$studentQuiz->successfull)?"checked":null}} />
                    Failed </label>
            </div>
        </div>
    </div>

</div>