            </div>
        </div>
        <div data-scroll-to-active="true" class="main-menu menu-fixed menu-light menu-accordion menu-shadow" style="padding-bottom: 100px;">
            <div class="main-menu-header">
                <input type="text" placeholder="Search" class="menu-search form-control round"/>
            </div>
            <div class="main-menu-content">
                <!--<ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main">
                    <?php foreach ($this->config->item('dashboard') as $key => $dashboard) { ?>
                        <li class="nav-item"><a href="<?= base_url('dashboard/home/'.$key) ?>"><i class="fa fa-line-chart"></i> <?= $dashboard['menu'] ?></a></li>
                    <?php } ?>                    
                </ul>-->
                <?php if (isset($filters)) { ?>
                    <?php $this->load->view('dashboard/partials/filter', array('filters' => $filters)) ?>
                <?php } ?>
            </div>
        </div>
        <footer class="footer footer-static footer-light navbar-border">
            <p class="clearfix blue-grey lighten-1 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"> Copyright  &copy; <span class="brand-text" style="margin-top: 50px; color: #337ab7; font-weight: bold; font-size: 18px">supre<span style="color: #ff3333">m</span>e energy</span> <?= date("Y"); ?></span><span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"> All rights reserved.</span></p>
        </footer>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/datatables.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/charts/echarts/echarts.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/core/app-menu.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/core/app.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/jquery-number/jquery.number.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/localization/indonesia.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/localization/localization-dashboard.js" type="text/javascript"></script>
        <?=isset($js) ? $js : ""?>
        <script>
            $(document).ready(function() {
                function id(v){ return document.getElementById(v); }
                function loadbar() {
                    var ovrl = id("overlay"),
                    prog = id("loader"),
                    img = document.images,
                    c = 0,
                    tot = img.length;
                    ovrl.style.opacity = 0;
                    setTimeout(function(){
                        ovrl.style.display = "none";
                    }, 1200);
                }
            });

            $(window).on('load', function() {
                $('#overlay').css('opacity', 0);
                $('#overlay').css('z-index', -1);
                setTimeout(function(){
                    $("#loadingdiv").hide();
                    $("#overlay").hide();
                }, 1300)
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
                  message: '<div class="semibold container">'+
                            '<div id="" class="ring blue"></div>'+
                            '<div id="content">'+
                                '<span class="brand-text" style="margin-top: 50px; color: #337ab7; font-weight: bold; font-size: 16px">supre<span style="color: #ff3333">m</span>e energy</span>'+
                            '</div>'+
                        '</div>',
                    overlayCSS: {
                        backgroundColor: '#000000',
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
                    } else {
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

                $("#notif").on('click', function(e) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('vendor/all_intern/update_notif'); ?>",
                        cache: false,
                        success: function (res) {
                            $(".badgetotal").html("0");
                        }
                    });
                });

                $("#messages").on('click', function(e) {
                    $.ajax({
                        type: "POST",
                        url: "<?= site_url('vendor/all_intern/update_notif_msg'); ?>",
                        cache: false,
                        success: function (res) {
                            $(".badgetotalmsg").html("0");
                        }
                    });
                });
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
        </script>
        <script>
            $(function() {
                $('#menu-toggle').click(function() {
                    if ($('#filter-container').hasClass('close')) {
                        $('#filter-container').removeClass('close').show()
                    } else {
                        $('#filter-container').addClass('close').hide()
                    }
                });
            });
            function toFloat(value) {
                value = parseFloat(value);
                if (!$.isNumeric(value)) {
                    return 0;
                } else {
                    return value;
                }
            }
        </script>
    </body>
</html>
