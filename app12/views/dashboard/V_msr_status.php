<div class="row">
    <div class="col-xl-5 col-lg-5">
        <div class="card">
            <div class="card-header" style="text-align:center"> 
                <h4 class="card-title">MSR Status</h4>
                <p>By number of MSR,Monthly</p>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div id="basic-pie" class="height-400 echart-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-7 col-lg-7">
        <div class="card">
            <div class="card-header" style="text-align:center"> 
                <h4 class="card-title">MSR Status - TREND</h4>
                <p>By number of MSR,Monthly</p>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div id="stacked-line" class="height-400 echart-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-5 col-lg-5">
        <div class="card">
            <div class="card-header" style="text-align:center"> 
                <h4 class="card-title">MSR Status ($)</h4>
                <p>By number of MSR,Monthly</p>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div id="basic-pie2" class="height-400 echart-container"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-7 col-lg-7">
        <div class="card">
            <div class="card-header " style="text-align:center">
                <h4 class="card-title">MSR Status ($) - TREND</h4>
                <p>By number of MSR,Monthly</p>
                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                <div class="heading-elements">
                    <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                    </ul>
                </div>
            </div>
            <div class="card-content collapse show">
                <div class="card-body">
                    <div id="stacked-line2" class="height-400 echart-container"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(function()
{
    require.config({
        paths: {
            echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'
        }
    });
    require(
        [
            'echarts',
            'echarts/chart/pie',
            'echarts/chart/funnel'
        ],
        function (ec) {            
            var myChart = ec.init(document.getElementById('basic-pie'));
            chartOptions = {                
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },                
                color: ['#00A5A8', '#626E82', '#FF7D4D','#FF4558', '#16D39A'],                
                calculable: true,
                series: [{
                    name: 'Browsers',
                    type: 'pie',
                    radius: '55%',
                    center: ['50%', '28.5%'],
                    data: [
                        {value: 335, name: 'IE'},
                        {value: 310, name: 'Opera'},
                        {value: 234, name: 'Safari'},
                        {value: 135, name: 'Firefox'},
                        {value: 1548, name: 'Chrome'}
                    ]
                }]
            };
            myChart.setOption(chartOptions);
            $(function () {
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);
                function resize() {
                    setTimeout(function() {
                        myChart.resize();
                    }, 200);
                }
            });
        }
    ); 

    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line'
        ],
        function (ec) {          
            var myChart = ec.init(document.getElementById('stacked-line'));
            chartOptions = {            
                grid: {
                    x: 40,x2: 20,
                    y: 35,y2: 25
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Email marketing', 'Advertising alliance', 'Video ads', 'Direct access', 'Search engine']
                },
                color: ['#F98E76', '#16D39A', '#2DCEE3', '#FF7588', '#626E82'],
                calculable: true,
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [
                        'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
                    ]
                }],
                yAxis: [{
                    type: 'value'
                }],
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
            myChart.setOption(chartOptions);
            $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart.resize();
                    }, 200);
                }
            });
        }
    );

    require(
        [
            'echarts',
            'echarts/chart/pie',
            'echarts/chart/funnel'
        ],
        function (ec) {            
            var myChart = ec.init(document.getElementById('basic-pie2'));
            chartOptions = {                
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },                
                color: ['#00A5A8', '#626E82', '#FF7D4D','#FF4558', '#16D39A'],                
                calculable: true,
                series: [{
                    name: 'Browsers',
                    type: 'pie',
                    radius: '55%',
                    center: ['50%', '28.5%'],
                    data: [
                        {value: 335, name: 'IE'},
                        {value: 310, name: 'Opera'},
                        {value: 234, name: 'Safari'},
                        {value: 135, name: 'Firefox'},
                        {value: 1548, name: 'Chrome'}
                    ]
                }]
            };
            myChart.setOption(chartOptions);
            $(function () {
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);
                function resize() {
                    setTimeout(function() {
                        myChart.resize();
                    }, 200);
                }
            });
        }
    ); 

    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line'
        ],
        function (ec) {          
            var myChart = ec.init(document.getElementById('stacked-line2'));
            chartOptions = {            
                grid: {
                    x: 40,x2: 20,
                    y: 35,y2: 25
                },
                tooltip: {
                    trigger: 'axis'
                },
                legend: {
                    data: ['Email marketing', 'Advertising alliance', 'Video ads', 'Direct access', 'Search engine']
                },
                color: ['#F98E76', '#16D39A', '#2DCEE3', '#FF7588', '#626E82'],
                calculable: true,
                xAxis: [{
                    type: 'category',
                    boundaryGap: false,
                    data: [
                        'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'
                    ]
                }],
                yAxis: [{
                    type: 'value'
                }],
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
            myChart.setOption(chartOptions);
            $(function () {

                // Resize chart on menu width change and window resize
                $(window).on('resize', resize);
                $(".menu-toggle").on('click', resize);

                // Resize function
                function resize() {
                    setTimeout(function() {

                        // Resize chart
                        myChart.resize();
                    }, 200);
                }
            });
        }
    );      
});
</script>