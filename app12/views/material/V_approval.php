<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">

<div id="main" class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5><?= lang("Persetujuan Material", "Registrasi Material") ?></h5>
                    <h5 class="title pull-right" style="margin:-10px -5px">
                        <a data-toggle="modal" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></a>
                    </h5>
                </div>
                <div class="ibox-content" style="height:420px">
                    <table id="tbl" class="table table-striped table-bordered table-hover display"  width="100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>SEMIC</th>
                                <th>Material</th>
                                <th>Deskripsi</th>
                                <th>UOM</th>
                                <th>Equipment<br/>Group ID</th>
                                <th>Equipment<br/>No</th>
                                <th>Manufacturer</th>
                                <th>Part No</th>
                                <th>Model</th>
                                <th>Sequence<br/>Group</th>
                                <th>Indicator Materials</th>
                                <th>&nbspAksi&nbsp</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>73.23.30.001.1</td>
                                <td>Cable</td>
                                <td>Cable High Quality</td>
                                <td>KG</td>
                                <td>73</td>
                                <td>1103</td>
                                <td>HOSE AND HOSE Connection</td>
                                <td>78</td>
                                <td>SWA</td>
                                <td>23</td>
                                <td>Accept With Condition </td>
                                <td>
                                    <a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='add()'><i class='fa fa-check'></i></a>
                                    </td><!--&nbsp<a class='btn btn-danger btn-sm' title='Update' href='javascript:void(0)' onclick='reject()'><i class='fa fa-ban'></i></a></td>-->
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>65.23.30.002.1</td>
                                <td>Genset</td>
                                <td>Genset High Quality</td>
                                <td>KG</td>
                                <td>65</td>
                                <td>93243</td>
                                <td>Electric Power source</td>
                                <td>78</td>
                                <td>SWA</td>
                                <td>23</td>
                                <td>Accept With Condition </td>
                                <td><a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='add()'><i class='fa fa-check'></i></a>
                                    </td><!--&nbsp<a class='btn btn-danger btn-sm' title='Update' href='javascript:void(0)' onclick='reject()'><i class='fa fa-ban'></i></a></td>-->
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>61.23.30.002.1</td>
                                <td>Genset</td>
                                <td>Genset High Quality</td>
                                <td>KG</td>
                                <td>61</td>
                                <td>73243</td>
                                <td>Building,Structures and tanks</td>
                                <td>66</td>
                                <td>SWA</td>
                                <td>23</td>
                                <td>Accept With Condition </td>
                                <td><a class='btn btn-primary btn-sm' title='Update' href='javascript:void(0)' onclick='add()'><i class='fa fa-check'></i></a>
                                    </td><!--&nbsp<a class='btn btn-danger btn-sm' title='Update' href='javascript:void(0)' onclick='reject()'><i class='fa fa-ban'></i></a></td>-->
                            </tr>
                        </tbody>
                    </table>
                    <label class="form-group" style="font-weight:500" id="info">Showing <?= (isset($total) != false ? ($total >= 1 ? "1" : 0) : '0') ?> to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label>
                </div>
            </div>
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
                            <label class="form-label col-md-6" for="field-1">Material Name</label>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Description", "Description") ?></label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_matr" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_desc" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-6" for="field-1"><?= lang("UOM", "Long Description") ?></label>
                            <label class="form-label col-md-6" for="field-1">Model/Type</label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_long" multiple data-role="tagsinput">
                                </select>
                            </div>

                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_group" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Equipment GrupID", "Material Group") ?></label>
                            <label class="form-label col-md-6" for="field-1"><?= lang("EquipmentNo", "Material Type") ?></label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Manufacturer", "Material Type") ?></label>
                            <label class="form-label col-md-6" for="field-1">Part No</label>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_type" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <div class="col-md-6">
                                <select style="width:100%" class="col-md-12" id="search_uom" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-6" for="field-1"><?= lang("Sequence Grup", "Material Type") ?></label>
                            <label class="form-label col-md-6" for="field-1">Indicator Materials</label>
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
                                    <input class="touchspin3" type="text" value="10" id="limit" name="demo3">
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

<div id="edit" class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <div class="row">
                        <div class="text-left col-md-5">
                            <button type="button" class="btn btn-default" id="back" aria-hidden="true"><i class="fa fa-arrow-circle-o-left"></i></button>
                            <label class="form-group"><?= lang("Kembali", "Back") ?></label>
                        </div>
                        <div class="m-t">
                        <h5 style="text-center"><?= lang("Persetujuan Material", "Registrasi Material") ?></h5>
                        </div>
                    </div>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <input name="id" id="id" hidden>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="form-group m-t col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('Material Name', 'Material Name') ?></label>
                                <div class="col-md-8">
                                    <span>Bearing</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4 "><?= lang('Description', 'Description') ?></label>
                                <div class="col-md-8">
                                    <span>Material Bearing</span>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('UOM', 'Main Grub') ?></label>
                                <div class="col-md-8">
                                    <span>KG</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('Equipment GrupID', 'Main Grub') ?></label>
                                <div class="col-md-8">
                                    <span>Grup Production</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('Manufacturer', 'Model') ?></label>
                                <div class="col-md-8">
                                    <span>PT.SWA</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('Model/Type', 'Model') ?></label>
                                <div class="col-md-8">
                                    <span>Material Barang</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('Sequence group', 'Model') ?></label>
                                <div class="col-md-8">
                                    <span>Production</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('Indicator materials', 'Model') ?></label>
                                <div class="col-md-8">
                                    <span>High</span>
                                </div>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('Equipment No', 'Part No') ?></label>
                                <div class="col-md-8">
                                    <span>5324</span>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name" class="label-control col-md-4"><?= lang('Part No', 'Part No') ?></label>
                                <div class="col-md-8">
                                    <span>1009292</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <hr>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="checked">-->
                                        <span><i class="fa fa-check"></i></span>
                                        <?= lang('Item In General Use', 'Item In General Use') ?>
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="checked">-->
                                        <span><i class="fa fa-check"></i></span>
                                        <?= lang('Consignment  Stock', 'Consignment  Stock') ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="checked">-->
                                        <span><i class="fa fa-check"></i></span>
                                        <?= lang('Isurance Stock', 'Isurance Stock') ?>
                                    </label>
                                </div>
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="">-->
                                        <?= lang('Order As Required', 'Order As Required') ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="">-->
                                        <?= lang('Obsolate Stock', 'Obsolate Stock') ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="checked">-->
                                        <?= lang('Long Lead Time', 'Long Lead Time') ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="checked">-->
                                        <?= lang('Mode Rate Read Time', 'Mode Rate Read Time') ?>
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="">-->
                                        <span><i class="fa fa-check"></i></span>
                                        <?= lang('Short Lead Time', 'Short Lead Time') ?>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12">
                            <hr>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="">-->
                                        <?= lang('Plant Production Stoper', 'Plant Production Stoper') ?>
                                    </label>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="">-->
                                        <?= lang('Job Deffered', 'Job Deffered') ?>
                                    </label>
                                </div>

                            </div>
                            <div class="col-md-4">
                                <div class="i-checks">
                                    <label>
                                        <!--<input type="checkbox" id="" name="" value="checked">-->
                                        <?= lang('Minimum Effect', 'Minimum Effect') ?>
                                    </label>
                                </div>

                            </div>
                        </div>
                        <!--                        <div class="col-md-12">
                                                    <hr>
                                                    <div class="">
                                                        <textarea name="note" id="note" class="form-control" placeholder="Note :" rows="4" required="required"></textarea>
                                                    </div>
                                                    </form>
                                                    <br><hr>
                                                </div>-->
                        <div class="modal-footer">
                            <div class="col-md-12">
                                <button type="button" class="btn btn-danger" onclick="reject()">Reject</button>
                                <button type="button" id="btnSave" onclick="approve()" class="btn btn-primary"><?= lang("Setujui", "Approve") ?></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modal-edit" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <form id="form_edit" class="form-horizontal">
                    <div class="row">
                        <div class="form-group">
                            <div class="col-md-12">
                                <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                                <label id="label_rej" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                                <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note"></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button class="btn btn-danger" id="reject_inv"><?= lang("Tolak", "Reject") ?></button>
                <button class="btn btn-primary" id="finish"><?= lang("Setujui", "Approve and send invitation") ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(function () {
        $('#edit').hide();
        $('#back').click(function(){
            $('#edit').hide();
            $('#main').show();
        })
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
                        msg_danger("Oops, Something Wrong!");
                    }
                }
            });
        });
    });
    function filter() {
        $('.modal-filter').html("<?= lang("Filter Data", "Filter Data") ?>");
        $('#total').text("dari " + "<?= (isset($total) != false ? $total : '0') ?>" + " Data");
        $('#modal-filter .modal-header').css('background-color', "#23c6c8");
        $('#modal-filter .modal-header').css('color', "#fff");
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
//            if (matr !== null){
//    matr.map((data, index) = > {
//    obj["matr" + index] = data;
//    });
//    }
//    else
//            obj["matr"] = null;
//            if (desc !== null){
//    desc.map((data, index) = > {
//    obj["desc" + index] = data;
//    });
//    }
//    else
//            obj["desc"] = null;
//            if (long !== null){
//    long.map((data, index) = > {
//    obj["long" + index] = data;
//    });
//    }
//    else
//            obj["long"] = null;
//            if (type != null){
//    type.map((data, index) = > {
//    obj["type" + index] = data;
//    });
//    }
//    else
//            obj["type"] = null;
//            if (group !== null){
//    group.map((data, index) = > {
//    obj["group" + index] = data;
//    });
//    }
//    else
//            obj["group"] = null;
//            if (uom !== null){
//    uom.map((data, index) = > {
//    obj["uom" + index] = data;
//    });
//    }
//    else
//            obj["uom"] = null;
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
//        document.getElementById("form").reset();
//        document.getElementById("material_type").disabled = true;
//        document.getElementById("material_uom").disabled = true;
//        document.getElementById("mat_name").disabled = true;
//        document.getElementById("desc").disabled = true;
//        document.getElementById("als").disabled = true;
//        document.getElementById("part_no").disabled = true;
//        document.getElementById("model").disabled = true;
//        document.getElementById("img_product").disabled = true;
//        document.getElementById("img_drawing").disabled = true;
//        document.getElementById("note").disabled = true;
//        $("#btnSave").attr("disabled", true);

//    $('.modal-title').html("<?= lang("Persetujuan Material", "Form Registration Material") ?>");
//            //$('#open_edit').summernote('code')
//            $('#myModal').modal('show');
//            $('#myModal .modal-header').css('background-color', "#1ab394");
//            $('#myModal .modal-header').css('color', "#fff");
//            $('#id').val("");
//            document.getElementById("aktif").checked = true;
        $('#main').hide();
        $('#edit').show();
        lang();
    }

    function reject() {
        $('#modal-edit .edit-title').text("Tolak Material");
        $('#modal-edit .modal-header').css("background", "#d9534f");
        $('#modal-edit .modal-header').css("color", "#fff");
        $('#modal-edit #finish').hide();
        $('#modal-edit #reject_inv').show();
        $('#modal-edit #label_rej').show();
        $('#modal-edit').modal('show');
    }
    function approve() {
        $('#modal-edit .edit-title').text("Setujui Material");
        $('#modal-edit .modal-header').css("background", "#1ab394");
        $('#modal-edit .modal-header').css("color", "#fff");
        $('#modal-edit #finish').show();
        $('#modal-edit #reject_inv').hide();
        $('#modal-edit #label_rej').hide();
        $('#modal-edit').modal('show');
    }
    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('material/registration/get/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#mat_material').val(d.MATERIAL);
                $('#desc').val(d.DESCRIPTION);
                $('#open_edit').summernote('code', d.LONG_DESCRIPTION);
                $('#group_material').val(d.MATERAIL_GROUP);
                $('#material_type').val(d.MATERAIL_TYPE);
                $('#material_uom').val(d.MATERAIL_UOM);
                //$('#open_edit').summernote('code', data.open_edit);
                if (d.STATUS == "1") {
                    document.getElementById("aktif").checked = true;
                } else {
                    document.getElementById("nonaktif").checked = true;
                }

                $('#modal').modal('show');
                lang();
            }
        });
    }

//    function aktif_form(){
//        document.getElementById("material_type").disabled = false;
//
//    }
//
//    function aktif_form2(){
//        document.getElementById("material_uom").disabled = false;
//
//    }
//
//    function aktif_form3(){
//        document.getElementById("mat_name").disabled = false;
//        document.getElementById("desc").disabled = false;
//        document.getElementById("als").disabled = false;
//        document.getElementById("part_no").disabled = false;
//        document.getElementById("model").disabled = false;
//        document.getElementById("img_product").disabled = false;
//        document.getElementById("img_drawing").disabled = false;
//        document.getElementById("note").disabled = false;
//        $("#btnSave").attr("disabled", false);
//    }

    $('#tbl').DataTable({
        scrollX: true,
        scrollY: '300px',
        info: false,
        searching: false,
        scrollCollapse: true,
        paging: false,
        info: false,
                fixedColumns: {
                    leftColumns: 1,
                    rightColumns: 1
                },
//        columns: [
//            {title: "<center>No</center>"},
//            {title: "<center><?= lang('Material', 'Material Number') ?></center>"},
//            {title: "<center><?= lang("Deskripsi", "Description") ?></center>"},
//            {title: "<center><?= lang('Grup Material', 'Material Group') ?></center>"},
//            {title: "<center><?= lang("Tipe Material", "Material Type") ?></center>"},
//            {title: "<center><?= lang("UOM Material", "Material UOM") ?></center>"},
//            {title: "<center>Status</center>"},
//            {title: "<center><?= lang("Aksi", "Action") ?></center>"}
//        ],
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
