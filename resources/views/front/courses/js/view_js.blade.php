<script>
    $(".reply-form").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            discussion: {
                validators: {
                    notEmpty: {
                        message: 'discussion is required'
                    }
                },
                required: true
            }
        }
    }).on('success.form.bv', function(e) {
        e.preventDefault();
        var form = $(this);
        $.ajax({
            url: form.attr('action'),
            data: form.serialize(),
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            },
            beforeSend: function(){
                form.find(".insert_comment").button("loading");
            },
            success: function( message ) {
                form.find(".reply-message").html(message);
            },
            //complete event
            complete: function() {
                form.find(".insert_comment").button("reset");
            }
        });
    });

    $("#form-review").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            value_quality: {
                validators: {
                    notEmpty: {
                        message: 'quality is required'
                    }
                },
                required: true
            },
            value_subject: {
                validators: {
                    notEmpty: {
                        message: 'تعمير خانة جودة المادة إجباري<br>'
                    }
                },
                required: true
            },
            value_price: {
                validators: {
                    notEmpty: {
                        message: 'تعمير خانة السعر إجباري<br>'
                    }
                },
                required: true
            },
            value_teacher: {
                validators: {
                    notEmpty: {
                        message: 'تعمير خانة منصة التعليم إجباري<br>'
                    }
                },
                required: true
            },
            value_exam: {
                validators: {
                    notEmpty: {
                        message: 'تعمير خانة الامتحان إجباري<br>'
                    }
                },
                required: true
            },
            value_value: {
                validators: {
                    notEmpty: {
                        message: 'value is required'
                    }
                },
                required: true
            },
            value_seller: {
                validators: {
                    notEmpty: {
                        message: 'seller is required'
                    }
                },
                required: true
            },
            title: {
                validators: {
                    notEmpty: {
                        message: '{{trans("home.this_field_required")}}'
                    }
                },
                required: true
            },
            comment: {
                validators: {
                    notEmpty: {
                        message: '{{trans("home.this_field_required")}}'
                    }
                },
                required: true
            }
        }
    }).on('success.form.bv', function(e) {

    });

    $("#cart-form").bootstrapValidator({
        excluded: [':disabled'],
        fields: {
            quantity: {
                validators: {
                    notEmpty: {
                        message: 'برجاء إختيار الكمية'
                    }
                },
                required: true
            },
            coursetypevariation_id: {
                validators: {
                    notEmpty: {
                        message: 'برجاء إختيار المدرب'
                    }
                },
                required: true
            },

        }
    }).on('success.form.bv', function(e) {

    });

    $(".select_form").change(function(){
        var quantity = $("select[name='quantity']").val();
       var price = $("input[name='coursetypevariation_id']:checked").data("price");
       if(price==undefined)
           price = 0;
       var discount = $("select[name='quantity']").find(':selected').data("discount");
       var vat = '{{App('setting')->vat}}';

       price = quantity*price;
        price = price - discount*price/100;
        vat = parseFloat(vat)*price/100;

        $("#quantity_span").html(quantity);
       $("#ttlprc").html(price+vat+"$");
    });

    $(".startquiz").click(function(){
        if($(this).data("type")=="video"){
            location.href = '{{ url(App("urlLang")."courses/video-exam?course_id=".$course->id) }}'+"&videoexam_id="+$(this).data("id");
        }else{
            if($(this).data("coursetype_id")=="292"){
                location.href = '{{ url(App("urlLang")."courses/quiz-attempt?coursetype_id=54") }}'+"&quiz_id="+$(this).data("id");

            }else
            {
                location.href = '{{ url(App("urlLang")."courses/quiz-attempt?coursetype_id=".$courseType->id) }}'+"&quiz_id="+$(this).data("id");

            }
        }
    });

    $(".country_id").change(country_select);
    function country_select(e){
        var countryId = $(this).val();
        var country = $(this);
        var main_div = $(this).closest(".select_group");

        var govern_div = main_div.find(".governments_div");

        if(countryId!=""){
            govern_div.slideDown();
            $.ajax({
                url: "{{ url('/home/governments') }}",
                data: {countryId: countryId},
                type: "get",
                beforeSend: function(){
                    country.closest(".controls").append("<img src='{{asset('assets/admin/img/input-spinner.gif')}}' width='20' />");
                },
                success: function(result){

                    govern_div.find("select.form-control").html(result["governments"]);
//                    if(result["nonzip"]){
//                        $("input[name='post_code']").parent().addClass("display-none");
//                    }else{
//                        $("input[name='post_code']").parent().removeClass("display-none");
//                    }
                },
                complete: function(){
                    country.closest(".controls").children('img').remove();
                }
            });
        }else{
            govern_div.slideUp();
        }
    }
</script>