<?php
$opt_company = array('' => 'Select Company') + @$opt_company;
$opt_msr_type = array('' => 'Select MSR Type') + @$opt_msr_type;
$opt_pmethod = array('' => 'Select Proposed Proc. Method') + @$opt_pmethod;
$opt_plocation = array('' => 'Select Proc. Location') + @$opt_plocation;
$opt_currency = array('' => 'Select Currency') + @$opt_currency;
$opt_cost_center = array('' => 'Select Cost Center') + @$opt_cost_center;
$opt_location = array('' => 'Select Location') + @$opt_location;
$opt_delivery_point = array('' => 'Select Delivery Point') + @$opt_delivery_point;
$opt_delivery_term = array('' => 'Select Delivery Term') + @$opt_delivery_term;
$opt_importation = array('' => 'Select Importation') + @$opt_importation;
$opt_requestfor = array('' => 'Select Request for') + @$opt_requestfor;
$opt_inspection = array('' => 'Select Inspection') + @$opt_inspection;
$opt_freight = array('' => 'Select Freight') + @$opt_freight;
$opt_itemtype = array('' => 'Select Item Type') + @$opt_itemtype;
$opt_account_subsidiary = array('' => 'Select Account Subsidiary') + @$opt_account_subsidiary;
$opt_msr_inventory_type = array('' => 'Select Inventory Type') + @$opt_msr_inventory_type;
$msr_no = false; // MSR not yet created
$posts = $this->input->post();
$exchange_rate_db = @json_encode(exchange_rate_db()) ?: '{}';

function hidden_input($name, $value) {
  return "<input type=\"hidden\" name=\"" . htmlspecialchars($name) ."\" value=\"" . htmlspecialchars($value) . "\">";
}

$can_create_msr = can_create_msr();

?>
<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<!-- <link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet"> -->
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<!-- <link href="<?= base_url() ?>ast11/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/> -->
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">

<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<!-- <link href="//fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet"> -->
<?php /* page specific */ ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/pickadate/pickadate.css">
<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<style>
.msr-development-detail-list-table, .msr-development-budget-table {
margin-bottom: 20px;
margin-top: 5px;
}


.slc2font{
  font-size:4px;
}
</style>

<div class="app-content content">
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
    <h3 class="content-header-title"><?= lang("MSR Preparation", "MSR Preparation") . ' ' .set_value('msr_no', '')?></h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
          <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
          <li class="breadcrumb-item active"><?= lang("MSR Preparation", "MSR Preparation") ?></li>
        </ol>
      </div>
    </div>
  </div>


  <div class="content-body">
    <div class="row info-header">
      <div class="col-md-4">
        <table class="table table-condensed">
         <tr>
              <td width="20%">Title</td>
              <td class="no-padding-lr">:</td>
              <td ><label id="msr_title"></label></td>
            </tr>
          </table>
      </div>
    <div class="col-md-3">
        <table class="table table-condensed">
         <tr>
              <td width="20%">User Requestor</td>
              <td class="no-padding-lr">:</td>
              <td><span><?= $data_user["NAME"]; ?></span></td>
            </tr>
            <tr>
              <td width="20%">Department</td>
              <td class="no-padding-lr">:</td>
              <td><span><?= @$data_department[0]->DEPARTMENT_DESC; ?></span></td>
            </tr>
          </table>
      </div>

      <div class="col-md-5">
        <table class="table table-condensed">
		  <tr>
            <td width="30%">Total (Excl. VAT)</td>
            <td class="no-padding-lr">:</td>
            <td class="pull-right">
              <span id="total_amount"></span>
            </td>
          </tr>
          <tr>
            <td width="30%">VAT</td>
            <td class="no-padding-lr">:</td>
            <td class="pull-right">
              <span id="total_tax"></span>
            </td>
          </tr>
          <tr>
            <td width="30%">Total (Incl. VAT)</td>
            <td class="no-padding-lr">:</td>
            <td class="pull-right">
              <span id="total_amount_with_tax"></span>
            </td>
          </tr>
        </table>
      </div>
    </div>
    <section id="configuration">
      <div class="row">
        <div class="col-md-12">
          <?php if (isset($message) && !empty($message['message'])): ?>
            <?php $message['type'] = $message['type'] == 'error' ? 'danger' : $message['type']; ?>
            <div class="alert alert-dismissible alert-<?= $message['type'] ?>" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <?= $message['message'] ?>
            </div>
          <?php endif; ?>

          <?php if ($this->session->flashdata('message')): ?>
            <?php $message = $this->session->flashdata('message') ?>
            <div class="alert alert-dismissible alert-<?= $message['type'] ?>" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <?= $message['message'] ?>
            </div>
          <?php endif; ?>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-content collapse show "  >

              <div class="card-body card-dashboard card-scroll" >
                <div class="row">
                  <div class="col-md-12">
                    <!-- form #msr-development-form -->
                    <form id="msr-development-form" method="POST" enctype="multipart/form-data" class="steps-validation wizard-circle">
                      <?php /* MSR Header */ ?>
                      <input id="draft_id" name="draft_id" type="hidden" value="<?= set_value('draft_id')?>">
                      <input id="msr_no" name="msr_no" type="hidden" value="<?= set_value('msr_no')?>">
                      <h6><i class="step-icon icon-info"></i> Header</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="company">
                                Company :
                                <span class="danger">*</span>
                              </label>
                <?= form_dropdown('company', $opt_company, set_value('company'), 'class="custom-select form-control required" id="company"')
                ?>
                            </div>
                          </div>

						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="plocation">Procurement Location :
                                <span class="danger">*</span>
                              </label>
                              <?php if ($is_writable): ?>
                              <?= form_dropdown('plocation', $opt_plocation, set_value('plocation'), 'class="custom-select form-control required" id="plocation"') ?>
                              <?php else: ?>
                              <?= form_input('plocation', '', set_value('plocation'), 'type="form-control" readonly="readonly"') ?>
                              <?php endif; ?>
                            </div>
                          </div>



                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="required_date">
                                Required Date :
                                <span class="danger">*</span>
                              </label>
                              <input type="text" class="form-control date required" value="<?= set_value('required_date') ?>" id="required_date" name="required_date" style="background-color: #ffffff;">
                            </div>
                          </div>

						<div class="col-md-3">
                            <div class="form-group">
                              <label for="lead_time">
                                Lead Time :
                                <span class="danger">*</span>
                              </label>
                              <div class="input-group">
                                <input class="form-control required" value="<?= set_value('lead_time')?>" data-bts-postfix="Week(s)" id="lead_time" name="lead_time" min="0">
                                <span class="input-group-addon">Week(s)</span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="title">Title :
                                <span class="danger">*</span>
                              </label>
                              <textarea class="form-control required" id="title" name="title" rows="2" maxlength="30"><?= set_value('title') ?></textarea>
                            </div>
                          </div>

              <div class="col-md-3">
                            <div class="form-group">
                              <label for="pmethod">
                                Proposed Procurement Method :
                                <span class="danger">*</span>
                              </label>
                              <?php if ($is_writable): ?>
                              <?= form_dropdown('pmethod', $opt_pmethod, set_value('pmethod'), 'class="form-control custom-select required" id="pmethod"') ?>
                              <?php else: ?>
                              <?= form_input('pmethod', '', set_value('pmethod'), 'type="form-control" readonly="readonly"') ?>
                              <?php endif; ?>
                            </div>
                          </div>

						 <div class="col-md-3">
                            <div class="form-group">
                              <label for="procure_processing_time">
                                Procurement Processing Time :
                              </label>
                              <div class="input-group">
                                <input type="text" readonly name="procure_processing_time" id="procure_processing_time" class="form-control" value="<?= set_value('procure_processing_time') ?>">
                                <span class="input-group-addon">days </span>
                              </div>
							  <p><small class="text-muted">Excluding lead time. After MSR received by Procurement.</small></p>
                            </div>
                          </div>


                          <!-- <div class="col-md-2">
                            <div class="form-group form-check">
                              <input type="checkbox" name="blanket" id="blanket" class="form-check-input position-static" value="1">
                              <label for="blanket" class="col-form-label">Blanket</label>
                            </div>
                          </div> -->

                        </div>

                        <div class="row">

						<div class="col-md-3">
                            <div class="form-group">
                              <label for="msr_type">
                                MSR Type :
                                <span class="danger">*</span>
                              </label>
                              <?php if ($is_writable): ?>
                              <?= form_dropdown('msr_type', $opt_msr_type, set_value('msr_type'), 'class="custom-select form-control required" id="msr_type"') ?>
                              <?php else: ?>
                              <?= form_input('msr_type', '', set_value('msr_type'), 'type="form-control" readonly="readonly"') ?>
                              <?php endif; ?>
                            </div>
                          </div>

						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="msr_type">
                                Blanket Type :
                                <span class="danger">*</span>
                              </label>
                              <?php if ($is_writable): ?>
                                <?= form_dropdown('blanket', [''=>'Select Blanket Type',1=>'Blanket',0=>'Non Blanket'], set_value('blanket'), 'class="custom-select form-control required" id="blanket"') ?>
                              <?php else: ?>
                              <?= form_input('blanket', '', set_value('blanket'), 'type="form-control" readonly="readonly"') ?>
                              <?php endif; ?>
                            </div>
                          </div>



						 <div class="col-md-3">
                            <div class="form-group">
                              <label for="cost_center">
                                Cost Center :
                                <span class="danger">*</span>
                              </label>
                              <?= form_dropdown('cost_center', array(),
								set_value('cost_center'), 
								'class="custom-select form-control hidden" id="cost_center"')
							  ?>
                              <?= form_dropdown('cost_center_slc2', array(),
								set_value('cost_center'), 
								'class="select2 block form-control required" id="cost_center_slc2" placeholder="Select Cost Center" style="width: 100%"');
 							  ?>
                            </div>
                          </div>

						 <div class="col-md-3">
                            <div class="form-group">
                              <label for="currency">
                                Currency :
                                <span class="danger">*</span>
                              </label>
                              <?php if ($is_writable): ?>
                              <?= form_dropdown('currency', $opt_currency, set_value('currency'), 'class="form-control custom-select required" id="currency"') ?>
                              <?php else: ?>
                              <?= form_input('currency', '', set_value('currency'), 'type="form-control" readonly="readonly" id="currency"') ?>
                              <?php endif; ?>
                            </div>
                          </div>
                        </div>

                      </fieldset>

                      <?php /* MSR Detail */ ?>
                      <h6><i class="step-icon icon-list"></i> Detail</h6>
                      <fieldset>
                        <div id="msr_type_alert" class="alert alert-warning" role="alert">
                          <strong>Warning!</strong> No MSR Type selected
                        </div>

                        <?php /* Jika MSR type = Goods */ ?>
                        <div class="msr_detail_type_goods">
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="delivery_point">
                                  Delivery Point :
                                </label>
                                <?= form_dropdown('delivery_point', $opt_delivery_point, set_value('delivery_point'), 'class="form-control custom-select" id="delivery_point"') ?>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="importation">
                                  Importation :
                                </label>
                                <?= form_dropdown('importation', $opt_importation, set_value('importation'), 'class="form-control custom-select" id="importation"') ?>
                              </div>
                            </div>

              <div class="col-md-3">
                              <div class="form-group">
                                <label for="delivery_term">Delivery Term :</label>
                                <?= form_dropdown('delivery_term', $opt_delivery_term, set_value('delivery_term'), 'class="form-control custom-select" id="delivery_term"') ?>
                              </div>
                            </div>

              <div class="col-md-3">
                              <div class="form-group">
                                <label for="freight">Freight :</label>
                                <?= form_dropdown('freight', $opt_freight, set_value('freight'), 'class="form-control custom-select" id="freight"') ?>
                              </div>
                            </div>

                          </div>

                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="requestfor">Request for :</label>
                                <?= form_dropdown('requestfor', $opt_requestfor, set_value('requestfor'), 'class="form-control custom-select" id="requestfor"') ?>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="inspection">
                                  Inspection/Acceptance :
                                </label>
                                <?= form_dropdown('inspection', $opt_inspection, set_value('inspection'), 'class="form-control custom-select" id="inspection"') ?>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label>
                                  Master List :
                                </label>
                                <div class="checkbox">
                                  <label for="master_list">
                                    <?= form_checkbox('master_list', set_value('master_list', 1), (boolean) set_value('master_list', 0), 'id="master_list"') ?>
                                  </label>
                                </div>
                              </div>
                            </div>

                          </div>
                        </div>

                        <?php /* Jika MSR type = Services */ ?>
                        <div class="msr_detail_type_service">
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="scope_of_work">Brief of Scope of Work :
                                  <span class="danger">*</span>
                                </label>
                                <textarea class="form-control" rows="4" name="scope_of_work" id="scope_of_work"><?= set_value('scope_of_work') ?></textarea>
                              </div>
                            </div>
              <div class="col-md-3">
                              <div class="form-group">
                                <label for="location">Location :</label>
                                <?= form_dropdown('location', $opt_location, set_value('location'), 'class="form-control custom-select" id="location"') ?>
                              </div>
                            </div>
                          </div>


                        </div>

                        <div class="row msr-development-detail-list-table">
                          <div class="col-md-12">
                            <!--<div id="item-table-alert" class="alert alert-warning" role="alert" style="">
                              Please add at least an item
                            </div>-->
                            <div class="btn-group pull-right">
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#msr-development-item-modal">Add New Item</button>
                              <!--
                              <button type="button" class="btn btn-sm btn-secondary">Upload</button>
                              <button type="button" class="btn btn-sm btn-info">Download</button>
                              -->
                            </div>
                            <input name="items-summary" id="items-summary" type="hidden">
                            <div class="table-responsive">
                              <table id="msr-development-detail-list" class="table stripe nowrap"></table>
                            </div>
                          </div>
                        </div>
                      </fieldset>

                      <?php /* Step 3 */ ?>
                      <h6><i class="step-icon icon-calculator"></i> Budget</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">
                            <span id="current_exchange_rate_text">Current exchange rate:</span> <span id="budget_exchange_rate"></span>
                          </div>
                        </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table id="msr-development-budget" class="table table-striped base-style nowrap">
                            <thead>
                            <tr>
                              <th data-data="cost_center_name" rowspan="2">Cost Center</th>
                              <th data-data="account_subsidiary_name" rowspan="2">Account Subsidiary</th>
                              <th data-data="currency_base_name" rowspan="2">Currency</th>
                              <th data-data="msr_booking_amount_base" rowspan="2">Booking Amount</th>
                              <th data-data="available_budget" colspan="2" style="text-align: center">Available Budget</th>
                              <th data-data="status_budget" rowspan="2">Status Budget</th>
                              <th data-data="hidden_input" rowspan="2"></th>
                            </tr>
                            <tr>
                              <th data-data="available_budget_cost_center">Cost Center</th>
                              <th data-data="available_budget_account_subsidiary">Acc. Subsidairy</th>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                            </table>
                          </div>
                        </div>
                    </div>
<!--
                            <table id="msr-development-budget" class="table table-striped base-style">
                            <thead>
                                <tr>
                                  <th data-data="cost_center_name" rowspan="2">Cost Center</th>
                                  <th data-data="account_subsidiary_name" rowspan="2">Account Subsidiary</th>
                                  <th data-data="currency_name" rowspan="2">Currency</th>
                                  <th data-data="msr_booking_amount" rowspan="2">Booking Amount</th>
                                  <th data-data="available_budget" colspan="2" style="text-align: center">Available Budget</th>
                                  <th data-data="status_budget" rowspan="2">Status Budget</th>
                                  <th data-data="hidden_input" rowspan="2"></th>
                                </tr>
                                <tr>
                                  <th data-data="available_budget_cost_center">Cost Center</th>
                                  <th data-data="available_budget_account_subsidiary">Acc. Subsidairy</th>
                                </tr>
                            </thead>
                            </table>
-->
                      </fieldset>

                      <?php /* Attachment */ ?>
                      <h6><i class="step-icon icon-paper-clip"></i> Attachment</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">

                            <!--<div id="attachment-alert" class="alert alert-warning" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>-->
                            <div id="attachment-list" class="repeater">
                              <div class="row">
                                <div class="col-md-12 text-right">
                                  <!--button data-repeater-create class="btn btn-primary" type="button">Upload File</button-->
								  <!--machrus-->
								  <button type="button" id="btn-attachment" class="btn btn-primary" onclick="modalFileOpen();">Upload File</button>
                                </div>
								<!--machrus-->
                            
							  </div>
							<hr>
							<div>
								<table id="attachment-table" class="table">
									<thead>
										<tr>
											<th>Type</th>
											<th>Filename</th>
											<th>Uploaded Date</th>
											<th>Uploaded By</th>
											<th class="text-center">Action</th>
										</tr>
									</thead>
									<tbody></tbody>
								</table>
							</div>
                              <hr>
                              <!--div class="row">
                                <div class="col-md-2"><?php /* type */ ?>
                                  <label>Type</label>
                                </div>
                                <div class="col-md-1"><?php /* sequence */ ?>
                                  <label>Seq</label>
                                </div>
                                <div class="col-md-3"><?php /* filename */ ?>
                                  <label>Filename</label>
                                </div>
                                <div class="col-md-3"><?php /* upload time */ ?>
                                  <label>Uploaded Date</label>
                                </div>
                                <div class="col-md-2"><?php /* upload by */ ?>
                                  <label>Uploaded By</label>
                                </div>
                                <div class="col-md-1"><?php /* action button */ ?></div>
                              </div>
                              <hr>
                              <div data-repeater-list="attachments">
                                <?php if (isset($attachments) && count($attachments)): ?>
                                  <?php foreach($attachments as $att): ?>
                                  <div data-repeater-item>

                                    <div class="row form-group">
                                      <div class="col-md-2"><?php /* type */ ?>
                                        <?= form_dropdown('attachment_type', @$opt_msr_attachment_type, $att->tipe,
                                          'class="form-control required" data-msg-required="Please select type"') ?>
                                      </div>

                                      <div class="col-md-1"><?php /* sequence */ ?> </div>

                                      <div class="col-md-3 attachment-filename-col"><?php /* filename */ ?>
                                        <a class="attachment-link" href="<?= base_url($att->file_path.$att->file_name) ?>" target="_blank"><?= $att->file_name ?></a>
                                        <input type="hidden" class="attachment-file-id" name="attachment_file_id" value="<?= $att->id ?>">
                                        <input type="file" disabled name="attachment_file" class="form-control attachment-file hidden required" data-msg-required=" Please select a file">
                                      </div>

                                      <div class="col-md-3"><?php /* upload time */ ?> </div>

                                      <div class="col-md-2"><?php /* upload by */ ?> </div>

                                      <div class="col-md-1"><?php /* action button */ ?>
                                        <button type="button" data-repeater-delete class="btn btn-icon btn-sm btn-danger">
                                          <i class="icon-trash"></i>
                                        </button>
                                      </div>
                                    </div>
                                  </div> 
                                  <?php endforeach; ?>
                                <?php else: ?>
                                <div data-repeater-item>

                                  <div class="row form-group">
                                    <div class="col-md-2"><?php /* type */ ?>
                                      <?= form_dropdown('attachment_type', @$opt_msr_attachment_type, '',
                                        'class="form-control required" data-msg-required="Please select type"') ?>
                                    </div>

                                    <div class="col-md-1"><?php /* sequence */ ?> </div>

                                    <div class="col-md-3 attachment-filename-col"><?php /* filename */ ?>
                                      <a class="attachment-link" href="" target="_blank"></a>
                                      <input type="hidden" class="attachment-file-id" name="attachment_file_id" value="">
                                      <input type="file" disabled name="attachment_file" class="attachment-file hidden required" data-msg-required=" Please select a file">
                                    </div>

                                    <div class="col-md-3"><?php /* upload time */ ?> </div>

                                    <div class="col-md-2"><?php /* upload by */ ?> </div>

                                    <div class="col-md-1"><?php /* action button */ ?>
                                      <button type="button" data-repeater-delete class="btn btn-icon btn-sm btn-danger">
                                        Delete
                                      </button>
                                    </div>
                                  </div>
                                </div> <!-- end repeater item -->
                                <?php endif;?>

                                <!--
                                <div data-repeater-item>

                                  <div class="row form-group">
                                    <div class="col-md-2"><?php /* type */ ?>
                                      <?= form_dropdown('attachment_type', @$opt_msr_attachment_type, null,
                                        'class="form-control required" data-msg-required="Please select type"') ?>
                                    </div>

                                    <div class="col-md-1"><?php /* sequence */ ?> </div>

                                    <div class="col-md-3"><?php /* filename */ ?>
                                      <input type="file" name="attachment_file" class="form-control required" data-msg-required=" Please select a file">
                                    </div>

                                    <div class="col-md-3"><?php /* upload time */ ?> </div>

                                    <div class="col-md-2"><?php /* upload by */ ?> </div>

                                    <div class="col-md-1"><?php /* action button */ ?>
                                      <button type="button" data-repeater-delete class="btn btn-icon btn-sm btn-danger">
                                        <i class="icon-trash"></i>
                                      </button>
                                    </div>
                                  </div>
                                </div>
                                -->
                                <!-- end repeater item -->

                              </div> <!-- end repeater list -->
                            </div>  <!-- end repeater attachment -->
                          </div>
                        </div>
                      </fieldset>
                      <input type="hidden" name="submit-second-aas-approver-id" id="submit-second-aas-approver-id">

                      <?php if ($msr_no): ?>
                      <h6>Approval</h6>
                      <fieldset>
                        <?= /* function_exists('list_approval') ? list_approval(@$moduleKode, @$dataId) : '' */ '' ?>
                      </fieldset>
                      <?php endif; ?>
                    </form>

                  </div>
                </div>
				<!--<div class="row" id="required-warning" hidden>
					<div class="col-md-12">
						<div id="item-table-alert" class="alert alert-warning" role="alert" style="">Please fill out all the required fields (*)</div>
					</div>
			   </div>-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="form-group text-right">
    <button id="save-as-draft" class="btn btn-primary">Save Draft</button>
    <?php if ($can_create_msr) { ?>
      <button id="save-as-submit" type="button" role="button" class="btn btn-success" onclick="submit_msr()">Submit</button>
    <?php } ?>
  </div>
</div>
</div>

<!-- modal #msr-development-item-modal -->
<div class="modal fade" id="msr-development-item-modal"  role="dialog" aria-labelledby="modallabel-item" aria-hidden="true">
<div class="modal-dialog modal-lg modal-form" role="document">
  <div class="modal-content">

    <div class="modal-header">
      <h4 class="modal-title" id="modal-label-item">Add Item</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <?php /* TODO: Beautify layout */?>
    <div class="modal-body form-horizontal">
      <form action="#" class="row">
        <!-- left column -->
      <div class="col-sm-6">
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Item Type: </label>
        <div class="col-sm-8">
        <?= form_dropdown('item-item_type',
        $opt_itemtype,
        set_value('item-item_type'),
        'class="form-control custom-select" placeholder="Select Item Type" id="item-item_type"');
        ?>
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Category: </label>
        <div class="col-sm-8">
        <?= form_dropdown('item-itemtype_category',
        array(),
        set_value('item-itemtype_category'),
        'class="form-control custom-select" placeholder="Select Category" id="item-itemtype_category"');
        ?>
        </div>
        </div>
        <div class="form-group row">
        <label for="item-material_id" class="clearfix col-form-label col-sm-4"><span id="item-material_label">Semic No</span>: </label>
        <div class="col-sm-8">
        <?= form_dropdown('item-material_id',
        null,
        set_value('item-material_id'),
        'class="select2 block form-control" placeholder="Select Semic No" id="item-material_id" style="width: 100%"');
        ?>
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Description of Unit: </label>
        <div class="col-sm-8">
          <!-- <input type="text" readonly="readonly" placeholder="" id="item-description" class="form-control"> -->
          <textarea type="text" name="item-semic_no_name" id="item-semic_no_name" class="form-control" style="width:100%"></textarea>
          <input type="hidden" name="item-semic_no_value" id="item-semic_no_value">
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Classification:</label>
        <div class="col-sm-8">
          <input type="text" readonly="readonly" id="item-group" class="form-control-plaintext" style="width:100%">
          <input type="hidden" name="item-group_value" id="item-group_value">
          <input type="hidden" name="item-group_name" id="item-group_name">
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Group/Category: </label>
        <div class="col-sm-8">
          <input type="text" readonly="readonly" id="item-subgroup" class="form-control-plaintext" style="width:100%">
          <input type="hidden" id="item-subgroup_value">
          <input type="hidden" id="item-subgroup_name">
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">On-Hand Qty: </label>
        <div class="col-sm-8">
          <input type="text" readonly="readonly" id="item-qty_onhand" class="form-control-plaintext">
          <input type="text" readonly="readonly" id="item-uom_name_qty_onhand" class="form-control-plaintext">
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Ordered Qty: </label>
        <div class="col-sm-8">
          <input type="text"  readonly="readonly" id="item-qty_ordered" class="form-control-plaintext">
          <input type="text" readonly="readonly" id="item-uom_name_qty_ordered" class="form-control-plaintext">
        </div>
        </div>
      </div>

      <!-- right column -->
      <div class="col-sm-6">
        <div class="form-group row item-is_asset_div">
        <label for="item-is_asset" class="col-form-label col-sm-4">
          Asset
        </label>
        <div class="col-sm-8">
          <div class="form-check">
          <input type="checkbox" class="form-check-input position-static" name="item-is_asset" id="item-is_asset" value="1">
          </div>
        </div>
        </div>
        <!-- // MSR - Tambah Inputan inventory type -->
        <div class="form-group row item-inv_type_div">
        <label for="item-is_asset" class="col-form-label col-sm-4">
          Inventory Type
        </label>
        <div class="col-sm-8">
          <div class="form-check">
            <?= form_dropdown('item-inv_type', $opt_msr_inventory_type,
            set_value('item-inv_type'),
            'class="form-control custom-select" id="item-inv_type" placeholder="Select inventory type"')
            ?>
          </div>
        </div>
        </div>
        <div class="form-group row item-item_modification_div">
        <label for="item-item_modification" class="col-form-label col-sm-4">
          Item Modification
        </label>
        <div class="col-sm-8">
          <div class="form-check">
          <input type="checkbox" class="form-check-input position-static" name="item-item_modification" id="item-item_modification" value="1">
          </div>
        </div>
        </div>
        <!-- // MSR - Tambah Inputan inventory type -->
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Required Qty / UoM: </label>
        <div class="col-sm-4">
          <input type="text" id="item-qty_required" name="item-qty_required" class="form-control">
        </div>
        <div class="col-sm-4">
          <input type="text" readonly="readonly" id="item-uom_name" name="item-uom_name" class="form-control">
          <select type="text" id="item-uom_name_service" name="item-uom_name_service" class="form-control"></select>
          <input type="hidden" id="item-uom_value">
        </div>
        </div>
        <!--
        <div class="form-group row">
        <label class="col-form-label">Unit of Measure: </label>
        </div>
        -->
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Est. Unit Price: </label>
        <div class="col-sm-4">
          <input type="text" id="item-unit_price" name="item-unit_price" class="form-control">
        </div>
        <div class="col-sm-4">
          <input type="text" readonly="readonly" id="item-currency_name" name="item-currency_name" class="form-control">
          <input type="hidden" id="item-currency_value">
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Est. Total Value:</label>
        <div class="col-sm-6">
          <input type="text" readonly="readonly" placeholder="Est. Total Value" id="item-total_value" class="form-control">
        </div>
        <div class="col-sm-2">
          <input type="text" readonly="readonly" id="item-currency_name_total_value" class="form-control">
        </div>
        </div>
        <!--
        <div class="form-group row">
        <label class="col-form-label">Currency:</label>
        <?php /* form_dropdown('item-currency',
        $opt_currency, set_value('item-currency'),
        'class="form-control custom-select" readonly="readonly" id="item-currency"')
         */
        ?>
        </div>
        -->
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Cost Center:</label>
        <div class="col-sm-8">
        <?= form_dropdown('item-cost_center', array(),
        set_value('item-cost_center'),
        'class="form-control custom-select hidden" id="item-cost_center" placeholder="Select Cost Center"')
        ?>
		<?= form_dropdown('item-cost_center_slc2', array(),
        set_value('item-cost_center'),
		'class="select2 block form-control" id="item-cost_center_slc2" placeholder="Select Cost Center" style="width: 100%"')
        ?>
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Account Subsidiary:</label>
        <div class="col-sm-8">
        <?= form_dropdown('item-account_subsidiary', $opt_account_subsidiary,
        set_value('item-account_subsidiary'),
        'class="form-control custom-select" id="item-account_subsidiary" placeholder="Select Account Subsidiary"')
        ?>
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Importation:</label>
        <div class="col-sm-8">
        <?= form_dropdown('item-importation',
        $opt_importation, set_value('item-importation'),
        'class="form-control custom-select" id="item-importation"')
        ?>
        <input type="hidden" id="item-importation_name">
        </div>
        </div>
        <div class="form-group row">
        <label class="col-form-label col-sm-4">Delivery Point/Location:</label>
        <div class="col-sm-8">
        <?= form_dropdown('item-delivery_point', $opt_delivery_point,
        set_value('item-delivery_point'),
        'class="form-control custom-select" id="item-delivery_point" placeholder="Select Delivery Point"')
        ?>
        </div>
        </div>
      </div>
      </form>
    </div>
    <div class="modal-footer">
      <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-primary" id="item-add">Add</button>
    </div>
  </div>
</div>
</div>

<!-- modal select second AAS approval -->
<div class="modal fade text-left" id="msr-development-approval-user"  role="dialog" aria-labelledby="modallabel-item" aria-hidden="true">
<div class="modal-dialog modal-lg" role="document">

  <div class="modal-content">

    <div class="modal-header">
      <h4 class="modal-title" id="modal-label-item" style="font-weight: bold">AAS Approvers Determination</h4>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>

    <div class="modal-body form-horizontal">
      <div class="form-group row">
        <label class="col-form-label col-md-3">
         MSR Total Value
        </label>
        <div class="col-md-9">
          <!-- <label id="aas_msr_total_amount" style="font-weight: bold" class="col-form-label"></label> -->
          <label id="aas_total_amount" style="font-weight: bold" class="col-form-label"></label>
        </div>
      </div>
      <div class="row">
        <label class="col-form-label col-md-3">
          <label>AAS First Approver</label>
        </label>
        <div class="col-md-9">
            <input type="text" id="first-aas-approver" readonly class="form-control-plaintext" style="width: 100%">
        </div>
      </div>

      <div class="row">
        <label class="col-form-label col-md-3">
          AAS Second Approver
        </label>
        <div class="col-md-9">
            <select id="second-aas-approver-id" name="second-aas-approver-id" class="form-control" style="width: 100%"></select>
        </div>
      </div>
    </div>
	



    <div class="modal-footer">
      <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-success" id="submit-approver">Submit</button>
    </div>
  </div>
</div>
</div>


<!--modal upload machrus start-->
<div class="modal fade" id="attachment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Type</label>
					<?= $this->form->select('attachment_type', array('' => 'Please Select')+@$opt_msr_attachment_type, null, 'id="attachment-modal-select_type" class="form-control"') ?>
				</div>
				<div id="form-group-attachment-modal-type" class="form-group" style="display:none">
                    <?= $this->form->text('attachment_modal_type', null, 'id="attachment-modal-type" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Filename</label>
                    <?= $this->form->text('attachment_file_id', null, 'id="attachment-modal-file_name" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>File</label>
                    <input type="file" name="attachment_file" id="attachment-modal-file">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="attachment_upload()">Upload</button>
            </div>
        </div>
    </div>
</div>
<!--modal upload machrus end-->

<script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<!--<script src="<?= base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>
<!-- <script src="<?= base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script>  -->
<script src="<?= base_url() ?>ast11/filter/scripts.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<!--<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/dataTables.select.min.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>
<script src="<?= base_url('ast11/assets/js/accounting.js/accounting.js') ?>"></script>

<script>
var mapMsrTypeItemType = '<?= @json_encode($mapMsrTypeItemType, JSON_HEX_QUOT | JSON_HEX_APOS) ?>';
var itemTypeCategoryByParent = JSON.parse('<?= @json_encode($opt_itemtype_category_by_parent, JSON_HEX_QUOT | JSON_HEX_APOS) ?>')
var itemTypeCategory = JSON.parse('<?= @json_encode($opt_itemtype_category, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');
var cost_center = '<?= @json_encode($opt_cost_center) ?>';
var item_master = [];
var attachmentType = JSON.parse('<?= @json_encode($opt_msr_attachment_type, JSON_HEX_QUOT | JSON_HEX_APOS)?>');
var attachment_list = {};
var msr_development_budget = {};
var threshold_amount = {
    'DA' : <?= $this->msr->getAmountThreshold('DA') ?: 0 ?>,
    'DS' : <?= $this->msr->getAmountThreshold('DS') ?: 0 ?>
}
var pmethods = <?= @json_encode($pmethods) ?>;
var currency_abbr = <?= @json_encode($opt_currency_abbr) ?>;
var user_costcenter = '<?= $user_costcenter ?>';
var last_costcenter = '<?= set_value('cost_center') ?>'
var base_currency = {
    id: '<?= base_currency() ?>',
    code: '<?= base_currency_code() ?>'
}
var exchange_rate_db = <?= $exchange_rate_db ?: '{}' ?>;
var uoms = JSON.parse('<?= @json_encode($uoms, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');

//machrus
function modalFileOpen(){
	$('#attachment-modal-select_type').val('');  
	$('#attachment-modal-type').val('');  
	$('#attachment-modal-file_name').val('');  
	$('#attachment-modal-file').val('');  
	$('#attachment-modal').modal('show');  
		
}

function attachment_upload() {
	//alert($('#attachment-modal-select_type').val());
	$('#attachment-modal #error_message').remove();
	var formData = new FormData;
	formData.append('type', $('#attachment-modal-select_type').val());
	formData.append('file_name', $('#attachment-modal-file_name').val());
	formData.append('file', $('#attachment-modal-file')[0].files[0]);
	$.ajax({
		type:'POST',
		enctype:'multipart/form-data',
		data: formData,
		processData: false,
		contentType: false,
		dataType:'json',
		url : '<?= base_url('procurement/msr/attachment_upload') ?>',
		success : function(response) {
			if (response.success) {
				add_attachment($('#attachment-modal-select_type').val(), $('#attachment-modal-file_name').val(), './upload/MSR/'+response.data.file_name, Localization.humanDatetime(new Date()), '<?= $_SESSION['NAME'] ?>')
				$('#attachment-modal').modal('hide');
			} else {
				$('#attachment-modal .modal-body').prepend('<div id="error_message" class="alert alert-danger">'+response.message+'</div>');
			}
		}
	});
}
var attachment_row = $('#attachment-table tbody tr').length;
var attrType = {
	SCOPE   : 'Scope of Work',
	RA      : 'Risk Assessment',
	JD      : 'Justification Document',
	OWNEST  : "Owners Estimate",
	SCOPESUPLY : 'Scope of Supply',
	OTHER   : 'Other'
};
function add_attachment(type, file_name, file, upload_at, upload_by) {
	//alert(attrType[type]);
	var html_attachment_table = '<tr data-row-id="'+attachment_row+'">';
		html_attachment_table += '<td>';
			html_attachment_table += '<input type="hidden" id="attachments"  name="attachment['+attachment_row+'][type]" value="'+type+'">'+attrType[type];
		html_attachment_table += '</td>';
		html_attachment_table += '<td>';
			html_attachment_table += '<input type="hidden" name="attachment['+attachment_row+'][file_name]" value="'+file_name+'"><input type="hidden" name="attachment['+attachment_row+'][file]" value="'+file+'"><a href="<?= base_url() ?>'+file+'" target="_blank">'+file_name+'</a>';
		html_attachment_table += '</td>';
		html_attachment_table += '<td>'+upload_at+'</td>';
		html_attachment_table += '<td>'+upload_by+'</td>';
		html_attachment_table += '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="remove_attachment(\''+attachment_row+'\')">Delete</button></td>';
	html_attachment_table += '</tr>';
	$('#attachment-table tbody').append(html_attachment_table);
	attachment_row++;
}

function remove_attachment(id) {
	swalConfirm('ARF Preparation', '<?= __('confirm_delete') ?>', function() {
		$('#attachment-table tbody [data-row-id="'+id+'"]').remove();
	});
}

function exchange_rate(from, to, amount)
{
    var rate_db = exchange_rate_db;

    var from = from.toUpperCase();
    var to = to.toUpperCase();

    function get_rate(from, to)
    {
        if (from == to) {
            return 1;
        }

        var key = from + '|' + to;

        return (key in rate_db) ? rate_db[key] : 0;
    }

    var rate = get_rate(from, to);

    return parseFloat(amount) * parseFloat(rate);
}

function set_exchange_rate(from, to, rate)
{
    var key = from + '|' + to;

    exchange_rate_db[key] = parseFloat(rate);
}

/*
function cost_center_select2() {
  return cost_center.map(function(v, k) {
    return { id: k, text: v }
  })
}
*/

function DefaultItemValue() {
  this.msr_type = ''
  this.item_type = ''
  this.itemtype_category = ''
  this.cost_center = ''
  this.location = ''
  this.item_type = ''
  this.delivery_point = ''
  this.importation = ''
  this.requestfor = ''
  this.delivery_term = ''
  this.inspection = ''
  this.freight = ''
  this.currency = ''

  var mapMsr = JSON.parse(mapMsrTypeItemType)

  this.setItemTypeFromMsrType = function (msr_type) {
    if (mapMsr.hasOwnProperty(msr_type)) {
      this.msr_type = msr_type
      this.item_type = mapMsr[msr_type]
    } else {
      this.msr_type = ''
      this.item_type = ''
    }
  }


  this.setValue = function(prop, value) {
    if (this.hasOwnProperty(prop)) {
      console.log('Set defaut value ' + prop + ':' + value)
      this[prop] = value;
    }
  }
}


function Items() {
  this.items = [];

  var fetch_url = '<?= base_url() . "/procurement/msr/findItem" ?>';

  function fetch(data) {
    return $.get(fetch_url, data)
  }

  function format_items(data) {
    this.items = data;

    return this.items
  }

  this.get = function(params, callback, callback_error) {
    var f = fetch({ 'type': params['type'], 'query': params['query']})
    .done(function(result) {
        //var items = format_items(result)
        callback(items)
      })
    .fail(function(error) {
      callback_error(error)
    })
  }
}


function add_item(table, data) {
  data['no'] = table.data().length + 1;
  data['action'] = ''

  return table.row().add(data)
}

function remove_item(selected_row) {
  return msr_developement_detail_list.row(selected_row).remove()
}

function split_semic(value) {
  var sep = '-'
  var arr = value.split(sep)

  return {
    semic_no : arr.shift().trim(),
    description: arr.join(sep).trim()
  }
}

function validate_msr_item(form) {
/*
  var validation_rules = {
      "item-item_type": {
        required: true
      },
      "item-itemtype_category": {
        required: true
      },
      "item-material_id": {
        required: true
      },
      "item-qty_required": {
        required: true,
        number: true
      },
      "item-unit_price": {
        required: true,
        number: true
      },
      "item-cost_center": {
        required: true
      },
      "item-account_subsidiary": {
        required: false
      },
      "item-semic_no_name": {
        required: true
      },
  }
*/
  $("#item-item_type, #item-itemtype_category, \
    #item-material_id, #item-qty_required, #item-unit_price, \
    #item-cost_center, #item-semic_no_name").addClass('required')

  $('#item-qty_required, #item-unit_price').attr('number', true);

  var itemtype_category = $('#item-itemtype_category').val()
  if (itemtype_category != 'SEMIC' && itemtype_category != '') {
    $("#item-uom_name_service").addClass('required');
    $('#item-inv_type').removeClass('required');
  } else {
    $("#item-uom_name_service").removeClass('required')
    $('#item-inv_type').addClass('required');
  }

  if ($('#item-inv_type').val() == 1) {
    $('#item-account_subsidiary').removeClass('required');
    $('#item-account_subsidiary').html('');
  } else {
    $('#item-account_subsidiary').addClass('required');
  }

  var form = $(form)

  //if (['BLANKET', 'SERVICE', 'CONSULTATION'].indexOf(form.find('#item-item_type').val()) != -1) {
    //validation_rules['item-semic_no_name'] = { required: true }
  //}

  // set validation
  form.validate({
    ignore: 'input[type=hidden]', // ignore hidden fields
    errorClass: 'danger',
    successClass: 'success',
    highlight: function(element, errorClass) {
      $(element).addClass(errorClass);
    },
    unhighlight: function(element, errorClass) {
      $(element).removeClass(errorClass);
    },
    errorPlacement: function(error, element) {
      error.insertBefore($(element).parents('.form-group'));
    },
  });


  // validated!!
  return form.valid();
}

<?php
/*
  0. capture data from msr detail table (previous step)
  1. send to server to be calculated
  2. receive data from server
  3. update budget table list data and redraw!
  4. do not update and show erros if failed
  5. return calculated data (?)
*/
?>
function calculate_budget() {

  var master_list = $('#master_list:checked').val() ? 1 : 0;
  $.post(
    '<?= base_url().'/procurement/msr/calculateBudget' ?>',
    'master_list='+master_list+'&'+$('#msr-development-detail-list').find('input,select,textarea').serialize()
  )
  .done(function(data) {
    if (data.status == 'error') {
      // alert(data.message);
      return false;
    }

    msr_development_budget.clear()
    msr_development_budget.rows.add(data.data).draw()

    $('#msr-development-budget').find('select').prop('disabled', true)

    var budget_exchange_rate = accounting.formatMoney(data.exchange_rate_from, { symbol: data.msr_currency_name })
                + ' = ' + accounting.formatMoney(data.exchange_rate_to, { format: '%s %v', symbol: data.base_currency_name });

    $('#budget_exchange_rate').text(budget_exchange_rate);

    if (data.msr_currency_id == data.base_currency_id) {
      $("#current_exchange_rate_text").hide();
      $('#budget_exchange_rate').hide();
    } else {
      $("#current_exchange_rate_text").show();
      $('#budget_exchange_rate').show();
    }
  })
  .fail(function(error) {
    // alert(error)
    swal('<?= __('warning') ?>',error,'warning')

  })
  .always(function() {
    // e.g. remove waiting animation
  })
}

function create_select_option(elem, placeholder, options, selected_id = null, placeholder_id = '') {
  elem.empty();
  if (placeholder) {
   elem.append(new Option(placeholder, placeholder_id));
  }

  options.forEach(function(v, k) {
    elem.append(new Option(v, k, k == selected_id))
  })
}

function check_budget_holder() {
  var result = false

  $.ajax({
    method: 'POST',
    url: '<?= base_url().'/procurement/msr/checkBudgetHolder' ?>',
    data: $('#msr-development-detail-list').find('input,select,textarea').serialize(),
    async: false,
  })
  .done(function(data) {
    result = data.status
  })
  .fail(function(error) {
    // alert(error)
    swal('<?= __('warning') ?>',error,'warning')
  })
  .always(function() {
    // e.g. remove waiting animation
  })

  return result
}

function get_total_msr_amount_from_detail_item() {
    var total_amount = 0;
    var names = [];
    var msr_development_detail_list = $('#msr-development-detail-list')

    // only take row index that (assumed) as input name array key
    /*
    msr_development_detail_list.DataTable().data().each(function(k,v) {
        names.push('items['+ v +'][total_value]');
    })

    msr_development_detail_list.find('input').each(function(k,v) {
        var elem = $(v);

        if (names.indexOf(elem.attr('name')) != -1) {
          total_amount += parseFloat(elem.val());
        }
    })
    */

    msr_development_detail_list.DataTable().column('total_value:name')
        .data()
        .each(function(e) {
            total_amount += parseFloat($($.parseHTML(e)).filter('input')[0].value)
        })

    return total_amount;
}

// get tax amount from total_amount
function get_tax_amount_from_total(total_amount) {
  var includeVAT = !$('#master_list').is(':checked');
  var percentVAT = 0.0;

  if (includeVAT) {
    percentVAT = 0.1;
  }

  return total_amount * percentVAT;
}

function display_multi_currency_format(amount_from, currency_from, amount_to, currency_to) {
    var text = accounting.formatMoney(amount_from, { symbol: currency_from })

    if (currency_from != currency_to && currency_from) {
        text += '<br><small class="text-muted">(equal to ' + accounting.formatMoney(amount_to, { symbol: currency_to }) + ')</small>'
    }

    return text;
}

function display_total_value_header_section() {
  var currency_name = ''
  if ($('#currency').val()) {
    currency_name = $('#currency option:selected').text();
  }


  var total_amount = get_total_msr_amount_from_detail_item()
  var total_tax = get_tax_amount_from_total(total_amount)
  var total_amount_with_tax = total_amount + total_tax

  var total_amount_base = exchange_rate(currency_name, base_currency.code, total_amount)
  var total_tax_base = exchange_rate(currency_name, base_currency.code, total_tax)
  var total_amount_with_tax_base = exchange_rate(currency_name, base_currency.code, total_amount_with_tax)

  $('#total_amount').html(
    display_multi_currency_format(total_amount, currency_name, total_amount_base, base_currency.code)
  )
  $('#total_tax').html(
    display_multi_currency_format(total_tax, currency_name, total_tax_base, base_currency.code)
  )
  $('#total_amount_with_tax').html(
    display_multi_currency_format(total_amount_with_tax, currency_name, total_amount_with_tax_base, base_currency.code)
  )
}

<?php
/* MSR Attachment validation
  1. MSR Services require Scope of Work and Risk Assessment
  2. MSR with Procurement Method DA & DS out of the provisions require Justification Document
     based on total MSR value
     DA => 10K USD
     DS => 100K USD
*/
?>
function validate_attachment() {
  var attachments;
  var msr_service_required = ['SCOPE', 'RA', 'OWNEST'];
  var msr_goods_required = ['SCOPESUPLY'];
  var pmethod_required = [];
  var success_score = {};
  var msr_type = $('#msr_type').val();
  var pmethod = $('#pmethod').val();
  var currency = $('#currency').val();
  var total_amount = get_total_msr_amount_from_detail_item();
  var total_amount_to_check = 0;
  var currency_from;
  var currency_to = '<?= $this->msr->getThresholdBaseCurrency() ?>';

    //machrus comment open
  if ( (currency_from = currency_abbr[currency]) == undefined ) {
    swal('<?= __('warning') ?>','Cannot check total amount. Unsupported currency','warning')
	return false;
  } 

  total_amount_to_check = exchange_rate(currency_from, currency_to, total_amount);
 
  // If no item added, calling repeaterVal() will raise "TypeError: a[0] is undefined"
  try {
//    attachments = attachment_list.repeaterVal().attachments;
	//machrus
	attachments = attachment_list.repeaterVal().attachment;
  } catch(error) {
    if (msr_type != 'MSR02' && pmethod != 'DA' && pmethod != 'DS') {
      return true;
    }

    attachments = []

    // display_alert_validate_attachment('Please upload required document')
    // return false;
  }

  // double check
  // if (attachments.length == 0) {
    // display_alert_validate_attachment('Please upload required document')
    // return false;
  // }

  if (msr_type == 'MSR02') {
    msr_service_required.forEach(function(t) {
      success_score[t] = 0;
    })
  }

  if (msr_type == 'MSR01') {
    msr_goods_required.forEach(function(t) {
      success_score[t] = 0;
    })
  }

  if (pmethod == 'DA' || pmethod == 'DS') {
    if (total_amount_to_check > threshold_amount[pmethod]) {
        // require Justification Document
        pmethod_required.push('JD')
    }


    pmethod_required.forEach(function(t) {
      success_score[t] = 0;
    })
  }
  
  //machrus
	//console.log(attachments);
  /* for (k in attachments) {
    if (msr_type == 'MSR01') {  // MSR Goods
      if (msr_goods_required.indexOf(attachments[k].attachment_type) >= 0  &&
        (attachments[k].attachment_file != '' || attachments[k].attachment_file_id)) {
        success_score[attachments[k].attachment_type]++
      }
    }

    if (msr_type == 'MSR02') {  // MSR Services
      if (msr_service_required.indexOf(attachments[k].attachment_type) >= 0  &&
        (attachments[k].attachment_file != '' || attachments[k].attachment_file_id)) {
        success_score[attachments[k].attachment_type]++
      }
    }

    if (pmethod == 'DA' || pmethod == 'DS') { // Direct Appointment && Direct Selection
      if (pmethod_required.indexOf(attachments[k].attachment_type) >= 0  &&
        (attachments[k].attachment_file != '' || attachments[k].attachment_file_id) ) {
        success_score[attachments[k].attachment_type]++
      }
    }
  } */
  for (k in attachments) {
	  /* alert(msr_type);
	  alert(pmethod); */
    if (msr_type == 'MSR01') {  // MSR Goods
	  //alert('MSR01');
      if (msr_goods_required.indexOf(attachments[k].type) >= 0  &&
        (attachments[k].file != '')) {
        success_score[attachments[k].type]++
      }
    }

    if (msr_type == 'MSR02') {  // MSR Services
      //alert('MSR02');
	  if (msr_service_required.indexOf(attachments[k].type) >= 0  &&
        (attachments[k].file != '')) {
        success_score[attachments[k].type]++
      }
    }

    if (pmethod == 'DA' || pmethod == 'DS') { // Direct Appointment && Direct Selection
      //alert('DA DS');
	  if (pmethod_required.indexOf(attachments[k].type) >= 0  &&
        (attachments[k].file != '')) {
        success_score[attachments[k].type]++
      }
    }
  }

  var error = false;
  var required_document = []
  for (var k in success_score) {
    if (success_score[k] == 0) {
      // raise 'required' error
      required_document.push(attachmentType[k])
      error = true
    }
  }

  if (error) {
    display_alert_validate_attachment(required_document.join(', ')+ ' document required')
    return false
  }

  return !error;
}

function display_alert_validate_attachment(text, elm_class = 'danger')
{
  swal('<?= __('warning') ?>', text, 'warning');
  $('#attachment-alert').removeClass().addClass('alert alert-'+elm_class).text(text).show()
}
//var items = new Items();
var default_item_value = new DefaultItemValue();

$(document).ready(function() {
  if (!($('.modal.in').length)) {
    $('.modal-dialog').css({
      top: 0,
      left: 0
    });
  }
  $('.modal-dialog').draggable({
    handle: ".modal-header"
  });
// MSR - Tambah Inputan inventory type
$(".item-is_asset_div").hide();
$("#item-inv_type").prop("disabled", true);
//$("#item-account_subsidiary").prop("disabled", true);
$(".item-item_modification_div").hide();
$(document).on('change', '#item-itemtype_category', function(){
  var inv_val = $(this).val();
  if (inv_val == 1) {
    $("#item-account_subsidiary").prop("disabled", true);
  } else {
    $("#item-account_subsidiary").prop("disabled", false);
  }
})
$(document).on('change', '#item-inv_type', function(){
  var inv_val = $(this).val();
  if (inv_val == 1) {
    $("#item-account_subsidiary").prop("disabled", true);
  } else {
    $("#item-account_subsidiary").prop("disabled", false);
  }
})
// MSR - Tambah Inputan inventory type

<?php /* TODO: where is the configuration ??? */ ?>
accounting.settings = {
  currency: {
    decimal : ".",  // decimal point separator
    thousand: ",",  // thousands separator
    precision : 2,   // decimal places
    format: "%s %v"
  },
  number: {
    precision : 2,  // default precision on numbers is 0
    thousand: ",",
    decimal : "."
  }
}

  var id_warehouse = "AAA";
  var semic_no_global = "BBB";

// Validate steps wizard
// Show form
var form = $("#msr-development-form"); form.show();
var item_table_alert = $('#item-table-alert'); item_table_alert.hide();
form.find('.alert').hide();

var msr_development_steps = $("#msr-development-form").steps({
  headerTag: "h6",
  bodyTag: "fieldset",
  transitionEffect: "fade",
  titleTemplate: '#title#',
  enableFinishButton: false,
  enablePagination: true,
  enableAllSteps: true,
  onStepChanging: function (event, currentIndex, newIndex)
  {
    // every tab/step up change trigger budget preparation and calculation
    calculate_budget();

    // Allways allow previous action even if the current form is not valid!
    if (currentIndex > newIndex)
    {
      return true;
    }

    if (currentIndex == 0)
    {
      // Block MSR creation for procurement location other than 'PG01' (Head Office Procurement)
      var plocation = $('#plocation').val()
      if (plocation != '' && plocation != 'PG01') {
        // alert('Creation MSR with Procurement Location ' + $('#plocation option:selected').text() + " is disallowed")
        swal('<?= __('warning') ?>','Creation MSR with Procurement Location ' + $('#plocation option:selected').text() + " is disallowed",'warning')
        return false
      }

      // Check exchange rate
      var currency_id = $('#currency').val();
      if (currency_id != '') {
        if (!check_exchange_rate(currency_id)) {
            swal('<?= __('warning') ?>','Exchange rate from '+ currency_abbr[currency_id] +' to ' + base_currency.code +' not maintained yet','warning')
            return false;
        }
      }

      var goods_section = $('.msr_detail_type_goods'); goods_section.hide();
      var service_section = $('.msr_detail_type_service'); service_section.hide();
      form.find('#msr_type_alert').hide();

      switch(form.find('#msr_type').val())
      {
        case 'MSR01':
          goods_section.show();
          form.find('#scope_of_work .required').removeClass('required');
          break;
        case 'MSR02':
          service_section.show();
          form.find('#scope_of_work').addClass('required');
          break;
        default:
          form.find('#msr_type_alert').show();
      }
    } else if (currentIndex == 1)
    {
      $('#item-table-alert').hide()
      // cek datatable $('#msr-development-detail-list').DataTable() harus minimal 1 item
      if (msr_development_detail_list.data().length == 0) {
        swal('<?= __('warning') ?>', 'Please add at least an item', 'warning');
        $('#item-table-alert').text('Please add at least an item').show()
        return false;
      }
    } else if (currentIndex == 2)
    {
        $('#attachment-alert').hide()
    }

    // Needed in some cases if the user went back (clean up)
    if (currentIndex < newIndex)
    {
      // To remove error styles
      form.find(".body:eq(" + newIndex + ") label.error").remove();
      form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
    }

    //show single required warning
    form.validate().settings.ignore = ":disabled,:hidden";
    
	//machrus open comment
	if (!form.valid()){
      swal('<?= __('warning') ?>', 'Please fill out all the required fields (*)', 'warning');
    }
    //return true;
    return form.valid();
  }
});

//hide next and previous button
$('a[href="#next"]').hide();
$('a[href="#previous"]').hide();


$('#second-aas-approver-id').select2();

$('#msr-development-approval-user #submit-approver').click(function(e) {
    swalConfirm('MSR Preparation', '<?= __('confirm_submit') ?>', function() {
      var first_aas_approver_data = $('#first-aas-approver').data()
      var second_aas_approver_id = $('#second-aas-approver-id').val()

      if (first_aas_approver_data.user_role != 1 || first_aas_approver_data.parent_id != 0) {
        if (!second_aas_approver_id) {
            swal('<?= __('warning') ?>','Please select an approver','warning')
            return false;
        }
      }

      $('#submit-second-aas-approver-id').val(second_aas_approver_id ? second_aas_approver_id : '')
      // if (confirm("Are you sure want to proceed ?")) {
      var form = $('#msr-development-form')
//      var action_url = '<?= base_url('procurement/msr/saveDraft') ?>'
      var action_url = '<?= base_url('procurement/msr/saveDraftV1') ?>'
      var data = new FormData(form[0])
      var btn = this

      start($(btn).parents('.content-body'))
      $.ajax({
        method: "POST",
        url: action_url,
        contentType: false,
        processData: false,
        data: data
      })
      .done(function(data) {
		  //console.log(data);
		  var frm = new FormData;
			frm.append('draft_id', data.draft_id);
			frm.append('msr_no', data.msr_no);
		  //machrus 
		  $.ajax({
			method: "POST",
			url: '<?= base_url('procurement/msr/updateAtt') ?>',
			contentType: false,
			processData: false,
			data: frm
		  })
		  .done(function(data) {
			  //console.log(data);
			  $("#msr-development-form").submit()
		  })
		  
      })
    // }
    });
})

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
   error.insertBefore($(element).parents('.form-group'));
 },
 rules: { }
});

// Pick a date
//$('.pickadate').datetimepicker();

msr_development_budget = $("#msr-development-budget").DataTable({
  "paging":   false,
  "info":     false,
  "searching": false,
  "ordering": false,
  "select": false,
  "columnDefs": [
    { "targets": 0, "createdCell": function(td, rowData, rowData, row, col) {
      $(td).text(rowData.cost_center_value + ' - ' + rowData.cost_center_name)
    }},
    { "targets": 1, "createdCell": function(td, cellData, rowData, row, col) {
      $(td).text(rowData.account_subsidiary_value + ' - ' + rowData.account_subsidiary_name)
    }},
    {"targets": 2, "class":"text-center"},
    {"targets": 3, "class":"text-center"},
    {"targets": 4, "class":"text-center"},
    {"targets": 5, "class":"text-center"},
    {"targets": 6, "class":"text-center"}
  ]
});

var msr_development_detail_list = $('#msr-development-detail-list').DataTable({
  "paging":   false,
  "info":     false,
  "searching": false,
  "ordering": false,
  "select": false,
  "rowId": "id",
  "columns": [
    /* {"data": "no", "title": "No"}, */
    {"name": "item_type", "data": "item_type", "title": "Item Type"},
    // {"name": "itemtype_category", "data": "itemtype_category", "title": "Category"},
    {"name": "semic_no", "data": "semic_no", "title": "Semic No/ Service Cat", "class": "Semic"},
    {"name": "description_of_unit", "data": "description_of_unit", "title": "Description of Unit", "class": "description"},
    {"name": "group", "data": "group", "title": "Classification", "class": "classification"},
    {"name": "subgroup", "data": "subgroup", "title": "Group/ Category", "class": "category"},
    {"name": "qty_required", "data": "qty_required", "title": "Qty Req", "class": "Qty-Req text-center"},
    {"name": "qty_onhand", "data": "qty_onhand", "title": "Qty OH", "class": "Qty-OH text-center"},
    {"name": "qty_ordered", "data": "qty_ordered", "title": "Qty Ord", "class": "Qty-Ord text-center"},
    {"name": "uom", "data": "uom", "title": "UoM", "class":"text-center"},
    {"name": "unit_price", "data": "unit_price", "title": "Est. Unit Price", "class": "price text-right"},
    {"name": "total_value", "data": "total_value", "title": "Est. Total Value", "class": "value text-right"},
    {"name": "currency", "data": "currency", "title": "Currency", "class": "text-center"},
    {"name": "importation", "data": "importation", "title": "Importation"},
    {"name": "delivery_point", "data": "delivery_point", "title": "Delivery Point/ Location", "class": "delivery-point"},
    {"name": "cost_center", "data": "cost_center", "title": "Cost Center"},
    {"name": "account_subsidiary", "data": "account_subsidiary", "title": "Account Subsidiary", "class": "subsidiary"},
    /*{"name": "is_asset", "data": "is_asset", "title": "Asset"},*/
    {"name": "inv_type", "data": "inv_type", "title": "Inv Type"},
    {"name": "item_modification", "data": "item_modification", "title": "Item Modification", "class" : "text-center"},
    {"name": "action", "data": "action", createdCell: function(td, cellData, rowData, row, col) {
        $(td).html('<button type="button" id="item-delete_btn'+row+'" class="btn btn-icon btn-md btn-danger btn-sm item-delete_btn">Delete</button>')
    }, "class": "text-center"}
  ]
})
.on('select', function(event, data, type, indexes) {
  // @doc https://datatables.net/reference/event/select
  if ( type === 'row' ) {
    //var data = table.rows( indexes ).data().pluck( 'id' );

    // do something with the ID of the selected items
  }
})
.on('draw.dt', function() {
  /*
  $('#msr-development-detail-list tbody ').on('click', 'button.item-delete_btn', function() {
    if (confirm('Are you sure want to delete this row?')) {
      $('#msr-development-detail-list').DataTable()
        .row( $(this).parents('tr') )
        .remove()
        .draw();
    }
  })
  */
  $('#msr-development-detail-list').on('click', '.item-delete_btn', function() {
    var elem = this;
    swalConfirm('MSR Preparation', '<?= __('confirm_delete') ?>', function() {
      $('#msr-development-detail-list').DataTable()
        .row($(elem).parents('tr'))
        .remove()
        .draw();
      display_total_value_header_section();
    });
  });
})


attachment_list = $('#attachment-list').repeater({
  initEmpty: <?= isset($attachments) && count($attachments) > 0 ? 'false' : 'true' ?>,
  show: function () {
    var file_col = $(this).find('.attachment-filename-col')
    var attachment_link = file_col.find('.attachment-link')
    var attachment_file_id = file_col.find('.attachment-file-id')
    var attachment_file = file_col.find('.attachment-file')

    // if file already uploaded before, disallow to upload file
    if (attachment_file_id.val()) {
      attachment_file.attr('disabled', false).addClass('hidden')
      attachment_link.removeClass('hidden')
      attachment_file_id.attr('disabled', false)
    } else {
      attachment_file.attr('disabled', false).removeClass('hidden')
      attachment_link.addClass('hidden')
      attachment_file_id.attr('disabled', true)
    }
    $(this).slideDown();
  },
  hide: function (deleteElement) {
    swalConfirm('MSR Preparation', '<?= __('confirm_delete') ?>', function() {
      $(this).slideUp(deleteElement);
    });
  },
  isFirstItemUndeletable: false
});

//vertical TouchSpin
$(".touchspin-vertical").TouchSpin({
  verticalbuttons: true,
  verticalupclass: 'fa fa-angle-up',
  verticaldownclass: 'fa fa-angle-down',
  buttondown_class: "btn btn-primary",
  buttonup_class: "btn btn-primary",
});


$("#company").change(function () {
    var dt = $("#company").val();
    $.ajax({
        url: '<?= base_url('procurement/Msr/wh_code') ?>',
        dataType: 'json',
        type: 'get',
        data: { company : dt},
        success: function(res){
          // console.log(res.group);
          console.log(res[0].id_warehouse);
          id_warehouse = res[0].id_warehouse
          // alert(group+"."+sub_group+"."+subsub_group+"."+sequence_group+"."+res.indicator_group+"."+maxid);
          // console.log(group+"."+sub_group+"."+subsub_group+"."+sequence_group+"."+res.indicator_group+"."+maxid);
        }
      })

	$('#cost_center_slc2,#item-cost_center_slc2').select2();
	//$("#cost_center_slc2").select2({ dropdownCssClass: "slc2font" });
	//$("#item-cost_center_slc2").select2({ dropdownCssClass: "slc2font" });
	
    $('#cost_center').html('')
    $('#item-cost_center').html('')

    $.get('<?= base_url('procurement/msr/getCostCenters') ?>', {
      company: dt
    })
    .done(function(data) {
      if (data.length > 0) {
		$('#cost_center_slc2').empty();
		$('#cost_center_slc2').select2({
		  data: data
		});

		$('#item-cost_center_slc2').empty();
		$('#item-cost_center_slc2').select2({
		  data: data
		});
		
        var option = document.createElement('option');
        option.value = ''
        option.text = 'Please select'

        $('#cost_center').append(option)

        var option = document.createElement('option');
        option.value = ''
        option.text = 'Please select'

        $('#item-cost_center').append(option)

        data.map(function(v, k) {
          var option = document.createElement('option');
          option.value = v.id_costcenter
          option.text = v.id_costcenter + ' - ' + v.costcenter_desc

          if (last_costcenter && option.value == last_costcenter) {
              option.selected = true
          }
          else if (option.value == user_costcenter) {
              option.selected = true
          }

          $('#cost_center').append(option)
		  
		  $('#cost_center_slc2').val(last_costcenter); // Select the option with a value of '1'
		  $('#cost_center_slc2').trigger('change'); // Notify any JS components that the value changed
        })

        data.map(function(v, k) {
          var option = document.createElement('option');
          option.value = v.id_costcenter
          option.text = v.id_costcenter + ' - ' + v.costcenter_desc

          if (option.value == user_costcenter) {
              option.selected = true
          }

          $('#item-cost_center').append(option)
        })
      }
    })
    .fail(function(data) {
        // alert('Failed fetching cost center')
        swal('<?= __('warning') ?>','Failed fetching cost center','warning')
    })

});

function load_account_subsidiary() {
    var company_id = $("#company").val();
    var costcenter_id = $('#item-cost_center_slc2').val()

    $('#item-account_subsidiary').html('')

    $.get('<?= base_url('procurement/msr/getAccountSubsidiaries') ?>', {
        company_id : company_id,
        costcenter_id: costcenter_id
    })
    .done(function(data) {
      if (data.length > 0) {
        var option = document.createElement('option');
        option.value = ''
        option.text = 'Please select'

        $('#item-account_subsidiary').append(option)

        data.map(function(v, k) {
          var option = document.createElement('option');
          option.value = v.id_account_subsidiary
          option.text = v.id_account_subsidiary + ' - ' + v.account_subsidiary_desc

          $('#item-account_subsidiary').append(option)
        })
      }
    })
    .fail(function(data) {
      // alert('Failed fetching account subsidiaries')
      swal('<?= __('warning') ?>','Failed fetching account subsidiaries','warning')
    })
}

function select_material_label(item_type, itemtype_category) {
//  return itemTypeCategoryByParent[item_type][itemtype_category];

  var material_label = ''


  switch(itemtype_category.toUpperCase()) {
    case 'MATGROUP':
      material_label = 'Material Group'
      break
    case 'CONSULTATION':
      material_label = 'Consultation Category'
      break
    case 'WORKS':
      material_label = 'Works Category'
      break
    case 'SEMIC':
    default:
      material_label = 'Semic No'
      break
  }

  return material_label
}

$('#item-cost_center, #item-cost_center_slc2').change(function(e) {
    load_account_subsidiary();
})

$('#msr-development-item-modal').on('show.bs.modal', function(event) {
  // 0. clear form data
  // 1. select default value
  // 2. inititate material xhr request, based on itemtype
  var modal = $(event.target)
  modal.find('form')[0].reset();

  var item = new DefaultItemValue();
  item.setItemTypeFromMsrType($('#msr_type').val())

  var delivery_point = '';
  if (item.item_type == 'SERVICE' || item.item_type == 'CONSULTATION' ) {
    delivery_point = $('#location').val();
  } else if (item.item_type == 'GOODS' || item.item_type == 'BLANKET') {
    delivery_point = $('#delivery_point').val();
  }

  $("#item-itemtype_category").empty();
  $("#item-itemtype_category").append(new Option('Please select', ''))
  $.each(itemTypeCategoryByParent[item.item_type], function(id, text) {
    $('#item-itemtype_category').append(new Option(text, id))
  })


  var semic_no_name = $('#item-semic_no_name')
  var uom = $('#item-uom_name')
  var uom_service = $('#item-uom_name_service')

  $('#item-item_type').val(item.item_type)
  $('#item-itemtype_category').val(item.itemtype_category).trigger('change')
  $('#item-delivery_point').val(delivery_point)
  $('#item-material_id').select2('data', null)
  $('#item-material_id').val(null).trigger('change')
 
  $('#item-cost_center_slc2').val($('#cost_center_slc2').val()).trigger('change')

  $('#item-currency_value').val($('#currency').val())
  $('#item-currency_name').val($('#currency option:selected').text())
  $('#item-currency_name_total_value').val($('#item-currency_name').val())
  $('#item-cost_center').val($('#cost_center').val())
  $('#item-uom_name').val('')
  $('#item-uom_value').val('')
  $('#item-uom_name_service').val('')
  semic_no_name.val('')

  if (item.item_type == 'GOODS') {
    // semic_no_name.parents('.form-group').addClass('hidden')
    // semic_no_name.attr('type', 'hidden')
    semic_no_name.prop('readonly', true)
    uom.attr('readonly', true)
    uom.show();
    uom_service.hide();
    $('#item-importation').val($('#importation').val())
    $('#item-requestfor').val($('#requestfor').val())
    $('#item-inspection').val($('#inspection').val())
    $('#item-delivery_term').val($('#delivery_term').val())
    $('#item-freight').val($('#freight').val())

    $('#item-importation').parents('.form-group').removeClass('hidden')
    $('#item-delivery_point').parents('.form-group').removeClass('hidden')
    $('#item-qty_onhand').parents('.form-group').removeClass('hidden')
    $('#item-qty_ordered').parents('.form-group').removeClass('hidden')
    $(".item-item_modification_div").hide();
  } else {
    // semic_no_name.parents('.form-group').removeClass('hidden')
    // semic_no_name.attr('type', 'text')
    semic_no_name.prop('readonly', false)
    uom.attr('readonly', true)
    uom.hide();
    uom_service.show();
    $('#item-importation').val('')
    $('#item-requestfor').val('')
    $('#item-inspection').val('')
    $('#item-delivery_term').val('')
    $('#item-freight').val('')

    $('#item-importation').parents('.form-group').addClass('hidden')
    $('#item-delivery_point').parents('.form-group').addClass('hidden')
    $('#item-qty_onhand').parents('.form-group').addClass('hidden')
    $('#item-qty_ordered').parents('.form-group').addClass('hidden')
    $(".item-item_modification_div").show();
  }

  // pre-fetch account subsidiary
  load_account_subsidiary();
});

$('#msr-development-item-modal').on('hide.bs.modal', function(event) {
  // 0. validate input
  // 1. catch data, add to datagrid
  // 2. redraw the datagrid

  $(this).find('form')[0].reset()
});

$('#pmethod').change(function(e) {
    var pmethod = $(this).val().toUpperCase();

    var procure_processing_time = pmethods.find(function(elem, key) {
      return elem.ID_PMETHOD == pmethod;
    })

    $('#procure_processing_time').val(
      procure_processing_time == undefined ? '' : procure_processing_time.PROCESSING_TIME
    );
})

$('#item-item_type').change(function() {
  var itemtype = $('#item-item_type').val()
  //console.log("should fetch data")
  // 0. clear semic_no data

  // MSR - Tambah Inputan inventory type
  $("#item-inv_type").val("");
  $("#item-account_subsidiary").val("");
  $("#item-inv_type").prop("disabled", true);
  // MSR - Tambah Inputan inventory type


  $('#item-material_id').select2('data', null)
  $('#item-material_id').val('').trigger('change')

  $("#item-itemtype_category").empty();
  $("#item-itemtype_category").append(new Option('Please select', ''))
  $.each(itemTypeCategoryByParent[itemtype], function(id, text) {
    $('#item-itemtype_category').append(new Option(text, id))
  })

  // 1. clear description, qty_oh, qty_ordered, classification, group value
  $('#item-description_of_unit').val('');
  $('#item-semic_no_name').val('');
  $('#item-qty_onhand').val('')
  $('#item-uom_name_qty_onhand').val('')
  $('#item-qty_ordered').val('')
  $('#item-uom_name_qty_ordered').val('')
  $('#item-qty_required').val('')
  $('#item-uom_name').val('')
  $('#item-unit_price').val('')
  $('#item-total_value').val('')
  $('#item-group').val('')
  $('#item-subgroup').val('')
  $('#item-uom_name_service').val('')
  $('#item-uom_value').val('')

  // 2. show editable material description if itemtype are SERVICE, CONSULTATION, BLANKET, hide if GOODS
  // 3. set UoM to readonly if itemtype is GOODS else
  var semic_no_name = $('#item-semic_no_name')
  var uom = $('#item-uom_name')
  var uom_service = $('#item-uom_name_service')

  if (itemtype == 'GOODS') {
    // semic_no_name.parents('.form-group').addClass('hidden')
    semic_no_name.prop('readonly', true)
    uom.prop('readonly', true)
    uom.show();
    uom_service.hide();

    $(".item-item_modification_div").hide();
    $('#item-importation').parents('.form-group').removeClass('hidden')
    $('#item-delivery_point').parents('.form-group').removeClass('hidden')
    $('#item-qty_onhand').parents('.form-group').removeClass('hidden')
    $('#item-qty_ordered').parents('.form-group').removeClass('hidden')
  } else {
    // semic_no_name.parents('.form-group').removeClass('hidden')
    semic_no_name.prop('readonly', false)
    uom.prop('readonly', true)
    uom.hide();
    uom_service.show();

    $(".item-item_modification_div").show();

    $('#item-importation').parents('.form-group').addClass('hidden')
    $('#item-delivery_point').parents('.form-group').addClass('hidden')
    $('#item-qty_onhand').parents('.form-group').addClass('hidden')
    $('#item-qty_ordered').parents('.form-group').addClass('hidden')
  }
})

$('#item-itemtype_category').change(function(e) {
  var itemtype = $('#item-item_type').val()
  var itemtype_category = $(this).val()

  // MSR - Tambah Inputan inventory type
  $("#item-inv_type").val("");
  $("#item-account_subsidiary").val("");
  // MSR - Tambah Inputan inventory type


  $('#item-material_id').select2('data', null)
  $('#item-material_id').val('').trigger('change')
  $('#item-description_of_unit').val('');
  $('#item-semic_no_name').val('');
  $('#item-qty_onhand').val('')
  $('#item-uom_name_qty_onhand').val('')
  $('#item-qty_ordered').val('')
  $('#item-uom_name_qty_ordered').val('')
  $('#item-qty_required').val('')
  $('#item-uom_name').val('')
  $('#item-unit_price').val('')
  $('#item-total_value').val('')
  $('#item-group').val('')
  $('#item-subgroup').val('')
  $('#item-uom_name_service').val('')
  $('#item-uom_value').val('')

  var semic_no_name = $('#item-semic_no_name')
  var uom = $('#item-uom_name')
  var uom_service = $('#item-uom_name_service')
  var uom_options = [];


  if (itemtype_category == 'SEMIC') {
    // semic_no_name.parents('.form-group').addClass('hidden')
    semic_no_name.prop('readonly', true)
    uom.prop('readonly', true)
    uom.show();
    uom_service.hide();

    $('#item-importation').parents('.form-group').removeClass('hidden')
    $('#item-delivery_point').parents('.form-group').removeClass('hidden')
    $('#item-qty_onhand').parents('.form-group').removeClass('hidden')
    $('#item-qty_ordered').parents('.form-group').removeClass('hidden')
    $('#item-is_asset').attr('readonly', false).prop('checked', false).unbind('click')
  } else {
    // semic_no_name.parents('.form-group').removeClass('hidden')
    semic_no_name.prop('readonly', false)
    uom.prop('readonly', true)
    uom.hide();
    uom_service.show();

    var use_uom_type = [];
    if (itemtype_category == 'MATGROUP') {
        use_uom_type = [1, 2]
    } else if (itemtype_category != '') {
        use_uom_type = [2]
    }

    use_uom_type.forEach(function(type) {
      if (uoms[type]) {
        $.each(uoms[type], function(k, uom) {
          uom_options[k] = uom_name_format(uom.MATERIAL_UOM, uom.DESCRIPTION)
        })
      }
    })

    create_select_option(uom_service, 'Select', uom_options);

    $('#item-importation').parents('.form-group').addClass('hidden')
    $('#item-delivery_point').parents('.form-group').addClass('hidden')
    $('#item-qty_onhand').parents('.form-group').addClass('hidden')
    $('#item-qty_ordered').parents('.form-group').addClass('hidden')
    $('#item-is_asset').attr('readonly', true).prop('checked', false)
      .bind('click', function() { return false })
  }

  material_label = select_material_label(itemtype, itemtype_category)
  $('#item-material_label').text(material_label)

  // MSR - Tambah Inputan inventory type
  var i_type = $("#item-item_type").val();
  var i_typecategory = $("#item-itemtype_category").val();
  if (i_type == 'GOODS' && i_typecategory == 'SEMIC') {
    $("#item-inv_type").prop("disabled", false);
  } else {
    $("#item-inv_type").prop("disabled", true);
  }
  // MSR - Tambah Inputan inventory type

})

$('#item-material_id').select2({
  // since select2 version 4, dropdownParent property must be defined to show up at modal
  // @see https://stackoverflow.com/questions/18487056/select2-doesnt-work-when-embedded-in-a-bootstrap-modal/33884094#33884094
  dropdownParent: $("#msr-development-item-modal"),
  minimumInputLength: 1,
  escapeMarkup: function(markup) {
    return markup
  },
  ajax: {
    url: "<?php echo base_url() . '/procurement/msr/findItem' ?>",
    dataType: 'json',
    cache: true,
    data: function(params) {
      var query = {
        query: params.term,
        type: $('#item-item_type').val(),
        itemtype_category: $('#item-itemtype_category').val(),
        id_company: $('#company').val()
      }

      return query
    },
    marker: function(marker) {
      return marker;
    },
    processResults: function (data) {
      var items = data.map(function(r) {
        return {
          "id": r.id,
          "text": r.semic_no + ' - ' + r.name,
          "semic_no": r.semic_no,
          "name": r.name
        }
      });

      return {
        results: items
      };
    },
    templateResult: function(row) {
      return "<div class=\"select2-result-repository clearfix\">"
      + "<div class=\"select2-result-repository__title\">"+ row.name +"</div>"
      + "<div class=\"select2-result-repository__description\">"+ row.semic_no +"</div>"
      + "</div>";
    },
    templateSelection: function(row) {
        console.log(row);
        return row.semic_no
    }
  }
})
.on('select2:select', function(e,d,c) {
  console.log(e,d,c)
  // var material = split_semic($('#item-material_id option:selected').text())
  var selected_material = $('#item-material_id').select2('data')[0]
  var material = {
    semic_no: selected_material.semic_no,
    description: selected_material.name
  }

  semic_no_global = material.semic_no
  console.log(material.semic_no);
  $('#item-semic_no_value').val(material.semic_no)

  if ($('#item-itemtype_category').val() != 'SEMIC') {
    material.description = ''
  }

  $('#item-semic_no_name').val(material.description.trim())

  $.ajax({
        url: '<?= base_url('procurement/Msr/requestJDEQtyonHand') ?>',
        dataType: 'json',
        type: 'get',
        data: { wh : id_warehouse , semic_no : semic_no_global },
        success: function(res){
          console.log(res.qty_onhand);
          console.log(res.qty_onorder);
          $('#item-qty_onhand').val(res.qty_onhand);
          $('#item-qty_ordered').val(res.qty_onorder);
          // console.log(res.group);
          // alert(group+"."+sub_group+"."+subsub_group+"."+sequence_group+"."+res.indicator_group+"."+maxid);
          // console.log(group+"."+sub_group+"."+subsub_group+"."+sequence_group+"."+res.indicator_group+"."+maxid);
        }
      })

  // 0. fetch additional item data from server
  console.log('fetch additional selected item data')
  $.get('<?= base_url()."/procurement/msr/findItemAttributes" ?>', {
    material_id : $(this).val(),
    type: $('#item-item_type').val().trim(),
    itemtype_category: $('#item-itemtype_category').val().trim()
  }, function(data) {
    if (data.group_code) {
      $('#item-group').val(data.group_code + '. ' + data.group_name)
      $('#item-group_value').val(data.group_code)
      $('#item-group_name').val(data.group_name)
      $('#item-subgroup').val(data.subgroup_code + '. ' + data.subgroup_name)
      $('#item-subgroup_value').val(data.subgroup_code)
      $('#item-subgroup_name').val(data.subgroup_name)
      //$('#item-qty_onhand').val(data.qty_onhand)
      //$('#item-qty_ordered').val(data.qty_ordered)
      $('#item-uom_name').val(uom_name_format(data.uom_name, data.uom_description))
      $('#item-uom_name').data('name', data.uom_name)
      $('#item-uom_name').data('description', data.uom_description)
      $('#item-uom_value').val(data.uom_id)
      $('#item-uom_name_qty_ordered').val(data.uom_name)
      $('#item-uom_name_qty_onhand').val(data.uom_name)


      var itemtype_category = $('#item-itemtype_category').val()
      if (['WORKS', 'CONSULTATION', 'MATGROUP'].indexOf(itemtype_category) != -1) {
        $('#item-semic_no_name').focus()
      }

    }
  })
  .fail(function(error) {
    swal('<?= __('warning') ?>','Cannot fetch material attributes. Please try again in few moments','warning')
    console.error(error)
  })
})

function uom_name_format(name, description)
{
    return name + ' - ' + description;
}

function uom_name_parse(text)
{
  var out = text.split(' - ');

  return {
    name: out.shift(),
    description: out.join(' - ')
  }
}


$('#item-add').click(function() {
	console.log('item-add');
  var modal = $('#msr-development-item-modal')

  if (!validate_msr_item(modal.find('form')[0])) {
    return false;
  }

  var total_amount = 0
  var total_tax = 0
  var total_amount_with_tax = 0

  var selected_material = $('#item-material_id').select2('data')[0]
  var material = {
    semic_no: selected_material.semic_no,
    description: selected_material.name
  }

  var index = Math.floor(Math.random() * 10) + Date.now();
  var item_namespace = 'items['+index+']'

  var item_type_value = $('#item-item_type').val()
  var item_type_name = $('#item-item_type option:selected').text()
  var itemtype_category_value = $('#item-itemtype_category').val()
  var itemtype_category_name = $('#item-itemtype_category option:selected').text()
  var material_id = $('#item-material_id').val()
  // var material = split_semic($('#item-material_id option:selected').text())
  var group_value = $('#item-group_value').val()
  var group_name = $('#item-group_name').val()
  var subgroup_value = $('#item-subgroup_value').val()
  var subgroup_name = $('#item-subgroup_name').val()
  var qty_ordered_value = accounting.parse($('#item-qty_ordered').val())
  var qty_onhand_value = accounting.parse($('#item-qty_onhand').val())
  var qty_required_value = accounting.parse($('#item-qty_required').val())
  var _uom, uom_name = '', uom_id = '', uom_description = ''
  if (itemtype_category_value == 'SEMIC') {
    uom_value = $('#item-uom_value').val()
    if (uom_value) {
      _uom = uom_name_parse($('#item-uom_name').val())
      uom_name = _uom.name
      uom_description = _uom.description
    }
  } else {
    uom_value = $('#item-uom_name_service').val()
    if (uom_value) {
      _uom = uom_name_parse($('#item-uom_name_service option:selected').text())
      uom_name = _uom.name
      uom_description = _uom.description
    }
  }

  var unit_price_value = accounting.parse($('#item-unit_price').val());
  var total_value_value = accounting.parse($('#item-total_value').val());

  var currency_value = $('#item-currency_value').val();
  var currency_name = $('#item-currency_name').val();

  var importation_value = $('#item-importation').val() ? $('#item-importation').val() : ''
  var importation_name = importation_value ? $('#item-importation option:selected').text() : '';

  var delivery_point_value = $('#item-delivery_point').val() ? $('#item-delivery_point').val() : ''
  var delivery_point_name = delivery_point_value ? $('#item-delivery_point option:selected').text() : '';

  var cost_center_value = $('#item-cost_center').val() ? $('#item-cost_center').val() : ''
  var cost_center_name = ''
  if (cost_center_value) {
    cost_center_name = $('#item-cost_center option:selected').text()
    cost_center_name = cost_center_name.split(' - ')
    cost_center_name.shift()
    cost_center_name = cost_center_name.join(' - ')
  }
  
  //replace costcenter
  var cost_center_value = $('#item-cost_center_slc2').val() ? $('#item-cost_center_slc2').val() : ''
  var cost_center_name = ''
  if (cost_center_value) {
    cost_center_name = $('#item-cost_center_slc2 option:selected').text()
    cost_center_name = cost_center_name.split(' - ')
    cost_center_name.shift()
    cost_center_name = cost_center_name.join(' - ')
  }

  var account_subsidiary_value = $('#item-account_subsidiary').val() ? $('#item-account_subsidiary').val() : ''
  var account_subsidiary_name = ''
  if (account_subsidiary_value) {
    account_subsidiary_name = $('#item-account_subsidiary option:selected').text()
    account_subsidiary_name = account_subsidiary_name.split(' - ')
    account_subsidiary_name.shift()
    account_subsidiary_name = account_subsidiary_name.join(' - ')
  }

  var is_asset_value = $('#item-is_asset').is(':checked') ? 1 : 0;
  var is_asset_name = is_asset_value == 1 ? 'Yes': 'No';

  var item_modification_value = $('#item-item_modification').is(':checked') ? 1 : 0;
  var item_modification_name = item_modification_value == 1 ? 'Yes': 'No';

  var inv_type_value = $('#item-inv_type').val() ? $('#item-inv_type').val() : ''
  var inv_type_name = ''
  if (inv_type_value) {
    inv_type_name = $('#item-inv_type option:selected').text()
  }

  if (['WORKS', 'CONSULTATION', 'MATGROUP'].indexOf(itemtype_category_value) != -1) {
    material.description = $('#item-semic_no_name').val()
  }


  msr_development_detail_list.row.add({
    "id": index,

    "item_type": modal.find('#item-item_type option:selected').text()
      + hidden_input(item_namespace + '[item_type_value]', item_type_value)
      + hidden_input(item_namespace + '[item_type_name]', item_type_name)
      + hidden_input(item_namespace + '[itemtype_category_value]', itemtype_category_value)
      + hidden_input(item_namespace + '[itemtype_category_name]', itemtype_category_name),

    "itemtype_category": itemtype_category_name
      + hidden_input(item_namespace + '[itemtype_category_value]', itemtype_category_value)
      + hidden_input(item_namespace + '[itemtype_category_name]', itemtype_category_name),

    "semic_no": material.semic_no
      + hidden_input(item_namespace + '[material_id]', material_id)
      + hidden_input(item_namespace + '[semic_no_value]', material.semic_no),

    "description_of_unit": material.description
      + hidden_input(item_namespace + '[semic_no_name]', material.description),

    "group": modal.find('#item-group').val()
      + hidden_input(item_namespace + '[group_value]', group_value)
      + hidden_input(item_namespace + '[group_name]', group_name),

    "subgroup": modal.find('#item-subgroup').val()
      + hidden_input(item_namespace + '[subgroup_value]', subgroup_value)
      + hidden_input(item_namespace + '[subgroup_name]', subgroup_name),

    "qty_required": modal.find('#item-qty_required').val()
      + hidden_input(item_namespace + '[qty_required_value]', qty_required_value),

    "qty_onhand": accounting.format(qty_onhand_value)
      + hidden_input(item_namespace + '[qty_onhand_value]', qty_onhand_value),

    "qty_ordered": accounting.format(qty_ordered_value)
      + hidden_input(item_namespace + '[qty_ordered_value]', qty_ordered_value),

    "uom": uom_name_format(uom_name, uom_description)
      + hidden_input(item_namespace + '[uom_name]', uom_name)
      + hidden_input(item_namespace + '[uom_value]', uom_value)
      + hidden_input(item_namespace + '[uom_description]', uom_description),

    "unit_price": accounting.format(unit_price_value)
      + hidden_input(item_namespace + '[unit_price_value]', unit_price_value),

    "total_value": accounting.format(total_value_value)
      + hidden_input(item_namespace + '[total_value]', total_value_value),

    "currency": currency_name
      + hidden_input(item_namespace + '[currency_value]', currency_value)
      + hidden_input(item_namespace + '[currency_name]', currency_name),

    "importation": importation_name
      + hidden_input(item_namespace + '[importation_value]', importation_value)
      + hidden_input(item_namespace + '[importation_name]', importation_name),

    "delivery_point": delivery_point_name
      + hidden_input(item_namespace + '[delivery_point_value]', delivery_point_value)
      + hidden_input(item_namespace + '[delivery_point_name]', delivery_point_name),

    "cost_center": cost_center_name
      + hidden_input(item_namespace + '[cost_center_value]', cost_center_value)
      + hidden_input(item_namespace + '[cost_center_name]', cost_center_name),

    "account_subsidiary": account_subsidiary_value+" - "+account_subsidiary_name
      + hidden_input(item_namespace + '[account_subsidiary_value]', account_subsidiary_value)
      + hidden_input(item_namespace + '[account_subsidiary_name]', account_subsidiary_name),

    /*"is_asset": is_asset_name
      + hidden_input(item_namespace + '[is_asset]', is_asset_value),*/

    "inv_type": inv_type_name
      + hidden_input(item_namespace + '[inv_type_value]', inv_type_value)
      + hidden_input(item_namespace + '[inv_type_name]', inv_type_name),

    "item_modification": item_modification_name
      + hidden_input(item_namespace + '[item_modification_value]', item_modification_value),

    "action": ""
  }).draw()

  display_total_value_header_section()

  modal.modal('hide')
})

$('#item-qty_required').change(function(e) {
  var qty_required = $(this).val()
  var unit_price = $('#item-unit_price').val()
 var total_value = calculate_item_total_value(
    accounting.parse(qty_required),
    accounting.parse(unit_price)
    )

  var f_qty_required = accounting.format(qty_required)
  var f_total_value = accounting.format(total_value)

  //$(this).val(f_qty_required)
  $('#item-total_value').val(f_total_value)
})

$('#item-unit_price').change(function(e) {
  var unit_price = $(this).val();
  var qty_required = $('#item-qty_required').val()
  var total_value = calculate_item_total_value(
    accounting.parse(qty_required),
    accounting.parse(unit_price)
    )

  var f_unit_price= accounting.format(unit_price)
  var f_total_value = accounting.format(total_value)

  $(this).val(f_unit_price)
  $('#item-total_value').val(f_total_value)
})

$('#item-total_value').change(function(e) {
    var formatted = accounting.format($(this).val())
    $(this).val(formatted)
})

function calculate_item_total_value(qty, unit_price) {
  return parseFloat(qty) * parseFloat(unit_price)
}

function hidden_input(name, value) {
  var input = document.createElement('input')
  input.type = "hidden"
  input.name = name
  input.value = value

  return input.outerHTML

  return "<input type=\"hidden\" name=\""+name+"\" value=\""+value+"\">";
}

function check_exchange_rate(currency_code)
{
//    return exchange_rate(currency_code, base_currency.code, 1) != 0;
    var status = false;
    $.ajax({
      url: '<?= base_url('procurement/msr/checkExchangeRate') ?>',
      data: {
        currency: $('#currency').val()
      },
      async: false,
      method: 'GET',
    })
    .done(function(data) {
        status = data.exchange_rate_status;
        set_exchange_rate(data.from_currency_code, data.base_currency_code, data.message);
    })

    return status;
}

$('.item-btn-action').click(function(e) {
  console.log('should delete this row')
  console.log(e)
})

$('#title').keyup(function(){
  // $('#msr_title').html($('#title').val());
  var s = $("#title").val();
  var x = s.search('>')
  var y = s.search('<')
  var z = s.search('&')

  if(x == -1 && y == -1 && z == -1)
  {
    $('#msr_title').html(s)
    return true
  }
  else
  {
    var n = s.replace('<','')
    n = n.replace('>','')
    n = n.replace('&','')

    $("#title").val(n)
  }
})
.keyup()
.change(function() {
  $(this).keyup()
})
.blur(function() {
  $(this).keyup()
})

$('#currency').change(function() {
  var currency_id = $(this).val();
  var item_table = $('#msr-development-detail-list').DataTable()

  if (item_table.data().length > 0) {
    var cell = $(item_table.row(0).column(11).nodes()).html()
    var item_currency_id = $.parseHTML(cell)[1].value

    $(this).val(item_currency_id)

    // alert('Currency change is not permitted because there are items already added')
    swal('<?= __('warning') ?>','Currency change is not permitted because there are items already added','warning')
    return false
  }

  if (!check_exchange_rate(currency_id)) {
    // alert('Exchange rate from '+ currency_abbr[currency_id] +' to ' + base_currency.code +' not maintained yet');
    swal('<?= __('warning') ?>','Exchange rate from '+ currency_abbr[currency_id] +' to ' + base_currency.code +' not maintained yet','warning')
    return false;
  }
})

$('#item-itemtype').change(function(e) {
  var item_type = $(this).val();

  $("#item-itemtype_category").empty();
  $("#item-itemtype_category").append(new Option('Please select', ''))
  $.each(itemTypeCategoryByParent[item_type], function(id, text) {
    $('#item-itemtype_category').append(new Option(text, id))
  })
})

if ($('#company').val() != '') {
  $('#company').change();
}

<?php if (!empty($posts) && count($posts['items']) > 0): ?>

<?php
$ready_items = [];
foreach ($posts['items'] as $i => $item) {
  $item_namespace = "items[$i]";

  $ready_items[] = array(
    "no" => $i + 1,
    "item_type" => $item['item_type_name']
      . hidden_input($item_namespace . '[item_type_value]', $item['item_type_value'])
      . hidden_input($item_namespace . '[item_type_name]', $item['item_type_name'])
      . hidden_input($item_namespace . '[itemtype_category_value]', @$item['itemtype_category'])
      . hidden_input($item_namespace . '[itemtype_category_name]', @$item['itemtype_category_name']),

    "itemtype_category" => @$item['itemtype_category_name']
      . hidden_input($item_namespace . '[itemtype_category_value]', @$item['itemtype_category'])
      . hidden_input($item_namespace . '[itemtype_category_name]', @$item['itemtype_category_name']),

    "semic_no" => $item['semic_no_value']
        . hidden_input($item_namespace . '[material_id]', $item['material_id'])
        . hidden_input($item_namespace . '[semic_no_value]', $item['semic_no_value']),

    "description_of_unit" => $item['semic_no_name']
      . hidden_input($item_namespace . '[semic_no_name]', $item['semic_no_name']),

    "group" => $item['group_value'].'. '.$item['group_name']
      . hidden_input($item_namespace . '[group_value]', $item['group_value'])
      . hidden_input($item_namespace . '[group_name]', $item['group_name']),
    "group_value" => '',

    "subgroup" => $item['subgroup_value'].'. '.$item['subgroup_name']
      . hidden_input($item_namespace . '[subgroup_value]', $item['subgroup_value'])
      . hidden_input($item_namespace . '[subgroup_name]', $item['subgroup_name']),
    "subgroup_value" => '',

    "qty_required" => numEng($item['qty_required_value'])
      . hidden_input($item_namespace . '[qty_required_value]', $item['qty_required_value']),

    "qty_onhand" => numEng(@$item['qty_onhand_value'])
      . hidden_input($item_namespace . '[qty_onhand_value]', $item['qty_onhand_value']),

    "qty_ordered" => numEng(@$item['qty_ordered_value']) // data from somewhere
      . hidden_input($item_namespace . '[qty_ordered_value]', $item['qty_ordered_value']),

    "uom" => $item['uom_name'].' - '.$item['uom_description']
      . hidden_input($item_namespace . '[uom_value]', $item['uom_value'])
      . hidden_input($item_namespace . '[uom_name]', $item['uom_name'])
      . hidden_input($item_namespace . '[uom_description]', $item['uom_description']),

    "uom_value" => $item['uom_value'],

    "unit_price" => numEng($item['unit_price_value'])
        . hidden_input($item_namespace . '[unit_price_value]', $item['unit_price_value']),
    "unit_price_value" => $item['unit_price_value'],

    "total_value" => numEng($item['total_value'])
        . hidden_input($item_namespace . '[total_value]', $item['total_value']),

    "currency" => $item['currency_name']
        . hidden_input($item_namespace . '[currency_value]', $item['currency_value'])
        . hidden_input($item_namespace . '[currency_name]', $item['currency_name']),

    "importation" => $item['importation_name']
        . hidden_input($item_namespace . '[importation_value]', $item['importation_value'])
        . hidden_input($item_namespace . '[importation_name]', $item['importation_name']),

    "delivery_point" => $item['delivery_point_name']
        . hidden_input($item_namespace . '[delivery_point_value]', $item['delivery_point_value'])
        . hidden_input($item_namespace . '[delivery_point_name]', $item['delivery_point_name']),

    "cost_center" => $item['cost_center_value'].' - '.$item['cost_center_name']
        . hidden_input($item_namespace . '[cost_center_value]', $item['cost_center_value'])
        . hidden_input($item_namespace . '[cost_center_name]', $item['cost_center_name']),

    "account_subsidiary" => $item['account_subsidiary_value'].' - '.$item['account_subsidiary_name']
        . hidden_input($item_namespace . '[account_subsidiary_value]', $item['account_subsidiary_value'])
        . hidden_input($item_namespace . '[account_subsidiary_name]', $item['account_subsidiary_name']),

    "is_asset" => $item['is_asset'] == 1 ? 'yes': 'no'
        . hidden_input($item_namespace . '[is_asset]', $item['is_asset']),

    "inv_type" => $item['inv_type_name']
        . hidden_input($item_namespace . '[inv_type_value]', $item['inv_type_value'])
        . hidden_input($item_namespace . '[inv_type_name]', $item['inv_type_name']),

    "item_modification" => $item['item_modification'] == 1 ? 'Yes': 'No'
        . hidden_input($item_namespace . '[item_modification]', $item['item_modification']),
    "action" => ""
  );
}
?>

msr_development_detail_list.rows.add(<?php echo json_encode($ready_items ?: [])  ?>).columns.adjust().draw();
<?php endif; ?>

<?php if (!$is_writable): ?>
$('input, select, textarea').attr('disabled', true)
<?php endif; ?>

$('#required_date').datetimepicker({format : 'YYYY-MM-DD'})
<?php if (set_value('required_date')): ?>
$('#required_date').val('<?= set_value('required_date') ?>');
<?php endif; ?>

$('#pmethod').change();

$('#save-as-draft').click(function(e) {
  var form = $('#msr-development-form')
//  var action_url = '<?= base_url('procurement/msr/saveDraft') ?>'
  //machrus
  var action_url = '<?= base_url('procurement/msr/saveDraftV1') ?>'
  var data = new FormData(form[0])
  var btn = this

  start($(btn).parents('.content-body'))
  $.ajax({
    method: "POST",
    url: action_url,
    contentType: false,
    processData: false,
    data: data
  })
  .done(function(data) {
    if (data.message.status == 'OK') {
      // set ID of draft
      $('#draft_id').val(data.draft_id)

      // toastr.success(data.message.text + ' #' + data.draft_id)
      swal('<?= __('success') ?>', '<?= __('success_submit') ?>','success')
      return true
    }

    // toastr.error(data.message.text)
    swal('<?= __('warning') ?>', '<?= __('success_submit') ?>','warning')
    return false
  })
  .fail(function() {
    // toastr.error(data.message.text ? data.message.text : 'Unknown error')
    swal('<?= __('warning') ?>',data.message.text ? data.message.text : 'Unknown error','warning')
  })
  .always(function() {
    stop($(btn).parents('.content-body'))
  })

})


$('#master_list').change(function(e) {
  display_total_value_header_section()
})

display_total_value_header_section()
$('#master_list').change()

//var attachments = "<?php echo json_encode($attachments)?>";
$.each(<?php echo json_encode($attachments)?>, function(i, attachment) {
	add_attachment(attachment.tipe, attachment.file_name, attachment.file_path, Localization.humanDatetime(attachment.created_at), attachment.created_by_name);
});

// end document ready
});

function load_aas_approver_modal() {
  var company_id = $('#company').val()
  var currency_id = $('#currency').val()
  var amount = get_total_msr_amount_from_detail_item();
  var base_currency = '<?= base_currency_code() ?>'

  //amount = amount + get_tax_amount_from_total(amount)
  console.log(company_id, currency_id, amount);

  /*
  $('#second-aas-approver-id').select2('data', null)
  $('#second-aas-approver-id').val('').trigger('change')
  */
  $("#second-aas-approver-id").html('')
  $('#first-aas-approver').val('')
  $('#aas_total_amount').text('')
  // $('#aas_msr_total_amount').text('')
  $('#first-aas-approver').data('user_role', '').data('parent_id', '')
  $('#second-aas-approver-id').prop('disabled', false)

  // --------------  Second AAS Approver ----------------
  $.get('<?= base_url('procurement/msr/getAasApprover/') ?>', {
    company_id: company_id,
    currency_id: currency_id,
    amount: amount,
  })
  .done(function(data) {
    // FIXME: too many dom manipulations :(

    var amount = 0;
    var msr_amount = 0;
    if (data.amount) {
        amount = data.amount;
        msr_amount = data.msr_amount;
    }

    // $('#aas_msr_total_amount').text(accounting.formatMoney(msr_amount, { format: '%s %v', symbol: data.msr_currency_name }));
    // $('#aas_total_amount').text('(' + accounting.formatMoney(amount, { format: '%s %v', symbol: data.base_currency }) + ')');
    $('#aas_total_amount').html(
      display_multi_currency_format(msr_amount, data.msr_currency_name, amount, data.base_currency)
    )

    /*
    if (data.base_currency_id == data.msr_currency_id) {
      $('#aas_total_amount').hide();
    } else {
      $('#aas_total_amount').show();
    }
    */

    if (data.first_aas) {
       $('#first-aas-approver').data('user_role', data.first_aas.user_role)
            .data('parent_id', data.first_aas.parent_id)
       $('#first-aas-approver').val(data.first_aas.NAME ? data.first_aas.NAME : '')

       // if (data.first_aas.user_role == 1 && data.first_aas.parent_id == 0) {
       //    $('#second-aas-approver-id').prop('disabled', true)
       // }
    }

    var nominals, f_nominals;
    var options, r_options;

    nominals, f_nominals = 0;
    r_options = []; options = [];

    options.push({
        id: '',
        text: '',
        name: '',
      })

    if (data.second_aas) {
      nominals = data.second_aas.map(function(v) {
          return v.nominal
      })

      f_nominals = accounting.formatColumn(nominals, { symbol: data.base_currency })

      r_options = data.second_aas.map(function(v, k) {
        return {
          id: v.user_id,
          t_jabatan_id: v.id,
          user_id: v.user_id,
          text: v.NAME,
          name: v.NAME,
          position: v.position,
          title: v.title,
          nominal: v.nominal,
          operand: v.operand,
          f_nominal: f_nominals[k],
          currency: data.base_currency
        }
      })
    }

    options = options.concat(r_options)

    $('#second-aas-approver-id').select2({
        data: options,
        placeholder: 'Please select',
        escapeMarkup: function(markup) {
          return markup
        },
        templateResult: function(v) {
           if (v.loading) {
             return v.text
           }

           if (v.id == '') {
             return v.text
           }

           var operand = v.parent_id == 0 && v.user_role == 1 ? v.operand : ' ';
           var markup  = '<div class="row">'
             + '<div class="col-md-4">' + v.text + '</div>'
             + '<div class="col-md-4">' + v.title + '</div>'
             + '<div class="col-md-4" style="text-align: right">' + operand + ' ' + v.f_nominal + '</div>'
             + '</div>'

           return markup
        },
        templateSelection: function(v) {
          return v.text
        }
    })
  })
  .fail(function(data){
    swal('<?= __('warning') ?>','Cannot get AAS second approver list','warning')
  })

  $('#msr-development-approval-user').modal('show')
}

function submit_msr() {
    var form = $("#msr-development-form");
    form.validate().settings.ignore = ":disabled";
    if (form.valid()){
      $('#required-warning').attr('hidden', 'hidden');
    }
    else {
      $('#required-warning').removeAttr('hidden');
      return false;
    }

    // Block MSR creation for procurement location other than 'PG01' (Head Office Procurement)
    var plocation = $('#plocation').val()
    if (plocation != '' && plocation != 'PG01') {
      swal('<?= __('warning') ?>','Creation MSR with Procurement Location ' + $('#plocation option:selected').text() + " is disallowed",'warning')
      return false
    }


    $('#item-table-alert').hide()
    // cek datatable $('#msr-development-detail-list').DataTable() harus minimal 1 item
    var msr_development_detail_list = $('#msr-development-detail-list')
    if (msr_development_detail_list.data().length == 0) {
      $('#item-table-alert').text('Please add at least an item').show()
      return false;
    }

    if (!validate_attachment()) {
      return false;
    }

    if (!check_budget_holder()) {
      swal('<?= __('warning') ?>','Budget holder are not set yet','warning')
      return false;
    }

    load_aas_approver_modal();

    return true;
}




set_value('cost_center')
</script>

<?php /* vim: set fen foldmethod=indent ts=2 sw=2 tw=0 et autoindent :*/ ?>
