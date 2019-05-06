
<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
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
                <h3 class="content-header-title"><?= lang("Persetujuan Permintaan Material", "Material Request Approval") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Permintaan Material", "Material Request") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Persetujuan Permintaan Material", "Material Request Approval") ?></li>
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
                                                  <!-- <button aria-expanded="false" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></button> -->
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
                                                          <th><center>Req No</center></th>
                                                          <th><center>Req Date</center></th>
                                                          <th><center>Material Request Type</center></th>
                                                          <th><center>Purpose of Request</center></th>
                                                          <th><center>SEMIC</center></th>
                                                          <th><center>Item Desc</center></th>
                                                          <th><center>UOM</center></th>
                                                          <th><center>Qty Req</center></th>
                                                          <th><center>Qty Act</center></th>
                                                          <th><center>B/P Warehouse</center></th>
                                                          <th><center>To B/P Warehouse</center></th>
                                                          <th><center><?= lang("Approval", "Approval") ?></center></th>
                                                          <th><center><?= lang("Status", "Status") ?></center></th>
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
              </section>
          </div>
        </div>
        <!-- //section form -->
    </div>
</div>

<!-- modalselect material & currency -->
<div id="modal_mreq" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class="modal-content" id="mreq_show">
            <div class="modal-header">
                <?= lang("Tambah Material", "Add Material")?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="text-bold-600 font-medium-2"><?= lang("Pilih Material", "Select Material")?></div>
                  <select class="form-control select_material" style="width:450px !important;" name="select_material" required>
                    <option value=""> - </option>
                    <?php
                    foreach ($material->result_array() as $arr) { ?>
                      <option value="<?= $arr['MATERIAL']?>"><?= $arr['MATERIAL_NAME']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <div class="text-bold-600 font-medium-2"><?= lang("Pilih Matauang", "Select Currency")?></div>
                  <select class="form-control select_currency" style="width:450px !important;" name="select_currency" required>
                    <option value=""> - </option>
                    <?php
                    foreach ($currency->result_array() as $arr) { ?>
                      <option value="<?= $arr['ID']?>"><?= $arr['CURRENCY']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Tambah Data", "Add Data") ?></button>
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
                                                                    <textarea id="issue" rows="6" class="form-control border-primary" name="issue" placeholder="Issue for ICT" required readonly></textarea>
                                                                </div>
                                                            </div>

                                                            <div class="form-group row">
                                                                <label class="col-md-3 label-control" for="userinput6">Material Request Type</label>
                                                                <div class="col-md-9">
                                                                  <select class="form-control mr_type" style="width:350px !important;" name="mr_type" required disabled>
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
                                                              <select disabled class="form-control from_company" style="width:350px;" name="from_company" >
                                                                <option value=""> - </option>
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
                                                                  <select disabled class="form-control bp" style="width:350px;" name="bp" required>
                                                                    <option value=""> - </option>
                                                                    <?php
                                                                    foreach ($bp->result_array() as $arr) { ?>
                                                                      <option value="<?= $arr['ID_BPLANT']?>"><?= $arr['ID_BPLANT'].' - '.$arr['BPLANT_DESC'] ?></option>
                                                                    <?php } ?>
                                                                  </select>
                                                                </div>
                                                            </div>
                                                          </div>

                                                          <div class="to_branch_plant_div">
                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">To Branch/Plant</label>
                                                              <div class="col-md-9">
                                                                <!-- <input type="text" class="form-control to_branch_plant" name="to_branch_plant" value=""> -->
                                                                <select disabled class="form-control to_branch_plant" style="width:350px;" name="to_branch_plant" >
                                                                  <option value=""> - </option>
                                                                  <?php
                                                                  foreach ($bp->result_array() as $arr) { ?>
                                                                    <option value="<?= $arr['ID_BPLANT']?>"><?= $arr['ID_BPLANT'].' - '.$arr['BPLANT_DESC'] ?></option>
                                                                  <?php } ?>
                                                                </select>
                                                              </div>
                                                            </div>
                                                          </div>

                                                          <div class="busines_unit">
                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">Business Unit</label>
                                                              <div class="col-md-9">
                                                                <select class="form-control costcenter" style="width:350px;" name="costcenter" disabled>
                                                                  <option value=""> - </option>
                                                                  <?php
                                                                  foreach ($costcenter->result_array() as $arr) { ?>
                                                                  <option value="<?= $arr['ID_COSTCENTER'] ?>"><?= $arr['ID_COSTCENTER'].' - '.$arr['COSTCENTER_DESC'] ?></option>
                                                                  <?php } ?>
                                                                </select>
                                                              </div>
                                                            </div>
                                                          </div>

                                                          <div class="account_charge">
                                                              <div class="form-group row">
                                                                <label class="col-md-3 label-control" for="userinput8">Account Charge</label>
                                                                <div class="col-md-9">
                                                                  <input class="form-control dept" name="dept" value="" readonly>
                                                                </div>
                                                              </div>
                                                          </div>

                                                          <!-- to company -->
                                                          <div class="to_company_div">
                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">To Company</label>
                                                              <div class="col-md-9">
                                                                <select disabled class="form-control to_company" style="width:350px;" name="to_company" >
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
                                                          <div class="wo_reason_div">
                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">Write-Off Reason</label>
                                                              <div class="col-md-9">
                                                                <select disabled class="form-control wo_reason" style="width:350px;" name="wo_reason" >
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
                                                          <div class="intercomp_trf">
                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">Type of Asset Utilization</label>
                                                              <div class="col-md-9">
                                                                <select class="form-control asset_type" style="width:350px !important;" name="asset_type" disabled>
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
                                                                <select class="form-control disposal_method" name="disposal_method" disabled>
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
                                                                <textarea maxlength="30" id="disposal_desc" rows="6" class="form-control border-primary" name="disposal_desc" placeholder="Justification On Disposal Method" disabled></textarea>
                                                              </div>
                                                            </div>

                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">Estimate Disposal Value</label>
                                                              <div class="col-md-3">
                                                                <select class="form-control disposal_value" style="width:100px !important;" name="disposal_value" disabled>
                                                                  <option value=""> - </option>
                                                                  <?php
                                                                  foreach ($currency->result_array() as $arr) { ?>
                                                                    <option value="<?= $arr['ID'] ?>"><?= $arr['CURRENCY'] ?></option>
                                                                  <?php } ?>
                                                                </select>
                                                              </div>
                                                              <div class="col-md-6">
                                                                <input type="text" class="form-control" id="dis_val" name="dis_val" placeholder="" readonly>
                                                              </div>
                                                            </div>

                                                            <div class="form-group row">
                                                              <label class="col-md-3 label-control" for="userinput8">Estimate Disposal Cost</label>
                                                              <div class="col-md-3">
                                                                <select class="form-control disposal_cost" style="width:100px !important;" name="disposal_cost" disabled>
                                                                  <option value=""> - </option>
                                                                  <?php
                                                                  foreach ($currency->result_array() as $arr) { ?>
                                                                    <option value="<?= $arr['ID'] ?>"><?= $arr['CURRENCY'] ?></option>
                                                                  <?php } ?>
                                                                </select>
                                                              </div>
                                                              <div class="col-md-6">
                                                                <input type="text" class="form-control" id="dis_cost" name="dis_cost" placeholder="" readonly>
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
                                                          <th class="bu-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Busines Unit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
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
                    <button type="button" class="btn btn-danger" id="btnreject"><?= lang('Tolak', 'Reject') ?></button>
                    <button type="button" class="btn btn-primary" id="btnapprove"><?= lang('Setujui', 'Approve') ?></button>
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
    // $(".form_mreq").hide();
    var dt_array = [];

    $("#add").on('click', function(e) {
      // e.preventDefault();
      /* Act on the event */
      $(".table_mreq").fadeOut();
      $(".form_mreq").fadeIn();
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


    $(document).on('shown.bs.modal', '#modal_approval', function(e){
      $("#item_mreq_apprv").find('tr').remove();
      var idnya = $(e.relatedTarget).data("id");
      var statusx = $(e.relatedTarget).data("status");
      get_note(idnya);
      get_log(idnya);
      $("#notes").val("");
      $("select").select2({ width: 'resolve' });
      $("#mr_status_approval").html(statusx);
      var result;
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
          $('#issue').html(res.material_request.purpose_of_request);

          $('#mr_no').val(res.material_request.request_no);
          $('#comp_code').val(res.material_request.company_code);
          $('#user').val(res.material_request.create_by);

          $('.mr_type').val(res.material_request.document_type).select2();
          $('.dept').val(res.material_request.account+" - "+res.material_request.account_desc);
          $('.bp').val(res.material_request.branch_plant).select2();
          $('.costcenter').val(res.material_request.busines_unit).select2();
          $('.to_branch_plant').val(res.material_request.to_branch_plant).select2();
          $('.from_company').val(res.material_request.from_company).select2();
          $('.to_company').val(res.material_request.to_company).select2();
          $('.wo_reason').val(res.material_request.wo_reason).select2();
          $('.asset_type').val(res.material_request.asset_type).select2();


          if (res.material_request.inspection == 1) { $('#inspection').attr('checked', true); } else { $('#inspection').attr('checked', false); }
          if (res.material_request.asset_valuation == 1) { $('#asset_valuation').attr('checked', true); } else { $('#asset_valuation').attr('checked', false); }

          $("#disposal_desc").html(res.material_request.justification_disposal_method);
          $(".disposal_method").val(res.material_request.disposal_method).select2({ width: '100%' });
          $(".disposal_value").val(res.material_request.disposal_value_curr).select2();
          $("#dis_val").val(res.material_request.disposal_value);
          $(".disposal_cost").val(res.material_request.disposal_cost_curr).select2();
          $("#dis_cost").val(res.material_request.disposal_cost);

          $('#user_roles').val(res.get_approval[0].user_roles);
          $('#sequence').val(res.get_approval[0].sequence);
          $('#status_approve').val(res.get_approval[0].status_approve);
          $('#reject_step').val(res.get_approval[0].reject_step);
          $('#email_approve').val(res.get_approval[0].email_approve);
          $('#email_reject').val(res.get_approval[0].email_reject);
          $('#edit_content').val(res.get_approval[0].edit_content);
          $('#extra_case').val(res.get_approval[0].extra_case);




          // if (res.material_request.from_company != "" || res.material_request.to_company != "") {
          //   $('.to_company_div').show();
          // }
          //
          // if (res.material_request.branch_plant != "") {
          //   $('.to_branch_plant_div').show();
          // }

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
                        '<td class="bu-item"><input class="form-control" type="hidden" id="bu'+el.mr_item.MATERIAL+'" name="bu[]" value="'+el.mr_item.busines_unit+'" readonly>'+el.mr_item.busines_unit+'</td>'+
                        '<td class="loc-item"><input type="hidden" class="form-control" id="from_loc'+el.mr_item.MATERIAL+'" name="from_loc[]" value="'+el.mr_item.location+'" readonly>'+el.mr_item.location+'</td>'+
                        '<td class="toloc-item"><input type="hidden" class="form-control" id="to_loc'+el.mr_item.MATERIAL+'" name="to_loc[]" value="'+el.mr_item.to_location+'" readonly>'+el.mr_item.to_location+'</td>'+
                        '<td class="acc-item"><input type="hidden" class="form-control" id="acc'+el.mr_item.MATERIAL+'" name="acc[]" value="'+el.mr_item.account+'" readonly>'+el.mr_item.account+'</td>'+
                        '<td class="accdesc-item"><input type="hidden" class="form-control" id="acc_desc'+el.mr_item.MATERIAL+'" name="acc_desc[]" value="'+el.mr_item.account_desc+'" readonly>'+el.mr_item.account_desc+'</td>'+
                        '<td class="cat-item"><input class="form-control" type="hidden" id="category'+el.mr_item.MATERIAL+'" name="category[]" readonly>'+el.mr_item.category+'</td>'+
                        '<td class="acqyear-item"><input class="form-control" type="hidden" id="acq_year'+el.mr_item.MATERIAL+'" name="acq_year[]" readonly>'+el.mr_item.acq_year+'</td>'+
                        '<td class="acqval-item"><input class="form-control" type="hidden" id="acq_value'+el.mr_item.MATERIAL+'" name="acq_value[]" readonly>'+el.mr_item.acq_value+'</td>'+
                        '<td class="book-item"><input class="form-control" type="hidden" id="curr_book'+el.mr_item.MATERIAL+'" name="curr_book[]" readonly>'+el.mr_item.book_value+'</td>'+
                        '<td class="mtrstatus-item"><input type="hidden" class="form-control" id="mtr_status'+res.MATERIAL+'" name="mtr_status[]">'+el.mr_item.material_status+'</td>'+
                        '<td class="assetvprice-item"><input type="hidden" class="form-control" id="assetv_price'+res.MATERIAL+'" name="assetv_price[]">'+numeral(parseInt(el.mr_item.to_unit_cost)).format('0,0')+'</td>'+
                        '<td class="remark-item"><input type="hidden" id="remark'+el.mr_item.MATERIAL+'" rows="3" class="form-control border-primary" name="remark[]" placeholder="Fill some note here" disabled>'+el.mr_item.remark+'</input></td>'+
                    '</tr>';
            $("#item_mreq_apprv").append(str);
            input_numberic('#unit_price'+el.mr_item.MATERIAL, true);
            input_numberic('#qty'+el.mr_item.MATERIAL, true);
            input_numberic('#to_unit_cost'+el.mr_item.MATERIAL, true);
            input_numberic('#to_total'+el.mr_item.MATERIAL, true);
            setTimeout(function(){
              var val = $(".mr_type").val();

              if (val == 1 || val == 4) {
                $(".account_charge").hide();
                $(".busines_unit").show();
                $(".dept").attr('required', true);

                $(".branchplant_div").show();
                $(".to_branch_plant_div").hide();
                $(".bp").attr('required', false);
                $(".to_branch_plant").attr('required', false);

                $(".to_company_div").hide();
                $(".from_company").attr('required', false);
                $(".to_company").attr('required', false);
                $(".wo_reason_div").hide();
                $(".wo_reason").attr('required', false);

                // issue
                $(".curr-item").show();
                $(".glclass-item").show();
                $(".unitcost-item").hide();
                $(".tounitcost-item").show();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").hide();
                $(".loc-item").show();
                $(".toloc-item").hide();
                $(".acc-item").show();
                $(".accdesc-item").hide();
                $(".cat-item").hide();
                $(".acqyear-item").hide();
                $(".acqval-item").hide();
                $(".book-item").hide();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div").hide();

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

                // adjustment
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").hide();
                $(".tounitcost-item").hide();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").hide();
                $(".loc-item").show();
                $(".toloc-item").hide();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").hide();
                $(".acqyear-item").hide();
                $(".acqval-item").hide();
                $(".book-item").hide();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div").hide();

                // if (val == 4) {
                //   $(".busines_unit").show();
                // }

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

                // transfer b/p program & item modification
                $(".curr-item").hide();
                $(".glclass-item").hide();
                $(".unitcost-item").hide();
                $(".tounitcost-item").hide();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").hide();
                $(".tobp-item").hide();
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
                $(".disposal_div").hide();


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

                // Intercompany transfer
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").show();
                $(".tounitcost-item").hide();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").show();
                $(".loc-item").show();
                $(".toloc-item").show();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").hide();
                $(".acqyear-item").hide();
                $(".acqval-item").hide();
                $(".book-item").hide();
                $(".mtrstatus-item").show();
                $(".intercomp_trf").show();
                $(".assetvprice-item").show();
                $(".disposal_div").hide();
                $(".inspection_div").hide();


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

                // Write Off
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").show();
                $(".tounitcost-item").hide();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").hide();
                $(".loc-item").show();
                $(".toloc-item").hide();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").show();
                $(".acqyear-item").show();
                $(".acqval-item").show();
                $(".book-item").show();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div").hide();

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
                $(".wo_reason").attr('required', true);

                // disposal
                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").show();
                $(".tounitcost-item").hide();
                $(".exammount-item").hide();
                $(".toexammount-item").hide();
                $(".bp-item").show();
                $(".tobp-item").hide();
                $(".loc-item").show();
                $(".toloc-item").hide();
                $(".acc-item").hide();
                $(".accdesc-item").hide();
                $(".cat-item").show();
                $(".acqyear-item").show();
                $(".acqval-item").show();
                $(".book-item").show();
                $(".mtrstatus-item").hide();
                $(".intercomp_trf").hide();
                $(".assetvprice-item").hide();
                $(".disposal_div").show();

                console.log("VIII");
              } else {
                $(".to_branch_plant_div").hide();
                $(".bp").attr('required', false);
                $(".to_branch_plant").attr('required', false);

                $(".to_company_div").hide();
                $(".from_company").attr('required', false);
                $(".to_company").attr('required', false);
                $(".account_charge").hide();
                $(".busines_unit").hide();
                $(".dept").attr('required', false);

                $(".curr-item").show();
                $(".glclass-item").hide();
                $(".unitcost-item").hide();
                $(".tounitcost-item").show();
                $(".exammount-item").hide();
                $(".toexammount-item").show();
                $(".bp-item").show();
                $(".tobp-item").show();
                $(".loc-item").show();
                $(".toloc-item").show();
                $(".acc-item").show();
                $(".accdesc-item").show();
                $(".cat-item").show();
                $(".acqyear-item").show();
                $(".acqval-item").show();
                $(".book-item").show();
                $(".mtrstatus-item").show();
                $(".intercomp_trf").show();
                $(".assetvprice-item").hide();
                $(".disposal_div").show();

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

              console.log(res.get_approval[0].sequence);
              if (res.get_approval[0].user_roles == 15 && res.get_approval[0].sequence == 1) {
                $("#inspection").prop('disabled', false);
                $("#asset_valuation").prop('disabled', true);
              } else if (res.get_approval[0].user_roles == 19 && res.get_approval[0].sequence == 2) {
                $("#inspection").prop('disabled', true);
                $("#asset_valuation").prop('disabled', false);
              } else {
                $("#inspection").prop('disabled', true);
                $("#asset_valuation").prop('disabled', true);
              }
            },1000)

          });
        }
      });

    })

    $(document).on('click', '#btnapprove', function(e){
      e.preventDefault();
      (new PNotify({
        title: 'Confirmation Needed',
        text: 'are you sure you will approve this material request?',
        icon: 'glyphicon glyphicon-question-sign',
        hide: false,
        confirm: {
            confirm: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        },
        addclass: 'stack-modal',
        stack: {
            'dir1': 'down',
            'dir2': 'right',
            'modal': true
        }
      })).get().on('pnotify.confirm', function() {
        var xmodalx = modal_start($("#modal_approval").find(".modal-content"));
        approval_mr('<?= base_url('material/Material_req_approval/approve_mr')?>', xmodalx);
      })
    })

    $(document).on('click', '#btnreject', function(e){
      e.preventDefault();
      swal({
        title: "Data will rejected, are you sure?",
        text: "<textarea rows='6' class='form-control border-primary' id='note' required></textarea>",
        html: true,
        showCancelButton: true,
        closeOnConfirm: true,
        showLoaderOnConfirm: false,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, Reject it!',
        animation: "slide-from-top",
        inputPlaceholder: "Write something"
      }, function(inputValue) {
        console.log(inputValue);
        if (inputValue == true) {
          var notex = document.getElementById('note').value;
          if (notex == '') {
            setTimeout(function(){
              swal_notify("Oops!", "You need to write something !", "warning");
            },1000)
          } else {
            var xmodalx = modal_start($("#modal_approval").find(".modal-content"));
            approval_mr('<?= base_url('material/Material_req_approval/reject_mr')?>', xmodalx, notex);
            // swal("Nice!", "You wrote: " + val, "success");
          }
        }

      });
    })

    $(document).on('click', '.savenote', function(e){
      var notes = $("#notes").val();
      var mr_no = $("#mr_no").val();
      var result;
      if (notes == "") {
        alert("Please fill some note !");
      } else {
        if (confirm("Save this note, Are you sure ?")) {
          $.ajax({
            url: '<?= base_url('material/Material_req_approval/save_note')?>',
            type: 'POST',
            dataType: 'json',
            data: {
              notes: notes,
              mr_no: mr_no,
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
              get_note(mr_no);
            }
          });
        }
      }
    })

    $(document).on('shown.bs.modal', '#modal_mreq', function(e){
      $('.select_material').val("").select2();
      $('.select_currency').val("").select2();
    })

    $("#mreq_show").submit(function(e) {
      e.preventDefault();
      var data = $(this).serialize();
      // console.log(data);

      var result;
      $.ajax({
        url: '<?= base_url("material/Material_req/get_material")?>',
        type: 'POST',
        dataType: 'JSON',
        data: data
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        if (result == true) {
          // console.log(dt_array.includes(res.MATERIAL));
          // console.log(dt_array);
          if (dt_array.includes(parseInt(res.MATERIAL)) == true) {
            swal_notify( "Oops" ,  "Material already selected" ,  "error" );
            $('.select_material').val("").select2();
          } else {
            var str = '<tr>'+
                        '<td><input class="form-control" type="hidden" name="semic[]" value="'+res.MATERIAL_CODE+'">'+res.MATERIAL_CODE+'</td>'+
                        '<td><input class="form-control" type="hidden" name="m_name[]" value="'+res.MATERIAL_NAME+'">'+res.MATERIAL_NAME+'</td>'+
                        '<td><input class="form-control" type="hidden" name="curr[]" value="'+res.CURRENCY+'">'+res.CURRENCY_NAME+'</td>'+
                        '<td><input class="form-control" type="hidden" name="uom[]" value="'+res.UOM1+'">'+res.UOM1+'</td>'+
                        '<td><input class="form-control" type="text" onKeyup="change('+res.MATERIAL+')" id="unit_price'+res.MATERIAL+'" name="unit_price[]" required></td>'+
                        '<td><input class="form-control" type="text" onKeyup="change('+res.MATERIAL+')" id="qty'+res.MATERIAL+'" name="qty[]" required></td>'+
                        '<td><input class="form-control" type="text" id="total'+res.MATERIAL+'" name="ammount[]" readonly></td>'+
                        '<td><button class="btn btn-danger rm_item" data-id="'+res.MATERIAL+'" type="button"> Remove</button></td>'+
                    '</tr>';
            $("#item_mreq").append(str);
            input_numberic('#unit_price'+res.MATERIAL, true);
            input_numberic('#qty'+res.MATERIAL, true);
            dt_array.push(parseInt(res.MATERIAL));
            $('#modal_mreq').modal('hide');
            $('.select_material').val("").select2();
            $('.select_currency').val("").select2();
          }

        }
      });
    });

    $(document).on('click', '.rm_item', function(e) {
      // e.preventDefault();
      var idnya = $(this).data("id");
      // console.log(idnya);
      if (confirm('Are you sure you want to remove this item?')) {
        $(this).closest('tr').remove();
        // dt_array.indexOf();
        removeA(dt_array, idnya);
        // console.log(dt_array);
      }
    });

    $(".mreq_form").submit(function(e){
      e.preventDefault();
      var data = $(this).serialize();
      var resultx;
      // console.log(data);
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
          if (res.success == true) {
            swal({
              title: "Done",
              text: "Material request successfuly created",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: '#0072cf',
              confirmButtonText: 'Oke',
              closeOnConfirm: true,
              closeOnCancel: true
            },
            function(){
              window.location.href = "<?= base_url("material/material_req")?>";
            });
          }
        }
      });

    })

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

    var table = $('#tbl').DataTable({
        ajax: {
            url: '<?= base_url('material/Material_req_approval/datatable_mr') ?>',
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
            {title: "<center>Material Request Type</center>"},
            {title: "<center>Purpose of Request</center>"},
            {title: "<center>SEMIC</center>"},
            {title: "<center>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Item Desc&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</center>"},
            {title: "<center>UOM</center>"},
            {title: "<center>Qty Req</center>"},
            {title: "<center>Qty Act</center>"},
            {title: "<center>B/P Warehouse</center>"},
            {title: "<center>To B/P Warehouse</center>"},
            {title: "<center><?= lang("Approval", "Approval") ?></center>"},
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
            {"className": "dt-center", "targets": [9]},
            {"className": "dt-center", "targets": [10]},
            {"className": "dt-center", "targets": [11]},
            {"className": "dt-center", "targets": [12]},
            {"className": "dt-center", "targets": [13]},
            {"className": "dt-center", "targets": [14]},
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

  function change(id){
    var unit_price = $("#unit_price"+id).val();
    var qty = $("#qty"+id).val();
    // $("#unit_price"+id).val(0)
    $("#to_unit_cost"+id).val(0)
    $("#total"+id).val(0)
    $("#to_total"+id).val(0)
    var sum = parseInt(unit_price)*parseInt(qty);
    $("#total"+id).val(sum);
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

  function approval_mr(url, xmodalx, notex){
    var resx;
    if (document.getElementById("inspection").checked) { var val_inspection = 1; } else { var val_inspection = 0; }
    if (document.getElementById("asset_valuation").checked) { var val_asset_valuation = 1; } else { var val_asset_valuation = 0; }
    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'JSON',
      data: {
        mr_no: $('#mr_no').val(),
        user: $('#user').val(),
        user_roles: $('#user_roles').val(),
        sequence: $('#sequence').val(),
        status_approve: $('#status_approve').val(),
        reject_step: $('#reject_step').val(),
        email_approve: $('#email_approve').val(),
        email_reject: $('#email_reject').val(),
        edit_content: $('#edit_content').val(),
        extra_case: $('#extra_case').val(),
        inspection: val_inspection,
        asset_valuation: val_asset_valuation,
        note: notex,
        semic: $("input[name='semic[]']").map(function(){return $(this).val();}).get(),
        qty: $("input[name='qty[]']").map(function(){return $(this).val();}).get(),
        unit_price: $("input[name='unit_price[]']").map(function(){return $(this).val();}).get(),
        to_unit_cost: $("input[name='to_unit_cost[]']").map(function(){return $(this).val();}).get(),
        ammount: $("input[name='ammount[]']").map(function(){return $(this).val();}).get(),
        to_ammount: $("input[name='to_ammount[]']").map(function(){return $(this).val();}).get(),
        remark: $("textarea[name='remark[]']").map(function(){return $(this).val();}).get(),
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
          modal_stop(xmodalx);
          window.location.href = '<?= base_url('material/material_req_approval')?>';
      }
    });
  }

</script>
