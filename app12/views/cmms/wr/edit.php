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
                            <input class="form-control" readonly="" id="eq_number" name="eq_number" value="<?=$row->eq_number?>">
                          </div>
                          <div class="form-group">
                            <label>Equipment Description</label>
                            <input class="form-control" readonly="" id="eq_desc" name="eq_desc" value="<?=$row->eq_desc?>">
                          </div>
                          <div class="form-group">
                            <label>Equipment Class</label>
                            <input class="form-control" readonly="" id="eq_class" name="eq_class" value="<?=$row->eq_class?>">
                          </div>
                          <div class="form-group">
                            <label>Equipment Type</label>
                            <input class="form-control" readonly="" id="eq_type" name="eq_type" value="<?=$row->eq_type?>">
                          </div>
                          <div class="form-group">
                            <label>Location</label>
                            <input class="form-control" readonly="" id="eq_location" name="eq_location" value="<?=$row->eq_location?>">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>WO Type</label>
                            <?= $optWoType ?>
                          </div>
                          <div class="form-group">
                            <label>WR Description</label>
                            <input class="form-control" id="wr_description" name="wr_description" value="<?=$row->wr_description?>">
                          </div>
                          <div class="form-group">
                            <label>Failure Description</label>
                            <select class="form-control" name="failure_desc" id="failure_desc"></select>
                          </div>
                          <div class="form-group">
                            <label><a href="<?=base_url('upload/wr/'.$row->photo)?>" target="_blank" title="Click to View">Photo (Click to View) </a></label>
                            <input class="form-control" type="file" id="photo" name="photo">
                          </div>
                          <div class="form-group">
                            <label>Requested Finish Date</label>
                            <input class="form-control" id="req_finish_date" name="req_finish_date" value="<?=$row->req_finish_date?>">
                          </div>
                          <div class="form-group">
                            <label>Priority</label>
                            <?= $optPriority ?>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Additional Description</label>
                            <input class="form-control" name="additional_description" id="additional_description" value="<?=$row->additional_description?>">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Hazard Identification & Risk Assesment</label>
                            <textarea class="form-control" name="hazard" id="hazard" rows="5"><?=$row->hazard?></textarea>
                          </div>
                        </div>
                        <?php if($approval): ?>
                        <div class="col-md-12">
                          <button class="btn btn-primary" type="button" onclick="updateAndApprove()">Approve/Reject</button>
                        </div>
                        <?php endif;?>
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
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Approval</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="frm-approval" method="post">
          <input type="hidden" name="wr_no" value="<?=$row->wr_no?>">
          <input type="hidden" name="id" value="<?=$approval->approval_id?>">
          <div class="form-group">
            <label>Approval</label>
            <select class="form-control" name="status" id="status">
              <option value="1">Approve</option>
              <option value="2">Reject</option>
            </select>
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea class="form-control" name="description" id="description"></textarea>
          </div>
          <div class="form-group">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button class="btn btn-primary" type="button" onclick="submitApproval()">Submit</button>
          </div>
        </form>
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
    function selectEquipmentForWr() {
      var eq_no = $("#eq_number").val()
      $.ajax({
        type:'post',
        data:{eq_number:eq_no,failure_desc:"<?= $row->failure_desc ?>"},
        url:"<?=base_url('cmms/wr/opt_ajax_failure_desc')?>",
        success:function(q){
          $("#failure_desc").html(q)
        }
      })
    }
    selectEquipmentForWr()
  });
  function updateAndApprove() {
    $("#myModal").modal('show')
  }
  function submitApproval() {
    var status = $("#status").val()
    if(parseInt(status) == 2)
    {
      var description = $("#description").val()
      if(!description)
      {
        swal('Reject','Description is Required','warning')
        return false
      }
    }
    var req_finish_date = $("#req_finish_date").val()
    if(!req_finish_date)
    {
      swal('Info','Requested Finish Date is Required','warning')
      return false
    }

    var form = $("#frm-bled")[0];
    var data = new FormData(form);
    var poData = jQuery(document.forms['frm-approval']).serializeArray();
    for (var i=0; i<poData.length; i++)
      data.append(poData[i].name, poData[i].value);

    $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "<?=base_url('cmms/wr/update_and_approve')?>",
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
</script>