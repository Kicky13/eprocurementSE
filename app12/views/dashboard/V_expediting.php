<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Expediting Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Expediting Dashboard</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
                <div class="card-body">
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel " class="tab-pane active" id="stats" aria-labelledby="stats-tab1" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="delivery-status-chart" class="height-200 echart-container" style="min-width:450px;"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="delivery-status-trend-chart" class="height-300 echart-container"></div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <table id="data-table" class="table table-striped table-bordered table-hover table-no-wrap display text-center" style="font-size: 12px">
                                        <thead>
                                            <tr>
                                                <th>Supplier</th>
                                                <th>No. PO</th>
                                                <th>PO Date</th>
                                                <th>Title</th>
                                                <th>Department</th>
                                                <th>Procurement Specialist</th>
                                                <th>Delivery Point</th>
                                                <th>Promised Delivery Date</th>
                                                <th>Actual Delivery Date</th>
                                                <th>Days Late</th>
                                                <th>Status</th>
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
    </div>
</div>
<?php $this->load->view('dashboard/partials/filter_script') ?>
<script>
    var echarts;

    var inititatedExpediting = false;
    var deliveryStatusChart;
    var deliveryStatusTrendChart;
    var deliveryStatusGeneralOption = {
        legend : ['On Time', 'Late', 'Delayed'],
        color : globalChartOption.color
    };

    var dataTable;

    $(function() {
        $('#btn-process').click(function() {
            $('#dashboard-content').show();
            start($('#dashboard-content'));
            loadExpediting();
            dataTable.ajax.url('<?= base_url('dashboard/expediting/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
        });

        require.config({
            paths: {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
        });

        require(
            [
                'echarts',
                'echarts/chart/bar',
                'echarts/chart/line'
            ],
            function (ec) {
                echarts = ec;
                $('#btn-process').prop('disabled', false);
            }
        );

        dataTable = $('#data-table').DataTable({
            serverSide: true,
            processing: true,
            ajax: '<?= base_url('dashboard/expediting/get_details') ?>?'+$('[name*="filter"]').serialize(),
            paging: false,
            columns: [
                {data : 'vendor'},
                {data : 'po_no'},
                {data : 'po_date', render : function(data) {
                    return Localization.humanDate(data);
                }},
                {data : 'title'},
                {data : 'department'},
                {data : 'specialist'},
                {data : 'dpoint'},
                {data : 'delivery_date', render : function(data) {
                    return Localization.humanDate(data);
                }},
                {data : 'expediting_date', render : function(data) {
                    return Localization.humanDate(data);
                }},
                {data : 'days_late'},
                {data : 'status'}
            ],
            searching: false,
            scrollX: true,
            scrollY: '400px',
            scrollCollapse: true,
            info: false
        });
    });

    function initExpediting() {
        deliveryStatusChart = echarts.init(document.getElementById('delivery-status-chart'));
        deliveryStatusTrendChart = echarts.init(document.getElementById('delivery-status-trend-chart'));
        if (!inititatedExpediting) {
            function resize() {
                setTimeout(function() {
                    deliveryStatusChart.resize();
                    trendDevliveryChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            inititatedExpediting = true;
        }
    }

    function loadExpediting() {
        $.ajax({
            url: '<?= base_url('dashboard/expediting/get_expediting') ?>',
            type: 'post',
            data: $('[name*="filter"]').serialize(),
            dataType: 'json',
            success: function(response) {
                initExpediting();
                var periode = [];
                $.each(response.periode, function(key, row) {
                    periode[key] = Localization.humanDate(row, '{Y} {m}');
                });
                var deliveryStatusData = {
                    'Delayed' : 0,
                    'On Time' : 0,
                    'Late' : 0
                }
                $.each(response.data.expediting, function(i, expediting) {
                    deliveryStatusData[expediting.status] = expediting.count;
                });

                deliveryStatusChartOption = {
                    title: {
                        text: 'Delivert Status',
                        x: 'center',
                    },
                    grid: {
                        x: 30, y: 60,
                    },
                    tooltip : {
                        trigger: 'axis',
                        axisPointer : {            // Axis indicator axis trigger effective
                            type : 'shadow'        // The default is a straight line, optionally: 'line' | 'shadow'
                        }
                    },
                    legend: {
                        data: deliveryStatusGeneralOption.legend,
                        y: 40
                    },
                    color: deliveryStatusGeneralOption.color,
                    xAxis: [{
                        type: 'value',
                    }],
                    yAxis: [{
                        type: 'category',
                        data: [' ']
                    }],
                    series : [
                        {
                            name:'On Time',
                            type:'bar',
                            stack: 'Total',
                            itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                            data:[deliveryStatusData['On Time']]
                        },
                        {
                            name:'Late',
                            type:'bar',
                            stack: 'Total',
                            itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                            data:[deliveryStatusData['Late']]
                        },
                        {
                            name:'Delayed',
                            type:'bar',
                            stack: 'Total',
                            itemStyle : { normal: {label : {show: true, position: 'insideRight'}}},
                            data:[deliveryStatusData['Delayed']]
                        },
                    ]
                };
                deliveryStatusChart.setOption(deliveryStatusChartOption);
                var deliveryStatusTrendData = [];
                $.each(deliveryStatusGeneralOption.legend, function(i, status) {
                    deliveryStatusTrendData[i] = {
                        name: status,
                        type: 'line',
                        data: []
                    }
                    $.each(response.periode, function(j, month) {
                        if (response.data.expediting_trend[status]) {
                            if (response.data.expediting_trend[status][month]) {
                                deliveryStatusTrendData[i].data[j] = response.data.expediting_trend[status][month].count;
                            } else {
                                deliveryStatusTrendData[i].data[j] = 0;
                            }
                        } else {
                            deliveryStatusTrendData[i].data[j] = 0;
                        }
                    });
                });

                var deliveryStatusTrendChartOption = {
                    title: {
                        text: 'Trend Delibery',
                        x: 'center'
                    },
                    tooltip : {
                        trigger: 'axis'
                    },
                    xAxis: [
                        {
                            type: 'category',
                            boundaryGap: false,
                            data: periode
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value'
                        }
                    ],
                    grid: {
                        x: 65, x2: 40,
                        y: 75
                    },
                    color: deliveryStatusGeneralOption.color,
                    legend : {
                        data: deliveryStatusGeneralOption.legend,
                        x: 'center',
                        y: 55
                    },
                    series: deliveryStatusTrendData
                }
                deliveryStatusTrendChart.setOption(deliveryStatusTrendChartOption);
                stop($('#dashboard-content'));
            }
        });
    }
</script>