<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Pengingat Dokumen Kadaluarsa", "Expired Document Reminder") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Manajemen Supplier", "Supplier Management") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Pengingat Dokumen Kadaluarsa", "Expired Document Reminder") ?></li>
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
                                            <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">

                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center><?= lang("Tipe Dokumen", "Document Type") ?></center></th>
                                                        <th><center><?= lang("Hari Peringatan", "Reminder Day") ?></center></th>
                                                        <th><center><?= lang("Hari Peringatan", "Reminder Day") ?></center></th>
                                                        <th><center><?= lang("Hari Peringatan", "Reminder Day") ?></center></th>
                                                        <th><center>Status</th>
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


<!--change data-->
<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class=" modal-content">
        <form id="formtambah" class="form-horizontal">
            <!--hide value-->
            <input type="hidden" name="iddoc" id="iddoc" value="">
            <!--end hide value-->
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="form-group">
                    <label class="form-label"><?= lang("Tipe Dokumen", "Document Type") ?></label>
                    <div class="controls">
                        <input type="text" name="type_doc" id="type_doc" class="form-control" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= lang("Hari Pengingat", "Reminder Day 1") ?></label>
                    <div class="controls">
                        <input type="number" name="reminder_day" id="reminder_day" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Hari Pengingat", "Reminder Day 2") ?></label>
                    <div class="controls">
                        <input type="number" name="reminder_day2" id="reminder_day2" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Hari Pengingat", "Reminder Day 3") ?></label>
                    <div class="controls">
                        <input type="number" name="reminder_day3" id="reminder_day3" class="form-control" required>
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
                <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                <button type="submit" class="btn btn-success" id="save"><?= lang('Simpan', 'Save') ?></button>
            </div>
        </form>
    </div>
  </div>
</div>

<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<script src="<?php echo base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {

    $(document).on('submit', '#formtambah', function (e) {
      e.preventDefault();
      $.ajax({
        url: '<?= base_url('vendor/Expired_doc_reminder/add_doc_type'); ?>',
        dataType: 'json',
        type: 'POST',
        data: $(this).serialize(),
        success: function (res) {
          if (res.success == true) {
            $('#modal').modal('hide');
            $('#tbl').DataTable().ajax.reload();
            msg_info('Sukses tersimpan');
          } else {
            msg_danger(res.message);
          }
        }
      });
    });

  });

  function add() {
    document.getElementById("formtambah").reset();
    $("#iddoc").val("");
    $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
    $('#modal').modal('show');
    document.getElementById("aktif").checked = true;
    lang();
  }

  function update(id) {
  $("#iddoc").val(id);

    $.ajax({
    type: 'POST',
    url: '<?= base_url('vendor/Expired_doc_reminder/show_edit/') ?>' + id,
    success: function (msg) {
        $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
        var msg = msg.replace("[", "");
        var msg = msg.replace("]", "");
        var d = JSON.parse(msg);

        $("#type_doc").val(d.document_type);
        $("#reminder_day").val(d.reminder_day);
        $("#reminder_day2").val(d.reminder_day2);
        $("#reminder_day3").val(d.reminder_day3);

        if (d.active == "1"){
          document.getElementById("aktif").checked = true;
        } else {
          document.getElementById("nonaktif").checked = true;
        }

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
  lang();

  var table=$('#tbl').DataTable({
    ajax: {
        url: '<?= base_url('vendor/Expired_doc_reminder/show_document') ?>',
        dataSrc: ''
    },
    scrollX: true,
    scrollY: '300px',
    scrollCollapse: true,
    paging: true,
    filter: true,
    info:true,
    fixedColumns: {
        leftColumns: 0,
        rightColumns: 1
    },
    columns: [
        {title: "<center>No</center>"},
        {title: "<center><?= lang('Tipe Dokumen', 'Document Type') ?></center>"},
        {title: "<center><?= lang('Hari Pengingat', 'Reminder Day 1') ?></center>"},
        {title: "<center><?= lang('Hari Pengingat', 'Reminder Day 2') ?></center>"},
        {title: "<center><?= lang('Hari Pengingat', 'Reminder Day 3') ?></center>"},
        {title: "<center><?= lang('Status', 'Status') ?></center>"},
        {title: "<center>Action</center>", "width": "50px"},
    ],
    "columnDefs": [
      {"className": "dt-center", "targets": [0]},
      {"className": "dt-center", "targets": [1]},
      {"className": "dt-center", "targets": [2]},
      {"className": "dt-center", "targets": [3]},
      {"className": "dt-center", "targets": [4]},
      {"className": "dt-center", "targets": [5]},
      {"className": "dt-center", "targets": [6]},
    ]
  });
  $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
          table.column( $(this).data('index') )
          .search( this.value )
          .draw();
  });

</script>
