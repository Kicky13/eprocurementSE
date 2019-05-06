<?php
    $opt_msr_type = array('' => 'Please Select') + @$opt_msr_type;
    $opt_pmethod = array('' => 'Please Select') + @$opt_pmethod;
    $opt_plocation = array('' => 'Please Select') + @$opt_plocation;
    $opt_uom = array('' => '-') + @$opt_uom;
    $opt_currency = array('' => '-') + @$opt_currency;
    // $opt_cost_center = array('' => 'Please Select') + @$opt_cost_center;
    $opt_location = array('' => 'Please Select') + @$opt_location;
    $opt_delivery_point = array('' => 'Please Select') + @$opt_delivery_point;
    $opt_delivery_term = array('' => 'Please Select') + @$opt_delivery_term;
    $opt_importation = array('' => 'Please Select') + @$opt_importation;
    $opt_requestfor = array('' => 'Please Select') + @$opt_requestfor;
    $opt_inspection = array('' => 'Please Select') + @$opt_inspection;
    $opt_freight = array('' => 'Please Select') + @$opt_freight;
    $opt_itemtype = array('' => 'Please Select') + @$opt_itemtype;
    $opt_invtype = array('' => 'Please Select') + @$opt_invtype;
?>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 id="arfn_title1" class="content-header-title">
                    <?= lang("Persetujuan Notifikasi Amendment", "Amendment Notification Approval") ?>
                </h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Persetujuan Notifikasi Amendment", "Amendment Notification Approval") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-detached">
            <div class="content-body" id="container_list">
                <div class="card">
                    <div class="card-content">
                        <div class="card-body">
                            <div class="col-12 form-row prepared">
                                <table id="list1" class="table table-striped table-bordered table-hover display table-no-wrap" width="100%">
                                    <tfoot>
                                        <tr>
                                            <th>No</th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th></th>
                                            <th>Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="content-body" id="container_arf_notif" style="display: none;">
                <div class="row info-header">
                    <div class="col-md-4">
                        <table class="table table-condensed">
                            <tr>
                                <td width="30%">Title</td>
                                <td class="no-padding-lr">:</td>
                                <td><strong><span id="head_title"></span> </strong></td>
                            </tr>
                            <tr>
                                <td width="30%">Vendor</td>
                                <td class="no-padding-lr">:</td>
                                <td><strong><span id="head_vendor"></span> </strong></td>
                            </tr>
                            <tr>
                                <td width="30%">Company</td>
                                <td class="no-padding-lr">:</td>
                                <td><strong><span id="head_comp"></span> </strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <table class="table table-condensed">
                            <tr>
                                <td width="30%">Requestor</td>
                                <td class="no-padding-lr">:</td>
                                <td><strong><span id="head_rqstr"></span> </strong></td>
                            </tr>
                            <tr>
                                <td width="30%">Agreement No</td>
                                <td class="no-padding-lr">:</td>
                                <td><strong><span id="head_agrmnt"></span> </strong></td>
                            </tr>
                            <tr>
                                <td width="30%">Amendment No</td>
                                <td class="no-padding-lr">:</td>
                                <td><strong><span id="head_amend"></span> </strong></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-4">
                        <table class="table table-condensed">
                            <tr>
                                <td width="30%">Total (Excl. VAT)</td>
                                <td class="no-padding-lr">:</td>
                                <td class="text-right"><strong><span id="head_total"></span> </strong></td>
                            </tr>
                            <tr>
                                <td width="30%">VAT</td>
                                <td class="no-padding-lr">:</td>
                                <td class="text-right"><strong><span id="head_vat"></span> </strong></td>
                            </tr>
                            <tr>
                                <td width="30%">Total (Incl. VAT)</td>
                                <td class="no-padding-lr">:</td>
                                <td class="text-right"><strong><span id="head_total_vat"></span> </strong></td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="card">
                    <div class="card-content">
                        <div class="card-body body-step">
                            <div class="col-12 form-row x-tab" id="project-info">
                                <div class="steps clearfix">
                                    <input type="hidden" id="param_po"/>
                                    <input type="hidden" id="param_amd"/>
                                    <input type="hidden" id="param_notif"/>
                                    <input type="hidden" id="param_seq"/>
                                    <input type="hidden" id="param_draft"/>
                                    <input type="hidden" id="param_comp"/>
                                    <input type="hidden" id="page_show"/>
                                    <ul role="tablist" class="tablist">
                                        <li id="main-t-1">
                                            <button onclick="show_page(1)" id="main-b-1" class="project-info-icon btn btn-default">
                                               Amendment Request
                                            </button>
                                        </li>
                                        <li id="main-t-2">
                                            <button onclick="show_page(2)" id="main-b-2" class="project-info-icon btn btn-default">
                                                Schedule of Price
                                            </button>
                                        </li>
                                        <li id="main-t-3">
                                            <button onclick="show_page(3)" id="main-b-3" class="project-info-icon btn btn-default">
                                                Approval
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12" id="main-p-1">
                                <div id="main-c-1">
                                    <div class="col-md-12" style="padding-bottom: 1em;">
                                        Company intends to amend the above agreement. The amendment is to:
                                    </div>
                                    <div class="col-md-12">
                                        <form id="form_notif_revision">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th colspan="3" class="text-center">Type / Description<br><small>(tick one when applicable)</small></th>
                                                    <th class="text-center" style="vertical-align: top !important;">Remark</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td width="1px"><input type="checkbox" name="notif_value_check" id="notif_value_check" value="1" disabled/></td>
                                                    <td width="50px">Value</td>
                                                    <td width="150px"><input name="notif_value_input" id="notif_value_input" class="form-control-plaintext text-right" readonly></td>
                                                    <td><input name="notif_value_remark" id="notif_value_remark" class="form-control-plaintext" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td width="1px"><input type="checkbox" name="notif_time_check" id="notif_time_check" value="1" disabled/></td>
                                                    <td width="50px">Time</td>
                                                    <td width="150px"><input name="notif_time_input" id="notif_time_input" class="form-control-plaintext" readonly></td>
                                                    <td><input name="notif_time_remark" id="notif_time_remark" class="form-control-plaintext" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td width="1px"><input type="checkbox" name="notif_scope_check" id="notif_scope_check" value="1" disabled/></td>
                                                    <td width="50px">Scope</td>
                                                    <td width="150px"><input name="notif_scope_input" id="notif_scope_input" class="form-control-plaintext" readonly></td>
                                                    <td><input name="notif_scope_remark" id="notif_scope_remark" class="form-control-plaintext" readonly></td>
                                                </tr>
                                                <tr>
                                                    <td width="1px"><input type="checkbox" name="notif_other_check" id="notif_other_check" value="1" disabled/></td>
                                                    <td width="50px">Other</td>
                                                    <td width="150px"><input name="notif_other_input" id="notif_other_input" class="form-control-plaintext" readonly></td>
                                                    <td><input name="notif_other_remark" id="notif_other_remark" class="form-control-plaintext" readonly></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </form>
                                        <form id="form_notif_main">
                                        <div class="form-group row">
                                            <label class="col-md-2">Estimated New Value</label>
                                            <div class="col-md-4">
                                                <input name="notif_newval_input" id="notif_newval_input" class="form-control-plaintext text-right" readonly>
                                            </div>
                                            <label class="col-md-2">Expected commendment date of this Amendment</label>
                                            <div class="col-md-4">
                                                <input name="notif_comdate_input" id="notif_comdate_input" class="form-control-plaintext" readonly>
                                                <!-- <input name="notif_comdate_input" id="notif_comdate_input" class="form-control" disabled> -->
                                            </div>
                                        </div>
                                        </form>
                                    </div>
                                    <div class="col-md-12" style="padding-bottom: 1em; font-weight: bold;">
                                        Attachment
                                    </div>
                                    <div class="col-md-12">
                                        <table id="notif_upload_list" class="table table-striped table-bordered table-hover display" width="100%">
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-2">
                                <div id="main-c-2">
                                    <div class="col-md-12" style="padding-bottom: 1em; font-weight: bold;">
                                        List Item
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table width="100%" id="notif_item_ori" class="table table-no-wrap">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
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
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 2em; padding-bottom: 1em; font-weight: bold;">
                                        ARF List Item
                                    </div>
                                    <div class="col-md-12">
                                        <div class="table-responsive">
                                            <table width="100%" id="notif_item_arf" class="table table-no-wrap">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
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
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="notif_item_proc_placer">
                                        <div class="table-responsive">
                                            <table width="100%" id="notif_item_proc" class="table table-no-wrap">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th>Item Type</th>
                                                        <th>Description of Unit</th>
                                                        <th class="text-center">Qty 1</th>
                                                        <th class="text-center">UoM 1</th>
                                                        <th class="text-center">Qty 2</th>
                                                        <th class="text-center">UoM 2</th>
                                                        <th class="text-center">Item Modification</th>
                                                        <th>Inv Type</th>
                                                        <th>Cost Center</th>
                                                        <th>Account Subsidiary</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-3">
                                <div id="main-c-3">
                                    <div class="col-md-12">
                                        <table id="notif_approval" class="table table-bordered" width="100%">
                                            <thead>
                                                <tr>
                                                    <th width="1px">No</th>
                                                    <th>Role</th>
                                                    <th>User</th>
                                                    <th>Approval Status</th>
                                                    <th>Transaction Date</th>
                                                    <th>Comment</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <hr/>
                            <div class="col-12 row">
                                <!-- <div class="col-md-4">
                                    <button class="btn btn-default" id="min"><i class="fa fa-arrow-left"></i></button>
                                    <button class="btn btn-default" id="plus"><i class="fa fa-arrow-right"></i></button>
                                </div> -->
                                <div class="col-md-12 text-right">
                                    <!-- <button class="btn btn-danger" data-toggle="modal" data-target="#modal_reject"><?= lang("Tolak", "Reject")?></button>
                                    <button class="btn btn-success" data-toggle="modal" data-target="#modal_approve"><?= lang("Setujui", "Approve")?></button> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="modal_sop" class="modal fade" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-lg modal-form">
                <div class="modal-content">
                    <div class="modal-header bg-primary white">
                        <h4 class="edit-title"> <?= lang("Form SOP", "SOP Form") ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    </div>
                    <div class="form-horizontal">
                        <div class="modal-body row">
                            <input type="hidden" name="modal_sop_id" id="modal_sop_id">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Nama Barang", "Item Name") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_item_name',
                                            array('' => 'Please Select'),
                                            '',
                                            ' id="modal_sop_item_name" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Tipe Barang", "Item Type") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_item_type',
                                            $opt_itemtype,
                                            '',
                                            ' id="modal_sop_item_type" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Kategori", "Category") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_cat',
                                            array('' => 'Please Select'),
                                            '',
                                            ' id="modal_sop_cat" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label id="semic_title" class="col-form-label col-md-3"><?= lang("Sub Kategori", "Sub Category") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_subcat',
                                            array('' => 'Please Select'),
                                            '',
                                            ' id="modal_sop_subcat" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Deskripsi Unit", "Unit Description") ?></label>
                                    <div class="col-md-9">
                                        <input name="modal_sop_desc" id="modal_sop_desc" class="form-control" disabled>
                                        <input type="hidden" name="modal_sop_desc_val" id="modal_sop_desc_val">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Klasifikasi", "Classification") ?></label>
                                    <div class="col-md-9">
                                        <input readonly="readonly" id="modal_sop_group" class="form-control-plaintext" style="width:100%">
                                        <input type="hidden" name="modal_sop_group_value" id="modal_sop_group_value">
                                        <input type="hidden" name="modal_sop_group_name" id="modal_sop_group_name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Grup", "Group") ?></label>
                                    <div class="col-md-9">
                                        <input readonly="readonly" id="modal_sop_subgroup" class="form-control-plaintext" style="width:100%">
                                        <input type="hidden" name="modal_sop_subgroup_value" id="modal_sop_subgroup_value">
                                        <input type="hidden" name="modal_sop_subgroup_name" id="modal_sop_subgroup_name">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row" id="sop_inv_thinker">
                                    <label class="col-form-label col-md-3"><?= lang("Tipe Inventaris", "Inventory Type") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_inv_type',
                                            $opt_invtype,
                                            '',
                                            ' id="modal_sop_inv_type" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row" id="sop_mod_thinker" style="display: none;">
                                    <label class="col-form-label col-md-3"><?= lang("Modifikasi Barang", "Item Modification") ?></label>
                                    <div class="col-md-9">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input position-static" name="modal_sop_item_mod" id="modal_sop_item_mod" value="1" disabled>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3"><?= lang("Tipe Jumlah", "Quantity Type") ?></label>
                                    <div class="col-sm-9">
                                        <?= form_dropdown('modal_sop_qty_type',
                                            array('1' => 'Type 1', '2' => 'Type 2'),
                                            '',
                                            ' id="modal_sop_qty_type" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3"><?= lang("Jumlah / Satuan 1", "Qty / UoM 1") ?></label>
                                    <div class="col-sm-3">
                                        <input name="modal_sop_qty_1" id="modal_sop_qty_1" class="form-control" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= form_dropdown('modal_sop_uom_1',
                                            $opt_uom,
                                            '',
                                            ' id="modal_sop_uom_1" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3"><?= lang("Jumlah / Satuan 2", "Qty / UoM 2") ?></label>
                                    <div class="col-sm-3">
                                        <input name="modal_sop_qty_2" id="modal_sop_qty_2" class="form-control" disabled>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= form_dropdown('modal_sop_uom_2',
                                            $opt_uom,
                                            '',
                                            ' id="modal_sop_uom_2" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none;">
                                    <label class="col-form-label col-sm-3"><?= lang("Perkiraan Harga", "Estimated Price") ?></label>
                                    <div class="col-sm-6">
                                        <input name="modal_sop_price_val" id="modal_sop_price_val" class="form-control" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= form_dropdown('modal_sop_price_cur',
                                            $opt_currency,
                                            '',
                                            ' id="modal_sop_price_cur" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row" style="display: none;">
                                    <label class="col-form-label col-sm-3"><?= lang("Perkiraan Total Harga", "Estimated Total Price") ?></label>
                                    <div class="col-sm-6">
                                        <input name="modal_sop_price_tot_val" id="modal_sop_price_tot_val" class="form-control" disabled>
                                    </div>
                                    <div class="col-sm-3">
                                        <?= form_dropdown('modal_sop_price_tot_cur',
                                            $opt_currency,
                                            '',
                                            ' id="modal_sop_price_tot_cur" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Pusat Biaya", "Cost Center") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_cost_center',
                                            array('' => 'Please Select'),
                                            '',
                                            ' id="modal_sop_cost_center" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Akun Pembantu", "Subsidiary Account") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_sub_acc',
                                            array('' => 'No Subsidiary'),
                                            '',
                                            ' id="modal_sop_sub_acc" class="form-control" disabled');
                                        ?>
                                    </div>
                                    <div id="modal_sop_sub_acc_placer" style="display: none;"></div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Cara Impor", "Importation") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_import',
                                            $opt_importation,
                                            '',
                                            ' id="modal_sop_import" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Titik Kirim", "Delivery Point") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_deliv',
                                            $opt_delivery_point,
                                            '',
                                            ' id="modal_sop_deliv" class="form-control" disabled');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal"><?= lang("Tutup", "Close") ?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="modal_preview" class="modal fade bs-example-modal-lg" role="dialog" style="z-index: 9999;">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" >
            <div class="modal-header bg-primary white">
                <h4 class="modal-title">Preview File</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <iframe id="ref" style="width:100%; height:600px;" frameborder="0"></iframe>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>
<div id="modal_approve" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class="modal-content" id="modal_approve_form">
            <div class="modal-header">
                <h4 class="edit-title"><?= lang("Persetujuan Data", "Approval") ?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Status</label>
                    <select class="form-control" name="type" id="type">
                        <option value="1">Approve</option>
                        <option value="2">Reject</option>
                    </select>
                </div>
                <div class="form-group">
                    <label>Comment</label>
                    <textarea class="form-control" rows="3" name="modal_note" id="modal_note"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-success"><?= lang("Setujui", "Approve") ?></button>
            </div>
        </form>
    </div>
</div>
<div id="modal_reject" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="modal_reject_form" action="javascript:;">
            <div class="modal-header bg-danger white">
                <?= lang("Tolak Data", "Reject Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label">
                                <?= lang("Catatan", "Note") ?><span style="color:rgb(217, 83, 79)">*</span>
                            </label>
                            <textarea placeholder="Fill in your comment" class="form-control note" rows="5" name="modal_note" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-danger"><?= lang("Tolak", "Reject") ?></button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?= base_url('ast11/assets/js/accounting.js/accounting.js') ?>"></script>
<script>
    $(document).ready(function() {
        $('#notif_value_input').number(true, 2);
        var itcp = JSON.parse('<?= @json_encode($opt_itemtype_category_by_parent, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');
        var itc = JSON.parse('<?= @json_encode($opt_itemtype_category, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');
        accounting.settings = {
            currency: {
                decimal : ".",  // decimal point separator
                thousand: ",",  // thousands separator
                precision : 2,   // decimal places
                format: "%v"
            },
            number: {
                precision : 2,  // default precision on numbers is 0
                thousand: ",",
                decimal : "."
            }
        }
        $('#list1 tfoot th').each(function (i) {
          var title = $('#list1 thead th').eq($(this).index()).text();
          if ($(this).text() == 'No') {
            $(this).html('');
          } else if ($(this).text() == 'Action') {
            $(this).html('');
          } else {
            $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
          }

        });
        list1 = $('#list1').DataTable({
            ajax: {
                url: '<?= base_url('procurement/arf_notif_approval/get_list/') ?>',
                'dataSrc': ''
            },
            "destroy": true,
            "scrollX": true,
            "selected": true,
            "paging": true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            "columns": [
                {title:"No"},
                {title:"<?= lang("Permintaan Pada", "Requested Date") ?>"},
                {title:"<?= lang("No Perjanjian", "Agreement No") ?>"},
                {title:"<?= lang("No Amandemen", "Amendment No") ?>"},
                {title:"<?= lang("Tipe Perjanjian", "Agreement Type") ?>"},
                {title:"<?= lang("Nama", "Subject") ?>"},
                {title:"<?= lang("Permintaan Oleh", "Requested By") ?>"},
                {title:"<?= lang("Departemen", "Department") ?>"},
                {title:"<?= lang("Perusahaan", "Company") ?>"},
                {title:"<?= lang("Aksi", "Action") ?>"},
            ],
            "columnDefs": [
                {"class": "text-center", "targets": [9]}
            ]
        });
        $('#list1 tbody').on('click', 'tr .proc_get', function() {
            var elm = start($('.app-content').find('.content-wrapper'));
            var data_chosen = list1.row($(this).parents('tr')).data();
            var obj = {};
            obj.po = data_chosen[2];
            obj.amd = data_chosen[3];
            $('#param_po').val(data_chosen[2]);
            $('#param_amd').val(data_chosen[3]);
            $('#param_seq').val($(this).attr('data-seq'));
            $.ajax({
                type: "post",
                url: "<?= base_url('procurement/arf_notif_approval/create_main/') ?>",
                data: obj,
                success: function (m) {
                    if (m.status === "Success") {
                        $('#param_notif').val(m.data.id);
                        $('#param_draft').val(m.data.is_draft);
                        $('#notif_newval_input').val(accounting.formatMoney(m.data.estimated_value_new));
                        $('#notif_comdate_input').val(m.data.response_date);
                        // $('#notif_comdate_input').datepicker({ dateFormat: 'yy-mm-dd' });
                        // $('#notif_comdate_input').datepicker('setDate', m.data.response_date);
                        process(1, elm);
                        // msg_info(m.msg, m.status);
                    } else {
                        stop(elm);
                        msg_danger(m.msg, m.status);
                    }
                },
                error: function(m) {
                    stop(elm);
                    msg_danger("Oops, something went wrong!", "Failed");
                }
            });
        });

        $(list1.table().container()).on('keyup', 'tfoot input', function () {
          list1.column($(this).data('index')).search(this.value).draw();
        });

        $('#modal_approve_form').submit(function(e) {
            e.preventDefault();
            var obj = $(this).serializeArray();
            obj.push({name: 'po', value: $('#param_po').val()});
            obj.push({name: 'amd', value: $('#param_amd').val()});
            obj.push({name: 'notif', value: $('#param_notif').val()});
            obj.push({name: 'seq', value: $('#param_seq').val()});
            // obj.push({name: 'type', value: 1});
            var elm = start($('#modal_approve_form').find('.modal-content'));
            var status = $("#type").val();
            if(status == '2')
            {
              var note = $("#modal_note").val()
              if(note)
              {
                submitApproval(obj,elm)
              }
              else
              {
                swal('<?= __('warning') ?>','The Comment field is required', 'warning');
                return false;
              }
            }
            else
            {
                submitApproval(obj,elm)
            }
        });
        function submitApproval(obj,elm) {
            swalConfirm('Amendment Notification Preparation', '<?= __('confirm_submit') ?>', function() {
                $.ajax({
                    type: "post",
                    url: "<?= base_url('procurement/arf_notif_approval/send_approval/') ?>",
                    data: obj,
                    cache: false,
                    success: function (m) {
                        if (m.status === "Success") {
                            $('#modal_approve').modal('hide');
                            if(m.multi)
                            {
                                setTimeout(function() {
                                    swal('<?= __('success') ?>','<?= __('success_submit') ?>','success')
                                }, swalDelay)
                                get_approval()
                            }
                            else
                            {
                                document.location.href = '<?= base_url('home') ?>';
                            }

                        } else {
                            setTimeout(function() {
                                swal('<?= __('warning') ?>',m.msg,'warning')
                            }, swalDelay)
                            // msg_danger(m.msg, m.status);
                        }
                    },
                    error: function(m) {
                        setTimeout(function() {
                            swal('<?= __('warning') ?>','something went wrong!','warning')
                        }, swalDelay)
                    }
                });
            });
        }

        $('#modal_reject_form').submit(function(e) {
            e.preventDefault();
            var obj = $(this).serializeArray();
            obj.push({name: 'po', value: $('#param_po').val()});
            obj.push({name: 'amd', value: $('#param_amd').val()});
            obj.push({name: 'notif', value: $('#param_notif').val()});
            obj.push({name: 'seq', value: $('#param_seq').val()});
            obj.push({name: 'type', value: 2});
            var elm = start($('#modal_reject_form').find('.modal-content'));
            $.ajax({
                type: "post",
                url: "<?= base_url('procurement/arf_notif_approval/send_approval/') ?>",
                data: obj,
                cache: false,
                success: function (m) {
                    if (m.status === "Success") {
                        $('#modal_reject').modal('hide');
                        main();
                        msg_info(m.msg, m.status);
                    } else {
                        msg_danger(m.msg, m.status);
                    }
                    stop(elm);
                },
                error: function(m) {
                    msg_danger("Oops, something went wrong!", "Failed");
                    stop(elm);
                }
            });
        });

        $('#modal_sop_item_type').change(function() {
            var itemtype = $(this).val();

            $('#modal_sop_inv_type').prop('disabled', true);
            $('#modal_sop_item_mod').prop('disabled', true);

            $('#modal_sop_group').val('');
            $('#modal_sop_group_value').val('');
            $('#modal_sop_group_name').val('');
            $('#modal_sop_subgroup').val('');
            $('#modal_sop_subgroup_value').val('');
            $('#modal_sop_subgroup_name').val('');
            $('#modal_sop_uom_1').val('').change();
            $('#modal_sop_uom_1').prop('disabled', true);
            $('#modal_sop_desc').val('');
            $('#modal_sop_desc').prop('readonly', true);
            $('#modal_sop_desc_val').val('');

            $('#modal_sop_cat').empty();
            $('#modal_sop_cat').append(new Option('Please Select', ''));
            $.each(itcp[itemtype], function(id, text) {
                $('#modal_sop_cat').append(new Option(text, id));
            });

            $('#modal_sop_subcat').val('').change();
            $('#modal_sop_subcat').prop('disabled', true);

            if (itemtype == 'GOODS') {
                $('#sop_inv_thinker').show();
                $('#sop_mod_thinker').hide();
            } else if (itemtype == 'SERVICE') {
                $('#sop_inv_thinker').hide();
                $('#sop_mod_thinker').show();
            }
        });

        $('#modal_sop_cat').change(function() {
            var itemtype = $('#modal_sop_item_type').val();
            var itemtype_cat = $(this).val();

            // $('#modal_sop_inv_type').prop('disabled', true);
            // $('#modal_sop_item_mod').prop('disabled', true);

            $('#modal_sop_group').val('');
            $('#modal_sop_group_value').val('');
            $('#modal_sop_group_name').val('');
            $('#modal_sop_subgroup').val('');
            $('#modal_sop_subgroup_value').val('');
            $('#modal_sop_subgroup_name').val('');
            $('#modal_sop_uom_1').val('').change();
            // $('#modal_sop_uom_1').prop('disabled', true);
            $('#modal_sop_desc').val('');
            $('#modal_sop_desc').prop('readonly', true);
            $('#modal_sop_desc_val').val('');

            $('#modal_sop_subcat').val('').change();
            // $('#modal_sop_subcat').prop('disabled', true);

            switch (itemtype_cat.toUpperCase()) {
                case 'MATGROUP':
                    $('#semic_title').html('Material Group');
                    break;
                case 'CONSULTATION':
                    $('#semic_title').html('Consultation Category');
                    break;
                case 'WORKS':
                    $('#semic_title').html('Works Category');
                    break;
                case 'SEMIC':
                    $('#semic_title').html('Semic No');
                    break;
                default:
                    $('#semic_title').html('Sub Category');
                    break;
            }

            // if (itemtype == 'GOODS') {
            //     if (itemtype_cat == 'SEMIC') {
            //         $('#modal_sop_inv_type').prop('disabled', false);
            //     } else if (itemtype_cat != '') {
            //         $('#modal_sop_uom_1').prop('disabled', false);
            //         $('#modal_sop_desc').prop('readonly', false);
            //     }
            // } else if (itemtype != '') {
            //     $("#modal_sop_item_mod").prop('disabled', false);
            //     $('#modal_sop_uom_1').prop('disabled', false);
            //     $('#modal_sop_desc').prop('readonly', false);
            // }
            // $('#modal_sop_subcat').prop('disabled', false);
        });

        // $('#modal_sop_inv_type').change(function() {
        //     if ($(this).val() == 1) {
        //         $('#modal_sop_sub_acc').prop('disabled', true);
        //     } else {
        //         $('#modal_sop_sub_acc').prop('disabled', false);
        //     }
        // });

        // $('#modal_sop_qty_type').change(function() {
        //     if ($(this).val() == 2) {
        //         $('#modal_sop_qty_2').prop('disabled', false);
        //         $('#modal_sop_uom_2').prop('disabled', false);
        //     } else {
        //         $('#modal_sop_qty_2').prop('disabled', true);
        //         $('#modal_sop_uom_2').prop('disabled', true);
        //     }
        // });

        // $('#modal_sop_uom_2').change(function() {
        //     if ($(this).val() == '') {
        //         $('#modal_sop_qty_2').prop('required', false);
        //     } else {
        //         $('#modal_sop_qty_2').prop('required', true);
        //     }
        // });

        $('#modal_sop_price_val').change(function() {
            $(this).val(accounting.formatMoney($(this).val()));
        });

        $('#modal_sop_price_tot_val').change(function() {
            $(this).val(accounting.formatMoney($(this).val()));
        });

        $('#modal_sop_cost_center').change(function() {
            get_subsidiary_account($(this).val());
        });
    });

    function main() {
        $('#list1').DataTable().ajax.reload();
        $('#container_arf_notif').hide();
        $('#container_list').show();
    }

    function show_tab() {
        var i;
        var ps = $('#page_show').val();
        ps = ps.split(',');
        for (i = 1; i <= 2; i++) {
            $('#main-t-'+i).hide();
        }
        for (i = 0; i < ps.length; i++) {
            $('#main-t-'+(ps[i])).show();
        }
    }

    function show_page(numtab) {
        var i;
        for (i = 1; i <= 3; i++) {
            if (i == numtab) {
                $('#main-p-'+i).show();
                $('#main-b-'+i).addClass("current");
            } else {
                $('#main-p-'+i).hide();
                $('#main-b-'+i).removeClass("current");
            }
        }
    }

    function preview(id) {
        // var words = path.split('.');
        // if (words[words.length - 1] == 'pdf') {
        //     // $('#ref').attr('src', "<?= base_url()?>" + path);
        //     // $('#ref').attr('src', '<?= base_url()?>procurement/arf_notif_approval/download_file/' + '18000555-OP-10101' + '_' + id);
        //     $('#modal_preview').modal('show');
        // } else {
            window.open('<?= base_url()?>procurement/arf_notif_approval/download_file/' + $('#param_po').val() + '_' + $('#param_notif').val() + '_' + id, '_self');
        // }
    }

    function sop_mdl_edit(id) {
        var obj = {};
        obj.id = id;
        $.ajax({
            url: "<?= base_url('procurement/arf_notif_approval/get_item_proc_single')?>",
            type: "POST",
            data: obj,
            success: function(r) {
                if (r) {
                    $('#modal_sop_id').val(id);
                    $('#modal_sop_item_name').val(r.arf_item_id).change();
                    $('#modal_sop_item_type').val(r.id_itemtype).change();
                    $('#modal_sop_cat').val(r.id_itemtype_category).change();
                    $('#modal_sop_subcat').empty();
                    var option = document.createElement('option');
                    option.value = r.item_material_id;
                    option.text = r.item_semic_no_value + ' - ' + (r.id_itemtype_category == 'SEMIC' ? r.item : r.sub_groupcat_desc);
                    $('#modal_sop_subcat').append(option);
                    $('#modal_sop_subcat').val(r.item_material_id).change();
                    $('#modal_sop_desc').val(r.item);
                    $('#modal_sop_desc_val').val(r.item_semic_no_value);
                    $('#modal_sop_group').val(r.groupcat + '. ' + r.groupcat_desc);
                    $('#modal_sop_group_value').val(r.groupcat);
                    $('#modal_sop_group_name').val(r.groupcat_desc);
                    $('#modal_sop_subgroup').val(r.sub_groupcat + '. ' + r.sub_groupcat_desc);
                    $('#modal_sop_subgroup_value').val(r.sub_groupcat);
                    $('#modal_sop_subgroup_name').val(r.sub_groupcat_desc);
                    $('#modal_sop_inv_type').val(r.inv_type).change();
                    $('#modal_sop_item_mod').prop('checked', (r.item_modification == 1 ? true : false));
                    $('#modal_sop_qty_type').val(r.sop_type).change();
                    $('#modal_sop_qty_1').val(r.qty1);
                    $('#modal_sop_uom_1').val(r.uom1).change();
                    $('#modal_sop_qty_2').val(r.qty2);
                    $('#modal_sop_uom_2').val(r.uom2).change();
                    // $('#modal_sop_price_val').val('');
                    // $('#modal_sop_price_cur').val('').change();
                    // $('#modal_sop_price_tot_val').val('');
                    // $('#modal_sop_price_tot_cur').val('').change();
                    $('#modal_sop_sub_acc_placer').html(r.id_accsub);
                    $('#modal_sop_cost_center').val(r.id_costcenter).change();
                    $('#modal_sop_import').val(r.id_importation).change();
                    $('#modal_sop_deliv').val(r.id_delivery_point).change();
                    $('#modal_sop').modal('show');
                } else {
                    msg_danger("Oops, something went wrong!", "Failed");
                }
            },
            error: function() {
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    }

    function process(type, elm) {
        $('#page_show').val('1,3');
        show_tab();
        get_header();
        get_upload();
        get_item_ori();
        get_item_arf();
        get_item_proc();
        get_approval();
        $('#container_list').hide();
        $('#container_arf_notif').show();
        show_page(1);
        stop(elm);
    }

    function get_cost_center(comp) {
        $('#modal_sop_cost_center').empty();
        $('#modal_sop_cost_center').append(new Option('Please Select', ''));
        var obj = {};
        obj.comp = comp;
        $.ajax({
            url: "<?=base_url('procurement/arf_notif_approval/get_cost_center')?>",
            type: 'post',
            data: obj,
            success: function(r) {
                if (r) {
                    $.each(r, function(k, v) {
                        var option = document.createElement('option');
                        option.value = k;
                        option.text = v;
                        $('#modal_sop_cost_center').append(option);
                    });
                } else {
                    msg_danger('Oops, something went wrong!', 'Error');
                }
            }
        });
    }

    function get_subsidiary_account(cc_id) {
        var co_id = $('#param_comp').val();
        $('#modal_sop_sub_acc').empty();

        $.get('<?= base_url('procurement/msr/getAccountSubsidiaries') ?>', {
            company_id : co_id,
            costcenter_id: cc_id
        })
        .done(function(data) {
            if (data.length > 0) {
                var option = document.createElement('option');
                option.value = '';
                option.text = 'Please select';
                $('#modal_sop_sub_acc').append(option);
                data.map(function(v, k) {
                    var option = document.createElement('option');
                    option.value = v.id_account_subsidiary;
                    option.text = v.id_account_subsidiary + ' - ' + v.account_subsidiary_desc;
                    $('#modal_sop_sub_acc').append(option);
                });
                var sub_acc_val = $('#modal_sop_sub_acc_placer').html();
                $('#modal_sop_sub_acc').val(sub_acc_val).change();
            } else {
                var option = document.createElement('option');
                option.value = '';
                option.text = 'No subsidiary';
                $('#modal_sop_sub_acc').append(option);
            }
        })
        .fail(function(data) {
            var option = document.createElement('option');
            option.value = '';
            option.text = 'No subsidiary';
            $('#modal_sop_sub_acc').append(option);
            msg_danger('Fetching subsidiary accounts failed!', 'Error');
        })
    }

    function get_header() {
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        $.ajax({
            url: "<?=base_url('procurement/arf_notif_approval/get_header')?>",
            type: 'post',
            data: obj,
            success: function(r) {
                if (r) {
                    get_revision();
                    get_cost_center(r.id_comp);
                    $('#param_comp').val(r.id_comp);
                    $('#head_title').html(r.title);
                    $('#head_vendor').html(r.vendor);
                    $('#head_comp').html(r.company);
                    $('#head_rqstr').html(r.requestor);
                    $('#head_agrmnt').html(r.po_no);
                    $('#head_amend').html(r.doc_no);
                    $('#head_total').html(accounting.formatMoney(r.total));
                    $('#head_vat').html(accounting.formatMoney(r.vat));
                    $('#head_total_vat').html(accounting.formatMoney(r.total_vat));
                } else {
                    $('#modal_sop_cost_center').empty();
                    $('#modal_sop_cost_center').append(new Option('Please Select', ''));
                    msg_danger('Oops, something went wrong!', 'Error');
                }
            }
        });
    }

    function get_revision() {
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.notif = $('#param_notif').val();
        $.ajax({
            url: "<?=base_url('procurement/arf_notif_approval/get_revision')?>",
            type: 'post',
            data: obj,
            success: function(r) {
                if (r) {
                    rev = ['value', 'time', 'scope', 'other'];
                    $.each(r, function(k, v) {
                        if (v.value != null) {
                            $('#notif_'+rev[v.type-1]+'_check').prop('checked', true).change();
                            if (v.type == 1) {
                                $('#page_show').val('1,2,3');
                                show_tab();
                            }
                            // switch (v.type) {
                            //     case '1':
                            //         $('#notif_'+rev[v.type-1]+'_input').val(v.value).change();
                            //         break;
                            //     case '2':
                            //         $('#notif_'+rev[v.type-1]+'_input').datepicker({ dateFormat: 'yy-mm-dd' });
                            //         $('#notif_'+rev[v.type-1]+'_input').datepicker('setDate', v.value);
                            //         break;
                            //     default:
                            //         $('#notif_'+rev[v.type-1]+'_input').val(v.value);
                            //         break;
                            // }
                            $('#notif_'+rev[v.type-1]+'_input').val(v.value);
                            $('#notif_'+rev[v.type-1]+'_remark').val(v.remark);
                        }
                    });
                } else {
                    msg_danger('Oops, something went wrong!', 'Error');
                }
            },
            error: function() {
                msg_danger('Oops, something went wrong!', 'Error');
            }
        });
    }

    function get_upload() {
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.notif = $('#param_notif').val();
        list_ul = $('#notif_upload_list').DataTable({
            ajax: {
                url: '<?= base_url('procurement/arf_notif_approval/get_upload/') ?>',
                type: 'post',
                data: obj,
                'dataSrc': function (r) {
                    lang();
                    return r;
                }
            },
            "destroy": true,
            "selected": true,
            "paging": false,
            "searching": false,
            "ordering": false,
            "info": false,
            "columns": [
                {title:"No"},
                // {title:"<?= lang("Tipe", "Type") ?>"},
                // {title:"<?= lang("SEQ", "SEQ") ?>"},
                {title:"<?= lang("Nama File", "Filename") ?>"},
                {title:"<?= lang("Diunggah Pada", "Uploaded Date") ?>"},
                {title:"<?= lang("Diunggah Oleh", "Uploaded By") ?>"},
                {title:"<?= lang("Aksi", "Action") ?>"},
            ]
        });
    }

    function get_item_ori(id) {
        var obj = {};
        obj.po = $('#param_po').val();
        $.ajax({
            url: '<?= base_url('procurement/arf_notif_approval/get_item_ori/') ?>',
            type : 'post',
            data: obj,
            dataType: 'json',
            success: function(response) {
                var tableHTML = '';
                $.each(response, function(i, rows) {
                    tableHTML += '<tr>';
                        tableHTML +='<td>'+rows[0]+'</td>';
                        tableHTML +='<td>'+rows[1]+'</td>';
                        tableHTML +='<td>'+rows[2]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[3]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[4]+'</td>';
                        tableHTML +='<td class="text-center">'+Localization.boolean(rows[5], 'Yes', 'No')+'</td>';
                        tableHTML +='<td class="text-center">'+coalesce(rows[6], '-')+'</td>';
                        tableHTML +='<td>'+coalesce(rows[7], '-')+'</td>';
                        tableHTML +='<td>'+rows[8]+'</td>';
                        tableHTML +='<td class="text-right">'+Localization.number(rows[9])+'</td>';
                        tableHTML +='<td class="text-right">'+Localization.number(rows[10])+'</td>';
                    tableHTML += '</tr>';
                });
                $('#notif_item_ori tbody').html(tableHTML);
            }
        });
    }

    function get_item_arf(id) {
        $('#modal_sop_item_name').empty();
        $('#modal_sop_item_name').append(new Option('Please Select', ''));
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        $.ajax({
            url: '<?= base_url('procurement/arf_notif_approval/get_item_arf/') ?>',
            type: 'post',
            data: obj,
            dataType: 'json',
            success: function(response) {
                var tableHTML = '';
                $.each(response, function(i, rows) {
                    var option = document.createElement('option');
                    option.value = rows[0];
                    option.text = rows[2];
                    $('#modal_sop_item_name').append(option);
                    tableHTML += '<tr>';
                        tableHTML +='<td class="text-center">'+(i+1)+'</td>';
                        tableHTML +='<td>'+rows[1]+'</td>';
                        tableHTML +='<td>'+rows[2]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[3]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[4]+'</td>';
                        tableHTML +='<td class="text-center">'+Localization.boolean(rows[5], 'Yes', 'No')+'</td>';
                        tableHTML +='<td>'+rows[6]+'</td>';
                        tableHTML +='<td>'+coalesce(rows[7], '-')+'</td>';
                        tableHTML +='<td>'+rows[8]+'</td>';
                        tableHTML +='<td class="text-right">'+Localization.number(rows[9])+'</td>';
                        tableHTML +='<td class="text-right">'+Localization.number(rows[10])+'</td>';
                    tableHTML += '</tr>';
                });
                $('#notif_item_arf tbody').html(tableHTML);
            }
        });
    }

    function get_item_proc(id) {
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        $.ajax({
            url: '<?= base_url('procurement/arf_notif_approval/get_item_proc/') ?>',
            type: 'post',
            data: obj,
            success: function(r) {
                if (r) {
                    get_item_proc_placer(r['type'], r['data']);
                } else {
                    msg_danger('Oops, something went wrong!', 'Error');
                    get_item_proc_placer(1);
                }
            },
            error: function() {
                msg_danger('Oops, something went wrong!', 'Error');
                get_item_proc_placer(1);
            }
        });
    }

    function get_item_proc_placer(type, data) {
        var tableHTML = '';
        $.each(data, function(i, cols) {
            tableHTML += '<tr>';
                tableHTML += '<td>'+cols[0]+'</td>';
                tableHTML += '<td>'+cols[1]+'</td>';
                tableHTML += '<td>'+cols[2]+'</td>';
                tableHTML += '<td class="text-center">'+cols[3]+'</td>';
                tableHTML += '<td class="text-center">'+cols[4]+'</td>';
                tableHTML += '<td class="text-center">'+cols[5]+'</td>';
                tableHTML += '<td class="text-center">'+cols[6]+'</td>';
                tableHTML += '<td class="text-center">'+cols[7]+'</td>';
                tableHTML += '<td>'+cols[8]+'</td>';
                tableHTML += '<td>'+cols[9]+'</td>';
                tableHTML += '<td>'+cols[10]+'</td>';
            tableHTML += '</tr>';
        });
        $('#notif_item_proc tbody').html(tableHTML);
        lang();
    }

    function get_approval() {
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.notif = $('#param_notif').val();
        $.ajax({
            url: '<?= base_url('procurement/arf_notif_approval/get_approval/') ?>',
            type: 'post',
            data: obj,
            dataType: 'json',
            success: function(response) {
                var tableHTML = '';
                $.each(response, function(i, cols) {
                    tableHTML += '<tr>';
                        tableHTML += '<td>'+cols[0]+'</td>';
                        tableHTML += '<td>'+cols[1]+'</td>';
                        tableHTML += '<td>'+cols[2]+'</td>';
                        tableHTML += '<td>'+cols[3]+'</td>';
                        tableHTML += '<td>'+cols[4]+'</td>';
                        tableHTML += '<td>'+coalesce(cols[5])+'</td>';
                        tableHTML += '<td class="text-center">'+cols[6]+'</td>';
                    tableHTML += '</tr>';
                });
                $('#notif_approval tbody').html(tableHTML)
            }
        });
    }
    function sequenceClick(seq) {
        $("#param_seq").val(seq)
    }
</script>
