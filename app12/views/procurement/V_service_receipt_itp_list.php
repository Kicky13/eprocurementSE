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
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="text-right" style="margin-bottom: 20px">
                            <a href="<?= base_url('procurement/service_receipt') ?>" class="btn btn-primary">Service Receipt List</a>
                        </div>
                        <table id="data-table" class="table table-bordered table-no-wrap" style="min-width:100%">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ITP Date</th>
                                    <th>ITP No</th>
                                    <th>Agreement No</th>
                                    <th>Vendor</th>
                                    <th>Created By</th>
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
    var table;
    $(function() {
        $('#data-table thead th').each(function (i) {
            var title = $('#data-table thead th').eq($(this).index()).text();
            if ($(this).is(':first-child') || $(this).is(':last-child')) {
                $('#data-table tfoot tr').append('<th>'+title+'</th>');
            } else {
                $('#data-table tfoot tr').append('<th><input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" /></th>');
            }
        });

        table = $('#data-table').dataTable({
            processing : true,
            ajax : '<?= base_url('procurement/service_receipt/itp_list') ?>',
            columns : [
                {data : 'id_itp', render : function(data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data : 'dated', name : 't_itp.dated', render : function(data) {
                    return Localization.humanDate(data);
                }},
                {data : 'itp_no', name : 't_itp.itp_no'},
                {data : 'no_po', name : 't_itp.no_po'},
                {data : 'vendor', name : 'm_vendor.NAMA'},
                {data : 'creator', name : 'm_user.NAME'},
                {data : 'id_itp', name : 't_itp.id_itp', render : function(data) {
                    return actionColumn.create('process', {
                        template : '<a href="<?= base_url('procurement/service_receipt/create') ?>/'+data+'" class="btn btn-success btn-sm">Process</a>'
                    }).render('{process}', {url : '<?= base_url('procurement/service_receipt') ?>', key : data});
                }, orderable : false, searchable : false, class : 'text-center'}
            ],
            scrollX : true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            }
        });

        $(table.api().table().container()).on('keyup', 'tfoot input', function () {
            table.api().column($(this).data('index')).search(this.value).draw();
        });
    });
</script>