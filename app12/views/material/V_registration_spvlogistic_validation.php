<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Persetujuan Material", "Material Approvement") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Persetujuan Material", "Material Approvement") ?></li>
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
                                            <!-- <h5 class="title pull-right">
                                                <button aria-expanded="false" onclick="filter()" id="filter" class="btn btn-info"><i class="fa fa-filter"></i> <?= lang("Filter", "Filter") ?></button>
                                                <button aria-expanded="false" onclick="add()" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></button>
                                            </h5> -->
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
                                                    <th><center>No</center></th>
                                                    <th><center>Req No</center></th>
                                                    <th><center>Description Material</center></th>
                                                    <th><center>Material UOM</center></th>
                                                    <th><center>Status</center></th>
                                                    <th><center><?= lang("Aksi", "Action") ?></center></th>
                                                </tfoot>
                                            </table>
                                            <!-- <label class="form-group" style="font-weight:300" id="info">Showing 1 to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label> -->
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



<!-- MODAL PROSES -->
<div id="myModal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class=" modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
                <div class="modal-body">
                  <!-- main1 -->
                  <div class="main1">
    <!--- ////////////////////////////////////////////////// Form Logistic Specialist //////////////////////////////////////////-->
                  <form class="form-horizontal m_registration_catalog" id="form" enctype="multipart/form-data">
                    <input type="hidden" id="material" name="material" value="">
                    <input type="hidden" id="kodematerial" name="kodematerial" value="">
                    <div class="media">
                      <div class="media-body text-right">
                        <center>
                        <a class="media-right" id="showuser">
                          <img class="media-object rounded-circle" src="<?= base_url()?>ast11/img/iconuser.png" alt="Generic placeholder image" style="width: 64px;height: 64px;">
                        </a>
                        <h5><?= lang('Tampilkan User Input', 'Display User Input')?></h5>
                      </center>
                      </div>
                    </div>

                    <div class="card-footer border-2 text-muted mt-2">
                      <div class="form-group row">
                        <label class="col-md-2"><?= lang("Nama Material", "Material Name") ?></label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <input class="form-control" id="m_name" name="m_name" rows="5" maxlength="30" disabled required/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2"><?= lang("Deskripsi Material", "Material Description") ?></label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-12">
                              <div class="form-group">
                                <textarea class="form-control" id="m_desc_cataloguing" name="m_desc_cataloguing" rows="5" maxlength="500" disabled required></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Material UOM</label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <select class="form-control" name="optmaterial_uom2" id="optmaterial_uom2" disabled required>

                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Equipment Group ID <br><small><i>Group</i></small> </label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <select class="form-control" name="equipment_id" id="equipment_id" disabled required>

                                </select>
                              </div>
                            </div>
                            <div class="col-md-1">
                              <!-- <div class="form-group">
                                <input type="text" id="" name="" value="" class="form-control ff" required/>
                              </div> -->
                            </div>
                            <div class="row">
                              <label class="col-md-6 text-left">Equipment No</label>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <input type="text" id="equipment_no" name="equipment_no" maxlength="2" value="" class="form-control ff" disabled required/>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Manufacturer <br><small><i>Sub Group</i></small> </label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-2">
                              <div class="form-group">
                                <input type="text" id="no_manufacturer" name="no_manufacturer" aria-describedby="sizing-addon2" maxlength="2" value="" class="form-control ff" disabled required/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <input type="text" id="name_manufacturer" name="name_manufacturer" value="" class="form-control ff" disabled required/>
                              </div>
                            </div>
                            <div class="col-md-1">
                              <!-- <div class="form-group">
                                <input type="text" id="" name="" value="" class="form-control ff" required/>
                              </div> -->
                            </div>
                            <div class="row">
                              <label class="col-md-6 text-left">Part No &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                              <div class="col-md-6">
                                <div class="form-group">
                                  <input type="text" id="part_no" name="part_no" value="" maxlength="2" class="form-control ff" disabled required/>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Model /Type <br><small><i>Sub-Sub Group</i></small> </label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-2">

                              <div class="form-group">
                                <input type="text" id="model_type_no" name="model_type_no" maxlength="2" value="" class="form-control ff" disabled required/>
                              </div>
                            </div>
                            <div class="col-md-4">

                              <div class="form-group">
                                <input type="text" id="model_type_name" name="model_type_name" value="" class="form-control ff" disabled required/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Sequence Group <br><small><i>Sequence Group</i></small> </label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-2">

                              <div class="form-group">
                                <input type="text" id="squence_group_no" name="squence_group_no" maxlength="3" value="" class="form-control ff" disabled required/>
                              </div>
                            </div>
                            <div class="col-md-4">
                              <div class="form-group">
                                <input type="text" id="squence_group_name" name="squence_group_name" value="" class="form-control ff" disabled required/>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2"><?= lang("Indikator Material", "Material Indicator") ?> <br><small><i>Indicator Group</i></small> </label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group">
                                <select class="form-control" name="material_indicator" id="material_indicator" disabled required>

                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Stock Class</label>
                        <div class="col-md-10">
                          <div class="row">
                            <?php
                              foreach ($material_stackclass as $arr) { ?>
                                <div class="col-md-2">
                                  <fieldset class="form-group">
                                    <div class="i-checks col-md-12">
                                        <label><input type="checkbox" name="stockclass[]" value="<?= $arr['id']; ?>" id="stockclass<?= $arr['id']; ?>" disabled><small><b> <?= lang($arr['desc_in'], $arr['desc_en'] );?></b></small> </label>
                                    </div>
                                  </fieldset>
                                </div>
                              <?php }
                             ?>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2"><?= lang("Ketersediaan", "Availability") ?></label>
                        <div class="col-md-10">
                          <div class="row">
                            <?php
                              foreach ($material_avalable as $arr) { ?>
                                <div class="col-md-2">
                                  <fieldset class="form-group">
                                    <div class="i-checks col-md-12">
                                        <label><input type="checkbox" name="available[]" value="<?= $arr['id']; ?>" id="available<?= $arr['id']; ?>" disabled><small><b> <?= lang($arr['desc_in'], $arr['desc_en'] );?></b></small> </label>
                                    </div>
                                  </fieldset>
                                </div>
                              <?php }
                             ?>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Cricatility</label>
                        <div class="col-md-10">
                          <div class="row">
                            <?php
                              foreach ($material_criticaly as $arr) { ?>
                                <div class="col-md-2">
                                  <fieldset class="form-group">
                                    <div class="i-checks col-md-12">
                                        <label><input type="checkbox" name="critical[]" value="<?= $arr['id']; ?>" id="critical<?= $arr['id']; ?>" disabled><small><b> <?= lang($arr['desc_in'], $arr['desc_en'] );?></b></small> </label>
                                    </div>
                                  </fieldset>
                                </div>
                              <?php }
                             ?>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Material Image</label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group" id="material_image2">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2">Material Drawing</label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group" id="material_drawing2">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="col-md-2"><?= lang("Lainya", "Others") ?></label>
                        <div class="col-md-10">
                          <div class="row">
                            <div class="col-md-6">
                              <div class="form-group" id="material_other2">

                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <!-- main2 -->
                  <div class="main2">
                  <div class="media">
                    <div class="media-body text-right">
                      <center>
                      <a class="media-right" id="showspv">
                        <img class="media-object rounded-circle" src="<?= base_url()?>ast11/img/arrow-back-icon.png" alt="Generic placeholder image" style="width: 64px;height: 64px;">
                      </a>
                      <h5><?= lang('Kembali', 'Back')?></h5>
                    </center>
                    </div>
                  </div>
    <!--- ////////////////////////////////////////////////// Show requestor //////////////////////////////////////////-->
                  <div class="card-footer border-2 text-muted mt-2">
                    <div class="form-group row">
                      <label class="col-md-2"><?= lang("Deskripsi Material", "Material Description") ?></label>
                      <div class="col-md-10">
                        <div class="row">
                          <div class="col-md-12">
                            <div class="form-group">
                              <textarea class="form-control" id="m_desc" name="m_desc" rows="5" maxlength="500" value="" disabled></textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-2">Material UOM</label>
                      <div class="col-md-10">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <input type="text" id="optmaterial_uom" name="optmaterial_uom" value="" class="form-control ff" disabled/>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                  <label class="col-md-2">User Requestor</label>
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" id="user_requestor" name="user_requestor" value="" class="form-control ff" disabled/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-md-2">Departement Requestor</label>
                  <div class="col-md-10">
                    <div class="row">
                      <div class="col-md-6">
                        <div class="form-group">
                          <input type="text" id="department_requestor" name="department_requestor" value="" class="form-control ff" disabled/>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                    <div class="form-group row">
                      <label class="col-md-2">Material Image</label>
                      <div class="col-md-10">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group" id="material_image">

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-2">Material Drawing</label>
                      <div class="col-md-10">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group" id="material_drawing">

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="form-group row">
                      <label class="col-md-2"><?= lang("Lainya", "Others") ?></label>
                      <div class="col-md-10">
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group" id="material_other">

                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" class="btn btn-info" id="save"><?= lang('Setujui', 'Approve') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--reject-->
<div id="modal_rej" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="reject_mdl">
            <div class="modal-header">
                <?= lang("Tolak Data", "Reject Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input style="display:none" name="id_vendor" class="id_vendor" hidden>
                    <input style="display:none" name="email" class="email" hidden>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                            <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                            <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note" required></textarea>
                            <input type="hidden" id="idnya" name="idnya" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-danger"><?= lang("Tolak Data", "Reject Data") ?></button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    // ajax_loader("#myModal");

    simple_ckeditor('m_desc');
    simple_ckeditor('m_desc_cataloguing');
    $(".main2").hide();

    $("#showuser").on('click', function() {
      $(".main2").show();
      $(".main1").hide();
    });

    $("#showspv").on('click', function() {
      $(".main2").hide();
      $(".main1").show();
    });


    $(document).on('show.bs.modal', '#myModal', function(e){
      var xmodalx = modal_start($("#myModal").find(".modal-content"));

      // e.preventDefault();
      document.getElementById("form").reset();
      $("input[type=checkbox]").attr('checked', false);
      // var content = CKEDITOR.instances['m_desc_cataloguing'].setData("");

      $('.modal-title').html("<?= lang("Formulir Pendaftaran", "Form Registration Material") ?>");
      $('#myModal .modal-header').css('background-color', "#1c84c6");
      $('#myModal .modal-header').css('color', "#fff");
      lang();

      var idnya = $(e.relatedTarget).data("id");
      // generatecode
      $.ajax({
        url: '<?= base_url('material/Registration_spvlogistic_validation/material_code') ?>',
        dataType: 'json',
        type: 'get',
        data: {idnya: idnya},
        success: function(res){
          // console.log(res.group);
          if (res.group.length == 1) { var group = '0'+res.group; } else { var group = res.group; }
          if (res.sub_group.length == 1) { var sub_group = '0'+res.sub_group; } else { var sub_group = res.sub_group; }
          if (res.subsub_group.length == 1) { var subsub_group = '0'+res.subsub_group; } else { var subsub_group = res.subsub_group; }
          if (res.sequence_group.length == 1) { var sequence_group = '00'+res.sequence_group; } else if(res.sequence_group.length == 2){ var sequence_group = '0'+res.sequence_group; } else { var sequence_group = res.sequence_group; }
          if (res.indicator_group.length == 1) { var indicator_group = '0'+res.indicator_group; } else { var indicator_group = res.indicator_group; }
          if (res.max_id.toString().length == 1) { var maxid = '00'+res.max_id; } else if (res.max_id.toString().length == 2){ var maxid = '0'+res.max_id; } else { var maxid = res.max_id; }

          var kodenya = group+"."+sub_group+"."+subsub_group+"."+sequence_group+"."+res.indicator_group;
          $("#kodematerial").val(kodenya);
          console.log(kodenya);
          // alert(group+"."+sub_group+"."+subsub_group+"."+sequence_group+"."+res.indicator_group+"."+maxid);
          // console.log(group+"."+sub_group+"."+subsub_group+"."+sequence_group+"."+res.indicator_group+"."+maxid);
          modal_stop(xmodalx);
        }
      })

      // showdata
      $.ajax({
        url: '<?= base_url('material/registration_spvuser_validation/get_data_requestor') ?>',
        dataType: 'json',
        type: 'post',
        data: {
          idnya: idnya
        },
        success: function(res){
          $.each(res, function(index, el) {
            var content2 = CKEDITOR.instances['m_desc_cataloguing'].setData(el.description1);
            var content = CKEDITOR.instances['m_desc'].setData(el.description);

            $('#user_requestor').val(el.name);
            $('#department_requestor').val(el.department_desc);
            // main1
            $("#m_name").val(el.material_name)
            $("#optmaterial_uom2").html('<option>'+el.uom1+'</option>')
            $("#equipment_id").html('<option>'+el.eqp_desc+'</option>')
            $("#equipment_no").val(el.equipment_no)
            $("#no_manufacturer").val(el.manufacturer)
            $("#name_manufacturer").val(el.manufacturer_desc)
            $("#part_no").val(el.part_no)
            $("#model_type_no").val(el.material_type)
            $("#model_type_name").val(el.material_type_desc)
            $("#squence_group_no").val(el.sequence_group)
            $("#squence_group_name").val(el.sequence_group_desc)
            $("#material_indicator").html('<option>'+el.indicator_desc+'</option>')
            $("#material_image2").html('<a data-lightbox="lightboxmain" data-title="MATERIAL IMAGE" href="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img3_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/img/small/small_'+el.img3_url+'"></a>')
            $("#material_drawing2").html('<a data-lightbox="lightboxmain" data-title="MATERIAL IMAGE" href="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img4_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/img/small/small_'+el.img4_url+'"></a>')
            if (el.file_url2 == "" || el.file_url2 == "-") {
              $("#material_other2").html('<a href="#"> No File </a>')
            } else {
              var formatid = el.file_url2.split(".").pop();
              if (formatid == 'jpg' || formatid == 'jpeg' || formatid == 'png' || formatid == 'gif') {
                  $("#material_other2").html('<a data-lightbox="lightbox" data-title="MATERIAL IMAGE" href="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url2+'"><img src="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url2+'"></a>')
              } else {
                  $("#material_other2").html('<a href="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url2+'" target="_blank" >Show File</a>')
              }
            }

            var stockclass = el.stock_class.split('|');
            for (var i = 0; i < stockclass.length; i++) {
              $("#stockclass"+stockclass[i]).attr('checked', 'checked');
              $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green',
              });
            }

            var available = el.availability.split('|');
            for (var i = 0; i < available.length; i++) {
              $("#available"+available[i]).attr('checked', 'checked');
              $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green',
              });
            }
            var critical = el.criticality.split('|');
            for (var i = 0; i < critical.length; i++) {
              $("#critical"+critical[i]).attr('checked', 'checked');
              $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green',
              });
            }

            // main2
            $("#material").val(el.material)
            $("#optmaterial_uom").val(el.uom)
            $("#material_image").html('<a data-lightbox="lightbox" data-title="MATERIAL IMAGE" href="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img1_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/img/small/small_'+el.img1_url+'"></a>')
            $("#material_drawing").html('<a data-lightbox="lightbox" data-title="MATERIAL IMAGE" href="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img2_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/img/small/small_'+el.img2_url+'"></a>')

            if (el.file_url == "" || el.file_url == "-") {
              $("#material_other").html('<a href="#"> No File </a>')
            } else {
              var formatid = el.file_url.split(".").pop();
              if (formatid == 'jpg' || formatid == 'jpeg' || formatid == 'png' || formatid == 'gif') {
                  $("#material_other").html('<a data-lightbox="lightbox" data-title="MATERIAL IMAGE" href="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'"></a>')
              } else {
                  $("#material_other").html('<a href="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'" target="_blank" >Show File</a>')
              }
            }
          });

          modal_stop(xmodalx);
        }
      })


      $(document).on('click', '#save', function(e) {
        $("#material").val()
        e.preventDefault();
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this imaginary file!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#0072cf',
          confirmButtonText: 'Yes, Approve it!',
          closeOnConfirm: false,
          //closeOnCancel: false
        },
        function(){
          var elm = modal_start($('.sweet-alert'));
          $.ajax({
            url: '<?= base_url('material/Registration_spvlogistic_validation/approve_request_material') ?>',
            dataType: 'json',
            type: 'post',
            data: {
              idnya: idnya,
              note: 'Registrasi Material Disetujui Dengan SMIC Code : '+$("#kodematerial").val(),
              kodematerial: $("#kodematerial").val(),
      			  MATERIAL_NAME :$("#m_name").val(),
      			  DESCRIPTION : CKEDITOR.instances['m_desc_cataloguing'].getData(),
      			  MATERIAL_CODE :$("#kodematerial").val(),
      			  ID :idnya,
      			  UOM :$("#optmaterial_uom2").val()
            },
            success: function(res){
              if (res == true) {
                modal_stop(elm);
                setTimeout(function() {
                    swal({
                        title: 'Approve Material Registration Success',
                        text: 'Registration Material Approved With SMIC Code :'+$("#kodematerial").val(),
                        type: "success"
                    }, function() {
                      window.location.href = "<?=base_url('material/Registration_spvlogistic_validation')?>";
                    });
                }, 1000);
              } else {
                modal_stop(elm);
                setTimeout(function() {
                    swal({
                        title: 'Approve Material Registration Failed',
                        text: 'Registration Material Is Failed - JDE ERROR, Please Try Again or Contact administrator !',
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonColor: '#d9534f',
                        confirmButtonText: 'Close',
                    }, function() {
                      window.location.href = "<?=base_url('material/Registration_spvlogistic_validation')?>";
                    });
                }, 1000);
              }

            }
          })
        });
      });

    });

    // reject
    $(document).on('show.bs.modal', '#modal_rej', function(e) {
      document.getElementById("reject_mdl").reset();
      var idnya = $(e.relatedTarget).data("id");
      $("#idnya").val(idnya)
      $('#modal_rej .modal-header').css("background", "#d9534f");
      $('#modal_rej .modal-header').css("color", "#fff");

      // submit reject
      $('#reject_mdl').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData(this);
        // alert(idnya)
        swal({
          title: "Are you sure?",
          text: "You will not be able to recover this imaginary file!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: '#DD6B55',
          confirmButtonText: 'Yes, Reject it!',
          closeOnConfirm: false,
          //closeOnCancel: false
        },
        function(){
          var elm = modal_start($('.sweet-alert'));
          $.ajax({
            url: '<?= base_url('material/Registration_spvuser_validation/reject_request_catalog') ?>',
            dataType: 'json',
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(res){
              window.location.href = "<?=base_url('material/Registration_spvlogistic_validation')?>";
            }
          })
        });
      });

    });

    // show data
    $('#tbl tfoot th').each(function (i) {
        var title = $('#tbl thead th').eq($(this).index()).text();
        $(this).html('<input type="text" placeholder="Search ' + title + '" data-index="' + i + '" />');
    });
    var table=$('#tbl').DataTable({
        "ajax": {
            "url": "<?= base_url('material/Registration_spvlogistic_validation/datatable_persetujuan_material') ?>",
            "dataSrc": ""
        },
        "paging":true,
        "columns": [
            {title: "<center>No</center>"},
            {title: "<center>Request No</center>"},
            {title: "<center><?= lang("Nama Material", "Material Name") ?></center>"},
            {title: "<center>Material UOM</center>"},
            {title: "<center>Status</center>"},
            {title: "<center><?= lang("Aksi", "Action") ?></center>"}
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
        ]
    });
    $(table.table().container()).on('keyup', 'tfoot input', function () {
        table.column($(this).data('index'))
        .search(this.value)
        .draw();
    });

  });
</script>
