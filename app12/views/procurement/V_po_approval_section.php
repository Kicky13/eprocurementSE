<style src="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css" type="text/stylesheet"></style>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/select/select2.min.js" type="text/javascript"></script>
<div class="row">
  <div class="col-md-12" style="overflow: auto">
<table class="table table-striped">
  <thead>
    <tr>
      <th width="1">No</th>
      <th>Role</th>
      <th>User</th>
      <th>Approval Status</th>
      <th>Transaction Date</th>
      <th>Comment</th>
      <th class="text-center">Action</th>
    </tr>
  </thead>
	<tbody>
  <?php
  $no = 1;
  $urutan = [];
  $msr = $this->M_msr->find($po->msr_no);
  foreach ($rows as $row) :
    $t_approval_id = $row->t_approval_id;
    $m_approval_id = $row->approval_id;
    $urutan[$row->urutan] = $row->status;

    if ($row->status == 0) {
        if ($row->urutan == 2) {
            $user_approver = @user($msr->create_by);
        }
        elseif ($row->urutan == 3) {
            $creator_jabatan = $this->M_jabatan->findByUser($msr->create_by);
            $manager_jabatan = @$this->M_jabatan->findParentJabatan($creator_jabatan, 1)[0];
            $user_approver = @user(@$manager_jabatan->user_id);
        }
        else {
            $user_approver = @$this->M_view_user->getByRole($row->role_id)[0];
        }
    }
    else {
        $user_approver = @user($row->created_by);
    }

    $display_approve_button = false;
    if (in_array($row->role_id, $roles)) {
      if ($row->urutan - 1 == 0) {
        if ($row->status != 1) {
          $display_approve_button = true;
        }
      }
      elseif (@$urutan[$row->urutan - 1] == 1 || @$urutan[$row->urutan - 1] == 2) {
        if ($row->status != 1 && $user_approver->ID_USER == $this->session->userdata('ID_USER')) {
          $display_approve_button = true;
        }
      }
    }


  ?>
    <tr>
      <td><?= $no++?></td>
      <td><?= $row->role_name ?></td>
      <td><?= @$user_approver->NAME ?></td>
      <td><?= langApproval($row->status)['title'] ?></td>
      <td><?= $row->status > 0 ? dateToIndo($row->created_at) : '-' ?></td>
      <td><?= $row->deskripsi ?></td>
      <td>
        <?php if ($display_approve_button): ?>
        <a href='#' onclick='approveRejectModal(<?= $t_approval_id ?>)' class='btn btn-sm btn-primary'>Approve/Reject</a>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach;?>
	</tbody>
</table>

  </div>
</div>
<?php /* The hack. Add first child form to able querying second form */ ?>
<form></form>
<!-- Modal -->
<div class="modal fade" id="approvalActionModal" tabindex="-1" role="dialog" aria-labelledby="approvalActionModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Approval</h4>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="approvalActionModalForm">
        	<!-- data_id -->
        	<input type="hidden" name="id" id="id" value="">
        	<input type="hidden" name="data_id" id="data_id" value="<?= $data_id?>">
        	<div class="form-group">
        		<label>Status</label>
        			<select class="form-control" name="status" id="status">
        				<option value="1">Approve</option>
        				<option value="2">Reject</option>
        			</select>
        	</div>
        	<div class="form-group">
        		<label>Description</label>
        			<textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
        	</div>
        	<div class="form-group text-right">
        			<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        			<button type="button" class="btn btn-success" onclick="saveApprovalClick()">Submit</button>
        	</div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
function approveRejectModal(id) {
  $("#approvalActionModal").modal('show');
  $("#approvalActionModal").find('#id').val(id);
}

function saveApprovalClick() {
  var data_id = $("#data_id").val();
  var url = "<?=base_url('procurement/purchase_order/approve')?>/" + data_id;
  xStatus = parseInt($("#status").val());
  if(xStatus == 1)
  {

  }
  else
  {
    if($("#deskripsi").val())
    {

    }
    else
    {
      swal('<?= __('warning') ?>','The Comment field is required','warning')
      return false;
    }
  }
  swalConfirm('Agreement Approval', '<?= __('confirm_submit') ?>', function() {
    $.ajax({
      type: 'POST',
      data: $("#approvalActionModalForm").serialize(),
      url: url,
      success:function(data){
        // alert(data.message)
        if (data.type == 'success') {
          location.replace('<?= base_url('home') ?>');
        } else {
          swal('Done',data.message,'success')
        }
      }
    })
  });
}
</script>
