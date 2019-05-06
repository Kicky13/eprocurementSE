<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Inventory Ratio Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Inventory Ratio Dashboard<li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
                <div class="card-body steps">
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel " class="tab-pane active" id="stats" aria-labelledby="stats-tab1" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-6 col-md-12">
                                    <div id="ito-chart" class="height-400 echart-container" style="min-width:450px;" ></div>
                                </div>
                                <div class="col-lg-6 col-md-12">
                                  <div id="month-Inventory-chart" class="height-400 echart-container" style="min-width:450px;" ></div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6 col-md-12">
                                  <div id="service-level-chart" class="height-400 echart-container" style="min-width:450px;" ></div>
                              </div>
                              <div class="col-lg-6 col-md-12">
                                  <div id="accuracy-level-chart" class="height-400 echart-container" style="min-width:450px;" ></div>
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

var itoChart;
var serviceLevelChart;
var MOIChart;
var AccLevelChart;
var initiatedInventoryRatio = false;

$(function() {
    $('#btn-process').click(function() {
        $('#dashboard-content').show();
        start($('#dashboard-content'));
        loadInventoryRatio();
    });

    require.config({
        paths: {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
    });

    require([
        'echarts',
        'echarts/chart/bar',
        'echarts/chart/line'
    ], function(ec) {
        echarts = ec;
        $('#btn-process').prop('disabled', false);
    });

    function initInventoryRatio() {
        itoChart = echarts.init(document.getElementById('ito-chart'));
        serviceLevelChart = echarts.init(document.getElementById('service-level-chart'));
        MOIChart = echarts.init(document.getElementById('month-Inventory-chart'));
        AccLevelChart = echarts.init(document.getElementById('accuracy-level-chart'));
        if (!initiatedInventoryRatio)  {
            function resize() {
                setTimeout(function() {
                    itoChart.resize();
                    serviceLevelChart.resize();
                    MOIChart.resize();
                    AccLevelChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedInventoryRatio = true;
        }
    }

    function loadInventoryRatio() {
        $.ajax({
            url: '<?= base_url('dashboard/inventory_ratio/get_ratio') ?>',
            type: 'post',
            data: $('[name*="filter"]').serialize(),
            dataType: 'json',
            success : function(response) {
                initInventoryRatio();
                var itoBalance = [];
                var itoRatio = [];
                $.each(response.data.ito, function(periode, ito) {
                    itoBalance.push(ito.BALANCE);
                    itoRatio.push(ito.LTMI/ito.BALANCE);
                });
                var maxItoBalance = Math.max.apply(Math,itoBalance);
                var maxItoRatio = Math.max.apply(Math,itoRatio);

                var periode = [];
                var itoBalanceValues = [];
                var itoRatioValues = [];
                var serviceLevelValues = {
                    ideal:[],
                    min:[],
                    actual:[]
                };
                $.each(response.periode, function(key, row) {
                    periode[key] = Localization.humanDate(row, '{Y} {m}');
                    if (response.data.ito[row]) {
                        itoBalanceValues[key] = response.data.ito[row].BALANCE;
                        var ratio = response.data.ito[row].LTMI/response.data.ito[row].BALANCE;
                        itoRatioValues[key] = ratio.toFixed(5);
                    } else {
                        itoBalanceValues[key] = 0;
                        itoRatioValues[key] = 0;
                    }
                    if (response.data.service_level[row]) {
                        serviceLevelValues.ideal[key] = response.data.service_level[row].ideal;
                        serviceLevelValues.min[key] = response.data.service_level[row].min;
                        if (response.data.service_level[row].actual) {
                            serviceLevelValues.actual[key] = ((response.data.service_level[row].actual.ISSUED_QTY/response.data.service_level[row]['actual'].SERVICE_QTY) * 100).toFixed(2);
                        } else {
                            serviceLevelValues.actual[key] = 0;
                        }
                    }
                });

                var itoChartOptions = {
                    title: {
                        text: 'Inventory Turn Over',
                        subtext: 'In Years',
                        x: 'center'
                    },
                    tooltip : {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['Inventory Value', 'Ratio'],
                        x : 'center',
                        y : 55
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: periode,
                        }
                    ],
                    yAxis: [
                        {
                            name: 'Inventory Value',
                            type: 'value',
                            position: 'left',
                            min:0,
                            max: maxItoBalance
                        },
                        {
                            name: 'Ratio',
                            type: 'value',
                            position: 'right',
                            min:0,
                            max:maxItoRatio,
                            axisLabel: {
                                formatter: function(value) {
                                    return value.toFixed(4);
                                }
                            }
                        }
                    ],
                    grid: {
                        x: 80, x2: 50,
                        y: 75
                    },
                    color: globalChartOption.color,
                    series: [
                        {
                            name: 'Inventory Value',
                            type: 'bar',
                            data: itoBalanceValues
                        },
                        {
                            name: 'Ratio',
                            type: 'line',
                            yAxisIndex : 1,
                            data: itoRatioValues
                        }
                    ]
                }
                itoChart.setOption(itoChartOptions);

                var serviceLevelChartOptions = {
                    title: {
                        text: 'Service Level Ratio',
                        x: 'center'
                    },
                    tooltip : {
                        trigger: 'axis'
                    },
                    legend: {
                        data:['Ideal', 'Min', 'Actual'],
                        x : 'center',
                        y : 55
                    },
                    xAxis: [
                        {
                            type: 'category',
                            data: periode,
                            boundaryGap: false,
                        }
                    ],
                    yAxis: [
                        {
                            type: 'value',
                        }
                    ],
                    grid: {
                        x: 80, x2: 50,
                        y: 75
                    },
                    color: globalChartOption.color,
                    series: [
                        {
                            name: 'Ideal',
                            type: 'line',
                            data: serviceLevelValues.ideal
                        },
                        {
                            name: 'Min',
                            type: 'line',
                            data: serviceLevelValues.min
                        },
                        {
                            name: 'Actual',
                            type: 'line',
                            data: serviceLevelValues.actual
                        }
                    ]
                }
                serviceLevelChart.setOption(serviceLevelChartOptions);

                MOIchartOptions = {
                  title: {
                      text: 'Month Of Inventory Ratio',
                      x: 'center'
                  },

                  // Setup grid
                  grid: {
                    x: 80, x2: 50,
                    y: 75
                  },

                  // Add tooltip
                  tooltip: {
                      trigger: 'axis'
                  },

                  // Add legend
                  legend: {
                      data: ['Email marketing', 'Advertising alliance', 'Video ads', 'Direct access', 'Search engine'],
                      x : 'center',
                      y : 55,
                  },

                  // Add custom colors
                  color: ['#F98E76', '#16D39A', '#2DCEE3', '#FF7588', '#626E82'],

                  // Enable drag recalculate
                  calculable: true,

                  // Hirozontal axis
                  xAxis: [{
                      type: 'category',
                      boundaryGap: false,
                      data: [
                          'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
                      ]
                  }],

                  // Vertical axis
                  yAxis: [{
                      type: 'value'
                  }],

                  // Add series
                  series: [
                      {
                          name: 'Email marketing',
                          type: 'line',
                          stack: 'Total',
                          data: [120, 132, 101, 134, 90, 230, 210]
                      },
                      {
                          name: 'Advertising alliance',
                          type: 'line',
                          stack: 'Total',
                          data: [220, 182, 191, 234, 290, 330, 310]
                      },
                      {
                          name: 'Video ads',
                          type: 'line',
                          stack: 'Total',
                          data: [150, 232, 201, 154, 190, 330, 410]
                      },
                      {
                          name: 'Direct access',
                          type: 'line',
                          stack: 'Total',
                          data: [320, 332, 301, 334, 390, 330, 320]
                      },
                      {
                          name: 'Search engine',
                          type: 'line',
                          stack: 'Total',
                          data: [820, 932, 901, 934, 1290, 1330, 1320]
                      }
                  ]
                };
                MOIChart.setOption(MOIchartOptions);

                AccLevelchartOptions = {

                  title: {
                      text: 'Accuracy Level Ratio',
                      x: 'center'
                  },
                  // Setup grid
                  grid: {
                    x: 80, x2: 50,
                    y: 75
                  },

                  // Add tooltip
                  tooltip: {
                      trigger: 'axis'
                  },

                  // Add legend
                  legend: {
                      data: ['ALR', 'Discrepancy', 'Max Dicrap'],
                      x : 'center',
                      y : 55,
                  },

                  // Add custom colors
                  color: ['#00A5A8', '#FF4558', '#FF7D4D'],

                  // Enable drag recalculate
                  calculable: true,

                  // Horizontal axis
                  xAxis: [{
                      type: 'category',
                      data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
                  }],

                  // Vertical axis
                  yAxis : [
                      {
                          type : 'value',
                          name : 'Percent',
                          axisLabel : {
                              formatter: '{value} %'
                          }
                      },
                      {
                          type : 'value',
                          name : 'Discrap',
                          axisLabel : {
                              formatter: '{value} %'
                          }
                      }
                  ],

                  // Add series
                  series : [
                      {
                          name:'ALR',
                          type:'bar',
                          data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
                      },
                      {
                          name:'Discrepancy',
                          type:'bar',
                          data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
                      },
                      {
                          name:'Max Dicrap',
                          type:'line',
                          yAxisIndex: 1,
                          data:[2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
                      }
                  ]
                };
                AccLevelChart.setOption(AccLevelchartOptions);

                stop($('#dashboard-content'));
            }
        });
    }
});
</script>
