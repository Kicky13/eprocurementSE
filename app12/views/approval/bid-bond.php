<?php 
	$t_bid_bond = $this->vendor_lib->tBidBond($bled_no)->result();
	if($this->vendor_lib->tBidBond($bled_no)->num_rows() > 0): 
?>
			<label class="col-12" style="margin-top: 10px;font-weight: bold">Bid Bond</label>
		<div class="table-responsive">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Bid Bond No</th>
            <th>Issuer</th>
            <th>Issued Date</th>
            <th class="text-right">Value</th>
            <th class="text-center">Currency</th>
            <th>Effective Date</th>
            <th>Expired Date</th>
            <th class="text-center">Document</th>
            <!-- <th class="text-center">Status</th> -->
            <th>Description</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					$td = "";
		      foreach ($t_bid_bond as $key => $value) {
	          $td .= "<tr>
	          <td>$value->bid_bond_no</td>
	          <td>$value->issuer</td>
	          <td>".dateToIndo($value->issued_date)."</td>
	          <td class='text-right'>".numIndo($value->nominal)."</td>
	          <td class='text-center'>$value->currency_name</td>
	          <td>".dateToIndo($value->effective_date)."</td>
	          <td>".dateToIndo($value->expired_date)."</td>
	          <td class='text-center'>".($value->bid_bond_file ? '<a target="_blank" href="'.base_url('upload/bid/'.$value->bid_bond_file).'"  class="btn btn-info btn-sm">Download</a>' : '-')."</td>
	          <td>$value->description</td>
	          </tr>";
		      }
		      echo $td;
					?>
				</tbody>
			</table>
		</div>
<?php endif;?>