@extends('admin/layouts/master')

@section('title')
	View Invoice
@endsection

@section("header_styles")
	<link href="{{asset('assets/admin/vendors/validation/css/bootstrapValidator.min.css')}}" type="text/css" rel="stylesheet">
	<link href="{{asset('assets/admin/vendors/jasny-bootstrap/jasny-bootstrap.min.css')}}" rel="stylesheet" />

	<link href="{{asset('assets/admin/css/pages/editor.css')}}" rel="stylesheet" type="text/css"/>
	<link href="{{asset('assets/admin/vendors/bootstrap-select/css/bootstrap-select.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/admin/vendors/select2/select2.min.css')}}" type="text/css" rel="stylesheet">
	<link href="{{asset('assets/admin/vendors/select2/select2-bootstrap.min.css')}}" type="text/css" rel="stylesheet">
	<link href="{{asset('assets/admin/vendors/jquery-multi-select/css/multi-select.css')}}" rel="stylesheet" type="text/css" />

	<link href="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.css')}}" rel="stylesheet" type="text/css" media="all"/>

	<link href="{{asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/admin/vendors/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
	<style type="text/css" >
		#map_canvas {
			 width:300px;
			 height:300px;
		}
		.print{
			display:none;
		}
		@media print{
			.noprint {display:none;}
			.print{
				display:block;
				position:absolute;
				top:0;
				left:0;
			}
		}
	</style>
@endsection

@section('content')
<!-- Content Header (Page header) -->
<section class="content-header noprint">
    <!--section starts-->
    <h1>View Invoice {{$factures->id}}</h1>
    <ol class="breadcrumb">
        <li>
            <a href="{{url('/admin')}}">
                <i class="livicon" data-name="home" data-size="14" data-loop="true"></i>
                dashboard
            </a>
        </li>
        <li>
            <a href="{{url('/admin/invoice')}}">Invoice</a>
        </li>       
        <li class="active">View</li>
    </ol>
</section>
<!--section ends-->
<section class="content noprint">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary filterable portlet box">
            	<div class="panel-heading clearfix">
					<div class="panel-title pull-left">
					   <div class="caption">
							<i class="livicon" data-name="camera-alt" data-size="16" data-loop="true" data-c="#fff" data-hc="white"></i>
							View Invoice {{$factures->id}}
						</div>
					</div>
				</div>
          		
                <div class="panel-body">
					<div class="form-actions left" style="float: right;">
						<a id="print" class="btn btn-responsive btn-primary btn-sm">
							Print
						</a>
						<a href="/admin/invoice/send/{{$factures->id}}" class="btn btn-responsive btn-primary btn-sm">
							Send Invoice
						</a>
					</div>
					<div>
						<img src="https://swedish-academy.se/uploads/kcfinder/upload/image/factures/facture{{$factures->id}}.jpg" style="max-width:100%;" />
					</div>
                </div>
           </div>
	    </div>
	</div>  
</section>
<img src="https://swedish-academy.se/uploads/kcfinder/upload/image/factures/facture{{$factures->id}}.jpg" style="max-width:100%;" class="print" />

@endsection

@section("footer_scripts")
	<script src="{{asset('assets/admin/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/bootstrap-select/js/bootstrap-select.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/jquery-multi-select/js/jquery.multi-select.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/js/pages/components-multi-select.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/select2/select2.min.js')}}" type="text/javascript"></script>

	<script src="{{asset('assets/admin/vendors/tags/dist/bootstrap-tagsinput.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/touchspin/dist/jquery.bootstrap-touchspin.js')}}"></script>

	<script src="{{asset('assets/admin/vendors/moment.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/admin/vendors/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>

	<script src="{{asset('assets/admin/js/pages/components-date-time-pickers.js')}}" type="text/javascript"></script>
	<script>
		document.querySelector("#print").addEventListener("click", function() {
			window.print();
		});
	</script
@endsection
