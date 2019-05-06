<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/swal.css">
<footer class="footer footer-static footer-light navbar-border">
    <p class="clearfix blue-grey lighten-1 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"> Copyright  &copy; <span class="brand-text" style="margin-top: 50px; color: #337ab7; font-weight: bold; font-size: 18px">supre<span style="color: #ff3333">m</span>e energy</span> <?= date("Y"); ?></span><span class="float-md-right d-block d-md-inline-blockd-none d-lg-block"> All rights reserved.</span></p>
    <!-- <p class="clearfix blue-grey lighten-2 text-sm-center mb-0 px-2"><span class="float-md-left d-block d-md-inline-block"> <a href="#" class="text-bold-800 grey darken-2">PT. SUPREME ENERGY</a>, All rights reserved. </span><span class="float-md-right d-block d-md-inline-blockd-none d-lg-block">Copyright  &copy; <?= date("Y"); ?></span></p> -->
</footer>

<!-- <script src="<?= base_url() ?>ast11/assets_lm/js/bootstrap.min.js"></script> -->
<!-- <script src="<?= base_url() ?>ast11/js/plugins/staps/jquery.steps.min.js"></script> -->
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/extensions/jquery.steps.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/js/plugins/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/js/plugins/validation/additional-methods.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/js/plugins/validation/form-validation.js" type="text/javascript"></script>

<script src="<?= base_url() ?>ast11/app-assets/vendors/js/bootbox/bootbox.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/action-column/action-column.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/jquery-number/jquery.number.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/localization/indonesia.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/localization/localization.js" type="text/javascript"></script>

<script src="<?= base_url() ?>ast11/app-assets/js/core/app-menu.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/core/app.js" type="text/javascript"></script>

<script src="<?= base_url() ?>ast11/js/plugins/sweetalert/sweetalert.min.js"></script>
<script src="<?= base_url() ?>ast11/pnotify/pnotify.custom.min.js"></script>
<script src="<?= base_url() ?>ast11/js/pnotify.custom.js"></script>



<?=isset($js) ? $js : ""?>

<script type="text/javascript">
    $(function() {
        if ($('#main-menu-navigation a[href="'+window.location.href+'"]')) {
            $('#main-menu-navigation a[href="'+window.location.href+'"]').parent().addClass('active');
            $('#main-menu-navigation a[href="'+window.location.href+'"]').parent().parent().show();
            $('#main-menu-navigation a[href="'+window.location.href+'"]').parent().parent().parent().addClass('open');
        }
    });
</script>

<script>
function coalesce(str, to) {
    if (str == null || str  == '') {
        if (to) {
            return to;
        } else {
            return '';
        }
    } else {
        return str;
    }
}

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
