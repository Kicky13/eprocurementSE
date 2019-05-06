<?php
function hidden_input($name, $value) {
  return "<input type=\"hidden\" name=\"" . $name ."\" value=\"" . $value . "\">";
}

$id_msr_type = set_value('id_msr_type');

$base_currency_code = base_currency_code();
$currency_desc = set_value('currency_desc');
$include_tax = $this->input->post_get('master_list') ? false : true; // TODO: set out there

$total_amount = set_value('total_amount');
$total_tax = calculate_vat_amount($total_amount, $include_tax);
$total_amount_with_tax = $total_amount + $total_tax;

$total_amount_base = set_value('total_amount_base');
$total_tax_base = calculate_vat_amount($total_amount_base, $include_tax);
$total_amount_with_tax_base = $total_amount_base + $total_tax_base;

$total_amount_text = display_multi_line_currency_format(
  numEng($total_amount),
  $currency_desc,
  numEng($total_amount_base),
  $base_currency_code
);

$total_tax_text = display_multi_line_currency_format(
  numEng($total_tax),
  $currency_desc,
  numEng($total_tax_base),
  $base_currency_code
);

$total_amount_with_tax_text = display_multi_line_currency_format(
  numEng($total_amount_with_tax),
  $currency_desc,
  numEng($total_amount_with_tax_base),
  $base_currency_code
);

$ready_items = [];

if (!empty($_POST['items']) && count($_POST['items']) > 0):
  foreach ($_POST['items'] as $i => $item) {
    $item_namespace = "items[$i]";

    $ready_items[] = array(

      "item_type" => @$opt_itemtype[$item->id_itemtype]
        . hidden_input($item_namespace . '[msr_no]', (!empty($_POST['msr_no']) ?  $_POST['msr_no'] :  ""))
        . hidden_input($item_namespace . '[item_type_value]', $item->id_itemtype)
        . hidden_input($item_namespace . '[item_type_name]', @$opt_itemtype[$item->id_itemtype])
        . hidden_input($item_namespace . '[itemtype_category_value]', @$item->itemtype_category)
        . hidden_input($item_namespace . '[itemtype_category_name]', @$item->itemtype_category_name),

      "semic_no" => $item->semic_no
          . hidden_input($item_namespace . '[material_id]', $item->material_id)
          . hidden_input($item_namespace . '[semic_no_value]', $item->semic_no),

      "description_of_unit" => $item->description
        . hidden_input($item_namespace . '[semic_no_name]', $item->description),

      "group" => $item->groupcat.'. '.$item->groupcat_desc
        . hidden_input($item_namespace . '[group_value]', $item->groupcat)
        . hidden_input($item_namespace . '[group_name]', $item->groupcat_desc),

      "subgroup" => $item->sub_groupcat.'. '.$item->sub_groupcat_desc
        . hidden_input($item_namespace . '[subgroup_value]', $item->sub_groupcat)
        . hidden_input($item_namespace . '[subgroup_name]', $item->sub_groupcat_desc),

      "qty_required" => numEng($item->qty)
        . hidden_input($item_namespace . '[qty_required_value]', $item->qty),

      "qty_onhand" => numEng(0), // data from somewhere
      "qty_ordered" => numEng(0), // data from somewhere

      "uom" => $item->uom.' - '.$item->uom_description
        . hidden_input($item_namespace . '[uom_value]', $item->uom_id)
        . hidden_input($item_namespace . '[uom_name]', $item->uom)
        . hidden_input($item_namespace . '[uom_description]', $item->uom_description),

      "unit_price" => numEng($item->priceunit)
          . hidden_input($item_namespace . '[unit_price_value]', $item->priceunit),

      "total_value" => numEng($item->qty * $item->priceunit)
          . hidden_input($item_namespace . '[total_value]', $item->qty * $item->priceunit),

      "currency" => set_value('currency_desc')
          . hidden_input($item_namespace . '[currency_value]', set_value('id_currency'))
          . hidden_input($item_namespace . '[currency_name]', set_value('currency_desc')),

      "importation" => $item->importation_desc
          . hidden_input($item_namespace . '[importation_value]', $item->id_importation)
          . hidden_input($item_namespace . '[importation_name]', $item->importation_desc),

      "delivery_point" => $item->dpoint_desc
          . hidden_input($item_namespace . '[delivery_point_value]', $item->id_dpoint)
          . hidden_input($item_namespace . '[delivery_point_name]', $item->dpoint_desc),

      "cost_center" => $item->costcenter_desc
          . hidden_input($item_namespace . '[cost_center_value]', $item->id_costcenter)
          . hidden_input($item_namespace . '[cost_center_name]', $item->costcenter_desc),

      "account_subsidiary" => $item->id_accsub.' - '.$item->accsub_desc
          . hidden_input($item_namespace . '[account_subsidiary_value]', $item->id_accsub)
          . hidden_input($item_namespace . '[account_subsidiary_name]', $item->accsub_desc),

      "inv_type" => @$opt_msr_inventory_type[$item->inv_type]
          . hidden_input($item_namespace . '[inv_type]', $item->inv_type),

      "item_modification" => ($item->item_modification == '1' ? 'Yes' : 'No')
          . hidden_input($item_namespace . '[item_modification]', $item->item_modification),

      "action" => ""
    );
  }
endif;

?>
<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<?php /* page specific */ ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
<!--<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">-->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<style>
.msr-development-detail-list-table, .msr-development-budget-table {
margin-bottom: 20px;
margin-top: 5px;
}
body {
font-family: "Open Sans", sans-serif;
font-size: 14px;
font-weight: normal;
}
</style>

<div class="app-content content">
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
      <h3 class="content-header-title"><?= lang("MSR", "MSR") . ' ' . set_value('msr_no') ?></h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
          <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
          <li class="breadcrumb-item active"><?= lang("MSR", "MSR") ?></li>
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
              <td ><span><?= set_value('title') ?></span></td>
            </tr>
         </table>
      </div>
	  <div class="col-md-3">
		 <table class="table table-condensed">
            <tr>
              <td width="20%">User Requestor</td>
              <td class="no-padding-lr">:</td>
              <td><span><?= $_POST['create_by_name'] ?></span></td>
            </tr>
            <tr>
              <td width="20%">Department</td>
              <td class="no-padding-lr">:</td>
              <td><span><?= $_POST['creator_department_name'] ?></span></td>
            </tr>
          </table>
        </div>
		<div class="col-md-5">
		 <table class="table table-condensed">
			<tr>
              <td width="30%">Total (Excl. VAT)</td>
              <td class="no-padding-lr">:</td>
              <td class="text-right"><?= $total_amount_text ?></span></td>
            </tr>
            <tr>
              <td width="30%">VAT</td>
              <td class="no-padding-lr">:</td>
              <td class="text-right"><?= $total_tax_text ?></span></td>
            </tr>
            <tr>
              <td width="30%">Total (Incl. VAT)</td>
              <td class="no-padding-lr">:</td>
              <td class="text-right"><?= $total_amount_with_tax_text ?></span></td>
            </tr>
		 </table>
		</div>
    </div>
    <section id="configuration">
      <div class="row">
        <div class="col-md-12">
          <?php if (isset($message) && !empty($message['message'])): ?>
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

            <div class="card-content collapse show">
              <div class="card-body card-dashboard card-scroll">
                <div class="row">
                  <div class="col-md-12">
                    <!-- form #msr-development-form -->
                    <form id="msr-development-form" method="POST" class="steps-validation wizard-circle">
                      <?php /* MSR Header */ ?>
                      <h6><i class="step-icon icon-info"></i> Header</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="company">
                                Company :
                              </label>
                              <?= form_input('company', set_value('company_desc'), 'class="form-control" disabled="disabled" id="company"')?>
                            </div>
                          </div>
                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="plocation">Procurement Location :
                              </label>
                              <?= form_input('plocation', set_value('rloc_desc'), 'class="form-control" disabled="disabled"') ?>
                            </div>
                          </div>

                          <div class="col-md-3">
                            <div class="form-group">
                              <label for="required_date">
                                Required Date :
                              </label>
                              <?= form_input('required_date', set_value('req_date'), 'class="form-control" disabled="disabled" id="required_date"') ?>
                            </div>
                          </div>

						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="lead_time">
                                Lead Time :
                              </label>
                              <div class="input-group">
                                <?= form_input('lead_time', set_value('lead_time'), 'id="lead_time" class="form-control" disabled="disabled" data-bts-postfix="Week(s)"') ?>
                                <span class="input-group-addon">Week(s)</span>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="title">Title :
                              </label>
                              <textarea class="form-control" disabled="disabled" id="title" name="title" rows="2"><?= set_value('title') ?></textarea>
                            </div>
                          </div>

						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="pmethod">
                                Proposed Procurement Method :
                              </label>
                              <?= form_input('pmethod', set_value('pmethod_desc'), 'class="form-control" disabled="disabled"') ?>
                            </div>
                          </div>

						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="procure_processing_time">
                                Procurement Processing Time :
                              </label>
                              <div class="input-group">
                                <input type="text" disabled name="procure_processing_time" id="procure_processing_time" class="form-control" value="<?= set_value('procure_processing_time') ?>">
                                <span class="input-group-addon">days</span>
                              </div>
							  <p><small class="text-muted">Excluding lead time. After MSR received by Procurement.</small></p>
                            </div>
                          </div>
                        </div>

                        <div class="row">

						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="msr_type">
                                MSR Type :
                              </label>
                              <?= form_input('msr_type', set_value('msr_type_desc'), 'id="msr_type" class="form-control" disabled="disabled"') ?>
                            </div>
                          </div>

						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="msr_type">
                                Blanket :
                              </label>
                              <?= form_input('blanket', set_value('blanket') == 1 ? 'Blanket':'Non Blanket', 'id="blanket" class="form-control" disabled="disabled"') ?>
                            </div>
                          </div>
						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="cost_center">
                                Cost Center :
                              </label>
                              <?= form_input('cost_center', set_value('costcenter_desc'), 'id="cost_center" class="form-control" disabled="disabled"') ?>
                            </div>
                          </div>
						  <div class="col-md-3">
                            <div class="form-group">
                              <label for="currency">
                                Currency :
                              </label>
                              <?= form_input('currency', set_value('currency_desc'), 'class="form-control" disabled="disabled"') ?>
                            </div>
                          </div>
						</div>

                      </fieldset>

                      <?php /* MSR Detail */ ?>
                      <h6><i class="step-icon icon-list"></i> Detail</h6>
                      <fieldset>

                        <?php if ($id_msr_type == 'MSR01'): /* Jika MSR type = MSR Materials */ ?>

                        <div class="msr_detail_type_goods">
                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="delivery_point">
                                  Delivery Point :
                                </label>
                                <?= form_input('delivery_point', set_value('dpoint_desc'), 'class="form-control" disabled="disabled" id="delivery_point"') ?>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="importation">
                                  Importation :
                                </label>
                                <?= form_input('importation', set_value('importation_desc'), 'class="form-control" disabled="disabled" id="importation"') ?>
                              </div>
                            </div>

							<div class="col-md-3">
                              <div class="form-group">
                                <label for="delivery_term">Delivery Term :</label>
                                <?= form_input('delivery_term', set_value('deliveryterm_desc'), 'class="form-control" disabled="disabled" id="delivery_term"') ?>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="freight">Freight :</label>
                                <?= form_input('freight', set_value('freight_desc'), 'class="form-control" disabled="disabled" id="freight"') ?>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="requestfor">Request for :</label>
                                <?= form_input('requestfor', set_value('requestfor_desc'), 'class="form-control" disabled="disabled" id="requestfor"') ?>
                              </div>
                            </div>

                            <div class="col-md-3">
                              <div class="form-group">
                                <label for="inspection">
                                  Inspection/Acceptance :
                                </label>
                                <?= form_input('inspection', set_value('inspection_desc'), 'class="form-control" disabled="disabled" id="inspection"') ?>
                              </div>
                            </div>


                            <div class="col-md-3">
                              <div class="form-group">
                                <label>
                                  Master List :
                                </label>
                                <div class="checkbox">
                                  <label for="master_list">
                                  <?= form_checkbox('master_list', set_value('master_list'), (boolean) set_value('master_list'), 'id="master_list" disabled="disabled"') ?>
                                  </label>
                                </div>
                              </div>
                            </div>


                          </div>
                        </div>
                        <?php endif; ?>


                        <?php if ($id_msr_type == 'MSR02'): /* Jika MSR type = MSR Services */ ?>
                        <div class="msr_detail_type_service">
                          <div class="row">
                            <div class="col-md-6">
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
                                <?= form_input('location', set_value('dpoint_desc'), 'class="form-control" disabled="disabled" id="location"') ?>
                              </div>
                            </div>
                          </div>

                        </div>
                        <?php endif; ?>

                        <div class="row msr-development-detail-list-table">
                          <div class="col-md-12">
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
                              <table id="msr-development-budget" class="table table-striped nowrap base-style">
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

                        <br>
                        <br>
                    <!--
                        <div class="row msr-development-budget-table">
                          <div class="col-md-12">
                            <table id="msr-development-budget">
                            <thead>
                                <tr>
                                  <th data-data="cost_center_name" rowspan="2">Cost Center</th>
                                  <th data-data="account_subsidiary_name" rowspan="2">Account Subsidiary Description</th>
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
                          </div>
                        </div>
                        -->
                      </fieldset>

                      <?php /* Attachment */ ?>
                      <h6><i class="step-icon icon-paper-clip"></i> Attachment</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">

                            <div id="attachment-alert" class="alert alert-warning" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div id="attachment-list">
                              <hr>
                              <div class="row">
                                <div class="col-md-2"><?php /* type */ ?>
                                  <label>Type</label>
                                </div>
                                <div class="col-md-1"><?php /* sequence */ ?>
                                  <label>Seq</label>
                                </div>
                                <div class="col-md-4"><?php /* filename */ ?>
                                  <label>Filename</label>
                                </div>
                                <div class="col-md-3"><?php /* upload time */ ?>
                                  <label>Uploaded Date</label>
                                </div>
                                <div class="col-md-2"><?php /* upload by */ ?>
                                  <label>Uploaded By</label>
                                </div>
                              </div>
                              <hr>
                              <?php if (isset($_POST['attachments']) && count($_POST['attachments']) > 0): ?>

                              <?php foreach($_POST['attachments'] as $attachment): ?>
                              <div class="row form-group">
                                <div class="col-md-2"><?php /* type */ ?>
                                  <?= @$opt_msr_attachment_type[$attachment->tipe] ?>
                                </div>

                                <div class="col-md-1"><?= $attachment->sequence ?> </div>

                                <div class="col-md-4">
                                  <?php $href = base_url().$attachment->file_path.$attachment->file_name; ?>
                                  <a href="<?= $href ?>" target="_blank"><?= $attachment->file_name ?></a>
                                </div>

                                <div class="col-md-3"><?= dateToIndo($attachment->created_at) ?> </div>

                                <div class="col-md-2"><?= $attachment->created_by_name ?> </div>

                              </div>
                              <?php endforeach; ?>
                              <?php endif; ?>
                            </div>  <!-- end repeater attachment -->
                          </div>
                        </div>
                      </fieldset>

                      <?php if (isset($_POST['msr_no']) && !empty($_POST['msr_no'])): ?>
                      <h6><i class="step-icon icon-directions"></i>Approval</h6>
                      <fieldset>
                        <?= function_exists('list_approval') ? list_approval('msr', @$_POST['msr_no']) : '' ?>
                      </fieldset>
                      <?php endif; ?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="row">
  <div class="col-md-12 text-right">
    <div class="form-group">
      <?php if($this->approval_lib->getRejectByMsr($_POST['msr_no'])): ?>
        <a href="<?= base_url('procurement/msr/edit/'.set_value('msr_no'))?>" class="btn btn-warning">Edit</a>
        <a href="#" class="btn btn-success resubmit" msr-no="<?=$_POST['msr_no']?>">Re Submit</a>
      <?php endif; ?>
    </div>
  </div>

  </div>
</div>
</div>

<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<script src="<?= base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/dataTables.select.min.js" type="text/javascript"></script>
<script src="<?= base_url('ast11/assets/js/accounting.js/accounting.js') ?>"></script>

<script>
var mapMsrTypeItemType = '<?= @json_encode($mapMsrTypeItemType) ?>';
var cost_center = '<?= @json_encode($opt_cost_center) ?>';
var item_master = [];
var attachmentType = JSON.parse('<?= @json_encode($opt_msr_attachment_type)?>');
var attachment_list = {};
var msr_development_budget = {};
var msr_development_detail_list = {};

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
    description: arr.join(sep)
  }
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

  var data = $('#msr-development-detail-list').find('input,select,textarea').serializeArray()

  var elem_master_list = $('#master_list');
  if (elem_master_list.is(':checked')) {
    data.push({ name: elem_master_list.attr('name'), value: elem_master_list.val() })
  }

  $.post(
    '<?= base_url().'/procurement/msr/calculateBudget' ?>',
    data
  )
  .done(function(data) {
    if (data.status == 'error') {
      alert(data.message);
      return false;
    }

    msr_development_budget.clear()
    msr_development_budget.rows.add(data.data).draw()

    var budget_exchange_rate = accounting.formatMoney(data.exchange_rate_from, { symbol: data.msr_currency_name })
                + ' = ' + accounting.formatMoney(data.exchange_rate_to, { symbol: data.base_currency_name });

    $('#budget_exchange_rate').text(budget_exchange_rate);

    if (data.msr_currency_id == data.base_currency_id) {
      $("#current_exchange_rate_text").hide();
      $('#budget_exchange_rate').hide();
    } else {
      $("#current_exchange_rate_text").show();
      $('#budget_exchange_rate').show();
    }

    $('#msr-development-form').validate();

    $('#msr-development-budget').find('select')
      .on('change', function(e) {
        var elem = $(this);
        var msr_no = elem.data('msr_no');
        var msr_item_id = elem.data('msr_item_id');
        var costcenter_id = elem.data('costcenter_id');
        var accsub_id = elem.data('accsub_id');

        if (!msr_no) {
          // alert('Undefine MSR No data')
          swal('Ooopss','Undefine MSR No data','warning')
          return false
        }

        // if (!msr_item_id) {
        //   alert('Undefined MSR Item data')
        //   return false
        // }

        $.post('<?= base_url('procurement/msr/updateBudget') ?>', {
          msr_no: msr_no,
          costcenter_id: costcenter_id,
          accsub_id: accsub_id,
          msr_item_id: msr_item_id,
          status_budget: elem.val()
        })
        .done(function(data) {
          console.log(data.message)
          if (data.message == 'Ok') {
            toastr.success('Status budget changed')
          }  else {
            toastr.error(data.message)
          }
        })
        .fail(function(error) {
          console.log($(this))
          toastr.error(error.message)
        });
        // console.log($(e.target).val())
      })

  })
  .fail(function(error) {
    alert(error)
  })
  .always(function() {
    // e.g. remove waiting animation
  })
}


function display_alert_validate_attachment(text, elm_class = 'danger')
{
  $('#attachment-alert').removeClass().addClass('alert alert-'+elm_class).text(text).show()
}

function validate_status_budget() {
  // invoked only from MSR approval screen
  var form, invalid_elem = []
  if ((form = $('#msr-development-form')) && form.length > 0) {
    form.find('select.status-budget.required').each(function(i, elem) {
      if ($(elem).val() == '') {
        invalid_elem.push(elem)
      }
    })

    if (invalid_elem.length > 0) {
      // alert('Please select Status Budget first')
      swal('Ooopss','Please select Status Budget first','warning')
      return false
    }
  }

  return true
}

$(document).ready(function() {
  $(".resubmit").click(function(){
    var msr_no = $(this).attr('msr-no');
    swalConfirm('MSR', '<?= __('confirm_submit') ?>', function() {
      $.ajax({
            type : 'post',
            data : {msr_no:msr_no},
            url  : "<?=base_url('approval/approval/resubmit')?>",
            beforeSend : function(){
              start($('#configuration'));
            },
            error:function(e){
              stop($('#configuration'));
              var r = eval("("+e+")");
              // alert(r.msg);
              setTimeout(function() {
                swal('<?= __('warning') ?>',r.msg,'warning');
              }, swalDelay);
            },
            success:function(e){
              var r = eval("("+e+")");
              // alert(r.msg);
              stop($('#configuration'));
              window.open("<?=base_url('home')?>", "_self");
            }
          });
    });
    /*swal({
          title: "MSR",
          text: "Are you sure to proceed ?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Submit",
          closeOnConfirm: true
        },function () {

        })*/
    /*if(confirm('Are you sure want to re submit?'))
    {*/
    // }
  });

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
  labels: {
  },
  onStepChanging: function (event, currentIndex, newIndex)
  {
    // Allways allow previous action even if the current form is not valid!
    if (currentIndex > newIndex)
    {
      if (newIndex == 2) {
        calculate_budget()
      }

      return true;
    }

    if (newIndex == 2)
    {
      // kalkulasikan biaya cost center yang diisi di tabel item
      calculate_budget()
    }

    if (currentIndex == 2)
    {
      var isValid = $('#msr-development-form').valid()
      console.log(isValid)
      if (!isValid) return false

      // traditional validation :-)
      /*
      var unselected = []
      $('#msr-development-form select.status-budget').each(function(i, elem) {
        if ($(elem).val() == '') {
          unselected.push(elem)
        }
      })

      if (unselected.length > 0) {
        alert('Please select Status Budget')
        return false;
      }
      */
    }

	if (newIndex == 4)
    {
      /* var isValid = $('#msr-development-form').valid() */
      /* console.log(isValid) */
      /* if (!isValid) return false */

      // traditional validation :-)
      /*
      var unselected = []
      $('#msr-development-form select.status-budget').each(function(i, elem) {
        if ($(elem).val() == '') {
          unselected.push(elem)
        }
      })

      if (unselected.length > 0) {
        alert('Please select Status Budget')
        return false;
      }
      */
    }

    return true;
  }
});

//hide next and previous button
$('a[href="#next"]').hide();
$('a[href="#previous"]').hide();

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

msr_development_detail_list = $('#msr-development-detail-list').DataTable({
  "paging":   false,
  "info":     false,
  "searching": false,
  "ordering": false,
  "select": true,
  "columns": [
    {"data": "item_type", "title": "Item Type"},
    {"data": "semic_no", "title": "Semic No/ Service Cat", "class": "Semic"},
    {"data": "description_of_unit", "title": "Description of Unit", "class": "description"},
    {"data": "group", "title": "Classification", "class": "classification"},
    {"data": "subgroup", "title": "Group/ Category", "class": "category"},
    {"data": "qty_required", "title": "Qty Req", "class": "Qty-Req text-center"},
    {"data": "qty_onhand", "title": "Qty OH", "class": "Qty-OH text-center"},
    {"data": "qty_ordered", "title": "Qty Ord", "class": "Qty-Ord text-center"},
    {"data": "uom", "title": "UoM", "class" : "text-center"},
    {"data": "unit_price", "title": "Est. Unit Price", "align": "right", "class": "price text-right"},
    {"data": "total_value", "title": "Est. Total Value", "align": "right", "class": "value text-right"},
    {"data": "currency", "title": "Currency", "class" : "text-center"},
    {"data": "importation", "title": "Importation"},
    {"data": "delivery_point", "title": "Delivery Point/Location", "class": "delivery-point"},
    {"data": "cost_center", "title": "Cost Center"},
    {"data": "account_subsidiary", "title": "Account Subsidiary", "class": "subsidiary"},
    {"data": "inv_type", "name": "inv_type", "title": "Inv Type"},
    {"data": "item_modification", "name": "item_modification", "title": "Item Modification", "class" : "text-center"}
  ]
});

msr_development_detail_list.rows.add(<?php echo json_encode($ready_items) ?>).draw()

$('#required_date').attr('disabled', false);
$('#required_date').pickadate({
  format: 'd mmmm yyyy',
  formatSubmit: 'yyyy-mm-dd'
})
<?php if (set_value('req_date')): ?>
.pickadate('picker').set('select', new Date('<?= set_value('req_date') ?>'))
<?php endif; ?>
$('input, select, textarea').attr('disabled', true)
$('#msr-development-detail-list').find('input').attr('disabled', false)
$('form#frm').find('input,select,textarea').attr('disabled', false);

calculate_budget()

// end document ready
});
</script>

<?php /* vim: set fen foldmethod=indent ts=2 sw=2 tw=0 et autoindent :*/ ?>
