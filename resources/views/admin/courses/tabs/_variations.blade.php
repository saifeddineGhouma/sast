<div class="table-responsive">
    <table id="variations_{{$type1}}" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td class="text-left">teacher</td>
                @if(isset($type1) && $type1=="classroom")
                    <td>country</td>
                    <td class="text-right">government</td>
                    <td>date range</td>
                @endif
                <td class="text-right">price</td>
                 <td class="text-right">price sale</td>
                <td>certificate</td>
                <td></td>
            </tr>
        </thead>
        <tbody>
        @if($course_type->couseType_variations()->count()>0)
            @foreach($course_type->couseType_variations as $courseTypeVariation)
                <tr id="variation_{{$type1}}-row{{$courseTypeVariation->id}}" data-id="{{$courseTypeVariation->id}}">
                    <td class="text-left">
                        <select name="variation{{$type1}}_teacher_id_{{$courseTypeVariation->id}}" class="form-control">
                            @foreach($teachers as $teacher)
                                <option value="{{$teacher->id}}" {{ $teacher->id==$courseTypeVariation->teacher_id?"selected":null }}>{{$teacher->user->full_name_ar}}</option>
                            @endforeach
                        </select>
                    </td>
                    @if(isset($type1) && $type1=="classroom")
                        <td>
                            <div>
                                <?php
                                $currentCountry = "";
                                if(!empty($courseTypeVariation->government)){
                                    $currentCountry = $courseTypeVariation->government->country;
                                    $governments = $currentCountry->governments;
                                }
                                ?>
                                <select name="variation{{$type1}}_country_id_{{$courseTypeVariation->id}}" data-id="{{$courseTypeVariation->id}}" class="form-control country">

                                    @foreach($countries as $country)
                                        <option value="{{$country->id}}" {{!empty($currentCountry)&&$country->id==$currentCountry->id?"selected":null }}>{{$country->country_trans("en")->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </td>
                        <td class="text-right">
                            <select name="variation{{$type1}}_govern_id_{{$courseTypeVariation->id}}" class="form-control govern">
                                @foreach($governments as $government)
                                    <option value="{{$government->id}}" {{ $government->id==$courseTypeVariation->govern_id?"selected":null }}>{{$government->government_trans("en")->name}}</option>
                                @endforeach
                            </select>
                        </td>
                        <td class="text-right">
                            <div class="input-group input-large date-picker input-daterange"  data-date-format="yyyy-mm-dd">
                                <input type="text"  class="form-control" name="variation{{$type1}}_date_from_{{$courseTypeVariation->id}}" value="{{$courseTypeVariation->date_from}}">
                                <span class="input-group-addon"> to </span>
                                <input type="text" class="form-control" name="variation{{$type1}}_date_to_{{$courseTypeVariation->id}}" value="{{$courseTypeVariation->date_to}}">
                            </div>
                        </td>
                    @endif
                    <td class="text-right">
                        <input  type="text"  name="variation{{$type1}}_price_{{$courseTypeVariation->id}}" class="form-control touchspin_1" value="{{$courseTypeVariation->price or 0}}">
						<br>
						<div class="col-md-6" style="padding-left:0;">
							<input  type="text"  name="variation{{$type1}}_priceautre_{{$courseTypeVariation->id}}" class="form-control" value="{{$courseTypeVariation->priceautre or 0}}">
						</div>
						<div class="col-md-6" style="padding-right:0;">
							<select name="variation{{$type1}}_pricedevise_{{$courseTypeVariation->id}}" class="form-control">
								<option value="TND" {{ $courseTypeVariation->devise=="TND"?"selected":null }}>TND</option>
								<option value="USD" {{ $courseTypeVariation->devise=="USD"?"selected":null }}>USD</option>
								<option value="GBP" {{ $courseTypeVariation->devise=="GBP"?"selected":null }}>GBP</option>
								<option value="JPY" {{ $courseTypeVariation->devise=="JPY"?"selected":null }}>JPY</option>
								<option value="KWD" {{ $courseTypeVariation->devise=="KWD"?"selected":null }}>KWD</option>
								<option value="EGP" {{ $courseTypeVariation->devise=="EGP"?"selected":null }}>EGP</option>
								<option value="QAR" {{ $courseTypeVariation->devise=="QAR"?"selected":null }}>QAR</option>
								<option value="MAD" {{ $courseTypeVariation->devise=="MAD"?"selected":null }}>MAD</option>
								<option value="BHD" {{ $courseTypeVariation->devise=="BHD"?"selected":null }}>BHD</option>
							</select>
						</div>
				  </td>
                        <td class="text-right">
                        <input  type="text"  name="variation{{$type1}}_pricesale_{{$courseTypeVariation->id}}" class="form-control touchspin_1" value="{{$courseTypeVariation->pricesale or 0}}">
                    </td>
                    <td class="text-right">
                        <select name="variation{{$type1}}_certificate_id_{{$courseTypeVariation->id}}" class="form-control">
                            @foreach($certificates as $certificate)
                                <option value="{{$certificate->id}}"
                                        {{ $courseTypeVariation->certificate_id==$certificate->id?"selected":null }}>
                                    {{ $certificate->name_ar }}
                                </option>
                            @endforeach
                        </select>
                    </td>
                    <td class="text-left"><button type="button" onclick="$('#variation_{{$type1}}-row{{$courseTypeVariation->id}}').remove();" data-toggle="tooltip" title="" class="btn btn-danger" data-original-title="Remove"><i class="fa fa-minus-circle"></i></button></td>
                </tr>
            @endforeach
        @endif
        </tbody>
        <tfoot>
        <tr>
            <td colspan="{{ (isset($type1) && $type1=="classroom")?6:3 }}"></td>
            <td class="text-left"><button type="button" onclick="addVariation('{{$type1}}');" data-toggle="tooltip" title="" class="btn btn-primary" data-original-title="Add Image"><i class="fa fa-plus-circle"></i></button></td>
        </tr>
        </tfoot>
    </table>
</div>