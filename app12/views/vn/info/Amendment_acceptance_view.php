<link href="<?= base_url() ?>ast11/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="<?= base_url() ?>ast11/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">Amendment No <?= $arf->doc_no ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                    <li class="breadcrumb-item">Amendment Acceptance</li>
                  </ol>
                </div>
            </div>
        </div>
        <div class="row info-header">
            <div class="col-md-6">
                 <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td>Agreement Number</td>
                            <td>:</td>
                            <td><?= $arf->po_no ?></td>
                        </tr>
                        <tr>
                            <td>Amendment Number</td>
                            <td>:</td>
                            <td><?= substr($arf->doc_no, -5) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="content-body">
                    <section id="icon-tabs">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="icons-tab-steps wizard-circl">
                                        <h6><i class="step-icon fa fa-info"></i> Amendment Data</h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px">
                                                    Agreement Data including this Amendment
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3">Original Agreement Value</label>
                                                <div class="col-md-3 text-right">
                                                    <?= numIndo($arf->amount_po) ?>
                                                </div>
                                                <label class="col-md-3">Additional Value</label>
                                                <div class="col-md-3 text-right">
                                                    <?= numIndo($arf->estimated_value) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3">Latest Agreement Value</label>
                                                <div class="col-md-3 text-right">
                                                    <?= numIndo($arf->amount_po_arf) ?>
                                                </div>
                                                <label class="col-md-3">New Agreement Value</label>
                                                <div class="col-md-3 text-right">
                                                    <?= numIndo($arf->estimated_value+$arf->amount_po_arf) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            Original Agreement Period
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?= dateToIndo($po->po_date,false,false) ?>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            to
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?= dateToIndo($po->delivery_date,false,false) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            Additional Time
                                                        </div>
                                                        <div class="col-md-3" style="font-weight: bold">
                                                            Up to
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php if (isset($arf->revision['time'])) { ?>
                                                                <?= dateToIndo($arf->revision['time'],false,false ) ?>
                                                            <?php } else { ?>
                                                                <?= dateToIndo($arf->amended_date,false,false ) ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            Latest Agreement Period
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?= dateToIndo($po->po_date,false,false) ?>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            to
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?= dateToIndo($arf->amended_date,false,false) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="row">
                                                        <div class="col-md-5">
                                                            New Agreement Period
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?= dateToIndo($po->po_date,false,false) ?>
                                                        </div>
                                                        <div class="col-md-1 text-center">
                                                            to
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php if (isset($arf->revision['time'])) { ?>
                                                                <?= dateToIndo($arf->revision['time'],false,false ) ?>
                                                            <?php } else { ?>
                                                                <?= dateToIndo($arf->amended_date,false,false ) ?>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px">
                                                    Additional Documents
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th></th>
                                                            <th class="text-center">Original Expiry Date</th>
                                                            <th class="text-center">Latest Expiry Date</th>
                                                            <th class="text-center">Extend</th>
                                                            <th class="text-center">New Date</th>
                                                            <th class="text-center">Remarks</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>Performance Bond</td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center"></td>
                                                            <td class="text-center">
                                                                <?php if ($arf->extend1) { ?>
                                                                    <i class="fa fa-check-square-o text-success"></i>
                                                                <?php } else { ?>
                                                                    <i class="fa fa-square-o"></i>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= dateToIndo($arf->new_date_1) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $arf->remarks_1 ?>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Insurance</td>
                                                            <td></td>
                                                            <td></td>
                                                            <td class="text-center">
                                                                <?php if ($arf->extend2) { ?>
                                                                    <i class="fa fa-check-square-o text-success"></i>
                                                                <?php } else { ?>
                                                                    <i class="fa fa-square-o"></i>
                                                                <?php } ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= dateToIndo($arf->new_date_2) ?>
                                                            </td>
                                                            <td class="text-center">
                                                                <?= $arf->remarks_2 ?>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </fieldset>
                                        <?php if(isset($arf->revision['value'])):?>
                                        <h6><i class="step-icon fa fa-calendar"></i> Schedule of Price</h6>
                                        <fieldset>
                                            <div id="po-detail">
                                                <h4>Original</h4>
                                                <div class="table-responsive">
                                                    <table width="100%" id="po_item-table" class="table table-bordered table-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>Item Type</th>
                                                                <th>Description</th>
                                                                <th class="text-center">Qty</th>
                                                                <th class="text-center">UoM</th>
                                                                <th class="text-center">Item Modif</th>
                                                                <th class="text-center">Inventory Type</th>
                                                                <th class="text-center">Cost Center</th>
                                                                <th class="text-center">Acc Sub</th>
                                                                <th class="text-right">Unit Price</th>
                                                                <th class="text-right">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($po->item as $item) { ?>
                                                                <tr>
                                                                    <td><?= $item->item_type ?></td>
                                                                    <td><?= $item->material_desc ?></td>
                                                                    <td class="text-center"><?= $item->qty ?></td>
                                                                    <td class="text-center"><?= $item->uom ?></td>
                                                                    <td class="text-center"><?= ($item->item_modification) ? '<i class="fa fa-check-square text-success"></i>' : '<i class=" fa fa-times text-danger"></i>' ?></td>
                                                                    <td class="text-center"><?= $item->inventory_type ?></td>
                                                                    <td class="text-center"><?= $item->id_costcenter ?> - <?= $item->costcenter ?></td>
                                                                    <td class="text-center"><?= $item->id_account_subsidiary ?> - <?= $item->account_subsidiary ?></td>
                                                                    <td class="text-right"><?= numIndo($item->unit_price) ?></td>
                                                                    <td class="text-right"><?= numIndo($item->total_price) ?></td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="offset-md-6 col-md-3">Total</label>
                                                    <div class="col-md-3 text-right">
                                                        <?= numIndo($arf->amount_po) ?>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>Amendment</h4>
                                                    </div>
                                                </div><br>
                                                <div class="table-responsive">
                                                    <table id="arf_item-table" class="table table-bordered table-sm" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th>Item Type</th>
                                                                <th>Description</th>
                                                                <th class="text-center">Qty</th>
                                                                <th class="text-center">UoM</th>
                                                                <th class="text-center">Qty 2</th>
                                                                <th class="text-center">UoM 2</th>
                                                                <th class="text-center">Item Modif</th>
                                                                <th class="text-center">Inventory Type</th>
                                                                <th class="text-center">Cost Center</th>
                                                                <th class="text-center">Acc Sub</th>
                                                                <th class="text-right">Unit Price</th>
                                                                <th class="text-right">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($arf->item as $item) { ?>
                                                                <tr id="arf_item-row-<?= $item->item_semic_no_value ?>" data-row-id="<?= $item->item_semic_no_value ?>">
                                                                    <td><?= $item->item_type ?></td>
                                                                    <td><?= $item->item ?></td>
                                                                    <td class="text-center"><?= $item->response_qty1 ?></td>
                                                                    <td class="text-center"><?= $item->uom1 ?></td>
                                                                    <td class="text-center"><?= $item->response_qty2 ? $item->response_qty2 : '-' ?></td>
                                                                    <td class="text-center"><?= $item->uom2 ? $item->uom2 : '-' ?></td>
                                                                    <td class="text-center"><?= ($item->item_modification) ? '<i class="fa fa-check-square text-success"></i>' : '<i class=" fa fa-times text-danger"></i>' ?></td>
                                                                    <td class="text-center"><?= $item->inventory_type ?></td>
                                                                    <td class="text-center"><?= $item->id_costcenter ?> - <?= $item->costcenter_desc ?></td>
                                                                    <td class="text-center"><?= $item->id_accsub ?> - <?= $item->accsub_desc ?></td>
                                                                    <td class="text-right"><?= numIndo($item->response_unit_price) ?></td>
                                                                    <td class="text-right">
                                                                        <?php
                                                                            $total = $item->response_unit_price * $item->response_qty1;
                                                                            if ($item->response_qty2) {
                                                                                $total *= $item->response_qty2;
                                                                            }
                                                                        ?>
                                                                        <?= numIndo($total) ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="offset-md-6 col-md-3">Total</label>
                                                    <div class="col-md-3 text-right">
                                                        <?= numIndo($arf->estimated_value) ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="offset-md-6 col-md-3">Total Summary</label>
                                                    <div class="col-md-3 text-right">
                                                        <?= numIndo($arf->estimated_new_value) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php endif;?>
                                        
                                        <h6><i class="step-icon fa fa-paperclip"></i> Amendment Document</h6>
                                        <fieldset>
                                            <table id="attachment-table" class="table" style="font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th>TYPE</th>
                                                        <th>FILE NAME</th>
                                                        <th>UPLOAD AT</th>
                                                        <th>UPLOADER</th>
                                                        <th>ACTION</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php 
                                                        foreach ($arf->document as $document) { 
                                                            $docType = arfIssuedDoc($document->tipe);
                                                            if($document->tipe == 2)
                                                            {
                                                              $userName = $this->db->where(['ID'=>$document->created_by])->get('m_vendor')->row();
                                                              $userName = $userName->NAMA;
                                                            }
                                                            else
                                                            {
                                                              $userName = user($document->created_by)->NAME;
                                                            }
                                                    ?>
                                                        <tr>
                                                            <td><?= $docType ?></td>
                                                            <td><?= $document->file_path ?></td>
                                                            <td><?= dateToIndo($document->created_at, false, true) ?></td>
                                                            <td><?= $userName ?></td>
                                                            <td>
                                                              <a href="<?= base_url('upload/ARFRECOMPREP/'.$document->file_path) ?>" target="_blank" class="btn btn-primary btn-sm">Download</a>
                                                            </td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </fieldset>
                                        <h6><i class="step-icon fa fa-check"></i> Completeness</h6>
                                        <fieldset>
                                            <?php if ($arf->extend1) { ?>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h4>Performance Bond</h4>
                                                </div>
                                            </div>
                                            <table id="document-table-1" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Performance Bond No</th>
                                                        <th class="text-center">Issuer</th>
                                                        <th class="text-center">Issued Date</th>
                                                        <th class="text-center">Value</th>
                                                        <th class="text-center">Curr</th>
                                                        <th class="text-center">Effective Date</th>
                                                        <th class="text-center">Expired Date</th>
                                                        <th>Description</th>
                                                        <th width="100px" class="text-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1 ?>
                                                    <?php foreach ($po->doc_performance_bond as $doc) { ?>
                                                        <tr>
                                                            <td><?= $no ?></td>
                                                            <td><?= $doc->doc_no ?></td>
                                                            <td class="text-center"><?= $doc->issuer ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->issued_date) ?></td>
                                                            <td class="text-center"><?= numIndo($doc->value) ?></td>
                                                            <td class="text-center"><?= $doc->currency ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->effective_date) ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->expired_date) ?></td>
                                                            <td><?= $doc->description ?></td>
                                                            <td class="text-right"><a href="<?= base_url($doc->file_path.$doc->file_name) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                    <?php foreach ($arf->performance_bond as $doc) { ?>
                                                        <tr>
                                                            <td><?= $no ?></td>
                                                            <td><?= $doc->no ?></td>
                                                            <td class="text-center"><?= $doc->issuer ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->issued_date) ?></td>
                                                            <td class="text-center"><?= numIndo($doc->value) ?></td>
                                                            <td class="text-center"><?= $doc->currency ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->effective_date) ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->expired_date) ?></td>
                                                            <td><?= $doc->description ?></td>
                                                            <td class="text-right"><a href="<?= base_url($document_path.'/'.$doc->file) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                            <?php if ($arf->extend2) { ?>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h4>Insurance</h4>
                                                </div>
                                            </div>
                                            <table id="document-table-2" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Insurance No</th>
                                                        <th class="text-center">Issuer</th>
                                                        <th class="text-center">Issued Date</th>
                                                        <th class="text-center">Value</th>
                                                        <th class="text-center">Curr</th>
                                                        <th class="text-center">Effective Date</th>
                                                        <th class="text-center">Expired Date</th>
                                                        <th>Description</th>
                                                        <th width="100px" class="text-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1 ?>
                                                    <?php foreach ($po->doc_insurance as $doc) { ?>
                                                        <tr>
                                                            <td><?= $no ?></td>
                                                            <td><?= $doc->doc_no ?></td>
                                                            <td class="text-center"><?= $doc->issuer ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->issued_date) ?></td>
                                                            <td class="text-center"><?= numIndo($doc->value) ?></td>
                                                            <td class="text-center"><?= $doc->currency ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->effective_date) ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->expired_date) ?></td>
                                                            <td><?= $doc->description ?></td>
                                                            <td class="text-right"><a href="<?= base_url($doc->file_path.$doc->file_name) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                    <?php foreach ($arf->Insurance as $doc) { ?>
                                                        <tr>
                                                            <td><?= $no ?></td>
                                                            <td><?= $doc->no ?></td>
                                                            <td class="text-center"><?= $doc->issuer ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->issued_date) ?></td>
                                                            <td class="text-center"><?= numIndo($doc->value) ?></td>
                                                            <td class="text-center"><?= $doc->currency ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->effective_date) ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->expired_date) ?></td>
                                                            <td><?= $doc->description ?></td>
                                                            <td class="text-right"><a href="<?= base_url($document_path.'/'.$doc->file) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                            <?php if ($arf->extend1 || $arf->extend2) { ?>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h4>Other</h4>
                                                </div>
                                            </div>
                                            <table id="document-table-3" class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No.</th>
                                                        <th>Insurance No</th>
                                                        <th class="text-center">Issuer</th>
                                                        <th class="text-center">Issued Date</th>
                                                        <th class="text-center">Value</th>
                                                        <th class="text-center">Curr</th>
                                                        <th class="text-center">Effective Date</th>
                                                        <th class="text-center">Expired Date</th>
                                                        <th>Description</th>
                                                        <th width="100px" class="text-right"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1 ?>
                                                    <?php foreach ($po->doc_other as $doc) { ?>
                                                        <tr>
                                                            <td><?= $no ?></td>
                                                            <td><?= $doc->doc_no ?></td>
                                                            <td class="text-center"><?= $doc->issuer ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->issued_date) ?></td>
                                                            <td class="text-center"><?= numIndo($doc->value) ?></td>
                                                            <td class="text-center"><?= $doc->currency ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->effective_date) ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->expired_date) ?></td>
                                                            <td><?= $doc->description ?></td>
                                                            <td class="text-right"><a href="<?= base_url($doc->file_path.$doc->file_name) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                    <?php foreach ($arf->doc_other as $doc) { ?>
                                                        <tr>
                                                            <td><?= $no ?></td>
                                                            <td><?= $doc->no ?></td>
                                                            <td class="text-center"><?= $doc->issuer ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->issued_date) ?></td>
                                                            <td class="text-center"><?= numIndo($doc->value) ?></td>
                                                            <td class="text-center"><?= $doc->currency ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->effective_date) ?></td>
                                                            <td class="text-center"><?= dateToIndo($doc->expired_date) ?></td>
                                                            <td><?= $doc->description ?></td>
                                                            <td class="text-right"><a href="<?= base_url($document_path.'/'.$doc->file) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
    $(function() {
        $(".icons-tab-steps").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '#title#',
            enableFinishButton: false,
            enablePagination: false,
            enableAllSteps: true,
            enableFinishButton: false,
            labels: {
                finish: 'Done'
            }
        });
    });
</script>