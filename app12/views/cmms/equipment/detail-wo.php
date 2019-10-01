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
		$identity = 'WO ';
		if(isset($_GET['type']))
		{
			if($_GET['type'] == 'wr')
			{
				$identity = 'WR ';
			}
		}
?>
		<tr>
			<td><?= str_replace('WO ', $identity, $wod->desc) ?></td>
			<td><input disabled="" class="form-control" value="<?=$txt?>"></td>
		</tr>
<?php endforeach;?>
	</tbody>
</table>

