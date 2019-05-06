<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
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
                    <li class="breadcrumb-item">ARF Notification</li>
                  </ol>
                </div>
            </div>
        </div>
        <div class="row info-header">
            <div class="col-md-6">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td width="35%">Title</td>
                            <td width="1px">:</td>
                            <td><?= $arf->title ?></td>
                        </tr>
                        <tr>
                            <td>Contractor / Vendor</td>
                            <td>:</td>
                            <td><?= $arf->vendor ?></td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>:</td>
                            <td><?= $arf->company ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
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
                                        <h6><i class="step-icon fa fa-info"></i> Amendment Notification</h6>
                                        <fieldset>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-center">Type/Description<br><small>(thick one when applicable)</small></th>
                                                        <th style="vertical-align: top !important;">Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td width="1px">
                                                            <?php if (isset($arf->revision[1])) { ?>
                                                                <i class="fa fa-check-square text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-square-o"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td>Value</td>
                                                        <td>
                                                            <?php if (isset($arf->revision[1])) { ?>
                                                                <?= $arf->currency ?> <span id="amdNotificationValue"></span>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= @$arf->revision[1]->remark ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="1px">
                                                            <?php if (isset($arf->revision[2])) { ?>
                                                                <i class="fa fa-check-square text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-square-o"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td>Time</td>
                                                        <td><?= dateToIndo(@$arf->revision[2]->value) ?></td>
                                                        <td><?= @$arf->revision[2]->remark ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="1px">
                                                            <?php if (isset($arf->revision[3])) { ?>
                                                                <i class="fa fa-check-square text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-square-o"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td>Scope</td>
                                                        <td><?= @$arf->revision[3]->value ?></td>
                                                        <td><?= @$arf->revision[3]->remark ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="1px">
                                                            <?php if (isset($arf->revision[4])) { ?>
                                                                <i class="fa fa-check-square text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-square-o"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td width="50px">Other</td>
                                                        <td><?= @$arf->revision[4]->value ?></td>
                                                        <td><?= @$arf->revision[4]->remark ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-4">Contractor/Vendor to Response no Later then</label>
                                                        <div class="col-md-6">
                                                            <?= dateToIndo($arf->response_date, false, true) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ht>
                                            <table class="table" style="font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>File</th>
                                                        <th>Upload At</th>
                                                        <th>Uploader</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($arf->attachment as $attachment) { ?>
                                                        <tr>
                                                            <td><?= $attachment->file_name ?></td>
                                                            <td><a href="<?= base_url($attachment->file_path) ?>" target="_blank">Download</a></td>
                                                            <td><?= dateToIndo($attachment->create_date, false, true) ?></td>
                                                            <td><?= $attachment->creator ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </fieldset>
                                        <?php if(isset($arf->revision[1])): ?>
                                        <h6><i class="step-icon fa fa-calendar"></i> Schedule of Price</h6>
                                        <fieldset>
                                            <div id="po-detail">
                                                <h4>Contract List Item</h4>
                                                <table width="100%" id="po_item-table" class="table table-bordered table-sm" style="font-size: 12px;">
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
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>ARF List</h4>
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
                                                        <?= numIndo($arf->response_subtotal) ?>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="offset-md-6 col-md-3">Total Summary</label>
                                                    <div class="col-md-3 text-right">
                                                        <?= numIndo(($arf->amount_po+$arf->response_subtotal)) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <?php endif;?>
                                        <h6><i class="step-icon fa fa-exclamation"></i> Amendment Notification Response</h6>
                                        <fieldset>
                                            <h4>Amendment Notification Response</h4>
                                            <hr>
                                            <div class="form-group">
                                                <?= $this->m_arf_response->enum('confirm', $arf->confirm) ?>
                                            </div>
                                            <div class="form-group">
                                                <?= nl2br($arf->note) ?>
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
                                                            <td><a href="<?= base_url($document_path.'/'.$attachment->file) ?>" target="_blank"><?= $attachment->file ?></a></td>
                                                            <td><?= dateToIndo($attachment->created_at, false, true) ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </fieldset>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
        <a href="<?= base_url('vn/info/arf_notification/submitted') ?>" class="btn btn-secondary">Back</a>
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
        <?php if(isset($total)): ?>
        $("#amdNotificationValue").text('<?= numIndo($total) ?>')
        <?php endif;?>
    });
</script>