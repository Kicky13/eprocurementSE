<table class="table">
	<thead>
		<tr>
			<th>NAME</th>
			<th>DEPARTMENT</th>
			<th>ACTUAL LABOR HOUR</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($labor_list as $r) {
				$LABOR_HOUR = $r->LABOR_HOUR;
				$laba = substr($LABOR_HOUR, 0, 2);
				$labb = substr($LABOR_HOUR, 2, 2);
				$labor = $laba.'.'.$labb;
				echo "<tr><td>$r->EMPLOYEE_NAME</td><td>$r->DEPARTMENT</td><td>$labor</td></tr>";
			}
		?>
	</tbody>
</table>