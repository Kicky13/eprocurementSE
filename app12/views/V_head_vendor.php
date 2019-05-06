<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

        <title><?= isset($title) ? $title : 'Supplier Registration'; ?></title>
        <link rel="apple-touch-icon" href="<?= base_url() ?>ast11/app-assets/images/ico/apple-icon-120.png">
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("ast11/img/supreme.png") ?>">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
              rel="stylesheet">

        <link href="<?= base_url() ?>ast11/css/plugins/ladda/ladda-themeless.min.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/vendors.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/extensions/nouislider.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/ui/prism.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/extensions/noui-slider.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/colors/palette-noui.css">


        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/pages/chat-application.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/app.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/menu/menu-types/horizontal-menu.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/pages/project.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/fonts/simple-line-icons/style.css">


        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/datatables.min.css">

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/extensions/toastr.css">
        <!-- old -->
        <link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
        <link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/js/plugins/datapicker/bootstrap-datepicker.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
        <style>
            #project-info .project-info-count .project-info-icon {
                border: 3px solid #ececec;
                border-radius: 50%;
                display: block;
                margin: 0 auto;
                padding: 0px;
                position: relative;
                width: 60px;
                height: 60px;
            }
            #project-info .project-info-count .project-info-text {
                display: block;
                margin-top:0px;
                left: 0;
                position: relative;
                top: 0;
                width: 99.8%;
            }
            .error{
                color:#dc3545;
            }
            .has-error .form-control{
                color: #dc3545;
                border-color: #dc3545;
            }
            .has-success .form-control {
                border-color: #1ab394;
            }


            /* table{
                margin: 0 auto;
                width: 100%;
                clear: both;
                border-collapse: collapse;
                table-layout: fixed;
                word-wrap:break-word;
                overflow:hidden;
            } */
            #overlay{
                position:fixed;
                z-index:99999;
                top:0;
                left:0;
                bottom:0;
                right:0;
                background:rgba(0,0,0,0.9);
                transition: 1s 0.4s;
            }
            #progress{
                height:1px;
                background:#fff;
                position:absolute;
                width:0;                /* will be increased by JS */
                top:50%;
            }
            #progstat{
                font-size:0.7em;
                letter-spacing: 3px;
                position:absolute;
                top:50%;
                margin-top:-40px;
                width:100%;
                text-align:center;
                color:#fff;
            }

            /* table{
                margin: 0 auto;
                width: 100%;
                clear: both;
                border-collapse: collapse;
                table-layout: fixed;
                word-wrap:break-word;
                overflow:hidden;
            } */

            #loader {
            position: absolute;
            top: 50%;
            left: 50%;
            -webkit-transform: translate(-50%, -50%);
                    transform: translate(-50%, -50%);
            width: 200px;
            height: 20px;
            background: #ffffff;
            border-radius: 5px;
            -webkit-animation: load 1.8s ease-in-out infinite;
                    animation: load 1.8s ease-in-out infinite;
            }
            #loader:before, #loader:after {
            position: absolute;
            display: block;
            content: "";
            -webkit-animation: load 1.8s ease-in-out infinite;
                    animation: load 1.8s ease-in-out infinite;
            height: 10px;
            border-radius: 5px;
            }
            #loader:before {
            top: -20px;
            left: 10px;
            width: 130px;
            background: #0072cf;
            }
            #loader:after {
            bottom: -20px;
            width: 130px;
            background: #d3222a;
            }

            @-webkit-keyframes load {
            0% {
              -webkit-transform: translateX(40px);
                      transform: translateX(40px);
            }
            50% {
              -webkit-transform: translateX(-30px);
                      transform: translateX(-30px);
            }
            100% {
              -webkit-transform: translateX(40px);
                      transform: translateX(40px);
            }
            }

            @keyframes load {
            0% {
              -webkit-transform: translateX(40px);
                      transform: translateX(40px);
            }
            50% {
              -webkit-transform: translateX(-30px);
                      transform: translateX(-30px);
            }
            100% {
              -webkit-transform: translateX(40px);
                      transform: translateX(40px);
            }
            }

            .notif1 {
              /* margin-left: 30px; */
              /* float: left; */
              overflow-y: scroll;
              /* margin-bottom: 25px; */
            }

            /*
             *  STYLE 1
             */

            #style-1::-webkit-scrollbar-track
            {
              -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
              border-radius: 5px;
              background-color: #F5F5F5;
            }

            #style-1::-webkit-scrollbar
            {
              width: 7px;
              background-color: #F5F5F5;
            }

            #style-1::-webkit-scrollbar-thumb
            {
              border-radius: 5px;
              -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,.3);
              background-color: #c5c5c5;
            }


            /* LOADER 2 */
            body { background: #222 }
            /* ANIMATION */
            @-webkit-keyframes rotate {
              from { -webkit-transform: rotate(0deg) }
              to { -webkit-transform: rotate(360deg) } }
            @-moz-keyframes rotate {
              from { -moz-transform: rotate(0deg) }
              to { -moz-transform: rotate(360deg) } }
            @-o-keyframes rotate {
              from { -o-transform: rotate(0deg) }
              to { -o-transform: rotate(360deg) } }
            @keyframes rotate {
              from { transform: rotate(0deg) }
              to { transform: rotate(360deg) } }

            @-webkit-keyframes fade {
              from { opacity: 1 }
              50% { opacity: 0 }
              to { opacity: 1 } }
            @-moz-keyframes fade {
              from { opacity: 1 }
              50% { opacity: 0 }
              to { opacity: 1 } }
            @-o-keyframes fade {
              from { opacity: 1 }
              50% { opacity: 0 }
              to { opacity: 1 } }
            @keyframes fade {
              from { opacity: 1 }
              50% { opacity: 0 }
              to { opacity: 1 } }

            /* CONTAINER */
            .container-load {
              width: 150px;
              height: 150px;
              /* PRESENTATIONAL PURPOSES */
              margin: auto;
              position: absolute;
              top: 0; left: 0; bottom: 0; right: 0;
              /**/
              cursor: pointer;
              -webkit-user-select: none;
              -webkit-border-radius: 50%;
              -moz-border-radius: 50%;
              border-radius: 50%;
              -webkit-box-shadow: 0 0 0 6px #222,
                0 0 6px 10px #444;
              -moz-box-shadow: 0 0 0 6px #222,
                0 0 6px 10px #444;
              box-shadow: 0 0 0 6px #222,
                0 0 6px 10px #444
            }

            /* TEXT */
            #content {
              background: #222;
              background: -webkit-linear-gradient(#222,#111);
              background: -moz-linear-gradient(#222,#111);
              background: -o-linear-gradient(#222,#111);
              background: linear-gradient(#222,#111);
              position: absolute;
              top: 5px;
              left: 5px;
              right: 5px;
              bottom: 5px;
              -webkit-border-radius: 50%;
              -moz-border-radius: 50%;
              border-radius: 50%;
              text-align: center;
              font: normal normal normal 12px/140px
                'Electrolize', Helvetica, Arial, sans-serif;
              color: #fff
            }

            #content span {
              vertical-align: middle;
              -webkit-animation: fade 1s linear infinite;
              -moz-animation: fade 1s linear infinite;
              -o-animation: fade 1s linear infinite;
              animation: fade 1s linear infinite
            }

            /* SPINNING GRADIENT */
            .ring {
              margin: 0 auto;
              border-radius: 110px;
              padding: 10px;
              position: absolute;
              top: 0;
              right: 0;
              bottom: 0;
              left: 0;
              -webkit-animation: rotate 1s linear infinite;
              -moz-animation: rotate 1s linear infinite;
              -o-animation: rotate 1s linear infinite;
              animation: rotate 1s linear infinite
            }

            /* COLORS */
            .green {
              background: -webkit-linear-gradient(#bfff00,transparent,#bfff00);
              background: -moz-linear-gradient(#bfff00,transparent,#bfff00);
              background: -o-linear-gradient(#bfff00,transparent,#bfff00);
              background: linear-gradient(#bfff00,transparent,#bfff00)
            }

            .blue {
              background: -webkit-linear-gradient(#3cf,transparent,#3cf);
              background: -moz-linear-gradient(#3cf,transparent,#3cf);
              background: -o-linear-gradient(#3cf,transparent,#3cf);
              background: linear-gradient(#3cf,transparent,#3cf)
            }

            .red {
              background: -webkit-linear-gradient(#cd5c5c,transparent,#cd5c5c);
              background: -moz-linear-gradient(#cd5c5c,transparent,#cd5c5c);
              background: -o-linear-gradient(#cd5c5c,transparent,#cd5c5c);
              background: linear-gradient(#cd5c5c,transparent,#cd5c5c)
            }

            .purple {
              background: -webkit-linear-gradient(#e166e1,transparent,#e166e1);
              background: -moz-linear-gradient(#e166e1,transparent,#e166e1);
              background: -o-linear-gradient(#e166e1,transparent,#e166e1);
              background: linear-gradient(#e166e1,transparent,#e166e1)
            }
            .table-price tr th, .table-price tr td{
              padding: 10px !important;
            }
            .table-no-wrap th, .table-no-wrap td {
              white-space: nowrap;
            }
        </style>
        <!-- new -->
        <script src="<?= base_url() ?>ast11/assets/js/tables/jquery-1.12.3.js"></script>

        <script src="<?= base_url() ?>ast11/app-assets/js/iCheck/icheck.min.js" type="text/javascript"></script>

        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/js/plugins/datapicker/bootstrap-datepicker.css">


        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/staps/jquery.steps.min.js"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/jquery.steps.min.js" type="text/javascript"></script>

        <!--<script src="<?= base_url() ?>ast11/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>-->
        <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>-->
        <script src="<?= base_url() ?>ast11/assets/js/forms/select/select2.full.min.js" type="text/javascript"></script>

        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/scripts/extensions/toastr.js" type="text/javascript"></script>
        <!-- <script src="<?= base_url() ?>ast11/app-assets/js/scripts/noui-slider.js" type="text/javascript"></script> -->
        <script src="<?= base_url() ?>ast11/js/global_function.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/numeral.js/2.0.6/numeral.min.js"></script>

        <script>
        $(document).ready(function() {
          function id(v){ return document.getElementById(v); }
            function loadbar() {
              var ovrl = id("overlay"),
                  prog = id("loader"),
                  img = document.images,
                  c = 0,
                  tot = img.length;
                  // prog.innerHTML = "Loading ";
                  ovrl.style.opacity = 0;
                   setTimeout(function(){
                     ovrl.style.display = "none";
                   }, 1200);
               }
        });

        $(window).on('load', function() {
            // $('#overlay').fadeOut(2000);
            $('#overlay').css('opacity', 0);
            $('#overlay').css('z-index', -1);
            setTimeout(function(){ $("#loadingdiv").hide(); $("#overlay").hide();  }, 1300)
            // loadbar();
         });
            $(function () {
                lang();
                function id(v) {
                    return document.getElementById(v);
                }
            }());

            function msg_danger(title, m)
            {
                toastr.warning(m, title);
            }
            function msg_info(title, m)
            {
                toastr.success(m, title);
            }
            function msg_default(title, m)
            {
                toastr.info(m, title);
            }
            function start(elmnt)
            {
                var block_ele = elmnt;
                $(block_ele).block({
                    message: '<div class="semibold"><span class=" white fa fa-spinner fa-spin fa-3x fa-fw"></span><h2 class="white">&nbsp; Loading ...</h2></div>',
                    overlayCSS: {
                        backgroundColor: '#404E67',
                        opacity: 0.8,
                        cursor: 'wait'
                    },
                    css: {
                        border: 0,
                        padding: 0,
                        backgroundColor: 'transparent'
                    }
                });
                return block_ele;
            }

            function stop(elmnt)
            {
                setTimeout(function () {
                    $(elmnt).unblock();
                }, 1200);

            }
            function language(dt)
            {
                if (dt === "IDN")
                {
                    $('.ENG').hide();
                    $('.IND').show();
                    $('.IDN').show();
                }
                else
                {
                    $('.IND').hide();
                    $('.IDN').hide();
                    $('.ENG').show();
                }
            }
            function lang()
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vendor/all_intern/check_lang_sess'); ?>",
                    cache: false,
                    success: function (res)
                    {
                        language(res);
                    }
                });
            }
        </script>
    </head>
    <body data-open="hover" data-menu="horizontal-menu" data-col="content-detached-right-sidebar" class="horizontal-layout horizontal-menu content-detached-right-sidebar menu-expanded">
      <div id="overlay">
        <div class="container-load loadingdiv" style="">
          <div class='ring blue'></div>
          <div id="content">
            <span class="brand-text" style="margin-top: 50px; color: #337ab7; font-weight: bold; font-size: 16px">supre<span style="color: #ff3333">m</span>e energy</span>
          </div>
        </div>
      </div>
        <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
            <div class="navbar-wrapper">
                <div class="navbar-header" style="width:auto;">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs fa fa-home"><i class="ft-menu font-large-1"></i></a></li>
                        <li class="nav-item">
                            <a class="navbar-brand" href="#">
                              <img style="width:23px;" alt="Supreme admin logo" src="<?= base_url(); ?>ast11/img/supreme.png" class="brand-logo">
                              <h2 class="brand-text">supreme energy</h2>
                            </a>
                        </li>
                        <li class="nav-item d-md-none">
                            <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="fa fa-ellipsis-v"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-container content">
                    <div id="navbar-mobile" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav mr-auto float-left">
                            <li class="nav-item d-none d-md-block"><a href="<?= base_url('vn/info/greetings'); ?>" class="nav-link nav-menu-main"><i class="fa fa-home fa-lg"></i></a></li>
                            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-link-expand"><i class="fa fa-window-maximize"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-language nav-item">
                                <?php
                                if ($_SESSION['lang'] == "IDN")
                                    echo '<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link"><i id="flag" class="flag-icon flag-icon-id"></i><span class="selected-language"></span></a>';
                                else
                                    echo '<a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link"><i id="flag" class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>';
                                ?>
                                <div aria-labelledby="dropdown-flag" class="dropdown-menu">
                                    <!-- <button onclick="set_lang(this.value)" value="IDN" class="dropdown-item"><i class="flag-icon flag-icon-id"></i> Indonesia</button> -->
                                    <button onclick="set_lang(this.value)" value="ENG" class="dropdown-item"><i class="flag-icon flag-icon-gb"></i> English</button>
                                </div>
                            </li>
                            <li class="dropdown dropdown-notification nav-item">
                                <!--<a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon ft-bell"></i>-->
                                    <!--<span class="badge badge-pill badge-default badge-danger badge-default badge-up">5</span>-->
                                <!--</a>-->
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <h6 class="dropdown-header m-0">
                                            <span class="grey darken-2">Notifications</span>
                                            <!--<span class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>-->
                                        </h6>
                                    </li>
                                    <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-center">Read all notifications</a></li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-notification nav-item">
                                <!--<a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon ft-mail"></i>-->
                                    <!--<span class="badge badge-pill badge-default badge-warning badge-default badge-up">3</span>-->
                                <!--</a>-->
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <h6 class="dropdown-header m-0">
                                            <span class="grey darken-2">Messages</span>
                                            <!--<span class="notification-tag badge badge-default badge-warning float-right m-0">4 New</span>-->
                                        </h6>
                                    </li>
                                    <li class="scrollable-container media-list">
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                                <div class="media-left">
                                                    <span class="avatar avatar-sm avatar-online rounded-circle">
                                                        <img src="<?= base_url() ?>ast11/app-assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Margaret Govan</h6>
                                                    <p class="notification-text font-small-3 text-muted">I like your portfolio, let's start.</p>
                                                    <small>
                                                        <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Today</time>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                                <div class="media-left">
                                                    <span class="avatar avatar-sm avatar-busy rounded-circle">
                                                        <img src="<?= base_url() ?>ast11/app-assets/images/portrait/small/avatar-s-2.png" alt="avatar"><i></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Bret Lezama</h6>
                                                    <p class="notification-text font-small-3 text-muted">I have seen your work, there is</p>
                                                    <small>
                                                        <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Tuesday</time>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                                <div class="media-left">
                                                    <span class="avatar avatar-sm avatar-online rounded-circle">
                                                        <img src="<?= base_url() ?>ast11/app-assets/images/portrait/small/avatar-s-3.png" alt="avatar"><i></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Carie Berra</h6>
                                                    <p class="notification-text font-small-3 text-muted">Can we have call in this week ?</p>
                                                    <small>
                                                        <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Friday</time>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                                <div class="media-left">
                                                    <span class="avatar avatar-sm avatar-away rounded-circle">
                                                        <img src="<?= base_url() ?>ast11/app-assets/images/portrait/small/avatar-s-6.png" alt="avatar"><i></i></span>
                                                </div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Eric Alsobrook</h6>
                                                    <p class="notification-text font-small-3 text-muted">We have project party this saturday.</p>
                                                    <small>
                                                        <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">last month</time>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-center">Read all messages</a></li>
                                </ul>
                            </li>
                            <li class="dropdown dropdown-user nav-item">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                                    <span class="avatar avatar-online">
                                        <img src="<?= base_url() ?>ast11/app-assets/images/portrait/small/user-2517433_960_720.png" alt="avatar"><i></i></span>
                                    <span class="user-name"><?= $this->session->userdata('NAME') ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <!-- <a href="#" class="dropdown-item"><i class="ft-user"></i> Edit Profile</a>
                                  <a href="#" class="dropdown-item"><i class="ft-mail"></i> My Inbox</a>
                                  <a href="#" class="dropdown-item"><i class="ft-check-square"></i> Task</a>
                                  <a href="#" class="dropdown-item"><i class="ft-message-square"></i> Chats</a> -->
                                  <a href="<?= base_url() ?>vn/info/greetings" class="dropdown-item"><i class="fa fa-home"></i> Home</a>
                                  <div class="dropdown-divider"></div>
                                  <a href="<?= base_url() ?>vn/info/all_vendor/log_out" class="dropdown-item"><i class="fa  fa-power-off"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- ////////////////////////////////////////////////////////////////////////////-->
        <!-- Horizontal navigation-->
        <!-- <div role="navigation" data-menu="menu-wrapper" class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border">
            Horizontal menu content
            <div data-menu="menu-container" class="navbar-container main-menu-content container center-layout">
                include ../../../includes/mixins
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="nav navbar-nav">
                    <?php
                        /*$url = strtolower($_SERVER['PATH_INFO']);
                        $arr_url = explode("/", $url);
                        $url_min1 = str_replace("#", "", substr($url, 1));
                        if(isset($menu))
                        {
                        foreach ($menu[0] as $k => $v) {
                                $active = "";
                                if ($v['URL'] == $url_min1) {
                                    $active = "active";
                                }
                                echo '<li><a href="' . base_url($v['URL']) . '" class="dropdown-toggle nav-link" ' . $active . '">
                                            <i class="'.$v["ICON"].' text-primary"></i>
                                            <span class="IDN">' . $v["DESKRIPSI_IND"] . '</span>
                                            <span class="ENG">' . $v["DESKRIPSI_ENG"] . '</span>
                                        </a></li>';
                        }
                        echo '<script type="text/javascript">',
                        'lang();',
                        '</script>';
                    }*/
                    ?>
                </ul>
            </div>
        </div> -->
        <div class="modal fade" id="check_list_data" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h4 class="modal-title"> <?= lang('Tampil Rincian Data', 'Show Detail Data') ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-12">
                                <table id="tbl_checklist" class="table table-striped table-bordered table-hover display" width="100%"></table>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                        <button id="save2" onclick="update_vendor_stat()" class="btn btn-primary" data-dismiss="modal"><?= lang('Perbarui Data', 'Update Data') ?></button>
                        <button id="save" type="submit" class="btn btn-success" data-dismiss="modal"><?= lang('Kirim untuk Proses', 'Send for Proccess') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="data_comment" class="modal fade " data-backdrop="static" role="dialog">
            <div class="modal-dialog">
                <div class=" modal-content">
                    <div class="content-body">
                        <div class="modal-header bg-success white">
                            <h4 class="modal-title" id="myModalLabel1"><?= lang("Pesan", "Message") ?></h4>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body chat-application" style="padding:0px">
                            <section class="chat-app-window">
                                <div class="badge badge-default mb-1">Chat History</div>
                                <input type="text" id="type_msg" style="display:none">
                                <div class="chats">
                                    <div id="message" style="max-height:300px" class="chats">
                                    </div>
                                </div>
                            </section>
                            <section class="chat-app-form">
                                <form id="form_chat" class="chat-app-input d-flex">
                                    <fieldset class="form-group position-relative has-icon-left col-10 m-0">
                                        <div class="form-control-position">
                                            <i class="fa fa-paper-plane-o"></i>
                                        </div>
                                        <input type="text" class="form-control" id="send_msg" placeholder="Type your message">
                                        <div class="form-control-position control-position-right">
                                            <i class="ft-image"></i>
                                        </div>
                                    </fieldset>
                                    <fieldset class="form-group position-relative has-icon-left col-2 m-0">
                                        <button id="btn_msg" type="button" onclick="send()" class="btn btn-success"><i class="fa fa-paper-plane-o d-lg-none"></i>
                                            <span class="d-none d-lg-block"><?= lang("Kirim", "Send") ?></span>
                                        </button>
                                    </fieldset>
                                </form>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(function ()
            {
                lang();
                check_status();
                $('#data_comment').on('hidden.bs.modal', function (e) {
                    if($('#check_list_data').hasClass('show')) {
                        $('body').addClass('modal-open');
                    }
                });
                $('#save').click(function ()
                {
                    var obj = {};
                    obj.total = $("#total_wajib").val();
                    obj.total_check_mandatory = $("#total_check_mandatory").val();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('vn/info/all_vendor/check_send/') ?>',
                        data: obj,
                        success: function (msg)
                        {
                            if (msg.status == "failed")
                                msg_danger(msg.status, msg.msg);
                            else
                            {
                                submit_data();
                            }
                            lang();
                        }
                    });
                });
                $('.verif').hide();
                $('.verif_rej').hide();
            });
            function update_data()
            {
                swal({
                    title: "Are you sure?",
                    text: "To make an update, your data will go through the approval process again",
                    type: "warning",
                    showCancelButton: true,
                    CancelButtonColor: "#DD6B55",
                    confirmButtonColor: "#d9534f",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                }, function () {
                    var elm = start($('.sweet-alert'));
                    var obj = {};
                    obj.API = "insert";
                    $.ajax({
                        type: 'POST',
                        data: obj,
                        url: '<?= base_url('vn/info/all_vendor/update_supplier_new/') ?>',
                        success: function (msg) {
                            stop(elm);
                            swal(msg.msg, "", msg.status);
                            if (msg.status == "success")
                                check_status();
                            lang();
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            stop(elm);
							msg_danger("Failed", "Oops, an error occurred")
                        }
                    });
                });
            }
            function set_lang(dt)
            {
//                    var dt = $(this).val();
                console.log(dt);
                var obj = {};
                obj.lang = dt;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/all_vendor/set_sess'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        language(dt);
                    }
                });
            }
            function language(dt)
            {
                if (dt === "IDN")
                {
                    $('.ENG').hide();
                    $('.IDN').show();
                    $("#flag").removeClass("flag-icon-gb");
                    $("#flag").addClass("flag-icon-id");
                }
                else
                {
                    $('.IDN').hide();
                    $('.ENG').show();
                    $("#flag").addClass("flag-icon-gb");
                    $("#flag").removeClass("flag-icon-id");
                }
            }
            function lang()
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/all_vendor/check_lang_sess'); ?>",
                    cache: false,
                    success: function (res)
                    {
                        language(res);
                    }
                });
            }
            function check_list() {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/all_vendor/get_checklist/') ?>',
                    success: function (msg) {
                        $('#tbl_checklist').html(msg);
//                        $('#check_list_data #save').show();
//                        $('#check_list_data #save2').hide();
                        check_status();
                        $('#check_list_data .modal-title').html("<?= lang("Rincian Data", "List Data") ?>");
                        $('#check_list_data .modal-header').removeClass("bg-primary");
                        $('#check_list_data .modal-header').addClass("bg-success");
                        $('#check_list_data .modal-header').css("color", "#fff");
                        $('#check_list_data').modal('show');
                        lang();
                    }
                });
                lang();
            }
            function list_rejected() {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/all_vendor/get_list_rejected/') ?>',
                    success: function (msg) {
                        $('#tbl_checklist').html(msg);
//                        $('#check_list_data #save').hide();
                        $('#check_list_data #save2').hide();
                        $('#check_list_data .modal-title').html("<?= lang("Rincian Perbaikan Data", "Update Data List") ?>");
                        $('#check_list_data .modal-header').removeClass("bg-success");
                        $('#check_list_data .modal-header').addClass("bg-primary");
                        $('#check_list_data .modal-header').css("color", "#fff");
                        $('#check_list_data').modal('show');
                        lang();
                    }
                });
                lang();
            }

            function comment(type)
            {
                var obj = {};
                obj.type = type;
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/all_vendor/comment/') ?>',
                    data: obj,
                    success: function (m) {
                        $('#message').html(m);
                        $('#type_msg').val(type)
                        lang();
                        $('#data_comment').modal('show');
                    }
                });
            }

            function send()
            {
                var obj = {};
                obj.msg = $('#send_msg').val();
                obj.type = $('#type_msg').val();
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/all_vendor/send') ?>',
                    data: obj,
                    success: function (m) {
                        if (m != false)
                        {
                            document.getElementById("form_chat").reset();
                            comment(obj.type);
                        }
                        else
                            msg_danger("Failed", "Oops, an error occurred")
                    }
                });
            }

            function check_status()
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vn/info/all_vendor/check_status_new'); ?>",
                    cache: false,
                    success: function (res)
                    {
                      console.log(res);
                        $('#slka').hide();
                        $('.verif_gen').hide();
                        $('.verif_app').hide();
                        $('.verif_rej').hide();
                        $('.update-btn').hide();
                        $('.verif').hide();
                        $('#check_list_data #save2').hide();
                        console.log(res.update);
                        if (res.status != false)
                        {
                            if (!res.update)
                            {
                              console.log("masuk");
                                //$('.btn-primary').prop('disabled', true);
                                $('form :input').prop('disabled', true);
                                $('.open-this :input').prop('disabled', false);
                                $('#save').prop('disabled', true);
                                $('.verif_rej').prop('disabled', false);
                            }
                            else
                            {
                              console.log("tidk");
                                $('.verif_app').show();
                                $('.checklist').show();
                                $('#check_list_data #save').hide();
                                $('#check_list_data #save2').show();
                            }

                            if (res.msg === "app")
                            {
                                $('.verif').show();
                                if (!res.update && res.slka == true)
                                {
                                    $('.update-btn').show();
                                    $('.checklist').hide();
                                    $('.update-btn').prop('disabled', false);
                                }
                                if (res.slka == true)
                                {
                                    $('#slka').show();
                                    $('.verif_app').show();
                                }
                                else
                                {
                                    $('.verif_gen').show();
                                    $('#slka').hide();
                                }
                            }
                            else if (res.msg === "rej")
                            {
                                $('.verif_rej').show();
                                $('#check_list_data #save').hide();
                                $('#check_list_data #save2').show();
                                $('#send_msg').prop('disabled', false);
                                $('#btn_msg').prop('disabled', false);
                                $('#check_list_data #save2').prop('disabled', false);
                                process();
                            }
                        }
                    }
                });
            }
            function submit_data()
            {
                swal({
                    title: "Are you sure?",
				    text: "To Send This Data",
                    type: "warning",
                    showCancelButton: true,
                    CancelButtonColor: "#DD6B55",
                    confirmButtonColor: "#d9534f",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                }, function () {
                    var elm = start($('.sweet-alert'));
                    msg_default("Info", "Sent Data..");
                    var obj = {};
                    obj.API = "insert";
                    $.ajax({
                        type: 'POST',
                        data: obj,
                        url: '<?= base_url('vn/info/all_vendor/submit_data_new/') ?>',
                        success: function (msg) {
                            stop(elm);
                            swal(msg.msg, "", msg.status);
                            if (msg.status == "success")
                                check_status();
                            lang();
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            stop(elm);
                            msg_danger("Failed", "Oops, an error occurred");
                        }
                    });
                }
                );
            }
            function update_vendor_stat()
            {
                var obj = {};
                obj.total = $("#total_wajib").val();
                obj.total_check_mandatory = $("#total_check_mandatory").val();
                $.ajax({
                        type: 'POST',
                        url: '<?= base_url('vn/info/all_vendor/check_send/') ?>',
                        data: obj,
                        success: function (msg)
                        {
                            if (msg.status == "failed")
                                msg_danger(msg.status, msg.msg);
                            else
                            {
                                update_submit_data();
                            }
                            lang();
                        }
                    });
            }
            function update_submit_data()
            {
                swal({
                    title: "Are you sure?",
                    text: "To Send This Data",
                    type: "warning",
                    showCancelButton: true,
                    CancelButtonColor: "#DD6B55",
                    confirmButtonColor: "#d9534f",
                    confirmButtonText: "Yes",
                    closeOnConfirm: false
                }, function () {
                    var elm = start($('.sweet-alert'));
                    msg_default("Info", "Data Sedang Dikirim..");
                    var obj = {};
                    obj.API = "update";
                    $.ajax({
                        type: 'POST',
                        data: obj,
                        url: '<?= base_url('vn/info/all_vendor/submit_data_new/') ?>',
                        success: function (msg) {
                            swal(msg.msg, "", msg.status);
                            if (msg.status == "success")
                                check_status();
                            lang();
                            stop(elm);
                        },
                        error: function (XMLHttpRequest, textStatus, errorThrown) {
                            stop(elm);
                           msg_danger("Failed", "Oops, an error occurred")
                        }
                    });
                }
                );
            }
            function process()
            {
                $.ajax({
                    type: 'POST',
                    url: '<?= base_url('vn/info/all_vendor/get_reject') ?>',
                    success: function (res)
                    {
                        if (res['deact']) {
                            for (var i = 0; i < res['deact'].length; i++)
                            {
                                $("#" + res['deact'][i] + " .verif_rej").hide();
                                $("#" + res['deact'][i] + " .verif").show();
                                // $(".btn.btn-danger").hide();
                                $("#" + res['deact'][i]).next('.card-content').find(".btn.btn-danger").hide();
                            }
                        }
                        if (res['act']) {
                            for (var i = 0; i < res['act'].length; i++)
                            {
                                $("#" + res['act'][i] + " .verif_rej").show();
                                $("." + res['act'][i] + " :input").prop("disabled", false);
                                $("#" + res['act'][i]).next('.card-content').find(".btn.btn-danger").show();

                            }
                        }
                    }
                });
            }
        </script>
