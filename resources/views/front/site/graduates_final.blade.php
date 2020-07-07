@extends('front/layouts/master')

@section('meta')
    <title>@lang('navbar.gratuated')</title>

@stop
@php $dir = session()->get('locale') === "ar" ? "rtl" : "ltr" @endphp
@php $textalign = session()->get('locale') === "ar" ? "right" : "left" @endphp
@section('content')
    <div class="training_purchasing">
        <div class="container training_container">
            <div class="media" style="direction : {{ $dir }}">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <i class="fa fa-home" aria-hidden="true"></i>
                            <a href="{{url(App('urlLang'))}}"><span>{{trans('home.home')}}</span></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            <span>@lang('navbar.gratuated')</span> <span>({{ $year }})
                                @if(!empty($course))
                                    ({{ $course->course_trans(session()->get('locale'))->name }})
                                @endif
                            </span>
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    
    <div class="container padding-50" style="text-align: {{ $textalign }}">
        <h3><span>@lang('navbar.gratuated')</span> <span>({{ $year }})
                @if(!empty($course))
                    ({{ $course->course_trans(session()->get('locale'))->name }}) 
                    <br/>
                    @lang('navbar.records')    : {{ $studentCertificate->teacher_name }}
                @endif
            </span>
        </h3>
        <div class="row">
            <input type="hidden" name="start" value="0"/>
            <input type="hidden" name="length" value="40"/>
      
			<form  id="info_form" method="get" action="{{ url(App('urlLang').'graduates') }}" enctype="multipart/form-data" autocomplete="on" style="width: 100%;">
        @if(session()->get('locale') === "ar")
				<div class="col-xs-12 userlogedin text-right">
					<div class="col-md-8">
						<div class="form-group autocomplete"  >
							<input type="text" placeholder="Search by name or certificate ID" class="form-control search-name"  id="myInput" name="code"/>
						</div>
					</div>
					<div class="col-md-4">
						<div class="form-group">
							<input type="submit" class="btn btn-md btn-success svme" value="Search">
						</div>
					</div>
        </div>
        @else 
        <div class="col-xs-12 userlogedin text-right">
            <div class="col-md-4">
                <div class="form-group">
                  <input type="submit" class="btn btn-md btn-success svme" value="@lang('navbar.search')">
                </div>
              </div>
            <div class="col-md-8">
              <div class="form-group autocomplete" style="direction: {{$dir}}">
                <input type="text" placeholder="@lang('navbar.searchByNameOrCertificat')" class="form-control search-name"  id="myInput" name="code"/>
              </div>
            </div>
            
          </div>

        @endif
        
			</form>
            
            <div class="col-md-12" id="graduates_content">
            </div>
        </div>
    </div>

	<?php
		$listlistStudentt="";
		foreach($listStudent as $listStudents){
			$listlistStudentt .= '"'.$listStudents->full_name_en.'",';
		}
		$listlistStudentt = substr($listlistStudentt, 0 , -1);
		
		$listlistcert="";
		foreach($listcertificate as $listcertificates){
			$listlistcert .= '"'.$listcertificates->serialnumber.'",';
		}
		$listlistcert = substr($listlistcert, 0 , -1);
		
		if($listlistStudentt!="" and $listlistcert!=""){
			$list = $listlistStudentt.','.$listlistcert;
		}
		
		if($listlistStudentt=="" and $listlistcert!=""){
			$list = $listlistcert;
		}
		
		if($listlistStudentt!="" and $listlistcert==""){
			$list = $listlistStudentt;
		}
	?>

@stop

@section('scripts')
    @include("front.site.js.graduates_js")

<script text="javascript">
  function autocomplete(inp, arr) {
  /*the autocomplete function takes two arguments,
  the text field element and an array of possible autocompleted values:*/
  var currentFocus;
  /*execute a function when someone writes in the text field:*/
  inp.addEventListener("input", function(e) {
      var a, b, i, val = this.value;
      /*close any already open lists of autocompleted values*/
      closeAllLists();
      if (!val) { return false;}
      currentFocus = -1;
      /*create a DIV element that will contain the items (values):*/
      a = document.createElement("DIV");
      a.setAttribute("id", this.id + "autocomplete-list");
      a.setAttribute("class", "autocomplete-items");
      /*append the DIV element as a child of the autocomplete container:*/
      this.parentNode.appendChild(a);
      /*for each item in the array...*/
      for (i = 0; i < arr.length; i++) {
        /*check if the item starts with the same letters as the text field value:*/
        if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
          /*create a DIV element for each matching element:*/
          b = document.createElement("DIV");
          /*make the matching letters bold:*/
          b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
          b.innerHTML += arr[i].substr(val.length);
          /*insert a input field that will hold the current array item's value:*/
          b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
          /*execute a function when someone clicks on the item value (DIV element):*/
          b.addEventListener("click", function(e) {
              /*insert the value for the autocomplete text field:*/
              inp.value = this.getElementsByTagName("input")[0].value;
              /*close the list of autocompleted values,
              (or any other open lists of autocompleted values:*/
              closeAllLists();
          });
          a.appendChild(b);
        }
      }
  });
  /*execute a function presses a key on the keyboard:*/
  inp.addEventListener("keydown", function(e) {
      var x = document.getElementById(this.id + "autocomplete-list");
      if (x) x = x.getElementsByTagName("div");
      if (e.keyCode == 40) {
        /*If the arrow DOWN key is pressed,
        increase the currentFocus variable:*/
        currentFocus++;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 38) { //up
        /*If the arrow UP key is pressed,
        decrease the currentFocus variable:*/
        currentFocus--;
        /*and and make the current item more visible:*/
        addActive(x);
      } else if (e.keyCode == 13) {
        /*If the ENTER key is pressed, prevent the form from being submitted,*/
        e.preventDefault();
        if (currentFocus > -1) {
          /*and simulate a click on the "active" item:*/
          if (x) x[currentFocus].click();
        }
      }
  });
  function addActive(x) {
    /*a function to classify an item as "active":*/
    if (!x) return false;
    /*start by removing the "active" class on all items:*/
    removeActive(x);
    if (currentFocus >= x.length) currentFocus = 0;
    if (currentFocus < 0) currentFocus = (x.length - 1);
    /*add class "autocomplete-active":*/
    x[currentFocus].classList.add("autocomplete-active");
  }
  function removeActive(x) {
    /*a function to remove the "active" class from all autocomplete items:*/
    for (var i = 0; i < x.length; i++) {
      x[i].classList.remove("autocomplete-active");
    }
  }
  function closeAllLists(elmnt) {
    /*close all autocomplete lists in the document,
    except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
      if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
}
var namelist = [<?php echo $list; ?>];

/*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
autocomplete(document.getElementById("myInput"), namelist);
</script>


@stop


