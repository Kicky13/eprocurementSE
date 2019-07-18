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
			<?php foreach(cmms_settings('wo_list')->get()->result() as $wol):?>
				<th><?= $wol->desc ?></th>
			<?php endforeach;?>
		</tr>
		<tr>
			<?php 
				$no=1;
				foreach ($wo as $key => $value) {
					$woNo = $value->WADOCO;
					$woDesc = $value->WADL01;
					$woType = $value->WOTYPE;
					$woStatus = $value->STATUS;
					echo "<tr><td>$no</td><td>$woNo</td><td>$woDesc</td><td>$woType</td><td>$woStatus</td></tr>";
					$no++;
				}
			?>
			<td></td>
		</tr>
	</thead>
</table>