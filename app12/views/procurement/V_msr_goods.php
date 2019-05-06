<div class="ibox-content" style="zoom: 80%;">
    <div class="row">
        <table id="tbl" class="table table-striped table-bordered table-hover display" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th rowspan="2">No</th>
                    <th rowspan="2"><center><?= lang('Semic NO', 'Material Number') ?></center></th>
            <th rowspan="2"><center><?= lang("Description of Units", "Description") ?></center></th>
            <th rowspan="2"><center>Main Group</center></th>
            <th rowspan="2"><center>Sub Group</center></th>
            <th rowspan="2"><center>QTY</center></th>
            <th rowspan="2"><center>UOM</center></th>
            <th colspan="2"><center>Stock Status</center></th>
            <th rowspan="2"><center>Estimate Unit Price</center></th>
            <th rowspan="2"><center>Estimate Total Amount</center></th>
            <th rowspan="2"><center>CUR</center></th>
            <th rowspan="2"><center>Costcenter</center></th>
            <th rowspan="2"><center>Branch/Plant</center></th>
            <th rowspan="2"><center>Delivery Term</center></th>
            <th rowspan="2"><center>Importation</center></th>
            </tr>
            <tr>                          
                <th><center><?= lang("ON HAND", "UOM") ?></center></th>
            <th><center><?= lang('ON ORDER', 'QTY') ?></center></th>
            </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>10</td>
                    <td>EA</td>
                    <td>2</td>
                    <td>0</td>
                    <td>500.000</td>
                    <td>5.000.000</td>
                    <td>IDR</td>
                    <td></td>
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
            function get()
            {
                var matr = $('#search_matr').val();
                var desc = $('#search_desc').val();
                var long = $('#search_long').val();
                var group = $('#search_group').val();
                var type = $('#search_type').val();
                var uom = $('#search_uom').val();
                var obj = {};

                obj.limit = $('#limit').val();
                if ($('#status1').is(":checked"))
                    obj.status1 = 1;
                else
                    obj.status1 = "none";
                if ($('#status2').is(":checked"))
                    obj.status2 = 0;
                else
                    obj.status2 = "none";
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('material/registration/filter_data'); ?>",
                    data: obj,
                    cache: false,
                    success: function (res)
                    {
                        $('#tbl').DataTable().clear().draw();
                        $('#tbl').DataTable().rows.add(res).draw();
                        var tamp = 0;
                        if (res.length > 0)
                            tamp = 1;
                        $('#info').text("Showing " + tamp + " to " + res.length + " data from " +<?= (isset($total) != false ? $total : '0') ?>)
                    }
                })
            }
            function add() {
                document.getElementById("form").reset();
                lang();
            }

            function update(id) {
            }

            $('#tbl').DataTable({
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
            // select2 ->  
            jQuery(function ($) {

                if ($.isFunction($.fn.select2)) {

                    $("#group_material").select2({
                        placeholder: 'select',
                        required: true,
                        allowClear: true
                    }).on('select2-open', function () {
                        // Adding Custom Scrollbar
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        $('#tbl').DataTable().ajax.reload();
                    });
                    $("#material_type").select2({
                        required: true,
                        placeholder: 'select',
                        allowClear: true
                    }).on('select2-open', function () {
                        // Adding Custom Scrollbar
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        $('#tbl').DataTable().ajax.reload();
                    });
                    $("#material_uom").select2({
                        placeholder: 'select',
                        required: true,
                        allowClear: true
                    }).on('select2-open', function () {
                        // Adding Custom Scrollbar
                        $(this).data('select2').results.addClass('overflow-hidden').perfectScrollbar();
                        $('#tbl').DataTable().ajax.reload();
                    });
                }
            });
        </script>