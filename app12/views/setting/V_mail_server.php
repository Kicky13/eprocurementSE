<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Mail Server", "Mail Server") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengaturan", "Setting") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Mail Server", "Mail Server") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
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
                                          <button aria-expanded="false" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></button>
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
                                                  <th><center>desc</center></th>
                                                  <th><center>desc</center></th>
                                                  <th><center>desc</center></th>
                                                  <th><center>desc</center></th>
                                                  <th><center>desc</center></th>
                                                  <th><center>status</center></th>
                                                  <th><center>aksi</center></th>
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
        </div>
  </div>
</div>



<!--change data-->
<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class=" modal-content">
        <form id="formtambah" class="form-horizontal">
            <!--hide value-->
            <input type="hidden" name="idx" id="idx" value="">
            <!--end hide value-->
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label"><?= lang("Email", "Email") ?></label>
                    <div class="controls">
                        <input type="email" name="email_address" id="email_address" class="form-control" maxlength="100" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("SMTP", "SMTP") ?></label>
                    <div class="controls">
                        <input type="text" name="smtp" id="smtp" class="form-control" maxlength="30" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Port", "Port") ?></label>
                    <div class="controls">
                        <input type="text" name="port" id="port" class="form-control" maxlength="9" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Protocol", "Protocol") ?></label>
                    <div class="controls">
                        <input type="text" name="protocol" id="protocol" class="form-control" maxlength="9" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Crypto", "Crypto") ?></label>
                    <div class="controls">
                        <input type="text" name="crypto" id="crypto" class="form-control" maxlength="4" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Password", "Password") ?></label>
                    <div class="controls">
                        <input type="password" name="email_password" id="email_password" class="form-control" maxlength="25" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Confirm Password", "Confirm Password") ?></label>
                    <div class="controls">
                        <input type="password" name="confirm_pass" id="confirm_pass" class="form-control" maxlength="25" required>
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

<script type="text/javascript">
$(document).ready(function() {
  input_numberic("#port", true);
  $(document).on('submit', '#formtambah', function (e) {
    e.preventDefault();
    var pass = $("#email_password").val();
    var pass_confirm = $("#confirm_pass").val();
    if (pass == pass_confirm) {
      $.ajax({
        url: '<?= base_url('setting/Mail_server/add'); ?>',
        dataType: 'json',
        type: 'POST',
        data: $(this).serialize(),
        success: function (res) {
          console.log(res);
          if (res.success == 1) {
            $('#modal').modal('hide');
            $('#tbl').DataTable().ajax.reload();
            msg_info('Success Save');
          } else if(res.success == 2){
            msg_danger("Kode Sudah Terpakai");
          } else {
            msg_danger("Something wrong, Please Call The Admin");
          }
        }
      });
    } else {
      msg_danger('Password Confirmation is not match!');
    }
  });

});

    function add() {
      document.getElementById("formtambah").reset();
      $("#idx").val("");
      $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
      $('#modal').modal('show');
      document.getElementById("aktif").checked = true;
      lang();
    }

    function update(id) {
    $("#idx").val(id);
    $.ajax({
    type: 'GET',
    url: '<?= base_url('setting/Mail_server/get/') ?>' + id,
    success: function (res) {
        $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
        // console.log(id);
        var res = res.replace("[", "");
        var res = res.replace("]", "");
        var d = JSON.parse(res);
        $('#email_address').val(d.email_address);
        $('#smtp').val(d.smtp);
        $('#port').val(d.port);
        $('#protocol').val(d.protocol);
        $('#crypto').val(d.crypto);
        $('#email_password').val(d.email_password);
        $('#confirm_pass').val("");
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
      $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
    });
    lang();

    var table=$('#tbl').DataTable({
      ajax: {
          url: '<?= base_url('setting/Mail_server/show') ?>',
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
          {title: "<center><?= lang('Email', 'Email') ?></center>"},
          {title: "<center><?= lang('SMTP', 'SMTP') ?></center>"},
          {title: "<center><?= lang('Port', 'Port') ?></center>"},
          {title: "<center><?= lang('Protocol', 'Protocol') ?></center>"},
          {title: "<center><?= lang('Crypto', 'Crypto') ?></center>"},
          {title: "<center><?= lang("Status", "Status") ?></center>", "width": "50px"},
          {title: "<center><?= lang("Aksi", "Action") ?></center>", "width": "50px"},
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
      ]
    });
    $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
            table.column( $(this).data('index') )
            .search( this.value )
            .draw();
    });
    lang();

</script>
