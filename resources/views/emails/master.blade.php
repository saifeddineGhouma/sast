<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield("title")</title>
    <style>
        body {
            padding: 0;
            margin: 0;
        }

        .email_navbar {
            padding: 10px 20px;
            background-color: #fff;
            max-width: 600px;
            margin: 0 auto;
            box-sizing: border-box;
        }

        .email_navbar .navbar_logo {
            display: inline-block!important;
            width: 27%;
            text-align: right;
            margin: 1% 0!important;
            vertical-align: middle;
        }

        .email_navbar .navbar_social {
            padding: 0;
            margin: 1% 0 1% 1%!important;
            list-style: none;
            display: inline-block!important;
            width: 70%;
            vertical-align: middle;
        }

        .email_navbar .navbar_social li {
            display: inline-block;
            transition: all ease-out 0.3s;
            border-bottom: 1px solid transparent;
        }
        .email_navbar .navbar_social li a {
            display: inline-block;
            
            
        }

        .email_navbar .navbar_social li:hover {
            opacity: 0.9;
            border-bottom: 1px solid #ffcb05;
        }

        .email_header {
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            box-sizing: border-box;
            background: linear-gradient(to right, #ffcb05 0%, #0071ae 100%);
            padding: 3% 1%;
            position: relative;
        }

        .email_header:after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            left: 0;
            top: 0;
            background-image: url('{{asset('assets/front/img/email/email_header.jpg')}}');
            opacity: 0.44;
        }

        .email_header h2 {
            font-family: 'Tahoma';
            color: #fff;
            margin: 0;
            position: relative;
            z-index: 55;
            font-size:18px;
        }

        .email_welcome {
            background-color: #fff;
            max-width: 600px;
            margin: 0 auto;
            text-align: center;
            padding: 2%;
            box-sizing: border-box;
        }

        .email_welcome h2 {
            font-family: 'Tahoma';
            color: #00213e;
            font-size: 16pt;
            margin: 0;
        }

        .email_welcome .lock {
            margin: 5% 0;
        }

        .email_welcome .reset_pass {
            display: inline-block;
            text-decoration: none;
            font-family: 'Tahoma';
            font-weight: bold;
            color: #000;
            background: #ffcb05;
            padding: 3% 9%;
            border-radius: 100px;
            margin: 5% 0 2% 0;
            transition: all ease-out 0.3s;
        }

        .email_welcome .reset_pass:hover {
            color: #fff;
            background: #0071ae;
        }

        .email_welcome .message_error {
            font-family: 'Tahoma';
            color: #00213e;
            font-size: 8pt;
            margin: 0;
        }

        .email_footer {
            max-width: 600px;
            margin: 0 auto;
            box-sizing: border-box;
            background: #222534;
            padding: 1% 2% 0.5% 2%;
            text-align: center;
        }

        .email_footer .footer_about {
            padding: 0;
            margin: 1% 0;
            display: inline-block;
            width: 49%;
            text-align: left;
            vertical-align: middle;
        }

        .email_footer .footer_about li {
            list-style: square;
            display: inline-block;
            font-family: 'Source Sans Pro';
            margin: 0 3%;
            position: relative;
        }

        .email_footer .footer_about li::before {
            content: '';
            position: absolute;
            left: -11px;
            width: 5px;
            background-image: url('{{asset('assets/front/img/email/list_sq.png')}}');
            height: 5px;
            top: 50%;
        }

        .email_footer .footer_about li:first-child::before {
            display: none;
        }

        .email_footer .footer_about li a {
            display: inline-block;
            color: #fff;
        }
        .notestxt {padding-top:30px; text-align:center; font-size:18px; width:100%; font-weight:700;}

        .email_footer .footer_social {
            padding: 0;
            margin: 1% 0;
            list-style: none;
            text-align: right;
            display: inline-block;
            width: 49%;
            vertical-align: middle;
        }

        .email_footer .footer_social li {
            display: inline-block;
        }

        .email_footer .email_copy p {
            font-family: 'Tahoma';
            color: #fff;
            font-size: 9pt;
            margin: 1% 0;
        }

        @media (max-width: 500px) {
            .email_navbar .navbar_logo {
                width: 40%;
            }
            .email_navbar .navbar_social {
                width: 57%;
            }
        }
    </style>
</head>

<body>
<div class="email_navbar">
    {{-- <ul class="navbar_social">
        @foreach(App('setting')->socials as $social)
            <li><a href="{{$social->link}}"><img width="20px" height="20px" src="{{asset('assets/front/img/email/'.$social->name.'.png')}}" alt="{{$social->name}}"></a></li>
        @endforeach
    </ul> --}}
    <a href="{{url(App('urlLang'))}}" class="navbar_logo">
        <img src="{{asset('assets/front/img/email/navbar_logo.jpg')}}" alt="Logo">
    </a>
</div>
<header class="email_header">
    <h2>الاكاديمية السويدية للتدريب الرياضي SAST</h2>
</header>
<section class="email_welcome">
    @yield("content")
</section>
<footer class="email_footer">
    <ul class="footer_about">
        <?php
        $menuPos = App\MenuPos::find(2);
        $menu = $menuPos->menus()->first();
        ?>
        @if(!empty($menu))
            {!! $menu->links("header") !!}
        @endif
    </ul>
    {{-- <ul class="footer_social">
        @foreach(App('setting')->socials as $social)
            <li><a href="{{$social->link}}"><img width="20px" height="20px" src="{{asset('assets/front/img/email/'.$social->name.'.png')}}" alt="{{$social->name}}"></a></li>
        @endforeach
    </ul> --}}
    <div class="email_copy">
        <p>
            جميع الحقوق محفوظة © 2020 الأكاديمية السويدية للتدريب الرياضي - السويد
        </p>
    </div>
</footer>
</body>

</html>
