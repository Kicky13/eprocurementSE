<div class="col-md-12">
<div class="form-group row">
	<label>Equipment Number</label>
	<input class="form-control" disabled="" value="<?= @$basic_info_form->FAASID ?>">
</div>
<div class="form-group row">
	<label>Equipment Description</label>
	<input class="form-control" disabled="" value="<?= @$basic_info_form->FADL01 ?>">
</div>
</div>
<table class="table">
	<thead>
		<tr>
			<th width="15">No</th>
			<?php foreach(cmms_settings('pm_list')->get()->result() as $pml):?>
				<th><?= $pml->desc ?></th>
			<?php endforeach;?>
		</tr>
	</thead>
	<tbody>
		<?php 
			$no=1;
			if(isset($pm1))
			{
				foreach ($pm1 as $pm) {
					$taskLink = $pm->WO_NUMBER;
					if($pm->TASKINSTRUCTION)
					{
						$taskLink = "<a href='#' onclick=\"taskInstructionPm('$pm->TASKINSTRUCTION')\">$pm->WO_NUMBER</a>";
					}
					echo "<tr><td>$no</td><td>$taskLink</td><td>$pm->WO_DESC</td><td>$pm->NEXT_DUE_DATE</td></tr>";
					$no++;
				}
			}
		?>
	</tbody>
</table>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">TASK INSTRUCTION</h4>
      </div>
      <div class="modal-body" id="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function taskInstructionPm(task_instruction) {
		$.ajax({
			type:'post',
			data:{task_instruction:task_instruction},
			url:"<?= base_url('cmms/equipment/get_task_instruction_from_pm') ?>",
			success:function(e){
				$("#modal-body").html(e)
				$("#myModal").modal('show')
			}
		})
	}
</script>