<table width="100%">
	<tbody>
		<?php foreach ($log_lists->result() as $r)?>
		<tr>
			<td>
				<p><b><?=$r->author_name?></b> <?=$r->description?></p>
				<br>
				<?=dateToIndo($r->created_at)?>
			</td>
		</tr>
		<?php endforeach;?>
	</tbody>
</table>