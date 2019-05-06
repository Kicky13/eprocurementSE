<?php $this->load->view('report/partials/filter_script') ?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= $title ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Laporan", "Report") ?></li>
                        <li class="breadcrumb-item active"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <?php $this->load->view('report/partials/filter') ?>
                        <table id="data-table" class="table table-bordered" style="width:100%; font-size: 14px;">
                            <thead>
                                <tr>                                        
                                    <th rowspan="2" style="line-height: 50px">Index</th>
                                    <th rowspan="2" style="line-height: 50px">Comodity Type</th>
                                    <th rowspan="2" style="line-height: 50px">Number Of Procurement Process</th>                                    
                                    <th class="text-center" colspan="2">Agreement Value</th>                                    
                                    <th rowspan="2" style="line-height: 50px">% Local Content</th>
                                </tr>
                                <tr>
                                    <th class="text-center">USD</th>
                                    <th class="text-center">%</th>
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
        $('#btn-filter').click(function() {
            dataTable.ajax.url('?'+$('[name*="filter"]').serialize()).load();
        });

        dataTable = $('#data-table').DataTable({                
            lengthMenu : [
                [10, 50, 100, -1],
                [10, 50, 100, 'Show all']
            ],
            processing : true,
            ajax : '?'+$('[name*="filter"]').serialize(),
            columns : [
                {data : 'msr_no', render : function(data, type, row, meta) {
                    return meta.row + meta.settings._iDisplayStart + 1;
                }},
                {data : 'method'},
                {data : 'number', class : 'text-center', searchable : false},
                {data : 'value', render : function(data) {
                    return Localization.number(data);
                }, class : 'text-center'},
                {data : 'value', render : function(data, type, row) {
                    if (row.total_agreement == 0) {
                        return (0).toFixed(2);
                    } else {
                        return ((data / row.total_agreement) * 100).toFixed(2);
                    }
                }, class : 'text-center'},
                {data : 'local_value', render : function(data, type, row) {
                    if (row.value == 0) {
                        return (0).toFixed(2);
                    } else {
                        return ((data / row.value) * 100).toFixed(2);
                    }
                }, class : 'text-center'}
            ],                        
            dom: 'Bfrtip',
            buttons: [   
                'pageLength',
                {
                    extend: 'excel',
                    text: 'Excel',     
                    title : '<?= $title ?>',
                    filename: '<?= strtolower(str_replace(' ', '-', $title)) ?>',
                    customize: function (xlsx) {                    
                        var sheet = xlsx.xl.worksheets['sheet1.xml'];
                        var downrows = 5;
                        var clRow = $('row', sheet);                    
                        clRow.each(function () {
                            var attr = $(this).attr('r');
                            var ind = parseInt(attr);
                            ind = ind + downrows;
                            $(this).attr("r",ind);
                        });                    
                        $('row c ', sheet).each(function () {
                            var attr = $(this).attr('r');
                            var pre = attr.substring(0, 1);
                            var ind = parseInt(attr.substring(1, attr.length));
                            ind = ind + downrows;
                            $(this).attr("r", pre + ind);
                        });
                        function Addrow(index,data) {
                            msg='<row r="'+index+'">'
                            for(i=0;i<data.length;i++){
                                var key=data[i].k;
                                var value=data[i].v;
                                msg += '<c t="inlineStr" r="' + key + index + '" s="0">';
                                msg += '<is>';
                                msg +=  '<t>'+value+'</t>';
                                msg+=  '</is>';
                                msg+='</c>';
                            }
                            msg += '</row>';
                            return msg;
                        }        
                        var filter_company = 'All Company';    
                        if ($('#filter-company').val() != '') {
                            filter_company = [];
                            $.each($('#filter-company option:selected'), function(i, elem) {
                                filter_company[i] = $(elem).text();
                            });
                            filter_company = filter_company.join(', ')
                        }         
                        var r1 = Addrow(1, [{ k: 'A', v: '<?= $title ?>' }, { k: 'B', v: '' }, { k: 'C', v: '' }]);
                        var r2 = Addrow(2, [{ k: 'A', v: '' }, { k: 'B', v: 'Company' }, { k: 'C', v: filter_company }, ]);
                        var r3 = Addrow(3, [{ k: 'A', v: '' }, { k: 'B', v: 'Begin Date' },{ k: 'C', v: $("#filter-begin_date").val()}]);
                        var r4 = Addrow(4, [{ k: 'A', v: '' }, { k: 'B', v: 'End Date' },{ k: 'C', v: $("#filter-end_date").val()}]);
                        var r5 = Addrow(5, [{ k: 'A', v: '' }, { k: 'B', v: 'Creation Date' },{ k: 'C', v:  Localization.humanDatetime(new Date()) }]);
                        var r6 = Addrow(6, [{ k: 'A', v: '' }, { k: 'B', v: '' },{ k: 'C', v: '' }]);
                        var r7 = Addrow(7, [{ k: 'A', v: '' }, { k: 'B', v: '' },{ k: 'C', v: '' }]);
                        sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2+ r3+ r4 + r5 + r6 + r7 + sheet.childNodes[0].childNodes[1].innerHTML;
                    },
                },                
                {
                    text: 'PDF',
                    extend: 'pdfHtml5',
                    title : '<?= $title ?>',
                    filename: '<?= strtolower(str_replace(' ', '-', $title)) ?>',
                    customize: function (doc) {
                        doc.pageMargins = [20,60,20,30];
                        var rowCount = doc.content[1].table.body.length;
                        for (i = 1; i < rowCount; i++) {
                            doc.content[1].table.body[i][2].alignment = 'center';
                            doc.content[1].table.body[i][3].alignment = 'center';
                            doc.content[1].table.body[i][4].alignment = 'center';
                        };
                        doc['header']=(function(page) {
                            var filter_company = 'All Company';
                            var filter_begin_date = $('#filter-begin_date').val();
                            var filter_end_date = $('#filter-end_date').val();
                            if ($('#filter-company').val() != '') {
                                filter_company = [];
                                $.each($('#filter-company option:selected'), function(i, elem) {
                                    filter_company[i] = $(elem).text();
                                });
                                filter_company = filter_company.join(', ')
                            }                                
                            headerText = [];
                            headerText.push('Company : '+filter_company);
                            if (filter_begin_date != '') {
                                headerText.push('Begin Date : '+filter_begin_date);
                            }
                            if (filter_end_date != '') {
                                headerText.push('End Date : '+filter_end_date);
                            }  
                            headerText.push('Creation Date : '+ Localization.humanDatetime(new Date()));                          
                            if (page == 1) {
                                return {
                                    columns : [
                                        {
                                            alignment: 'left',                                            
                                            text: headerText.join("\n"),
                                            margin: [20, 20]
                                        }
                                    ]                                    
                                }
                            }
                        });
                    }                    
                }
            ]
        });
    });
</script>