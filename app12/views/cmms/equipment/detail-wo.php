<table class="table">
	<tbody>
<?php 
	foreach(cmms_settings('wo_detail')->get()->result() as $wod):
		$desc2 = $wod->desc2;
		$txt = $desc2 ? $wo_detail->$desc2 : '';
		if($wod->desc2 == 'WOTYPE')
		{
			$wotype = $cmms_wo_type = $this->db->where('id', $txt)->get('cmms_wo_type')->row();
			@$txt = $wotype->notation;
		}
?>
		<tr>
			<td><?= $wod->desc ?></td>
			<td><input disabled="" class="form-control" value="<?=$txt?>"></td>
		</tr>
<?php endforeach;?>
	</tbody>
</table>

