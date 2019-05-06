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
<form method="post" action="<?=base_url('approval/approves')?>" class="form-horizontal" id="frmff">
</form>
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Approval</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?=base_url('approval/approve')?>" class="form-horizontal" id="frm">
        	<!-- data_id -->
        	<input type="hidden" name="id" id="id" value="">
        	<input type="hidden" name="data_id" value="<?=$data_id?>">
        	<input type="hidden" name="module_kode" value="<?=$module_kode?>">
        	<!-- m_approval_id -->
        	<!-- <input type="text" name="m_approval_id" value="<?=$m_approval_id?>"> -->
        	<div class="form-group">
        		<label>Status</label>
        		<select class="form-control" name="status" id="status">
    				<option value="1">Approve</option>
    				<option value="2">Reject</option>
    			</select>
        	</div>
        	<div class="form-group">
        		<label>Comment</label>
        		<textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
        	</div>
        	<div class="form-group text-right">
        		<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        		<button type="button" class="btn btn-success" onclick="saveApprovalClick()" id="str-btn-ar">Submit</button>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Modal ASSIGN SP -->
<div class="modal fade" id="modal-assign" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">MSR ASSIGNMENT</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?=base_url('approval/assignment')?>" class="form-horizontal" id="frm-assignment">
        	<!-- data_id -->
        	<input type="hidden" name="t_approval_id" id="t_approval_id" value="">
        	<input type="hidden" name="data_id" value="<?=$data_id?>">
        	<input type="hidden" name="author_type" value="m_user">
        	<!-- m_approval_id -->
        	<!-- <input type="text" name="m_approval_id" value="<?=$m_approval_id?>"> -->
        	<div class="form-group">
        		<label>Select Procurement Specialist</label>
        		<div class="col-sm-12">
        			<select class="form-control" name="author_id" id="author_id">
        				<option value="1">Dummy 1</option>
        				<option value="2">Dummy 2</option>
        			</select>
        		</div>
        	</div>
        	<div class="form-group">
        		<label style="font-weight: bold">MSR TYPE</label>
        		<div class="col-sm-12">
        			<?=msrType($msr->id_msr_type)->MSR_DESC?>
        		</div>
        	</div>
        	<div class="form-group">
        		<label style="font-weight: bold">PROCUREMENT METHOD</label>
        		<div class="col-sm-12">
        			<?=$msr->id_pmethod.' '.pMethod($msr->id_pmethod)->PMETHOD_DESC?>
        		</div>
        	</div>
        	<div class="form-group">
        		<div class="col-sm-12">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
        			<button type="button" class="btn btn-primary" onclick="saveAssignmentClick()">Save changes</button>
        		</div>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>


		<div class="panel panel-default" id="modal-bl" style="margin-left: 10%">
			<div class="panel-heading">
				<h3 class="panel-title"><?=$msr->title?></h3>
			</div>
			<div class="panel-body">
				<form method="post" class="form-horizontal" id="frm-bled">
		        	<!-- data_id -->
		        	<input type="hidden" name="msr_no" value="<?=$msr->msr_no?>">

		        	<div class="form-group row">
		        		<label class="col-sm-3 col-form-label">TITLE</label>
		        		<div class="col-sm-4">
		        			<input class="form-control" value="<?=$msr->title?>" name="title" required="">
		        		</div>
		        	</div>
		        	<div class="form-group row">
		        		<label class="col-sm-3 col-form-label">VENDOR</label>
		        		<div class="col-sm-4">
		        			<select class="form-control select2" id="vendor" name="vendor">
		        				<?php foreach ($this->db->get('m_vendor')->result() as $v) : ?>
		        					<option value="<?=$v->ID?>"><?=$v->NAMA?></option>
		        				<?php endforeach;?>
		        			</select>
		        		</div>
		        		<div class="col-sm-1">
		        			<a href="javascript:void(0)" class="btn btn-primary btn-md" onclick="addClick()">Add</a>
		        		</div>
		        	</div>
		        	<div class="form-group">
		        		<div class="col-sm-12">
		        			<button type="button" class="btn btn-primary" onclick="saveBl()">Save changes</button>
		        		</div>
		        	</div>
		        </form>
		        <table class="table table-responsive">
		        	<thead>
		        		<tr>
		        			<th rowspan="2">No</th>
		        			<th rowspan="2">Bidder(s) Name</th>
		        			<th rowspan="2">SLKA No</th>
		        			<th rowspan="2">Address</th>
		        			<th colspan="3">Contract</th>
		        			<th rowspan="2">Hapus</th>
		        		</tr>
		        		<tr>
		        			<th>Name</th>
		        			<th>Mobile</th>
		        			<th>Email</th>
		        		</tr>
		        	</thead>
		        	<tbody id="dt-bled">

		        	</tbody>
		        </table>
			</div>
		</div>

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
