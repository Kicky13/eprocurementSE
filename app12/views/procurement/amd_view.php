<?php 
    $this->load->view('procurement/partials/script');
    $newDate1Now = $new_date_1;
    $newDate2Now = $new_date_2;
    $amdNumber = substr($arf->doc_no, -5);
    $latestExpiryDatePerformanceBond = '';
    $latestExpiryDateInsurance = '';
    $arfRevisionTime = isset($arf->revision['time']->value) ? dateToIndo($arf->revision['time']->value) : '-';

    $originalInsurance = '-';
    $originalPerformanceBond = '-';
    $po_no = $arf->po_no;
    $t_purchase_order_document = $this->db->select('t_purchase_order_document.*')
    ->join('t_purchase_order','t_purchase_order.id = t_purchase_order_document.po_id', 'left')
    ->where(['t_purchase_order.po_no'=>$po_no])
    ->where_in('t_purchase_order_document.doc_type', [1,2])
    ->get('t_purchase_order_document');
    $insuranceOriginalValue = '-';
    $performanceBondOriginalValue = '-';
    foreach ($t_purchase_order_document->result() as $key => $value) {
        if($value->doc_type == 1)
        {
            $performanceBondOriginalValue = dateToIndo($value->expired_date);
        }
        if($value->doc_type == 2)
        {
            $insuranceOriginalValue = dateToIndo($value->expired_date);
        }
    }
    if($amdNumber == 'AMD01')
    {
        $dataBefore = false;
        $new_date_1 = '-';
        $new_date_2 = '-';
    }
    else
    {
        $substr = substr($amdNumber, -2);
        $originalStr =  $substr;
        $toInt = number_format($substr)-1;
        $amdNoBefore = $toInt > 10 ? $toInt : '0'.$toInt;
        $strAmdNoBefore = 'AMD'.$amdNoBefore;
        $docNo = $arf->po_no.'-'.$strAmdNoBefore;
        $dataBefore = $this->db->where(['doc_no'=>$docNo])->get('t_arf_recommendation_preparation')->row();
        if($dataBefore)
        {
            $new_date_1 = $dataBefore->new_date_1;
        $new_date_2 = $dataBefore->new_date_2;
        }
        else
        {
            $new_date_1 = '-';
        $new_date_2 = '-';
        }
        
    }
?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang($title, $title) ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Amendment Details", "Amendment Details") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row info-header">
                <div class="col-md-4">
                    <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td width="25%">Title</td>
                                <td width="1px">:</td>
                                <td><?= $arf->title ?></td>
                            </tr>
                            <tr>
                                <td>Supplier</td>
                                <td>:</td>
                                <td><?= $arf->vendor ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                     <table class="table table-condensed">
                        <tbody>
                            <tr>
                                <td>Company</td>
                                <td>:</td>
                                <td><?= $arf->company ?></td>
                            </tr>
                            <tr>
                                <td>Amendment Value</td>
                                <td>:</td>
                                <td><?= numIndo($arf->estimated_value) ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
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
                                <td><?= $amdNumber ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard card-scroll">
                        <form id="wizard-arf" class="wizard-circle">
                          <input type="hidden" name="arf_response_id" value="<?= $arf->id ?>">
                          <input type="hidden" name="doc_no" value="<?= $arf->doc_no ?>">
                          <input type="hidden" name="po_no" value="<?= $arf->po_no ?>">
                            <?php if(isset($issued)): ?>
                            <?php else:?>
                            <h6><i class="step-icon icon-info"></i> Amendment Request</h6>
                            <fieldset>
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">Type/Description<br><small>(thick one when applicable)</small></th>
                                            <th style="vertical-align: top !important;">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="1px">
                                                <?php if (isset($arf->revision['value'])) { ?>
                                                    <i class="fa fa-check-square text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-square-o"></i>
                                                <?php } ?>
                                            </td>
                                            <td>Value</td>
                                            <td>
                                                <?php if (isset($arf->revision['value'])) { ?>
                                                    <?= $arf->currency ?> <span id="arf_request_value"></span>
                                                <?php } ?>
                                            </td>
                                            <td><?= @$arf->revision['value']->remark ?></td>
                                        </tr>
                                        <tr>
                                            <td width="1px">
                                                <?php if (isset($arf->revision['time'])) { ?>
                                                    <i class="fa fa-check-square text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-square-o"></i>
                                                <?php } ?>
                                            </td>
                                            <td>Time</td>
                                            <td><?= dateToIndo(@$arf->revision['time']->value) ?></td>
                                            <td><?= @$arf->revision['time']->remark ?></td>
                                        </tr>
                                        <tr>
                                            <td width="1px">
                                                <?php if (isset($arf->revision['scope'])) { ?>
                                                    <i class="fa fa-check-square text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-square-o"></i>
                                                <?php } ?>
                                            </td>
                                            <td>Scope</td>
                                            <td><?= @$arf->revision['scope']->value ?></td>
                                            <td><?= @$arf->revision['scope']->remark ?></td>
                                        </tr>
                                        <tr>
                                            <td width="1px">
                                                <?php if (isset($arf->revision['other'])) { ?>
                                                    <i class="fa fa-check-square text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-square-o"></i>
                                                <?php } ?>
                                            </td>
                                            <td width="50px">Other</td>
                                            <td><?= @$arf->revision['other']->value ?></td>
                                            <td><?= @$arf->revision['other']->remark ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <h4><b>Amendment Process</b></h4>
                                <div class="form-group row">
                                    <label class="col-md-3">ARF Received</label>
                                    <div class="col-md-3">
                                        <?= dateToIndo($arf->assignment_date, false, true) ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3">Amendment Notification Issued</label>
                                    <div class="col-md-3">
                                        <?= dateToIndo($arf->notification_date) ?>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3">Contractor Response Received</label>
                                    <div class="col-md-3">
                                        <?= dateToIndo($arf->responsed_at, false, true) ?>
                                    </div>
                                </div>
                            </fieldset>
                            <?php endif;?>
                            <?php if(isset($issued)): ?>
                            <?php else:?>
                            <h6><i class="step-icon fa fa-exclamation"></i> Amendment Notification Response</h6>
                            <fieldset>
                                <h4>Amendment Notification Response</h4>
                                <hr>
                                <div class="form-group row">
                                    <div class="col-md-3">
                                        <input disabled="" type="radio" name="confirm" value="1" <?= $arf->confirm == 1 ? "checked": "" ?> >
                                        <label style="bottom: 8px;position: relative;margin-left: 10px;">Confirm</label>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input disabled="" type="radio" name="confirm" value="2" <?= $arf->confirm == 2 ? "checked": "" ?> >
                                        <label style="bottom: 8px;position: relative;margin-left: 10px;">Confirm With Note</label>
                                    </div>
                                    <div class="col-md-6">
                                        <b style="margin-left: 25px;font-weight: bold;">Comments</b>
                                        <textarea disabled="" class="form-control" style="margin-left: 25px;"><?= $arf->note ?></textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        <input disabled="" type="radio" name="confirm" value="3" <?= $arf->confirm == 3 ? "checked": "" ?> >
                                        <label style="bottom: 8px;position: relative;margin-left: 10px;">Quotation refer to schedule of price and attachment</label>
                                    </div>
                                </div>

                                <h4>Attachment</h4>
                                <hr>
                                <table id="attachment-table" class="table" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>File</th>
                                            <th>Upload At</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($arf->response_attachment as $attachment) { ?>
                                            <tr>
                                                <td><?= $attachment->file ?></td>
                                                <td><a href="<?= base_url($document_path.'/'.$attachment->file) ?>"><?= $attachment->file ?></a></td>
                                                <td><?= dateToIndo($attachment->created_at, false, true) ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </fieldset>
                            <?php endif;?>
                            <?php if(isset($arf->revision['value'])):?>
                            <h6><i class="step-icon fa fa-calendar"></i> SOP List Item</h6>
                            <fieldset>
                                <div id="po-detail">
                                    <h4>Contract List Item</h4>
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
                                    <div class="form-group row">
                                        <label class="offset-md-6 col-md-3">Total</label>
                                        <div class="col-md-3 text-right">
                                            <?= numIndo($arf->amount_po) ?>
                                        </div>
                                    </div>
                                    <?php
                                                    $total = 0;
                                                    foreach ($arf->item as $item) {
                                                        $qty = $item->qty2 > 0 ? $item->qty1*$item->qty2 : $item->qty1;
                                                        $response_qty = $item->response_qty1 > 0 ? $item->response_qty1*$item->response_qty2 : $item->response_qty1;
                                                        $uom = $item->uom2 ? $item->uom1.'/'.$item->uom2 : $item->uom1;
                                                        $price = $item->new_price > 0 ? $item->new_price : $item->response_unit_price;
                                                        $subTotalPrice = $price*$qty;      
                                                        $total += $subTotalPrice;
                                                      }
                                                ?>
                                    <?php $this->load->view('procurement/V_all_amd')?>
                                </div>
                            </fieldset>
                            <?php else:?>
                                <?php 
                                    $total = 0;
                                ?>
                            <?php endif;?>
                            <h6><i class="step-icon fa fa-thumbs-up"></i> <?= isset($issued) ? ' Amendment Data' : 'Amendment Recommendation' ?></h6>
                            <fieldset>
                                <?php if(isset($issued)): ?>
                                <?php else:?>
                                <div class="row amendment_recommendation_tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Analysis <small style="font-style: italic">(Technical justification and commercial impact for recommending the Amendment)</small></label>
                                            <?= $this->form->textarea('analysis', @$recom->analysis, 'class="form-control"') ?>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Negotiation</label><br>
                                            <?= $this->form->radio('nego', 0) ?> No
                                            <?= $this->form->radio('nego', 1) ?> Yes
                                        </div>
                                        <div class="form-group">
                                            <?= $this->form->textarea('nego_str', @$recom->nego_str, 'class="form-control" style="height:170px;"') ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row amendment_recommendation_tab">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Budget Analysis</label>
                                            <?= $this->form->textarea('budget_analysis', @$recom->budget_analysis, 'class="form-control"') ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <div class="row amendment_recommendation_tab">
                                    <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px;font-size: 17px">
                                        Agreement Data including this Amendment
                                    </div>
                                </div>
                                <div class="form-group row amendment_recommendation_tab">
                                    <label class="col-md-3">Original Agreement Value</label>
                                    <div class="col-md-3">
                                        <input class="form-control" disabled value="<?=numIndo($arf->amount_po)?>">
                                    </div>
                                    <label class="col-md-3">Additional Value</label>
                                    <div class="col-md-3">
                                        <input class="form-control" disabled value="<?=numIndo($total)?>">
                                    </div>
                                </div>
                                <div class="form-group row amendment_recommendation_tab">
                                    <label class="col-md-3">Latest Agreement Value</label>
                                    <div class="col-md-3">
                                      <input id="latest-agreement-value" class="form-control" disabled value="<?=numIndo($arf->amount_po_arf)?>">
                                    </div>
                                    <label class="col-md-3">New Agreement Value</label>
                                    <div class="col-md-3">
                                      <input id="new-agreement-value" class="form-control" disabled value="<?=numIndo($total+$arf->amount_po_arf)?>">
                                    </div>
                                </div>
                                <div class="form-group row amendment_recommendation_tab" style="margin-top:20px">
                                    <div class="col-md-6">
                                        BOD Approval for this Value Amendment Request is required
                                        <br>
                                        <input type="radio" name="bod_approval" value="0" <?= $arf->bod_approval == 0 ? "checked=''" : '' ?>>
                                        <label style="bottom: 10px;position: relative;margin-right: 20px;">No</label>
                                        <input type="radio" name="bod_approval" value="1" <?= $arf->bod_approval == 1 ? "checked=''" : '' ?> >
                                        <label style="bottom: 10px;position: relative;">Yes, BOD Review Required</label>
                                    </div>
                                    <div class="col-md-6">
                                        Accumulative Amendment
                                        <br>
                                        <input type="radio" name="aa" value="0" <?= $arf->aa == 0 ? "checked=''" : '' ?>>
                                        <label style="bottom: 10px;position: relative;margin-right: 20px;">No</label>
                                        <input type="radio" name="aa" value="1" <?= $arf->aa == 1 ? "checked=''" : '' ?>>
                                        <label style="bottom: 10px;position: relative;">Yes, requires 1 level up for the Amendment signature as per AAS</label>
                                    </div>
                                </div>
                                <div class="form-group row amendment_recommendation_tab">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5">
                                                Original Agreement Period
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                to
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" disabled value="<?=dateToIndo($po->delivery_date,false,false)?>">
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
                                                <input class="form-control" disabled value="<?= $arfRevisionTime ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row amendment_recommendation_tab">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5">
                                                Latest Agreement Period
                                                <!--
                                                po_date
                                                 -->
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                to
                                            </div>
                                            <div class="col-md-3">
                                                <!--
                                                    kondisi ammendment
                                                    max date di t_arf_detail_revision kolom tipe per doc_id
                                                 -->
                                                <input class="form-control" disabled value="<?=dateToIndo($arf->amended_date,false,false)?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-5">
                                                New Agreement Period
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                                            </div>
                                            <div class="col-md-1 text-center">
                                                to
                                            </div>
                                            <div class="col-md-3">
                                                <input class="form-control" disabled value="<?=dateToIndo($newAgreementPeriodTo,false,false)?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px;font-size: 17px">
                                        Additional Documents
                                    </div>
                                </div>
                                <div class="form-group row amendment_recommendation_tab">
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-4"></div>
                                            <div class="col-md-4">Original Expiry Date</div>
                                            <div class="col-md-4">Latest Expiry Date</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">Performance Bond</div>
                                            <div class="col-md-4">
                                                <input class="form-control" disabled value="<?= $performanceBondOriginalValue ?>">
                                            </div>
                                            <div class="col-md-4"><input class="form-control" disabled value="<?=$new_date_1?>" ></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-4">Insurance</div>
                                            <div class="col-md-4">
                                                <input class="form-control" disabled value="<?= $insuranceOriginalValue ?>">
                                            </div>
                                            <div class="col-md-4"><input class="form-control" disabled value="<?=$new_date_2?>"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-2">Extend</div>
                                            <div class="col-md-5">New Date</div>
                                            <div class="col-md-5">Remarks</div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="checkbox" name="extend1" id="extend1" value="1" 
                                                <?php
                                                    if($view)
                                                    {
                                                        echo $extend1 ? "disabled='' checked='checked'" : "";
                                                    }
                                                ?>
                                                >
                                            </div>
                                            <div class="col-md-5"><input class="form-control" disabled="" name="new_date_1" id="new_date_1" value="<?= $newDate1Now ?>" ></div>
                                            <div class="col-md-5"><input class="form-control" disabled="" name="remarks_1" id="remarks_1" value="<?= $remarks_1 ?>" ></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2">
                                                <input type="checkbox" name="extend2" id="extend2" value="1"
                                                <?php
                                                    if($view)
                                                    {
                                                        echo $extend2 ? "disabled='' checked='checked'" : "";
                                                    }
                                                ?>
                                                >
                                            </div>
                                            <div class="col-md-5"><input class="form-control" disabled="" name="new_date_2" id="new_date_2" value="<?= $newDate2Now ?>" ></div>
                                            <div class="col-md-5"><input class="form-control" disabled="" name="remarks_2" id="remarks_2" value="<?= $remarks_2 ?>" ></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px;font-size: 17px;">
                                        Recommendation
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="col-md-12">
                                        Based on the above overall analysis, Team is recommending continuing the amendment process by signing the Amendment <b><?= substr($arf->doc_no, -5) ?></b> of this Agreement.
                                    </div>
                                </div>
                            </fieldset>
                            <h6><i class="step-icon fa fa-paperclip"></i> Amendment Document</h6>
                            <fieldset>
                                <div class="row">
                                  <div class="col-md-12" style="margin-bottom: 10px">
                                    <a href="#" class="btn btn-success btn-sm pull-right btn-upload" data-toggle="modal" data-target="#myModal">Upload</a>
                                  </div>
                                  <div class="col-md-12">
                                    <div class="table-responsive">
                                      <table class="table table-condensed">
                                        <thead>
                                          <tr>
                                            <th>TYPE</th>
                                            <th>FILE NAME</th>
                                            <th>UPLOAD AT</th>
                                            <th>UPLOADER</th>
                                            <th>ACTION</th>
                                          </tr>
                                        </thead>
                                        <tbody id="devbled-attachment">
                                          <?php foreach ($doc as $key => $value) {
                                            $createdName = user($value->created_by)->NAME;
                                            if(isset($issued))
                                            {
                                                if($value->module_kode == 'arf-issued')
                                                {
                                                    $docType = arfIssuedDoc($value->tipe);
                                                    if($value->tipe == 2)
                                                    {
                                                        $vendor = $this->db->where(['ID'=>$value->created_by])->get('m_vendor')->row();
                                                        $createdName = $vendor->NAMA;
                                                    }
                                                }
                                                elseif($value->module_kode == 'arf-recom-prep')
                                                {
                                                    $docType = arfRecomPrepType($value->tipe, true);
                                                }
                                            }
                                            else
                                            {
                                                $docType = arfRecomPrepType($value->tipe, true);
                                            }
                                            echo "<tr>
                                              <td>$docType</td>
                                              <td>".$value->file_name."</td>
                                              <td>".dateToIndo($value->created_at, false, true)."</td>
                                              <td>".$createdName."</td>
                                              <td>
                                                <a href='".base_url($value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                                                <a href='#' class='btn btn-sm btn-danger btn-hapus-file' onclick='hapusFile($value->id)'>Hapus</a>
                                              </td>
                                            </tr>";
                                          }?>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                            </fieldset>
                            <?php if(isset($issued)): ?>
                            <?php else:?>
                            <?php if($approval_view): ?>
                            <h6 class="hidden"><i class="step-icon fa fa-thumbs-up"></i> Approval</h6>
                            <fieldset class="<?= $approval_count; ?>">
                              <div class="table-responsive">
                                <table class="table">
                                  <thead>
                                    <tr>
                                      <th>Role Akses</th>
                                      <th>User</th>
                                      <th>Approval Status</th>
                                      <th>Transaction Date</th>
                                      <th>Comments</th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <?php foreach ($approval_list->result() as $al) {
                                      $status = '';
                                      $transactionDate = '';
                                      if($al->sequence > 1)
                                      {
                                        if($al->status > 0)
                                          {
                                            $status = $al->status == 1 ? "Approve":"Reject";
                                            $transactionDate = dateToIndo($al->approved_at, false, false);
                                          }
                                          $approve_link = '';
                                          if($al->id_user == $this->session->userdata('ID_USER') and $al->status == 0)
                                          {
                                            $approve_link = "<a id='btn-approval-$al->id' onclick='approveClick($al->id)' href='#' class='btn btn-sm btn-primary'>Approve</a>";
                                          }
                                          if(@$is_reject)
                                          {
                                            $approve_link = '';
                                          }
                                          echo "<tr>
                                          <td>$al->role_name</td>
                                          <td>$al->user_name</td>
                                          <td id='status-$al->id'>$status</td>
                                          <td id='transaction-date-$al->id'>$transactionDate</td>
                                          <td id='note-$al->id'>$al->note</td>
                                          <td>
                                            $approve_link
                                          </td>
                                          </tr>";
                                      }
                                    }?>
                                  </tbody>
                                </table>
                              </div>
                            </fieldset>
                            <?php endif;?>
                            <?php endif;?>
                        </form>
                    </div>
                    <div class="card-footer">
                      <?php 
                        $back_url = base_url('procurement/amendment_recommendation/amd_lists');
                        if($this->input->get('back_url'))
                        {
                          $back_url = base_url('procurement/arf?status=submitted');
                        }
                      ?>
                      <a href="<?= $back_url ?>" class="btn btn-info">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#wizard-arf").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '#title#',
            enableFinishButton: false,
            enablePagination: false,
            enableAllSteps: true,
            enableFinishButton: false
        });
        const numberWithCommas = (x) => {
          return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
        function numberNormal(n='',separator='.') {
            n = n.replace(/\,/g, '');
            return n;
        }
        var new_agreement = $("#all-amd-<?= $arf->doc_no ?>").text();
        var latest_agreement_value = (toFloat(numberNormal(new_agreement)) - toFloat(<?= $total ?>));
        $("#latest-agreement-value").val(Localization.number(latest_agreement_value))
        $("#new-agreement-value").val(new_agreement)
        
        $('#new_date_1,#new_date_2').datepicker({
            dateFormat : 'yy-mm-dd'
        });
        $("#extend1").on('click',function(){
          var rs = $("#extend1:checked").val()
          if(rs)
          {
            $("#new_date_1,#remarks_1").removeAttr("disabled")
          }
          else
          {
            $("#new_date_1,#remarks_1").attr("disabled","disabled")
          }
        });
        $("#extend2").on('click',function(){
          var rs = $("#extend2:checked").val()
          if(rs)
          {
            $("#new_date_2,#remarks_2").removeAttr("disabled")
          }
          else
          {
            $("#new_date_2,#remarks_2").attr("disabled","disabled")
          }
        });
    });
  $(document).ready(function(){
    <?php if($approval_view): ?>
    $(".amendment_recommendation_tab textarea, .amendment_recommendation_tab input").attr("disabled","")
    $(".btn-upload, .btn-hapus-file").hide()
    <?php endif;?>
    <?php if(isset($issued)):?>
        $(".btn-upload, .btn-hapus-file").show()
    <?php endif;?>
    $("#arf_request_value").text('<?= numIndo($total) ?>');
  })
</script>