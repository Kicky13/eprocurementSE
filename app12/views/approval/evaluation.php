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
          <h3 class="content-header-title mb-0">
          	<?php
          		$award = $this->input->get('award');
          		echo $award ? "AWARD" : "EVALUATION";
          	?>
	      </h3>
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
                <td style="width: 150px;">MSR Value (Excl. VAT)</td>
                <td class="no-padding-lr">:</td>
                <td class="text-right">
                    <?=$msr->currency?> <?=numIndo($msr->total_amount)?>
                    <?=equal_to($msr)?>
                </td>
            </tr>
            <?php if($ed->ee_value > 0): ?>
            <tr>
                <td style="width: 125px;">Rev. MSR Value</td>
                <td class="no-padding-lr">:</td>
                <td>
                  <?php
                    $edc = $this->db->where(['ID'=>$ed->currency])->get('m_currency')->row();
                    echo $edc->CURRENCY;
                  ?>
                  <?=numIndo($ed->ee_value)?>
                </td>
            </tr>
            <?php endif;?>
          </table>
        </div>
    <div class="col-md-4">
        <table class="table table-condensed">
            <tr>
                <td style="width: 105px;">ED Number</td>
                <td class="no-padding-lr">:</td>
                <td><?=str_replace('OR', 'OQ', $msr_no)?></td>
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
                      <input type="hidden" name="msr_no" id="msr_no" value="<?=$msr_no?>">
                      <!-- Step 1 -->
                      <h6><i class="step-icon fa fa-info"></i> Quotation</h6>
                      <fieldset>
                        <h3>Quotation Status</h3>
                        <?php $this->load->view('approval/quotation_view',['ed'=>$ed]);?>
                      </fieldset>
                      <!-- Step Administartive -->
                      <?php
                        $disAdm = 'disabled';
                        if(in_array(28, $roles))
                        {
                          $disAdm = '';
                        }
                      ?>
                      <h6><i class="step-icon fa fa-th-list"></i>Evaluation</h6>
                      <fieldset>
                        <div class="row">
						  <div class="col-md-12">
							  <nav>
								  <div class="nav nav-tabs sub-tabs" id="nav-tab" role="tablist">
									<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-administrative" role="tab" aria-controls="nav-home" aria-selected="true">Administrative</a>
									<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-technical" role="tab" aria-controls="nav-profile" aria-selected="false">Technical</a>
									<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-commercial" role="tab" aria-controls="nav-contact" aria-selected="false">Commercial</a>
								  </div>
							  </nav>
							  <div class="tab-content" id="nav-tabContent">
								  <div class="tab-pane fade show active" id="nav-administrative" role="tabpanel" aria-labelledby="nav-administrative-tab">
									<div class="row">
										<div class="col-md-12 text-center">
											<?php
											  $btndis = '';
											  $btndis2 = true;
											  $disAdm = 'disabled';
											  if(in_array(bled, $roles))
											  {
												$disAdm = '';
											  }
											  if (isset($approved_administration)):
												$btndis = $approved_administration->administrative == 3 || $approved_administration->administrative == 1 ? '':'disabled';
												// $btndis2 = $approved_administration->administrative == 3 || $approved_administration->administrative == 1  || $approved_administration->administrative == 4 ? false:true;
												$btnApprovalAdmin = $approved_administration->administrative == 3 ? "hidden":"";
												$adminAttachment = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
											?>
											  <!-- <a href="<?=base_url('upload/evaluation/'.@$adminAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a> -->
											<?php else:?>
											  <!-- <a href="#" data-toggle="modal" data-target="#modal-upload-administrative" class="btn btn-sm btn-primary <?=$disAdm?>">Upload</a> -->
											<?php endif;?>

										  </div>
										  <div class="col-md-12">
											<div class="table-responsive">
											  <table class="table table-condensed table-striped">
												<thead>
												  <tr>
													<th width="1">No</th>
													<th>SLKA No</th>
													<th>Bidder(s) Name</th>
													<th>Status</th>
													<?php if($btndis2): ?>
													<?php endif;?>
													<th>Result</th>
													<th>Remark</th>
													<th>
														<?php
														  if($ed->administrative == 0 or $ed->administrative == 2)
														  {
															$btndis2 = true;
														  }
														  else
														  {
															$btndis2 = false;
														  }

														  if($ed->administrative == 0 or $ed->administrative == 2):
														?>
														<?php
														  else:
															$adminAttachment = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
														?>
														  <a href="<?=base_url('upload/evaluation/'.@$adminAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
														<?php endif;?>
													</th>
												  </tr>
												</thead>
												<tbody>
												  <?php
												  $no=1;
												  foreach ($blDetails->result() as $blDetail) {
									if($blDetail->confirmed == 1)
									{
													echo "<tr>
													<td>$no</td>
													<td><a href='".base_url('vendor/registered_supplier?id='.$blDetail->vendor_id)."' target='_blank'>$blDetail->no_slka<a/></td>
													<td>$blDetail->vendor_name</td>
													<td><a href='javascript:void(0)' onclick='document_expired(\"".$blDetail->vendor_id."\")'>$blDetail->status_doc<a/></td>";
													echo "<td id='adm-result-$blDetail->bl_detail_id'>".evaluationStatus($blDetail->administrative)."</td>
													<td id='adm-remark-$blDetail->bl_detail_id'>$blDetail->desc_administrative</td>
													<td></td>
													</tr>";
									$no++;
									}
												  }
												  ?>
												</tbody>
											  </table>
											</div>
										  </div>
									</div>
								  </div>
								  <div class="tab-pane fade show " id="nav-technical" role="tabpanel" aria-labelledby="nav-technical-tab">
									<div class="row">
									  <div class="col-md-12 text-center">
										<?php
										  $btndisTech = '';
										  $btndis2Tech = true;
										  $disTech = 'disabled';
										  if(in_array(26, $roles))
										  {
											$disTech = '';
										  }
										  if (isset($approved_technical)):
											$btndisTech = $approved_technical->technical == 3 || $approved_technical->technical == 1 ? '':'disabled';
											$btndis2Tech = $approved_technical->technical == 3 || $approved_technical->technical == 1  || $approved_technical->technical == 4 ? false:true;
											$btnApprovalTech = $approved_technical->technical == 3 ? "hidden":"";
										?>
										  <!-- <a href="<?=base_url('upload/evaluation/'.@$technicalAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a> -->
										<?php else:?>
										  <!-- <a href="#" data-toggle="modal" data-target="#modal-upload-technical" class="btn btn-sm btn-primary <?=$disTech?>">Upload</a> -->
										<?php endif;?>

									  </div>
									  <div class="col-md-12">
										<div class="table-responsive">
										  <table class="table table-condensed table-striped">
											<thead>
											  <tr>
												<th width="15">No</th>
												<th>SLKA No</th>
												<th>Bidder(s) Name</th>
												<?php if($btndis2Tech): ?>
												  <?php if($ed->technical_data == 2): ?>
													<th style="width: 20%">Scoring</th>
												  <?php else:?>
												  <?php endif;?>
												<?php endif;?>
												<th>Result</th>
												<th>Remark</th>
												<th>
													<?php
													  if($ed->technical == 0 or $ed->technical == 2)
													  {
														$btndis2Tech = true;
													  }
													  else
													  {
														$btndis2Tech = false;
													  }

													  if($ed->technical == 0 or $ed->technical == 2):
													?>
													<?php
													  else:
														$techAttachment = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
													?>
													<a href="<?=base_url('upload/evaluation/'.@$techAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
													<?php endif;?>
												</th>
											  </tr>
											</thead>
											<tbody>
											  <?php
											  $no=1;
											  foreach ($blDetails->result() as $blDetail) {
												if($blDetail->confirmed == 1)
												{
												  echo "<tr>
												  <td>$no</td>
												  <td>$blDetail->no_slka</td>
												  <td>$blDetail->vendor_name</td>";
												  if($ed->commercial_data == 2)
												  {
													echo "<td id='tech-$no-result'>".($blDetail->scoring)."</td>";
												  }
												  else
												  {
													echo "<td id='tech-result-$blDetail->bl_detail_id'>".evaluationStatus($blDetail->technical)."</td>";
												  }
												  echo "<td id='tech-remark-$blDetail->bl_detail_id'>$blDetail->desc_technical</td>
												  <td></td></tr>";
												  $no++;
												}
											  }
											  ?>
											</tbody>
										  </table>
										</div>
									  </div>
									</div>
								  </div>
								  <div class="tab-pane fade show " id="nav-commercial" role="tabpanel" aria-labelledby="nav-commercial-tab">
									<div class="row">
    									<?php
    									  $btndisCom = '';
    									  $btndisCom2 = true;
    									  $disCom = 'disabled';
    									  if(in_array(bled, $roles) and $ed->technical == 5 and $ed->administrative == 5)
    									  {
    										$disCom = '';
    									  }
    									  if (isset($approved_commercial)):
    										$btndisCom = $approved_commercial->commercial == 3 || $approved_commercial->commercial == 1 ? '':'disabled';
    										$btndisCom2 = $approved_commercial->commercial == 3 || $approved_commercial->commercial == 1  || $approved_commercial->commercial == 4 ? false:true;
    										$btnApprovalCom = $approved_commercial->commercial == 3 ? "hidden":"";
    									?>
    									  <!-- <a href="<?=base_url('upload/evaluation/'.$commercialAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a> -->
    									<?php else:?>
    									  <!-- <a href="#" data-toggle="modal" data-target="#modal-upload-commercial" class="btn btn-sm btn-primary <?=$disCom?>">Upload</a> -->
    									<?php endif;?>
									  <div class="col-md-12">
										<div class="table-responsive" style="margin-bottom: 15px;">
										  <table class="table table-condensed table-striped">
											<thead>
											  <tr>
												<th width="1">No</th>
												<th>SLKA No</th>
												<th>Bidder(s) Name</th>
												<th>Original Value</th>
												<th>Latest Value</th>
												<th>Result</th>
												<th>Remark</th>
												<th>
													<?php
													  if(($ed->commercial == 0 or $ed->commercial == 2)):
													?>
													<?php
													  else:
														$commercialAttachment = $this->M_approval->seeAttachment('eva-commercial', $msr_no)->row();
													?>
													  <a href="<?=base_url('upload/evaluation/'.@$commercialAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
													<?php endif;?>
												</th>
											  </tr>
											</thead>
											<tbody>
											  <?php
											  $no=1;
											  foreach ($blDetails->result() as $blDetail) {
												if($blDetail->confirmed == 1)
												{
												echo "<tr>
												<td>$no</td>
												<td>$blDetail->no_slka</td>
												<td>$blDetail->vendor_name</td>";
												$sop_bid = $this->db->select('*')
												->join('t_sop','t_sop_bid.sop_id=t_sop.id','left')
												->where(['t_sop.msr_no'=>$msr_no,'vendor_id'=>$blDetail->vendor_id])->get('t_sop_bid')->result();
												// $sop = $this->db->where(['msr_no'=>$msr_no])->get('t_sop')->result();
												$oriVal = 0;
												$latVal = 0;
												foreach ($sop_bid as $r) {
												  if($r->qty2 > 0)
												  {
													$oriVal += $r->qty1*$r->qty2*$oriVal;
													$latVal += $r->qty1*$r->qty2*$latVal;
												  }
												  else
												  {
													$oriVal += $r->qty1*$r->unit_price;
													$latVal += $r->qty1*$r->nego_price;
												  }
												}

												echo "<td class='text-center'>".numIndo($oriVal)."</td>";
												echo "<td class='text-center'>".numIndo($latVal > 0 ? $latVal : $oriVal)."</td>";
												echo "<td id='com-result-$blDetail->bl_detail_id'>".evaluationStatus($blDetail->commercial)."</td>
												<td id='com-remark-$blDetail->bl_detail_id'>$blDetail->desc_commercial</td>
												<td></td>
												</tr>";
												$no++;
												}
											  }
											  ?>
											</tbody>
										  </table>
										</div>
									  </div>
									</div>
									<!-- Step Price Evaluation -->
                                    <nav>
                                        <div class="nav nav-tabs sub-tabs" id="nav-tab" role="tablist">
                                            <a class="nav-item nav-link active" id="nav-original-value-tab" data-toggle="tab" href="#tab-original-value" role="tab" aria-controls="nav-home" aria-selected="true">Original Value</a>
                                            <a class="nav-item nav-link" id="nav-latest-value-tab" data-toggle="tab" href="#tab-latest-value" role="tab" aria-controls="nav-profile" aria-selected="false">Latest Value</a>
                                            <a class="nav-item nav-link" id="nav-recommendation-tab" data-toggle="tab" href="#tab-recommendation" role="tab" aria-controls="nav-contact" aria-selected="false">Recommendation</a>
                                        </div>
                                    </nav>
                                    <div class="tab-content" id="nav-tabContent">
                                        <div class="tab-pane fade show active" id="tab-original-value" role="tabpanel" aria-labelledby="original-value-tab" style="padding: 15px 0px;">
                                            <?php $this->load->view('approval/priceevaluationnegotiation-new',['ed'=>$ed,'nego'=>false]);?>
                                        </div>
                                        <div class="tab-pane fade show" id="tab-latest-value" role="tabpanel" aria-labelledby="latest-value-tab" style="padding: 15px 0px;">
                                            <?php $this->load->view('approval/priceevaluationnegotiation-new',['ed'=>$ed, 'nego'=>true]);?>
                                        </div>
                                        <div class="tab-pane fade show" id="tab-recommendation" role="tabpanel" aria-labelledby="recommendation-tab" style="padding: 15px 0px;">
                                            <?php $this->load->view('approval/perform-award-recomendation',['ed'=>$ed]);?>
                                        </div>
                                    </div>
								  </div>
							  </div>
						  </div>
						</div>


                      </fieldset>

                      <!-- Step 2 -->
                      <h6><i class="step-icon fa fa-th-list"></i>Enquiry Data</h6>
                      <fieldset>
                        <?php $this->load->view('approval/tab_ed_view', ['ed'=>$ed, 'msr'=>$msr]); ?>
                      </fieldset>
                      <!-- Step 3 -->
                      <h6><i class="step-icon fa fa-download"></i>Enquiry Document</h6>
                      <fieldset>
                        <div class="row">
                          <div class="col-md-12">
                            <div class="table-responsive">
                              <table class="table table-condensed">
                                <thead>
                                  <tr>
                                    <th>Type</th>
                                    <th>Filename</th>
                                    <th>Uploaded Date</th>
                                    <th>Uploaded By</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <?php foreach ($doc as $key => $value) {
                                    echo "<tr>
                                      <td>".biduploadtype($value->tipe, true)."</td>
                                      <td><a href='".base_url('userfiles/temp/'.$value->file_path)."' target='_blank'>".$value->file_name."</a></td>
                                      <td>".$value->created_at."</td>
                                      <td>".user($value->created_by)->NAME."</td>
                                    </tr>";
                                  }?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                      <h6><i class="step-icon fa fa-history"></i><?= $award ? "Approval" : "History" ?></h6>
                      <fieldset>
                        <div class="table-responsive">
                          <table class="table">
                            <thead>
                              <tr>
                                <th width="1">No</th>
                                <th>User</th>
                                <th>Description</th>
                                <th>Transaction Date</th>
                                <?php if($award): ?>
                                <th>Status</th>
                                <?php endif;?>
                                <th>Comment</th>
                              </tr>
                            </thead>
                            <tbody id="result-approval">
                              <?php
                              $no = 1;
                              if($award)
                              {
                              	foreach ($listApprovalAward as $r) {
                              		$transction_date = $r->status > 0 ? dateToIndo($r->created_at, false, true) : '';
                              		$deskripsi = $r->status > 0 ? $r->deskripsi : '';
                              		$status = '';
                              		if($r->status == 1)
                              			$status == 'Approve';
                              		if($r->status == 2)
                              			$status == 'Reject';

                              		echo "<tr>
                                  <td>$no</td>
                                  <td>".$r->user_nama."</td>
                                  <td>".$r->role_name."</td>
                                  <td>".$transction_date."</td>
                                  <td>".$status."</td>
                                  <td>".$deskripsi."</td>
                                  </tr>";
                                  $no++;
                              	}
                              }
                              else
                              {
                                $log_history = $this->db->where(['data_id'=>$msr_no])->where_in('module_kode', ['technical evaluation','admin evaluation','award'])->order_by('created_at','desc')->get('log_history');
                                foreach ($log_history->result() as $r) {
                                  echo "<tr>
                                  <td>$no</td>
                                  <td>".user($r->created_by)->NAME."</td>
                                  <td>".$r->description."</td>
                                  <td>".dateToIndo($r->created_at, false, true)."</td>
                                  <td>".$r->keterangan."</td>
                                  </tr>";
                                  $no++;
                                }
                              }
                              ?>

                            </tbody>
                          </table>
                        </div>
                      </fieldset>

                      <?php $this->load->view('approval/review_ee_tab');?>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <!-- Form wizard with icon tabs section end -->
      </div>
    </div>
  </div>

  <!-- myModalEvaluation -->
  <div class="modal fade" id="modalApprovalTech" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Approval Technical Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/approvalevaluation')?>" class="form-horizontal">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <div class="form-group row">
              <label class="col-sm-3">
                Choose One
              </label>
              <div class="col-sm-9">
                <select class="form-control status" name="technical">
                  <option value="3">Approve</option>
                  <option value="0">Reject</option>
                </select>
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

  <div class="modal fade" id="modalApprovalAdm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Approval Administration Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/approvalevaluation')?>" class="form-horizontal">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <input type="hidden" name="approval_ed" value="administrative" class="not-disabled">
            <div class="form-group row">
              <label class="col-sm-3">
                Choose One
              </label>
              <div class="col-sm-9">
                <select class="form-control status" name="administrative" id="administrative_approval">
                  <option value="3">Approve</option>
                  <option value="0">Reject</option>
                </select>
              </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-12">
                  <textarea name="deskripsi" id="deskripsi_approvaladministrative" class="form-control not-disabled" placeholder="Comment Here"></textarea>
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

  <div class="modal fade" id="modalApprovalCom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Approval Commercial Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/approvalevaluation')?>" class="form-horizontal">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <div class="form-group row">
              <label class="col-sm-3">
                Choose One
              </label>
              <div class="col-sm-9">
                <select class="form-control status" name="commercial">
                  <option value="3">Approve</option>
                  <option value="0">Reject</option>
                </select>
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

  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Bid Opening</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/savebidopening')?>/<?=$ed->id?>" class="form-horizontal" id="mydfr ">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <div class="form-group">
              <div class="col-sm-12">
                Are you Sure to Bid Opening
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

  <div class="modal fade" id="myModalEvaluation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Administration Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/administrationevaluation')?>" class="form-horizontal" id="mydfr ">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <input type="hidden" name="administrative" id="administrative" value="1">
            <div class="form-group">
              <div class="col-sm-12">
                Are you Sure to Finish Administration Evaluation
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <textarea name="deskripsi" id="deskripsi" class="form-control not-disabled" placeholder="Comment Here"></textarea>
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

  <div class="modal fade" id="myModalEvaluationTechnical" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Technical Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/technicalevaluation')?>" class="form-horizontal" id="mydfr ">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <input type="hidden" name="technical" id="technical" value="1">
            <div class="form-group">
              <div class="col-sm-12">
                Are you Sure to Finish Technical Evaluation
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <textarea name="deskripsi" id="deskripsi" class="form-control not-disabled" placeholder="Comment Here"></textarea>
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

  <div class="modal fade" id="myModalEvaluationCommercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Award Recommendation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/award/recomendation')?>" class="form-horizontal" id="frmcomeva">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <input type="hidden" class="msr_no" name="msr_no" value="<?=$msr_no?>">
            <input type="hidden" name="commercial" id="commercial" value="1">
            <input type="hidden" name="award" id="award" value="1">
            <div class="form-group award-popup">

            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- modalAckAdm -->
  <div class="modal fade" id="modalAckAdm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Administrative Acknowledge Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/administrationevaluation')?>" class="form-horizontal">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <input type="hidden" name="administrative" id="administrative" value="<?= $ed->administrative == 3 ? 4 : 5 ?>">
            <div class="form-group">
              <div class="col-sm-12">
                Are you Sure to Acknowledge Administration Evaluation?
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

  <!-- modalAckTech -->
  <div class="modal fade" id="modalAckTech" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Technical Acknowledge Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/technicalevaluation')?>" class="form-horizontal">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <input type="hidden" name="technical" id="technical" value="<?= $ed->technical == 3 ? 4: 5 ?>">
            <div class="form-group">
              <div class="col-sm-12">
                Are you Sure to Acknowledge Technical Evaluation?
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

  <!-- modalAckCom -->
  <div class="modal fade" id="modalAckCom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Commercial Acknowledge Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/technicalevaluation')?>" class="form-horizontal">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <input type="hidden" name="commercial" id="commercial" value="4">
            <div class="form-group">
              <div class="col-sm-12">
                Are you Sure to Acknowledge Commercial Evaluation?
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

  <div class="modal fade" id="modal-pass-adm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="adm-confirm"></h4>
        </div>
        <div class="modal-body">
          <div id="body-adm-confirm"></div>
          <form method="post" action="<?=base_url('approval/approval/administrative')?>" id="frmadm">
            <input type="hidden" name="bl_detail_id" id="bl_detail_id">
            <input type="hidden" name="administrative" id="administrative">
            <div class="form-group row">
              <div class="col-md-12">
                <textarea class="form-control" rows="3" name="desc_administrative" id="desc_administrative" placeholder="Add note optional"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="admClick()" class="btn btn-success">Yes</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-pass-commercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="commercial-confirm"></h4>
        </div>
        <div class="modal-body">
          <div id="body-commercial-confirm"></div>
          <form method="post" action="<?=base_url('approval/approval/commercial')?>" id="frmtech">
            <input type="hidden" name="commercial" id="commercial">
            <div class="form-group row">
              <div class="col-md-12">
                <textarea class="form-control desc-note" rows="3" name="desc_commercial" id="desc_commercial" placeholder="Add note optional"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="commercialClick()" class="btn btn-success">Yes</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-pass-tech" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="tech-confirm"></h4>
        </div>
        <div class="modal-body">
          <div id="body-adm-confirm"></div>
          <form method="post" action="<?=base_url('approval/approval/administrative')?>" id="frmtech">
            <input type="hidden" name="technical" id="technical">
            <div class="form-group row">
              <div class="col-md-12">
                <textarea class="form-control desc-note" rows="3" name="desc_technical" id="desc_technical" placeholder="Add note optional"></textarea>
              </div>
            </div>
            <div class="form-group row">
              <div class="col-md-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="techClick()" class="btn btn-success">Yes</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-upload-commercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Upload</h4>
        </div>
        <div class="modal-body">
          <form method="post" class="form-horizontal" id="frmcommercial" enctype="multipart/form-data">
            <input type="hidden" name="data_id" value="<?=$msr_no?>" class="data_id">
            <div class="form-group">
              <div class="col-sm-12">
                <input type="file" name="upload" required="" class="attachment desc-note">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="evaluationupload('commercial')" class="btn btn-success">Upload</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-upload-administrative" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Upload</h4>
        </div>
        <div class="modal-body">
          <form method="post" class="form-horizontal" id="frmadministrative" enctype="multipart/form-data">
            <input type="hidden" name="data_id" value="<?=$msr_no?>" class="data_id">
            <div class="form-group">
              <div class="col-sm-12">
                <input type="file" name="upload" required="" class="attachment desc-note">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="evaluationupload('administrative')" class="btn btn-success">Upload</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modal-upload-technical" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Upload</h4>
        </div>
        <div class="modal-body">
          <form method="post" class="form-horizontal" id="frmtechnical" enctype="multipart/form-data">
            <input type="hidden" name="data_id" value="<?=$msr_no?>" class="data_id">
            <div class="form-group">
              <div class="col-sm-12">
                <input type="file" name="upload" required="" class="attachment desc-note">
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="evaluationupload('technical')" class="btn btn-success">Upload</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <div id="document_expired-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content" >
            <div class="modal-header">
                <h4 class="title-title"><?= lang("Document Expired","Document Expired")?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="document_expired-modal-body" class="modal-body" style="max-height: 400px; overflow-y: auto;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
  </div>
  <script type="text/javascript">
$(document).ready(function(){
      $("#frm-bled input,#frm-bled select,#frm-bled textarea").attr('disabled','disabled');
      $("#ed_id,#desc_administrative,#administrative,#bl_detail_id,.attachment,.data_id,#desc_technical,#technical,.status,.desc-note,#commercial,.recomendation,#award_choice,#msr_no,.msr_no,#award,.not-disabled").removeAttr('disabled');
      // $("#kirim-clarification").removeAttr('class');
      // $("#kirim-clarification").attr('class','btn btn-primary disabled');

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
  $("#administrative_approval").change(function(){
    if($(this).val() == '0')
    {
      $("#deskripsi_approvaladministrative").attr('required', '')
    }
    else
    {
      $("#deskripsi_approvaladministrative").removeAttr('required')
    }
  })
  //hide next and previous button
  $('a[href="#next"]').hide();
  $('a[href="#previous"]').hide();

    });
    $("input,select,textarea").attr('disabled','disabled');
    function adm(bl_detail_id,administrative,type) {
      if(type == 'pass')
      {
        $("#adm-confirm").html('Pass Evaluation Confirmation');
        $("#body-adm-confirm").html('Are You Sure to Pass?');
      }
      else
      {
        $("#adm-confirm").html('Fail Evaluation Confirmation');
        $("#body-adm-confirm").html('Are You Sure to Fail?');
      }
      $("#bl_detail_id").val(bl_detail_id);
      $("#administrative").val(administrative);
      $("#modal-pass-adm").modal('show');
    }
    function admClick() {
      var blDetailId = $('#bl_detail_id').val();
      $.ajax({
        type:'post',
        data:{id:blDetailId,administrative:$('#administrative').val(),desc_administrative:$('#desc_administrative').val()},
        url:"<?=base_url('approval/approval/administrative')?>",
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        success: function (data) {
          var r = eval("("+data+")");
          $("#modal-pass-adm").modal('hide');
          $("#adm-result-"+blDetailId).html(r.msg);
          $("#adm-remark-"+blDetailId).html(r.remark);
          stop($('#icon-tabs'));
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#icon-tabs'));
        }
      })
    }
    function evaluationupload(type) {
      var form = $('#frm'+type)[0];
      var data = new FormData(form);
      $.ajax({
          type: "POST",
          enctype: 'multipart/form-data',
          url: "<?=base_url('approval/approval/evaluationupload')?>/"+type,
          data: data,
          processData: false,
          contentType: false,
          cache: false,
          timeout: 600000,
          success: function (data) {
            var x = eval("("+data+")");
            alert(x.msg);
            $("#modal-upload-"+type).modal('hide');
          },
          error: function (e) {
            alert('Fail, Try Again');
          }
      });
    }
    function tech(bl_detail_id,technical,type) {
      if(type == 'pass')
      {
        $("#tech-confirm").html('Pass Evaluation Confirmation');
        $("#body-tech-confirm").html('Are You Sure to Pass?');
      }
      else
      {
        $("#tech-confirm").html('Fail Evaluation Confirmation');
        $("#body-tech-confirm").html('Are You Sure to Fail?');
      }
      $("#bl_detail_id").val(bl_detail_id);
      $("#technical").val(technical);
      $("#modal-pass-tech").modal('show');
    }
    function commercial(bl_detail_id,technical,type) {
      if(type == 'pass')
      {
        $("#commercial-confirm").html('Pass Evaluation Confirmation');
        $("#body-commercial-confirm").html('Are You Sure to Pass?');
      }
      else
      {
        $("#commercial-confirm").html('Fail Evaluation Confirmation');
        $("#body-commercial-confirm").html('Are You Sure to Fail?');
      }
      $("#bl_detail_id").val(bl_detail_id);
      $("#commercial").val(technical);
      $("#modal-pass-commercial").modal('show');
    }
    function techClick() {
      var blDetailId = $('#bl_detail_id').val();
      $.ajax({
        type:'post',
        data:{id:$('#bl_detail_id').val(),technical:$('#technical').val(),desc_technical:$('#desc_technical').val()},
        url:"<?=base_url('approval/approval/administrative')?>",
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#icon-tabs'));
        },
        success:function(data){
          var r = eval("("+data+")");
          $("#modal-pass-tech").modal('hide');
          $("#tech-result-"+blDetailId).html(r.msg);
          $("#tech-remark-"+blDetailId).html(r.remark);
          stop($('#icon-tabs'));
        }
      })
    }
    function commercialClick() {
      var blDetailId = $('#bl_detail_id').val();
      $.ajax({
        type:'post',
        data:{id:$('#bl_detail_id').val(),commercial:$('#commercial').val(),desc_commercial:$('#desc_commercial').val()},
        url:"<?=base_url('approval/approval/administrative')?>",
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#icon-tabs'));
        },
        success:function(data){
          var r = eval("("+data+")");
          $("#modal-pass-commercial").modal('hide');
          $("#com-result-"+blDetailId).html(r.msg);
          $("#com-remark-"+blDetailId).html(r.remark);
          stop($('#icon-tabs'));
        }
      })

      /*$.ajax({
        type:'post',
        data:{id:$('#bl_detail_id').val(),commercial:$('#commercial').val(),desc_commercial:$('#desc_commercial').val()},
        url:"<?=base_url('approval/approval/administrative')?>",
        success:function(e){
          alert(e);
          $("#modal-pass-tech").modal('hide');
        },
        errorr:function(e){
          alert('Update error, try again');
        }
      })*/
    }
    function scoringChange(elementId,blDetailId) {
      var n = $("#"+elementId).val();
      $.ajax({
        type:'post',
        data:{n:n,bl_detail_id:blDetailId},
        url:"<?=base_url('approval/approval/scoring')?>",
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        success: function (data) {
          $("#"+elementId+"-result").html(data);
          stop($('#icon-tabs'));
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#icon-tabs'));
        }
      })
    }
    const numberWithCommas = (x) => {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function awardRecomendationClick() {

    }
    function document_expired(id) {
        $.ajax({
            url : '<?= base_url('vendor/registered_supplier/document_expired') ?>/'+id,
            success : function(response) {
                $('#document_expired-modal-body').html(response);
                $('#document_expired-modal').modal('show');
            }
        })
    }
    $(function() {
        $('#document_expired-modal').on('hidden.bs.modal', function() {
            $('#document_expired-modal-body').html('');
        });
    });
  </script>