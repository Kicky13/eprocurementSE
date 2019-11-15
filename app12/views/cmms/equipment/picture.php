<div class="col-md-12">
<div class="form-group row hidden">
	<label class="col-md-2">Picture</label>
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
			<?php foreach(cmms_settings('picture_list')->get()->result() as $pic):?>
				<th><?= $pic->desc ?></th>
			<?php endforeach;?>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody id="dt-picture">
		<?php $no=1; foreach ($eq_picture as $key => $value) {
		      $btnDelete = "<a href='#' onclick='deleteImageClick($value->id)' class='btn btn-sm btn-danger'>Delete</a>";
		      $img = "<img class='img-thumbnail' src='".base_url('upload/cmms/equipment_picture/'.$value->picture)."' style='height:100px;width:auto;' />";
			$btnDownload = "<a href='".base_url('upload/cmms/equipment_picture/'.$value->picture)."' target='_blank' class='btn btn-sm btn-info'>$img</a>";
		      echo "<tr><td>$no</td><td>".dateToIndo($value->created_at,false,true)."</td><td>$btnDownload</td><td>$btnDelete</td><tr>";
		      $no++;
		}?>
	</tbody>
</table>