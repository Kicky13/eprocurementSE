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
                <h3 class="content-header-title"><?= lang("Master Sub Grup Material", "Master Material Sub Group") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Sub Grup Material", "Material Sub Group") ?></li>
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
                                                <!--<button aria-expanded="false" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button>-->
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
                                                      <th><center>Group</th>
                                                      <th><center>Sub Group</center></th>
                                                      <th><center>Type</th>
                                                      <th><center>Status</th>
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
                      <option value="<?php echo $value->MATERIAL_GROUP."|".$value->TYPE;?>"><?php echo $value->DESCRIPTION;?></option>
                      <?php } ?>
                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= lang('Group Material', 'Material Group') ?></label>
                    <div class="controls">
                    <select id="mat_subgroup" name="mat_subgroup" required disabled>

                    </select>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label"><?= lang("Sub Grup Material", "Sub Material Group") ?></label>
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


<script type="text/javascript">
$(document).ready(function() {
  // $("#mat_subgroup").hide();

  // $("#mat_group").select2({
  //     placeholder: 'select',
  //     required : true,
  //     allowClear: true
  // }).on('select2-open', function() {
  //     // Adding Custom Scrollbar
  //     $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
  //     // $('#tbl').DataTable().ajax.reload();
  // });

  // $("#mat_subgroup").select2();

  $(document).on('change', '#mat_group', function(e) {
    e.preventDefault();
    // $("#mat_subgroup").closest('option').remove();
    var idnya = $(this).val();
    // alert(idnya)
    $("#mat_subgroup").prop('disabled', false);
    var result;
    $.ajax({
      url: '<?= base_url("material/Subcategory/getsubgroup") ?>',
      type: 'POST',
      dataType: '',
      data: {idnya: idnya}
    })
    .done(function() {
      result = true;
    })
    .fail(function() {
      result = false;
    })
    .always(function(res) {
      if (result == true) {
        $("#mat_subgroup").html(res);
        $("#mat_subgroup").val("").select2();
      }
    });
  });

  $("#formtambah").submit(function(e) {
    e.preventDefault();
    var result;
    $.ajax({
      url: '<?= base_url("material/Subcategory/save_subsubgrup")?>',
      type: 'post',
      dataType: 'json',
      data: $(this).serialize()
    })
    .done(function() {
      result = true;
    })
    .fail(function() {
      result = false;
    })
    .always(function(res) {
      if (result == true) {
        $('#modal').modal('hide');
        $('#tbl').DataTable().ajax.reload();
        msg_info('Save successfuly');
      } else {

      }
    });

  });

});

function add() {
  document.getElementById("formtambah").reset();
  $("#mat_subgroup").prop('disabled', true);
  $("#id_material").val("");
  $('#mat_group').select2('val', '');
  $('#mat_subgroup').select2('val', '');
  $('.modal-title').html("<?= lang("Tambah Data", "Add Data") ?>");
  $('#modal').modal('show');
  $('#id').val("");
  document.getElementById("aktif").checked = true;
  lang();
}

function update(id) {
$("#id_material").val(id);

$.ajax({
type: 'get',
url: '<?= base_url('material/Subcategory/get/') ?>' + id,
success: function (msg) {
    $('.modal-title').html("<?= lang("Edit Data", "Update Data") ?>");
    var msg = msg.replace("[", "");
    var msg = msg.replace("]", "");
    var d = JSON.parse(msg);
    // $('#id').val(d.idsub);
    $('#mat_group').select2('val', d.id2+"|"+d.type).trigger('change');
    setTimeout(function(){ $('#mat_subgroup').select2('val', d.id1); }, 500);
    // $('#mat_subgroup').select2('val', d.id2);
    // $('#mat_group').val(d.mgrup1+"|"+d.mtype1);
    $('#type').val(d.type);
    $('#desc').val(d.subdesc);
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

var table = $('#tbl').DataTable({
    ajax: {
        url: '<?= base_url('material/subcategory/show') ?>',
        dataSrc: ''
    },
    scrollX: true,
    scrollY: '300px',
    scrollCollapse: true,
    paging: true,
    info: true,
    searching: true,
    fixedColumns: {
        leftColumns: 0,
        rightColumns: 1
    },
    columns: [
        {title: "<center>No</center>", "width": "20px"},
        {title: "<center><?= lang("Klasifikasi", "Classification") ?></center>"},
        {title: "<center><?= lang("Grup", "Group") ?></center>"},
        {title: "<center><?= lang("Sub Group", "Sub Group") ?></center>"},
        {title: "<center><?= lang("Tipe", "Type") ?></center>"},
        {title: "<center><?= lang("Status", "Status") ?></center>"},
        {title: "<center>Action</center>"}
    ],
    "columnDefs": [
        {"className": "dt-right", "targets": [0]},
        {"className": "dt-center", "targets": [3]}
    ]
});
lang();

$(table.table().container() ).on( 'keyup', 'tfoot input', function () {
    table.column( $(this).data('index') ).search( this.value ).draw();
});

//select2
jQuery(function($) {

    if ($.isFunction($.fn.select2)) {

        $("#mat_subgroup").select2({
            placeholder: 'select',
            required : true,
            allowClear: true
        }).on('select2-open', function() {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
            // $('#tbl').DataTable().ajax.reload();
        });


    }

    if ($.isFunction($.fn.select2)) {

        $("#mat_group").select2({
            placeholder: 'select',
            required : true,
            allowClear: true
        }).on('select2-open', function() {
            // Adding Custom Scrollbar
            $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
            // $('#tbl').DataTable().ajax.reload();
        });


    }
});
</script>
<script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>

<script src="<?php echo base_url()?>ast11/filter/select2.min.js" type="text/javascript"></script>
<!-- <script src="<?php echo base_url()?>ast11/filter/scripts.js" type="text/javascript"></script> -->
<!-- <script src="<?php echo base_url()?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script> -->
<script src="<?php echo base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
