<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Inventory Index Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Inventory Index Dashboard<li>
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
                                <div class="col-lg-12 col-md-12">
                                    <div id="inventory-index-chart" class="height-400 echart-container" style="min-width:450px;" ></div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-lg-6 col-md-12">
                                  <div id="direct-charge-ratio-chart" class="height-400 echart-container" style="min-width:450px;" ></div>
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

var inventoryIndexChart;
var directChargeChart;
var acccuracyLevelRatio;
var initiatedInventoryIndex = false;

$(function() {
    $('#btn-process').click(function() {
        $('#dashboard-content').show();
        start($('#dashboard-content'));
        loadInventoryIndex();
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

    function initInventoryIndex() {
        inventoryIndexChart = echarts.init(document.getElementById('inventory-index-chart'));
        directChargeChart = echarts.init(document.getElementById('direct-charge-ratio-chart'));
        acccuracyLevelRatio = echarts.init(document.getElementById('accuracy-level-chart'));
        if (!initiatedInventoryIndex)  {
            function resize() {
                setTimeout(function() {
                    inventoryIndexChart.resize();
                    directChargeChart.resize();
                    acccuracyLevelRatio.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedInventoryIndex = true;
        }
    }

    function loadInventoryIndex() {
          initInventoryIndex();
          inventoryIndexChartOptions = {
            title: {
                text: 'Inventory Index',
                subtext: '',
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
                data: [
                    'ECharts1 - 2k Data','ECharts1 - 2w Data','ECharts1 - 20w Data','',
                    'ECharts2 - 2k Data','ECharts2 - 2w Data','ECharts2 - 20w Data'
                ],
                x : 'center',
                y : 55
            },
            // Enable drag recalculate
            calculable: true,
            // Horizontal axis
            xAxis: [{
                type : 'category',
                data : ['Line','Bar','Scatter','K','Map']
            },
            {
                type : 'category',
                axisLine: {show:false},
                axisTick: {show:false},
                axisLabel: {show:false},
                splitArea: {show:false},
                splitLine: {show:false},
                data : ['Line','Bar','Scatter','K','Map']
            }
            ],
            // Vertical axis
            yAxis: [{
                type : 'value',
                axisLabel:{formatter:'{value} ms'}
            }],
            // Add series
            series : [
                {
                    name:'ECharts2 - 2k Data',
                    type:'bar',
                    itemStyle: {normal: {color:'rgba(22,211,154,1)', label:{show:true}}},
                    data:[40,155,95,75, 0]
                },
                {
                    name:'ECharts2 - 2w Data',
                    type:'bar',
                    itemStyle: {normal: {color:'rgba(45,206,227,1)', label:{show:true,textStyle:{color:'#27727B'}}}},
                    data:[100,200,105,100,156]
                },
                {
                    name:'ECharts2 - 20w Data',
                    type:'bar',
                    itemStyle: {normal: {color:'rgba(249,142,118,1)', label:{show:true,textStyle:{color:'#E87C25'}}}},
                    data:[906,911,908,778,0]
                },
                {
                    name:'ECharts1 - 2k Data',
                    type:'bar',
                    xAxisIndex:1,
                    itemStyle: {normal: {color:'rgba(22,211,154,0.7)', label:{show:true,formatter:function(p){return p.value > 0 ? (p.value +'\n'):'';}}}},
                    data:[96,224,164,124,0]
                },
                {
                    name:'ECharts1 - 2w Data',
                    type:'bar',
                    xAxisIndex:1,
                    itemStyle: {normal: {color:'rgba(45,206,227,0.7)', label:{show:true}}},
                    data:[491,2035,389,955,347]
                },
                {
                    name:'ECharts1 - 20w Data',
                    type:'bar',
                    xAxisIndex:1,
                    itemStyle: {normal: {color:'rgba(249,142,118,0.7)', label:{show:true,formatter:function(p){return p.value > 0 ? (p.value +'+'):'';}}}},
                    data:[3000,3000,2817,3000,0]
                }
            ]
        };
        inventoryIndexChart.setOption(inventoryIndexChartOptions);

        directChargechartOptions = {
          title: {
              text: 'Direct Charge Ratio',
              subtext: '',
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
              data: ['All Receive Value', 'Direct Charge Value'],
              x : 'center',
              y : 55
          },

          // Add custom colors
          color: ['#00B5B8', '#FF7588'],

          // Enable drag recalculate
          calculable: true,

          // Horizontal axis
          xAxis: [{
              type: 'category',
              data: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec']
          }],

          // Vertical axis
          yAxis: [{
              type: 'value'
          }],

          // Add series
          series: [
              {
                  name: 'All Receive Value',
                  type: 'bar',
                  data: [2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3],
                  itemStyle: {
                      normal: {
                          label: {
                              show: true,
                              textStyle: {
                                  fontWeight: 500
                              }
                          }
                      }
                  },
                  markLine: {
                      data: [{type: 'average', name: 'Average'}]
                  }
              },
              {
                  name: 'Direct Charge Value',
                  type: 'bar',
                  data: [2.6, 5.9, 9.0, 26.4, 58.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3],
                  itemStyle: {
                      normal: {
                          label: {
                              show: true,
                              textStyle: {
                                  fontWeight: 500
                              }
                          }
                      }
                  },
                  markLine: {
                      data: [{type: 'average', name: 'Average'}]
                  }
              }
          ]
      };
      directChargeChart.setOption(directChargechartOptions);

      acccuracyLevelRatiochartOptions = {
          title: {
              text: 'Accuracy Level Ratio',
              subtext: '',
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
              data: ['Evaporation', 'Precipitation', 'Average temperature'],
              x : 'center',
              y : 55
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
                  name : 'Water',
                  axisLabel : {
                      formatter: '{value} ml'
                  }
              },
              {
                  type : 'value',
                  name : 'Temperature',
                  axisLabel : {
                      formatter: '{value} °C'
                  }
              }
          ],

          // Add series
          series : [
              {
                  name:'Evaporation',
                  type:'bar',
                  data:[2.0, 4.9, 7.0, 23.2, 25.6, 76.7, 135.6, 162.2, 32.6, 20.0, 6.4, 3.3]
              },
              {
                  name:'Precipitation',
                  type:'bar',
                  data:[2.6, 5.9, 9.0, 26.4, 28.7, 70.7, 175.6, 182.2, 48.7, 18.8, 6.0, 2.3]
              },
              {
                  name:'Average temperature',
                  type:'line',
                  yAxisIndex: 1,
                  data:[2.0, 2.2, 3.3, 4.5, 6.3, 10.2, 20.3, 23.4, 23.0, 16.5, 12.0, 6.2]
              }
          ]
      };
      acccuracyLevelRatio.setOption(acccuracyLevelRatiochartOptions);
      stop($('#dashboard-content'));
    }
});
</script>
