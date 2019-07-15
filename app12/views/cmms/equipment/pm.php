<div class="col-md-12">
<div class="form-group row">
	<label>Eqipment Number</label>
	<input class="form-control" disabled="" value="<?= $basic_info_form->FAASID ?>">
</div>
<div class="form-group row">
	<label>Eqipment Description</label>
	<input class="form-control" disabled="" value="<?= $basic_info_form->FADL01 ?>">
</div>
</div>
<table class="table">
	<thead>
		<tr>
			<th width="15">No</th>
			<?php foreach(cmms_settings('pm_list')->get()->result() as $pml):?>
				<th><?= $pml->desc ?></th>
			<?php endforeach;?>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no=1;
			foreach ($pm1 as $pm) {
				echo "<tr><td>$pm->WO_NUMBER<td><td>$pm->WO_DESC<td><td>$pm->NEXT_DUE_DATE<td></tr>";
				$no++;
			}
		?>
	</tbody>
</table>