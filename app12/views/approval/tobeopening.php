<?php
  $bled_no = str_replace('OR', 'OQ', $msr_no);
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/daterange/daterangepicker.js" type="text/javascript"></script>

<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
        <div class="content-header-left col-md-12 col-12 mb-2">
          <h3 class="content-header-title mb-0">Bid Opening</h3>
        </div>
      </div>
	  <div class="row info-header">
		<div class="col-md-4">
			<table class="table table-condensed">
            <tr>
                <td style="width: 105px;">Company</td>
                <td class="no-padding-lr">:</td>
                <td><?=$msr->company_name?></td>
            </tr>
            <tr>
                <td style="width: 105px;">Department</td>
                <td class="no-padding-lr">:</td>
                <td><?=$msr->department_desc?></td>
              </tr>
          </table>
        </div>
		<div class="col-md-4">
        <table class="table table-condensed">
            <tr>
                <td style="width: 105px;">MSR Number</td>
                <td class="no-padding-lr">:</td>
                <td><?=$msr_no?></td>
            </tr>
            <tr>
                <td style="width: 105px;">MSR Value (Excl. VAT)</td>
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
                <td style="width: 105px;">ED Number</td>
                <td class="no-padding-lr">:</td>
                <td><?=$bled_no?></td>
             </tr>
             <tr>
                <td style="width: 105px;">Title</td>
                <td class="no-padding-lr">:</td>
                <td><?=$ed->subject?></td>
            </tr>
          </table>
        </div>
	  </div>
      <div class="content-body">
        <!-- Form wizard with icon tabs section start -->
        <section id="icon-tabs">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <!-- <div class="card-header">
                  <h4 class="card-title">Please Verify MSR <?=$msr_no?></h4>
                </div> -->
                <div class="card-content collapse show">
                  <div class="card-body card-scroll">
                    <form action="<?=base_url('approval/approval/closingopening')?>" class="wizard-circle" id="frm-bled">
                      <!-- Step 1 -->
                      <h6><i class="step-icon fa fa-info"></i> Bid Proposal</h6>
                      <fieldset>
                        <h3>Bid Proposal</h3>
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                              <tr>
                                <td width="200">Invitation Date</td>
                                <td>
                                  <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
                                    <?=dateToIndo($ed->issued_date)?>
                                  </label>
                                </td>
                              </tr>
                              <tr>
                                <td>Pre Bid Date</td>
                                <td>
                                  <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
                                    <?= dateToIndo($ed->prebiddate, false, true) ?  dateToIndo($ed->prebiddate, false, true) : 'Not Applicable' ?>
                                  </label>
                                </td>
                              </tr>
                              <tr>
                                <td>Bid Validity</td>
                                <td>
                                  <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
                                    <?=dateToIndo($ed->bid_validity)?>
                                  </label>
                                </td>
                              </tr>
                              <tr>
                                <td>Closing Date</td>
                                <td>
                                  <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
                                    <?=dateToIndo($ed->closing_date, false, true)?>
                                  </label>
                                </td>
                              </tr>
                            </table>
                          </div>
                        </div>
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                              <thead>
                                <tr>
                                  <th>NO</th>
                                  <th>SLKA NO</th>
                                  <th>Bidder(s) Name</th>
                                  <!-- <th>Submission Date</th> -->
                                  <th>Status</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php
                                $no=1;
                                foreach ($blDetails->result() as $blDetail) {
                                  $t_sop_bid = $this->db->where(['vendor_id'=>$blDetail->vendor_id,'msr_no'=>$msr_no])->get('t_sop_bid');
                                $numSop = $t_sop_bid->num_rows();
                                $statusMsg = $blDetail->confirmed == 1 ? "Confirmed" : "Decline";
                                if($numSop > 0)
                                {
                                  $statusMsg = 'Bid Proposal Submitted';
                                }
                                  echo "<tr>
                                  <td>$no</td>
                                  <td>$blDetail->no_slka</td>
                                  <td>$blDetail->vendor_name</td>
                                  <td>".$statusMsg."</td>
                                  </tr>";
                                  $no++;
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </fieldset>
                      <!-- Step 2 -->
                      <h6><i class="step-icon fa fa-th-list"></i>Enquiry Data</h6>
                      <fieldset>
                        <?php $this->load->view('approval/tab_ed_view', ['ed'=>$ed, 'msr'=>$msr]); ?>
                      </fieldset>
                      <!-- Step 3 -->
                      <h6><i class="step-icon fa fa-btc"></i>Enquiry Document</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>TYPE</th>
                                    <th>FILE NAME</th>
                                    <th>UPLOAD AT</th>
                                    <th>UPLOADER</th>
                                    <th>ACTION</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($doc as $key => $value) {
                                    echo "<tr>
                                      <td>".biduploadtype($value->tipe, true)."</td>
                                      <td>".$value->file_name."</td>
                                      <td>".dateToIndo($value->created_at, false, true)."</td>
                                      <td>".user($value->created_by)->NAME."</td>
                                      <td>
                                        <a href='".base_url('userfiles/temp/'.$value->file_path)."' target='_blank' class='btn btn-sm btn-primary'>Download</a>
                                      </td>
                                    </tr>";
                                  }?>
                                </tbody>
                              </table>
                            </div>
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
        <!-- Form wizard with icon tabs section end -->
      </div>
      <div class="form-group text-right">
        <?php
          // $d = $ed->noting > 0 ? "" : "disabled";
          // $d = $ed->bid_opening > 0 ? "disabled" : $d;
        if($ed->bid_opening == 0):
        ?>
        <a href="#" onclick="bidOpening()" class="btn btn-success" >Bid Opening</a>
        <?php endif;?>
      </div>
    </div>
  </div>
  <form method="post" id="frm-bid-opening" action="<?=base_url('approval/approval/savebidopening')?>/<?=$ed->id?>" class="form-horizontal" id="mydfr">
    <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
  </form>
  <!--<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Bid Opening</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/savebidopening')?>/<?=$ed->id?>" class="form-horizontal" id="mydfr">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <div class="form-group">
              <div class="col-sm-12">
                <?php if (strtotime($ed->closing_date) <= strtotime(date('Y-m-d H:i:s'))) { ?>
                  Are you Sure to Bid Opening
                <?php } else { ?>
                  Bid opening allowed after closing date on <?= dateToIndo($ed->closing_date, false, true) ?>
                <?php } ?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <?php if (strtotime($ed->closing_date) <= strtotime(date('Y-m-d H:i:s'))) { ?>
                  <button type="submit" class="btn btn-success">Yes Continue</button>
                <?php } ?>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>-->
  <script type="text/javascript">
$(document).ready(function(){
      $("#frm-bled input,#frm-bled select,#frm-bled textarea").attr('disabled','disabled');
      $("#ed_id").removeAttr('disabled');

	  //form step
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
		}
		});

		//hide next and previous button
		$('a[href="#next"]').hide();
		$('a[href="#previous"]').hide();


    });
    $("input,select,textarea").attr('disabled','disabled');
    function bidOpening() {
      <?php if (strtotime($ed->closing_date) <= strtotime(date('Y-m-d H:i:s'))) { ?>
        swalConfirm('Bid Opening', '<?= __('confirm_bid_opening') ?>', function() {
          $('#frm-bid-opening').submit();
        });
      <?php } else { ?>
        swal('<?= __('warning') ?>', 'Bid opening allowed after closing date on <?= dateToIndo($ed->closing_date, false, true) ?>', 'warning');
      <?php } ?>
    }
  </script>