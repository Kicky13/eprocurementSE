<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">
                    <?php if ($approval && $approval->sequence > 1) { ?>
                        Approval Service Receipt
                    <?php } else { ?>
                        View Service Receipt
                    <?php } ?>
                </h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Service Receipt", "Service Receipt") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row">
                <div class="col-md-4">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="35%">Company</td>
                                <td width="1px">:</td>
                                <td><?= $itp->company ?></td>
                            </tr>
                            <tr>
                                <td>Department</td>
                                <td>:</td>
                                <td><?= $itp->department ?></td>
                            </tr>
                            <tr>
                                <td>Agreement No</td>
                                <td>:</td>
                                <td><?= $itp->no_po ?></td>
                            </tr>
                            <tr>
                                <td>Vendor</td>
                                <td>:</td>
                                <td><?= $itp->vendor ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="35%">ITP Date</td>
                                <td width="1px">:</td>
                                <td><?= dateToIndo($itp->dated) ?></td>
                            </tr>
                            <tr>
                                <td>ITP No</td>
                                <td>:</td>
                                <td><?= $itp->itp_no ?></td>
                            </tr>
                            <tr>
                                <td>ITP Creator</td>
                                <td>:</td>
                                <td><?= $itp->creator ?></td>
                            </tr>
                            <tr>
                                <td colspan="3">
                                    Note
                                    <p style="margin-top: 10px; font-size: 12px"><?= $itp->note ?></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table">
                        <tbody>
                            <tr>
                                <td width="35%">Total</td>
                                <td width="1px">:</td>
                                <td class="text-right"><?= display_multi_currency_format($itp->total, $itp->currency, $itp->total_base, $itp->currency_base) ?></td>
                            </tr>
                            <tr>
                                <td>Total Receipt</td>
                                <td>:</td>
                                <td class="text-right">
                                    <?= display_multi_currency_format($total_receipt->total_receipt, $itp->currency, exchange_rate_by_id($total_receipt->id_currency, $total_receipt->id_currency_base, $total_receipt->total_receipt), $itp->currency_base) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Remaining</td>
                                <td>:</td>
                                <td class="text-right">
                                    <?= $this->form->hidden('remaning', ($itp->total - $total_receipt->total_receipt), 'id="remaining"') ?>
                                    <?= display_multi_currency_format(($itp->total - $total_receipt->total_receipt), $itp->currency, ($itp->total_base - exchange_rate_by_id($total_receipt->id_currency, $total_receipt->id_currency_base, $total_receipt->total_receipt)), $itp->currency_base) ?>
                                </td>
                            </tr>
                            <tr>
                                <td>Remaining (%)</td>
                                <td>:</td>
                                <td >
                                    <?= round((($itp->total - $total_receipt->total_receipt)/$itp->total) * 100, 2)  ?>%
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="icons-tab-steps wizard-circle">
                            <h6><i class="step-icon fa fa-info"></i> Service Receipt</h6>
                            <fieldset>
                                <div class="row">
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td width="40%">Service Receipt No</td>
                                                    <td width="1px">:</td>
                                                    <td><?= $model->service_receipt_no ?></td>
                                                </tr>
                                                <tr>
                                                    <td>Receipt Date</td>
                                                    <td>:</td>
                                                    <td><?= dateToIndo($model->receipt_date) ?></td>
                                                </tr>
                                                <?php if ($model->id_external) { ?>
                                                    <tr>
                                                        <td>ID External</td>
                                                        <td>:</td>
                                                        <td><?= $model->id_external ?></td>
                                                    </tr>
                                                <?php } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-6">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        Note
                                                        <p style="margin-top: 10px; font-size: 12px"><?= $model->note ?></p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <h2>Item Selection</h2>
                                <table id="detail-item-table" class="table table-bordered table-no-wrap" style="font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th class="text-center">No</th>
                                            <th width="150px">Description</th>
                                            <th>Qty</th>
                                            <th>Unit Price</th>
                                            <th>Total</th>
                                            <th class="text-center">SR Qty Spending</th>
                                            <th class="text-right">SR Total Spending</th>
                                            <th class="text-center">Actual Qty Spending</th>
                                            <th class="text-right">Actual Total Spending</th>
                                            <th class="text-center">Remaining</th>
                                            <th class="text-center">Remaining (%)</th>
                                            <th width="75px" class="text-center">Qty Receipt</th>
                                            <th width="100px" class="text-right">Total Receipt</th>
                                            <th width="150px">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1 ?>
                                        <?php foreach ($itp->detail as $detail) { ?>
                                            <tr data-detail-item-row="<?= $detail->id_itp ?>-<?= $detail->material_id ?>">
                                                <td class="text-center"><?= $no ?></td>
                                                <td><?= $detail->material ?></td>
                                                <td class="text-center"><?= $detail->qty ?></td>
                                                <td class="text-right">
                                                    <?= numIndo($detail->priceunit) ?>
                                                </td>
                                                <td class="text-right"><?= numIndo($detail->total) ?></td>
                                                <td class="text-center"><?= $detail->qty_spending ?></td>
                                                <td class="text-right"><?= numIndo($detail->total_spending) ?></td>
                                                <td class="text-center"><?= $detail->qty_actual ?></td>
                                                <td class="text-right"><?= numIndo($detail->total_actual) ?></td>
                                                <td class="text-right"><?= numIndo(($detail->total - $detail->total_spending)) ?></td>
                                                <td class="text-center">
                                                    <?= (($detail->total - $detail->total_spending)/$detail->total) * 100 ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= @$model->item[$detail->id_itp][$detail->material_id]->qty ?>
                                                </td>
                                                <td class="text-right">
                                                    <?= numIndo(@$model->item[$detail->id_itp][$detail->material_id]->total) ?>
                                                </td>
                                                <td><?= @$model->item[$detail->id_itp][$detail->material_id]->note ?></td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <br></br>
                                <div class="row">
                                    <div class="offset-md-6 col-md-6">
                                        <table class="table">
                                            <tbody>
                                                <tr>
                                                    <td width="35%">Total Receipt</td>
                                                    <td width="1px">:</td>
                                                    <td class="text-right">
                                                        <?= $itp->currency ?>
                                                        <?= numIndo($model->subtotal) ?>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </fieldset>
                            <h6><i class="step-icon fa fa-paperclip"></i> Attachment</h6>
                            <fieldset>
                                <div class="form-group text-right">
                                    <!-- <button type="button" id="btn-attachment-modal" class="btn btn-success">Upload</button> -->
                                </div>
                                <div class="form-group">
                                    <table class="table table-bordered" id="detail-attachment">
                                        <thead>
                                            <tr>
                                                <th>Description</th>
                                                <th>File</th>
                                                <th>Upload At</th>
                                                <th>Uploader</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php foreach ($attachment as $atc) { ?>
                                            <tr>
                                                <td><?= $atc->description ?></td>
                                                <td><a href="<?= base_url('upload/PROCUREMENT/SERVICE_RECEIPT') ?>"><?= $atc->file ?></a></td>
                                                <td><?= dateToIndo($atc->created_date, false, true) ?></td>
                                                <td><?= $atc->creator ?></td>
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                </div>
            </div>
            <?php if ($approval && ($approval->sequence == 1 || $approval->edit_content == 1)) { ?>
                <a href="<?= base_url('procurement/service_receipt/edit/'.$itp->id_itp.'/'.$model->id) ?>" class="btn btn-warning">Edit & Resubmit</a>
            <?php } ?>
            <?php if ($approval && $approval->sequence > 1) { ?>
                <div class="text-right">
                    <button type="button" id="btn-reject-modal" class="btn btn-danger">Reject</button>
                    <button type="button" id="btn-approve-modal" class="btn btn-success">Approve</button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<div class="modal fade" id="approve-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Note</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->form->textarea('approve_description', null, 'id="form-approve-description" class="form-control" placeholder="Enter your note"') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-approve" class="btn btn-success">Approve</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="reject-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reason</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->form->textarea('reject_description', null, 'id="form-reject-description" class="form-control" placeholder="Enter your reason"') ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-reject" class="btn btn-danger">Reject</button>
            </div>
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
            enablePagination: true,
            enableAllSteps: true,
            enableFinishButton: false,
            labels: {
                finish: 'Done'
            },
            onInit: function (event, current) {
                $('.actions > ul > li').attr('style', 'display:none');
            },
            onStepChanged: function (event, current, next) {
                $('.actions > ul > li').attr('style', 'display:none');
            }
        });

        $('#detail-item-table').dataTable({
            searching : false,
            paging : false,
            ordering : false,
            info : false,
            fixedColumns : {
                leftColumns : 2,
                rightColumns : 3
            },
            scrollX : true
        });
        $('#approve-modal').on('hidden.bs.modal', function() {
            $('#form-approve-description').val('');
        });
        $('#reject-modal').on('hidden.bs.modal', function() {
            $('#form-reject-description').val('');
        });
        $('#btn-approve-modal').click(function() {
            $('#approve-modal').modal('show');
        });
        $('#btn-approve').click(function() {
            swalConfirm('Service Receipt', 'Are you sure to proceed ?', function() {
                $.ajax({
                    url : '<?= base_url('procurement/service_receipt/approval_store/'.$itp->id_itp.'/'.$model->id) ?>',
                    type : 'post',
                    data : {
                        description : $('#form-approve-description').val(),
                        status : 1
                    },
                    success : function(response) {
                        if (response.success) {
                            setTimeout(function() {
                                swalAlert('Done', 'Data is successfully submitted', function() {
                                    document.location.href = '<?=  base_url('procurement/service_receipt/approval') ?>';
                                });
                            }, swalDelay);
                        } else {
                            setTimout(function() {
                                swal('Ooopss', response.message, 'warning');
                            }, swalDelay);
                        }
                    }
                });
            });
        });
        $('#btn-reject-modal').click(function() {
            $('#reject-modal').modal('show');
        });
        $('#btn-reject').click(function() {
            $.ajax({
                url : '<?= base_url('procurement/service_receipt/approval_store/'.$itp->id_itp.'/'.$model->id) ?>',
                type : 'post',
                data : {status : 2, description : $('#form-reject-description').val()},
                success : function(response) {
                    if (response.success) {
                        swalAlert('Done', 'Data is successfully submitted', function() {
                            document.location.href = '<?=  base_url('procurement/service_receipt/approval') ?>';
                        });
                    } else {
                        swal('Ooopss', response.message, 'warning');
                    }
                }
            });
        });
    });
</script>