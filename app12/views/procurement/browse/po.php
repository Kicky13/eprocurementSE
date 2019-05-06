<table id="browse-table" class="table table-bordered table-striped table-no-wrap table-row-action" style="font-size: 12px; width: 100%;">
    <thead>
        <tr>
            <th></th>
            <th>Agreement No</th>
            <th>Date</th>
            <th>Company</th>
            <th>Supplier</th>
            <th>Currency</th>
            <th>Value</th>
        </tr>
    </thead>
</table>

<script>
    $(function() {
        setTimeout(function() {
            $('#browse-table').dataTable({
                processing : true,
                serverSide : true,
                ajax : '<?= base_url('procurement/browse/po?issued='.$this->input->get('issued').'&creator='.$this->input->get('creator').'&datatable=1') ?>',
                columns : [
                    {data : 'po_no', render : function(data, type, row) {
                        return '<button type="button" data-action="select-po" class="btn btn-success btn-sm"><i class="fa fa-check"></i></button>';
                    }, orderable : false, searchable : false},
                    {data : 'po_no'},
                    {data : 'po_date'},
                    {data : 'company', name : 'm_company.DESCRIPTION'},
                    {data : 'vendor', name : 'm_vendor.NAMA'},
                    {data : 'currency', name : 'currency.CURRENCY', class : 'text-center'},
                    {data : 'total_amount', name: 't_purchase_order.total_amount', render : function(data) {
                        return Localization.number(data);
                    }, class : 'text-right'}
                ],
                select : {
                    style : 'single'
                },
                rowCallback : function(row, data) {
                    $('[data-action="select-po"]', row).click(function() {
                        if (typeof browse_po_selected == 'function') {
                            browse_po_selected(data);
                        }
                        $('#browse-modal').modal('hide');
                    });
                    $(row).dblclick(function() {
                        if (typeof browse_po_selected == 'function') {
                            browse_po_selected(data);
                        }
                        $('#browse-modal').modal('hide');
                    });
                },
                scrollX : true,
                order: [[1, 'DESC']]
            });
        }, 500);
    });
</script>