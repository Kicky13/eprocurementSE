<!-- <link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet"> -->


<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Master UOM Material", "Master Material UOM") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("UOM Material", "Material UOM") ?></li>
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
                                                <!-- <button aria-expanded="false" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button> -->
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
                                            <table id="tbl" class="table nowrap table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center><?= lang('Material UOM', 'Material UOM') ?></center></th>
                                                        <th><center><?= lang("Deskripsi", "Description") ?></center></th>
                                                        <th><center>Status</center></th>
                                                        <th><center>For Service</center></th>
                                                        <th><center>Action</center></th>
                                                    </tr>
                                                </thead>
                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center><?= lang('Material UOM', 'Material UOM') ?></center></th>
                                                        <th><center><?= lang("Deskripsi", "Description") ?></center></th>
                                                        <th><center>Status</center></th>
                                                        <th><center>For Service</center></th>
                                                        <th><center>Action</center></th>
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
<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class=" modal-content">
        <form id="form">
            <!--hide value-->
            <input name="id" id="id" hidden>
            <!--end hide value-->
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label"><?= lang('Material UOM', 'Material UOM') ?></label>
                    <div class="controls">
                        <input type="text" name="mat_UOM" id="mat_UOM" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Deskripsi', 'Description') ?></label>
                    <div class="controls">
                        <input type="text" name="desc" id="desc" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="controls">
                        <div class="col-sm-10">
                            <input type="radio" value="1" name="status" id="aktif"> <i></i><?= lang('Aktif', 'Active') ?>
                            &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="0" name="status" id="nonaktif"> <i></i><?= lang('Nonaktif', 'Nonactive') ?>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">For Service UOM</label>
                    <input style="margin-left: 10px;top: 1px;position: relative;" type="checkbox" name="UOM_TYPE" id="UOM_TYPE" value="2">
                </div>
            </div>
            <br>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </form>
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
                            <label class="form-label col-md-12" for="field-1"><?= lang('Klasifikasi Material', 'Material Classification') ?></label>
                            <div class="col-md-12">
                                <select style="width:100%" class="col-md-12" id="search_klas" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-12" for="field-1"><?= lang("Deskripsi", "Description") ?></label>
                            <div class="col-md-12">
                                <select style="width:100%" class="col-md-12" id="search_desc" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-12" for="field-1">Type</label>
                            <div class="col-md-12">
                                <div class="i-checks col-md-12">
                                    <label><input type="checkbox" value="GOODS" id="type_good"> <i></i> Goods/Barang </label>
                                </div>
                                <div class="i-checks col-md-12">
                                    <label><input type="checkbox" value="SERVICE" id="type_service"> <i></i> Service/Jasa </label>
                                </div>
                                <div class="i-checks col-md-12">
                                    <label><input type="checkbox" value="CONSULTATION" id="type_consultation"> <i></i> Consultation/Konsultasi </label>
                                </div>
                            </div>
                            <label class="form-label col-md-12" for="field-1">Status</label>
                            <div class="col-md-12">
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="aktif" id="status1"> <i></i> <?=lang("Aktif","Active")?> </label>
                                </div>
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="tidak" id="status2"> <i></i> <?=lang("Tidak Aktif","NotActive")?> </label>
                                </div>
                            </div>
                            <hr>
                            <label class="form-label col-md-12" for="field-1"><?= lang("Batas Data", "Limit Data") ?></label>
                            <div class="col-md-12 m-b">
                                <div class="input-group">
                                    <input class="touchspin3" type="text" value="1" id="limit" name="demo3">
                                    <span class="input-group-addon" id="total"></span>
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
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $(".touchspin3").TouchSpin({
            verticalbuttons: true,
            buttondown_class: 'btn btn-white',
            buttonup_class: 'btn btn-white'
        });
        $('#form').on('submit', function (e) {
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '<?= base_url('material/uom/change') ?>',
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
    function get()
    {
        var desc = $('#search_desc').val();
        var uom = $('#search_uom').val();
        var obj = {};
        if (desc !== null){
            desc.map((data, index) => {
                obj["desc" + index] = data;
            });
        }
        else
        {
            obj["desc"] = null;
        }
        if (uom != null){
            uom.map((data, index) => {
                obj["uom" + index] = data;
            });
        }
        else{
            obj["uom"] = null;
        }
        if($('#status1').is(":checked"))
            obj.status1=1;
        else
            obj.status1="none";
        if($('#status2').is(":checked"))
            obj.status2=0;
        else
            obj.status2="none";
        obj.limit = $('#limit').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('material/uom/filter_data'); ?>",
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

    function filter() {
        $('.modal-filter').html("<?= lang("Filter Data", "Filter Data") ?>");
        $('#total').text("dari "+"<?= (isset($total) != false ? $total : '0') ?>"+" Data");
        $('#modal-filter .modal-header').css('background-color',"#23c6c8");
        $('#modal-filter .modal-header').css('color',"#fff");
        $('#modal-filter').modal('show');
        lang();
    }
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
        $("#UOM_TYPE").removeAttr("checked");
        $.ajax({
            type: 'POST',
            url: '<?= base_url('material/uom/get/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#mat_UOM').val(d.MATERIAL_UOM);
                $('#desc').val(d.DESCRIPTION);
                if (d.STATUS == "1") {
                    document.getElementById("aktif").checked = true;
                } else {
                    document.getElementById("nonaktif").checked = true;
                }
                if (d.UOM_TYPE == "2") {
                    $("#UOM_TYPE").attr("checked",true);
                } else {
                    $("#UOM_TYPE").removeAttr("checked");
                }
                $('#modal .modal-header').css('background-color',"#1ab394");
                $('#modal .modal-header').css('color',"#fff");
                $('#modal').modal('show');
                lang();
            }
        });
    }

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
            url: '<?= base_url('material/uom/show') ?>',
            dataSrc: ''
        },
        scrollX: true,
        scrollY: '300px',
        scrollCollapse: true,
        paging: true,
        filter: true,
        info:false,
        fixedColumns: {
            leftColumns: 0,
            rightColumns: 1
        },
        columns: [
            {title: "<center>No</center>", "width": "20px"},
            {title: "<center><?= lang('Material UOM', 'Material UOM') ?></center>"},
            {title: "<center><?= lang("Deskripsi", "Description") ?></center>"},
            {title: "<center>Status</center>"},
            {title: "<center>For Service</center>"},
            {title: "<center>Action</center>", "width": "50px"}
        ],
        "columnDefs": [
            {"className": "dt-right", "targets": [0]},
//            {"className": "dt-right", "targets": [3]},
            {"className": "dt-center", "targets": [4]}
        ]
    });
    $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
            table.column( $(this).data('index') )
            .search( this.value )
            .draw();
        } );
    lang();
</script>
<!-- <script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script> -->
