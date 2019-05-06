<!DOCTYPE html>

<!--Header-->
<html lang="en" data-textdirection="ltr" class="loading">
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <title>Supreme Energy</title>



        <!-- BEGIN VENDOR CSS-->
        <link rel="stylesheet" type="text/css" href="../assets/css/vendors.css">
        <link rel="stylesheet" type="text/css" href="../assets/vendors/css/tables/datatable/datatables.min.css">
        <link rel="stylesheet" type="text/css" href="../assets/vendors/css/pickers/daterange/daterangepicker.css">
        <link rel="stylesheet" type="text/css" href="../assets/vendors/css/pickers/pickadate/pickadate.css">



        <!--<link rel="stylesheet" type="text/css" href="../assets/vendors/css/forms/spinner/jquery.bootstrap-touchspin.css">-->
        <!-- END VENDOR CSS-->
        <!-- BEGIN STACK CSS-->
        <link rel="stylesheet" type="text/css" href="../assets/css/app.css">
        <!-- END STACK CSS-->
        <!-- BEGIN Page Level CSS-->
        <link rel="stylesheet" type="text/css" href="../assets/css/core/menu/menu-types/horizontal-menu.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/plugins/forms/validation/form-validation.css">

        <!-- END Page Level CSS-->
        <!-- BEGIN Custom CSS-->
        <link rel="stylesheet" type="text/css" href="../assets/css/plugins/forms/wizard.css">
        <link rel="stylesheet" type="text/css" href="../assets/css/plugins/pickers/daterange/daterange.css">

        <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
        <!-- END Custom CSS-->

    </head>

    <body data-open="click" data-menu="horizontal-menu" data-col="2-columns" class="horizontal-layout horizontal-menu 2-columns   menu-expanded">
        <!-- fixed-top-->
        <!--<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-light navbar-border navbar-brand-center">-->
        <nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
            <div class="navbar-wrapper">
                <div class="navbar-header">
                    <ul class="nav navbar-nav flex-row">
                        <li class="nav-item mobile-menu d-md-none mr-auto"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu font-large-1"></i></a></li>
                        <li class="nav-item">
                            <a href="index.html" class="navbar-brand">
                                <img alt="stack admin logo" src="../assets/images/logo/stack-logo-light.png"
                                     class="brand-logo">
                                <h2 class="brand-text">Stack</h2>
                            </a>
                        </li>
                        <li class="nav-item d-md-none">
                            <a data-toggle="collapse" data-target="#navbar-mobile" class="nav-link open-navbar-container"><i class="fa fa-ellipsis-v"></i></a>
                        </li>
                    </ul>
                </div>
                <div class="navbar-container container center-layout">
                    <div id="navbar-mobile" class="collapse navbar-collapse">
                        <ul class="nav navbar-nav mr-auto float-left">
                            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="ft-menu"></i></a></li>

                            <li class="nav-item d-none d-md-block"><a href="#" class="nav-link nav-link-expand"><i class="ficon ft-maximize"></i></a></li>
                        </ul>
                        <ul class="nav navbar-nav float-right">
                            <li class="dropdown dropdown-language nav-item">
                                <a id="dropdown-flag" href="#" data-toggle="dropdown" aria-haspopup="true"aria-expanded="false" class="dropdown-toggle nav-link">
                                    <i class="flag-icon flag-icon-gb"></i><span class="selected-language"></span></a>
                                <div aria-labelledby="dropdown-flag" class="dropdown-menu">
                                    <a href="#" class="dropdown-item"><i class="flag-icon flag-icon-gb"></i> English</a>
                                    <a href="#" class="dropdown-item"><i class="flag-icon flag-icon-fr"></i> French</a>
                                </div>
                            </li>

                            <li class="dropdown dropdown-notification nav-item">
                                <a href="#" data-toggle="dropdown" class="nav-link nav-link-label"><i class="ficon ft-bell"></i>
                                    <span class="badge badge-pill badge-default badge-danger badge-default badge-up">1</span>
                                </a>
                                <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                                    <li class="dropdown-menu-header">
                                        <h6 class="dropdown-header m-0">
                                            <span class="grey darken-2">Notifications</span>
                                            <span class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>
                                        </h6>
                                    </li>
                                    <li class="scrollable-container media-list">
                                        <a href="javascript:void(0)">
                                            <div class="media">
                                                <div class="media-left align-self-center"><i class="ft-file icon-bg-circle bg-teal"></i></div>
                                                <div class="media-body">
                                                    <h6 class="media-heading">Generate monthly report</h6>
                                                    <small>
                                                        <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">Last month</time>
                                                    </small>
                                                </div>
                                            </div>
                                        </a>
                                    </li>
                                    <li class="dropdown-menu-footer"><a href="javascript:void(0)" class="dropdown-item text-muted text-center">Read all notifications</a></li>
                                </ul>
                            </li>

                            <li class="dropdown dropdown-user nav-item">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link dropdown-user-link">
                                    <span class="avatar avatar-online">
                                        <img src="../assets/images/portrait/small/avatar-s-1.png" alt="avatar"><i></i></span>
                                    <span class="user-name">John Doe</span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="#" class="dropdown-item"><i class="ft-power"></i> Logout</a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Horizontal navigation-->
        <div role="navigation" data-menu="menu-wrapper" class="header-navbar navbar-expand-sm navbar navbar-horizontal navbar-fixed navbar-light navbar-without-dd-arrow navbar-shadow menu-border">
            <!-- Horizontal menu content-->
            <div data-menu="menu-container" class="navbar-container main-menu-content container center-layout">
                <!--include ../../../includes/mixins-->
                <ul id="main-menu-navigation" data-menu="menu-navigation" class="nav navbar-nav">

                    <li data-menu="megamenu" class="dropdown mega-dropdown nav-item"><a href="#" data-toggle="dropdown" class="dropdown-toggle nav-link"><i class="ft-bar-chart-2"></i><span>Charts &amp; Maps</span></a>
                        <ul class="mega-dropdown-menu dropdown-menu row">

                            <li data-mega-col="col-md-3" class="col-md-3">
                                <ul class="drilldown-menu">
                                    <li class="menu-list">
                                        <ul class="mega-menu-sub">
                                            <li><a href="#" class="dropdown-item"><i class="icon-bubble_chart"></i>Echarts</a>
                                                <ul class="mega-menu-sub">
                                                    <li>
                                                        <a href="echarts-line-area-charts.html" class="dropdown-item"><i class="undefined"></i>Line &amp; Area charts</a>
                                                    </li>
                                                    <li>
                                                        <a href="echarts-bar-column-charts.html" class="dropdown-item"><i class="undefined"></i>Bar &amp; Column charts</a>
                                                    </li>
                                                </ul>
                                            </li>
                                            <li><a href="#" class="dropdown-item"><i class="icon-pie-graph2"></i>Flot Charts</a>
                                                <ul class="mega-menu-sub">
                                                    <li>
                                                        <a href="flot-line-charts.html" class="dropdown-item"><i class="undefined"></i>Line charts</a>
                                                    </li>
                                                    <li><a href="flot-bar-charts.html" class="dropdown-item"><i class="undefined"></i>Bar charts</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>

                            <li data-mega-col="col-md-3" class="col-md-3">
                                <ul class="drilldown-menu">
                                    <li class="menu-list">
                                        <ul class="mega-menu-sub">
                                            <li><a href="morris-charts.html" class="dropdown-item"><i class="icon-graphic_eq"></i>Morris Charts</a>
                                            </li>

                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-mega-col="col-md-3" class="col-md-3">
                                <ul class="drilldown-menu">
                                    <li class="menu-list">
                                        <ul class="mega-menu-sub">
                                            <li><a href="#" class="dropdown-item"><i class="icon-stats-bars"></i>Chartist</a>
                                                <ul class="mega-menu-sub">
                                                    <li>
                                                        <a href="chartist-line-charts.html" class="dropdown-item"><i class="undefined"></i>Line charts</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                            <li data-mega-col="col-md-3" class="col-md-3">
                                <ul class="drilldown-menu">
                                    <li class="menu-list">
                                        <ul class="mega-menu-sub">
                                            <li><a href="#" class="dropdown-item"><i class="undefined"></i>Maps</a>
                                                <ul class="mega-menu-sub">
                                                    <li><a href="#" class="dropdown-item"><i class="undefined"></i>google Maps</a>
                                                        <ul class="mega-menu-sub">
                                                            <li>
                                                                <a href="gmaps-basic-maps.html" class="dropdown-item"><i class="undefined"></i>Maps</a>
                                                            </li>
                                                            <li>
                                                                <a href="gmaps-services.html" class="dropdown-item"><i class="undefined"></i>Services</a>
                                                            </li>
                                                        </ul>
                                                    </li>
                                                    <li>
                                                        <a href="vector-maps-jvector.html" class="dropdown-item"><i class="undefined"></i>jVector Map</a>
                                                    </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /horizontal menu content-->
        </div>
        <!-- Horizontal navigation-->
