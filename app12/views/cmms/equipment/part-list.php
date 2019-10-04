<table class="table">
	<thead>
		<tr>
			<th>ITEM NUMBER</th>
			<th>ITEM DESCRIPTION</th>
			<th>REQUEST</th>
			<th>ACTUAL</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($part_list->result() as $r)
			{
				echo "<tr><td>$r->ITEM_NUMBER</td><td>$r->DESCRIPTION</td><td>$r->REQUEST</td><td>$r->ACTUAL</td></tr>";
			}
		?>
	</tbody>
</table>