<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">Service Receipt No <?= $service_receipt->service_receipt_no ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                    <li class="breadcrumb-item">Service Receipt</li>
                  </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="content-body">
                    <section id="icon-tabs">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body card-scroll">
                                    <div class="icons-tab-steps wizard-circl">
                                        <h6><i class="step-icon fa fa-info"></i> Service Receipt</h6>
                                        <fieldset>
                                            <table class="table table-striped" style="font-size: 12px;">
                                                <tbody>
                                                    <tr>
                                                        <td>Company</td>
                                                        <td><?= $service_receipt->company ?></td>
                                                        <td>SR No</td>
                                                        <td><?= $service_receipt->service_receipt_no ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>PO</td>
                                                        <td><?= $service_receipt->no_po ?></td>
                                                        <td>Receipt Date</td>
                                                        <td><?= dateToIndo($service_receipt->receipt_date) ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>ITP No</td>
                                                        <td><?= $service_receipt->itp_no ?></td>
                                                        <td>Total Receipt</td>
                                                        <td><?= $service_receipt->currency ?> <?= numIndo($service_receipt->subtotal) ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <h4>Item</h4>
                                            <table class="table table-striped table-price">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">No</th>
                                                        <th width="150px">Description</th>
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-center">Currency</th>
                                                        <th class="text-right">Unit Price</th>
                                                        <th class="text-right">Total</th>
                                                        <th width="150px">Note</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1 ?>
                                                    <?php foreach ($service_receipt->detail as $detail) { ?>
                                                        <tr>
                                                            <td class="text-center" width="1px"><?= $no ?></td>
                                                            <td><?= $detail->material ?></td>
                                                            <td class="text-center"><?= $detail->qty ?></td>
                                                            <td class="text-center"><?= $service_receipt->currency ?></td>
                                                            <td class="text-right"><?= numIndo($detail->price) ?></td>
                                                            <td class="text-right"><?= numIndo($detail->total) ?></td>
                                                            <td>
                                                                <?= nl2br($detail->note) ?>
                                                            </td>
                                                        </tr>
                                                        <?php $no++ ?>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </fieldset>
                                        <h6><i class="step-icon fa fa-paperclip"></i> Attachment</h6>
                                        <fieldset>
                                            <table class="table table-striped table-price">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" width="1px">No</th>
                                                        <th width="150px">description</th>
                                                        <th class="text-right">Download</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php $no = 1 ?>
                                                    <?php foreach ($service_receipt->attachments as $attachment) { ?>
                                                        <tr>
                                                            <td class="text-center"><?= $no ?></td>
                                                            <td><?= $attachment->description ?>
                                                            <td class="text-right"><a href="<?= base_url('upload/PROCUREMENT/SERVICE_RECEIPT/'.$attachment->file) ?>" class="btn btn-info btn-sm" target="_blank">Download</a></td>
                                                        </tr>
                                                        <?php $no++ ?>
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
        <?php if ($service_receipt->accept == 0) { ?>
            <a href="<?= base_url('vn/info/service_receipt/accept/'.$service_receipt->id) ?>" class="btn btn-success" onclick="return confirm('Are you sure to accept this service receipt?')">Accept</a>
            <a href="<?= base_url('vn/info/service_receipt/acceptance') ?>" class="btn btn-secondary">Cancel</a>
        <?php } else { ?>
            <a href="<?= base_url('vn/info/service_receipt/accepted') ?>" class="btn btn-secondary">Back</a>
        <?php } ?>
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