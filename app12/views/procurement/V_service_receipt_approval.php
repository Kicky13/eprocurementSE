<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Aprroval Service Receipt", "Aprroval Service Receipt") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Aprroval Service Receipt", "Aprroval Service Receipt") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <table id="data-table" class="table table-bordered table-no-wrap" style="min-width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>SR Date</th>
                                    <th>SR No</th>
                                    <th>ITP No</th>
                                    <th>Agreement No</th>
                                    <th>Vendor</th>
                                    <th class="text-right">Total Receipt</th>
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
            ajax : '<?= base_url('procurement/service_receipt/approval') ?>',
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
                {data : 'vendor', name : 'm_vendor.NAME'},
                {data : 'subtotal', name : 't_service_receipt.subtotal', render : function(data) {
                    return Localization.number(data);
                }, class : 'text-right'},
                {data : 'id', render : function(data, type, row) {
                    return actionColumn.create('approval', {
                        template : '<a href="<?= base_url('procurement/service_receipt/view') ?>/'+row.id_itp+'/'+data+'" class="btn btn-primary btn-sm">Approval</a>'
                    }).render('{approval}', {url : '<?= base_url('procurement/service_receipt') ?>', key : data});
                }, orderable : false, searchable : false, class : 'text-center'}
            ],
            scrollX : true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            },
            order : [[1, 'DESC']]
        });

        $(dataTable.api().table().container()).on('keyup', 'tfoot input', function () {
            dataTable.api().column($(this).data('index')).search(this.value).draw();
        });
    });
</script>