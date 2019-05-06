<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">Amendment Notification</h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                        <li class="breadcrumb-item">Amendment Notification</li>
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
                                                <table id="dt" class="table table-condensed table-striped table-no-wrap">
                                                    <thead>
                                                        <tr>
                                                            <th>Agreement No</th>
                                                            <th>Amendment No</th>
                                                            <th>Subject Work</th>
                                                            <th>Company</th>
                                                            <th>Amendment Notification Date</th>
                                                            <!-- <th class="text-center">Status</th> -->
                                                            <th></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php foreach ($model as $row) { ?>
                                                            <tr>
                                                                <td><?= $row->po_no ?></td>
                                                                <td><?= substr($row->doc_no, -5) ?></td>
                                                                <td><?= $row->title ?></td>
                                                                <td><?= $row->company ?></td>
                                                                <td><?= dateToIndo($row->dated) ?></td>
                                                                <!-- <td class="text-center">
                                                                    <?php if ($row->open) { ?>
                                                                        <span class="badge badge-success">Open</span>
                                                                    <?php } else { ?>
                                                                        <span class="badge badge-danger">Closed</span>
                                                                    <?php } ?>
                                                                </td> -->
                                                                <td class="text-right">
                                                                    
                                                                        <a href="<?= base_url('vn/info/arf_notification/response/'.$row->id) ?>" class="btn btn-primary btn-sm">Response</a>
                                                                    
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
