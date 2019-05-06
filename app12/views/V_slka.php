<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

        <title>Supplier Registration</title>
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
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.css">
        <style>
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
        </style>
        <!-- new -->
        <script src="<?= base_url() ?>ast11/assets/js/tables/jquery-1.12.3.js"></script>                        

        <script src="<?= base_url() ?>ast11/app-assets/js/iCheck/icheck.min.js" type="text/javascript"></script>

        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>

        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/staps/jquery.steps.min.js"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/jquery.steps.min.js" type="text/javascript"></script>        

        <script src="<?= base_url() ?>ast11/assets/js/forms/select/select2.full.min.js" type="text/javascript"></script>            

        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/scripts/extensions/toastr.js" type="text/javascript"></script>

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
    <body data-open="hover" data-menu="horizontal-menu" data-col="content"class="horizontal-layout horizontal-menu content-detached-right-sidebar   menu-expanded">
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
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu font-large-1"></i></a></li>
                        <li class="nav-item">
                            <a href="index.html" class="navbar-brand">                                            
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
                            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu"></i></a></li>
                            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-link-expand"><i class="ficon ft-maximize"></i></a></li>
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
                                    <button onclick="set_lang(this.value)" value="IDN" class="dropdown-item"><i class="flag-icon flag-icon-id"></i> Indonesia</button>
                                    <button onclick="set_lang(this.value)" value="ENG" class="dropdown-item"><i class="flag-icon flag-icon-gb"></i> English</button>                                    
                                </div>
                            </li>                                                        
                        </ul>
                    </div>
                </div>
            </div>
        </nav>        
        <div class="content-wrapper">
            <div class="content-header row">
                <div class="content-header col-md-6 col-12 mb-2">                    
                    <div class="row breadcrumbs-top">
                        <div class="breadcrumb-wrapper col-12">
                            <ol class="breadcrumb">                                
                            </ol>
                        </div>
                    </div>                    
                </div>        
            </div>
            <div class="content-detached col-12" id="verified">
                <div class="content-body">                                                                                        
                    <section id="description">
                        <div class="card">
                            <div class="card-content GENERAL1">                            
                                <div class="card-header text-center">
                                    <h1 class="content-header-title mb-0"><?= lang("Verifikasi SLKA", "SLKA Verification") ?></h1>                                
                                </div>
                                <div class="card-body">                                
                                    <div class="row">
                                        <?php
                                        if($verif == true)
                                        {
                                        echo '<h2 class="text-center col-12">
                                            '.lang("Data SLKA anda Terverifikasi<br/>Untuk melihat data anda silahkan click link berikut ini <a href=# onclick=set()>Link SLKA</a>","Your SLKA Data is verified, click this link <a href=# onclick=set()>Link SLKA</a> to view your SLKA file").'
                                        </h2>';
                                        }
                                        else
                                        {
                                            echo '<h2 class="text-center col-12">
                                            '.lang("Data SLKA anda tidak ditemukan<br/>Pastikan anda sudah melakukan registrasi"
                                                    . " atau hubungi kami untuk informasi lebih lanjut","Your SLKA"
                                                    . " Data is not found,<br/> Please make sure you have registered or call us fo furhter information").'
                                        </h2>';
                                        }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="content-detached col-12" id="SLKA">
                <div class="content-body">                                                                                        
                    <section id="description">
                        <div class="card">
                            <div class="card-content GENERAL1">                            
                                <div class="card-header text-center">
                                    <h3 class="content-header-title mb-0"><?= lang("SLKA", "SLKA") ?></h3>                                
                                </div>
                                <div class="card-body">                                
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <table>
                                                        <tr>
                                                            <td>To</td>
                                                            <td>:<?= isset($slka[0])? $slka[0]['NAMA']:"" ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>NPWP</td>
                                                            <td>:<?= isset($slka[0])? $slka[0]['NO_NPWP']:"" ?></td>
                                                        </tr>
                                                        <tr>
                                                            <td>Adress</td>
                                                            <td>:<?= isset($slka[0])? $slka[0]['ADDRESS']:"" ?></td>
                                                        </tr>
                                                    </table>                                                          
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="tulisan">
                                                        <table>
                                                            <tr>
                                                                <td></td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Fax No.</td>
                                                                <td>:<?= isset($slka[0])? $slka[0]['FAX']:"" ?></td>
                                                            </tr>
                                                            <tr>
                                                                <td><p>Phone No.</td>
                                                                <td>:<?= isset($slka[0])? $slka[0]['TELP']:"" ?></p></td>
                                                            </tr>
                                                        </table>
                                                        <br/>
                                                    </div>
                                                </div>                        
                                            </div>
                                            <div class="tulisan">
                                                <table>
                                                    <tr>
                                                        <td><p>Subject</td>
                                                        <td>: Company’s Letter of Administration Qualification / Surat Lulus Kualifikasi Administrasi Perusahaan (SLKA)</p></td>
                                                    </tr>
                                                </table>
                                            </div>                    
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div id="open" class="tulisan">                                                            
                                                        <?= str_replace("XXXX", isset($slka[0])? $slka[0]['NO_SLKA']:"", isset($slka[0])? $slka[0]['OPEN_VALUE']:"") ?>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div id="close" class="tulisan">                                                            
                                                        <?= str_replace("XXXX", isset($slka[0])? $slka[0]['NO_SLKA']:"", isset($slka[0])? $slka[0]['CLOSE_VALUE']:"") ?>
                                                    </div>
                                                </div>
                                            </div>                                                
                                        </div>
                                    </div>
                                    <!-- <div class="text-center" id="qr">                                                                        
                                        <img src="<?= base_url() ?>/show_qr/get_qr/<?=$_GET['q']?>" />
                                    </div> -->
                                    <div class="row">                                                     
                                        <div class="text-left col-6" id="qr">                                                                        
                                            <img id="qr_slka" style="max-width:150px" src="<?= base_url() ?>show_qr/get_qr/<?=$_GET['q']?>" />
                                        </div>
                                        <div class="text-right col-6 mt-1">                     
                                            <div class="col-12 text-center mb-5">
                                                <p id="app_date">Jakarta, <?=DateTime::createFromFormat('Y-m-d H:i:s',isset($slka[0])? $slka[0]['SLKA_DATE']:date("Y-m-d H:i:s"))->format('d F Y')?></p>
                                            </div>
                                            <div class="col-12 text-center"> Sally Edwina Prajoga</div>
                                            <div class="col-12 text-center"> Head of Performance & Support SCM</div>
                                        </div>
                                    </div>
                                </div>                            
                            </div>            
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <footer class="footer fixed-bottom footer-dark navbar-shadow">
            <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2 content">
                <span class="float-md-left d-block d-md-inline-block">Copyright &copy; 2017 , All rights
                    reserved. </span>
                <span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Supreme Energy</span>
            </p>
        </footer>
        
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/assets/js/forms/select/select2.full.min.js" type="text/javascript"></script>            
        <script type="text/javascript" src="<?= base_url() ?>ast11/app-assets/vendors/js/ui/jquery.sticky.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>ast11/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
        <script type="text/javascript" src="<?= base_url() ?>ast11/app-assets/vendors/js/ui/jquery.sticky.js"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/nouislider.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/staps/jquery.steps.min.js"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/jquery.steps.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>                                                                       

        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/core/app-menu.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/core/app.js" type="text/javascript"></script>

        <script type="text/javascript" src="<?= base_url() ?>ast11/app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/scripts/pages/content-sidebar.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/validation/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/validation/additional-methods.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/plugins/validation/form-validation.js" type="text/javascript"></script>

        <script src="<?= base_url() ?>ast11/js/plugins/sweetalert/sweetalert.min.js"></script> 
        <script>
            $(function ()
            {
                $('#SLKA').hide();
                lang();
            });
            
            function set()
            {
                $('#verified').hide();
                $('#SLKA').show();
            }
            
            function set_lang(dt)
            {

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
        </script>
    </body>
</html>
