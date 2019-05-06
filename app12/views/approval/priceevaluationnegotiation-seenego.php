<?php 
	$header 	= $this->approval_lib->penHeader($ed->msr_no);
	$msrItem 	= $this->approval_lib->msrItem($ed->msr_no)->result();
	$msrItemList = [];
	foreach ($msrItem as $key => $value) {
		$msrItemList[] = $value->line_item;
	}
	$sop = $this->vendor_lib->sop_get(false, $msrItemList)->result();
?>
<div class="table-responsive">
	<table class="table table-condensed">
		<thead>
			<tr>
				<th rowspan="2">No</th>
				<th rowspan="2">Description</th>
				<th rowspan="2">Qty</th>
				<th rowspan="2">UoM</th>
				<th rowspan="2">Qty 2</th>
				<th rowspan="2">UoM 2</th>
				<th rowspan="2">Currency</th>
				<?php 
					if(isset($xvendor))
					{
						echo "<th>Price</th><th>Total</th>";
					}
					else
					{
						foreach ($header->result() as $r) {
							echo "<th colspan='2' class='text-center'>$r->NAMA</th>";
						}
					}
				?>
			</tr>
			<?php 
				if(isset($xvendor))
				{
					
				}
				else
				{
					echo "<tr>
					<th>Price</th>
					<th>Total</th>
					<th>Price</th>
					<th>Total</th>
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
					echo "<td>$r->item</td>";

					$qty = $r->qty1;
					if($r->qty2)
					{
						$qty = $r->qty1*$r->qty2;
					}
					$qty2 = $r->qty2 ? $r->qty2 : '-';
					$uom2 = $r->uom2 ? $r->uom2 : '-';

					echo "<td class='text-center'>$r->qty1</td>";
					echo "<td class='text-center'>$r->uom1</td>";
					
					echo "<td class='text-center'>$qty2</td>";
					echo "<td class='text-center'>$uom2</td>";

					echo "<td class='text-center'>$r->currency</td>";
					
					foreach ($header->result() as $row) {
						if(isset($xvendor))
						{
							if($xvendor == $row->vendor_id)
							{
								$vendor = $this->db->where(['sop_id'=>$r->id,'vendor_id'=>$row->vendor_id, 'msr_no'=> $ed->msr_no, 'nego_id'=>$nego_id])->get('t_nego_detail');
								if($vendor->num_rows() > 0)
								{
									$v = $vendor->row();
									
									$price = $v->negotiated_price;
									$total_unit_price = $price*$qty;

									if(isset($vendorTotal[$row->vendor_id]))
									{
										$vendorTotal[$row->vendor_id] += $total_unit_price;
									}
									else
									{
										$vendorTotal[$row->vendor_id] = $total_unit_price;
									}
									$style = $v->nego == 1 ? "style='color:#32CD32'" : "";
									echo "<td $style class='text-right'>".numIndo($price)."</td>";
									echo "<td $style class='text-right'>".numIndo($total_unit_price)."</td>";
								}
								else
								{
									echo "<td></td>";
									echo "<td></td>";
								}
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
				<td colspan="7"></td>
				<?php 
					foreach ($header->result() as $row) {
						if(isset($xvendor))
						{
							if($xvendor == $row->vendor_id)
							{
								echo "<td></td>";
								echo "<td class='text-right'>".numIndo(isset($vendorTotal[$row->vendor_id]) ? $vendorTotal[$row->vendor_id] : 0)."</td>";
							}
						}
					}
				?>
			</tr>
		</tfoot>
	</table>
</div>