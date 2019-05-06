<?php
  $row = $this->vendor_lib->greeting_list($type,$bled_no)->row();
  $doc = $this->db->where(['module_kode'=>'bled','data_id'=>$row->msr_no])->get('t_upload')->result();

  $prebiddate_str = dateToIndo($row->prebiddate,false,true);
  $prebidaddress_str = $row->prebid_address;
  if($row->prebid_loc == 0)
  {
    $prebiddate_str = 'Not Applicable';
    $prebidaddress_str = 'Not Applicable';
  }
?>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-12 col-12 mb-1">
         <h3 class="content-header-title"><?=$row->company_name?></h3>
         <h6 class="content-header-title">ENQUIRY DOCUMENT For<label class="pull-right">Refrence No : <?=$bled_no?></label></h6>
      </div>
      <div class="content-header-left">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
            <li class="breadcrumb-item">ENQUIRY DOCUMENT</li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content-body">
      <section id="configuration">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
				<!-- Form wizard with icon tabs section start -->
				<section id="icon-tabs">
				  <div class="row">
					<div class="col-12">
					  <div class="card">
						<!-- <div class="card-header">
						  <h4 class="card-title">Please Verify MSR <?=$msr_no?></h4>
						</div> -->
						<div class="card-content collapse show">
						  <div class="card-body  card-scroll">
							<form action="#" class="wizard-circle" id="icons-tab-steps">
							  <!-- Step 1 -->
							  <h6><i class="step-icon fa fa-info"></i> Invitation</h6>
							  <fieldset>
								<div class="row">
								  <div class="col-md-12">
									<center><b>INVITATION BID</b></center>
									<br>
									<table width="100%">
									  <tr>
										<td>Date</td>
										<td width="15">:</td>
										<td><?=dateToIndo($row->issued_date)?></td>
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
										<td>Pre Bid Date</td>
										<td>:</td>
										<td><?=$prebiddate_str?></td>
									  </tr>
									  <tr>
										<td>Location of Meeting</td>
										<td>:</td>
										<td><?=$prebidaddress_str?></td>
									  </tr>
									  <tr>
										<td>Closing Date</td>
										<td>:</td>
										<td><?=dateToIndo($row->closing_date, false, true)?></td>
									  </tr>
									</table>
									<br>
									<p>
									  <?=$row->company_name?> (COMPANY) invite <?=$this->session->userdata('NAME');?> to submit Bid Proposal subject tender.
									  <br>
									  Should you desire to bid or unable to bid, we request you to confirm your participation or notify your withdraw by <?=dateToIndo(date('Y-m-d', strtotime($row->issued_date.' +1 days')))?>.
									  <br>
									  We trust the information contained in the Enquiry Document is sufficient to the preparation of your Bid Proposal and look forward for your participation.
									  <br>
									  COMPANY reserves the right to reject any or all Bid Proposals without providing any reason thereof
									  <br>
									  <br>
									  Regards,
									  <br>
									  <br>
									  <br>
									  <br>
									  Procurement Commite
									</p>
								  </div>
								  <!-- <div class="col-md-12 text-center"> -->
									<!-- <a style="position: relative;top: 45px;margin-left: 20px;z-index: 9" href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">Participate</a>
									<a style="position: relative;top: 45px;margin-left: 10px;z-index: 9" href="#" class="btn btn-danger" data-toggle="modal" data-target="#myWith">Decline</a> -->
								  <!-- </div> -->
								</div>
							  </fieldset>
							  <!-- Step 2 -->
							  <h6><i class="step-icon fa fa-download"></i>Attachment</h6>
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
											  <td>".$value->created_at."</td>
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
        <div class="text-right">
          <?php if (strtotime($row->closing_date) >= strtotime(date('Y-m-d H:i:s'))) { ?>
            <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#myWith">Decline</a>
            <a href="#" class="btn btn-success" data-toggle="modal" data-target="#myModal">Participate</a>
          <?php } ?>
        </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>
<div class="modal fade" id="myWith" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: red">
        <h4 class="modal-title" id="myModalLabel" style="color: white">Decline Confirmation</h4>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal open-this" enctype="multipart/form-data" action="<?=base_url('vn/info/greetings/confirmation')?>">
          <input type="hidden" name="id" value="<?=$row->bldetail_id?>">
          <input type="hidden" name="status" value="2">
          <div class="form-group">
            <label><?=$row->company_name?></label>
            <div class="col-md-12">
              <?=$row->prebid_address?>
            </div>
          </div>
          <div class="form-group">
            <table width="100%">
              <tr>
                <td>Attn</td>
                <td width="15">:</td>
                <td>Procurement Commite</td>
              </tr>
              <tr>
                <td>Subject</td>
                <td>:</td>
                <td><?=$row->title?></td>
              </tr>
              <tr>
                <td>Ref No</td>
                <td>:</td>
                <td><?=$bled_no?></td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3">Dear Sir,</td>
              </tr>
              <tr>
                <td colspan="3">
                  We acknowledge receipt your complete set of Enquiry Document dated on <?=dateToIndo($row->issued_date)?> for subject services, and<br>
                  hereby confirm that we withdraw from further participation in the bidding process .<br>
                  We further confirm that we shall treat the Enquiry Document as confidential matter and only disclose to others<br>
                  such information as is necessary for the preparation of the Bid Proposal.<br>
                </td>
              </tr>
            </table>
          </div>
          <div class="form-group">
            <label class="col-sm-12">
              Message Default
            </label>
            <div class="col-sm-12">
              <select class="form-control" name="m_message" id="m_message">
                <option value="0">--Other--</option>
                <?php foreach ($message as $m) {
                  echo "<option value='$m->id'>$m->isi</option>";
                }
                ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <textarea class="form-control" required="" rows="3" name="reason" id="reason">--Other--</textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12 text-center">
              <center>
                Are you sure Decline ?
              </center>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Decline</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Paricipation Confirmation</h4>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal  open-this" enctype="multipart/form-data" action="<?=base_url('vn/info/greetings/confirmation')?>">
          <input type="hidden" name="id" value="<?=$row->bldetail_id?>">
          <input type="hidden" name="status" value="1">
          <div class="form-group">
            <label><?=$row->company_name?></label>
            <div class="col-md-12">
              <?=$row->prebid_address?>
            </div>
          </div>
          <div class="form-group">
            <table width="100%">
              <tr>
                <td>Attn</td>
                <td width="15">:</td>
                <td>Procurement Commite</td>
              </tr>
              <tr>
                <td>Subject</td>
                <td>:</td>
                <td><?=$row->title?></td>
              </tr>
              <tr>
                <td>Ref No</td>
                <td>:</td>
                <td><?=$bled_no?></td>
              </tr>
              <tr>
                <td colspan="3">&nbsp;</td>
              </tr>
              <tr>
                <td colspan="3">Dear Sir,</td>
              </tr>
              <tr>
                <td colspan="3">
                  We acknowledge receipt your complete set of Enquiry Document dated on <?=dateToIndo($row->issued_date)?> for subject services, and
                  <br>
                  hereby confirm that we: intend to participate in the bidding process and will submit our Bid Proposal in
                  <br>
                  accordance with the terms and requirements therein.
                  <br>
                  We further confirm that we shall treat the Enquiry Document as confidential matter and only disclose to others
                  <br>
                  such information as is necessary for the preparation of the Bid Proposal.
                </td>
              </tr>
            </table>
          </div>
          <div class="form-group">
            <div class="col-sm-12 text-center">
              <center>
                Are you sure participate ?
              </center>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success">Participate</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="<?=base_url('ast11/app-assets/js/scripts/forms/wizard-steps.js')?>" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<script type="text/javascript">
  $(document).ready(function(){
    $("#m_message").change(function(){
      var r = $("#m_message option:selected" ).text();
      $("#reason").val(r);
      $("#reason").focus();
    })



	//form step
	$("#icons-tab-steps").steps({
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


  })
</script>