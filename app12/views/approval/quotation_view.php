<?php
  $msr_no = $ed->msr_no;
  $bled_no = str_replace('OR', "OQ", $ed->msr_no);
  $blDetails = $this->vendor_lib->blDetail($msr_no)->result();
?>
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
			<td>Pre Bid Date</td>
			<td>
			  <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
          <?= dateToIndo($ed->prebiddate, false, true) ?  dateToIndo($ed->prebiddate, false, true) : 'Not Applicable' ?>
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
				<?=dateToIndo($ed->bid_validity, false, false)?>
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
    <table class="table table-condensed table-striped table-row-border table-no-wrap">
      <thead>
        <tr>
          <th rowspan="2" width="15">NO</th>
          <th rowspan="2" class="text-center">SLKA NO</th>
          <th rowspan="2" width="25%">Bidder(s) Name</th>
          <th rowspan="2" class="text-center">Submission Date</th>
          <th rowspan="2" class="text-center">Status</th>
          <th colspan="2" class="text-center">Bid</th>
          <th colspan="3" class="text-center">Evaluation Status</th>
          <th rowspan="2" class="text-center">Awarded</th>
        </tr>
        <tr>
          <th class="text-center">Original</th>
          <th class="text-center">Negotiation</th>
          <th class="text-center">Administrative</th>
          <th class="text-center">Tecnical</th>
          <th class="text-center">Commercial</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $no=1;
        foreach ($blDetails as $blDetail) {
          /*status*/
          $t_sop_bid = $this->db->where(['vendor_id'=>$blDetail->vendor_id,'msr_no'=>$msr_no])->get('t_sop_bid');
          $numSop = $t_sop_bid->num_rows();

          $statusMsg = $blDetail->confirmed == 1 ? "Confirmed" : "Decline";
          $is_nego = false;
          if($numSop > 0 and $blDetail->confirmed == 1)
          {
            $statusMsg = 'Bid Proposal Submitted';
            $t_nego = $this->db->where(['msr_no'=>$msr_no,'vendor_id'=>$blDetail->vendor_id])->get('t_nego');
            // $sql = "select * form t_nego where msr_no = '$msr_no' and vendor_id = '$blDetail->vendor_id' and (closed = 0 and status =0 )";
            if($t_nego->num_rows() > 0)
            {
             // $is_nego = false;
              foreach ($t_nego->result() as $tnego) {
                if($tnego->status == 0 or $tnego->closed == 0)
                {
                  $is_nego = false;
                }
                else
                {
                  $is_nego = true;
                }
              }
            }
            /*foreach ($t_sop_bid->result() as $r) {
              if($r->nego_price > 0)
              {
                $is_nego = true;
              }
            }*/
          }

          $submission_date = $numSop > 0 ? dateToIndo($blDetail->submission_date): '';
          $seequotation = $numSop > 0 && $ed->bid_opening == 1 ? "<a href='#' data-toggle='modal' data-target='#seequotation$no' class='btn btn-sm btn-primary btn-block'>See Quotation</a>" : "";

          $seenegotiated = $is_nego ? "<a href='#' data-toggle='modal' data-target='#seenego$no' class='btn btn-sm btn-primary  btn-block'>See Negotiation</a>" : "";
          $awarderStatus =  $blDetail->awarder == 1 ? "Award" : "";
          echo "<tr>
          <td class='text-center'>$no</td>
          <td class='text-center'>$blDetail->no_slka</td>
          <td>$blDetail->vendor_name</td>
          <td class='text-center'>$submission_date</td>
          <td class='text-center'>".$statusMsg."</td>
          <td class='text-center'>".$seequotation."</td>
          <td class='text-center'>".$seenegotiated."</td>
          <td class='text-center'>".evaluationStatus($blDetail->administrative)."</td>
          <td class='text-center'>".evaluationStatus($blDetail->technical)."</td>
          <td class='text-center'>".evaluationStatus($blDetail->commercial)."</td>
          <td class='text-center'>$awarderStatus</td>
          </tr>";
          $no++;
        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<?php
  $Modalno = 1;
  foreach ($blDetails as $blDetail) {
    $bidHead = $this->db->where(['bled_no'=>$bled_no,'created_by'=>$blDetail->vendor_id])->get('t_bid_head')->row();
?>
<div class="modal fade" id="seequotation<?=$Modalno?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?=$blDetail->vendor_name?> - Detail Quotation</h4>
      </div>
      <div class="modal-body">
		<div class="row">
			<div class="col-md-6">
				<div class="form-group row">
				  <label class="col-12" style="font-weight:bold;">Administration</label>
				</div>
				<div class="form-group row">
				  <label class="col-lg-6 col-md-12">Statement of Conformity</label>
				  <div class="col-md-6">
					<a href="<?=base_url('upload/bid/'.@$bidHead->soc)?>" target="_blank" class="btn btn-sm btn-info">Download</a>
				  </div>
				</div>
				<br>
				<div class="form-group row">
				  <label class="col-12" style="font-weight:bold;">Technical</label>
				  <label class="col-lg-6 col-md-12">Technical Proposal</label>
				  <div class="col-md-6">
					<a href="<?=base_url('upload/bid/'.@$bidHead->tp)?>" target="_blank" class="btn btn-sm btn-info">Download</a>
				  </div>
				</div>
				<div class="form-group row">
				  <label class="col-lg-6 col-md-12">Delivery work duration</label>
			      <div class="input-group col-md-6">
					<input class="form-control" disabled="" value="<?=@$bidHead->delivery_nilai?>" aria-describedby="basic-addon2">
					<span class="input-group-addon" id="basic-addon2"><?=@$bidHead->delivery_satuan?></span>
				  </div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="form-group row">
					<label class="col-12" style="font-weight:bold;">Commercial</label>
				</div>
				<div class="form-group row">
					<label class="col-lg-4 col-md-12">Bid Letter No</label>
					<div class="col-md-4" style="padding-right:0;">
					  <input name="bid_letter_no" class="form-control" disabled="" value="<?=@$bidHead->bid_letter_no?>">
					</div>
					<div class="col-md-4">
					  <?php if(@$bidHead->bid_letter_path): ?>
					  <a href="<?=base_url('upload/bid/'.@$bidHead->bid_letter_path)?>" target="_blank" class="btn btn-sm btn-info">Download</a>
					  <?php endif;?>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-4 col-md-12">Bid validity</label>
					<div class="col-md-5" style="padding-right:0;">
					  <input class="form-control" disabled="" value="<?=@$bidHead->bid_validity ? dateToIndo($bidHead->bid_validity,false,false) : ''?>">
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-4 col-md-12">Local content (TKDN)</label>
					<div class="col-md-4" style="padding-right:0;">
					 <?php
					   $id_local_content_type_str = '';
					   if(@$bidHead->id_local_content_type)
					   {
					  	$id_local_content_type_str = $this->mvn->find($bidHead->id_local_content_type)->name;
					   }
					 ?>
					 <input class="form-control" disabled="" value="<?=$id_local_content_type_str?>">
					</div>
					<div class="col-md-4">
					 <div class="input-group">
						<input class="form-control" disabled="" value="<?=@$bidHead->local_content?>" aria-describedby="basic-addon2">
						<span class="input-group-addon" id="basic-addon2">%</span>
					 </div>
					</div>
					<div class="col-md-4"> </div>
					<div class="col-md-8">
					  <a href="<?=base_url('upload/bid/'.@$bidHead->local_content_path)?>" target="_blank" class="btn btn-sm btn-info">Download</a>
					</div>
				</div>
				<div class="form-group row">
					<label class="col-lg-4 col-md-12">Other Commercial Document</label>
					<div class="col-md-8">
					  <?php if(isset($bidHead->pl)): ?>
					    <a href="<?=base_url('upload/bid/'.@$bidHead->pl)?>" target="_blank" class="btn btn-sm btn-info">Download</a>
					  <?php endif;?>
					</div>
				</div>
			</div>
		</div>
        <div class="form-group row">
			<label class="col-12">Note</label>
			 <div class="col-md-12">
				<textarea class="form-control" disabled=""><?=@$bidHead->note?></textarea>
			 </div>
        </div>
        <div class="form-group row">

          <?php $this->load->view('approval/priceevaluationnegotiation-one',['ed'=>$ed,'xvendor'=>$blDetail->vendor_id, 'nego'=>false]);?>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php $Modalno++; } ?>
<?php
  $Modalno = 1;
  foreach ($blDetails as $blDetail) {
    $bidHead = $this->db->where(['bled_no'=>$bled_no,'created_by'=>$blDetail->vendor_id])->get('t_bid_head')->row();
    $t_nego = $this->db->where(['msr_no'=>$msr_no, 'vendor_id'=>$blDetail->vendor_id, 'status'=>1, 'closed'=>1 ])->get('t_nego');
    $countNego = $t_nego->num_rows();
?>
<div class="modal fade" id="seenego<?=$Modalno?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title"><?=$blDetail->vendor_name?> - Detail Negotioation</h4>
      </div>
      <div class="modal-body">
        <?php
          $noNegoModal = 1;
          foreach ($t_nego->result() as $nego) :
        ?>
        <div class="form-group row">
          <div class="col-md-12">
            <a href="javascript:void(0)" class="btn btn-info btn-block" data-toggle="collapse" data-target="#nego-<?=$nego->id?>">Company Letter No : <?= $nego->company_letter_no ?></a>
          </div>
        </div>
        <div class="form-group row collapse <?= $noNegoModal == $countNego ? 'show':'' ?>" id="nego-<?=$nego->id?>" count-nego="<?=$countNego?>">
          <div class="col-md-12">
            <div class="form-group row">
              <label class="col-3">Closing Date</label>
              <div class="col-md-3">
                <input class="form-control" disabled="" value="<?=dateToIndo($nego->closing_date, false, true)?>">
              </div>
              <label class="col-3">Supporting Document</label>
              <div class="col-md-3">
                <a href="<?= base_url('upload/NEGOTIATION/'.$nego->local_content_file) ?>" target="_blank" class="btn btn-sm btn-info">Download</a>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3">Bid Letter No</label>
              <div class="col-md-3">
                <input class="form-control" disabled="" value="<?=@$nego->bid_letter_no?>">
              </div>
              <label class="col-3">Bid Letter File</label>
              <div class="col-md-3">
                <a href="<?= base_url('upload/NEGOTIATION/'.@$nego->bid_letter_file) ?>" target="_blank" class="btn btn-sm btn-info">Download</a>
              </div>
            </div>
            <div class="form-group row">
              <label class="col-3">Local Content</label>
              <div class="col-md-3">
                <select name="id_local_content_type" class="form-control disabled" disabled="">
                    <?php foreach($this->mvn->get_tkdn_type() as $tkdn_type) { ?>
                        <option value="<?= $tkdn_type->id ?>" <?= $tkdn_type->id == $nego->id_local_content_type ? 'selected' : '' ?>><?= $tkdn_type->name ?></option>
                    <?php } ?>
                </select>
              </div>
              <div class="col-md-3">
                  <input value="<?= $nego->local_content ?> %" class="form-control disabled" disabled="">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-md-3">Note</label>
              <div class="col-md-9">
                <textarea disabled="" rows="3" class="form-control"><?= $nego->bid_note ?></textarea>
              </div>
            </div>
          </div>
          <div class="col-md-12">
          <?php $this->load->view('approval/priceevaluationnegotiation-seenego',['ed'=>$ed,'xvendor'=>$blDetail->vendor_id, 'nego_id' => $nego->id]);?>
          </div>
        </div>
        <?php
          $noNegoModal++;
          endforeach;
        ?>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<?php $Modalno++; } ?>