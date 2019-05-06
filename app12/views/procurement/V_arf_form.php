<div class="row info-header">
    <div class="col-md-6">
        <table class="table table-condensed">
            <tbody>
                <tr>
                    <td width="150px">Subject</td>
                    <td width="1px">:</td>
                    <td><span id="po-title"></span></td>
                </tr>
                <tr>
                    <td>Requestor</td>
                    <td>:</td>
                    <td><span id="po-requestor"></span></td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>:</td>
                    <td><span id="po-department"></span></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-6">
         <table class="table table-condensed">
            <tbody>
                <tr>
                    <td width="150px">Total (Excl. VAT)</td>
                    <td width="1px">:</td>
                    <td class="text-right">
                        <span data-m="currency"></span>
                        <span id="arf_excl_vat">0.00</span><br>
                        <small>
                            <span id="excl_total_equal_to" style="display: none;">
                                (equal to <span data-m="currency_base"> <span id="excl_total_equal_to_val">0.00</span></span>)
                            </span>
                        </small>
                    </td>
                </tr>
                <tr>
                    <td>VAT</td>
                    <td>:</td>
                    <td class="text-right">
                        <span data-m="currency"></span>
                        <span id="vat">0.00</span><br>
                        <small>
                            <span id="vat_equal_to" style="display: none;">
                                (equal to <span data-m="currency_base"></span> <span id="vat_equal_to_val">0.00</span>)
                            </span>
                        </small>
                    </td>
                </tr>
                <tr>
                    <td>Total (Incl. VAT)</td>
                    <td>:</td>
                    <td class="text-right">
                        <span data-m="currency"></span>
                        <span id="arf_incl_vat">0.00</span><br>
                        <small>
                            <span id="incl_total_equal_to" style="display: none;">
                                (equal to <span data-m="currency_base"></span> <span id="incl_total_equal_to_val">0.00</span>)
                            </span>
                        </small>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <div id="wizard-arf" class="wizard-circle">
                <h6><i class="step-icon icon-info"></i> Header</h6>
                <fieldset>
                    <div class="form-group row">
                        <label class="col-md-2">ARF Reference<br><small>PO/SO/Contract No</small></label>
                        <div class="col-md-4">
                            <?= $this->form->hidden('po_id', null, 'id="po_id"') ?>
                            <?= $this->form->hidden('id_currency', null, 'id="id_currency"') ?>
                            <?= $this->form->hidden('currency', null, 'id="currency"') ?>
                            <?= $this->form->hidden('id_currency_base', null, 'id="id_currency_base"') ?>
                            <?= $this->form->hidden('currency_base', null, 'id="currency_base"') ?>
                            <?= $this->form->text('no_reference', null, 'id="no_reference" class="form-control" readonly') ?>
                            <small><a href="javascript:void(0)" id="browse-reference" onclick="browse('Agreement', '<?= base_url('procurement/browse/po?issued=1&creator='.$this->session->userdata('ID_USER')) ?>')"><i class="fa fa-search"></i> Browse Reference</a></small>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-md-5">
                            <div class="form-group row">
                                <label class="col-md-5">Title of Agreement</label>
                                <div class="col-md-7">
                                    <?= $this->form->text('po_title', null, 'id="po_title" class="form-control" readonly') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">Name of <span class="label-po_vendor_type">Vendor</span></label>
                                <div class="col-md-7">
                                    <?= $this->form->hidden('po_id_vendor', null, 'id="po_id_vendor"') ?>
                                    <?= $this->form->text('po_vendor', null, 'id="po_vendor" class="form-control" readonly') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">Company</label>
                                <div class="col-md-7">
                                    <?= $this->form->hidden('po_id_company', null, 'id="po_id_company"') ?>
                                    <?= $this->form->text('po_company', null, 'id="po_company" class="form-control" readonly') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">Agreement Date</label>
                                <div class="col-md-7">
                                    <?= $this->form->text('po_date', null, 'id="po_date" class="form-control" readonly') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <h4>Agreement Value (Excl. VAT)</h4>
                            <hr>
                            <div class="form-group row">
                                <label class="col-md-5">Original Value<br><small class="text-primary">(excluding any amendment)</small></label>
                                <div class="col-md-7">
                                    <?= $this->form->text('po_total', null, 'id="po_total" class="form-control text-right" readonly') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">Latest Value<br><small class="text-primary">(Original value plus previous amendment)</small></label>
                                <div class="col-md-7">
                                    <?= $this->form->text('po_latest_value', null, 'id="po_latest_value" class="form-control text-right" readonly') ?>
                                </div>
                                <input type="hidden" name="" id="po_latest_value_ori">
                            </div>
                            <h4>Agreement Remaining Value (Excl. VAT)</h4>
                            <hr>
                            <div class="form-group row">
                                <label class="col-md-5">Spending to Date<br><small class="text-primary"><!-- (comitted value incl.unpaid invoices) --></small></label>
                                <div class="col-md-7">
                                    <?= $this->form->text('po_spending_value', null, 'id="po_spending_value" class="form-control text-right" readonly') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">Remaining Value<br><small class="text-primary">(as of now)</small></label>
                                <div class="col-md-7">
                                    <?= $this->form->text('po_remaining_value', null, 'id="po_remaining_value" class="form-control text-right" readonly') ?>
                                </div>
                            </div>
							<h4><span>Agreement Delivery Date/Expiry Date</span></h4>
                            <hr>
                            <div class="form-group row">
                                <label class="col-md-5">Original Date<br><small class="text-primary">(as per orignal)</small></label>
                                <div class="col-md-7">
                                    <?= $this->form->text('po_delivery_date', null, 'id="po_delivery_date" class="form-control" readonly') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-5">Amended Date<br><small class="text-primary">(as amended by previous amendment)</small></label>
                                <div class="col-md-7">
                                    <?= $this->form->text('po_amended_date', null, 'id="po_amended_date" class="form-control" readonly') ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <h6><i class="step-icon icon-list"></i> Detail</h6>
                <fieldset>
                    <div class="row">
                        <div class="col-md-5">
                            <hr>
                            <div class="row">
                                <div class="col-md-8 text-center">
                                    <span style="font-weight: bold !important;">Type/Description</span>
                                    <br><small>(thick one when applicable)</small>
                                </div>
                                <div class="col-md-4 text-center">
                                    <span style="font-weight: bold !important;">Remarks</span>
                                </div>
                            </div>
                            <hr>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <?= $this->form->checkbox('value', 1, false, 'id="value" style="margin-right:10px;"') ?>
                                        <label>Value</label>
                                    </div>

                                </div>
                                <div class="col-md-4">
                                    <?= $this->form->text('value_value', null, 'id="value_value" class="form-control text-right" onkeyup="count_estimated_new_value()" disabled readonly') ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->form->text('value_remark', null, 'id="value_remark" class="form-control" disabled') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <?= $this->form->checkbox('time', 1, false, 'id="time" style="margin-right:10px;"') ?>
                                        <label>Time</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->form->text('time_value', null, 'id="time_value" class="form-control text-right" disabled') ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->form->text('time_remark', null, 'id="time_remark" class="form-control" disabled') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <?= $this->form->checkbox('scope', 1, false, 'id="scope" style="margin-right:10px;"') ?>
                                        <label>Scope</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->form->text('scope_value', null, 'id="scope_value" class="form-control text-right" disabled') ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->form->text('scope_remark', null, 'id="scope_remark" class="form-control" disabled') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-md-4">
                                    <div class="form-inline">
                                        <?= $this->form->checkbox('other', 1, false, 'id="other" style="margin-right:10px;"') ?>
                                        <label>Other</label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->form->text('other_value', null, 'id="other_value" class="form-control text-right" disabled') ?>
                                </div>
                                <div class="col-md-4">
                                    <?= $this->form->text('other_remark', null, 'id="other_remark" class="form-control" disabled') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-6">Estimated New Value</label>
                                <div class="col-md-6">
                                    <?= $this->form->text('estimated_new_value', null, 'id="estimated_new_value" class="form-control text-right" readonly') ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-6">Expected commencement date of this Amendment</label>
                                <div class="col-md-6">
                                    <?= $this->form->text('expected_commencement_date', null, 'id="expected_commencement_date" class="form-control"') ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-7">
                            <table class="table table-bordered" style="margin-bottom: 0px;">
                                <thead>
                                    <tr>
                                        <th>Additional Explanation</th>
                                    </tr>
                                    <tr>
                                        <td>The justification for this Amendment has met the criteria below, as stipulated in the applicable procedure (can be more then on)</td>
                                    </tr>
                                </thead>
                            </table>
                            <div style="max-height: 200px; overflow-y: auto;">
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <?php foreach ($this->m_procurement->get_reason('arf') as $reason) { ?>
                                                <tr>
                                                    <td width="1px"><?= $this->form->checkbox('reason['.$reason->id.'][id]', $reason->id, false, 'onchange="check_reason(\''.$reason->id.'\')"') ?></td>
                                                    <td>
                                                        <?= $reason->description ?>
                                                        <?php if ($reason->addendum_required) { ?>
                                                            <?= $this->form->text('reason['.$reason->id.'][reason]', null, 'class="form-control pull-right" style="display:none"') ?>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div id="po-detail" style="display: none;">
                        <h4>Original</h4>
                        <div class="table-responsive mb-1">
                            <table width="100%" id="po_item-table" class="table table-no-wrap">
                                <thead>
                                    <tr>
                                        <th>Item Type</th>
                                        <th>Description of Unit</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">UoM</th>
                                        <th>Item Modification</th>
                                        <th>Inv Type</th>
                                        <th>Cost Center</th>
                                        <th>Account Subsidiary</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="form-group row">
                            <label class="offset-md-6 col-md-3">Total</label>
                            <div class="col-md-3">
                                <?= $this->form->text('po_detail_total', null, 'id="po_detail_total" class="form-control text-right" disabled') ?>
                            </div>
                        </div>
                        <?php $this->load->view('procurement/V_arf_form_last_amd');?>
                        <input type="hidden" name="amd_total" id="amd_total" value="0">
                        <div class="row">
                            <div class="col-md-6">
                                <h4>Amendment</h4>
                            </div>
                            <div class="col-md-6 text-right">
                                <button type="button" id="btn-add-item" class="btn btn-primary">Add New Item</button>
                            </div>
                        </div><br>
                        <div class="table-responsive mb-1">
                            <table id="arf_item-table" class="table table-no-wrap">
                                <thead>
                                    <tr>
                                        <th>Item Type</th>
                                        <th>Description of Unit</th>
                                        <th class="text-center">Qty</th>
                                        <th class="text-center">UoM</th>
                                        <th class="text-center">Item Modification</th>
                                        <th>Inv Type</th>
                                        <th>Cost Center</th>
                                        <th>Account Subsidiary</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                            </table>
                        </div>
                        <div class="form-group row">
                            <label class="offset-md-6 col-md-3">Total</label>
                            <div class="col-md-3">
                                <?= $this->form->text('arf_detail_total', null, 'id="arf_detail_total" class="form-control text-right" disabled') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="offset-md-6 col-md-3">Total Summary</label>
                            <div class="col-md-3">
                                <?= $this->form->text('po_arf_total', null, 'id="po_arf_total" class="form-control text-right" disabled') ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <h6><i class="step-icon icon-calculator"></i> Budget</h6>
                <fieldset >
                    <!--<table id="budget_item-table" class="table table-bordered table-no-wrap table-sm" style="font-size: 11px;">
                        <thead>
                            <tr>
                                <th rowspan="2" style="line-height: 40px; width: 200px;">Description</th>
                                <th colspan="4" class="text-center">Lastest Value</th>
                                <th colspan="4" class="text-center">Amendment No</th>
                                <th rowspan="2" class="text-right" style="line-height: 40px; width: 150px;">Total</th>
                            </tr>
                            <tr>
                                <th class="text-center">Est.Qty</th>
                                <th class="text-center">UOM</th>
                                <th class="text-center">Unit Price</th>
                                <th class="text-center">Sub Total</th>
                                <th class="text-center">Est.Qty</th>
                                <th class="text-center">UOM</th>
                                <th class="text-center">Unit Price</th>
                                <th>Sub Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>-->
                    <div class="mb-1">
                        <span id="exchange-rate"></span>
                    </div>
                    <div class="table-responsive">
                        <table id="budget_item-table" class="table table-no-wrap">
                            <thead>
                                <tr>
                                    <th rowspan="2">Cost Center</th>
                                    <th rowspan="2">Account Subsidiary</th>
                                    <th rowspan="2" class="text-center">Currency</th>
                                    <th rowspan="2" class="text-center">Booking Amount</th>
                                    <th colspan="3" class="text-center">Available Budget</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Cost Center Value</th>
                                    <th class="text-center">Acc.Subsidiary Value</th>
                                    <th class="text-center">Status Budget</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                    <table class="table">
                        <tr>
                            <td width="1px" style="padding-left: 0px !important;">
                                <?php if (strpos($this->session->userdata('ROLES'), ','.$this->m_arf_approval->bsd_staf_id.',') === FALSE) { ?>
                                    <?= $this->form->checkbox('review_bod', 1, false, 'id="review_bod" disabled') ?>
                                <?php } else { ?>
                                    <?= $this->form->checkbox('review_bod', 1, false, 'id="review_bod"') ?>
                                <?php } ?>
                            </td>
                            <td>
                                BOD Approval for this Amendment Request is required<br>
                                <small>BSD to give check mark on this box if the Amendment Request is coming from the Agreement with Original Value or Latest Value or Latest Value plus estimated additional Value of more than USD 100,000</small>
                            </td>
                    </table>
                </fieldset>
                <h6><i class="step-icon icon-paper-clip"></i> Attachment</h6>
                <fieldset>
                    <div class="form-group text-right">
                        <button type="button" id="btn-attachment" class="btn btn-primary">Upload File</button>
                    </div>
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
                </fieldset>
                <?php if (isset($allowed_approve)) { ?>
                    <?php $this->load->view('procurement/partials/arf_approval') ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="browse-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="browse-modal-title" class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="browse-modal-body" class="modal-body">

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="add-item-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-form" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="add-item-modal-title" class="modal-title">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-5">Item Type</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_item_type', lists($this->m_procurement->get_item_type(), 'ID_ITEMTYPE', 'ITEMTYPE_DESC', 'Please Select'), null, 'id="add-item-id_item_type" class="form-control" style="width:100%"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Category</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_item_type_category', array('' => 'Please Select'), null, 'id="add-item-id_item_type_category" class="form-control"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5"><span class="add-item-label-semic_no">Semic No.</span></label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_semic_no', array('' => 'Please Select'), null, 'id="add-item-semic_no" class="form-control" style="width:100%"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Description of Unit</label>
                            <div class="col-md-7">
                                <?= $this->form->textarea('add_item_description_of_unit', null, 'id="add-item-description_of_unit" class="form-control" style="height:100px;" disabled') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Classification</label>
                            <div class="col-md-7">
                                <?= $this->form->text('add_item_classification', null, 'id="add-item-classification" class="form-control" disabled') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Group/Category</label>
                            <div class="col-md-7">
                                <?= $this->form->text('add_item_category', null, 'id="add-item-category" class="form-control" disabled') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="add-item-form-group-id_inventory_type" class="form-group row" style="display: none;">
                            <label class="col-md-5">Inventory Type</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_inventory_type', lists($this->m_procurement->get_msr_inventory_type(), 'id', 'description', 'Please Select'), null, 'id="add-item-id_inventory_type" class="form-control"') ?>
                            </div>
                        </div>
                        <div id="add-item-form-group-item_modification" class="form-group row" style="display: none;">
                            <label class="col-md-5">Item Modification</label>
                            <div class="col-md-7">
                                <?= $this->form->checkbox('add_item_item_modification', 1, false, 'id="add-item-item_modification"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Required Qty/UoM</label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $this->form->text('add_item_qty', null, 'id="add-item-qty" class="form-control text-center" onkeyup="add_item_count_total()"') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $this->form->select('add_item_uom', array('' => 'Please Select'), null, 'id="add-item-uom" class="form-control" disabled') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Est.Unit Price</label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?= $this->form->text('add_item_est_unit_price', null, 'id="add-item-est_unit_price" class="form-control text-right" onkeyup="add_item_count_total()"') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $this->form->hidden('add_item_est_unit_price_id_currency', null, 'id="add-item-est_unit_price_id_currency"') ?>
                                        <?= $this->form->text('add_item_est_unit_price_currency', null, 'id="add-item-est_unit_price_currency" class="form-control" disabled') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Est.Total Price</label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-8">
                                        <?= $this->form->text('add_item_est_total_price', null, 'id="add-item-est_total_price" class="form-control text-right" disabled') ?>
                                    </div>
                                    <div class="col-md-4">
                                        <?= $this->form->hidden('add_item_est_total_price_id_currency', null, 'id="add-item-est_total_price_id_currency" disabled') ?>
                                        <?= $this->form->text('add_item_est_total_price_currency', null, 'id="add-item-est_total_price_currency" class="form-control" disabled') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Cost Center</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_costcenter', array('' => 'Please Select'), null, 'id="add-item-id_costcenter" class="form-control"') ?>
                            </div>
                        </div>
                        <div id="add-item-form-group-id_account_subsidiary" class="form-group row" style="display: none;">
                            <label class="col-md-5">Account Subsidiary</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_account_subsidiary', array('' => 'Please Select'), null, 'id="add-item-id_account_subsidiary" class="form-control"') ?>
                            </div>
                        </div>
                        <div id="add-item-form-group-id_importation" class="form-group row" style="display:none;">
                            <label class="col-md-5">Importation</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_importation', lists($this->m_procurement->get_importation(), 'ID_IMPORTATION', 'IMPORTATION_DESC', 'Please Select'), null, 'id="add-item-id_importation" class="form-control"') ?>
                            </div>
                        </div>
                        <div id="add-item-form-group-id_delivery_point" class="form-group row" style="display:none;">
                            <label class="col-md-5">Delivery Point/Location</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_delivery_point', lists($this->m_procurement->get_delivery_point(), 'ID_DPOINT', 'DPOINT_DESC', 'Please Select'), null, 'id="add-item-id_delivery_point" class="form-control"') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn grey btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="add-item-btn-add-item">Add</button>
            </div>
        </div>
    </div>
</div>

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
                    <?= $this->form->select('attachment_modal_select_type', array('' => 'Please Select')+$this->m_arf_attachment->enum('type'), null, 'id="attachment-modal-select_type" class="form-control"') ?>
                </div>
                <div id="form-group-attachment-modal-type" class="form-group" style="display:none">
                    <?= $this->form->text('attachment_modal_type', null, 'id="attachment-modal-type" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Filename</label>
                    <?= $this->form->text('attachment_modal_file_name', null, 'id="attachment-modal-file_name" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>File</label>
                    <input type="file" name="attachment_modal_file" id="attachment-modal-file">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="attachment_upload()">Upload</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="validation-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Validation Checklist</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width="1px">#</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th width="1px">Check</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <th colspan="3">Header</th>
                            <th class="text-center"><span data-validation="header"></span></th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>ARF Reference</td>
                            <td>Required</td>
                            <td class="text-center"><span data-validation="po_id"></span></td>
                        </tr>
                        <tr>
                            <th colspan="3">Detail <small>(at least checked 1 revision)</small></th>
                            <th class="text-center"><span data-validation="detail"></span></th>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>Revision Value</td>
                            <td>Optional</td>
                            <td class="text-center"><span data-validation="value"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Amendment Value</td>
                            <td>Value must greater then zero</td>
                            <td class="text-center"><span data-validation="value_value"></span></td>
                        </tr>
                        <!--<tr>
                            <td></td>
                            <td>Amendment Item</td>
                            <td>Required if revision value checked</td>
                            <td class="text-center"><span data-validation="arf_item"></span></td>
                        </tr>-->
                        <tr>
                            <td>3</td>
                            <td>Revision Time</td>
                            <td>Optional</td>
                            <td class="text-center"><span data-validation="time"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Amendment Time</td>
                            <td>Required if revision time checked</td>
                            <td class="text-center"><span data-validation="time_value"></span></td>
                        </tr>
                         <tr>
                            <td>4</td>
                            <td>Revision Scope</td>
                            <td>Optional</td>
                            <td class="text-center"><span data-validation="scope"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Amendment Scope</td>
                            <td>Required if revision scope checked</td>
                            <td class="text-center"><span data-validation="scope_value"></span></td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>Revision Other</td>
                            <td>Optional</td>
                            <td class="text-center"><span data-validation="other"></span></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>Amendment Other</td>
                            <td>Required if revision other checked</td>
                            <td class="text-center"><span data-validation="other_value"></span></td>
                        </tr>
                        <tr>
                            <td>6</td>
                            <td>Additional Explanation</td>
                            <td>Required</td>
                            <td class="text-center"><span data-validation="reason"></span></td>
                        </tr>
                        <tr>
                            <td>7</td>
                            <td>Expected commencement date of this Amendment</td>
                            <td>Required</td>
                            <td class="text-center"><span data-validation="expected_commencement_date"></span></td>
                        </tr>
                        <tr>
                            <th colspan="3">Budget</th>
                            <th class="text-center"><span data-validation="budget"></th>
                        </tr>
                        <tr>
                            <td>8</td>
                            <td>Budget</td>
                            <td>Optional</td>
                            <td class="text-center"><span data-validation="budget"></td>
                        </tr>
                        <tr>
                            <th colspan="3">Attachment</th>
                            <th class="text-center"><span data-validation="attachment"></th>
                        </tr>
                        <tr>
                            <td>9</td>
                            <td>Owner Estimate</td>
                            <td>Required if revision value checked</td>
                            <td class="text-center"><span data-validation="attachment_value"></td>
                        </tr>
                        <tr>
                            <td>10</td>
                            <td>Scope of Work/Supply</td>
                            <td>Required if revision scope checked</td>
                            <td class="text-center"><span data-validation="attachment_scope"></td>
                        </tr>
                    </tbody>
                </table>
                <?php if (isset($allowed_approve)) { ?>
                    <div class="form-group">
                        <textarea name="submit_note" id="submit_note" class="form-control" placeholder="Note" style="display: none;"></textarea>
                    </div>
                <?php } ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!--<button type="button" id="btn-save-draft" class="btn btn-primary" style="display: none;">Save Draft</button>-->
                <button type="button" id="btn-submit" class="btn btn-success" style="display: none;">Submit</button>
                <?php if (isset($allowed_approve)) { ?>
                    <?php if ($allowed_approve->sequence == 1) { ?>
                        <button type="button" id="btn-resubmit" class="btn btn-success" style="display: none;">Resubmit</button>
                    <?php } else { ?>
                        <?php if ($allowed_approve->edit_content == 1) { ?>
                            <button type="button" id="btn-update-approve" class="btn btn-success" style="display: none;">Update & Approve</button>
                        <?php } ?>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</div>