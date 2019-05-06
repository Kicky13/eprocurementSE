<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<?php 
	$getVendorPass = $this->approval_lib->getVendorPass($ed->msr_no)->result();
?>
<a href="#" class="btn btn-success" data-toggle='modal' data-target='#modalNego' >Negotiation</a>
<div class="modal fade" id="modalNego" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Negotiation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="#" class="form-horizontal" id="frm-nego">
            <input class="status" type="hidden" name="msr_no" id="msr_no" value="<?=$ed->msr_no?>">
            <div class="form-group row">
              <label class="col-sm-2">
                Company Letter No
              </label>
              <div class="col-sm-6">
                <input class="form-control" name="company_letter_no" id="company_letter_no" required="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2">
                Closing Date
              </label>
              <div class="col-sm-6">
                <input class="form-control dp" name="closing_date" id="closing_date" required="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2">
                Supporting Document
              </label>
              <div class="col-sm-6">
                <input type="file" class="form-control dp" name="supporting_document" id="supporting_document" required="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-2">
                Choose One
              </label>
              <div class="col-sm-6">
                <select class="form-control status" name="vendor_id">
                <?php foreach ($getVendorPass as $vp) : ?>
                  <option value="<?=$vp->vendor_id?>"><?=($vp->NO_SLKA).' '.$vp->NAMA?></option>
              	<?php endforeach;?>
                </select>
              </div>
              <div class="col-sm-4">
              	<a href="#" class="btn btn-primary negoclick">Nego</a>
              	<a href="#" class="btn btn-success no-nego">No Nego</a>
              </div>
            </div>
            <div class="form-group row result-vendor-items">
            </div>
            <div class="form-group">
              <div class="col-sm-12">
              	<center>
                  <button type="button" class="btn btn-primary close-nego">Close Negotiation</button>
                	<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                </center>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
  	$(document).ready(function(){
      $(".dp").datetimepicker({
        icons: {
          time: "icon-clock",
          date: "icon-calendar",
          up: "fa fa-arrow-up",
          down: "fa fa-arrow-down"
        },
        format:'YYYY-MM-DD HH:mm'
      });
      $(".close-nego").click(function(){
        $.ajax({
          type:'post',
          data:{msr_no:'<?=$ed->msr_no?>'},
          url:"<?=base_url('approval/approval/issuednego')?>",
          beforeSend:function(){
            start($('#modalNego'));
          },
          success: function (data) {
              stop($('#modalNego'));
              alert(data);
          },
          error: function (e) {
            alert('Fail, Try Again');
            stop($('#modalNego'));
          }
        });
      });
  		$(".negoclick").click(function(){
  			$.ajax({
  				type:'post',
  				data:$("#frm-nego").serialize(),
  				url:"<?=base_url('approval/approval/vendor_items_nego')?>",
  				beforeSend:function(){
	              start($('#modalNego'));
	            },
	            success: function (data) {
	            	$(".result-vendor-items").html(data);
	              	stop($('#modalNego'));
	            },
	            error: function (e) {
	              alert('Fail, Try Again');
	              stop($('#modalNego'));
	            }
  			});
  		});
  		$(".no-nego").click(function(){
  			$.ajax({
  				type:'post',
  				data:$("#frm-nego").serialize(),
  				url:"<?=base_url('approval/approval/no_nego')?>",
  				beforeSend:function(){
	              start($('#modalNego'));
	            },
	            success: function (data) {
	            	alert(data);
	              	stop($('#modalNego'));
	            },
	            error: function (e) {
	              alert('Fail, Try Again');
	              stop($('#modalNego'));
	            }
  			})
  		});
  	});
  </script>