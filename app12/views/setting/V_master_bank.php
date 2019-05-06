<div class="app-content content">
    <div class="content-wrapper">
        <div id="main" class="wrapper wrapper-content animated fadeInRight">
            <div class="content-header row">
                <div class="content-header-left col-md-6 col-12 mb-1">
                    <h3 class="content-header-title"><?= lang("Master Bank", "Bank Master") ?></h3>
                </div>
                <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                    <div class="breadcrumb-wrapper col-12">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home">Home</a>
                            </li>
                            <li class="breadcrumb-item"><?= lang("Pengaturan", "Setting") ?>
                            </li>
                            <li class="breadcrumb-item"><?= lang("Master Bank", "Bank Master") ?>
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
                                      </div>
                                  </div>
                                  <div class="col-md-6">
                                      <div class="card-header">
                                          <div class="heading-elements">
                                              <h5 class="title pull-right">
                                                <button class="btn btn-outline-success" onclick="add()"><i class="fa fa-plus-circle"></i> <?=lang("Tambah data","CREATE")?></button>
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
                                                    <tfoot>
                                                        <tr>
                                                            <th><center>No</center></th>
                                                            <th><center><?= lang('Nama Bank', 'Bank Name') ?></center></th>
                                                            <th><center><?= lang('Deskripsi', 'Description') ?></center></th>
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
                <h4 class="modal-title"><?= lang("Tambah data Bank", "Add Bank Data") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body col-12">
                <form id="bank_form" class="form" action="javascript:;"  novalidate="novalidate">
                    <div class="form-body">
                        <div class="form-group row">
                            <label class="col-4 control-label" for="no_akta">
                                <?= lang("Nama Bank", "Bank Name"); ?>
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="nm_bank" name="nm_bank">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 control-label" for="no_akta">
                                <?= lang("Deskripsi", "Description"); ?>
                            </label>
                            <div class="col-8">
                                <input type="text" class="form-control" id="des_bank" name="des_bank">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-4 control-label" for="no_akta">
                                <?= lang("Status", "Status"); ?>
                            </label>
                            <div class="controls col-8">
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
<script>
$(function(){
    lang();
    $('#tbl tfoot th').each( function (i) {
      var title = $('#tbl1 thead th').eq($(this).index()).text();
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
            "url": "<?= base_url('setting/master_bank/show') ?>",
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
                {title: "<center>&nbspNo&nbsp</center>"},
                {title: "<center><?= lang('Nama Bank', 'Bank Name') ?></center>"},
                {title: "<center><?= lang('Deskripsi', 'Description') ?></center>"},
                {title: "<center>Status</center>"},
                {title: "<center>Action</center>"}
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]}
            ],
        });
        lang();
        $('#tbl tbody').on('click', 'tr .update', function () {
            var data = table.row($(this).parents('tr')).data();
            $('#nm_bank').val(data[1]);
            $('#des_bank').val(data[2]);
            var stat=0;
            if(data[3] == "AKTIF" || data[3] == "ACTIVE")
                $('.act').attr('checked',true);
            else
                $('.nact').attr('checked',true);
            $('#modal_edit .modal-title').html("<?= lang("Perbarui data bank", "Update Bank Data") ?>");
            $('#add').hide();
            $('#update').show();
            $('#update').val(this.id);
            $('#modal_edit').modal('show');
            lang();
        });
        $( table.table().container() ).on( 'keyup', 'tfoot input', function () {
           table.column( $(this).data('index') )
            .search( this.value )
            .draw();
        });
        lang();
        $('#bank_form').validate({
            focusInvalid: false,
            rules: {
                nm_bank: {required: true},
                des_bank: {required: true},
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
                $.each($("#bank_form").serializeArray(), function (i, field) {
                    obj[field.name] = field.value;
                });
                obj['key'] = $("#update").val();
//                console.log(obj);
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('setting/master_bank/add_data'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        stop(elm);
                        if (res.Status !== "Error") {
                            $('#modal_edit').modal('hide');
                            if ($('#update').val !== "0")
                            {
                                $('#update').val("0");
                                document.getElementById("bank_form").reset();
                            }
                            $('#tbl').DataTable().ajax.reload();
                            $('#tbl').DataTable().columns.adjust().draw();
                            msg_info(res.Status, res.msg);
                        }else
                        {
                            msg_danger(res.Status, res.msg);
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
function add()
{
    console.log('tet');
    $('#modal_edit .modal-title').html("<?= lang("Tambah data bank", "Add Bank Data") ?>");
    document.getElementById("bank_form").reset();
    $('#update').val("0");
    $('#add').show();
    $('#update').hide();
    $('#modal_edit').modal('show');
    lang();
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
            url: '<?= base_url('setting/master_company/delete_data/') ?>',
            data: obj,
            success: function (msg) {
                stop(elm);
                if (msg.Status !== "Error") {
                    $('#tbl').DataTable().ajax.reload();
                    $('#tbl').DataTable().columns.adjust().draw();
                    swal("msg.msg", "", "success");
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
