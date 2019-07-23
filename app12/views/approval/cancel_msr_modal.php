<?php 
  if($msr->status < 2 and isProcurementSpecialist() and isCreatorEd($ed) and notInLoi($ed)): 
?>
<div class="modal fade" id="modal-cancel-msr" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">MSR Cancellation</h4>
      </div>
      <div class="modal-body">
        <form id="frm-cancel-msr" method="post" class="form-horizontal" enctype="multipart/form-data">
          <div class="form-group row">
				<label class="col-sm-3">
				  Attachment
				</label>
				<div class="col-sm-9">
				  <input type="file" name="file_cancel_msr" id="file_cancel_msr" class="form-control" style="height: 45px !important">
				</div>
          </div>
		  <div class="form-group row">
				<label class="col-sm-3">
				  Comment
				</label>
				<div class="col-sm-9">
				  <textarea class="form-control" name="deskripsi" id="deskripsi" style="weight: 1px !important"></textarea>
				</div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-success" onclick="cancelMsrClick()">Yes Continue</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<a href="#" data-toggle="modal" data-target="#modal-cancel-msr" class="btn btn-danger" >MSR Cancellation</a>
<script type="text/javascript">
  $(document).ready(function(){
    $("#file_cancel_msr").removeAttr("disabled")
  })
	function cancelMsrClick()
	{
		swalConfirm('MSR Cancellation', 'Are you sure cancel this MSR', function() {
      var form = $('#frm-cancel-msr')[0];
        var data = new FormData(form);
        $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url:"<?=base_url('procurement/msr/action_cancel_msr/'.$msr_no)?>",
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          beforeSend:function(){
            start($('#icon-tabs'));
          },
          success:function(e){
           var r = eval("("+e+")");
            if(r.status){
              swal('Done',r.msg,'success');
              window.open("<?= base_url('home')?>", "_self")
            }
            else{
              swal('Fail',r.msg,'warning');

            }
            stop($('#icon-tabs')); 
          },
          error:function(){
            stop($('#icon-tabs'));
          }
      });
      /*$.ajax({
      	url:"<?=base_url('procurement/msr/action_cancel_msr/'.$msr_no)?>",
      	beforeSend:function(){
          start($('#icon-tabs'));
      	},
      	success:function(e){
      		var r = eval("("+e+")");
      		if(r.status){
            swal('Done',r.msg,'success');
            window.open("<?= base_url('approval/ed')?>", "_self")
      		}
          stop($('#icon-tabs'));
      	},
      	error:function(){
          stop($('#icon-tabs'));
      	}
      })*/
    });
	}
</script>
<?php endif;?>