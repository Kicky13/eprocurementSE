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
                            <input class="form-control" readonly="" id="eq_number" name="eq_number" value="<?=$row->eq_number?>">
                            <input type="hidden" readonly="" id="wr_no" name="wr_no" value="">
                            <input type="hidden" readonly="" id="faaaid" name="faaaid" value="<?=$row->faaaid?>">
                            <input type="hidden" readonly="" id="fanumb" name="fanumb" value="<?=$row->fanumb?>">
                          </div>
                          <div class="form-group">
                            <label>Equipment Description</label>
                            <input class="form-control" readonly="" id="eq_desc" name="eq_desc" value="<?=$row->eq_desc?>">
                          </div>
                          <div class="form-group">
                            <label>Equipment Class</label>
                            <input class="form-control" readonly="" id="eq_class" name="eq_class" value="<?=$row->eq_class?>">
                            <div style="height: 23px">&nbsp;</div>
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
                            <input class="form-control" id="wr_description" name="wr_description" maxlength="30" value="<?=$row->wr_description?>">
                          </div>
                          <div class="form-group">
                            <label>Failure Description</label>
                            <input class="form-control" name="failure_desc" name="failure_desc" maxlength="80" value="<?=$row->failure_desc?>">
                          </div>
                          <div class="form-group">
                            <label>Photo</label>
                            <input class="form-control" type="file" id="photo" name="photo">
                            <a class="btn btn-info btn-sm" target="_blank" href="<?= base_url('upload/wr/'.$row->photo) ?>">View Photo</a>
                          </div>
                          <div class="form-group">
                            <label>Requested Finish Date</label>
                            <input class="form-control" id="req_finish_date" name="req_finish_date" value="<?=$row->req_finish_date?>">
                          </div>
                          <div class="form-group">
                            <label>Parent WO</label>
                            <select class="form-control js-data-example-ajax" id="parent_id" name="parent_id"></select>
                            <span class="btn-info">WO Parent : <?= $row->parent_id ?></span>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="form-group">
                            <label>Hazard Identification & Risk Assesment</label>
                            <input class="form-control" name="hazard" id="hazard" maxlength="30" value="<?=$row->hazard?>">
                          </div>
                        </div>
                        <div class="col-md-12">
                          <a href="<?= base_url('cmms/wr') ?>" class="btn btn-info">Kembali</a>
                          <button id="btn-approve" class="btn btn-primary" type="button" onclick="updateWrClick()">Update & Approve</button>
                          <!-- <button id="btn-reject" class="btn btn-danger" type="button" onclick="rejectClick()">Reject</button> -->
                          <a id="btn-reject" href="#" class="btn btn-danger" data-toggle="modal" data-target="#myModalReject">Reject</a>
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
<div class="modal fade" id="myModalReject" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Reject Work Request</h4>
      </div>
      <div class="modal-body">
        <form id="form-attachment-bled" method="post" action="<?=base_url('approval/approval/bledupload')?>" class="form-horizontal" enctype="multipart/form-data">
          <div class="form-group">
            <label>Description</label>
            <input class="form-control" name="comment_supervisor" id="comment_supervisor" maxlength="30" />
          </div>
          <div class="form-group text-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" onclick="rejectClick()" class="btn btn-danger">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $("#wo_type_id").attr("disabled",'')
    <?php if($row->status == '05' or $row->status == '91' or isset($user_creator) or $this->input->get('all')): ?>
      $("#btn-approve,#btn-reject").hide()
      $("#hazard,#priority,#wr_description,#photo,#req_finish_date,#parent_id").attr("disabled","")
    <?php endif;?>
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
  
  function updateWrClick(argument) {
    var eq_number = $("#eq_number").val()
    if(eq_number)
    {
      var req_finish_date = $("#req_finish_date").val()
      if(!req_finish_date)
      {
        swal('Info','Requested Finish Date is Required','warning')
        return false
      }
      swalConfirm('Approval & Update', 'Are you sure?', function() {
        var form = $("#frm-bled")[0];
        var data = new FormData(form);
        $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "<?=base_url('cmms/wr/update')?>",
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
              setTimeout(function(){ 
                window.open("<?=base_url('home')?>","_self")
              }, 3000);
              
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
      });
    }
    else
    {
      swal('Info','Please Select Equipment First','warning')
    }
  }
  function validationReject() {
    var comment_supervisor = $("#comment_supervisor").val()
    if(comment_supervisor)
    {
      return true;
    }
    else
    {
      swal({ title: "Warning", text: "Description is Required", type: "warning" }, function(){
        location = "<?= base_url() ?>";
      });
      return false;
    }
  }
  function rejectSubmit() {
    swalConfirm('Reject', 'Are you sure?', function() {
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "<?=base_url('cmms/wr/reject/'.$row->wr_no)?>",
        data: {comment_supervisor:$("#comment_supervisor")},
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
    });
  }
  function rejectClick() {
    if(validationReject())
    {
      rejectSubmit()
    }
  }
</script>