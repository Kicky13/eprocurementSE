<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/>

<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Master Konversi Material", "Master Material Convertion") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Konversi Material", "Material Convertion") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card-header">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <div class="heading-elements">
                                            <h5 class="title pull-right">
                                                <!--<button aria-expanded="false" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button>-->
                                                <button aria-expanded="false" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "CREATE") ?></button>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <!-- <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                            </table> -->
                                            <table id="tbl" class="table nowrap table-striped table-bordered table-hover display" cellspacing="0" width="100%">
                                                <thead>
                                                    <tr>
                                                         <th rowspan="2">No</th>
                                                        <th rowspan="2" ><center><?= lang('Material', 'Material Number') ?></center></th>
                                                        <th rowspan="2"><center><?= lang("Deskripsi", "Description") ?></center></th>
                                                        <th colspan="2"><center>From</center></th>
                                                        <th colspan="2"><center>T0</center></th>
                                                        <th colspan="2"></th>
                                                    </tr>
                                                    <tr>

                                                        <th><center><?= lang("UOM", "UOM") ?></center></th>
                                                        <th><center><?= lang('QTY', 'QTY') ?></center></th>
                                                        <th><center><?= lang("UOM", "UOM") ?></center></th>
                                                        <th><center><?= lang("To QTY", "To QTY") ?></center></th>
                                                        <th>Status</th>
                                                        <th><center>Action</center></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th>No</th>
                                                        <th><center><?= lang('Material', 'Material Number') ?></center></th>
                                                        <th><center><?= lang("Deskripsi", "Description") ?></center></th>
                                                        <th><center><?= lang("UOM", "UOM") ?></center></th>
                                                        <th><center><?= lang('QTY', 'QTY') ?></center></th>
                                                        <th><center><?= lang("UOM", "UOM") ?></center></th>
                                                        <th><center><?= lang("To QTY", "To QTY") ?></center></th>
                                                        <th>Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <label class="form-group" style="font-weight:300" id="info">Showing 1 to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<!--change data-->
<div id="modal" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header bg-primary white">
              <h4 class="modal-title"></h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
              </button>
          </div>
            <div class="modal-body">
                <form id="form" class="form-horizontal">
                    <!--hide value-->
                    <input name="id" id="id" hidden>
                    <!--end hide value-->
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?= lang('Material', 'Material') ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="mat_material" id="mat_material" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label"><?= lang('Deskripsi', 'Description') ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="desc" id="desc" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label"><?= lang('From UOM', 'From UOM') ?></label>
                        <div class="col-sm-9">
                            <select id="from_uom" name="from_uom" class=""  placeholder="" type="text" required >
                                <option value=""></option>
                                <?php
                                $uom = $this->db->get("m_material_uom where STATUS = '1'");
                                foreach ($uom->result() as $value) {
                                    ?>
                                    <option value="<?php echo $value->MATERIAL_UOM; ?>"><?php echo $value->MATERIAL_UOM; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?= lang('From QTY', 'From QTY') ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="from_qty" id="from_qty" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputPassword3" class="col-sm-3 control-label"><?= lang('To UOM', 'To UOM') ?></label>
                        <div class="col-sm-9">
                            <select id="to_uom" name="to_uom" class="" placeholder="" type="text" required >
                                <option value=""></option>
                                <?php
                                $uom = $this->db->get("m_material_uom where STATUS = '1'");
                                foreach ($uom->result() as $value) {
                                    ?>
                                    <option value="<?php echo $value->MATERIAL_UOM; ?>"><?php echo $value->MATERIAL_UOM; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label"><?= lang('To QTY', 'To QTY') ?></label>
                        <div class="col-sm-9">
                            <input type="text" name="to_qty" id="to_qty" class="form-control" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-sm-3 control-label">Status</label>
                        <div class="col-sm-9">
                            <input type="radio" value="1" name="status" id="aktif"> <i></i><?= lang('Aktif', 'Active') ?>
                            &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="0" name="status" id="nonaktif"> <i></i><?= lang('Nonaktif', 'Nonactive') ?>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </div>
    </div>
</div>
<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form" class="form-horizontal">
              <div class="modal-header bg-primary white">
                  <h4 class="modal-filter"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
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
                            <label class="form-label col-md-6" for="field-1"><?= lang("Dari UOM", "From UOM") ?></label>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Ke UOM", "To UOM") ?></label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_from_uom" multiple data-role="tagsinput">
                                </select>
                            </div>

                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_to_uom" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Dari QTY", "From QTY") ?></label>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Ke QTY", "To QTY") ?></label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_from_qty" multiple data-role="tagsinput">
                                </select>
                            </div>

                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_to_qty" multiple data-role="tagsinput">
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
                url: '<?= base_url('material/uom_conversion/change') ?>',
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
        $('#tbl tfoot th').each( function (i) {
            var title = $('#tbl thead th').eq( $(this).index() ).text();
            if ($(this).text() == 'No') {
              $(this).html('');
            } else if ($(this).text() == 'Action') {
              $(this).html('');
            } else {
              $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
            }
        });
        var table=$('#tbl').DataTable({
            ajax: {
                url: '<?= base_url('material/uom_conversion/show') ?>',
                dataSrc: ''
            },
            scrollX: true,
            info:false,
            scrollY: '300px',
            scrollCollapse: true,
            paging: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            columns: [
                {title: "<center>No</center>"},
                {title: "<center><?= lang('Material', 'Material Number') ?></center>"},
                {title: "<center><?= lang("Deskripsi", "Description") ?></center>"},
                {title: "<center><?= lang("UOM", "UOM") ?></center>"},
                {title: "<center><?= lang('QTY', 'QTY') ?></center>"},
                {title: "<center><?= lang("UOM", "UOM") ?></center>"},
                {title: "<center><?= lang("QTY", "QTY") ?></center>"},
                {title: "<center>Status</center>"},
                {title: "<center>Action</center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
                {"className": "dt-center", "targets": [7]},
                {"className": "dt-center", "targets": [8]}
            ]
        });
        $( table.table().container() ).on( 'keyup', 'tfoot input', function () {
            table.column( $(this).data('index') )
            .search( this.value )
            .draw();
        } );
        lang();
    });

    function add() {
        document.getElementById("form").reset();
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
         $('#modal .modal-header').css('background-color',"#1c84c6");
        $('#modal .modal-header').css('color',"#fff");
        $('#modal').modal('show');
        $('#id').val("");
        document.getElementById("aktif").checked = true;
        lang();
    }

    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('material/uom_conversion/get/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#mat_material').val(d.MATERIAL);
                $('#desc').val(d.DESCRIPTION);
                $('#from_uom').val(d.FROM_UOM);
                $('#from_qty').val(d.FROM_QTY);
                $('#to_uom').val(d.TO_UOM);
                $('#to_qty').val(d.TO_QTY);
                if (d.STATUS == "1") {
                    document.getElementById("aktif").checked = true;
                } else {
                    document.getElementById("nonaktif").checked = true;
                }
                $('#modal .modal-header').css('background-color',"#1ab394");
                $('#modal .modal-header').css('color',"#fff");
                $('#modal').modal('show');
                lang();
            }
        });

    }
// select2 ->
    jQuery(function ($) {

        if ($.isFunction($.fn.select2)) {
            $("#from_uom").select2({
                placeholder: 'select',
                allowClear: true
            }).on('select2-open', function () {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                $('#tbl').DataTable().ajax.reload();
            });

            $("#to_uom").select2({
                placeholder: 'select',
                allowClear: true
            }).on('select2-open', function () {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                $('#tbl').DataTable().ajax.reload();
            });
        }
    });
    // select 2 <-

    // Colspan Table
    $(document).ready(function () {
        $('#tbl').DataTable();
    });

</script>
<script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>

<script src="<?php echo base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url() ?>ast11/filter/scripts.js" type="text/javascript"></script>
