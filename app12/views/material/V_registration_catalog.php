<!-- <link rel="stylesheet" href="<?= base_url()?>ast11/assets/css/style.css"> -->
<style media="screen">

.ui-autocomplete-input {
  z-index: 500;
  position: relative;
  }
  .ui-menu .ui-menu-item a {
  font-size: 12px;
  }
  .ui-autocomplete {
  position: absolute;
  top: 0;
  left: 0;
  z-index: 1510 !important;
  float: left;
  display: none;
  min-width: 160px;
  width: 160px;
  padding: 4px 0;
  margin: 2px 0 0 0;
  list-style: none;
  background-color: #ffffff;
  border-color: #ccc;
  border-color: rgba(0, 0, 0, 0.2);
  border-style: solid;
  border-width: 1px;
  -webkit-border-radius: 2px;
  -moz-border-radius: 2px;
  border-radius: 2px;
  -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
  -webkit-background-clip: padding-box;
  -moz-background-clip: padding;
  background-clip: padding-box;
  *border-right-width: 2px;
  *border-bottom-width: 2px;
  }
  .ui-menu-item > a.ui-corner-all {
    display: block;
    padding: 3px 15px;
    clear: both;
    font-weight: normal;
    line-height: 18px;
    color: #555555;
    white-space: nowrap;
    text-decoration: none;
  }
  .ui-state-hover, .ui-state-active {
      color: #ffffff;
      text-decoration: none;
      background-color: #0088cc;
      border-radius: 0px;
      -webkit-border-radius: 0px;
      -moz-border-radius: 0px;
      background-image: none;
  }
</style>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Registrasi Katalog", "Catalouging Registration") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Registrasi Katalog", "Catalouging Registration") ?></li>
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
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center>Req No</center></th>
                                                        <th><center>Description Material</center></th>
                                                        <th><center>Material UOM</center></th>
                                                        <th><center>Status</center></th>
                                                        <th><center><?= lang("Aksi", "Action") ?></center></th>
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

<div id="myModal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class=" modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1"></h4>
                <button type="button" class="close closemyModal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
                <div class="modal-body">
<!--- ////////////////////////////////////////////////// Show requestor //////////////////////////////////////////-->
              <div class="card-footer border-2 text-muted mt-2">
                <div class="form-group row">
                  <label class="col-md-2"><?= lang("Desktipsi Material", "Materaial Description") ?></label>
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
                  <label class="col-md-2"><?= lang("Lainya", "Other") ?></label>
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
<!--- ////////////////////////////////////////////////// Form Logistic Specialist //////////////////////////////////////////-->
              <form class="form-horizontal m_registration_catalog" id="form" enctype="multipart/form-data">
                <input type="hidden" id="material" name="material" value="">
                <div class="card-footer border-2 text-muted mt-2">
                  <div class="form-group row">
                    <label class="col-md-2"><?= lang("Nama Material", "Materaial Name") ?></label>
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <input class="form-control" id="m_name" name="m_name" rows="5" maxlength="30" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-2"><?= lang("Deskripsi Material", "Materaial Description") ?></label>
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <textarea class="form-control" id="m_desc_cataloguing" name="m_desc_cataloguing" rows="5" maxlength="500" required></textarea>
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
                            <select class="form-control" name="optmaterial_uom2" id="optmaterial_uom2" style="width: 350px !important;" required>
                              <option value="">Select </option>
                              <?php
                              foreach ($material_uom as $arr) { ?>
                                  <option value="<?= $arr['material_uom']; ?>"><?= $arr['material_uom']; ?></option>
                              <?php } ?>
                            </select>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-2">Clasification <br><small><i>Clasification</i></small> </label>
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <select class="form-control" name="clasification" id="clasification" style="width: 600px !important;" required>
                              <option value="">Pilih Clasification Group ID</option>
                              <?php
                              foreach ($material_group as $arr) { ?>
                                  <option value="<?= $arr['material_group']; ?>"><?= $arr['material_group'].". ".$arr['material_desc'].", (".$arr['type'].")"; ?></option>
                              <?php } ?>
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
                            <select class="form-control" name="equipment_id" id="equipment_id" style="width: 600px !important;" disabled required>

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
                              <input type="text" id="equipment_no" name="equipment_no" maxlength="30" value="" class="form-control ff" required/>
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
                            <input type="text" id="no_manufacturer" name="no_manufacturer" aria-describedby="sizing-addon2" maxlength="2" value="" class="form-control ff" required/>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <input type="text" id="name_manufacturer" name="name_manufacturer" value="" class="form-control ff" required/>
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
                              <input type="text" id="part_no" name="part_no" value="" maxlength="30" class="form-control ff"/>
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
                            <input type="text" id="model_type_no" name="model_type_no" maxlength="2" value="" class="form-control ff" required/>
                          </div>
                        </div>
                        <div class="col-md-4">

                          <div class="form-group">
                            <input type="text" id="model_type_name" name="model_type_name" value="" class="form-control ff" required/>
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
                            <input type="text" id="squence_group_no" name="squence_group_no" maxlength="3" value="" class="form-control ff" required/>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="form-group">
                            <input type="text" id="squence_group_name" name="squence_group_name" value="" class="form-control ff" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-2"><?= lang("Indikator Material", "Indicator Materaial") ?> <br><small><i>Indicator Group</i></small> </label>
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <select class="form-control" name="material_indicator" id="material_indicator" style="width: 350px !important;" required>
                              <option value="">Select </option>
                              <?php
                              foreach ($material_indicator as $arr) { ?>
                                  <option value="<?= $arr['id']; ?>">
                                    <?= $arr['desc_en']; ?>
                                  </option>
                              <?php } ?>
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
                                    <label><input type="checkbox" name="stockclass[]" value="<?= $arr['id']; ?>" id="stockclass<?= $arr['id']; ?>"><small><b> <?= lang($arr['desc_in'], $arr['desc_en'] );?></b></small> </label>
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
                                    <label><input type="checkbox" name="available[]" value="<?= $arr['id']; ?>" id="available<?= $arr['id']; ?>"><small><b> <?= lang($arr['desc_in'], $arr['desc_en'] );?></b></small> </label>
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
                                    <label><input type="checkbox" name="critical[]" value="<?= $arr['id']; ?>" id="critical<?= $arr['id']; ?>"><small><b> <?= lang($arr['desc_in'], $arr['desc_en'] );?></b></small> </label>
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
                        <div class="col-md-1">
                          <a href="#" id="img_material" data-lightbox="lightbox" data-title="MATERIAL IMG"><img id="image_upload" src="<?= base_url()?>ast11/img/showimg.png" alt="other file" style="height:60px;width:60px;" /></a>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <input type="file" id="material_image2" name="material_image2" value="" class="form-control ff" accept="image/jpeg, image/png" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-2">Material Drawing</label>
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-1">
                          <a href="#" id="img_mdrawing" data-lightbox="lightbox" data-title="MATERIAL DRAWING"><img id="image_upload2" src="<?= base_url()?>ast11/img/showimg.png" alt="other file" style="height:60px;width:60px;" /></a>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <input type="file" id="material_drawing2" name="material_drawing2" value="" class="form-control ff" accept="image/jpeg, image/png" required/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group row">
                    <label class="col-md-2"><?= lang("Lainya", "Other") ?></label>
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-1">
                          <a href="#" id="image_upload_location"><img id="image_upload3" src="<?= base_url()?>ast11/img/showimg.png" alt="other file" style="height:60px;width:60px;" /></a>
                        </div>
                        <div class="col-md-5">
                          <div class="form-group">
                            <input type="file" id="material_other2" name="material_other2" value="" class="form-control ff" accept="application/pdf, application/ms-excel, application/msword"/>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closemyModal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="submit" onclick="" class="btn btn-info" id="save"><?= lang('Setujui', 'Approve') ?></button>
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

<!--history-->
<div id="modal_history" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-lg">
        <form class=" modal-content" id="history">
            <div class="modal-header">
                <?= lang("Data History", "Data History") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
              <div class="table-responsive">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>No</th>
                        <th>Status</th>
                        <th>Note</th>
                        <th>Create By</th>
                        <th>Create Date</th>
                      </tr>
                    </thead>
                    <tbody id="table_history">

                    </tbody>
                  </table>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Tutup", "Close") ?></button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    // ajax_loader();
    simple_ckeditor('m_desc');
    simple_ckeditor('m_desc_cataloguing');

    input_numberic('#equipment_no', true);
    input_numberic('#no_manufacturer', true);
    input_numberic('#part_no', true);
    input_numberic('#model_type_no', true);
    input_numberic('#squence_group_no', true);
    $('select').select2();


    $("#clasification").on('change', function() {
      var klasifikasi = $(this).val();
      // alert(klasifikasi)
      $("#equipment_id").attr('disabled', false);
      $.ajax({
        url: '<?= base_url('material/Registration_catalog/material_equipment_group') ?>',
        type: 'GET',
        data: {idx: klasifikasi},
        success: function(res){
          $("#equipment_id").html(res);
        }
      })


    });

    $('.i-checks').iCheck({
        checkboxClass: 'icheckbox_square-green',
        radioClass: 'iradio_square-green',
    });

    function readURL(input, idorclass) {

      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $(idorclass).attr('src', e.target.result);
        }
        reader.readAsDataURL(input.files[0]);
      }
    }

    $("#material_image2").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          msg_danger("Format Allowed : "+fileExtension.join(', '));
          // alert("Format Allowed : "+fileExtension.join(', '));
          $(this).val("")
        } else {
          readURL(this, '#image_upload');
        }
    });
    $("#material_drawing2").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          msg_danger("Format Allowed : "+fileExtension.join(', '));
          // alert("Format Allowed : "+fileExtension.join(', '));
          $(this).val("")
        } else {
          readURL(this, '#image_upload2');
        }
    });
    $("#material_other2").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'docx', 'xlsx', 'doc'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          msg_danger("Format Allowed : "+fileExtension.join(', '));
          // alert("Format Allowed : "+fileExtension.join(', '));
          $(this).val("")
        } else {
          readURL(this, '#image_upload3');
        }
    });

    // simpan registrasi katalog
    $(".m_registration_catalog").submit(function(e) {
      e.preventDefault();

      var messageLength = CKEDITOR.instances['m_desc_cataloguing'].getData().replace(/<[^>]*>/gi, '').length;
      if( !messageLength ) {
        msg_danger("Description cannot be empty!")
      } else {
        var data = new FormData(this);
        data.append('m_desc_cataloguing', CKEDITOR.instances['m_desc_cataloguing'].getData());
        var xmodalx = modal_start($("#myModal").find(".modal-content"));
        save_material_catalog(data);
      }
    });

    // modal form
    $(document).on('show.bs.modal', '#myModal', function(e){
      var xmodalx = modal_start($("#myModal").find(".modal-content"));
      // e.preventDefault();
      document.getElementById("form").reset();
      $("input[type=checkbox]").attr('checked', false);
      var content = CKEDITOR.instances['m_desc_cataloguing'].setData("");
      // $("#equipment_id").attr('disabled', true);
      $('.modal-title').html("<?= lang("Formulir Pendaftaran", "Form Registration Material") ?>");
      $('#myModal .modal-header').css('background-color', "#1c84c6");
      $('#myModal .modal-header').css('color', "#fff");
      lang();

      // keyupform
      $("#no_manufacturer").on('keyup', function() {
        $("#name_manufacturer").val("")
      });

      $("#model_type_no").on('keyup', function() {
        $("#model_type_name").val("")
      });

      $("#squence_group_no").on('keyup', function() {
        $("#squence_group_name").val("")
      });
      // /-keyupform

      // autocomplete form
      $('#model_type_no').autocomplete({
        source: '<?= base_url('material/Registration_catalog/minta_material_modeltype') ?>',
        minLength: 1,
        select: function( event, ui ) {
            $("#model_type_name").val(ui.item.material_type)
            $(this).val(ui.item.value)
            return false;
          }
      });

      $('#no_manufacturer').autocomplete({
        source: '<?= base_url('material/Registration_catalog/minta_manufacturer') ?>',
        minLength: 1,
        select: function( event, ui ) {
            $("#name_manufacturer").val(ui.item.material_group)
            $(this).val(ui.item.value)
            return false;
          }
      });

      $('#squence_group_no').autocomplete({
        source: '<?= base_url('material/Registration_catalog/minta_material_sequence') ?>',
        minLength: 1,
        select: function( event, ui ) {
            $("#squence_group_name").val(ui.item.material_type)
            $(this).val(ui.item.value)
            return false;
          }
      });
      // /-autocomplete form

      var idnya = $(e.relatedTarget).data("id");

      $.ajax({
        url: '<?= base_url('material/Registration_catalog/get_data_requestor') ?>',
        dataType: 'json',
        type: 'post',
        data: {
          idnya: idnya
        },
        success: function(res){
          modal_stop(xmodalx);
          $.each(res, function(index, el) {
            var content = CKEDITOR.instances['m_desc'].setData(el.description);
            // $("#m_desc").val(el.description)
            $("#material").val(el.material)
            $("#optmaterial_uom").val(el.uom)
            $("#material_image").html('<a data-lightbox="lightbox" data-title="MATERIAL IMAGE" href="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img1_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img1_url+'" style="height:60px;width:60px;" alt=""></a>')
            $("#material_drawing").html('<a data-lightbox="lightbox" data-title="MATERIAL DRAWING" href="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img2_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img2_url+'" style="height:60px;width:60px;" alt=""></a>')

            if (el.file_url == "-" || el.file_url == "") {
              $("#material_other").html('<a href="#"> No File </a>')
            } else {
              var formatid = el.file_url.split(".").pop();
              if (formatid == 'jpg' || formatid == 'png' || formatid == 'gif') {
                $("#material_other").html('<a data-lightbox="lightbox" data-title="OTHER IMAGE" href="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'" style="height:60px;width:60px;" alt=""></a>')
              } else {
                $("#material_other").html('<a href="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'" target="_blank" >Show File</a>')
              }

            }

            // cataloging detail
            console.log(el.data2.MATERIAL_NAME);
            $('#m_name').val(el.data2.MATERIAL_NAME);
            if (el.description1 == "") {
              var content3 = CKEDITOR.instances['m_desc_cataloguing'].setData(el.description);
            } else {
              var content2 = CKEDITOR.instances['m_desc_cataloguing'].setData(el.description1);
            }

            $('#optmaterial_uom2').val(el.data2.UOM).select2();
            $('#clasification').val();
            // $('#equipment_id').val(el.data2.EQPMENT_ID).select2();
            if (el.data2.EQPMENT_ID == "") {
              $("#clasification").val("").trigger('change');
              $('#equipment_id').prop('disabled', true)
            } else {
              // $("#clasification").val()
              $.ajax({
                url: '<?= base_url('material/Registration_catalog/material_clasification_group') ?>',
                type: 'GET',
                data: {idx: el.data2.EQPMENT_ID},
                dataType: 'json',
                success: function(res){
                  console.log(res.mgroup.PARENT);
                  $("#clasification").val(res.mgroup.PARENT).trigger('change');
                  setTimeout(function(){ $('#equipment_id').val(el.data2.EQPMENT_ID).select2(); }, 500)
                  console.log(res);
                }
              })

            }
            $('#equipment_no').val(el.data2.EQPMENT_NO);
            $('#no_manufacturer').val(el.data2.MANUFACTURER);
            $('#name_manufacturer').val(el.data2.MANUFACTURER_DESCRIPTION);
            $('#part_no').val(el.data2.PART_NO);
            $('#model_type_no').val(el.data2.MATERIAL_TYPE);
            $('#model_type_name').val(el.data2.MATERIAL_TYPE_DESCRIPTION);
            $('#squence_group_no').val(el.data2.SEQUENCE_GROUP);
            $('#squence_group_name').val(el.data2.SEQUENCE_GROUP_DESCRIPTION);
            $('#material_indicator').val(el.data2.INDICATOR).select2();
            $('#user_requestor').val(el.data2.NAME);
            $('#department_requestor').val(el.data2.DEPARTMENT_DESC);

            var stockclass = el.data2.STOCK_CLASS.split('|');
            for (var i = 0; i < stockclass.length; i++) {
              $("#stockclass"+stockclass[i]).attr('checked', 'checked');
              $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green',
              });
            }

            var available = el.data2.AVAILABILITY.split('|');
            for (var i = 0; i < available.length; i++) {
              $("#available"+available[i]).attr('checked', 'checked');
              $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green',
              });
            }
            var critical = el.data2.CRITICALITY.split('|');
            for (var i = 0; i < critical.length; i++) {
              $("#critical"+critical[i]).attr('checked', 'checked');
              $('.i-checks').iCheck({
                  checkboxClass: 'icheckbox_square-green',
                  radioClass: 'iradio_square-green',
              });
            }

            // $('#material_image2').val();
            // $('#material_drawing2').val();
            // $('#material_other2').val();

            if (el.data2.IMG3_URL != "" && el.data2.IMG4_URL != "") {
              $("#image_upload").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.IMG3_URL)
              $("#image_upload2").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.IMG4_URL)
              $("#img_material").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.IMG3_URL);
              $("#img_mdrawing").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.IMG4_URL);
              $("#material_image2").prop('required', false);
              $("#material_drawing2").prop('required', false);

              if (el.data2.FILE_URL2 == "" || el.data2.FILE_URL2 == "-") {

              } else {
                var formatid = el.data2.FILE_URL2.split(".").pop();
                if (formatid == 'jpg' || formatid == 'png' || formatid == 'gif') {
                    $("#image_upload3").attr('src', '<?= base_url(); ?>upload/MATERIAL/files/' + el.data2.FILE_URL2)
                    $("#image_upload_location").attr('href', '#')
                } else {
                    $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/document-file-icon.png')
                    $("#image_upload_location").attr('href', '<?= base_url(); ?>upload/MATERIAL/files/' + el.data2.FILE_URL2)
                }
              }
            } else {
              $("#image_upload").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
              $("#image_upload2").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
              $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/showimg.png')
              $("#img_material").attr('href', '<?= base_url() ?>ast11/img/showimg.png');
              $("#img_mdrawing").attr('href', '<?= base_url() ?>ast11/img/showimg.png');
              $("#material_image").prop('required', true);
              $("#material_drawing").prop('required', true);
              $("#image_upload_location").attr('href', '#')
            }

          });
        }
      })
      // $("a#single_image").fancybox();
    });

    $(document).on('click', '.closemyModal', function(e) {
      swal({
        title: "Are you sure?",
        text: "You will close this form, you inserted data might be remove!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#0072cf',
        confirmButtonText: 'Oke',
        closeOnConfirm: true,
        closeOnCancel: true
      },
      function(){
        $("#myModal").modal("hide");
      });
    });

    // History
    $(document).on('show.bs.modal', '#modal_history', function(e){
      // e.preventDefault
      var idnya = $(e.relatedTarget).data("id");
      $('.modal-title').html("<?= lang("Histori Material", "Material History") ?>");
      $('#modal_history .modal-header').css('background-color', "#1c84c6");
      $('#modal_history .modal-header').css('color', "#fff");
      // alert(idnya)
      var result;
      $.ajax({
        url: '<?= base_url('material/Registration_catalog/show_history')?>',
        type: 'post',
        dataType: 'html',
        data: {id: idnya}
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        if (result = true) {
          $("#table_history").html(res);
          console.log(res);
        }
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
            url: '<?= base_url('material/Registration_catalog/reject_request_material') ?>',
            dataType: 'json',
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(res){
              modal_stop(elm)
              if (res == true) {
                window.location.href = "<?=base_url('material/registration_catalog')?>";
              } else {
                console.log("EMAIL NOT SEND !");
                window.location.href = "<?=base_url('material/registration_catalog')?>";
              }

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
            "url": "<?= base_url('material/Registration_catalog/datatable_logistic_specialist') ?>",
            "dataSrc": ""
        },
        "data": null,
        "searching": true,
        "paging": true,
        "columns": [
            {title: "<center>No</center>"},
            {title: "<center>Request No</center>"},
            {title: "<center>Description Material</center>"},
            {title: "<center>Material UOM</center>"},
            {title: "<center>Status</center>"},
            {title: "<center><?= lang("&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAksi&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp", "&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbspAction&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp") ?></center>"}
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
      table.column($(this).data('index')).search(this.value).draw();
    });
  });

  function save_material_catalog(data){
    $.ajax({
      url: '<?= base_url('material/Registration_catalog/save_registrasi_catalog') ?>',
      dataType: 'json',
      type: 'post',
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: function(res){
        if (res.success == true) {
          swal({
                  title: "Done",
                  text: "Data is successfuly saved.",
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: "#3085d6",
                  confirmButtonText: "Oke",
                  closeOnConfirm: false
              },function () {
                window.location.href = "<?= base_url()?>/material/registration_catalog";
          });
        } else {
          alert("Sistem Bermasalah Harap Hubungi Admin");
          window.location.href = "<?= base_url()?>/material/registration_catalog";
        }
      }
    })
  }
</script>
