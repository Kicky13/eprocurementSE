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
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Persetujuan Revisi Material", "Material Revision Approval") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Master Material", "Master Material") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Persetujuan Revisi Material", "Material Revision Approvment") ?></li>
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
                                                <!-- <a href="<?= base_url('material/registration_material/') ?>" class=""><i class="fa fa-plus-circle"></i> <?= lang("Usulan Material", "Material Propose") ?></a> -->
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
                                                        <th></th>
                                                        <th>Request No</th>
                                                        <th>Material Description</th>
                                                        <th>UoM</th>
                                                        <th>Position</th>
                                                        <th>Status</th>
                                                        <th></th>
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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
                <div class="modal-body">
<!--- ////////////////////////////////////////////////// Show requestor //////////////////////////////////////////-->
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

                <div class="card-footer border-2 text-muted mt-2">
                  <div class="form-group row">
                    <label class="col-md-2"><?= lang("Desktipsi Material", "Materaial Description") ?></label>
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group">
                            <textarea class="form-control" id="m_desc_1" name="m_desc_1" rows="5" maxlength="500" value="" disabled></textarea>
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
                    <label class="col-md-2">Material Image</label>
                    <div class="col-md-10">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group" id="material_image_user">

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
                          <div class="form-group" id="material_drawing_user">

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
                          <div class="form-group" id="material_other_user">

                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
<!--- ////////////////////////////////////////////////// Form Logistic Specialist //////////////////////////////////////////-->
              <div class="main1">
                <div class="card-header  bg-success bg-accent-4">
                  <div class="col-12 row">
                      <div class="col-8">
                          <h3 class="content-header-title mb-1">Catalogue Number Revision Request Approval</h3>
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
                          <h5>Status  : <strong id="req_status"> APPROVAL </strong></h5>
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
                  <form class="form-horizontal m_registration_catalog" id="form" enctype="multipart/form-data">
                    <input type="hidden" id="material" name="material" value="">
                    <input type="hidden" id="sequence_id" name="sequence_id" value="">
                    <input type="hidden" id="email_approve" name="email_approve" value="">
                    <input type="hidden" id="email_reject" name="email_reject" value="">
                    <input type="hidden" id="edit_content" name="edit_content" value="">
                    <input type="hidden" id="material_id" name="material_id" value=""/>
                    <input type="hidden" id="id" name="id" value=""/>
                    <div class="card-footer border-2 text-muted mt-2">
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Desk. Pendek Material*", "Item Short Desc*") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="m_name" name="m_name" class="form-control" rows="3" maxlength="30" required/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Teks Pencarian*", "Search Text*") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="search_text" name="search_text" class="form-control" rows="3" maxlength="30" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Desk. Pendek Material 2", "Item Short Desc 2") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="m_short_desc" name="m_short_desc" class="form-control" rows="3" maxlength="30"/>
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
                                <textarea id="m_desc" name="m_desc" class="form-control" rows="5" maxlength="500" required></textarea>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Klasifikasi SEMIC*", "SEMIC Classification*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="classification" name="classification" class="form-control" required>
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
                                <input type="text" id="semic_no" name="semic_no" class="form-control" minlength="14" maxlength="14" required/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Grup Utama SEMIC*", "SEMIC Main Group*") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="semic_group" name="semic_group" class="form-control" disabled required>
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
                                <?= lang("Unit Satuan*", "UOM Primary/Issue*") ?>
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
                                <input type="text" id="name_manufacturer" name="name_manufacturer" maxlength="30" class="form-control" required/>
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
                                <input type="text" id="part_no" name="part_no" class="form-control" maxlength="30" required/>
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
                                <?= lang("Satuan Isu", "UOM Purchase") ?>*
                            </label>
                            <div class="col-md-4">
                                <select id="unit_of_issue" name="unit_of_issue" class="form-control" required>
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
                                <select id="gl_class" name="gl_class" class="form-control" required>
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
                                <select id="line_type" name="line_type" class="form-control" required>
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
                                <select id="project_phase" name="project_phase" class="form-control" required>
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
                                <select id="stocking_type" name="stocking_type" class="form-control" required>
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
                                <select id="available" name="available" class="form-control" required>
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
                                <select id="stock_class" name="stock_class" class="form-control" required>
                                    <option value="">Please Select</option>
                                    <?php
                                    foreach ($stock_class as $arr) { ?>
                                        <option value="<?= $arr['id']; ?>"><?= $arr['description']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kekritisan", "Criticality *") ?>
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
                                            <input type="file" id="material_image" name="material_image" class="ff" accept="image/jpeg, image/png"/>
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
                                            <input type="file" id="material_drawing" name="material_drawing" class="ff" accept="image/jpeg, image/png"/>
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
                                            <input type="file" id="material_other" name="material_other" value="" class="ff" accept="application/pdf, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/msword"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kelas Grup", "Group Class") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="group_class" name="group_class" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Mnemonic", "Mnemonic") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="mnemonic" name="mnemonic" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Nama Barang Supplier", "Supplier Item Name") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="item_name" name="item_name" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("No. Bagian", "Part Number") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="part_number" name="part_number" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kode Nama Barang", "Item Name Code") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="item_name_code" name="item_name_code" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Preferensi", "Preference") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="preference" name="preference" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("No. Kode Stok", "Stock Code Number") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="stock_code_no" name="stock_code_no" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Status Bagian", "Part Status") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="part_status" name="part_status" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Tipe Stok", "Stock Type") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="stock_type" name="stock_type" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kepemilikan Barang", "Item Ownership") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="item_ownership" name="item_ownership" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("ROP", "ROP") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="rop" name="rop" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kode Statistik", "Statistic Code") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="statistic_code" name="statistic_code" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("ROQ", "ROQ") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="roq" name="roq" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Satuan Utama/Isu", "UOM Primary/Issue") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="unit_of_purchase" name="unit_of_purchase" class="form-control">
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
                                <?= lang("Min", "Min") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="min" name="min" maxlength="9" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Satuan Isu", "UOM Purchase") ?>
                            </label>
                            <div class="col-md-4">
                                <select id="unit_of_issue2" name="unit_of_issue2" class="form-control">
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
                                <?= lang("Kode Asal", "Origin Code") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="origin_code" name="origin_code" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Fakta Konv.", "Conv. Fact") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="conv_fact" name="conv_fact" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kode Tarif", "Tariff Code") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="tariff_code" name="tariff_code" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Pak Standar", "Std. Pack") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="std_pack" name="std_pack" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("No. Penyedia", "Supplier Number") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="supplier_number" name="supplier_number" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Harga Satuan", "Unit Price") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="unit_price" name="unit_price" maxlength="9" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("FPA", "FPA") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="fpa" name="fpa" maxlength="30" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kode Pengangkutan", "Freight Code") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="freight_code" name="freight_code" maxlength="30" class="form-control"/>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Waktu Tunggu", "Lead Time") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="lead_time" name="lead_time" maxlength="9" class="form-control"/>
                            </div>
                            <label class="col-md-2 col-form-label" style="text-align: right;">
                                <?= lang("Kode Inspeksi", "Inspection Code") ?>
                            </label>
                            <div class="col-md-4">
                                <input type="text" id="inspection_code" name="inspection_code" maxlength="30" class="form-control"/>
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
                              <button type="button" name="button" class="btn btn-primary pull-right savenote"> <i class="fa fa-location-arrow"></i> Send </button>
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
                                <th><?=lang("Tanggal Isu", "Issue Date")?></th>
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
                        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('Tutup', 'Cancel') ?></button>
                        <button type="button" data-id="" data-name="" id="prosesreject" data-toggle="modal" data-target="#modal_rej" class="btn btn-danger" title="Reject"> Reject</button>
                        <button type="submit" onclick="" class="btn btn-success" id="save"><?= lang('Setujui', 'Approve') ?></button>
                    </div>
                </form>
                </div>
                </div>
              </div>
              <!--- ////////////////////////////////////////////////// Show requestor //////////////////////////////////////////-->


        </div>
    </div>
</div>

<!--reject-->
<div id="modal_rej" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="reject_mdl">
            <div class="modal-header">
                <?= lang("Tolak Data", "Reject") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                  <input type="hidden" id="material_id_rej" name="material_id_rej" value="">
                  <input type="hidden" id="sequence_id_rej" name="sequence_id_rej" value="">
                  <input type="hidden" id="email_approve_rej" name="email_approve_rej" value="">
                  <input type="hidden" id="email_reject_rej" name="email_reject_rej" value="">
                  <input type="hidden" id="reject_step_rej" name="reject_step_rej" value="">
                  <input type="hidden" id="m_approval_id" name="m_approval_id" value="">
                  <!-- <input type="hidden" id="idnya" name="idnya" value=""> -->
                    <div class="form-group">
                        <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                        <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                        <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note" required></textarea>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-danger"><?= lang("Tolak Data", "Reject") ?></button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script> -->
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<script src="<?= base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
<script type="text/javascript">
  $(document).ready(function() {
    $(".main2").hide();

    $("#showuser").on('click', function() {
      $(".main2").show();
      $(".main1").hide();
    });

    $("#showspv").on('click', function() {
      $(".main2").hide();
      $(".main1").show();
    });

    // ajax_loader();
    simple_ckeditor('m_desc_1');
    simple_ckeditor('m_desc');

    input_numberic('#semic_no', true);
    input_numberic('#monthly_usage', true);
    input_numberic('#annual_usage', true);
    input_numberic('#initial_order_qty', true);
    input_numberic('#m_type', true);
    input_numberic('#estimate_value', true);
    input_numberic('#serial_number', true);
    input_numberic('#shelf_life', true);
    input_numberic('#cross_rererence', true);
    input_numberic('#min', true);
    input_numberic('#unit_price', true);
    input_numberic('#lead_time', true);
    $('select').select2({ width: '100%' });

    $("#classification").on('change', function() {
        var classification = $(this).val();
        $.ajax({
            url: '<?= base_url('material/material_revision_approval/material_equipment_group') ?>',
            type: 'GET',
            data: {idx: classification},
            success: function(res) {
                $("#semic_group").attr('disabled', false);
                $("#semic_group").html(res);
                $("#semic_group").attr('disabled', true);
            }
        });
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

    $("#material_image").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          msg_danger("Format file is only : "+fileExtension.join(', '));
          // alert("Format yang diizinkan hanya : "+fileExtension.join(', '));
          $(this).val("")
        } else {
          readURL(this, '#image_upload');
        }
    });
    $("#material_drawing").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          msg_danger("Format file is only : "+fileExtension.join(', '));
          // alert("Format yang diizinkan hanya : "+fileExtension.join(', '));
          $(this).val("")
        } else {
          readURL(this, '#image_upload2');
        }
    });
    $("#material_other").change(function() {
      var fileExtension = ['jpeg', 'jpg', 'png', 'pdf', 'docx', 'xlsx', 'doc'];
        if ($.inArray($(this).val().split('.').pop().toLowerCase(), fileExtension) == -1) {
          swal('<?= __('warning') ?>', "Format file is only : "+fileExtension.join(', '), 'warning');
          // alert("Format yang diizinkan hanya : "+fileExtension.join(', '));
          $(this).val("")
        } else {
          readURL(this, '#image_upload3');
        }
    });

    // simpan registrasi katalog
    $(".m_registration_catalog").submit(function(e) {
      e.preventDefault();
      console.log("Wow");
      var idnya = $(this).find('input[name=id]').val()

      var messageLength = CKEDITOR.instances['m_desc'].getData().replace(/<[^>]*>/gi, '').length;
      if( !messageLength ) {
        swal('<?= __('warning') ?>', "Empty item Long Desc!", 'warning');
      } else if (messageLength > 500){
        swal('<?= __('warning') ?>', "Item Long Desc maximum length is 500 character!", 'warning');
      } else {
        // $(".m_registration_catalog :input").prop("disabled", false);
        var data = new FormData(this);
        swalConfirm('Catalogue Number Revision Request Approval', '<?= __('confirm_submit') ?>', function() {
          data.append('m_desc', CKEDITOR.instances['m_desc'].getData());
          data.append('id', idnya);
          data.append('semic_no', $('#semic_no').val())
          data.append('classification', $('#classification').val())
          data.append('semic_group', $('#semic_group').val())
          data.append('gl_class', $('#gl_class').val())
          data.append('inventory_type', $('#inventory_type').val())
          data.append('line_type', $('#line_type').val())
          data.append('stocking_type', $('#stocking_type').val())
          data.append('m_uom', $('#m_uom').val())
          data.append('model_type_no', $('#model_type_no').val())
          data.append('model_type_name', $('#model_type_name').val())
          data.append('no_manufacturer', $('#no_manufacturer').val())
          data.append('name_manufacturer', $('#name_manufacturer').val())
          var xmodalx = modal_start($("#myModal").find(".modal-content"));
          save_material_catalog(data);
        });
        // setTimeout(function(){ save_material_catalog(data); }, 100)
      }
    });

    // modal form
    $(document).on('show.bs.modal', '#myModal', function(e) {
      $(".m_registration_catalog :input").prop("disabled", false);
      CKEDITOR.instances['m_desc'].setReadOnly(false);

      var xmodalx = modal_start($("#myModal").find(".modal-content"));
      // e.preventDefault();
      document.getElementById("form").reset();
      $("#sequence_id").val("");
      $("input[type=checkbox]").attr('checked', false);
      var content = CKEDITOR.instances['m_desc'].setData("");
      // $("#equipment_id").attr('disabled', true);
      $('.modal-title').html("<?= lang("Form Approval", "Form Approval") ?>");
      $('#myModal .modal-header').css('background-color', "#1c84c6");
      $('#myModal .modal-header').css('color', "#fff");
      lang();

      // keyupform
      $("#no_manufacturer").on('keyup', function() {
        $("#name_manufacturer").val("");
      });

      $("#model_type_no").on('keyup', function() {
        $("#model_type_name").val("");
      });

      $("#squence_group_no").on('keyup', function() {
        $("#squence_group_name").val("");
      });
      // /-keyupform

      // form handling
      var idnya = $(e.relatedTarget).data("id");
      var get_sequence = $(e.relatedTarget).data("name");
      var get_status = $(e.relatedTarget).data("status");
      var semicx = '';
      $("#req_status").html(get_status);
      $("#prosesreject").attr('data-id', idnya);
      $("#prosesreject").attr('data-name', get_sequence);
      $(this).find("input[name=id]").val(idnya)
      // get history & chat
      get_log(idnya);
      get_note(idnya);

      $(document).on('click', '.savenote', function(e){
        var notes = $("#notes").val();
        var idx = idnya;
        var result;
        if (notes == "") {
          alert("Please fill some note !");
        } else {
          if (confirm("Save this note, Are you sure ?")) {
            $.ajax({
              url: '<?= base_url('material/material_revision_approval/save_note')?>',
              type: 'POST',
              dataType: 'json',
              data: {
                notes: notes,
                mr_no: idx,
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
                $("#notes").val("");
                get_note(idx);
              }
            });
          }
        }
      });
      // get history & chat

      var result;
      $.ajax({
        url: '<?= base_url('material/material_revision_approval/request_sequence_id') ?>',
        type: 'POST',
        dataType: 'JSON',
        data: {get_sequence: get_sequence},
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        // console.log(res.sequence);
        $("#sequence_id").val(res.sequence);
        $("#email_approve").val(res.email_approve);
        $("#email_reject").val(res.email_reject);
        $("#edit_content").val(res.edit_content);

        if (res.edit_content == '0') {
          //alert(res.edit_content)
          setTimeout(function(){
            $("#m_name").prop('disabled', true);
            // $("#m_desc").prop('disabled', true);
            CKEDITOR.instances['m_desc'].setReadOnly(true);
            // $("#optmaterial_uom2").prop('disabled', true);
            // $("#classification").prop('disabled', true);
            // $("#equipment_id").prop('disabled', true);
            // $("#equipment_no").prop('disabled', true);
            // $("#no_manufacturer").prop('disabled', true);
            // $("#name_manufacturer").prop('disabled', true);
            // $("#part_no").prop('disabled', true);
            // $("#model_type_no").prop('disabled', true);
            // $("#model_type_name").prop('disabled', true);
            // $("#squence_group_no").prop('disabled', true);
            // $("#squence_group_name").prop('disabled', true);
            // $("#material_indicator").prop('disabled', true);
            // $("#material_image").prop('disabled', true);
            // $("#material_drawing").prop('disabled', true);
            // $("#material_other").prop('disabled', true);
            $(".m_registration_catalog :input").prop('disabled', true);
            $("select").prop('disabled', true);
            $('.m_registration_catalog input[type=checkbox]').prop('disabled', true);
            // setTimeout(function(){ $(".m_registration_catalog :input").prop("disabled", true); }, 1000)
            // $(".m_registration_catalog :input").prop("disabled", true);
          }, 1500);
        } else {
           $('#semic_no, #classification, #semic_group, #gl_class, #line_type, #inventory_type').attr('disabled', true).prop('disabled', true)
        }
      });

      $('#semic_no').keyup(function(e) {
          var code = this.value.replace(/\D/g,'').substring(0,10);
          var delKey = (e.keyCode == 8 || e.keyCode == 46);
          var len = code.length;
          if (len < 2) {
              code = code;
          } else if (len == 2) {
              code = code.substring(0, 2) + (delKey ? '' : '.');
          } else if (len < 4) {
              code = code.substring(0, 2) + '.' + code.substring(2, 4);
          } else if (len == 4) {
              code = code.substring(0, 2) + '.' + code.substring(2, 4) + (delKey ? '' : '.');
          } else if (len < 6) {
              code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6);
          } else if (len == 6) {
              code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6) + (delKey ? '' : '.');
          } else if (len < 9) {
              code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6) + '.' + code.substring(6, 9);
          } else if (len == 9) {
              code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6) + '.' + code.substring(6, 9) + (delKey ? '' : '.');
          } else {
              code = code.substring(0, 2) + '.' + code.substring(2, 4) + '.' + code.substring(4, 6) + '.' + code.substring(6, 9) + '.' + code.substring(9, 10);
          }
          this.value = code;
      });

      // check SEMIC if EXISTS
      // $("#semic_group").on('change', function() {
      //     if ($("#semic_no").val() != '') {
      //       $("#semic_no").val('')
      //     }
      //     console.log('haha');
      // });


      $("#semic_no").focusout(function(e) {
        var result;
        if ($(this).val() != '') {
          if (semicx === $("#semic_no").val() && idnya != '') {
            console.log("No Need Checking SEMIC");
          } else {
            $.ajax({
              url: '<?= base_url('material/Registration_material/check_semic') ?>',
              type: 'POST',
              dataType: 'json',
              data: {semic_id: $(this).val()}
            })
            .done(function() {
              result = true;
            })
            .fail(function() {
              result = false;
            })
            .always(function(res) {
              if (result) {
                // console.log(res);
                if (res.count > 0) {
                  $("#semic_no").val('');
                  swal("Oops!", "SEMIC "+res.data[0].MATERIAL_CODE+" ALREADY USED BY "+res.data[0].MATERIAL_NAME.toUpperCase(), "warning");
                }
              }
            });
          }
        }

        if ($("#semic_group").val() != "") {
          var semicgroup = $( "#semic_group option:selected" ).text();
          semicgroup = semicgroup=parseInt(semicgroup);
          var semic_no = $("#semic_no").val();
          var split_semic = semic_no.split('.');
          if (semicgroup.toString().length <= 1) {
            semicgroup = '0'+semicgroup.toString();
          }
          split_semic[0] = semicgroup;
          console.log(semicgroup);

          var replace_semic_no = split_semic.join('.').toString();
          $("#semic_no").val(replace_semic_no);
          // console.log(replace_semic_no);
          // alert($("#classification").val())
        } else {
          var semic_no = $("#semic_no").val();
          var split_semic = semic_no.split('.');
          $.ajax({
            url: '<?= base_url('material/Registration_material/check_semic_group') ?>',
            type: 'POST',
            dataType: 'json',
            data: {
              parent: $("#classification").val(),
              mgroup: parseInt(split_semic[0]),
          }
          })
          .done(function() {
            result = true;
          })
          .fail(function() {
            result = false;
          })
          .always(function(res) {
            if (result) {
              if (res.count > 0) {
                $("#semic_group").val(res.data.ID).trigger('change').select2();
              } else {
                $("#semic_no").val('');
                swal("Oops!", "SEMIC Main Group Not Exist", "warning");
              }
              // console.log(res);
            }
          });
        }
      });

      // autocomplete form
      $('#model_type_no').autocomplete({
        source: '<?= base_url('material/material_revision_approval/minta_material_modeltype') ?>',
        minLength: 1,
        select: function( event, ui ) {
            $("#model_type_name").val(ui.item.material_type);
            $(this).val(ui.item.value);
            return false;
          }
      });

      $('#no_manufacturer').autocomplete({
        source: '<?= base_url('material/material_revision_approval/minta_manufacturer') ?>',
        minLength: 1,
        select: function( event, ui ) {
            $("#name_manufacturer").val(ui.item.material_group);
            $(this).val(ui.item.value);
            return false;
          }
      });

      $('#squence_group_no').autocomplete({
        source: '<?= base_url('material/material_revision_approval/minta_material_sequence') ?>',
        minLength: 1,
        select: function( event, ui ) {
            $("#squence_group_name").val(ui.item.material_type);
            $(this).val(ui.item.value);
            return false;
          }
      });
      // /-autocomplete form

      $.ajax({
        url: '<?= base_url('material/material_revision_approval/get_data_requestor') ?>',
        dataType: 'json',
        type: 'post',
        data: {
          idnya: idnya
        },
        success: function(res){
          modal_stop(xmodalx);
          $.each(res, function(index, el) {
            setTimeout(function(){
              var content = CKEDITOR.instances['m_desc_1'].setData(el.description);
              var content2 = CKEDITOR.instances['m_desc'].setData(el.description1);
            }, 500)
            // $("#m_desc_1").val(el.description)
            $("#material").val(el.material);
            $("#material_id").val(el.material);
            $("#optmaterial_uom").val(el.uom);
            $('#user_requestor').val(el.data2.name);
            $('#department_requestor').val(el.data2.department_desc);
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

            // cataloging detail

            if (el.data2.semic_main_group == "") {
                $('#m_uom').val(el.data2.uom1).select2({ width: '100%' });
                $('#unit_of_issue').val(el.data2.uom1).select2({ width: '100%' });
                $('#material_indicator').val(el.data2.indicator).select2({ width: '100%' });
                $('#stock_class').val(el.data2.stock_class).select2({ width: '100%' });
                $('#available').val(el.data2.availability).select2({ width: '100%' });
                $('#critical').val(el.data2.criticality).select2({ width: '100%' });
                $('#unit_of_issue').val(el.data2.unit_of_issue).select2({ width: '100%' });

                $('#gl_class').val(el.data2.gl_class).select2({ width: '100%' });
                $('#line_type').val(el.data2.line_type).select2({ width: '100%' });
                $('#stocking_type').val(el.data2.stocking_type).select2({ width: '100%' });
                $('#project_phase').val(el.data2.project_phase).select2({ width: '100%' });
                $('#inventory_type').val(el.data2.inventory_type).select2({ width: '100%' });
                $('#hazardous').val(el.data2.hazardous).select2({ width: '100%' });
                $('#unit_of_purchase').val(el.data2.unit_of_purchase).select2({ width: '100%' });
                $('#unit_of_issue2').val(el.data2.unit_of_issue2).select2({ width: '100%' });

                $("#classification").val("").select2({ width: '100%' }).trigger('change');
                $('#equipment_id').prop('disabled', true);
            } else {
                $.ajax({
                    url: '<?= base_url('material/material_revision_approval/material_classification_group') ?>',
                    type: 'GET',
                    data: {idx: el.data2.semic_main_group},
                    dataType: 'json',
                    success: function(res) {
                        $('#m_uom').val(el.data2.uom1).select2({ width: '100%' });
                        $('#unit_of_issue').val(el.data2.uom1).select2({ width: '100%' });
                        $('#material_indicator').val(el.data2.indicator).select2({ width: '100%' });
                        $('#stock_class').val(el.data2.stock_class).select2({ width: '100%' });
                        $('#available').val(el.data2.availability).select2({ width: '100%' });
                        $('#critical').val(el.data2.criticality).select2({ width: '100%' });
                        $('#unit_of_issue').val(el.data2.unit_of_issue).select2({ width: '100%' });

                        $('#gl_class').val(el.data2.gl_class).select2({ width: '100%' });
                        $('#line_type').val(el.data2.line_type).select2({ width: '100%' });
                        $('#stocking_type').val(el.data2.stocking_type).select2({ width: '100%' });
                        $('#project_phase').val(el.data2.project_phase).select2({ width: '100%' });
                        $('#inventory_type').val(el.data2.inventory_type).select2({ width: '100%' });
                        $('#hazardous').val(el.data2.hazardous).select2({ width: '100%' });
                        $('#unit_of_purchase').val(el.data2.unit_of_purchase).select2({ width: '100%' });
                        $('#unit_of_issue2').val(el.data2.unit_of_issue2).select2({ width: '100%' });

                        $("#classification").val(res.mgroup.PARENT).select2({ width: '100%' }).trigger('change');
                        setTimeout(function() {
                            $('#semic_group').val(el.data2.semic_main_group).trigger('change')
                            if (el.edit_content != 1) {
                                $(".m_registration_catalog :input").prop("disabled", true);
                                CKEDITOR.instances['m_desc'].setReadOnly(true);
                            }
                        }, 300);
                    }
                });
            }
            $('#m_name').val(el.data2.material_name);
            $('#m_short_desc').val(el.data2.shortdesc);
            $('#colluquials').val(el.data2.colluquials);
            $('#semic_no').val(el.data2.material_code);
            semicx += el.data2.MATERIAL_CODE;
            $('#search_text').val(el.data2.search_text);
            $('#equipment_id').val(el.data2.eqpment_id);
            $('#equipment_no').val(el.data2.eqpment_no);
            $('#requestno').html(el.data2.request_no);
            $('#req_date').html(el.data2.create_time);

            $('#no_manufacturer').val(el.data2.manufacturer);
            $('#name_manufacturer').val(el.data2.manufacturer_description);
            $('#part_no').val(el.data2.part_no);
            $('#model_type_no').val(el.data2.material_type);
            $('#model_type_name').val(el.data2.material_type_description);
            $('#squence_group_no').val(el.data2.sequence_group);
            $('#squence_group_name').val(el.data2.sequence_group_description);

            $('#m_type').val(el.data2.type);
            $('#serial_number').val(el.data2.serial_number);
            $('#monthly_usage').val(el.data2.monthly_usage);
            $('#annual_usage').val(el.data2.annual_usage);
            $('#initial_order_qty').val(el.data2.initial_order_qty);
            $('#expl_element').val(el.data2.expl_element);
            $('#estimate_value').val(el.data2.estimate_value);
            $('#shelf_life').val(el.data2.shelf_life);
            $('#cross_rererence').val(el.data2.cross_rererence);

            $('#group_class').val(el.data2.group_class);
            $('#mnemonic').val(el.data2.mnemonic);
            $('#item_name_code').val(el.data2.item_name_code);
            $('#preference').val(el.data2.preference);
            $('#item_name').val(el.data2.item_name);
            $('#part_number').val(el.data2.part_number);
            $('#stock_code_no').val(el.data2.stock_code_no);
            $('#part_status').val(el.data2.part_status);
            $('#stock_type').val(el.data2.stock_type);
            $('#item_ownership').val(el.data2.item_ownership);
            $('#rop').val(el.data2.rop);
            $('#statistic_code').val(el.data2.statistic_code);
            $('#roq').val(el.data2.roq);
            $('#min').val(el.data2.min);
            $('#origin_code').val(el.data2.origin_code);
            $('#conv_fact').val(el.data2.conv_fact);
            $('#tariff_code').val(el.data2.tariff_code);
            $('#std_pack').val(el.data2.std_pack);
            $('#supplier_number').val(el.data2.supplier_number);
            $('#unit_price').val(el.data2.unit_price);
            $('#fpa').val(el.data2.fpa);
            $('#freight_code').val(el.data2.freight_code);
            $('#lead_time').val(el.data2.lead_time);
            $('#inspection_code').val(el.data2.inspection_code);


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

            if (el.data2.img3_url != "" && el.data2.img4_url != "") {
              $("#image_upload").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.img3_url);
              $("#image_upload2").attr('src', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.img4_url);
              $("#img_material").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.img3_url);
              $("#img_mdrawing").attr('href', '<?= base_url(); ?>upload/MATERIAL/img/ori/' + el.data2.img4_url);

              if (el.data2.file_url2 == "" || el.data2.file_url2 == "-") {

              } else {
                var formatid = el.data2.file_url2.split(".").pop();
                if (formatid == 'jpg' || formatid == 'png' || formatid == 'gif') {
                    $("#image_upload3").attr('src', '<?= base_url(); ?>upload/MATERIAL/files/' + el.data2.file_url2);
                    $("#image_upload_location").attr('href', '#');
                } else {
                    $("#image_upload3").attr('src', '<?= base_url() ?>ast11/img/document-file-icon.png');
                    $("#image_upload_location").attr('href', '<?= base_url(); ?>upload/MATERIAL/files/' + el.data2.file_url2);
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
      // $('#myModal').show();
      // $("a#single_image").fancybox();
    });


    // reject
    $(document).on('show.bs.modal', '#modal_rej', function(e) {
      $('#myModal').modal('toggle');
      document.getElementById("reject_mdl").reset();
      var idnya = $(e.relatedTarget).data("id");
      $("#material_id_rej").val(idnya)
      $('#modal_rej .modal-header').css("background", "#d9534f");
      $('#modal_rej .modal-header').css("color", "#fff");

      // form handling
      var get_sequence = $(e.relatedTarget).data("name");
      $("#m_approval_id").val(get_sequence)
      // console.log(get_sequence);
      var result;
      $.ajax({
        url: '<?= base_url('material/material_revision_approval/request_sequence_id') ?>',
        type: 'POST',
        dataType: 'JSON',
        data: {get_sequence: get_sequence},
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        // console.log(res.sequence);
        $("#sequence_id_rej").val(res.sequence)
        $("#email_approve_rej").val(res.email_approve)
        $("#email_reject_rej").val(res.email_reject)
        $("#reject_step_rej").val(res.reject_step)
      });

      // submit reject
      $('#reject_mdl').on('submit', function(e) {
        e.preventDefault();
        var data = new FormData(this);
        // alert(idnya)
        swalConfirm('Catalogue Number Revision Request', '<?= __('confirm_submit') ?>', function() {
          var elm = modal_start($('.sweet-alert'));
          $.ajax({
            url: '<?= base_url('material/material_revision_approval/reject_request_material') ?>',
            dataType: 'json',
            type: 'post',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(res){
              modal_stop(elm)
              if (res == true) {
                window.location.href = "<?=base_url('home')?>";
              } else {
                console.log("EMAIL NOT SEND !");
                window.location.href = "<?=base_url('home')?>";
              }
            }
          })
        });
      });
    });

    // show data
    $('#tbl tfoot th').each(function (i) {
        var title = $('#tbl thead th').eq($(this).index()).text();
        if ($(this).text() == 'No') {
          $(this).html('');
        } else if ($(this).text() == 'Action') {
          $(this).html('');
        } else {
          $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
        }
    });
    var table=$('#tbl').DataTable({
        "ajax": {
            "url": "<?= base_url('material/material_revision_approval/datatable_logistic_specialist') ?>",
            "dataSrc": ""
        },
        "scrollX": true,
        "data": null,
        "searching": true,
        "paging": true,
        fixedColumns: {
            leftColumns: 0,
            rightColumns: 1
        },
        "columns": [
            {title: "No"},
            {title: "<?= lang("No Permintaan", "Request Number") ?>"},
            {title: "<?= lang("Deskripsi Material", "Material Description") ?>"},
            {title: "UoM"},
            {title: "<?= lang("Jabatan", "Position") ?>"},
            {title: "Status"},
            {title: "Action"}
        ],
        "columnDefs": [
            {"class": "text-center", "targets": [3]},
        ]
    });
    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });


  }); // end $(document).ready()

  function save_material_catalog(data){
    $.ajax({
      url: '<?= base_url('material/material_revision_approval/save_registrasi_catalog') ?>',
      dataType: 'json',
      type: 'post',
      data: data,
      cache: false,
      processData: false,
      contentType: false,
      success: function(res){
        // var kodematerial = $("#kodematerial").val();
        if (res.sendjde == 1 && res.semic_no != '') {
          window.location.href = "<?=base_url('home')?>";
        } else {
          if (res.sendjde == 0 && res.success == true) {
            window.location.href = "<?=base_url('home')?>";
          } else if (res.sendjde == 2 && res.success == true) {
            window.location.href = "<?=base_url('home')?>";
          }else {
            swal('<?= __('warning') ?>', 'System Error, Please contact administrator', 'warning');
          }
        }

      }
    })
  }

  function get_log(id){
    var result;
    $.ajax({
      url: '<?= base_url('material/material_revision_approval/get_log')?>',
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

  function get_note(id){
    var result;
    $.ajax({
      url: '<?= base_url('material/material_revision_approval/get_note')?>',
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
</script>
