<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>

<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">
<script src="<?= base_url() ?>ast11/js/plugins/summernote/summernote.min.js"></script>


<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-6 col-12 mb-1">
          <h3 class="content-header-title"><?= $header_title; ?></h3>
        </div>
        <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
          <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="index.html">Home</a>
              </li>
              <li class="breadcrumb-item"><a href="#"><?= lang("Pengaturan", "Setting") ?></a>
              </li>
              <li class="breadcrumb-item active"><?= $breadcrumb_title; ?>
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
                                    <!--<a href="<?= base_url('vendor/Master_email') ?>" aria-expanded="false" class="btn btn-lg btn-danger"><i class="fa fa-arrow-left"></i> <?= lang("Back", "Back") ?></a> -->
                                    <button onclick="email_new()" aria-expanded="false" class="btn btn-success"><i class="fa fa-plus"></i>
                                      <?= lang(" Tambah", " Add") ?>
                                    </button>
                                </h5>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-content collapse show">
                    <div class="card-body card-dashboard">
                        <div class="row">
                          <div class="col-md-12">
                              <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                  <tfoot>
                                      <tr>
                                          <th><center>No</center></th>
                                          <th><center>code</center></th>
                                          <th><center>code</center></th>
                                          <th><center>code</center></th>
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

<div class="modal fade" id="Modal-email" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-primary white">
                  <h4 class="modal-title"><?= lang('Form Email', 'Email Form') ?></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">×</span>
                 </button>
            </div>
            <div class="modal-body">
                <form id="form-email" class="form-horizontal" action="javascript:;" novalidate="novalidate">
                    <input type="hidden" name="id_email" id="id_email" class="form-control" required>
                    <div class="form-body">
                        <!--<div class="form-group select_roles">
                            <label class="form-label"><?= lang('Rules', 'Rules') ?></label>
                            <select id="roles" name="roles[]" class="form-control" multiple="multiple">
                                <option value=""></option>
                                <?php
                                // ambil data dari database
                                $roles = $this->db->get("m_user_roles where STATUS = '1'");
                                foreach ($roles->result() as $value){
                                ?>
                                <option value="<?php echo $value->ID_USER_ROLES;?>"><?php echo $value->DESCRIPTION;?></option>
                                <?php }?>
                            </select>
                        </div>-->
                        <div class="form-group">
                            <label class="form-label" for="formfield2"><?= lang('Judul', 'Title') ?></label>
                            <div class="controls">
                                <input name="email_title" id="email_title" class="form-control" type="text" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="formfield2"><?= lang('Pembuka', 'Opening') ?></label>
                            <div class="controls">
                               <textarea id="email_open" name="email_open" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="formfield2"><?= lang('Penutup', 'Closing') ?></label>
                            <div class="controls">
                               <textarea id="email_close" name="email_close" required></textarea>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" id="btnSave" class="btn btn-primary" onclick="save_email()"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function() {
  // $(".select_roles").hide();
  ajax_loader();
  CKEDITOR.replace('email_open', {
    toolbar: [
      { name: 'document', items: ['-', 'NewPage', 'Preview', '-', 'Templates', 'Bold', 'Italic' ] },  // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
      [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ]
    ]
  });
  CKEDITOR.replace('email_close', {
    toolbar: [
      { name: 'document', items: ['-', 'NewPage', 'Preview', '-', 'Templates', 'Bold', 'Italic' ] },  // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
      [ 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ]
    ]
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
  lang();

  var table=$('#tbl').DataTable({
    ajax: {
        url: '<?= base_url('vendor/master_email/show/'.$get_id) ?>',
        dataSrc: ''
    },
    scrollX: true,
    scrollY: '300px',
    scrollCollapse: true,
    paging: true,
    filter: true,
    info:true,
    columns: [
        {title: "<center>No</center>"},
        {title: "<center><?= lang('Judul', 'Title') ?></center>"},
        {title: "<center><?= lang('Pembuka', 'Opening') ?></center>"},
        {title: "<center><?= lang('Penutup', 'Closing') ?></center>"},
        {title: "<center><?= lang("Aksi", "Action") ?></center>", "width": "50px"},
    ],
    "columnDefs": [
        {"className": "dt-center", "targets": [0]},
        {"className": "dt-center", "targets": [1]},
        {"className": "dt-center", "targets": [2]},
        {"className": "dt-center", "targets": [3]},
        {"className": "dt-center", "targets": [4]},
    ]
  });
  $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column( $(this).data('index') )
      .search( this.value )
      .draw();
  });

    function email_temp(id) {
        $.ajax({
            url: "<?= base_url('vendor/master_email/show_email_temp/') ?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function (data) {
                // $('#ckeditor').val(data.ckeditor);
                CKEDITOR.instances.email_open.setData(data.open);
                CKEDITOR.instances.email_close.setData(data.close);
                // $('[name="grubmenu[]"]').val(data.grubmenu);
                // $('[name="roles[]"]').val(data.roles);
                // $('#roles').select2('val', d.ROLES.split(','));
                $('#id_email').val(data.id);
                // $('[name="kategori"]').val(data.category);
                // $('#open_edit').summernote('code', data.open);
                // $('[name="close_edit"]').val(data.close);
                $('#email_title').val(data.title);
                $('#Modal-email .modal-header').css('background-color',"#347ab5");
                $('#Modal-email .modal-header').css('color',"#fff");
                $('#Modal-email').modal('show');
                lang();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    }

    function email_new() {
        // $('#ckeditor').val(data.ckeditor);
        CKEDITOR.instances.email_open.setData("");
        CKEDITOR.instances.email_close.setData("");
        // $('[name="grubmenu[]"]').val(data.grubmenu);
        // $('[name="roles[]"]').val("");
        // $('#roles').select2('val', d.ROLES.split(','));
        $('#id_email').val(0);
        // $('[name="kategori"]').val("");
        // $('#open_edit').summernote('code', data.open);
        // $('[name="close_edit"]').val(data.close);
        $('#email_title').val("");
        $('#Modal-email .modal-header').css('background-color',"#347ab5");
        $('#Modal-email .modal-header').css('color',"#fff");
        $('#Modal-email').modal('show');
        lang();
    }

    function save_email() {
        var email_title = $('#email_title').val();
        var open_ck = CKEDITOR.instances.email_open.getData();
        var close_ck = CKEDITOR.instances.email_close.getData();
        if (email_title === '' || open_ck === '' || close_ck === '') {
            msg_danger('Tolong Lengkapi Form!');
        } else {
            CKEDITOR.instances.email_open.updateElement();
            CKEDITOR.instances.email_close.updateElement();
            if ($('#id_email').val() == 0) {
                var obj = $('#form-email').serializeArray();
                obj.push({name: 'email_cat', value: <?=$get_id;?>});
                $.ajax({
                    url: "<?= base_url('vendor/master_email/add_email') ?>" ,
                    type: "POST",
                    data: obj,
                    dataType: "JSON",
                    success: function (data) {
                        if (data.status) {
                            $('#Modal-email').modal('hide');
                            $('#tbl').DataTable().ajax.reload();
                        }
                        swal.close(),
                        msg_info('Sukses tersimpan');
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        swal.close(),
                        msg_danger('Gagal Tersimpan!');
                    }
                });
            } else {
                swal({
                    title: "Apakah kamu yakin?",
                    text: "Mengubah template email?",
                    type: "info",
                    showCancelButton: true,
                    confirmButtonColor: "#0479fc",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Tidak",
                    closeOnConfirm: false
                }, function () {
                    $.ajax({
                        url: "<?= base_url('vendor/master_email/update_email') ?>" ,
                        type: "POST",
                        data: $('#form-email').serialize(),
                        dataType: "JSON",
                        success: function (data) {
                            if (data.status) {
                                $('#Modal-email').modal('hide');
                                $('#tbl').DataTable().ajax.reload();
                            }
                            swal.close(),
                            msg_info('Sukses tersimpan');
                        },
                        error: function (jqXHR, textStatus, errorThrown) {
                            swal.close(),
                            msg_danger('Gagal Tersimpan!');
                        }
                    });
                });
            }
        }
    }
</script>
<script src="<?php echo base_url()?>ast11/filter/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/filter/scripts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
