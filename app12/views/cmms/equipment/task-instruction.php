<table class="table">
	<thead>
		<tr>
			<th width="25">No</th>
			<th>Description</th>
		</tr>
	</thead>
	<tbody>
		<?php 
		foreach ($task_instruction as $key => $value) {
		echo "<tr><td>$no</td><td>$value->CFDS80</td></tr>";
		}
		?>
	</tbody>
</table>