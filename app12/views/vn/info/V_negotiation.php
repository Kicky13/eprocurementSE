<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">Negotiation</h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                        <li class="breadcrumb-item">Negotiation</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <table id="data-table" class="table table-bordered table-striped table-no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ED Number</th>
                                    <th>Subject</th>
                                    <th>Company</th>
                                    <th>Company Letter No</th>
                                    <th>Closing Date</th>
                                    <th>Requested At</th>
                                    <th>Responsed At</th>
                                    <th class="text-center">Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1 ?>
                                <?php foreach ($this->vendor_lib->get_negotiation() as $negotiation) { ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><?= $negotiation->bled_no ?></td>
                                        <td><?= $negotiation->subject ?></td>
                                        <td><?= $negotiation->company ?></td>
                                        <td><?= $negotiation->company_letter_no ?></td>
                                        <td><?= dateToIndo($negotiation->closing_date, false, true) ?></td>
                                        <td><?= dateToIndo($negotiation->created_at, false, true) ?></td>
                                        <td><?= dateToIndo($negotiation->responsed_at, false, true) ?></td>
                                        <td class="text-center">
                                            <?php
                                                if ($negotiation->status == 1) {
                                                    echo 'Submited';
                                                } elseif ($negotiation->closed == 1) {
                                                    echo 'Closed';
                                                } else {
                                                    echo 'Open';
                                                }
                                            ?>
                                        </td>
                                        <td class="text-right">
                                            <?php if ($negotiation->status == 1 || $negotiation->closed == 1) { ?>
                                                <a href="<?= base_url('vn/info/greetings/negotiation_response/'.$negotiation->id) ?>" class="btn btn-info btn-sm">View</a>
                                            <?php } else { ?>
                                                <a href="<?= base_url('vn/info/greetings/negotiation_response/'.$negotiation->id) ?>" class="btn btn-primary btn-sm">Response</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                    <?php $no++ ?>
                                <?php } ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#data-table thead th').each(function (i) {
            var title = $('#data-table thead th').eq($(this).index()).text();
            if ($(this).is(':first-child') || $(this).is(':last-child')) {
                $('#data-table tfoot tr').append('<th>'+title+'</th>');
            } else {
                $('#data-table tfoot tr').append('<th><input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" /></th>');
            }
        });

        var table = $('#data-table').DataTable({
            scrollX: true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            }
        })

        $(table.table().container()).on('keyup', 'tfoot input', function () {
            table.column($(this).data('index')).search(this.value).draw();
        });
    });
</script>