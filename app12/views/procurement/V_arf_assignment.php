<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("ARF Assignment", "ARF Assignment") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("ARF Assignment", "ARF Assignment") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <table id="data-table" class="table table-bordered table-no-wrap">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Requested Date</th>
                                    <th>Agreement No</th>
                                    <th>Amendment No</th>
                                    <!-- <th>Agreement Type</th> -->
                                    <th>Subject</th>
                                    <th>Requested By</th>
                                    <th>Department</th>
                                    <th>Company</th>
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
                $('#data-table tfoot tr').append('<th></th>');
            } else {
                $('#data-table tfoot tr').append('<th><input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" /></th>');
            }
        });

        dataTable = $('#data-table').dataTable({
            processing : true,
            ajax : '<?= base_url('procurement/arf/assignment') ?>',
            columns : [
                {data : 'id', render : function(data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data : 'doc_date', render : function(data) {
                    return Localization.humanDatetime(data);
                }},
                {data : 'po_no', name : 't_arf.po_no'},
                {data : 'doc_no', name : 't_arf.doc_no'},
                /*{data : 'po_type', name : 't_purchase_order.po_type'},*/
                {data : 'title', name : 't_purchase_order.title'},
                {data : 'requestor', name : 'm_user.NAME'},
                {data : 'department', name : 'm_departement.DEPARTMENT_DESC'},
                {data : 'abbr', name : 'm_company.ABBREVIATION'},
                {data : 'id', name : 't_arf.id', render : function(data, type, row) {
                    return actionColumn.create('assignment', {
                        template : '<a href="<?= base_url('procurement/arf/view') ?>/'+data+'" class="btn btn-success btn-sm">GO</a>'
                    }).render('{assignment}', {url : '<?= base_url('procurement/arf') ?>', key : data});
                }, class : 'text-right', searchable : false, orderable : false}
            ],
            order : [[1, 'DESC']],
            scrollX : true,
            fixedColumns: {
                leftColumns: 0,
                rightColumns: 1
            }
        });

        $(dataTable.api().table().container()).on('keyup', 'tfoot input', function () {
            dataTable.api().column($(this).data('index')).search(this.value).draw();
        });
    });
</script>