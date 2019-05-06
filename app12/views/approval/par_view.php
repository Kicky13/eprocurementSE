<?php
	$data = $this->input->post();
	$recomendation = $data['recomendation'];

	$msr_no = $data['msr_no'];
	$ed = $this->db->where(['msr_no'=>$msr_no])->get('t_eq_data')->row();

	$sop = [];
	$jml = [];
	foreach ($recomendation as $key => $value) {
		#key = sop_id value = vendor_id
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

	foreach ($sop as $key => $value) {
		$m_vendor = $this->db->where(['ID'=>$key])->get('m_vendor')->row();

		$item = $jml[$key] > 1 ? "items":"item";
		$strJmlItem = "($jml[$key] $item)";

		if($ed->packet == 2)
		{
			$strJmlItem='';
		}

		echo "<h4>$m_vendor->NAMA $strJmlItem</h4>";
		echo "<table class='table table-no-wrap'>";
		echo "<thead>";
		echo "<tr>";
		echo "<th>No</th>";
		echo "<th>Description</th>";
		echo "<th class='text-center'>Qty</th>";
		echo "<th class='text-center'>UoM</th>";
		echo "<th class='text-center'>Qty 2</th>";
		echo "<th class='text-center'>UoM 2</th>";
		echo "<th class='text-center'>Currency</th>";
		echo "<th>Deliery Time</th>";
		echo "<th class='text-right'>Unit Price</th>";
		echo "<th class='text-right'>Total</th>";
		echo "</tr>";
		echo "</thead>";
		echo "<tbody>";
		$no=1;
		$total = 0;
		foreach ($recomendation as $sop_id => $vendor_id) {
			if($vendor_id == $key)
			{
				$r = $this->vendor_lib->sop_get(['t_sop.id'=>$sop_id])->row();
				echo "<tr>";
				echo "<td>$no</td>";
				echo "<td>$r->item</td>";

				$qty = $r->qty1;
				if($r->qty2)
				{
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
			}
		}
		echo "</tbody>";
		echo "</tfoot>";
		echo "<tr><td colspan='9'>Total</td><td class='text-right'>".numIndo($total)."</td></tr>";
		echo "</tbody>";
		echo "</table>";
	}
?>
