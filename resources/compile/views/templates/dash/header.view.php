<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- FONTS -->
    <link href="/assets/css/materialicons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="https://indestructibletype.com/fonts/Jost.css" type="text/css" charset="utf-8" />

    <!-- STYLES -->
    <link rel="stylesheet" href="/assets/css/app.css">
    @if(( (isset($_COOKIE["darkmode"])) ? $_COOKIE["darkmode"] == "true" : false ))#
    <link id="darkmode" rel="stylesheet" href="/assets/css/darkmode.css">
    @else
    <link id="darkmode" rel="stylesheet" href="/assets/css/empty.css">
    @endif
    <!-- JS -->
    <script src="/assets/js/app.js"></script>

    <title>{{ $title }}</title>
</head>
<body>






<div id="nav" style="display: flex">
    @if(( (isset($usingSidenav)) ? $usingSidenav : true ))#
        <a class="material-icons rippleeffect menubtn">menu</a>
    @endif
    <a id="logo" href="/"><img id="logoimg" height="40px" src="/assets/images/icon.png"/> <p>Lehrga</p></a>
    <div id="navmenu">
    </div>
</div>
<div style='padding-top: 65px'>


<div id="main">
    </head>
    <body>

    <?#
        $url = (isset($_SERVER['REQUEST_URI'])) ? $_SERVER['REQUEST_URI'] : "";
    #?>

    @if(( (isset($usingSidenav)) ? $usingSidenav : true ))#
    <div id="behind_sidenav">
        <div id="mySidenav" class="sidenav">
            @if(( USER !== false ))#
            <a id="sidenav_home" href="/" title="Homepage" class="{{($url=="/") ? "sidenavselected " : ""}}rippleeffect drawerbtn drawerbtn1 sidenava"><i class="small material-icons-outlined sideicon">home</i></a>

            <a id="sidenav_personalinfo" href="/courses" title="Courses" class="{{($url=="/courses") ? "sidenavselected " : ""}}rippleeffect drawerbtn drawerbtn2 sidenava"><i  class="small material-icons-outlined sideicon">school</i></a>
            
            <a id="sidenav_personalinfo" href="/user" title="Students" class="{{($url=="/user") ? "sidenavselected " : ""}}rippleeffect drawerbtn drawerbtn2 sidenava"><i  class="small material-icons-outlined sideicon">group</i></a>

            <a id="sidenav_personalinfo" href="/messages" title="Messages" class="{{($url=="/messages") ? "sidenavselected " : ""}}rippleeffect drawerbtn drawerbtn2 sidenava"><i  class="small material-icons-outlined sideicon">message</i></a>
            
            <a id="sidenav_mystorage" moveto="m" href="/storage" title="My Files" class="{{($url=="/storage") ? "sidenavselected " : ""}}rippleeffect drawerbtn drawerbtn2 sidenava"><i  class="small material-icons-outlined sideicon">storage</i></a>

            <a id="sidenav_personalinfo" href="/auth/myaccount" title="My Account" class="{{($url=="/auth/myaccount") ? "sidenavselected " : ""}}rippleeffect drawerbtn drawerbtn2 sidenava"><i  class="small material-icons-outlined sideicon">person</i></a>
            @else
            <a id="sidenav_personalinfo" href="/auth/login" title="Login" class="rippleeffect drawerbtn drawerbtn2 sidenava"><i  class="small material-icons-outlined sideicon">person</i></a>
            @endif
        </div>
    </div>



    <script>
        var sidenavOpened = false;

        function openNav() {
            $(".sidenav").css({
                width:"270px",
                display: "block",
                top: "0",
                marginTop: "0px"
            });
            $("#behind_sidenav").css({
                width: "100%",
                background: "#32323250",
                position: "fixed",
                zIndex: "10000",
                top: "0"
            });
            sidenavOpened = true;
        }

        function closeNav() {
            $(".sidenav").css({
                width:"0px",
                display: "none",
                top: "0",
                marginTop: "20px"
            });
            $("#behind_sidenav").css({
                background: "none",
                width: "0px"
            });
            sidenavOpened = false;
        }

        $(".menubtn").click(function() {
            if (sidenavOpened)
                closeNav();
            else
                openNav();

        });

        $("#behind_sidenav").click(function() {
            if (sidenavOpened) closeNav();

        });

        function checkResize() {
            if ($(window).width() >= 720){
                $(".sidenav").css({
                    width:"270px",
                    display: "block",
                    top: "65px",
                    marginTop: "20px",
                    paddingTop: "0px"
                });

                $("#behind_sidenav").css({
                    background: "none",
                    width: "270px",
                    paddingTop: "20px"
                });
            }
        }

        $(window).resize(function(){
            checkResize();
        });



        $(window).resize(function(){
            $("#behind_sidenav").css({
                width: "270px"
            });
            if ($(window).width() <= 720){
                closeNav();
            }
        });


        function checkScroll() {

            if (window.pageYOffset > 1) {
                nav.style.boxShadow = " rgba(0, 0, 0, 0.55) 0px -45px 18px 34px";
            }
            else {
                nav.style.boxShadow = "0px 7px 17px -10px rgba(0,0,0,0)";
            }


        }
        $(document).ready(function() {
            var nav = $("#nav");
            var navmenu = document.getElementById("navmenu");
            checkScroll();
            window.onscroll = function() {
                checkScroll();
            };
            checkResize();
            if ($(window).width() <= 720){
                closeNav();
            }
        });


    </script>
    @endif
