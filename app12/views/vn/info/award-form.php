<!-- datepicker  -->
<link href="<?= base_url() ?>ast11/css/plugins/datapicker/datepicker3.css" rel="stylesheet">
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/daterange/daterangepicker.js" type="text/javascript"></script>
<?php 
  $this->db->where(['bled_no'=>$bled_no]);
  $row      = $this->vendor_lib->accept_award_nomination($status)->row();
  // echo $this->db->last_query();
  $doc      = $this->vendor_lib->tUpload('bled',$row->msr_no)->result();
  $msrItem  = $this->vendor_lib->msrItem($row->msr_no)->result();
  $t_bid_bond  = $this->vendor_lib->tBidBond($bled_no, $vendor_id)->result();

?>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row" style="margin-bottom: 10px">
      <div class="content-header-left col-md-12 col-12 mb-1">
         <h3 class="content-header-title"><?=$row->company_name?></h3>
      </div>
      <div class="col-md-6">
        <span style="color: red">ACCEPTANCE AWARD NOMINATION</span> For <span style="color: blue"><?=$row->title?></span>
      </div>
      <div class="col-md-6 text-right">
        Refrence No : <?=$bled_no?>
      </div>
    </div>
    <div class="content-body">
      <div class="row" style="background: #fff">
        <div class="col-md-12" style="margin-top: 10px">
          <center>
            <b><?= $row->awarder == 1 ? 'AWARD ACCEPTANCE' : ''  ?></b>
            <b><?= $row->awarder == 2 ? 'UNSUCCESSFULL NOTIFICATION' : ''  ?></b>
          </center>
          <table width="100%">
            <tr>
              <td>Date</td>
              <td width="15">:</td>
              <td><?=dateToIndo($row->awarder_date)?></td>
            </tr>
            <tr>
              <td>Subject</td>
              <td>:</td>
              <td><?=$row->title?></td>
            </tr>
            <tr>
              <td>Ref Number</td>
              <td>:</td>
              <td><?=$bled_no?></td>
            </tr>
            <tr>
              <td>Closing Date</td>
              <td>:</td>
              <td><?=dateToIndo($row->closing_date, false, true)?></td>
            </tr>
          </table>
          <br>
          <br>
          <p><< Information according to the note >></p>
          <p>For example : -</p>
          <br>
          <br>
          <br>
          <p>Regards,</p>
          <br>
          <p>Procurement Committee,</p>
        </div>
      </div>
    </div>
    <?php if($status == 1): ?>
    <div class="content-footer" style="margin-top: 10px">
      <div class="row">
      <div class="col-md-12">
          <?php if($row->accept_award == 0): ?>
          <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modal-approve' >Approval </a>
          <?php else:?>
            <center style="margin-bottom: 20px">
              MSR INI sudah anda terima
            </center>
          <?php endif;?>
      </div>
      </div>
    </div>
    <?php endif;?>
    <?php if($status == 2): ?>
      <a href="<?=base_url('vn/info/greetings')?>" class="btn btn-primary" >Back </a>
    <?php endif;?>
  </div>
</div>
<div class="modal fade" id="modal-approve" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Approval Award</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('vn/info/Greetings/terima')?>" class="form-horizontal open-this">
            <input type="hidden" name="t_bl_detail_id" value="<?=$row->t_bl_detail_id?>">
            <div class="form-group row">
              <label class="col-sm-3">
                Choose One
              </label>
              <div class="col-sm-9">
                <select class="form-control" name="accept_award" id="accept_award">
                  <option value="1">Approve</option>
                  <option value="2">Reject</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3">
                Description
              </label>
              <div class="col-sm-9">
                <textarea class="form-control" name="desc_accept_award" id="desc_accept_award"></textarea>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-success">Yes Continue</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

<script type="text/javascript">
// Wizard tabs with icons setup
$(".icons-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '<span class="step">#index#</span> #title#',
    enableFinishButton: false,
    labels: {
        finish: 'Done'
    },
    onFinished: function (event, currentIndex) {
        // alert("Form submitted.");
    }
});
</script>
<script src="<?= base_url() ?>ast11/assets/js/tables/jquery-1.12.3.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
  
$('.mydate').datepicker({
  format: "yyyy-mm-dd"
});
$(document).ready(function(){
  $(".status").removeAttr("disabled");
  $("#accept_award").change(function(){
    if($(this).val() == '2'){
      $("#desc_accept_award").attr("required","");
    }
    else
    {
      $("#desc_accept_award").removeAttr("required");
    }
  });
  if (!($('.modal.in').length)) {
    $('.modal-dialog').css({
      top: 0,
      left: 0
    });
  }
  $('.modal-dialog').draggable({
    handle: ".modal-header"
  });
})
</script>