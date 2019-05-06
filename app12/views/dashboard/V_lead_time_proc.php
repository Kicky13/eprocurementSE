<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Lead Time Procurement Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Lead Time Procurement Dashboard</li>
            </ol>
        </div>
    </div>
</div>
<div class="content-body">
    <div class="row">
        <div class="col-md-12">
            <div id="dashboard-content" class="card" style="display: none;">
			    <div class="card-body steps">
			        <ul class="nav nav-tabs nav-top-border no-hover-bg ">
			            <li class="nav-item">
			                <a class="nav-link active" id="procurment-method-tab" data-toggle="tab" href="#procurment-method" aria-controls="stats" aria-expanded="true">Procurement Method</a>
			            </li>
			            <li class="nav-item">
			                <a class="nav-link" id="procurment-specialist-tab" data-toggle="tab" href="#procurment-specialist" aria-controls="detailspecial">Procurement Specialist</a>
			            </li>
			            <li class="nav-item">
			                <a class="nav-link" id="details-tab" data-toggle="tab" href="#details" aria-controls="details">Details</a>
			            </li>
			        </ul>
			        <div class="tab-content px-1 pt-1">
			            <div role="tabpanel " class="tab-pane active" id="procurment-method" aria-labelledby="procurment-method-tab" aria-expanded="false">
			                <div class="row">
			                    <div class="col-lg-6 col-md-12">
			                        <div id="lead-time-chart" class="height-400 echart-container"></div>
			                    </div>
			                    <div class="col-lg-6 col-md-12">
			                        <div style="margin: 0px 15px">
			                            <h4 class="dashboard-title">Lead Time <small>in Step Details</small></h4>
			                        </div>
			                        <table id="lead-time-step-details-table" class="table table-sm table-striped table-bordered"style="font-size: 12px;">
			                            <thead>
			                                <tr>
			                                    <th rowspan="2" style="line-height: 50px;">Procurement Steps</th>
			                                    <th colspan="3" class="text-center">Lead Time (in days)</th>
			                                </tr>
			                                <tr>
			                                    <th class="text-center">DA</th>
			                                    <th class="text-center">DS</th>
			                                    <th class="text-center">Tender</th>
			                                </tr>
			                            </thead>
			                            <tbody>
			                            </tbody>
			                        </table>
			                    </div>
			                    <div class="col-lg-12 col-md-12 row" style="padding-top:30px;border-top:1px solid #f1f1f1">
			                        <div class="col-md-4">
			                            <h4 style='text-align:center'>DA Lead Time - TREND</h4>
			                            <div id="lead-time-da-chart" class="height-300 echart-container"></div>
			                        </div>
			                        <div class="col-md-4">
			                            <h4 style='text-align:center'>DS Lead Time - TREND</h4>
			                            <div id="lead-time-ds-chart" class="height-300 echart-container"></div>
			                        </div>
			                        <div class="col-md-4">
			                            <h4 style='text-align:center'>TENDER Lead Time - TREND</h4>
			                            <div id="lead-time-tender-chart" class="height-300 echart-container"></div>
			                        </div>
			                    </div>
			                </div>
			            </div>
			            <div class="tab-pane" id="procurment-specialist" role="tabpanel" aria-labelledby="procurment-specialist-tab" aria-expanded="false">
			                <table id="procurment-specialist-table" class="table table-sm table-striped table-bordered" width="100%" style="font-size: 12px">
			                    <thead>
			                        <tr>
			                            <th>User</th>
			                            <th>Name</th>
			                            <th class="text-center">Avg Actual DA</th>
			                            <th class="text-center">(n) DA</th>
			                            <th class="text-center">Avg Actual DS</th>
			                            <th class="text-center">(n) DS</th>
			                            <th class="text-center">Avg Actual Tender</th>
			                            <th class="text-center">(n) Tender</th>
			                        </tr>
			                    </thead>
			                    <tbody>

			                    </tbody>
			                </table>
			            </div>
			            <div class="tab-pane" id="details" role="tabpanel" aria-labelledby="details-tab" aria-expanded="false">
                            <div class="form-group" style="padding-left:15px;">
                                <button type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export</button>
                            </div>
			                <table id="details-table" class="table table-striped table-bordered nowrap" style="font-size: 12px">
			                    <thead>
			                        <tr>
			                            <th rowspan="2" style="line-height: 50px;">Agreement No</th>
			                            <th colspan="12" class="text-center">Date of Transaction</th>
			                        </tr>
			                        <tr>
			                            <th class="text-center">Create</th>
			                            <th class="text-center">Approval Manager</th>
			                            <th class="text-center">Approval Inventory Control</th>
			                            <th class="text-center">Approval BSD Staff</th>
			                            <th class="text-center">Approval VP BSD</th>
			                            <th class="text-center">Approval AAS</th>
			                            <th class="text-center">Verification</th>
			                            <th class="text-center">Assignment</th>
			                            <th class="text-center">ED Issueance</th>
			                            <th class="text-center">BID Opening</th>
			                            <th class="text-center">Awarding</th>
			                            <th class="text-center">Agreement</th>
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

    var initiatedProcurementMethod = false;
    var leadTimeChart;
    var leadTimeDaChart;
    var leadTimeDsChart;
    var leadTimeTenderChart;
    var procurementMethodGeneralOption = {
        step : ['MSR Realease', 'MSR Verification', 'MSR Assignment', 'ED Issuance', 'BID Opening', 'Awarding', 'Agreement', 'Procurement Lead Time', 'All Cycle', 'KPI'],
        legend : ['Procurement Lead Time', 'All Cycle', 'KPI'],
        color : globalChartOption.color
    }
    var procurementMethodData = {};

    var leadTimeStepDetailsTable;
    var procurementSpecialistTable;
    var detailsTable;

    $(function() {
        $('#btn-process').click(function() {
        	$('#dashboard-content').show();
        	currentFilterContent();
            getProcurementMethod();
            if (typeof(procurementSpecialistTable) == 'undefined') {
            	procurementSpecialistTable = $('#procurment-specialist-table').DataTable({
		            serverSide: true,
		            processing: true,
		            ajax: '<?= base_url('dashboard/lead_time_procurement/get_procurement_specialists') ?>?'+$('[name*="filter"]').serialize(),
		            columns : [
		                {data:'USERNAME'},
		                {data:'NAME'},
		                {data:'da_days', class:'text-center'},
		                {data:'da', class:'text-center'},
		                {data:'ds_days', class:'text-center'},
		                {data:'ds', class:'text-center'},
		                {data:'tender_days', class:'text-center'},
		                {data:'tender', class:'text-center'}
		            ],
		            paging: false,
		            searching: false,
		            info: false
		        });
            } else {
            	procurementSpecialistTable.ajax.url('<?= base_url('dashboard/lead_time_procurement/get_procurement_specialists') ?>?'+$('[name*="filter"]').serialize()).load();
            }

            if (typeof(detailsTable) == 'undefined') {
		        detailsTable = $('#details-table').DataTable({
		            serverSide: true,
		            processing: true,
		            ajax: '<?= base_url('dashboard/lead_time_procurement/get_details') ?>?'+$('[name*="filter"]').serialize(),
		            columns: [
		                {data:'po_no'},
		                {data:'create_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'approval_manager_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'inventory_control_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'approval_bsd_staff_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'approval_vp_bsd_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'approval_aas_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'verification_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'assignment_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'ed_issuance_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'bid_opening_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'awarding_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }},
		                {data:'agreement_date', render:function(data) {
		                    return Localization.humanDate(data);
		                }}
		            ],
		            paging: false,
		            searching: false,
		            scrollX: true,
		            scrollY: '400px',
		            scrollCollapse: true,
		            info: false
		        });
		    } else {
            	detailsTable.ajax.url('<?= base_url('dashboard/lead_time_procurement/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
            }
        });

        $('#procurment-method-tab').click(function() {
            setTimeout(function() {
                loadProcurementMethod();
            }, 200);
        });

        $('#procurment-specialist-tab').click(function() {
            setTimeout(function() {
                procurementSpecialistTable.columns.adjust();
            }, 200);
        });

        $('#details-tab').click(function() {
            setTimeout(function() {
                detailsTable.columns.adjust();
            }, 200);
        });

        require.config({
            paths : {echarts: '<?= base_url()?>ast11/app-assets/vendors/js/charts/echarts'}
        });

        require([
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line',
        ], function(ec) {
            echarts = ec;
            $('#btn-process').prop('disabled', false);
            //loadProcurementMethod();
        });
    });

    function currentFilterContent() {
        var currentFilterContentHtml = '';
        currentFilterContentHtml += renderCurrentFilterContent('company', 'Company');
        currentFilterContentHtml += renderCurrentFilterContent('department', 'Department');
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

    function initProcurementMethod() {
        leadTimeChart = echarts.init(document.getElementById('lead-time-chart'));
        leadTimeDaChart = echarts.init(document.getElementById('lead-time-da-chart'));
        leadTimeDsChart = echarts.init(document.getElementById('lead-time-ds-chart'));
        leadTimeTenderChart = echarts.init(document.getElementById('lead-time-tender-chart'));
        if (!initiatedProcurementMethod) {
            function resize() {
                setTimeout(function() {
                    leadTimeChart.resize();
                    leadTimeDaChart.resize();
                    leadTimeDsChart.resize();
                    leadTimeTenderChart.resize();
                }, 200);
            }
            $(window).on('resize', resize);
            $(".menu-toggle").on('click', resize);
            initiatedProcurementMethod = true;
        }
    }

    function loadProcurementMethod() {
    	$('#procurement_method-content').show();
    	var response = procurementMethodData;
    	initProcurementMethod();
        var leadTimeData = [];
        $.each(procurementMethodGeneralOption.legend, function(i, name) {
            leadTimeData[i] = {
                name : name,
                type : 'bar',
                data : []
            }
            $.each(response.procurement_methods, function(j, method) {
                if (response.data.lead_time[name]) {
                    if (response.data.lead_time[name][method]) {
                        leadTimeData[i].data[j] = response.data.lead_time[name][method].days;
                    } else {
                        leadTimeData[i].data[j] = 0;
                    }
                } else {
                    leadTimeData[i].data[j] = 0;
                }
            });
        });
        var leadTimeChartOption = {
            title: {
                text: 'Lead Time',
                subtext: 'by Procurement Method',
                x: 'center'
            },
            tooltip: {
                trigger: 'axis'
            },
            legend: {
                data: procurementMethodGeneralOption.legend,
                y: 60
            },
            xAxis: [
                {
                    type: 'category',
                    data: response.procurement_methods
                }
            ],
            yAxis: [
                {type: 'value'}
            ],
            grid: {
                x: 25, y: 80,
                x2: 25
            },
            color: procurementMethodGeneralOption.color,
            series: leadTimeData
        };
        leadTimeChart.setOption(leadTimeChartOption);
        var html = '';
        $.each(procurementMethodGeneralOption.step, function(i, step) {
            $.each(procurementMethodGeneralOption.legend, function(i, name) {
                if (step == name) {
                    html += '<tr style="background-color:'+procurementMethodGeneralOption.color[i]+';">';
                    return false;
                } else {
                    html += '<tr>';
                }
            });
            html += '<td>'+step+'</td>';
            $.each(response.procurement_methods, function(i, method) {
                if (response.data.lead_time[step]) {
                    if (response.data.lead_time[step][method]) {
                        html += '<td class="text-center">'+response.data.lead_time[step][method].days+'</td>';
                    } else {
                        html += '<td class="text-center">0</td>';
                    }
                } else {
                    html += '<td class="text-center">0</td>';
                }
            });
            html += '</tr>';
        });
        $('#lead-time-step-details-table tbody').html(html);
        var periode = [];
        $.each(response.periode, function(key, row) {
            periode[key] = Localization.humanDate(row, '{Y} {m}');
        });
        var leadTimeDaData = [];
        var leadTimeDsData = [];
        var leadTimeTenderData = [];
        $.each(procurementMethodGeneralOption.legend, function(i, name) {
            leadTimeDaData[i] = {
                name : name,
                type : 'line',
                data : []
            }
            leadTimeDsData[i] = {
                name : name,
                type : 'line',
                data : []
            }
            leadTimeTenderData[i] = {
                name : name,
                type : 'line',
                data : []
            }
            $.each(response.periode, function(j, month) {
                if (response.data.lead_time_trend[name]) {
                    if (response.data.lead_time_trend[name]['DA']) {
                        if (response.data.lead_time_trend[name]['DA'][month]) {
                            leadTimeDaData[i].data[j] = response.data.lead_time_trend[name]['DA'][month].days;
                        } else {
                            leadTimeDaData[i].data[j] = 0;
                        }
                    } else {
                        leadTimeDaData[i].data[j] = 0;
                    }

                    if (response.data.lead_time_trend[name]['DS']) {
                        if (response.data.lead_time_trend[name]['DS'][month]) {
                            leadTimeDsData[i].data[j] = response.data.lead_time_trend[name]['DS'][month].days;
                        } else {
                            leadTimeDsData[i].data[j] = 0;
                        }
                    } else {
                        leadTimeDsData[i].data[j] = 0;
                    }

                    if (response.data.lead_time_trend[name]['TN']) {
                        if (response.data.lead_time_trend[name]['TN'][month]) {
                            leadTimeTenderData[i].data[j] = response.data.lead_time_trend[name]['TN'][month].days;
                        } else {
                            leadTimeTenderData[i].data[j] = 0;
                        }
                    } else {
                        leadTimeTenderData[i].data[j] = 0;
                    }
                } else {
                    leadTimeDaData[i].data[j] = 0;
                    leadTimeDsData[i].data[j] = 0;
                    leadTimeTenderData[i].data[j] = 0;
                }
            });
        });

        var leadTimeDaChartOption = {
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:procurementMethodGeneralOption.legend
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
                }
            ],
            grid: {
                x: 25, x2: 10
            },
            color: procurementMethodGeneralOption.color,
            series: leadTimeDaData
        }

        leadTimeDaChart.setOption(leadTimeDaChartOption);

        var leadTimeDsChartOption = {
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:procurementMethodGeneralOption.legend
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
                }
            ],
            grid: {
                x: 25, x2: 10
            },
            color: procurementMethodGeneralOption.color,
            series: leadTimeDsData
        }

        leadTimeDsChart.setOption(leadTimeDsChartOption);

        var leadTimeTenderChartOption = {
            tooltip : {
                trigger: 'axis'
            },
            legend: {
                data:procurementMethodGeneralOption.legend
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
                }
            ],
            grid: {
                x: 25, x2: 10
            },
            color: procurementMethodGeneralOption.color,
            series: leadTimeTenderData
        }

        leadTimeTenderChart.setOption(leadTimeTenderChartOption);
    }

    function getProcurementMethod() {
    	start($('#dashboard-content'));
        $.ajax({
            url : '<?= base_url('dashboard/lead_time_procurement/get_procurement_method') ?>?',
            type : 'post',
            dataType : 'json',
            data : $('[name*="filter"]').serialize(),
            success : function(response) {
            	procurementMethodData = response;
            	loadProcurementMethod();
            	stop($('#dashboard-content'));
            }
        });
    }
</script>