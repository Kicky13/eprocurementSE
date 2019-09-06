<?php $this->load->view('procurement/partials/script') ?>
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
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Amendment Acceptance & Supplier Document Submission", "Amendment Acceptance & Supplier Document Submission") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
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
                                <td width="35%">Title</td>
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
                                <td><?= $arf->currency?> <span id="amendment_value"><?= numIndo($arf->estimated_value) ?></span></td>
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
                                <td><?= substr($arf->doc_no, -5) ?></td>
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
                            <h6><i class="step-icon icon-info"></i> Amendment Data</h6>
                            <fieldset>
							<?php
                                $stt = 0;
                                foreach ($arf->item as $item) {
                                    $qty = $item->qty2 > 0 ? $item->qty1*$item->qty2 : $item->qty1;
                                    $response_qty = $item->response_qty2 > 0 ? $item->response_qty1*$item->response_qty2 : $item->response_qty1;
                                    $uom = $item->uom2 ? $item->uom1.'/'.$item->uom2 : $item->uom1;
                                    $stt += $item->response_unit_price * $response_qty;
                                }
                            ?>
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
                                    <div class="col-md-3 text-right" id="additonal_value">
                                        
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-3">Latest Agreement Value</label>
                                    <div class="col-md-3 text-right" id="latest-agreement-value">
                                    </div>
                                    <label class="col-md-3">New Agreement Value</label>
                                    <div class="col-md-3 text-right" id="new-agreement-value">
                                    </div>
                                </div>
                                <div class="form-group row" style="margin-top:20px">
                                    <div class="col-md-6">
                                        BOD Approval for this Value Amendment Request is required
                                        <br>
                                        <?php if ($arf->bod_approval) { ?>
                                            <i class="fa fa-square-o"></i> No
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="fa fa-check-square-o text-success"></i> Yes, Bod Review Required
                                        <?php } else { ?>
                                            <i class="fa fa-check-square-o text-success"></i> No
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="fa fa-square-o"></i> Yes, Bod Review Required
                                        <?php } ?>
                                    </div>
                                    <div class="col-md-6">
                                        Accumulative Amendment(s) value exceeds 30% of original Contract Value
                                        <br>
                                        <?php if ($arf->aa) { ?>
                                            <i class="fa fa-square-o"></i> No
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="fa fa-check-square-o text-success"></i> Yes, requires 1 level up for the Amendment signature as per AAS
                                        <?php } else { ?>
                                            <i class="fa fa-check-square-o text-success"></i> No
                                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                            <i class="fa fa-square-o"></i> Yes, requires 1 level up for the Amendment signature as per AAS
                                        <?php } ?>
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
                                                    <?= dateToIndo($arf->revision['time']->value,false,false ) ?>
                                                <?php } else { ?>
                                                    -
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
                                                <?= dateToIndo(getLastTimeAmd($arf->doc_no, $po->delivery_date),false,false) ?>
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
                                                <?=  dateToIndo(getLastTimeAmd($arf->doc_no, $arf->amended_date,"<="), false, false) ?>
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
                            <h6><i class="step-icon fa fa-calendar"></i> Schedule of Price</h6>
                            <fieldset>
                                <div class="nav nav-tabs sub-tabs" id="nav-tab" role="tablist">
                                    <a class="nav-item nav-link active" id="nav-arf-sop" data-toggle="tab" href="#tab-arf-sop" role="tab" aria-controls="nav-home" aria-selected="true">ARF</a>
                                    <a class="nav-item nav-link" id="nav-response-sop" data-toggle="tab" href="#tab-response-sop" role="tab" aria-controls="nav-profile" aria-selected="false">Amendment</a>
                                </div>
                                <div class="tab-content" id="nav-tabContent">
                                    <div class="tab-pane fade show active" id="tab-arf-sop" role="tabpanel" aria-labelledby="original-value-tab" style="padding: 15px 0px;">
                                      <?php $this->load->view('procurement/V_amendment_acceptance_sop_arf')?>
                                    </div>
                                    <div class="tab-pane fade show" id="tab-response-sop" role="tabpanel" aria-labelledby="latest-value-tab" style="padding: 15px 0px;">
                                      <?php $this->load->view('procurement/V_amendment_acceptance_sop_response')?>  
                                    </div>
                                </div>
                            </fieldset>
                            <h6><i class="step-icon fa fa-paperclip"></i> Amendment Document</h6>
                            <fieldset>
                                <div class="row">
                                  <div class="col-md-12" style="margin-bottom: 10px">
                                    <a href="#" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#myModal">Upload</a>
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
                                            $uploadName = $value->creator_type == 'vendor' ? supplier($value->created_by)->NAMA : user($value->created_by)->NAME;
                                            echo "<tr>
                                              <td>".arfIssuedDoc($value->tipe)."</td>
                                              <td>".$value->file_name."</td>
                                              <td>".$value->created_at."</td>
                                              <td>".$uploadName."</td>
                                              <td>
                                                <a href='".base_url($value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                                                <a href='#' class='btn btn-sm btn-danger' onclick='hapusFile($value->id)'>Hapus</a>
                                              </td>
                                            </tr>";
                                          }?>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                </div>
                            </fieldset>

                            <h6><i class="step-icon fa fa-check"></i> Supporting Document</h6>
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
                                        <?php foreach ($acceptance_docs as $doc) { 
                                            if($doc->type == 1){
                                        ?>
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
                                                <td class="text-right"><a href="<?= base_url('./upload/amd_acceptance_vendor/'.$doc->file) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } } ?>
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
                                        <?php foreach ($po->doc_issurance as $doc) { ?>
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
                                        <?php foreach ($acceptance_docs as $doc) { 
                                            if($doc->type == 2){
                                        ?>
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
                                                <td class="text-right"><a href="<?= base_url('./upload/amd_acceptance_vendor/'.$doc->file) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } } ?>
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
                                        <?php foreach ($acceptance_docs as $doc) { 
                                            if($doc->type == 3){
                                        ?>
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
                                                <td class="text-right"><a href="<?= base_url('./upload/amd_acceptance_vendor/'.$doc->file) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                            </fieldset>
                        </form>
                    </div>
                    <div class="card-footer">
                      <button class="btn btn-danger doc_counter_sign" <?= $doc_counter_sign == 0 ? "disabled=''" : "style='display:none'" ?> type="button">Conter Sign Document Required</button>
                      <button class="btn btn-success completness-button" <?= $doc_counter_sign == 1 ? "":"style='display:none'" ?> type="button" onclick="completnesSubmit()">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-completness" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Supporting Document</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="body-completness" class="modal-body" style="max-height: 70vh; overflow-y: auto;">

            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="completness-submit-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Amendment Completed</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <button class="btn btn-primary pull-right" type="button" onclick="amendmentCompleteClick()">Ok</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Upload</h4>
      </div>
      <div class="modal-body">
        <form id="form-attachment-arf-acceptance" method="post" class="form-horizontal open-this" enctype="multipart/form-data">
          <!-- data_id -->
          <input type="hidden" name="module_kode" value="arf-issued">
          <input type="hidden" name="data_id" value="<?=$arf->doc_no?>">
          <!-- m_approval_id -->
          <div class="form-group">
            <label>Type</label>
            <div class="col-sm-12">
              <select class="form-control" name="tipe" id="tipe">
                <option value="1">Amendment Signed</option>
                <option value="2">Counter Signed</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>File</label>
            <div class="col-sm-12">
              <input type="file" class="form-control" name="file_path" id="file_path" />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" onclick="attachmentClick()" class="btn btn-primary">Upload</button>
            </div>
          </div>
        </form>
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
        var latest_agreement_value = (toFloat(numberNormal(new_agreement)) - toFloat(<?= $stt ?>));
        $("#latest-agreement-value").html(Localization.number(latest_agreement_value))
        $("#new-agreement-value").html(new_agreement)
        $("#amendment_value").text($("#additonal_value").text())
		function get_ajax_last_agreement() {
            $.ajax({
                type:'post',
                url:"<?= base_url('procurement/browse/last_amd_when_create_amd/'.$arf->doc_no) ?>",
                success: function (data) {
                    $("#latest-agreement-value").html(Localization.number(data))
					//alert(data)
                    var new_agreement = (toFloat(data) + toFloat(numberNormal($("#additional-value-<?=$arf->doc_no?>").text())));
                    $("#new-agreement-value").html(Localization.number(new_agreement))
                }
            })
        }
        get_ajax_last_agreement()
    });
    function completnessClick(id) {
        $.ajax({
            type:'POST',
            data:{id:id},
            url:"<?=base_url('procurement/amendment_acceptance/completness')?>",
            success:function(e){
                $("#body-completness").html(e)
                $("#modal-completness").modal('show')
            }
        })
    }
    function completnesStore() {
      var form = $("#compleness-form")[0];
      var data = new FormData(form);
      $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "<?=base_url('procurement/amendment_acceptance/completness_store')?>",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          beforeSend:function(){
            start($('#wizard-arf'));
          },
          success: function (data) {
            var e = eval("("+data+")");
            if(e.status)
            {
              stop($('#wizard-arf'));
              $("#modal-completness").modal('hide');
              alert(e.msg)
              $("#completness-performance-bond").html(e.html)
            }
            else
            {
              alert('Fail, Try Again');
              stop($('#wizard-arf'));
              $("#modal-completness").modal('hide');
            }
          },
          error: function (e) {
            alert('Fail, Try Again');
            stop($('#wizard-arf'));
            $("#modal-completness").modal('hide');
          }
      });
    }
    function completnesSubmit() {
      $("#completness-submit-modal").modal('show')
    }
    function amendmentCompleteClick() {
        $.ajax({
            type:'POST',
            data:{id:"<?= $arf->acceptance->id ?>"},
            url:"<?=base_url('procurement/amendment_acceptance/store')?>",
            beforeSend:function(){
                start($('#wizard-arf'));
            },
            success:function(data){
                var e = eval("("+data+")");
                if(e.status)
                {
                  stop($('#wizard-arf'));
                  $("#completness-submit-modal").modal('hide');
                  alert(e.msg)
                  window.open("<?= base_url('home') ?>","_self")
                }
                else
                {
                  alert('Fail, Try Again');
                  stop($('#wizard-arf'));
                  $("#completness-submit-modal").modal('hide');
                }
            },
            error: function (e) {
                alert('Fail, Try Again');
                stop($('#wizard-arf'));
                $("#completness-submit-modal").modal('hide');
            }
        })
    }
  function attachmentClick() {
      var form = $("#form-attachment-arf-acceptance")[0];
      var data = new FormData(form);
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "<?=base_url('procurement/amendment_acceptance/attachment_upload')?>",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        beforeSend:function(){
          start($('#myModal'));
        },
        success: function (data) {
          $("#devbled-attachment").html(data);
          stop($('#myModal'));
          $("#myModal").modal('hide');
          $("#file_path").val('');
          $("#file_name").val('');
            checkCounterSign();
        },
        error: function (e) {
          swal('Ooopss', 'Fail, Try Again', 'warning');
          stop($('#myModal'));
          $("#myModal").modal('hide');
            checkCounterSign();
        }
      });
    }
    function hapusFile(argument) {
      swalConfirm('Amendment Acceptance', 'Are you sure to delete this data ?', function() {
        $.ajax({
          url:'<?=base_url('procurement/amendment_acceptance/hapus_attachment')?>/'+argument,
          beforeSend:function(){
            start($('#icon-tabs'));
          },
          success: function (data) {
            $("#devbled-attachment").html(data);
            stop($('#icon-tabs'));
            checkCounterSign();
          },
          error: function (e) {
            swal('Ooopss', 'Fail, Try Again', 'warning');
            stop($('#icon-tabs'));
            checkCounterSign();
          }
        });
      })
    }
    function checkCounterSign() {
      $.ajax({
        type:'post',
        data:{doc_no:"<?=$arf->doc_no?>"},
        url:"<?= base_url('procurement/amendment_acceptance/check_counter_sign') ?>",
        success:function(e){
          var r = eval("("+e+")");
          if(r.status)
          {
            $(".doc_counter_sign").hide();
            $(".completness-button").show();
          }
          else
          {
            $(".doc_counter_sign").show();
            $(".doc_counter_sign").attr('disabled','');
            $(".completness-button").hide();
          }
        }
      })
    }
</script>