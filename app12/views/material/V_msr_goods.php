<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= lang("Filter", "Registrasi Material") ?></h5>
                    <h5 class="title pull-right" style="margin:-10px -5px">
<!--                        <a data-toggle="modal" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></a>
                        <a data-toggle="modal" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></a>                     -->
                    </h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <form id="myForm" action="" method="post" class="form-horizontal">
                                <input name="id" id="id" hidden>
                                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                                    <div class="form-group">
                                        <label for="name" class="label-control col-md-4"><?= lang('Company', 'Main Grub') ?></label>
                                        <div class="col-md-8">
                                            <select id="material_type" name="material_type" required onChange="aktif_form2()">
                                                <option value="">Muara Laboh</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="label-control col-md-4"><?= lang('Title', 'Main Grub') ?></label>
                                        <div class="col-md-8">
                                            <input type="text" name="equipement_no" id="equipment_no" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="name" class="label-control col-md-4"><?= lang('Required Date', 'Model') ?></label>
                                        <div class="col-md-8">
                                            <select type="text" name="model" id="model" class="form-control" required></select>
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
                                        <label for="name" class="label-control col-md-4"><?= lang('Dcoument Type', 'Main Grub') ?></label>
                                        <div class="col-md-8">
                                            <select id="material_type" class="form-control" name="material_type" required onChange="aktif_form2()">
                                                <option value="">MSR-Goods</option>
                                            </select>
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
                                        <label for="name" class="label-control col-md-4"><?= lang('Procurement Method', 'Part No') ?></label>
                                        <br/>
                                        <div class="i-checks col-md-12">
                                            <label><input type="radio" value="" name="KATEGORI"> DA (Direct Appoinment) </label><br/>
                                            <label><input type="radio" value="" name="KATEGORI"> DS (Direct Selection) </label><br/>
                                            <label><input type="radio" value="" name="KATEGORI"> Tender </label><br/>
                                        </div>
                                    </div>
                                    <label for="name" class="label-control col-md-12"><?= lang('Upload Document', 'Model') ?></label><br/>
                                    <div class="form-group">
                                        <label for="name" class="label-control col-md-4"><?= lang('Risk Assesment', 'Model') ?></label>
                                        <div class="col-md-8">
                                            <label title="Upload file" for="file_akta" class="btn btn-default">
                                                Upload File
                                                <input type="file" id="file_akta" name="file_akta" class="hide">
                                            </label>
                                        </div>
                                        <label for="name" class="label-control col-md-4"><?= lang('Justification Document', 'Model') ?></label>
                                        <div class="col-md-8">
                                            <label title="Upload file" for="file_akta" class="btn btn-default">
                                                Upload File
                                                <input type="file" id="file_akta" name="file_akta" class="hide">
                                            </label>
                                        </div>
                                    </div>
                                   <div class="form-group">
                                        <label for="name" class="label-control col-md-4"><?= lang('Leadtime', 'Main Grub') ?></label>
                                        <div class="col-md-8">
                                            <input type="text" name="equipement_no" id="equipment_no" class="form-control" required>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <br><hr>
                    <table id="tbl" class="table table-striped table-bordered table-hover display" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th rowspan="2">No</th>
                                <th rowspan="2"><center><?= lang('Semic NO', 'Material Number') ?></center></th>
                        <th rowspan="2"><center><?= lang("Description of Units", "Description") ?></center></th>
                        <th rowspan="2"><center>Main Group</center></th>
                        <th rowspan="2"><center>Sub Group</center></th>
                        <th rowspan="2"><center>QTY</center></th>
                        <th rowspan="2"><center>UOM</center></th>
                        <th colspan="2"><center>Stock Status</center></th>
                        <th rowspan="2"><center>Estimate Unit Price</center></th>
                        <th rowspan="2"><center>Estimate Total Amount</center></th>
                        <th rowspan="2"><center>CUR</center></th>
                        <th rowspan="2"><center>Costcenter</center></th>
                        <th rowspan="2"><center>Branch/Plant</center></th>
                        <th rowspan="2"><center>Delivery Term</center></th>
                        <th rowspan="2"><center>Importation</center></th>
                        </tr>
                        <tr>
                            <th><center><?= lang("ON HAND", "UOM") ?></center></th>
                        <th><center><?= lang('ON ORDER', 'QTY') ?></center></th>
                        </tr>
                        </thead>
<!--                        <tbody>
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td>TOTAL (excl. VAT)</td>
                                <td>5.000.000</td>
                                <td>IDR</td>

                            </tr>
                        </tbody>-->
                    </table>
                    <label class="form-group" style="font-weight:500" id="info">Showing <?= (isset($total) != false ? ($total >= 1 ? "1" : 0) : '0') ?> to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-filter"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label for="name" class="label-control col-md-4"><?= lang('Indicator materials', 'Model') ?></label>
                            <div class="col-md-8">
                                <select type="text" name="indic_matrials" id="model" class="form-control" required></select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="name" class="label-control col-md-4"><?= lang('Delivery Point', 'Model') ?></label>
                            <div class="col-md-8">
                                <select type="text" name="indic_matrials" id="model" class="form-control" required>
                                    <option>Muara Laboh</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="label-control col-md-4"><?= lang('Request for', 'Model') ?></label>
                            <div class="col-md-8">
                                <select type="text" name="indic_matrials" id="model" class="form-control" required>
                                    <option>Immediate Use</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="label-control col-md-4"><?= lang('Delivery term', 'Model') ?></label>
                            <div class="col-md-8">
                                <select type="text" name="indic_matrials" id="model" class="form-control" required>
                                    <option>DDP(Del.At Place)</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="label-control col-md-4"><?= lang('Importation', 'Model') ?></label>
                            <div class="col-md-8">
                                <select type="text" name="indic_matrials" id="model" class="form-control" required>
                                    <option>Imported</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="label-control col-md-4"><?= lang('Inspection', 'Model') ?></label>
                            <div class="col-md-8">
                                <select type="text" name="indic_matrials" id="model" class="form-control" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="name" class="label-control col-md-4"><?= lang('Freight', 'Model') ?></label>
                            <div class="col-md-8">
                                <select type="text" name="indic_matrials" id="model" class="form-control" required>
                                    <option></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" onclick="get()" data-dismiss="modal" class="btn btn-info" id="save"><?= lang('Filter', 'Filter') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--change data-->

<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form" class="form-horizontal">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-filter"></h4>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="form-label col-md-6" for="field-1">Material</label>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Deskripsi", "Description") ?></label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_matr" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_desc" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Deskripsi Lengkap", "Long Description") ?></label>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Grup Material", "Material Group") ?></label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_long" multiple data-role="tagsinput">
                                </select>
                            </div>

                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_group" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Tipe Material", "Material Type") ?></label>
                            <label class="form-label col-md-6" for="field-1">UOM Material</label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-12" for="field-1"><?= lang("Batas Data", "Limit Data") ?></label>
                            <div class="col-md-12 m-b">
                                <div class="input-group">
                                    <input class="touchspin3" type="text" value="100" id="limit" name="demo3">
                                    <span class="input-group-addon" id="total"></span>
                                </div>
                            </div>
                            <label class="form-label col-md-12" for="field-1">Status</label>
                            <div class="col-md-12">
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="aktif" id="status1"> <i></i> <?= lang("Aktif", "Active") ?> </label>
                                </div>
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="tidak" id="status2"> <i></i> <?= lang("Tidak Aktif", "NotActive") ?> </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" onclick="get()" data-dismiss="modal" class="btn btn-info" id="save"><?= lang('Filter', 'Filter') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(function () {
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
                        msg_info('Save successfuly');
                    } else {
                        msg_danger('Oops, Something Wrong!');
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
    function get()
    {
        var matr = $('#search_matr').val();
        var desc = $('#search_desc').val();
        var long = $('#search_long').val();
        var group = $('#search_group').val();
        var type = $('#search_type').val();
        var uom = $('#search_uom').val();
        var obj = {};

        obj.limit = $('#limit').val();
        if ($('#status1').is(":checked"))
            obj.status1 = 1;
        else
            obj.status1 = "none";
        if ($('#status2').is(":checked"))
            obj.status2 = 0;
        else
            obj.status2 = "none";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('material/registration/filter_data'); ?>",
            data: obj,
            cache: false,
            success: function (res)
            {
                $('#tbl').DataTable().clear().draw();
                $('#tbl').DataTable().rows.add(res).draw();
                var tamp = 0;
                if (res.length > 0)
                    tamp = 1;
                $('#info').text("Showing " + tamp + " to " + res.length + " data from " +<?= (isset($total) != false ? $total : '0') ?>)
            }
        })
    }
    function add() {
        document.getElementById("form").reset();
        lang();
    }

    function update(id) {
    }

    $('#tbl').DataTable({
        scrollX: true,
        scrollY: '300px',
        info: false,
        searching: false,
        scrollCollapse: true,
        paging: false,
        info: false,
                "columnDefs": [
                    {"className": "dt-right", "targets": [0]},
//            {"className": "dt-right", "targets": [3]},
                    {"className": "dt-center", "targets": [4]}
                ]
    });
    lang();
// select2 ->
    jQuery(function ($) {

        if ($.isFunction($.fn.select2)) {

            $("#group_material").select2({
                placeholder: 'select',
                required: true,
                allowClear: true
            }).on('select2-open', function () {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                $('#tbl').DataTable().ajax.reload();
            });
            $("#material_type").select2({
                required: true,
                placeholder: 'select',
                allowClear: true
            }).on('select2-open', function () {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                $('#tbl').DataTable().ajax.reload();
            });
            $("#material_uom").select2({
                placeholder: 'select',
                required: true,
                allowClear: true
            }).on('select2-open', function () {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                $('#tbl').DataTable().ajax.reload();
            });
        }
    });
    // select 2 <-
</script>

<script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/filter/scripts.js" type="text/javascript"></script>
