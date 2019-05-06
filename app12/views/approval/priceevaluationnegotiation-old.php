<?php 
	$header = $this->approval_lib->penHeader($ed->msr_no);
	$msri = $this->approval_lib->msrItem($ed->msr_no);
?>
<div class="table-responsive">
	<table class="table table-condensed table-striped">
		<thead>
			<tr>
				<th width="15" rowspan="2">No</th>
				<th rowspan="2">Item Type</th>
				<th rowspan="2">Description</th>
				<th rowspan="2">Qty</th>
				<th rowspan="2">UoM</th>
				<th rowspan="2">Currency</th>
				<th rowspan="2">Unit Price</th>
				<th rowspan="2">Total EE Value</th>
				<?php 
				foreach ($header->result() as $r) {
					echo "<th class='text-center'>$r->NAMA</th>";
				}
				if(isset($nego))
				{
					echo "<th class='text-center'>Negotiation Price</th>";
				}
				?>
			</tr>
			<tr>
				<?php 
				foreach ($header->result() as $r) {
					/*echo "<th class='text-center'>Unit Price</th>";*/
					echo "<th class='text-center'>Total</th>";
				}
				if(isset($nego))
				{
					/*echo "<th class='text-center'>Unit Price</th>";*/
					echo "<th class='text-center'>Total</th>";
				}
				?>
			</tr>
		</thead>
		<tbody>
			<?php 
				$no=1;
				$totalUnitPrice = 0;
				$totalEEValue = 0;
				$oriTotal = [];
				$latTotal = [];
				foreach ($msri->result() as $i) : 
					$totalUnitPrice += $i->priceunit;
					$totalEEValue += $i->priceunit*$i->qty;
			?>
			<tr>
				<td><?=$no++?></td>
				<td><?=$i->id_itemtype?></td>
				<td><?=$i->description?></td>
				<td><?=$i->qty?></td>
				<td><?=$i->uom?></td>
				<td><?=$i->currency?></td>
				<td class="text-right"><?=numIndo($i->priceunit,0)?></td>
				<td class="text-right"><?=numIndo($i->priceunit*$i->qty,0)?></td>
				<?php 
					foreach ($header->result() as $r) {
						
						if($isi == 'quotation')
						{
							$vendor = $this->approval_lib->priceVendorByItem($i->line_item, $r->vendor_id, $r->bled_no);
							if($vendor->num_rows())
							{
								$vendor = $vendor->row();
								if(isset($oriTotal[$r->vendor_id]))
								{
									$oriTotal[$r->vendor_id] += $vendor->unit_price;
								}
								else
								{
									$oriTotal[$r->vendor_id] = $vendor->unit_price;
								}
								echo "<td class='text-right'>".numIndo($vendor->unit_price,0)."</td>";
								// echo "<td class='text-right'>".numIndo($vendor->unit_price*$i->qty,0)."</td>";
							}
							else
							{
								echo "<td class='text-right'></td>";
								echo "<td class='text-right'></td>";
							}
						}
						if($isi == 'nego')
						{
							$vendor = $this->approval_lib->priceVendorByItem($i->line_item, $r->vendor_id, $r->bled_no);
							if($vendor->num_rows())
							{
								$vendor = $vendor->row();
								if(isset($latTotal[$r->vendor_id]))
								{
									$latTotal[$r->vendor_id] += $vendor->nego_price;
								}
								else
								{
									$latTotal[$r->vendor_id] = $vendor->nego_price;
								}
								echo "<td class='text-right'>".numIndo($vendor->nego_price,0)."</td>";
								// echo "<td class='text-right'>".numIndo($vendor->nego_price*$i->qty,0)."</td>";
							}
							else
							{
								echo "<td class='text-right'></td>";
								echo "<td class='text-right'></td>";
							}
						}
					}
					if(isset($nego))
					{
						echo "<td class='text-right'><input class='form-control' style='width:150px' qty='$i->qty' onchange='priceChange($i->line_item)' id='price_$i->line_item' name='msr_item[$i->line_item]' /></td>";
						echo "<td class='text-right'><input class='form-control' style='width:150px' readonly id='total_$i->line_item'></td>";
					}
				?>
			</tr>
			<?php endforeach;?>
		</tbody>
		<tfoot>
			<tr>
				<th colspan="6">Total</th>
				<th><?=numIndo($totalUnitPrice)?></th>
				<th><?=numIndo($totalEEValue)?></th>
				<?php 
					foreach ($header->result() as $r) {
						if($isi == 'quotation')
						{
							echo "<th>".numIndo(@$oriTotal[$r->vendor_id])."</th>";
						}
						if($isi == 'nego')
						{
							echo "<th>".numIndo(@$latTotal[$r->vendor_id])."</th>";
						}
					}
				?>
			</tr>
		</tfoot>
	</table>
</div>