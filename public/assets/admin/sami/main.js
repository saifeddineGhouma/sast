$(document).ready(function(){

    // les variables d'initialisation
    let token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    let userInfos = {};
    let courseInfos = {};


    // la fonction du test
    $( document ).on('click', '.test', function(){
    });

    // la fonction du recherche d'un user par email
    $( document ).on('keyup', '#emailSearch', function(){
        $('.course-choice').fadeOut();
        $('.search-results').fadeIn();
        $('.user-registration').fadeOut();
        if($('#emailSearch').val().length > 4){
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': token
                },
                type:'POST',
                url:'search-user',
                data:{
                    'char': $('#emailSearch').val(),
                    'action': 1
                },
                success:function (response) {
                    $('.list-group').html(response);
                },
                beforeSend: function(){
                    $('.list-group').html('Chargement....');
                },
                complete: function(){
                }
            });
        }
    });

    // la fonction du click sur l'email recherché
    $( document ).on('click', '.email-click', function(){
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            type:'POST',
            url:'search-user',
            data:{
                'user_id': $(this).attr('data-user-id'),
                'action': 2
            },
            success:function (response) {
                userInfos = response.user;

                if(response.user.address &&
                    response.user.mobile &&
                    response.user.gender &&
                    response.user.nationality &&
                    response.user.address &&
                    response.user.date_of_birth){
                    $('.course-choice').fadeIn();
                    $('html, body').animate({
                        scrollTop: $(".course-choice").offset().top
                    }, 1000);
                }else {
                    $('#btn-registration').removeClass('register').addClass('edit-user').html('Edit user information\'s');
                    $('.step').html('Step 1 : verify the user information\'s');
                    $('.user-registration').slideDown('fast');
                    $('html, body').animate({
                        scrollTop: $(".user-registration").offset().top
                    }, 1000);

                    $('#username').val(response.user.username);
                    $('#email').val(response.user.email).attr('disabled', true);
                    if(response.user.address)
                        $('#address').val(response.user.address);
                    if(response.user.mobile)
                        $('#mobile').val(response.user.mobile);
                    if(response.user.gender)
                        $('#gender').val(response.user.gender);
                    if(response.user.nationality)
                        $('#nationality').val(response.user.nationality);
                    if(response.user.date_of_birth) {
                        $('#year').val(response.user.date_of_birth.substring(0, 4));
                        $('#month').val(response.user.date_of_birth.substring(5, 7));
                        $('#day').val(response.user.date_of_birth.substring(8, 10));
                    }
                }
            },
            beforeSend: function(){
            },
            complete: function(){
            }
        });
        $('.search-results').fadeOut();
        $('#emailSearch').val('');
        return false;
    });

    // la fonction des radios box
    $( document ).on('click', '.radio-inline', function(){
        initialiseEverything();
        if($(this).attr('id') === "choice2"){
            $('.step').html('Step 1 : we should subscribe the user in the system : ');
            $('#btn-registration').removeClass('edit-user').addClass('register').html('Validate');
            $('.user-registration').slideDown('fast');

            $('html, body').animate({
                scrollTop: $(".user-registration").offset().top
            }, 1000);
        }else{
            $('.user-registration').hide('fast');
        }

        if($(this).attr('id') === "choice1"){
            $('.search-user').slideDown('fast');
        }else{
            $('.search-user').hide('fast');
        }
    });

    // la fonction du registration de l'utilisateur
    $( document ).on('click', '.register', function() {
        userRequest(null, 'create', $('#username').val(), $('#email').val(), $('#mobile').val(), $('#gender').val(), $('#nationality').val(), $('#address').val(), $('#year').val(), $('#month').val(), $('#day').val());
    });

    // la fonction du modification des données du user
    $( document ).on('click', '.edit-user', function() {
        userRequest(userInfos.id ,'edit', $('#username').val(), $('#email').val(), $('#mobile').val(), $('#gender').val(), $('#nationality').val(), $('#address').val(), $('#year').val(), $('#month').val(), $('#day').val());
    });

    // la fonction du choix du course
    $( document ).on('change', '#course', function(){

        courseInfos.course_id = $('#course option:selected').attr('data-courseId');
        courseInfos.course_type_id = $('#course option:selected').attr('data-courseTypeId');
        courseInfos.course_type_variation_id = $('#course option:selected').attr('data-courseTypeVariationId');
        courseInfos.course_price = $('#course option:selected').attr('data-courcePrice');
        courseInfos.totalTVA = $('#course option:selected').attr('data-totalTVA');
        courseInfos.total_with_tva = $('#course option:selected').attr('data-total');
        courseInfos.name = $('#course option:selected').attr('data-courseArabicName');


        $('.td-course-name').html($('#course option:selected').attr('data-courseArabicName'));
        $('.td-course-price').html($('#course option:selected').attr('data-totalWithTVA') + ' DT');
        $('.src-course-img').attr('src', $('#course option:selected').attr('data-courseImage'));

        $('.course-details').fadeIn();

        $('html, body').animate({
            scrollTop: $(".course-details").offset().top
        }, 1000);


        $('.td-user-username').html(userInfos.username);
        $('.td-user-address').html(userInfos.address);
        $('.td-user-mobile').html(userInfos.mobile);


        console.log(courseInfos);
    });

    // la fonction du validation de l'ordre
    $( document ).on('click', '.valid-order', function () {
        swal({
            title: "Are you sure to make this order ?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
            .then((Confirm) => {
                if (Confirm) {
                    $('.overlay').fadeIn();
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': token
                        },
                        type:'POST',
                        url:'create-order',
                        data:{
                            'courseInfos': courseInfos,
                            'userInfos': userInfos,
                        },
                        success:function (response) {
                            if(response.error){
                                swal("", response.msg, "error");
                            }else {
                                swal("", "The order was successfully created", "success");
                                $('.print-username').val(userInfos.username);
                                $('.print-birthDate').val(userInfos.date_of_birth + ' In ' + userInfos.nationality);
                                $('.print-gender').val(userInfos.gender);
                                $('.print-address').val(userInfos.address);
                                $('.print-phone').val(userInfos.mobile);
                                $('.print-email').val(userInfos.email);
                                $('.print-courseName').val(courseInfos.name);
                                $('#DivIdToPrint').fadeIn();
                                $('#btn-print').attr('disabled', false);
                            }


                            userInfos = {};
                            courseInfos = {};
                            $('.course-choice').fadeOut();
                            $('.course-details').fadeOut();
                            $('.search-user').fadeOut();
                            $('.overlay').fadeOut();
                        },
                        beforeSend: function(){
                        },
                        complete: function(){
                        }
                    });
                }
            });
    });



    // la fonction du requete user selon (edit ou create)
    function userRequest(userId = null, requestType ,username, email, mobile, gender, nationality, address, year, month, day) {
        $('.overlay').fadeIn();
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': token
            },
            type:'POST',
            url: requestType,
            data:{
                'user_id' : userId,
                'username' : username,
                'email' : email,
                'mobile' : mobile,
                'gender' : gender,
                'nationality' : nationality,
                'address' : address,
                'date_of_birth' : fullBirthdayDate(year, month, day)
            },
            success:function (response) {
                if(response.errors){
                    if(response.errors.username) $('.for-username').fadeIn().html(response.errors.username[0]);
                    else $('.for-username').fadeOut();
                    if(response.errors.email) $('.for-email').fadeIn().html(response.errors.email[0]);
                    else $('.for-email').fadeOut();
                    if(response.errors.mobile) $('.for-mobile').fadeIn().html(response.errors.mobile[0]);
                    else $('.for-mobile').fadeOut();
                    if(response.errors.gender) $('.for-gender').fadeIn().html(response.errors.gender[0]);
                    else $('.for-gender').fadeOut();
                    if(response.errors.nationality) $('.for-nationality').fadeIn().html(response.errors.nationality[0]);
                    else $('.for-nationality').fadeOut();
                    if(response.errors.address) $('.for-address').fadeIn().html(response.errors.address[0]);
                    else $('.for-address').fadeOut();
                    if(response.errors.date_of_birth) $('.for-date_of_birth').fadeIn().html(response.errors.date_of_birth[0]);
                    else $('.for-date_of_birth').fadeOut();
                }else {
                    $('.alert-danger').fadeOut();
                    $('.user-registration').fadeOut();
                    $('.course-choice').fadeIn();
                    $('html, body').animate({
                        scrollTop: $(".course-choice").offset().top
                    }, 1000);
                    $('.form-control').val('');
                    $('#address').val('Tunisia');
                    userInfos = response.user;
                }
                $('.overlay').fadeOut();
            },
            beforeSend: function(){
            },
            complete: function(){
            }
        });
    }

    // la fonction qui retourne full birthday a partir du year/month/day
    function fullBirthdayDate(year, month, day) {
        if (year.length && month.length && day.length)
            return year + '-' + month + '-' + day;
        else return '';
    }

    // la fonction qui initialise les input et les content
    function initialiseEverything() {
        userInfos = {};
        courseInfos = {};
        $('.form-control').val('');
        $('.alert-danger').fadeOut();
        $('#email').attr('disabled', false);
        $('#nationality').val('Tunisia');

        $('.search-user').hide();
        $('.course-choice').hide();
        $('.course-details').hide();
        $('#DivIdToPrint').hide();
        $('#btn-print').attr('disabled', true);
    }

});