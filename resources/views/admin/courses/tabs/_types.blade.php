<div class="checkbox-list">
    <label class="checkbox-inline">
        <div class="checker">
            <span><input type="checkbox" name="online" {{ $course_type_online->type=="online"?"checked":null }}></span>
        </div>
            Online
    </label>
</div>
<div class="row" id="online_div" style="margin-left: 20px;">

    <div class="form-group">
        <label class="col-md-2 control-label">Points</label>
        <div class="col-md-10">
            <input  type="text"  name="points" class="form-control touchspin_3" value="{{$course_type_online->points or 0}}">
        </div>
    </div>
    @include("admin.courses.tabs._variations",["type1"=>"online","course_type"=>$course_type_online])
</div>

<div class="checkbox-list">
    <label class="checkbox-inline">
        <div class="checker">
            <span><input type="checkbox" name="presence" {{ $course_type_presence->type=="classroom"?"checked":null }}></span>
        </div>
        Classroom
    </label>
    <div class="row" id="presence_div" style="margin-left: 20px;">
        <div class="form-group">
            <label class="col-md-2 control-label">Points</label>
            <div class="col-md-10">
                <input  type="text"  name="presence_points" class="form-control touchspin_3" value="{{$course_type_presence->points or 0}}">
            </div>
        </div>
        @include("admin.courses.tabs._variations",["type1"=>"classroom","course_type"=>$course_type_presence])
    </div>
</div>