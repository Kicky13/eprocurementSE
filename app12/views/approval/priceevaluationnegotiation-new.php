<?php
	/*
	$sql = "select vendor_id from t_sop_bid where msr_no = ?' group by vendor_id";
	$v = $this->db->query($sql, [$ed->msr_no]);
	if($v->num_rows() > 0)
	{
		$vendorId = [];
		foreach ($v->result() as $k => $v) {
			$vendorId[] = $v->vendor_id;
		}
		if(count($vendorId))
		{
			$this->db->where_in('m_vendor.ID',$vendorId);
		}
	}
	*/
	$header 	= $this->approval_lib->penHeader($ed->msr_no);
	$msrItem 	= $this->approval_lib->msrItem($ed->msr_no)->result();
	$msrItemList = [];
	foreach ($msrItem as $key => $value) {
		$msrItemList[] = $value->line_item;
	}
	$sop = $this->vendor_lib->sop_get(false, $msrItemList)->result();
?>
<div class="row">
	<div class="col-md-12">
		<div class="table-responsive">
			<table class="table table-condensed table-row-border table-no-wrap">
				<thead>
					<tr>
						<th rowspan="2">No</th>
						<th rowspan="2">Description Of Unit</th>
						<th rowspan="2" class="text-center">Qty</th>
						<th rowspan="2" class="text-center">UoM</th>
						<th rowspan="2" class="text-center">Qty 2</th>
						<th rowspan="2" class="text-center">UoM 2</th>
						<th rowspan="2" class="text-center">Currency</th>
						<?php
							foreach ($header->result() as $r) {
								echo "<th colspan='3' class='text-center'>$r->NAMA</th>";
							}
						?>
					</tr>
					<?php
						echo "<tr>";
						foreach ($header->result() as $r) {
							echo "<th>Delivery Time</th><th class='text-right'>Price</th><th class='text-right'>Total</th>";
						}
						echo "</tr>";
					?>
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

							foreach ($header->result() as $row) {
								$vendor = $this->db->where(['sop_id'=>$r->id,'vendor_id'=>$row->vendor_id])->get('t_sop_bid');
								if($vendor->num_rows() > 0)
								{
									$v = $vendor->row();

									$price = $v->unit_price;
									if(isset($nego))
									{
										if ($nego) {
											$price = $v->nego_price > 0 ? $v->nego_price : $price;
										}
									}
									// $price = isset($nego) && $nego ? $v->nego_price : $v->unit_price;
									$total_unit_price = $price*$qty;

									if(isset($vendorTotal[$row->vendor_id]))
									{
										$vendorTotal[$row->vendor_id] += $total_unit_price;
									}
									else
									{
										$vendorTotal[$row->vendor_id] = $total_unit_price;
									}

									$price_str = $price > 0 ? numIndo($price): '-';
									$total_unit_price_str = $total_unit_price > 0 ? numIndo($total_unit_price): '-';

									if(isset($nego))
									{
										if ($nego) {
											$deli_time = $this->db->where(['msr_no'=>$ed->msr_no,'vendor_id'=>$row->vendor_id])->order_by('id', 'desc')->get('t_nego');
		                                    if($deli_time->num_rows() > 0){
		                                    	$dt = $deli_time->row();
		                                    	$nego_detail = $this->db->where(['msr_no'=>$ed->msr_no,'nego_id'=>$dt->id,'sop_id'=>$r->id])->get('t_nego_detail');
		                                    	if($nego_detail->num_rows() > 0){
		                                    		$nd = $nego_detail->row();
		                                    		if(!is_null($nd->negotiated_price) && $nd->nego == 1){
		                                    			echo "<td class='text-center'>$dt->delivery_time</td>";
		                                    		}else{
		                                    			echo "<td class='text-center'>$v->unit_value $v->unit_uom</td>";
		                                    		}
		                                    	}else{
		                                    		echo "<td class='text-center'>$v->unit_value $v->unit_uom</td>";
		                                    	}
		                                    }else{
		                                    	echo "<td class='text-center'>$v->unit_value $v->unit_uom</td>";
		                                    }
										}else{
											echo "<td class='text-center'>$v->unit_value $v->unit_uom</td>";
										}
									}else{
										echo "<td class='text-center'>$v->unit_value $v->unit_uom</td>";
									}
									echo "<td class='text-right'>".$price_str."</td>";
									echo "<td class='text-right'>".$total_unit_price_str."</td>";
								}
								else
								{
									echo "<td></td>";
									echo "<td></td>";
								}
							}
							echo "</tr>";
							$no++;
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="7"></td>
						<?php
							foreach ($header->result() as $row) {
								echo "<td></td>";
								echo "<td></td>";
								echo "<td class='text-right'>".numIndo(isset($vendorTotal[$row->vendor_id]) ? $vendorTotal[$row->vendor_id] : 0)."</td>";

							}
						?>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
</div>