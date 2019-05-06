<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Completed Service Receipt", "Completed Service Receipt") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Completed Service Receipt", "Completed Service Receipt") ?></li>
                    </ol>
                </div>
            </div>
        </div>
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
                                    <th>SR Date</th>                          
                                    <th>SR No</th>                                    
                                    <th>ITP No</th>
                                    <th>Agreement No</th>                                    
                                    <th>Vendor</th>
                                    <th class="text-right">Total Receipt</th>                                    
                                    <th></th>                                                                                    
                                </tr>
                            </thead>
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
        dataTable = $('#data-table').dataTable({
            serverSide : true,
            processing : true,
            ajax : '<?= base_url('procurement/service_receipt/completed') ?>',
            columns : [                
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
                    return actionColumn.create('view', {
                        template : '<a href="<?= base_url('procurement/service_receipt/view') ?>/'+row.id_itp+'/'+row.id+'" class="btn btn-primary btn-sm">View</a>'
                    }).render('{view}', {url : '<?= base_url('procurement/service_receipt') ?>', key : data});
                }, class : 'text-right', orderable : false, searchable : false}                          
            ],
            scrollX : true,            
            order : [[1, 'DESC']]
        });
    });
</script>