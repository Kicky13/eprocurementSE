<?php if($labor_list['estimate']->num_rows() > 0): ?>
<table class="table">
	<thead>
		<tr bgcolor="#ccceee">
			<th colspan="3">ESTIMATE</th>
		</tr>
		<tr>
			<th>DEPARTMENT</th>
			<th>MANHOUR</th>
			<th>MAN POWER</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($labor_list['estimate']->result() as $r) {
				$department = $r->DEPARTMENT;
				$manhour = $r->MANHOUR;
				$manpower = $r->MANPOWER;
				$substr = substr($department, 0, 3);

				if($substr == '3RD')
				{
					echo "<tr><td>$department</td><td>$manhour</td><td>$manpower</td></tr>";
				}

			}
		?>
	</tbody>
</table>
<?php endif;?>
<?php if($labor_list['assignment']->num_rows() > 0): ?>
<table class="table">
	<thead>
		<tr bgcolor="#ccceee">
			<th colspan="3">ASSIGNMENT</th>
		</tr>
		<tr>
			<th>DEPARTMENT</th>
			<th>RESOURCE</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($labor_list['assignment']->result() as $r) {
				$department = $r->WLDSC1;
				$resource = $r->ABALPH;
				
				$substr = substr($department, 0, 3);

				if($substr == '3RD')
				{
					echo "<tr><td>$department</td><td>$resource</td></tr>";
				}
			}
		?>
	</tbody>
</table>
<?php endif;?>
<?php if($labor_list['actual_3rd']->num_rows() > 0): ?>
<table class="table">
	<thead>
		<tr bgcolor="#ccceee">
			<th colspan="2">ACTUAL</th>
		</tr>
		<tr>
			<th>NAME</th>
			<th>ACT HOUR</th>
		</tr>
	</thead>
	<tbody>
		<?php
			foreach ($labor_list['actual_3rd']->result() as $r) {
				$name = $r->NAME;
				$acthour = $r->ACTHOURS;
				echo "<tr><td>$name</td><td>$acthour</td></tr>";
			}
		?>
	</tbody>
</table>
<?php endif;?>