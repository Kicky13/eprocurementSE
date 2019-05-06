<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content v_inactive_and_rejected">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang('List Supplier Report', 'List Supplier Report') ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('home'); ?>">Home</a>
                        </li>
                        <li class="breadcrumb-item"><?= lang("Managemen Supplier", "Supplier Management") ?>
                        </li>
                        <li class="breadcrumb-item active"><?= lang("List Supplier Report", "List Supplier Report") ?>
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

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-content collapse show">

                                <div class="col-md-12">
                                    <table id="tbl_supplier_rejected" class="table nowrap table-striped table-bordered zero-configuration" width="100%">
                                            <thead>
                                                <tr>
                                                    <th><span>No</span></th>
                                                    <th>Email</th>
                                                    <th><?= lang('Nama Supplier', 'Supplier Name') ?></th>
                                                    <th>Company Type</th>
                                                    <th>Classification</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tfoot>
                                                <tr>
                                                    <th><span>No</span></th>
                                                    <th>Email</th>
                                                    <th>Nama Supplier</th>
                                                    <th>Company Type</th>
                                                    <th>Classification</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center"><center>Action</th>
                                                </tr>
                                            </tfoot>
                                    </table>
                                    <!-- <label class="form-group" style="font-weight:300" id="info">Showing 1 to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label> -->
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>

<?php $this->load->view('vendor/V_approval') ?>

<div class="modal fade" id="Modal-update" tabindex="-1" role="dialog">
    <div class="modal-dialog" >
        <div class="modal-content">
            <!-- <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"> </h4>
            </div> -->
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"><?= lang('Perbarui', 'Update') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="#" id="form-edit" class="form-horizontal">
                    <input type="hidden" value="" name="id" id="id"/>
                    <div class="form-body">
                        <div class="form-group">
                            <label class="form-label" for="formfield2">Nama Supplier</label>
                            <div class="controls">
                                <input name="nama_vendor_edit"  id="nama_vendor_edit" placeholder="Nama Supplier" class="form-control" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="formfield2">Email</label>
                            <div class="controls">
                                <input type="email" name="email_edit" id="email_edit" class="form-control" required>
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="button" id="btnSave" onclick="save()" class="btn btn-primary"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jqBootstrapValidation.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/validation/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/scripts/forms/validation/form-validation.js"type="text/javascript"></script>
<script>
    $(document).ready(function() {
      $(".btn.btn-primary#save").prop('disabled', true);
      $("#LEGAL4_BTN").find('button').prop('disabled', true);
      $("#LEGAL7_BTN").find('button').prop('disabled', true);
      $("#LEGAL8_BTN").find('button').prop('disabled', true);
      $(".btn.btn-danger#save").hide();
      $(".checklist").hide();
      // $(".back").hide();
      // $(".btn.btn-primary#save").hide();

      $(document).on("click", "#back", function (){
        $(".app-content.content").hide();
        location.reload();
      })
    });

    $('#tbl_supplier_rejected tfoot th').each( function (i) {
        var title = $('#tbl_supplier_rejected thead th').eq( $(this).index() ).text();
        if ($(this).text() == 'No') {
          $(this).html('');
        } else if ($(this).text() == 'Action') {
          $(this).html('');
        } else {
          $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
        }
    });
    lang();

    var table=$('#tbl_supplier_rejected').DataTable({
        ajax: {
            url: '<?= base_url('vendor/inactive_and_rejected/show') ?>',
            dataSrc: ''
        },
        scrollX: true,
        scrollY: '300px',
        scrollCollapse: true,
        paging: true,
        info: true,
        searching: true,
        destroy: true,
        fixedColumns: {
            leftColumns: 0,
            rightColumns: 1
        },
        "columnDefs": [
            {"className": "dt-right", "targets": [0]},
            {"className": "dt-right", "targets": [1]},
            {"className": "dt-right", "targets": [2]},
            {"className": "dt-right", "targets": [3]},
            {"className": "dt-right", "targets": [4]},
            {"className": "dt-right", "targets": [5]},
            {"className": "dt-right", "targets": [6]},
        ]
    });
    $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
            table.column( $(this).data('index') )
            .search( this.value )
            .draw();
        } );
    lang();

    function update(id) {
        $.ajax({
            type: 'POST',
            url: '<?= base_url('vendor/inactive_and_rejected/get/') ?>' + id,
            success: function (msg) {
                $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
                var msg = msg.replace("[", "");
                var msg = msg.replace("]", "");
                var d = JSON.parse(msg);
                $('#id').val(d.ID);
                $('#email_edit').val(d.ID_VENDOR);
                $('#nama_vendor_edit').val(d.NAMA);
                if (d.STATUS == "1") {
                    document.getElementById("aktif").checked = true;
                } else {
                    document.getElementById("nonaktif").checked = true;
                }
                $('#Modal-update').modal('show');
                lang();
            }
        });
    }

    function save() {
        swal({
            title: "Apakah kamu yakin?",
            text: "Mengubah data ini",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#347ab5",
            confirmButtonText: "Ya",
            cancelButtonText: "Tidak",
            closeOnConfirm: false
        }, function (isConfirm) {
            if (!isConfirm)
                return;
//            $('#btnSave').text('saving...');
//            $('#btnSave').attr('disabled', true);
            $.ajax({
                url: "<?= base_url('vendor/inactive_and_rejected/update_vendor') ?>/",
                type: "POST",
                data: $('#form-edit').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status)
                    {
                        $('#Modal-update').modal('hide');
                        $('#tbl_supplier_rejected').DataTable().ajax.reload();
                    }
                    swal.close()
                    msg_info('Sukses tersimpan');
                },
                error: function (jqXHR, textStatus, errorThrown)
                {
                    swal.close()
                    msg_danger('Gagal Tersimpan!');
                }
            });
        });
    }

    function delete_data($id) {
        swalConfirm('Supplier Report', '<?= __('confirm_delete') ?>', function() {
            $.ajax({
                url: "<?= base_url('vendor/inactive_and_rejected/delete_data') ?>/" + $id,
                type: "POST",
                data: $('#form-delete_data').serialize(),
                dataType: "JSON",
                success: function (data) {
                    if (data.status) //if success close modal and reload ajax table
                    {
                        $('#tbl_supplier_rejected').DataTable().ajax.reload();
                        setTimeout(function() {
                            swal('<?= __('success') ?>', '<?= __('success_delete') ?>', 'success');
                        }, swalDelay);
                    } else {
                        setTimeout(function() {
                            swal('<?= __('warning') ?>', '<?= __('failed_delete') ?>', 'warning');
                        }, swalDelay);
                    }
                }
            });
        });
    }



    // data detail
    $(document).ready(function() {
      $(".v_approval").hide();
      $(document).on("click", ".btndetail", function(){
        // console.log(var_result);
        if (var_result == false || var_result == true) {
          $(".v_approval").show();
          $(".nonregis").find('.btn.btn-primary').hide();
          $(".registrasi").find('.btn.btn-primary').hide();
          $(".nonregis").find('.btn.btn-danger').hide();
          setTimeout(function(){
            $(".v_inactive_and_rejected").hide();
          },500)
        }
      })
      $(document).on("click", ".btn.btn-default.back", function(){
        $(".v_approval").hide();
        $(".v_inactive_and_rejected").show();
      })
    });
    // data detail


</script>
