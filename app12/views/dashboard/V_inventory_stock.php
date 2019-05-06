<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Inventory Stock Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Inventory Stock Dashboard<li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
                <div class="card-body steps">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg ">
                        <li class="nav-item">
                            <a class="nav-link active" id="inventory_stock-tab" data-toggle="tab" href="#inventory_stock" aria-controls="inventory_stock" aria-expanded="true">Inventory Stock</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" aria-controls="details">Details</a>
                        </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel " class="tab-pane active" id="inventory_stock" aria-labelledby="inventory_stock-tab" aria-expanded="false">
                            <div class="row">
                                <?php foreach ($rs_company as $r_company) { ?>
                                    <div class="col-md-4">
                                        <div id="stock-moving-chart-<?= $r_company->ID_COMPANY ?>" class="height-300 echart-container"></div>
                                        <table id="stock-moving-table-<?= $r_company->ID_COMPANY ?>" class="table table-bordered table-sm" style="font-size: 12px;">
                                            <thead>
                                                <tr>
                                                    <th>Movement</th>
                                                    <th class="text-center">Value</th>
                                                    <th class="text-center">Transaction</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                        <div id="stock-moving-trend-chart-<?= $r_company->ID_COMPANY ?>" class="height-300 echart-container"></div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="tab-pane" id="details" role="tabpanel" aria-labelledby="details-tab1" aria-expanded="false">
                            <table id="data-table" class="table table-striped table-bordered table-hover table-no-wrap text-center" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="line-height: 50px">MESC Code</th>
                                        <th rowspan="2" style="line-height: 50px">Description</th>
                                        <th rowspan="2" style="line-height: 50px">Stock On Hand</th>
                                        <th rowspan="2" style="line-height: 50px">UOM</th>
                                        <th rowspan="2" style="line-height: 50px">Unit Price</th>
                                        <th rowspan="2" style="line-height: 50px">Inventory Value</th>
                                        <th rowspan="2" style="line-height: 50px">Location</th>
                                        <th colspan=2>Received</th>
                                        <th colspan=2>Issued</th>
                                        <th colspan=2>Return</th>
                                    </tr>
                                    <tr>
                                        <th>Qty</th>
                                        <th>UOM</th>
                                        <th>Qty</th>
                                        <th>UOM</th>
                                        <th>Qty</th>
                                        <th>UOM</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('dashboard/partials/filter_script') ?>
<script>
var echarts;

var initiatedInventoryStock = false;
var stockMovingCharts = {};
var stockMovingTrendCharts = {};
var detailsTable;
var movement_types = [];

var dataTables
$(function() {

    $('#btn-process').click(function() {
        $('#dashboard-content').show();
        start($('#dashboard-content'));
        loadInventoryStock();
        dataTable.ajax.url('<?= base_url('dashboard/inventory_stock/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
    });

    $('#inventory_stock-tab').click(function() {
        setTimeout(function() {
            loadInventoryStock();
        }, 200);
    });

    $('#details-tab').click(function() {
        setTimeout(function() {
            dataTable.columns.adjust();
        }, 200);
    });


    require.config({
        paths: {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
    });

    require([
        'echarts',
        'echarts/chart/pie',
        'echarts/chart/line'
    ], function(ec) {
        echarts = ec;
        $('#btn-process').prop('disabled', false);
    });

    dataTable = $('#data-table').DataTable({
        processing: true,
        ajax: '<?= base_url('dashboard/inventory_stock/get_details') ?>?'+$('[name*="filter"]').serialize(),
        columns : [
            {data : 'SEMIC_NO', name : 'moving_stock.SEMIC_NO'},
            {data : 'MATERIAL_NAME', name : 'm_material.MATERIAL_NAME'},
            {data : 'QTY', name : 'QTY'},
            {data : 'UOM', name : 'm_material.UOM1'},
            {data : 'UNIT_PRICE', name : 'UNIT_PRICE', searchable : false},
            {data : 'TOTAL', name : 'TOTAL', searchable : false},
            {data : 'BPLANT_DESC', name : 'm_bplant.BPLANT_DESC'},
            {data : 'RECEIPT_QTY', name : 'RECEIPT_QTY', searchable : false},
            {data : 'UOM', name : 'm_material.UOM1'},
            {data : 'ISSUED_QTY', name : 'ISSUED_QTY', searchable : false},
            {data : 'UOM', name : 'm_material.UOM1'},
            {data : 'RETURN_QTY', name : 'RETURN_QTY', searchable : false},
            {data : 'UOM', name : 'm_material.UOM1'},
        ],
        scrollX: true,
        scrollY: '300px',
        scrollCollapse: true
    });
});

function initInventoryStock() {

}

function loadInventoryStock() {
    start($('#dashboard-content'));
    $.ajax({
        url : '<?= base_url('dashboard/inventory_stock/get_stock_moving') ?>',
        type : 'post',
        data : $('[name*="filter"]').serialize(),
        dataType : 'json',
        success : function(response) {
            if (!initiatedInventoryStock) {
                function resize() {
                    setTimeout(function() {
                        $.each(stockMovingCharts, function(idCompany, stockMovingChart) {
                            stockMovingChart.resize();
                        });
                        $.each(stockMovingTrendCharts, function(idCompany, stockMovingTrendChart) {
                            stockMovingTrendChart.resize();
                        });
                    }, 200);
                }
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);
                initiatedInventoryStock = true;
            }
            movement_types = [];
            $.each(response.data.movement_types, function(i, movement_type) {
                movement_types.push(movement_type.description);
            });
            var periode = [];
            $.each(response.periode, function(key, row) {
                periode[key] = Localization.humanDate(row, '{Y} {m}');
            });
            var companies = response.data.companies;
            var stockMoving = response.data.stock_moving;
            var stockMovingChartOptions = {};
            var stockMovingChartTotals = {};
            var stockMovingChartValues = {};
            var stockMovingTrendChartOptions = {};
            var stockMovingTrendChartValues = {};
            $.each(companies, function(i, company) {
                stockMovingCharts[company.ID_COMPANY] = echarts.init(document.getElementById('stock-moving-chart-'+company.ID_COMPANY));
                stockMovingTrendCharts[company.ID_COMPANY] = echarts.init(document.getElementById('stock-moving-trend-chart-'+company.ID_COMPANY));
                stockMovingChartTotals[company.ID_COMPANY] = 0;
                stockMovingChartValues[company.ID_COMPANY] = new Array();
                stockMovingTrendChartValues[company.ID_COMPANY] = new Array();
                var stockMovingTableHtml = '';
                $.each(movement_types, function(i, movement_type) {
                    if (response.data.stock_moving[company.ID_COMPANY]) {
                        if (response.data.stock_moving[company.ID_COMPANY][movement_type]) {
                            stockMovingChartValues[company.ID_COMPANY][i] = {value : response.data.stock_moving[company.ID_COMPANY][movement_type].TOTAL, transaction : response.data.stock_moving[company.ID_COMPANY][movement_type].TRANSACTION, name : movement_type};
                        } else {
                            stockMovingChartValues[company.ID_COMPANY][i] = {value : 0, transaction : 0, name : movement_type};
                        }
                    } else {
                        stockMovingChartValues[company.ID_COMPANY][i] = {value : 0, transaction : 0, name : movement_type};
                    }
                    stockMovingChartTotals[company.ID_COMPANY] += toFloat(stockMovingChartValues[company.ID_COMPANY][i].value);
                    stockMovingTableHtml += '<tr>';
                        stockMovingTableHtml += '<td><span style="background-color:'+globalChartOption.color[i]+'">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span> '+movement_type+'</td>';
                        stockMovingTableHtml += '<td class="text-center">'+stockMovingChartValues[company.ID_COMPANY][i].value+'</td>';
                        stockMovingTableHtml += '<td class="text-center">'+stockMovingChartValues[company.ID_COMPANY][i].transaction+'</td>';
                    stockMovingTableHtml += '</tr>';
                    stockMovingTrendChartValues[company.ID_COMPANY][i] = {
                        name : movement_type,
                        type : 'line',
                        data : []
                    };
                    $.each(response.periode, function(j, month) {
                        if (response.data.stock_moving_trend[company.ID_COMPANY]) {
                            if (response.data.stock_moving_trend[company.ID_COMPANY][movement_type]){
                                if (response.data.stock_moving_trend[company.ID_COMPANY][movement_type][month]){
                                    stockMovingTrendChartValues[company.ID_COMPANY][i].data[j] = response.data.stock_moving_trend[company.ID_COMPANY][movement_type][month].TOTAL;
                                } else {
                                    stockMovingTrendChartValues[company.ID_COMPANY][i].data[j] = 0;
                                }
                            } else {
                                stockMovingTrendChartValues[company.ID_COMPANY][i].data[j] = 0;
                            }
                        } else {
                            stockMovingTrendChartValues[company.ID_COMPANY][i].data[j] = 0;
                        }
                    });
                });
                $('#stock-moving-table-'+company.ID_COMPANY+' tbody').html(stockMovingTableHtml);

                stockMovingChartOptions[company.ID_COMPANY] = {
                    title: {
                        text: company.DESCRIPTION,
                        x: 'center'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b}: {c} ({d}%)"
                    },
                    legend: {
                        data: movement_types,
                        show : false
                    },
                    color: globalChartOption.color,
                    calculable: true,
                    series: [
                        {
                            name: 'STOCK MOVING',
                            type: 'pie',
                            radius: '65%',
                            center: ['60%', '50%'],
                            itemStyle : {
                                normal: {
                                    label : {
                                        formatter: function (params) {
                                            var decimal = params.value/stockMovingChartTotals[company.ID_COMPANY]*100;
                                            var percentage = decimal.toFixed(2)+'%';
                                            return percentage;
                                        }
                                    },
                                    labelLine: {
                                        show : false
                                    }
                                }
                            },
                            data: stockMovingChartValues[company.ID_COMPANY]
                        }
                    ]
                };
                stockMovingCharts[company.ID_COMPANY].setOption(stockMovingChartOptions[company.ID_COMPANY]);

                stockMovingTrendChartOptions[company.ID_COMPANY] = {
                    grid: {
                        x: 60,x2: 20
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: movement_types,
                        show : false
                    },
                    color: globalChartOption.color,
                    calculable: true,
                    xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                        data: periode
                    }],
                    yAxis: [{
                        type: 'value'
                    }],
                    series : stockMovingTrendChartValues[company.ID_COMPANY]
                };
                stockMovingTrendCharts[company.ID_COMPANY].setOption(stockMovingTrendChartOptions[company.ID_COMPANY]);
            });
            stop($('#dashboard-content'));
        }
    });
}

</script>