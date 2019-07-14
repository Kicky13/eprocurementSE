<div class="col-md-12">
<div class="form-group row">
	<label>Eqipment Number</label>
	<input class="form-control" disabled="">
</div>
<div class="form-group row">
	<label>Eqipment Description</label>
	<input class="form-control" disabled="">
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
	</thead>
</table>