<?php
$opt_currency = array('' => 'Select currency') + $opt_currency;
$opt_yesno = ['' => '', 1 => 'Blanket', 0 => 'Non Blanket'];
$po_document_type = $this->M_purchase_order_document->getTypes();
/*print_r($po_document_type);
exit();*/
?>
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
</style>

<div class="app-content content">
<div class="content-wrapper">
  <div class="content-header row">
    <div class="content-header-left col-md-6 col-12 mb-1">
      <h3 class="content-header-title"><?= lang("Agreement", "Agreement") ?></h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
          <li class="breadcrumb-item active"><?= lang("Agreement", "Agreement") ?></li>
        </ol>
      </div>
    </div>
  </div>


  <div class="content-body">
    <div class="row">
      <div class="col-md-12">
        <h4>Agreement for <?= $po->po_no?></h4>
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

                <div class="row">
                  <div class="col-md-12">
                    <form id="purchase_order_form" method="POST" enctype="multipart/form-data" class="steps-validation wizard-circle">
                      <div class="open-this">
                        <input type="hidden" name="id" value="<?= $po->id ?>">
                      </div>

                      <?php /* PO Development */ ?>
                      <h6><i class="step-icon icon-info"></i> Agreement Data</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="title">
                                Title :
                              </label>
                              <textarea disabled class="form-control" id="title" name="title" rows="2" style="width: 100%"><?= $po->title ?></textarea>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="id_currency">
                                Currency :
                              </label>
                              <?= form_dropdown('id_currency', $opt_currency, $po->id_currency, 'class="form-control custom-select disabled" disabled id="id_currency"') ?>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-3">
                              <div class="form-group">
                                <label for="po_date">
                                  Agreement Date :
                                </label>
                                <input disabled class="form-control pickadate" data-value="<?= $po->po_date ?>" id="po_date" name="po_date" value="<?= $po->po_date ?>">
                              </div>
                          </div>

                          <div class="col-md-3">
                            <label for="blanket">
                              Blanket Type :
                              <span class="danger">*</span>
                            </label>
                            <input name="blanket" id ="blanket" disabled class="form-control" value="<?= @$opt_yesno[set_value('blanket', $po->blanket)] ?>">

                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="account_name">
                                Account Name :
                              </label>
                              <input disabled type="text" class="form-control required" value="<?= $po->account_name ?>" id="account_name" name="account_name">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group" value="<?= $po->po_date ?>">
                                <label for="delivery_date">
                                <?php if ($po->po_type == $this->M_purchase_order_type::TYPE_GOODS): ?>
                                  Delivery Date :
                                <?php else: ?>
                                  Expired Date :
                                <?php endif; ?>
                                </label>
                                <input disabled class="form-control pickadate" data-value="<?= $po->delivery_date ?>" id="delivery_date" name="delivery_date" value="<?= $po->po_date ?>">
                              </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="bank_name">
                                Bank Name :
                              </label>
                              <input disabled type="text" class="form-control" value="<?= $po->bank_name ?>" id="bank_name" name="bank_name">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label for="payment_term">
                                  Payment Term :
                                </label>
                                <textarea rows="2" disabled type="input" class="form-control" id="payment_term" name="payment_term"><?= $po->payment_term ?></textarea>
                              </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="shipping_term">
                                Shipping Term :
                              </label>
                              <input disabled type="text" class="form-control" value="<?= $po->shipping_term ?>" id="shipping_term" name="shipping_term">
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                              <div class="form-group">
                                <label for="id_dpoint">
                                  Delivery Point :
                                </label>
                                <?= form_dropdown('id_dpoint', $opt_dpoint, $po->id_dpoint, 'class="form-control disabled" disabled id="id_dpoint"') ?>
                              </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="id_importation">
                                Importation :
                              </label>
                              <?= form_dropdown('id_importation', $opt_importation, $po->id_importation, 'class="form-control disabled" disabled id="id_importation"') ?>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="tkdn_type">TKDN</label>
                              <?= form_dropdown('tkdn_type', $opt_tkdn_type, $po->tkdn_type, 'class="form-control disabled" disabled id="tkdn_type"') ?>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class="form-group">
                              <label for="tkdn_value_goods">TKDN Value</label>
                              <div class="row">
                                <div class="col-sm-4">
                                <input disabled type="number" name="tkdn_value_goods" id="tkdn_value_goods" value="<?= $po->tkdn_value_goods ?>" class="form-control" placeholder="Goods">
                                <small class="form-text text-muted">Goods</small>
                              </div>
                              <div class="col-sm-4">
                                <input readonly name="tkdn_value_service" id="tkdn_value_service" value="<?= $po->tkdn_value_service ?>" class="form-control" placeholder="Service">
                                <small class="form-text text-muted">Service</small>
                              </div>
                              <div class="col-md-4">
                                <input readonly name="tkdn_value_combination" id="tkdn_value_combination" value="<?= set_value('tkdn_value_combination', @$po->tkdn_value_combination) ?>" class="form-control" placeholder="Combination">
                                <small class="form-text text-muted">Combination</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-md-8">
                          <h5>Required Document</h5>
                          <table>
                          <tbody>
                          <?php foreach($po_document_type as $type => $description): ?>
                          <?php
                          $checked = '';
                          $reqdoc = @$po_required_doc[$type];
                          if ($reqdoc) {
                            $checked .= ' checked ';
                          }
                          ?>
                          <tr>
                            <td>
                            <label for="<?= 'po_document'.$type ?>"><?= $description ?></label>
                            </td>
                            <td>
                              <fieldset class="checkbox">
                              <label>
                              <input disabled type="checkbox" name="<?= 'po_document'.$type ?>" id="<?= 'po_document'.$type ?>" <?= $checked ?>>
                              <!-- <span></span> -->
                              </label>
                              </fieldset>
                            </td>
                            <td>
                              <?php if(@$reqdoc->description): ?>
                              <input disabled="" class="form-control" value="<?= @$reqdoc->description ?>">
                              <?php endif;?>
                            </td>
                          </tr>
                          <?php endforeach; ?>
                          </tbody>
                          </table>
                        </div>
                      </div>

                      <hr>

                      <div class="row" style="padding-top: 20px">
                        <div class="col-md-12">
                          <table class="table table-striped" id="po_items" style="width: 100%">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Item Type</th>
                              <th>Description</th>
                              <th>Qty</th>
                              <th>UoM</th>
                              <th>Unit Price</th>
                              <th>Total</th>
                            </tr>
                          </thead>
                          <tbody>
                          <?php $est_total_price = $total_price = 0 ?>
                          <?php if (count($po_items) > 0): ?>
                            <?php foreach($po_items as $i => $item): ?>
                            <tr>
                              <td><?= $i + 1 ?></td>
                              <td><?= @$opt_item_type[$item->id_itemtype] ?></td>
                              <td><?= $item->material_desc?></td>
                              <td><?= numEng($item->qty) ?></td>
                              <td><?= $item->uom_desc ?></td>
                              <td><span style="text-align:right"><?= numEng($item->unitprice) ?></span></td>
                              <td><span style="text-align:right"><?= numEng($item->total_price) ?></span></td>
                            </tr>
                            <?php
                              $est_total_price += $item->est_total_price ;
                              $total_price += $item->total_price;
                            ?>
                            <?php endforeach; ?>
                          </tbody>
                          <tfoot>
                            <tr>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td></td>
                              <td><span style="text-align:right">Total</span></td>
                              <td><span style="text-align:right"><?= numEng($total_price) ?></span></td>
                            </tr>
                          </tfoot>
                          <?php endif; ?>
                          </table>
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
                              <span aria-hidden="true">Ã—</span>
                            </button>
                          </div>
                          <div id="attachment-list" style="padding-bottom: 20px">

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
                              <div class="col-md-3"><?php /* upload by */ ?>
                                <label>Uploaded By</label>
                              </div>
                            </div>
                            <!-- start attachment -->

                            <?php /* TODO: use something like can_upload_document() ? */ ?>
                            <?php if ($po->completed != 1): ?>
                              <div class="row">
                                <div class="col-md-2"><?php /* type */ ?>
                                  <?= $po_attachment_type[$this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO] ?>
                                </div>
                                <div class="col-md-1"><?php /* sequence */ ?></div>
                                <div class="col-md-3">
                                  <input type="file" name="attachment_<?= $this->M_purchase_order_attachment::TYPE_COUNTER_SIGNED_PO ?>">
                                </div>
                                <div class="col-md-3"></div>
                                <div class="col-md-3"></div>
                              </div>
                            <?php endif; ?>

                        <?php if (isset($po_attachments) && count($po_attachments) > 0 ): ?>
                          <?php foreach($po_attachments as $attachment): ?>
                          <div class="row">
                            <div class="col-md-2"><?php /* type */ ?>
                              <?= $po_attachment_type[$attachment->tipe]?>
                            </div>
                            <div class="col-md-1"><?php /* sequence */ ?>
                              <?= $attachment->sequence ?>
                            </div>
                            <div class="col-md-3">
                              <a href="<?= base_url($attachment->file_path.$attachment->file_name) ?>" target="_blank"><?= $attachment->file_name ?></a>
                            </div>
                            <div class="col-md-3"><?= dateToIndo($attachment->created_at,false,true) ?> </div>
                            <div class="col-md-3"><?= $attachment->created_by_name ?></div>
                          </div>
                          <?php endforeach; ?>
                        <?php endif; ?>

                      </div>  <!-- end attachment -->
                    </div>
                  </div>
                </fieldset>


                <h6><i class="step-icon icon-directions"></i>Completeness</h6>
                <fieldset>
                <?php foreach($po_required_doc as $po_rdoc): ?>
                <div class="row open-this">
                  <div class="col-md-12">
                  <h6><?=
                  $po_rdoc->doc_type == $this->M_purchase_order_document::TYPE_OTHER ?
                    $po_rdoc->description :
                    $po_document_type[$po_rdoc->doc_type]
                  ?></h6>

                  <?php if ($po_rdoc->doc_type != $this->M_purchase_order_document::TYPE_OTHER): ?>
                  <button type="button" role="button" id="Add<?= $po_rdoc->doc_type?>" data-doc_type="<?= $po_rdoc->doc_type?>" data-doc_type_name="<?= $po_document_type[$po_rdoc->doc_type] ?>" class="btn btn-success pull-right po-document-open-btn" data-toggle="modal" data-target="#po_document_modal">Add</button>
                  <?php endif; ?>
                  </div>
                </div>
                <div class="row">
                  <?php if ($po_rdoc->doc_type != $this->M_purchase_order_document::TYPE_OTHER): ?>
                  <div class="col-md-12">
                    <table id="po_required_doc<?= $po_rdoc->doc_type?>" class="po_document_table table table-striped" style="width: 100%">
                      <thead>
                        <tr>
                        </tr>
                      </thead>
                    </table>
                  </div>
                  <?php else: ?>
                  <div class="col-md-4" class="open-this">
                  <?php $time = time() ?>
                  <input type="file" name="attachment" data-doc_id="<?= $time ?>" id="po_document<?= $po_rdoc->doc_type?>_file" class="form-control required">
                    </div>
                    <?php endif; ?>
                  </div>
                  <hr>
                  <?php endforeach; ?>
                </fieldset>
              <div id="po_document_data_table" class="open-this"></div>
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

<!-- modal #po_document_modal -->
<div class="modal fade text-left open-this" id="po_document_modal" role="dialog" aria-labelledby="modallabel-item" aria-hidden="true">
<div class="modal-dialog modal-sm" role="document">
<div class="modal-content">

<div class="modal-header">
<h4 class="modal-title" id="modal-label-item">Document</h4>
<button type="button" class="close" data-dismiss="modal" aria-label="Close">
  <span aria-hidden="true">&times;</span>
</button>
</div>

<div class="modal-body">
<form action="#" id="po_document-add_form">
        <div class="modal-body">
          <input type="hidden" id="po_document-doc_type" name="doc_type">
          <input type="hidden" id="po_document-po_id" name="po_id" value="<?= $po->id ?>">
          <input type="hidden" id="po_document-doc_id" name="doc_id">
          <input type="hidden" id="po_document-id" name="id">
          <div class="form-group">
            <label><span id="po_document-no_label">No</span></label>
            <input type="text" id="po_document-doc_no" name="doc_no" class="form-control">
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="po_document-issuer">Issuer: </label>
                <input type="text" name="issuer" id="po_document-issuer" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="po_document-issued_date">Issued date: </label>
                <input name="issued_date" id="po_document-issued_date" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="po_document-value">Value: </label>
                <input type="text" name="value" id="po_document-value" class="form-control" number="true" min="0">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="currency_name">Currency: </label>
                <input type="hidden" name="currency_id" id="po_document-currency_id" value="<?= $po->id_currency ?>">
                <input readonly name="currency_name" id="po_document-currency_name" value="<?= @$opt_currency[$po->id_currency] ?>" class="form-control">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="effective_date">Effective date: </label>
                <input name="effective_date" id="po_document-effective_date" class="form-control pickadate">
              </div>
            </div>
          </div>


          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="expired_date">Expired date: </label>
                <input name="expired_date" id="po_document-expired_date" class="form-control pickadate">
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="po_document-description">Description: </label>
                <textarea name="description" id="po_document-description" class="form-control"></textarea>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-12">
              <div class="form-group">
                <label for="attachment">Description: </label>
                <input type="file" name="attachment" id="po_document-attachment" class="form-control">
              </div>
            </div>
          </div>

        </div>
      </form>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
      <button type="button" class="btn btn-primary" id="po_document-add">Add</button>
    </div>
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
var po_document_types = <?= json_encode(@$po_document_type ?: []) ?>

var po_required_doc = <?= json_encode(@$po_required_doc ?: [])?>

$(function() {
  $('#po_document-value').number(true, 2);
});

function Cart() {
  this.items = [];
  this.datatable;

  this.add = function (doc_id, doc_no, doc_type, issuer, issued_date, value, currency_id,
    currency_name, effective_date, expired_date, status, description, file_name, file_url) {
    var item = new ItemCart();

    item.doc_id = doc_id
    item.doc_no = doc_no
    item.doc_type = doc_type
    item.issuer = issuer
    item.issued_date = issued_date
    item.value = value
    item.currency_id = currency_id
    item.currency_name = currency_name
    item.effective_date = effective_date
    item.expired_date = expired_date
    item.status = status
    item.description = description
    item.file_name = file_name
    item.file_url = file_url

    this.items.push(item);

    return item
  }

  this.remove = function (index) {
    if (index in this.items) {
      this.items.splice(index, 1);
    }
  }

  this.update = function (index, doc_id, doc_no, doc_type, issuer, issued_date, value,
    currency_id, currency_name, effective_date, expired_date, status, description, file_name,
    file_url) {
    if (index in this.items) {
      var item = this.items[index]

      item.doc_id = doc_id
      item.doc_no = doc_no
      item.doc_type = doc_type
      item.issuer = issuer
      item.issued_date = issued_date
      item.value = value
      item.currency_id = currency_id
      item.currency_name = currency_name
      item.effective_date = effective_date
      item.expired_date = expired_date
      item.status = status
      item.description = description
      item.file_name = file_name
      item.file_url = file_url

      this.items[index] = item

      return item
    }
  }

}

function ItemCart() {
    this.doc_id
    this.doc_no
    this.doc_type
    this.issuer
    this.issued_date
    this.value = 0
    this.currency_id
    this.currency_name
    this.effective_date
    this.expired_date
    this.status
    this.description
    this.file
    this.file_url
}

function dump_po_document_table(data) {
    $('#po_document_data_table').html('')

    data.forEach(function(elem, k) {
        for (name in elem) {
          var input = document.createElement('input')
          input.type = "hidden"
          input.name = 'po_document['+ k + '][' + name + ']'
          input.value = elem[name]

          $('#po_document_data_table').append(input)
        }
    })
}

var document_cart = [];
for (var doc in po_required_doc) {
    document_cart[po_required_doc[doc].doc_type] = new Cart;
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
    'finish': 'Completeness'
  },
  onFinishing: function (event, currentIndex)
  {
    form.validate({
      ignore: ":disabled",
      errorPlacement: function(error, element) {
        error.insertBefore($(element).parents('.form-group'));
      },
    })
    if (!form.valid()) {
      swal('Error', 'Please fill out required fields', 'error');
      return false;
    }

    var error = 0;
    for (var doc_type in document_cart) {
      // TODO: check in document_cart directly
      if (doc_type != 3 && $('#po_required_doc'+doc_type).DataTable().rows().data().length == 0) {
        error++
      }
    }

    if (error > 0) {
      swal('Error', 'Please add document', 'error')
      return false
    }

    return true;
  },
  onFinished: function (event, currentIndex)
  {
    /*
    var data_send = []

    var i = 0;
    for (var doc_type in document_cart) {
      var table_data = $('#po_required_doc'+doc_type).DataTable().rows().data()

      if (document_cart[doc_type].items.length > 0) {
        document_cart[doc_type].items.forEach(function(v, k) {
          var doc_files_elem = $('#po_document'+v.doc_type+'-'+v.doc_id+'_file')

          // rename input file property
          // $('#po_document'+ v.doc_type + '-' + v.doc_id + '_file')
          //   .prop('name', 'po_document-file_name['+  +']')

          data_send[i] = v

          i++
        })
      }
    }

    // check is any data added ?
    if (data_send.length == 0) {
      alert('No data provided')
      return false
    }

    // check is any required file missed ?

    console.log(data_send)
    console.debug(data_send)

    dump_po_document_table(data_send)
    */

    if (confirm("Are you sure want to submit?")) {
        /*
        $(this).toggleButton('finish', false)
        var url = '<?= base_url("procurement/purchase_order/createAgreement/{$po->id}") ?>'
        $.post(url, data)
         .done(function() {

         })
         .fail(function() {

         })
         .always(function() {
            $(this).toggleButton('finish', true)
         })
         */
        form.submit();
    }
  }
});

//hide next and previous button
$('a[href="#next"]').hide();
$('a[href="#previous"]').hide();

form.validate({
 ignore: ':disabled',
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
});

var po_date = $('#po_date').datetimepicker({
  format: 'D MMMM YYYY',
})
.data('DateTimePicker').date(new Date('<?= set_value('po_date_submit', $po->po_date) ?>')).disable()

var delivery_date = $('#delivery_date').datetimepicker({
  format: 'D MMMM YYYY',
})
.data('DateTimePicker').date(new Date('<?= set_value('delivery_date_submit', $po->delivery_date) ?>')).disable()
2247
$('#po_document-issued_date, #po_document-expired_date, #po_document-effective_date')
.datetimepicker({
  format: 'D MMMM YYYY',
})

<?php foreach($po_required_doc as $po_rdoc): ?>
<?php if ($po_rdoc->doc_type != $this->M_purchase_order_document::TYPE_OTHER): ?>
$('#po_required_doc<?= $po_rdoc->doc_type ?>').DataTable({
  "paging"    : false,
  "info"      : false,
  "searching" : false,
  "ordering"  : false,
  "processing": true,
  "columns"   : [
    { 'data': 'doc_id', 'title': 'ID', 'visible': false },
    { 'data': 'doc_type', 'title': 'Doc Type', 'visible': false },
    { 'data': 'doc_no', 'title': 'Doc No' },
    { 'data': 'issuer', 'title': 'Issuer' },
    { 'data': 'issued_date', 'title': 'Issued date' },
    { 'data': 'value', 'title': 'Value' },
    { 'data': 'currency_id', 'title': 'Currency', 'visible': false },
    { 'data': 'currency_name', 'title': 'Currency' },
    { 'data': 'effective_date', 'title': 'Effective date' },
    { 'data': 'expired_date', 'title': 'Expired date' },
    { 'data': 'description', 'title': 'Description' },
    { 'data': 'file_name', 'title': 'File', 'createdCell': function(td, cellData, rowData, row, col) {
        var file_name = ''
        if (rowData.file_name) {
          file_name = rowData.file_name
        }
        $(td).html('<a href="'+ rowData.file_url +'">'+ file_name + '</a>')
    }},
    { 'data': 'file_url', 'title': 'File URL', 'visible': false }
  ]
});

$.get('<?= base_url('procurement/purchase_order/getPODocumentAgreement/'.$po->id.'/'.$po_rdoc->doc_type) ?>')
.done(function(data) {
  data.data.forEach(function(d) {
    var item = document_cart[<?= $po_rdoc->doc_type?>].add(
      d.doc_id,
      d.doc_no,
      d.doc_type,
      d.issuer,
      d.issued_date,
      d.value,
      d.currency_id,
      d.currency_name,
      d.effective_date,
      d.expired_date,
      d.status,
      d.description,
      d.file_name,
      d.file_url
      )

      $('#po_required_doc<?= $po_rdoc->doc_type ?>').DataTable().row.add(item)
  })

  $('#po_required_doc<?= $po_rdoc->doc_type ?>').DataTable().draw()
})

<?php else: ?>
$.get('<?= base_url('procurement/purchase_order/getPODocumentAgreement/'.$po->id.'/'.$po_rdoc->doc_type) ?>')
.done(function(data) {
  if (data.data.length > 0) {
    data.data.forEach(function(d) {
      var item = document_cart[<?= $po_rdoc->doc_type?>].add(
        d.doc_id,
        d.doc_no,
        d.doc_type,
        d.issuer,
        d.issued_date,
        d.value,
        d.currency_id,
        d.currency_name,
        d.effective_date,
        d.expired_date,
        d.status,
        d.description,
        d.file_name,
        d.file_url
        )

      var p = $('#po_document3_file').parent()
      $('#po_document3_file').val('').prop('disabled', true).removeClass('required').hide()
      var file_name = ''
      if (d.file_name) {
        file_name = d.file_name
      }
      p.append('<a href="'+ d.file_url +'">'+ d.file_name +'</a>');
    })


    return true
  }

  $('#po_document3_file').val('').prop('disabled', false).addClass('required').show()
})

<?php endif; ?>

<?php endforeach; ?>

$('#po_document_modal').on('show.bs.modal', function(event) {
  $(this).find("form :input")
    .not('input[name=po_document-currency_id], input[name=po_document-currency_name]')
    .prop('disabled', false)
     $('#po_document-doc_no').val('')
     $('#po_document-issuer').val('')
     $('#po_document-issued_date').val('')
     $('#po_document-value').val('')
     $('#po_document-effective_date').val('')
     $('#po_document-expired_date').val('')
     $('#po_document-status').val('')
     $('#po_document-description').val('')
})
.on('hide.bs.modal', function(event) {
   // $(this).find('form')[0].reset();
});

$('.po-document-open-btn').click(function() {
    $("#po_document_modal form :input").prop('disabled', false)

    var doc_type = $(this).data('doc_type')
    var document_name = po_document_types[doc_type]

    $('#po_document_modal').find('form')[0].reset();
    $('#po_document-doc_type').val(doc_type)
    $('#po_document-no_label').text(document_name + ' No')
    $('#po_document_modal #modal-label-item').text(document_name + ' Document')

    $('#po_document_modal').modal('show')
});

$('#po_document-add').click(function(e) {
    var modal = $('#po_document_modal');

    var doc_id = (new Date).getTime();
    $('#po_document-doc_id').val(doc_id);
    var doc_type = $('#po_document-doc_type').val()
    var doc_no = $('#po_document-doc_no').val()
    var issuer = $('#po_document-issuer').val()
    var issued_date = $('#po_document-issued_date').val()
    var value = $('#po_document-value').val()
    var currency_id = $('#po_document-currency_id').val()
    var currency_name = $('#po_document-currency_name').val()
    var effective_date = $('#po_document-effective_date').val()
    var expired_date = $('#po_document-expired_date').val()
    var status = $('#po_document-status').val()
    var description = $('#po_document-description').val()
    var file_name = ''
    var file_url = ''

    var formdata = new FormData($('#po_document-add_form')[0])
    formdata.set('issued_date', moment(issued_date).format('YYYY-MM-DD'))
    formdata.set('effective_date', moment(effective_date).format('YYYY-MM-DD'))
    formdata.set('expired_date', moment(expired_date).format('YYYY-MM-DD'))

    var result;
    $.ajax({
      url: '<?= base_url('procurement/purchase_order/uploadPODocumentAgreement') ?>',
      data: formdata,
      enctype: 'multipart/form-data',
      processData: false,
      contentType: false,
      async: false,
      method: "POST",
    })
    .done(function(data) {
       result = data
       if (data.type == 'success') {
         toastr.success(data.message)
       } else {
         toastr.error(data.message)
       }
    })
    .fail(function(data) {
        toast.error('Something error happened on server')
    })
    .always()

    if (result.type == 'error') {
        return false
    }

    file_url = result.data.file_url
    file_name = result.data.file_name

    var item = document_cart[doc_type].add(doc_id, doc_no, doc_type, issuer, issued_date,
        Localization.number(value), currency_id, currency_name, effective_date, expired_date, status, description,
        file_name, file_url)

    console.debug(item)
    console.log(item)

    var datatable = $('#po_required_doc'+doc_type).DataTable().row.add(item).draw()

    modal.modal('hide')
})

$('#tkdn_type').change(function(e) {
  var val =  $(this).val();
  var goods_elem = $('#tkdn_value_goods'),
      service_elem = $('#tkdn_value_service'),
      combination_elem = $('#tkdn_value_combination')

  switch(val) {
    case '1': // Goods
      goods_elem.attr('disabled', true).addClass('required')
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
      service_elem.attr('disabled', true).addClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').show()
      combination_elem.val('').attr('disabled', true).removeClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').hide()
      break;
    case '3': // Combination
      goods_elem.val('').attr('disabled', true).addClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').show()
      service_elem.val('').attr('disabled', true).addClass('required')
        .attr('max', 100).attr('min', 0)
        .closest('div').show()
      combination_elem.attr('disabled', true).addClass('required')
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
})

$('#tkdn_type').change()
$('#po_document3_file').change(function(e) {
  console.log(e)

  var doc_id = (new Date).getTime();
  var doc_type = 3
  var doc_no = ''
  var issuer = ''
  var issued_date = ''
  var value = ''
  var currency_id = ''
  var currency_name = ''
  var effective_date = ''
  var expired_date = ''
  var status = ''
  var description = ''
  var file_name = ''
  var file_url = ''

  var formdata = new FormData()
  formdata.set('attachment', $('#po_document'+doc_type+'_file')[0].files[0])
  formdata.set('doc_id', doc_id)
  formdata.set('po_id', $('input[name=po_id]').val())
  formdata.set('doc_type', doc_type)

  var result;
  $.ajax({
    url: '<?= base_url('procurement/purchase_order/uploadPODocumentAgreement') ?>',
    data: formdata,
    enctype: 'multipart/form-data',
    processData: false,
    contentType: false,
    async: false,
    method: "POST",
  })
  .done(function(data) {
     result = data
     if (data.type == 'success') {
       toastr.success(data.message)
     } else {
       $('#po_document3_file').val('')
       toastr.error(data.message)
     }
  })
  .fail(function(data) {
      toast.error('Something error happened on server')
      console.error(data)
  })
  .always()

  if (result.type == 'error') {
      return false
  }

  file_url = result.data.file_url
  file_name = result.data.file_name

  var item = document_cart[doc_type].add(doc_id, doc_no, doc_type, issuer, issued_date,
      value, currency_id, currency_name, effective_date, expired_date, status, description,
      file_name, file_url)

  console.debug(item)
  console.log(item)

  var p = $('#po_document3_file').parent()
  $('#po_document3_file').val('').removeClass('required').hide()
  p.append('<a href="'+ file_url +'">'+ file_name +'</a>');
})

setTimeout(function() {
    $(':input[type=file]').prop('disabled', false)
}, 1000);

<?php if ($po->po_type != $this->M_purchase_order_type::TYPE_GOODS): ?>
$('#id_dpoint').parent().parent().hide()
$('#shipping_term').parent().parent().hide()
$('#id_importation').parent().parent().hide()
<?php endif; ?>

});
</script>
<?php /* vim: set fen foldmethod=indent ts=2 sw=2 tw=0 et autoindent :*/ ?>
