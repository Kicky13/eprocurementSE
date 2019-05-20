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
        <?= $this->form->open(null, 'id="form-acceptance" class="open-this"') ?>
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
                                            <div class="form-group row" style="margin-top:20px;display: none !important">
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
                                                    Accumulative Amendment
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
                                                        <div class="col-md-8">
                                                            Additional Time
                                                        </div>
                                                        <div class="col-md-1" style="font-weight: bold">
                                                            Up to
                                                        </div>
                                                        <div class="col-md-3">
                                                            <?php if (isset($arf->revision['time'])) { ?>
                                                                <?= dateToIndo($arf->revision['time']->value,false,false ) ?>
                                                            <?php } else { ?>
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
                                                            <?= dateToIndo($arf->amended_date,false,false) ?>
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
                                            <div id="po-detail">
                                                <h4>Contract List Item</h4>
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
                                                <?php $this->load->view('procurement/V_all_amd', ['dataTotalSummary'=>0]) ?>
                                            </div>
                                        </fieldset>
                                        <h6><i class="step-icon fa fa-paperclip"></i> Amendment Document</h6>
                                        <fieldset>
                                            <div class="col-md-12" style="margin-bottom: 10px">
                                                <a href="#" class="btn btn-success btn-sm pull-right btn-upload" data-toggle="modal" data-target="#myModal">Upload</a>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="table-responsive">
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
                                                        <tbody id="devbled-attachment">
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
                                                                      <?php if($document->tipe == 2)
                                                                      {
                                                                        echo "<a href='#' class='btn btn-sm btn-danger btn-hapus-file' onclick='hapusFile($document->id)'>Hapus</a>";
                                                                      }
                                                                      ?>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <h6><i class="step-icon fa fa-check"></i> Completeness</h6>
                                        <fieldset>
                                            <?php if ($arf->extend1) { ?>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h4>Performance Bond</h4>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="btn btn-success" onclick="open_form_document(1)">Update</button>
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
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                            <?php if ($arf->extend2) { ?>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h4>Insurance</h4>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="btn btn-success" onclick="open_form_document(2)">Update</button>
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
                                                </tbody>
                                            </table>
                                            <?php } ?>
                                            <?php if ($arf->extend1 || $arf->extend2) { ?>
                                            <div class="form-group row">
                                                <div class="col-md-6">
                                                    <h4>Other</h4>
                                                </div>
                                                <div class="col-md-6 text-right">
                                                    <button type="button" class="btn btn-success" onclick="open_form_document(3)">Update</button>
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
        <button type="button" id="btn-submit" class="btn btn-success">Completeness</button>
        <?= $this->form->close() ?>
    </div>
</div>

<div class="modal fade" id="document-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" style="max-height: 70vh; overflow-y: auto;">
                <input type="hidden" name="type" id="document-modal-type">
                <div class="form-group">
                    <label>Document No</label>
                    <?= $this->form->text('no', null, 'id="document-modal-no" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Issuer</label>
                    <?= $this->form->text('issuer', null, 'id="document-modal-issuer" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Issued Date</label>
                    <?= $this->form->text('issued_date', null, 'id="document-modal-issued_date" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Value</label>
                    <?= $this->form->text('value', null, 'id="document-modal-value" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Currency</label>
                    <?= $arf->currency ?>
                </div>
                <div class="form-group">
                    <label>Effective Date</label>
                    <?= $this->form->text('effective_date', null, 'id="document-modal-effective_date" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Expired Date</label>
                    <?= $this->form->text('expired_date', null, 'id="document-modal-expired_date" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Description</label>
                    <?= $this->form->text('description', null, 'id="document-modal-description" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Chose File</label>
                    <input type="file" name="document" id="document-modal-file">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="document_upload()">Upload</button>
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
    var document_row = [];
    document_row[1] = $('#document-table-1 tbody [data-row-id]').length;
    $('#document-modal-issued_date, #document-modal-effective_date, #document-modal-expired_date').datepicker({
        format: "yyyy-mm-dd"
    });
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

        $('#document-modal-value').number(true,2);

        $('#document-modal').on('hidden.bs.modal', function() {
            $('#document-modal-type').val('');
            $('#document-modal-no').val('');
            $('#document-modal-issuer').val('');
            $('#document-modal-issued_date').val('');
            $('#document-modal-value').val(0);
            $('#document-modal-effective_date').val('');
            $('#document-modal-expired_date').val('');
            $('#document-modal-description').val('');
        });

        $('#btn-submit').click(function() {
            swalConfirm('Amendment Accumulative', 'Are you sure to proceed ?', function() {
                $.ajax({
                    url: '<?= base_url('vn/info/amendment_acceptance/store/'.$arf->id) ?>',
                    type: 'post',
                    data: $('#form-acceptance').serialize(),
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            setTimeout(function() {
                                swalAlert('Done', 'Data is successfully submitted', '<?= base_url('vn/info/amendment_acceptance') ?>');
                            }, swalDelay);
                        } else {
                            setTimeout(function() {
                                swal('Ooops', response.message, 'error');
                            }, swalDelay);
                        }
                    }
                });
            });
        });
    })

    function open_form_document(type) {
        $('#document-modal-type').val(type);
        $('#document-modal').modal('show');
    }

    function document_upload() {
        $('#document-modal #error_message').remove();
        var formData = new FormData;
        formData.append('type', $('#document-modal-type').val());
        formData.append('no', $('#document-modal-no').val());
        formData.append('issuer', $('#document-modal-issuer').val());
        formData.append('issued_date', $('#document-modal-issued_date').val());
        formData.append('value', $('#document-modal-value').val());
        formData.append('effective_date', $('#document-modal-effective_date').val());
        formData.append('expired_date', $('#document-modal-expired_date').val());
        formData.append('description', $('#document-modal-description').val());
        formData.append('file', $('#document-modal-file')[0].files[0]);
        $.ajax({
            type:'POST',
            enctype:'multipart/form-data',
            data: formData,
            processData: false,
            contentType: false,
            dataType:'json',
            url : '<?= base_url('vn/info/amendment_acceptance/document_upload') ?>',
            success : function(response) {
                if (response.success) {
                    add_document(response.data);
                    $('#document-modal').modal('hide');
                } else {
                    $('#document-modal .modal-body').prepend('<div id="error_message" class="alert alert-danger">'+response.message+'</div>');
                }
            }
        });
    }

    function add_document(data) {
        var html = '<tr data-row-id="'+document_row[data.type]+'">';
            html += '<td></td>';
            html += '<td><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][no]" value="'+data.no+'"><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][file]" value="'+data.file.file_name+'">'+data.no+'</td>';
            html += '<td class="text-center"><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][issuer]" value="'+data.issuer+'">'+data.issuer+'</td>';
            html += '<td class="text-center"><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][issued_date]" value="'+data.issued_date+'">'+data.issued_date+'</td>';
            html += '<td class="text-center"><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][value]" value="'+data.value+'">'+data.value+'</td>';
            html += '<td class="text-center"><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][currency_id]" value="<?= $arf->currency_id ?>"><?= $arf->currency ?></td>';
            html += '<td class="text-center"><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][effective_date]" value="'+data.effective_date+'">'+data.effective_date+'</td>';
            html += '<td class="text-center"><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][expired_date]" value="'+data.expired_date+'">'+data.expired_date+'</td>';
            html += '<td><input type="hidden" name="document['+data.type+']['+document_row[data.type]+'][description]" value="'+data.description+'">'+data.description+'</td>';
            html += '<td>';
                html +='<a href="<?= base_url($document_path) ?>/'+data.file.file_name+'" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a> ';
                html += '<button type="button" class="btn btn-danger btn-sm" onclick="remove_document(\''+document_row[data.type]+'\')"><i class="fa fa-trash"></i></button>';
            html += '</td>';
        html += '</tr>';
        $('#document-table-'+data.type+' tbody').append(html);
        document_row[data.type]++;
    }

    function remove_document(id) {
        $('#document-table tbody [data-row-id="'+id+'"]').remove();
    }
    function attachmentClick() {
      var form = $("#form-attachment-arf-acceptance")[0];
      var data = new FormData(form);
      $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "<?=base_url('vn/info/amendment_acceptance/attachment_upload')?>",
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
          },
          error: function (e) {
            swal('Ooopss', 'Fail, Try Again', 'warning');
            stop($('#myModal'));
            $("#myModal").modal('hide');
          }
      });
    }
    function hapusFile(argument) {
      swalConfirm('Amendment Acceptance', 'Are you sure to delete this data ?', function() {
        $.ajax({
          url:'<?=base_url('vn/info/amendment_acceptance/hapus_attachment')?>/'+argument,
          beforeSend:function(){
            start($('#icon-tabs'));
          },
          success: function (data) {
            $("#devbled-attachment").html(data);
            stop($('#icon-tabs'));
          },
          error: function (e) {
            swal('Ooopss', 'Fail, Try Again', 'warning');
            stop($('#icon-tabs'));
          }
        });
      })
    }
</script>