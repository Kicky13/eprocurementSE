<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Supreme - Dashboard</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("ast11/img/supreme.png") ?>">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/pages/chat-application.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/vendors.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/app.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/fonts/simple-line-icons/style.min.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom-dashboard.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/fonts/feather/style.min.css">
        <script src="<?= base_url() ?>ast11/app-assets/js/core/libraries/jquery-3.2.1.min.js"></script>
        <script src="<?= base_url() ?>ast11/js/axios.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/vue.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/assets/js/accounting.js/accounting.js" type="text/javascript"></script>
        <script type="text/javascript">
            var globalChartOption = {
                color : ['#00B5B8', '#FF7588', '#CCCCCC', '#FFC107', '#0072CF', '#FFFF00', '#99FF00', '#FF00FF', '#00FFFF', '#000000', '#CC0000', '#006666']
            }
        </script>
        <style>
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
            .container {
                width: 150px;
                height: 150px;
                margin: auto;
                position: absolute;
                top: 0; left: 0; bottom: 0; right: 0;
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

            .blue {
                background: -webkit-linear-gradient(#3cf,transparent,#3cf);
                background: -moz-linear-gradient(#3cf,transparent,#3cf);
                background: -o-linear-gradient(#3cf,transparent,#3cf);
                background: linear-gradient(#3cf,transparent,#3cf);
            }
        </style>
    </head>
    <body data-open="click" data-menu="vertical-menu" data-col="2-columns" class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" style="zoom:90%">
        <div id="overlay">
            <div class="container loadingdiv">
                <div class='ring blue'></div>
                <div id="content">
                    <span class="brand-text" style="margin-top: 50px; color: #337ab7; font-weight: bold; font-size: 16px">supre<span style="color: #ff3333">m</span>e energy</span>
                </div>
            </div>
        </div>
        <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-light bg-gradient-x-grey-blue">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="fa fa-bars font-large-1"></i></a></li>
                        <li class="nav-item">
                            <a href="<?= base_url('dashboard/home') ?>" class="navbar-brand" style="margin-top:-10px">
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
                            <li id="menu-toggle" class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="fa fa-bars"></i></a></li>
                            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-link-expand"><i class="fa fa-window-maximize"></i></a></li>
                            <?php if (isset($title)) { ?>
                                <li class="nav-item d-none d-md-block"><a href="#" class="nav-link"><b><?= $title ?></b></a></li>
                            <?php } ?>
                        </ul>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-language nav-item">
                                <a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="dropdown-toggle nav-link">
                                  <i class="flag-icon flag-icon-id indonesia"></i>
                                  <i class="flag-icon flag-icon-gb english"></i>
                                  <span class="selected-language"></span></a>
                                <div aria-labelledby="dropdown-flag" class="dropdown-menu">
                                    <a href="#" onClick="change_lang('ENG')"  class="dropdown-item"><i class="flag-icon flag-icon-gb"></i> English</a>
                                </div>
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
                                    <a href="<?= base_url('dashboard/home') ?>" class="dropdown-item"><i class="fa fa-dashboard"></i> <?= lang("Beranda", "Home")?></a>
                                    <div class="dropdown-divider"></div>
                                    <a href="<?= base_url() ?>vendor/all_intern/log_out" class="dropdown-item"><i class="fa fa-sign-out"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>
        <div class="app-content content">
            <div class="content-wrapper">
