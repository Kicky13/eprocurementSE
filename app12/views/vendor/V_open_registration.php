<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Daftar Pendaftaran", "List Registration") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a>
                        </li>
                        <li class="breadcrumb-item"><?= lang("Management Supplier", "Management Supplier") ?>
                        </li>
                        <li class="breadcrumb-item"><?= lang("Daftar Pendaftaran", "List Registration") ?>
                        </li>
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
                                      <!-- <h4 class="card-title"><h5><?= lang("Daftar Pendaftaran", "List Registration") ?></h5></h4> -->
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <div class="heading-elements">
                                            <h5 class="title pull-right">
                                                <button data-toggle="modal" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button>
                                                <button data-toggle="modal" onclick="open_reg()" id="add" class="btn btn-primary"><i class="fa fa-plus-circle"></i> <?= lang("Buka Pendaftaran", "Open Registration") ?></button>
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tbl" class="table table-striped table-bordered zero-configuration" width="100%">

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

<!-- MODAL -->
<div class="modal fade" id="modal"  tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <form id="open_regis" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="open_date"><?= lang('Tanggal Pembukaan', 'Open Date') ?><span style="color:red">*</span></label>
                    <div class="controls">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="open_date" class="form-control" name="open_date" value="<?php echo date("m/d/Y"); ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield1"><?= lang('Tanggal Penutupan', 'Close Date') ?><span style="color:red">*</span></label>
                    <div class="controls">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="close_date" class="form-control" name="close_date" value="<?php echo date("m/d/Y"); ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-primary" id="save"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modal_update"  tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
        <form id="update_regis" class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label" for="open_date"><?= lang('Tanggal Pembukaan', 'Open Date') ?><span style="color:red">*</span></label>
                    <div class="controls">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="open_date" class="form-control" name="open_date">
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label" for="formfield1"><?= lang('Tanggal Penutupan', 'Close Date') ?><span style="color:red">*</span></label>
                    <div class="controls">
                        <div class="input-group date">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="close_date" class="form-control" name="close_date">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-primary" id="button_update"><?= lang('Perbarui', 'Update') ?></button>
            </div>
        </form>
    </div>
</div>

<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form" class="form-horizontal">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel1">Filter Data</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="row mb-1">
                                <div class="col-md-12 mb-1">
                                    <label class="form-label" for="open_date"><?= lang('Tanggal Pembukaan', 'Open Date') ?><span style="color:red">*</span></label>
                                    <div class="controls">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="search_open" class="form-control" name="search_open">
                                        </div>
                                    </div>                        
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label" for="open_date"><?= lang('Tanggal Penutupan', 'Close Date') ?><span style="color:red">*</span></label>
                                    <div class="controls">
                                        <div class="input-group date">
                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="search_close" class="form-control" name="search_close">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <fieldset class="form-group">
                                        <label for="roundText">Status</label>
                                        <div class="i-checks col-md-6">
                                            <label><input type="checkbox" value="aktif" id="status1"> <i></i> <?= lang("Aktif", "Active") ?> </label>
                                        </div>
                                        <div class="i-checks col-md-6">
                                            <label><input type="checkbox" value="tidak" id="status2"> <i></i> <?= lang("Tidak Aktif", "NotActive") ?> </label>
                                        </div>
                                    </fieldset>
                                </div>
                                <div class="col-md-12">
                                    <fieldset>
                                        <div class="input-group">
                                            <input  maxlength="10" type="text" class="touchspin" value="100" id="limit2" name="demo3">
                                            <span class="input-group-addon" id="total"></span>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" onclick="get()" class="btn btn-info" id="save"><?= lang('Filter', 'Filter') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(function () {

        lang();
        $(".touchspin").TouchSpin({
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary",
            buttondown_txt: '<i class="ft-minus"></i>',
            buttonup_txt: '<i class="ft-plus"></i>'
        });
        // $(".touchspin3").TouchSpin({
        //     verticalbuttons: true,
        //     buttondown_class: 'btn btn-white',
        //     buttonup_class: 'btn btn-white'
        // });
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $('.input-group.date').datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            forceParse: false,
            calendarWeeks: true,
            autoclose: true,
            format: "dd/mm/yyyy"
        });

        $('#modal').modal('hide');
        var selected = [];
        var table = $('#tbl').DataTable({
            "ajax": {
                "url": "<?= base_url('vendor/open_registration/show') ?>",
                "dataSrc": ""
            },
            "data": null,
            searching: false,
            info: false,
            paging: false,
            "autoWidth": true,
            "columns": [
                {title: "<center>No</center>"},
                {title: "<center><?= lang('Tanggal Pembukaan', 'Open Date') ?></center>"},
                {title: "<center><?= lang('Tanggal Ditutup', 'Close Date') ?></center>"},
                {title: "<center><?= lang("Aksi", "Action") ?></center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
            ],
        });
        lang();
        $('#tbl tbody').on('click', 'tr .update', function () {
            var data = table.rows({selected: true}).data();
            var data2 = table.row($(this).parents('tr')).data();
            $('#button_update').val(this.id);
            $('#modal_update #open_date').val(data2[1]);
            $('#modal_update #close_date').val(data2[2]);
            $('#modal_update .modal-title').html("Update Pendaftaran");
            $('#modal_update .modal-header').css('background-color', "#1ab394");
            $('#modal_update .modal-header').css('color', "#fff");
            $('#modal_update').modal('show');
        });
        $('#tbl tbody').on('click', 'tr .delete', function () {
            var data = table.rows({selected: true}).data();
            var data2 = table.row($(this).parents('tr')).data();
            var obj = {};
            obj.ID = this.id;
            swal({
                title: "Apakah anda yakin?",
                text: "Data tidak akan bisa dirubah kembali",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: "Ya",
                closeOnConfirm: false
            }, function () {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vendor/open_registration/delete_data'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        if (res.status == true)
                        {
                            swal("Data berhasil dihapus!", "Terima kasih", "success");
                            $('#tbl').DataTable().ajax.reload();
                        }
                        else {
                            swal("Gagal!", "Oops, Terjadi kesalahan penghapusan data", "failed");
                        }
                    }
                });
            });
        });
        $('#open_regis').validate({
            focusInvalid: false,
            rules: {
                open_date: {required: true},
                close_date: {required: true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type

                $('<span class="error"></span>').insertAfter($(element).parent()).append(label)
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            highlight: function (element) { // hightlight error inputs
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            success: function (label, element) {
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-error').addClass('has-success');
            },
            submitHandler: function (form)
            {
                var obj = {};
                $.each($("#open_regis").serializeArray(), function (i, field) {
                    obj[field.name] = field.value;
                });
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vendor/open_registration/add_data'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        if (res.msg != null)
                        {
                            msg_danger("Warning", res.msg);
                        }
                        else if (res.status == true)
                        {
                            msg_info("Sukses", "Data sukses disimpan");
                            $('#modal').modal('hide');
                            $('#tbl').DataTable().ajax.reload();
                        }
                        else {
                            msg_danger("Error", "Data gagal disimpan");
                        }
                    }
                });
            }

        });
        $('#update_regis').validate({
            focusInvalid: false,
            rules: {
                open_date: {required: true},
                close_date: {required: true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type

                $('<span class="error"></span>').insertAfter($(element).parent()).append(label)
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            highlight: function (element) { // hightlight error inputs
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-success').addClass('has-error');
            },
            success: function (label, element) {
                var parent = $(element).parent().parent('.form-group');
                parent.removeClass('has-error').addClass('has-success');
            },
            submitHandler: function (form)
            {
                var obj = {};
                $.each($("#update_regis").serializeArray(), function (i, field) {
                    obj[field.name] = field.value;
                });
                obj.ID = $('#button_update').val();
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('vendor/open_registration/update_data'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        if (res.msg != null)
                        {
                            msg_danger("Warning", res.msg);
                        }
                        else if (res.status == true)
                        {
                            msg_info("Sukses", "Data sukses disimpan");
                            $('#modal_update').modal('hide');
                            $('#tbl').DataTable().ajax.reload();
                        }
                        else {
                            msg_danger("Error", "Data gagal disimpan");
                        }
                    }
                });
            }

        });
    });
    function open_reg()
    {
        console.log("test");
        $('.modal-title').html("<?= lang("Buka Pendaftaran", "Open Registration") ?>");
        $('#modal .modal-header').css('background-color', "#1ab394");
        $('#modal .modal-header').css('color', "#fff")
        $('#modal').modal('show');
        lang();
    }
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
        var obj = {};
        obj.open = $('#search_open').val();
        obj.close = $('#search_close').val();
        obj.limit = $('#limit2').val();
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('vendor/open_registration/filter_data'); ?>",
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
                $('#modal-filter').modal('hide');
            }
        })
    }
</script>
