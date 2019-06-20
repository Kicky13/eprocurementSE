<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<table class="table table-bordered">
	<thead>
		<tr>
			<th width="1px">No</th>
			<th>Role</th>
			<th>User</th>
			<th>Approval Status</th>
			<th>Transaction Date</th>
			<th>Comment</th>
			<th class="text-center">Action</th>
		</tr>
	</thead>
	<tbody id="approval_list">
		<?php
			$userLogin = user();
			if($rows->num_rows() > 0):
				$no = 1;
				$urutan = [];
				$s = [];
				foreach ($rows->result() as $row)
				{
					if($row->created_by == $userLogin->ID_USER)
					{
						$s[] = $row;
					}
				}
				/*print_r($s);
				exit();*/
				foreach ($rows->result() as $row) :
					$urutan[$row->urutan] = $row->status;
		?>
				<tr>
					<td><?=$no++?></td>
					<td><?=$row->role_name?></td>
					<td>
						<?php
							$user = user($row->created_by);
							echo $user->NAME;
						?>
					</td>
					<td><?=langApproval($row->status)['title']?></td>
					<td>
						<?php
							if($row->status > 0)
							{
								echo dateToIndo($row->created_at);
							}
						?>
					</td>
					<td><?=$row->deskripsi?></td>
					<td class="text-center">
						<?php
							if($row->created_by == $userLogin->ID_USER)
							{
								$t_approval_id = $row->t_approval_id;
								$m_approval_id = $row->approval_id;
								if($row->status == 0)
								{
									if($row->urutan == 1)
									{
										$str = "<a href='#' onclick='approveRejectModal($t_approval_id)' class='btn btn-sm btn-primary'>Approve/Reject </a>";
										echo $str;
									}
									else
									{
										$disabled = '';
										if(count($s) > 1)
										{
											foreach ($s as $key => $value) {
												if($value->urutan == $row->urutan)
												{
													#cekStatusSebelumnya
													if($key-1 == -1)
													{
														// $disabled = $statusSebelumnya == 1 ? "":"disabled";
													}
													else
													{
														$cekSebelumnya = $s[$key-1];
														$statusSebelumnya = $cekSebelumnya->status;
														$disabled = $statusSebelumnya == 1 ? "":"disabled";
													}
												}
											}
										}
										else
										{
											$q = $this->db->select('t_approval.*')
											->join('m_approval','m_approval.id = t_approval.m_approval_id','left')
											->where([
												'data_id'				=>$msr->msr_no,
												't_approval.status'		=>0,
												't_approval.urutan <'	=>$row->urutan,
												'm_approval.module_kode'	=> $module_kode
											])->get('t_approval');
											// echo $q->num_rows();
											$disabled =  $q->num_rows() > 0 ? "disabled":"";
										}
										$str = "<a href='#' onclick='approveRejectModal($t_approval_id)' class='btn btn-sm btn-primary $disabled'>Approve/Reject </a>";
										echo $str;
									}
								}
								/*if($row->urutan-1 == 0)
								{
									if($row->status <> 1)
									{
										echo "<a href='#' onclick='approveRejectModal($t_approval_id)' class='btn btn-sm btn-primary'>Approve/Reject</a>";
									}
								}
								elseif(@$urutan[$row->urutan-1] == 1 and @$urutan[$row->urutan-1] <> 2)
								{
									if($row->status <> 1)
									{
										echo "<a href='#' onclick='approveRejectModal($t_approval_id)' class='btn btn-sm btn-primary'>Approve/Reject</a>";
									}
								}*/
							}
						?>
					</td>
				</tr>
			<?php endforeach;?>
			<?php
				$msr_spa = $this->approval_lib->msrSpaInMsr($msr);
				if($msr_spa->num_rows() > 0)
				{
					foreach ($msr_spa->result() as $key => $value) {
						$statusStr = '-';
						if($value->status == 1)
						{
							$statusStr = 'Approve';
						}
						elseif($value->status == 2)
						{
							$statusStr = 'Reject';
						}
						elseif($value->status == 3)
						{
							$statusStr = 'Reject';
						}
						elseif($value->status == 4)
						{
							$statusStr = 'Assignment';
						}
						echo "<tr>
						<td>".$no++."</td>
						<td>$value->role_name</td>
						<td>$value->user_name</td>
						<td>".$statusStr."</td>
						<td>".dateToIndo($value->created_at)."</td>
						<td>$value->deskripsi</td>
						<td></td>
						</tr>";
					}
				}
			?>
		<?php else:?>
			<tr>
				<td colspan="5" align="center" class="text-center">No data available in table</td>
			</tr>
		<?php endif;?>
	</tbody>
</table>

<?php /*$this->load->view('approval/list1');*/?>


<script type="text/javascript">
	function approveRejectModal(idnya) {
        if (!validate_status_budget()) {
            return false
        }

		$("#myModal").modal('show');
		$("#id").val(idnya);
	}
	function saveAssignmentClick() {

			url = "<?=base_url('approval/approval/assignment')?>";

		$.ajax({
			type:'post',
			data:$("#frm-assignment").serialize(),
			url:url,
			success:function(r){
				var a = eval("("+r+")");
				alert(a.msg);
				location.reload();
			}
		})
	}
	function saveApprovalClick() {
		swalConfirm('MSR Approval', '<?= __('confirm_approval') ?>', function() {
			xStatus = parseInt($("#status").val());
			if(xStatus == 1) {
				/*approve*/
				url = "<?=base_url('approval/approval/approve')?>";
			} else {
				url = "<?=base_url('approval/approval/reject')?>";
				if($("#deskripsi").val() == '') {
					setTimeout(function() {
						swal('<?= __('warning') ?>','The Comment field is required','warning');
					}, swalDelay);
					return false;
				}
			}
			$.ajax({
				type:'post',
				data:$("#frm").serialize(),
				url:url,
				beforeSend:function(){
					start($('#myModal'));
				},
				success:function(r){
					var a = eval("("+r+")");
					stop($('#myModal'));
					$("#myModal").modal('hide');
					if(a.status) {
						swal('Done','<?= __('success_approve') ?>','success');
						$.ajax({
							type:'post',
							url:"<?=base_url('approval/approval/get_ajax_list_approval')?>",
							data:{data_id:"<?=$data_id?>"},
							success:function(e)
							{
								$("#approval_list").html(e);
							}
						});
					} else {
						window.open("<?=base_url('home')?>","_self");
					}
				},
				error:function(){
					stop($('#myModal'));
				}
			})
		});
	}
	function saveBl() {
		url = "<?=base_url('approval/approval/savebl')?>";
		$.ajax({
			type:'post',
			data:$("#frm-bled").serialize(),
			url:url,
			success:function(r){
				var a = eval("("+r+")");
				// alert(a.msg);
				swal('Done',a.msg,'success')
				location.reload();
			}
		})
	}
	function assignSpCos(idnya) {
		$("#modal-bl").show();
		// $("#t_approval_id").val(idnya);
	}
	function assignSp(idnya) {
		$("#modal-assign").modal('show');
		$("#t_approval_id").val(idnya);
	}
	function addClick() {
		url = "<?=base_url('approval/approval/addbl')?>";
		$.ajax({
			type:'post',
			data:$("#frm-bled").serialize(),
			url:url,
			success:function(r){
				$("#dt-bled").html(r);
			}
		});
	}
	function hapusBlClick(vendorId) {
		url = "<?=base_url('approval/approval/removebl')?>/"+vendorId;
		$.ajax({
			url:url,
			success:function(r){
				$("#dt-bled").html(r);
			}
		});
	}
		$(document).ready(function(){
			$(".select2").select2();
			$("#modal-bl").hide('slow')
			$.ajax({
				url:"<?=base_url('approval/approval/dtBlSession')?>",
				success:function(r){
					$("#dt-bled").html(r);
				}
			});
			/*$("#status").change(function(){
				s = $("#status option:selected").text();
				$("#str-btn-ar").html(s);
			})*/
		});
</script>
