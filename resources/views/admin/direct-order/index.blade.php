<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Direct Order</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="{{asset('assets/admin/sami/MDB-Free_4.8.9/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/sami/MDB-Free_4.8.9/css/mdb.lite.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/sami/MDB-Free_4.8.9/css/addons/datatables.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/admin/sami/style.css')}}" rel="stylesheet" type="text/css" />
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Montserrat|Open+Sans+Condensed:300|Red+Hat+Text|Roboto+Mono&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark indigo">
    <a class="navbar-brand" href="#">Swedish academy</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
        <ul class="navbar-nav mr-auto mt-lg-0">
            <li class="nav-item active">
                <a class="nav-link" href="{{url('/')}}">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{url('/admin')}}">Admin dashboard</a>
            </li>
        </ul>
    </div>

    <button id="btn-print" class="btn btn-success" onClick="window.print();" disabled>Print</button>
</nav>


<div class="container main">
    <div class="">
        <div class="logo text-center">
            <img src="{{asset('assets/admin/img/logo.png')}}" alt="Logo">
        </div>
        <div class="card radios-box-content">
            are you register in the website ? <br>
            <label class="label-radio"><input id="choice1" type="radio" class="radio-inline" name="choice" value="oui"><span class="outside"><span class="inside"></span></span>Yes</label>
            <label class="label-radio"><input id="choice2" type="radio" class="radio-inline" name="choice" value="non"><span class="outside"><span class="inside"></span></span>No</label>
        </div>

        <div class="search-user content-divs">
            <div class="md-form">
                <label class="label label-default orange-text" for="emailSearch">Email search</label>
                <input type="email" id="emailSearch" name="emailSearch" placeholder="search your email" class="form-control input-lg">
                <div class="alert for-emailSearch"></div>
            </div>

            <div class="search-results">
                <ul class="list-group">
                </ul>
            </div>
        </div>

        <div class="user-registration content-divs card">
            <div class="card-body">
                <!--Header-->
                <div class="text-center">
                    <h3 class="blue-text mb-5"><strong class="step"></strong></h3>
                </div>
                <form id="inscription-form">
                    <div class="control-group">
                        <!-- username -->
                        <div class="md-form">
                            <label class="label label-default orange-text" for="username">Username : (اسم المشترك بالكامل) *</label>
                            <input type="text" id="username" name="username" placeholder="Username" class="form-control input-lg">
                            <div class="alert alert-danger for-username"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <!-- E-mail -->
                        <div class="md-form">
                            <label class="label label-default orange-text" for="email">E-mail : (ايميل المشترك) *</label>
                            <input type="email" id="email" name="email" placeholder="User email" class="form-control input-lg">
                            <div class="alert alert-danger for-email"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <!-- mobile -->
                        <div class="md-form">
                            <label class="label label-default orange-text" for="mobile">User mobile : (رقم هاتف المشترك) *</label>
                            <input type="tel" id="mobile" name="mobile" placeholder="User mobile" class="form-control input-lg">
                            <div class="alert alert-danger for-mobile"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <!-- gender -->
                        <div class="md-form">
                            <select id="gender" name="gender" class="form-control input-lg">
                                <option value="">Gender : (الجنس) *</option>
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                            <div class="alert alert-danger for-gender"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <!-- mobile -->
                        <div class="md-form">
                            <label class="label label-default orange-text" for="nationality">Nationality : (الجنسية) *</label>
                            <input type="text" value="Tunisia" id="nationality" name="nationality" placeholder="User nationality" class="form-control input-lg">
                            <div class="alert alert-danger for-nationality"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <!-- mobile -->
                        <div class="md-form">
                            <label class="label label-default orange-text" for="address">Address : (العنوان) *</label>
                            <input type="text" id="address" name="address" placeholder="User address" class="form-control input-lg">
                            <div class="alert alert-danger for-address"></div>
                        </div>
                    </div>
                    <div class="control-group border-blue">
                        <!-- mobile -->
                        <label class="label label-default orange-text" for="date_of_birth">Date of birthday : (تاريخ الميلاد) *</label>
                        <div class="md-form">
                            <div class="row">
                                <div class="col-md-4">
                                    <select id="year" name="year" class="form-control input-lg">
                                        <option value="">Year</option>
                                        @for($i = 1950; $i < 2020; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select id="month" name="month" class="form-control input-lg">
                                        <option value="">Month</option>
                                        @for($i = 1; $i < 10; $i++)
                                            <option value="0{{ $i }}">0{{ $i }}</option>
                                        @endfor
                                        <option value="11">11</option>
                                        <option value="12">12</option>
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <select id="day" name="day" class="form-control input-lg">
                                        <option value="">Day</option>
                                        @for($i = 1; $i < 10; $i++)
                                            <option value="0{{ $i }}">0{{ $i }}</option>
                                        @endfor
                                        @for($i = 11; $i < 32; $i++)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                            <div class="alert alert-danger for-date_of_birth"></div>
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="md-form">
                            <button type="button" id="btn-registration" name="register" class="btn btn-block btn-primary form-control input-lg"></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="course-choice content-divs">
            <label for="course">Select course</label>
            <div class="md-form">
                <select id="course" name="course" class="form-control input-lg">
                    <option value="">Select one....</option>
                    @foreach($courses as $course)
                        <option value=""
                                data-courseId="{{ $course->course_id }}"
                                data-courseTypeId="{{ $course->coursetype_id }}"
                                data-courseTypeVariationId="{{ $course->coursetype_variations_id }}"
                                data-courcePrice="{{ $course->price }}"
                                data-courseArabicName="{{ $course->name }}"
                                data-courseImage="{{ asset('uploads/kcfinder/upload/image/'.$course->image) }}"
                                data-coursePeriod="{{ $course->period }}"
                                data-totalTVA="{{ $tva * $course->price / 100 }}"
                                data-total="{{ ($tva * $course->price / 100) + $course->price }}"
                                data-totalWithTVA="{{ (($tva * $course->price / 100) + $course->price) * 2.86 }}"
                        >{{ $course->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="course-details content-divs table-responsive text-nowrap">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Course name</th>
                    <th>Course price</th>
                    <th>Course image</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="td-course-name"></td>
                    <td class="td-course-price"></td>
                    <td>
                        <img class="src-course-img" src="" width="300px">
                    </td>
                </tr>

                <tr>
                    <th class="text-center" colspan="3">User informations</th>
                </tr>
                <tr>
                    <th>User name</th>
                    <th>User address</th>
                    <th>User mobile</th>
                </tr>
                <tr>
                    <td class="td-user-username"></td>
                    <td class="td-user-address"></td>
                    <td class="td-user-mobile"></td>
                </tr>
                <tr>
                    <td colspan="3">
                        <button class="btn btn-danger btn-block valid-order">Validate</button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <!-- <button class="test">test arrays</button> -->



        <div class="form-print" id="DivIdToPrint">
            <section>
                <div class="container">
                    <div class="row">
                        <div class="col-md-3 gcss-logo">
                            <img src="{{asset('assets/admin/img/logo-gcss.png')}}" alt="Logo">
                        </div>
                        <div class="col-md-9 text-right">
                            <h2>استمارة التسجيل</h2>
                        </div>
                    </div>
                    <hr>
                </div>
            </section>

            <section id="personal-information">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6"><h3>Personal Information</h3></div>
                        <div class="col-md-6 text-right"><h3>البيانات الشجصية</h3></div>
                    </div>
                </div>
                <div class="container" style="border-radius: 30px; border:solid 2px deepskyblue; padding:50px;">
                    <div class="row">
                        <div class="col-md-3 pt-2">Name in Arabic</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            الاسم باللغة العربية
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3 pt-2">Name in English</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center print-username" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            الاسم باللغة الانقليزية
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3 pt-2">Place & Date of Birth</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center print-birthDate" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            محل و مكان الولادة
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3 pt-2">Gender</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center print-gender" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            الجنس
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3 pt-2">Current Address</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center print-address" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            عنوان السكن
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3 pt-2">Phone or Cell No</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center print-phone" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            الهاتف او المحمول
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3 pt-2">ُE.mail Address</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center print-email" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            البريد الالكتروني
                        </div>
                    </div>
                </div>
            </section>

            <section id="personal-information" style="margin-top: 50px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6"><h3>Registration Information</h3></div>
                        <div class="col-md-6 text-right"><h3>بيانات التسجيل</h3></div>
                    </div>
                </div>
                <div class="container" style="border-radius: 30px; border:solid 2px deepskyblue; padding:50px;">
                    <div class="row">
                        <div class="col-md-3 pt-2">ِCourse Level</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center print-courseName" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            اسم الدورة
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3 pt-2">Sport Wear Size</div>
                        <div class="col-md-6">
                            <input type="text" class="form-control text-center" style="border-radius: 30px; background-color: #F1F2F6" />
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            حجم الملابس الرياضية
                        </div>
                    </div>
                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3 pt-2">Payment Method</div>
                        <div class="col-md-6 text-center">
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="cash">Cash</label>
                                    <input id="cash" type="checkbox">
                                </div>
                                <div class="col-md-4">
                                    <label for="online">Online</label>
                                    <input id="online" type="checkbox">
                                </div>
                                <div class="col-md-4">
                                    <label for="bankTransfert">Bank Transfer</label>
                                    <input id="bankTransfert" type="checkbox">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 pt-2 text-right">
                            طريقة الدفع
                        </div>
                    </div>
                </div>
            </section>

            <section style="margin-top: 50px; margin-bottom: 50px;">
                <div class="container">
                    <div class="col-4 offset-4 text-center">
                        <label for="sign">التوقيع</label>
                        <input id="sign" type="text" class="form-control input-lg" style="border-radius: 30px; border-color: deepskyblue;">

                        <label for="date">التاريج</label>
                        <input id="date" type="text" class="form-control input-lg" style="border-radius: 30px; border-color: deepskyblue;">
                    </div>
                </div>
            </section>

            <section style="margin-top: 330px; ">
                <div class="container">
                    <hr>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-2 text-right">
                                    <i style="font-size: 40px; color: orange;" class="fa fa-mobile"></i>
                                </div>
                                <div class="col-md-10 text-left" style="font-size: 13px;">
                                    +00216 29 633 663 <br> +0046767045506
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <i style="font-size: 40px; color: orange;" class="fa fa-envelope"></i>
                                </div>
                                <div class="col-md-9 text-left" style="font-size: 13px;">
                                    info@swedish-academy.se
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="row">
                                <div class="col-md-3 text-right">
                                    <i style="font-size: 40px; color: orange;" class="fa fa-map"></i>
                                </div>
                                <div class="col-md-9 text-left" style="font-size: 13px;">
                                    Svärmaregaten 3, 60361 <br> Norrköping, Sweden
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>



    </div>
</div>



<div class="overlay">
    <div class="overlay-loader">
        <div class="sk-circle">
            @for($i=0;$i<12;$i++)
                <div class="sk-circle{{$i+1}} sk-child"></div>
            @endfor
        </div>
    </div>
</div>




<script src="{{asset('assets/admin/js/jquery-1.11.3.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/sami/MDB-Free_4.8.9/js/bootstrap.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/sami/MDB-Free_4.8.9/js/mdb.min.js')}}" type="text/javascript"></script>
<script src="{{asset('assets/admin/sami/MDB-Free_4.8.9/js/addons/datatables.min.js')}}" type="text/javascript"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>



<script src="{{asset('assets/admin/sami/main.js')}}" type="text/javascript"></script>
</body>
</html>