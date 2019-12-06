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
                    <div class="col-md-12">
                      <center>                        
                      <a href="#" class="btn btn-primary btn-to-msr" style="display: none" onclick="check_cart()">Draft to MSR Preparation</a>
                      </center>
                    </div>
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap">
                          <thead>
                            <tr>
                              <th width="25">#</th>
                              <?php 
                                foreach ($thead as $key => $value) {
                                  echo "<th>$value</th>";
                                }
                                echo "<th>Status Description</th>";
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
        <h4>Detail</h4>
      </div>
      <div id="result-modal-wo-detail" class="modal-body row">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function detailReplenisment(no) {
    $.ajax({
      type:'post',
      url:"<?= base_url('cmms/replenisment/show') ?>/"+no,
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
        'url': '<?php echo base_url('cmms/replenisment/ajax_list')?>',
        'type': 'POST',
        'data': function ( data ) {
          
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
  // var dt = [];
  function addItemNumber(a,b) {
    // alert($("#tag"+b).text());
    attr = $("#tag"+b).text()
    if(attr == 'Add')
    {
      addToCart(a,b)
      // $("#tag"+b).text('Remove')
    }
    else
    {
      removeToCart(a,b)
      // $("#tag"+b).text('Add')
    }
  }
  function addToCart(a,b) {
    $.ajax({
      type:'POST',
      data:{item_number:a},
      url:"<?= base_url('cmms/replenisment/add_to_cart') ?>",
      success:function(e){
        if(e == '1')
        {
          $(".btn-to-msr").show()
        }
        else
        {
          $(".btn-to-msr").hide()
        }
        $("#tag"+b).text('Remove')
      }
    })
  }
  function removeToCart(a,b) {
   $.ajax({
      type:'POST',
      data:{item_number:a},
      url:"<?= base_url('cmms/replenisment/remove_to_cart') ?>",
      success:function(e){
        if(e == '1')
        {
          $(".btn-to-msr").show()
        }
        else
        {
          $(".btn-to-msr").hide()
        }
        $("#tag"+b).text('Add')
      }
    })
  }
  function check_cart() {
    $.ajax({
      url:"<?= base_url('cmms/replenisment/save_draft_msr') ?>",
      success:function(e){
        swal('Done','Item has been created to Draft MSR, Please Login to SCM Portal Application','success');
        location.reload();
        // window.open("<?=base_url('procurement/msr/createFromDraft')?>/"+e,"_self");
      }
    })
  }
  </script>