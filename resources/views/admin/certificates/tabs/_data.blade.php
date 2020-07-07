<div class="row">
	<div class="col-md-10">
		<div class="form-group">
			<input type="hidden" name="image" id="image" value="{{$certificate->image}}"/>
		</div>
		<div id="qrcodeDiv" style="position: absolute; top: 0px; left: 0px;">
			@if(!is_null($certificate->qrcodex) && !is_null($certificate->qrcodey))
				<img src='{{asset('assets/admin/img/qr.jpg')}}'>
				<script>
                    <?php
                        $x = $certificate->qrcodex;
                        $y = $certificate->qrcodey;
                         $x_draw=$x+29;
                         $y_draw=$y+29
                    ?>
				$(document).ready(function(){
                        $('#qrcodeDiv').css({
                            "padding": "0px",
                            "background": "#fff",
                            "position": "absolute",
                            "left": {{ $x_draw }},
                            "top": {{ $y_draw }}
                        });
                        $("#qrcodeX").val("{{ $x }}");
                        $("#qrcodeY").val("{{ $y }}");
                    });
				</script>
			@endif
		</div>
		@foreach($infoCategory as $category=>$value)
			<div id="{{$category}}Div" style="position: absolute; top: 0px; left: 0px;">
				@if($certificate->certificate_contents()->where("fieldcolumn",$category)->count()>0)
					{{ $value }}
					@php
						$certificat_content = $certificate->certificate_contents()->where("fieldcolumn",$category)->first();
                        //$x = $certificate->x_input($certificat_content->xposition,$certificate->image_width);
                        //$y = $certificate->y_output($certificat_content->yposition,$certificate->image_height,$certificate->image_real_height)-5;
                        $x =$certificat_content->xposition;
                        $y = $certificat_content->yposition;
                         $x_draw=$x+29;
                        $y_draw=$y+29
					@endphp
					<script>
                        $(document).ready(function(){
                            $('#{{$category}}Div').css({
                                "padding": "0px",
                                "background": "#fff",
                                "position": "absolute",
                                "color": "{{ $certificat_content->fontcolors }}",
                                "font-size": {{ $certificat_content->fontsize }}+"px",
                                "left": {{ $x_draw }},
                                "top": {{ $y_draw }}
                            });
                            $("#{{$category}}X").val("{{ $x }}");
                            $("#{{$category}}Y").val("{{ $y }}");
                            $("#{{$category}}Color").val("{{ $certificat_content->fontcolors }}");
                            $("#{{$category}}Font").val("{{ $certificat_content->fontsize }}");
                            @if($certificat_content->showoncertificate)
								$("#{{$category}}Checked").prop("checked","true");
                            @else
								$("#{{$category}}Checked").removeAttr("checked");
							@endif
                        });

					</script>
				@endif
			</div>
		@endforeach

		<div id="certificate-div" onclick="drawTextToCertificate(event)" onmousemove="getPosition(event)" style="border: 1px solid #c4c4c4; top: 0px; left: 0px;">
			<img src="{{asset('uploads/kcfinder/upload/image/'.$certificate->image)}}" id="image-img"
				width="800px">

		</div>
	</div>
	<div class="col-md-2">

		<div class="form-group">
			<label>Active Element:</label>
			<input type="text" class="form-control" name="activeElement" id="activeElement" value="fullnamear" disabled >
		</div>
		<div class="form-group">
			<label>Mouse Position:</label>
			<div id="position"></div>
		</div>

		<div class="form-group">
			<div class="col-md-6">
				<a class="btn btn-file" onclick="openKCFinder($('#image-img'),$('#image'))">Select Certificate</a>
			</div>
		</div>
		<div class="form-group">
			<label class="radio-inline">
				<input type="radio" name="image_width" value="{{ $certificate->image_width or 1000 }}" checked="checked">Vertical
			</label>
			<label class="radio-inline">
				<input type="radio" name="image_width" value="{{ $certificate->image_width or 1415 }}">Horizontal
			</label>
		</div>

		<div class="panel-group form-group" id="accordion">

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse2" onmousedown="activeElementChange('fullnamear')">
							Full Name Arabic
						</a>
					</h4>
				</div>
				<div id="collapse2" class="panel-collapse collapse">
					<div class="panel-body" style="padding: 10px;">

						<div class="form-group col-sm-12">
							<label style="width: 100%">Position X and Y :</label>
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="fullnamearX" name="fullnamearX" onfocusout="drawTextTFromInput()">
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="fullnamearY" name="fullnamearY" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Width:</label>
							<input type="text" class="form-control" id="fullnamearWidth" name="fullnamearWidth" onfocusout="drawTextTFromInput()">
						</div>
						<div class="form-group col-sm-12">
							<label>Height:</label>
							<input type="text" class="form-control" id="fullnamearHeight" name="fullnamearHeight" onfocusout="drawTextTFromInput()">
						</div>

						<div class="checkbox1">
							<label>
								<input type="checkbox" id="fullnamearChecked" name="fullnamearChecked"  checked="checked">
								Show on Certificate
							</label>
						</div>

						<div class="form-group col-sm-12">
							<label>Text:</label>
							<input type="text" class="form-control" id="fullnamear" name="fullnamear" value="الاسم الثلاثي بالعربية" onfocusout="drawTextTFromInput()">
						</div>



						<div class="form-group col-sm-12">
							<label>Font size:</label>
							<input type="number" class="form-control text-center" id="fullnamearFont" name="fullnamearFont" value="13" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Color:</label>
							<input type="text" class="form-control" id="fullnamearColor" name="fullnamearColor" value="#000000" onfocusout="drawTextTFromInput()">
						</div>


					</div>
				</div>
			</div>




			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse3" onmousedown="activeElementChange('fullnameen')" >
							Full Name English
						</a>
					</h4>
				</div>
				<div id="collapse3" class="panel-collapse collapse">
					<div class="panel-body" style="padding: 10px;">

						<div class="form-group col-sm-12">
							<label style="width: 100%">Position X and Y :</label>
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="fullnameenX" name="fullnameenX" onfocusout="drawTextTFromInput()">
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="fullnameenY" name="fullnameenY" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Width:</label>
							<input type="text" class="form-control" id="fullnameenWidth" name="fullnameenWidth" onfocusout="drawTextTFromInput()">
						</div>
						<div class="form-group col-sm-12">
							<label>Height:</label>
							<input type="text" class="form-control" id="fullnameenHeight" name="fullnameenHeight" onfocusout="drawTextTFromInput()">
						</div>

						<div class="checkbox1">
							<label>
								<input type="checkbox" id="fullnameenChecked" name="fullnameenChecked" checked="checked">
								Show on Certificate
							</label>
						</div>


						<div class="form-group col-sm-12">
							<label>Text:</label>
							<input type="text" class="form-control" name="fullnameen" id="fullnameen" value="Full Name English" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Font size:</label>
							<input type="number" class="form-control text-center" id="fullnameenFont" name="fullnameenFont" value="13" onfocusout="drawTextTFromInput()">
						</div>


						<div class="form-group col-sm-12">
							<label>Color:</label>
							<input type="text" class="form-control" id="fullnameenColor" name="fullnameenColor" value="#000000" onfocusout="drawTextTFromInput()">
						</div>

					</div>
				</div>
			</div>


			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse4" onmousedown="activeElementChange('date')">
							Date
						</a>
					</h4>
				</div>
				<div id="collapse4" class="panel-collapse collapse">
					<div class="panel-body" style="padding: 10px;">

						<div class="form-group col-sm-12">
							<label style="width: 100%">Position X and Y :</label>
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="dateX" name="dateX" onfocusout="drawTextTFromInput()">
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="dateY" name="dateY" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Width:</label>
							<input type="text" class="form-control" id="dateWidth" name="dateWidth" onfocusout="drawTextTFromInput()">
						</div>
						<div class="form-group col-sm-12">
							<label>Height:</label>
							<input type="text" class="form-control" id="dateHeight" name="dateHeight" onfocusout="drawTextTFromInput()">
						</div>

						<div class="checkbox1">
							<label>
								<input type="checkbox" id="dateChecked" name="dateChecked" checked="checked">
								Show on Certificate
							</label>
						</div>

						<div class="form-group col-sm-12">
							<label>Text:</label>
							<?php $date = (empty($certificate->date)) ? date("Y-m-d") : $certificate->date;?>
							<input type="date" class="form-control" id="date" name="date" value="<?php echo $date; ?>" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Font size:</label>
							<input type="text" class="form-control text-center" id="dateFont" name="dateFont" value="13" onfocusout="drawTextTFromInput()">
						</div>


						<div class="form-group col-sm-12">
							<label>Color:</label>
							<input type="text" class="form-control" id="dateColor" name="dateColor" value="#000000" onfocusout="drawTextTFromInput()">
						</div>

					</div>
				</div>
			</div>



			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse7" onmousedown="activeElementChange('serialnumber')">
							Serial Number
						</a>
					</h4>
				</div>
				<div id="collapse7" class="panel-collapse collapse">
					<div class="panel-body" style="padding: 10px;">

						<div class="form-group col-sm-12">
							<label style="width: 100%">Position X and Y :</label>
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="serialnumberX" name="serialnumberX" onfocusout="drawTextTFromInput()">
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="serialnumberY" name="serialnumberY" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Width:</label>
							<input type="text" class="form-control" id="serialnumberWidth" name="serialnumberWidth" onfocusout="drawTextTFromInput()">
						</div>
						<div class="form-group col-sm-12">
							<label>Height:</label>
							<input type="text" class="form-control" id="serialnumberHeight" name="serialnumberHeight" onfocusout="drawTextTFromInput()">
						</div>

						<div class="checkbox1">
							<label>
								<input type="checkbox" id="serialnumberChecked" name="serialnumberChecked" checked="checked" >
								Show on Certificate
							</label>
						</div>

						<div class="form-group col-sm-12">
							<label>Text:</label>
							<input type="text" class="form-control" id="serialnumber" name="serialnumber" value="54654545465465" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Font size:</label>
							<input type="text" class="form-control text-center" id="serialnumberFont" name="serialnumberFont" value="13" onfocusout="drawTextTFromInput()">
						</div>


						<div class="form-group col-sm-12">
							<label>Color:</label>
							<input type="text" class="form-control" id="serialnumberColor" name="serialnumberColor" value="#000000" onfocusout="drawTextTFromInput()">
						</div>

					</div>
				</div>
			</div>

			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="panel-title">
						<a data-toggle="collapse" data-parent="#accordion" href="#collapse5" onmousedown="activeElementChange('qrcode')">
							Qr
						</a>
					</h4>
				</div>
				<div id="collapse5" class="panel-collapse collapse">
					<div class="panel-body" style="padding: 10px;">

						<div class="form-group col-sm-12">
							<label style="width: 100%">Position X and Y :</label>
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="qrcodeX" name="qrcodex" onfocusout="drawTextTFromInput()">
							<input type="text" class="form-control col-sm-12" style="width: 45%; " id="qrcodeY" name="qrcodey" onfocusout="drawTextTFromInput()">
						</div>

						<div class="form-group col-sm-12">
							<label>Width:</label>
							<input type="text" class="form-control" id="qrcodeWidth" name="qrcodeWidth" onfocusout="drawTextTFromInput()">
						</div>
						<div class="form-group col-sm-12">
							<label>Height:</label>
							<input type="text" class="form-control" id="qrcodeHeight" name="qrcodeHeight" onfocusout="drawTextTFromInput()">
						</div>

						<div class="checkbox1">
							<label>
								<input type="checkbox" id="qrcodeChecked" name="qrcodeChecked"checked="checked">
								Show on Certificate
							</label>
						</div>

						<div class="form-group col-sm-12">
							<label>Text:</label>
							<input type="text" class="form-control" id="qrcode" value="<img src='{{asset('assets/admin/img/qr.jpg')}}'>" disabled>
						</div>

						<div class="form-group col-sm-12">
							<label>Font size:</label>
							<input type="text" class="form-control text-center" id="qrcodeFont" name="qrcodeFont" value="13" onfocusout="drawTextTFromInput()">
						</div>


						<div class="form-group col-sm-12">
							<label>Color:</label>
							<input type="text" class="form-control" id="qrcodeColor" name="qrcodeColor" value="#000000" onfocusout="drawTextTFromInput()">
						</div>

					</div>
				</div>
			</div>

		</div>
	</div>


</div>
