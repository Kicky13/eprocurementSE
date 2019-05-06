<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Agreement Spending Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Agreement Spending Dashboard</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8 col-md-12 row">
                            <div class="col-md-5">
                                <div id="agreement-spending-chart" class="height-350 echart-container"></div>
                            </div>
                            <div class="col-md-7">
                                <table class="table" width="100%" style="margin-top: 80px; font-size: 12px;">
                                    <thead>
                                        <tr>
                                            <th>Spending Status</th>
                                            <th class="text-center">Amount</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr class="text-primary">
                                            <td>Total Value</td>
                                            <td class="text-center"><span data-model="total">0</span></td>
                                        </tr>
                                        <tr class="text-danger">
                                            <td>Spend Value</td>
                                            <td class="text-center"><span data-model="spending">0</span></td>
                                        </tr>
                                        <tr class="text-success">
                                            <td>Remain Value</td>
                                            <td class="text-center"><span data-model="remaining">0</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-lg-4 col-md-12">
                            <div id="remaining-value-trend-chart" class="height-300 echart-container"></div>
                        </div>
                        <div class="col-lg-12 col-md-12">
                            <div class="text-right" style="margin: 0px 15px;">
                                <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-file-excel-o"></i></button>
                                <button type="button" class="btn btn-success btn-sm"><i class="fa fa-print"></i></button>
                            </div>
                            <table id="data-table" class="table table-striped table-bordered table-hover table-no-wrap display text-center" width="100%" style="font-size: 12px;">
                                <thead>
                                    <tr>
                                        <th rowspan="2" style="line-height: 50px">Contract No</th>
                                        <th rowspan="2" style="line-height: 50px">Supplier</th>
                                        <th rowspan="2" style="line-height: 50px">Company</th>
                                        <th rowspan="2" style="line-height: 50px">Department</th>
                                        <th rowspan="2" style="line-height: 50px">Validity Start</th>
                                        <th rowspan="2" style="line-height: 50px">Validity End</th>
                                        <th rowspan="2" style="line-height: 50px">Contract Value</th>
                                        <th colspan="3">Spending Value</th>
                                        <th rowspan="2" style="line-height: 50px">Remaining Value</th>
                                    </tr>
                                    <tr>
                                        <th>Committed</th>
                                        <th>Payable</th>
                                        <th>Paid</th>
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

    var initiatedAgreementSpending = false  ;
    var agreementSpendingChart;
    var remainingValueTrendChart;
    var agreementSpendingGeneralOption = {
        color : globalChartOption.color
    };
    var dataTable;

    $(function() {
        $('#btn-process').click(function() {
            $('#dashboard-content').show();
            currentFilterContent();
            loadAgreementSpending();
            dataTable.ajax.url('<?= base_url('dashboard/agreement_spending/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
        });

        require.config({
            paths: {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
        });

        require(
            [
                'echarts',
                'echarts/chart/pie',
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
            ajax: '<?= base_url('dashboard/agreement_spending/get_details') ?>?'+$('[name*="filter"]').serialize(),
            columns: [
                {data : 'po_no'},
                {data : 'vendor'},
                {data : 'company'},
                {data : 'department'},
                {data : 'po_date', render : function(data) {
                    return Localization.humanDate(data);
                }},
                {data : 'po_date', render : function(data) {
                    return Localization.humanDate(data);
                }},
                {data : 'total', render : function(data) {
                    return Localization.number(data);
                }},
                {data : 'spending', render : function(data) {
                    return Localization.number(data);
                }},
                {data : 'payable', render : function(data) {
                    return Localization.number(data);
                }},
                {data : 'paid', render : function(data) {
                    return Localization.number(data);
                }},
                {data : 'remaining', render : function(data) {
                    return Localization.number(data);
                }},
            ],
            paging: false,
            searching: false,
            info : false,
            scrollX: true,
            scrollY: '300px',
            scrollCollapse: true,
        });
    });

    function currentFilterContent() {
        var currentFilterContentHtml = '';
        currentFilterContentHtml += renderCurrentFilterContent('company', 'Company');
        currentFilterContentHtml += renderCurrentFilterContent('department', 'Department');
        currentFilterContentHtml += renderCurrentFilterContent('status', 'Agreement Status');
        currentFilterContentHtml += renderCurrentFilterContent('type', 'Agreement Type');
        currentFilterContentHtml += renderCurrentFilterContent('method', 'Procurement Method');
        currentFilterContentHtml += renderCurrentFilterContent('specialist', 'Procurement Specialist');
        currentFilterContentHtml += renderCurrentFilterContent('years', 'Years');
        currentFilterContentHtml += renderCurrentFilterContent('months', 'Months');
        if (currentFilterContentHtml == '') {
            currentFilterContentHtml = 'Data not filtered';
        }
        $('#current-filter-content').html(currentFilterContentHtml);
    }

    function initAgreementSpending() {
        agreementSpendingChart = echarts.init(document.getElementById('agreement-spending-chart'));
        remainingValueTrendChart = echarts.init(document.getElementById('remaining-value-trend-chart'));
        if (!initiatedAgreementSpending) {
            function resize() {
                setTimeout(function() {
                    agreementSpendingChart.resize();
                    remainingValueTrendChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedAgreementSpending = true;
        }
    }

    function loadAgreementSpending() {
        start($('#dashboard-content'));
        $.ajax({
            url: '<?= base_url('dashboard/agreement_spending/get_spending') ?>',
            type: 'post',
            data: $('[name*="filter"]').serialize(),
            dataType: 'json',
            success: function(response) {
                initAgreementSpending();
                var periode = [];
                $.each(response.periode, function(key, row) {
                    periode[key] = Localization.humanDate(row, '{Y} {m}');
                });
                $('[data-model="total"]').html(Localization.number(response.data.spending.total));
                $('[data-model="spending"]').html(Localization.number(response.data.spending.spending));
                $('[data-model="remaining"]').html(Localization.number(response.data.spending.remaining));

                var agreementSpendingChartOption = {
                    title: {
                        text: 'Agreement Spending',
                        x: 'center'
                    },
                    tooltip: {
                        trigger: 'item',
                        formatter: "{a} <br/>{b}: {c} ({d}%)"
                    },
                    color: agreementSpendingGeneralOption.color,
                    legend : {
                        data: ['Committed', 'Remaining'],
                        x: 'center',
                        y: 55
                    },
                    series: [{
                        name: 'Agreement Spending',
                        type: 'pie',
                        radius: '50%',
                        center: ['50%', '40%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return ((params.value/response.data.spending.total)*100).toFixed(2) + '%';
                                    }
                                },
                                labelLine: {
                                    show: true
                                }
                            },
                        },
                        data: [
                            {value: response.data.spending.spending, name: 'Committed'},
                            {value: response.data.spending.remaining, name: 'Remaining'},
                        ]
                    }]
                }
                agreementSpendingChart.setOption(agreementSpendingChartOption);

                var remainingValue = [];
                $.each(response.periode, function(i, month) {
                    if (response.data.spending_trend[month]) {
                        remainingValue[i] = response.data.spending_trend[month].remaining;
                    } else {
                        remainingValue[i] = 0;
                    }
                });

                var remainingValueTrendChartOption = {
                    title: {
                        text: 'Trend Remaining Value',
                        subtext : 'in Million',
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
                            type: 'value',
                            axisLabel : {
                                formatter: function(value) {
                                    return (value/1000000).toFixed(2);
                                }
                            }
                        }
                    ],
                    grid: {
                        x: 80, x2: 10,
                        y: 75
                    },
                    color: agreementSpendingGeneralOption.color,
                    legend : {
                        data: ['Remaining'],
                        x: 'center',
                        y: 55
                    },
                    series: [
                        {
                            name: 'Remaining',
                            type: 'line',
                            data: remainingValue,
                        }
                    ]
                }
                remainingValueTrendChart.setOption(remainingValueTrendChartOption);
                stop($('#dashboard-content'));
            }
        });
    }
</script>