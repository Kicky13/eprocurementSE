<?php
	$header 	= $this->approval_lib->penHeader($ed->msr_no);
	$msrItem 	= $this->approval_lib->msrItem($ed->msr_no)->result();
	$msrItemList = [];
	foreach ($msrItem as $key => $value) {
		$msrItemList[] = $value->line_item;
	}
	$sop = $this->vendor_lib->sop_get(false, $msrItemList)->result();
	// print_r($sop);
	// exit();
?>
<?php if(isset($xvendor)) : ?>
<?php else:?>
<div class="row">
	<div class="col-md-12">
<?php endif;?>
		<div class="table-responsive">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th rowspan="2">No</th>
						<th rowspan="2">Item Type</th>
						<th rowspan="2">Description</th>
						<th rowspan="2">Qty</th>
						<th rowspan="2">UoM</th>
						<th rowspan="2">Qty 2</th>
						<th rowspan="2">UoM 2</th>
						<th rowspan="2">Currency</th>
						<?php
							if(isset($xvendor))
							{
								echo "<th class='text-right'>Price</th><th class='text-right'>Total</th>";
							}
							else
							{
								foreach ($header->result() as $r) {
									echo "<th colspan='2' class='text-center'>$r->NAMA</th>";
								}
							}
						?>
						<th rowspan="2">Remark</th>
					</tr>
					<?php
						if(isset($xvendor))
						{

						}
						else
						{
							echo "<tr>
							<th class='text-right'>Price</th>
							<th class='text-right'>Total</th>
							<th class='text-right'>Price</th>
							<th class='text-right'>Total</th>
							</tr>";
						}
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
							echo "<td>$r->id_itemtype</td>";
							echo "<td>$r->item</td>";

							$qty = $r->qty1;
							if($r->qty2)
							{
								$qty = $r->qty1*$r->qty2;
							}
							$qty2 = $r->qty2 ? $r->qty2 : '-';
							$uom2 = $r->uom2 ? $r->uom2 : '-';

							echo "<td class='text-center'>$r->qty1</td>";
							echo "<td class='text-center' class='text-center'>$r->uom1</td>";

							echo "<td class='text-center'>$qty2</td>";
							echo "<td class='text-center'>$uom2</td>";

							echo "<td class='text-center'>$r->currency</td>";

							foreach ($header->result() as $row) {
								if(isset($xvendor))
								{
									if($xvendor == $row->vendor_id)
									{
										$vendor = $this->db->where(['sop_id'=>$r->id,'vendor_id'=>$row->vendor_id])->get('t_sop_bid');
										if($vendor->num_rows() > 0)
										{
											$v = $vendor->row();

											$price = isset($nego) && $nego ? $v->nego_price : $v->unit_price;
											$total_unit_price = $price*$qty;

											if(isset($vendorTotal[$row->vendor_id]))
											{
												$vendorTotal[$row->vendor_id] += $total_unit_price;
											}
											else
											{
												$vendorTotal[$row->vendor_id] = $total_unit_price;
											}

											echo "<td class='text-right'>".numIndo($price)."</td>";
											echo "<td class='text-right'>".numIndo($total_unit_price)."</td>";
											echo "<td>$v->remark</td>";
										}
										else
										{
											echo "<td></td>";
											echo "<td></td>";
											echo "<td></td>";
										}
									}
								}
								else
								{
									$vendor = $this->db->where(['sop_id'=>$r->id,'vendor_id'=>$row->vendor_id])->get('t_sop_bid');
									if($vendor->num_rows() > 0)
									{
										$v = $vendor->row();

										$price = isset($nego) ? $v->nego_price : $v->unit_price;
										$total_unit_price = $price*$qty;

										if(isset($vendorTotal[$row->vendor_id]))
										{
											$vendorTotal[$row->vendor_id] += $total_unit_price;
										}
										else
										{
											$vendorTotal[$row->vendor_id] = $total_unit_price;
										}

										echo "<td class='text-right'>".numIndo($price)."</td>";
										echo "<td class='text-right'>".numIndo($total_unit_price)."</td>";
										echo "<td>$v->remark</td>";
									}
									else
									{
										echo "<td></td>";
										echo "<td></td>";
										echo "<td></td>";
									}
								}
							}
							echo "</tr>";
							$no++;
						}
					?>
				</tbody>
				<tfoot>
					<tr>
						<th colspan="8"></th>
						<?php
							foreach ($header->result() as $row) {
								if(isset($xvendor))
								{
									if($xvendor == $row->vendor_id)
									{
										echo "<th></th>";
										echo "<th class='text-right'>".numIndo(isset($vendorTotal[$row->vendor_id]) ? $vendorTotal[$row->vendor_id] : 0)."</th>";
									}
								}
								else
								{
									echo "<th></th>";
									echo "<th class='text-right'>".numIndo(isset($vendorTotal[$row->vendor_id]) ? $vendorTotal[$row->vendor_id] : 0)."</th>";
								}
							}
						?>
					</tr>
				</tfoot>
			</table>
		</div>
<?php if(isset($xvendor)) : ?>
<?php else:?>
	</div>
</div>
<?php endif;?>