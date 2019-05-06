<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Negotiation List", "Negotiation List") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Negotiation List", "Negotiation List") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <table id="data-table" class="table table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ED Number</th>
                                    <th>Subject</th>
                                    <th>Company</th>
                                    <th>Department</th>
                                    <th>Requestor</th>
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
    var dataTable
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
            processing: true,
            ajax: '<?= base_url('procurement/negotiated_ed') ?>',
            columns: [
                {data : 'id', name: 't_nego.id', render : function(data, type, row, meta) {
                     return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data: 'bled_no', name: 't_bl.bled_no'},
                {data: 'subject', name: 't_eq_data.subject'},
                {data: 'company', name: 'm_company.DESCRIPTION'},
                {data: 'department', name: 'm_departement.DEPARTMENT_DESC'},
                {data: 'requestor', name: 'm_user.NAMA'},
                {data: 'msr_no', name: 't_nego.msr_no', render: function(data) {
                    return '<a href="<?= base_url('procurement/negotiated_ed/detail') ?>/'+data+'" class="btn btn-primary btn-sm">Detail</a>';
                }, searchable: false, orderable: false, class: 'text-center'}
            ],
            scrollX: true,
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