<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Supreme - Eproc</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("ast11/img/supreme.png") ?>">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/pages/chat-application.css">

        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/vendors.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/app.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/fonts/simple-line-icons/style.min.css">

        <!-- <link href="<?= base_url() ?>ast11/assets_lm/css/bootstrap.min.css" rel="stylesheet"> -->
        <!--<link href="<?= base_url() ?>ast11/css/plugins/font-awesome/css/font-awesome.css" rel="stylesheet">-->

        <link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
        <!-- <link href="<?= base_url() ?>ast11/css/plugins/datapicker/datepicker3.css" rel="stylesheet"> -->

        <link href="<?= base_url() ?>ast11/assets_lm/css/animate.css" rel="stylesheet">

        <link href="<?= base_url() ?>ast11/css/plugins/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
        <!-- <link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet"> -->
        <link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
        <!-- <link href="<?= base_url() ?>ast11/css/plugins/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/> -->
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/extensions/toastr.css">
        <!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/extensions/toastr.css">-->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">


        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/validation/form-validation.css">

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/pickadate/pickadate.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css">

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

            .tabledisp td{
                padding:7px 0px 7px 0px;
            }

            #project-info .project-info-count .project-info-text {
                display: block;
                margin-top:0px;
                left: 0;
                text-align:center;
                position: relative;
                top: 0;
                width: 99.8%;
            }
            .k-multiselect-wrap{
                display: block;
                width: 100%;
                min-height:29px;
                border: 1px solid #f1f1f1;
            }
            .k-input{
                display:none;
            }
            .k-button{
                display: inline-block;
                padding: 6px 12px;
                margin-bottom: 0;
                font-size: 14px;
                font-weight: 400;
                line-height: 1.42857143;
                text-align: center;
                white-space: nowrap;
                vertical-align: middle;
                touch-action: manipulation;
                cursor: pointer;
                user-select: none;
                background-image: none;
                border-radius: 3px;
                border: 1px solid #f1f1f1;
            }
            html .k-dialog .k-window-titlebar {
                padding-left: 17px;
            }

            .k-dialog .k-content {
                padding: 17px;
            }
            #filterText {
                width: 100%;
                box-sizing: border-box;
                padding: 6px;
                border-radius: 3px;
                border: 1px solid #d9d9d9;
            }

            .selectAll {
                margin: 17px 0;
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

            #result {
                color: #9ca3a6;
                float: right;
            }

            #treeview {
                height: 300px;
                overflow-y: auto;
                overflow-x: hidden;
                border: 1px solid #d9d9d9;
            }

            .dashboard-title small {
                font-size: 12px;
                color: #AAA
            }
            th {
                word-wrap:break-word
            }
            .table-no-wrap th, .table-no-wrap td {
              white-space: nowrap;
            }
            .table-sm {
                font-size: 11px;
            }
            .table-sm th, .table-sm td{
                padding: 3px !important;
                white-space: normal !important;
            }
            .select2-dropdown-large {
                width: 400px !important;
            }
            .select2-font-sm {
                font-size: 12px;
            }
        </style>
        <!--<script src="<?= base_url() ?>ast11/assets/js/tables/jquery-1.12.3.js"?></script>-->
        <script src="<?= base_url() ?>ast11/app-assets/js/core/libraries/jquery-3.2.1.min.js"></script>

        <script src="<?= base_url() ?>ast11/js/plugins/staps/jquery.steps.min.js"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/jquery.steps.min.js" type="text/javascript"></script>



        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
        <!-- <script src="<?= base_url() ?>ast11/app-assets/js/scripts/tables/datatables/datatable-basic.js"></script> -->


        <script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
        <script src="<?= base_url() ?>ast11/css/plugins/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/datapicker/bootstrap-datepicker.js"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/summernote/summernote.min.js"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/switchery/switchery.js"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/spinner/jquery.bootstrap-touchspin.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/global_function.js"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/scripts/extensions/toastr.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/scripts/extensions/block-ui.js" type="text/javascript"></script>
        <script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.js"></script>
        <!-- <script src="<?= base_url() ?>ast11/js/plugins/jquery-ui/jquery-ui.js"></script> -->
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/assets/js/forms/select/select2.full.min.js" type="text/javascript"></script>


        <style>
            .main-menu.menu-light .navigation > li.open {
                border-left: 4px solid #337ab7;
            }
            .main-menu.menu-light .navigation > li ul .active > a {
                color: #337ab7;
                font-weight: 500;
            }
            img{
                width:100%;
            }

            body{ font: 200 16px/1 sans-serif; }
            img{ width:32.2%; }

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
            .container {
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
        </style>

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
            function msg_danger(x, y) {
                toastr.warning(x, y);
            }

            function msg_info(xx, yy) {
                toastr.success(xx, yy);
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

            $(document).ready(function() {
                  lang();

                  function language(dt) {
                      if (dt === "IND") {
                          $('.ENG').hide();
                          $('.IND').show();
                          $('.IDN').show();
                      }
                      else {
                          $('.IND').hide();
                          $('.IDN').hide();
                          $('.ENG').show();
                      }
                  }
                  function lang() {
                      $.ajax({
                          type: "POST",
                          url: "<?= site_url('vendor/all_intern/check_lang_sess'); ?>",
                          cache: false,
                          success: function (res)
                          {
                              language(res);
                              if (res == "ENG") {
                                $(".indonesia").hide();
                                $(".english").show();
                              } else {
                                $(".indonesia").show();
                                $(".english").hide();
                              }
                          }
                      });
                  }



            });

            function change_lang(lang) {
                $.ajax({
                    type: "POST",
                    url: "<?= site_url('vendor/all_intern/change_lang/'); ?>" + lang,
                    cache: false,
                    success: function (res) {
                        language(res);
                    }
                });
            }
            function language(dt)
            {
                if (dt === "IND")
                {
                    $('.ENG').hide();
                    $('.IND').show();
                    $('.IDN').show();
                    $(".indonesia").show();
                    $(".english").hide();
                }
                else
                {
                    $('.IND').hide();
                    $('.IDN').hide();
                    $('.ENG').show();
                    $(".indonesia").hide();
                    $(".english").show();

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

            var globalChartOption = {
                color : ['#00B5B8', '#FF7588', '#CCCCCC', '#FFC107', '#0072CF', '#FFFF00', '#99FF00', '#FF00FF', '#00FFFF', '#000000', '#CC0000', '#006666']
            }
        </script>
    </head>
    <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" style="zoom:90%">
        <div id="overlay">
            <div class="container loadingdiv" style="">
            <div class='ring blue'></div>
                <div id="content">
                    <span class="brand-text" style="margin-top: 50px; color: #337ab7; font-weight: bold; font-size: 16px">supre<span style="color: #ff3333">m</span>e energy</span>
                </div>
            </div>
        </div>
        <!-- fixed-top-->
        <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-light bg-gradient-x-grey-blue">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="fa fa-bars font-large-1"></i></a></li>
                        <li class="nav-item">
                            <a href="<?= base_url('home') ?>" class="navbar-brand" style="margin-top:-10px">
                                <img style="width:20%;" alt="Supreme admin logo" src="<?= base_url("ast11/img/supreme.png") ?>" class="brand-logo">
                                <h4 class="brand-text" style="margin-left: -15px; color: #337ab7; font-weight: bold;">supre<span style="color: #ff3333">m</span>e energy</h4>
                            </a>
                        </li>
                        <li class="nav-item d-md-none"><a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="fa fa-ellipsis-v"></i></a></li>
                    </ul>
                </div>
                <div class="navbar-container content">
                    <div id="navbar-mobile" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav mr-auto float-left">
                            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="fa fa-bars"></i></a></li>
                            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-link-expand"><i class="fa fa-window-maximize"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-language nav-item">
                                <a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link">
                                  <i class="flag-icon flag-icon-id indonesia"></i>
                                  <i class="flag-icon flag-icon-gb english"></i>
                                  <span class="selected-language"></span></a>
                                <div aria-labelledby="dropdown-flag" class="dropdown-menu">
                                    <a href="#" onClick="change_lang('IND')" class="dropdown-item"><i class="flag-icon flag-icon-id"></i> Indonesia</a>
                                    <a href="#" onClick="change_lang('ENG')"  class="dropdown-item"><i class="flag-icon flag-icon-gb"></i> English</a>
                                </div>
                            </li>

                            <!-- NOTIFIKASI LONCENG -->
                            <li class="dropdown dropdown-notification nav-item" id="notif">

                            </li>

                            <!-- NOTIFIKASI AMPLOP -->
                            <li class="dropdown dropdown-notification nav-item"  id="messages">

                            </li>

                            <li class="dropdown dropdown-user nav-item">
                              <?php
                              $this->db->where('ID_USER', $this->session->userdata['ID_USER']);
                              $data = $this->db->select('*')->from('m_user a')->order_by('CREATE_TIME DESC')->get();
                              $row = $data->row();
                               ?>
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                                    <span class="avatar avatar-online">
                                        <img src="<?php if($row->IMG != ""){ echo base_url('upload/').$row->IMG; } else { echo base_url('ast11/app-assets/images/portrait/small/user-2517433_960_720.png'); } ?>" style="width:30px; height:30px;" alt="avatar"><i></i></span>
                                    <span class="user-name"><?= strtolower($_SESSION['NAME']) ?></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                  <a href="<?= base_url()?>users/User_profile" class="dropdown-item"><i class="fa fa-user"></i> <?= lang("Profil User", "User Profile")?></a>
                                  <div class="dropdown-divider"></div>
                                  <a href="<?= base_url() ?>vendor/all_intern/log_out" class="dropdown-item"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <!-- main menu-->
        <div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow">
            <div class="col-md-12 main-menu-content">
                <div class="mb-2" style="height:80px;border: 1px solid #f1f1f1">
                </div>
                <?php if (isset($side_filter)) { ?>
                    <?php $this->load->view($side_filter) ?>
                <?php } else { ?>
                    <?php $this->load->view('dashboard/partials/msr_filter.php') ?>
                <?php } ?>
            </div>
        </div>