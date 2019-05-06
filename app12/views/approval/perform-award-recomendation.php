<input type="hidden" id="lowest_price_val">
<?php
	$header 	= $this->approval_lib->penHeader($ed->msr_no);
	$msrItem 	= $this->approval_lib->msrItem($ed->msr_no)->result();
	$msrItemList = [];
	foreach ($msrItem as $key => $value) {
		$msrItemList[] = $value->line_item;
	}
	$sop = $this->vendor_lib->sop_get(false, $msrItemList)->result();
?>
<?php if($ed->packet == 2): ?>
	<div class="form-inline" style="margin-bottom: 10px;">
		<div class="form-group">
			<label>Award Choice</label>&nbsp;
			<select class="form-control" name="award_choice" id="award_choice" onchange="awardChoiceChange()">
			<?php
				foreach ($header->result() as $r) {
					if($r->confirmed == 1)
					{
						echo "<option value='$r->vendor_id'>$r->NAMA</option>";
					}
				}
			?>
			</select>
		</div>
	</div>
<?php endif;?>
<div class="form-group">
	<div class="table-responsive">
		<table class="table table-condensed table-row-border table-no-wrap">
			<thead>
				<tr>
					<th rowspan="2">No</th>
					<th rowspan="2">Description</th>
					<th rowspan="2" class="text-center">Qty</th>
					<th rowspan="2" class="text-center">UoM</th>
					<th rowspan="2" class="text-center">Qty 2</th>
					<th rowspan="2" class="text-center">UoM 2</th>
					<th rowspan="2" class="text-center">Currency</th>
					<?php
						foreach ($header->result() as $r) {
							if($r->confirmed == 1)
							{
							echo "<th colspan='3' class='text-center'>$r->NAMA</th>";
							}
						}
					?>
					<th colspan="2" class="text-center">Recommendation</th>
				</tr>
				<tr>
					<?php
						foreach ($header->result() as $r) {
							if($r->confirmed == 1)
							{
								echo "<th>Delivery Time</th>";
								echo "<th class='text-right'>Price</th>";
								echo "<th class='text-right'>Total</th>";
							}
						}
					?>
					<th>Lowest</th>
					<th>Awarder</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$no = 1;
					$vendorTotal = [];
					$sopId = [];
					foreach ($sop as $r) {
						$sopId[] = $r->id;
						echo "<tr>";
						echo "<td>$no</td>";
						echo "<td>$r->item</td>";

						$qty = $r->qty1;
						if($r->qty2)
						{
							$qty = $r->qty1*$r->qty2;
						}
						$qty2 = $r->qty2 ? $r->qty2 : '-';
						$uom2 = $r->uom2 ? $r->uom2.' - '.$r->uom2_desc : '-';

						echo "<td class='text-center'>$r->qty1</td>";
						echo "<td class='text-center'>$r->uom1 - $r->uom1_desc</td>";

						echo "<td class='text-center'>$qty2</td>";
						echo "<td class='text-center'>$uom2</td>";

						echo "<td class='text-center'>$r->currency</td>";

						$vendorRecomendation = [];
						foreach ($header->result() as $row) {
							if($row->confirmed == 1)
							{
								$vendor = $this->db->where(['sop_id'=>$r->id,'vendor_id'=>$row->vendor_id])->get('t_sop_bid');
								if($vendor->num_rows() > 0)
								{
									$v = $vendor->row();
									// print_r($v);
									$price = ($v->nego_price > 0) ? $v->nego_price : $v->unit_price;
									$total_unit_price = $price*$qty;

									if(isset($vendorTotal[$row->vendor_id]))
									{
										$vendorTotal[$row->vendor_id] += $total_unit_price;
									}
									else
									{
										$vendorTotal[$row->vendor_id] = $total_unit_price;
									}

									$vendorRecomendation[$row->vendor_id] = $total_unit_price;

									echo "<td class='text-center'>$v->unit_value $v->unit_uom</td>";
									echo "<td class='text-right'>".numIndo($price)."</td>";
									echo "<td class='text-right'>".numIndo($total_unit_price)."</td>";
								}
								else
								{
									echo "<td></td>";
									echo "<td></td>";
									echo "<td></td>";
								}
							}
						}
						asort($vendorRecomendation);
						echo "<td class='text-right' id='value_recomendation_$r->id'>";
						$x = 1;
						$first = '';
						foreach ($vendorRecomendation as $y=>$z) {
							if($x > 1)
							{
								break;
							}
							echo numIndo($z);
							$first = $y;
							$x++;
						}
						echo "</td>";
						echo "<td>";
						echo "<select style='width:125px' class='form-control recomendation' id='recomendation_$r->id' name='recomendation[$r->id]' onchange='recomenrationChange($r->id)'>";
						foreach ($header->result() as $row) {
							if($row->confirmed == 1)
							{
								$selected = $row->vendor_id == $first ? "selected":"";
								if($ed->packet == 2)
								{
									$selected = "";
								}
								echo "<option $selected value='$row->vendor_id' nilai='".$vendorRecomendation[$row->vendor_id]."'>$row->NAMA</option>";
							}
						}
						echo "</select>";
						echo "</td>";
						echo "</tr>";
						foreach ($header->result() as $row) {
							if($row->confirmed == 1)
							{
								echo "<input type='hidden' value='".$vendorRecomendation[$row->vendor_id]."' id='nilai_$row->vendor_id"."_$r->id' >";
							}
						}
						$no++;
					}
					$headerJson = json_encode($sopId);
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7"></td>
					<?php
						foreach ($header->result() as $row) {
							if($row->confirmed == 1)
							{
								echo "<td></td>";
								echo "<td></td>";
								echo "<td class='text-right'>".numIndo($vendorTotal[$row->vendor_id])."</td>";
							}
						}
					?>
					<td id="lowest_price" class="text-right"></td>
				</tr>
			</tfoot>
		</table>
	</div>
</div>
<div class="form-group">
	<h3>Bidder(s) Recommendation</h3>
</div>
<div class="form-group">
	<div class="table-responsive" id="bidders-recomendation">

	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		<?php if($ed->packet == 2): ?>
			$(".recomendation").val($("#award_choice").val());
		<?php endif;?>
		var xNilai = 0;
		$("[id^=value_recomendation_]").each(function(){
			var nilai = $(this).text();
			var res = nilai.replace(/,/g, "");
			xNilai += parseInt(res);
		})
		$("#lowest_price_val").val(xNilai)
		$("#lowest_price").html(numberWithCommas(xNilai)+'.00')
		$.ajax({
			type:'post',
			data:$("#frm-bled").serialize(),
			url:"<?=base_url('approval/award/par_view')?>",
			success:function(r){
				var s = eval("("+r+")");
				$("#bidders-recomendation").html(s.result);
				$(".award-popup").html(s.popup);
				<?php if($ed->packet == 2): ?>
				$(".recomendation").attr("disabled","");
				<?php endif;?>
			}
		})
	})
	function lowest_price(num) {
		$("#lowest_price_val").val(num)
		return $("#lowest_price").html(numberWithCommas(num)+'.00');
	}
	<?php if($ed->packet == 1): ?>
	function recomenrationChange(sop_id) {
		var getVendorPemenang = $("#recomendation_"+sop_id).val();
		var getNilai = $("#nilai_"+getVendorPemenang+"_"+sop_id).val()
		$("#value_recomendation_"+sop_id).html(numberWithCommas(getNilai)+'.00');

		value_recomendation()
		$(".recomendation").removeAttr("disabled");
		$.ajax({
			type:'post',
			data:$("#frm-bled").serialize(),
			url:"<?=base_url('approval/award/par_view')?>",
			success:function(r){
				var s = eval("("+r+")");
				$("#bidders-recomendation").html(s.result);
				$(".award-popup").html(s.popup);
			}
		})
	}
	<?php endif;?>
	function awardChoiceChange() {
		$(".recomendation").val($("#award_choice").val())

		var s = <?=$headerJson?>;
		console.log(s)
		$.each(s, function(key,value){
			// console.log(value);
			var getVendorPemenang = $("#recomendation_"+value).val();
			var getNilai = $("#nilai_"+getVendorPemenang+"_"+value).val()
			$("#value_recomendation_"+value).html(numberWithCommas(getNilai)+'.00');
		})
		value_recomendation()
		$(".recomendation").removeAttr("disabled");
		$.ajax({
			type:'post',
			data:$("#frm-bled").serialize(),
			url:"<?=base_url('approval/award/par_view')?>",
			success:function(r){
				var s = eval("("+r+")");
				$("#bidders-recomendation").html(s.result);
				$(".award-popup").html(s.popup);
				<?php if($ed->packet == 2): ?>
				$(".recomendation").attr("disabled","");
				<?php endif;?>
			}
		})
	}
	function value_recomendation() {
		var xNilai = 0;
		$("[id^=value_recomendation_]").each(function(){
			var nilai = $(this).text();
			var res = nilai.replace(/,/g, "");
			xNilai += parseInt(res);
		})
		lowest_price(xNilai)
	}
	<?php if($ed->packet == 2): ?>
		awardChoiceChange()
	<?php endif;?>
</script>
