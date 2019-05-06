<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= lang("Master Tipe Material", "Master Material Type") ?></h5>
                    <h5 class="title pull-right" style="margin:-10px -5px">
                        <a data-toggle="modal" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></a>
                        <a data-toggle="modal" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></a>
                    </h5>
                </div>
                <div class="ibox-content" style="height:420px">
                    <table id="tbl" class="table table-striped table-bordered table-hover display" width="100%"></table>
                    <label class="form-group" style="font-weight:500" id="info">Showing <?= (isset($total) != false ? ($total >= 1 ? "1" : 0) : '0')?> to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label>
                </div>
            </div>
        </div>
    </div>
</div>

<!--change data-->
<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <form id="form" class="modal-content">
            <!--hide value-->
            <input name="id" id="id" hidden>
            <!--end hide value-->
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label"><?= lang('Tipe Material', 'Material Type') ?></label>
                    <div class="controls">
                        <input type="text" name="mat_type" id="mat_type" class="form-control" required>
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
            </div>
            <br>
            <div class="modal-footer">
                <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
                <button type="button" class="btn" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
            </div>
        </form>
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
                            <label class="form-label col-md-12" for="field-1">Tipe Material</label>
                            <div class="col-md-12">
                                <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-12" for="field-1"><?= lang("Deskripsi", "Description") ?></label>
                            <div class="col-md-12">
                                <select style="width:100%" class="col-md-12" id="search_desc" multiple data-role="tagsinput">
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
                                    <label><input type="checkbox" value="aktif" id="status1"> <i></i> <?=lang("Aktif","Active")?> </label>
                                </div>
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="tidak" id="status2"> <i></i> <?=lang("Tidak Aktif","NotActive")?> </label>
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
                url: '<?= base_url('material/type/change') ?>',
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
        var type = $('#search_type').val();
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
        if (type != null){
            type.map((data, index) => {
                obj["type" + index] = data;
            });
        }
        else{
            obj["type"] = null;
        }
        obj.limit = $('#limit').val();
        if($('#status1').is(":checked"))
            obj.status1=1;
        else
            obj.status1="none";
        if($('#status2').is(":checked"))
            obj.status2=0;
        else
            obj.status2="none";
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('material/type/filter_data'); ?>",
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
        $('#modal-filter').modal('show');
        lang();
    }

    function add() {
        document.getElementById("form").reset();
        $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
        $('#modal').modal('show');
        $('#id').val("");
        document.getElementById("aktif").checked = true;
        lang();
    }

    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('material/type/get/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#mat_type').val(d.MATERIAL_TYPE);
                $('#desc').val(d.DESCRIPTION);
                if(d.STATUS == "1"){
                   document.getElementById("aktif").checked = true;
                }else{
                   document.getElementById("nonaktif").checked = true;
                }
                $('#modal').modal('show');
                lang();
            }
        });

    }

    $('#tbl').DataTable({
        ajax: {
            url: '<?= base_url('material/type/show') ?>',
            dataSrc: ''
        },
        scrollX: true,
        scrollY: '300px',
        scrollCollapse: true,
        paging: false,
        filter: false,
        info:false,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
        columns: [
            {title: "<center>No</center>", "width": "20px"},
            {title: "<center><?= lang('Tipe Material', 'Material Type') ?></center>"},
            {title: "<center><?= lang("Deskripsi", "Description") ?></center>"},
            {title: "<center>Status</center>"},
            {title: "<center><?= lang("Aksi", "Action") ?></center>", "width": "50px"}
        ],
        "columnDefs": [
            {"className": "dt-right", "targets": [0]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]}
        ]
    });
    lang();
</script>
<script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?php echo base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
