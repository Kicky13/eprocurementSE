<table width="100">
	<tbody>
<?php 
	foreach(cmms_settings('wo_detail')->get()->result() as $wod):
		$desc2 = $wod->desc2;
		$txt = $desc2 ? $wo_detail->$desc2 : '';
?>
		<tr>
			<td><?= $wod->desc ?></td>
			<td><input disabled="" class="form-control" value="$txt"></td>
		</tr>
<?php endforeach;?>
	</tbody>
</table>

