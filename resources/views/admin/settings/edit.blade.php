@extends('admin/layouts/master')
@section("title")
Edit Public Settings
@endsection

@section("header_styles")
<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
 <link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
 <link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" />
@endsection
                 
@section('content') 
<!-- Content Header (Page header) -->
<section class="content-header">
    <!--section starts-->
    <h1>Edit Public Settings</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                Dashboard
            </a>
        </li>      
        <li class="active">Edit Public Settings</li>
    </ol>
</section>
<!--section ends-->
<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable portlet box">
            	 <div class="panel-heading clearfix">
	                    <div class="panel-title pull-left">
                           <div class="caption">
		                        <i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
		                        Edit Public Settings
		                    </div>
	                    </div>
	                </div>
          		
                <div class="panel-body">
					@include('common.flash')
					@include('common.errors')
	                	
	                @include("admin.settings._form",array("method"=>"edit"))
                </div>
           </div>
	    </div>
	</div>
</section>

@endsection    
@section("footer_scripts")
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/bootstrap-maxlength/bootstrap-maxlength.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>

	<script  src="{{asset('assets/admin/vendors/ckeditor/ckeditor.js')}}" type="text/javascript"></script>
	<script  src="{{asset('assets/admin/vendors/ckeditor/adapters/jquery.js')}}" type="text/javascript"></script>
	<script  src="{{asset('assets/admin/vendors/ckeditor/config.js')}}" type="text/javascript"></script>

<script>

{{--var areas = Array('en_index_section', 'ar_index_section');--}}
{{--$.each(areas, function (i, area) {--}}
	{{--CKEDITOR.replace(area, {--}}
		{{--filebrowserBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=file")}}',--}}
		{{--filebrowserImageBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=image")}}',--}}
		{{--filebrowserFlashBrowseUrl: '{{asset("uploads/kcfinder/browse.php?type=flash")}}',--}}
	{{--});--}}
 {{--});--}}

	//init maxlength handler
$('.maxlength-handler').maxlength({
    limitReachedClass: "label label-danger",
    alwaysShow: true,
    threshold: 5
});
$(".touchspin_1").TouchSpin({
    min: 0,
    max: 20000,
    step: 0.001,
    decimals: 2,
    boostat: 5,
    maxboostedstep: 10,
    postfix: '$'
});

$(".touchspin_3").TouchSpin({
    min: 0,
    max: 500,
    step: 1,
    decimals: 0,
    boostat: 5,
    maxboostedstep: 20,
    postfix: 'point'
});
$(".touchspin_2").TouchSpin({
    min: 0,
    max: 100,
    step: 0.5,
    decimals: 1,
    boostat: 5,
    maxboostedstep: 20,
    postfix: '%'
});

function openKCFinder(field,hiddenField) {
    window.KCFinder = {
        callBack: function(url) {
             field.attr("src",url) ;
           	var filename = url.substr(url.lastIndexOf('image/')+6);
        	hiddenField.val(filename);
            window.KCFinder = null;
        },
        title: 'File Browser',
    };
	window.open('{{asset("uploads/kcfinder/browse.php?type=image")}}', 'kcfinder_textbox',
        'status=0, toolbar=0, location=0, menubar=0, directories=0, ' +
        'resizable=1, scrollbars=0, width=800, height=600'
    );
}

$("#phone").change(function(){
	var phone = $("#phone").val().replace(/[^0-9]/g, '');
	$(this).val(phone);
});

$("#mobile").change(validatePhone);
function validatePhone(){
	var error = 0;
	 var phone= $("#mobile").val().replace(/[^0-9]/g, '');
	 $(this).val(phone);
    
   return error; 
}

function addImage(lang){
	var id =  1;
	var lastRow = $('#images-ar > tbody');
	if($('#images-ar tbody>tr:last').data("id")){
		id = parseInt($('#images tbody>tr:last').data("id"))+1;
	}
	if(lang=='en'){
		lastRow = $('#images-en > tbody');
		if($('#images-en tbody>tr:last').data("id")){
			id = parseInt($('#images tbody>tr:last').data("id"))+1;
		}
	}
	
	lastRow.append('<tr id="image-row_'+lang+id+'" data-id="'+id+'">'+
         ' <td class="text-left">'+
          	'<a href="javascript:void(0)" id="thumb-image'+id+'" data-toggle="image" class="img-thumbnail">'+
          	
          		'<div class="fileinput-new thumbnail" onclick="openKCFinder($(\'#sliderimage'+lang+id+'\'),$(\'#sliderimage_image_'+lang+id+'\'))" data-trigger="fileinput" style="width: 100px; height: 100px;margin-bottom: 0px;">'+
          			'<img src="" id="sliderimage'+lang+id+'">'+
          		'</div>'+
          	'</a>'+
          	'<input type="hidden" name="sliderimage_'+lang+'['+id+'][image]" value="" id="sliderimage_image_'+lang+id+'">'+
          '</td>'+          
           '<td>'+
          	'<input type="text" name="sliderimage_'+lang+'['+id+'][title]" placeholder="Title" class="form-control">'+
          '</td>'+
          '<td>'+
          	'<textarea name="sliderimage_'+lang+'['+id+'][description]" cols="60" placeholder="Description" class="form-control"></textarea>'+
          '</td>'+
          
          '<td>'+
          	'<input type="text" name="sliderimage_'+lang+'['+id+'][link]" placeholder="Link" class="form-control">'+
          '</td>'+
          '<td class="text-right">'+
          	'<input type="number" name="sliderimage_'+lang+'['+id+'][sort_order]" value="" placeholder="Sort Order" class="form-control">'+
          '</td>'+
          '<td class="text-right">'+
          	'<input type="checkbox" name="sliderimage_'+lang+'['+id+'][active]" checked placeholder="Active" >'+
          '</td>'+
          '<td class="text-left"><button type="button" onclick="$(\'#image-row_'+lang+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
        '</tr> ');
}

function addSocial(){
	var id =  1;
	var lastRow = $('#socials > tbody');
	
	if($('#socials tbody>tr:last').data("id")){
		id = parseInt($('#socials tbody>tr:last').data("id"))+1;
	}
	
	lastRow.append('<tr id="link-row'+id+'" data-id="'+id+'">'+
		         ' <td class="text-left">'+
		          	'<a href="javascript:void(0)">'+
		          		'<input type="text" name="socials['+id+'][name]" class="form-control">'+
		          	'</a>'+
		          '</td>'+
		          '<td>'+
		          	'<select class="form-control" name="socials['+id+'][font]">'+
		          		@foreach($socialArray as $key=>$value)
		          			'<option value="{{$key}}">{{$value}}</option>'+
		          		@endforeach
		          	'</select>'+		          	
		          '</td>'+
		          '<td class="text-right">'+
		          	'<input type="text" name="socials['+id+'][link]" class="form-control">'+
		          '</td>'+
		          '<td class="text-left"><button type="button" onclick="$(\'#link-row'+id+'\').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>'+
		        '</tr>');
	
}


    
    
$("#form_settings").bootstrapValidator({
	
}).on('success.form.bv', function(e) {

}); 
</script>

@endsection

