<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Pertukaran Mata Uang", "Exchange Rate") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengaturan", "Setting") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Pertukaran Mata Uang", "Exchange Rate") ?></li>
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
                                      <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">

                                          <tfoot>
                                              <tr>
                                                  <th><center>No</center></th>
                                                  <th><center>Currency from</center></th>
                                                  <th><center>Currency To</center></th>
                                                  <th><center>Amount from</center></th>
                                                  <th><center>Amount To</center></th>
                                                  <th><center>Valid from</center></th>
                                                  <th><center>Valid To</center></th>
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
                  <label class="form-label col-md-3"><?= lang("Nominal", "Amount From") ?></label>
                  <div class="col-md-6">
                    <input type="number" name="amount_from" id="amount_from" class="form-control" required="">
                  </div>
                  <div class="col-md-3">
                    <div class="controls">
                      <select class="form-control" name="currency_from" id="currency_from">
                        <?php foreach ($m_currency as $currency) : ?>
                        <option value="<?= $currency->ID ?>"><?= $currency->CURRENCY ?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-md-3"><?= lang("Nilai Konversi", "Currency To") ?></label>
                  <div class="col-md-6">
                    <input type="number" name="amount_to" id="amount_to" class="form-control" required="">
                  </div>
                  <div class="col-md-3">
                    <div class="controls">
                      <select class="form-control" name="currency_to" id="currency_to">
                        <?php foreach ($m_currency as $currency) : ?>
                        <option value="<?= $currency->ID ?>"><?= $currency->CURRENCY ?></option>
                        <?php endforeach;?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Tanggal Aktif", "Valid From") ?></label>
                    <div class="controls">
                      <input type="date" name="valid_from" id="valid_from" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang("Sampai Tanggal", "Valid To") ?></label>
                    <div class="controls">
                      <input type="date" name="valid_to" id="valid_to" class="form-control">
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
      url: '<?= base_url('setting/Currency/add_exchange_rate'); ?>',
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
      $("#currency_to").val(<?=$def->ID?>);
      $("#currency_to").attr("readonly","true");
      lang();
    }

    function update(id) {
    $("#id").val(id);
    $("#currency_to").removeAttr("readonly");
    $.ajax({
    type: 'GET',
    url: '<?= base_url('setting/Currency/get_exchange_rate/') ?>' + id,
    success: function (res) {
        $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
        // console.log(id);
        var res = res.replace("[", "");
        var res = res.replace("]", "");
        var d = JSON.parse(res);
        $('#currency_from').val(d.currency_from);
        $('#currency_to').val(d.currency_to);
        $('#amount_from').val(d.amount_from);
        $('#amount_to').val(d.amount_to);
        $('#valid_from').val(d.valid_from);
        $('#valid_to').val(d.valid_to);
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
          url: '<?= base_url('setting/Currency/exchange_rate_show') ?>',
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
          {title: "<center><?= lang('Nominal', 'Amount From') ?></center>"},
          {title: "<center><?= lang('Mata Uang', 'Currency From') ?></center>"},
          {title: "<center><?= lang('Nilai Konversi', 'Amount To') ?></center>"},
          {title: "<center><?= lang('Konversi Ke', 'Currency To') ?></center>"},
          {title: "<center><?= lang('Tanggal Aktif', 'Valid From') ?></center>"},
          {title: "<center><?= lang('Sampai Tanggal', 'Valid To') ?></center>"},
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
        {"className": "dt-center", "targets": [7]},
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
          url:"<?=base_url('setting/currency/delete_exchange_rate')?>",
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
