<?php if($modal): ?>
<div class="modal fade" id="cmms-modal-history" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Log History</h4>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
        	<table class="table">
						<thead>
							<tr>
								<th width="15">NO</th>
								<th>CREATED BY</th>
								<th>CREATED AT</th>
								<th>ACTION</th>
								<th>DESCRIPTION</th>
							</tr>
						</thead>
						<tbody id="cmms-modal-history-table-result">
						</tbody>
					</table>
        </div>
      </div>
      <div class="modal-footer">
      	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
	function getCmmsLogHistory(data_id) 
	{
		$("#cmms-modal-history").modal('show')
		$.ajax({
			type:'post',
			url:"<?=base_url('cmms/log_history/get_cmms_log_history')?>",
			data:{data_id:data_id},
			success:function(e){
				$("#cmms-modal-history-table-result").html(e)
			}
		})
	}
</script>
<?php else: ?>
<?php 
	$no = 1;
	foreach ($rows as $row) {
		$user = user($row->created_by);
		$date = dateToIndo($row->created_at);
		$action = $row->description1;
		$desc = $row->description2;
		echo "<tr><td>$no</td><td>$user->NAME</td><td>$date</td><td>$action</td><td>$desc</td></tr>";
		$no++;
	}
?>
<?php endif;?>