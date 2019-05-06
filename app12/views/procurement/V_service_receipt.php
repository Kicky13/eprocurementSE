<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Create Service Receipt", "Create Service Receipt") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Create Service Receipt", "Create Service Receipt") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <?php $this->load->view('V_alert') ?>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="text-right" style="margin-bottom: 20px">
                            <a href="<?= base_url('procurement/service_receipt/itp_list') ?>" class="btn btn-success">Create Service Receipt</a>
                        </div>
                        <table id="data-table" class="table table-bordered table-no-wrap" style="min-width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SR Date</th>
                                    <th>SR No</th>
                                    <th>ITP No</th>
                                    <th>Agreement No</th>
                                    <th>ID External</th>
                                    <th>Vendor</th>
                                    <th class="text-right">Total Receipt</th>
                                    <th>Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
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
    var dataTable;
    $(function() {
        $('#data-table thead th').each(function (i) {
            var title = $('#data-table thead th').eq($(this).index()).text();
            if ($(this).is(':first-child') || $(this).is(':last-child')) {
                $('#data-table tfoot tr').append('<th>'+title+'</th>');
            } else {
                $('#data-table tfoot tr').append('<th><input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" /></th>');
            }
        });

        dataTable = $('#data-table').dataTable({
            processing : true,
            ajax : '<?= base_url('procurement/service_receipt') ?>',
            columns : [
                {data : 'id', render : function(data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data : 'receipt_date', name : 't_service_receipt.receipt_date', render : function(data) {
                    return Localization.humanDate(data);
                }},
                {data : 'service_receipt_no', name : 't_service_receipt.service_receipt_no'},
                {data : 'itp_no', name : 't_itp.itp_no'},
                {data : 'no_po', name : 't_itp.no_po'},
                {data : 'id_external', name : 't_service_receipt.id_external'},
                {data : 'vendor', name : 'm_vendor.NAMA'},
                {data : 'subtotal', name : 't_service_receipt.subtotal', render : function(data) {
                    return Localization.number(data);
                }, class : 'text-right'},
                {data : 'approval_status', name:'t_approval_service_receipt.status', render : function(data, type, row) {
                    if (row.cancel == 1) {
                        return 'Canceled';
                    } else {
                        if (data == 1) {
                            return 'Proccess';
                        } else {
                            return 'Reject';
                        }
                    }
                }},
                {data : 'id', render : function(data, type, row) {
                    actionColumn.create('edit', {
                        template : function() {
                            if (row.cancel == 1) {
                                return '<a href="<?= base_url('procurement/service_receipt/edit') ?>/'+row.id_itp+'/'+row.id+'" class="btn btn-warning btn-sm disabled">Edit</a>';
                            } else {
                                if (row.approval_status == 0) {
                                    return '<a href="<?= base_url('procurement/service_receipt/edit') ?>/'+row.id_itp+'/'+row.id+'" class="btn btn-warning btn-sm">Edit</a>';
                                } else {
                                    return '<a href="<?= base_url('procurement/service_receipt/edit') ?>/'+row.id_itp+'/'+row.id+'" class="btn btn-warning btn-sm disabled">Edit</a>';
                                }
                            }
                        }
                    });
                    actionColumn.create('cancel', {
                        template : function() {
                            if (row.cancel == 0) {
                                return '<a href="<?= base_url('procurement/service_receipt/cancel') ?>/'+row.id_itp+'/'+row.id+'" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure to cancel this service receipt?\')">Cancel</a>';
                            } else {
                                return '<a href="<?= base_url('procurement/service_receipt/cancel') ?>/'+row.id_itp+'/'+row.id+'" class="btn btn-danger btn-sm disabled" onclick="return confirm(\'Are you sure to cancel this service receipt?\')">Cancel</a>';
                            }
                        }
                    });
                    return actionColumn.create('view', {
                        template : '<a href="<?= base_url('procurement/service_receipt/view') ?>/'+row.id_itp+'/'+row.id+'" class="btn btn-primary btn-sm">View</a>'
                    }).render('{view} {cancel} {edit}', {url : '<?= base_url('procurement/service_receipt') ?>', key : data});
                }, class : 'text-center', orderable : false, searchable : false}
            ],
            scrollX : true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            }
        });

        $(dataTable.table().container()).on('keyup', 'tfoot input', function () {
            dataTable.column($(this).data('index')).search(this.value).draw();
        });
    });
</script>