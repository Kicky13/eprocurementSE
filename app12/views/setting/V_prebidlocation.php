<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Pre Bid Location", "Pre Bid Location") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengaturan", "Setting") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Pre Bid Location", "Pre Bid Location") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body" id="ctn">
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
                                                  <th><center>Location Name</center></th>
                                                  <th><center>Address</center></th>
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
        </div>
  </div>
</div>



<!--change data-->
<div class="modal fade" id="modal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="ultraModal-Label" aria-hidden="true">
    <div class="modal-dialog">
      <div class=" modal-content">
        <form id="formtambah" class="form-horizontal">
            <!--hide value-->
            <input type="hidden" name="id" id="id" value="">
            <!--end hide value-->
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                  <label class="form-label col-md-3"><?= lang("Nama Lokasi", "Location Name") ?></label>
                  <div class="col-md-9">
                    <input name="nama" id="nama" class="form-control" required="">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3"><?= lang("Alamat", "Address") ?></label>
                  <div class="col-md-9">
                    <input type="text" name="alamat" id="alamat" class="form-control" required="">
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
  $(document).on('submit', '#formtambah', function (e) {
    e.preventDefault();
    $.ajax({
      url: '<?= base_url('setting/prebidlocaiton/add'); ?>',
      dataType: 'json',
      type: 'POST',
      data: $(this).serialize(),
      success: function (res) {
        if(res.status)
        {
          msg_info(res.msg);
        }
        else
        {
          msg_danger(res.msg);
        }
        $('#tbl').DataTable().ajax.reload();
        $('#modal').modal('hide');
      }
    });
  });

});

    function add() {
      document.getElementById("formtambah").reset();
      $("#id").val("");
      $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
      $('#modal').modal('show');
      lang();
    }

    function update(id) {
    $("#id").val(id);
    $.ajax({
    type: 'GET',
    url: '<?= base_url('setting/prebidlocaiton/get/') ?>' + id,
    success: function (res) {
        $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
        // console.log(id);
        var res = res.replace("[", "");
        var res = res.replace("]", "");
        var d = JSON.parse(res);
        $('#nama').val(d.nama);
        $('#alamat').val(d.alamat);
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
          url: '<?= base_url('setting/prebidlocation/show') ?>',
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
          {title: "<center><?= lang('Nama Lokasi', 'Location Name') ?></center>"},
          {title: "<center><?= lang('Alamat', 'Address') ?></center>"},
          {title: "<center><?= lang("Aksi", "Action") ?></center>", "width": "50px"},
      ],
      "columnDefs": [
        {"className": "dt-center", "targets": [0]},
        {"className": "dt-center", "targets": [1]},
        {"className": "dt-center", "targets": [2]},
        {"className": "dt-center", "targets": [3]},
      ]
    });
    $(table.table().container() ).on( 'keyup', 'tfoot input', function () {
            table.column( $(this).data('index') )
            .search( this.value )
            .draw();
    });
    function delEx(id) {
      if(confirm('Are you sure want to delete it?'))
      {
        $.ajax({
          type:'post',
          data:{id:id},
          url:"<?=base_url('setting/prebidlocaiton/delete')?>",
          beforeSend:function(){
            start($("#ctn"));
          },
          success:function(){
            alert('Success');
            $('#tbl').DataTable().ajax.reload();
            stop($("#ctn"));
          }
        })
      }
    }
    lang();

</script>
