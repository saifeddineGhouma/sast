

		<input type="hidden" id="id" name="id" value="{{$method=='edit' ? $course->id:"0"}}">

		<div id="courseTypeMessage" class="alert alert-danger display-none">

			Course Types Required

		</div>

		<div class="form-actions left" style="float: right;">

	        <button type="submit" id="submitbtn" class="btn btn-responsive btn-primary btn-sm" data-loading-text="saving...">

	            <i class="fa fa-check"></i> Save</button>

	        <button type="button" class="btn btn-responsive btn-default" onclick="js:window.location='{{url('admin/'.$table_name)}}'"><i class="fa fa-reply"></i> Cancel</button>

			@if($method=="edit")

				<br/>

				<a data-toggle="modal" href="#modal-2" class="btn btn-responsive btn-success merge">

					Merge

				</a>

				<a data-toggle="modal" href="#modal-3" class="btn btn-responsive btn-success import">

					Import

				</a>

			@endif

	    </div>	

	    

	    

	    <div class="tabbable-bordered">

            <ul class="nav nav-tabs">

                <li class="active">

                    <a href="#tab_general" data-toggle="tab"> Public </a>

                </li>

                <li>

					<a href="#tab_data" data-toggle="tab"> Data </a>

				</li>

				<li>

					<a href="#tab_types" data-toggle="tab"> Types </a>

				</li>

				<li>

					<a href="#tab_discount" data-toggle="tab"> Discount </a>

				</li>

				<li>

					<a href="#tab_studies" data-toggle="tab"> Studies

						<span class="badge badge-success"> {{$course->studies->count()}} </span>

					</a>

				</li>

				<li>

					<a href="#tab_exams" data-toggle="tab"> Exams & Quizzes </a>

				</li>
				@if($method=="edit")
					<li>
						<a href="#tab_stats" data-toggle="tab"> Stats </a>
					</li>
				@endif

            </ul>

            <div class="tab-content">

                <div class="tab-pane active" id="tab_general">

                	<div class="row">

			            <div class="col-lg-12">

			                <div class="panel">

			                	 <div class="panel-heading">

			

			                    </div>

			                    <div class="panel-body">

                    				@include("admin.".$table_name.".tabs._general")

                    			</div>

                    		</div>

                    	</div>

                   </div>

                </div>

                <div class="tab-pane" id="tab_data">

                    <div class="row">

		        		<div class="panel">

		        			<div class="panel-heading">

		

		                    </div>

		        			<div class="panel-body">

                       			@include("admin.".$table_name.".tabs._data")

                       		</div>

                       	</div>

                    </div>

                </div>

				<div class="tab-pane" id="tab_types">

					<div class="row">

						<div class="panel">

							<div class="panel-heading">



							</div>

							<div class="panel-body">

								@include("admin.".$table_name.".tabs._types")

							</div>

						</div>

					</div>

				</div>

				<div class="tab-pane" id="tab_discount">

					<div class="row">

						<div class="panel">

							<div class="panel-heading">



							</div>

							<div class="panel-body">

								@include("admin.".$table_name.".tabs._discount")

							</div>

						</div>

					</div>

				</div>

				<div class="tab-pane" id="tab_studies">

					<div class="row">

						<div class="panel">

							<div class="panel-heading">



							</div>

							<div class="panel-body">

								@include("admin.".$table_name.".tabs._studies")

							</div>

						</div>

					</div>

				</div>

				<div class="tab-pane" id="tab_exams">

					<div class="row">

						<div class="panel">

							<div class="panel-heading">



							</div>

							<div class="panel-body">

								@include("admin.".$table_name.".tabs._exams")

							</div>

						</div>

					</div>

				</div>	

				@if($method=="edit")			
					<div class="tab-pane" id="tab_stats">

						<div class="row">

							<div class="panel">

								<div class="panel-heading">



								</div>

								<div class="panel-body">

									@include("admin.".$table_name.".tabs._stats")

								</div>

							</div>

						</div>

					</div>
				@endif
			</div>

           

        </div>