<table class="table">
	<thead>
		<tr>
			<th>ITEM NUMBER</th>
			<th>ITEM DESCRIPTION</th>
			<th>QTY</th>
			<th>UOM</th>
		</tr>
	</thead>
	<tbody>
		<?php 
			foreach ($part_list as $r)
			{
				echo "<tr><td>$r->ITEM_NUMBER</td><td>$r->DESCRIPTION</td><td>$r->QTY</td><td>$r->UOM</td></tr>";
			}
		?>
	</tbody>
</table>