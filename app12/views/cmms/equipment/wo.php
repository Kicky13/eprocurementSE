<div class="col-md-12">
<div class="form-group row">
	<label>Equipment Number</label>
	<input class="form-control" disabled="" value="<?= $basic_info_form->FAASID ?>">
</div>
<div class="form-group row">
	<label>Equipment Description</label>
	<input class="form-control" disabled="" value="<?= $basic_info_form->FADL01 ?>">
</div>
</div>
<table class="table">
	<thead>
		<tr>
			<th width="15">No</th>
			<?php foreach(cmms_settings('wo_list')->get()->result() as $wol):?>
				<th><?= $wol->desc ?></th>
			<?php endforeach;?>
		</tr>
		<tr>
			<?php 
				$no=1;
				foreach ($wo as $key => $value) {
					$woNo = $value->WADOCO;
					$woDesc = $value->WADL01;
					$woType = $value->WOTYPE;
					$wotype = $cmms_wo_type = $this->db->where('id', $value->WOTYPE)->get('cmms_wo_type')->row();
					@$woType = $wotype->notation;
					$woStatus = $value->STATUS;
					$woDate = $value->WO_DATE;
					$woFailureDesc = $value->FAILURE_DESC;
					$link = "<a href='#' onclick=\"openModalWoDetail('$woNo')\">$woNo</a>";
					echo "<tr><td>$no</td><td>$link</td><td>$woDesc</td><td>$woType</td><td>$woStatus</td><td>$woDate</td><td>$woFailureDesc</td></tr>";
					$no++;
				}
			?>
			<td></td>
		</tr>
	</thead>
</table>
<div class="modal fade" id="my-modal-wo-detail" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h4>WO Detail - CMMS08</h4>
      </div>
      <div id="result-modal-wo-detail" class="modal-body">
        
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-default pull-left" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span> Cancel</button>
    </div>
<script type="text/javascript">
	function openModalWoDetail(wono) {
		$.ajax({
			type:'post',
			url:"<?= base_url('cmms/equipment/wo_detail') ?>/"+wono,
			success:function(e){
				$("#result-modal-wo-detail").html(e)
				$("#my-modal-wo-detail").modal('show')
			}
		})
	}
</script>