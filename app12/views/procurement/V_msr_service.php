<div class="ibox-content" style="zoom: 80%;">
    <div class="row">
        <table id="tbl2" class="table table-striped table-bordered table-hover display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th><center><?= lang("Item Services", "Description") ?></center></th>
            <th><center>Serviced Category</center></th>
            <th><center>Category</center></th>
            <th><center>SUB Category</center></th>
            <th><center>QTY</center></th>
            <th><center>UOM</center></th>
            <th><center>Estimate Unit Price</center></th>
            <th><center>Estimate Total Amount</center></th>
            <th><center>CUR</center></th>
            <th><center>Costcenter</center></th>
            <th><center>Branch/Plant</center></th>
            <th><center>GL Account</center></th>
            </tr>

            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Fluid Service</td>
                    <td>A-1</td>
                    <td>General</td>
                    <td>Buildings</td>
                    <td>1</td>
                    <td>PKT</td>
                    <td>250.000.000</td>
                    <td>250.000.000</td>
                    <td>IDR</td>
                    <td></td>
                    <td></td>
                    <td>8161-0100IT Hardware Purchase</td>
                </tr>
            </tbody>
        </table> 
        <label class="form-group" style="font-weight:500" id="info">Showing <?= (isset($total) != false ? ($total >= 1 ? "1" : 0) : '0') ?> to <?= (isset($total) != false ? ($total > 100 ? "100" : $total) : '0') ?> data from <?= (isset($total) != false ? $total : '0') ?> data</label>      
    </div>
</div>
<script>
    $('#tbl2').DataTable({
        scrollX: true,
        scrollY: '300px',
        info: false,
        searching: false,
        scrollCollapse: true,
        paging: false,
        info: false,
                "columnDefs": [
                    {"className": "dt-right", "targets": [0]},
//            {"className": "dt-right", "targets": [3]},
                    {"className": "dt-center", "targets": [4]}
                ]
    });
    lang();
</script>