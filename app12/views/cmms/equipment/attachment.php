<div class="form-control" style="background: #eee">
	<?=$attachment?>
</div>
<?php if($attachment_other->num_rows() > 0): ?>
	<?php foreach ($attachment_other->result() as $r) {
		echo "<a href='$r->GDGTFILENM' target='_blank'>Download</a>";
	}?>
<?php endif;?>