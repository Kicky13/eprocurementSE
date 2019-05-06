<div class="app-content content">
    <div class="content-wrapper">
        <div id="main" class="wrapper wrapper-content animated fadeInRight">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1">
                    <h3 class="content-header-title"><?= lang("Master approval", "Approval Master") ?></h3>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a>
                            </li>
                            <li class="breadcrumb-item"><?= lang("Pengaturan", "Settings") ?>
                            </li>
                            <li class="breadcrumb-item"><?= lang("Master approval", "Approval Master") ?>
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
                                <div class="col-12 text-right mt-1">
                                    <button class="btn btn-outline-success" onclick="add()"><i class="fa fa-plus-circle"></i><?=lang("Tambah data","CREATE")?></button>
                                </div>
                                <div class="card-content collapse show">
                                    <div class="card-body card-dashboard">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table id="tbl" class="table nowrap table-striped table-bordered zero-configuration" width="100%">
                                                    <tfoot>
                                                        <tr>
                                                            <th><center>No</center></th>
                                                            <th><center><?= lang('Roles Pengguna', 'User Roles') ?></center></th>
                                                            <th><center><?= lang('Urutan Persetujuan','Approval Sequence')?></center></th>
                                                            <th><center><?= lang('Deskripsi', 'Description') ?></center></th>
                                                            <th><center><?= lang('Modul', 'Module') ?></center></th>
                                                            <th><center><?= lang('Step Tolak', 'Reject Step') ?></center></th>
                                                            <th><center><?= lang('Email Setuju', 'Email Approve') ?></center></th>
                                                            <th><center><?= lang('Email Tolak', 'Email Reject') ?></center></th>
                                                            <th><center><?= lang('Ubah konten', 'Edit Content') ?></center></th>
                                                            <th><center><?= lang('Pengaturan tambahan', 'Extra Case') ?></center></th>
                                                            <th><center>Status</center></th>
                                                            <th><center>Action</center></th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
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
</div>
<div class="modal fade bs-example-modal-lg" data-backdrop="static" id="modal_edit" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"><?= lang("Tambah data", "Add Data") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body col-12">
                <form id="com_form" class="form" action="javascript:;"  novalidate="novalidate">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-2 control-label" for="modul">
                                <?= lang("Modul", "Module"); ?>
                            </label>
                            <div class="col-4">
                                <select class="select2 form-control m-b" id="modul" name="modul" tabindex="2" style="width: 100%" >
                                </select>
                            </div>
                            <label class="col-2 control-label" for="jabatan">
                                <?= lang("Jabatan", "Roles"); ?>
                            </label>
                            <div class="col-4">
                                <select class="select2 form-control m-b" id="jabatan" name="jabatan" tabindex="2" style="width: 100%" >
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="no_akta">
                                <?= lang("Deskripsi", "Description"); ?>
                            </label>
                            <div class="col-4">
                                <input type="text" class="form-control" id="desc" name="desc">
                            </div>
                            <label class="col-2 control-label" for="seq">
                                <?= lang("Urutan Persetujuan", "Approval Sequence"); ?>
                            </label>
                            <div class="col-4">
                                <input type="number" min="1" class="form-control" id="seq" name="seq">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="seq">
                                <?= lang("Step Tolak", "Reject Step"); ?>
                            </label>
                            <div class="col-4">
                                <input type="number" min="0" class="form-control" id="rej_step" name="rej_step">
                            </div>
                            <label class="col-2 control-label" for="seq">
                                <?= lang("Email Tolak", "Reject Email Template"); ?>
                            </label>
                            <div class="col-4">
                                <input type="number" min="0" class="form-control" id="mail_app" name="mail_app">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-2 control-label" for="seq">
                                <?= lang("Email Setuju", "Approve Email Template"); ?>
                            </label>
                            <div class="col-4">
                                <input type="number" min="0" class="form-control" id="mail_rej" name="mail_rej">
                            </div>
                            <label class="col-2 control-label" for="seq">
                                <?= lang("Ubah Konten", "Edit Content"); ?>
                            </label>
                            <div class="col-4">
                                <div class="c-inputs-stacked">
                                    <div class="i-checks">
                                        <input type="radio" class="act_edit" value="1" id="edit_con" name="edit_con"> <i></i><?=lang("Ya","Yes")?>
                                        &nbsp<input type="radio" class="nact_edit" value="0" id="edit_con" name="edit_con"> <i></i><?=lang("Tidak","No")?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-2 control-label" for="seq">
                                <?= lang("Pengaturan Tambahan", "Extra Case"); ?>
                            </label>
                            <div class="col-4">
                                <div class="c-inputs-stacked">
                                    <div class="i-checks">
                                        <input type="radio" class="act_extra" value="1" id="extra_case" name="extra_case"> <i></i><?=lang("Ya","Yes")?>
                                        &nbsp<input type="radio" class="nact_extra" value="0" id="extra_case" name="extra_case"> <i></i><?=lang("Tidak","No")?>
                                    </div>
                                </div>
                            </div>
                            <label class="col-2 control-label" for="no_akta">
                                <?= lang("Status", "Status"); ?>
                            </label>
                            <div class="controls col-4">
                                <div class="c-inputs-stacked">
                                    <div class="i-checks">
                                        <input type="radio" class="act" value="1" id="status" name="status"> <i></i><?=lang("Aktif","Active")?>
                                        &nbsp<input type="radio" class="nact" value="0" id="status" name="status"> <i></i><?=lang("Tidak Aktif","Not Active")?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr/>
                        <div class="col-12 text-right">
                            <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                            <button type="submit" class="btn btn-primary" id="add"><?= lang("Tambah", "Add") ?></button>
                            <button type="submit" class="btn btn-primary" id="update" name="update" value="0"><?= lang("Perbarui", "Update") ?></button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css">
<script src="<?= base_url() ?>ast11/assets/js/forms/select/select2.full.min.js" type="text/javascript"></script>
<script>
$(function(){
    $("#modul").select2({
        placeholder: "Please Select Module"
    });
    $("#jabatan").select2({
        placeholder: "Please Select Module"
    });
    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });
    lang();
    get_dt();
    $('#tbl tfoot th').each( function (i) {
      var title = $('#tbl thead th').eq($(this).index()).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'Action') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }
    });

    var table = $('#tbl').DataTable({
        "ajax": {
            "url": "<?= base_url('setting/master_approval/show') ?>",
            "dataSrc": ""
        },
        scrollX: true,
        scrollY: '300px',
        scrollCollapse: true,
        paging: true,
        filter: true,
        info: false,
        destroy: true,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
            "columns": [
                {title: "<center>No</center></th>"},
                {title: "<center><?= lang('Jabatan', 'Roles') ?></center></th>"},
                {title: "<center><?= lang('Urutan<br/>Persetujuan','Approval<br/>Sequence')?></center></th>"},
                {title: "<center><?= lang('Deskripsi', 'Description') ?></center></th>"},
                {title: "<center><?= lang('Modul', 'Module') ?></center></th>"},
                {title: "<center><?= lang('Step Tolak', 'Reject Step') ?></center></th>"},
                {title: "<center><?= lang('Email Setuju', 'Email Approve') ?></center></th>"},
                {title: "<center><?= lang('Email Tolak', 'Email Reject') ?></center></th>"},
                {title: "<center><?= lang('Ubah konten', 'Edit Content') ?></center></th>"},
                {title: "<center><?= lang('Pengaturan<br/>tambahan', 'Extra<br/>Case') ?></center></th>"},
                {title: "<center>Status</center></th>"},
                {title: "<center>Action</center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [6]},
                {"className": "dt-center", "targets": [7]},
                {"className": "dt-center", "targets": [8]},
                {"className": "dt-center", "targets": [9]},
                {"className": "dt-center", "targets": [10]}

            ],
        });
        lang();
        $( table.table().container() ).on( 'keyup', 'tfoot input', function () {
           table.column( $(this).data('index') )
            .search( this.value )
            .draw();
        });
        lang();
        $('#com_form').validate({
            focusInvalid: false,
            rules: {
                modul: {required: true},
                jabatan: {required: true},
                desc: {required: true},
                seq: {required:true},
                rej_step: {required:true},
                mail_app: {required:true},
                mail_rej: {required:true},
                edit_con: {required:true},
                extra_case: {required:true},
                status: {required:true},
            },
            errorPlacement: function (label, element) { // render error placement for each input type
                var elmnt = element[0].id;
                if(elmnt != "status")
                    $('<span class="error"></span>').insertAfter(element).append(label)
                else
                    $('<span class="error"></span>').insertAfter(".c-inputs-stacked").append(label)
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
                label.parent().removeClass('error');
                label.remove();
            },
            submitHandler: function (form)
            {
                var elm = start($('#modal_edit').find('.modal-content'));
                var obj = {};
                $.each($("#com_form").serializeArray(), function (i, field) {
                    obj[field.name] = field.value;
                });
                obj['key'] = $("#update").val();

                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('setting/master_approval/add_data'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.Status === "Success") {
                            $('#modal_edit').modal('hide');
                            if ($('#update').val !== "0")
                            {
                                $('#update').val("0");
                                document.getElementById("com_form").reset();
                            }
                            $('#tbl').DataTable().ajax.reload();
                            $('#tbl').DataTable().columns.adjust().draw();
                            msg_info(res.msg,res.Status);
                        }else
                        {
                            msg_danger(res.msg,res.Status);
                        }
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        stop(elm);
                        msg_danger("Gagal", "Oops,Terjadi kesalahan");
                    }
                });
            }
        });
});
function edit(dt)
{
    $('#add').hide();
            $('#update').show();
            $('#update').val(dt);
            $('#modal_edit .modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
            $('#modal_edit').modal('show');
            $('.iradio_square-green').removeClass("checked");
            $('#com_form :input').prop('checked',false);
            lang();
            var obj={};
            obj.id=dt;
            $.ajax({
                type: 'POST',
                url: '<?= base_url('setting/master_approval/get_ids/') ?>',
                data:obj,
                success: function (msg)
                {
                    if(msg !== "false")
                    {
                        $('#modul').val(msg[0]['module']).select2();
                        $('#jabatan').val(msg[0]['user_roles']).select2();
                        $('#desc').val(msg[0]['description']);
                        $('#seq').val(msg[0]['sequence']);
                        $('#rej_step').val(msg[0]['reject_step']);
                        $('#mail_app').val(msg[0]['email_approve']);
                        $('#mail_rej').val(msg[0]['email_reject']);
                        if(msg[0]['edit_content'] == '0')
                        {
                            $('.act_edit').parent().addClass("checked");
                            $('.act_edit').prop('checked',true);
                        }
                        else
                        {
                            $('.nact_edit').parent().addClass("checked");
                            $('.nact_edit').prop('checked',true);
                        }

                        if(msg[0]['extra_case'] == '1')
                        {
                            console.log(msg[0]['extra_case']);
                            $('.act_extra').parent().addClass("checked");
                            $('.act_extra').prop('checked',true);
                        }
                        else
                        {
                            $('.nact_extra').parent().addClass("checked");
                            $('.nact_extra').prop('checked',true);
                        }

                        if(msg[0]['status'] == '1')
                        {
                            $('.act').parent().addClass("checked");
                            $('.act').prop('checked',true);
                        }
                        else
                        {
                            $('.nact').parent().addClass("checked");
                            $('.nact').prop('checked',true);
                        }

                    }
                    else
                        msg_danger("Error","Oops,Terjadi kesalahan pengambilan data");
                },
                error: function (XMLHttpRequest, textStatus, errorThrown)
                {
                    msg_danger("Error","Oops,Terjadi kesalahan pengambilan data");
                }
            });
}
function up(dt,seq)
{
    var obj={};
    obj.id=dt;
    obj.sel="up";
    obj.seq=seq;
    $.ajax({
        type: 'POST',
        url: '<?= base_url('setting/master_approval/chg_seq/') ?>',
        data:obj,
        success: function (msg)
        {
            if(msg.status !== "Error")
            {
                $('#tbl').DataTable().ajax.reload();
                $('#tbl').DataTable().columns.adjust().draw();
            }
            else
                msg_danger(msg.status,msg.msg);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            msg_danger("Error","Oops,Terjadi Kesalahan");
        }
    });
}
function down(dt,seq)
{
    var obj={};
    obj.id=dt;
    obj.sel="down";
    obj.seq=seq;
    $.ajax({
        type: 'POST',
        url: '<?= base_url('setting/master_approval/chg_seq/') ?>',
        data:obj,
        success: function (msg)
        {
            if(msg.status !== "Error")
            {
                $('#tbl').DataTable().ajax.reload();
                $('#tbl').DataTable().columns.adjust().draw();
            }
            else
                msg_danger(msg.status,msg.msg);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            msg_danger("Error","Oops,Terjadi Kesalahan");
        }
    });
}

function add(dt)
{
    document.getElementById("com_form").reset();
    $('.iradio_square-green').removeClass("checked");
    $('#com_form :input').prop('checked',false);
    $('#add').show();
    $('#update').hide();
    $('#update').val("0");
    $('#modal_edit .modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
    $('#modal_edit').modal('show');
    // var elm = start($('#modal_edit').find('.modal-content'));
    lang();
}
function get_dt()
{
    $.ajax({
        type: 'POST',
        url: '<?= base_url('setting/master_approval/get_sel/') ?>',
        success: function (msg)
        {
            // stop(elm);
            if(msg.status !== "Error")
            {
                $('#modul').html(msg[0]['modul']);
                $('#jabatan').html(msg[0]['jabatan']);
            }
            else
                msg_danger(msg.status,msg.msg);
        },
        error: function (XMLHttpRequest, textStatus, errorThrown)
        {
            msg_danger("Error","Oops,Terjadi kesalahan pengambilan data");
        }
    });
}
function delete_dt(id)
{
    swal({
        title: "Apakah anda yakin?",
        text: "Untuk menghapus data ini",
        type: "warning",
        showCancelButton: true,
        CancelButtonColor: "#DD6B55",
        confirmButtonColor: "#FF6275",
        confirmButtonText: "Ya",
        closeOnConfirm: false
    }, function () {
        var elm = start($('.sweet-alert'));
        var obj={};
        obj.ID=id;
        $.ajax({
            type: 'POST',
            url: '<?= base_url('setting/master_approval/delete_data/') ?>',
            data: obj,
            success: function (msg) {
                stop(elm);
                if (msg.Status !== "Error") {
                    $('#tbl').DataTable().ajax.reload();
                    $('#tbl').DataTable().columns.adjust().draw();
                    swal(msg.msg, "", "success");
                    msg_info(msg.Status, msg.msg);
                }else
                {
                    msg_danger(msg.Status, msg.msg);
                    swal("Gagal!", msg.msg, "failed");
                }
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                stop(elm);
                msg_danger("Gagal", "Oops,Terjadi kesalahan");
                swal("Data Gagal di hapus", "", "failed");
            }
        });
    });
}
</script>
