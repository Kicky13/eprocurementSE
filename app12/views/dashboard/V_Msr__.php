<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">        
    </div>
    <div class="content-detached">        
        <div class="content-body" id="main-content">
            <section>
                <div class="card">
                    <div class="card-header">                        
                        <div class="row">                            
                        </div>                 
                    </div>
                    <div class="card-body row">                              
                        <div class="form-group col-sm-4">
                            <div class="col-sm-12 form-row approval" id="data3">                            
                                <div class="input-group date">
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span><input type="text" id="tanggal_filter" class="form-control" name="tanggal_filter" value="<?php echo date("Y-m-d"); ?>">
                                </div>                            
                            </div>                                                    
                        </div>
                        <div class="form-group" style="padding-top: 15px;border-top: 1px solid #f1f1f1;border-bottom: 1px solid #f1f1f1;">
                            <input type="checkbox" value="01" id="month" name="month"> <i></i>Jan
                            <input type="checkbox" value="02" id="month" name="month"> <i></i>Feb
                            <input type="checkbox" value="03" id="month" name="month"> <i></i>Mar
                            <input type="checkbox" value="04" id="month" name="month"> <i></i>Apr
                            <input type="checkbox" value="05" id="month" name="month"> <i></i>May
                            <input type="checkbox" value="06" id="month" name="month"> <i></i>Jun
                            <input type="checkbox" value="07" id="month" name="month"> <i></i>Jul
                            <input type="checkbox" value="08" id="month" name="month"> <i></i>Aug
                            <input type="checkbox" value="09" id="month" name="month"> <i></i>Sep
                            <input type="checkbox" value="10" id="month" name="month"> <i></i>Oct
                            <input type="checkbox" value="11" id="month" name="month"> <i></i>Nov
                            <input type="checkbox" value="12" id="month" name="month"> <i></i>Dec
                        </div>
                    </div>                                                    
                </div>
                <div class="card">
                    <div class="card-body">                        
                        <ul class="nav nav-tabs nav-top-border no-hover-bg nav-justified">
                            <li class="nav-item">
                                <a class="nav-link active" id="stats-tab1" data-toggle="tab" href="#stats" aria-controls="stats" aria-expanded="true">Status</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="types-tab1" data-toggle="tab" href="#stats" aria-controls="types">Type</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" id="methods-tab1" data-toggle="tab" href="#stats" aria-controls="methods">Procurement Method</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="specialists-tab1" data-toggle="tab" href="#stats" aria-controls="specialist">Procurement Specialist</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="details-tab1" data-toggle="tab" href="#stats" aria-controls="details">Details</a>
                            </li>
                        </ul>
                        <div class="tab-content px-1 pt-1">
                            <div role="tabpanel " class="tab-pane active" id="stats" aria-labelledby="stats-tab1" aria-expanded="false">
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
                                            <div id="basic-line" class="height-400 echart-container"></div>
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
                                            <div id="basic-line2" class="height-400 echart-container"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                        
                            </div>
                            <div class="tab-pane" id="types" role="tabpanel" aria-labelledby="types-tab1" aria-expanded="false">
                                <p>Chocolate bar gummies sesame snaps. Liquorice cake sesame
                                snaps cotton candy cake sweet brownie. Cotton candy candy
                                canes brownie. Biscuit pudding sesame snaps pudding pudding
                                sesame snaps biscuit tiramisu.</p>
                            </div>                        
                            <div class="tab-pane" id="methods" role="tabpanel" aria-labelledby="methods-tab1" aria-expanded="false">
                                <p> icing tootsie roll cupcake jelly-o sesame snaps. Gummies
                                cookie dragée cake jelly marzipan donut pie macaroon. Gingerbread
                                powder chocolate cake icing. Cheesecake gummi bears ice
                                cream marzipan.</p>
                            </div>
                            <div class="tab-pane" id="specialist" role="tabpanel" aria-labelledby="specialist-tab1" aria-expanded="false">
                                <p>tootsie roll cupcake jelly-o sesame snaps. Gummies
                                cookie dragée cake jelly marzipan donut pie macaroon. Gingerbread
                                powder chocolate cake icing. Cheesecake gummi bears ice
                                cream marzipan.</p>
                            </div>
                            <div class="tab-pane" id="details" role="tabpanel" aria-labelledby="details-tab1" aria-expanded="false">
                                <p>roll cupcake jelly-o sesame snaps. Gummies
                                cookie dragée cake jelly marzipan donut pie macaroon. Gingerbread
                                powder chocolate cake icing. Cheesecake gummi bears ice
                                cream marzipan.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>        
    </div>
</div>
</div>
<script src="<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts/echarts.js" type="text/javascript"></script>

<script>
    $(document).ready(function () 
    {        
        var pos='msr_status';
        $('.input-group.date').datetimepicker({
            format: 'YYYY'
        });
        
        $('#stats-tab1').click(function(){
            Window.pos='msr_status';
           get_status("msr_status");
        });
        $('#types-tab1').click(function(){
            Window.pos='msr_type';
           get_status("msr_type");
        });
        $('#methods-tab1').click(function(){
            Window.pos='msr_method';
           get_status("msr_method");
        });
        $('#specialist-tab1').click(function(){
            Window.pos='msr_specialist';
           get_status("msr_specialist");
        });

        $('#process').on('submit', function (e) {
            e.preventDefault();
            var obj={};
            $.each($('#process').serializeArray(), function (i, field) {
                obj[field.name] = field.value;
            });
            obj.position=Window.pos;
            $.ajax({
                url:"<?= base_url("dashboard/msr/process")?>",
                type:"POST",
                data:obj,
                success:function(m){
                    setChart(m,Window.pos);
                }    
            });
        });

        var Chart;
        require.config({
            paths: {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
        });
        require(
            [
                'echarts',
                'echarts/chart/pie',
                'echarts/chart/funnel'
            ],
            function (ec) {            
                Window.Chart = ec.init(document.getElementById('basic-pie'));                         
                $(function () {
                    $(window).on('resize', resize);
                    $(".menu-toggle").on('click', resize);
                    function resize() {
                        setTimeout(function() {
                            Window.Chart.resize();
                        }, 200);
                    }
                });
            }
        ); 

        var ChartLine;
        require(
            [
                'echarts',
                'echarts/chart/bar',
                'echarts/chart/line'
            ],
            function (ec) {          
                Window.ChartLine = ec.init(document.getElementById('basic-line'));                
                
                $(function () {
                    $(window).on('resize', resize);
                    $(".menu-toggle").on('click', resize);
                    function resize() {
                        setTimeout(function() {
                            Window.ChartLine.resize();
                        }, 200);
                    }
                });
            }
        );
        var Chart2;
        require(
            [
                'echarts',
                'echarts/chart/pie',
                'echarts/chart/funnel'
            ],
            function (ec) {            
                Window.Chart2 = ec.init(document.getElementById('basic-pie2'));                
                $(function () {
                    $(window).on('resize', resize);
                    $(".menu-toggle").on('click', resize);
                    function resize() {
                        setTimeout(function() {
                            Window.Chart2.resize();
                        }, 200);
                    }
                });
            }
        ); 
        var ChartLine2;
        require(
            [
                'echarts',
                'echarts/chart/bar',
                'echarts/chart/line'
            ],
            function (ec) {          
                Window.ChartLine2 = ec.init(document.getElementById('basic-line2'));                
                $(function () {
                    $(window).on('resize', resize);
                    $(".menu-toggle").on('click', resize);
                    function resize() {
                        setTimeout(function() {
                            Window.ChartLine2.resize();
                        }, 200);
                    }
                });
            }
        );                              
        get_status("msr_status");
    });
    function get_status(sel)
    {
        $.ajax({
            url:"<?= base_url("dashboard/msr/")?>"+sel,
            type:"POST",
            data:$('#process').serializeArray(),
            success:function(m){                
                setChart(m,sel);
            }
        });
    }
    function setChart(m,sel)
    {
        var dt=[];                
                var name=['','','','',''];                
                var pie=[0,0,0,0,0];
                var pie2=[0,0,0,0,0];
                var temp=[];
                var cnt=0;
                if(m != null)          
                {
                    arrlenght = m.length;
                    if(sel=="msr_status")
                    {
                        name[0]="Preparation";name[1]="Selection";
                        name[2]="Completed";name[3]="Signed";
                        name[4]="Canceled";
                    }
                    else if(sel=="msr_type"){
                        name[0]="Goods";name[1]="Service";
                        name[2]="Blanket";
                    }
                    else if(sel=="msr_method"){
                        name[0]="DA";name[1]="DS";
                        name[2]="TN";
                    }
                    m.map((i,index)=>{
                        temp=[];                      
                        pie[0]+=parseInt(i.name[0]);pie[1]+=parseInt(i.name[1]);
                        pie[2]+=parseInt(i.name[2]);pie[3]+=parseInt(i.name[3]);
                        pie[4]+=parseInt(i.name[4]);                        
                        temp[parseInt(i.period)]=pie[0];
                        if(index == 0)
                        {
                            temp[parseInt(i.period)]=parseInt(i.name[0]);
                            
                            dt.push({'name':name[0],
                                "markPoint" : {"data" : [
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'},
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'}]},
                                'type':'line',
                                'data':temp.splice(0)});
                            temp[parseInt(i.period)]=parseInt(i.name[1]);
                            dt.push({'name':name[1],
                                "markPoint" : {"data" : [
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'},
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'}]},
                                'type':'line',
                                'data':temp.splice(0)});
                            temp[parseInt(i.period)]=parseInt(i.name[2]);
                            dt.push({'name':name[2],
                                "markPoint" : {"data" : [
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'},
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'}]},
                                'type':'line',
                                'data':temp.splice(0)});
                            temp[parseInt(i.period)]=parseInt(i.name[3]);
                            dt.push({'name':name[3],
                                "markPoint" : {"data" : [
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'},
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'}]},
                                'type':'line',
                                'data':temp.splice(0)});
                            temp[parseInt(i.period)]=parseInt(i.name[4]);
                            dt.push({'name':name[4],
                                "markPoint" : {"data" : [
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'},
                                    {"type" : 'max', "name": 'Max'},{"type" : 'min', "name": 'Min'}]},
                                'type':'line',
                                'data':temp.splice(0)}); 
                            dt2=JSON.parse(JSON.stringify(dt));
                            dt2[0].data=[];dt2[1].data=[];
                            dt2[2].data=[];dt2[3].data=[];
                            dt2[4].data=[];
                            if(i.name[0]>=1){
                                pie2[0]+=parseInt(i.value[0]);
                                temp[parseInt(i.period)]=parseInt(i.value[0]);
                                dt2[0].data=temp.splice(0);
                            }                                        
                            if(i.name[1]>=1){
                                pie2[1]+=parseInt(i.value[1]);
                                temp[parseInt(i.period)]=parseInt(i.value[1]);
                                dt2[1].data=temp.splice(0);
                            }                                                            
                            if(i.name[2]>=1)
                            {
                                pie2[2]+=parseInt(i.value[2]);
                                temp[parseInt(i.period)]=parseInt(i.value[2]);
                                dt2[2].data=temp.splice(0);
                            }                                
                            if(i.name[3]>=1)
                            {
                                pie2[3]+=parseInt(i.value[3]);
                                temp[parseInt(i.period)]=parseInt(i.value[3]);
                                dt2[3].data=temp.splice(0);
                            }                                
                            if(i.name[4]>=1)
                            {
                                pie2[4]+=parseInt(i.value[4]);
                                temp[parseInt(i.period)]=parseInt(i.value[4]);
                                dt2[4].data=temp.splice(0);
                            }                                
                        }
                        else{
                            
                            dt[0].data[i.period]=parseInt(i.name[0]);
                            dt[1].data[i.period]=parseInt(i.name[1]);
                            dt[2].data[i.period]=parseInt(i.name[2]);
                            dt[3].data[i.period]=parseInt(i.name[3]);
                            dt[4].data[i.period]=parseInt(i.name[4]);
                            if(i.name[0]>=1)
                            {
                                pie2[0]+=parseInt(i.value[0]);
                                dt2[0].data[i.period]=parseInt(i.value[0]);
                            }
                            if(i.name[1]>=1)
                            {
                                pie2[1]+=parseInt(i.value[1]);
                                dt2[1].data[i.period]=parseInt(i.value[1]);
                            }
                            if(i.name[2]>=1)
                            {
                                pie2[2]+=parseInt(i.value[2]);
                                dt2[2].data[i.period]=parseInt(i.value[2]);
                            }
                            if(i.name[3]>=1)
                            {
                                pie2[3]+=parseInt(i.value[3]);
                                dt2[3].data[i.period]=parseInt(i.value[3]);
                            }
                            if(i.name[4]>=1)
                            {
                                pie2[4]+=parseInt(i.value[4]);
                                dt2[4].data[i.period]=parseInt(i.value[4]);
                            }
                        }
                    })
                }             
                
                pieOptions = {                
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },                
                color: ['#00A5A8', '#626E82', '#FF7D4D','#ffc107', '#16D39A'],                
                calculable: true,
                series: [{
                    name: 'MSR',
                    type: 'pie',
                    radius: '65%',
                    center: ['50%', '58.5%'],
                    data: [
                        {value: pie[0], name: name[0]},
                        {value: pie[1], name: name[1]},
                        {value: pie[2], name: name[2]},
                        {value: pie[3], name: name[3]},
                        {value: pie[4], name: name[4]}
                    ]
                }]                    
                };
                
                Window.Chart.setOption(pieOptions);    
                
                chartOptions = {            
                    grid: {
                        x: 40,x2: 20,
                        y: 35,y2: 25
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: [name[0],name[1],name[2],name[3],name[4]]
                    },
                    color: ['#F98E76', '#16D39A', '#2DCEE3', '#FF7588', '#626E82'],
                    calculable: true,
                    xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                        data: ['January', 'February', 'March', 'April', 'Mei', 'June', 'July','Agustus','September','October','November','December']
                    }],
                    yAxis: [{
                        type: 'value'
                    }],
                    series:dt
                };
                Window.ChartLine.setOption(chartOptions);                           
                
                pieOptions2 = {                
                tooltip: {
                    trigger: 'item',
                    formatter: "{a} <br/>{b}: {c} ({d}%)"
                },                
                color: ['#00A5A8', '#626E82', '#FF7D4D','#ffc107', '#16D39A'],                
                calculable: true,
                series: [{
                    name: 'MSR',
                    type: 'pie',
                    radius: '65%',
                    center: ['50%', '58.5%'],
                    data: [
                        {value: pie2[0], name: name[0]},
                        {value: pie2[1], name: name[1]},
                        {value: pie2[2], name: name[2]},
                        {value: pie2[3], name: name[3]},
                        {value: pie2[4], name: name[4]}
                    ]
                }]                    
                };
                
                Window.Chart2.setOption(pieOptions2);

                chartOptions = {            
                    grid: {
                        x: 40,x2: 20,
                        y: 35,y2: 25
                    },
                    tooltip: {
                        trigger: 'axis'
                    },
                    legend: {
                        data: [name[0],name[1],name[2],name[3],name[4]]
                    },
                    color: ['#F98E76', '#16D39A', '#2DCEE3', '#FF7588', '#626E82'],
                    calculable: true,
                    xAxis: [{
                        type: 'category',
                        boundaryGap: false,
                        data: ['January', 'February', 'March', 'April', 'Mei', 'June', 'July','Agustus','September','October','November','December']
                    }],
                    yAxis: [{
                        type: 'value'
                    }],
                    series:dt2
                };
                Window.ChartLine2.setOption(chartOptions);                           
    }
</script>