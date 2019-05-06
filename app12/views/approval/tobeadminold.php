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
          <h3 class="content-header-title mb-0">Enquiry Document Development</h3>
          <div class="table-responsive info-header">
            <table class="table table-condensed table-striped">
              <tr>
                <td>Company</td>
                <td width="15">:</td>
                <td><?=$msr->company_name?></td>
                <td>Department</td>
                <td width="15">:</td>
                <td><?=$msr->company_name?></td>
              </tr>
              <tr>
                <td>MSR Number</td>
                <td>:</td>
                <td><?=$msr_no?></td>
                <td>Proc Method</td>
                <td>:</td>
                <td><?=$msr->proc_method_name?></td>
              </tr>
              <tr>
                <td>ED Number</td>
                <td>:</td>
                <td><?=str_replace('OR', 'OQ', $msr_no)?></td>
                <td>MSR Value</td>
                <td>:</td>
                <td><?=$msr->currency?> <?=numIndo($msr->total_amount_base,0)?> (<small style="color:red"><i>Exclude VAT</i></small>)</td>
              </tr>
            </table>
          </div>
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
                      <h6><i class="step-icon fa fa-info"></i> Quotation</h6>
                      <fieldset>
                        <h3>Quotation Status</h3>
						<div class="row">
							<div class="col-md-6">
							  <div class="table-responsive">
								<table class="table table-condensed  ">
								  <tr>
									<td width="200">Invitation Date</td>
									<td>
									  <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
										<?=dateToIndo($t_bl->created_at)?>    
									  </label>
									</td>
								  </tr>
								  <tr>
									<td>Pre Bid Date Date</td>
									<td>
									  <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px"><?=dateToIndo($ed->prebiddate, false, true)?>
									  </label>
									</td>
								  </tr> 
								</table>
							  </div>
							</div>
							<div class="col-md-6">
							  <div class="table-responsive">
								<table class="table table-condensed  "> 
								  <tr>
									<td>Bid Validity</td>
									<td>
									  <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
										<?=dateToIndo($ed->bid_validity, false, true)?>
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
						</div>
                        <div class="col-md-12">
                          <div class="table-responsive">
                            <table class="table table-condensed table-striped">
                              <thead>
                                <tr>
                                  <th rowspan="2" width="15">NO</th>
                                  <th rowspan="2">SLKA NO</th>
                                  <th rowspan="2">Bidder(s) Name</th>
                                  <th rowspan="2">Submission Date</th>
                                  <th rowspan="2">Status</th>
                                  <th colspan="3" class="text-center">Evaluation Status</th>
                                  <th rowspan="2">Awarded</th>
                                </tr>
                                <tr>
                                  <th>Administrative</th>
                                  <th>Tecnical</th>
                                  <th>Commercial</th>
                                </tr>
                              </thead>
                              <tbody>
                                <?php 
                                $no=1;
                                foreach ($blDetails->result() as $blDetail) {
                  $submission_date = $blDetail->confirmed == 0 ? '': dateToIndo($blDetail->submission_date);
                  $seequotation = $blDetail->confirmed == 1 ? "<a href='#' data-toggle='modal' data-target='#seequotation$no' class='btn btn-sm btn-primary'>See Quotation</a>" : "";
                                  echo "<tr>
                                  <td>$no</td>
                                  <td>$blDetail->no_slka</td>
                                  <td>$blDetail->vendor_name</td>
                                  <td>$submission_date</td>
                                  <td>".statusBidVendor($blDetail->confirmed)."$seequotation </td>
                                  <td>".evaluationStatus($blDetail->administrative)."</td>
                                  <td>".evaluationStatus($blDetail->technical)."</td>
                                  <td>".evaluationStatus($blDetail->commercial)."</td>
                                  </tr>";
                                  $no++;
                                }
                                ?>
                              </tbody>
                            </table>
                          </div>
                        </div>
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
                            Administrative
                          </div>
                          <div class="col-md-12 text-center">
                            <?php 
                              $btndis = '';
                              $btndis2 = true;
                              $disAdm = 'disabled';
                              if(in_array(assign_sp, $roles))
                              {
                                $disAdm = '';
                              }
                              if (isset($approved_administration)):
                                $btndis = $approved_administration->administrative == 3 || $approved_administration->administrative == 1 ? '':'disabled';
                                $btndis2 = $approved_administration->administrative == 3 || $approved_administration->administrative == 1  || $approved_administration->administrative == 4 ? false:true;
                                $btnApprovalAdmin = $approved_administration->administrative == 3 ? "hidden":"";
                            ?>
                              <a href="<?=base_url('upload/evaluation/'.$adminAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
                            <?php else:?>
                              <a href="#" data-toggle="modal" data-target="#modal-upload-administrative" class="btn btn-sm btn-primary <?=$disAdm?>">Upload</a>
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
                                    <?php if($btndis2): ?>
                                      <th>Action</th>
                                    <?php endif;?>
                                    <th>Result</th>
                                    <th>Remark</th>
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
                                    if($btndis2)
                                    {
                                      echo "<td>
                                        <a href='#' onclick=\"adm('$blDetail->bl_detail_id',1,'pass')\" class='btn btn-sm btn-success'><i class='fa fa-check'></i></a>
                                        <a href='#' onclick=\"adm('$blDetail->bl_detail_id',2,'check')\" class='btn btn-sm btn-danger'><i class='fa fa-stop'></i></a>
                                      </td>";
                                    }
                                    echo "<td id='adm-result-$blDetail->bl_detail_id'>".evaluationStatus($blDetail->administrative)."</td>
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
                        
                        <!-- Step Technical -->
                        <div class="row">
                          <div class="col-md-12">
                            Technical
                          </div>
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
                              <a href="<?=base_url('upload/evaluation/'.$technicalAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
                            <?php else:?>
                              <a href="#" data-toggle="modal" data-target="#modal-upload-technical" class="btn btn-sm btn-primary <?=$disTech?>">Upload</a>
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
                                        <th>Action</th>
                                      <?php endif;?>
                                    <?php endif;?>
                                    <th>Result</th>
                                    <th>Remark</th>
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
                                      if($btndis2Tech)
                                      {
                                        if($ed->technical_data == 2)
                                        {
                                          echo "<td><input type='number' onchange=\"scoringChange('tech-$no','$blDetail->bl_detail_id')\" id='tech-$no' class='form-control attachment' min='0' max='100' value='$blDetail->scoring'></td>";
                                        }
                                        else
                                        {
                                          echo "<td>
                                            <a href='#' onclick=\"tech('$blDetail->bl_detail_id',1,'pass')\" class='btn btn-sm btn-success $disTech'><i class='fa fa-check'></i></a>
                                            <a href='#' onclick=\"tech('$blDetail->bl_detail_id',2,'check')\" class='btn btn-sm btn-danger $disTech'><i class='fa fa-stop'></i></a>
                                          </td>";
                                        }
                                      }
                                      if($ed->technical_data == 2)
                                      {
                                        echo "<td id='tech-$no-result'>".($blDetail->scoring)."</td>";
                                      }
                                      else
                                      {
                                        echo "<td>".evaluationStatus($blDetail->technical)."</td>";
                                      }
                                      echo "<td></td></tr>";
                                      $no++;
                                    }
                                  }
                                  ?>
                                </tbody>
                              </table>
                            </div>
                          </div>
                        </div>

                        <?php if(isset($commercial)): ?>
                        <!-- Step Commercial -->
                        <div class="row">
                          <div class="col-md-12">
                            Commercial
                          </div>
                          <div class="col-md-12 text-center">
                            <?php 
                              $btndisCom = '';
                              $btndisCom2 = true;
                              $disCom = 'disabled';
                              if(in_array(bled, $roles))
                              {
                                $disCom = '';
                              }
                              if (isset($approved_commercial)):
                                $btndisCom = $approved_commercial->commercial == 3 || $approved_commercial->commercial == 1 ? '':'disabled';
                                $btndisCom2 = $approved_commercial->commercial == 3 || $approved_commercial->commercial == 1  || $approved_commercial->commercial == 4 ? false:true;
                                $btnApprovalCom = $approved_commercial->commercial == 3 ? "hidden":"";
                            ?>
                              <a href="<?=base_url('upload/evaluation/'.$commercialAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
                            <?php else:?>
                              <a href="#" data-toggle="modal" data-target="#modal-upload-commercial" class="btn btn-sm btn-primary <?=$disCom?>">Upload</a>
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
                                    <?php if($btndis2): ?>
                                      <th>Action</th>
                                    <?php endif;?>
                                    <th>Result</th>
                                    <th>Remark</th>
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
                                    if($btndisCom2)
                                    {
                                      echo "<td>
                                        <a href='#' onclick=\"commercial('$blDetail->bl_detail_id',1,'pass')\" class='btn btn-sm btn-success $disTech'><i class='fa fa-check'></i></a>
                                        <a href='#' onclick=\"commercial('$blDetail->bl_detail_id',2,'check')\" class='btn btn-sm btn-danger $disTech'><i class='fa fa-stop'></i></a>
                                      </td>";
                                    }
                                    echo "<td>".evaluationStatus($blDetail->commercial)."</td>
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
                        <?php endif;?>

                        <!-- Step Price Evaluation -->
                        <div class="row" style="margin-top: 30px">
                          <div class="col-md-12" style="margin-bottom: 10px">
                            Price Evaluation Quotation
                          </div>
                          <div class="col-md-12">
                            <?php $this->load->view('approval/priceevaluationnegotiation',['ed'=>$ed, 'isi'=>'quotation']);?>
                          </div>
                          <?php if($this->input->get('devmode')): ?>
                          <div class="col-md-12" style="margin-top: 20px">
                            <table class="table table-condensed">
                              <thead>
                                <tr>
                                  <th>VENDOR</th>
                                  <th>NILAI TEKNIS</th>
                                  <th>BOBOT TEKNIS (<?=$ed->bobot_teknis?>%)</th>
                                  <th>HARGA</th>
                                  <th>NILAI KOMERSIAL</th>
                                  <th>BOBOT KOMERSIAL (<?=$ed->bobot_komersial?>%)</th>
                                  <th>TOTAL NILAI</th>
                                  <th>RANK</th>
                                </tr>
                              </thead>
                              <tbody>
                              <?php 
                              $nilai = [];
                              foreach ($this->approval_lib->bidDetailByBled($bled_no)->result() as $bidDetail) {
                                $nilai[] = $bidDetail->price_total;
                              }
                              $totalNilai = [];
                              foreach ($this->approval_lib->bidDetailByBled($bled_no)->result() as $bidDetail) {
                                @$t_bl_detail = $this->db->where(['msr_no'=>$msr_no,'vendor_id'=>$bidDetail->vendor_id])->get('t_bl_detail')->row();
                                @$bobot_teknis = ($ed->bobot_teknis/100)*$t_bl_detail->scoring;
                                @$findNilaiKomersial = findNilaiKomersial($nilai, $bidDetail->price_total);
                                @$bobot_komersial = ($ed->bobot_komersial/100)*$findNilaiKomersial;
                                @$total_nilai = $bobot_komersial+$bobot_teknis;
                                $totalNilai[$bidDetail->vendor_id] = $total_nilai;
                              }
                              asort($totalNilai);
                              $r = 1;
                              foreach ($totalNilai as $key => $value) {
                                $s[$key] = $r;
                                $r++;
                              }
                              foreach ($this->approval_lib->bidDetailByBled($bled_no)->result() as $bidDetail) {
                                @$t_bl_detail = $this->db->where(['msr_no'=>$msr_no,'vendor_id'=>$bidDetail->vendor_id])->get('t_bl_detail')->row();
                                @$bobot_teknis = ($ed->bobot_teknis/100)*$t_bl_detail->scoring;
                                @$findNilaiKomersial = findNilaiKomersial($nilai, $bidDetail->price_total);
                                @$bobot_komersial = ($ed->bobot_komersial/100)*$findNilaiKomersial;
                                @$total_nilai = $bobot_komersial+$bobot_teknis;
                                $vendor = $this->db->where(['ID'=>$bidDetail->vendor_id])->get('m_vendor')->row();
                                echo "<tr>
                                  <td>$vendor->NAMA</td>
                                  <td>$t_bl_detail->scoring %</td>
                                  <td>".numIndo($bobot_teknis)." %</td>
                                  <td>".numIndo($bidDetail->price_total,0)."</td>
                                  <td>".numIndo($findNilaiKomersial)." %</td>
                                  <td>".numIndo($bobot_komersial)." %</td>
                                  <td>".numIndo($total_nilai)." %</td>
                                  <td>".$s[$bidDetail->vendor_id]."</td>
                                </tr>";
                              }
                              ?>
                              </tbody>
                            </table>
                          </div>
                          <?php endif;?>
                        </div>

                        <!-- Step Price Negotiation -->
                        <div class="row" style="margin-top: 30px">
                          <div class="col-md-12" style="margin-bottom: 10px">
                            Price Evaluation Negotiation
                          </div>
                          <div class="col-md-12">
                            <?php $this->load->view('approval/priceevaluationnegotiation',['ed'=>$ed, 'isi'=>'nego']);?>
                          </div>
                        </div>
                      </fieldset>

                      <!-- Step 2 -->
                      <h6><i class="step-icon fa fa-th-list"></i>Enquiry Data</h6>
                      <fieldset>
                          <div class="row">
  <!-- left side -->
  <div class="col-md-6">
    <div class="row">
      <div class="form-group col-md-12">
        <label for="proposalTitle2">Subject :</label>
        <input class="form-control" name="subject" id="subject" value="<?=@$ed->subject?>">
      </div>
      <div class="form-group col-md-6">
        <label for="emailAddress4">Pre Bid Date :</label>
        <input class="form-control dp" id="prebiddate" name="prebiddate" value="<?=@$ed->prebiddate?>">
      </div>
      <div class="form-group col-md-6">
        <label for="videoUrl2">Pre Bid Location :</label>
        <?=optLocation('prebid_loc', @$ed->prebid_loc)?>
      </div>
      <div class="form-group col-md-7">
        <label for="emailAddress4">Pre Bid Address :</label>
        <textarea class="form-control" id="prebid_address" name="prebid_address"> <?=@$ed->prebid_address?></textarea>
      </div>
      <div class="form-group col-md-5">
        <label for="emailAddress4">Closing Date :</label>
        <input class="form-control dp" id="closing_date" name="closing_date" value="<?=@$ed->closing_date?>">
      </div>
      <div class="form-group col-md-5">
        <label for="emailAddress4">Envelope System :</label>
        <select class="form-control" name="envelope_system" disabled="">
          <option value="1" <?=@$ed->envelope_system == 1 ? "selected":"" ?> >1 Envelope</option>
          <option value="2" <?=@$ed->envelope_system == 2 ? "selected":"" ?> >2 Envelope</option>
        </select>
      </div>
      <div class="form-group col-md-4">
        <label for="packet">Itemize/Packet</label>
        <select class="form-control" name="packet" id="packet" disabled="">
          <option value="1" <?=@$ed->packet == 1 ? "selected":"" ?> >Itemize</option>
          <option value="2" <?=@$ed->packet == 2 ? "selected":"" ?> >Packet</option>
        </select>
      </div>
      <div class="form-group col-md-3">
        <label for="incoterm">Incoterm</label>
        <select class="form-control" name="incoterm" id="incoterm" disabled="">
          <option value="1" <?=@$ed->incoterm == 1 ? "selected":"" ?> >DDP</option>
          <option value="2" <?=@$ed->incoterm == 2 ? "selected":"" ?> >DAP</option>
        </select>
      </div>
    </div>
  </div>
<!-- right side -->
  <div class="col-md-6">
    <div class="form-group">
      <label for="jobTitle3">Method Evaluation :</label>
      <input class="form-control disabled" value="<?=@edOptData('mix', $ed->commercial_data)?>">
    </div>
    <div class="form-group row">
      <label class="col-md-3" for="jobTitle3">Currency :</label>
      <div class="col-md-4">
        <?=optCurrency('currency', @$ed->currency)?>
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3" for="jobTitle3">Bid Bond :</label>
      <div class="col-md-4">
        <select class="form-control" name="bid_bond_type" id="bid_bond_type" style="margin-bottom: 10px;">
          <option value="1" <?=@$ed->bid_bond_type == 1 ? "selected":""?>>%</option>
          <option value="2" <?=@$ed->bid_bond_type == 2 ? "selected":""?>>Not Applicable</option>
        </select>
      </div>
      <div class="col-md-3">
        <input placeholder="Fill bid here" class="form-control" id="bid_bond"  name="bid_bond" value="<?=@$ed->bid_bond?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3" for="jobTitle3">Bid Bond Validty:</label>
      <div class="col-md-4">
        <input  class="form-control dp" id="bid_bond_validity"  name="bid_bond_validity" value="<?=@$ed->bid_bond_validity?>">
      </div>
    </div>
    <div class="form-group row">
      <label class="col-md-3" for="jobTitle3">Bid Validty :</label>
      <div class="col-md-4">
        <input class="form-control dp" id="bid_validity" name="bid_validity" value="<?=@$ed->bid_validity?>">
      </div>
    </div>
  </div>
</div>
                      </fieldset>
                      <!-- Step 3 -->
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
                      <!-- step 4 -->
                      <h6><i class="step-icon fa fa-info"></i>Clarification</h6>
                      <fieldset>
                        <?php $this->load->view('V_note',['module_kode'=>'bidnote','data_id'=>$bled_no])?>
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
      <!-- footer  -->
      <div class="content-footer">
        <?php 
          if ($btndis == ''): 
        ?>
          <a href="#" class="btn btn-success <?= $ed->administrative == 0 || $ed->administrative == 0 ? '':'hidden' ?>" data-toggle='modal' data-target='#myModalEvaluation' >Administration</a>
        <?php else: ?>
          <a href="#" class="btn btn-success <?=$btnApprovalAdmin?>" data-toggle='modal' data-target='#modalApprovalAdm' >Approval Administration</a>
        <?php endif;?>

        <?php 
          if ($btndisTech == ''): 

        ?>
          <a href="#" class="btn btn-success <?= $ed->technical == 0 || $ed->technical == 2 ? '':'hidden' ?>" data-toggle='modal' data-target='#myModalEvaluationTechnical' >Technical</a>
        <?php else: ?>
          <a href="#" class="btn btn-success <?=$btnApprovalTech?>" data-toggle='modal' data-target='#modalApprovalTech' >Approval Technical</a>
        <?php endif;?>

        <?php 
          if(isset($commercial)):
            if ($btndisCom == ''): 
        ?>
              <a href="#" class="btn btn-success <?= $ed->commercial == 0 || $ed->commercial == 0 ? '':'hidden' ?>" data-toggle='modal' data-target='#myModalEvaluationCommercial' >Commercial Evaluation</a>
            <?php else: ?>
              <a href="#" class="btn btn-success <?=$btnApprovalCom?>" data-toggle='modal' data-target='#modalApprovalCom' >Approval Commercial</a>
          <?php endif;?>
        <?php endif;?>
          <?php 
            if($ed->commercial == 3):
          ?>
            <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modalAckCom' >Acknowledge Commercial</a>
          <?php endif;?>

        
        <?php 
          if($ed->administrative == 3):
        ?>
          <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modalAckAdm' >Acknowledge Administrative</a>
        <?php endif;?>

        <?php 
          if($ed->technical == 3):
        ?>
          <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modalAckTech' >Acknowledge Technical</a>
        <?php endif;?>

        <?php if($ed->administrative == 4 and $ed->commercial == 4 and $ed->technical == 4):?>
          <?php $this->load->view('approval/modalnego', ['ed'=>$ed]);?>
        <?php endif;?>

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
            <div class="form-group row">
              <label class="col-sm-3">
                Choose One
              </label>
              <div class="col-sm-9">
                <select class="form-control status" name="administrative">
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
                Are you Sure to Finish Administration Evaluation
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
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Commercial Evaluation</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/approval/approvalevaluation')?>" class="form-horizontal" id="frmcomeva">
            <input type="hidden" name="ed_id" id="ed_id" value="<?=$ed->id?>">
            <input type="hidden" name="commercial" id="commercial" value="1">
            <div class="form-group">
              <div class="col-sm-12">
                Are you Sure to Finish Commercial Evaluation
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
            <input type="hidden" name="administrative" id="administrative" value="4">
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
            <input type="hidden" name="technical" id="technical" value="4">
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

  <?php 
  $Modalno = 1;
    foreach ($blDetails->result() as $blDetail) {
      $bh = $this->vendor_lib->tBidHead($bled_no,$blDetail->vendor_id)->row();
  ?>
  <div class="modal fade" id="seequotation<?=$Modalno?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title"><?=$blDetail->vendor_name?> - Detail Quotation</h4>
        </div>
        <div class="modal-body">
          <div class="form-group row">
            <label class="col-3">Bid Letter No</label>
            <div class="col-md-3">
              <input name="bid_letter_no" class="form-control" disabled="" value="<?=@$bh->bid_letter_no?>">
            </div>
            <label class="col-4">Statement of Conformity</label>
            <div class="col-md-2">
              <a href="<?=base_url('upload/bid/'.@$bh->soc)?>" target="_blank" class="btn btn-sm btn-primary">Download</a>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-3">Local content (TKDN)</label>
            <div class="col-md-3">
              <input class="form-control" disabled="" value="<?=@$bh->local_content?>">
            </div>
            <label class="col-4">Technical Proposal</label>
            <div class="col-md-2">
              <a href="<?=base_url('upload/bid/'.@$bh->tp)?>" target="_blank" class="btn btn-sm btn-primary">Download</a>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-3">Delivery work duration</label>
            <div class="col-md-4">
              <div class="input-group">
                <input disabled="" class="form-control" placeholder="Username" aria-describedby="basic-addon1" value="<?=@$bh->delivery_nilai?>">
                <span class="input-group-addon"><?=$bh->delivery_satuan;?></span>
              </div>
            </div>
          </div>
          <div class="form-group row">
            <label class="col-3">Bid validity</label>
            <div class="col-md-3">
              <input class="form-control" disabled="" value="<?=@$bh->bid_validity ? dateToIndo($bh->bid_validity,false,true) : ''?>">
            </div>
            <label class="col-4">Price Book/Price List</label>
            <div class="col-md-2">
              <?php if(isset($bh->pl)): ?>
                <a href="<?=base_url('upload/bid/'.@$bh->pl)?>" target="_blank" class="btn btn-sm btn-primary">Download</a>
              <?php endif;?>
            </div>
          </div>
          <div class="form-group row">
            <div class="table-responsive">
              <table class="table table-condensed table-striped">
                <thead>
                  <tr>
                    <th>No</th>
                    <th>Item Type</th>
                    <th>Description</th>
                    <th>Qty</th>
                    <th>UoM</th>
                    <th>Unit Price (IDR)</th>
                    <th>Sub Total (IDR)</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <?php 
                      $no=1;
                      $total = 0;
                      foreach ($msrItem->result() as $r) :
              if($r->vendor_id == $blDetail->vendor_id):
                        $subTotal = $r->unit_price2*$r->qty;
                        $total += $subTotal;
                    ?>
                    <tr>
                      <td><?=$no?></td>
                      <td><?=$r->id_itemtype?></td>
                      <td><?=$r->description?></td>
                      <td>
                        <?=$r->qty?>
                      </td>
                      <td><?=$r->uom?></td>
                      <td class="text-right">
                        <?=numIndo($r->unit_price2,0)?>
                      </td>
                      <td class="text-right"><?=numIndo($subTotal,0)?></td>
                    </tr>
                    <?php $no++?>
          <?php endif;?>
                    <?php endforeach;?>
                  </tr>
                  <tr>
                    <td colspan="6" class="text-right">Total</td>
                    <td><?=numIndo($total,0)?></td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php $Modalno++; } ?>
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
  <script type="text/javascript">
$(document).ready(function(){
      $("#frm-bled input,#frm-bled select,#frm-bled textarea").attr('disabled','disabled');
      $("#ed_id,#desc_administrative,#administrative,#bl_detail_id,.attachment,.data_id,#desc_technical,#technical,.status,.desc-note,#commercial").removeAttr('disabled');
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
          $("#modal-pass-adm").modal('hide');
          $("#adm-result-"+blDetailId).html(data);
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
      $.ajax({
        type:'post',
        data:{id:$('#bl_detail_id').val(),technical:$('#technical').val(),desc_technical:$('#desc_technical').val()},
        url:"<?=base_url('approval/approval/administrative')?>",
        success:function(e){
          alert(e);
          $("#modal-pass-tech").modal('hide');
        },
        errorr:function(e){
          alert('Update error, try again');
        }
      })
    }
    function commercialClick() {
      $.ajax({
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
      })
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
  </script>