<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/datetime/bootstrap-datetimepicker.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom-dashboard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/fonts/feather/style.min.css">

<div class="app-content content">
<div class="content-wrapper">
    <div class="content-header row"> 
		<div class="content-header-left col-md-6 col-12 mb-1">
		  <h3 class="content-header-title">Supplier Performance Dashboard</h3>
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
								<div class="label-current-filter">Supplier Rating</div> 
									<span class="current-filter">Good</span>
							  </div> 
							  <div class="col-xl-2">
								<div class="label-current-filter">Supplier Category</div> 
									<span class="current-filter">Penyedia Jasa</span> 
							  </div>
							  <div class="col-xl-1">
								<div class="label-current-filter">SLK No</div> 
									<span class="current-filter">PT SENTOSA</span>
									<span class="current-filter">Selection</span>
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
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion1" aria-expanded="false" aria-controls="accordion1" class="h6  collapsed">Supplier Rating</a>
								  </div> 
								  <div id="accordion1" role="tabpanel" aria-labelledby="heading1" class="card-collapse collapse" aria-expanded="false" style="height: 0px;"> 
											<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
											</label> 
										<?php foreach ($this->m_dashboard->get_supplier_rating() as $supplier_rating) { ?> 
											<label class="custom-control ">
												<input type="checkbox" id="rating" name="filter[rating][]" tabindex="2" value="<?= $supplier_rating->id ?>"  > 
												<span class="checkbox-label"><?= $supplier_rating->description ?></span>
											</label> 
										<?php } ?>  
								  </div>
							  </span> 
							  <span class="checkbox-list" >
								  <div id="heading2" role="tab" class="card-header checkbox-item-list">
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion2" aria-expanded="false" aria-controls="accordion2" class="h6  collapsed">Supplier Category</a>
								  </div> 
								  <div id="accordion2" role="tabpanel" aria-labelledby="heading2" class="card-collapse collapse" aria-expanded="false" style="height: 0px;"> 
											<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
											</label>
										<?php foreach ($this->m_dashboard->get_supplier_classification() as $supplier_classification) { ?> 
											<label class="custom-control ">
												<input type="checkbox" id="classification" name="filter[classification][]" tabindex="2" value="<?= $supplier_classification->DESCRIPTION ?>"  > 
												<span class="checkbox-label"><?= $supplier_classification->DESCRIPTION ?></span>
											</label> 
										<?php } ?>  
								  </div>
							  </span>  
							  <span class="checkbox-list" >
								  <div id="heading3" role="tab" class="card-header checkbox-item-list">
									<a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion3" aria-expanded="false" aria-controls="accordion3" class="h6  collapsed">SLKA No</a>
								  </div> 
								  <div id="accordion3" role="tabpanel" aria-labelledby="heading3" class="card-collapse collapse" aria-expanded="false" style="height: 0px;"> 
											<label class="custom-control "> 
												<span class="checkbox-label"><a href="">Select All</a></span>
											</label>
										<?php foreach ($this->m_dashboard->get_supplier() as $supplier) { ?> 
											<label class="custom-control ">
												<input type="checkbox" id="supplier" name="filter[supplier][]" tabindex="2" value="<?= $supplier->ID ?>"  > 
												<span class="checkbox-label"><?= $supplier->NO_SLKA.' - '.$supplier->NAMA ?></span>
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
            </section>
        </div>        
    </div>
</div>
</div>
<script>
    var echarts;

    var initiatedSupplierPerformance = false;
    var supplierPerformanceChart;
    var cpmCorPerformedChart;
    var ratingColor = ['#20A464', '#4A66A0', '#FFFF00','#DD5044'];

    var dataTable;

    $(function() {
        $('#btn-process').click(function() {            
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
                loadSupplierPerformance();
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
            info: false
        });
    });

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
                var radius = [45, 55];   

                var performanceData = response.data.performance;     
                var data = {};   
                $.each(response.rating, function(i, performance) {
                    if (performanceData[i]) {
                        data[i] = (performanceData[i].length/countAllSuppliers*100).toFixed(2);
                    } else {
                        data[i] = 0;
                    }
                });                      
                var supplierPerformanceChartOption = {
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
                supplierPerformanceChart.setOption(supplierPerformanceChartOption);           
            }
        });  
    }      
</script>