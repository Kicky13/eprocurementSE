<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">MSR Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">MSR Dashboard</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
                <div class="card-body steps">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg">
                        <li class="nav-item">
                            <a class="nav-link active" id="msr-status-tab" data-toggle="tab" href="#msr-status" aria-controls="stats" aria-expanded="true">Status</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="msr-type-tab" data-toggle="tab" href="#msr-type" aria-controls="msr-type">Type</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" id="procurement-method-tab" data-toggle="tab" href="#procurement-method" aria-controls="procurement-method">Procurement Method</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="procurement-specialist-tab" data-toggle="tab" href="#procurement-specialist" aria-controls="procurement-specialist">Procurement Specialist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" aria-controls="details">Details</a>
                        </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active" id="msr-status" aria-labelledby="msr-status-tab" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="msr-status-number-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="msr-status-number-trend-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="msr-status-value-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="msr-status-value-trend-chart" class="height-400 echart-container"></div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="msr-type" aria-labelledby="msr-type-tab" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="msr-type-number-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="msr-type-number-trend-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="msr-type-value-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="msr-type-value-trend-chart" class="height-400 echart-container"></div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="procurement-method" aria-labelledby="procurement-method-tab" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="procurement-method-number-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="procurement-method-number-trend-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="procurement-method-value-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="procurement-method-value-trend-chart" class="height-400 echart-container"></div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="procurement-specialist" aria-labelledby="procurement-specialist-tab" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="procurement-specialist-number-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="procurement-specialist-number-trend-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="procurement-specialist-value-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="procurement-specialist-value-trend-chart" class="height-400 echart-container"></div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="details" role="tabpanel" aria-labelledby="details-tab" aria-expanded="false">
                            <div class="form-group" style="padding-left:15px;">
                                <button type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
                            </div>
                            <table id="data-table" class="table table-striped table-condensed table-bordered table-hover display nowrap" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>No MSR</th>
                                        <th>Item MSR</th>
                                        <th>Description of Units</th>
                                        <th>Clasification</th>
                                        <th>Group / Category</th>
                                        <th>Qty</th>
                                        <th class="text-right">Estimate Unit Price</th>
                                        <th class="text-right">Estimate Total Value</th>
                                        <th>Currency</th>
                                        <th>Importation</th>
                                        <th>Cost Center</th>
                                        <th>Account Subsidiary</th>
                                        <th>Company</th>
                                        <th>Department</th>
                                        <th>MSR Status</th>
                                        <th>MSR Type</th>
                                        <th>Title</th>
                                        <th>MSR Date</th>
                                        <th>Required Date</th>
                                        <th>Procurement Location</th>
                                        <th>Procurement Method</th>
                                        <th>Delivery Point</th>
                                        <th>Request for</th>
                                        <th>Delivery Term</th>
                                        <th>Inspection</th>
                                        <th>Freight</th>
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

    var initiatedMsrStatus = false;
    var msrStatusNumberChart;
    var msrStatusNumberTrendChart
    var msrStatusValueChart;
    var msrStatusValueTrendChart
    var msrStatusGeneralOption = {
        legend : ['Preparation', 'Selection', 'Completed', 'Signed', 'Canceled'],
        color : globalChartOption.color
    };
    var msrStatusNumberChartOption = {};
    var msrStatusValueChartOption = {};
    var msrStatusNumberTrendChartOption = {};
    var msrStatusValueTrendChartOption = {};

    var initiatedMsrType = false;
    var msrTypeNumberChart;
    var msrTypeNumberTrendChart
    var msrTypeValueChart;
    var msrTypeValueTrendChart
    var msrTypeGeneralOption = {
        color : globalChartOption.color
    };
    var msrTypeNumberChartOption = {};
    var msrTypeValueChartOption = {};
    var msrTypeNumberTrendChartOption = {};
    var msrTypeValueTrendChartOption = {};

    var initiatedProcurementMethod = false;
    var procurementMethodNumberChart;
    var procurementMethodNumberTrendChart
    var procurementMethodValueChart;
    var procurementMethodValueTrendChart
    var procurementMethodGeneralOption = {
        color : globalChartOption.color
    };
    var procurementMethodNumberChartOption = {};
    var procurementMethodValueChartOption = {};
    var procurementMethodNumberTrendChartOption = {};
    var procurementMethodValueTrendChartOption = {};

    var initiatedProcurementSpecialist = false;
    var procurementSpecialistNumberChart;
    var procurementSpecialistNumberTrendChart
    var procurementSpecialistValueChart;
    var procurementSpecialistValueTrendChart
    var procurementSpecialistGeneralOption = {
        color : globalChartOption.color
    };
    var procurementSpecialistNumberChartOption = {};
    var procurementSpecialistValueChartOption = {};
    var procurementSpecialistNumberTrendChartOption = {};
    var procurementSpecialistValueTrendChartOption = {};

    var dataTable;

    $(function() {
        $('#btn-process').click(function() {
            $('#dashboard-content').show();
            start($('#dashboard-content'));
            currentFilterContent();
            $.ajax({
                url: '<?= base_url('dashboard/msr/get') ?>',
                type: 'post',
                data: $('[name*="filter"]').serialize(),
                dataType: 'json',
                success: function(response) {
                    getMsrStatus(response.status);
                    getMsrType(response.type);
                    getProcurementMethod(response.method);
                    getProcurementSpecialist(response.specialist);
                    stop($('#dashboard-content'));
                }
            });
            if (typeof(dataTable) == 'undefined') {
                dataTable = $('#data-table').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: '<?= base_url('dashboard/msr/get_details') ?>?'+$('[name*="filter"]').serialize(),
                    columns: [
                        {data: 'msr_no', name: 't_msr.msr_no'},
                        {data: 'material_id', name: 't_msr_item.material_id'},
                        {data: 'material', name: 'm_material.MATERIAL_NAME'},
                        {data: 'clasification', name: 'clasification.DESCRIPTION'},
                        {data: 'category', name: 'category.DESCRIPTION'},
                        {data: 'qty', name: 't_msr_item.qty'},
                        {data: 'priceunit_base', name: 't_msr_item.priceunit_base', render: function(data) {
                            return Localization.number(data);
                        }, class: 'text-right'},
                        {data: 'amount_base', name: 't_msr_item.amount_base', render: function(data) {
                            return Localization.number(data);
                        }, class: 'text-right'},
                        {data: 'currency', name: 'm_currency.CURRENCY'},
                        {data: 'item_importation', name: 't_msr_item.importation_desc'},
                        {data: 'costcenter', name: 't_msr.costcenter_desc'},
                        {data: 'accsub', name: 'm_accsub.accsub'},
                        {data: 'company', name: 'm_company.DESRIPTION'},
                        {data: 'department', name: 'm_departement.DEPARTMENT_DESC'},
                        {data: 'status', name: 't_msr.status'},
                        {data: 'type', name: 'm_msrtype.MSR_DESC'},
                        {data: 'title', name: 't_msr.title'},
                        {data: 'create_on', name: 't_msr.create_on', render: function(data) {
                            return Localization.humanDate(data);
                        }},
                        {data: 'req_date', name: 't_msr.req_date', render: function(data) {
                            return Localization.humanDate(data);
                        }},
                        {data: 'rloc_desc', name: 't_msr.rloc_desc'},
                        {data: 'method', name: 'm_pmethod.PMETHOD_DESC'},
                        {data: 'dpoint_desc', name: 't_msr.dpoint_desc'},
                        {data: 'requestfor_desc', name: 't_msr.requestfor_desc'},
                        {data: 'deliveryterm_desc', name: 't_msr.deliveryterm_desc'},
                        {data: 'inspection_desc', name: 't_msr.inspection_desc'},
                        {data: 'freight_desc', name: 't_msr.freight_desc'}
                    ],
                    scrollX: true,
                    scrollY: '300px',
                    scrollCollapse: true,
                });
            } else {
                dataTable.ajax.url('<?= base_url('dashboard/msr/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
            }
        });

        $('#msr-status-tab').click(function() {
            setTimeout(function() {
                loadMsrStatus();
            }, 200);
        });

        $('#msr-type-tab').click(function() {
            setTimeout(function() {
                loadMsrType();
            }, 200);
        });

        $('#procurement-method-tab').click(function() {
            setTimeout(function() {
                loadProcurementMethod();
            }, 200);
        });

        $('#procurement-specialist-tab').click(function() {
            setTimeout(function() {
                loadProcurementSpecialist();
            }, 200);
        });

        $('#details-tab').click(function() {
            setTimeout(function() {
                dataTable.columns.adjust();
            }, 200);
        });

        require.config({
            paths : {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
        });

        require([
            'echarts',
            'echarts/chart/pie',
            'echarts/chart/bar',
            'echarts/chart/line',
        ], function(ec) {
            echarts = ec;
            $('#btn-process').prop('disabled', false);
            //loadMsrStatus();
            /*dataTable = $('#data-table').DataTable({
                serverSide: true,
                processing: true,
                ajax: '<?= base_url('dashboard/msr/get_details') ?>?'+$('[name*="filter"]').serialize(),
                columns: [
                {data: 'msr_no', name: 't_msr.msr_no'},
                {data: 'material_id', name: 't_msr_item.material_id'},
                {data: 'material', name: 'm_material.MATERIAL_NAME'},
                {data: 'clasification', name: 'clasification.DESCRIPTION'},
                {data: 'category', name: 'category.DESCRIPTION'},
                {data: 'qty', name: 't_msr_item.qty'},
                {data: 'priceunit_base', name: 't_msr_item.priceunit_base', render: function(data) {
                    return Localization.number(data);
                }, class: 'text-right'},
                {data: 'amount_base', name: 't_msr_item.amount_base', render: function(data) {
                    return Localization.number(data);
                }, class: 'text-right'},
                {data: 'currency', name: 'm_currency.CURRENCY'},
                {data: 'item_importation', name: 't_msr_item.importation_desc'},
                {data: 'costcenter', name: 't_msr.costcenter_desc'},
                {data: 'accsub', name: 'm_accsub.accsub'},
                {data: 'company', name: 'm_company.DESRIPTION'},
                {data: 'department', name: 'm_departement.DEPARTMENT_DESC'},
                {data: 'status', name: 't_msr.status'},
                {data: 'type', name: 'm_msrtype.MSR_DESC'},
                {data: 'title', name: 't_msr.title'},
                {data: 'create_on', name: 't_msr.create_on', render: function(data) {
                    return Localization.humanDate(data);
                }},
                {data: 'req_date', name: 't_msr.req_date', render: function(data) {
                    return Localization.humanDate(data);
                }},
                {data: 'rloc_desc', name: 't_msr.rloc_desc'},
                {data: 'method', name: 'm_pmethod.PMETHOD_DESC'},
                {data: 'dpoint_desc', name: 't_msr.dpoint_desc'},
                {data: 'requestfor_desc', name: 't_msr.requestfor_desc'},
                {data: 'deliveryterm_desc', name: 't_msr.deliveryterm_desc'},
                {data: 'inspection_desc', name: 't_msr.inspection_desc'},
                {data: 'freight_desc', name: 't_msr.freight_desc'}
                ],
                scrollX: true,
                scrollY: '300px',
                scrollCollapse: true,
            });*/
        });
    });

    function currentFilterContent() {
        var currentFilterContentHtml = '';
        currentFilterContentHtml += renderCurrentFilterContent('company', 'Company');
        currentFilterContentHtml += renderCurrentFilterContent('department', 'Department');
        currentFilterContentHtml += renderCurrentFilterContent('status', 'Status');
        currentFilterContentHtml += renderCurrentFilterContent('type', 'MSR Type');
        currentFilterContentHtml += renderCurrentFilterContent('method', 'Procurement Method');
        currentFilterContentHtml += renderCurrentFilterContent('specialist', 'Procurement Specialist');
        currentFilterContentHtml += renderCurrentFilterContent('years', 'Years');
        currentFilterContentHtml += renderCurrentFilterContent('months', 'Months');
        if (currentFilterContentHtml == '') {
            currentFilterContentHtml = 'Data not filtered';
        }
        $('#current-filter-content').html(currentFilterContentHtml);
    }

    function initMsrStatus() {
        msrStatusNumberChart = echarts.init(document.getElementById('msr-status-number-chart'));
        msrStatusNumberTrendChart = echarts.init(document.getElementById('msr-status-number-trend-chart'));
        msrStatusValueChart = echarts.init(document.getElementById('msr-status-value-chart'));
        msrStatusValueTrendChart = echarts.init(document.getElementById('msr-status-value-trend-chart'));
        if (!initiatedMsrStatus)  {
            function resize() {
                setTimeout(function() {
                    msrStatusNumberChart.resize();
                    msrStatusNumberTrendChart.resize();
                    msrStatusValueChart.resize();
                    msrStatusValueTrendChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedMsrStatus = true;
        }
    }

    function loadMsrStatus() {
        initMsrStatus();
        msrStatusNumberChart.setOption(msrStatusNumberChartOption);
        msrStatusValueChart.setOption(msrStatusValueChartOption);
        msrStatusNumberTrendChart.setOption(msrStatusNumberTrendChartOption);
        msrStatusValueTrendChart.setOption(msrStatusValueTrendChartOption);
    }

    function getMsrStatus(response) {
        var periode = [];
        $.each(response.periode, function(key, row) {
            periode[key] = Localization.humanDate(row, '{Y} {m}');
        });
        var number = [];
        var value = [];
        $.each(msrStatusGeneralOption.legend, function(key, name) {
            if (response.data.status[name]) {
                number[key] = {value : response.data.status[name].number, name : name};
                value[key] = {value : response.data.status[name].value, name : name};
            } else {
                number[key] = {value : 0, name : name};
                value[key] = {value : 0, name : name};
            }
        });

        console.log(number);

        msrStatusNumberChartOption = {
            title: {
                text: 'MSR STATUS',
                subtext: 'By number of MSR',
                x: 'center'
            },
            // tooltip: {
            //     trigger: 'item',
            //     formatter: "{a} <br/>{b}: {c} ({d}%)"
            // },
            legend: {
                x: 'center', y: 50,
                data: msrStatusGeneralOption.legend
            },
            color: msrStatusGeneralOption.color,
            calculable: true,
            series: [{
                name: 'MSR',
                type: 'pie',
                radius: '60%',
                center: ['50%', '55%'],
                itemStyle: {
        					normal: {
        						label: {
        							formatter: function (params) {
        								return params.value;
        							}
        						},
        					},
        				},
                data: number
            }]
        };

        msrStatusValueChartOption = {
            title: {
                text: 'MSR STATUS',
                subtext: 'By value of MSR',
                x: 'center'
            },
            // tooltip: {
            //     trigger: 'item',
            //     formatter: "{a} <br/>{b}: {c} ({d}%)"
            // },
            legend: {
                x: 'center', y: 50,
                data: msrStatusGeneralOption.legend
            },

            color: msrStatusGeneralOption.color,
            calculable: true,
            series: [{
                name: 'MSR',
                type: 'pie',
                radius: '60%',
                center: ['50%', '55%'],
                itemStyle: {
        					normal: {
        						label: {
        							formatter: function (params) {
        								return params.value;
        							}
        						},
        					},
        				},
                data: value
            }]
        };

        var numberData = [];
        var valueData = [];

        $.each(msrStatusGeneralOption.legend, function(i, name) {
            numberData[i] = {
                name: name,
                type: 'line',
                data: []
            }
            valueData[i] = {
                name: name,
                type: 'line',
                data:[]
            }
            $.each(response.periode, function(j, month) {
                if (response.data.status_trend[name]) {
                    if (response.data.status_trend[name][month]) {
                        numberData[i].data[j] = response.data.status_trend[name][month].number;
                        valueData[i].data[j] = (response.data.status_trend[name][month].value/1000000);
                    } else {
                        numberData[i].data[j] = 0;
                        valueData[i].data[j] = 0;
                    }
                } else {
                    numberData[i].data[j] = 0;
                    valueData[i].data[j] = 0;
                }
            });
        });

        msrStatusNumberTrendChartOption = {
            title: {
                text: 'MSR STATUS - Trend',
                subtext: 'Number of MSR, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 100,y2: 70
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: msrStatusGeneralOption.legend,
                x: 'center',
                y: 50,
            },
            color: msrStatusGeneralOption.color,
            calculable: true,
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: periode
            }],
            yAxis: [{
                type: 'value'
            }],
            series: numberData
        };

        msrStatusValueTrendChartOption = {
            title: {
                text: 'MSR STATUS - Trend',
                subtext: 'Value of MSR, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 100,y2: 70
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: msrStatusGeneralOption.legend,
                x: 'center',
                y: 50,
            },
            color: msrStatusGeneralOption.color,
            calculable: true,
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: periode
            }],
            yAxis: [{
                type: 'value'
            }],
            series: valueData
        };
        loadMsrStatus();
    }

    function initMsrType() {
        msrTypeNumberChart = echarts.init(document.getElementById('msr-type-number-chart'));
        msrTypeNumberTrendChart = echarts.init(document.getElementById('msr-type-number-trend-chart'));
        msrTypeValueChart = echarts.init(document.getElementById('msr-type-value-chart'));
        msrTypeValueTrendChart = echarts.init(document.getElementById('msr-type-value-trend-chart'));
        if (!initiatedMsrType)  {
            function resize() {
                setTimeout(function() {
                    msrTypeNumberChart.resize();
                    msrTypeNumberTrendChart.resize();
                    msrTypeValueChart.resize();
                    msrTypeValueTrendChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedMsrType = true;
        }
    }

    function loadMsrType() {
        initMsrType();
        msrTypeNumberChart.setOption(msrTypeNumberChartOption);
        msrTypeValueChart.setOption(msrTypeValueChartOption);
        msrTypeValueTrendChart.setOption(msrTypeValueTrendChartOption);
        msrTypeNumberTrendChart.setOption(msrTypeNumberTrendChartOption);
    }

    function getMsrType(response) {
        var legend = [];
        $.each(response.msr_type, function(key, row) {
            legend[key] = row.MSR_DESC;
        });
        var periode = [];
        $.each(response.periode, function(key, row) {
            periode[key] = Localization.humanDate(row, '{Y} {m}');
        });
        var number = [];
        var value = [];
        $.each(legend, function(key, name) {
            if (response.data.type[name]) {
                number[key] = {value : response.data.type[name].number, name : name};
                value[key] = {value : response.data.type[name].value, name : name};
            } else {
                number[key] = {value : 0, name : name};
                value[key] = {value : 0, name : name};
            }
        });

        msrTypeNumberChartOption = {
            title: {
                text: 'MSR TYPE',
                subtext: 'By number of MSR',
                x: 'center'
            },
            // tooltip: {
            //     trigger: 'item',
            //     formatter: "{a} <br/>{b}: {c} ({d}%)"
            // },
            legend: {
                x: 'center', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'MSR',
                type: 'pie',
                radius: '60%',
                center: ['50%', '55%'],
                itemStyle: {
        					normal: {
        						label: {
        							formatter: function (params) {
        								return params.value;
        							}
        						},
        					},
        				},
                data: number
            }]
        };

        msrTypeValueChartOption = {
            title: {
                text: 'MSR Type',
                subtext: 'By value of MSR',
                x: 'center'
            },
            // tooltip: {
            //     trigger: 'item',
            //     formatter: "{a} <br/>{b}: {c} ({d}%)"
            // },
            legend: {
                x: 'center', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'MSR',
                type: 'pie',
                radius: '60%',
                center: ['50%', '55%'],
                itemStyle: {
        					normal: {
        						label: {
        							formatter: function (params) {
        								return params.value;
        							}
        						},
        					},
        				},
                data: value
            }]
        };

        var numberData = [];
        var valueData = [];

        $.each(legend, function(i, name) {
            numberData[i] = {
                name: name,
                type: 'line',
                data: []
            }
            valueData[i] = {
                name: name,
                type: 'line',
                data:[]
            }
            $.each(response.periode, function(j, month) {
                if (response.data.type_trend[name]) {
                    if (response.data.type_trend[name][month]) {
                        numberData[i].data[j] = response.data.type_trend[name][month].number;
                        valueData[i].data[j] = (response.data.type_trend[name][month].value/1000000);
                    } else {
                        numberData[i].data[j] = 0;
                        valueData[i].data[j] = 0;
                    }
                } else {
                    numberData[i].data[j] = 0;
                    valueData[i].data[j] = 0;
                }
            });
        });

        msrTypeNumberTrendChartOption = {
            title: {
                text: 'MSR Type - Trend',
                subtext: 'Number of MSR, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 100,y2: 70
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: legend,
                x:'center',
                y:50,
            },
            color: msrTypeGeneralOption.color,
            calculable: true,
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: periode
            }],
            yAxis: [{
                type: 'value'
            }],
            series: numberData
        };

        msrTypeValueTrendChartOption = {
            title: {
                text: 'MSR Type - Trend',
                subtext: 'Value of MSR, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 100,y2: 70
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: legend,
                x:'center',
                y:50,
            },
            color: msrTypeGeneralOption.color,
            calculable: true,
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: periode
            }],
            yAxis: [{
                type: 'value'
            }],
            series: valueData
        };

        loadMsrType();
    }

    function initProcurementMethod() {
        procurementMethodNumberChart = echarts.init(document.getElementById('procurement-method-number-chart'));
        procurementMethodNumberTrendChart = echarts.init(document.getElementById('procurement-method-number-trend-chart'));
        procurementMethodValueChart = echarts.init(document.getElementById('procurement-method-value-chart'));
        procurementMethodValueTrendChart = echarts.init(document.getElementById('procurement-method-value-trend-chart'));
        if (!initiatedProcurementMethod)  {
            function resize() {
                setTimeout(function() {
                    procurementMethodNumberChart.resize();
                    procurementMethodNumberTrendChart.resize();
                    procurementMethodValueChart.resize();
                    procurementMethodValueTrendChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedProcurementMethod = true;
        }
    }

    function loadProcurementMethod() {
        initProcurementMethod();
        procurementMethodNumberChart.setOption(procurementMethodNumberChartOption);
        procurementMethodValueChart.setOption(procurementMethodValueChartOption);
        procurementMethodNumberTrendChart.setOption(procurementMethodNumberTrendChartOption);
        procurementMethodValueTrendChart.setOption(procurementMethodValueTrendChartOption);
    }

    function getProcurementMethod(response) {
        var legend = [];
        $.each(response.procurement_method, function(key, row) {
            legend[key] = row.PMETHOD_DESC;
        });
        var periode = [];
        $.each(response.periode, function(key, row) {
            periode[key] = Localization.humanDate(row, '{Y} {m}');
        });
        var number = [];
        var value = [];
        $.each(legend, function(key, name) {
            if (response.data.method[name]) {
                number[key] = {value : response.data.method[name].number, name : name};
                value[key] = {value : response.data.method[name].value, name : name};
            } else {
                number[key] = {value : 0, name : name};
                value[key] = {value : 0, name : name};
            }
        });

        procurementMethodNumberChartOption = {
            title: {
                text: 'MSR PROCUREMENT METHOD',
                subtext: 'By number of MSR',
                x: 'center'
            },
            // tooltip: {
            //     trigger: 'item',
            //     formatter: "{a} <br/>{b}: {c} ({d}%)"
            // },
            legend: {
                x: 'center', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'MSR',
                type: 'pie',
                radius: '60%',
                center: ['50%', '55%'],
                itemStyle: {
        					normal: {
        						label: {
        							formatter: function (params) {
        								return params.value;
        							}
        						},
        					},
        				},
                data: number
            }]
        };

        procurementMethodValueChartOption = {
            title: {
                text: 'MSR PROCUREMENT METHOD',
                subtext: 'By value of MSR',
                x: 'center'
            },
            // tooltip: {
            //     trigger: 'item',
            //     formatter: "{a} <br/>{b}: {c} ({d}%)"
            // },
            legend: {
                x: 'center', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'MSR',
                type: 'pie',
                radius: '60%',
                center: ['50%', '55%'],
                itemStyle: {
        					normal: {
        						label: {
        							formatter: function (params) {
        								return params.value;
        							}
        						},
        					},
        				},
                data: value
            }]
        };

        var numberData = [];
        var valueData = [];

        $.each(legend, function(i, name) {
            numberData[i] = {
                name: name,
                type: 'line',
                data: []
            }
            valueData[i] = {
                name: name,
                type: 'line',
                data:[]
            }
            $.each(response.periode, function(j, month) {
                if (response.data.method_trend[name]) {
                    if (response.data.method_trend[name][month]) {
                        numberData[i].data[j] = response.data.method_trend[name][month].number;
                        valueData[i].data[j] = (response.data.method_trend[name][month].value/1000000);
                    } else {
                        numberData[i].data[j] = 0;
                        valueData[i].data[j] = 0;
                    }
                } else {
                    numberData[i].data[j] = 0;
                    valueData[i].data[j] = 0;
                }
            });
        });

        procurementMethodNumberTrendChartOption = {
            title: {
                text: 'MSR PROCUREMENT METHOD - Trend',
                subtext: 'Number of MSR, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 100,y2: 70
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: legend,
                x:'center',
                y:50,
            },
            color: msrTypeGeneralOption.color,
            calculable: true,
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: periode
            }],
            yAxis: [{
                type: 'value'
            }],
            series: numberData
        };

        procurementMethodValueTrendChartOption = {
            title: {
                text: 'MSR PROCUREMENT METHOD - Trend',
                subtext: 'Value of MSR, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 100,y2: 70
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: legend,
                x:'center',
                y:50,
            },
            color: msrTypeGeneralOption.color,
            calculable: true,
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: periode
            }],
            yAxis: [{
                type: 'value'
            }],
            series: valueData
        };
        loadProcurementMethod();
    }

    function initProcurementSpecialist() {
        procurementSpecialistNumberChart = echarts.init(document.getElementById('procurement-specialist-number-chart'));
        procurementSpecialistNumberTrendChart = echarts.init(document.getElementById('procurement-specialist-number-trend-chart'));
        procurementSpecialistValueChart = echarts.init(document.getElementById('procurement-specialist-value-chart'));
        procurementSpecialistValueTrendChart = echarts.init(document.getElementById('procurement-specialist-value-trend-chart'));
        if (!initiatedProcurementSpecialist)  {
            function resize() {
                setTimeout(function() {
                    procurementSpecialistNumberChart.resize();
                    procurementSpecialistNumberTrendChart.resize();
                    procurementSpecialistValueChart.resize();
                    procurementSpecialistValueTrendChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedProcurementSpecialist = true;
        }
    }

    function loadProcurementSpecialist() {
        initProcurementSpecialist();
        procurementSpecialistNumberChart.setOption(procurementSpecialistNumberChartOption);
        procurementSpecialistValueChart.setOption(procurementSpecialistValueChartOption);
        procurementSpecialistNumberTrendChart.setOption(procurementSpecialistNumberTrendChartOption);
        procurementSpecialistValueTrendChart.setOption(procurementSpecialistValueTrendChartOption);
    }

    function getProcurementSpecialist(response) {
        var legend = [];
        $.each(response.procurement_specialist, function(key, row) {
            legend[key] = row.NAME;
        });
        var periode = [];
        $.each(response.periode, function(key, row) {
            periode[key] = Localization.humanDate(row, '{Y} {m}');
        });
        var number = [];
        var value = [];
        $.each(legend, function(key, name) {
            if (response.data.specialist[name]) {
                number[key] = {value : response.data.specialist[name].number, name : name};
                value[key] = {value : response.data.specialist[name].value, name : name};
            } else {
                number[key] = {value : 0, name : name};
                value[key] = {value : 0, name : name};
            }
        });

        procurementSpecialistNumberChartOption = {
            title: {
                text: 'MSR PROCUREMENT SPECIALIST',
                subtext: 'By number of MSR',
                x: 'center'
            },
            // tooltip: {
            //     trigger: 'item',
            //     formatter: "{a} <br/>{b}: {c} ({d}%)"
            // },
            legend: {
                orient: 'vertical',
                x: 'left', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'MSR',
                type: 'pie',
                radius: '60%',
                center: ['50%', '55%'],
                itemStyle: {
        					normal: {
        						label: {
        							formatter: function (params) {
        								return params.value;
        							}
        						},
        					},
        				},
                data: number
            }]
        };

        procurementSpecialistValueChartOption = {
            title: {
                text: 'MSR PROCUREMENT SPECIALIST',
                subtext: 'By value of MSR',
                x: 'center'
            },
            // tooltip: {
            //     trigger: 'item',
            //     formatter: "{a} <br/>{b}: {c} ({d}%)"
            // },
            legend: {
                orient: 'vertical',
                x: 'left', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'MSR',
                type: 'pie',
                radius: '60%',
                center: ['50%', '55%'],
                itemStyle: {
        					normal: {
        						label: {
        							formatter: function (params) {
        								return params.value;
        							}
        						},
        					},
        				},
                data: value
            }]
        };

        var numberData = [];
        var valueData = [];

        $.each(legend, function(i, name) {
            numberData[i] = {
                name: name,
                type: 'line',
                data: []
            }
            valueData[i] = {
                name: name,
                type: 'line',
                data:[]
            }
            $.each(response.periode, function(j, month) {
                if (response.data.specialist_trend[name]) {
                    if (response.data.specialist_trend[name][month]) {
                        numberData[i].data[j] = response.data.specialist_trend[name][month].number;
                        valueData[i].data[j] = (response.data.specialist_trend[name][month].value/1000000);
                    } else {
                        numberData[i].data[j] = 0;
                        valueData[i].data[j] = 0;
                    }
                } else {
                    numberData[i].data[j] = 0;
                    valueData[i].data[j] = 0;
                }
            });
        });

        procurementSpecialistNumberTrendChartOption = {
            title: {
                text: 'MSR PROCUREMENT SPECIALIST - Trend',
                subtext: 'Number of MSR, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 80,y2: 70
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                orient: 'vertical',
                data: legend,
                x:40,
                y:50,
            },
            color: msrTypeGeneralOption.color,
            calculable: true,
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: periode
            }],
            yAxis: [{
                type: 'value'
            }],
            series: numberData
        };

        procurementSpecialistValueTrendChartOption = {
            title: {
                text: 'MSR PROCUREMENT SPECIALIST - Trend',
                subtext: 'Value of MSR, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 80,y2: 70
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                orient: 'vertical',
                data: legend,
                x:40,
                y:50,
            },
            color: msrTypeGeneralOption.color,
            calculable: true,
            xAxis: [{
                type: 'category',
                boundaryGap: false,
                data: periode
            }],
            yAxis: [{
                type: 'value'
            }],
            series: valueData
        };

        loadProcurementSpecialist();
    }
</script>
