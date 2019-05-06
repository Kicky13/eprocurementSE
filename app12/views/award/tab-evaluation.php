<fieldset>
  <div class="row">
    <div class="col-md-12">
	  <nav>
		  <div class="nav nav-tabs sub-tabs" id="nav-tab" role="tablist">
			<a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-administrative" role="tab" aria-controls="nav-home" aria-selected="true">Administrative</a>
			<a class="nav-item nav-link" id="nav-profile-tab" data-toggle="tab" href="#nav-technical" role="tab" aria-controls="nav-profile" aria-selected="false">Technical</a>
			<a class="nav-item nav-link" id="nav-contact-tab" data-toggle="tab" href="#nav-commercial" role="tab" aria-controls="nav-contact" aria-selected="false">Commercial</a>
            <?php $contract_review = $this->approval_lib->contract_review($msr_no) ?>
            <?php if($contract_review->num_rows() > 0): ?>
                <a class="nav-item nav-link" id="nav-contract-review-tab" data-toggle="tab" href="#tab-contract-review" role="tab" aria-controls="nav-contact" aria-selected="false">BOD Contract Review</a>
            <?php endif;?>
		  </div>
	  </nav>
	  <div class="tab-content" id="nav-tabContent">
		  <div class="tab-pane fade show active" id="nav-administrative" role="tabpanel" aria-labelledby="nav-administrative-tab">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-condensed table-striped">
						  <thead>
							<tr>
							  <th width="1%">No</th>
							  <th>SLKA No</th>
							  <th>Bidder(s) Name</th>
							  <th class="text-center">Result</th>
							  <th>Remark</th>
							  <th>
								<?php
									if($adminAttachment):
								?>
									<a href="<?=base_url('upload/evaluation/'.$adminAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
								<?php endif;?>
							  </th>
							</tr>
						  </thead>
						  <tbody>
							<?php
							$no=1;
							foreach ($blDetails->result() as $blDetail) {
							  echo "<tr>
							  <td>$no</td>
							  <td>$blDetail->no_slka</td>
							  <td>$blDetail->vendor_name</td>";
							  echo "<td class='text-center'>".evaluationStatus($blDetail->administrative)."</td>
							  <td></td>
                              <td></td>
							  </tr>";
							  $no++;
							}
							?>
						  </tbody>
						</table>
					  </div>
				</div>
			</div>
		  </div>
		  <div class="tab-pane fade show" id="nav-technical" role="tabpanel" aria-labelledby="nav-technical-tab">
			<div class="row">
				<div class="col-md-12">
					<div class="table-responsive">
						<table class="table table-condensed table-striped">
						  <thead>
							<tr>
							  <th width="1">No</th>
							  <th>SLKA No</th>
							  <th>Bidder(s) Name</th>
							  <th class="text-center">Result</th>
							  <th>Remark</th>
							  <th>
								<?php
								  if($technicalAttachment):
								?>
								  <a href="<?=base_url('upload/evaluation/'.$technicalAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
								<?php endif;?>
							  </th>
							</tr>
						  </thead>
						  <tbody>
							<?php
							$no=1;
							foreach ($blDetails->result() as $blDetail) {
							  echo "<tr>
							  <td>$no</td>
							  <td>$blDetail->no_slka</td>
							  <td>$blDetail->vendor_name</td>";
							  echo "<td class='text-center'>".evaluationStatus($blDetail->technical)."</td>
							  <td></td>
                              <td></td>
							  </tr>";
							  $no++;
							}
							?>
						  </tbody>
						</table>
					  </div>
				</div>
			</div>
		  </div>
		  <div class="tab-pane fade show" id="nav-commercial" role="tabpanel" aria-labelledby="nav-commercial-tab">
			<div class="row">
				<div class="col-md-12">
				  <div class="table-responsive">
					<table class="table table-condensed table-striped">
					  <thead>
						<tr>
						  <th width="1">No</th>
						  <th>SLKA No</th>
						  <th>Bidder(s) Name</th>
						  <th class="text-center">Result</th>
						  <th>Note</th>
						  <th class="text-right">Original Value</th>
						  <th class="text-right">Latest Value</th>
						  <th>
							<?php
							  $commercialAttachment = $this->M_approval->seeAttachment('eva-commercial', $msr_no)->row();
							  if($commercialAttachment):
							?>
							  <a href="<?=base_url('upload/evaluation/'.$commercialAttachment->file_path)?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a>
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
							->where(['t_sop.msr_no'=>$msr_no,'vendor_id'=>$blDetail->vendor_id])
							->get('t_sop_bid')->result();

							$oriVal = 0;
							$latVal = 0;
							foreach ($sop_bid as $r) {
							  if($r->qty2 > 0)
							  {
								$oriVal += $r->qty1*$r->qty2*$r->unit_price;
								$latVal += $r->qty1*$r->qty2*$r->nego_price;
							  }
							  else
							  {
								$oriVal += $r->qty1*$r->unit_price;
								$latVal += $r->qty1*$r->nego_price;
							  }
							}
							echo "<td class='text-center'>".evaluationStatus($blDetail->commercial)."</td>
							<td>$blDetail->desc_commercial</td>";
							echo "<td class='text-right'>".numIndo($oriVal)."</td>";
							echo "<td class='text-right'>".numIndo($latVal > 0 ? $latVal : $oriVal)."</td>
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
			<div style="margin-top: 15px;">
				<nav>
					<div class="nav nav-tabs sub-tabs" id="nav-tab" role="tablist">
						<a class="nav-item nav-link active" id="nav-original-value-tab" data-toggle="tab" href="#tab-original-value" role="tab" aria-controls="nav-home" aria-selected="true">Original Value</a>
						<a class="nav-item nav-link" id="nav-latest-value-tab" data-toggle="tab" href="#tab-latest-value" role="tab" aria-controls="nav-profile" aria-selected="false">Latest Value</a>
						<a class="nav-item nav-link" id="nav-recommendation-tab" data-toggle="tab" href="#tab-recommendation" role="tab" aria-controls="nav-contact" aria-selected="false">Recommendation</a>
					</div>
                </nav>
				<div class="tab-content" id="nav-tabContent">
	  				<div class="tab-pane fade show active" id="tab-original-value" role="tabpanel" aria-labelledby="original-value-tab" style="padding: 15px 0px;">
	  					<?php $this->load->view('approval/priceevaluationnegotiation-new',['ed'=>$ed, 'nego'=>false]);?>
					</div>
					<div class="tab-pane fade show" id="tab-latest-value" role="tabpanel" aria-labelledby="latest-value-tab" style="padding: 15px 0px;">
	  					<?php $this->load->view('approval/priceevaluationnegotiation-new',['ed'=>$ed, 'nego'=>true]);?>
					</div>
					<div class="tab-pane fade show" id="tab-recommendation" role="tabpanel" aria-labelledby="recommendation-tab" style="padding: 15px 0px;">
                        <div class="row">
                            <div class="col-md-12">
    		  					<?php
    							    $t_sop_bid = $this->db->where(['msr_no'=>$ed->msr_no,'award'=>1])->get('t_sop_bid');
    							    $recomendation = [];
    							    foreach ($t_sop_bid->result() as $recomendations) {
    							        $recomendation[$recomendations->sop_id] = $recomendations->vendor_id;
    							    }
    							    $sop = [];
    							    $jml = [];
    							    foreach ($recomendation as $key => $value) {
    							        $sop[$value] = $key;
    							        if(isset($jml[$value])) {
    							            $jml[$value] += 1;
    							        } else {
    							            $jml[$value] = 1;
    							        }
    							    }

    							    foreach ($sop as $key => $value) {
    							        $m_vendor = $this->db->where(['ID'=>$key])->get('m_vendor')->row();
    							        $item = $jml[$key] > 1 ? "items":"item";
    							        echo "<h4>$m_vendor->NAMA ($jml[$key] $item)</h4>";
                                        echo "<div class='table-responsive'>";
    							        echo "<table class='table table-no-wrap'>";
    							            echo "<thead>";
    							                echo "<tr>";
    							                echo "<th>No</th>";
    							                echo "<th>Description</th>";
    							                echo "<th class='text-center'>Qty</th>";
    							                echo "<th  class='text-center'>UoM</th>";
    							                echo "<th  class='text-center'>Qty 2</th>";
    							                echo "<th  class='text-center'>UoM 2</th>";
    							                echo "<th  class='text-center'>Currency</th>";
    							                echo "<th>Deliery Time</th>";
    							                echo "<th class='text-right'>Unit Price</th>";
    							                echo "<th class='text-right'>Total</th>";
    							                echo "</tr>";
    							            echo "</thead>";
    							            echo "<tbody>";
    							            $no=1;
    							            $total = 0;
    							            foreach ($recomendation as $sop_id => $vendor_id) {
    							                if($vendor_id == $key) {
    							                    $r = $this->vendor_lib->sop_get(['t_sop.id'=>$sop_id])->row();
    							                    if($r) {
    							                        echo "<tr>";
    							                        echo "<td>$no</td>";
    							                        echo "<td>$r->item</td>";

    							                        $qty = $r->qty1;
    							                        if($r->qty2) {
    							                            $qty = $r->qty1*$r->qty2;
    							                        }
    							                        $qty2 = $r->qty2 ? $r->qty2 : '-';
    							                        $uom2 = $r->uom2 ? $r->uom2 . ' - ' . $r->uom2_desc : '-';

    							                        echo "<td class='text-center'>$r->qty1</td>";
    							                        echo "<td class='text-center'>$r->uom1 - $r->uom1_desc</td>";

    							                        echo "<td class='text-center'>$qty2</td>";
    							                        echo "<td class='text-center'>$uom2</td>";

    							                        echo "<td class='text-center'>$r->currency</td>";
    							                        $vendor = $this->db->where(['sop_id'=>$sop_id,'vendor_id'=>$vendor_id])->get('t_sop_bid');
    							                        $v = $vendor->row();
    							                        echo "<td class='text-center'>$v->unit_value $v->unit_uom</td>";
    							                        $price = ($v->nego_price > 0) ? $v->nego_price : $v->unit_price;
    							                        $total_unit_price = $price*$qty;
    							                        echo "<td class='text-right'>".numIndo($price)."</td>";
    							                        echo "<td class='text-right'>".numIndo($total_unit_price)."</td>";
    							                        echo "</tr>";
    							                        $total += $total_unit_price;
    							                        $no++;
    							                    } else {
    							                        echo "<tr><td colspan='10'>$sop_id</td></tr>";
    							                    }
    							                }
    							            }
    							            echo "</tbody>";
    							            echo "<tfoot>";
    							                echo "<tr><td colspan='9'>Total</td><td class='text-right'>".numIndo($total)."</td></tr>";
    							            echo "</tfoot>";
    							        echo "</table>";
                                        echo "</div>";
    							    }
    							?>
                            </div>
                        </div>
					</div>
	  			</div>
			</div>
		  </div>
          <?php if($contract_review->num_rows() > 0): ?>
            <div class="tab-pane fade show" id="tab-contract-review" role="tabpanel" aria-labelledby="contract-review-tab" style="padding: 15px 0px;">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th width="1">No</th>
                                    <th>Filename</th>
                                    <th>Uploaded Date</th>
                                    <th>Uploaded By</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php
                                $n =1;
                                foreach ($contract_review->result() as $cr) {
                                    echo "<tr>
                                        <td>".$n++."</td>
                                        <td><a href='".base_url('upload/contract_review/'.$cr->file_path)."' target='_blank'>".$cr->file_name."</a></td>
                                        <td>".dateToIndo($cr->created_at, false, true)."</td>
                                        <td>".user($cr->created_by)->NAME."</td>
                                    </tr>";
                                }
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
          <?php endif;?>
	  </div>
    </div>
  </div>
</fieldset>