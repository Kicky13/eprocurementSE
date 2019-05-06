<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Supplier Performance Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Supplier Performance Dashboard</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="card">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
                <div class="card-body">
                    <div class="tab-content px-1 pt-1">
                        <div role="tabpanel " class="tab-pane active" id="stats" aria-labelledby="stats-tab1" aria-expanded="false">
                            <div class="row">
                                <div class="col-lg-7 col-md-12 row">
                                    <div id="supplier-performance-chart" class="height-300 width-700  echart-container" style="min-width:450px;"></div>
                                </div>
                                <div class="col-lg-5 col-md-12">
                                    <div id="cpm-cor-performed-chart" class="height-300 echart-container"></div>
                                </div>
                                <div class="col-lg-12 col-md-12">
                                    <table id="data-table" class="table table-striped table-bordered table-hover display text-center" width="100%" style="font-size: 12px;">
                                        <thead>
                                            <tr>
                                                <th>Supplier</th>
                                                <th>SLKA No</th>
                                                <th>Supply Category</th>
                                                <th>Average Rating</th>
                                                <th>Performance</th>
                                                <th>History</th>
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

    var initiatedSupplierPerformance = false;
    var supplierPerformanceChart;
    var cpmCorPerformedChart;
    var ratingColor = ['#20A464', '#4A66A0', '#FFFF00','#DD5044'];

    var dataTable;

    $(function() {
        $('#btn-process').click(function() {
            $('#dashboard-content').show();
            currentFilterContent();
            loadSupplierPerformance();
            dataTable.ajax.url('<?= base_url('dashboard/supplier_performance/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
        });

        require.config({
            paths: {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
        });
        require(
            [
                'echarts',
                'echarts/chart/pie',
                'echarts/chart/bar'
            ],
            function (ec) {
                echarts = ec;
                $('#btn-process').prop('disabled', false);
            }
        );

        dataTable = $('#data-table').DataTable({
            serverSide: true,
            processing: true,
            ajax: '<?= base_url('dashboard/supplier_performance/get_details') ?>?'+$('[name*="filter"]').serialize(),
            columns: [
                {data:'NAMA'},
                {data:'NO_SLKA'},
                {data:'CLASSIFICATION'},
                {data:'AVG_RATING'},
                {data:'PERFORMANCE', render:function(data) {
                    if (data == 'Excellent') {
                        return '<span style="color:'+ratingColor[0]+'">'+data+'</span>';
                    } else if (data == 'Good') {
                        return '<span style="color:'+ratingColor[1]+'">'+data+'</span>';
                    } else if (data == 'Fair') {
                        return '<span style="color:'+ratingColor[2]+'">'+data+'</span>';
                    } else {
                        return '<span style="color:'+ratingColor[3]+'">'+data+'</span>';
                    }
                }},
                {data:'ID'}
            ],
            paging: false,
            searching: false,
            info: false,
            scrollX: true
        });
    });

    function currentFilterContent() {
        var currentFilterContentHtml = '';
        currentFilterContentHtml += renderCurrentFilterContent('supplier_rating', 'Supplier Rating');
        currentFilterContentHtml += renderCurrentFilterContent('supplier_classification', 'Supplier Classification');
        currentFilterContentHtml += renderCurrentFilterContent('supplier', 'Supplier');
        currentFilterContentHtml += renderCurrentFilterContent('years', 'Years');
        currentFilterContentHtml += renderCurrentFilterContent('months', 'Months');
        if (currentFilterContentHtml == '') {
            currentFilterContentHtml = 'Data not filtered';
        }
        $('#current-filter-content').html(currentFilterContentHtml);
    }

    function initSupplierPerformance() {
        supplierPerformanceChart = echarts.init(document.getElementById('supplier-performance-chart'));
        cpmCorPerformedChart = echarts.init(document.getElementById('cpm-cor-performed-chart'));
        if (!initiatedSupplierPerformance) {
            function resize() {
                setTimeout(function() {
                    supplierPerformanceChart.resize();
                    cpmCorPerformedChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedSupplierPerformance = true;
        }
    }

    function loadSupplierPerformance() {
        start($('#dashboard-content'));
        $.ajax({
            url: '<?= base_url('dashboard/supplier_performance/get_performance') ?>',
            type: 'post',
            data: $('[name*="filter"]').serialize(),
            dataType: 'json',
            success: function(response) {
                initSupplierPerformance();
                var countAllSuppliers = 0;
                $.each(response.data.performance, function(performance, suppliers) {
                    countAllSuppliers+=suppliers.length;
                });
                var labelTop = {
                    normal: {
                        label: {
                            show: true,
                            position: 'center',
                            formatter: '{b}\n',
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


                var labelFromatter = {
                    normal: {
                        label: {
                            formatter: function (params) {
                                return '\n\n' + (100 - params.value) + '%';
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
                    emphasis: {
                        color: 'rgba(0,0,0,0)'
                    }
                };
                var radius = [30, 40];

                var performanceData = response.data.performance;
                var data = {};
                $.each(response.rating, function(i, performance) {
                    if (performanceData[i]) {
                        data[i] = (performanceData[i].length/countAllSuppliers*100).toFixed(2);
                    } else {
                        data[i] = 0;
                    }
                });
                var supplierPerformanceChartOptions = {
                    title: {
                        text: 'Supplier Rating',
                        x: 'center'
                    },
                    legend: {
                        x: 'center',
                        y: '80%',
                        data: ['Excellent', 'Good', 'Fair', 'Poor']
                    },
                    color: ratingColor,
                    series: [
                        {
                            type: 'pie',
                            center: ['15%', '40%'],
                            radius: radius,
                            itemStyle: labelFromatter,
                            data: [
                                {name: 'other', value: (100-data['Excellent']), itemStyle: labelBottom},
                                {name: 'Excellent', value: data['Excellent'], itemStyle: labelTop}
                            ]
                        },
                        {
                            type: 'pie',
                            center: ['40%', '40%'],
                            radius: radius,
                            itemStyle: labelFromatter,
                            data: [
                                {name: 'other', value: (100-data['Good']), itemStyle: labelBottom},
                                {name: 'Good', value: data['Good'], itemStyle: labelTop}
                            ]
                        },
                        {
                            type: 'pie',
                            center: ['65%', '40%'],
                            radius: radius,
                            itemStyle: labelFromatter,
                            data: [
                                {name: 'other', value: (100-data['Fair']), itemStyle: labelBottom},
                                {name: 'Fair', value: data['Fair'], itemStyle: labelTop}
                            ]
                        },
                        {
                            type: 'pie',
                            center: ['90%', '40%'],
                            radius: radius,
                            itemStyle: labelFromatter,
                            data: [
                                {name: 'other', value: (100-data['Poor']), itemStyle: labelBottom},
                                {name: 'Poor', value: data['Poor'], itemStyle: labelTop}
                            ]
                        },

                    ]
                };
                supplierPerformanceChart.setOption(supplierPerformanceChartOptions);


                var agreementData = response.data.agreement;
                var agreementDataOption = {
                  legend : ['Performed', 'Agreement'],
                  category : ['COR', 'CPM'],
                }
                var agreement_data = [];
                $.each(agreementDataOption.legend, function(i, name) {
                  agreement_data[i] = {
                      name : name,
                      type : 'bar',
                      data : []
                  }
                  $.each(agreementDataOption.category, function(key, row) {
                    // console.log(row);
                    // console.log(row[name]);
                    if (agreementData[name]) {
                      if (agreementData[name][row]) {
                        agreement_data[i].data[key] = response.data.agreement[name][row].number;
                        console.log(response.data.agreement[name][row]);
                      } else {
                        agreement_data[i].data[key] = 0;
                      }
                    } else {
                      agreement_data[i].data[key] = 0;
                    }
                  });
                });

                cpmCorPerformedChartOptions = {
                    title: {
                        text: 'CPM & COR Performed',
                        subtext: '> by number of Agreement',
                        x: 'center'
                    },
                    grid: {
                        x: 80,
                        x2: 60,
                        y: 65,
                        y2: 45
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        x: 'center',
                        y: '95%',
                        data: agreementDataOption.legend
                    },
                    color: ['#ffcc66', '#996600'],
                    xAxis: [{
                        type: 'value',
                    }],
                    yAxis: [{
                        type: 'category',
                        data: agreementDataOption.category
                    }],
                    series : agreement_data
                };
                cpmCorPerformedChart.setOption(cpmCorPerformedChartOptions);
                stop($('#dashboard-content'));
            }
        });
    }
</script>
