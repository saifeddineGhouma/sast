$(document).ready(function() {

       /*
        $(window).on("resize", function() {
                var win = $(this); //this = window
                if (win.width() >= 641) {

                        // Courses Section

                        var js_1 = "<div class=\"col-lg-3 col-md-4 col-margin replacejs_one\"> <div class=\"card course_animation card_style_one\"> <img class=\"card-img-top\" src=\"img/course_1.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">208$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i><i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"> <img src=\"img/course_profile_1.jpg\" style=\"top: -5%;left: -50%;\" /> </div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div>";
                        var js_2 = "<div class=\"col-lg-3 col-md-4 col-margin replacejs_two\"> <div class=\"card course_animation card_style_two\"> <img class=\"card-img-top\" src=\"img/course_2.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">120$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_2.jpg\" style=\"top: -2px; left: -137px;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div>";
                        var js_3 = "<div class=\"col-lg-3 col-md-4 col-margin replacejs_three\"> <div class=\"card course_animation card_style_three\"> <img class=\"card-img-top\" src=\"img/course_2.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">190$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_3.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div>";
                        var js_4 = "<div class=\"col-lg-3 col-md-4 col-margin replacejs_four\"> <div class=\"card course_animation card_style_four\"> <img class=\"card-img-top\" src=\"img/course_3.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">119$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_2.jpg\" style=\"top: -2px; left: -137px;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div>";
                        var js_5 = "<div class=\"col-lg-3 col-md-4 col-margin replacejs_five\"> <div class=\"card course_animation card_style_three\"> <img class=\"card-img-top\" src=\"img/course_1.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">208$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_3.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div>";
                        var js_6 = "<div class=\"col-lg-3 col-md-4 col-margin replacejs_six\"> <div class=\"card course_animation card_style_four\"> <img class=\"card-img-top\" src=\"img/course_4.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">190$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_1.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div>";
                        var js_7 = "<div class=\"col-lg-3 col-md-4 col-margin replacejs_seven more_courses\"> <div class=\"card course_animation card_style_five\"> <img class=\"card-img-top\" src=\"img/course_2.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">190$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i><i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_3.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div>";
                        var js_8 = "<div class=\"col-lg-3 col-md-4 col-margin replacejs_eight more_courses\"> <div class=\"card course_animation card_style_six\"> <img class=\"card-img-top\" src=\"img/course_3.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">119$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_2.jpg\" style=\"top: -2px; left: -137px;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div>";

                        $(".js_slider_one").replaceWith(js_1);
                        $(".js_slider_two").replaceWith(js_2);
                        $(".js_slider_three").replaceWith(js_3);
                        $(".js_slider_four").replaceWith(js_4);
                        $(".js_slider_five").replaceWith(js_5);
                        $(".js_slider_six").replaceWith(js_6);
                        $(".js_slider_seven").replaceWith(js_7);
                        $(".js_slider_eight").replaceWith(js_8);
                        $('.courses').find('.company_courses').removeClass('swiper-container swiper_course');
                        $('.courses').find('.swiper-wrapper').addClass('row justify-content-around').removeClass('swiper-wrapper')
                        $(".course_animation").mouseenter(function() {$(this).addClass("card_hover");$(this).find(".card-body").addClass("card_body_hover");});
                        $(".course_animation").mouseleave(function() {$(this).removeClass("card_hover");$(this).find(".card-body").removeClass("card_body_hover");});

                        // Certificate Section

                        var certificate_one = "<div class=\"col-lg-3 col-sm-6 mr-auto certificate_content certificate_js_one\"> <img src=\"img/certificate_1.jpg\" /> <p> الاعتماد الدولي للعلوم الرياضية في واشنطن (International Accreditation of Sport Education (IASE </p> </div>";
                        var certificate_two = "<div class=\"col-lg-3 col-sm-6 ml-0 certificate_content certificate_js_two\"> <img src=\"img/certificate_1.jpg\" /> <p> الاعتماد الدولي للعلوم الرياضية في واشنطن (International Accreditation of Sport Education (IASE </p> </div>";
                        var certificate_three = "<div class=\"col-lg-3 col-sm-6 more_certificate ml-auto certificate_content certificate_js_three\"> <img src=\"img/certificate_2.jpg\" /> <p> الاعتماد الدولي للعلوم الرياضية في واشنطن (International Accreditation of Sport Education (IASE </p> </div>";
                        $(".certificate_slide_js_one").replaceWith(certificate_one);
                        $(".certificate_slide_js_two").replaceWith(certificate_two);
                        $(".certificate_slide_js_three").replaceWith(certificate_three);
                        $('.certificate').find('.swiper-container').addClass('swiper-contain').removeClass('swiper-container');
                        $('.certificate').find('.swiper-wrapper').addClass('row').removeClass('swiper-wrapper');
                        $(".certificate_content").mouseenter(function() {$(this).find("img").css("top", "0");});
                        $(".certificate_content").mouseleave(function() {$(this).find("img").css("top", "90px");});

                        // Certificate Section

                        var book_one = "<div class=\"col-lg-3 col-md-4 col-sm-4 book_js_one\"> <div class=\"card books_item  deactive \"> <div class=\"books_card_header books_style_one\"> <img class=\"card-img-top\" src=\"img/book_1.jpg\" alt=\"Card image cap\"> </div> <div class=\"row\"> <div class=\"col\"> <div class=\"card-body books_body\"> <p class=\"card-text\">كتاب الاكاديمية السويدية “ الاصابات الرياضية المستوي الاول”</p> </div> </div> </div> <a href=\"#\" class=\"badge badge-primary pdf_sallary\"> <i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> 44$ </a> <a href=\"#\" class=\"badge badge-warning book_sallary\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> 44$ </a> </div> </div>";
                        var book_two = "<div class=\"col-lg-3 col-md-4 col-sm-4 book_js_two\"> <div class=\"card books_item  deactive\"> <div class=\"books_card_header books_style_two\"> <img class=\"card-img-top\" src=\"img/book_2.jpg\" alt=\"Card image cap\"> </div> <div class=\"row\"> <div class=\"col\"> <div class=\"card-body books_body\"> <p class=\"card-text\">كتاب الاكاديمية السويدية “ الاصابات الرياضية المستوي الاول”</p> </div> </div> </div> <a href=\"#\" class=\"badge badge-primary pdf_sallary\"> <i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> 44$ </a> <a href=\"#\" class=\"badge badge-warning book_sallary\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> 44$ </a> </div> </div>";
                        var book_three = "<div class=\"col-lg-3 col-md-4 col-sm-4 book_js_three\"> <div class=\"card books_item  deactive\"> <div class=\"books_card_header books_style_one\"> <img class=\"card-img-top\" src=\"img/book_1.jpg\" alt=\"Card image cap\"> </div> <div class=\"row\"> <div class=\"col\"> <div class=\"card-body books_body\"> <p class=\"card-text\">كتاب الاكاديمية السويدية “ الاصابات الرياضية المستوي الاول”</p> </div> </div> </div> <a href=\"#\" class=\"badge badge-primary pdf_sallary\"> <i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> 44$ </a> <a href=\"#\" class=\"badge badge-warning book_sallary\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> 44$ </a> </div> </div>";
                        var book_four= "<div class=\"col-lg-3 col-md-4 more_books book_js_four\"> <div class=\"card books_item  deactive\"> <div class=\"books_card_header books_style_one\"> <img class=\"card-img-top\" src=\"img/book_1.jpg\" alt=\"Card image cap\"> </div> <div class=\"row\"> <div class=\"col\"> <div class=\"card-body books_body\"> <p class=\"card-text\">كتاب الاكاديمية السويدية “ الاصابات الرياضية المستوي الاول”</p> </div> </div> </div> <a href=\"#\" class=\"badge badge-primary pdf_sallary\"> <i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> 44$ </a> <a href=\"#\" class=\"badge badge-warning book_sallary\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> 44$ </a> </div> </div>";

                        $(".book_slider_one").replaceWith(book_one);
                        $(".book_slider_two").replaceWith(book_two);
                        $(".book_slider_three").replaceWith(book_three);
                        $(".book_slider_four").replaceWith(book_four);
                        $('.book').find('.swiper-container').addClass('container').removeClass('swiper-container swiper_course');
                        $('.book').find('.swiper-wrapper').addClass('books_category row').removeClass('swiper-wrapper');
                        $(".book .col-lg-3").mouseenter(function() {$(this).find(".deactive").removeClass("deactive");$(this).find(".books_body").css("border-top", "5px solid #ffcb05");});
                        $(".book .col-lg-3").mouseleave(function() {$(this).find(".books_item").addClass("deactive");$(this).find(".books_body").css("border-top", "5px solid #0071ae");});

                        // Coaches Section
                        var coaches_one = "<div class=\"col-3 coaches_info coashes_js_one\"> <div class=\"coach_header\"> <img src=\"img/coach_1.jpg\"> </div> <div class=\"coach_more_info\"> <div class=\"info_content\"> <a href=\"#\"> <i class=\"fa fa-plus\" aria-hidden=\"true\"></i> <p> مشاهدة المزيد </p> </a> </div> </div> <p class=\"coach_name\"> +23 مدرب اخر </p> </div>";
                        var coaches_two = "<div class=\"col-3 coaches_info coashes_js_two\"> <div class=\"coach_header\"> <img class=\"header_2\" src=\"img/coach_2.jpg\" style=\"transform: scale(0.6);position:relative;top:-75px;left:-100%;\"> </div> <div class=\"coach_more_info coach_social\"> <div class=\"info_content\"> <a href=\"#\"><i class=\"fa fa-facebook\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-twitter\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-google-plus\" aria-hidden=\"true\"></i></a> </div> </div> <p class=\"coach_name\"> رانيا ابراهيم </p> <p class=\"coach_country\"> لبنان </p> </div>";
                        var coaches_three = "<div class=\"col-3 coaches_info coashes_js_three\"> <div class=\"coach_header\"> <img class=\"header_3\" src=\"img/coach_3.jpg\" style=\"transform: scale(0.6);position:relative;top:-80px;left:-100%;\"> </div> <div class=\"coach_more_info coach_social\"> <div class=\"info_content\"> <a href=\"#\"><i class=\"fa fa-facebook\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-twitter\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-google-plus\" aria-hidden=\"true\"></i></a> </div> </div> <p class=\"coach_name\"> عبدالعزيز مسعود </p> <p class=\"coach_country\"> السعودية </p> </div>";
                        var coaches_four = "<div class=\"col-3 coaches_info coashes_js_four\"> <div class=\"coach_header\"> <img class=\"header_4\" src=\"img/coach_4.jpg\" style=\"transform: scale(0.8);position:relative;top:-75px;left:-20%;\"> </div> <div class=\"coach_more_info coach_social\"> <div class=\"info_content\"> <a href=\"#\"><i class=\"fa fa-facebook\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-twitter\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-google-plus\" aria-hidden=\"true\"></i></a> </div> </div> <p class=\"coach_name\"> احمد عبدالحميد </p> <p class=\"coach_country\"> مصر </p> </div>";
                        $(".coaches_slider_one").replaceWith(coaches_one);
                        $(".coaches_slider_two").replaceWith(coaches_two);
                        $(".coaches_slider_three").replaceWith(coaches_three);
                        $(".coaches_slider_four").replaceWith(coaches_four);
                        $('.coaches').find('.swiper-container').addClass('container_swip ').removeClass('swiper_coaches  swiper-container');
                        $('.coaches').find('.swiper-wrapper').addClass('justify-content-around row').removeClass('swiper-wrapper');
                        $(".coach_more_info").mouseenter(function() {$(this).css("opacity", "1");$(this).siblings(".coach_name").css("color", "#ffcb05");});
                        $(".coach_more_info").mouseleave(function() {$(this).css("opacity", "0");$(this).siblings(".coach_name").css("color", "#fff");});
                        var footer_downup_one = "<div class=\"col-lg-4 col-md-4 col-sm-6 width_640 feedback_footer \"> <input class=\"form-control feedback_send\" type=\"text\" placeholder=\"ادخل بريدك الاكتروني للاشتراك\"> <button class=\"subscribe\">اشتراك</button> <div class=\"mail\"> <i class=\"fa fa-envelope\" aria-hidden=\"true\"></i> <span>info@swedish-academy.se</span> </div> <div class=\"phone\"> <i class=\"fa fa-phone\" aria-hidden=\"true\"></i> <span>0046767045506</span> </div> </div>";
                        var footer_downup_two = "<div class=\"col-lg-4 col-md-4 short_info col-sm-6 width_640 logo_footer\"> <img src=\"img/web_logo_2.png\"> <p>الاكاديمية السويدية للتدريب الرياضي SAST هي احدى المؤسسات التعليمية الرياضية التابعة الى المجلس العالمي للعلوم الرياضية في السويد GCSS</p> </div>";

                        $(".footer_logo").replaceWith(footer_downup_one);
                        $(".footer_feadback").replaceWith(footer_downup_two);
                }
                if (win.width() < 640) {

                        // Courses Section
                       // var slider_1 = "<div class=\"swiper-slide js_slider_one\"> <div class=\" col-margin\"> <div class=\"card course_animation card_style_one\"> <img class=\"card-img-top\" src=\"img/course_1.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">208$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_1.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div> </div>";
                       // var slider_2 = "<div class=\"swiper-slide js_slider_two\"> <div class=\"col-margin\"> <div class=\"card course_animation card_style_two\"> <img class=\"card-img-top\" src=\"img/course_2.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">120$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_2.jpg\" style=\"top: -2px; left: -137px;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div> </div>";
                     //   var slider_3 = "<div class=\"swiper-slide js_slider_three\"> <div class=\"col-margin\"> <div class=\"card course_animation card_style_three\"> <img class=\"card-img-top\" src=\"img/course_2.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">190$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_3.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div> </div>";
                       // var slider_4 = "<div class=\"swiper-slide js_slider_four\"> <div class=\"col-margin\"> <div class=\"card course_animation card_style_four\"> <img class=\"card-img-top\" src=\"img/course_3.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">119$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_2.jpg\" style=\"top: -2px; left: -137px;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div> </div>";
                       // var slider_5 = "<div class=\"swiper-slide js_slider_five\"> <div class=\"col-margin\"> <div class=\"card course_animation card_style_three\"> <img class=\"card-img-top\" src=\"img/course_1.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">208$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_3.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div> </div>";
                       // var slider_6 = "<div class=\"swiper-slide js_slider_six\"> <div class=\"col-margin\"> <div class=\"card course_animation card_style_four\"> <img class=\"card-img-top\" src=\"img/course_4.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">190$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_1.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div> </div>";
                       // var slider_7 = "<div class=\"swiper-slide js_slider_seven\"> <div class=\"col-margin\"> <div class=\"card course_animation card_style_five\"> <img class=\"card-img-top\" src=\"img/course_2.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">190$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_3.jpg\" style=\"top: -5%;left: -50%;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div> </div>";
                       // var slider_8 = "<div class=\"swiper-slide js_slider_eight\"> <div class=\"col-margin\"> <div class=\"card course_animation card_style_six\"> <img class=\"card-img-top\" src=\"img/course_3.jpg\" alt=\"Card image cap\"> <span class=\"badge badge-pill badge-warning\">119$</span> <div class=\"card-body \"> <p class=\"comments\"> 65 تعليق </p> <section class=\"rate\"> <i class=\"fa fa-star checked\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> <i class=\"fa fa-star\" aria-hidden=\"true\"></i> </section> <div class=\"circle_profile\"><img src=\"img/course_profile_2.jpg\" style=\"top: -2px; left: -137px;\" /></div> <h5 class=\"card-title\">الاستاذ / راشد عبدالعزيز</h5> <p class=\"card-text\">دورة المدرب الشخصي المستوي الرابع المقدمة من الاكاديمية</p> <div class=\"more_info\"> <div class=\"row\"> <div class=\"col\"> <i class=\"fa fa-calendar\" aria-hidden=\"true\"></i> <p>18 يناير</p> <p>23 يناير</p> </div> <div class=\"col\"> <i class=\"fa fa-map-marker\" aria-hidden=\"true\"></i> <p>السعودية</p> <p>الكويت</p> </div> </div> <div class=\"row\"> <div class=\"col train_prograrm\"> <img src=\"img/verified_list.svg\" /> <a href=\"#\"> البرنامج التدريبي </a> <i class=\"fa fa-caret-down\" aria-hidden=\"true\"></i> </div> </div> </div> </div> </div> </div> </div>";
                     //   $(".replacejs_one").replaceWith(slider_1);
                     //   $(".replacejs_two").replaceWith(slider_2);
                     //   $(".replacejs_three").replaceWith(slider_3);
                     //   $(".replacejs_four").replaceWith(slider_4);
                     //   $(".replacejs_five").replaceWith(slider_5);
                     //   $(".replacejs_six").replaceWith(slider_6);
                     //   $(".replacejs_seven").replaceWith(slider_7);
                     //   $(".replacejs_eight").replaceWith(slider_8);
                     //   $('.courses').find('.company_courses').addClass('swiper-container swiper_course');
                     //   $('.courses').find('.justify-content-around').addClass('swiper-wrapper').removeClass('row justify-content-around');
                     //   $(".course_animation").mouseenter(function() {$(this).addClass("card_hover");$(this).find(".card-body").addClass("card_body_hover");});
                      //  $(".course_animation").mouseleave(function() {$(this).removeClass("card_hover");$(this).find(".card-body").removeClass("card_body_hover");});

                        // Certificate Section
                        var certificate_one_slider = "<div class=\"swiper-slide certificate_slide_js_one\"> <div class=\"ml-0 certificate_content\"> <img src=\"img/certificate_1.jpg\" /> <p> الاعتماد الدولي للعلوم الرياضية في واشنطن (International Accreditation of Sport Education (IASE </p> </div> </div>";
                        var certificate_two_slider = "<div class=\"swiper-slide certificate_slide_js_two\"> <div class=\"ml-0 certificate_content\"> <img src=\"img/certificate_1.jpg\" /> <p> الاعتماد الدولي للعلوم الرياضية في واشنطن (International Accreditation of Sport Education (IASE </p> </div> </div>";
                        var certificate_three_slider = "<div class=\"swiper-slide certificate_slide_js_three\"> <div class=\" ml-0 certificate_content\"> <img src=\"img/certificate_2.jpg\" /> <p> الاعتماد الدولي للعلوم الرياضية في واشنطن (International Accreditation of Sport Education (IASE </p> </div> </div>";
                        $(".certificate_js_one").replaceWith(certificate_one_slider);
                        $(".certificate_js_two").replaceWith(certificate_two_slider);
                        $(".certificate_js_three").replaceWith(certificate_three_slider);
                        $('.certificate').find('.swiper-contain').addClass('swiper-container').removeClass('swiper-contain');
                        $('.certificate').find('.row').addClass('swiper-wrapper').removeClass('row');
                        $(".certificate_content").mouseenter(function() {$(this).find("img").css("top", "0");});
                        $(".certificate_content").mouseleave(function() {$(this).find("img").css("top", "90px");});

                        // Book Section
                        //var book_one_slider = "<div class=\"swiper-slide book_slider_one\"> <div class=\"book_slider\"> <div class=\"card books_item  deactive \"> <div class=\"books_card_header books_style_one\"> <img class=\"card-img-top\" src=\"img/book_1.jpg\" alt=\"Card image cap\"> </div> <div class=\"row\"> <div class=\"col\"> <div class=\"card-body books_body\"> <p class=\"card-text\">كتاب الاكاديمية السويدية “ الاصابات الرياضية المستوي الاول”</p> </div> </div> </div> <a href=\"#\" class=\"badge badge-primary pdf_sallary\"> <i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> 44$ </a> <a href=\"#\" class=\"badge badge-warning book_sallary\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> 44$ </a> </div> </div> </div>";
                       // var book_two_slider = "<div class=\"swiper-slide book_slider_two\"> <div class=\"book_slider\"> <div class=\"card books_item  deactive\"> <div class=\"books_card_header books_style_two\"> <img class=\"card-img-top\" src=\"img/book_2.jpg\" alt=\"Card image cap\"> </div> <div class=\"row\"> <div class=\"col\"> <div class=\"card-body books_body\"> <p class=\"card-text\">كتاب الاكاديمية السويدية “ الاصابات الرياضية المستوي الاول”</p> </div> </div> </div> <a href=\"#\" class=\"badge badge-primary pdf_sallary\"> <i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> 44$ </a> <a href=\"#\" class=\"badge badge-warning book_sallary\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> 44$ </a> </div> </div> </div>";
                       // var book_three_slider = "<div class=\"swiper-slide book_slider_three\"> <div class=\"book_slider\"> <div class=\"card books_item  deactive\"> <div class=\"books_card_header books_style_one\"> <img class=\"card-img-top\" src=\"img/book_1.jpg\" alt=\"Card image cap\"> </div> <div class=\"row\"> <div class=\"col\"> <div class=\"card-body books_body\"> <p class=\"card-text\">كتاب الاكاديمية السويدية “ الاصابات الرياضية المستوي الاول”</p> </div> </div> </div> <a href=\"#\" class=\"badge badge-primary pdf_sallary\"> <i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> 44$ </a> <a href=\"#\" class=\"badge badge-warning book_sallary\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> 44$ </a> </div> </div> </div>";
                       // var book_four_slider = "<div class=\"swiper-slide book_slider_four\"> <div class=\"book_slider\"> <div class=\"card books_item  deactive\"> <div class=\"books_card_header books_style_one\"> <img class=\"card-img-top\" src=\"img/book_1.jpg\" alt=\"Card image cap\"> </div> <div class=\"row\"> <div class=\"col\"> <div class=\"card-body books_body\"> <p class=\"card-text\">كتاب الاكاديمية السويدية “ الاصابات الرياضية المستوي الاول”</p> </div> </div> </div> <a href=\"#\" class=\"badge badge-primary pdf_sallary\"> <i class=\"fa fa-file-pdf-o\" aria-hidden=\"true\"></i> 44$ </a> <a href=\"#\" class=\"badge badge-warning book_sallary\"> <i class=\"fa fa-book\" aria-hidden=\"true\"></i> 44$ </a> </div> </div> </div>";
                      //  $(".book_js_one").replaceWith(book_one_slider);
                      //  $(".book_js_two").replaceWith(book_two_slider);
                      //  $(".book_js_three").replaceWith(book_three_slider);
                      //  $(".book_js_four").replaceWith(book_four_slider);
                      //  $('.book').find('.container').addClass('swiper-container swiper_course').removeClass('container');
                      //  $('.book').find('.books_category').addClass('swiper-wrapper').removeClass('books_category row');
                      //  $(".book .book_slider").mouseenter(function() {$(this).find(".deactive").removeClass("deactive");$(this).find(".books_body").css("border-top", "5px solid #ffcb05");});
                       // $(".book .book_slider").mouseleave(function() {$(this).find(".books_item").addClass("deactive");$(this).find(".books_body").css("border-top", "5px solid #0071ae");});

                        // Coaches Section
                        var coaches_one_slider = "<div class=\"swiper-slide coaches_slider_one\"> <div class=\"coaches_info\"> <div class=\"coach_header\"> <img src=\"img/coach_1.jpg\"> </div> <div class=\"coach_more_info\"> <div class=\"info_content\"> <a href=\"#\"> <i class=\"fa fa-plus\" aria-hidden=\"true\"></i> <p> مشاهدة المزيد </p> </a> </div> </div> <p class=\"coach_name\"> +23 مدرب اخر </p> </div> </div>";
                        var coaches_two_slider = "<div class=\"swiper-slide coaches_slider_two\"> <div class=\"coaches_info\"> <div class=\"coach_header\"> <img class=\"header_2\" src=\"img/coach_2.jpg\" style=\"transform: scale(0.6);position:relative;top:-75px;left:-100%;\"> </div> <div class=\"coach_more_info coach_social\"> <div class=\"info_content\"> <a href=\"#\"><i class=\"fa fa-facebook\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-twitter\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-google-plus\" aria-hidden=\"true\"></i></a> </div> </div> <p class=\"coach_name\"> رانيا ابراهيم </p> <p class=\"coach_country\"> لبنان </p> </div> </div>";
                        var coaches_three_slider = "<div class=\"swiper-slide coaches_slider_three\"> <div class=\"coaches_info\"> <div class=\"coach_header\"> <img class=\"header_3\" src=\"img/coach_3.jpg\" style=\"transform: scale(0.6);position:relative;top:-80px;left:-100%;\"> </div> <div class=\"coach_more_info coach_social\"> <div class=\"info_content\"> <a href=\"#\"><i class=\"fa fa-facebook\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-twitter\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-google-plus\" aria-hidden=\"true\"></i></a> </div> </div> <p class=\"coach_name\"> عبدالعزيز مسعود </p> <p class=\"coach_country\"> السعودية </p> </div> </div>";
                        var coaches_four_slider = "<div class=\"swiper-slide coaches_slider_four\"> <div class=\"coaches_info\"> <div class=\"coach_header\"> <img class=\"header_4\" src=\"img/coach_4.jpg\" style=\"transform: scale(0.8);position:relative;top:-75px;left:-20%;\"> </div> <div class=\"coach_more_info coach_social\"> <div class=\"info_content\"> <a href=\"#\"><i class=\"fa fa-facebook\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-twitter\" aria-hidden=\"true\"></i></a> <a href=\"#\"><i class=\"fa fa-google-plus\" aria-hidden=\"true\"></i></a> </div> </div> <p class=\"coach_name\"> احمد عبدالحميد </p> <p class=\"coach_country\"> مصر </p> </div> </div> </div>";
                        $(".coashes_js_one").replaceWith(coaches_one_slider);
                        $(".coashes_js_two").replaceWith(coaches_two_slider);
                        $(".coashes_js_three").replaceWith(coaches_three_slider);
                        $(".coashes_js_four").replaceWith(coaches_four_slider);
                        $('.coaches').find('.container_swip').addClass('swiper-container swiper_coaches').removeClass('container_swip');
                        $('.coaches').find('.justify-content-around').addClass('swiper-wrapper').removeClass('justify-content-around row');
                        $(".coach_more_info").mouseenter(function() {$(this).css("opacity", "1");$(this).siblings(".coach_name").css("color", "#ffcb05");});
                        $(".coach_more_info").mouseleave(function() {$(this).css("opacity", "0");$(this).siblings(".coach_name").css("color", "#fff");});
                        var footer_updown_one = "<div class=\"col-lg-4 col-md-4 short_info col-sm-6 width_640 footer_logo\"> <img src=\"img/web_logo_2.png\"> <p>الاكاديمية السويدية للتدريب الرياضي SAST هي احدى المؤسسات التعليمية الرياضية التابعة الى المجلس العالمي للعلوم الرياضية في السويد GCSS</p> </div>";
                        var footer_updown_two = "<div class=\"col-lg-4 col-md-4 col-sm-6 width_640  footer_feadback\"> <input class=\"form-control feedback_send\" type=\"text\" placeholder=\"ادخل بريدك الاكتروني للاشتراك\"> <button class=\"subscribe\">اشتراك</button> <div class=\"mail\"> <i class=\"fa fa-envelope\" aria-hidden=\"true\"></i> <span>info@swedish-academy.se</span> </div> <div class=\"phone\"> <i class=\"fa fa-phone\" aria-hidden=\"true\"></i> <span>0046767045506</span> </div> </div>";
                        $(".feedback_footer").replaceWith(footer_updown_one);
                        $(".logo_footer").replaceWith(footer_updown_two);
                        var swiper = new Swiper(' .certificate .swiper-container');
                        var swiper_four = new Swiper('.swiper_coaches');
                        var swiper_two = new Swiper('.swiper_course', { slidesPerView: 3, spaceBetween: 30, freeMode: true, });
                        var swiper_three = new Swiper('.bloger_swiper', { direction: 'vertical', });
                }
        });
        */
        //  Navbar Animation
        $(window).on("scroll", function() {var scroll = $(window).scrollTop();if (scroll > 100) {$(".navbar").addClass("fixed-top")}var scroll_two = $(window).scrollTop();if (scroll < 100) {$(".navbar").removeClass("fixed-top")}});
        $(window).on("scroll", function() {var scroll = $(window).scrollTop();if (scroll > 50) {$(".width_640_only").addClass("fixed-top")}});
        $(window).on("scroll", function() {var scroll = $(window).scrollTop();if (scroll < 50) {$(".navbar").removeClass("navbar-fixed-top")}});
        $(".navbar-collapse .navbar-nav li").click(function() {$(this).addClass("active");$(this).siblings().removeClass("active");});

        //  Search & Shoping
        $(".navbar .fa-search").click(function() {$('.search_website').css("display","block");$('html').css("overflow","hidden");});
        $(".search_website .btn-light").click(function() {$('.search_website').css("display","none");$('html').css("overflow-y","scroll");});
        $(".search_website .exit").click(function() {$('.search_website').css("display","none");$('html').css("overflow-y","scroll");});
        $(".navbar .fa-shopping-basket").click(function() {$('.shoping_website').css("display","block");$('html').css("overflow","hidden");});
        $(".shoping_website .btn-light").click(function() {$('.shoping_website').css("display","none");$('html').css("overflow-y","scroll");});
        $(".shoping_website .exit").click(function() {$('.shoping_website').css("display","none");$('html').css("overflow-y","scroll");});

        // Navbar Dropdown
        $(".navbar-collapse .navbar-nav .nav-item").click(function() {$(this).toggleClass("dropdown_active");$(this).siblings().removeClass("dropdown_active");$(this).find(".menu_sup").addClass("nav_dropdown");});

        // Courses Animation
        $(".course_animation").mouseenter(function() {$(this).addClass("card_hover");$(this).find(".card-body").addClass("card_body_hover");});
        $(".course_animation").mouseleave(function() {$(this).removeClass("card_hover");$(this).find(".card-body").removeClass("card_body_hover");});

        // Books Animation
        $(".book .col-lg-3").mouseenter(function() {$(this).find(".deactive").removeClass("deactive");$(this).find(".books_body").css("border-top", "5px solid #ffcb05");});
        $(".book .col-lg-3").mouseleave(function() {$(this).find(".books_item").addClass("deactive");$(this).find(".books_body").css("border-top", "5px solid #0071ae");});
        $(".book .book_slider").mouseenter(function() {$(this).find(".deactive").removeClass("deactive");$(this).find(".books_body").css("border-top", "5px solid #ffcb05");});
        $(".book .book_slider").mouseleave(function() {$(this).find(".books_item").addClass("deactive");$(this).find(".books_body").css("border-top", "5px solid #0071ae");});

        // Coaches Animation
        $(".coach_more_info").mouseenter(function() {$(this).css("opacity", "1");$(this).siblings(".coach_name").css("color", "#ffcb05");});
        $(".coach_more_info").mouseleave(function() {$(this).css("opacity", "0");$(this).siblings(".coach_name").css("color", "#fff");});

        // Bloger Animation
        $(".bloger .row").mouseenter(function() {$(this).find(".mt-0").css("color", "#0071ae");});
        $(".bloger .row").mouseleave(function() {$(this).find(".mt-0").css("color", "#000");});
        $(".fa-angle-double-up").click(function(){$('.bloger_swiper .swiper-wrapper').css("margin-top","-=50px");});
        $(".fa-angle-double-down").click(function(){$('.bloger_swiper .swiper-wrapper').css("margin-top","+=50px");});
        var swiper_three = new Swiper('.bloger_swiper', {direction: 'vertical',});

        // Join Us Animation
        $(".join").mouseenter(function() {$(this).find(".academy_student").addClass("active_student");});
        $(".join").mouseleave(function() {$(this).find(".academy_student").removeClass("active_student");});
        $(".join").mouseenter(function() {$(this).find(".academy_trainer").addClass("active_trainer");});
        $(".join").mouseleave(function() {$(this).find(".academy_trainer").removeClass("active_trainer");});

        // Certificate Animation
        $(".certificate_content").mouseenter(function() {$(this).find("img").css("top", "0");});
        $(".certificate_content").mouseleave(function() {$(this).find("img").css("top", "90px");});

        // Courses Page
        $(".curriculum_card .card-header .btn-link").click(function() { $(this).parents(".curriculum_card").toggleClass("curriculum_card_active"); $(this).parents(".curriculum_card").siblings().removeClass("curriculum_card_active"); $(this).parents(".curriculum_card").toggleClass("card_deactive"); $(".more_info_two .courses_ad ").toggleClass("course_ad_active"); });
        $(".discussion_card .card-header .btn-link").click(function() { $(this).parents(".discussion_card").toggleClass("discussion_card_active"); $(this).parents(".discussion_card").siblings().removeClass("discussion_card_active"); $(this).parents(".discussion_card").toggleClass("card_deactive"); $(".more_info_three .courses_ad ").toggleClass("course_ad_active"); });
        $(".curriculum_card .card-body .row").mouseenter(function() { $(this).find(".curriculum_type .fa").css("color", "#0071ae"); $(this).find(".curriculum_title p").css("color", "#0071ae"); $(this).find(".curriculum_watch button").css({ 'color': '#fff' , 'background' :'#0071ae' }); });
        $(".curriculum_card .card-body .row").mouseleave(function() { $(this).find(".curriculum_type .fa").css("color", "#000"); $(this).find(".curriculum_title p").css("color", "#000"); $(this).find(".curriculum_watch button").css({ 'color': '#000' , 'background' :'#ffcb05' }); });
        $(".curriculum_exam_card .card-body .row").mouseenter(function() { $(this).find(".curriculum_exam_title p").css("color", "#0071ae"); $(this).find(".curriculum_exam_question_number p").css("color", "#0071ae"); $(this).find(".curriculum_exam_watch p").css({ 'color': '#0071ae' }); $(this).find(".curriculum_exam_watch button").css({ 'color': '#fff' , 'background' :'#0071ae' }); });
        $(".curriculum_exam_card .card-body .row").mouseleave(function() { $(this).find(".curriculum_exam_title p").css("color", "#000"); $(this).find(".curriculum_exam_question_number p").css("color", "#000"); $(this).find(".curriculum_exam_watch p").css({ 'color': '#03e3ac' }); $(this).find(".curriculum_exam_watch button").css({ 'color': '#fff' , 'background' :'#ce0000' }); });
        $("#information").click(function() { $('.more_info_one').css("display", "flex"); $('more_info_one').siblings().css("display", "none"); });
        $("#curriculum").click(function() { $('.more_info_two').css("display", "flex"); $('.more_info_two').siblings().css("display", "none"); });
        $("#discussion").click(function() { $('.more_info_three').css("display", "flex"); $('.more_info_three').siblings().css("display", "none"); });
        $("#curriculum_exam").click(function() { $('.more_info_four').css("display", "flex"); $('.more_info_four').siblings().css("display", "none"); });
        $("#teacher").click(function() { $('.more_info_five').css("display", "flex"); $('.more_info_five').siblings().css("display", "none"); });

        
        // Range 2
        $(function() { $("#slider-range_two").slider({isRTL: true, range: true, min: 1, max: 5, values: [2, 5], slide: function(event, ui) { $("#amount_three").val(+ui.values[0]); $("#amount_four").val(+ui.values[1]); } }); $("#amount_three").val($("#slider-range_two").slider("values", 0)); $("#amount_four").val($("#slider-range_two").slider("values", 1)); });
        $("#amount_three").change(function() { $("#slider-range_two").slider('values', 0, $(this).val()); });
        $("#amount_four").change(function() { $("#slider-range_two").slider('values', 1, $(this).val()).addClass("fa fa-star"); });


    +function ($) {
        'use strict';

        // MODAL CLASS DEFINITION
        // ======================

        var Modal = function (element, options) {
            this.options             = options
            this.$body               = $(document.body)
            this.$element            = $(element)
            this.$dialog             = this.$element.find('.modal-dialog')
            this.$backdrop           = null
            this.isShown             = null
            this.originalBodyPad     = null
            this.scrollbarWidth      = 0
            this.ignoreBackdropClick = false

            if (this.options.remote) {
                this.$element
                    .find('.modal-content')
                    .load(this.options.remote, $.proxy(function () {
                        this.$element.trigger('loaded.bs.modal')
                    }, this))
            }
        }

        Modal.VERSION  = '3.3.6'

        Modal.TRANSITION_DURATION = 300
        Modal.BACKDROP_TRANSITION_DURATION = 150

        Modal.DEFAULTS = {
            backdrop: true,
            keyboard: true,
            show: true
        }

        Modal.prototype.toggle = function (_relatedTarget) {
            return this.isShown ? this.hide() : this.show(_relatedTarget)
        }

        Modal.prototype.show = function (_relatedTarget) {
            var that = this
            var e    = $.Event('show.bs.modal', { relatedTarget: _relatedTarget })

            this.$element.trigger(e)

            if (this.isShown || e.isDefaultPrevented()) return

            this.isShown = true

            this.checkScrollbar()
            this.setScrollbar()
            this.$body.addClass('modal-open')

            this.escape()
            this.resize()

            this.$element.on('click.dismiss.bs.modal', '[data-dismiss="modal"]', $.proxy(this.hide, this))

            this.$dialog.on('mousedown.dismiss.bs.modal', function () {
                that.$element.one('mouseup.dismiss.bs.modal', function (e) {
                    if ($(e.target).is(that.$element)) that.ignoreBackdropClick = true
                })
            })

            this.backdrop(function () {
                var transition = $.support.transition && that.$element.hasClass('fade')

                if (!that.$element.parent().length) {
                    that.$element.appendTo(that.$body) // don't move modals dom position
                }

                that.$element
                    .show()
                    .scrollTop(0)

                that.adjustDialog()

                if (transition) {
                    that.$element[0].offsetWidth // force reflow
                }

                that.$element.addClass('in')

                that.enforceFocus()

                var e = $.Event('shown.bs.modal', { relatedTarget: _relatedTarget })

                transition ?
                    that.$dialog // wait for modal to slide in
                        .one('bsTransitionEnd', function () {
                            that.$element.trigger('focus').trigger(e)
                        })
                        .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
                    that.$element.trigger('focus').trigger(e)
            })
        }

        Modal.prototype.hide = function (e) {
            if (e) e.preventDefault()

            e = $.Event('hide.bs.modal')

            this.$element.trigger(e)

            if (!this.isShown || e.isDefaultPrevented()) return

            this.isShown = false

            this.escape()
            this.resize()

            $(document).off('focusin.bs.modal')

            this.$element
                .removeClass('in')
                .off('click.dismiss.bs.modal')
                .off('mouseup.dismiss.bs.modal')

            this.$dialog.off('mousedown.dismiss.bs.modal')

            $.support.transition && this.$element.hasClass('fade') ?
                this.$element
                    .one('bsTransitionEnd', $.proxy(this.hideModal, this))
                    .emulateTransitionEnd(Modal.TRANSITION_DURATION) :
                this.hideModal()
        }

        Modal.prototype.enforceFocus = function () {
            $(document)
                .off('focusin.bs.modal') // guard against infinite focus loop
                .on('focusin.bs.modal', $.proxy(function (e) {
                    if (this.$element[0] !== e.target && !this.$element.has(e.target).length) {
                        this.$element.trigger('focus')
                    }
                }, this))
        }

        Modal.prototype.escape = function () {
            if (this.isShown && this.options.keyboard) {
                this.$element.on('keydown.dismiss.bs.modal', $.proxy(function (e) {
                    e.which == 27 && this.hide()
                }, this))
            } else if (!this.isShown) {
                this.$element.off('keydown.dismiss.bs.modal')
            }
        }

        Modal.prototype.resize = function () {
            if (this.isShown) {
                $(window).on('resize.bs.modal', $.proxy(this.handleUpdate, this))
            } else {
                $(window).off('resize.bs.modal')
            }
        }

        Modal.prototype.hideModal = function () {
            var that = this
            this.$element.hide()
            this.backdrop(function () {
                that.$body.removeClass('modal-open')
                that.resetAdjustments()
                that.resetScrollbar()
                that.$element.trigger('hidden.bs.modal')
            })
        }

        Modal.prototype.removeBackdrop = function () {
            this.$backdrop && this.$backdrop.remove()
            this.$backdrop = null
        }

        Modal.prototype.backdrop = function (callback) {
            var that = this
            var animate = this.$element.hasClass('fade') ? 'fade' : ''

            if (this.isShown && this.options.backdrop) {
                var doAnimate = $.support.transition && animate

                this.$backdrop = $(document.createElement('div'))
                    .addClass('modal-backdrop ' + animate)
                    .appendTo(this.$body)

                this.$element.on('click.dismiss.bs.modal', $.proxy(function (e) {
                    if (this.ignoreBackdropClick) {
                        this.ignoreBackdropClick = false
                        return
                    }
                    if (e.target !== e.currentTarget) return
                    this.options.backdrop == 'static'
                        ? this.$element[0].focus()
                        : this.hide()
                }, this))

                if (doAnimate) this.$backdrop[0].offsetWidth // force reflow

                this.$backdrop.addClass('in')

                if (!callback) return

                doAnimate ?
                    this.$backdrop
                        .one('bsTransitionEnd', callback)
                        .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
                    callback()

            } else if (!this.isShown && this.$backdrop) {
                this.$backdrop.removeClass('in')

                var callbackRemove = function () {
                    that.removeBackdrop()
                    callback && callback()
                }
                $.support.transition && this.$element.hasClass('fade') ?
                    this.$backdrop
                        .one('bsTransitionEnd', callbackRemove)
                        .emulateTransitionEnd(Modal.BACKDROP_TRANSITION_DURATION) :
                    callbackRemove()

            } else if (callback) {
                callback()
            }
        }

        // these following methods are used to handle overflowing modals

        Modal.prototype.handleUpdate = function () {
            this.adjustDialog()
        }

        Modal.prototype.adjustDialog = function () {
            var modalIsOverflowing = this.$element[0].scrollHeight > document.documentElement.clientHeight

            this.$element.css({
                paddingLeft:  !this.bodyIsOverflowing && modalIsOverflowing ? this.scrollbarWidth : '',
                paddingRight: this.bodyIsOverflowing && !modalIsOverflowing ? this.scrollbarWidth : ''
            })
        }

        Modal.prototype.resetAdjustments = function () {
            this.$element.css({
                paddingLeft: '',
                paddingRight: ''
            })
        }

        Modal.prototype.checkScrollbar = function () {
            var fullWindowWidth = window.innerWidth
            if (!fullWindowWidth) { // workaround for missing window.innerWidth in IE8
                var documentElementRect = document.documentElement.getBoundingClientRect()
                fullWindowWidth = documentElementRect.right - Math.abs(documentElementRect.left)
            }
            this.bodyIsOverflowing = document.body.clientWidth < fullWindowWidth
            this.scrollbarWidth = this.measureScrollbar()
        }

        Modal.prototype.setScrollbar = function () {
            var bodyPad = parseInt((this.$body.css('padding-right') || 0), 10)
            this.originalBodyPad = document.body.style.paddingRight || ''
            if (this.bodyIsOverflowing) this.$body.css('padding-right', bodyPad + this.scrollbarWidth)
        }

        Modal.prototype.resetScrollbar = function () {
            this.$body.css('padding-right', this.originalBodyPad)
        }

        Modal.prototype.measureScrollbar = function () { // thx walsh
            var scrollDiv = document.createElement('div')
            scrollDiv.className = 'modal-scrollbar-measure'
            this.$body.append(scrollDiv)
            var scrollbarWidth = scrollDiv.offsetWidth - scrollDiv.clientWidth
            this.$body[0].removeChild(scrollDiv)
            return scrollbarWidth
        }


        // MODAL PLUGIN DEFINITION
        // =======================

        function Plugin(option, _relatedTarget) {
            return this.each(function () {
                var $this   = $(this)
                var data    = $this.data('bs.modal')
                var options = $.extend({}, Modal.DEFAULTS, $this.data(), typeof option == 'object' && option)

                if (!data) $this.data('bs.modal', (data = new Modal(this, options)))
                if (typeof option == 'string') data[option](_relatedTarget)
                else if (options.show) data.show(_relatedTarget)
            })
        }

        var old = $.fn.modal

        $.fn.modal             = Plugin
        $.fn.modal.Constructor = Modal


        // MODAL NO CONFLICT
        // =================

        $.fn.modal.noConflict = function () {
            $.fn.modal = old
            return this
        }


        // MODAL DATA-API
        // ==============

        $(document).on('click.bs.modal.data-api', '[data-toggle="modal"]', function (e) {
            var $this   = $(this)
            var href    = $this.attr('href')
            var $target = $($this.attr('data-target') || (href && href.replace(/.*(?=#[^\s]+$)/, ''))) // strip for ie7
            var option  = $target.data('bs.modal') ? 'toggle' : $.extend({ remote: !/#/.test(href) && href }, $target.data(), $this.data())

            if ($this.is('a')) e.preventDefault()

            $target.one('show.bs.modal', function (showEvent) {
                if (showEvent.isDefaultPrevented()) return // only register focus restorer if modal will actually get shown
                $target.one('hidden.bs.modal', function () {
                    $this.is(':visible') && $this.trigger('focus')
                })
            })
            Plugin.call($target, option, this)
        })

    }(jQuery);






























        function playVideo(el) {
            var videoId = el.data('video');
            var video = document.getElementById(videoId);

            if (video.paused) {
                // Play the video
                video.play();
                el.removeClass('paused').addClass('playing');
            }
            else {
                // Pause the video
                video.pause();
                el.removeClass('playing').addClass('paused');
            }
        }

        $(document).on('click', '.js-video-control', function(e) {
          playVideo($(this));
          e.preventDefault();
        });






});


var currentStep = 1;

$(document).ready(function () {

    $('.li-nav').click(function () {

        var $targetStep = $($(this).attr('step'));
        currentStep = parseInt($(this).attr('id').substr(7));

        if (!$(this).hasClass('disabled')) {
            $('.li-nav.active').removeClass('active');
            $(this).addClass('active');
            $('.setup-content').hide();
            $targetStep.show();
        }
    });

    $('#navStep1').click();

});

        

function step1Next() {
    //You can make only one function for next, and inside you can check the current step
    if (true) {//Insert here your validation of the first step
        currentStep += 1;
        $('#navStep' + currentStep).removeClass('disabled');
        $('#navStep' + currentStep).click();
    }
}

function prevStep() {
    //Notice that the btn prev not exist in the first step
    currentStep -= 1;
    $('#navStep' + currentStep).click();
}

function step2Next() {
    if (true) {
        $('#navStep3').removeClass('disabled');
        $('#navStep3').click();
    }
}

function step3Next() {
    if (true) {
        $('#navStep4').removeClass('disabled');
        $('#navStep4').click();
    }
}

    $(".click").click(function () {
          $("ul").toggleClass("open");
        });
