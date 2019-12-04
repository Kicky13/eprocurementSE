<div class="col-md-12">
<div class="form-group row hidden">
	<label class="col-md-2">Attachment</label>
	<div class="col-md-3">
		
	<input type="file" name="image" id="image_picture" class="form-control" style="height:35px !important;padding:6px">
	</div>
	<div class="col-md-2">
		
	<button type="button" class="btn btn-flat btn-primary btn-block btn-upload">Upload</button>
	</div>
</div>
</div>
<table class="table">
	<thead>
		<tr>
			<th width="15">No</th>
			<th>File Name</th>
			<th>View</th>
		</tr>
	</thead>
	<tbody id="dt-picture">
		<?php $no=1; foreach ($eq_picture->result() as $key => $value) {
			$link = $value->GDGTFILENM;
			$view = "<a href='".$link."' target='_blank' class='btn btn-sm btn-info'>View</a>";
		      echo "<tr><td>$no</td><td>$value->GDGTITNM</td><td>$view</td><tr>";
		      $no++;
		}?>
	</tbody>
</table>