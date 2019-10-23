<div class="form-control" style="background: #eee;margin-bottom: 10px">
	<?php 
		$x = explode('[', $attachment);
		$s =  str_replace('\par', '<br>', @$x[1]);
		$s =  str_replace('}', ' ', $s);
		$s =  str_replace(']', ' ', $s);
		// $s =  str_replace('Urutan', ' ', $s);
		
		echo $s;
	?>
</div>
<?php if(@$wr->photo): ?>
<a href="<?= base_url('upload/wr/'.$wr->photo) ?>" target='_blank'>WR Attachment</a>
<?php endif;?>
<br>
<?php if($attachment_other->num_rows() > 0): ?>
	<?php foreach ($attachment_other->result() as $r) {
		//$link = str_replace("\\",'/',$r->GDGTFILENM);
		$link = $r->GDGTFILENM;
		echo "<a href='$link' target='_blank'>$r->GDGTITNM</a><br>";
	}?>
<?php endif;?>
<script>
function openlinkattachment(link){
	window.open("<?=base_url('cmms/equipment/filejde/')?>?xlink="+link,'_blank')
}
</script>