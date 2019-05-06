<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet">
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>

<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Master Grup Material", "Master Material Group") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Grup Material", "Material Group") ?></li>
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
                                            <table id="tbl" class="table nowrap table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">

                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center>Klasifikasi</center></th>
                                                        <th><center>Group Material</center></th>
                                                        <th><center>Nama Group</th>
                                                        <th><center>Tipe</center></th>
                                                        <th><center>Status</center></th>
                                                        <th><center>Action</center></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <!--<label class="form-group" style="font-weight:300" id="info">Showing 1 to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label>-->
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
            <input type="hidden" name="id_material" id="id_material" value="">
            <!--end hide value-->
            <div class="modal-header bg-primary white">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="form-label"><?= lang('Klasifikasi Material', 'Material Classification') ?></label>
                    <div class="controls">
                    <select id="mat_group" name="mat_group" required>
                      <?php
                      $mat_group = $this->db->get("m_material_group where CATEGORY = 'CLASIFICATION'");
                      foreach ($mat_group->result() as $value){
                      ?>
                      <option value="<?php echo $value->ID;?>"><?php echo $value->DESCRIPTION;?></option>
                      <?php } ?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= lang("Grup Material", "Material Group") ?></label>
                    <div class="controls">
                        <input type="text" name="desc" id="desc" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="form-label"><?= lang('Tipe', 'Type') ?></label>
                    <div class="controls">
                        <select name="type" id="type" class="form-control" required>
                            <option value="GOODS">Goods/Barang</option>
                            <option value="SERVICE">Service/Jasa</option>
                            <option value="CONSULTATION">Consultation/Konsultan</option>
                        </select>
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

<div id="modal-filter" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <div class=" modal-content">
            <form id="form" class="form-horizontal">
              <div class="modal-header bg-primary white">
                  <h4 class="modal-filter"></h4>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">×</span>
                  </button>
              </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="form-group">
                            <label class="form-label col-md-12" for="field-1"><?= lang('Klasifikasi Material', 'Material Classification') ?></label>
                            <div class="col-md-12">
                                <select style="width:100%" class="col-md-12" id="search_klas" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-12" for="field-1"><?= lang("Material Grup", "Group Material") ?></label>
                            <div class="col-md-12">
                                <select style="width:100%" class="col-md-12" id="search_desc" multiple data-role="tagsinput">
                                </select>
                            </div>
                            <label class="form-label col-md-12" for="field-1">Type</label>
                            <div class="col-md-12">
                                <div class="i-checks col-md-12">
                                    <label><input type="checkbox" value="GOODS" id="type_good"> <i></i> Goods/Barang </label>
                                </div>
                                <div class="i-checks col-md-12">
                                    <label><input type="checkbox" value="SERVICE" id="type_service"> <i></i> Service/Jasa </label>
                                </div>
                                <div class="i-checks col-md-12">
                                    <label><input type="checkbox" value="CONSULTATION" id="type_consultation"> <i></i> Consultation/Konsultasi </label>
                                </div>
                            </div>
                            <label class="form-label col-md-12" for="field-1">Status</label>
                            <div class="col-md-12">
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="aktif" id="status1"> <i></i> <?=lang("Aktif","Active")?> </label>
                                </div>
                                <div class="i-checks col-md-6">
                                    <label><input type="checkbox" value="tidak" id="status2"> <i></i> <?=lang("Tidak Aktif","NotActive")?> </label>
                                </div>
                            </div>
                            <hr>
                            <label class="form-label col-md-12" for="field-1"><?= lang("Batas Data", "Limit Data") ?></label>
                            <div class="col-md-12 m-b">
                                <div class="input-group">
                                    <input class="touchspin3" type="text" value="1" id="limit" name="demo3">
                                    <span class="input-group-addon" id="total"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" onclick="get()" data-dismiss="modal" class="btn btn-info" id="save"><?= lang('Filter', 'Filter') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript">
$(function () {
  $('.i-checks').iCheck({
  checkboxClass: 'icheckbox_square-green',
          radioClass: 'iradio_square-green',
  });

  $(".touchspin3").TouchSpin({
  verticalbuttons: true,
          buttondown_class: 'btn btn-white',
          buttonup_class: 'btn btn-white'
  });

  $(document).on('submit', '#formtambah', function (e) {
    e.preventDefault();
    $.ajax({
      url: '<?= base_url('material/Group/add_material_group'); ?>',
      dataType: 'json',
      type: 'POST',
      data: $(this).serialize(),
      success: function (res) {
        if (res.success == true) {
          $('#modal').modal('hide');
          $('#tbl').DataTable().ajax.reload();
          msg_info('Save successfuly');
        } else {
          msg_danger("Oops, Something Wrong!");
        }
      }
    });
  });

});

    function filter() {
      $('.modal-filter').html("<?= lang("Filter Data", "Filter Data") ?>");
      $('#total').text("dari " + "<?= (isset($total) != false ? $total : '0') ?>" + " Data");
      $('#modal-filter').modal('show');
      lang();
    }

    function add() {
      document.getElementById("formtambah").reset();
      $("#id_material").val("");
      $('#mat_group').select2('val', '0');
      $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
      $('#modal').modal('show');
      $('#id').val("");
      document.getElementById("aktif").checked = true;
      lang();
    }

    function update(id) {
    $("#id_material").val(id);

    $.ajax({
    type: 'POST',
    url: '<?= base_url('material/group/get/') ?>' + id,
    success: function (msg) {
        $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
        var msg = msg.replace("[", "");
        var msg = msg.replace("]", "");
        var d = JSON.parse(msg);
        $('#id').val(d.id2);
        $('#mat_group').select2('val', d.id1);
        // $('#mat_group').val(d.id1);
        $('#type').val(d.type);
        $('#desc').val(d.grupname);
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
          url: '<?= base_url('material/group/show') ?>',
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
          {title: "<center><?= lang('Klasifikasi', 'Classification') ?></center>"},
          {title: "<center><?= lang('Group Material', 'Material Group') ?></center>"},
          {title: "<center><?= lang('Nama Group', 'Group Name') ?></center>"},
          {title: "<center><?= lang('Tipe', 'Type') ?></center>"},
          {title: "<center><?= lang("Status", "Status") ?></center>", "width": "50px"},
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
    lang();

    //select2
    jQuery(function($) {

        if ($.isFunction($.fn.select2)) {

            $("#mat_group").select2({
                placeholder: 'select',
                required : true,
                allowClear: true
            }).on('select2-open', function() {
                // Adding Custom Scrollbar
                $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                $('#tbl').DataTable().ajax.reload();
            });


        }
    });
</script>
<script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>ast11/filter/select2.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/filter/scripts.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="<?php echo base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
