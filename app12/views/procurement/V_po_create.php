<?php
$opt_tkdn_type = array('' =>  'Choose TKDN Type') + $opt_tkdn_type;
$opt_importation = array('' =>  '') + $opt_importation;
$opt_delivery_term = array('' =>  '') + $opt_delivery_term;
$opt_dpoint = array('' =>  '') + $opt_dpoint;
$opt_yesno = array('' => '', '1' => 'Yes', 0 => 'No');
// $opt_vendor_bank_account = array('' =>  '') + $opt_vendor_bank_account;
?>
<?php /* page specific */ ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/pickadate/pickadate.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">

<style>
body {
  font-family: "Open Sans", sans-serif;
  font-size: 14px;
  font-weight: normal;
}

.alert ul {
  margin-bottom: 0;
}
</style>

<div class="app-content content">
<div class="content-wrapper">
<div class="content-header row">
  <div class="content-header-left col-md-6 col-12 mb-1">
    <h3 class="content-header-title"><?= lang("Agreement Development", "Agreement Development") ?></h3>
  </div>
  <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
    <div class="breadcrumb-wrapper col-12">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
        <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
        <li class="breadcrumb-item active"><?= lang("Agreement Development", "Agreement Development") ?></li>
      </ol>
    </div>
  </div>
</div>


<div class="content-body">
  <div class="row info-header">
    <div class="col-md-4">
      <table class="table table-condensed">
        <tr>
          <td width="30%">Company</td>
          <td width="5%">:</td>
          <td width="65%"><?= $bl->company_desc ?>
          </td>
        </tr>
        <tr>
          <td>Supplier</td>
          <td>:</td>
          <td><?= $vendor->NAMA ?>
          </td>
        </tr>
      </table>
    </div>
    <div class="col-md-4">
      <table class="table table-condensed">
        <tr>
          <td width="30%">Agreement No.</td>
          <td width="5%">:</td>
          <td width="65%"><?= $po_no ?></td>
        </tr>
        <tr>
          <td>Agreement Value</td>
          <td>:</td>
          <td class="text-right"><?= display_multi_currency_format(@$bl->total_amount, @$opt_currency[$bl->id_currency], (exchange_rate(@$opt_currency[$bl->id_currency], base_currency_code(), @$bl->total_amount)), base_currency_code()) ?></td>
        </tr>
      </table>
    </div>
    <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
            <td width="30%">Title</td>
            <td width="5%">:</td>
            <td width="65%"><?= $bl->title ?></td>
          </tr>
          <tr>
            <td>Department</td>
            <td>:</td>
            <td><?= @$bl->department_desc ?></td>
          </tr>
        </table>
      </div>
  </div>
  <section id="configuration">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-content collapse show">
            <div class="card-body card-dashboard card-scroll">
               <div class="row">
                <div class="col-md-12">
                <?php $this->load->view('V_message_section', compact('message')) ?>
                </div>
              </div>

<?php
/*
if ($this->form_validation->error_array())
{
print_r($this->form_validation->error_array());
}
*/
?>

              <div class="row">
                <div class="col-md-12">
                  <form id="purchase_order_form" method="POST" enctype="multipart/form-data" class="steps-validation wizard-circle">
                      <input type="hidden" name="bl_detail_id" value="<?= $bl_detail_id ?>">
                      <input type="hidden" name="po_type" value="<?= $po_type ?>">
                      <?php /* PO Development */ ?>
                      <h6><i class="step-icon icon-info"></i> Agreement Data</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="title">
                                Title :
                              </label>
                              <textarea class="form-control required" id="title" onkeyup="titleKeyup('title')" name="title" rows="2" style="width: 100%" maxlength="60"><?= set_value('title', substr($bl->title, 0, 60)) ?></textarea>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="id_currency">
                                Currency :
                              </label>
                              <input type="hidden" name="id_currency" id="id_currency" value="<?= set_value('id_currency', $bl->id_currency)?>">
                              <input type="text" name="name_currency" id="name_currency" readonly class="form-control" value="<?= @$opt_currency[set_value('id_currency', $bl->id_currency)] ?>">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3">
                              <div class="form-group">
                                <label for="po_date">
                                  Agreement Date :
                                </label>
                                <input type="date" class="form-control pickadate required" data-value="<?= set_value('po_date') ?>" id="po_date" name="po_date" style="background-color: #ffffff;">
                              </div>
                          </div>
                          <div class="col-md-3">
                            <label for="msr_type">
                              Blanket Type :
                              <span class="danger">*</span>
                            </label>
                              <?= form_dropdown('blanket', ['' => '', 1 => 'Blanket', 0 => 'Non Blanket'], set_value('blanket', $bl->blanket),
                              'class="custom-select form-control required" id="blanket"') ?>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="bank_account">
                                Bank Account :
								<span class="danger">*</span>
                              </label>
                              <?= form_dropdown('bank_account', $opt_vendor_bank_account, set_value('bank_account', @$bl->bank_account), 'class="form-control required" id="bank_account"') ?>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label for="delivery_date">
                                <?php if ($bl->blanket == 0 and $bl->id_msr_type == 'MSR01'): ?>
                                  Delivery Date :
                                <?php else: ?>
                                  Expired Date :
                                <?php endif; ?>
								  <span class="danger">*</span>
                                </label>
                                <input type="date" class="form-control pickadate required" data-value="<?= set_value('delivery_date') ?>" id="delivery_date" name="delivery_date" style="background-color: #ffffff;">
                              </div>
                          </div>

                          <div class="col-md-2">
                            <div class="form-group">
                              <label for="bank_name">
                                Bank Name :
								<span class="danger">*</span>
                              </label>
                              <input type="text" readonly class="form-control required" value="<?= set_value('bank_name', @$vendor_bank_account->BANK_NAME) ?>" id="bank_name" name="bank_name">
                            </div>
                          </div>
                          <div class="col-md-4">
                            <div class="form-group">
                              <label for="account_name">
                                Account Name :
								<span class="danger">*</span>
                              </label>
                              <input type="text" readonly class="form-control required" value="<?= set_value('account_name', @$vendor_bank_account->NAME) ?>" id="account_name" name="account_name">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label for="payment_term">
                                  Payment Term :
								  <span class="danger">*</span>
                                </label>
                                <textarea rows="2" onkeyup="titleKeyup('payment_term')" class="form-control required" id="payment_term" name="payment_term"><?= $frompo ? $frompo->payment_term : set_value('payment_term') ?></textarea>
                              </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="shipping_term">
                                Shipping Term :
								<span class="danger">*</span>
                              </label>
                              <?= form_dropdown('shipping_term', $opt_delivery_term, set_value('shipping_term', @$bl->incoterm), 'class="form-control required" id="shipping_term"') ?>
<!--                              <input type="text" class="form-control required" value="<?= set_value('shipping_term', $bl->incoterm) ?>" id="shipping_term" name="shipping_term"> -->
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label for="id_dpoint">
                                  Delivery Point :
                                </label>
                                <?= form_dropdown('id_dpoint', $opt_dpoint, set_value('id_dpoint', $bl->id_dpoint), 'class="form-control required" id="id_dpoint"') ?>
                              </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="id_importation">
                                Importation :
                              </label>
                              <?= form_dropdown('importation_desc', $opt_importation, set_value('id_importation', $bl->id_importation), 'class="form-control required" disabled id="importation_desc"') ?>
                              <input type="hidden" name="id_importation" id="id_importation" value="<?= set_value("id_importation", $bl->id_importation)?>">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="tkdn_type">TKDN
							  <span class="danger">*</span>
							  </label>
                              <?= form_dropdown('tkdn_type', $opt_tkdn_type, set_value('tkdn_type', @$bl->tkdn_type), 'class="form-control required" id="tkdn_type"') ?>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                                <label for="tkdn_value_goods">TKDN Value
								</label>
                                <div class="row">
                                  <div class="col-sm-4">
                                    <input name="tkdn_value_goods" id="tkdn_value_goods" value="<?= set_value('tkdn_value_goods', @$bl->tkdn_value_goods) ?>" class="form-control" placeholder="Goods">
                                    <!--<small class="form-text text-muted">Goods</small>-->
                                  </div>
                                  <div class="col-sm-4">
                                    <input name="tkdn_value_service" id="tkdn_value_service" value="<?= set_value('tkdn_value_service', @$bl->tkdn_value_service) ?>" class="form-control" placeholder="Service">
                                    <!--<small class="form-text text-muted">Service</small>-->
                                  </div>
                                  <div class="col-md-4">
                                    <input name="tkdn_value_combination" id="tkdn_value_combination" value="<?= set_value('tkdn_value_combination', @$bl->tkdn_value_combination) ?>" class="form-control" placeholder="Combination">
                                    <!--<small class="form-text text-muted">Combination</small>-->
                                  </div>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label>
                                Master List :
                              </label>
                              <div class="checkbox">
                                <label for="master_list">
                                  <?= form_checkbox('master_list', set_value('master_list', @$bl->master_list), (boolean) set_value('master_list', @$bl->master_list), 'id="master_list"') ?>
                                </label>
                              </div>
                            </div>
                          </div>
                        </div>

						<!--<div class="row" id="required-warning-1" hidden>
							<div class="col-md-12" style="padding:0px;">
								<div id="item-table-alert" class="alert alert-warning" role="alert" style="">Please fill out all the required fields (*)</div>
							</div>
					   </div>-->

                        <hr>

                        <div class="row">
                          <div class="col-md-8">
                            <h5>Required Document</h5>
                            <table>
                            <tbody>
                              <?php foreach($this->M_purchase_order_document->getTypes() as $type => $description): ?>
                              <?php
                              $checked_and_readonly = '';
                              // mandatory
                              // if ($type == $this->M_purchase_order_document::TYPE_PERFORMANCE_BOND) {
                              //   $checked_and_readonly = ' checked readonly onclick="return false"';
                              // }
                              ?> <tr>
                                <td><label for="<?= 'po_document'.$type ?>"><?= $description ?></label></td>
                                <td>
                                <fieldset class="checkbox">
                                <label>
                                <input type="checkbox" class="po_document_checkbox" name="<?= 'po_document'.$type ?>" id="<?= 'po_document'.$type ?>" <?= $checked_and_readonly ?>>

                                <input style="width: 90%" class="form-control pull-right" name="po_document<?= $type?>_text" id="po_document<?= $type?>_text" value="<?= set_value('po_document<?= $type?>_text')?>">

                                </label>
                                </fieldset>
                                </td>
                                <td>

                                </td>
                              </tr>
                              <?php endforeach; ?>
                            </tbody>
                            </table>
                          </div>
                        </div>

                        <hr>

                        <div class="row" style="padding-top: 20px; padding-bottom: 10px">
                          <div class="col-md-12" style="overflow: auto">
                            <div id="po-item-alert" class="alert alert-dismissible alert-danger" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                              <span aria-hidden="true">×</span>
                            </button>
                            <ul></ul>
                            </div>
                            <div class="table-responsive">
                              <table class="table table-no-wrap" id="po_items" style="width:100%">
                              <thead>
                                <tr>
                                  <th>No</th>
                                  <th>Item Type</th>
                                  <th>Semic No</th>
                                  <th>Description</th>
                                  <th class="text-center">Qty</th>
                                  <th class="text-center">UoM</th>
                                  <th class="text-right">Unit Price</th>
                                  <th class="text-right">Total</th>
                                  <th>Cost Center</th>
                                  <th>Account Subsidiary</th>
                                  <th>Inv Type</th>
                                  <th class="text-center">Item Modification</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php if (count($po_items) > 0): ?>
                              <?php foreach($po_items as $i => $item): ?>
                                <tr>
                                  <td><?= $i + 1 ?></td>
                                  <td><?= @$opt_item_type[$item['id_itemtype']] ?></td>
                                  <td><?= $item['id_itemtype'] == 'GOODS' ? $item['semic_no'] : '' ?></td>
                                  <td><?= $item['item_desc'] ?></td>
                                  <td class="text-center"><?= $item['qty'] ?></td>
                                  <td class="text-center"><?= $item['uom_desc'] ?> - <?= $item['uom_description'] ?>
                                    <input type="text" name="id_uom-<?= $item['msr_item_id']?>" id="id_uom-<?= $item['msr_item_id']?>" class="id_uom hidden required" value="<?= $item['id_uom']?>">
                                    <input type="text" name="uom_desc-<?= $item['msr_item_id']?>" id="uom_desc-<?= $item['msr_item_id']?>" class="uom_desc hidden required" value="<?= $item['uom_desc']?>">
                                  <td><span style="text-align:right"><?= numEng($item['unitprice']) ?></span></td>
                                  <td><span style="text-align:right"><?= numEng($item['total_price']) ?></span></td>
                                  <td><?= $item['costcenter_desc'] ?></td>
                                  <td><?= $item['accsub_desc'] ?></td>
                                  <td><?= @$opt_msr_inventory_type[$item['id_msr_inv_type']] ?></td>
                                  <td class="text-center"><?= $item['id_itemtype'] == 'GOODS' ? '' : @$opt_yesno[$item['is_modification']]?></td>
                                </tr>
                              <?php endforeach; ?>
                              </tbody>
                              <tfoot>
                                <tr>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td><span style="text-align:right">Total</span></td>
                                  <td><span style="text-align:right"><?= numEng($bl->total_amount) ?></span></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                  <td></td>
                                </tr>
                              </tfoot>
                              <?php endif; ?>
                              </table>
                            </td>
                          </div>
                        </div>
                      </fieldset>

                      <?php /* PO Attachment */ ?>
                      <h6><i class="step-icon icon-paper-clip"></i> Agreement Document</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">

                            <div id="attachment-alert" class="alert alert-warning hidden" role="alert">
                              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">×</span>
                              </button>
                            </div>
                            <div id="attachment-list">

                              <div class="row">
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
                              </div>

                              <div class="row">
                                <div class="col-md-2"><?php /* type */ ?>
                                    <?= $po_attachment_type[$m_purchase_order_attachment::TYPE_DRAFT_PO]     ?>
                                </div>

                                <div class="col-md-1"><?php /* sequence */ ?> </div>

                                <div class="col-md-3">
                                  <input type="file" name="draft_of_po" class="required">
                                </div>

                                <div class="col-md-3"><?php /* upload time */ ?> </div>

                                <div class="col-md-2"><?php /* upload by */ ?> </div>
                              </div>

                              <?php if (isset($po_attachments) && count($po_attachments) > 0 ): ?>
                              <?php foreach($po_attachments as $attachment): ?>
                                <div class="row">
                                  <div class="col-md-2"><?php /* type */ ?>
                                    <?= $po_attachment_type[$attachment->tipe]?>
                                  </div>
                                  <div class="col-md-1"><?php /* sequence */ ?>
                                    <?= $attachment->sequence ?>
                                  </div>
                                  <div class="col-md-3"><?= $attachment->file_name ?></div>

                                  <div class="col-md-3"><?= $attachment->created_at ?> </div>

                                  <div class="col-md-2"><?= $attachment->created_by ?></div>
                                  <div class="col-md-1">

                                  </div>
                                </div>
                              <?php endforeach; ?>
                              <?php endif; ?>

                            </div>  <!-- end repeater attachment -->
                          </div>
                        </div>
						<!--<div class="row" id="required-warning-2" style="margin-top: 2em;" hidden>
							<div class="col-md-12" style="padding:0px;">
								<div id="item-table-alert" class="alert alert-warning" role="alert" style="">Please fill out all the required fields (*)</div>
							</div>
						</div>-->
                      </fieldset>
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
</div>
</div>


<script src="<?= base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/dataTables.select.min.js" type="text/javascript"></script>
<script>
function tkdn_average(type, goods_value, service_value) {
  if (type == '1') { // goods
    return toFloat(goods_value)
  }
  else if (type == '2') {
    return toFloat(service_value)
  }
  else if (type == '3') {
    return (toFloat(goods_value) + toFloat(service_value) ) / 2;
  }

  return 0;
}

function titleKeyup(field_id){
  var s = $("#"+field_id).val();
  var x = s.search('>')
  var y = s.search('<')
  var z = s.search('&')

  if(x == -1 && y == -1 && z == -1)
  {
    // $('#msr_title').html(s)
    return true
  }
  else
  {
    var n = s.replace('<','')
    n = n.replace('>','')
    n = n.replace('&','')

    $("#"+field_id).val(n)
  }
}

$(document).ready(function() {
var form = $('#purchase_order_form');

$('#purchase_order_form').steps({
  headerTag: "h6",
  bodyTag: "fieldset",
  transitionEffect: "fade",
  titleTemplate: '#title#',
  enablePagination: true,
  enableAllSteps: true,
  labels: {
    finish: 'Submit'
  },
  onStepChanging: function (event, currentIndex, newIndex)
  {
    $('#po-item-alert').find('ul').empty()

    if (currentIndex > newIndex)
    {
      return true;
    }

    // Needed in some cases if the user went back (clean up)
    if (currentIndex < newIndex)
    {
      // To remove error styles
      form.find(".body:eq(" + newIndex + ") label.error").remove();
      form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
    }


    form.validate({
        errorPlacement: function(error, element) {
            // alert()
            swal('<?= __('warning') ?>', 'Please fill out all the required fields (*)', 'warning')
        }
    }).settings.ignore = ":disabled,:hidden";
    if (form.valid()){
      $('#required-warning-1').attr('hidden', 'hidden');
    }
    else {
      $('#required-warning-1').removeAttr('hidden');
      swal('<?= __('warning') ?>', 'Please fill out all the required fields (*)', 'warning');
    }

	return form.valid();

    if (currentIndex == 0) {
      if ($('#po_items').find('tbody tr').length == 0) {
        $('#po-item-alert').find('ul').append('<li>No item provided</li>')
        $('#po-item-alert').show()
        return false
      }
    }

    return true
  },
  onFinishing: function (event, currentIndex)
  {
    $('#po-item-alert').find('ul').empty()

    form.validate().settings.ignore = ":disabled,:hidden";
    if (form.valid()){
      $('#required-warning-2').attr('hidden', 'hidden');
    }
    else {
      $('#required-warning-2').removeAttr('hidden');
      swal('<?= __('warning') ?>', 'Please fill out all the required fields (*)', 'warning');
      return false;
    }

	return form.valid();

    if ($('#po_items').find('tbody tr').length == 0) {
      $('#po-item-alert').find('ul').append('<li>No item provided</li>').show()
      return false;
    }

    return true;
  },
  onFinished: function (event, currentIndex)
  {
    var leng = $("#title").val().length;
    if (leng > 60) {
      // alert("Maximum length Title in Agreement data is 30");
      swal('<?= __('warning') ?>','Maximum length Title in Agreement data is 60','warning')
    } else {
      swal({
        title: "AGREEMENT DEVELOPMENT",
        text: "Are you sure want to submit?",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        confirmButtonText: "Submit",
        closeOnConfirm: true
      },function () {
        $(form).submit();
      })
    }

  }
});

//hide next and previous button
$('a[href="#next"]').hide();
$('a[href="#previous"]').hide();


var po_date = $('#po_date').pickadate({
  format: 'd mmmm yyyy',
  formatSubmit: 'yyyy-mm-dd'
})
.pickadate('picker').set('select', new Date('<?= $frompo ? $frompo->po_date :  set_value('po_date_submit')?>'));

var delivery_date = $('#delivery_date').pickadate({
  format: 'd mmmm yyyy',
  formatSubmit: 'yyyy-mm-dd'
});

<?php
$delivery_date_submit = set_value('delivery_date_submit', $delivery_date);
?>

<?php if ($delivery_date_submit): ?>
delivery_date.pickadate('picker').set('select', new Date('<?= $delivery_date_submit ?>'));
<?php endif; ?>

$('#bank_account').change(function(e) {
  var selected_text = $(this).find('option:selected').text()
  var bank_name, account_name

  if (selected_text) {
    var s = selected_text.split(' - ')
    bank_name = s.shift()
    account_name = s.join(' - ')
  }

  $('#bank_name').val(bank_name)
  $('#account_name').val(account_name)
})

$('#tkdn_type').change(function(e) {
  var val =  $(this).val();
  var goods_elem = $('#tkdn_value_goods'),
      service_elem = $('#tkdn_value_service'),
      combination_elem = $('#tkdn_value_combination')

  switch(val) {
    case '1': // Goods
      goods_elem.attr('disabled', false).addClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').show()
      service_elem.val('').attr('disabled', true).removeClass('required')
        .attr('max', null).attr('min', null)
        .closest('div').hide()
      combination_elem.val('').attr('disabled', true).removeClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').hide()
      break;
    case '2': // Service
      goods_elem.val('').attr('disabled', true).removeClass('required')
        .attr('max', null).attr('min', null)
        .closest('div').hide()
      service_elem.attr('disabled', false).addClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').show()
      combination_elem.val('').attr('disabled', true).removeClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').hide()
      break;
    case '3': // Combination
      goods_elem.val('').attr('disabled', false).addClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').show()
      service_elem.val('').attr('disabled', false).addClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').show()
      combination_elem.attr('disabled', false).addClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').show()
      break;
    default:
      goods_elem.val('').attr('disabled', true).removeClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').hide()
      service_elem.val('').attr('disabled', true).removeClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').hide()
      combination_elem.val('').attr('disabled', true).removeClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').hide()
      break;
  }
});

$('.po_document_checkbox').change(function() {
  var text_elem = $(this).next('input')

  if (text_elem) {
    if ($(this).is(':checked')) {
      text_elem.val('').prop('disabled', false).show()
    } else {
      text_elem.val('').prop('disabled', true).hide()
    }
  }
})

if ($('#po-item-alert').find('ul li').length == 0) {
  $('#po-item-alert').hide();
}

$('#bank_account').change();
$('#tkdn_type').change();
$('.po_document_checkbox').change();

<?php if ($po_type != $this->M_purchase_order_type::TYPE_GOODS): ?>
$('#id_dpoint').parent().parent().hide()
$('#shipping_term').parent().parent().hide()
$('#importation_desc').parent().parent().hide()
<?php endif; ?>

});
</script>

<?php /* vim: set fen foldmethod=indent ts=2 sw=2 tw=0 et autoindent :*/ ?>
