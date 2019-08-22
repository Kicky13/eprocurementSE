<?php
	$cmms_settings = cmms_settings('spec_form')->get()->result();
?>
<div class="col-md-6">
	<?php
		foreach ($cmms_settings as $bi) :
			if($bi->desc1 == 'left'):
				$col = $bi->desc2;
				$txt = $bi->desc2 == 'FAASID' ? @$basic_info_form->FAASID : @$spec->$col;
	?>
				<div class="form-group">
					<label><?= $bi->desc ?></label>
					<input class="form-control" disabled="" value="<?= @$txt ?>">		
				</div>
		<?php endif;?>
	<?php endforeach;?>
</div>
<div class="col-md-6">
	<?php
		foreach ($cmms_settings as $bi) :
			if($bi->desc1 == 'right'):
				$col = $bi->desc2;
				$txt = $bi->desc2 == 'FAASID' ? @$basic_info_form->FAASID : @$spec->$col;
	?>
				<div class="form-group">
					<label><?= $bi->desc ?></label>
					<input class="form-control" disabled="" value="<?= @$txt ?>">		
				</div>
		<?php endif;?>
	<?php endforeach;?>
</div>
