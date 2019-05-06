<table class="table table-condensed table-striped" id="vnote-table">
	<?php foreach ($s->result() as $r) { ?>
	<tr>
		<td>
			<?php
				$where = $r->author_type == 'm_vendor' ? ['ID'=>$r->created_by] : ['ID_USER'=>$r->created_by];
				$auhtor = $this->db->where($where)->get($r->author_type)->row();
				echo $r->author_type == 'm_vendor' ? $auhtor->NAMA : $auhtor->NAME;
			?>
			<br>
			<small><?=dateToIndo($r->created_at,false,true)?></small>
			<br>
			<?=$r->description?>
			<?php if($r->path): ?>
			<br><a target="_blank" href="<?=base_url('upload/CLARIFICATION/'.$r->path)?>" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Download</a>
			<?php endif;?>
		</td>
	</tr>
	<?php } ?>
</table>