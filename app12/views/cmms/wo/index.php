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
            <li class="breadcrumb-item"><a href="#"><?= $title ?></a></li>
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
                          <?php foreach ($filter as $key => $value) : ?>
                          <div class="form-group row">
                            <label class="col-md-3"><?=$value->desc?></label>
                            <div class="col-md-6">
                              <input class="form-control" name="<?= $value->desc1 ?>" id="filter_<?= $value->desc1 ?>">
                            </div>
                          </div>
                          <?php endforeach;?>
                          <div class="form-group row">
                            <div class="col-md-6">
                            <button type='button' id='btn-filter' class='btn btn-primary'>Filter</button>
                            </div>
                            </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap">
                          <thead>
                            <tr>
                              <th width="25">No</th>
                              <?php 
                                foreach ($thead as $key => $value) {
                                  echo "<th>$value->desc</th>";
                                }
                              ?>  
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
<div class="modal fade" id="my-modal-wo-detail" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4>WO Detail - CMMS08</h4>
      </div>
      <div id="result-modal-wo-detail" class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function openModalWoDetail(wono) {
    $.ajax({
      type:'post',
      url:"<?= base_url('cmms/equipment/wo_detail') ?>/"+wono,
      success:function(e){
        $("#result-modal-wo-detail").html(e)
        $("#my-modal-wo-detail").modal('show')
      }
    })
  }
</script>
<SCRIPT LANGUAGE='JavaScript'>
  var table
  $(document).ready(function() {
    table = $('#tbl').DataTable({ 
      'processing': true, //Feature control the processing indicator.
      'serverSide': true, //Feature control DataTables' server-side processing mode.
      'order': [], //Initial no order.
      'bSort':false,
      'bFilter':false,
      // Load data for the table's content from an Ajax source
      'ajax': {
        'url': '<?php echo base_url('cmms/wo/ajax_list')?>',
        'type': 'POST',
        'data': function ( data ) {
          data.WONO = $('#filter_WONO').val();
          data.WODESC = $('#filter_WODESC').val();
          data.EQNO = $('#filter_EQNO').val();
          data.EQDESC = $('#filter_EQDESC').val();
          data.washno = 1;
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