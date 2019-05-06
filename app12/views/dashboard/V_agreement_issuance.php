<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Agreement Issuance Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Agreement Issuance Dashboard</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
                <div class="card-body">
                    <ul class="nav nav-tabs nav-top-border no-hover-bg">
                        <li class="nav-item">
                            <a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" aria-controls="general" aria-expanded="true">General</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="agreement-type-tab" data-toggle="tab" href="#agreement-type" aria-controls="type">Type</a>
                        </li>
                        <li class="nav-item ">
                            <a class="nav-link" id="agreement-company-tab" data-toggle="tab" href="#agreement-company" aria-controls="company">Company</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="procurement-method-tab" data-toggle="tab" href="#procurement-method" aria-controls="procurement-method">Procurement Method</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="procurement-specialist-tab" data-toggle="tab" href="#procurement-specialist" aria-controls="procurement-specialist">Procurement Specialist</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="risk-assessment-tab" data-toggle="tab" href="#risk-assessment" aria-controls="risk-assessment">Risk Assessment</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" aria-controls="details">Details</a>
                        </li>
                    </ul>
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel" class="tab-pane active" id="general" aria-labelledby="general-tab" aria-expanded="false">
                            <div class="row" id="vue-row">
                                    <div class="col-md-4" v-for="item of items">
                                        <table class="tabledisp" width="100%" style="margin-bottom: 15px;">
                                            <thead style="border-bottom: 1px solid #efefef;padding-bottom:7px">
                                                <tr style="text-align:center">
                                                    <th colspan=2 style="padding-bottom:5px">
                                                        {{ item.po }}<br><br>
                                                        <span style="color:green">USD {{ (parseFloat(item.total_base) + (parseFloat(item.total)/parseFloat(item.amount_from))) | currency }}</span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody style="font-size: 12px">
                                                <tr>
                                                    <td valign="top">Original (USD)</td>
                                                    <td class="text-right">USD {{ item.total_base | currency }}</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">Original (IDR)</td>
                                                    <td class="text-right">IDR {{ item.total | currency }}</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top">Exchange Rate</td>
                                                    <td class="text-right">1 USD = {{ item.amount_from | currency }} IDR</td>
                                                </tr>
                                                <tr>
                                                    <td valign="top"    >Number of Contract</td>
                                                    <td class="text-right">{{ item.countusd }} (USD), {{ item.countidr }} (IDR)</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                            </div>
                            <div class="col-md-12" style="padding-top:10px; border-top:1px solid #f1f1f1">
                                <div style="width: 18%; margin: 0px 1%; float: left;">
                                    <div id="status-chart" class="height-250 echart-container"></div>
                                </div>
                                <div style="width: 18%; margin: 0px 1%; float: left;">
                                    <div id="agreement-type-chart" class="height-250 echart-container"></div>
                                </div>
                                <div style="width: 18%; margin: 0px 1%; float: left;">
                                    <div id="company-chart" class="height-250 echart-container"></div>
                                </div>
                                <div style="width: 18%; margin: 0px 1%; float: left;">
                                    <div id="procurement-method-chart" class="height-250 echart-container"></div>
                                </div>
                                <div style="width: 18%; margin: 0px 1%; float: left;">
                                    <div id="risk-assessment-chart" class="height-250 echart-container"></div>
                                </div>
                            </div>
                            <div class="col-md-12 row" style="padding-top:10px; border-top:1px solid #f1f1f1; font-size: 12px;">
                                <div class="col-md-4">
                                    <h4 class="title-dashboard">Top Proc. Specialist</h4>
                                    <table id="top-procurement-specialist-table" class="table table-bordered table-sm table-striped" style="width: 100%; margin: 0px -15px;">
                                        <thead>
                                            <tr>
                                                <th>Proc. Specialist</th>
                                                <th>Value (USD)</th>
                                                <th>#Agreement</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <h4>Top Departments</h4>
                                    <table id="top-departments-table" class="table table-bordered table-sm table-striped" style="width: 100%; margin: 0px -15px;">
                                        <thead>
                                            <tr>
                                                <th>Department</th>
                                                <th>Value (USD)</th>
                                                <th>#Agreement</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                                <div class="col-md-4">
                                    <h4>Top Suppliers</h4>
                                    <table id="top-suppliers-table" class="table table-bordered table-sm table-striped" style="width: 100%; margin: 0px -15px;">
                                        <thead>
                                            <tr>
                                                <th>Supplier</th>
                                                <th>Value (USD)</th>
                                                <th>#Agreement</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="agreement-type" aria-labelledby="type-tab" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="agreement-type-number-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="agreement-type-number-trend-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="agreement-type-value-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="agreement-type-value-trend-chart" class="height-400 echart-container"></div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="agreement-company" aria-labelledby="type-tab" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="agreement-company-number-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="agreement-company-number-trend-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="agreement-company-value-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="agreement-company-value-trend-chart" class="height-400 echart-container"></div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="procurement-method" aria-labelledby="type-tab" aria-expanded="false">
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
                        <div role="tabpanel" class="tab-pane" id="procurement-specialist" aria-labelledby="type-tab" aria-expanded="false">
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
                        <div role="tabpanel" class="tab-pane" id="risk-assessment" aria-labelledby="type-tab" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="risk-assessment-number-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="risk-assessment-number-trend-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="risk-assessment-value-chart" class="height-400 echart-container"></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                    <div id="risk-assessment-value-trend-chart" class="height-400 echart-container"></div>
                                </div>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="details" aria-labelledby="details-tab" aria-expanded="false">
                            <table id="details-table" class="table table-striped table-bordered table-hover  table-no-wrap display text-center" width="100%" style="font-size: 12px">
                                <thead>
                                    <tr>
                                        <th>Agreement No</th>
                                        <th>Type</th>
                                        <th>Value</th>
                                        <th>Currency</th>
                                        <th>Supplier</th>
                                        <th>Promise Date</th>
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
    var echarts

    var initiatedGeneral = false;
    var statusChart;
    var agreementTypeChart;
    var companyChart;
    var procurementMethodChart;
    var riskAssessmentChart;

    var initiatedAgreementType = false;
    var agreementTypeNumberChart;
    var agreementTypeNumberTrendChart;
    var agreementTypeValueChart;
    var agreementTypeValueTrendChart;

    var initiatedAgreementCompany = false;
    var agreementCompanyNumberChart;
    var agreementCompanyNumberTrendChart;
    var agreementCompanyValueChart;
    var agreementCompanyValueTrendChart;

    var initiatedProcurementMethod = false;
    var procurementMethodNumberChart;
    var procurementMethodNumberTrendChart;
    var procurementMethodValueChart;
    var procurementMethodValueTrendChart;

    var initiatedProcurementSpecialist = false;
    var procurementSpecialistNumberChart;
    var procurementSpecialistNumberTrendChart;
    var procurementSpecialistValueChart;
    var procurementSpecialistValueTrendChart;

    var initiatedRiskAssessment = false;
    var riskAssessmentNumberChart;
    var riskAssessmentNumberTrendChart;
    var riskAssessmentValueChart;
    var riskAssessmentValueTrendChart;

    var topProcurementSpecialistTable;
    var topDepartmentsTable;
    var topSuppliersTable;

    var detailsTable;

    Vue.filter('currency', function (money) {
         return accounting.formatMoney(money, "", 0, ",", ".")
    })

    const app = new Vue({
          el: '#vue-row',
          data: {
            items: {}
          }
        });


    $(function() {
        $('#btn-process').click(function() {
            $('#dashboard-content').show();

            loadGeneral();
            currentFilterContent();
            refreshGeneral();
            callAgreementDetail();

            //End
            start($('#dashboard-content'));
            stop($('#dashboard-content'));
        });

        $('#general-tab').click(function() {
            setTimeout(function() {
                loadGeneral();
            }, 200);
        });

        $('#agreement-type-tab').click(function() {
            setTimeout(function() {
                loadAgreementType();
            }, 200);
        });


        $('#agreement-company-tab').click(function() {
            setTimeout(function() {
                loadAgreementCompany();
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

        $('#risk-assessment-tab').click(function() {
            setTimeout(function() {
                loadRiskAssessment();
            }, 200);
        });

        $('#details-tab').click(function() {
            setTimeout(function() {
                detailsTable.columns.adjust().draw();
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
            //loadGeneral();
            $('#btn-process').prop('disabled', false);
        });


    });
    function callAgreementDetail(){
        detailsTable = $('#details-table').DataTable({
            serverSide : true,
            destroy : true,
            ajax : '<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_detail') ?>?'+$('[name*="filter"]').serialize(),
            columns : [
                {data:'agreement_no'},
                {data:'type'},
                {data:'value', render : function(data) {
                    return Localization.number(data);
                }, class:'text-right'},
                {data:'currency', class : 'text-center'},
                {data:'supplier', class : 'text-center'},
                {data:'promise_date', render : function(data) {
                    return Localization.date(data);
                }, class:'text-right'}
            ],
            paging: false,
            searching: false,
            info: false
        });
    }

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

    function initGeneral() {
        statusChart = echarts.init(document.getElementById('status-chart'));
        agreementTypeChart = echarts.init(document.getElementById('agreement-type-chart'));
        companyChart = echarts.init(document.getElementById('company-chart'));
        procurementMethodChart = echarts.init(document.getElementById('procurement-method-chart'));
        riskAssessmentChart = echarts.init(document.getElementById('risk-assessment-chart'));
        function resize() {
            setTimeout(function() {
                statusChart.resize();
                agreementTypeChart.resize();
                companyChart.resize();
                procurementMethodChart.resize();
                riskAssessmentChart.resize();
            }, 200);
        }
        $(window).on('resize', resize);

        initiatedGeneral = true;
        loadGeneral();

    }

    function loadGeneral() {
        if (!initiatedGeneral) {
            initGeneral();
            return true;
        }

        if (!initiatedGeneral) {
            initGeneral();
            return true;
        }

        refreshGeneral();

    }

    function initAgreementType() {
        agreementTypeNumberChart = echarts.init(document.getElementById('agreement-type-number-chart'));
        agreementTypeNumberTrendChart = echarts.init(document.getElementById('agreement-type-number-trend-chart'));
        agreementTypeValueChart = echarts.init(document.getElementById('agreement-type-value-chart'));
        agreementTypeValueTrendChart = echarts.init(document.getElementById('agreement-type-value-trend-chart'));
        function resize() {
            setTimeout(function() {
                agreementTypeNumberChart.resize();
                agreementTypeNumberTrendChart.resize();
                agreementTypeValueChart.resize();
                agreementTypeValueTrendChart.resize();
            }, 200);
        }
        $(window).on('resize', resize);

        initiatedAgreementType = true;
        loadAgreementType();
    }

    // Tab Agreement Type
    function loadAgreementType() {
        if (!initiatedAgreementType) {
            initAgreementType();
            return true;
        }

        var agreement_type_data = {};
        var agreement_type_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_type') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_type_data = response.data;
                //console.log(agreement_type_data.length);
                for (var i = 0; i < agreement_type_data.length ; i++) {
                    agreement_type_data_legend.push(agreement_type_data[i].name);
                    //console.log(agreement_type_data[i].name);
                }
                var agreementTypeNumberChartOption = {
                    title: {
                            text: 'Agreement Type',
                            subtext: 'by Number of Agreement',
                            x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D', '#FFFF00', '#0072CF'],
                    legend : {
                        data: agreement_type_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Agreement Type',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_type_data
                    }]
                }
                agreementTypeNumberChart.setOption(agreementTypeNumberChartOption);
                setTimeout(function() {
                        agreementTypeNumberChart.resize();
                }, 200);
        })
          .catch(function (error) {
            console.log(error);
        });


        var agreement_type_data_value = {};
        var agreement_type_data_legend_value = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_type_value') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_type_data_value = response.data;
                //console.log(agreement_type_data.length);
                for (var i = 0; i < agreement_type_data.length ; i++) {
                    agreement_type_data_legend.push(agreement_type_data_value[i].name);
                    //console.log(agreement_type_data[i].name);
                }
                var agreementTypeValueChartOption = {
                title: {
                    text: 'Agreement Type',
                    subtext: 'by Value of Agreement',
                    x: 'center'
                },
                // tooltip: {
                //     trigger: 'item',
                //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                // },
                color: ['#00A5A8', '#626E82', '#FF7D4D', '#FFFF00', '#0072CF'],
                legend : {
                    data: agreement_type_data_legend_value,
                    x: 'center',
                    y: 55
                },
                calculable: true,
                series: [{
                    name: 'Agreement Type',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    itemStyle: {
                        normal: {
                            label: {
                                formatter: function (params) {
                                    return params.value;
                                }
                            },

                        },
                    },
                    data: agreement_type_data_value
                }]
            }
            agreementTypeValueChart.setOption(agreementTypeValueChartOption);
            setTimeout(function() {
                agreementTypeValueChart.resize();
            }, 200);
        })
          .catch(function (error) {
            console.log(error);
        });

        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_type_trend_value') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
               /*var legend = [];
               var chartdata = [];
               for (var i = 0; i < Object.keys(response.data.data).length; i++) {
                   legend.push(response.data.data[i].name);
               }*/

                var legend = [];
                var lastlegend = '';
                var inte = 0;
                $.each(response.data.data, function(key, row) {
                    if(row.name != lastlegend){
                        lastlegend = row.name;
                        legend[inte] = row.name;
                        inte++;
                    }
                });
                var periode = [];
                $.each(response.data.periode, function(key, row) {
                    //periode[key] = Localization.humanDate(row, '{Y} {m}');
                    periode[key] = row;
                });
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
                    $.each(periode, function(j, month) {
                        $.each(response.data.data, function(key, row) {
                            if((row.name == name)&&(row.periode == month)&&(row.number!="0")){
                                numberData[i].data[j] = row.number;
                                valueData[i].data[j] = parseInt(row.value);
                            }else {
                                if(numberData[i].data[j]){

                                }else{
                                    numberData[i].data[j] = 0;
                                    valueData[i].data[j] = 0;
                                }

                            }
                        });
                    });

                });

                var agreementTypeNumberTrendChartOption = {
                        title: {
                            text: 'Agreement Type - Trend',
                            subtext: 'by Number of Agreement, Monthly',
                            x: 'center'
                        },
                        tooltip : {
                            trigger: 'axis'
                        },
                        xAxis: [
                            {
                                type: 'category',
                                boundaryGap: false,
                                data: response.data.periode
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
                        color: ['#00A5A8', '#626E82', '#FF7D4D', '#FFFF00', '#0072CF'],
                        legend : {
                            data: legend,
                            x: 'center',
                            y: 55
                        },
                        series: numberData
                }
                agreementTypeNumberTrendChart.setOption(agreementTypeNumberTrendChartOption);

                 setTimeout(function() {
                        agreementTypeNumberTrendChart.resize();
                    }, 200);


               var agreementTypeValueTrendChartOption = {
                    title: {
                        text: 'Agreement Type - Trend',
                        subtext: 'by Value of Agreement, Monthly',
                        x: 'center'
                    },
                    tooltip : {
                        trigger: 'axis'
                    },
                    xAxis: [
                        {
                            type: 'category',
                            boundaryGap: false,
                            data: response.data.periode
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D', '#FFFF00', '#0072CF'],
                    legend : {
                        data: legend,
                        x: 'center',
                        y: 55
                    },
                    series: valueData
                }
                agreementTypeValueTrendChart.setOption(agreementTypeValueTrendChartOption);
        })
          .catch(function (error) {
            console.log(error);
        });


    }

    function refreshGeneral(){
        topProcurementSpecialistTable = $('#top-procurement-specialist-table').DataTable({
            serverSide : true,
            destroy : true,
            ajax : '<?= base_url('dashboard/agreement_issuance/get_top_procurement_specialists') ?>?'+$('[name*="filter"]').serialize(),
            columns : [
                {data:'NAME'},
                {data:'agreement_value', render : function(data) {
                    return Localization.number(data);
                }, class:'text-right'},
                {data:'agreement_number', class : 'text-center'}
            ],
            paging: false,
            searching: false,
            info: false,
            order:[['1', 'DESC']]
        });

        topDepartmentsTable = $('#top-departments-table').DataTable({
            serverSide : true,
            destroy : true,
            ajax : '<?= base_url('dashboard/agreement_issuance/get_top_departments') ?>?'+$('[name*="filter"]').serialize(),
            columns : [
                {data:'DEPARTMENT_DESC'},
                {data:'agreement_value', render : function(data) {
                    return Localization.number(data);
                }, class:'text-right'},
                {data:'agreement_number', class : 'text-center'}
            ],
            paging: false,
            searching: false,
            info: false,
            order:[['1', 'DESC']]
        });

        topSuppliersTable = $('#top-suppliers-table').DataTable({
            serverSide : true,
             destroy : true,
            ajax : '<?= base_url('dashboard/agreement_issuance/get_top_suppliers') ?>?'+$('[name*="filter"]').serialize(),
            columns : [
                {data:'NAMA'},
                {data:'agreement_value', render : function(data) {
                    return Localization.number(data);
                }, class:'text-right'},
                {data:'agreement_number', class : 'text-center'}
            ],
            paging: false,
            searching: false,
            info: false,
            order:[['1', 'DESC']]
        });

        axios.post('<?= base_url('dashboard/agreement_issuance/get_total_po_type') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
        }).then(function (response) {
            app.items = response.data
        })
            .catch(function (error) {
            console.log(error);
        });



        var agreement_status_data = {};
        var agreement_status_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_status') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_status_data = response.data;
                //console.log(agreement_type_data.length);
                for (var i = 0; i < agreement_status_data.length ; i++) {
                    agreement_status_legend.push(agreement_status_data[i].name);
                    //console.log(agreement_type_data[i].name);
                }
                var statusChartOption = {
                title: {
                    text: 'Status',
                    x: 'center'
                },
                // tooltip: {
                //     trigger: 'item',
                //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                // },
                color: ['#00A5A8', '#626E82', '#FF7D4D'],
                legend : {
                    data: agreement_status_legend,
                    x: 'center',
                    y: 30
                },
                calculable: true,
                series: [{
                    name: 'Status',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    itemStyle: {
                        normal: {
                            label: {
                                formatter: function (params) {
                                    return params.value;
                                }
                            },

                        },
                    },
                    data: agreement_status_data
                }]
            }
            statusChart.setOption(statusChartOption);
            setTimeout(function() {
                statusChart.resize();
            }, 200);

        })
          .catch(function (error) {
            console.log(error);
        });



        var agreement_type_data = {};
        var agreement_type_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_type') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_type_data = response.data;
                //console.log(agreement_type_data.length);
                for (var i = 0; i < agreement_type_data.length ; i++) {
                    agreement_type_data_legend.push(agreement_type_data[i].name);
                    //console.log(agreement_type_data[i].name);
                }
                var agreementTypeChartOption = {
                    title: {
                        text: 'Agreement Type',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_type_data_legend,
                        x: 'center',
                        y: 30
                    },
                    calculable: true,
                    series: [{
                        name: 'Agreement Type',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_type_data
                    }]
                }
                agreementTypeChart.setOption(agreementTypeChartOption);
                setTimeout(function() {
                    agreementTypeChart.resize();
                }, 200);

            })
              .catch(function (error) {
                console.log(error);
            });

        var agreement_method_data = {};
        var agreement_method_data_final = [];
        var agreement_method_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_method') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_method_data = response.data;
                for (var i = 0; i < agreement_method_data.length ; i++) {
                    agreement_method_data_legend.push(agreement_method_data[i].name);
                }

                for (var i = 0; i < agreement_method_data.length ; i++) {
                    agreement_method_data_final.push({
                        "name" : agreement_method_data[i].name,
                        "value" : agreement_method_data[i].number
                    });
                }
                var procurementMethodChartOption = {
                title: {
                    text: 'Proc. Method',
                    x: 'center'
                },
                // tooltip: {
                //     trigger: 'item',
                //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                // },
                color: ['#00A5A8', '#626E82', '#FF7D4D'],
                legend : {
                    data: agreement_method_data_legend,
                    x: 'center',
                    y: 30
                },
                calculable: true,
                series: [{
                    name: 'Proc. Method',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    itemStyle: {
                        normal: {
                            label: {
                                formatter: function (params) {
                                    return params.value;
                                }
                            },

                        },
                    },
                    data: agreement_method_data_final
                }]
            }
            procurementMethodChart.setOption(procurementMethodChartOption);
            setTimeout(function() {
                procurementMethodChart.resize();
            }, 200);

        })
          .catch(function (error) {
            console.log(error);
        });

        var agreement_risk_data = {};
        var agreement_risk_data_final = [];
        var agreement_risk_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_risk') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_risk_data = response.data;
                for (var i = 0; i < agreement_risk_data.length ; i++) {
                    agreement_risk_data_legend.push(agreement_risk_data[i].name);
                }

                for (var i = 0; i < agreement_risk_data.length ; i++) {
                    agreement_risk_data_final.push({
                        "name" : agreement_risk_data[i].name,
                        "value" : agreement_risk_data[i].number
                    });
                }
                var riskAssessmentChartOption = {
                title: {
                    text: 'Risk Assessment',
                    x: 'center'
                },
                // tooltip: {
                //     trigger: 'item',
                //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                // },
                color: ['#00A5A8', '#626E82', '#FF7D4D'],
                legend : {
                    data: agreement_risk_data_legend,
                    x: 'center',
                    y: 30
                },
                calculable: true,
                series: [{
                    name: 'Risk Assessment',
                    type: 'pie',
                    radius: '60%',
                    center: ['50%', '50%'],
                    itemStyle: {
                        normal: {
                            label: {
                                formatter: function (params) {
                                    return params.value;
                                }
                            },

                        },
                    },
                    data: agreement_risk_data_final
                }]
            }
            riskAssessmentChart.setOption(riskAssessmentChartOption);
            setTimeout(function() {
                riskAssessmentChart.resize();
            }, 200);


        })
          .catch(function (error) {
            console.log(error);
        });

        var agreement_company_data_number = [];
        var agreement_company_data_value = [];
        var agreement_company_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_company') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_company_data = response.data;
                for (var i = 0; i < agreement_company_data.length ; i++) {
                    agreement_company_data_legend.push(agreement_company_data[i].name);
                    agreement_company_data_value[i] = {
                        "name" : agreement_company_data[i].name,
                        "value" : agreement_company_data[i].value,
                    };
                    agreement_company_data_number[i] = {
                        "name" : agreement_company_data[i].name,
                        "value" : agreement_company_data[i].number,
                    };
                }

                var companyChartOption = {
                    title: {
                        text: 'Company',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_company_data_legend,
                        x: 'center',
                        y: 30
                    },
                    calculable: true,
                    series: [{
                        name: 'Company',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_company_data_number
                    }]
                }
                companyChart.setOption(companyChartOption);
                setTimeout(function() {
                    companyChart.resize();
                }, 200);



        })
          .catch(function (error) {
            console.log(error);
        });
    }

    function initAgreementCompany() {
        agreementCompanyNumberChart = echarts.init(document.getElementById('agreement-company-number-chart'));
        agreementCompanyNumberTrendChart = echarts.init(document.getElementById('agreement-company-number-trend-chart'));
        agreementCompanyValueChart = echarts.init(document.getElementById('agreement-company-value-chart'));
        agreementCompanyValueTrendChart = echarts.init(document.getElementById('agreement-company-value-trend-chart'));
        function resize() {
            setTimeout(function() {
                agreementCompanyNumberChart.resize();
                agreementCompanyNumberTrendChart.resize();
                agreementCompanyValueChart.resize();
                agreementCompanyValueTrendChart.resize();
            }, 200);
        }

        initiatedAgreementCompany = true;
        loadAgreementCompany();
    }

    function loadAgreementCompany() {
        if (!initiatedAgreementCompany) {
            initAgreementCompany();
            return true;
        }

        var agreement_company_data_number = [];
        var agreement_company_data_value = [];
        var agreement_company_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_company') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_company_data = response.data;
                for (var i = 0; i < agreement_company_data.length ; i++) {
                    agreement_company_data_legend.push(agreement_company_data[i].name);
                    agreement_company_data_value[i] = {
                        "name" : agreement_company_data[i].name,
                        "value" : agreement_company_data[i].value,
                    };
                    agreement_company_data_number[i] = {
                        "name" : agreement_company_data[i].name,
                        "value" : agreement_company_data[i].number,
                    };
                }

                var companyChartOption = {
                    title: {
                        text: 'Company',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_company_data_legend,
                        x: 'center',
                        y: 30
                    },
                    calculable: true,
                    series: [{
                        name: 'Company',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_company_data_number
                    }]
                }
                companyChart.setOption(companyChartOption);
                setTimeout(function() {
                    companyChart.resize();
                }, 200);

                var agreementCompanyNumberChartOption = {
                    title: {
                        text: 'Company',
                        subtext: 'by Number of Agreement',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_company_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Company',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_company_data_number
                    }]
                }
                agreementCompanyNumberChart.setOption(agreementCompanyNumberChartOption);

                setTimeout(function() {
                    agreementCompanyNumberChart.resize();
                }, 200);

                var agreementCompanyValueChartOption = {
                    title: {
                        text: 'Company',
                        subtext: 'by Value of Agreement',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_company_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Company',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_company_data_value
                    }]
                }
                agreementCompanyValueChart.setOption(agreementCompanyValueChartOption);

                setTimeout(function() {
                    agreementCompanyValueChart.resize();
                }, 200);

        })
          .catch(function (error) {
            console.log(error);
        });


        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_company_trend') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {

                var legend = [];
                var lastlegend = '';
                var inte = 0;
                $.each(response.data.data, function(key, row) {
                    if(row.name != lastlegend){
                        lastlegend = row.name;
                        legend[inte] = row.name;
                        inte++;
                    }
                });
                var periode = [];
                $.each(response.data.periode, function(key, row) {
                    //periode[key] = Localization.humanDate(row, '{Y} {m}');
                    periode[key] = row;
                });
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
                    $.each(periode, function(j, month) {
                        $.each(response.data.data, function(key, row) {
                            if((row.name == name)&&(row.periode == month)&&(row.number!="0")){
                                numberData[i].data[j] = row.number;
                                valueData[i].data[j] = parseInt(row.value);
                            }else {
                                if(numberData[i].data[j]){

                                }else{
                                    numberData[i].data[j] = 0;
                                    valueData[i].data[j] = 0;
                                }

                            }
                        });
                    });
                });

                 var agreementCompanyNumberTrendChartOption = {
                    title: {
                        text: 'Company - Trend',
                        subtext: 'by Number of Agreement, Monthly',
                        x: 'center'
                    },
                    tooltip : {
                        trigger: 'axis'
                    },
                    xAxis: [
                        {
                            type: 'category',
                            boundaryGap: false,
                            data: response.data.periode
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: legend,
                        x: 'center',
                        y: 55
                    },
                    series: numberData
                }
                agreementCompanyNumberTrendChart.setOption(agreementCompanyNumberTrendChartOption);

                setTimeout(function() {
                    agreementCompanyNumberTrendChart.resize();
                }, 200);

                var agreementCompanyValueTrendChartOption = {
                    title: {
                        text: 'Company - Trend',
                        subtext: 'by Value of Agreement, Monthly',
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: legend,
                        x: 'center',
                        y: 55
                    },
                    series: valueData
                }
        agreementCompanyValueTrendChart.setOption(agreementCompanyValueTrendChartOption);
        setTimeout(function() {
            agreementCompanyValueTrendChart.resize();
                }, 200);

        })
          .catch(function (error) {
            console.log(error);
        });
    }

    function initProcurementMethod() {
        procurementMethodNumberChart = echarts.init(document.getElementById('procurement-method-number-chart'));
        procurementMethodNumberTrendChart = echarts.init(document.getElementById('procurement-method-number-trend-chart'));
        procurementMethodValueChart = echarts.init(document.getElementById('procurement-method-value-chart'));
        procurementMethodValueTrendChart = echarts.init(document.getElementById('procurement-method-value-trend-chart'));
        function resize() {
            setTimeout(function() {
                procurementMethodNumberChart.resize();
                procurementMethodNumberTrendChart.resize();
                procurementMethodValueChart.resize();
                procurementMethodValueTrendChart.resize();
            }, 200);
        }

        initiatedProcurementMethod = true;
        loadProcurementMethod();
    }

    function loadProcurementMethod() {
        if (!initiatedProcurementMethod) {
            initProcurementMethod();
            return true;
        }

        var agreement_method_data_number = [];
        var agreement_method_data_value = [];
        var agreement_method_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_method') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_method_data = response.data;
                //console.log(agreement_type_data.length);
                for (var i = 0; i < agreement_method_data.length ; i++) {
                    agreement_method_data_legend.push(agreement_method_data[i].name);
                    agreement_method_data_value[i] = {
                        "name" : agreement_method_data[i].name,
                        "value" : agreement_method_data[i].value,
                    };
                    agreement_method_data_number[i] = {
                        "name" : agreement_method_data[i].name,
                        "value" : agreement_method_data[i].number,
                    };
                }

                console.log(agreement_method_data_number);
                var procurementMethodNumberChartOption = {
                    title: {
                        text: 'Procurement Method',
                        subtext: 'by Number of Agreement',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_method_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Procurement Method',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_method_data_number
                    }]
                }
                procurementMethodNumberChart.setOption(procurementMethodNumberChartOption);

                setTimeout(function() {
                    procurementMethodNumberChart.resize();
                }, 200);

                var procurementMethodValueChartOption = {
                    title: {
                        text: 'Procurement Method',
                        subtext: 'by Value of Agreement',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_method_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Procurement Method',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_method_data_value
                    }]
                }
                procurementMethodValueChart.setOption(procurementMethodValueChartOption);
        })
          .catch(function (error) {
            console.log(error);
        });


        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_method_trend') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {

                var legend = [];
                var lastlegend = '';
                var inte = 0;
                $.each(response.data.data, function(key, row) {
                    if(row.name != lastlegend){
                        lastlegend = row.name;
                        legend[inte] = row.name;
                        inte++;
                    }
                });
                var periode = [];
                $.each(response.data.periode, function(key, row) {
                    //periode[key] = Localization.humanDate(row, '{Y} {m}');
                    periode[key] = row;
                });
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
                    $.each(periode, function(j, month) {
                        $.each(response.data.data, function(key, row) {
                            if((row.name == name)&&(row.periode == month)&&(row.number!="0")){
                                numberData[i].data[j] = row.number;
                                valueData[i].data[j] = parseInt(row.value);
                            }else {
                                if(numberData[i].data[j]){

                                }else{
                                    numberData[i].data[j] = 0;
                                    valueData[i].data[j] = 0;
                                }

                            }
                        });
                    });
                });

                var procurementMethodNumberTrendChartOption = {
                    title: {
                        text: 'Procurement Method - Trend',
                        subtext: 'by Number of Agreement, Monthly',
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data : legend,
                        x: 'center',
                        y: 55
                    },
                    series: numberData
                }
                procurementMethodNumberTrendChart.setOption(procurementMethodNumberTrendChartOption);



                var procurementMethodValueTrendChartOption = {
                    title: {
                        text: 'Procurement Method - Trend',
                        subtext: 'by Value of Agreement, Monthly',
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D', '#FFFF00', '#0072CF'],
                    legend : {
                        data: legend,
                        x: 'center',
                        y: 55
                    },
                    series: valueData
                }
                procurementMethodValueTrendChart.setOption(procurementMethodValueTrendChartOption);



        })
          .catch(function (error) {
            console.log(error);
        });




    }

    function initProcurementSpecialist() {
        procurementSpecialistNumberChart = echarts.init(document.getElementById('procurement-specialist-number-chart'));
        procurementSpecialistNumberTrendChart = echarts.init(document.getElementById('procurement-specialist-number-trend-chart'));
        procurementSpecialistValueChart = echarts.init(document.getElementById('procurement-specialist-value-chart'));
        procurementSpecialistValueTrendChart = echarts.init(document.getElementById('procurement-specialist-value-trend-chart'));
        function resize() {
            setTimeout(function() {
                procurementSpecialistNumberChart.resize();
                procurementSpecialistNumberTrendChart.resize();
                procurementSpecialistValueChart.resize();
                procurementSpecialistValueTrendChart.resize();
            }, 200);
        }
        $(window).on('resize', resize);

        initiatedProcurementSpecialist = true;
        loadProcurementSpecialist();
    }

    function loadProcurementSpecialist() {
        if (!initiatedProcurementSpecialist) {
            initProcurementSpecialist();
            return true;
        }

        var agreement_procspe_data_number = [];
        var agreement_procspe_data_value = [];
        var agreement_procspe_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_procspe') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                agreement_procspe_data = response.data;
                //console.log(agreement_type_data.length);
                for (var i = 0; i < agreement_procspe_data.length ; i++) {
                    agreement_procspe_data_legend.push(agreement_procspe_data[i].name);
                    agreement_procspe_data_value[i] = {
                        "name" : agreement_procspe_data[i].name,
                        "value" : agreement_procspe_data[i].value,
                    };
                    agreement_procspe_data_number[i] = {
                        "name" : agreement_procspe_data[i].name,
                        "value" : agreement_procspe_data[i].number,
                    };
                }

                console.log(agreement_procspe_data_number);
                var procurementSpecialistNumberChartOption = {
                    title: {
                        text: 'Procurement Method',
                        subtext: 'by Number of Agreement',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_procspe_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Procurement Method',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_procspe_data_number
                    }]
                }
                procurementSpecialistNumberChart.setOption(procurementSpecialistNumberChartOption);

                setTimeout(function() {
                    procurementSpecialistNumberChart.resize();
                }, 200);

                var procurementSpecialistValueChartOption = {
                    title: {
                        text: 'Procurement Method',
                        subtext: 'by Value of Agreement',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_procspe_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Procurement Method',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_procspe_data_value
                    }]
                }
                procurementSpecialistValueChart.setOption(procurementSpecialistValueChartOption);
        })
          .catch(function (error) {
            console.log(error);
        });


        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_procurement_specialist_trend') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {

                var legend = [];
                var lastlegend = '';
                var inte = 0;
                $.each(response.data.data, function(key, row) {
                    if(row.name != lastlegend){
                        lastlegend = row.name;
                        legend[inte] = row.name;
                        inte++;
                    }
                });
                var periode = [];
                $.each(response.data.periode, function(key, row) {
                    //periode[key] = Localization.humanDate(row, '{Y} {m}');
                    periode[key] = row;
                });
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
                    $.each(periode, function(j, month) {
                        $.each(response.data.data, function(key, row) {
                            if((row.name == name)&&(row.periode == month)&&(row.number!="0")){
                                numberData[i].data[j] = row.number;
                                valueData[i].data[j] = parseInt(row.value);
                            }else {
                                if(numberData[i].data[j]){

                                }else{
                                    numberData[i].data[j] = 0;
                                    valueData[i].data[j] = 0;
                                }

                            }
                        });
                    });
                });

                var procurementSpecialistNumberTrendChartOption = {
                    title: {
                        text: 'Procurement Specialist - Trend',
                        subtext: 'by Number of Agreement, Monthly',
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data : legend,
                        x: 'center',
                        y: 55
                    },
                    series: numberData
                }
                procurementSpecialistNumberTrendChart.setOption(procurementSpecialistNumberTrendChartOption);



                var procurementSpecialistValueTrendChartOption = {
                    title: {
                        text: 'Procurement Specialist - Trend',
                        subtext: 'by Value of Agreement, Monthly',
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D', '#FFFF00', '#0072CF'],
                    legend : {
                        data: legend,
                        x: 'center',
                        y: 55
                    },
                    series: valueData
                }
                procurementSpecialistValueTrendChart.setOption(procurementSpecialistValueTrendChartOption);



        })
          .catch(function (error) {
            console.log(error);
        });



    }

    function initRiskAssessment() {
        riskAssessmentNumberChart = echarts.init(document.getElementById('risk-assessment-number-chart'));
        riskAssessmentNumberTrendChart = echarts.init(document.getElementById('risk-assessment-number-trend-chart'));
        riskAssessmentValueChart = echarts.init(document.getElementById('risk-assessment-value-chart'));
        riskAssessmentValueTrendChart = echarts.init(document.getElementById('risk-assessment-value-trend-chart'));
        function resize() {
            setTimeout(function() {
                riskAssessmentNumberChart.resize();
                riskAssessmentNumberTrendChart.resize();
                riskAssessmentValueChart.resize();
                riskAssessmentValueTrendChart.resize();
            }, 200);
        }
        $(window).on('resize', resize);

        initiatedRiskAssessment = true;
        loadRiskAssessment();
    }

    function loadRiskAssessment() {
        if (!initiatedRiskAssessment) {
            initRiskAssessment();
            return true;
        }

        var agreement_risk_data_number = [];
        var agreement_risk_data_value = [];
        var agreement_risk_data_legend = [];
        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_risk') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {
                console.log(response.data);
                agreement_risk_data = response.data;
                //console.log(agreement_type_data.length);
                for (var i = 0; i < agreement_risk_data.length ; i++) {
                    agreement_risk_data_legend.push(agreement_risk_data[i].name);
                    agreement_risk_data_value[i] = {
                        "name" : agreement_risk_data[i].name,
                        "value" : agreement_risk_data[i].value,
                    };
                    agreement_risk_data_number[i] = {
                        "name" : agreement_risk_data[i].name,
                        "value" : agreement_risk_data[i].number,
                    };
                }


                var riskAssessmentNumberChartOption = {
                    title: {
                        text: 'Risk Assessment',
                        subtext: 'by Number of Agreement',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_risk_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Risk Assessment',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_risk_data_number
                    }]
                }
                riskAssessmentNumberChart.setOption(riskAssessmentNumberChartOption);

                setTimeout(function() {
                    riskAssessmentNumberChart.resize();
                }, 200);

                var riskAssessmentValueChartOption = {
                    title: {
                        text: 'Risk Assessment',
                        subtext: 'by Value of Agreement',
                        x: 'center'
                    },
                    // tooltip: {
                    //     trigger: 'item',
                    //     formatter: "{a} <br/>{b}: {c} ({d}%)"
                    // },
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data: agreement_risk_data_legend,
                        x: 'center',
                        y: 55
                    },
                    calculable: true,
                    series: [{
                        name: 'Procurement Method',
                        type: 'pie',
                        radius: '60%',
                        center: ['50%', '50%'],
                        itemStyle: {
                            normal: {
                                label: {
                                    formatter: function (params) {
                                        return params.value;
                                    }
                                },

                            },
                        },
                        data: agreement_risk_data_value
                    }]
                }
                riskAssessmentValueChart.setOption(riskAssessmentValueChartOption);
        })
          .catch(function (error) {
            console.log(error);
        });


        axios.post('<?= base_url('dashboard/agreement_issuance/get_issuance_agreement_risk_trend') ?>?'+$('[name*="filter"]').serialize(), {
              foo: 'bar'
            }).then(function (response) {

                var legend = [];
                var lastlegend = '';
                var inte = 0;
                $.each(response.data.data, function(key, row) {
                    if(row.name != lastlegend){
                        lastlegend = row.name;
                        legend[inte] = row.name;
                        inte++;
                    }
                });
                var periode = [];
                $.each(response.data.periode, function(key, row) {
                    //periode[key] = Localization.humanDate(row, '{Y} {m}');
                    periode[key] = row;
                });
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
                    $.each(periode, function(j, month) {
                        $.each(response.data.data, function(key, row) {
                            if((row.name == name)&&(row.periode == month)&&(row.number!="0")){
                                numberData[i].data[j] = row.number;
                                valueData[i].data[j] = parseInt(row.value);
                            }else {
                                if(numberData[i].data[j]){

                                }else{
                                    numberData[i].data[j] = 0;
                                    valueData[i].data[j] = 0;
                                }

                            }
                        });
                    });
                });

                var riskAssessmentNumberTrendChartOption = {
                    title: {
                        text: 'Risk Assessment - Trend',
                        subtext: 'by Number of Agreement, Monthly',
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D'],
                    legend : {
                        data : legend,
                        x: 'center',
                        y: 55
                    },
                    series: numberData
                }
                riskAssessmentNumberTrendChart.setOption(riskAssessmentNumberTrendChartOption);



                var riskAssessmentValueTrendChartOption = {
                    title: {
                        text: 'Risk Assessment - Trend',
                        subtext: 'by Value of Agreement, Monthly',
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
                    color: ['#00A5A8', '#626E82', '#FF7D4D', '#FFFF00', '#0072CF'],
                    legend : {
                        data: legend,
                        x: 'center',
                        y: 55
                    },
                    series: valueData
                }
                riskAssessmentValueTrendChart.setOption(riskAssessmentValueTrendChartOption);



        })
          .catch(function (error) {
            console.log(error);
        });


    }
</script>
