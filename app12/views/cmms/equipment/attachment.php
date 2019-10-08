<div class="form-control" style="background: #eee">
	<?=$attachment?>
</div>
<?php if($attachment_other->num_rows() > 0): ?>
	<?php foreach ($attachment_other->result() as $r) {
		$link = str_replace("\\",'/',$r->GDGTFILENM);
		echo "<a href='#' onclick=\"openlinkattachment('$link')\" target='_blank'>$r->GDGTITNM</a>";
	}?>
<?php endif;?>
<script>
function openlinkattachment(link){
	window.open("<?=base_url('cmms/equipment/filejde/')?>?xlink="+link,'_blank')
}
</script>