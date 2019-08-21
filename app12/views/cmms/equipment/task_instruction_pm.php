<table class="table table-striped table-condensed">
	<?php 
		$no = 1; 
		foreach ($results as $row) {
		?>
	<tr>
		<td width="15"><?= $no++ ?></td>
		<td><?= $row->CFDS80 ?></td>
	</tr>
	<?php } ?>
</table>