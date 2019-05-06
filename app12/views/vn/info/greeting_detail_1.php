<!-- datepicker  -->
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="<?=base_url('ast11')?>/app-assets/vendors/js/pickers/daterange/daterangepicker.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/pickadate/pickadate.css">
<?php
  $row      = $this->vendor_lib->greeting_list($type,$bled_no)->row();
  $doc      = $this->vendor_lib->tUpload('bled',$row->msr_no)->result();
  $msrItem  = $this->vendor_lib->msrItem($row->msr_no)->result();
  $msrItemList = [];
  foreach ($msrItem as $key => $value) {
  	$msrItemList[] = $value->line_item;
  }
  $t_bid_bond  = $this->vendor_lib->tBidBond($bled_no, $vendor_id)->result();
  $bidHead = $this->vendor_lib->tBidHead($bled_no, $this->session->userdata('ID'))->row();
?>
<div class="app-content content">
	<div class="content-wrapper">
		<div class="content-header row">
			<div class="content-header-left col-md-6 col-12 mb-1">
				<h3 class="content-header-title">Bid Proposal For <?=$bled_no?></h3>
			</div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                    <li class="breadcrumb-item">Bid Proposal</li>
                  </ol>
                </div>
            </div>
		</div>
		<div class="content-body">
			<section id="configuration">
				<div class="content-body">
					<section id="icon-tabs">
						<div class="card">
							<div class="card-content collapse show">
								<div class="card-body">
                            		<div class="icons-tab-steps wizard-circl">
                            			<h6><i class="step-icon fa fa-info"></i> Invitation</h6>
                            			<fieldset>
                            				<div class="row">
                            					<div class="col-md-12">
                        							<table class="table table-condensed table-striped" style="font-size: 12px;">
                        								<tbody>
                        									<tr>
                        										<td width="20%">Company</td>
                        										<td width="30%"><?=$row->company_name?></td>
                        										<td width="20%">Currency</td>
                        										<td width="30%"><?=$row->currency?></td>
                        									</tr>
                        									<tr>
                        										<td>Enquiry No</td>
                        										<td><?=$row->bled_no?></td>
                        										<td>Envelope System</td>
                        										<td><?=@$row->envelope_system == 1 ? "1 Envelope":"2 Envelopes" ?></td>
                        									</tr>
                        									<tr>
                        										<td>Subject Title</td>
                        										<td><?=$row->title?></td>
                        										<td>Packet/Itemize</td>
                        										<td><?=@$row->packet == 1 ? "Itemize":"Packet" ?></td>
                        									</tr>
                        									<tr>
                        										<td>Invitation Date</td>
                        										<td><?=dateToIndo($row->issued_date)?></td>
                        										<td>Bid Bond</td>
                        										<td>
                        											<?php
                        											if ($row->bid_bond_type == 2) {
                        												echo 'Not Applicable';
                        											} elseif ($row->bid_bond_type == 1) {
                        												echo $row->bid_bond.' %';
                        											}elseif ($row->bid_bond_type == 3) {
                        												echo $row->currency.' '.numIndo($row->bid_bond);
                        											} else {
                        												echo '-';
                        											}
                        											?>
                        										</td>
                        									</tr>
                        									<tr>
                        										<td>Bid Validity</td>
                        										<td><?=dateToIndo($row->bid_validity)?></td>
                        										<td>Bid Bond Validity</td>
                        										<td><?=dateToIndo($row->bid_bond_validity)?></td>
                        									</tr>
                        									<tr>
                        										<td>Pre Bid Address</td>
                        										<td><?=nl2br($row->prebid_address)?></td>
                                                                <?php if ($row->id_msr_type == 'MSR01') { ?>
                        										<td>Incoterm</td>
                        										<td>
                        											<?=@$row->incoterm?>
                        										</td>
                                                                <?php } ?>
                        									</tr>
                        									<tr>
                        										<td>Pre Bid Date</td>
                        										<td><?=dateToIndo($row->prebiddate, false, true)?></td>
                                                                <?php if ($row->id_msr_type == 'MSR01') { ?>
                        										<td>Delivery Point</td>
                        										<td>
                        											<?=@$row->loc ?>
                        										</td>
                                                                <?php } ?>
                        									</tr>
                        									<tr>
                        										<td>Closing Date</td>
                        										<td <?= $row->status_closing_date == 'Close' ? 'style="color: #FF0000"':'' ?>><?=dateToIndo($row->closing_date, false, true)?></td>
                        									</tr>
                        								</tbody>
                        							</table>
                            					</div>
                            				</div>
                            			</fieldset>
                            			<h6><i class="step-icon fa fa-download"></i>Attachment</h6>
                            			<fieldset id="form-attachment">
                            				<div class="row">
                            					<div class="col-md-12">
                            						<div class="table-responsive">
                            							<table class="table table-condensed">
                            								<thead>
                            									<tr>
                            										<th>Type</th>
                            										<th>File Name</th>
                            										<th>Uploaded Date</th>
                            										<th>Uploaded By</th>
                            									</tr>
                            								</thead>
                            								<tbody>
                            									<?php foreach ($doc as $key => $value) {
                            										echo "<tr>
	                            										<td>".biduploadtype($value->tipe, true)."</td>
	                            										<td><a href='".base_url('userfiles/temp/'.$value->file_path)."' target='_blank'>".$value->file_name."</a></td>
	                            										<td>".dateToIndo($value->created_at,false,true)."</td>
	                            										<td>".user($value->created_by)->NAME."</td>
                            										</tr>";
                            									}?>
                            								</tbody>
                            							</table>
                            						</div>
                            					</div>
                            				</div>
                            			</fieldset>
                            			<h6><i class="step-icon fa fa-info"></i>Clarification</h6>
			                            <fieldset>
			                                <?php
			                                    if (($row->confirmed == 1  && strtotime($row->closing_date) >= strtotime(date('Y-m-d H:i:s'))) || $row->bid_opening == 1) {
			                                        $allow_send = true;
			                                    } else {
			                                        $allow_send = false;
			                                    }
			                                    $this->load->view('V_note_clarification',['module_kode'=>'bidnote','data_id'=>$bled_no, 'allow_send' => $allow_send]);
			                                ?>
			                            </fieldset>
			                            <h6><i class="step-icon fa fa-info"></i>Quotation</h6>
										<fieldset>
										    <form action="<?=base_url('vn/info/greetings/quotation')?>" id="quotation" class="icons-tab-steps wizard-circle" method="post" enctype="multipart/form-data">
										        <input type="hidden" name="bled_no" value="<?=$row->bled_no?>">
										        <input type="hidden" name="msr_no" value="<?=$row->msr_no?>">
										        <input type="hidden" name="id_currency" value="<?=$row->id_currency?>">
										        <input type="hidden" name="id_currency_base" value="<?=$row->id_currency_base?>">
												<div class="row">
													<div class="col-md-6">
														<div class="form-group row">
														  <label class="col-12" style="font-weight:bold;">Administration <i class="fa fa-info-circle"></i></label>
														</div>
														<div class="form-group row">
														   <label class="col-md-4">Statement of Conformity  (PDF Files)</label>
    										                <div class="col-md-8">
    										                    <input type="file" name="soc" required="">
    										                    <input name="soc_file" type="hidden" value="<?= @$bidHead->soc ?>">
    										                    <?php if (@$bidHead->soc) { ?>
    										                        <a href="<?= base_url('upload/bid/'.$bidHead->soc) ?>" class="download-link-form" target="_blank"><i class="fa fa-download"></i> Statement of Conformity File</a>
    										                    <?php } ?>
    										                </div>
														</div>
														<br>
														<div class="form-group row">
															<label class="col-12" style="font-weight:bold;">Technical <i class="fa fa-info-circle"></i></label>
														</div>
														<div class="form-group row">
															<label class="col-4">Technical Proposal (PDF Files)</label>
										                    <div class="col-md-8">
										                        <input type="file" name="tp" required="">
										                        <input name="tp_file" type="hidden" value="<?= @$bidHead->tp ?>">
										                        <?php if (@$bidHead->tp) { ?>
										                            <a href="<?= base_url('upload/bid/'.$bidHead->tp) ?>" class="download-link-form"><i class="fa fa-download"></i> Technical Proposal File</a>
										                        <?php } ?>
										                    </div>
														</div>
														<div class="form-group row">
															<label class="col-4"><?= $row->id_msr_type == 'MSR01' ? 'Delivery Time' : 'Work Duration' ?></label>
    										                <div class="col-md-4">
    										                    <input name="delivery_nilai" id="delivery_nilai" class="form-control" type="text" value="<?= @$bidHead->delivery_nilai ?>" >
    										                </div>
    										                <div class="col-md-4">
    										                    <select class="form-control" name="delivery_satuan" id="delivery_satuan">
    										                        <option <?= @$bidHead->delivery_satuan == 'WEEK' ? "selected" : "" ?> value="WEEK">WEEK</option>
    										                        <option <?= @$bidHead->delivery_satuan == 'MONTH' ? "selected" : "" ?> value="MONTH">MONTH</option>
    										                    </select>
    										                </div>
														</div>
													</div>
													<div class="col-md-6">
														<div class="form-group row">
														  <label class="col-12" style="font-weight:bold;">Commercial <i class="fa fa-info-circle"></i></label>
														</div>
														<div class="form-group row">
														   <label class="col-md-4">Bid Letter No</label>
    										                <div class="col-md-8">
    										                    <div class="row">
    										                        <div class="col-md-6">
    										                            <input name="bid_letter_no" id="bid_letter_no" class="form-control" required="" value="<?= @$bidHead->bid_letter_no ?>">
    										                            <input name="bid_letter_file" type="hidden" value="<?= @$bidHead->bid_letter_path ?>">
    										                        </div>
    										                        <div class="col-md-6">
    										                            <input type="file" name="bid_letter_path" required="">
    										                        </div>
    										                    </div>
    										                    <?php if (@$bidHead->bid_letter_path) { ?>
    										                        <a href="<?= base_url('upload/bid/'.$bidHead->bid_letter_path) ?>"><i class="fa fa-download"></i> Bid Letter File</a>
    										                    <?php } ?>
    										                </div>
														</div>
														<div class="form-group row">
															<label class="col-4">Bid validity</label>
										                    <div class="col-md-4">
										                      <input name="bid_validity" id="bid_validity" class="form-control mydate" value="<?= @$bidHead->bid_validity ?>" >
										                    </div>
														</div>
														<div class="form-group row">
															<label class="col-4">Local content (TKDN)</label>
										                    <div class="col-md-4">
																<div class="form-group">
										                            <select name="id_local_content_type" class="form-control">
										                                <option value="">Please Select</option>
										                                <?php foreach($this->mvn->get_tkdn_type() as $tkdn_type) { ?>
										                                    <option value="<?= $tkdn_type->id ?>" <?= $tkdn_type->id == @$bidHead->id_local_content_type ? 'selected' : '' ?>><?= $tkdn_type->name ?></option>
										                                <?php } ?>
										                            </select>
										                        </div>
										                    </div>
															<div class="col-md-4">
																<div class="form-group">
																	<div class="input-group">
																		<input name="local_content" id="local_content" class="form-control" required="" value="<?= @$bidHead->local_content ?>" aria-describedby="basic-addon2">
																		<input name="local_content_file" type="hidden" value="<?= @$bidHead->local_content_path ?>">
																		<span class="input-group-addon" id="basic-addon2">%</span>
																	</div>
																</div>
															</div>
															<div class="col-md-4"></div>
															<div class="col-md-8">
																<input type="file" name="local_content_path" required="">
															</div>
															<div class="col-md-4"></div>
															<div class="col-md-4">
																<?php if (@$bidHead->local_content_path) { ?>
										                            <a href="<?= base_url('upload/bid/'.$bidHead->local_content_path) ?>" target="_blank" ><i class="fa fa-download"></i> Local content (TKDN) File</a>
										                        <?php } ?>
															</div>
														</div>
														<div class="form-group row">
															<label class="col-4">Other Commercial Document (PDF Files)</label>
										                    <div class="col-md-8">
    										                    <input type="file" name="pb">
    										                    <input name="pb_file" type="hidden" value="<?= @$bidHead->pl ?>">
    										                    <?php if (@$bidHead->pl) { ?>
    										                        <a href="<?= base_url('upload/bid/'.$bidHead->pl) ?>" class="download-link-form"><i class="fa fa-download"></i> Price Book/Price List File</a>
    										                    <?php } ?>
    										                </div>
														</div>
													</div>
												</div>
												<div class="row">
										            <div class="col-md-12">
														<div class="form-group row">
														  <label class="col-12" style="font-weight:bold;">Note</label>
														</div>
														<div class="form-group row">
															<div class="col-md-12">
    										                    <textarea class="form-control" name="note" name="id" placeholder="Note"><?= @$bidHead->note ?></textarea>
    										                </div>
														</div>
                                                    </div>
                                                </div>

										        <div class="form-group">
                                                    <label style="font-weight: bold;">SOP List Item </label>
										            <div class="table-responsive">
										                <table class="table table-no-wrap">
										                    <thead>
										                        <tr>
										                            <th style="width: 1px">No</th>
										                            <th>Item Type</th>
										                            <th>Description Of Unit</th>
										                            <th class="text-center">Qty 1</th>
                                                                    <th class="text-center">UoM 1</th>
                                                                    <th class="text-center">Qty 2</th>
                                                                    <th class="text-center">UoM 2</th>
										                            <th colspan="2" class="text-center">Delivery Time/Work Duration</th>
										                            <th class="text-center">Currency</th>
                                                                    <th class="text-right">Unit Price</th>
										                            <th class="text-right">Sub Total</th>
										                            <th class="text-center">Deviation</th>
										                            <th>Remark</th>
										                        </tr>
										                    </thead>
										                    <tbody>
										                        <?php
										                            $no=1;
										                            $x = $this->vendor_lib->sop_get(false, $msrItemList)->result();
										                            foreach ($x as $key => $value) :
										                            $tBidDetail = $this->db->where(['vendor_id'=>$vendor_id,'sop_id'=>$value->id])->get('t_sop_bid')->row();
										                            $itemPrice = @$tBidDetail->unit_price ? @$tBidDetail->unit_price : 0;
										                        ?>
										                        <tr>
                                                                    <td><?= $no ?></td>
                                                                    <td><?=$value->id_itemtype?></td>
										                            <td><?=$value->item?></td>
										                            <th class="text-center">
                                                                        <?=$value->qty1?>
                                                                    </td>
                                                                    <th class="text-center"><?=$value->uom1?> - <?=$value->uom1_desc?></td>
                                                                    <th class="text-center">
                                                                        <?php $qty = $value->qty1;?>
                                                                        <?php if($value->qty2): ?>
                                                                            <?=$value->qty2?>
                                                                            <?php $qty = $qty * $value->qty2;?>
                                                                        <?php else: ?>
                                                                            -
                                                                        <?php endif; ?>
                                                                        <input type="hidden" id="qty_<?=$no?>" value="<?=$qty?>" name="qty_[<?=$value->id?>]">
                                                                    </td>
										                            <th class="text-center">
										                                <?php if($value->uom2): ?>
                                                                            <?=$value->uom2?> - <?=$value->uom2_desc?>
                                                                        <?php else : ?>
                                                                            -
										                                <?php endif;?>
										                            </td>
										                            <td style="min-width:150px;">
										                                <input type="text" name="unit_value[<?=$value->id?>]" class="form-control text-center" value="<?= @$tBidDetail->unit_value ?>">
										                            </td>
										                            <td style="min-width: 150px;">
										                                <select class="form-control text-center" name="unit_uom[<?=$value->id?>]" id="unit_uom">
										                                    <option value="WEEK" <?= @$tBidDetail->unit_uom == 'WEEK' ? "selected":"" ?> >WEEK</option>
										                                    <option value="MONTH" <?= @$tBidDetail->unit_uom == 'MONTH' ? "selected":"" ?>>MONTH</option>
										                                </select>
										                            </td>
                                                                    <th class="text-center"><?=$row->currency?></td>
										                            <td>
										                                <input style="width: 140px" value="<?= $itemPrice ?>" type="text" class="form-control text-right" name="unit_price[<?=$value->id?>]" required="" id="unit_price_<?=$no?>" onchange="unitPriceChange()">
										                            </td>
										                            <td id="sub_total_<?=$no?>" class="text-right">
										                                <?= numIndo($qty * $itemPrice) ?>
										                            </td>
										                            <td>
										                                <select style="width: 75px" class="form-control" name="deviation[<?=$value->id?>]" id="deviation_<?=$no?>" onchange="deviationChange(<?=$no?>)">
										                                    <option value="0" <?= @$tBidDetail->deviation == 0 ? "selected=''" : "" ?> >No</option>
										                                    <option value="1" <?= @$tBidDetail->deviation == 1 ? "selected=''" : "" ?> >Yes</option>
										                                </select>
										                            </td>
										                            <td>
                                                                        <input type="text" value="<?= @$tBidDetail->remark ?>" class="form-control" name="remark[<?= $value->id ?>]" id="remark_<?= $no ?>" readonly style="width: 150px;">
										                            </td>
										                        </tr>
										                        <?php $no++;?>
										                        <?php endforeach;?>
										                    </tbody>
                                                            <tfoot>
                                                                <tr style="border-top: 1px solid #CCC;">
                                                                    <td colspan="11">Total</td>
                                                                    <td class="text-right"><span id="bid_proposal_total">0.00</span></td>
                                                                    <td colspan="2"></td>
                                                                </tr>
                                                            </tfoot>
										                </table>
										            </div>
										        </div>
										        <div class="form-group row">
										            <div class="col-md-12 text-center">
										                <!-- <button type="submit" class="btn btn-primary">SUBMIT</button> -->
										                <input type="hidden" id="jmlUnitPrice" class="form-control text-center" value="0">
										            </div>
										        </div>
										        <?php if ($row->bid_bond_type <> 2) { ?>
                                                     <div class="form-group row">
                                                        <div class="col-md-6">
                                                            <label style="font-weight: bold;">Bid Bond</label>
                                                        </div>
                                                        <div class="col-md-6 text-right">
                                                            <?php if ($row->confirmed == 1 && strtotime($row->closing_date) >= strtotime(date('Y-m-d H:i:s'))) { ?>
                                                                <a id="addBidBond" href="#" class="btn btn-success" data-toggle="modal" data-target="#bidBondModal">Add New</a>
                                                            <?php } ?>
                                                        </div>
                                                    </div>
										            <div class="form-group">
										                <div class="table-responsive">
										                    <table class="table">
										                        <thead>
										                            <tr>
										                                <th>Bid Bond No</th>
										                                <th>Issuer</th>
										                                <th>Issued Date</th>
										                                <th class="text-right">Value</th>
										                                <th class="text-center">Currency</th>
										                                <th>Effective Date</th>
										                                <th>Expired Date</th>
										                                <th class="text-center">Document</th>
										                                <th class="text-center">Status</th>
										                                <th>Description</th>
										                                <th class="text-center">Action</th>
										                            </tr>
										                        </thead>
										                        <tbody id="bidbond-tbody">
										                        <?php
										                            $td = "";
										                            foreach ($t_bid_bond as $key => $value) {
										                                $td .= "<tr>
										                                <td>$value->bid_bond_no</td>
										                                <td>$value->issuer</td>
										                                <td>".dateToIndo($value->issued_date)."</td>
										                                <td class='text-right'>".numIndo($value->nominal)."</td>
										                                <td class='text-center'>$value->currency_name</td>
										                                <td>".dateToIndo($value->effective_date)."</td>
										                                <td>".dateToIndo($value->expired_date)."</td>
										                                <td class='text-center'>".($value->bid_bond_file ? '<a href="'.base_url('upload/bid/'.$value->bid_bond_file).'" class="btn btn-info btn-sm">Download</a>' : '-')."</td>
										                                <td class='text-center'>".statusBid($value->status)."</td>
										                                <td>$value->description</td>
										                                <td class='text-center'><button type='button' class='btn btn-danger btn-sm' onclick='deleteBidBond(\"".$value->id."\")'>Delete</button></td>
										                                </tr>";
										                            }
										                            echo $td;
										                        ?>
										                        </tbody>
										                    </table>
										                </div>
										            </div>
										        <?php } ?>
										        <?php if ($row->confirmed == 1 && strtotime($row->closing_date) >= strtotime(date('Y-m-d H:i:s'))) { ?>
										            <div class="form-group text-right">
										                <a href="javascript:void(0)" class="btn btn-danger" id="withdraw-btn" >Withdraw</a>
                                                        <a href="javascript:void(0)" class="btn btn-success" id="bidsumbissionBtn" onclick="sendBidProposal()">Bid Submission</a>
										            </div>
										        <?php } ?>
										    </form>
										</fieldset>
										<h6><i class="fa fa-pencil"></i> Addendum</h6>
			                            <fieldset>
			                                <h4>Log Resume</h4>
			                                <?php foreach ($addendum as $r_addendum) { ?>
			                                  	<div>
			                                    	<p><i>#<?= $r_addendum->no_addendum ?></i><br><small><span class="fa fa-user"></span> <?= $r_addendum->creator ?> | <span class="fa fa-clock-o"></span> <?= dateToIndo($r_addendum->created_at, false, true) ?></small></p>
			                                    	<p><?= nl2br($r_addendum->resume) ?></p>
			                                  	</div>
			                                  	<hr>
			                                <?php } ?>
			                            </fieldset>
                            		</div>
                            	</div>
                            </div>
						</div>
					</section>
				</div>
			</section>
		</div>
	</div>
</div>

<div class="modal fade" id="myWith" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: red">
        <h4 class="modal-title" id="myModalLabel" style="color: white">Withdraw Confirmation</h4>
      </div>
      <div class="modal-body">
        <form method="post" class="form-horizontal open-this" enctype="multipart/form-data" action="<?=base_url('vn/info/greetings/confirmation')?>">
          <input type="hidden" name="id" value="<?=$row->bldetail_id?>">
          <input type="hidden" name="status" value="3">
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
                  We acknowledge receipt your complete set of Enquiry Document dated on <?=dateToIndo($row->closing_date, false, true)?> for subject services, and<br>
                  hereby confirm that we withdraw from further participation in the bidding process .<br>
                  We further confirm that we shall treat the Enquiry Document as confidential matter and only disclose to others<br>
                  such information as is necessary for the preparation of the Bid Proposal.<br>
                </td>
              </tr>
            </table>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <textarea class="form-control" required="" rows="3" name="reason" id="reason"></textarea>
            </div>
          </div>
          <div class="form-group" style="background: red;padding-bottom: 10px">
            <div class="col-sm-12 text-center">
              <center style="color: #fff">
                Are you sure Withdraw ?
              </center>
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-danger">Withdraw</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="bidBondModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Bid Bond Document</h4>
      </div>
      <div class="modal-body">
        <form method="post" enctype="multipart/form-data" class= "open-this" id="frm-bid-modal">
          <input type="hidden" name="bled_no" id="bled_no" value="<?=$bled_no?>">
          <input type="hidden" name="status" id="status" value="1">
          <div class="form-group">
            <label>Bid Bond No</label>
            <input class="form-control" name="bid_bond_no" id="bid_bond_no" required="" />
          </div>
          <div class="form-group">
            <label>Bid Bond Document</label><br>
            <input type="file" name="bid_bond_file" id="bid_bond_file" required="" />
          </div>
          <div class="form-group">
            <label>Issuer</label>
            <input class="form-control" name="issuer" id="issuer" required="" />
          </div>
          <div class="form-group">
            <label>Issued Date</label>
            <input class="form-control mydate" name="issued_date" id="issued_date" required="" />
          </div>
          <div class="form-group">
            <label>Value</label>
            <input type="text" class="form-control" name="nominal" id="nominal" required="" />
          </div>
          <div class="form-group">
            <label>Currency</label>
            <?=optCurrency('currency')?>
          </div>
          <div class="form-group">
            <label>Effective Date</label>
            <input class="form-control mydate" name="effective_date" id="effective_date" />
          </div>
          <div class="form-group">
            <label>Expired Date</label>
            <input class="form-control mydate" name="expired_date" id="expired_date" />
          </div>
          <div class="form-group">
            <label>Description</label>
            <input class="form-control" name="description" id="description" />
          </div>
          <div class="form-group text-right">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="button" onclick="saveBidBond()" class="btn btn-success">Submit</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="bidsumbissionModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #16D39A !important">
        <h4 class="modal-title" id="myModalLabel">Bid Sumbission</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="" class="form-horizontal open-this" id="frm-bid-sumbission">
          <div class="form-group">
            <label>You will be send Bid Proposal</label>
          </div>
          <div class="form-group">
            <div class="col-sm-12 text-right">
              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
              <button type="button" onclick="sendBidProposal()" class="btn btn-success">Yes Continue</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
  $(function() {
    $('[name*="unit_price"], #nominal').number(true, 2);
  });

  function saveBidBond() {
  	$('#frm-bid-modal-error').remove();
  	var form = $('#frm-bid-modal')[0];
    var formData = new FormData(form);
    $.ajax({
      type:'POST',
      enctype:'multipart/form-data',
      data:formData,
      processData: false,
      contentType: false,
      url:"<?=base_url('vn/info/greetings/savebidbond')?>",
      success:function(e){
      	var r = $.parseJSON(e);
      	if (r.error) {
      		$('#frm-bid-modal').prepend('<div id="frm-bid-modal-error" class="alert alert-danger" style="font-size:12px;">'+r.error+'</div>');
      	} else {
        	$("#bidbond-tbody").html(r.data);
        	$("#bidBondModal").modal('hide');
        	isBidBondExists();
        }
      }
    });
  }
// Wizard tabs with icons setup
$(".icons-tab-steps").steps({
    headerTag: "h6",
    bodyTag: "fieldset",
    transitionEffect: "fade",
    titleTemplate: '#title#',
    enableFinishButton: false,
    enablePagination: true,
    enableAllSteps: true,
    enableFinishButton: false,
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

function unitPriceChange() {
  var unitPrice = 0;
  for(i=1; i <= <?=$no-1?>; i++){
    if($("#unit_price_"+i).val() === '')
    {
      unit_price = parseInt(0);
    }
    else
    {
      unit_price = parseFloat($("#unit_price_"+i).val());
    }

    subTotal  = parseFloat(unit_price)*parseInt($("#qty_"+i).val());
    // alert(subTotal)
    $("#sub_total_"+i).text(Localization.number(subTotal));
    unitPrice += subTotal;
  }
  $('#bid_proposal_total').html(Localization.number(unitPrice));
  <?php if($row->currency == 'USD'):?>
    $("#jmlUnitPrice").val(unitPrice);
  <?php else:?>
    unitPrice = exchange_rate(unitPrice);
    $("#jmlUnitPrice").val(unitPrice);
  <?php endif;?>

  // alert(unitPrice);
  if(parseInt(unitPrice) >= parseInt(minbidbond()))
  {
    $("#addBidBond").removeAttr('class');
    $("#addBidBond").attr('class','btn btn-success pull-right');
  }
  else if (parseInt(unitPrice) < parseInt(minbidbond()))
  {
    if(parseInt(<?=$row->bid_bond_type?>) == 2)
    {
      $("#addBidBond").removeAttr('class');
      $("#addBidBond").attr('class','btn btn-success pull-right disabled');
    }
    else
    {
      $("#addBidBond").removeAttr('class');
      $("#addBidBond").attr('class','btn btn-success pull-right');
    }
  }
}

const numberWithCommas = (x) => {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
}
function sendBidProposal() {
  if(myValidation())
  {
    swalConfirm('Bid Proposal', '<?= __('confirm_submit') ?>', function() {
        jmlUnitPrice = $("#jmlUnitPrice").val();
        var form = $('#quotation')[0];
        var data = new FormData(form);
        if(parseInt(<?=$row->bid_bond_type?>) == 1 || parseInt(<?=$row->bid_bond_type?>) == 3)
        {
            if(parseInt(jmlUnitPrice) >= parseInt(minbidbond()))
            {
              $.ajax({
                type:'get',
                data:{bled_no:'<?=$bled_no?>'},
                url:"<?=base_url('vn/info/greetings/checkbidbond')?>",
                success:function(q){
                  var r = eval("("+q+")");
                  if(r.status)
                  {
                    $.ajax({
                        type: "POST",
                        enctype: 'multipart/form-data',
                        url: "<?=base_url('vn/info/greetings/quotation')?>",
                        data: data,
                        processData: false,
                        contentType: false,
                        cache: false,
                        timeout: 600000,
                        beforeSend:function(){
                          //start($('#icon-tabs'));
                        },
                        success: function (data) {
                          var x = eval("("+data+")");
                          window.open("<?=base_url('vn/info/greetings')?>","_self");
                        },
                        error: function (e) {
                          setTimeout(function() {
                            swal('<?= __('warning') ?>', 'Bid Submission Fail, Try Again', 'warning');
                          }, swalDelay);
                          //stop($('#icon-tabs'));
                        }
                    });
                  }
                  else
                  {
                    setTimeout(function() {
                        swal('<?= __('warning') ?>', 'Bid Bond Is Mandatory', 'warning');
                    }, swalDelay)
                  }
                }
              });
            }
            else
            {
                send_bid_proposal()
            }
        }
        else
        {
        	send_bid_proposal()
        }
    });
  }
}
function send_bid_proposal() {
   var form = $('#quotation')[0];

        // Create an FormData object
      var data = new FormData(form);
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "<?=base_url('vn/info/greetings/quotation')?>",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        beforeSend:function(){
          //start($('#icon-tabs'));
        },
        success: function (data) {
          var x = eval("("+data+")");
          //swal('<?= __('warning') ?>', x.msg, 'warning');
          $("#bidsumbissionModal").modal('hide');
          //stop($('#icon-tabs'));
          window.open("<?=base_url('vn/info/greetings')?>","_self");
        },
        error: function (e) {
          setTimeout(function() {
            swal('<?= __('warning') ?>', 'Bid Submission Fail, Try Again', 'warning');
          }, swalDelay);
          //stop($('#icon-tabs'));
        }
    });
}
function myValidation() {
  if($("#bid_letter_no").val() == ''){
    swal('<?= __('warning') ?>', 'bid Letter no, must be filled', 'warning');
    return false;
  }
  if($("input[name='bid_letter_path']").val() === '' && $("input[name='bid_letter_file']").val() === ''){
    swal('<?= __('warning') ?>', 'bid Letter file, must be upload', 'warning');
    return false;
  }
  if($("select[name='id_local_content_type']").val() === ''){
  	swal('<?= __('warning') ?>', 'Local Content Type, must be select', 'warning');
    return false;
  }
  if($("input[name='local_content']").val() === ''){
  	swal('<?= __('warning') ?>', 'Local Content, must be upload', 'warning');
    return false;
  }
  if($("input[name='local_content_path']").val() === '' && $("input[name='local_content_file']").val() === ''){
  	swal('<?= __('warning') ?>', 'Local content file, must be upload', 'warning');
    return false;
  }
  if($("input[name='delivery_satuan']").val() === ''){
    swal('<?= __('warning') ?>', 'Delivery Time, must be filled', 'warning');
    return false;
  }
  if($("input[name='delivery_nilai']").val() === ''){
    swal('<?= __('warning') ?>', 'Delivery Time, must be filled', 'warning');
    return false;
  }
  if($("input[name='bid_validity']").val() === ''){
  	swal('<?= __('warning') ?>', 'Bid Validity, must be filled', 'warning');
    return false;
  }
  if($("input[name='soc']").val() === '' && $("input[name='soc_file']").val() === ''){
  	swal('<?= __('warning') ?>', 'Statement of Conformity file, must be upload', 'warning');
    return false;
  }
  if($("input[name='tp']").val() === '' && $("input[name='tp_file']").val() === ''){
  	swal('<?= __('warning') ?>', 'Technical Proposal file, must be upload', 'warning');
    return false;
  }
  /*if($("input[name='pb']").val() === '' && $("input[name='pb_file']").val() === ''){
  	alert('Price Book file, must be upload');
    return false;
  }*/
  for(i=1; i <= <?=$no-1?>; i++){
    if(parseInt($("#unit_price_"+i).val()) <= 0){
      swal('<?= __('warning') ?>', 'Unit Price, must be more then 0', 'warning');
      return false;
    }
  }
  return true;
}
function checkBidBond() {
  $.ajax({
    type:'get',
    data:{bled_no:'<?=$bled_no?>'},
    url:"<?=base_url('vn/info/greetings/checkbidbond')?>",
    success:function(q){
      var r = eval("("+q+")");
      if(r.status)
      {
        // alert(r.status);
        return true;
      }
      else
      {
        // alert(r.status);
        return false;
      }
    }
  });
}
</script>
<script src="<?= base_url() ?>ast11/assets/js/tables/jquery-1.12.3.js"></script>
<script src="<?= base_url() ?>ast11/js/plugins/datapicker/bootstrap-datepicker.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  $('.mydate').datetimepicker({format : 'YYYY-MM-DD'});
  $("#withdraw-btn").click(function(){
    swalConfirm('Withdraw', 'Are you sure to proceed ?', function() {
        $.ajax({
            type:'post',
            data:{msr_no:'<?=$row->msr_no?>'},
            url:"<?=base_url('vn/info/greetings/withdraw')?>",
            beforeSend:function(){
              start($('#icon-tabs'));
            },
            success:function(q){
              stop($('#icon-tabs'));
              document.location.href = '<?= base_url('vn/info/greetings') ?>';
            },
        });
    });
  });
});
function deviationChange(no) {
  a  = $("#deviation_"+no).val();
  if(a == '0')
  {
    $("#remark_"+no).attr("readonly","");
  }
  else if(a == '1')
  {
    $("#remark_"+no).removeAttr("readonly");
  }
}

$(function() {
	<?php if($row->confirmed == 1  && strtotime($row->closing_date) >= strtotime(date('Y-m-d H:i:s'))):?>
		$('#quotation').addClass('open-this');
		$('#form-attachment').addClass('open-this');
  	<?php endif;?>
	isBidBondExists();
	$('#local_content').keyup(function() {
		var value = $('#local_content').val();
		if (!$.isNumeric(value)) {
			$('#local_content').val(0);
		} else {
			if (value > 100) {
				$('#local_content').val(100);
			}
			if (value < 0) {
				$('#local_content').val(0);
			}
		}
	});
});

function deleteBidBond(id) {
    swalConfirm('BID Bond', 'Are you sure to proceed ?', function() {
        $.ajax({
          url:"<?=base_url('vn/info/greetings/deletebidbond/'.$bled_no)?>/"+id,
          success:function(e){
            var r = $.parseJSON(e);
            $("#bidbond-tbody").html(r.data);
            isBidBondExists();
          }
        });
    });
}

function isBidBondExists() {
	if ($("#bidbond-tbody tr").length == 0) {
		$('#addBidBond').show();
	} else {
		$('#addBidBond').hide();
	}
}

$(function() {
    unitPriceChange();
    $('#delivery_nilai').keyup(function() {
        $('[name*="unit_value"]').val($('#delivery_nilai').val());
    });
    $('#delivery_satuan').change(function() {
        $('[name*="unit_uom"]').val($('#delivery_satuan').val());
    });
});
function find_exchange_rate_base() {
    rate = "<?=find_exchange_rate_base($row->currency, 'USD')?>";
    return rate;
}
function exchange_rate(amount)
{
    rate = find_exchange_rate_base();
    return amount * rate;
}
function minbidbond() {
    return "<?=exchange_rate('IDR','USD',minbidbond)?>";
}
</script>