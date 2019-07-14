<?php
	$cmms_settings = cmms_settings('basic_info_form')->get()->result();
?>
<div class="col-md-6">
	<?php
		foreach ($cmms_settings as $bi) :
			if($bi->desc1 == 'left'):
			$col = $bi->desc2;
	?>
				<div class="form-group">
					<label><?= $bi->desc ?></label>
					<input class="form-control" disabled="" value="<?= $basic_info_form->$col ?>">
				</div>
		<?php endif;?>
	<?php endforeach;?>
</div>
<div class="col-md-6">
	<?php
		foreach ($cmms_settings as $bi) :
			if($bi->desc1 == 'right'):
			$col = $bi->desc2;
	?>
				<div class="form-group">
					<label><?= $bi->desc ?></label>
					<input class="form-control" disabled="" value="<?= $basic_info_form->$col ?>">
				</div>
		<?php endif;?>
	<?php endforeach;?>
</div>
