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
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 id="arfn_title1" class="content-header-title onprepare">
                    <?= lang("Persiapan Notifikasi ARF", "ARF Notification Preparation") ?>
                </h3>
                <h3 id="arfn_title2" class="content-header-title onprogress" style="display: none;">
                    <?=lang("Progres Notifikasi ARF", "ARF Notification On Progress")?>
                </h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Persiapan Notifikasi ARF", "ARF Notification Preparation") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-detached">
            <div class="content-body" id="container_list">
                <div class="card">
                    <div class="card-content">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-8">
                                </div>
                                <div class="col-sm-4 pull-right text-right">
                                    <button id="cpm_btn1" class="btn btn-primary onprogress" onclick="show_prepare()" style="display: none;">
                                        <i class="fa fa-exchange"></i>
                                        <?=lang("Persiapan", "Preparation")?>
                                    </button>
                                    <button id="cpm_btn2" class="btn btn-primary onprepare" onclick="show_progress()">
                                        <i class="fa fa-exchange"></i>
                                        <?=lang("Progres", "On Progress")?>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12 onprepare">
                                <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><?= lang("Permintaan Pada", "Requested At") ?></th>
                                        <th><?= lang("No Perjanjian", "Agreement No") ?></th>
                                        <th><?= lang("No Amandemen", "Amendment No") ?></th>
                                        <th><?= lang("Tipe Perjanjian", "Agreement Type") ?></th>
                                        <th><?= lang("Nama", "Title") ?></th>
                                        <th><?= lang("Permintaan Oleh", "Requested By") ?></th>
                                        <th><?= lang("Departemen", "Department") ?></th>
                                        <th><?= lang("Perusahaan", "Company") ?></th>
                                        <th><?= lang("Aksi", "Action") ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                    $no = 1;
                                    // print_r($list1);
                                    /*Array ( [0] => Array ( [id] => 6 [doc_date] => 2018-11-28 [po_no] => 18000167-OP-10101 [doc_no] => 18000167-OP-10101-AMD01 [po_type] => Service Order [po_title] => Pebelian Kursi [requestor] => DEMAS SETO ARDHIWIRAWAN [department] => SCM (SUPPLY CHAIN MGT) [company] => Supreme Energy Muara Laboh [status] => 0 ) )*/
                                    foreach ($list1 as $l1) {
                                        echo "<tr>";
                                        echo "<td>$no</td>";
                                        echo "<td>".dateToIndo($l1['doc_date'])."</td>";
                                        echo "<td>$l1[po_no]</td>";
                                        echo "<td>$l1[doc_no]</td>";
                                        echo "<td>$l1[po_type]</td>";
                                        echo "<td>$l1[po_title]</td>";
                                        echo "<td>$l1[requestor]</td>";
                                        echo "<td>$l1[department]</td>";
                                        echo "<td>$l1[company]</td>";
                                        echo "<td>Action</td>";
                                        echo "</tr>";
                                        $no++;
                                    }
                                    ?>
                                </tbody>
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
                                        <th><?= lang("Aksi", "Action") ?></th>
                                    </tr>
                                </tfoot>
                                </table>
                            </div>
                            <div class="col-12 form-row onprogress" style="display: none;">
                                <table id="list2" class="table table-striped table-bordered table-hover table-no-wrap  display text-center" width="100%">
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
                                <td width="30%">Total <span>(Exc. VAT)</span></td>
                                <td class="no-padding-lr">:</td>
                                <td class="text-right">
                                    <strong>
                                        <span data-m="currency"></span> <span id="head_total"></span><br>
                                        <small class="text-muted"><span class="equal_to">(equal to <span data-m="currency_base"></span> <span id="head_total_base">0</span>)</span></small>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">VAT</td>
                                <td class="no-padding-lr">:</td>
                                <td class="text-right">
                                    <strong>
                                        <span data-m="currency"></span> <span id="head_vat"></span><br>
                                        <small><span class="equal_to">(equal to <span data-m="currency_base"></span> <span id="head_vat_base">0</span>)</span></small>
                                    </strong>
                                </td>
                            </tr>
                            <tr>
                                <td width="30%">Total <span>(Inc. VAT)</span></td>
                                <td class="no-padding-lr">:</td>
                                <td class="text-right">
                                     <strong>
                                        <span data-m="currency"></span> <span id="head_total_vat"></span><br>
                                        <small><span class="equal_to">(equal to <span data-m="currency_base"></span> <span id="head_total_vat_base">0</span>)</span></small>
                                    </strong>
                                </td>
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
                                    <input type="hidden" id="param_draft"/>
                                    <input type="hidden" id="param_type"/>
                                    <input type="hidden" id="param_comp"/>
                                    <input type="hidden" id="param_poval"/>
                                    <ul role="tablist" class="tablist">
                                        <li id="main-t-2_1">
                                            <button onclick="show_page(2, 1)" id="main-b-2_1" class="project-info-icon btn btn-default">
                                               Amendment Request
                                            </button>
                                        </li>
                                        <li id="main-t-2_2">
                                            <button onclick="show_page(2, 2)" id="main-b-2_2" class="project-info-icon btn btn-default">
                                                Schedule of Price
                                            </button>
                                        </li>
                                        <!--<li id="main-t-2_2">
                                            <button onclick="show_page(2, 3)" id="main-b-2_3" class="project-info-icon btn btn-default">
                                                History
                                            </button>
                                        </li>-->
                                        <li id="main-t-2_3">
                                            <button onclick="show_page(2, 4)" id="main-b-2_4" class="project-info-icon btn btn-default">
                                                Approval
                                            </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="col-12" id="main-p-2_1">
                                <div id="main-c-2_1">
                                    Company intends to amend the above agreement. The amendment is to:
                                    <form id="form_notif_revision">
                                        <hr>
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                <span style="font-weight: bold !important;">Type/Description</span>
                                                <br><small>(thick one when applicable)</small>
                                            </div>
                                            <div class="col-md-8 text-center">
                                                <span style="font-weight: bold !important;">Remarks</span>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <div class="form-inline">
                                                    <input type="checkbox" name="notif_value_check" id="notif_value_check" value="1" style="margin-right: 10px" />
                                                    <label>Value</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input name="notif_value_input" id="notif_value_input" class="form-control text-right" disabled/></td>
                                            </div>
                                            <div class="col-md-8">
                                                <input name="notif_value_remark" id="notif_value_remark" class="form-control" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <div class="form-inline">
                                                    <input type="checkbox" name="notif_time_check" id="notif_time_check" value="1" style="margin-right: 10px" />
                                                    <label>Time</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input name="notif_time_input" id="notif_time_input" class="form-control" disabled/></td>
                                            </div>
                                            <div class="col-md-8">
                                                <input name="notif_time_remark" id="notif_time_remark" class="form-control" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <div class="form-inline">
                                                    <input type="checkbox" name="notif_scope_check" id="notif_scope_check" value="1" style="margin-right: 10px" />
                                                    <label>Scope</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input name="notif_scope_input" id="notif_scope_input" class="form-control text-right" disabled/></td>
                                            </div>
                                            <div class="col-md-8">
                                                <input name="notif_scope_remark" id="notif_scope_remark" class="form-control" disabled/>
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <div class="col-md-2">
                                                <div class="form-inline">
                                                    <input type="checkbox" name="notif_other_check" id="notif_other_check" value="1" style="margin-right: 10px" />
                                                    <label>Scope</label>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <input name="notif_other_input" id="notif_other_input" class="form-control text-right" disabled/></td>
                                            </div>
                                            <div class="col-md-8">
                                                <input name="notif_other_remark" id="notif_other_remark" class="form-control" disabled/>
                                            </div>
                                        </div>
                                    </form>
                                    <form id="form_notif_main">
                                        <div class="form-group row">
                                            <label class="col-md-2">Estimated New Value</label>
                                            <div class="col-md-4">
                                                <input name="notif_newval_input" id="notif_newval_input" class="form-control-plaintext text-right" readonly>
                                            </div>
                                            <label class="col-md-2">Contractor/Vendor to Response no Later than</label>
                                            <div class="col-md-4">
                                                <input name="notif_comdate_input" id="notif_comdate_input" class="form-control">
                                            </div>
                                        </div>
                                    </form>
                                    <div class="form-group row" style="padding-bottom: 1em; font-weight: bold;">
                                        <div class="col-md-6">
                                            Attachment
                                        </div>
                                        <div class="col-sm-6 text-right">
                                            <button onclick="upload_mdl()" class="btn btn-primary btn-modif">Upload File</button>
                                        </div>
                                    </div>
                                    <table id="notif_upload_list" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                    </table>
                                </div>
                            </div>
                            <div class="col-12" id="main-p-2_2">
                                <div id="main-c-2_2">
                                    <div class="col-md-12" style="padding-bottom: 1em; font-weight: bold;">
                                        Original
                                    </div>
                                    <div class="col-md-12">
                                        <table width="100%" id="notif_item_ori" class="table table-bordered table-sm" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Item Type</th>
                                                    <th>Description</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">UoM</th>
                                                    <th class="text-center">Item Modification</th>
                                                    <th class="text-center">Inventory Type</th>
                                                    <th class="text-center">Cost Center</th>
                                                    <th class="text-center">Account Subsidiary</th>
                                                    <th class="text-right">Unit Price</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12" style="margin-top: 2em; padding-bottom: 1em; font-weight: bold;">
                                        Amendment
                                    </div>
                                    <div class="col-md-12">
                                        <table width="100%" id="notif_item_arf" class="table table-bordered table-sm" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Item Type</th>
                                                    <th>Description</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">UoM</th>
                                                    <th class="text-center">Item Modification</th>
                                                    <th class="text-center">Inventory Type</th>
                                                    <th class="text-center">Cost Center</th>
                                                    <th class="text-center">Account Subsidiary</th>
                                                    <th class="text-right">Unit Price</th>
                                                    <th class="text-right">Total</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12 text-right" style="margin-top: 2em; padding-bottom: 1em;">
                                        <button onclick="sop_mdl_add()" class="btn btn-primary btn-modif">Add New Item</button>
                                    </div>
                                    <div class="col-md-12" id="notif_item_proc_placer">
                                        <table width="100%" id="notif_item_proc" class="table table-bordered table-sm" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">No</th>
                                                    <th>Item Type</th>
                                                    <th>Description</th>
                                                    <th class="text-center">Qty 1</th>
                                                    <th class="text-center">UoM 1</th>
                                                    <th class="text-center">Qty 2</th>
                                                    <th class="text-center">UoM 2</th>
                                                    <th class="text-center">Item Modification</th>
                                                    <th class="text-center">Inventory Type</th>
                                                    <th class="text-center">Cost Center</th>
                                                    <th class="text-center">Account Subsidiary</th>
                                                    <th class="text-center">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!--<div class="col-12" id="main-p-2_3">
                                <table id="approval-table" class="table" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th width="1px" class="text-center">No</th>
                                            <th>Roles</th>
                                            <th>User</th>
                                            <th class="text-center">Approval Status</th>
                                            <th class="text-center">Transaction Date</th>
                                            <th>Comments</th>
                                            <th class="text-right">BOD Review Meeting</th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>-->
                            <div class="col-12" id="main-p-2_4">
                                <div id="main-c-2_3">
                                    <div class="col-md-12">
                                        <table id="notif_approval" class="table table-striped table-bordered table-hover display text-center" width="100%">
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group text-right">
                    <button class="btn btn-primary btn-modif btn-prep" onclick="send_data(1)"><?= lang("Simpan Draf", "Save Draft")?></button>
                    <button class="btn btn-success btn-modif btn-prep" onclick="send_data(2)"><?= lang("Kirim", "Submit")?></button>
                    <button class="btn btn-success btn-modif btn-resub" data-toggle="modal" data-target="#modal_approve"><?= lang("Kirim", "Submit")?></button>
                </div>
            </div>
        </div>
        <div id="modal_sop" class="modal fade" data-backdrop="static" role="dialog">
            <div class="modal-dialog modal-lg modal-form">
                <input type="hidden" id="modal_sop_index" disabled>
                <form id="modal_sop_form" class="modal-content" action="javascript:;" enctype="multipart/form-data">
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
                                            ' id="modal_sop_item_name" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Tipe Barang", "Item Type") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_item_type',
                                            $opt_itemtype,
                                            '',
                                            ' id="modal_sop_item_type" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Kategori", "Category") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_cat',
                                            array('' => 'Please Select'),
                                            '',
                                            ' id="modal_sop_cat" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label id="semic_title" class="col-form-label col-md-3"><?= lang("Sub Kategori", "Sub Category") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_subcat',
                                            array('' => 'Please Select'),
                                            '',
                                            ' id="modal_sop_subcat" class="select2 block form-control modal-sop-input" style="width: 100%;" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Deskripsi Unit", "Unit Description") ?></label>
                                    <div class="col-md-9">
                                        <input name="modal_sop_desc" id="modal_sop_desc" class="form-control modal-sop-input" required>
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
                                            ' id="modal_sop_inv_type" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row" id="sop_mod_thinker" style="display: none;">
                                    <label class="col-form-label col-md-3"><?= lang("Modifikasi Barang", "Item Modification") ?></label>
                                    <div class="col-md-9">
                                        <div class="form-check">
                                            <input type="checkbox" class="form-check-input position-static modal-sop-input" name="modal_sop_item_mod" id="modal_sop_item_mod" value="1">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3"><?= lang("Tipe Jumlah", "Quantity Type") ?></label>
                                    <div class="col-sm-9">
                                        <?= form_dropdown('modal_sop_qty_type',
                                            array('1' => 'Type 1', '2' => 'Type 2'),
                                            '',
                                            ' id="modal_sop_qty_type" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3"><?= lang("Jumlah / Satuan 1", "Qty / UoM 1") ?></label>
                                    <div class="col-sm-3">
                                        <input name="modal_sop_qty_1" id="modal_sop_qty_1" class="form-control modal-sop-input" required>
                                    </div>
                                    <div class="col-sm-6">
                                        <?= form_dropdown('modal_sop_uom_1',
                                            $opt_uom,
                                            '',
                                            ' id="modal_sop_uom_1" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-sm-3"><?= lang("Jumlah / Satuan 2", "Qty / UoM 2") ?></label>
                                    <div class="col-sm-3">
                                        <input name="modal_sop_qty_2" id="modal_sop_qty_2" class="form-control modal-sop-input">
                                    </div>
                                    <div class="col-sm-6">
                                        <?= form_dropdown('modal_sop_uom_2',
                                            $opt_uom,
                                            '',
                                            ' id="modal_sop_uom_2" class="form-control modal-sop-input"');
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
                                            ' id="modal_sop_cost_center" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Akun Pembantu", "Subsidiary Account") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_sub_acc',
                                            array('' => 'No Subsidiary'),
                                            '',
                                            ' id="modal_sop_sub_acc" class="form-control modal-sop-input" required');
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
                                            ' id="modal_sop_import" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-form-label col-md-3"><?= lang("Titik Kirim", "Delivery Point") ?></label>
                                    <div class="col-md-9">
                                        <?= form_dropdown('modal_sop_deliv',
                                            $opt_delivery_point,
                                            '',
                                            ' id="modal_sop_deliv" class="form-control modal-sop-input" required');
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                        <button type="submit" class="btn btn-primary btn-modif"><?= lang("Proses", "Process") ?></button>
                    </div>
                </form>
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
<div id="modal_upload" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form id="modal_upload_form" class="modal-content" action="javascript:;" enctype="multipart/form-data">
            <div class="modal-header bg-primary white">
                <h4 class="edit-title"><?= lang("Unggah File", "Upload File") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true" aria-label="Close">&times;</button>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="controls col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Pilih File", "Choose File") ?></label>
                            <input type="file" name="modal_upload_file" id="modal_upload_file" class="form-control" required/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Tambah", "Add") ?></button>
            </div>
        </form>
    </div>
</div>
<div id="modal_approve" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="modal_approve_form">
            <div class="modal-header bg-success white">
                <?= lang("Pengajuan Kembali Data", "Resubmit Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <div class="form-group">
                        <div class="col-md-12">
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
                <button type="submit" class="btn btn-success"><?= lang("Setujui", "Approve") ?></button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?= base_url('ast11/assets/js/accounting.js/accounting.js') ?>"></script>
<script>
    var page_show = ['N', 'N', 'N'];
    var sop_arf = [];
    var item_arf = [];
    var it = JSON.parse('<?= @json_encode($opt_itemtype, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');
    var itcp = JSON.parse('<?= @json_encode($opt_itemtype_category_by_parent, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');
    var itc = JSON.parse('<?= @json_encode($opt_itemtype_category, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');
    var iit = JSON.parse('<?= @json_encode($opt_invtype, JSON_HEX_QUOT | JSON_HEX_APOS) ?>');

    $(document).ready(function() {
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
        var table = $('#tbl').DataTable({
          scrollX : true,
          fixedColumns: {
              leftColumns: 0,
              rightColumns: 1
          },
        });
        $(table.table().container()).on('keyup', 'tfoot input', function () {
          table.column($(this).data('index')).search(this.value).draw();
        });
        $('#notif_value_input').number(true, 2);
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
        list1 = $('#list1').DataTable({
            ajax: {
                url: '<?= base_url('procurement/arf_notif_preparation/get_list_prepare/') ?>',
                'dataSrc': function (r) {
                    lang();
                    return r;
                }
            },
            "destroy": true,
            "scrollX": true,
            "selected": true,
            "paging": true,
            "columns": [
                {title:"No"},
                {title:"<?= lang("Permintaan Pada", "Requested At") ?>"},
                {title:"<?= lang("No Perjanjian", "Agreement No") ?>"},
                {title:"<?= lang("No Amandemen", "Amendment No") ?>"},
                {title:"<?= lang("Tipe Perjanjian", "Agreement Type") ?>"},
                {title:"<?= lang("Nama", "Title") ?>"},
                {title:"<?= lang("Permintaan Oleh", "Requested By") ?>"},
                {title:"<?= lang("Departemen", "Department") ?>"},
                {title:"<?= lang("Perusahaan", "Company") ?>"},
                {title:"<?= lang("Aksi", "Action") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
                {"className": "dt-center", "targets": [7]},
                {"className": "dt-center", "targets": [8]},
                {"className": "dt-center", "targets": [9]},
            ]
        });
        $('#list1 tbody').on('click', 'tr .proc_prep', function() {
            trigger_detail(1, list1.row($(this).parents('tr')).data());
        });
        $('#list1 tbody').on('click', 'tr .proc_review', function() {
            var url = "<?= base_url('procurement/arf/view/" + $(this).attr("data-arf") +  "') ?>";
            var form = $('<form action="' + url + '" method="post" style="display: none;">' +
                '<input type="hidden" name="notif_flag" value="1" />' +
                '</form>');
            $('body').append(form);
            form.submit();
        });

        list2 = $('#list2').DataTable({
            ajax: {
                url: '<?= base_url('procurement/arf_notif_preparation/get_list_progress/') ?>',
                'dataSrc': function (r) {
                    lang();
                    return r;
                }
            },
            "destroy": true,
            "scrollX": true,
            "selected": true,
            "paging": true,
            "columns": [
                {title:"No"},
                {title:"<?= lang("Permintaan Pada", "Requested At") ?>"},
                {title:"<?= lang("No Perjanjian", "Agreement No") ?>"},
                {title:"<?= lang("No Amandemen", "Amendment No") ?>"},
                {title:"<?= lang("Tipe Perjanjian", "Agreement Type") ?>"},
                {title:"<?= lang("Nama", "Title") ?>"},
                {title:"<?= lang("Jabatan Persetujuan", "Approval Role") ?>"},
                {title:"<?= lang("Status Persetujuan", "Approval Status") ?>"},
                {title:"<?= lang("Tanggal Persetujuan", "Approval Date") ?>"},
                {title:"<?= lang("Aksi", "Action") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
                {"className": "dt-center", "targets": [6]},
                {"className": "dt-center", "targets": [7]},
                {"className": "dt-center", "targets": [8]},
                {"className": "dt-center", "targets": [9]},
            ]
        });
        $('#list2 tbody').on('click', 'tr .proc_resub', function() {
            trigger_detail(2, list2.row($(this).parents('tr')).data());
        });
        $('#list2 tbody').on('click', 'tr .proc_watch', function() {
            trigger_detail(3, list2.row($(this).parents('tr')).data());
        });

        $('[id^=notif_][id$=_check]').change(function() {
            var id_tag = this.id.split('_');
            if (this.checked) {
                if (id_tag[1] == 'value') {
                    page_show[1] = 'Y';
                    var newval = $('#param_poval').val() * 1 + $('#notif_value_input').val() * 1;
                    $('#notif_newval_input').val(accounting.formatMoney(newval));
                    show_tab();
                    $('#notif_' + id_tag[1] + '_input').prop('readonly', true);
                }
                $('#notif_' + id_tag[1] + '_input').prop('disabled', false);
                $('#notif_' + id_tag[1] + '_remark').prop('disabled', false);
            } else {
                if (id_tag[1] == 'value') {
                    page_show[1] = 'N';
                    var newval = $('#param_poval').val() * 1;
                    $('#notif_newval_input').val(accounting.formatMoney(newval));
                    show_tab();
                }
                $('#notif_' + id_tag[1] + '_input').prop('disabled', true);
                $('#notif_' + id_tag[1] + '_remark').prop('disabled', true);
            }
        });

        $('#notif_value_input').change(function() {
            var newval = $('#param_poval').val() * 1 + $(this).val() * 1;
            $('#notif_newval_input').val(accounting.formatMoney(newval));
        });

        $('#modal_upload_form').submit(function(e) {
            e.preventDefault();
            var formData = new FormData($('#modal_upload_form')[0]);
            formData.append('po', $('#param_po').val());
            formData.append('amd', $('#param_amd').val());
            formData.append('notif', $('#param_notif').val());
            var elm = start($('#modal_upload_form').find('.modal-content'));
            $.ajax({
                type: "post",
                url: "<?= base_url('procurement/arf_notif_preparation/upload_file/') ?>",
                data: formData,
                cache: false,
                processData: false,
                contentType: false,
                success: function (m) {
                    if (m.status === "Success") {
                        $('#modal_upload').modal('hide');
                        $('#notif_upload_list').DataTable().ajax.reload();
                        swal('Done', m.msg, 'success');
                    } else {
                        swal('Ooopss', m.msg, 'warning');
                    }
                    stop(elm);
                },
                error: function(m) {
                    msg_danger("Oops, something went wrong!", "Failed");
                    stop(elm);
                }
            });
        });

        $('#modal_sop_form').submit(function(e) {
            e.preventDefault();
            var obj = {};

            if ($('#modal_sop_uom_2').val() == '') {
                $('#modal_sop_qty_2').val(0);
            }

            $('#modal_sop_uom_1').prop('disabled', false);
            obj_arr = $(this).serializeArray();
            obj['modal_sop_notif'] = $('#param_notif').val();
            $(obj_arr).each(function(i, field) {
                obj[field.name] = field.value;
            });

            if ($('#modal_sop_cat').val() == 'SEMIC')
                $('#modal_sop_uom_1').prop('disabled', true);

            if ($('#modal_sop_cost_center').val()) {
                choice = $('#modal_sop_cost_center option:selected').text();
                choice = choice.split(' - ');
                choice.shift();
                obj['modal_sop_cost_center_name'] = choice.join(' - ');
            } else {
                obj['modal_sop_cost_center_name'] = '';
            }

            if ($('#modal_sop_sub_acc').val()) {
                choice = $('#modal_sop_sub_acc option:selected').text();
                choice = choice.split(' - ');
                choice.shift();
                obj['modal_sop_sub_acc_name'] = choice.join(' - ');
            } else {
                obj['modal_sop_sub_acc_name'] = '';
            }

            if ($('#modal_sop_deliv').val()) {
                choice = $('#modal_sop_deliv option:selected').text();
                obj['modal_sop_deliv_name'] = choice;
            }

            // obj.modal_sop_price_val = accounting.parse($('#modal_sop_price_val').val());
            // obj.modal_sop_price_tot_val = accounting.parse($('#modal_sop_price_tot_val').val());
            var elm = start($('#modal_sop').find('.modal-content'));
            var resp = [];

            if (sop_arf.length > 0 && sop_arf[0]['modal_sop_qty_type'] != obj['modal_sop_qty_type']) {
                resp[0] = 'Failed';
                resp[1] = 'SOP Type is different from other data!';
            }

            if (obj['modal_sop_qty_1'] <= 0) {
                resp[0] = 'Failed';
                resp[1] = 'Quantity 1 must be greater than 0!';
            }

            if (obj['modal_sop_qty_type'] == 2 && obj['modal_sop_uom_2'] != '' && obj['modal_sop_qty_2'] <= 0) {
                resp[0] = 'Failed';
                resp[1] = 'Quantity 2 must be greater than 0!';
            }

            if (resp.length > 0) {
                msg_danger(resp[1], resp[0]);
            } else {
                if (typeof obj['modal_sop_item_mod'] === "undefined") {
                    obj['modal_sop_item_mod'] = false;
                }
                if ($('#modal_sop_index').val() < 0) {
                    obj['modal_sop_item_name_desc'] = item_arf[obj['modal_sop_item_name']];
                    obj['modal_sop_item_type_desc'] = it[obj['modal_sop_item_type']];
                    obj['modal_sop_inv_type_desc'] = iit[obj['modal_sop_inv_type']];
                    if (typeof obj['modal_sop_inv_type_desc'] === "undefined")
                        obj['modal_sop_inv_type_desc'] = '';
                    obj['status'] = 1;
                    sop_arf.push(obj);
                    resp[0] = 'Success';
                    resp[1] = 'Data has been added!';
                } else {
                    obj['modal_sop_item_name_desc'] = item_arf[obj['modal_sop_item_name']];
                    obj['modal_sop_item_type_desc'] = it[obj['modal_sop_item_type']];
                    obj['modal_sop_inv_type_desc'] = iit[obj['modal_sop_inv_type']];
                    if (typeof obj['modal_sop_inv_type_desc'] === "undefined")
                        obj['modal_sop_inv_type_desc'] = '';
                    if (obj['modal_sop_id'] != 0)
                        obj['status'] = 2;
                    else
                        obj['status'] = 1;
                    for (var i = 0; i < sop_arf.length; i++) {
                        if (i == $('#modal_sop_index').val()) {
                            sop_arf[i] = obj;
                            break;
                        }
                    }
                    resp[0] = 'Success';
                    resp[1] = 'Data has been modified!';
                }
                $('#modal_sop').modal('hide');
                set_item_proc();
                msg_info(resp[1], resp[0]);
            }
            stop(elm);
        });

        $('#modal_approve_form').submit(function(e) {
            e.preventDefault();
            send_data(3);
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

            $('#modal_sop_subcat').select2('data', null);
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

            $('#modal_sop_subcat').select2('data', null);
            $('#modal_sop_subcat').val('').change();
            $('#modal_sop_subcat').prop('disabled', true);

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

            if ($('#modal_sop_item_name').is(':enabled')) {
                if (itemtype == 'GOODS') {
                    if (itemtype_cat == 'SEMIC') {
                        $('#modal_sop_inv_type').prop('disabled', false);
                    } else if (itemtype_cat != '') {
                        $('#modal_sop_uom_1').prop('disabled', false);
                        $('#modal_sop_desc').prop('readonly', false);
                    }
                } else if (itemtype != '') {
                    $("#modal_sop_item_mod").prop('disabled', false);
                    $('#modal_sop_uom_1').prop('disabled', false);
                    $('#modal_sop_desc').prop('readonly', false);
                }
                $('#modal_sop_subcat').prop('disabled', false);
            }
        });

        $('#modal_sop_subcat').select2({
            dropdownParent: $("#modal_sop"),
            minimumInputLength: 1,
            allowClear: true,
            placeholder :'Please Select',
            escapeMarkup: function(markup) {
                return markup;
            },
            ajax: {
                url: "<?php echo base_url() . '/procurement/msr/findItem' ?>",
                dataType: 'json',
                cache: true,
                data: function(params) {
                    var query = {
                        query: params.term,
                        type: $('#modal_sop_item_type').val(),
                        itemtype_category: $('#modal_sop_cat').val(),
                        id_company: $('#param_comp').val()
                    }
                    return query;
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
                        };
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
                    return row.semic_no;
                }
            }
        })
        .on('select2:select', function() {
            var selected_material = $('#modal_sop_subcat').select2('data')[0];
            var material = {
                semic_no: selected_material.semic_no,
                description: selected_material.name
            }

            semic_no_global = material.semic_no;
            $('#modal_sop_desc_val').val(material.semic_no);

            $.get('<?= base_url()."/procurement/msr/findItemAttributes" ?>', {
                material_id : $(this).val(),
                type: $('#modal_sop_item_type').val(),
                itemtype_category: $('#modal_sop_cat').val()
            }, function(data) {
                if (data.group_code) {
                    $('#modal_sop_group').val(data.group_code + '. ' + data.group_name);
                    $('#modal_sop_group_value').val(data.group_code);
                    $('#modal_sop_group_name').val(data.group_name);
                    $('#modal_sop_subgroup').val(data.subgroup_code + '. ' + data.subgroup_name);
                    $('#modal_sop_subgroup_value').val(data.subgroup_code);
                    $('#modal_sop_subgroup_name').val(data.subgroup_name);
                    if ($('#modal_sop_cat').val() == 'SEMIC') {
                        $('#modal_sop_desc').val(material.description);
                        $('#modal_sop_uom_1').val(data.uom_name);
                    }
                }
            })
            .fail(function(error) {
                alert('Cannot fetch material attributes. Please try again in few moments');
            });
        });

        $('#modal_sop_inv_type').change(function() {
            if ($('#modal_sop_item_name').is(':enabled')) {
                if ($(this).val() == 1) {
                    $('#modal_sop_sub_acc').prop('disabled', true);
                } else {
                    $('#modal_sop_sub_acc').prop('disabled', false);
                }
            }
        });

        $('#modal_sop_qty_type').change(function() {
            if ($('#modal_sop_item_name').is(':enabled')) {
                if ($(this).val() == 2) {
                    $('#modal_sop_qty_2').prop('disabled', false);
                    $('#modal_sop_uom_2').prop('disabled', false);
                } else {
                    $('#modal_sop_qty_2').prop('disabled', true);
                    $('#modal_sop_uom_2').prop('disabled', true);
                }
            }
        });

        $('#modal_sop_uom_2').change(function() {
            if ($(this).val() == '') {
                $('#modal_sop_qty_2').prop('required', false);
            } else {
                $('#modal_sop_qty_2').prop('required', true);
            }
        });

        $('#modal_sop_price_val').change(function() {
            $(this).val(accounting.formatMoney($(this).val()));
        });

        $('#modal_sop_price_tot_val').change(function() {
            $(this).val(accounting.formatMoney($(this).val()));
        });

        $('#modal_sop_cost_center').change(function() {
            get_subsidiary_account($(this).val());
        });

        <?php
            if (isset($data_rev) && $data_rev && strcmp($data_rev->flag, 'after_review') == 0) { ?>
                var elm = start($('.app-content').find('.content-wrapper'));
                $('#param_po').val('<?=$data_rev->po_no; ?>');
                $('#param_amd').val('<?=$data_rev->doc_no; ?>');
                $('#param_notif').val('<?=$data_rev->id; ?>');
                $('#param_draft').val('<?=$data_rev->is_draft; ?>');
                $('.modal-sop-input').prop('disabled', false);
                $('#notif_comdate_input').removeClass('form-control-plaintext');
                $('#notif_comdate_input').addClass('form-control');
                $('#notif_comdate_input').datetimepicker({format:'YYYY-MM-DD'});
                $('#notif_comdate_input').val('<?=$data_rev->response_date; ?>');
                process(1, elm);
        <?php }
        ?>
    });

    function trigger_detail(data_type, data_chosen) {
        var elm = start($('.app-content').find('.content-wrapper'));
        var obj = {};
        obj.po = data_chosen[2];
        obj.amd = data_chosen[3];
        obj.type = data_type;
        $('#param_po').val(data_chosen[2]);
        $('#param_amd').val(data_chosen[3]);
        $.ajax({
            type: "post",
            url: "<?= base_url('procurement/arf_notif_preparation/get_main/') ?>",
            data: obj,
            success: function (m) {
                if (m.status === "Success") {
                    $('#param_notif').val(m.data.id);
                    $('#param_draft').val(m.data.is_draft);
                    if (data_type == 3) {
                        $('.modal-sop-input').prop('disabled', true);
                        $('#notif_comdate_input').removeClass('form-control');
                        $('#notif_comdate_input').addClass('form-control-plaintext');
                        $('#notif_comdate_input').val(m.data.response_date);
                    } else {
                        $('.modal-sop-input').prop('disabled', false);
                        $('#notif_comdate_input').removeClass('form-control-plaintext');
                        $('#notif_comdate_input').addClass('form-control');
                        $('#notif_comdate_input').datetimepicker({format:'YYYY-MM-DD'});
                        $('#notif_comdate_input').val(m.data.response_date);
                    }
                    process(data_type, elm);
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
    }

    function main() {
        normalize();
        $('#list1').DataTable().ajax.reload();
        $('#list2').DataTable().ajax.reload();
        $('#container_arf_notif').hide();
        $('#container_list').show();
    }

    function normalize() {
        for (i = 0; i < page_show.length; i++) {
            page_show[i] = 'N';
        }
        sop_arf.length = 0;

        var rev = ['value', 'time', 'scope', 'other'];
        $.each(rev, function(k, v) {
            $('#notif_'+v+'_check').val('');
            $('#notif_'+v+'_input').val('');
            $('#notif_'+v+'_remark').val('');
            $('#notif_'+v+'_check').prop('disabled', false);
            $('#notif_'+v+'_input').prop('disabled', true);
            $('#notif_'+v+'_remark').prop('disabled', true);
        });
    }

    function show_tab() {
        var i;
        for (i = 0; i < page_show.length; i++) {
            if (page_show[i] == 'Y')
                $('#main-t-2_'+(i+1)).show();
            else
                $('#main-t-2_'+(i+1)).hide();
        }
    }

    function show_page(phase, numtab) {
        var i, j;
        var mt = [5, 3];
        for (i = 1; i <= 2; i++) {
            for (j = 1; j <= mt[i-1]; j++) {
                if (i == phase && j == numtab) {
                    $('#main-p-'+i+'_'+j).show();
                    $('#main-b-'+i+'_'+j).addClass("current");
                } else {
                    $('#main-p-'+i+'_'+j).hide();
                    $('#main-b-'+i+'_'+j).removeClass("current");
                }
            }
        }
    }

    function show_prepare() {
        $('.onprepare').show();
        $('.onprogress').hide();
    }

    function show_progress() {
        $('.onprepare').hide();
        $('.onprogress').show();
    }

    function upload_mdl() {
        $('#modal_upload').modal('show');
    }

    function delete_ul(id) {
        var obj = {};
        obj.id = id;
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.notif = $('#param_notif').val();
        $.ajax({
            url: "<?= base_url('procurement/arf_notif_preparation/delete_uploads')?>",
            type: "POST",
            data: obj,
            success: function(m) {
                if (m.status == "Success") {
                    msg_info("Data has been deleted!", "Success");
                    get_upload(2);
                } else
                    msg_danger("Oops, something went wrong!", "Failed");
            },
            error: function() {
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    }

    function preview(id) {
        // var words = path.split('.');
        // if (words[words.length - 1] == 'pdf') {
        //     // $('#ref').attr('src', "<?= base_url()?>" + path);
        //     // $('#ref').attr('src', '<?= base_url()?>procurement/arf_notif_preparation/download_file/' + '18000555-OP-10101' + '_' + id);
        //     $('#modal_preview').modal('show');
        // } else {
            window.open('<?= base_url()?>procurement/arf_notif_preparation/download_file/' + $('#param_po').val() + '_' + $('#param_notif').val() + '_' + id, '_self');
        // }
    }

    function sop_mdl_add() {
        $('#modal_sop_index').val(-1);
        $('#modal_sop_id').val(0);
        $('#modal_sop_item_name').val('').change();
        $('#modal_sop_item_type').val('').change();
        $('#modal_sop_cat').val('').change();
        $('#modal_sop_desc').val('');
        $('#modal_sop_desc_val').val('');
        $('#modal_sop_group').val('');
        $('#modal_sop_group_value').val('');
        $('#modal_sop_group_name').val('');
        $('#modal_sop_subgroup').val('');
        $('#modal_sop_subgroup_value').val('');
        $('#modal_sop_subgroup_name').val('');
        $('#modal_sop_inv_type').val('').change();
        $('#modal_sop_item_mod').prop('checked', false);
        $('#modal_sop_qty_type').val('1').change();
        $('#modal_sop_qty_1').val('');
        $('#modal_sop_uom_1').val('').change();
        $('#modal_sop_qty_2').val('');
        $('#modal_sop_uom_2').val('').change();
        // $('#modal_sop_price_val').val('');
        // $('#modal_sop_price_cur').val('').change();
        // $('#modal_sop_price_tot_val').val('');
        // $('#modal_sop_price_tot_cur').val('').change();
        $('#modal_sop_sub_acc_placer').html('');
        $('#modal_sop_cost_center').val('').change();
        $('#modal_sop_import').val('').change();
        $('#modal_sop_deliv').val('').change();
        $('#modal_sop').modal('show');
    }

    function sop_mdl_edit(index) {
        $('#modal_sop_index').val(index);
        $('#modal_sop_id').val(sop_arf[index]['modal_sop_id']);
        $('#modal_sop_item_name').val(sop_arf[index]['modal_sop_item_name']).change();
        $('#modal_sop_item_type').val(sop_arf[index]['modal_sop_item_type']).change();
        $('#modal_sop_cat').val(sop_arf[index]['modal_sop_cat']).change();
        $('#modal_sop_subcat').empty();
        var option = document.createElement('option');
        option.value = sop_arf[index]['modal_sop_subcat'];
        option.text = sop_arf[index]['modal_sop_desc_val'] + ' - ' + (sop_arf[index]['modal_sop_cat'] == 'SEMIC' ? sop_arf[index]['modal_sop_desc'] : sop_arf[index]['modal_sop_subgroup_name']);
        $('#modal_sop_subcat').append(option);
        $('#modal_sop_subcat').val(sop_arf[index]['modal_sop_subcat']).change();
        $('#modal_sop_desc').val(sop_arf[index]['modal_sop_desc']);
        $('#modal_sop_desc_val').val(sop_arf[index]['modal_sop_desc_val']);
        $('#modal_sop_group').val(sop_arf[index]['modal_sop_group_value'] + '. ' + sop_arf[index]['modal_sop_group_name']);
        $('#modal_sop_group_value').val(sop_arf[index]['modal_sop_group_value']);
        $('#modal_sop_group_name').val(sop_arf[index]['modal_sop_group_name']);
        $('#modal_sop_subgroup').val(sop_arf[index]['modal_sop_subgroup_value'] + '. ' + sop_arf[index]['modal_sop_subgroup_name']);
        $('#modal_sop_subgroup_value').val(sop_arf[index]['modal_sop_subgroup_value']);
        $('#modal_sop_subgroup_name').val(sop_arf[index]['modal_sop_subgroup_name']);
        $('#modal_sop_inv_type').val(sop_arf[index]['modal_sop_inv_type']).change();
        $('#modal_sop_item_mod').prop('checked', (sop_arf[index]['modal_sop_item_mod'] == 1 ? true : false));
        $('#modal_sop_qty_type').val(sop_arf[index]['modal_sop_qty_type']).change();
        $('#modal_sop_qty_1').val(sop_arf[index]['modal_sop_qty_1']);
        $('#modal_sop_uom_1').val(sop_arf[index]['modal_sop_uom_1']).change();
        $('#modal_sop_qty_2').val(sop_arf[index]['modal_sop_qty_2']);
        $('#modal_sop_uom_2').val(sop_arf[index]['modal_sop_uom_2']).change();
        // $('#modal_sop_price_val').val('');
        // $('#modal_sop_price_cur').val('').change();
        // $('#modal_sop_price_tot_val').val('');
        // $('#modal_sop_price_tot_cur').val('').change();
        $('#modal_sop_sub_acc_placer').html(sop_arf[index]['modal_sop_sub_acc']);
        $('#modal_sop_cost_center').val(sop_arf[index]['modal_sop_cost_center']).change();
        $('#modal_sop_import').val(sop_arf[index]['modal_sop_import']).change();
        $('#modal_sop_deliv').val(sop_arf[index]['modal_sop_deliv']).change();
        $('#modal_sop').modal('show');
    }

    function arf_item_copy(id) {
        var obj = {};
        obj.id = id;
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.notif = $('#param_notif').val();
        $.ajax({
            url: "<?= base_url('procurement/arf_notif_preparation/arf_item_copy')?>",
            type: "POST",
            data: obj,
            success: function(m) {
                if (m.status == "Success") {
                    if (sop_arf.length > 0)
                        m.data.modal_sop_qty_type = sop_arf[0]['modal_sop_qty_type'];
                    sop_arf.push(m.data);
                    set_item_proc();
                    msg_info(m.msg, m.status);
                } else {
                    msg_danger(m.msg, m.status);
                }
            },
            error: function() {
                msg_danger("Oops, something went wrong!", "Failed");
            }
        });
    }

    function sop_del(index) {
        var elm = start($('.card').find('.card-content'));
        if (sop_arf[index]['modal_sop_id'] == 0)
            sop_arf[index]['status'] = 0;
        else
            sop_arf[index]['status'] = 3;
        set_item_proc();
        stop(elm);
    }

    function process(type, elm) {
        $('#param_type').val(type);
        page_show[0] = 'Y';
        if (type == 1) {
            $('.btn-modif').show();
            $('.btn-resub').hide();
        } else if (type == 2) {
            page_show[2] = 'Y';
            get_approval();
            $('.btn-modif').show();
            $('.btn-prep').hide();
        } else if (type == 3) {
            page_show[2] = 'Y';
            get_approval();
            $('.btn-modif').hide();
        }
        show_tab();
        get_header(2);
        get_upload(2);
        get_item_ori();
        get_item_arf();
        get_item_proc();
        //get_approval_arf_prep();
        $('#container_list').hide();
        $('#container_arf_notif').show();
        show_page(2, 1);
        stop(elm);
    }

    function get_cost_center(comp) {
        $('#modal_sop_cost_center').empty();
        $('#modal_sop_cost_center').append(new Option('Please Select', ''));
        var obj = {};
        obj.comp = comp;
        $.ajax({
            url: "<?=base_url('procurement/arf_notif_preparation/get_cost_center')?>",
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

    function get_header(phase) {
        var obj = {};
        obj.phase = phase;
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        $.ajax({
            url: "<?=base_url('procurement/arf_notif_preparation/get_header')?>",
            type: 'post',
            data: obj,
            success: function(r) {
                if (r) {
                    get_revision(phase);
                    get_cost_center(r.id_comp);
                    $('#param_comp').val(r.id_comp);
                    $('#param_poval').val(r.po_val);
                    $('#head_title').html(r.title);
                    $('#head_vendor').html(r.vendor);
                    $('#head_comp').html(r.company);
                    $('#head_rqstr').html(r.requestor);
                    $('#head_agrmnt').html(r.po_no);
                    $('#head_amend').html(r.doc_no);
                    $('#head_total').html(accounting.formatMoney(r.total));
                    $('#head_total_base').html(accounting.formatMoney(r.total_base));
                    $('#head_vat').html(accounting.formatMoney(r.vat));
                    $('#head_vat_base').html(accounting.formatMoney(r.vat_base));
                    $('#head_total_vat').html(accounting.formatMoney(r.total_vat));
                    $('#head_total_vat_base').html(accounting.formatMoney(r.total_vat_base));
                    $('[data-m="currency"]').html(r.currency);
                    $('[data-m="currency_base"]').html(r.currency_base);
                    if (r.currency == r.currency_base) {
                        $('.equal_to').hide();
                    } else {
                        $('.equal_to').show();
                    }
                } else {
                    $('#modal_sop_cost_center').empty();
                    $('#modal_sop_cost_center').append(new Option('Please Select', ''));
                    msg_danger('Oops, something went wrong!', 'Error');
                }
            }
        });
    }

    function get_revision(phase) {
        var obj = {};
        obj.phase = phase;
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.notif = $('#param_notif').val();
        obj.draft = $('#param_draft').val();
        var rev = ['value', 'time', 'scope', 'other'];
        $.ajax({
            url: "<?=base_url('procurement/arf_notif_preparation/get_revision')?>",
            type: 'post',
            data: obj,
            success: function(r) {
                if (r) {
                    type = $('#param_type').val();
                    $.each(r, function(k, v) {
                        if (v.value != null) {
                            if (isNaN(v.type)) {
                                $('#notif_'+v.type+'_check').prop('checked', true).change();
                                switch (v.type) {
                                    case 'value':
                                        $('#notif_'+v.type+'_input').val(v.value).change();
                                        break;
                                    case 'time':
                                        $('#notif_'+v.type+'_input').datetimepicker({format:'YYYY-MM-DD'});
                                        $('#notif_'+v.type+'_input').val(v.value);
                                        break;
                                    default:
                                        $('#notif_'+v.type+'_input').val(v.value);
                                        break;
                                }
                                $('#notif_'+v.type+'_remark').val(v.remark);
                            } else {
                                $('#notif_'+rev[v.type-1]+'_check').prop('checked', true).change();
                                switch (v.type) {
                                    case '1':
                                        $('#notif_'+rev[v.type-1]+'_input').val(v.value).change();
                                        break;
                                    case '2':
                                        $('#notif_'+rev[v.type-1]+'_input').datetimepicker({format:'YYYY-MM-DD'});
                                        $('#notif_'+rev[v.type-1]+'_input').val(v.value);
                                        break;
                                    default:
                                        $('#notif_'+rev[v.type-1]+'_input').val(v.value);
                                        break;
                                }
                                $('#notif_'+rev[v.type-1]+'_remark').val(v.remark);
                            }
                        }
                    });
                    if (type != 3) {
                        $.each(rev, function(k, v) {
                            $('#notif_'+v+'_check').prop('disabled', false);
                        });
                    } else {
                        $.each(rev, function(k, v) {
                            $('#notif_'+v+'_check').prop('disabled', true);
                            $('#notif_'+v+'_input').prop('disabled', true);
                            $('#notif_'+v+'_remark').prop('disabled', true);
                        });
                    }
                } else {
                    msg_danger('Oops, something went wrong!', 'Error');
                }
            },
            error: function() {
                msg_danger('Oops, something went wrong!', 'Error');
            }
        });
    }

    function get_upload(phase) {
        var obj = {};
        obj.phase = phase;
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.notif = $('#param_notif').val();
        obj.type = $('#param_type').val();
        list_ul = $('#notif_upload_list').DataTable({
            ajax: {
                url: '<?= base_url('procurement/arf_notif_preparation/get_upload/') ?>',
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
            "columns": [
                {title:"No"},
                // {title:"<?= lang("Tipe", "Type") ?>"},
                // {title:"<?= lang("SEQ", "SEQ") ?>"},
                {title:"<?= lang("Nama File", "Filename") ?>"},
                {title:"<?= lang("Diunggah Pada", "Uploaded At") ?>"},
                {title:"<?= lang("Diunggah Oleh", "Uploaded By") ?>"},
                {title:"<?= lang("Aksi", "Action") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                // {"className": "dt-center", "targets": [5]},
                // {"className": "dt-center", "targets": [6]},
            ]
        });
    }

    function get_item_ori(id) {
        var obj = {};
        obj.po = $('#param_po').val();
        $.ajax({
            url: '<?= base_url('procurement/arf_notif_preparation/get_item_ori/') ?>',
            type : 'post',
            data: obj,
            dataType: 'json',
            success: function(response) {
                var tableHTML = '';
                $.each(response, function(i, rows) {
                    tableHTML += '<tr>';
                        tableHTML +='<td class="text-center">'+rows[0]+'</td>';
                        tableHTML +='<td>'+rows[1]+'</td>';
                        tableHTML +='<td>'+rows[2]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[3]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[4]+'</td>';
                        tableHTML +='<td class="text-center">'+Localization.boolean(rows[5])+'</td>';
                        tableHTML +='<td class="text-center">'+rows[6]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[7]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[8]+'</td>';
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
        obj.type = $('#param_type').val();
        $.ajax({
            url: '<?= base_url('procurement/arf_notif_preparation/get_item_arf/') ?>',
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
                        tableHTML +='<td class="text-center">'+Localization.boolean(rows[5])+'</td>';
                        tableHTML +='<td class="text-center">'+rows[6]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[7]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[8]+'</td>';
                        tableHTML +='<td class="text-right">'+Localization.number(rows[9])+'</td>';
                        tableHTML +='<td class="text-right">'+Localization.number(rows[10])+'</td>';
                        tableHTML +='<td class="text-center">'+rows[11]+'</td>';
                        tableHTML +='<td class="text-center">'+rows[12]+'</td>';
                    tableHTML += '</tr>';
                });
                $('#notif_item_arf tbody').html(tableHTML);
            }
        });
    }

    function get_item_proc() {
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.draft = $('#param_draft').val();
        obj.type = $('#param_type').val();
        $.ajax({
            url: '<?= base_url('procurement/arf_notif_preparation/get_item_proc/') ?>',
            type: 'post',
            data: obj,
            success: function(r) {
                if (r) {
                    sop_arf = r;
                } else {
                    msg_danger('Oops, something went wrong!', 'Error');
                }
                set_item_proc();
            },
            error: function() {
                msg_danger('Oops, something went wrong!', 'Error');
                set_item_proc();
            }
        });
    }

    function set_item_proc() {
        /*$('#notif_item_proc_placer').html('');
        var tbl_placer = '<table id="notif_item_proc" class="table table-striped table-bordered table-hover display text-center table-no-wrap"></table>';
        $('#notif_item_proc_placer').html(tbl_placer);*/
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.draft = $('#param_draft').val();
        obj.type = $('#param_type').val();
        if (sop_arf.length == 0) {
            get_item_proc_placer(1);
        } else {
            var sal_counter = 0;
            var sop_arf_list = [];
            if (sop_arf[0]['modal_sop_qty_type'] == 2) {
                for (var i = 0; i < sop_arf.length; i++) {
                    if (sop_arf[i]['status'] == 2 || sop_arf[i]['status'] == 1 || (sop_arf[i]['status'] == 0 && sop_arf[i]['modal_sop_id'] != 0)) {
                        sop_arf_list.push([]);
                        sop_arf_list[sal_counter][0] = sal_counter + 1;
                        sop_arf_list[sal_counter][1] = sop_arf[i]['modal_sop_item_type_desc'];
                        sop_arf_list[sal_counter][2] = sop_arf[i]['modal_sop_desc'];
                        sop_arf_list[sal_counter][3] = sop_arf[i]['modal_sop_qty_1'];
                        sop_arf_list[sal_counter][4] = sop_arf[i]['modal_sop_uom_1'];
                        sop_arf_list[sal_counter][5] = (sop_arf[i]['modal_sop_uom_2'] == null ? '-' : sop_arf[i]['modal_sop_qty_2']);
                        sop_arf_list[sal_counter][6] = (sop_arf[i]['modal_sop_uom_2'] == null ? '-' : sop_arf[i]['modal_sop_uom_2']);
                        sop_arf_list[sal_counter][7] = Localization.boolean(sop_arf[i]['modal_sop_item_mod']);
                        sop_arf_list[sal_counter][8] = (sop_arf[i]['modal_sop_inv_type'] == 0 ? '-' : sop_arf[i]['modal_sop_inv_type_desc']);
                        sop_arf_list[sal_counter][9] = sop_arf[i]['modal_sop_cost_center_name'];
                        sop_arf_list[sal_counter][10] = sop_arf[i]['modal_sop_sub_acc_name'];
                        if (obj.type != 3)
                            sop_arf_list[sal_counter][11] = "<button class='btn btn-sm btn-warning' onclick='sop_mdl_edit(" + i + ")'><i class='fa fa-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' onclick='sop_del(" + i + ")'><i class='fa fa-trash'></i></button>";
                        else
                            sop_arf_list[sal_counter][11] = "<button class='btn btn-sm btn-warning' onclick='sop_mdl_edit(" + i + ")'><i class='fa fa-info'></i></button>";
                        sal_counter++;
                    }
                }
            } else {
                for (var i = 0; i < sop_arf.length; i++) {
                    if (sop_arf[i]['status'] == 2 || sop_arf[i]['status'] == 1 || (sop_arf[i]['status'] == 0 && sop_arf[i]['modal_sop_id'] != 0)) {
                        sop_arf_list.push([]);
                        sop_arf_list[sal_counter][0] = i + 1;
                        sop_arf_list[sal_counter][1] = sop_arf[i]['modal_sop_item_type_desc'];
                        sop_arf_list[sal_counter][2] = sop_arf[i]['modal_sop_desc'];
                        sop_arf_list[sal_counter][3] = sop_arf[i]['modal_sop_qty_1'];
                        sop_arf_list[sal_counter][4] = sop_arf[i]['modal_sop_uom_1'];
                        sop_arf_list[sal_counter][5] = '-';
                        sop_arf_list[sal_counter][6] = '-';
                        sop_arf_list[sal_counter][7] = Localization.boolean(sop_arf[i]['modal_sop_item_mod']);
                        sop_arf_list[sal_counter][8] = (sop_arf[i]['modal_sop_inv_type'] == 0 ? '-' : sop_arf[i]['modal_sop_inv_type_desc']);
                        sop_arf_list[sal_counter][9] = sop_arf[i]['modal_sop_cost_center_name'];
                        sop_arf_list[sal_counter][10] = sop_arf[i]['modal_sop_sub_acc_name'];
                        if (obj.type != 3)
                            sop_arf_list[sal_counter][11] = "<button class='btn btn-sm btn-warning' onclick='sop_mdl_edit(" + i + ")'><i class='fa fa-pencil'></i></button>&nbsp;<button class='btn btn-sm btn-danger' onclick='sop_del(" + i + ")'><i class='fa fa-trash'></i></button>";
                        else
                            sop_arf_list[sal_counter][11] = "<button class='btn btn-sm btn-warning' onclick='sop_mdl_edit(" + i + ")'><i class='fa fa-info'></i></button>";
                        sal_counter++;
                    }
                }
            }
            get_item_proc_placer(sop_arf[0]['modal_sop_qty_type'], sop_arf_list);
        }
    }

    function get_item_proc_placer(type, data) {
        var tableHTML = '';
        $.each(data, function(i, cols) {
            tableHTML += '<tr>';
                tableHTML += '<td class="text-center">'+cols[0]+'</td>';
                tableHTML += '<td>'+cols[1]+'</td>';
                tableHTML += '<td>'+cols[2]+'</td>';
                tableHTML += '<td class="text-center">'+cols[3]+'</td>';
                tableHTML += '<td class="text-center">'+cols[4]+'</td>';
                tableHTML += '<td class="text-center">'+cols[5]+'</td>';
                tableHTML += '<td class="text-center">'+cols[6]+'</td>';
                tableHTML += '<td class="text-center">'+cols[7]+'</td>';
                tableHTML += '<td class="text-center">'+cols[8]+'</td>';
                tableHTML += '<td class="text-center">'+cols[9]+'</td>';
                tableHTML += '<td class="text-center">'+cols[10]+'</td>';
                tableHTML += '<td class="text-center">'+cols[11]+'</td>';
            tableHTML += '</tr>';
        });
        $('#notif_item_proc tbody').html(tableHTML);
        /*if (type == 2) {
            list_ul = $('#notif_item_proc').DataTable({
                "data": data,
                "destroy": true,
                "scrollX": true,
                "selected": true,
                "paging": false,
                "searching":false,
                "ordering":false,
                "columns": [
                    {title:"No"},
                    {title:"<?= lang("Tipe Barang", "Item Type") ?>"},
                    {title:"<?= lang("Deskripsi", "Description") ?>"},
                    {title:"<?= lang("Jumlah 1", "Quantity 1") ?>"},
                    {title:"<?= lang("Satuan Pengukuran 1", "UoM 1") ?>"},
                    {title:"<?= lang("Jumlah 2", "Quantity 2") ?>", render: function(data) {
                        if (data == '' || data == 0)
                            return '-';
                        else
                            return data;
                    }},
                    {title:"<?= lang("Satuan Pengukuran 2", "UoM 2") ?>", render: function(data) {
                        if (data == '' || data == 0)
                            return '-';
                        else
                            return data;
                    }},
                    {title:"<?= lang("Modifikasi Barang", "Item Modification") ?>", render: function(data) {
                        return data == 1 ? 'Yes' : 'No';
                    }},
                    {title:"<?= lang("Tipe Inventaris", "Inventory Type") ?>"},
                    {title:"<?= lang("Pusat Biaya", "Cost Center") ?>"},
                    {title:"<?= lang("Akun Pembantu", "Account Subsidiary") ?>", render: function(data) {
                        if (data == '' || data == null)
                            return '-';
                        else
                            return data;
                    }},
                    {title:"<?= lang("Aksi", "Action") ?>"},
                ],
                "columnDefs": [
                    {"className": "dt-center", "targets": [0]},
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
                ]
            });
        } else {
            list_ul = $('#notif_item_proc').DataTable({
                "data": data,
                "destroy": true,
                "scrollX": true,
                "selected": true,
                "paging": true,
                "columns": [
                    {title:"No"},
                    {title:"<?= lang("Tipe Barang", "Item Type") ?>"},
                    {title:"<?= lang("Deskripsi", "Description") ?>"},
                    {title:"<?= lang("Jumlah", "Quantity") ?>"},
                    {title:"<?= lang("Satuan Pengukuran", "UoM") ?>"},
                    {title:"<?= lang("Modifikasi Barang", "Item Modification") ?>", render: function(data) {
                        return data == 1 ? 'Yes' : 'No';
                    }},
                    {title:"<?= lang("Tipe Inventaris", "Inventory Type") ?>"},
                    {title:"<?= lang("Pusat Biaya", "Cost Center") ?>"},
                    {title:"<?= lang("Akun Pembantu", "Account Subsidiary") ?>", render: function(data) {
                        if (data == '' || data == null)
                            return '-';
                        else
                            return data;
                    }},
                    {title:"<?= lang("Aksi", "Action") ?>"},
                ],
                "columnDefs": [
                    {"className": "dt-center", "targets": [0]},
                    {"className": "dt-center", "targets": [1]},
                    {"className": "dt-center", "targets": [2]},
                    {"className": "dt-center", "targets": [3]},
                    {"className": "dt-center", "targets": [4]},
                    {"className": "dt-center", "targets": [5]},
                    {"className": "dt-center", "targets": [6]},
                    {"className": "dt-center", "targets": [7]},
                    {"className": "dt-center", "targets": [8]},
                    {"className": "dt-center", "targets": [9]},
                ]
            });
        }
        lang();*/
    }

    function get_approval() {
        var obj = {};
        obj.po = $('#param_po').val();
        obj.amd = $('#param_amd').val();
        obj.notif = $('#param_notif').val();
        list_ap = $('#notif_approval').DataTable({
            ajax: {
                url: '<?= base_url('procurement/arf_notif_preparation/get_approval/') ?>',
                type: 'post',
                data: obj,
                'dataSrc': ''
            },
            "searching": false,
            "destroy": true,
            "selected": true,
            "paging": false,
            "columns": [
                {title:"No"},
                {title:"<?= lang("Jabatan", "Role") ?>"},
                {title:"<?= lang("Pengguna", "User") ?>"},
                {title:"<?= lang("Status Persetujuan", "Approval Status") ?>"},
                {title:"<?= lang("Tanggal Persetujuan", "Approval Date") ?>"},
                {title:"<?= lang("Catatan", "Remark") ?>"},
            ],
            "columnDefs": [
                {"className": "dt-center", "targets": [0]},
                {"className": "dt-center", "targets": [1]},
                {"className": "dt-center", "targets": [2]},
                {"className": "dt-center", "targets": [3]},
                {"className": "dt-center", "targets": [4]},
                {"className": "dt-center", "targets": [5]},
            ]
        });
    }

    function get_approval_arf_prep() {
        var obj = {};
        obj.amd = $('#param_amd').val();
        $.ajax({
            //url: '<?= base_url('procurement/arf_notif_preparation/get_approval_arf_prep') ?>',
            type: 'post',
            data: obj,
            dataType: 'json',
            success: function(response) {
                var html = '';
                var no = 1;
                $.each(response, function(i, row) {
                    if (row.status == 1) {
                        var status = 'Approved';
                    } else if (row.status == 2) {
                        var status = 'Rejected';
                    } else {
                        var status = '-';
                    }
                    html += '<tr>';
                        html += '<td>'+no+'</td>';
                        html += '<td>'+row.role+'</td>';
                        html += '<td>'+row.name+'</td>';
                        html += '<td class="text-center">'+status+'</td>';
                        html += '<td class="text-center">'+Localization.datetime(row.approved_at)+'</td>';
                        html += '<td>'+row.note+'</td>';
                        html += '<td class="text-right">';
                        if (row.review_bod) {
                            if (row.review_bod.value == 1) {
                                html += 'Required';
                            } else {
                                html += 'Not Requestor';
                            }
                        }
                        html += '</td>';
                    html += '</tr>';
                    no++;
                });
                $('#approval-table tbody').html(html);
            }
        });
    }

    function send_data(type) {
        if ($('#notif_comdate_input').val() == '' && type != 1) {
            msg_danger('Expected commendment date must be defined!', 'Error');
        } else {
            var elm = start($('.card').find('.card-content'));
            var obj = {};
            obj.po = $('#param_po').val();
            obj.amd = $('#param_amd').val();
            obj.notif = $('#param_notif').val();
            obj.type = type;
            $('#notif_newval_input').val(accounting.parse($('#notif_newval_input').val()));
            obj.main = $('#form_notif_main').serializeArray();
            $('#notif_newval_input').val(accounting.formatMoney($('#notif_newval_input').val()));
            obj.revision = $('#form_notif_revision').serializeArray();
            obj.sop = sop_arf;
            if (type == 3)
                obj.note = $('textarea[name="modal_note"]').val();
            $.ajax({
                url: '<?= base_url('procurement/arf_notif_preparation/send_data/') ?>',
                type: 'post',
                data: obj,
                success: function(m) {
                    if (m.status == 'Success') {
                        if (type == 3)
                            $('#modal_approve').modal('hide');
                        main();
                        msg_info(m.msg, m.status);
                    } else {
                        msg_danger(m.msg, m.status);
                    }
                    stop(elm);
                },
                error: function() {
                    msg_danger('Oops, something went wrong!', 'Error');
                    stop(elm);
                }
            });
        }
    }
</script>
