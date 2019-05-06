<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">SR Acceptance</h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                        <li class="breadcrumb-item">SR Acceptance</li>
                    </ol>
                </div>
            </div>
        </div>
        <?php $this->load->view('V_alert') ?>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive">
                                                <table id="dt" class="table table-condensed table-striped">
                                                    <thead>
                                                        <tr>
                                                            <th>SR Date</th>
                                                            <th>SR No</th>
                                                            <th>ITP No</th>
                                                            <th>Agreement No</th>
                                                            <th class="text-right">Total Receipt</th>
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($rs_service_receipt as $r_service_receipt) { ?>
                                                            <tr>
                                                                <td><?= dateToIndo($r_service_receipt->receipt_date) ?></td>
                                                                <td><?= $r_service_receipt->service_receipt_no ?></td>
                                                                <td><?= $r_service_receipt->itp_no ?></td>
                                                                <td><?= $r_service_receipt->no_po ?></td>
                                                                <td class="text-right"><?= $r_service_receipt->currency ?> <?= numIndo($r_service_receipt->subtotal) ?></td>
                                                                <td class="text-right">
                                                                    <a href="<?=base_url('vn/info/service_receipt/view/'.$r_service_receipt->id) ?>" class="btn btn-primary btn-sm">Accept</a>
                                                                </td>
                                                            </tr>
                                                        <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
