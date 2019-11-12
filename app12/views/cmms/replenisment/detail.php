<table class="table table-striped">
  <thead>
    <tr>
    	<th>WO Number</th>
    	<th>WO Reservation Qty</th>
    	<th>Plan Finish Date</th>
    	<th>Request Finish Date</th>
    </tr>
  </thead>
  <tbody>
  	<?php
  	foreach ($data->result() as $d) {
  		echo "<tr>
  		<td>$d->RPDOCO</td>
  		<td>$d->RPTRQT</td>
  		<td>$d->RPDPL</td>
  		<td>$d->RPDRQJ</td>
  		</tr>";
  	}?>
  </tbody>
</table>