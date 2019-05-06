<!--- ////////////////////////////////////////////////// Form Logistic Specialist //////////////////////////////////////////-->
<div class="main1">
  <div class="card-header  bg-success bg-accent-4">
    <div class="col-12 row">
        <div class="col-8">
            <h3 class="content-header-title mb-1">CATALOG REVISION NUMBER REQUEST</h3>
        </div>
        <div class="col-sm-8">
            <h5 id="name"><?= $this->session->userdata['NAME']; ?></h5>
            <h5 id="dept_desc"><?php
            $qq = $this->db->query("SELECT DEPARTMENT_DESC FROM m_departement WHERE ID_DEPARTMENT = '".$this->session->userdata['DEPARTMENT']."'");
            echo $qq->row()->DEPARTMENT_DESC;
             ?></h5>
        </div>
        <div class="col-sm-4">
            <h5>Item ID  : <strong id="requestno"></strong></h5>
            <h5>Request Date  : <strong id="req_date"></strong></h5>
            <h5>Status  : <strong id="req_status"></strong></h5>
        </div>
    </div>
  </div>
  <div class="media">
    <div class="media-body text-right bg-info bg-lighten-4">
      <center>
        <!-- <a class="media-right" id="showuser">
          <img class="media-object rounded-circle" src="<?= base_url()?>ast11/img/iconuser.png" alt="Generic placeholder image" style="width: 64px;height: 64px;">
        </a>
        <h5><?= lang('Tampilkan User Input', 'Display User Input')?></h5> -->

        <ul class="nav nav-tabs nav-iconfall">
          <li class="nav-item round-tab">
            <a class="nav-link active" id="infoicon-tab1" data-toggle="tab" href="#infoicon" aria-controls="infoicon"
        aria-expanded="true"><i class="fa fa-info"></i> Information</a>
      </li>
      <li class="nav-item round-tab">
        <a class="nav-link" id="noteicon-tab1" data-toggle="tab" href="#noteicon"
        aria-controls="noteicon" aria-expanded="false"><i class="fa fa-sticky-note"></i> Note</a>
      </li>
      <li class="nav-item round-tab">
        <a class="nav-link" id="historyicon-tab1" data-toggle="tab" href="#historyicon" aria-controls="historyicon"
        aria-expanded="false"><i class="fa fa-header"></i> History</a>
      </li>
    </ul>
  </center>
</div>
</div>

<div class="tab-content">
<div role="tabpanel" class="tab-pane active in" id="infoicon" aria-labelledby="infoicon-tab1" aria-expanded="true">
  <form class="form-horizontal" id="revision-material-form" enctype="multipart/form-data">
      <input type="hidden" id="id" name="id" value="<?= set_value('id', @$material['id'])?>">
        <input type="hidden" id="material" name="material" value="<?= set_value('material', $material['MATERIAL'])?>">
        <input type="hidden" id="material_id" name="material_id" value="<?= set_value('material', $material['MATERIAL'])?>">
        <input type="hidden" id="sequence_id" name="sequence_id" value="">
        <input type="hidden" id="email_approve" name="email_approve" value="">
        <input type="hidden" id="email_reject" name="email_reject" value="">
        <input type="hidden" id="edit_content" name="edit_content" value="">
        <input type="hidden" id="kodematerial" name="kodematerial" value="">
        <div class="card-footer border-2 text-muted mt-2">
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Desk. Pendek Material*", "Item Short Desc*") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="m_name" name="m_name" class="form-control required" rows="3" maxlength="30" required/>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Teks Pencarian*", "Search Text*") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="search_text" name="search_text" class="form-control required" rows="3" maxlength="30" required/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Desk. Pendek Material 2", "Item Short Desc 2") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="m_short_desc" name="m_short_desc" class="form-control required" rows="3" maxlength="30" required/>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Nama Tidak Resmi", "Colloquials") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="colluquials" name="colluquials" class="form-control" rows="3" maxlength="30"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Desk. Panjang Material *", "Item Long Desc *") ?>
                </label>
                <div class="col-md-10">
                    <textarea id="m_desc" name="m_desc" class="form-control required" rows="5" maxlength="500" required></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Klasifikasi SEMIC*", "SEMIC Classification*") ?>
                </label>
                <div class="col-md-4">
                    <select id="classification" name="classification" class="form-control required" required>
                        <option value="">Please Select</option>
                        <?php
                            foreach ($material_group as $arr) { ?>
                        <option value="<?= $arr['material_group']; ?>"><?= $arr['material_group'].". ".$arr['material_desc'].", (".$arr['type'].")"; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("No SEMIC*", "SEMIC Number*") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="semic_no" name="semic_no" class="form-control required" minlength="14" maxlength="14" required/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Grup Utama SEMIC*", "SEMIC Main Group*") ?>
                </label>
                <div class="col-md-4">
                    <select id="semic_group" name="semic_group" class="form-control required" disabled required>
                    </select>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Penggunaan Bulanan", "Monthly Usage") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="monthly_usage" name="monthly_usage" maxlength="9" class="form-control"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Satuan Utama/Isu*", "UOM Primary / Issue*") ?>
                </label>
                <div class="col-md-4">
                    <select id="m_uom" name="m_uom" class="form-control" required>
                        <option value="">Please Select</option>
                        <?php
                            foreach ($material_uom as $arr) { ?>
                        <option value="<?= $arr['material_uom']; ?>"><?= $arr['material_uom']; ?> - <?= $arr['description'] ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Perk. Penggunaan Tahunan", "Est. Annual Usage") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="annual_usage" name="annual_usage" maxlength="9" class="form-control"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Pabrikan*", "Manufacturer*") ?>
                </label>
                <div class="col-md-4">
                    <input type="hidden" id="no_manufacturer" name="no_manufacturer" maxlength="2" value=""/>
                    <input type="text" id="name_manufacturer" name="name_manufacturer" maxlength="30" class="form-control required" required/>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Jumlah Pesanan Awal", "Initial Order Qty") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="initial_order_qty" name="initial_order_qty" maxlength="9" class="form-control"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("No. Bagian*", "Part Number*") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="part_no" name="part_no" class="form-control required" maxlength="30" required/>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Expl. Element", "Expl. Element") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="expl_element" name="expl_element" maxlength="30" class="form-control"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Model", "Model") ?>
                </label>
                <div class="col-md-4">
                    <input type="hidden" id="model_type_no" name="model_type_no" value=""/>
                    <input type="text" id="model_type_name" name="model_type_name" class="form-control"/>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Satuan Pembelian", "UOM Purchase") ?>*
                </label>
                <div class="col-md-4">
                    <select id="unit_of_issue" name="unit_of_issue" class="form-control required" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($material_uom as $arr) { ?>
                            <option value="<?= $arr['material_uom']; ?>"><?= $arr['material_uom']; ?> - <?= $arr['description'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Tipe", "Type") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="m_type" name="m_type" maxlength="9" class="form-control"/>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Perkiraan Nilai", "Estimated Value") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="estimate_value" name="estimate_value" maxlength="9" class="form-control"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("No. Serial", "Serial Number") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="serial_number" name="serial_number" maxlength="9" class="form-control" />
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Masa Rak", "Shelf Life") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="shelf_life" name="shelf_life" maxlength="9" class="form-control"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("ID Grup Perlengkapan", "Equipment Group ID") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="equipment_id" name="equipment_id" maxlength="30" class="form-control"/>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Berbahaya", "Hazardous") ?>
                </label>
                <div class="col-md-4">
                    <select id="hazardous" name="hazardous" class="form-control">
                        <option value="">Please Select</option>
                        <?php
                        foreach ($hazardous as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("No. Perlengkapan", "Equipment Number") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="equipment_no" name="equipment_no" maxlength="30" class="form-control"/>
                </div>
                <label class="col-md-2" style="text-align: right;">
                    <?= lang("Kode Stok</br>Referensi Silang", "Cross Reference</br>Stock Code") ?>
                </label>
                <div class="col-md-4">
                    <input type="text" id="cross_rererence" name="cross_rererence" maxlength="9" class="form-control"/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Kelas G/L*", "G/L Class*") ?>
                </label>
                <div class="col-md-4">
                    <select id="gl_class" name="gl_class" class="form-control required" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($gl_class as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['code'] . ' - ' . $arr['description']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Tipe Barang*", "Inventory Type*") ?>
                </label>
                <div class="col-md-4">
                    <select id="inventory_type" name="inventory_type" class="form-control" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($inventory_type as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Tipe Garis*", "Line Type*") ?>
                </label>
                <div class="col-md-4">
                    <select id="line_type" name="line_type" class="form-control required" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($line_type as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['code'] . ' - ' . $arr['description']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Fase Proyek*", "Project Phase*") ?>
                </label>
                <div class="col-md-4">
                    <select id="project_phase" name="project_phase" class="form-control required" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($project_phase as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Tipe Stok*", "Stocking Type*") ?>
                </label>
                <div class="col-md-4">
                    <select id="stocking_type" name="stocking_type" class="form-control required" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($stocking_type as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['code'] . ' - ' . $arr['description']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Ketersediaan*", "Availability*") ?>
                </label>
                <div class="col-md-4">
                    <select id="available" name="available" class="form-control required" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($material_avalable as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['desc_en']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Kelas Stok*", "Stock Class*") ?>
                </label>
                <div class="col-md-4">
                    <select id="stock_class" name="stock_class" class="form-control required" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($stock_class as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                        <?php } ?>
                    </select>
                </div>
                <label class="col-md-2 col-form-label" style="text-align: right;">
                    <?= lang("Kekritisan", "Criticality") ?>
                </label>
                <div class="col-md-4">
                    <select id="critical" name="critical" class="form-control" required>
                        <option value="">Please Select</option>
                        <?php
                        foreach ($material_criticaly as $arr) { ?>
                            <option value="<?= $arr['id']; ?>"><?= $arr['desc_en']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">Material Image</label>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-1">
                            <a href="#" id="img_material" data-lightbox="lightbox" data-title="MATERIAL DRAWING"><img id="image_upload" src="<?= base_url() ?>ast11/img/showimg.png" alt="your image" style="height:60px;width:60px;" /></a>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="file" id="material_image" name="material_image" class="form-control ff" accept="image/jpeg, image/png"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">Material Drawing</label>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-1">
                            <a href="#" id="img_mdrawing" data-lightbox="lightbox" data-title="MATERIAL DRAWING"><img id="image_upload2" src="<?= base_url() ?>ast11/img/showimg.png" alt="your image" style="height:60px;width:60px;" /></a>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="file" id="material_drawing" name="material_drawing" class="form-control ff" accept="image/jpeg, image/png"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label" style="text-align: right;">Other</label>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-1">
                            <a target="blank" href="#" id="image_upload_location"><img id="image_upload3" src="<?= base_url() ?>ast11/img/showimg.png" alt="other file" style="height:60px;width:60px;" /></a>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <input type="file" id="material_other" name="material_other" value="" class="form-control ff" accept="application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/msword"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      </div>

      <div class="tab-pane" id="noteicon" role="tabpanel" aria-labelledby="noteicon-tab1" aria-expanded="false">
        <!--- ////////////////////////////////////////////////// Show note //////////////////////////////////////////-->
        <fieldset id="bagian2" class="col-12">
        <br>
        <!-- <h2 class="m-b"><?= lang("Catatan", "Note"); ?></h2> -->
        <div class="card-footer px-0 py-0">
          <div class="card-body">
            <div class="form-group position-relative has-icon-left mb-0">
              <textarea id="notes" name="notes" maxlength="225" rows="8" cols="80" class="form-control" placeholder="Write Some Note..."></textarea>
                <div class="form-control-position">
                    <i class="fa fa-dashcube"></i>
                </div>
                <br>
                <button type="button" name="button" id="send-note-btn" class="btn btn-primary pull-right savenote"> <i class="fa fa-location-arrow"></i> Send </button>
            </div>
          </div>
          <br>
          <br>
          <div class="data-note">

          </div>
          </div>
        </fieldset>
        <!--- ////////////////////////////////////////////////// Show note //////////////////////////////////////////-->
      </div>

      <div class="tab-pane" id="historyicon" role="tabpanel" aria-labelledby="historyicon-tab1" aria-expanded="false">
        <!--- ////////////////////////////////////////////////// Show history //////////////////////////////////////////-->
        <fieldset id="bagian3" class="col-12">
        <br>
        <!-- <h2 class="m-b"><?= lang("History", "History"); ?></h2> -->
          <div class="table-responsive">
            <table class="table table-condensed">
              <thead>
                <tr>
                  <th>No</th>
                  <th>User</th>
                  <th><?=lang("Tanggal Dibuat", "Create Date")?></th>
                  <th><?=lang("Keterangan", "Description")?></th>
                </tr>
              </thead>
              <tbody id="log_history">

              </tbody>
            </table>
          </div>
        </fieldset>
        <!--- ////////////////////////////////////////////////// Show history //////////////////////////////////////////-->
      </div>

      <div class="modal-footer">
        <button type="button" id="submit-material-btn" class="btn btn-success" data-dismiss="modal"><?= lang('Submit', 'Submit') ?></button>
      </div>
  </form>
</div>
<script type="text/javascript">

$(document).ready(function() {
  var id =  $('#id').val();
  var material =  $('#material').val();
  console.log('document ready')

  get_material_data(material)
  if (id) {
    get_note(id)
    get_log(id)
  }

  $('#semic_no, #classification, #semic_group, #gl_class, #line_type, #inventory_type').attr('disabled', true).prop('disabled', true)
  $('#send-note-btn').attr('disabled', !id)

  // initiate CKEDITOR
  CKEDITOR.replace('m_desc', {
    toolbar: [
        {name: 'document', items: ['-', 'NewPage', 'Preview', '-', 'Templates', 'Bold', 'Italic']}, // Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
        ['Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo']
    ]
  });

  $('#submit-material-btn').click(function() {
      swalConfirm('Material Revision', '<?= __('confirm_submit') ?>', function() {
        console.log('submit button clicked')
        $('#revision-material-form').submit()
      });
  })

    $('#revision-material-form').submit(function (e) {
        e.preventDefault();

        $('#revision-material-form').validate()
        var formValid = $('#revision-material-form').valid()
        if (!formValid) {
          return false;
        }

        var data = new FormData(this);
        data.append('m_desc', CKEDITOR.instances['m_desc'].getData());
        data.append('semic_no', $('#semic_no').val())
        data.append('classification', $('#classification').val())
        data.append('semic_group', $('#semic_group').val())
        data.append('gl_class', $('#gl_class').val())
        data.append('inventory_type', $('#inventory_type').val())
        data.append('line_type', $('#line_type').val())
        data.append('stocking_type', $('#stocking_type').val())
        var material_other = $("#material_other").val();
        // alert(material_other)
        var material_id = $("#material_id").val();

        //var messageLength = CKEDITOR.instances['m_desc'].getData().replace(/<[^>]*>/gi, '').length;
        var messageLength = $('<textarea />').html(CKEDITOR.instances['m_desc'].getData().replace(/<[^>]*>/gi, '')).text();
        console.log(messageLength.length);
        if( !messageLength.length ) {
          setTimeout(function() {
            swal('<?= __('warning') ?>', 'Empty item Long Desc', 'warning')
          }, swalDelay);
        } else if (messageLength.length > 500){
          setTimeout(function() {
            swal('<?= __('warning') ?>', 'Item Long Desc maximum length is 500 character', 'warning')
          }, swalDelay);
        } else {
          if (document.getElementById("material_image").files.length == 0 || document.getElementById("material_drawing").files.length == 0) {
              var xmodalx = modal_start($("#myModal").find(".modal-content"));
              save_material_revision_ajax(data);
              // modal_stop(xmodalx);
          } else {
              if (fileSize("#material_image") > 1048576) {
                  setTimeout(function() {
                    swal('<?= __('warning') ?>', 'File size limit is 1Mb', 'warning');
                  }, swalDelay);
              } else if (fileSize("#material_drawing") > 1048576) {
                  setTimeout(function() {
                    swal('<?= __('warning') ?>', 'File size limit is 1Mb', 'warning');
                  }, swalDelay);
              } else if (material_other != "") {
                  if (fileSize("#material_other") > 1048576) {
                      setTimeout(function() {
                        swal('<?= __('warning') ?>', 'File size limit is 1Mb', 'warning');
                      }, swalDelay);
                  } else {
                      var xmodalx = modal_start($("#myModal").find(".modal-content"));
                      save_material_revision_ajax(data);
                      // modal_stop(xmodalx);
                  }
              } else {
                  var xmodalx = modal_start($("#myModal").find(".modal-content"));
                  save_material_revision_ajax(data);
                  // modal_stop(xmodalx);
              }
          }
        }

    });

    $("#material_image").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          //msg_danger("Format file is only : "+fileExtension.join(', '));
          // alert("Format yang diizinkan hanya : "+fileExtension.join(', '));
          swal('<?= __('warning') ?>', "Format allowed : "+fileExtension.join(', '), 'warning');
          $(this).val("")
        } else {
          readURL(this, '#image_upload');
        }
    });
    $("#material_drawing").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          //msg_danger("Format file is only : "+fileExtension.join(', '));
          // alert("Format yang diizinkan hanya : "+fileExtension.join(', '));
          swal('<?= __('warning') ?>', "Format allowed : "+fileExtension.join(', '), 'warning');
          $(this).val("")
        } else {
          readURL(this, '#image_upload2');
        }
    });
    $("#material_other").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'docx', 'xlsx', 'doc'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          //msg_danger("Format file is only : "+fileExtension.join(', '));
          // alert("Format yang diizinkan hanya : "+fileExtension.join(', '));
          swal('<?= __('warning') ?>', "Format allowed : "+fileExtension.join(', '), 'warning');
          $(this).val("")
        } else {
          readURL(this, '#image_upload3');
        }
    });

})

function readURL(input, idorclass) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function(e) {
      $(idorclass).attr('src', e.target.result);
    }
    reader.readAsDataURL(input.files[0]);
  }
}

function get_note(id){
    var result;
    $.ajax({
      url: '<?= base_url('material/Material_req_approval/get_note')?>',
      type: 'POST',
      dataType: 'html',
      data: {
        mr_no: id,
      }
    })
    .done(function() {
      result = true;
    })
    .fail(function() {
      result = false;
    })
    .always(function(res) {
      if (result = true) {
        // console.log(res);
        $(".data-note").html(res);
      }
    });
}

function get_log(id){
    var result;
    $.ajax({
      url: '<?= base_url('material/Mregist_approval/get_log')?>',
      type: 'POST',
      dataType: 'html',
      data: {
        idx: id,
      }
    })
    .done(function() {
      result = true;
    })
    .fail(function() {
      result = false;
    })
    .always(function(res) {
      if (result = true) {
        // console.log(res);
        $("#log_history").html(res);
      }
    });
}

function get_material_data(material) {

  $.ajax({
    url: '<?= base_url('material/Mregist_approval/get_data_requestor') ?>',
    dataType: 'json',
    type: 'post',
    data: {
      idnya: material
    },
    success: function(res){
  //    modal_stop(xmodalx);
      $.each(res, function(index, el) {
        var content = CKEDITOR.instances['m_desc'].setData(el.description1);
        $("#m_desc").val(el.description)
        $("#material").val(el.material);
        $("#optmaterial_uom").val(el.uom);
        $('#user_requestor').val(el.data2.NAME);
        $('#department_requestor').val(el.data2.DEPARTMENT_DESC);
        $("#material_image").html('<a data-lightbox="lightbox" data-title="MATERIAL IMAGE" href="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img1_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img1_url+'" style="height:60px;width:60px;" alt=""></a>');
        $("#material_drawing").html('<a data-lightbox="lightbox" data-title="MATERIAL DRAWING" href="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img2_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/img/ori/'+el.img2_url+'" style="height:60px;width:60px;" alt=""></a>');

        if (!el.file_url || el.file_url == "-" || el.file_url == "") {
          $("#material_other").html('<a href="#"> No File </a>');
        } else {
          var formatid = el.file_url.split(".").pop();
          if (formatid == 'jpg' || formatid == 'png' || formatid == 'gif') {
            $("#material_other").html('<a data-lightbox="lightbox" data-title="OTHER IMAGE" href="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'"><img src="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'" style="height:60px;width:60px;" alt=""></a>');
          } else {
            $("#material_other").html('<a href="<?= base_url(); ?>upload/MATERIAL/files/'+el.file_url+'" target="_blank" >Show File</a>');
          }

        }

        console.log(el.data2.SEMIC_MAIN_GROUP);
        if (el.data2.SEMIC_MAIN_GROUP == "") {
          $("#clasification").val("").trigger('change');
          $('#equipment_id').prop('disabled', true)
        } else {
          // $("#clasification").val()
          // $("#clasification").val("").trigger('change');
          $.ajax({
            url: '<?= base_url('material/Mregist_approval/material_clasification_group') ?>',
            type: 'GET',
            data: {idx: el.data2.SEMIC_MAIN_GROUP},
            dataType: 'json',
            success: function(res){
              console.log(res);

              // console.log(res.mgroup.PARENT);
              $("#clasification").val(res.mgroup.PARENT).trigger('change');
              setTimeout(function(){
                var selected = res.mgroup.ID == el.data2.SEMIC_MAIN_GROUP ? 'selected' : '';
                $('#semic_group').html('<option value="'+ res.semic_main_group.ID+'" '+selected+'>'+res.semic_main_group.MATERIAL_GROUP+'. '+res.semic_main_group.DESCRIPTION+'</option>').trigger('change');
              }, 1000)
              // console.log(res);
            }
          })


        }

        // cataloging detail
        // var content2 = CKEDITOR.instances['m_desc'].setData(el.description1);
        if (el.data2.SEMIC_MAIN_GROUP == "") {
            $('#m_uom').val(el.data2.UOM1).select2({ width: '100%' });
            $('#unit_of_issue').val(el.data2.UOM1).select2({ width: '100%' });
            $('#material_indicator').val(el.data2.INDICATOR).select2({ width: '100%' });
            $('#stock_class').val(el.data2.STOCK_CLASS).select2({ width: '100%' });
            $('#available').val(el.data2.AVAILABILITY).select2({ width: '100%' });
            $('#critical').val(el.data2.CRITICALITY).select2({ width: '100%' });
            $('#unit_of_issue').val(el.data2.UNIT_OF_ISSUE).select2({ width: '100%' });

            $('#gl_class').val(el.data2.GL_CLASS).select2({ width: '100%' });
            $('#line_type').val(el.data2.LINE_TYPE).select2({ width: '100%' });
            $('#stocking_type').val(el.data2.STOCKING_TYPE).select2({ width: '100%' });
            $('#project_phase').val(el.data2.PROJECT_PHASE).select2({ width: '100%' });
            $('#inventory_type').val(el.data2.INVENTORY_TYPE).select2({ width: '100%' });
            $('#hazardous').val(el.data2.HAZARDOUS).select2({ width: '100%' });
            $('#unit_of_purchase').val(el.data2.UNIT_OF_PURCHASE).select2({ width: '100%' });
            $('#unit_of_issue2').val(el.data2.UNIT_OF_ISSUE2).select2({ width: '100%' });

            $("#classification").val("").select2({ width: '100%' }).trigger('change');
            $('#equipment_id').prop('disabled', true);
        } else {
            $.ajax({
                url: '<?= base_url('material/Mregist_approval/material_classification_group') ?>',
                type: 'GET',
                data: {idx: el.data2.SEMIC_MAIN_GROUP},
                dataType: 'json',
                success: function(res) {
                    $('#m_uom').val(el.data2.UOM1).select2({ width: '100%' });
                    $('#unit_of_issue').val(el.data2.UOM1).select2({ width: '100%' });
                    $('#material_indicator').val(el.data2.INDICATOR).select2({ width: '100%' });
                    $('#stock_class').val(el.data2.STOCK_CLASS).select2({ width: '100%' });
                    $('#available').val(el.data2.AVAILABILITY).select2({ width: '100%' });
                    $('#critical').val(el.data2.CRITICALITY).select2({ width: '100%' });
                    $('#unit_of_issue').val(el.data2.UNIT_OF_ISSUE).select2({ width: '100%' });

                    $('#gl_class').val(el.data2.GL_CLASS).select2({ width: '100%' });
                    $('#line_type').val(el.data2.LINE_TYPE).select2({ width: '100%' });
                    $('#stocking_type').val(el.data2.STOCKING_TYPE).select2({ width: '100%' });
                    $('#project_phase').val(el.data2.PROJECT_PHASE).select2({ width: '100%' });
                    $('#inventory_type').val(el.data2.INVENTORY_TYPE).select2({ width: '100%' });
                    $('#hazardous').val(el.data2.HAZARDOUS).select2({ width: '100%' });
                    $('#unit_of_purchase').val(el.data2.UNIT_OF_PURCHASE).select2({ width: '100%' });
                    $('#unit_of_issue2').val(el.data2.UNIT_OF_ISSUE2).select2({ width: '100%' });

                    $("#classification").val(res.mgroup.PARENT).select2({ width: '100%' }).trigger('change');
                    setTimeout(function() {
                        $('#semic_group').val(el.data2.SEMIC_MAIN_GROUP).select2({ width: '100%' });
                        if (el.edit_content != 1) {
                            $(".m_registration_catalog :input").prop("disabled", true);
                            //CKEDITOR.instances['m_desc'].setReadOnly(true);
                        }
                    }, 300);
                }
            });
        }
        $('#m_name').val(el.data2.MATERIAL_NAME);
        $('#m_short_desc').val(el.data2.SHORTDESC);
        $('#colluquials').val(el.data2.COLLUQUIALS);
        $('#semic_no').val(el.data2.MATERIAL_CODE);
        $('#search_text').val(el.data2.SEARCH_TEXT);
        $('#equipment_id').val(el.data2.EQPMENT_ID);
        $('#equipment_no').val(el.data2.EQPMENT_NO);
        $('#requestno').html(el.data2.MATERIAL);
        $('#req_date').html(el.data2.CREATE_TIME);

        $('#no_manufacturer').val(el.data2.MANUFACTURER);
        $('#name_manufacturer').val(el.data2.MANUFACTURER_DESCRIPTION);
        $('#part_no').val(el.data2.PART_NO);
        $('#model_type_no').val(el.data2.MATERIAL_TYPE);
        $('#model_type_name').val(el.data2.MATERIAL_TYPE_DESCRIPTION);
        $('#squence_group_no').val(el.data2.SEQUENCE_GROUP);
        $('#squence_group_name').val(el.data2.SEQUENCE_GROUP_DESCRIPTION);

        $('#m_type').val(el.data2.TYPE);
        $('#serial_number').val(el.data2.SERIAL_NUMBER);
        $('#monthly_usage').val(el.data2.MONTHLY_USAGE);
        $('#annual_usage').val(el.data2.ANNUAL_USAGE);
        $('#initial_order_qty').val(el.data2.INITIAL_ORDER_QTY);
        $('#expl_element').val(el.data2.EXPL_ELEMENT);
        $('#estimate_value').val(el.data2.ESTIMATE_VALUE);
        $('#shelf_life').val(el.data2.SHELF_LIFE);
        $('#cross_rererence').val(el.data2.CROSS_RERERENCE);

        $('#group_class').val(el.data2.GROUP_CLASS);
        $('#mnemonic').val(el.data2.MNEMONIC);
        $('#item_name_code').val(el.data2.ITEM_NAME_CODE);
        $('#preference').val(el.data2.PREFERENCE);
        $('#item_name').val(el.data2.ITEM_NAME);
        $('#part_number').val(el.data2.PART_NUMBER);
        $('#stock_code_no').val(el.data2.STOCK_CODE_NO);
        $('#part_status').val(el.data2.PART_STATUS);
        $('#stock_type').val(el.data2.STOCK_TYPE);
        $('#item_ownership').val(el.data2.ITEM_OWNERSHIP);
        $('#rop').val(el.data2.ROP);
        $('#statistic_code').val(el.data2.STATISTIC_CODE);
        $('#roq').val(el.data2.ROQ);
        $('#min').val(el.data2.MIN);
        $('#origin_code').val(el.data2.ORIGIN_CODE);
        $('#conv_fact').val(el.data2.CONV_FACT);
        $('#tariff_code').val(el.data2.TARIFF_CODE);
        $('#std_pack').val(el.data2.STD_PACK);
        $('#supplier_number').val(el.data2.SUPPLIER_NUMBER);
        $('#unit_price').val(el.data2.UNIT_PRICE);
        $('#fpa').val(el.data2.FPA);
        $('#freight_code').val(el.data2.FREIGHT_CODE);
        $('#lead_time').val(el.data2.LEAD_TIME);
        $('#inspection_code').val(el.data2.INSPECTION_CODE);


        // var stockclass = el.data2.STOCK_CLASS.split('|');
        // for (var i = 0; i < stockclass.length; i++) {
        //   $("#stockclass"+stockclass[i]).attr('checked', 'checked');
        //   $('.i-checks').iCheck({
        //       checkboxClass: 'icheckbox_square-green',
        //       radioClass: 'iradio_square-green',
        //   });
        // }
        //
        // var available = el.data2.AVAILABILITY.split('|');
        // for (var i = 0; i < available.length; i++) {
        //   $("#available"+available[i]).attr('checked', 'checked');
        //   $('.i-checks').iCheck({
        //       checkboxClass: 'icheckbox_square-green',
        //       radioClass: 'iradio_square-green',
        //   });
        // }
        // var critical = el.data2.CRITICALITY.split('|');
        // for (var i = 0; i < critical.length; i++) {
        //   $("#critical"+critical[i]).attr('checked', 'checked');
        //   $('.i-checks').iCheck({
        //       checkboxClass: 'icheckbox_square-green',
        //       radioClass: 'iradio_square-green',
        //   });
        // }

        // $('#material_image').val();
        // $('#material_drawing').val();
        // $('#material_other').val();

        if (el.data2.IMG3_URL != "" && el.data2.IMG4_URL != "") {
          $("#image_upload").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.IMG3_URL);
          $("#image_upload2").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.IMG4_URL);
          $("#img_material").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.IMG3_URL);
          $("#img_mdrawing").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.IMG4_URL);

          if (!el.data2.FILE_URL2 || el.data2.FILE_URL2 == "" || el.data2.FILE_URL2 == "-") {

          } else {
            var formatid = el.data2.FILE_URL2.split(".").pop();
            if (formatid == 'jpg' || formatid == 'png' || formatid == 'gif') {
                $("#image_upload3").attr('src', '<?= base_url(); ?>upload/MATERIAL/files/' + el.data2.FILE_URL2);
                $("#image_upload_location").attr('href', '#');
            } else {
                $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/document-file-icon.png');
                $("#image_upload_location").attr('href', '<?= base_url(); ?>upload/MATERIAL/files/' + el.data2.FILE_URL2);
            }
          }
        } else {
          $("#image_upload").attr('src', '<?= base_url() ?>ast11/img/showimg.png');
          $("#image_upload2").attr('src', '<?= base_url() ?>ast11/img/showimg.png');
          $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/showimg.png');
          $("#img_material").attr('href', '<?= base_url() ?>ast11/img/showimg.png');
          $("#img_mdrawing").attr('href', '<?= base_url() ?>ast11/img/showimg.png');
          $("#image_upload_location").attr('href', '#');
        }

      });
    }
  });
}

// function save_material_revision_approval(data){
//     $.ajax({
//       url: '<?= base_url('material/Mregist_approval/save_registrasi_catalog') ?>',
//       dataType: 'json',
//       type: 'post',
//       data: data,
//       cache: false,
//       processData: false,
//       contentType: false,
//       success: function(res){
//         var kodematerial = $("#kodematerial").val();
//         if (res.sendjde == 1 && kodematerial != '') {
//           setTimeout(function() {
//               swal({
//                   title: 'Approve Material Registration Success',
//                   text: 'Registration Material Approved With SMIC Code :'+kodematerial,
//                   type: "success"
//               }, function() {
//                 window.location.href = "<?=base_url('material/Mregist_approval')?>";
//               });
//           }, 1000);
//         } else {
//           if (res.sendjde == 0 && res.success == true) {
//             swal({
//                     title: "Done",
//                     text: "Data is successfuly saved.",
//                     type: "success",
//                     showCancelButton: false,
//                     confirmButtonColor: "#3085d6",
//                     confirmButtonText: "Oke",
//                     closeOnConfirm: false
//                 },function () {
//                   window.location.href = "<?= base_url()?>/material/Mregist_approval";
//             });
//           } else if (res.sendjde == 2 && res.success == true) {
//             setTimeout(function() {
//                 swal({
//                     title: 'Approve Material Registration Failed',
//                     text: 'Registration Material Is Failed - JDE ERROR, Please Try Again or Contact administrator !',
//                     type: "warning",
//                     showCancelButton: false,
//                     confirmButtonColor: '#d9534f',
//                     confirmButtonText: 'Close',
//                 }, function() {
//                   window.location.href = "<?= base_url()?>/material/Mregist_approval";
//                 });
//             }, 1000);
//           }else {
//             alert("Sistem Bermasalah Harap Hubungi Admin");
//             window.location.href = "<?= base_url()?>/material/Mregist_approval";
//           }
//         }

//       }
//     })
// }

function save_material_revision_ajax(data)
{
        $.ajax({
            url: '<?= base_url('material/revision_material/save') ?>',
            type: 'POST',
            dataType: 'JSON',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function (res) {
                if (res.status === "success") {
                    window.location.href = "<?= base_url('home') ?>";
                } else {
                    setTimeout(function() {
                        swal('<?= __('warning') ?>', 'Processing has failed.', 'warning');
                    }, swalDelay)
                }
            },
            fail: function (res) {
                setTimeout(function() {
                    swal('<?= __('warning') ?>', 'Processing has failed.', 'warning');
                }, swalDelay)
            }
        })
}

lang()

</script>
