<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Procurement Saving Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Procurement Saving Dashboard</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
                <div class="card">
                    <div class="card-body steps">
                        <ul class="nav nav-tabs nav-top-border no-hover-bg ">
                            <li class="nav-item">
                                <a class="nav-link active" id="comparisons-tab" data-toggle="tab" href="#comparisons" aria-controls="stats" aria-expanded="true">Comparisons</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" aria-controls="details">Details</a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div role="tabpanel " class="tab-pane active" id="comparisons" aria-labelledby="comparisons-tab" aria-expanded="false">
                                <div class="row">
                                    <div class="col-lg-7 col-md-12 row">
                                        <div class="col-md-5">
                                            <div id="agreement-compared-to-msr-chart" class="height-350 echart-container" style="min-width:500px;"></div>
                                        </div>
                                        <div class="col-md-7">
                                            <table id="agreement-msr-procurement-saving-table" class="tabledisp" width="100%" style="margin-top: 80px">
                                                <thead style="border-bottom: 1px solid #efefef;padding-bottom:7px;">
                                                    <tr>
                                                        <th>Saving Value</th>
                                                        <th class="text-right">
                                                            <span data-model="currency"></span>
                                                            <span data-model="saving_value"></span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size: 12px;">
                                                    <tr>
                                                        <td valign="top">Number of Agreement</td>
                                                        <td class="text-right"><span data-model="agreement_number"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top">Total value of MSR</td>
                                                        <td class="text-right">
                                                            <span data-model="currency"></span>
                                                            <span data-model="msr_value"></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top">Total value of Agreement</td>
                                                        <td class="text-right">
                                                            <span data-model="currency"></span>
                                                            <span data-model="agreement_value"></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <div id="agreement-compared-to-msr-trend-chart" class="height-350 echart-container"></div>
                                    </div>
                                    <div class="col-lg-7 col-md-12 row">
                                        <div class="col-md-5">
                                            <div id="agreement-compared-to-proposal-chart" class="height-350 echart-container" style="min-width:500px;"></div>
                                        </div>
                                        <div class="col-md-7">
                                            <table id="agreement-proposal-procurement-saving-table" class="tabledisp" width="100%" style="margin-top: 80px">
                                                <thead style="border-bottom: 1px solid #efefef;padding-bottom:7px;">
                                                    <tr>
                                                        <th>Saving Value</th>
                                                        <th class="text-right">
                                                            <span data-model="currency"></span>
                                                            <span data-model="saving_value"></span>
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody style="font-size: 12px;">
                                                    <tr>
                                                        <td valign="top">Number of Agreement</td>
                                                        <td class="text-right"><span data-model="agreement_number"></span></td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top">Total value of Proposal</td>
                                                        <td class="text-right">
                                                            <span data-model="currency"></span>
                                                            <span data-model="proposal_value"></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td valign="top">Total value of Agreement</td>
                                                        <td class="text-right">
                                                            <span data-model="currency"></span>
                                                            <span data-model="agreement_value"></span>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="col-lg-5 col-md-12">
                                        <div id="agreement-compared-to-proposal-trend-chart" class="height-350 echart-container"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="details" role="tabpanel" aria-labelledby="details-tab" aria-expanded="false">
                                <div class="form-group" style="padding-left:15px;">
                                    <button type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
                                </div>
                                <table id="details-table" class="table table-striped table-bordered nowrap text-center" style="font-size: 12px min-width: 100%">
                                    <thead>
                                        <tr>
                                            <th>Agreement No</th>
                                            <th>Agreement Value</th>
                                            <th>Quotation Value</th>
                                            <th>MSR Value</th>
                                            <th>Saving EE to Agreement</th>
                                            <th>Saving Quotation to Agreement</th>
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
<?php $this->load->view('dashboard/partials/filter_script') ?>
<script>
    var echarts;

    var initiatedComparisons = false;
    var agreementComparedToMsrChart;
    var agreementComparedToMsrTrendChart;
    var agreementComparedToProposalChart;
    var agreementComparedToProposalTrendChart;
    var comparisonsData = {};
    var detailsTable;

    $(function() {
        $('#btn-process').click(function() {
            currentFilterContent();
            $('#dashboard-content').show();
            getComparisons();
            if (typeof(detailsTable) == 'undefined') {
                detailsTable = $('#details-table').DataTable({
                    serverSide: true,
                    processing: true,
                    ajax: '<?= base_url('dashboard/procurement_saving/get_details') ?>?'+$('[name*="filter"]').serialize(),
                    columns: [
                        {data:'po_no'},
                        {data:'agreement_value', render: function(data) {
                            return Localization.number(data);
                        }, class: 'text-right'},
                        {data:'quotation_value', render: function(data) {
                            return Localization.number(data);
                        }, class: 'text-right'},
                        {data:'msr_value', render: function(data) {
                            return Localization.number(data);
                        }, class: 'text-right'},
                        {data:'saving_msr_value', render: function(data) {
                            return Localization.number(data);
                        }, class: 'text-right'},
                        {data:'saving_quotation_value', render: function(data) {
                            return Localization.number(data);
                        }, class: 'text-right'}
                    ],
                    paging: false,
                    searching: false,
                    scrollX: true,
                    scrollY: '400px',
                    scrollCollapse: true,
                    info: false
                });
            } else {
                detailsTable.ajax.url('<?= base_url('dashboard/procurement_saving/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
            }
        });

        $('#comparisons-tab').click(function() {
            setTimeout(function() {
                loadComparisons();
            }, 200);
        });

        $('#details-tab').click(function() {
            setTimeout(function() {
                detailsTable.columns.adjust();
            }, 200);
        });

        require.config({
            paths: {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
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
        currentFilterContentHtml += renderCurrentFilterContent('method', 'Procurement Method');
        currentFilterContentHtml += renderCurrentFilterContent('specialist', 'Procurement Specialist');
        currentFilterContentHtml += renderCurrentFilterContent('type', 'Agreement Type');
        currentFilterContentHtml += renderCurrentFilterContent('years', 'Years');
        currentFilterContentHtml += renderCurrentFilterContent('months', 'Months');
        if (currentFilterContentHtml == '') {
            currentFilterContentHtml = 'Data not filtered';
        }
        $('#current-filter-content').html(currentFilterContentHtml);
    }

    function initComparisons() {
        agreementComparedToMsrChart = echarts.init(document.getElementById('agreement-compared-to-msr-chart'));
        agreementComparedToMsrTrendChart = echarts.init(document.getElementById('agreement-compared-to-msr-trend-chart'));
        agreementComparedToProposalChart = echarts.init(document.getElementById('agreement-compared-to-proposal-chart'));
        agreementComparedToProposalTrendChart = echarts.init(document.getElementById('agreement-compared-to-proposal-trend-chart'));
        if (!initiatedComparisons) {
            function resize() {
                setTimeout(function() {
                    agreementComparedToMsrChart.resize();
                    agreementComparedToMsrTrendChart.resize();
                    agreementComparedToProposalChart.resize();
                    agreementComparedToProposalTrendChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedComparisons = true;
        }
    }

    function loadComparisons() {
        var response = comparisonsData;
        initComparisons();
        var procurementSaving = response.data.procurement_saving;
        $('#agreement-msr-procurement-saving-table [data-model="currency"]').html(procurementSaving.currency);
        $('#agreement-msr-procurement-saving-table [data-model="agreement_number"]').html(procurementSaving.agreement_number);
        $('#agreement-msr-procurement-saving-table [data-model="msr_value"]').html(Localization.number(procurementSaving.msr_value));
        $('#agreement-msr-procurement-saving-table [data-model="agreement_value"]').html(Localization.number(procurementSaving.agreement_value));
        $('#agreement-msr-procurement-saving-table [data-model="saving_value"]').html(Localization.number(procurementSaving.saving_value));
        var labelTop = {
            normal: {
                color: '#20A464',
                label: {
                    show: false,
                    position: 'center',
                    formatter: '{b}',
                    textStyle: {
                        baseline: 'middle',
                        fontWeight: 300,
                        fontSize: 15
                    }
                },
                labelLine: {
                    show: false
                }
            }
        };
        var labelFormatter = {
            normal: {
                label: {
                    formatter: function (params) {
                        return (100 - params.value).toFixed(2) + '%';
                    }
                }
            }
        };
        var labelBottom = {
            normal: {
                color: '#eee',
                label: {
                    show: true,
                    position: 'center',
                    textStyle: {
                        baseline: 'middle'
                    }
                },
                labelLine: {
                    show: false
                }
            },
        };
        var saving = procurementSaving.saving_value/procurementSaving.msr_value*100;
        var other = 100-saving;
        var agreementComparedToMsrChartOption = {
            title: {
                text: 'Agreement Compared to MSR',
                subtext: 'By Saving Value',
                x: 'left'
            },
            color: ['#20A464', '#20A464'],
            series: [
                {
                    type: 'pie',
                    center: ['15%', '45%'],
                    radius: [60, 75],
                    itemStyle: labelFormatter,
                    data: [
                        {name: 'other', value: parseFloat(other).toFixed(2), itemStyle: labelBottom},
                        {name: 'Saving', value: parseFloat(saving).toFixed(2), itemStyle: labelTop}
                    ]
                },

            ]
        };
        agreementComparedToMsrChart.setOption(agreementComparedToMsrChartOption);
        var periode = [];
        var procurementSavingTrend = response.data.procurement_saving_trend;
        var procurementSavingTrendData = [];
        $.each(response.periode, function(key, row) {
            periode[key] = Localization.humanDate(row, '{Y} {m}');
            if (procurementSavingTrend[row]) {
                procurementSavingTrendData[key] = procurementSavingTrend[row].saving_value/1000000;
            } else {
                procurementSavingTrendData[key] = 0;
            }
        });

        var agreementComparedToMsrTrendChartOption = {
            title: {
                text: 'Agreement Compared to MSR - Trend',
                subtext: 'by Saving Value, Monthly',
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
                    name: 'Value',
                    type: 'value',
                    position: 'left',
                    min:0,
                    max: (procurementSaving.saving_value/1000000).toFixed(2)
                },
                {
                    name: 'Percentage',
                    type: 'value',
                    position: 'right',
                    min:0,
                    max:100,
                    axisLabel: {
                        formatter: '{value} %'
                    }
                }
            ],
            grid: {
                x: 80, x2: 45,
                y: 75
            },
            color: ['#00B5B8'],
            series: [
                {
                    name: 'Saving',
                    type: 'line',
                    data: procurementSavingTrendData
                }
            ]
        }
        agreementComparedToMsrTrendChart.setOption(agreementComparedToMsrTrendChartOption);
        //Agreement to Proposal
        var procurementProposalSaving = response.data.procurement_proposal_saving;
        $('#agreement-proposal-procurement-saving-table [data-model="currency"]').html(procurementProposalSaving.currency);
        $('#agreement-proposal-procurement-saving-table [data-model="agreement_number"]').html(procurementProposalSaving.agreement_number);
        $('#agreement-proposal-procurement-saving-table [data-model="proposal_value"]').html(Localization.number(procurementProposalSaving.proposal_value));
        $('#agreement-proposal-procurement-saving-table [data-model="agreement_value"]').html(Localization.number(procurementProposalSaving.agreement_value));
        $('#agreement-proposal-procurement-saving-table [data-model="saving_value"]').html(Localization.number(procurementProposalSaving.saving_value));

        var labelTop = {
            normal: {
                color: '#20A464',
                label: {
                    show: false,
                    position: 'center',
                    formatter: '{b}',
                    textStyle: {
                        baseline: 'middle',
                        fontWeight: 300,
                        fontSize: 15
                    }
                },
                labelLine: {
                    show: false
                }
            }
        };
        var labelFormatter = {
            normal: {
                label: {
                    formatter: function (params) {
                        return (100 - params.value).toFixed(2) + '%';
                    }
                }
            }
        };
        var labelBottom = {
            normal: {
                color: '#eee',
                label: {
                    show: true,
                    position: 'center',
                    textStyle: {
                        baseline: 'middle'
                    }
                },
                labelLine: {
                    show: false
                }
            },
        };
        var saving = procurementProposalSaving.saving_value/procurementProposalSaving.proposal_value*100;
        var other = 100-saving;
        var agreementComparedToProposalChartOption = {
            title: {
                text: 'Agreement Compared to Proposal',
                subtext: 'By Saving Value',
                x: 'left'
            },
            color: ['#20A464', '#20A464'],
            series: [
                {
                    type: 'pie',
                    center: ['15%', '45%'],
                    radius: [60, 75],
                    itemStyle: labelFormatter,
                    data: [
                        {name: 'other', value: parseFloat(other).toFixed(2), itemStyle: labelBottom},
                        {name: 'Saving', value: parseFloat(saving).toFixed(2), itemStyle: labelTop}
                    ]
                },

            ]
        };
        agreementComparedToProposalChart.setOption(agreementComparedToProposalChartOption);
        var periode = [];
        var procurementProposalSavingTrend = response.data.procurement_proposal_saving_trend;
        var procurementProposalSavingTrendData = [];
        $.each(response.periode, function(key, row) {
            periode[key] = Localization.humanDate(row, '{Y} {m}');
            if (procurementProposalSavingTrend[row]) {
                procurementProposalSavingTrendData[key] = procurementProposalSavingTrend[row].saving_value/1000000;
            } else {
                procurementProposalSavingTrendData[key] = 0;
            }
        });

        var agreementComparedToProposalTrendChartOption = {
            title: {
                text: 'Agreement Compared to Proposal - Trend',
                subtext: 'by Saving Value, Monthly',
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
                    name: 'Value',
                    type: 'value',
                    position: 'left',
                    min:0,
                    max: (procurementProposalSaving.saving_value/1000000).toFixed(2)
                },
                {
                    name: 'Percentage',
                    type: 'value',
                    position: 'right',
                    min:0,
                    max:100,
                    axisLabel: {
                        formatter: '{value} %'
                    }
                }
            ],
            grid: {
                x: 85, x2: 45,
                y: 75
            },
            color: ['#00B5B8'],
            series: [
                {
                    name: 'Saving',
                    type: 'line',
                    data: procurementProposalSavingTrendData
                }
            ]
        }
        agreementComparedToProposalTrendChart.setOption(agreementComparedToProposalTrendChartOption);
    }

    function getComparisons() {
        start($('#dashboard-content'));
        $.ajax({
            url : '<?= base_url('dashboard/procurement_saving/get_agreement_msr_procurement_saving') ?>',
            type : 'post',
            data : $('[name*="filter"]').serialize(),
            dataType : 'json',
            success : function(response) {
                comparisonsData = response;
                loadComparisons();
                stop($('#dashboard-content'));
            }
        });
    }
</script>