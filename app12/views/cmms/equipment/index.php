<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?= $title ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content-body">
      <section id="configuration">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                  <div class="row">
                    <div class="col-md-12" style="margin-bottom:10px">
                      <a href="#filter-view" class="btn btn-info" data-toggle="collapse">Filter View</a>
                      <div class="panel panel-default collapse" id="filter-view" style="margin-top: 10px">
                        <div class="panel-body">
                          <div class="form-group row">
                            <label class="col-md-3">Allow Work Request</label>
                            <div class="col-md-6">
							<input type="checkbox" value="1" name="ALLOWANCE" id="filter_ALLOWANCE">
                              <!--<select class="form-control" name="ALLOWANCE" id="filter_ALLOWANCE">
                                <option value="0">--Select One--</option>
                                <option value="1">YES</option>
                                <option value="2">NO</option>
                              </select>-->
                            </div>
                          </div>
                          <?php 
                            foreach ($thead as $key => $value) {
                          ?>
                          <div class="form-group row">
                            <label class="col-md-3"><?=$value?></label>
                            <div class="col-md-6">
                              <?php if($key == 'CIT'): ?>
                                <?= $optCriticality ?>
                              <?php elseif($key == 'EQTYPE'):?>
                                <?= $optEqType ?>
                              <?php else:?>
                              <input class="form-control" name="<?= $key ?>" id="filter_<?= $key ?>">
                              <?php endif;?>
                            </div>
                          </div>
                          <?php } ?>
          						  <div class="form-group row">
          							<button type='button' id='btn-filter' class='btn btn-primary'>Filter</button>
          						  </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                          <thead>
                            <tr>
                              <th width="25">No</th>
                              <th class="text-center">Action</th>
                              <?php thead($thead);?>
                            </tr>
                          </thead>
                          <tbody>
                            
                          </tbody>
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
	<SCRIPT LANGUAGE='JavaScript'>
	var table
  /*'FAASID' => 'Equipment Number',
      'FADL01' => 'Equipment Description',
      'LOCT' => 'Location',
      'CIT' => 'Criticality',
      'PARENTS' => 'Parent EQ Number',
      'DSPARENTS' => 'Parent Description',
      'EQCLAS' => 'Equipment Class',
      'EQTYPE' => 'Equipment Type',*/;
	//jquery
	$(document).ready(function() {
		
		//datatables
		table = $('#tbl').DataTable({ 
	 
			'processing': true, //Feature control the processing indicator.
			'serverSide': true, //Feature control DataTables' server-side processing mode.
			'order': [], //Initial no order.
			'bSort':false,
      'bFilter':false,
			// Load data for the table's content from an Ajax source
			'ajax': {
				'url': '<?php echo base_url('cmms/equipment/ajax_list')?>',
				'type': 'POST',
				'data': function ( data ) {
          data.FAASID = $('#filter_FAASID').val();
          data.FADL01 = $('#filter_FADL01').val();
          data.LOCT = $('#filter_LOCT').val();
          data.CIT = $('#filter_CIT').val();
          data.PARENTS = $('#filter_PARENTS').val();
          data.EQCLAS = $('#filter_EQCLAS').val();
          data.EQTYPE = $('#filter_EQTYPE').val();
		  var filterallowance = 0;
		  if ($('#filter_ALLOWANCE').is(":checked"))
			{
			  var filterallowance = 1;
			}
          data.ALLOWANCE = filterallowance;
				}
			},
	 
			//Set column definition initialisation properties.
			'columnDefs': [
			{ 
				'defaultContent': '-',
				'targets': '_all',
			},
			],
	 
		});
	 
		$('#btn-filter').click(function(){ //button filter event click
			table.ajax.reload();  //just reload table
		});
		$('#btn-reset').click(function(){ //button reset event click
			$('#form-filter')[0].reset();
			table.ajax.reload();  //just reload table
		});
	});
	</script>