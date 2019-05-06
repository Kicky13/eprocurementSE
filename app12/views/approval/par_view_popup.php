<?php
	$data = $this->input->post();

	$recomendation = $data['recomendation'];
	// $this->session->set_userdata('pemenang', $recomendation);
	$sop = [];
	$jml = [];
	$vendor_id = [];
	$total_vendor = [];
	foreach ($recomendation as $key => $value) {
		#key = sop_id value = vendor_id
		$vendor_id[$value] = $value;
		$sop[$value] = $key;
		if(isset($jml[$value]))
		{
			$jml[$value] += 1;
		}
		else
		{
			$jml[$value] = 1;
		}
	}

	$blDetails = $this->vendor_lib->blDetail($data['msr_no'], $vendor_id);
	/*looping vendor price total*/
	foreach ($sop as $key => $value) {
		$m_vendor = $this->db->where(['ID'=>$key])->get('m_vendor')->row();
		$item = $jml[$key] > 1 ? "items":"item";
		$no=1;
		$total = 0;
		foreach ($recomendation as $sop_id => $vendor_id) {
			if($vendor_id == $key)
			{
				$r = $this->vendor_lib->sop_get(['t_sop.id'=>$sop_id])->row();
				$qty = $r->qty1;
				if($r->qty2)
				{
					$qty = $r->qty1*$r->qty2;
				}
				if($r->uom2)
				{

				}

				$vendor = $this->db->where(['sop_id'=>$sop_id,'vendor_id'=>$vendor_id])->get('t_sop_bid');
				$v = $vendor->row();
				$price = ($v->nego_price > 0) ? $v->nego_price : $v->unit_price;
				$total_unit_price = $price*$qty;

				$total += $total_unit_price;
				$no++;
			}
		}
		$total_vendor[$key] = $total;
	}
	/*end looping*/
	$sum_total_vendor_ori = array_sum($total_vendor);
	$sum_total_vendor = array_sum($total_vendor);
	$sum_total_vendor_ori = array_sum($total_vendor);
	$getMsr = $this->approval_lib->getMsr($data['msr_no'])->row();
	$getEd = $this->approval_lib->getEd($data['msr_no'])->row();
	$total_amount = $getMsr->total_amount;
	if($getEd->ee_value > 0)
	{
		$total_amount = $getEd->ee_value;
	}
	$sum_total_vendor = exchange_rate_by_id($getEd->currency, 3, $sum_total_vendor);
	if($getEd->currency != $getMsr->id_currency)
	{
		$sum_total_vendor_ori = exchange_rate_by_id($getEd->currency, $getMsr->id_currency, $sum_total_vendor);
	}

	if($sum_total_vendor_ori <= $total_amount)
	{
		$statusEE = 'Submit';
		$disabled = '';
	}
	else
	{
		$statusEE = "Can't Continue, Over EE Value";
		$disabled = 'disabled';
	}
?>
<div class="form-group">
	<div class="table-responsive">
		<table class="table table-condensed table-no-wrap">
			<thead>
				<tr>
					<th rowspan="2">SLKA No</th>
					<th rowspan="2">Bidder(s)</th>
					<th colspan="3" class="text-center">Evaluation</th>
					<th rowspan="2">Items</th>
					<th rowspan="2" class="text-center">Currency</th>
					<th rowspan="2" class="text-right">Final Price</th>
				</tr>
				<tr>
					<th class="text-center">Administration</th>
					<th class="text-center">Technical</th>
					<th lass="text-center">Commercial</th>
				</tr>
			</thead>
			<tbody>
			<?php

				foreach ($blDetails->result() as $blDetail) {
					echo "<tr><td>$blDetail->no_slka</td>
					<td>$blDetail->vendor_name</td>
					<td>".evaluationStatus($blDetail->administrative)."</td>
			        <td>".evaluationStatus($blDetail->technical)."</td>
			        <td class='com-result-$blDetail->bl_detail_id'>".evaluationStatus($blDetail->commercial)."</td>
			        <td class='text-center'>".$jml[$blDetail->vendor_id]."</td>
			        <td class='text-center'>".$blDetail->currency."</td>
			        <td class='text-right'>".numIndo($total_vendor[$blDetail->vendor_id])."</td>";
					echo "</tr>";
				}
			?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">Total</td>
					<td class='text-right'><?= numIndo($sum_total_vendor_ori) ?></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<?php if($sum_total_vendor >= 100000):?>
<div class="form-group">
		<div class="form-inline">
			<div class="form-group">
				<label>Contract Review</label>&nbsp;
				<input class="form-control" placeholder="File Name" name="contract_review_name" id="contract_review_name" required="">&nbsp;
				<input type="file" name="contract_review_file" id="contract_review_file" required="">
			</div>
		</div>
</div>
<?php endif;?>
<div class="form-group">
	<textarea name="desc_of_award" id="desc_of_award" class="form-control" placeholder="Description of Award Recommendation"></textarea>
</div>
<div class="form-group text-right">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
    <button type="submit" class="btn btn-success" <?=$disabled?>><?=$statusEE?></button>
</div>