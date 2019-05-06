<?php $this->load->view('dashboard/partials/current_filter') ?>
<div class="content-header row" style="margin-top: 220px;">
    <div class="content-header-left col-md-6 col-12 mb-1">
        <h3 class="content-header-title">Budget Spending Dashboard</h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="<?= base_url('dashboard/home') ?>">Home</a></li>
                <li class="breadcrumb-item">Budget Spending Dashboard</li>
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
			            <div role="tabpanel " class="tab-pane active" id="procurment-method" aria-labelledby="procurment-method-tab" aria-expanded="false">
			                <div class="row">
			                    <div class="col-lg-12 col-md-12">
			                        <div id="budget-spending-chart" class="height-400 echart-container"></div>
			                    </div>
                          <div class="col-lg-12 col-md-12">
                              <!-- <div class="form-group" style="padding-left:15px;">
                                  <button type="button" onclick="window.print()" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Print</button>
                              </div> -->
        			                <table id="details-table" class="table table-striped table-condensed table-bordered table-hover display nowrap" style="font-size: 12px">
        			                    <thead>
        			                        <tr>
        			                            <th rowspan="2" style="line-height: 50px;">Company</th>
        			                            <th rowspan="2" style="line-height: 50px;">Department</th>
        			                            <th rowspan="2" style="line-height: 50px;">Cost-Center</th>
        			                            <th rowspan="2" style="line-height: 50px;">Subsidiary Account</th>
        			                            <th colspan="5" class="text-center">Budget Analysis</th>
        			                        </tr>
        			                        <tr>
        			                            <th class="text-center">Approved</th>
        			                            <th class="text-center">Allocated</th>
        			                            <th class="text-center">Payable</th>
        			                            <th class="text-center">Paid</th>
        			                            <th class="text-center">Remaining (Approved - Allocated)</th>
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

    var initiatedProcurementMethod = false;
    var budgetSpending;
    var procurementMethodGeneralOption = {
        step : ['Approved', 'Allocated', 'Remaining'],
        legend : ['Approved', 'Allocated', 'Remaining'],
        color : globalChartOption.color
    }
    var procurementMethodData = {};

    var budgetsStepDetailsTable;
    var procurementSpecialistTable;
    var detailsTable;

    $(function() {
        $('#btn-process').click(function() {
        	$('#dashboard-content').show();
        	currentFilterContent();
            getBudgetSpending();

            if (typeof(detailsTable) == 'undefined') {
		        detailsTable = $('#details-table').DataTable({
		            serverSide: true,
		            processing: true,
		            // responsive: true,
		            ajax: '<?= base_url('dashboard/budget_spending/get_details') ?>?'+$('[name*="filter"]').serialize(),
		            columns: [
		                {data:'company'},
		                {data:'DEPARTMENT_DESC'},
		                {data:'id_costcenter'},
		                {data:'id_accsub'},
		                {data:'value2', render:function(data) {
		                    return Localization.number(data);
		                }, class: 'text-right'},
		                {data:'value', render:function(data) {
		                    return Localization.number(data);
		                }, class: 'text-right'},
		                {data:'payable', render:function(data) {
		                    return Localization.number(data);
		                }, class: 'text-right'},
		                {data:'paid', render:function(data) {
		                    return Localization.number(data);
		                }, class: 'text-right'},
		                {data:'remaining', render:function(data) {
		                    return Localization.number(data);
		                }, class: 'text-right'},
		            ],
		            paging: false,
		            searching: false,
                scrollX: true,
                scrollY: '300px',
                scrollCollapse: true,
		            info: false,
                dom: 'Bfrtip',
                buttons: [
                    // 'copy',
                    // 'csv',
                    // 'excel',
                    // 'pdf',
                    'print',
                ],
		        });
  		    } else {
              	detailsTable.ajax.url('<?= base_url('dashboard/budget_spending/get_details') ?>?'+$('[name*="filter"]').serialize()).load();
          }
          detailsTable.columns.adjust();

        });

        $('#procurment-method-tab').click(function() {
            setTimeout(function() {
                loadProcurementMethod();
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
        });
    });

    function currentFilterContent() {
        var currentFilterContentHtml = '';
        currentFilterContentHtml += renderCurrentFilterContent('company', 'Company');
        currentFilterContentHtml += renderCurrentFilterContent('department', 'Department');
        currentFilterContentHtml += renderCurrentFilterContent('costcenter', 'Costcenter');
        currentFilterContentHtml += renderCurrentFilterContent('subsidiary_account', 'Subsidiary Account');
        currentFilterContentHtml += renderCurrentFilterContent('years', 'Years');
        currentFilterContentHtml += renderCurrentFilterContent('months', 'Months');
        if (currentFilterContentHtml == '') {
            currentFilterContentHtml = 'Data not filtered';
        }
        $('#current-filter-content').html(currentFilterContentHtml);
    }

    function initProcurementMethod() {
        budgetSpending = echarts.init(document.getElementById('budget-spending-chart'));
        if (!initiatedProcurementMethod) {
            function resize() {
                setTimeout(function() {
                    budgetSpending.resize();
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
        var budgetsData = [];
        $.each(procurementMethodGeneralOption.legend, function(i, name) {
            budgetsData[i] = {
                name : name,
                type : 'bar',
                data : []
            }
            $.each(response.procurement_methods, function(j, method) {
                if (response.data.budget_spending[name]) {
                    if (response.data.budget_spending[name][method]) {
                        budgetsData[i].data[j] = response.data.budget_spending[name][method];
                    } else {
                        budgetsData[i].data[j] = 0;
                    }
                } else {
                    budgetsData[i].data[j] = 0;
                }
            });
        });
        var budgetSpendingOption = {
            title: {
                text: 'Budget Spending',
                subtext: 'by Company',
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
            series: budgetsData
        };
        budgetSpending.setOption(budgetSpendingOption);
        var html = '';

        var periode = [];
        $.each(response.periode, function(key, row) {
            periode[key] = Localization.humanDate(row, '{Y} {m}');
        });
        var budgetsDaData = [];
        var budgetsDsData = [];
        var budgetsTenderData = [];
        $.each(procurementMethodGeneralOption.legend, function(i, name) {
            budgetsDaData[i] = {
                name : name,
                type : 'line',
                data : []
            }
            budgetsDsData[i] = {
                name : name,
                type : 'line',
                data : []
            }
            budgetsTenderData[i] = {
                name : name,
                type : 'line',
                data : []
            }
            $.each(response.periode, function(j, month) {
                if (response.data.budget_spending_trend[name]) {
                    if (response.data.budget_spending_trend[name]['SEML']) {
                        if (response.data.budget_spending_trend[name]['SEML'][month]) {
                            budgetsDaData[i].data[j] = response.data.budget_spending_trend[name]['SEML'][month];
                        } else {
                            budgetsDaData[i].data[j] = 0;
                        }
                    } else {
                        budgetsDaData[i].data[j] = 0;
                    }

                    if (response.data.budget_spending_trend[name]['SERB']) {
                        if (response.data.budget_spending_trend[name]['SERB'][month]) {
                            budgetsDsData[i].data[j] = response.data.budget_spending_trend[name]['SERB'][month];
                        } else {
                            budgetsDsData[i].data[j] = 0;
                        }
                    } else {
                        budgetsDsData[i].data[j] = 0;
                    }

                    if (response.data.budget_spending_trend[name]['SERD']) {
                        if (response.data.budget_spending_trend[name]['SERD'][month]) {
                            budgetsTenderData[i].data[j] = response.data.budget_spending_trend[name]['SERD'][month];
                        } else {
                            budgetsTenderData[i].data[j] = 0;
                        }
                    } else {
                        budgetsTenderData[i].data[j] = 0;
                    }
                } else {
                    budgetsDaData[i].data[j] = 0;
                    budgetsDsData[i].data[j] = 0;
                    budgetsTenderData[i].data[j] = 0;
                }
            });
        });
    }

    function getBudgetSpending() {
    	start($('#dashboard-content'));
        $.ajax({
            url : '<?= base_url('dashboard/Budget_spending/get') ?>?',
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
