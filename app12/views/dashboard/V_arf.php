<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">ARF Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">ARF Dashboard</li>
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
                                        <th>Agreement No</th>
                                        <th>ARF No</th>
                                        <th>ARF Item</th>
                                        <th>Description</th>
                                        <th>Qty</th>
                                        <th>UoM</th>
                                        <th>Price</th>
                                        <th>Total Value</th>
                                        <th>Status Document</th>
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
        legend : ['Preparation', 'Completed', 'Signed', 'Canceled'],
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
                url: '<?= base_url('dashboard/arf/get') ?>',
                type: 'post',
                data: $('[name*="filter"]').serialize(),
                dataType: 'json',
                success: function(response) {
                    getMsrStatus(response.status);
                    getMsrType(response.type);
                    getProcurementSpecialist(response.specialist);
                    stop($('#dashboard-content'));
                    if (typeof(dataTable) == 'undefined') {
                        dataTable = $('#data-table').DataTable({
                            serverSide: true,
                            processing: true,
                            ajax: '<?= base_url('dashboard/arf/get_details') ?>?'+$('[name*="filter"]').serialize(),
                            columns: [
                                {data: 'po_no', name: 'po_no'},
                                {data: 'doc_no', name: 'doc_no'},
                                {data: 'material_desc', name: 'material_desc'},
                                {data: 'po_title', name: 'po_title'},
                                {data: 'qty', name: 'qty'},
                                {data: 'uom', name: 'uom'},
                                {data: 'unit_price_base', name: 'unit_price_base', render: function(data) {
                                    return Localization.number(data);
                                }, class: 'text-right'},
                                {data: 'total_price_base', name: 'total_price_base', render: function(data) {
                                    return Localization.number(data);
                                }, class: 'text-right'},
                                {data: 'status', name: 'status'},
                            ],
                            scrollX: true,
                            scrollY: '300px',
                            scrollCollapse: true,
                        });
                    } else {
                        dataTable.ajax.url('<?= base_url('dashboard/arf/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
                    }
                }
            });

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
        });
    });

    function currentFilterContent() {
        var currentFilterContentHtml = '';
        currentFilterContentHtml += renderCurrentFilterContent('company', 'Company');
        currentFilterContentHtml += renderCurrentFilterContent('department', 'Department');
        currentFilterContentHtml += renderCurrentFilterContent('status', 'Status');
        currentFilterContentHtml += renderCurrentFilterContent('type', 'ARF Type');
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

        msrStatusNumberChartOption = {
            title: {
                text: 'ARF STATUS',
                subtext: 'By number of ARF',
                x: 'center'
            },
            legend: {
                x: 'center', y: 50,
                data: msrStatusGeneralOption.legend
            },
            color: msrStatusGeneralOption.color,
            calculable: true,
            series: [{
                name: 'ARF',
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
                        labelLine: {
                            show: true
                        }
                    },
                },
                data: number
            }]
        };

        msrStatusValueChartOption = {
            title: {
                text: 'ARF STATUS',
                subtext: 'By value of ARF',
                x: 'center'
            },
            legend: {
                x: 'center', y: 50,
                data: msrStatusGeneralOption.legend
            },

            color: msrStatusGeneralOption.color,
            calculable: true,
            series: [{
                name: 'ARF',
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
                        labelLine: {
                            show: true
                        }
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
                text: 'ARF STATUS - Trend',
                subtext: 'Number of ARF, Monthly',
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
                text: 'ARF STATUS - Trend',
                subtext: 'Value of ARF, Monthly',
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
        var legend = ['Goods', 'Services'];
        // $.each(response.data, function(key, row) {
        //     legend[key] = row.MSR_DESC;
        // });
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
                text: 'ARF TYPE',
                subtext: 'By number of ARF',
                x: 'center'
            },
            legend: {
                x: 'center', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'ARF',
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
                        labelLine: {
                            show: true
                        }
                    },
                },
                data: number
            }]
        };

        msrTypeValueChartOption = {
            title: {
                text: 'ARF Type',
                subtext: 'By value of ARF',
                x: 'center'
            },
            legend: {
                x: 'center', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'ARF',
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
                        labelLine: {
                            show: true
                        }
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
                text: 'ARF Type - Trend',
                subtext: 'Number of ARF, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 100,y2: 70
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
                text: 'ARF Type - Trend',
                subtext: 'Value of ARF, Monthly',
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
                text: 'ARF PROCUREMENT SPECIALIST',
                subtext: 'By number of ARF',
                x: 'center'
            },
            legend: {
                orient: 'vertical',
                x: 'left', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'ARF',
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
                        labelLine: {
                            show: true
                        }
                    },
                },
                data: number
            }]
        };

        procurementSpecialistValueChartOption = {
            title: {
                text: 'ARF PROCUREMENT SPECIALIST',
                subtext: 'By value of ARF',
                x: 'center'
            },
            legend: {
                orient: 'vertical',
                x: 'left', y: 50,
                data: legend
            },

            color: msrTypeGeneralOption.color,
            calculable: true,
            series: [{
                name: 'ARF',
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
                        labelLine: {
                            show: true
                        }
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
                text: 'ARF PROCUREMENT SPECIALIST - Trend',
                subtext: 'Number of ARF, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 80,y2: 70
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
                text: 'ARF PROCUREMENT SPECIALIST - Trend',
                subtext: 'Value of ARF, Monthly',
                x: 'center',
            },
            grid: {
                x: 60,x2: 20,
                y: 80,y2: 70
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
