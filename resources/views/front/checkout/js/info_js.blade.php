<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css"/>

<script src="{{asset('assets/front/vendors/build/js/intlTelInput.js')}}"></script>

<script src="{{asset('assets/front/vendors/validation/js/bootstrapValidator.min.js')}}" type="text/javascript"></script>

<script>

    $("#mobile").intlTelInput({

        // allowDropdown: false,

        // autoHideDialCode: false,

        // autoPlaceholder: "off",

        // dropdownContainer: "body",

        // excludeCountries: ["us"],

        // formatOnDisplay: false,

        // geoIpLookup: function(callback) {

        //   $.get("http://ipinfo.io", function() {}, "jsonp").always(function(resp) {

        //     var countryCode = (resp && resp.country) ? resp.country : "";

        //     callback(countryCode);

        //   });

        // },

        hiddenInput: "mobile",

        initialCountry: "auto",

        // nationalMode: false,

        // onlyCountries: ['us', 'gb', 'ch', 'ca', 'do'],

        placeholderNumberType: "MOBILE",

        // preferredCountries: ['cn', 'jp'],

        // separateDialCode: true,

        utilsScript: "{{asset('assets/front/vendors/build/js/utils.js')}}"

    });



</script>

<script>

    $(document).ready(function(){

        var date_input=$('.date-picker'); //our date input has the name "date"

        var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

        date_input.datepicker({

            format: 'yyyy-m-d',

            container: container,

            todayHighlight: true,

            autoclose: true,

        })

    })

    $("input[name='address'], input[name='streat'], input[name='house_number'], input[name='full_name_en']").keyup(function() {
        if (this.value.match(/[^a-zA-Z0-9 ]/g)) {
            this.value = this.value.replace(/[^a-zA-Z0-9 ]/g, '');
        }
    });

    $("input[name='full_name_ar']").keyup(function() {
        if (this.value.match(/[^0-9ا-ي]/g)) {
            this.value = this.value.replace(/[^0-9ا-ي ]/g, '');
        }
    });

    $("input[name='mobile']").keyup(function() {
        if (this.value.match(/[^0-9 ]/g)) {
            this.value = this.value.replace(/[^0-9 ]/g, '');
        }
    });


    $(".country_id").change(country_select);

    function country_select(e){

        var countryId = $(this).val();

        var country = $(this);

        var main_div = $(this).closest(".userlogedin");



        var govern_div = main_div.find(".governments_div");



        if(countryId!=""){

            govern_div.slideDown();

            $.ajax({

                url: "{{ url('/home/governments') }}",

                data: {countryId: countryId},

                type: "get",

                beforeSend: function(){

                    country.closest(".form-group").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");

                },

                success: function(result){



                    govern_div.find("select.form-control").html(result["governments"]);

//                        if(result["nonzip"]){

//                            $("input[name='post_code']").parent().addClass("display-none");

//                        }else{

//                            $("input[name='post_code']").parent().removeClass("display-none");

//                        }

                },

                complete: function(){

                    country.closest(".form-group").children('img').remove();

                }

            });

        }else{

            govern_div.slideUp();

        }

    }





</script>