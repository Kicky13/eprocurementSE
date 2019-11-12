<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.full.js"></script>
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
                            <label>Priority</label>
                            <?= $optPriority ?>
                          </div>
                          <div class="form-group">
                            <label>Equipment Number</label>
                            <input class="form-control" readonly="" id="eq_number" name="eq_number">
                            <input type="hidden" readonly="" id="faaaid" name="faaaid">
                            <input type="hidden" readonly="" id="fanumb" name="fanumb">
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
                            <input class="form-control toupper" id="wr_description" name="wr_description" maxlength="30">
                            <small>&nbsp;</small>
                          </div>
                          <div class="form-group">
                            <label>Failure Description</label>
                            <input class="form-control toupper" name="failure_desc" name="failure_desc" maxlength="80">
                          </div>
                          <div class="form-group">
                            <label>Photo</label>
                            <input class="form-control" type="file" id="photo" name="photo" style="height:35px !important;padding:6px">
							<span id="photo_preview"></span>
                          </div>
                          <div class="form-group">
                            <label>Requested Finish Date</label>
                            <input class="form-control" id="req_finish_date" name="req_finish_date">
                          </div>
                          <div class="form-group">
                            <label>Parent WO</label>
                            <select class="form-control js-data-example-ajax" value="" id="parent_id" name="parent_id"></select>
                            <small><a href="#" onclick="clearParentId()">Click Here to Clear</a></small>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Hazard Identification & Risk Assesment</label>
                            <input class="form-control toupper" name="hazard" id="hazard" maxlength="100">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Long Description</label>
                            <textarea class="form-control toupper" name="long_description" id="long_description" rows="3"></textarea>
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
  <div class="modal-dialog modal-lg" role="document" style="max-width: 1024px">
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
            <a href="#" class="btn btn-sm btn-primary btn-filter" style="margin-top: 5px">Search</a>
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
                    <!-- <th>Select</th> -->
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

    $('.btn-filter').click(function(){ //button filter event click
      table.ajax.reload();  //just reload table
    });
	$('.js-data-example-ajax').select2({
	  ajax: {
		delay:250,
		url: "<?= base_url('cmms/wr/wo_search') ?>",
		dataType: 'json',
		data: function (params) {
		  var query = {
			search: params.term,
			//type: 'public'
		  }

		  // Query parameters will be ?search=[term]&type=public
		  return query;
		},
		processResults: function (data) {
		  // Transforms the top-level key of the response object from 'items' to 'results'
		  return {
			results: data
		  };
		}
		// Additional AJAX parameters go here; see the end of this chapter for the full code of this example
	  },
	  placeholder: 'Search ',
		minimumInputLength: 3,
	});
  });
  function getSelectedData(id)
  {
    /*<button type="button" href="#" faasid="LCA21AP001" fadl01="HOT WELL PUMP" loct="" cit="" parents="LCA21AP001" dsparents="HOT WELL PUMP" eqclas="MHHP - MECH. HANDLING - HYDRAULIC OIL" eqtype="PU - PUMP" class="btn btn-sm btn-primary" id="34956" onclick="getSelectedData(34956)">Select</button>*/
    var faaaid =$("#"+id).attr("faaaid");
    var fanumb =$("#"+id).attr("fanumb");
    var faasid =$("#"+id).attr("faasid");
    var fadl01 =$("#"+id).attr("fadl01");
    var loct =$("#"+id).attr("loct");
    var eqtype =$("#"+id).attr("eqtype");
    var eqclas =$("#"+id).attr("eqclas");
    $("#faaaid").val(faaaid);
    $("#fanumb").val(fanumb);
    $("#eq_number").val(faasid);
    $("#eq_desc").val(fadl01);
    $("#eq_location").val(loct);
    $("#eq_type").val(eqtype);
    $("#eq_class").val(eqclas);
    // console.log(r);
	//get ajax data failure analysys
  	/*$.ajax({
  		type:'post',
  		data:{eqclas:eqclas},
  		url:"<?=base_url('cmms/wr/opt_ajax_failure_desc')?>",
  		success:function(e){
  			$("#failure_desc").html(e)
  		}
  	})*/
	$("#myModal").modal('hide')
  }
  function browseEquipmentPoup() {
    $("#myModal").modal('show')
  }
  
  function selectEquipmentForWr(eq_no) {
    $("#eq_number").val(eq_no)
    $("#eq_desc").val($("#eqdesc-"+eq_no).text())
    $("#eq_type").val($("#eqtype-"+eq_no).text())
    $("#eq_class").val($("#eqclass-"+eq_no).text())
    $("#eq_location").val($("#eqlocation-"+eq_no).text())
    /*$.ajax({
      type:'post',
      data:{eq_number:eq_no},
      url:"<?=base_url('cmms/wr/opt_ajax_failure_desc')?>",
      success:function(q){
        $("#failure_desc").html(q)
      }
    })*/
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
              swal({ 
                title: "Success",
                text: r.msg,
                type: "success",
                },
                function(){
                  location = "<?= base_url() ?>";
              });
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
  $(function() {
	$("#photo").change(function(event){
        var tmppath = URL.createObjectURL(event.target.files[0]);
        previewFile('photo', tmppath);
    })
    function previewFile(param, tmppath) {
        $("#"+param+"_preview").html("<a href='"+tmppath+"' target='_blank'>Preview Here</a>");
    }
    $('.toupper').change(function(){
        this.value = this.value.toUpperCase();
    });
	});
  function clearParentId() {
      $('.js-data-example-ajax').val(null).trigger('change');
    }
</script>