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