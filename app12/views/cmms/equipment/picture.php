<div class="col-md-12">
<div class="form-group row">
	<label class="col-md-2">Picture</label>
	<div class="col-md-3">
		
	<input type="file">
	</div>
	<div class="col-md-2">
		
	<button class="btn btn-flat btn-primary btn-block">Upload</button>
	</div>
</div>
</div>
<table class="table">
	<thead>
		<tr>
			<th width="15">No</th>
			<?php foreach(cmms_settings('picture_list')->get()->result() as $pic):?>
				<th><?= $pic->desc ?></th>
			<?php endforeach;?>
			<th>Delete</th>
		</tr>
	</thead>
</table>