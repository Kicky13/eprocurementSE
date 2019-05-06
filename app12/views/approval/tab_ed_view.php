<div class="row">
	<!-- left side -->
    <div class="col-md-6">
	  <div class="row">
		  <div class="form-group col-md-12">
			<label for="proposalTitle2">Subject :</label>
			<input  class="form-control" disabled name="subject" id="subject" value="<?=@$ed->subject?>">
		  </div>
          <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="emailAddress4">Pre Bid Date :</label>
                        <input  class="form-control" disabled id="prebiddate" name="prebiddate" value="<?=dateToInput(@$ed->prebiddate, 'Y-m-d H:i')?>">
                    </div>
                    <div class="form-group">
                        <label for="emailAddress4">Closing Date :</label>
                        <input class="form-control" disabled id="closing_date" name="closing_date" value="<?=dateToInput(@$ed->closing_date,'Y-m-d H:i')?>">
                    </div>
                    <div class="form-group">
                        <label for="jobTitle3">Bid Validty :</label>
                        <input  class="form-control" disabled id="bid_validity" name="bid_validity" value="<?=@$ed->bid_validity?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="videoUrl2">Pre Bid Location :</label>
                        <?php
                            $prebidloc = 'Not Applicable';
                            $pbl = $this->db->where('id',$ed->prebid_loc)->get('m_pre_bid_location');
                            if($pbl->num_rows() > 0)
                            {
                                $pbl = $pbl->row();
                                $prebidloc = $pbl->nama;
                            }
                        ?>
                        <input value="<?=$prebidloc?>" class="form-control disabled" disabled >
                    </div>
                    <div class="form-group">
                        <label for="emailAddress4">Pre Bid Address :</label>
                        <textarea class="form-control" disabled id="prebid_address" name="prebid_address"> <?=@$ed->prebid_address?></textarea>
                    </div>
                </div>
            </div>
          </div>
	  </div>
    </div>
	<!-- right side -->
    <div class="col-md-6">
		<div class="row">
		  <div class="form-group col-md-6">
			<label for="jobTitle3">Currency :</label>
			<input class="form-control" disabled="" value="<?=$this->db->where('ID', $ed->currency)->get('m_currency')->row()->CURRENCY?>">
		  </div>
		  <div class="col-md-6"></div>
		  <div class="form-group col-md-6">
			  <label for="jobTitle3">Bid Bond :</label>
				<select class="form-control" disabled style="margin-bottom: 10px;">
				  <option value="1" <?=@$ed->bid_bond_type == 1 ? "selected":""?>>%</option>
				  <option value="3" <?=@$ed->bid_bond_type == 3 ? "selected":""?>>Value</option>
				  <option value="2" <?=@$ed->bid_bond_type == 2 ? "selected":""?>>Not Applicable</option>
				</select>
		  </div>
		  <div class="col-md-6">
            <label for="jobTitle3">&nbsp;</label>
            <?php
            	$bid_bond = '';
            	if (@$ed->bid_bond_type == 1) {
            		$bid_bond = round($ed->bid_bond, 2);
            	} elseif (@$ed->bid_bond_type == 3) {
            		$bid_bond = numIndo($ed->bid_bond);
            	} else {
            		$bid_bond = '';
            	}
            ?>
            <input placeholder="Fill bid here" class="form-control" disabled id="bid_bond"  name="bid_bond" value="<?=$bid_bond?>">
          </div>
		  <div class="form-group col-md-6">
			<label for="jobTitle3">Bid Bond Validty:</label>
			<input disabled class="form-control" id="bid_bond_validity"  name="bid_bond_validity" value="<?= dateToInput(@$ed->bid_bond_validity, 'Y-m-d')?>">
		  </div>
		  <div class="form-group col-md-6">
			<label for="jobTitle3">Evaluation Method :</label>
			<input type="text" name="x" disabled="" value="<?=edOptData('mix',$ed->commercial_data)?>" class="form-control">
		  </div>
		  <div class="form-group col-md-6">
			<label for="emailAddress4">Envelope System :</label>
			<select class="form-control" name="envelope_system" disabled="">
			  <option value="1" <?=@$ed->envelope_system == 1 ? "selected":"" ?> >1 Envelope</option>
			  <option value="2" <?=@$ed->envelope_system == 2 ? "selected":"" ?> >2 Envelope</option>
			</select>
		  </div>
		  <div class="form-group col-md-6">
			<label for="packet">Itemize/Packet</label>
			<select class="form-control" name="packet" id="packet" disabled="">
			  <option value="1" <?=@$ed->packet == 1 ? "selected":"" ?> >Itemize</option>
			  <option value="2" <?=@$ed->packet == 2 ? "selected":"" ?> >Packet</option>
			</select>
		  </div>
			<?php
				if($msr->id_msr_type == 'MSR01') :
					$m_deliveryterm = $this->db->where(['ID_DELIVERYTERM'=>$ed->incoterm])->get('m_deliveryterm')->row();
					$m_deliverypoint = $this->db->where(['ID_DPOINT'=>$ed->delivery_point])->get('m_deliverypoint')->row();
			?>
		  <div class="form-group col-md-6">
            <label for="incoterm">Incoterm</label>
            <input value="<?= @$ed ? @$m_deliveryterm->DELIVERYTERM_DESC : $msr->DELIVERYTERM_DESC ?>" class="form-control disabled" disabled="">
          </div>
          <div class="form-group col-md-6">
			<label for="dpoint">Delivery Point</label>
            <input  value="<?= @$ed ? @$m_deliverypoint->DPOINT_DESC : $msr->DPOINT_DESC ?>" class="form-control disabled" disabled="">
			</div>
          <?php endif;?>
		</div>
    </div>
  </div>