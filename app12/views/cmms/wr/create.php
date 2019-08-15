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
    	<section id="icon-tabs">
        <div class="row">
          <div class="col-12">
            <div class="card">
            	<div class="card-content collapse show">
                <div class="card-body card-scroll">
                  <form action="#" class="wizard-circle frm-bled" id="frm-bled" enctype="multipart/form-data">
                    <h6> <?= $title ?></h6>
                    <fieldset>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Parent WO</label>
                            <input class="form-control" value="" id="parent_id" name="parent_id">
                          </div>
                          <div class="form-group">
                            <label>Equipment Number</label>
                            <input class="form-control" readonly="" id="eq_number" name="eq_number">
                            <small><a href="#" onclick="browseEquipmentPoup()">Click Here to Browse</a></small>
                          </div>
                          <div class="form-group">
                            <label>Equipment Description</label>
                            <input class="form-control" readonly="" id="eq_desc" name="eq_desc">
                          </div>
                          <div class="form-group">
                            <label>Equipment Class</label>
                            <input class="form-control" readonly="" id="eq_class" name="eq_class">
                          </div>
                          <div class="form-group">
                            <label>Equipment Type</label>
                            <input class="form-control" readonly="" id="eq_type" name="eq_type">
                          </div>
                          <div class="form-group">
                            <label>Location</label>
                            <input class="form-control" readonly="" id="eq_location" name="eq_location">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>WO Type</label>
                            <?= $optWoType ?>
                          </div>
                          <div class="form-group">
                            <label>WR Description</label>
                            <input class="form-control" id="wr_description" name="wr_description">
                            <small>&nbsp;</small>
                          </div>
                          <div class="form-group">
                            <label>Failure Description</label>
                            <select class="form-control" name="failure_desc" id="failure_desc"></select>
                          </div>
                          <div class="form-group">
                            <label>Photo</label>
                            <input class="form-control" type="file" id="photo" name="photo">
                          </div>
                          <div class="form-group">
                            <label>Requested Finish Date</label>
                            <input class="form-control" id="req_finish_date" name="req_finish_date">
                          </div>
                          <div class="form-group">
                            <label>Priority</label>
                            <?= $optPriority ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Additional Description</label>
                            <input class="form-control" name="additional_description" id="additional_description">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Hazard Identification & Risk Assesment</label>
                            <textarea class="form-control" name="hazard" id="hazard" rows="5"></textarea>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <button class="btn btn-primary" type="button" onclick="creaeteWrClick()">Create</button>
                        </div>
                      </div>
                    </fieldset>
                	</form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Search Equipment - CMMS09</h4>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-12" style="margin-bottom: 10px">
            <a href="#filter-view" class="btn btn-info btn-sm" data-toggle="collapse" style="border-radius: 5px 5px 0px 0px;padding: 10px;">Filter View</a>
          </div>
          <div class="col-md-12 collapse" id="filter-view" style="margin-bottom: 10px">
            <input class="form-control" name="eq_number" id="filter_FAASID" placeholder="Equipment Number" style="margin-bottom: 5px">
            <input class="form-control" name="eq_desc" id="filter_FADL01" placeholder="Equipment Description" style="margin-bottom: 5px">
            <input class="form-control" name="eq_class" id="filter_EQCLAS" placeholder="Equipment Class" style="margin-bottom: 5px">
            <?= $optEqType ?>
            <a href="#" class="btn btn-sm btn-primary" onclick="searchEquipmentClick()">Filter</a>
          </div>
        </div>
        <div class="row">
          <div class="col-md-12">
            <div class="table-responsive">
              <table class="table table-condensed" id="dt-equipment">
                <thead>
                  <tr>
                    <th>Equipment Number</th>
                    <th>Equipment Description</th>
                    <th>Equipment Class</th>
                    <th>Equipment Type</th>
                    <th>Select</th>
                  </tr>
                </thead>
                <tbody id="tbody-equipment-search">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <a href="#" class="btn btn-info" data-dismiss="modal">Close</a>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$("#frm-bled").steps({
      headerTag: "h6",
      bodyTag: "fieldset",
      transitionEffect: "fade",
      titleTemplate: '#title#',
      enableFinishButton: false,
      enablePagination: true,
      enableAllSteps: true,
      labels: {
          finish: 'Done'
      },
      onFinished: function (event, currentIndex) {
          // alert("Form submitted.");
      },
      onStepChanged: function (event, currentIndex, priorIndex) {

      }
    });
    $('#req_finish_date').datepicker({
      dateFormat:'yy-mm-dd',
    });
    //hide next and previous button
    $('a[href="#next"]').hide();
    $('a[href="#previous"]').hide();
  });
  function browseEquipmentPoup() {
    $("#myModal").modal('show')
  }
  function searchEquipmentClick() {
    /*var q = $("#q").val()
    $.ajax({
      type:'post',
      data:{q:q},
      url:"<?=base_url('cmms/wr/search_for_wr')?>",
      success:function(e){
        $("#tbody-equipment-search").html(e)
      }
    })*/
    table = $('#dt-equipment').DataTable({ 
      'processing': true, //Feature control the processing indicator.
      'serverSide': true, //Feature control DataTables' server-side processing mode.
      'order': [], //Initial no order.
      'bSort':false,
      'bFilter':false,
      // Load data for the table's content from an Ajax source
      'ajax': {
        'url': '<?php echo base_url('cmms/wr/ajax_list_equipment')?>',
        'type': 'POST',
        'data': function ( data ) {
          data.FAASID = $('#filter_FAASID').val();
          data.FADL01 = $('#filter_FADL01').val();
          data.EQCLAS = $('#filter_EQCLAS').val();
          data.EQTYPE = $('#filter_EQTYPE').val();
          data.ALLOWANCE = 1;
        },
        "bLengthChange": false
      },
   
      //Set column definition initialisation properties.
      'columnDefs': [
      { 
        'defaultContent': '-',
        'targets': '_all',
      },
      ],
   
    });
  }
  function selectEquipmentForWr(eq_no) {
    $("#eq_number").val(eq_no)
    $("#eq_desc").val($("#eqdesc-"+eq_no).text())
    $("#eq_type").val($("#eqtype-"+eq_no).text())
    $("#eq_class").val($("#eqclass-"+eq_no).text())
    $("#eq_location").val($("#eqlocation-"+eq_no).text())
    $.ajax({
      type:'post',
      data:{eq_number:eq_no},
      url:"<?=base_url('cmms/wr/opt_ajax_failure_desc')?>",
      success:function(q){
        $("#failure_desc").html(q)
      }
    })
    $("#myModal").modal('hide')
  }
  function creaeteWrClick(argument) {
    var eq_number = $("#eq_number").val()
    if(eq_number)
    {
      var req_finish_date = $("#req_finish_date").val()
      if(!req_finish_date)
      {
        swal('Info','Requested Finish Date is Required','warning')
        return false
      }

      var form = $("#frm-bled")[0];
      var data = new FormData(form);
      $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "<?=base_url('cmms/wr/store')?>",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          beforeSend:function(){
            start($('#icon-tabs'));
          },
          success: function (e) {
            var r = eval("("+e+")");
            if(r.status){
              swal('Success',r.msg,'success')
              window.open("<?=base_url('home')?>","_self")
            }else{
              swal('<?= __('warning') ?>',r.msg,'warning')
            }
            stop($('#icon-tabs'));
          },
          error: function (e) {
            swal('<?= __('warning') ?>','Something went wrong!','warning')
            stop($('#icon-tabs'));
          }
      });
    }
    else
    {
      swal('Info','Please Select Equipment First','warning')
    }
  }
</script>