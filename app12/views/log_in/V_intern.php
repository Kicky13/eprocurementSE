<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta name="description" content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="PIXINVENT">
        <title>Login Supreme</title>
        <link rel="shortcut icon" type="image/x-icon" href="<?= base_url("ast11/img/supreme.png") ?>">
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
              rel="stylesheet">

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/app-assets/css/vendors.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/app-assets/vendors/css/extensions/toastr.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/app-assets/css/plugins/extensions/toastr.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/app-assets/css/app.css">

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/app-assets/css/core/menu/menu-types/vertical-menu.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/app-assets/css/core/colors/palette-gradient.css">
        <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/app-assets/css/pages/login-register.css">

        <link rel="stylesheet" type="text/css" href="<?=base_url()?>ast11/assets/css/style.css">
        <style>
            img{
                height:60px;
                width:100%;
            }
        </style>
    </head>
    <body data-open="click" data-menu="vertical-menu" data-col="1-column" class="vertical-layout vertical-menu 1-column menu-expanded blank-page">

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
                                            <span><?= lang("Login Akun", "Login Account") ?></span>
                                        </h6>
                                    </div>
                                    <div class="card-content">
                                        <div class="card-body">
                                            <form class="form-horizontal form-simple" id="login" >
                                                <fieldset class="form-group position-relative has-icon-left mb-1">
                                                    <input type="text" class="form-control form-control-lg input-lg" id="username" name="username" placeholder="Account Name">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-user"></i>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left mb-1">
                                                    <input type="password" class="form-control form-control-lg input-lg" id="user-password"
                                                           placeholder="Enter Password" name="password">
                                                    <div class="form-control-position">
                                                        <i class="fa fa-key"></i>
                                                    </div>
                                                </fieldset>
                                                <fieldset class="form-group position-relative has-icon-left mb-1">
                                                    <select id="bahasa" class="chosen-select form-control m-b" value="IDN">
                                                        <!-- <option value="IND"><a href="#">Bahasa Indonesia</a></option> -->
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
                                                            <input type="text" name="chaptcha" style="height:60px" class="form-control" value="">
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
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
        <script src="<?=base_url()?>ast11/app-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
        <script src="<?=base_url()?>ast11/app-assets/vendors/js/vendors.min.js" type="text/javascript"></script>
        <script src="<?=base_url()?>ast11/app-assets/vendors/js/extensions/toastr.min.js" type="text/javascript"></script>
        <script src="<?=base_url()?>ast11/app-assets/js/scripts/extensions/toastr.js" type="text/javascript"></script>
        <script src="<?=base_url()?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js"type="text/javascript"></script>

        <script src="<?=base_url()?>ast11/app-assets/js/core/app-menu.js" type="text/javascript"></script>
        <script src="<?=base_url()?>ast11/app-assets/js/core/app.js" type="text/javascript"></script>

        <script src="<?=base_url()?>ast11/app-assets/js/scripts/forms/form-login-register.js" type="text/javascript"></script>
        <script src="<?= base_url() ?>ast11/js/global_function.js"></script>
        <script>
            function lang() {
                $('.ENG').hide();
            }
            $(function () {
                lang();
                $(".refresh").click(function () {
                    jQuery.ajax({
                        type: "POST",
                        url: "<?= base_url(); ?>" + "log_in_in/captcha_refresh",
                        success: function (res) {
                            if (res)
                            {
                                $("#ch").html(res);
                            }
                        }
                    });
                });
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
                $('#login').on('submit', function (e) {
                    e.preventDefault();
                    var obj = {};
                    var xmodalx = modal_start($(".content-body").find(".card"));
                    $.each($("#login").serializeArray(), function (i, field) {
                        obj[field.name] = field.value;
                    });
                    obj.lang = $('#bahasa').val();
                    $.ajax({
                        type: 'POST',
                        url: '<?= base_url('log_in_in/cek_login') ?>',
                        data: obj,
                        success: function (m) {
                            console.log(m);
                            if (m == 'sukses') {
                                // modal_stop(xmodalx);
                                document.location.href = '<?= base_url('home') ?>';
                            } else {
                                modal_stop(xmodalx);
                                setTimeout(function () {
                                    toastr.options = {
                                        closeButton: true,
                                        progressBar: true,
                                        showMethod: 'slideDown',
                                        timeOut: 4000
                                    };
                                    toastr.warning(m, 'Warning');
                                }, 100);
                            }
                        }
                    });
                });
            });
        </script>
    </body>
</html>
