<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<script src="<?= base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Master Budget Holder Approval", "Master Budget Holder Approval") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengaturan", "Setting") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Master Budget Holder Approval", "Master Budget Holder Approval") ?></li>
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
                                                  <th><center>code</center></th>
                                                  <th><center>code</center></th>
                                                  <th><center>code</center></th>
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
<div class="modal fade" id="modal" data-backdrop="static" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
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
                    <label class="form-label"><?= lang("User", "User") ?></label>
                    <div class="controls">
                      <select class="form-control id_user" name="id_user" required>
                        <option value=""> Select .. </option>
                        <?php
                        foreach ($get_user as $arr) { ?>
                          <option value="<?= $arr['ID_USER']?>"><?= $arr['NAME'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Cost Center", "Cost Center") ?></label>
                    <div class="controls">
                      <select class="form-control costcenter" name="costcenter" required>
                        <option value=""> Select .. </option>
                        <?php
                        foreach ($get_costcenter as $arr) { ?>
                          <option value="<?= $arr['ID_COSTCENTER']?>"><?= $arr['ID_COSTCENTER']." - ".$arr['COSTCENTER_DESC'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label">Status</label>
                    <div class="controls">
                        <div class="col-sm-10">
                            <input type="radio" value="1" name="status" id="aktif"> <i></i><?= lang('Aktif', 'Enable') ?>
                            &nbsp;&nbsp;&nbsp;
                            <input type="radio" value="0" name="status" id="nonaktif"> <i></i><?= lang('Nonaktif', 'Disable') ?>
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
  $("select").select2({ "width": "100%" });

  if ($.isFunction($.fn.select2)) {
      $("#optmaterial_uom").select2({
          placeholder: 'select',
          required : true,
          allowClear: true
      }).on('select2-open', function() {
          // Adding Custom Scrollbar
          $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
          // $('#tbl').DataTable().ajax.reload();
      });
  }


  $(document).on('submit', '#formtambah', function (e) {
    e.preventDefault();
    var check = $(".costcenter").is(':disabled');
    $(".costcenter").prop('disabled', false);
    var obj = $(this).serialize();
    if (check)
      $(".costcenter").prop('disabled', true);
    $.ajax({
      url: '<?= base_url('setting/budget_holder/add'); ?>',
      dataType: 'json',
      type: 'POST',
      data: obj,
      success: function (res) {
        if (res.success == 1) {
          $('#modal').modal('hide');
          $('#tbl').DataTable().ajax.reload();
          msg_info('Success Save');
        } else if(res.success == 2){
          msg_danger("Data Already Exist!");
        } else {
          msg_danger("Something wrong, Please Call The Admin");
        }
      }
    });
  });

  // $.ajax({
  //   url: '<?= base_url('setting/budget_holder/m_costcenter_exist')?>',
  //   type: 'POST',
  //   dataType: 'JSON',
  // })
  // .done(function() {
  //   console.log("success");
  // })
  // .fail(function() {
  //   console.log("error");
  // })
  // .always(function(res) {
  //   if (res == true) {
  //     console.log(res);
  //     $(".costcenter option").attr('disabled', false);
  //     $.each(res, function(al, el) {
  //       $(".costcenter option[value='"+el.costcenter_exist.ID_COSTCENTER+"']").attr('disabled',true);
  //     });
  //   }
  // });


});

    function add() {
      $(".costcenter").prop('disabled', false);
      document.getElementById("formtambah").reset();
      $("#idx").val("");
      $(".id_user").val("").select2({ "width": "100%" });
      $(".costcenter").val("").select2({ "width": "100%" });
      $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
      $('#modal').modal('show');
      document.getElementById("aktif").checked = true;
      lang();
    }

    function update(cc, id) {
    $(".costcenter").prop('disabled', true);
    document.getElementById("formtambah").reset();
    $("#idx").val(id);
    var obj = {};
    obj.cc = cc;
    obj.id = id;
    $.ajax({
    type: 'POST',
    url: '<?= base_url('setting/budget_holder/get') ?>',
    data: obj,
    success: function (res) {
        $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
        // console.log(id);
        var res = res.replace("[", "");
        var res = res.replace("]", "");
        var d = JSON.parse(res);
        $(".id_user").val(d.id_user).select2({ "width": "100%" });
        $(".costcenter").val(d.cost_center).select2({ "width": "100%" });

        if (d.status == "1"){
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
          url: '<?= base_url('setting/budget_holder/show') ?>',
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
          {title: "<center><?= lang('Costcenter', 'Costcenter') ?></center>"},
          {title: "<center><?= lang('Description', 'Description') ?></center>"},
          {title: "<center><?= lang('User', 'User') ?></center>"},
          {title: "<center><?= lang("Status", "Status") ?></center>", "width": "50px"},
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
    $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
            table.column( $(this).data('index') )
            .search( this.value )
            .draw();
    });
    lang();

</script>
