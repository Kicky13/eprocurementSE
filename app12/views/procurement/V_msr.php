<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/>   
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">

<style>
    .top {
        overflow: hidden;
        position: fixed;
        top: 0;
        width: 100%;
        z-index: 100;
        padding-right: 230px;
        margin-top: 50px;
        margin-left: -12px;
    }

    .top a {
        float: left;
        display: block;
        text-align: center;
        padding: 14px 16px;
        text-decoration: none;
        font-size: 17px;     
    }

    #main {
        margin-top: 300px;
        height: 1500px;  
        width: 100%;
    }
</style>

<div class="top">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        MSR
                        <span class="pull-right" style="margin: -15px -10px">
                            <a id="up" style="color:white"><i class="fa fa-chevron-up"></i></a>
                            <a id="down" style="color:white"><i class="fa fa-chevron-down"></i></a>
                        </span>
                    </div>
                    <div class="panel-body" id="header_filter">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">                          
                                <form id="myForm" action="" method="post" class="form-horizontal" >      
                                    <input name="id" id="id" hidden>                            
                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4" >
                                        <h3><b><u><?= lang('HEADHER DATA', 'Main Grub') ?></u></b></h3>
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-4"><?= lang('Company', 'Main Grub') ?></label>
                                            <div class="col-md-8">
                                                <select type="text" name="indic_matrials" id="model" class="form-control" required>
                                                    <option>Muara Laboh</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-4"><?= lang('Dcoument Type', 'Main Grub') ?></label>
                                            <div class="col-md-8">
                                                <select id="doc_type" class="form-control" name="material_type" required>
                                                    <option value=""></option>
                                                    <option value="goods">MSR-Goods</option>
                                                    <option value="service">MSR-Service</option>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-4"><?= lang('Title', 'Main Grub') ?></label>
                                            <div class="col-md-8">
                                                <textarea name="" id="input" class="form-control" rows="3" required="required"></textarea>
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-4"></label>
                                            <div class="col-md-8">

                                            </div>
                                        </div>       
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-4"><?= lang('Department', 'Main Grub') ?></label>
                                            <div class="col-md-8">
                                                <select id="material_type" class="form-control" name="material_type" required onChange="aktif_form2()">
                                                    <option value="">Reservoir Enggineer</option>                                            
                                                </select>
                                            </div>
                                        </div>      
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-4"><?= lang('Required Date', 'Model') ?></label>
                                            <div class="col-md-8">
                                                <select type="text" name="model" id="model" class="form-control" required></select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-4"><?= lang('Leadtime', 'Model') ?></label>
                                            <div class="col-md-5">
                                                <input type="text" name="model" id="model" class="form-control" required></input>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-4"><?= lang('Currency', 'Model') ?></label>
                                            <div class="col-md-8">
                                                <select type="text" name="model" id="model" class="form-control" required></select>
                                            </div>
                                        </div>  
                                    </div>

                                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">	
                                        <div class="form-group">                                        
                                            <div class="i-checks col-md-12 ">
                                                <label for="name" class="label-control col-md-8"><?= lang('Purchasing group', 'Part No') ?></label><br/>
                                                <label><input type="radio" value="" name="KATEGORI"> Center Of Procurement</label><br/>
                                                <label><input type="radio" value="" name="KATEGORI"> Branch Procurement </label><br/>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="name" class="label-control col-md-12"><?= lang('Procurement Method', 'Part No') ?></label>
                                            <br/>
                                            <div class="i-checks col-md-12">
                                                <label><input type="radio" value="" name="KATEGORI"> DA (Direct Appoinment) </label><br/>
                                                <label><input type="radio" value="" name="KATEGORI"> DS (Direct Selection) </label><br/>
                                                <label><input type="radio" value="" name="KATEGORI"> Tender </label><br/>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="main">
    <div id="service_form" hidden>
        <?php
        $this->load->view('procurement/V_msr_service_form')
        ?>
    </div>
    <div id="goods_form" hidden>
        <?php
        $this->load->view('procurement/V_msr_goods_form')
        ?>
    </div>
    <div id="goods" hidden>
        <?php
        $this->load->view('procurement/V_msr_goods')
        ?>
    </div>
    <div id="service" hidden>
        <?php
        $this->load->view('procurement/V_msr_service')
        ?>
    </div>
</div>

<script type="text/javascript">

    $(function () {
        $("#down").hide();
        $("#up").click(function () {
            $("#header_filter").hide('fast');
            $("#down").show();
            $("#up").hide();
            document.getElementById("main").style.marginTop = "70px";
        });
        $("#down").click(function () {
            $("#header_filter").show('fast');
            $("#up").show();
            $("#down").hide();
            document.getElementById("main").style.marginTop = "300px";
        });
        $("#doc_type").change(function () {
            var dt = $("#doc_type").val();
            if (dt == 'goods') {
                $('#goods').show('fast');
                $('#goods_form').show('fast');
                $('#service').hide();
                $('#service_form').hide();
            } else if (dt == 'service') {
                $('#service').show('fast');
                $('#service_form').show('fast');
                $('#goods').hide();
                $('#goods_form').hide();
            } else {
                msg_danger('Harap pilih tipe yg benar!');
            }
        });
        $(".touchspin3").TouchSpin({
            verticalbuttons: true,
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('#form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('material/registration/change') ?>',
                data: $('#form').serialize(),
                success: function (m) {
                    if (m == 'sukses') {
                        $('#modal').modal('hide');
                        $('#tbl').DataTable().ajax.reload();
                        msg_info('Sukses tersimpan');
                    } else {
                        msg_danger(m);
                    }
                }
            });
        });
    });
    function filter() {
        $('.modal-filter').html("<?= lang("Filter Data", "Filter Data") ?>");
        $('#total').text("dari " + "<?= (isset($total) != false ? $total : '0') ?>" + " Data");
        $('#modal-filter').modal('show');
        lang();
    }
    // select 2 <-
</script>

<script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>        
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script> 
<script src="<?= base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>     
<script src="<?= base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script> 
<script src="<?= base_url() ?>ast11/filter/scripts.js" type="text/javascript"></script> 
