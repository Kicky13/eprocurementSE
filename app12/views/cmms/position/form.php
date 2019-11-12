<table class="table">
	<tr>
		<td>Title</td>
		<td><input value="<?= @$row->title ?>" name="title" id="title" class="form-control"></td>
	</tr>
	<tr>
		<td>User</td>
		<td>
			<select class="form-control" name="user_id" id="user_id">
				<?php foreach ($user->result() as $r): ?>
					<option value="<?=$r->ID_USER?>"><?= $r->NAME ?></option>
				<?php endforeach;?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Supervisor</td>
		<td>
			<select class="form-control" name="parent_id" id="parent_id">
				<option value="0">--No Selected--</option>
				<?php foreach ($parent->result() as $r): ?>
				<option value="<?=$r->id?>" <?= $r->id == @$row->parent_id ? "selected=''" : '' ?>><?= $r->NAME ?></option>
				<?php endforeach;?>
			</select>
		</td>
	</tr>
	<tr>
		<td>Rule</td>
		<td>
			<select class="form-control" name="portal_rule" id="portal_rule">
				<?php foreach (portal_rule('',true) as $k=>$v): ?>
				<option value="<?=$k?>" <?= $k == @$row->portal_rule ? "selected=''" : '' ?>><?= $v ?></option>
				<?php endforeach;?>
			</select>
		</td>
	</tr>
</table>
<?php if($id): ?>
	<input type="hidden" name="id" id="id" value="<?= $id ?>">
<?php endif;?>