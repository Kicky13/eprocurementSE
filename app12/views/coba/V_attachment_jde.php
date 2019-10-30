
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>WYMeditor</title>
    <link rel="stylesheet" href="<?=base_url('ast11/js/plugins/wymeditor-master/dist/')?>/wymeditor/skins/default/skin.css">
</head>

<body>
    <h1>WYMeditor integration example</h1>
    <p><a href="http://www.wymeditor.org/">WYMeditor</a> is a web-based XHTML WYSIWYM editor.</p>
    <form method="post" action="">
        <textarea class="wymeditor"><?=$attachment?></textarea>
        <input type="submit" class="wymupdate" />
    </form>

    <!--for IE8, ES5 shims are required-->
    <!--[if IE 8]>
    <script src="vendor/es5-shim.js"></script>
    <script src="vendor/es5-sham.js"></script>
    <![endif]-->

    <script src="<?=base_url('ast11/js/plugins/wymeditor-master/dist/examples')?>/vendor/jquery/jquery.js"></script>
    <script src="<?=base_url('ast11/js/plugins/wymeditor-master/dist/')?>/wymeditor/jquery.wymeditor.js"></script>
    <script type="text/javascript">
        /* Here we replace each element with class 'wymeditor'
         * (typically textareas) by a WYMeditor instance.
         *
         * We could use the 'html' option, to initialize the editor's content.
         * If this option isn't set, the content is retrieved from
         * the element being replaced.
         */
        $(function() {
            $('.wymeditor').wymeditor();
        });
    </script>
</body>
</html>
