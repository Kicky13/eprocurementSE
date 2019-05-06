<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom-dashboard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/fonts/feather/style.min.css">
<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row">
		<div class="content-header-left col-md-6 col-12 mb-1">
		  <h3 class="content-header-title">Procurement Saving Dashboard</h3>
	    </div>
    </div>
    <div class="content-detached">        
        <div class="content-body" id="main-content">
            <section>
                <div class="row match-height card-columns">
					<div class="col-xl-12">
					  <div class="card">
						<div class="card-header" >
						  <h4 class="card-title">Current Filter</h4>
						  <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
						  <div class="heading-elements">
							<ul class="list-inline mb-0">
							  <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
							</ul>
						  </div>
						</div>
						<div class="card-content collapse show" style="">
						  <div class="card-body">
							<div class="row">
							  <div class="col-xl-2">
								<div class="label-current-filter">Company</div> 
									<span class="current-filter">Supreme Energy Muara Laboh </span>
							  </div>  
							  <div class="col-xl-1">
								<div class="label-current-filter">MSR Type</div> 
									<span class="current-filter">MSR Goods</span>  
							  </div>
							  <div class="col-xl-2">
								<div class="label-current-filter">Procurement Method</div>  
									<span class="current-filter">Direct Appointment</span>
							  </div>
							  <div class="col-xl-2">
								<div class="label-current-filter">Procurement Specialist</div>  
									<span class="current-filter">100077 - DEMAS SETO ARDHIWIRAWAN</span>
							  </div>
							  <div class="col-xl-1">
								<div class="label-current-filter">Year</div> 
									<span class="current-filter">2017</span> 
									<span class="current-filter">2016</span> 
							  
							  </div>
							  <div class="col-xl-1">
								<div class="label-current-filter">Month</div>  
							  
							  </div>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				</div>
				<div class="row match-height card-columns">
					<div class="col-xl-2 col-md-6 col-sm-12 ">
					  <div class="card filter-card"  >
						<div class="card-content">  
						  <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
							<div class="card collapse-icon panel mb-0 box-shadow-0 border-0">
							  <div id="heading11" role="tab" class="card-header border-bottom-lighten-2 " style="padding-bottom: 0px;">
								<h4 class="card-title">Filter</h4> 
							  </div>
							  <div id="heading11" role="tab" class="card-header">
								<button type="submit" id="btn-process" class="col-md-12 btn btn-sm btn-success" style="margin-bottom:10px;">Process</button>
								<button type="submit" id="btn-primary" class="col-md-12 btn btn-sm btn-primary">Clear Selection</button>
							  </div> 
							  <span class="checkbox-list" >
								  <div id="heading1" role="tab" class="card-header checkbox-item-list">
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion1" aria-expanded="false" aria-controls="accordion1" class="h6  collapsed"><?= lang("Perusahaan","Company")?></a>
								  </div> 
								  <div id="accordion1" role="tabpanel" aria-labelledby="heading1" class="card-collapse collapse" aria-expanded="false" style="height: 0px;"> 
											<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
											</label> 
										<?php foreach ($this->m_dashboard->get_company() as $company) { ?> 
											<label class="custom-control ">
												<input type="checkbox" id="company" name="filter[company][]" value="<?= $company->ID_COMPANY ?>"  > 
												<span class="checkbox-label"><?= $company->DESCRIPTION ?></span>
											</label> 
										<?php } ?>  
								  </div>
							  </span>     
							  <span class="checkbox-list" >
								  <div id="heading4" role="tab" class="card-header checkbox-item-list">
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion4" aria-expanded="false" aria-controls="accordion4" class="h6  collapsed"><?= lang("Type MSR","MSR Type")?></a>
								  </div> 
								  <div id="accordion4" role="tabpanel" aria-labelledby="heading4" class="card-collapse collapse" aria-expanded="false" style="height: 0px;"> 
											<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
											</label>
										<?php foreach ($this->m_dashboard->get_msr_type() as $type_msr) { ?> 
											<label class="custom-control ">
												<input type="checkbox" id="type" name="filter[type][]" value="<?= $type_msr->ID_MSR ?>"  > 
												<span class="checkbox-label"><?= $type_msr->MSR_DESC ?></span>
											</label> 
										<?php } ?>  
								  </div>
							  </span>
							  <span class="checkbox-list" >
								  <div id="heading5" role="tab" class="card-header checkbox-item-list">
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion5" aria-expanded="false" aria-controls="accordion5" class="h6  collapsed"><?= lang("Metode Procurement","Procurement Method")?></a>
								  </div> 
								  <div id="accordion5" role="tabpanel" aria-labelledby="heading5" class="card-collapse collapse" aria-expanded="false" style="height: 0px;"> 
											<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
											</label>
										<?php foreach ($this->m_dashboard->get_procurement_method() as $procurement_method) { ?> 
											<label class="custom-control ">
												<input type="checkbox" id="method" name="filter[method][]" value="<?= $procurement_method->ID_PMETHOD ?>"  > 
												<span class="checkbox-label"><?= $procurement_method->PMETHOD_DESC ?></span>
											</label> 
										<?php } ?>  
								  </div>
							  </span> 
							  <span class="checkbox-list" >
								  <div id="heading6" role="tab" class="card-header checkbox-item-list">
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion6" aria-expanded="false" aria-controls="accordion6" class="h6  collapsed"><?= lang("Procurement Specialist","Procurement Specialist")?></a>
								  </div> 
								  <div id="accordion6" role="tabpanel" aria-labelledby="heading6" class="card-collapse collapse" aria-expanded="false" style="height: 0px;"> 
											<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
											</label>
										<?php foreach ($this->m_dashboard->get_procurement_specialist() as $procurement_specialist) { ?> 
											<label class="custom-control ">
												<input type="checkbox" id="specialist" name="filter[specialist][]" value="<?= $procurement_specialist->ID_USER ?>"  > 
												<span class="checkbox-label"><?= $procurement_specialist->USERNAME ?> - <?= $procurement_specialist->NAME ?></span>
											</label> 
										<?php } ?>  
								  </div>
							  </span>
							  <span class="checkbox-list year-month-list" >
								  <div id="heading7" role="tab" class="card-header checkbox-item-list">
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion7" aria-expanded="false" aria-controls="accordion7" class="h6  collapsed">Year</a>
								  </div> 
								  <div id="accordion7" role="tabpanel" aria-labelledby="heading7" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">  
										<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
										</label>
										<label class="custom-control ">
											<?php for($i = 1970; $i<=date('Y'); $i++) { ?>
												<input type="checkbox" value="<?= $i ?>" name="filter[years][]" <?= ($i==date('Y')) ? 'checked' : '' ?>> <?= $i ?><br>
											<?php } ?>  
										</label>  
								  </div>
							  </span>
							  <span class="checkbox-list year-month-list" >
								  <div id="heading8" role="tab" class="card-header checkbox-item-list">
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion8" aria-expanded="false" aria-controls="accordion8" class="h6  collapsed"><?= lang("Bulan","Months")?></a>
								  </div> 
								  <div id="accordion8" role="tabpanel" aria-labelledby="heading8" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">  
										<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
										</label>
										<label class="custom-control ">
											<input type="checkbox" value="01" name="filter[months][]" checked> Jan <br>
											<input type="checkbox" value="02" name="filter[months][]" checked> Feb <br>
											<input type="checkbox" value="03" name="filter[months][]" checked> Mar <br>
											<input type="checkbox" value="04" name="filter[months][]" checked> Apr <br>
											<input type="checkbox" value="05" name="filter[months][]" checked> May <br>
											<input type="checkbox" value="06" name="filter[months][]" checked> Jun <br>
											<input type="checkbox" value="07" name="filter[months][]" checked> Jul <br>
											<input type="checkbox" value="08" name="filter[months][]" checked> Aug <br>
											<input type="checkbox" value="09" name="filter[months][]" checked> Sep <br>
											<input type="checkbox" value="10" name="filter[months][]" checked> Oct <br>
											<input type="checkbox" value="11" name="filter[months][]" checked> Nov <br> 
											<input type="checkbox" value="12" name="filter[months][]" checked> Dec <br>
										</label>  
								  </div>
							  </span>
							</div>
						  </div>
						</div>
					  </div>
					</div> 
					<div class="col-xl-10 col-md-6 col-sm-12">
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
															<td valign="top">Total value of msr</td>                            
															<td class="text-right">
																<span data-model="currency"></span>
																<span data-model="msr_value"></span>
															</td>
														</tr>
														<tr>
															<td valign="top">Total value of agreement</td>                            
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
															<td valign="top">Total value of msr</td>                            
															<td class="text-right">
																<span data-model="currency"></span>
																<span data-model="msr_value"></span>
															</td>
														</tr>
														<tr>
															<td valign="top">Total value of agreement</td>                            
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
									<table id="details-table" class="table table-striped table-bordered table-hover table-no-wrap display text-center" style="font-size: 12px">
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
            </section>
        </div>        
    </div>
</div>
</div>
<script>

    var echarts;

    var initiatedComparisons = false;
    var agreementComparedToMsrChart;
    var agreementComparedToMsrTrendChart;
    var agreementComparedToProposalChart;
    var agreementComparedToProposalTrendChart;
    var detailsTable;

    $(function() {
        $('#btn-process').click(function() {     
            loadComparisons();
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
            loadComparisons();
        });

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
    });

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
        $.ajax({
            url : '<?= base_url('dashboard/procurement_saving/get_agreement_msr_procurement_saving') ?>',
            type : 'post',
            data : $('[name*="filter"]').serialize(),
            dataType : 'json',
            success : function(response) {
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
                                return (100 - params.value) + '%';
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
                                return (100 - params.value) + '%';
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
        });
    }        
/*$(document).ready(function () 
{       
    var pos='' ;
    $('#detailspecialist-tab1').click(function(){
        Window.pos='msr_specialist';        
    });
    $('#details-tab1').click(function(){
        Window.pos='process';       
    });
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
            var myChart = ec.init(document.getElementById('multiple-doughnut'));
            var labelTop = {
                normal: {
                    color: '#20A464',
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
            var radius = [60, 75];            
            chartOptions = {    
                title: {
                    text: 'Agreement Compared to MSR',
                    subtext: 'By Saving Value',
                    x: 'center'
                },                         
                color: ['#20A464', '#20A464'],
                series: [
                    {
                        type: 'pie',
                        center: ['15%', '40%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 46, itemStyle: labelBottom},
                            {name: 'Agreement', value: 54,itemStyle: labelTop}
                        ]
                    },
                    
                ]
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
            'echarts/chart/pie',
            'echarts/chart/funnel'
        ],
        function (ec) {          
            var myChart = ec.init(document.getElementById('multiple-doughnut2'));
            var labelTop = {
                normal: {
                    color: '#20A464',
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
            var radius = [60, 75];            
            chartOptions = {    
                title: {
                    text: 'Agreement Compared to Proposal',
                    subtext: 'By Saving Value',
                    x: 'center'
                },                         
                color: ['#20A464', '#20A464'],
                series: [
                    {
                        type: 'pie',
                        center: ['15%', '40%'],
                        radius: radius,
                        itemStyle: labelFromatter,
                        data: [
                            {name: 'other', value: 46, itemStyle: labelBottom},
                            {name: 'Agreement', value: 54,itemStyle: labelTop}
                        ]
                    },
                    
                ]
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
            var myChart = ec.init(document.getElementById('basic-line'));
            chartOptions = {
                title: {
                    text: 'Agreement Compared to MSR - Trend',
                    subtext: 'By Saving Value, Monthly',
                    x: 'center'
                }, 
                grid: {
                    x: 40,
                    x2: 40,
                    y: 80,
                    y2: 25
                },
                tooltip : {
                    trigger: 'axis'
                },
                color: ['#20A464'],
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data : ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLabel : {
                            formatter: '{value}'
                        }
                    }
                ],
                series : [
                    {
                        name:'Agreement',
                        type:'line',
                        data:[11, 11, 15, 13, 12, 13, 10],
                        markPoint : {
                            data : [
                                {type : 'max', name: 'Max'},
                                {type : 'min', name: 'Min'}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name: 'Average'}
                            ]
                        }
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
      // -------------------- Line 2 ------------------    
    require(
        [
            'echarts',
            'echarts/chart/bar',
            'echarts/chart/line'
        ],
        function (ec) {          
            var myChart = ec.init(document.getElementById('basic-line2'));
            chartOptions = {
                title: {
                    text: 'Agreement Compared to Proposal - Trend',
                    subtext: 'By Saving Value, Monthly',
                    x: 'center'
                }, 
                grid: {
                    x: 40,
                    x2: 40,
                    y: 80,
                    y2: 25
                },
                tooltip : {
                    trigger: 'axis'
                },
                color: ['#20A464'],
                calculable : true,
                xAxis : [
                    {
                        type : 'category',
                        boundaryGap : false,
                        data : ['Mon','Tue','Wed','Thu','Fri','Sat','Sun']
                    }
                ],
                yAxis : [
                    {
                        type : 'value',
                        axisLabel : {
                            formatter: '{value}'
                        }
                    }
                ],
                series : [
                    {
                        name:'Agreement',
                        type:'line',
                        data:[11, 11, 15, 13, 12, 13, 10],
                        markPoint : {
                            data : [
                                {type : 'max', name: 'Max'},
                                {type : 'min', name: 'Min'}
                            ]
                        },
                        markLine : {
                            data : [
                                {type : 'average', name: 'Average'}
                            ]
                        }
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
    tableSet();
});   
function tableSet()
{     
    var tabel = $('#list').DataTable({            
        "scrollX": true,
        "selected": true,
        "scrollY": "300px",
        "scrollCollapse": true,
        "paging": false,        
        "columns": [            
            {title:"No"},
            {title:"<?= lang("No MSR", "MSR No") ?>"},
            {title:"<?= lang("Tanggal MSR", "MSR Date") ?>"},
            {title:"<?= lang("Deskripsi unit", "Description of Units") ?>"},
            {title:"<?= lang("Grup", "Group/Category") ?>"},
            {title:"<?= lang("Sub Grup", "Sub Group/Sub Category") ?>"},            
            {title:"<?= lang("Jumlah", "Qty") ?>"},                        
            {title:"<?= lang("Uom", "UoM") ?>"},
            {title:"<?= lang("Estimasi Harga unit", "Estimate Unit Price") ?>"},
            {title:"<?= lang("Estimasi Harga Total", "Estimate Total Value") ?>"},
            {title:"<?= lang("Mata Uang", "Currency") ?>"},
            {title:"<?= lang("Importation", "Importation") ?>"},
            {title:"<?= lang("Cost Center", "Cost Center") ?>"},
            {title:"<?= lang("Akun Subsdiary", "Account Subsidiary") ?>"},
            {title:"<?= lang("Perusahaan", "Company") ?>"},
            {title:"<?= lang("Departemen", "Department") ?>"},
            {title:"<?= lang("Status MSR", "MSR Status") ?>"},
            {title:"<?= lang("Tipe MSR", "MSR Type") ?>"},
            {title:"<?= lang("Judul", "Title") ?>"},
            {title:"<?= lang("Tanggal MSR", "MSR Date") ?>"},
            {title:"<?= lang("Tanggal Dibutuhkan", "Required Date") ?>"},
            {title:"<?= lang("Lokasi Procurement", "Procurement Location") ?>"},
            {title:"<?= lang("Metode Procurement ", "Procurement Method") ?>"},
            {title:"<?= lang("Tujuan Pengiriman", "Delivery Point") ?>"},
            {title:"<?= lang("Permintaan Untuk", "Request For") ?>"},
            {title:"<?= lang("Klausul Pengiriman", "Delivery Term") ?>"},
            {title:"<?= lang("Inspeksi", "Inspections") ?>"},
            {title:"<?= lang("Barang", "Freight") ?>"},
            
        ],
        "columnDefs": [
            {"className": "text-center", "width":"1px", "targets": [0]},
            {"width":"200px", "targets": [1]},
            {"className": "text-right", "targets": [8]},
            {"className": "text-right", "targets": [9]},
        ] 
        });
    }*/
</script>