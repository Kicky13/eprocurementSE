<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/daterange/daterangepicker.js" type="text/javascript"></script>
<?php
  $msri = $this->approval_lib->msrItem($ed->msr_no);
?>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?=isset($titleApp) ? $titleApp : '';?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
          </ol>
        </div>
      </div>
    </div>
    <div class="row info-header">
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 150px;">Company</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->company_name?></td>
          </tr>
          <tr>
              <td style="width: 150px;">Department</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr->department_desc?></td>
            </tr>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 150px;">MSR Number</td>
              <td class="no-padding-lr">:</td>
              <td><?=$msr_no?></td>
          </tr>
          <tr>
              <td style="width: 150px;">MSR Value (Excl. VAT)</td>
              <td class="no-padding-lr">:</td>
              <td class="text-right">
                <?=$msr->currency?> <?=numIndo($msr->total_amount)?>
                <?=equal_to($msr)?>
              </td>
          </tr>
        </table>
      </div>
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
              <td style="width: 150px;">ED Number</td>
              <td class="no-padding-lr">:</td>
              <td><?=str_replace('OR', 'OQ', $msr_no)?></td>
           </tr>
          <tr>
              <td style="width: 150px;">Title</td>
              <td class="no-padding-lr">:</td>
              <td><?=$ed->subject?></td>
          </tr>
        </table>
      </div>
    </div>
    <div class="content-body">
      <section id="icon-tabs">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body">
                  <form action="<?=base_url('approval/award/awardtobeissued')?>" class="frm-recomendation" id="frm-recomendation">
                    <input type="hidden" name="id" id="id" value="<?=$ed->id?>">
                    <input type="hidden" name="award" id="award" value="9">
                    <h6><i class="step-icon fa fa-info"></i> BOC</h6>
                    <fieldset>
                      <!-- <div class="form-group row">
                        <label class="control-label col-md-3">BOD Approval Date</label>
                        <div class="col-md-3">
                          <input name="bod_date" class="form-control datepicker" value="<?=$ed->bod_date?>">
                        </div>
                        <div class="col-md-3">
                          <input type="file" name="path_bod" required="">
                        </div>
                      </div> -->

                      <div class="form-group row">
                        <label class="control-label col-md-3">BOC Approval Date</label>
                        <div class="col-md-3">
                          <input name="boc_date" class="form-control tgl-aja" value="<?=$ed->boc_date?>">
                        </div>
                        <div class="col-md-3">
                          <input type="file" name="path_boc" id="path_boc" required="">
                        </div>
                      </div>

                      <div class="form-group row">
                        <label class="control-label col-md-3">Approval BOC</label>
                        <div class="col-md-9">
                          <textarea class="form-control" name="issued_award_note"><?=$ed->issued_award_note?></textarea>
                        </div>
                      </div>
                    </fieldset>

                    <h6><i class="step-icon fa fa-th-list"></i>Evaluation</h6>
                    <?php $this->load->view('award/tab-evaluation', ['blDetails'=>$blDetails])?>

                    <h6><i class="step-icon fa fa-info"></i> Quotation</h6>
                    <fieldset>
                        <h3>Quotation Status</h3>
                        <?php $this->load->view('approval/quotation_view',['ed'=>$ed]);?>
                      </fieldset>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="content-footer text-right">
      <!-- <a href="#" class="btn btn-primary" onclick="saveBoc('frm-bled')">Save BOC & BOD</a> -->
      <a href="#" class="btn btn-success" onclick="issuedAwardClick()">Issued Award Notification</a>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-frm-recomendation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">
            Award to be Issued
          </h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/award/approval')?>" class="form-horizontal" id="ss">
            <input type="hidden" name="id" id="id" value="<?=$ed->id?>">
            <input type="hidden" name="award" id="award" value="9">
            <!-- Award to be Issued? -->
            <div class="form-group">
              <div class="col-sm-12 text-center">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="formSubmitAjax('frm-recomendation')" class="btn btn-success">Yes Continue</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function issuedAwardClick() {
      var path_boc = $("#path_boc").val();
      if(parseInt(<?=$sum_award_total_value?>) >= 5000000)
      {
        if(path_boc)
        {
          swalConfirm('Award Recomendation & Evaluation', '<?= __('confirm_submit') ?>', function() {
            formSubmitAjax('frm-recomendation')
          });
        }
        else
        {
          swal('<?= __('warning') ?>','Path BOC is Mandatory','warning')
          return false;
        }
      }
      else
      {
        swalConfirm('Award Recomendation & Evaluation', '<?= __('confirm_submit') ?>', function() {
          formSubmitAjax('frm-recomendation')
        });
      }
    }
    function formSubmitAjax(frm) {
      var f = $("#"+frm).attr('action');
      var form = $("#"+frm)[0];
      var data = new FormData(form);
      $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: f,
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          beforeSend:function(){
            //start($('#icon-tabs'));
          },
          success: function (data) {
            /*swal('Done',data,'success')
            stop($('#modal-'+frm));
            $('#modal-'+frm).modal('hide');*/
            window.open("<?=base_url('home')?>","_self")
          },
          error: function (e) {
            swal('<?= __('warning') ?>','Fail, Try Again','warning')
            //stop($('#modal-'+frm));
            //$('#modal-'+frm).modal('hide');
          }
      });
    }
  </script>
<script type="text/javascript">
  $(document).ready(function(){
    if (!($('.modal.in').length)) {
      $('.modal-dialog').css({
        top: 0,
        left: 0
      });
    }
    $('.modal-dialog').draggable({
      handle: ".modal-header"
    });
	//form step
    $("#frm-recomendation").steps({
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
    //hide next and previous button
    $('a[href="#next"]').hide();
    $('a[href="#previous"]').hide();
  })
</script>