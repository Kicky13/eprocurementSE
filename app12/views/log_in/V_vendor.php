<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="PIXINVENT">
        <title>Login Account - Supreme </title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("ast11/img/supreme.png") ?>">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
              rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/vendors.css">

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/app.css">

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/pages/login-register.css">

        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/assets/css/style.css">
        <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/extensions/toastr.css">
        <!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/extensions/toastr.css">-->

    </head>
    <body data-open="click" data-menu="vertical-menu" data-col="1-column" class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page">
        <div class="app-content content">
            <div class="content-wrapper">
                <div class="content-header row">
                </div>
                <div class="content-body">
                    <section class="flexbox-container">
                        <div class="col-12 d-flex align-items-center justify-content-center">
                            <div class="col-md-4 col-10 box-shadow-2 p-0">
                                <div class="card border-grey border-lighten-3 px-2 py-2 m-0">
                                    <div class="card-header border-0">
                                        <div class="card-title text-center">
                                            <img src="<?=base_url()?>ast11/img/logo-supreme2.png" style="width:80%; height:auto;" alt="branding logo">
                                        </div>
                                        <h6 class="card-subtitle line-on-side text-muted text-center font-small-3 pt-2">
                                            <span>Login Account</span>
                                        </h6>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form-horizontal form-simple" id="form_login" novalidate>
                                                <input value="<?= $url ?>" name="url" hidden>
                                                <fieldset class="form-group position-relative has-icon-left mb-1">
                                                    <input type="text" class="form-control form-control-lg input-lg" id="username" name="username" placeholder="Username" size="60">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left">
                                                    <input type="password" class="form-control form-control-lg input-lg" id="password" name="password" placeholder="Enter Password" size="60">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left mb-1">
                                                    <select id="bahasa" class="chosen-select form-control m-b" value="IDN" name="lang">
                                                        <!--<option value="IDN"><a href="#">Bahasa Indonesia</a></option>-->
                                                        <option value="ENG"><a href="#">English</a></option>
                                                    </select>
                                                    <div class="form-control-position">
                                                        <i class="fa fa-flag"></i>
                                                    </div>
                                                </fieldset>
                                                <div class="row mb-1">
                                                    <div class="col-sm-6">
                                                        <div id="ch" class="form-group" style="padding-left:0px">
                                                            <?= $image; ?>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="input-group">
                                                            <input type="text" name="chaptcha" style="height:60px" class="form-control" size="10" value="">
                                                            <span class="input-group-btn">
                                                                <button type="button" style="height:60px" class="btn btn-primary refresh">
                                                                    <i class="fa fa-refresh"></i>
                                                                </button>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr>
                                                <button type="submit" class="btn btn-primary btn-lg btn-block"><i class="ft-unlock"></i>Login</button>
                                            </form>
                                        </div>
                                        <!--<p class="text-center">Already have an account ? <a href="login-simple.html" class="card-link">Login</a></p>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <!-- BEGIN VENDOR JS-->
        <script src="<?= base_url() ?>ast11/app-assets/js/core/libraries/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
        <!--<script src="<?= base_url() ?>ast11/app-assets/js/scripts/extensions/toastr.js" type="text/javascript"></script>-->
        <script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"></script>

        <script src="<?= base_url() ?>ast11/app-assets/js/core/app-menu.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/core/app.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
        <!-- END PAGE LEVEL JS-->
    </body>
</html>

<script>
//    toastr.warning('dd', "Warning");
    $(function () {
        $('.ENG').hide();
        $('#bahasa').change(function () {
            $dt = $('#bahasa').val();
            if ($dt === "IDN")
            {
                $('.ENG').hide();
                $('.IDN').show();
            }
            else
            {
                $('.IDN').hide();
                $('.ENG').show();
            }
        });
        $(".refresh").click(function () {
            jQuery.ajax({
                type: "POST",
                url: "<?= base_url(); ?>" + "log_in/captcha_refresh",
                success: function (res) {
                    if (res)
                    {
                        $("#ch").html(res);
                    }
                }
            });
        });
        var l = $('.ladda-button-demo');
        // .ladda();
        $('#form_login').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('log_in/cek_login') ?>',
                data: $('#form_login').serialize(),
                success: function (m) {
                    if (m == 'sukses') {
                        document.location.href = "<?= base_url('vn/info/greetings') ?>"
                    } else {
                        toastr.warning(m, "Warning");
                    }
                }
            });
        });
    });
</script>
</body>
</html>
