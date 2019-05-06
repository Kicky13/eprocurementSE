<!-- <link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet"> -->
<!-- <link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<style media="screen">
input[type=checkbox]
{
/* Double-sized Checkboxes */
-ms-transform: scale(2); /* IE */
-moz-transform: scale(2); /* FF */
-webkit-transform: scale(2); /* Safari and Chrome */
-o-transform: scale(2); /* Opera */
padding: 10px;
}

/* Might want to wrap a span around your checkbox text */
.checkboxtext
{
/* Checkbox text */
font-size: 110%;
display: inline;
}
</style>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Buat Permintaan Material", "Create Material Request") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Permintaan Material", "Material Request") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Buat Permintaan Material", "Create Material Request") ?></li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- section tabel -->
        <div class="table_mreq" id="">
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
                                                  <button aria-expanded="false" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("TAMBAH PERMINTAAN MATERIAL", "CREATE") ?></button>
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
                                                          <th>No<</th>
                                                          <th>Req No<</th>
                                                          <th>Req Date<</th>
                                                          <th>Branch/Plant<</th>
                                                          <th>Material Request Type<</th>
                                                          <th>To Branch/Plant<</th>
                                                          <th>Purpose of Request<</th>
                                                          <th><?= lang("Status", "Status") ?><</th>
                                                          <th>Action<</th>
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
        <!-- //section form -->

        <!-- section form -->
        <div class="form_mreq" id="">
          <form class="form form-horizontal mreq_form">
          <div class="row ">
            <div class="col-md-12">
              <div class="card-header info-header" style="background-color:#d3f7ef">
                <div class="row ">
                  <div class="col-md-4">
                    <div class="card-content">
                      <div class="row">
                          <div class="col-md-12">
                            <table class="table table-borderless table-sm">
                              <tbody>
                                <tr>
                                  <td>User Requestor </td>
                                  <td class="text-left">: <?= $this->session->NAME; ?></td>
                                </tr>
                                <tr>
                                  <td>Department </td>
                                  <td class="text-left">: <?= $company->row()->DEPARTMENT_DESC; ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
                  </div>
                  <div class="col-md-4">
                    <div class="card-content">
                      <div class="row">
                          <div class="col-md-12">
                            <table class="table table-borderless table-sm">
                              <tbody>
                                <tr>
                                  <td>Material Request No </td>
                                  <td class="text-left" id="mr_no_htm">: <?= $req_no; ?> </td>
                                </tr>
                                <tr>
                                  <td>Request Date </td>
                                  <td class="text-left">: <?= date("d M Y"); ?></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
                  </div>
				          <div class="col-md-4">
                    <div class="card-content">
                      <div class="row">
                          <div class="col-md-12">
                            <table class="table table-borderless table-sm">
                              <tbody>
                                <tr>
                                  <td>Inv Transaction No / User </td>
                                  <td class="text-left" id="mr_tnumber">: <strong><label id="mr_tnumber"> - </label> / <label id="mr_user"> - </label></strong> </td>
                                </tr>
                                <tr>
                                  <td>Status </td>
                                  <td class="text-left" id="mr_status">: - </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
                  </div>
                  <input type="hidden" name="get_id" id="get_id" value="<?= $get_id; ?>" readonly>
                  <input type="hidden" name="mr_no" value="<?= $req_no; ?>">
                  <input type="hidden" name="comp_code" value="<?= $this->session->COMPANY ?>">
                  <input type="hidden" name="user" value="<?= $this->session->ID_USER; ?>">
                  <input type="hidden" name="departement" value="<?= $this->session->DEPARTMENT; ?>">
                  <input type="hidden" name="check_aas" id="check_aas" value="0">
                </div>
                  <!-- <div class="col-12 row">
                      <div class="col-12">
                          <h3 class="content-header-title mb-1" id="title_htm">Material Request<span id="company"></span></h3>
                      </div>
                      <div class="col-sm-6 row">
                          <div class="col-sm-3 pull-left">
                          <h5>User Requestor</h5>
                          <h5>Department</h5>
                          </div>
                          <div class="col-sm-3 pull-left">
                          <h5><?= $this->session->NAME; ?></h5>
                          <h5><?= $company->row()->DEPARTMENT_DESC; ?></h5>
                          </div>

                      </div>
                      <div class="col-sm-6 row" style="margin-left: 45px; padding-left: 90px;">
                          <div class="col-sm-4 pull-left">
                            <h5>Material Request No  </h5>
                            <h5>Request Date         </h5>
                            <h5>Inv. Transaction Number / User </h5>
                            <h5>Status   </h5>
                          </div>
                          <div class="col-sm-2 pull-right">
                            <h5><strong id="mr_no_htm"><?= $req_no; ?></strong></h5>
                            <h5><strong><?= date("d M Y"); ?></strong></h5>
                            <h5><strong><label id="mr_tnumber"> - </label> / <label id="mr_user"> - </label></strong></h5>
                            <h5><strong><label id="mr_status"> - </label></strong></h5>
                          </div>
                      </div>
                  </div> -->
                </div>
                <div class="card">
                    <div class="card-content collpase show card-scroll">
                        <div class="card-body">

                                <div class="form-body">

                                    <h4 class="form-section"><i class="ft-mail"></i> <?= lang("Permintaan Material", "Material Request") ?></h4>

                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput5">Purpose of Request</label>
                                                <div class="col-md-9">
                                                    <textarea maxlength="40" id="issue" rows="6" class="form-control border-primary" name="issue" placeholder="" required></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput6">Material Request Type</label>
                                                <div class="col-md-9">
                                                  <select class="form-control mr_type" style="width:350px;" name="mr_type" required>
                                                    <option value=""> Select .. </option>
                                                    <?php
                                                    foreach ($mr_type->result_array() as $arr) { ?>
                                                      <option value="<?= $arr['id']?>"><?= $arr['description'] ?></option>
                                                    <?php } ?>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">

                                          <!-- to company -->
                                          <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput8">From Company</label>
                                            <div class="col-md-9">
                                              <select class="form-control from_company" style="width:350px;" name="from_company" >
                                                <option value=""> Select .. </option>
                                                <?php
                                                foreach ($to_comp->result_array() as $arr) { ?>
                                                  <option value="<?= $arr['ID_COMPANY'] ?>"><?= $arr['DESCRIPTION'] ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                          </div>


                                          <!-- to branch plant -->
                                          <div class="branchplant_div">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control">From Branch/Plant</label>
                                                <div class="col-md-9">
                                                  <!-- <input type="text" class="form-control bp" name="bp" value=""> -->
                                                  <select class="form-control bp" style="width:350px;" name="bp" required>
                                                    <!-- <option value=""> Select .. </option>
                                                    <?php
                                                    foreach ($bp->result_array() as $arr) { ?>
                                                      <option value="<?= $arr['ID_BPLANT']?>"><?= $arr['ID_BPLANT'].' - '.$arr['BPLANT_DESC'] ?></option>
                                                    <?php } ?> -->
                                                  </select>
                                                </div>
                                            </div>
                                          </div>

                                          <div class="to_branch_plant_div">
                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">To Branch/Plant</label>
                                              <div class="col-md-9">
                                                <!-- <input type="text" class="form-control to_branch_plant" name="to_branch_plant" value=""> -->
                                                <select class="form-control to_branch_plant" style="width:350px;" name="to_branch_plant" >
                                                  <!-- <option value=""> Select .. </option>
                                                  <?php
                                                  foreach ($bp->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['ID_BPLANT']?>"><?= $arr['ID_BPLANT'].' - '.$arr['BPLANT_DESC'] ?></option>
                                                  <?php } ?> -->
                                                </select>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="to_company_div">
                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">To Company</label>
                                              <div class="col-md-9">
                                                <select class="form-control to_company" style="width:350px;" name="to_company" >
                                                  <option value=""> Select .. </option>
                                                  <?php
                                                  foreach ($to_comp->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['ID_COMPANY'] ?>"><?= $arr['DESCRIPTION'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>

                                          <div class="busines_unit">
                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">Business Unit</label>
                                              <div class="col-md-9">
                                                <select class="form-control costcenter" style="width:350px;" name="costcenter" >
                                                  <!-- <option value=""> Select .. </option>
                                                  <?php
                                                  foreach ($costcenter->result_array() as $arr) { ?>
                                                  <option value="<?= $arr['ID_COSTCENTER'] ?>"><?= $arr['COSTCENTER_DESC'] ?></option>
                                                <?php } ?> -->
                                              </select>
                                            </div>
                                          </div>
                                          </div>
                                          <div class="account_charge">
                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">Account Charge</label>
                                              <div class="col-md-9">
                                                <select class="form-control dept" style="width:350px;" name="dept">

                                                </select>
                                              </div>
                                            </div>
                                          </div>

                                          <!-- wo reason -->
                                          <div class="wo_reason_div">
                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">Write-Off Reason</label>
                                              <div class="col-md-9">
                                                <select class="form-control wo_reason" style="width:350px;" name="wo_reason" >
                                                  <option value=""> Select .. </option>
                                                  <?php
                                                  foreach ($wo_reason->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['id'] ?>"><?= $arr['wo_desc'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>

                                          <!-- intercompany transfer -->
                                          <div class="intercomp_trf">
                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">Type of Asset Utilization</label>
                                              <div class="col-md-9">
                                                <select class="form-control asset_type" style="width:350px !important;" name="asset_type" >
                                                  <option value=""> Select </option>
                                                  <?php
                                                  foreach ($asset_type->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['id'] ?>"><?= $arr['asset_type_desc'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>

                                            <div class="inspection_div">
                                              <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput8">Inspection</label>
                                                <div class="col-md-9">
                                                  <input type="checkbox" name="inspection" id="inspection" disabled>
                                                </div>
                                              </div>
                                              <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput8">Asset Valuation</label>
                                                <div class="col-md-9">
                                                  <input type="checkbox" name="asset_valuation" id="asset_valuation" disabled>
                                                </div>
                                              </div>
                                            </div>
                                          </div>

                                          <!-- disposal -->
                                          <div class="disposal_div">
                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">Disposal Method</label>
                                              <div class="col-md-9">
                                                <select class="form-control disposal_method" name="disposal_method" >
                                                  <option value=""> Select </option>
                                                  <?php
                                                  foreach ($disposal_method->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['id'] ?>"><?= $arr['disposal_desc'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>

                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">Justification On Disposal Method</label>
                                              <div class="col-md-9">
                                                <textarea maxlength="30" id="disposal_desc" rows="6" class="form-control border-primary" name="disposal_desc" placeholder="Justification On Disposal Method" ></textarea>
                                              </div>
                                            </div>

                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">Estimate Disposal Value</label>
                                              <div class="col-md-3">
                                                <select class="form-control disposal_value" name="disposal_value" >
                                                  <?php
                                                  foreach ($currency->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['ID'] ?>"><?= $arr['CURRENCY'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                              <div class="col-md-6">
                                                <input type="text" class="form-control" id="dis_val" name="dis_val" placeholder="">
                                              </div>
                                            </div>

                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">Estimate Disposal Cost</label>
                                              <div class="col-md-3">
                                                <select class="form-control disposal_cost" name="disposal_cost" >
                                                  <?php
                                                  foreach ($currency->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['ID'] ?>"><?= $arr['CURRENCY'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                              <div class="col-md-6">
                                                <input type="text" class="form-control" id="dis_cost" name="dis_cost" placeholder="">
                                              </div>
                                            </div>
                                          </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group text-right">
                                  <button class="btn btn-primary" type="button" id="add_mreq" data-toggle="modal" data-target="#modal_mreq" name="button"><?= lang("Tambah Material", "Add Material")?></button>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped table_item_request">
                                    <thead style="background-color:#d3f7ef" id="item_mreq_head">

                                    </thead>
                                    <tbody id="item_mreq">

                                    </tbody>
                                </table>
                            </div>
                                <div class="form-actions right">
                                  <a href="<?= base_url('material/material_req')?>" class="btn btn-secondary" id="" name="button"><?= lang("Batal", "Cancel")?></a>
                                  <button class="btn btn-success" type="submit" id="save_mreq" name="button"><?= lang("Simpan", "Submit")?></button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

      </div>
        <!-- //section form -->

    </div>
</div>

<!-- modalselect material & currency -->
<div id="modal_mreq" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <form class="modal-content" id="mreq_show">
            <div class="modal-header">
                <h3><b><?= lang("Tambah Material", "Add Material")?></b></h3>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button> -->
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
              <div class="row select_currency_div">
                <div class="col-md-6">
                  <div class="text-bold-600 font-medium-2"><h4><b><?= lang("Select Currency", "Select Currency")?></b> </h4></div>
                  <select class="form-control select_currency" style="width:750px !important;" name="select_currency" required>
                    <?php
                    foreach ($currency->result_array() as $arr) { ?>
                      <option value="<?= $arr['ID']?>" CURRENCY_NAME="<?= $arr['CURRENCY']?>"><?= $arr['CURRENCY'].' - '.$arr['DESCRIPTION']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <br>
              <h4><b><?= lang("Tambah Material", "Select Material")?></b> </h4>
              <div class="card-body card-dashboard">
                  <div class="row">
                      <div class="col-md-12">
                        <table id="tbl_add_material" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                            <tfoot>
                                <tr>
                                    <th><center></center></th>
                                    <th><center>SEMIC</center></th>
                                    <th><center>Description</center></th>
                                    <th><center>UOM</center></th>
                                    <th><center>Qty Avl</center></th>
                                    <th><center>Item Cost</center></th>
                                </tr>
                            </tfoot>
                        </table>
                      </div>
                  </div>
              </div>

              <!-- <div class="row">
                <div class="col-md-6">
                  <div class="text-bold-600 font-medium-2"><?= lang("Pilih Material", "Select Material")?></div>
                  <select class="form-control select_material" style="width:750px !important;" name="select_material" required>
                    <option value=""> Select .. </option>
                    <?php
                    foreach ($material->result_array() as $arr) { ?>
                      <option value="<?= $arr['MATERIAL']?>"><?= $arr['MATERIAL_NAME']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div> -->


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btncancel"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary add_dtmaterial"><?= lang("Tambah Data", "Add Material") ?></button>
            </div>
        </form>
    </div>
</div>

<!-- modal AAS -->
<div id="modal_aas" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class="modal-content" id="mreq_aas">
            <div class="modal-header">
                <?= lang("Asign To User AAS", "Asign To User AAS")?>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="text-bold-600 font-medium-2"><?= lang("Asign to user AAS ", "Asign to user AAS")?></div>
                  <input type="text" style="width:450px !important;" class="form-control aas_1" name="aas_1" value="" readonly>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <div class="text-bold-600 font-medium-2"><?= lang("Select second user AAS", "Select second user AAS")?></div>
                  <div class="select_aas2">

                  </div>
                </div>
              </div>

              <div class="intercomp_trf_aas">
                <br>
                <div class="row">
                  <div class="col-md-6">
                    <div class="text-bold-600 font-medium-2 title_aas1_other"><?= lang("Asign to user AAS other company", "Asign to user AAS other company")?></div>
                    <div class="select_aas1_other_comp">

                    </div>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-md-6">
                    <div class="text-bold-600 font-medium-2 title_aas2_other"><?= lang("Select second user AAS other company", "Select second user AAS other company")?></div>
                    <div class="select_aas2_other_comp">

                    </div>
                  </div>
                </div>
                <br>
              </div>

            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary"><?= lang("Simpan", "Simpan") ?></button>
            </div>
        </form>
    </div>
</div>


<!-- modal approval -->
<div id="modal_approval" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class=" modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1"><b>Material Request</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
                <div class="modal-body">
                  <div class="row">
                  <div class="col-md-12">
                      <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->
                    <div class="app-content">
                      <div class="content-wrapper">
                      <div id="edit" class="wrapper wrapper-content animated fadeInRight white-bg">
                        <form id="itp_form_apprv" action="#" class="steps-validation wizard-circle" enctype="multipart/form-data">
                            <h6><?= lang("Informasi", "Information"); ?></h6>
                            <h6><?= lang("Catatan", "Note"); ?></h6>
                            <h6><?= lang("History", "History"); ?></h6>

                            <fieldset id="bagian1" class="col-md-12" class="white-bg">
                            <h2 class="m-b-md"><?= lang("Informasi", "Information"); ?></h2>
                              <!-- section form -->
                            <div class="" id="">
                              <div class="row">
                                <div class="col-md-12">
                                  <div class="card-header"  >
                                    <div class="row info-header">
                                      <div class="col-md-4">
                                        <div class="card-content">
                                          <div class="row">
                                              <div class="col-md-12">
                                                <table class="table table-borderless table-sm">
                                                  <tbody>
                                                    <tr>
                                                      <td>User Requestor </td>
                                                      <td class="text-left" id="name">: </td>
                                                    </tr>
                                                    <tr>
                                                      <td>Department </td>
                                                      <td class="text-left" id="dept_desc">: </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="card-content">
                                          <div class="row">
                                              <div class="col-md-12">
                                                <table class="table table-borderless table-sm">
                                                  <tbody>
                                                    <tr>
                                                      <td>Material Request No </td>
                                                      <td class="text-left" id="mreq_no">:  </td>
                                                    </tr>
                                                    <tr>
                                                      <td>Request Date </td>
                                                      <td class="text-left" id="req_date">: </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                        </div>
                                      </div>
									  <div class="col-md-4">
                                        <div class="card-content">
                                          <div class="row">
                                              <div class="col-md-12">
                                                <table class="table table-borderless table-sm">
                                                  <tbody>
                                                    <tr>
                                                      <td>Inv Transaction No / User </td>
                                                      <td class="text-left" id="mr_tnumber_approval">: <strong><label id="mr_tnumber_approval"> - </label> / <label id="mr_user"> - </label></strong> </td>
                                                    </tr>
                                                    <tr>
                                                      <td>Status </td>
                                                      <td class="text-left" id="mr_status_approval">: - </td>
                                                    </tr>
                                                  </tbody>
                                                </table>
                                              </div>
                                            </div>
                                        </div>
                                      </div>
                                      <input type="hidden" id="mr_no" name="mr_no" value="">
                                      <input type="hidden" id="comp_code" name="comp_code" value="">
                                      <input type="hidden" id="user" name="user" value="">
                                      <input type="hidden" id="user_roles" name="user_roles" value="">
                                      <input type="hidden" id="sequence" name="sequence" value="">
                                      <input type="hidden" id="status_approve" name="status_approve" value="">
                                      <input type="hidden" id="reject_step" name="reject_step" value="">
                                      <input type="hidden" id="email_approve" name="email_approve" value="">
                                      <input type="hidden" id="email_reject" name="email_reject" value="">
                                      <input type="hidden" id="edit_content" name="edit_content" value="">
                                      <input type="hidden" id="extra_case" name="extra_case" value="">
                                    </div>
                                      <!-- <div class="col-12 row">
                                          <div class="col-8">
                                              <h3 class="content-header-title mb-1"><?= lang("Permintaan Material", "Material Request") ?><span id="company"></span></h3>
                                          </div>
                                          <div class="col-sm-8">
                                              <h5 id="name"></h5>
                                              <h5 id="dept_desc"></h5>
                                          </div>
                                          <div class="col-sm-4">
                                              <h5>Material Request No  : <strong id="mreq_no"> </strong></h5>
                                              <h5>Request Date  : <strong id="req_date"> </strong></h5>
                                          </div>
                                          <input type="hidden" id="mr_no" name="mr_no" value="">
                                          <input type="hidden" id="comp_code" name="comp_code" value="">
                                          <input type="hidden" id="user" name="user" value="">
                                          <input type="hidden" id="user_roles" name="user_roles" value="">
                                          <input type="hidden" id="sequence" name="sequence" value="">
                                          <input type="hidden" id="status_approve" name="status_approve" value="">
                                          <input type="hidden" id="reject_step" name="reject_step" value="">
                                          <input type="hidden" id="email_approve" name="email_approve" value="">
                                          <input type="hidden" id="email_reject" name="email_reject" value="">
                                          <input type="hidden" id="edit_content" name="edit_content" value="">
                                          <input type="hidden" id="extra_case" name="extra_case" value="">
                                      </div> -->
                                    </div>
                                    <div class="card">
                                    <div class="card-content collpase show card-scroll">
                                      <div class="card-body">

                                              <div class="form-body">
                                                  <h4 class="form-section"><i class="ft-mail"></i> <?= lang("Permintaan Material", "Material Request") ?></h4>

                                                  <div class="row">
                                                      <div class="col-md-6">

                                                          <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput5">Purpose of Request</label>
                                                              <div class="col-md-9">
                                                                  <textarea id="issue_apprv" rows="6" class="form-control border-primary" name="issue_apprv" placeholder="Issue for ICT" required readonly></textarea>
                                                              </div>
                                                          </div>

                                                          <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput6">Material Request Type</label>
                                                              <div class="col-md-9">
                                                                <select class="form-control mr_type_apprv" style="width:350px !important;" name="mr_type_apprv" required disabled>
                                                                  <option value=""> - </option>
                                                                  <?php
                                                                  foreach ($mr_type->result_array() as $arr) { ?>
                                                                    <option value="<?= $arr['id']?>"><?= $arr['description'] ?></option>
                                                                  <?php } ?>
                                                                </select>
                                                              </div>
                                                          </div>
                                                      </div>

                                                      <div class="col-md-6">
                                                        <div class="form-group row">
                                                          <label class="col-md-3 label-control" for="userinput8">From Company</label>
                                                          <div class="col-md-9">
                                                            <select disabled class="form-control from_company_apprv" style="width:350px;" name="from_company_apprv" >
                                                              <option value=""> - </option>
                                                              <?php
                                                              foreach ($to_comp->result_array() as $arr) { ?>
                                                                <option value="<?= $arr['ID_COMPANY'] ?>"><?= $arr['DESCRIPTION'] ?></option>
                                                              <?php } ?>
                                                            </select>
                                                          </div>
                                                        </div>
                                                        <!-- to branch plant -->
                                                        <div class="branchplant_div_apprv">
                                                          <div class="form-group row">
                                                              <label class="col-md-3 label-control">From Branch/Plant</label>
                                                              <div class="col-md-9">
                                                                <!-- <input type="text" class="form-control bp" name="bp" value=""> -->
                                                                <select disabled class="form-control bp_apprv" style="width:350px;" name="bp_apprv" required>
                                                                  <option value=""> - </option>
                                                                  <?php
                                                                  foreach ($bp->result_array() as $arr) { ?>
                                                                    <option value="<?= $arr['ID_BPLANT']?>"><?= $arr['ID_BPLANT'].' - '.$arr['BPLANT_DESC'] ?></option>
                                                                  <?php } ?>
                                                                </select>
                                                              </div>
                                                          </div>
                                                        </div>

                                                        <div class="to_branch_plant_div_apprv">
                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">To Branch/Plant</label>
                                                            <div class="col-md-9">
                                                              <!-- <input type="text" class="form-control to_branch_plant" name="to_branch_plant" value=""> -->
                                                              <select disabled class="form-control to_branch_plant_apprv" style="width:350px;" name="to_branch_plant_apprv" >
                                                                <option value=""> - </option>
                                                                <?php
                                                                foreach ($bp->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['ID_BPLANT']?>"><?= $arr['ID_BPLANT'].' - '.$arr['BPLANT_DESC'] ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <div class="busines_unit_apprv">
                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">Business Unit</label>
                                                            <div class="col-md-9">
                                                              <select class="form-control costcenter_apprv" style="width:350px;" name="costcenter_apprv" disabled>
                                                                <option value=""> - </option>
                                                                <?php
                                                                foreach ($costcenter->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['ID_COSTCENTER'] ?>"><?= $arr['ID_COSTCENTER'].' - '.$arr['COSTCENTER_DESC'] ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                          </div>
                                                        </div>
                                                        <div class="account_charge_apprv">
                                                          <div class="form-group row ">
                                                            <label class="col-md-3 label-control" for="userinput8">Account Charge</label>
                                                            <div class="col-md-9">
                                                              <input class="form-control dept_apprv" name="dept_apprv" value="" readonly>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <!-- to company -->
                                                        <div class="to_company_div_apprv">

                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">To Company</label>
                                                            <div class="col-md-9">
                                                              <select disabled class="form-control to_company_apprv" style="width:350px;" name="to_company_apprv" >
                                                                <option value=""> - </option>
                                                                <?php
                                                                foreach ($to_comp->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['ID_COMPANY'] ?>"><?= $arr['DESCRIPTION'] ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <!-- wo reason -->
                                                        <div class="wo_reason_div_apprv">
                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">Write-Off Reason</label>
                                                            <div class="col-md-9">
                                                              <select disabled class="form-control wo_reason_apprv" style="width:350px;" name="wo_reason_apprv" >
                                                                <option value=""> - </option>
                                                                <?php
                                                                foreach ($wo_reason->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['id'] ?>"><?= $arr['wo_desc'] ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                          </div>
                                                        </div>

                                                        <!-- intercompany transfer -->
                                                        <div class="intercomp_trf_apprv">
                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">Type of Asset Utilization</label>
                                                            <div class="col-md-9">
                                                              <select class="form-control asset_type_apprv" style="width:350px !important;" name="asset_type_apprv" disabled>
                                                                <option value=""> Select </option>
                                                                <?php
                                                                foreach ($asset_type->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['id'] ?>"><?= $arr['asset_type_desc'] ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                          </div>

                                                          <div class="inspection_div_apprv">
                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">Inspection</label>
                                                              <div class="col-md-9">
                                                                <input type="checkbox" name="inspection_apprv" id="inspection_apprv" disabled>
                                                              </div>
                                                            </div>
                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">Asset Valuation</label>
                                                              <div class="col-md-9">
                                                                <input type="checkbox" name="asset_valuation_apprv" id="asset_valuation_apprv" disabled>
                                                              </div>
                                                            </div>
                                                          </div>

                                                        </div>

                                                        <!-- disposal -->
                                                        <div class="disposal_div_apprv">
                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">Disposal Method</label>
                                                            <div class="col-md-9">
                                                              <select class="form-control disposal_method_apprv" name="disposal_method_apprv" disabled>
                                                                <option value=""> Select </option>
                                                                <?php
                                                                foreach ($disposal_method->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['id'] ?>"><?= $arr['disposal_desc'] ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                          </div>

                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">Justification On Disposal Method</label>
                                                            <div class="col-md-9">
                                                              <textarea maxlength="30" id="disposal_desc_apprv" rows="6" class="form-control border-primary" name="disposal_desc_apprv" placeholder="Justification On Disposal Method" disabled></textarea>
                                                            </div>
                                                          </div>

                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">Estimate Disposal Value</label>
                                                            <div class="col-md-3">
                                                              <select class="form-control disposal_value_apprv" style="width:100px !important;" name="disposal_value_apprv" disabled>
                                                                <option value=""> - </option>
                                                                <?php
                                                                foreach ($currency->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['ID'] ?>"><?= $arr['CURRENCY'] ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                              <input type="text" class="form-control" id="dis_val_apprv" name="dis_val_apprv" placeholder="" readonly>
                                                            </div>
                                                          </div>

                                                          <div class="form-group row">
                                                            <label class="col-md-3 label-control" for="userinput8">Estimate Disposal Cost</label>
                                                            <div class="col-md-3">
                                                              <select class="form-control disposal_cost_apprv" style="width:100px !important;" name="disposal_cost_apprv" disabled>
                                                                <option value=""> - </option>
                                                                <?php
                                                                foreach ($currency->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['ID'] ?>"><?= $arr['CURRENCY'] ?></option>
                                                                <?php } ?>
                                                              </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                              <input type="text" class="form-control" id="dis_cost_apprv" name="dis_cost_apprv" placeholder="" readonly>
                                                            </div>
                                                          </div>
                                                        </div>

                                                      </div>
                                                  </div>
                                              </div>
                                              <div class="table-responsive">
                                              <table class="table table-bordered table-striped">
                                                <thead style="background-color:#d3f7ef">
                                                    <tr>
                                                        <th class="semic-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; SEMIC &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="desc-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= lang("Deskripsi", "Description"); ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="uom-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; UOM &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="qtyact-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Req &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="qtyavl-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Avl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="qtyreq-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Act &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="glclass-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GL Class &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="unitcost-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Unit Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="curr-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?= lang("Matauang","Currency")?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="tounitcost-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To Unit Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="exammount-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Ammount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="toexammount-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To Extended Ammount &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="bp-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; From Branch / Plant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="tobp-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To Branch / Plant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="bu-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Business unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="loc-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; From Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="toloc-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="acc-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Account &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="accdesc-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Account Desc &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="cat-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="acqyear-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Acquitition Year &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="acqval-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Acquitition Value &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="book-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Current Book &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="mtrstatus-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Material Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="assetvprice-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Asset Valuation Price &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                        <th class="remark-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="item_mreq_apprv">

                                                </tbody>
                                              </table>
                                          </div>

                                      </div>
                                    </div>
                                </div>
                              </div>
                            </div>

                          </div>
                          <!-- //section form -->
                          </fieldset>
                          <br>

                          <!-- section note -->
                          <fieldset id="bagian2" class="col-12">
                          <h2 class="m-b"><?= lang("Catatan", "Note"); ?></h2>
                          <div class="card-footer px-0 py-0">
                            <div class="card-body">
                              <div class="form-group position-relative has-icon-left mb-0">
                                <textarea id="notes" name="notes" maxlength="225" rows="8" cols="80" class="form-control" placeholder="Write Some Note..." disabled></textarea>
                                  <div class="form-control-position">
                                      <i class="fa fa-dashcube"></i>
                                  </div>
                                  <br>
                                  <button type="button" name="button" class="btn btn-primary pull-right savenote" disabled  > <i class="fa fa-location-arrow"></i> Send </button>
                              </div>
                            </div>
                            <br>
                            <br>
                            <div class="data-note">

                            </div>
                          </fieldset>

                          <fieldset id="bagian3" class="col-12">
                          <h2 class="m-b"><?= lang("History", "History"); ?></h2>
                          <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>No</th>
                                    <th>Role Access</th>
                                    <th>User</th>
                                    <th><?=lang("Keterangan", "Approval Status")?></th>
                                    <th><?=lang("Tanggal Dibuat", "Transaction Date")?></th>
                                  </tr>
                                </thead>
                                <tbody id="log_history">

                                </tbody>
                              </table>
                            </div>
                          </fieldset>

                      </div>
                      </div>
                    </div>
                    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->

                  </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <!-- <button type="button" class="btn btn-info" id="note" style="margin-right: 300px;"><i class="fa fa-desktop"></i> <?= lang('Catatan', 'Note') ?></button> -->
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <a href="#" type="button" class="btn btn-primary" onClick="return confirm('You will update this material request data, are you sure?')" id="btnrecreate"><?= lang('Usulkan Ulang', 'Re-Proposed') ?></a>
                    <!-- <button type="button" class="btn btn-danger" id="btnreject"><?= lang('Tolak', 'Reject') ?></button>
                    <button type="button" class="btn btn-primary" id="btnapprove"><?= lang('Setujui', 'Approve') ?></button> -->
                </div>
              </form>
        </div>
    </div>
</div>
</div>
</div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<script src="<?= base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/core/app.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function() {
    // $(".table_mreq").hide();
    $(".form_mreq").hide();
    $("#save_mreq").prop('disabled', true);

    var dt_array = [];
    var dt_intrf = [];
    var dt_material = [];
    var get_currency = '';
    var get_accsub = '';
    var dt_accsub = [];
    $(".mr_type").select2();
    $(".dept").select2();
    $(".bp").select2();

    $(".from_company").select2();
    $(".to_company").select2();
    $(".wo_reason").select2();
    $(".asset_type").select2();
    $(".costcenter").select2();
    $(".account_charge").hide();
    $(".to_branch_plant_div").hide();
    $(".to_company_div").hide();
    $(".branchplant_div").hide();
    $(".wo_reason_div").hide();
    $(".intercomp_trf").hide();
    $(".disposal_div").hide();
    $(".select_currency_div").hide();
    $(".busines_unit").hide();
    input_numberic('#dis_val', true);
    input_numberic('#dis_cost', true);

    $("#add").on('click', function(e) {
      // e.preventDefault();
      /* Act on the event */
      $(".table_mreq").hide();
      $(".form_mreq").show();
    });

    // wijard
    var form = $(".steps-validation").show();
    $(".number-tab-steps").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
        labels: {
            finish: 'Submit'
        },
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });

    // Show form
    var form = $(".steps-validation").show();

    $(".steps-validation").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
    		titleTemplate: '#title#',
    		enableFinishButton: false,
    		enablePagination: true,
    		enableAllSteps: true,
        labels: {
            finish: 'Submit'
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex)
            {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age-2").val()) < 18)
            {
                return false;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex)
            {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            $("li a:contains(Submit)").hide();
            // $("#save").show();
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            alert("Submitted!");
        }
    });

	//hide next and previous button
	$('a[href="#next"]').hide();
	$('a[href="#previous"]').hide();

    // Initialize validation
    $(".steps-validation").validate({
        ignore: 'input[type=hidden]', // ignore hidden fields
        errorClass: 'danger',
        successClass: 'success',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            email: {
                email: true
            }
        }
    });

    // selection when add or recreate data //
    $(".costcenter").on("change", function(){
      var resx;
      $('.dept').val("").select2();
      if (dt_material.length > 0) {
        var xmodalx = modal_start($(".form_mreq").find(".mreq_form"));

        $.each(dt_material, function(index, el) {
          // console.log(el);
          var res = el.split("|");
          // console.log(parseInt(res[0]));
          $.ajax({
            url: '<?= base_url('material/material_req/show_acharge')?>',
            type: 'POST',
            dataType: 'JSON',
            data: {idx: $(".costcenter").val(), mid: res[1], }
          })
          .done(function() {
            resx = true;
          })
          .fail(function() {
            resx = false;
          })
          .always(function(ress) {
            if (resx == true) {
              modal_stop(xmodalx);
              // $(".dept").html(res.data);
              var str_opt = ress.data;
              // $(".account_id").html(str_opt);

              $("#acc"+parseInt(res[0])).html(str_opt);
              $("#bu"+parseInt(res[0])).val($(".costcenter").val());
            }
          });

        });
      } else {
        $.ajax({
          url: '<?= base_url('material/material_req/show_acharge')?>',
          type: 'POST',
          dataType: 'JSON',
          data: {idx: $(this).val() }
        })
        .done(function() {
          resx = true;
        })
        .fail(function() {
          resx = false;
        })
        .always(function(res) {
          if (resx == true) {
            $(".dept").html(res.data);
          }
        });
      }

    })

    $(".bp").on("change", function(){
      var resy;
      if (dt_material.length > 0) {
        var xmodalx = modal_start($(".form_mreq").find(".mreq_form"));
        $.ajax({
          url: '<?= base_url('material/material_req/get_data_jde')?>',
          type: 'POST',
          dataType: 'JSON',
          data: {
            bplant: $(this).val(),
            semic_no: dt_material
           }
        })
        .done(function() {
          resy = true;
        })
        .fail(function() {
          resy = false;
        })
        .always(function(ress) {
          if (resy == true) {
            setTimeout(function(){
              modal_stop(xmodalx);
              console.log(ress);
              $.each(ress, function(indexx, dul) {
                console.log(dul.data_jde.qty_onhand);
                $("#qty_avl"+parseInt(dul.material_id)).val(dul.data_jde.qty_onhand);
                $("#qty_avl_ori"+parseInt(dul.material_id)).val(dul.data_jde.qty_onhand);
                $("#bp_item"+parseInt(dul.material_id)).val($(".bp").val());
              });
            },1000)

          }
        });
      }
    })

    $(".to_company").on("change", function(){
      var resx;
      var resy;
      if ($(this).val() != "" && $(".mr_item").val() != "") {
        $("#add_mreq").prop('disabled', false);
      } else {
        $("#add_mreq").prop('disabled', true);
      }

      $.ajax({
        url: '<?= base_url('material/material_req/show_company_selection')?>',
        type: 'POST',
        dataType: 'JSON',
        data: {idx: $(this).val() }
      })
      .done(function() {
        resx = true;
      })
      .fail(function() {
        resx = false;
      })
      .always(function(res) {
        if (resx == true) {
          $(".to_branch_plant").html(res.data_bplant);
          $('.to_branch_plant').select2();
          // console.log(res.data);
        }
      });

      if (dt_material.length > 0) {

        var xmodalx = modal_start($(".form_mreq").find(".mreq_form"));

        $.ajax({
          url: '<?= base_url('material/material_req/get_data_jde')?>',
          type: 'POST',
          dataType: 'JSON',
          data: {
            bplant: $(".bp").val(),
            semic_no: dt_material
           }
        })
        .done(function() {
          resy = true;
        })
        .fail(function() {
          resy = false;
        })
        .always(function(ress) {
          if (resy == true) {
            setTimeout(function(){
              modal_stop(xmodalx);
              $.each(ress, function(indexx, dul) {
                console.log(dul.material_id);
                $("#qty_avl"+parseInt(dul.material_id)).val(dul.data_jde.qty_onhand);
                $("#qty_avl_ori"+parseInt(dul.material_id)).val(dul.data_jde.qty_onhand);
                $("#to_bp_item"+parseInt(dul.material_id)).val($(".to_branch_plant").val());
              });
            },1000)

          }
        });
      }

    })


    $(".from_company").on("change", function(){
      var resx;
      var resy;
      if ($(this).val() != "" && $(".mr_item").val() != "") {
        $("#add_mreq").prop('disabled', false);
      } else {
        $("#add_mreq").prop('disabled', true);
      }
      $('.costcenter').val("").select2();

      $.ajax({
        url: '<?= base_url('material/material_req/show_company_selection')?>',
        type: 'POST',
        dataType: 'JSON',
        data: {idx: $(this).val() }
      })
      .done(function() {
        resx = true;
      })
      .fail(function() {
        resx = false;
      })
      .always(function(res) {
        if (resx == true) {
          $(".bp").html(res.data_bplant);
          $(".to_branch_plant").html(res.data_to_bplant);
          $(".costcenter").html(res.data_costcenter);
          $('.bp').select2();
          $('.to_branch_plant').select2();
          $("#mr_no_htm").html(': '+res.data_request_no);
          // console.log(res.data);
        }
      });

      if (dt_material.length > 0) {

        var xmodalx = modal_start($(".form_mreq").find(".mreq_form"));

        $.ajax({
          url: '<?= base_url('material/material_req/get_data_jde')?>',
          type: 'POST',
          dataType: 'JSON',
          data: {
            bplant: $(".bp").val(),
            semic_no: dt_material
           }
        })
        .done(function() {
          resy = true;
        })
        .fail(function() {
          resy = false;
        })
        .always(function(ress) {
          if (resy == true) {
            setTimeout(function(){
              modal_stop(xmodalx);
              $.each(ress, function(indexx, dul) {
                console.log(dul.material_id);
                $("#qty_avl"+parseInt(dul.material_id)).val(dul.data_jde.qty_onhand);
                $("#qty_avl_ori"+parseInt(dul.material_id)).val(dul.data_jde.qty_onhand);
                $("#bp_item"+parseInt(dul.material_id)).val($(".bp").val());
              });
            },1000)

          }
        });
      }

    })

    /////////////////////////////////////////////////////////////// RECREATE MR ///////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////// RECREATE MR ///////////////////////////////////////////////////////////////////////////
    var get_id = $("#get_id").val();
    if (get_id != "") {
      $(".table_mreq").hide();
      $(".form_mreq").show();
      $("#add_mreq").prop('disabled', false);

      var resx;
      $.ajax({
        url: '<?= base_url('material/Material_req_approval/get_material_req')?>',
        type: 'POST',
        dataType: 'JSON',
        data: {
          idnya: get_id,
          // costcenter: $(".costcenter").val(),
        }
      })
      .done(function() {
        resx = true;
      })
      .fail(function() {
        resx = false;
      })
      .always(function(res) {
        if (resx == true) {
          console.log(res);
          $("#mr_no").val(res.material_request.request_no);
          $("#comp_code").val(res.material_request.departement);

          $("#mr_no_htm").html(res.material_request.request_no);
          $("#title_htm").html("Re-proposed Material Request : "+res.material_request.request_no);
          $("#issue").html(res.material_request.purpose_of_request);
          $(".mr_type").val(res.material_request.document_type).trigger("change").select2();
          $(".mr_type").attr('disabled', true);
          $(".to_branch_plant").val(res.material_request.to_branch_plant).select2();
          $(".from_company").val(res.material_request.from_company).select2().trigger('change');
          setTimeout(function(){
            $(".bp").val(res.material_request.branch_plant).select2();
            $(".costcenter").val(res.material_request.busines_unit).select2().trigger('change');
            setTimeout(function(){
              $(".dept").val(res.material_request.account+'|'+res.material_request.account_desc).select2();
            },1000)
          },1500)
          $(".to_company").val(res.material_request.to_company).select2();
          $(".wo_reason").val(res.material_request.wo_reason).select2();
          // var uniquedt = [];
          $.each(res.material_request_detail, function(index, al) {
            dt_material.push(al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl);

            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //////////////
            setTimeout(function(){
              if (dt_material.length <= 0) {
                swal('Ooops!', 'You Must Select The Material', 'warning');
                $("#save_mreq").prop('disabled', true);
              } else {
                $("#save_mreq").prop('disabled', false);

                var option_bp_item = $(".bp").val();
                var option_to_bp_item = $(".to_branch_plant").val();
                var option_bu = $(".costcenter").val();
                // var opt_acharge = show_acharge(option_bu);
                var currency_id = $(".select_currency").val();
                var currency_name = $('option:selected', ".select_currency").attr('CURRENCY_NAME');
                var acc_charge = $(".dept").val();
                 if (acc_charge == "" || acc_charge == null) {
                   var accx = '';
                   var acc_desc = '';
                 } else {
                   var acc_charge_split = acc_charge.split("|");
                   var accx = acc_charge_split[0];
                   var subsidiary = accx.replace("-", ".");
                   var acc_desc = acc_charge_split[1];
                 }

                 $("#material_check"+al.mr_item.MATERIAL).prop('checked', true);
                 console.log(dt_material);
                  $.each(al.mr_item, function(index, el) {
                    // console.log(dt_material);
                    var res = el.split("|");
                    var mr_type = $(".mr_type").val();
                    if (mr_type == 1 || mr_type == 4) {
                      // issue
                      var str = '<tr>'+
                                  '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+al.mr_item.MATERIAL+'"><input class="form-control" type="hidden" name="semic[]" value="'+al.mr_item.semic_no+'">'+al.mr_item.semic_no+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="m_name[]" value="'+al.mr_item.item_desc+'">'+al.mr_item.item_desc+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="uom[]" value="'+al.mr_item.uom+'">'+al.mr_item.uom+'</td>'+
                                  '<td><input class="form-control" type="text" id="qty'+al.mr_item.MATERIAL+'" name="qty[]" value="'+al.mr_item.qty+'" onChange="change('+al.mr_item.MATERIAL+', '+mr_type+')" required></td>'+
                                  '<td><input class="form-control" type="hidden" id="qty_avl'+al.mr_item.MATERIAL+'" name="qty_avl[]" value="'+al.mr_item.qty_avl+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+al.mr_item.MATERIAL+'" name="qty_avl_ori[]" value="'+al.mr_item.qty_avl+'" readonly></td>'+
                                  '<td><input class="form-control" type="text" id="qty_act'+al.mr_item.MATERIAL+'" name="qty_act[]" readonly></td>'+
                                  '<td><input class="form-control" type="hidden" id="gl_class'+al.mr_item.MATERIAL+'" name="gl_class[]" value="'+al.mr_item.glclass_desc+'" readonly>'+al.mr_item.glclass_desc+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+currency_name+'</td>'+
                                  '<input class="form-control" type="hidden" id="unit_price'+al.mr_item.MATERIAL+'" name="unit_price[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="total'+al.mr_item.MATERIAL+'" name="ammount[]" readonly>'+
                                  '<td><input class="form-control" type="text" id="bp_item'+al.mr_item.MATERIAL+'" value="'+option_bp_item+'" name="bp_item[]" required readonly></td>'+
                                  '<td><input class="form-control" type="text" id="bu'+al.mr_item.MATERIAL+'" value="'+option_bu+'" name="bu[]" readonly></td>'+
                                  '<td><input type="text" class="form-control" id="from_loc'+al.mr_item.MATERIAL+'" name="from_loc[]" value="'+al.mr_item.location+'"></td>'+
                                  '<td><select class="form-control account_id" id="acc'+al.mr_item.MATERIAL+'" name="acc[]" required>'+get_accsub+'</select></td>'+
                                  '<input type="hidden" class="form-control" id="acc_desc'+al.mr_item.MATERIAL+'" name="acc_desc[]" value="'+acc_desc+'" readonly>'+acc_desc+' '+
                                  '<td><textarea id="remark'+al.mr_item.MATERIAL+'" rows="3" class="form-control border-primary" name="remark[]"   readonly>'+al.mr_item.remark+'</textarea></td>'+
                                  '<input class="form-control" type="hidden" id="mtr_status'+al.mr_item.MATERIAL+'" name="mtr_status[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="category'+al.mr_item.MATERIAL+'" name="category[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acq_year'+al.mr_item.MATERIAL+'" name="acq_year[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acq_value'+al.mr_item.MATERIAL+'" name="acq_value[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="curr_book'+al.mr_item.MATERIAL+'" name="curr_book[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="to_total'+al.mr_item.MATERIAL+'" name="to_ammount[]">'+
                                  '<input class="form-control" type="hidden" id="to_unit_cost'+al.mr_item.MATERIAL+'" name="to_unit_cost[]" >'+
                                  '<input type="hidden" class="form-control" id="to_loc'+al.mr_item.MATERIAL+'" name="to_loc[]">'+
                                  '<input class="form-control" type="hidden" id="to_bp_item'+al.mr_item.MATERIAL+'" name="to_bp_item[]">'+
                                  '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'" type="button"> Remove</button></td>'+
                              '</tr>';
                    } else if (mr_type == 2) {
                      // adjustment
                      var str = '<tr>'+
                                  '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+al.mr_item.MATERIAL+'"><input class="form-control" type="hidden" name="semic[]" value="'+al.mr_item.semic_no+'">'+al.mr_item.semic_no+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="m_name[]" value="'+al.mr_item.item_desc+'">'+al.mr_item.item_desc+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="uom[]" value="'+al.mr_item.uom+'">'+al.mr_item.uom+'</td>'+
                                  '<td><input class="form-control" type="text" id="qty'+al.mr_item.MATERIAL+'" name="qty[]" value="'+al.mr_item.qty+'" onChange="change('+al.mr_item.MATERIAL+', '+mr_type+')" required></td>'+
                                   '<td><input class="form-control" type="hidden" id="qty_avl'+al.mr_item.MATERIAL+'" name="qty_avl[]" value="'+al.mr_item.qty_avl+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+al.mr_item.MATERIAL+'" name="qty_avl_ori[]" value="'+al.mr_item.qty_avl+'" readonly></td>'+
                                  '<td><input class="form-control" type="text" id="qty_act'+al.mr_item.MATERIAL+'" name="qty_act[]" readonly></td>'+
                                  '<td><input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+currency_name+'</td>'+
                                  '<input class="form-control" type="hidden" id="unit_price'+al.mr_item.MATERIAL+'" name="unit_price[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="total'+al.mr_item.MATERIAL+'" name="ammount[]" readonly>'+
                                  '<td><input class="form-control" type="text" id="bp_item'+al.mr_item.MATERIAL+'" value="'+option_bp_item+'" name="bp_item[]" required readonly></td>'+
                                  '<td><input type="text" class="form-control" id="from_loc'+al.mr_item.MATERIAL+'" name="from_loc[]" value="'+al.mr_item.location+'"></td>'+
                                  '<td><textarea id="remark'+al.mr_item.MATERIAL+'" rows="3" class="form-control border-primary" name="remark[]"   readonly>'+al.mr_item.remark+'</textarea></td>'+
                                  '<input class="form-control" type="hidden" id="mtr_status'+al.mr_item.MATERIAL+'" name="mtr_status[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="category'+al.mr_item.MATERIAL+'" name="category[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acq_year'+al.mr_item.MATERIAL+'" name="acq_year[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acq_value'+al.mr_item.MATERIAL+'" name="acq_value[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="curr_book'+al.mr_item.MATERIAL+'" name="curr_book[]" readonly>'+
                                  '<input type="hidden" class="form-control" id="acc'+al.mr_item.MATERIAL+'" name="acc[]">'+
                                  '<input type="hidden" class="form-control" id="acc_desc'+al.mr_item.MATERIAL+'" name="acc_desc[]">'+
                                  '<input class="form-control" type="hidden" id="to_total'+al.mr_item.MATERIAL+'" name="to_ammount[]">'+
                                  '<input class="form-control" type="hidden" id="to_unit_cost'+al.mr_item.MATERIAL+'" name="to_unit_cost[]" >'+
                                  '<input type="hidden" class="form-control" id="to_loc'+al.mr_item.MATERIAL+'" name="to_loc[]">'+
                                  '<input class="form-control" type="hidden" id="to_bp_item'+al.mr_item.MATERIAL+'" name="to_bp_item[]">'+
                                  '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'" type="button"> Remove</button></td>'+
                              '</tr>';
                    } else if (mr_type == 3 || mr_type == 5) {
                      // transfer b/p program & item modification
                      var str = '<tr>'+
                                  '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+al.mr_item.MATERIAL+'"><input class="form-control" type="hidden" name="semic[]" value="'+al.mr_item.semic_no+'">'+al.mr_item.semic_no+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="m_name[]" value="'+al.mr_item.item_desc+'">'+al.mr_item.item_desc+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="uom[]" value="'+al.mr_item.uom+'">'+al.mr_item.uom+'</td>'+
                                  '<td><input class="form-control" type="text" id="qty'+al.mr_item.MATERIAL+'" name="qty[]" value="'+al.mr_item.qty+'" onChange="change('+al.mr_item.MATERIAL+', '+mr_type+')" required></td>'+
                                   '<td><input class="form-control" type="hidden" id="qty_avl'+al.mr_item.MATERIAL+'" name="qty_avl[]" value="'+al.mr_item.qty_avl+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+al.mr_item.MATERIAL+'" name="qty_avl_ori[]" value="'+al.mr_item.qty_avl+'" readonly></td>'+
                                  '<td><input class="form-control" type="text" id="qty_act'+al.mr_item.MATERIAL+'" name="qty_act[]" readonly></td>'+
                                  '<td><input type="text" class="form-control" id="from_loc'+al.mr_item.MATERIAL+'" name="from_loc[]" value="'+al.mr_item.location+'"></td>'+
                                  '<td><input type="text" class="form-control" id="to_loc'+al.mr_item.MATERIAL+'" value="'+al.mr_item.to_location+'" name="to_loc[]"></td>'+
                                  '<td><textarea id="remark'+al.mr_item.MATERIAL+'" rows="3" class="form-control border-primary" name="remark[]"   readonly>'+al.mr_item.remark+'</textarea></td>'+
                                  '<input class="form-control" type="hidden" id="mtr_status'+al.mr_item.MATERIAL+'" name="mtr_status[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="category'+al.mr_item.MATERIAL+'" name="category[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acq_year'+al.mr_item.MATERIAL+'" name="acq_year[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acq_value'+al.mr_item.MATERIAL+'" name="acq_value[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="curr_book'+al.mr_item.MATERIAL+'" name="curr_book[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="bp_item'+al.mr_item.MATERIAL+'" name="bp_item[]" required>'+
                                  '<input class="form-control" type="hidden" id="unit_price'+al.mr_item.MATERIAL+'" name="unit_price[]" >'+
                                  '<input class="form-control" type="hidden" id="total'+al.mr_item.MATERIAL+'" name="ammount[]" >'+
                                  '<input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+
                                  '<input type="hidden" class="form-control" id="acc'+al.mr_item.MATERIAL+'" name="acc[]">'+
                                  '<input type="hidden" class="form-control" id="acc_desc'+al.mr_item.MATERIAL+'" name="acc_desc[]">'+
                                  '<input class="form-control" type="hidden" id="to_total'+al.mr_item.MATERIAL+'" name="to_ammount[]">'+
                                  '<input class="form-control" type="hidden" id="to_unit_cost'+al.mr_item.MATERIAL+'" name="to_unit_cost[]" >'+
                                  '<input class="form-control" type="hidden" id="to_bp_item'+al.mr_item.MATERIAL+'" name="to_bp_item[]">'+
                                  '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'" type="button"> Remove</button></td>'+
                              '</tr>';
                    } else if (mr_type == 6) {
                      // intercompany trf
                      var str = '<tr>'+
                                  '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+al.mr_item.MATERIAL+'"><input class="form-control" type="hidden" name="semic[]" value="'+al.mr_item.semic_no+'">'+al.mr_item.semic_no+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="m_name[]" value="'+al.mr_item.item_desc+'">'+al.mr_item.item_desc+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="uom[]" value="'+al.mr_item.uom+'">'+al.mr_item.uom+'</td>'+
                                  '<td><input class="form-control" type="text" id="qty'+al.mr_item.MATERIAL+'" name="qty[]" value="'+al.mr_item.qty+'" onChange="change('+al.mr_item.MATERIAL+', '+mr_type+')" required></td>'+
                                   '<td><input class="form-control" type="hidden" id="qty_avl'+al.mr_item.MATERIAL+'" name="qty_avl[]" value="'+al.mr_item.qty_avl+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+al.mr_item.MATERIAL+'" name="qty_avl_ori[]" value="'+al.mr_item.qty_avl+'" readonly></td>'+
                                  '<td><input class="form-control" type="text" id="qty_act'+al.mr_item.MATERIAL+'" name="qty_act[]" readonly></td>'+
                                  '<td><input class="form-control" type="text" id="bp_item'+al.mr_item.MATERIAL+'" value="'+option_bp_item+'" name="bp_item[]" required readonly></td>'+
                                  '<input type="hidden" class="form-control" id="from_loc'+al.mr_item.MATERIAL+'" name="from_loc[]" value="'+al.mr_item.location+'">'+
                                  '<td><input class="form-control" type="text" id="to_bp_item'+al.mr_item.MATERIAL+'" name="to_bp_item[]" value="'+option_to_bp_item+'" required></td>'+
                                  '<td><select class="form-control" id="mtr_status'+al.mr_item.MATERIAL+'" name="mtr_status[]"><option value="NEW">NEW</option><option value="EX_WORK">EX-WORK</option></select></td>'+
                                  '<input type="hidden" class="form-control" id="to_loc'+al.mr_item.MATERIAL+'" value="'+al.mr_item.to_location+'" name="to_loc[]">'+
                                  '<td><input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+currency_name+'</td>'+
                                  '<td><input class="form-control" type="hidden" id="unit_price'+al.mr_item.MATERIAL+'" name="unit_price[]" value="'+al.mr_item.unit_cost+'" readonly>'+al.mr_item.unit_cost+'</td>'+
                                  '<td><input class="form-control" type="text" id="to_unit_cost'+al.mr_item.MATERIAL+'" name="to_unit_cost[]" readonly>'+al.mr_item.to_unit_cost+'</td>'+
                                  '<td><textarea id="remark'+al.mr_item.MATERIAL+'" rows="3" class="form-control border-primary" name="remark[]"   readonly>'+al.mr_item.remark+'</textarea></td>'+
                                  '<input class="form-control" type="hidden" id="acq_value'+al.mr_item.MATERIAL+'" name="acq_value[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="total'+al.mr_item.MATERIAL+'" name="ammount[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="category'+al.mr_item.MATERIAL+'" name="category[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acq_year'+al.mr_item.MATERIAL+'" name="acq_year[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="curr_book'+al.mr_item.MATERIAL+'" name="curr_book[]" readonly>'+
                                  '<input type="hidden" class="form-control" id="acc_desc'+al.mr_item.MATERIAL+'" name="acc_desc[]" readonly>'+
                                  '<input type="hidden" class="form-control" id="acc'+al.mr_item.MATERIAL+'" name="acc[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="to_total'+al.mr_item.MATERIAL+'" name="to_ammount[]">'+
                                  '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'" type="button"> Remove</button></td>'+
                              '</tr>';
                    } else if (mr_type == 7 || mr_type == 8) {
                      // writte off & disposal
                      var str = '<tr>'+
                                  '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+al.mr_item.MATERIAL+'"><input class="form-control" type="hidden" name="semic[]" value="'+al.mr_item.semic_no+'">'+al.mr_item.semic_no+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="m_name[]" value="'+al.mr_item.item_desc+'">'+al.mr_item.item_desc+'</td>'+
                                  '<td><select class="form-control" id="category'+al.mr_item.MATERIAL+'" name="category[]"><option value="Fixed and Movable Asset">Fixed and Movable Asset</option><option value="Stock Item">Stock Item</option><option value="Project Surplus Materials">Project Surplus Materials</option><option value="Scrap and Wasted">Scrap and Wasted</option><option value="Other">Other</option></select></td>'+
                                  '<td><input class="form-control" type="hidden" name="uom[]" value="'+al.mr_item.uom+'">'+al.mr_item.uom+'</td>'+
                                  '<td><input class="form-control" type="text" id="qty'+al.mr_item.MATERIAL+'" name="qty[]" value="'+al.mr_item.qty+'" onChange="change('+al.mr_item.MATERIAL+', '+mr_type+')" required></td>'+
                                   '<td><input class="form-control" type="hidden" id="qty_avl'+al.mr_item.MATERIAL+'" name="qty_avl[]" value="'+al.mr_item.qty_avl+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+al.mr_item.MATERIAL+'" name="qty_avl_ori[]" value="'+al.mr_item.qty_avl+'" readonly></td>'+
                                  '<td><input class="form-control" type="text" id="qty_act'+al.mr_item.MATERIAL+'" name="qty_act[]" readonly></td>'+
                                  '<td><input class="form-control" type="hidden" id="unit_price'+al.mr_item.MATERIAL+'" name="unit_price[]" value="'+al.mr_item.unit_cost+'" readonly>'+al.mr_item.unit_cost+'</td>'+
                                  '<td><input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+currency_name+'</td>'+
                                  '<td><input class="form-control" type="text" id="acq_year'+al.mr_item.MATERIAL+'" name="acq_year[]" maxlength="4" Value="'+al.mr_item.acq_year+'" ></td>'+
                                  '<td><input class="form-control" type="text" id="acq_value'+al.mr_item.MATERIAL+'" name="acq_value[]" Value="'+al.mr_item.acq_value+'" ></td>'+
                                  '<td><input class="form-control" type="text" id="curr_book'+al.mr_item.MATERIAL+'" name="curr_book[]" required Value="'+al.mr_item.book_value+'" readonly></td>'+
                                  '<td><input class="form-control" type="text" id="bp_item'+al.mr_item.MATERIAL+'" value="'+option_bp_item+'" name="bp_item[]" required readonly></td>'+
                                  '<td><input class="form-control" type="text" id="from_loc'+al.mr_item.MATERIAL+'" name="from_loc[]" Value="'+al.mr_item.location+'"></td>'+
                                  '<td><textarea id="remark'+al.mr_item.MATERIAL+'" rows="3" class="form-control border-primary" name="remark[]"   readonly>'+al.mr_item.remark+'</textarea></td>'+
                                  '<input class="form-control" type="hidden" id="mtr_status'+al.mr_item.MATERIAL+'" name="mtr_status[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="to_bp_item'+al.mr_item.MATERIAL+'" name="to_bp_item[]" required>'+
                                  '<input class="form-control" type="hidden" id="to_loc'+al.mr_item.MATERIAL+'" name="to_loc[]">'+
                                  '<input class="form-control" type="hidden" id="total'+al.mr_item.MATERIAL+'" name="ammount[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acc_desc'+al.mr_item.MATERIAL+'" name="acc_desc[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="acc'+al.mr_item.MATERIAL+'" name="acc[]" readonly>'+
                                  '<input class="form-control" type="hidden" id="to_total'+al.mr_item.MATERIAL+'" name="to_ammount[]">'+
                                  '<input class="form-control" type="hidden" id="to_unit_cost'+al.mr_item.MATERIAL+'" name="to_unit_cost[]" >'+
                                  '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+al.mr_item.MATERIAL+'|'+al.mr_item.semic_no+'|'+al.mr_item.item_desc+'|'+al.mr_item.uom+'|'+al.mr_item.qty_avl+'" type="button"> Remove</button></td>'+
                              '</tr>';
                    }
                    $("#item_mreq").find('tr').remove();

                    setTimeout(function(){
                      $("#item_mreq").append(str);
                      input_numberic('#unit_price'+al.mr_item.MATERIAL, true);
                      // input_numberic('#qty'+al.mr_item.MATERIAL, true);
                      input_numberic('#to_unit_cost'+al.mr_item.MATERIAL, true);
                      input_numberic('#to_total'+al.mr_item.MATERIAL, true);
                      input_numberic('#acq_year'+al.mr_item.MATERIAL, true);
                      input_numberic('#acq_value'+al.mr_item.MATERIAL, true);
                      input_numberic('#curr_book'+al.mr_item.MATERIAL, true);
                      dt_array.push(parseInt(al.mr_item.MATERIAL));
                      console.log("type doc : "+mr_type);
                      if (mr_type == 2 || mr_type == 7 || mr_type == 8) {
                        input_numberic_min('#qty'+al.mr_item.MATERIAL, true);
                        $('#qty'+al.mr_item.MATERIAL).prop('type', 'text');
                      } else {
                        input_numberic('#qty'+al.mr_item.MATERIAL, true);
                        $('#qty'+al.mr_item.MATERIAL).prop('type', 'text');

                        $("#qty"+al.mr_item.MATERIAL).on("keyup", function(){
                          if (parseInt($(this).val()) > parseInt($("#qty_avl_ori"+al.mr_item.MATERIAL).val())) {
                            $(this).val();
                            $("#qty_avl"+al.mr_item.MATERIAL).val($("#qty_avl_ori"+al.mr_item.MATERIAL).val());
                            swal('Ooops!', 'Quantity Request can not be more than Quantity Available!', 'warning');
                          }
                        })
                      }
                      $('#modal_mreq').modal('hide');
                      $('.select_material').val("").select2();
                      $('.select_currency').val("").select2();
                      $('#mtr_status'+al.mr_item.MATERIAL).val(al.mr_item.material_status);
                      $('#category'+al.mr_item.MATERIAL).val(al.mr_item.category);
                    },500);
                    setTimeout(function(){ if (mr_type == 1 || mr_type == 4) { if (dt_material.length > 0) {
                      show_acharge($(".costcenter").val(), '.account_id');
                      setTimeout(function(){ $('#acc'+al.mr_item.MATERIAL).val(al.mr_item.account) }, 900);
                    } } }, 800);

                    // setTimeout(function(){ $('#acc'+al.mr_item.MATERIAL).val(al.mr_item.account) }, 1200);
                    console.log(al.mr_item.MATERIAL);
                    // console.log(al.mr_item.account);
                    return false;
                  });
              }
            },1800)
            ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////// //////////////
          });
          // console.log(dt_material);
        }
      });
    }
    /////////////////////////////////////////////////////////////// RECREATE MR ///////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////////////////// RECREATE MR ///////////////////////////////////////////////////////////////////////////


    $("#add_mreq").prop('disabled', true);
    // selection form
    $(document).on('change', '.mr_type', function(e){
      var val = $(this).val();
      dt_material = [];
      $('.material_check').prop('checked', false);
      if (val != "" && $(".from_company").val() != "") {
        $("#add_mreq").prop('disabled', false);
      } else {
        $("#add_mreq").prop('disabled', true);
      }
      $('.bp').val("").select2();
      $('.to_branch_plant').val("").select2();
      $('.from_company').val("").select2();
      $('.to_company').val("").select2();
      $('.wo_reason').val("").select2();
      $('.dept').val("").select2();
      // $(".dept").html('<option value="">Data is empty</option>');
      $("#item_mreq").find('tr').remove();
      dt_array = [];
      var str;
      var result;
      $.ajax({
        url: '<?= base_url("material/Material_req/check_aas")?>',
        type: 'POST',
        dataType: 'text',
        data: {document_type: $(this).val()}
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        if (result = true) {
          $("#check_aas").val(res);
        }
      });

      if (val == 1 || val == 4) {
        $(".account_charge").hide();
        $(".busines_unit").show();
        $(".dept").attr('required', false);

        $(".branchplant_div").show();
        $(".to_branch_plant_div").hide();
        $(".bp").attr('required', false);
        $(".to_branch_plant").attr('required', false);

        $(".to_company_div").hide();
        $(".from_company").attr('required', false);
        $(".to_company").attr('required', false);
        $(".wo_reason_div").hide();
        $(".wo_reason").attr('required', false);
        $(".intercomp_trf").hide();
        $(".disposal_div").hide();


        // issue
        str = '<tr>'+
            '<th>SEMIC</th>'+
            '<th class="desc-item">Description</th>'+
            '<th>UOM</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Req &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Avl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Act &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; GL Class &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Currency</th>'+
            '<th>Branch / Plant</th>'+
            '<th>Business Unit</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Account &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            // '<th>Account Desc</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Action</th>'+
        '</tr>';
        console.log("I & IV");
      } else if (val == 2) {
        $(".branchplant_div").show();
        $(".to_branch_plant_div").hide();
        $(".bp").attr('required', false);
        $(".to_branch_plant").attr('required', false);

        $(".to_company_div").hide();
        $(".from_company").attr('required', false);
        $(".to_company").attr('required', false);
        $(".account_charge").hide();
        $(".busines_unit").hide();
        $(".dept").attr('required', false);
        $(".wo_reason_div").hide();
        $(".wo_reason").attr('required', false);
        $(".intercomp_trf").hide();
        $(".disposal_div").hide();

        if (val == 4) {
          $(".busines_unit").show();
        }

        // adjustment
        str = '<tr>'+
            '<th>SEMIC</th>'+
            '<th class="desc-item">Description</th>'+
            '<th>UOM</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Req &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Avl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Act &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Currency</th>'+
            '<th>Branch / Plant</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Action</th>'+
        '</tr>';
        console.log("II");
      } else if (val == 3 || val == 5) {
        $(".branchplant_div").show();
        $(".to_branch_plant_div").show();
        $(".bp").attr('required', true);
        $(".to_branch_plant").attr('required', true);

        $(".to_company_div").hide();
        $(".from_company").attr('required', false);
        $(".to_company").attr('required', false);
        $(".account_charge").hide();
        $(".busines_unit").hide();
        $(".dept").attr('required', false);
        $(".wo_reason_div").hide();
        $(".wo_reason").attr('required', false);
        $(".intercomp_trf").hide();
        $(".disposal_div").hide();


        // transfer b/p program & item modification
        str = '<tr>'+
            '<th>SEMIC</th>'+
            '<th class="desc-item">Description</th>'+
            '<th>UOM</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Req &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Avl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Act &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; From Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Action</th>'+
        '</tr>';
        console.log("III & V");
      } else if (val == 6) {
        $(".to_company_div").show();
        $(".from_company").attr('required', true);
        $(".to_company").attr('required', true);

        $(".branchplant_div").hide();
        $(".to_branch_plant_div").hide();
        $(".bp").attr('required', false);
        $(".to_branch_plant").attr('required', false);
        $(".account_charge").hide();
        $(".busines_unit").hide();
        $(".dept").attr('required', false);
        $(".wo_reason_div").hide();
        $(".wo_reason").attr('required', false);
        $(".intercomp_trf").show();
        $(".inspection_div").hide();
        $(".disposal_div").hide();


        // Intercompany transfer
        str = '<tr>'+
            '<th>SEMIC</th>'+
            '<th class="desc-item">Description</th>'+
            '<th>UOM</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Req &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Avl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Act &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>From Branch / Plant</th>'+
            // '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; From Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To Branch / Plant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Material Status &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            // '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Currency</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Unit Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Asset Valuation Price &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Action</th>'+
        '</tr>';
        console.log("VI");
      } else if (val == 7) {
        $(".to_company_div").hide();
        $(".from_company").attr('required', false);
        $(".to_company").attr('required', false);

        $(".branchplant_div").show();
        $(".to_branch_plant_div").hide();
        $(".bp").attr('required', true);
        $(".to_branch_plant").attr('required', false);
        $(".account_charge").hide();
        $(".busines_unit").hide();
        $(".dept").attr('required', false);
        $(".wo_reason_div").show();
        $(".wo_reason").attr('required', true);
        $(".intercomp_trf").hide();
        $(".disposal_div").hide();


        // Write Off
        str = '<tr>'+
            '<th>SEMIC</th>'+
            '<th class="desc-item">Description</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>UOM</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Req &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Avl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Act &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Unit Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Currency</th>'+
            '<th>Acquitition Year</th>'+
            '<th>Acquitition Value</th>'+
            '<th>Current Book Value</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Branch/Plant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Action</th>'+
        '</tr>';
        console.log("VII");
      } else if (val == 8) {
        $(".to_company_div").hide();
        $(".from_company").attr('required', false);
        $(".to_company").attr('required', false);

        $(".branchplant_div").show();
        $(".to_branch_plant_div").hide();
        $(".bp").attr('required', true);
        $(".to_branch_plant").attr('required', false);
        $(".account_charge").hide();
        $(".busines_unit").hide();
        $(".dept").attr('required', false);
        $(".wo_reason_div").hide();
        $(".wo_reason").attr('required', false);
        $(".intercomp_trf").hide();
        $(".disposal_div").show();

        // Write Off
        str = '<tr>'+
            '<th>SEMIC</th>'+
            '<th class="desc-item">Description</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Category &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>UOM</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Req &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Avl &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty Act &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Unit Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Currency</th>'+
            '<th>Acquitition Year</th>'+
            '<th>Acquitition Value</th>'+
            '<th>Current Book Value</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Branch/Plant &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Location &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>'+
            '<th>Action</th>'+
        '</tr>';
      } else {
        $(".to_branch_plant_div").hide();
        $(".bp").attr('required', false);
        $(".to_branch_plant").attr('required', false);

        $(".to_company_div").hide();
        $(".from_company").attr('required', false);
        $(".to_company").attr('required', false);
        $(".account_charge").hide();
        $(".dept").attr('required', false);
        $(".intercomp_trf").hide();

        console.log("ELSE");
      }
      console.log(val);

      $("#item_mreq_head").html(str);
    })


    // selection when add or recreate data //
    $(document).on('shown.bs.modal', '#modal_mreq', function(e){
      $('.select_material').val("").select2();
      $('.select_currency').val(3).select2();
      setTimeout(function(){
        $("#material_check"+parseInt(dt_material[0])).attr('checked', true);
      },500)
    })

    // new add material
    $('#tbl_add_material').on('click', 'input[type="checkbox"]', function() {
        var idx = $(this).val();
        var result;
        var bp = $(".bp").val();
        var option_bp_item = bp;
        var option_to_bp_item = $(".to_branch_plant").val();
        var content_dt = "";
        var splitx = idx.split("|");
        get_currency = '';
        get_accsub = '';

        // console.log(splitx[1]);
        if($("#material_check"+parseInt(splitx[0])).is(':checked')){
          // var data = $(this).serialize()+ "&bplant=" + bp;
          var xmodalx = modal_start($("#modal_mreq").find("#mreq_show"));
            $.ajax({
              url: '<?= base_url("material/Material_req/get_material")?>',
              type: 'POST',
              dataType: 'JSON',
              data: {
                select_material: parseInt(splitx[0]),
                semic_no: splitx[1],
                select_currency: $(".select_currency").val(),
                bplant: bp,
                costcenter: $(".costcenter").val(),
              }
            })
            .done(function() {
              result = true;
            })
            .fail(function() {
              result = false;
            })
            .always(function(res) {
              if (result == true) {
                modal_stop(xmodalx);
                // $("#qty_avl_mtr"+res.MATERIAL).val(res.get_jde.qty_onhand);
                // idx+"|"+res.get_jde.qty_onhand;
                var val_accsub = res.get_location;
                var val_idmat = parseInt(splitx[0]);
                var obj = {};
                var total_item_cost = $("#qty_avl_mtr"+parseInt(res.MATERIAL)).val()*$("#item_cost"+parseInt(splitx[0])).val()
                dt_material.push(idx+"|"+$("#qty_avl_mtr"+parseInt(res.MATERIAL)).val()+"|"+$("#item_cost"+parseInt(splitx[0])).val()+"|"+res.GL_CLASS_NAME);
                get_currency = res.get_currency;
                get_accsub = res.get_location;
                obj[val_idmat] = val_accsub;
                dt_accsub.push(obj);
                console.log(dt_accsub);
              }
            })
            // console.log(content_dt);
        } else {
          var total_item_cost = $("#qty_avl_mtr"+parseInt(splitx[0])).val()*$("#item_cost"+parseInt(splitx[0])).val()
          removeA(dt_material, idx+"|"+$("#qty_avl_mtr"+parseInt(splitx[0])).val()+"|"+total_item_cost);

          // get index of object with id:37
          var removeIndex = dt_accsub.map(function(item) { return item.id; }).indexOf(parseInt(splitx[0]));
          // remove object
          dt_accsub.splice(removeIndex, 1);
          $("#qty_avl_mtr"+parseInt(splitx[0])).val("");
          console.log(dt_accsub);
        }

        // alert($(this).val());
        // console.log(dt_material);
        // console.log(parseInt(splitx[0]));
    });

    $('#add_mreq').click(function(e){
      // e.preventDefault()
      // $('#tbl_add_material').fnDestroy();
      $('#tbl_add_material').DataTable().ajax.reload();
      $(".add_dtmaterial").prop('disabled', false);
    })


    ///---------------------------------------------------------------- CREATE MR ///////////////////////////////////////////////////////////////////
    ///---------------------------------------------------------------- CREATE MR ///////////////////////////////////////////////////////////////////
    $("#mreq_show").submit(function(e) {
      e.preventDefault();
      $(".add_dtmaterial").prop('disabled', true);
      if (dt_material.length <= 0) {
        swal('Ooops!', 'You Must Select The Material', 'warning');
        $("#save_mreq").prop('disabled', true);
      } else {
        $("#save_mreq").prop('disabled', false);

        var option_bp_item = $(".bp").val();
        var option_to_bp_item = $(".to_branch_plant").val();
        var option_bu = $(".costcenter").val();
        // var opt_acharge = show_acharge(option_bu);
        var currency_id = $(".select_currency").val();
        var currency_name = $('option:selected', ".select_currency").attr('CURRENCY_NAME');
        var acc_charge = $(".dept").val();
         if (acc_charge == "" || acc_charge == null) {
           var accx = '';
           var acc_desc = '';
         } else {
           var acc_charge_split = acc_charge.split("|");
           var accx = acc_charge_split[0];
           var subsidiary = accx.replace("-", ".");
           var acc_desc = acc_charge_split[1];
         }

         var to_bp_val = $(".to_company").val();
         var bp_val = $(".from_company").val();

          $.each(dt_material, function(index, el) {
            // console.log(el);
            var res = el.split("|");
            var mr_type = $(".mr_type").val();
            var mid = parseInt(res[0]);
            var getIndex = dt_accsub.map(function(item) { return item[mid]; });

            console.log(getIndex);
            if (mr_type == 1 || mr_type == 4) {
              // issue
              var str = '<tr>'+
                          '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+el+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+res[0]+'"><input class="form-control" type="hidden" name="semic[]" value="'+res[1]+'">'+res[1]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="m_name[]" value="'+res[2]+'">'+res[2]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="uom[]" value="'+res[3]+'">'+res[3]+'</td>'+
                          '<td><input class="form-control" type="text" id="qty'+res[0]+'" name="qty[]" onChange="change('+res[0]+', '+mr_type+')" required></td>'+
                           '<td><input class="form-control" type="hidden" id="qty_avl'+res[0]+'" name="qty_avl[]" value="'+res[4]+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+res[0]+'" name="qty_avl_ori[]" value="'+res[4]+'" readonly></td>'+
                          '<td><input class="form-control" type="text" id="qty_act'+res[0]+'" name="qty_act[]" readonly></td>'+
                          '<td><input class="form-control" type="hidden" id="gl_class'+res[0]+'" name="gl_class[]" value="'+res[6]+'" readonly>'+res[6]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+currency_name+'</td>'+
                          '<input class="form-control" type="hidden" id="unit_price'+res[0]+'" name="unit_price[]" readonly>'+
                          '<input class="form-control" type="hidden" id="total'+res[0]+'" name="ammount[]" readonly>'+
                          '<td><input class="form-control" type="text" id="bp_item'+res[0]+'" value="'+option_bp_item+'" name="bp_item[]" required readonly></td>'+
                          '<td><input class="form-control" type="text" id="bu'+res[0]+'" value="'+option_bu+'" name="bu[]" readonly></td>'+
                          '<td><input type="text" class="form-control" id="from_loc'+res[0]+'" name="from_loc[]"></td>'+
                          '<td><select class="form-control" id="acc'+res[0]+'" name="acc[]" required>'+getIndex+'</select></td>'+
                          '<input type="hidden" class="form-control" id="acc_desc'+res[0]+'" name="acc_desc[]" value="'+acc_desc+'" readonly>'+
                          '<td><textarea id="remark'+res[0]+'" rows="3" class="form-control border-primary" name="remark[]"   readonly></textarea></td>'+
                          '<input class="form-control" type="hidden" id="mtr_status'+res[0]+'" name="mtr_status[]" readonly>'+
                          '<input class="form-control" type="hidden" id="category'+res[0]+'" name="category[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acq_year'+res[0]+'" name="acq_year[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acq_value'+res[0]+'" name="acq_value[]" readonly>'+
                          '<input class="form-control" type="hidden" id="curr_book'+res[0]+'" name="curr_book[]" readonly>'+
                          '<input class="form-control" type="hidden" id="to_total'+res[0]+'" name="to_ammount[]">'+
                          '<input class="form-control" type="hidden" id="to_unit_cost'+res[0]+'" name="to_unit_cost[]" >'+
                          '<input type="hidden" class="form-control" id="to_loc'+res[0]+'" name="to_loc[]">'+
                          '<input class="form-control" type="hidden" id="to_bp_item'+res[0]+'" name="to_bp_item[]">'+
                          '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+el+'" type="button"> Remove</button></td>'+
                      '</tr>';
            } else if (mr_type == 2) {
              // adjustment ---
              var str = '<tr>'+
                          '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+el+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+res[0]+'"><input class="form-control" type="hidden" name="semic[]" value="'+res[1]+'">'+res[1]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="m_name[]" value="'+res[2]+'">'+res[2]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="uom[]" value="'+res[3]+'">'+res[3]+'</td>'+
                          '<td><input class="form-control" type="text" id="qty'+res[0]+'" name="qty[]" onChange="change('+res[0]+', '+mr_type+')" required></td>'+
                           '<td><input class="form-control" type="hidden" id="qty_avl'+res[0]+'" name="qty_avl[]" value="'+res[4]+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+res[0]+'" name="qty_avl_ori[]" value="'+res[4]+'" readonly></td>'+
                          '<td><input class="form-control" type="text" id="qty_act'+res[0]+'" name="qty_act[]" readonly></td>'+
                          '<td><input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+currency_name+'</td>'+
                          '<input class="form-control" type="hidden" id="unit_price'+res[0]+'" name="unit_price[]" readonly>'+
                          '<input class="form-control" type="hidden" id="total'+res[0]+'" name="ammount[]" readonly>'+
                          '<td><input class="form-control" type="text" id="bp_item'+res[0]+'" value="'+option_bp_item+'" name="bp_item[]" required readonly></td>'+
                          '<td><input type="text" class="form-control" id="from_loc'+res[0]+'" name="from_loc[]"></td>'+
                          '<td><textarea id="remark'+res[0]+'" rows="3" class="form-control border-primary" name="remark[]"   readonly></textarea></td>'+
                          '<input class="form-control" type="hidden" id="mtr_status'+res[0]+'" name="mtr_status[]" readonly>'+
                          '<input class="form-control" type="hidden" id="category'+res[0]+'" name="category[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acq_year'+res[0]+'" name="acq_year[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acq_value'+res[0]+'" name="acq_value[]" readonly>'+
                          '<input class="form-control" type="hidden" id="curr_book'+res[0]+'" name="curr_book[]" readonly>'+
                          '<input type="hidden" class="form-control" id="acc'+res[0]+'" name="acc[]">'+
                          '<input type="hidden" class="form-control" id="acc_desc'+res[0]+'" name="acc_desc[]">'+
                          '<input class="form-control" type="hidden" id="to_total'+res[0]+'" name="to_ammount[]">'+
                          '<input class="form-control" type="hidden" id="to_unit_cost'+res[0]+'" name="to_unit_cost[]" >'+
                          '<input type="hidden" class="form-control" id="to_loc'+res[0]+'" name="to_loc[]">'+
                          '<input class="form-control" type="hidden" id="to_bp_item'+res[0]+'" name="to_bp_item[]">'+
                          '<td><button class="btn btn-danger rm_item" data-id="'+el+'" type="button"> Remove</button></td>'+
                      '</tr>';
            } else if (mr_type == 3 || mr_type == 5) {
              // transfer b/p program & item modification
              var str = '<tr>'+
                          '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+el+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+res[0]+'"><input class="form-control" type="hidden" name="semic[]" value="'+res[1]+'">'+res[1]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="m_name[]" value="'+res[2]+'">'+res[2]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="uom[]" value="'+res[3]+'">'+res[3]+'</td>'+
                          '<td><input class="form-control" type="text" id="qty'+res[0]+'" name="qty[]" onChange="change('+res[0]+', '+mr_type+')" required></td>'+
                           '<td><input class="form-control" type="hidden" id="qty_avl'+res[0]+'" name="qty_avl[]" value="'+res[4]+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+res[0]+'" name="qty_avl_ori[]" value="'+res[4]+'" readonly></td>'+
                          '<td><input class="form-control" type="text" id="qty_act'+res[0]+'" name="qty_act[]" readonly></td>'+
                          '<td><input type="text" class="form-control" id="from_loc'+res[0]+'" name="from_loc[]"></td>'+
                          '<td><input type="text" class="form-control" id="to_loc'+res[0]+'" name="to_loc[]"></td>'+
                          '<td><textarea id="remark'+res[0]+'" rows="3" class="form-control border-primary" name="remark[]"   readonly></textarea></td>'+
                          '<input class="form-control" type="hidden" id="mtr_status'+res[0]+'" name="mtr_status[]" readonly>'+
                          '<input class="form-control" type="hidden" id="category'+res[0]+'" name="category[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acq_year'+res[0]+'" name="acq_year[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acq_value'+res[0]+'" name="acq_value[]" readonly>'+
                          '<input class="form-control" type="hidden" id="curr_book'+res[0]+'" name="curr_book[]" readonly>'+
                          '<input class="form-control" type="hidden" id="bp_item'+res[0]+'" name="bp_item[]" required>'+
                          '<input class="form-control" type="hidden" id="unit_price'+res[0]+'" name="unit_price[]" >'+
                          '<input class="form-control" type="hidden" id="total'+res[0]+'" name="ammount[]" >'+
                          '<input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+
                          '<input type="hidden" class="form-control" id="acc'+res[0]+'" name="acc[]">'+
                          '<input type="hidden" class="form-control" id="acc_desc'+res[0]+'" name="acc_desc[]">'+
                          '<input class="form-control" type="hidden" id="to_total'+res[0]+'" name="to_ammount[]">'+
                          '<input class="form-control" type="hidden" id="to_unit_cost'+res[0]+'" name="to_unit_cost[]" >'+
                          '<input class="form-control" type="hidden" id="to_bp_item'+res[0]+'" name="to_bp_item[]">'+
                          '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+el+'" type="button"> Remove</button></td>'+
                      '</tr>';
            } else if (mr_type == 6) {
              // intercompany transfer
              var str = '<tr>'+
                          '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+el+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+res[0]+'"><input class="form-control" type="hidden" name="semic[]" value="'+res[1]+'">'+res[1]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="m_name[]" value="'+res[2]+'">'+res[2]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="uom[]" value="'+res[3]+'">'+res[3]+'</td>'+
                          '<td><input class="form-control" type="text" id="qty'+res[0]+'" name="qty[]" onChange="change('+res[0]+', '+mr_type+')" required></td>'+
                           '<td><input class="form-control" type="hidden" id="qty_avl'+res[0]+'" name="qty_avl[]" value="'+res[4]+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+res[0]+'" name="qty_avl_ori[]" value="'+res[4]+'" readonly></td>'+
                          '<td><input class="form-control" type="text" id="qty_act'+res[0]+'" name="qty_act[]" readonly></td>'+
                          '<td><input class="form-control" type="text" id="bp_item'+res[0]+'" value="'+option_bp_item+'" name="bp_item[]" required readonly></td>'+
                          '<input type="hidden" class="form-control" id="from_loc'+res[0]+'" name="from_loc[]">'+
                          '<td><input class="form-control" type="text" id="to_bp_item'+res[0]+'" name="to_bp_item[]" value="'+option_to_bp_item+'" required readonly></td>'+
                          '<td><select class="form-control" id="mtr_status'+res[0]+'" name="mtr_status[]"><option value="NEW">NEW</option><option value="EX_WORK">EX-WORK</option></select></td>'+
                          '<input type="hidden" class="form-control" id="to_loc'+res[0]+'" name="to_loc[]">'+
                          '<td><select class="form-control" id="curr'+res[0]+'" name="curr[]">'+get_currency+'</select></td>'+
                          '<td><input class="form-control" type="hidden" id="unit_price'+res[0]+'" name="unit_price[]" value="'+res[5]+'" readonly>'+res[5]+'</td>'+
                          '<td><input class="form-control" type="hidden" id="to_unit_cost'+res[0]+'" name="to_unit_cost[]" value="0" readonly><input class="form-control" type="text" id="cal'+res[0]+'" readonly> </td>'+
                          '<td><textarea id="remark'+res[0]+'" rows="3" class="form-control border-primary" name="remark[]" readonly></textarea></td>'+
                          '<input class="form-control" type="hidden" id="acq_value'+res[0]+'" name="acq_value[]" readonly>'+
                          '<input class="form-control" type="hidden" id="total'+res[0]+'" name="ammount[]" readonly>'+
                          '<input class="form-control" type="hidden" id="category'+res[0]+'" name="category[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acq_year'+res[0]+'" name="acq_year[]" readonly>'+
                          '<input class="form-control" type="hidden" id="curr_book'+res[0]+'" name="curr_book[]" readonly>'+
                          '<input type="hidden" class="form-control" id="acc_desc'+res[0]+'" name="acc_desc[]" readonly>'+
                          '<input type="hidden" class="form-control" id="acc'+res[0]+'" name="acc[]" readonly>'+
                          '<input class="form-control" type="hidden" id="to_total'+res[0]+'" name="to_ammount[]">'+
                          '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+el+'" type="button"> Remove</button></td>'+
                      '</tr>';
            } else if (mr_type == 7 || mr_type == 8) {
              // write off & disposal
              var str = '<tr>'+
                          '<td><input class="dt_item" type="hidden" name="dt_item[]" value="'+el+'"><input class="dt_item_id" type="hidden" name="dt_item_id[]" value="'+res[0]+'"><input class="form-control" type="hidden" name="semic[]" value="'+res[1]+'">'+res[1]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="m_name[]" value="'+res[2]+'">'+res[2]+'</td>'+
                          '<td><select class="form-control" id="category'+res[0]+'" name="category[]"><option value="Fixed and Movable Asset">Fixed and Movable Asset</option><option value="Stock Item">Stock Item</option><option value="Project Surplus Materials">Project Surplus Materials</option><option value="Scrap and Wasted">Scrap and Wasted</option><option value="Other">Other</option></select></td>'+
                          '<td><input class="form-control" type="hidden" name="uom[]" value="'+res[3]+'">'+res[3]+'</td>'+
                          '<td><input class="form-control" type="text" id="qty'+res[0]+'" name="qty[]" onChange="change('+res[0]+', '+mr_type+')" required></td>'+
                           '<td><input class="form-control" type="hidden" id="qty_avl'+res[0]+'" name="qty_avl[]" value="'+res[4]+'" readonly><input class="form-control" type="text" id="qty_avl_ori'+res[0]+'" name="qty_avl_ori[]" value="'+res[4]+'" readonly></td>'+
                          '<td><input class="form-control" type="text" id="qty_act'+res[0]+'" name="qty_act[]" readonly></td>'+
                          '<td><input class="form-control" type="hidden" id="unit_price'+res[0]+'" name="unit_price[]" Value="'+res[5]+'" readonly>'+res[5]+'</td>'+
                          '<td><input class="form-control" type="hidden" name="curr[]" value="'+currency_id+'">'+currency_name+'</td>'+
                          '<td><input class="form-control" type="text" id="acq_year'+res[0]+'" maxlength="4" name="acq_year[]" ></td>'+
                          '<td><input class="form-control" type="text" id="acq_value'+res[0]+'" name="acq_value[]" value="" ></td>'+
                          '<td><input class="form-control" type="text" id="curr_book'+res[0]+'" name="curr_book[]" required readonly></td>'+
                          '<td><input class="form-control" type="text" id="bp_item'+res[0]+'" value="'+option_bp_item+'" name="bp_item[]" required readonly></td>'+
                          '<td><input class="form-control" type="text" id="from_loc'+res[0]+'" name="from_loc[]"></td>'+
                          '<td><textarea id="remark'+res[0]+'" rows="3" class="form-control border-primary" name="remark[]"   readonly></textarea></td>'+
                          '<input class="form-control" type="hidden" id="mtr_status'+res[0]+'" name="mtr_status[]" readonly>'+
                          '<input class="form-control" type="hidden" id="to_bp_item'+res[0]+'" name="to_bp_item[]" required>'+
                          '<input class="form-control" type="hidden" id="to_loc'+res[0]+'" name="to_loc[]">'+
                          '<input class="form-control" type="hidden" id="total'+res[0]+'" name="ammount[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acc_desc'+res[0]+'" name="acc_desc[]" readonly>'+
                          '<input class="form-control" type="hidden" id="acc'+res[0]+'" name="acc[]" readonly>'+
                          '<input class="form-control" type="hidden" id="to_total'+res[0]+'" name="to_ammount[]">'+
                          '<input class="form-control" type="hidden" id="to_unit_cost'+res[0]+'" name="to_unit_cost[]" >'+
                          '<td><button class="btn btn-danger btn-sm rm_item" data-id="'+el+'" type="button"> Remove</button></td>'+
                      '</tr>';
            }
            $("#item_mreq").find('tr').remove();

            setTimeout(function(){
              $("#item_mreq").append(str);
              input_numberic('#unit_price'+res[0], true);
              input_numberic('#acq_year'+res[0], true);
              input_numberic('#acq_value'+res[0], true);
              input_numberic('#curr_book'+res[0], true);
              // input_numberic('#qty'+res[0], true);
              input_numberic('#to_unit_cost'+res[0], true);
              input_numberic('#to_total'+res[0], true);
              dt_array.push(parseInt(res[0]));
              // console.log("type doc : "+mr_type);
              if (mr_type == 2 || mr_type == 7 || mr_type == 8) {
                input_numberic_min('#qty'+res[0], true);
                $('#qty'+res[0]).prop('type', 'text');
              } else {
                input_numberic('#qty'+res[0], true);
                $('#qty'+res[0]).prop('type', 'text');
                $("#qty"+res[0]).on("keyup", function(){
                  if (parseInt($(this).val()) > parseInt($("#qty_avl_ori"+res[0]).val())) {
                    $(this).val(0);
                    $("#qty_avl"+res[0]).val($("#qty_avl_ori"+res[0]).val());
                    swal('Ooops!', 'Quantity Request can not be more than Quantity Available!', 'warning');
                  }
                })
              }

              $('#modal_mreq').modal('hide');
              $('.select_material').val("").select2();
              $('.select_currency').val("").select2();
            },1000);
          });
      }

    })

    ///---------------------------------------------------------------- CREATE MR ///////////////////////////////////////////////////////////////////
    ///---------------------------------------------------------------- CREATE MR ///////////////////////////////////////////////////////////////////

    $(document).on('click', '.rm_item', function(e) {
      // e.preventDefault();
      var idnya = $(this).data("id");
      var split = idnya.split("|");
      var elem = this;
      // console.log(idnya);
        swalConfirm('Material Request', '<?= __('confirm_delete') ?>', function() {
          $(elem).closest('tr').remove();
          // dt_array.indexOf();
          removeA(dt_material, idnya);
          console.log(dt_material);
          $('#material_check'+split[0]).prop('checked', false);
          var removeIndex = dt_accsub.map(function(item) { return item.id; }).indexOf(parseInt(split[0]));
          dt_accsub.splice(removeIndex, 1);
        });
        // console.log(dt_array);
    });

    $(document).on('click', '.btncancel', function(){
      dt_material = [];
      dt_itemm = [];
      $("#modal_mreq").modal('hide');

    $(".table_item_request").find('tr').each(function (i, el) {
        var td_val = $(this).find(".dt_item").val();
        var td_val_id = $(this).find(".dt_item_id").val();

        $(".material_check").prop('checked', false);
        setTimeout(function(){
          $("#material_check"+td_val_id).prop('checked', true);

          dt_itemm.push(td_val);
          dt_material = cleanArray(dt_itemm);
          // cleanArray(dt_material);
          // console.log(td_val);
          // console.log(el[0]);
        },700);

    });

      setTimeout(function(){
        console.log(dt_material);

      },1000);

    })

    $(".mreq_form").submit(function(e){
      e.preventDefault();
      $(".mr_type").prop('disabled', false);
      var data = $(this).serialize();
      var resultx;
      // console.log(data);
      var resultz;
      $("#item_mreq").find('input[name="dt_item[]"]').each(function() {

        var res = this.value;
        var splitx = res.split("|");
        var qty_request = $("#qty"+splitx[0]).val();
        console.log(qty_request);
        if (parseInt(qty_request) == 0) {
          resultz = false;
          return false;
        } else {
          resultz = true;
          return true;
        }
      })
      console.log(resultz);


        // (new PNotify({
        //   title: 'Confirmation Needed',
        //   text: 'are you sure you will submit this material request?',
        //   icon: 'glyphicon glyphicon-question-sign',
        //   hide: false,
        //   confirm: {
        //       confirm: true
        //   },
        //   buttons: {
        //       closer: false,
        //       sticker: false
        //   },
        //   history: {
        //       history: false
        //   },
        //   addclass: 'stack-modal',
        //   stack: {
        //       'dir1': 'down',
        //       'dir2': 'right',
        //       'modal': true
        //   }
        // })).get().on('pnotify.confirm', function() {
        swalConfirm('Material Request', '<?= __('confirm_submit') ?>', function() {
          if (resultz == true) {
          // console.log($(".mr_type").val());
            var xmodalx = modal_start($(".form_mreq").find(".mreq_form"));
            $.ajax({
              url: '<?= base_url("material/Material_req/create_mr"); ?>',
              type: 'POST',
              dataType: 'JSON',
              data: data
            })
            .done(function() {
              resultx = true;
            })
            .fail(function() {
              resultx = false;
            })
            .always(function(res) {
              if (resultx == true) {
                if (res.check_business_unit == true) {
                  // jika tipe dokumen WRITE OFF
                  if (parseInt($("#check_aas").val()) == 1) {
                    if (res.success == true) {
                      console.log($("#check_aas").val());

                      $("#modal_aas").modal("show");
                      setTimeout(function(){
                        if ($(".mr_type").val() == 6) { $(".intercomp_trf_aas").show(); } else { $(".intercomp_trf_aas").hide(); }
                        $(".select_aas2").html(res.aas_2);
                        $(".aas_1").val(res.aas_1.NAME);
                        $(".title_aas1_other").html(res.aas_1_other_comp_title);
                        $(".select_aas1_other_comp").html(res.aas_1_other_comp);
                        $(".title_aas2_other").html(res.aas_2_other_comp_title);
                        $(".select_aas2_other_comp").html(res.aas_2_other_comp);
                      },1800);

                      $("#mreq_aas").submit(function(e) {
                        e.preventDefault();
                        var resz;
                        $("#modal_aas").modal("hide");
                        $.ajax({
                          url: '<?= base_url("material/material_req/add_approval_aas")?>',
                          type: 'POST',
                          dataType: 'JSON',
                          data: {
                            id: res.aas_1.id,
                            position: res.aas_1.position,
                            title: res.aas_1.title,
                            user_id: res.aas_1.user_id,
                            golongan: res.aas_1.golongan,
                            nominal: res.aas_1.nominal,
                            nominal_writeoff: res.aas_1.nominal_writeoff,
                            aas_2 : $(".aas_2").val(),
                            mr_no : res.data.request_no,
                            doc_type : res.data.document_type,
                            aas_1_other : $(".aas_1_other").val(),
                            aas_2_other : $(".aas_2_other").val(),
                            create_by : res.data.user,
                          }
                        })
                        .done(function() {
                          resz = true;
                        })
                        .fail(function() {
                          resz = false;
                        })
                        .always(function(ress) {
                          if (resz == true) {
                            if (ress.success == true) {
                            //   new PNotify({
                            //  title: 'Done',
                            //  text: "Material request "+ress.mr_no+" has been created",
                            //  type: 'success',
                            //  hide: false,
                            //  confirm: {
                            //    confirm: true,
                            //    buttons: [{
                            //      text: 'Ok',
                            //      addClass: 'btn-primary',
                            //      click: function(notice) {
                            //        notice.remove();
                            //        window.location.href = "<?= base_url("material/material_req")?>";
                            //      }
                            //    },
                            //    null]
                            //  },
                            //  buttons: {
                            //    closer: false,
                            //    sticker: false
                            //  },
                            //  history: {
                            //    history: false
                            //  }
                            // });
                            setTimeout(function(){
                              swal({
                                title: "Done",
                                text: "Material request "+ress.mr_no+" has been created",
                                type: "success",
                                showCancelButton: false,
                                confirmButtonColor: '#0072cf',
                                confirmButtonText: 'Oke',
                                closeOnConfirm: true,
                                closeOnCancel: true
                              },
                              function(e){
                                modal_stop(xmodalx);
                                window.location.href = "<?= base_url("material/material_req")?>";
                              });
                            }, 1000)

                            }
                          }
                        });

                      });
                    }
                  } else {
                    if (res.success == true) {
                      // new PNotify({
                      //  title: 'Done',
                      //  text: "Material request "+res.data.request_no+" has been created",
                      //  type: 'success',
                      //  hide: false,
                      //  confirm: {
                      //    confirm: true,
                      //    buttons: [{
                      //      text: 'Ok',
                      //      addClass: 'btn-primary',
                      //      click: function(notice) {
                      //        notice.remove();
                      //        window.location.href = "<?= base_url("material/material_req")?>";
                      //      }
                      //    },
                      //    null]
                      //  },
                      //  buttons: {
                      //    closer: false,
                      //    sticker: false
                      //  },
                      //  history: {
                      //    history: false
                      //  }
                      // });
                      setTimeout(function(){
                        swal({
                          title: "Done",
                          text: "Material request "+res.data.request_no+" has been created",
                          type: "success",
                          showCancelButton: false,
                          confirmButtonColor: '#0072cf',
                          confirmButtonText: 'Oke',
                          closeOnConfirm: true,
                          closeOnCancel: true
                        },
                        function(){
                          modal_stop(xmodalx);
                          window.location.href = "<?= base_url("material/material_req")?>";
                        });
                      },1000)

                    }
                  }

                } else {
                  modal_stop(xmodalx);
                  setTimeout(function() {
                    swal('<?= __('warning') ?>', 'GL CLASS & Account Subsidiary is not allowed for this item', 'warning');
                  }, swalDelay);
                }
              }
            });
          } else {
            setTimeout(function() {
              swal('<?= __('warning') ?>', 'Quantity Request can not be zero!', 'warning');
            }, swalDelay);
          }
        });




    })

    // AAS INTERCOMPANY TRF
    $(document).on('change', '.aas_1_other', function(e){
      // dt_intrf.push(el);
      $(".aas_2_other").val("");
      $(".aas_2_other option").attr('disabled', false);
      $(".aas_2_other option[value='"+$(this).val()+"']").each(function() {
        $(".aas_2_other option[value='"+$(this).val()+"']").attr('disabled',true);
      });
    })

///////////////////////////////////////////////////////////////// MODAL APPROVAL MR /////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// MODAL APPROVAL MR /////////////////////////////////////////////////////////////////////
    $(document).on('shown.bs.modal', '#modal_approval', function(e){
      $("#item_mreq_apprv").find('tr').remove();
      var idnya = $(e.relatedTarget).data("id");
      var statusx = $(e.relatedTarget).data("status");
      var data_approval = $(e.relatedTarget).data("approval");
      get_note(idnya);
      get_log(idnya);
      if (data_approval == 'danger') {
        $("#btnrecreate").show();
      } else {
        $("#btnrecreate").hide();
      }
      $("#mr_status_approval").html(statusx);
      $("#notes").val("");
      // $("select").select2();
      var result;
      $("#btnrecreate").attr("href", "<?= base_url('material/material_req/index/'); ?>"+idnya);
      $.ajax({
        url: '<?= base_url('material/Material_req_approval/get_material_req')?>',
        type: 'POST',
        dataType: 'JSON',
        data: {idnya: idnya}
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        // $('.to_branch_plant_div').hide();
        // $('.to_company_div').hide();
        if (result = true) {
          $('#name').html(res.material_request.name);
          $('#dept_desc').html(res.material_request.DEPARTMENT_DESC);
          $('#mreq_no').html(res.material_request.request_no);
          $('#req_date').html(res.material_request.request_date);
          $('#issue_apprv').html(res.material_request.purpose_of_request);

          $('#mr_no').val(res.material_request.request_no);
          $('#comp_code').val(res.material_request.company_code);
          $('#user').val(res.material_request.create_by);

          $('.mr_type_apprv').val(res.material_request.document_type).select2();
          $('.dept_apprv').val(res.material_request.account+" - "+res.material_request.account_desc);
          $('.bp_apprv').val(res.material_request.branch_plant).select2();
          $('.costcenter_apprv').val(res.material_request.busines_unit).select2();
          $('.to_branch_plant_apprv').val(res.material_request.to_branch_plant).select2();
          $('.from_company_apprv').val(res.material_request.from_company).select2();
          $('.to_company_apprv').val(res.material_request.to_company).select2();
          $('.wo_reason_apprv').val(res.material_request.wo_reason).select2();
          $('.asset_type_apprv').val(res.material_request.asset_type).select2();
          if (res.material_request.inspection == 1) { $('#inspection_apprv').attr('checked', true); } else { $('#inspection_apprv').attr('checked', false); }
          if (res.material_request.asset_valuation == 1) { $('#asset_valuation_apprv').attr('checked', true); } else { $('#asset_valuation_apprv').attr('checked', false); }
          $("#disposal_desc_apprv").html(res.material_request.justification_disposal_method);
          $(".disposal_method_apprv").val(res.material_request.disposal_method).select2({ width: '100%' });
          $(".disposal_value_apprv").val(res.material_request.disposal_value_curr).select2();
          $("#dis_val_apprv").val(res.material_request.disposal_value);
          $(".disposal_cost_apprv").val(res.material_request.disposal_cost_curr).select2();
          $("#dis_cost_apprv").val(res.material_request.disposal_cost);

          $('#user_roles').val(res.get_approval[0].user_roles);
          $('#sequence').val(res.get_approval[0].sequence);
          $('#status_approve').val(res.get_approval[0].status_approve);
          $('#reject_step').val(res.get_approval[0].reject_step);
          $('#email_approve').val(res.get_approval[0].email_approve);
          $('#email_reject').val(res.get_approval[0].email_reject);
          $('#edit_content').val(res.get_approval[0].edit_content);
          $('#extra_case').val(res.get_approval[0].extra_case);

          var str_loc = '<option value="">Select Location</option>';
          $.each(res.get_location, function(index, el) {
            str_loc += '<option value="'+el.ID_LOCATION+'">'+el.LOCATION_DESC+'</option>';
          });

          $.each(res.material_request_detail, function(index, el) {
            var val_loc = '<option value="'+el.mr_item.location+'">'+el.mr_item.location+'</option>';

            var str = '<tr>'+
                        '<td class="semic-item"><input class="form-control" type="hidden" name="semic[]" value="'+el.mr_item.semic_no+'">'+el.mr_item.semic_no+'</td>'+
                        '<td class="desc-item"><input class="form-control" type="hidden" name="m_name[]" value="'+el.mr_item.item_desc+'">'+el.mr_item.item_desc+'</td>'+
                        '<td class="uom-item"><input class="form-control" type="hidden" name="uom[]" value="'+el.mr_item.uom+'">'+el.mr_item.uom+'</td>'+
                        '<td class="qtyact-item"><input class="form-control" type="hidden" id="qty'+el.mr_item.MATERIAL+'" name="qty[]" value="'+el.mr_item.qty+'" readonly>'+el.mr_item.qty+'</td>'+
                        '<td class="qtyavl-item"><input class="form-control" type="hidden" id="qtyavl'+el.mr_item.MATERIAL+'" name="qtyavl[]" value="'+el.mr_item.qty_avl+'" readonly>'+el.mr_item.qty_avl+'</td>'+
                        '<td class="qtyreq-item"><input class="form-control" type="hidden" id="qty_act'+el.mr_item.MATERIAL+'" name="qty_act[]" value="'+el.mr_item.qty_act+'" readonly>'+el.mr_item.qty_act+'</td>'+
                        '<td class="glclass-item"><input class="form-control" type="hidden" id="gl_class'+el.mr_item.MATERIAL+'" name="gl_class[]" value="'+el.mr_item.glclass_desc+'" readonly>'+el.mr_item.glclass_desc+'</td>'+
                        '<td class="unitcost-item"><input class="form-control" type="hidden" id="unit_price'+el.mr_item.MATERIAL+'" name="unit_price[]" value="'+el.mr_item.unit_cost+'" readonly>'+el.mr_item.unit_cost+'</td>'+
                        '<td class="curr-item"><input class="form-control" type="hidden" name="curr[]" value="'+el.mr_item.CURRENCY+'">'+el.mr_item.CURRENCY+'</td>'+
                        '<td class="tounitcost-item"><input class="form-control" type="hidden" id="to_unit_cost'+el.mr_item.MATERIAL+'" name="to_unit_cost[]" value="'+el.mr_item.to_unit_cost+'" readonly>'+el.mr_item.to_unit_cost+'</td>'+
                        '<td class="exammount-item"><input class="form-control" type="hidden" id="total'+el.mr_item.MATERIAL+'" name="ammount[]" value="'+el.mr_item.extended_ammount+'" readonly>'+el.mr_item.extended_ammount+'</td>'+
                        '<td class="toexammount-item"><input class="form-control" type="hidden" id="to_total'+el.mr_item.MATERIAL+'" name="to_ammount[]" value="'+el.mr_item.to_extended_ammount+'" readonly>'+el.mr_item.to_extended_ammount+'</td>'+
                        '<td class="bp-item"><input class="form-control" type="hidden" id="bp_item'+el.mr_item.MATERIAL+'" name="bp_item[]" value="'+el.mr_item.branch_plant+'" readonly>'+el.mr_item.branch_plant+'</td>'+
                        '<td class="tobp-item"><input class="form-control" type="hidden" id="to_bp_item'+el.mr_item.MATERIAL+'" name="to_bp_item[]" value="'+el.mr_item.to_branch_plant+'" readonly>'+el.mr_item.to_branch_plant+'</td>'+
                        '<td class="bu-item"><input class="form-control" type="hidden" id="bu'+el.mr_item.busines_unit+'" name="bu[]" value="'+el.mr_item.to_branch_plant+'" readonly>'+el.mr_item.busines_unit+'</td>'+
                        '<td class="loc-item"><input type="hidden" class="form-control" id="from_loc'+el.mr_item.MATERIAL+'" name="from_loc[]" value="'+el.mr_item.location+'" readonly>'+el.mr_item.location+'</td>'+
                        '<td class="toloc-item"><input type="hidden" class="form-control" id="to_loc'+el.mr_item.MATERIAL+'" name="to_loc[]" value="'+el.mr_item.to_location+'" readonly>'+el.mr_item.to_location+'</td>'+
                        '<td class="acc-item"><input type="hidden" class="form-control" id="acc'+el.mr_item.MATERIAL+'" name="acc[]" value="'+el.mr_item.account+'" readonly>'+el.mr_item.account+'</td>'+
                        '<td class="accdesc-item"><input type="hidden" class="form-control" id="acc_desc'+el.mr_item.MATERIAL+'" name="acc_desc[]" value="'+el.mr_item.account_desc+'" readonly>'+el.mr_item.account_desc+'</td>'+
                        '<td class="cat-item"><input class="form-control" type="hidden" id="category'+el.mr_item.MATERIAL+'" name="category[]" readonly>'+el.mr_item.category+'</td>'+
                        '<td class="acqyear-item"><input class="form-control" type="hidden" id="acq_year'+el.mr_item.MATERIAL+'" name="acq_year[]" readonly>'+el.mr_item.acq_year+'</td>'+
                        '<td class="acqval-item"><input class="form-control" type="hidden" id="acq_value'+el.mr_item.MATERIAL+'" name="acq_value[]" readonly>'+el.mr_item.acq_value+'</td>'+
                        '<td class="book-item"><input class="form-control" type="hidden" id="curr_book'+el.mr_item.MATERIAL+'" name="curr_book[]" readonly>'+el.mr_item.book_value+'</td>'+
                        '<td class="mtrstatus-item"><input type="hidden" class="form-control" id="mtr_status'+res.MATERIAL+'" name="mtr_status[]">'+el.mr_item.material_status+'</td>'+
                        '<td class="assetvprice-item"><input type="hidden" class="form-control" id="assetv_price'+res.MATERIAL+'" name="assetv_price[]">'+parseInt(el.mr_item.to_unit_cost)+'</td>'+
                        '<td class="remark-item"><input type="hidden" id="remark'+el.mr_item.MATERIAL+'" rows="3" class="form-control border-primary" name="remark[]"   disabled>'+el.mr_item.remark+'</input></td>'+
                    '</tr>';

            $("#item_mreq_apprv").append(str);
            input_numberic('#unit_price'+el.mr_item.MATERIAL, true);
            input_numberic('#qty'+el.mr_item.MATERIAL, true);
            input_numberic('#to_unit_cost'+el.mr_item.MATERIAL, true);
            input_numberic('#to_total'+el.mr_item.MATERIAL, true);
            setTimeout(function(){
              var val = $(".mr_type_apprv").val();

              if (val == 1 || val == 4) {
                $(".account_charge_apprv").hide();
                $(".busines_unit_apprv").show();
                $(".dept_apprv").attr('required', true);

                $(".branchplant_div_apprv").show();
                $(".to_branch_plant_div_apprv").hide();
                $(".bp_apprv").attr('required', false);
                $(".to_branch_plant_apprv").attr('required', false);

                $(".to_company_div_apprv").hide();
                $(".from_company_apprv").attr('required', false);
                $(".to_company_apprv").attr('required', false);
                $(".wo_reason_div_apprv").hide();
                $(".wo_reason_apprv").attr('required', false);

                // issue
                $(".curr-item").show();
                $(".glclass-item").show();
                $(".unitcost-item").hide();
                $(".tounitcost-item").show();
                $(".exammount-item").show();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").hide();
                $(".bu-item").show();
                $(".loc-item").show();
                $(".toloc-item").hide();
                $(".acc-item").show();
                $(".accdesc-item").hide();
                $(".cat-item").hide();
                $(".acqyear-item").hide();
                $(".acqval-item").hide();
                $(".book-item").hide();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf_apprv").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div_apprv").hide();

                console.log("I & IV");
              } else if (val == 2) {
                $(".branchplant_div_apprv").show();
                $(".to_branch_plant_div_apprv").hide();
                $(".bp_apprv").attr('required', false);
                $(".to_branch_plant_apprv").attr('required', false);

                $(".to_company_div_apprv").hide();
                $(".from_company_apprv").attr('required', false);
                $(".to_company_apprv").attr('required', false);
                $(".account_charge_apprv").hide();
                $(".busines_unit_apprv").hide();

                $(".dept_apprv").attr('required', false);
                $(".wo_reason_div_apprv").hide();
                $(".wo_reason_apprv").attr('required', false);

                // adjustment
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").show();
                $(".tounitcost-item").hide();
                $(".exammount-item").show();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").hide();
                $(".bu-item").hide();
                $(".loc-item").show();
                $(".toloc-item").hide();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").hide();
                $(".acqyear-item").hide();
                $(".acqval-item").hide();
                $(".book-item").hide();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf_apprv").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div_apprv").hide();

                // if (val == 4) {
                //   $(".busines_unit_apprv").show();
                // }
                console.log("II");
              } else if (val == 3 || val == 5) {
                $(".branchplant_div_apprv").show();
                $(".to_branch_plant_div_apprv").show();
                $(".bp_apprv").attr('required', true);
                $(".to_branch_plant_apprv").attr('required', true);

                $(".to_company_div_apprv").hide();
                $(".from_company_apprv").attr('required', false);
                $(".to_company_apprv").attr('required', false);
                $(".account_charge_apprv").hide();
                $(".dept_apprv").attr('required', false);
                $(".wo_reason_div_apprv").hide();
                $(".wo_reason_apprv").attr('required', false);

                // transfer b/p program & item modification
                $(".busines_unit_apprv").hide();
                $(".curr-item").hide();
                $(".glclass-item").hide();
                $(".unitcost-item").hide();
                $(".tounitcost-item").hide();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").hide();
                $(".tobp-item").hide();
                $(".bu-item").hide();
                $(".loc-item").show();
                $(".toloc-item").show();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").hide();
                $(".acqyear-item").hide();
                $(".acqval-item").hide();
                $(".book-item").hide();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div_apprv").hide();


                console.log("III & V");
              } else if (val == 6) {
                $(".to_company_div_apprv").show();
                $(".from_company_apprv").attr('required', true);
                $(".to_company_apprv").attr('required', true);

                $(".branchplant_div_apprv").hide();
                $(".to_branch_plant_div_apprv").hide();
                $(".bp_apprv").attr('required', false);
                $(".to_branch_plant_apprv").attr('required', false);
                $(".account_charge_apprv").hide();
                $(".dept_apprv").attr('required', false);
                $(".wo_reason_div_apprv").hide();
                $(".wo_reason_apprv").attr('required', false);

                // Intercompany transfer
                $(".busines_unit_apprv").hide();
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").show();
                $(".tounitcost-item").hide();
                $(".exammount-item").show();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").show();
                $(".bu-item").hide();
                $(".loc-item").hide();
                $(".toloc-item").hide();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").hide();
                $(".acqyear-item").hide();
                $(".acqval-item").show();
                $(".book-item").hide();
                $(".mtrstatus-item").show();
                $(".intercomp_trf_apprv").show();
                $(".assetvprice-item").show();
                $(".disposal_div_apprv").hide();
                $(".inspection_div_apprv").hide();

                console.log("VI");
              } else if (val == 7) {
                $(".to_company_div_apprv").hide();
                $(".from_company_apprv").attr('required', false);
                $(".to_company_apprv").attr('required', false);

                $(".branchplant_div_apprv").show();
                $(".to_branch_plant_div_apprv").hide();
                $(".bp_apprv").attr('required', true);
                $(".to_branch_plant_apprv").attr('required', false);
                $(".account_charge_apprv").hide();
                $(".dept_apprv").attr('required', false);
                $(".wo_reason_div_apprv").show();
                $(".wo_reason_apprv").attr('required', true);

                // Write Off
                $(".busines_unit_apprv").hide();
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").show();
                $(".tounitcost-item").hide();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").hide();
                $(".bu-item").hide();
                $(".loc-item").show();
                $(".toloc-item").hide();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").show();
                $(".acqyear-item").show();
                $(".acqval-item").show();
                $(".book-item").show();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf_apprv").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div_apprv").hide();

                console.log("VII");
              } else if (val == 8) {
                $(".to_company_div_apprv").hide();
                $(".from_company_apprv").attr('required', false);
                $(".to_company_apprv").attr('required', false);

                $(".branchplant_div_apprv").show();
                $(".to_branch_plant_div_apprv").hide();
                $(".bp_apprv").attr('required', true);
                $(".to_branch_plant_apprv").attr('required', false);
                $(".account_charge_apprv").hide();
                $(".dept_apprv").attr('required', false);
                $(".wo_reason_div_apprv").hide();
                $(".wo_reason_apprv").attr('required', true);

                // disposal
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").show();
                $(".tounitcost-item").hide();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").hide();
                $(".bu-item").hide();
                $(".loc-item").show();
                $(".toloc-item").hide();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").show();
                $(".acqyear-item").show();
                $(".acqval-item").show();
                $(".book-item").show();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf_apprv").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div_apprv").show();

                console.log("VIII");
              } else {
                $(".to_branch_plant_div_apprv").hide();
                $(".bp_apprv").attr('required', false);
                $(".to_branch_plant_apprv").attr('required', false);

                $(".to_company_div_apprv").hide();
                $(".from_company_apprv").attr('required', false);
                $(".to_company_apprv").attr('required', false);
                $(".account_charge_apprv").hide();
                $(".dept_apprv").attr('required', false);

                $(".busines_unit_apprv").show();
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").show();
                $(".tounitcost-item").show();
                $(".exammount-item").show();
                $(".toexammount-item").show();
                $(".bp-item").show();
                $(".tobp-item").show();
                $(".bu-item").show();
                $(".loc-item").show();
                $(".toloc-item").show();
                $(".acc-item").show();
                $(".accdesc-item").show();
                $(".cat-item").show();
                $(".acqyear-item").show();
                $(".acqval-item").show();
                $(".book-item").show();
                $(".mtrstatus-item").show();
                $(".intercomp_trf_apprv").show();
                $(".assetvprice-item").hide();
                $(".disposal_div_apprv").show();

                console.log("ELSE");
              }

              // $("#semic").hide();
              $("#from_loc"+el.mr_item.MATERIAL).val(el.mr_item.location);
              $("#to_loc"+el.mr_item.MATERIAL).val(el.mr_item.to_location);
              // console.log(res.get_approval[0].extra_case);
              if (res.get_approval[0].extra_case == 1) {
                $("#qty"+el.mr_item.MATERIAL).attr('readonly', false);
                $("#unit_price"+el.mr_item.MATERIAL).attr('readonly', false);
                $("#to_unit_cost"+el.mr_item.MATERIAL).attr('readonly', false);
                $("#remark"+el.mr_item.MATERIAL).attr('readonly', false);
                $("#to_total"+el.mr_item.MATERIAL).attr('readonly', false);
              } else {
                $("#qty"+el.mr_item.MATERIAL).attr('readonly', true);
                $("#unit_price"+el.mr_item.MATERIAL).attr('readonly', true);
                $("#to_unit_cost"+el.mr_item.MATERIAL).attr('readonly', true);
                $("#remark"+el.mr_item.MATERIAL).attr('readonly', true);
                $("#to_total"+el.mr_item.MATERIAL).attr('readonly', true);
              }
            },1000)

          });
        }
      });

    })
///////////////////////////////////////////////////////////////// MODAL APPROVAL MR /////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////// MODAL APPROVAL MR /////////////////////////////////////////////////////////////////////


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
    var table2 = $('#tbl').DataTable({
        ajax: {
            url: '<?= base_url('material/Material_req/datatable_mr') ?>',
            dataSrc: ''
        },
        scrollX: true,
        scrollY: '300px',
        scrollCollapse: true,
        paging: true,
        filter: true,
        info:false,
        fixedColumns: {
            leftColumns: 3,
            rightColumns: 1
        },
        columns: [
            {title: "<center>No</center>", "width": "20px"},
            {title: "<center><?= lang('Req No', 'Req No') ?></center>"},
            {title: "<center><?= lang('Tanggal', 'Req Date') ?></center>"},
            {title: "<center>Branch/Plant</center>"},
            {title: "<center>Material Request Type</center>"},
            {title: "<center>To Branch/Plant</center>"},
            {title: "<center>Purpose of Request</center>"},
            {title: "<center><?= lang("Status", "Status") ?></center>", "width": "50px"},
            {title: "<center>Action</center>", "width": "50px"},
        ],
        "columnDefs": [
            {"className": "dt-right", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
            {"className": "dt-center", "targets": [6]},
            {"className": "dt-center", "targets": [7]},
            {"className": "dt-center", "targets": [8]},
        ]
    });
    $(table2.table().container()).on('keyup', 'tfoot input', function () {
        table2.column( $(this).data('index') )
        .search( this.value )
        .draw();
    });

    // if($(".bp").val() != ""){ var bplantx = $(".bp").val();  } else { var bplantx = '10101WH01'; }
    $('#tbl_add_material tfoot th').each( function (i) {
        var title = $('#tbl_add_material thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" class="form-control" placeholder="Search '+title+'" data-index="'+i+'" />' );
    });
    var table = $('#tbl_add_material').DataTable({
        ajax: {
            url: '<?= base_url('material/Material_req/datatable_add_material') ?>',
            type:'POST',
            data: function(d){
              d.bplant = $(".bp").val();
            },
            "dataSrc": "",
        },
        scrollX: false,
        scrollCollapse: true,
        paging: true,
        filter: true,
        info:true,
        responsive:true,
        columns: [
            {title: "<center> - </center>", "width": "20px"},
            {title: "<center>SEMIC</center>"},
            {title: "<center>Description</center>"},
            {title: "<center>UOM</center>"},
            {title: "<center>Qty Avl</center>"},
            {title: "<center>Item Cost</center>"},
        ],
        "columnDefs": [
            {"className": "dt-left", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "text-right", "targets": [4]},
            {"className": "text-right", "targets": [5]},
        ]
    });

    $(table.table().container()).on('keyup', 'tfoot input', function () {
        table.column( $(this).data('index') )
        .search( this.value )
        .draw();
    });

    // fungsi
    function removeA(dt_array) {
        var what, a = arguments, L = a.length, ax;
        while (L > 1 && dt_array.length) {
            what = a[--L];
            while ((ax= dt_array.indexOf(what)) !== -1) {
                dt_array.splice(ax, 1);
            }
        }
        return dt_array;
    }

    function getSum(total, num) {
      return total + Math.round(num);
    }

  });

  // function change(id){
  //   var unit_price = $("#unit_price"+id).val();
  //   var qty = $("#qty"+id).val();
  //
  //   var sum = parseInt(unit_price)*parseInt(qty);
  //   $("#total"+id).val(sum);
  // }

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
      url: '<?= base_url('material/Material_req_approval/get_log')?>',
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
        $("#log_history").html(res);
      }
    });
  }

  function change(idx, mr_type){
    var qty = parseInt($("#qty"+idx).val());
    var qty_avl = parseInt($("#qty_avl"+idx).val());
    var qty_avl_ori = parseInt($("#qty_avl_ori"+idx).val());
    var item_cost = parseFloat($('#item_cost'+idx).val());
    var total_cost = 0;

    var sum = qty_avl_ori + qty;
    var reduction = qty_avl_ori - qty;
    if (mr_type == 2 || mr_type == 7 || mr_type == 8) {
      if (sum <= 0) {
        swal('Ooops!', 'Quantity Request can not be more than Quantity Available!', 'warning');
        $("#qty_avl"+idx).val(0);
        $("#qty"+idx).val(0);
        return false;
      } else {
        $("#qty_avl"+idx).val(sum);
        $('#curr_book'+idx).val(item_cost * qty);
      }
    }
    else if (mr_type == 6) {
        $('#to_unit_cost'+idx).val(item_cost * qty);
        var yy = item_cost * qty;
        $("#cal"+idx).val(numeral(yy).format('0,0'));
    }
    else {
      $("#qty_avl"+idx).val(reduction);
    }

  }

  function cleanArray(actual) {
    var newArray = new Array();
    for (var i = 0; i < actual.length; i++) {
      if (actual[i]) {
        newArray.push(actual[i]);
      }
    }
    return newArray;
  }

  function show_acharge(costcenter, idclass){
    $.ajax({
      url: '<?= base_url('material/material_req/show_acharge_item')?>',
      type: 'POST',
      dataType: 'json',
      data: {idx: costcenter }
    })
    .done(function() {
      resx = true;
    })
    .fail(function() {
      resx = false;
    })
    .always(function(res) {
      if (resx == true) {
        var str_opt = res.data;
        $(idclass).html(str_opt);
      }
    });
  }
</script>
