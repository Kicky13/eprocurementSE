<style src="<?= base_url() ?>ast11/app-assets/vendors/css/forms/selects/select2.min.css" type="text/stylesheet"></style>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/select/select2.min.js" type="text/javascript"></script>
<table class="table">
  <thead>
    <tr>
      <th width="15">No</th>
      <th>Role Access</th>
      <th>Approval Status</th>
      <th>Desc</th>
      <th>Approve</th>
    </tr>
  </thead>
	<tbody>
  <?php 
  $no = 1; 
  $urutan = []; 
  foreach ($rows as $row) : 
    $t_approval_id = $row->t_approval_id;	
    $m_approval_id = $row->approval_id;	
    $urutan[$row->urutan] = $row->status;

    $display_approve_button = false;
    if (in_array($row->role_id, $roles)) {
      if ($row->urutan - 1 == 0) {
        if ($row->status != 1) {
          $display_approve_button = true;
        }
      }
      elseif (@$urutan[$row->urutan - 1] == 1 && @$urutan[$row->urutan - 1] != 2) {
        if ($row->status != 1) {
          $display_approve_button = true;
        } 
      }
    }
  ?>
    <tr>
      <td><?= $no++?></td>
      <td><?= $row->role_name ?></td>
      <td><?= langApproval($row->status)['title'] ?></td>
      <td><?= $row->deskripsi ?></td>
      <td>
        <?php if ($display_approve_button): ?>
        <a href='#' onclick='approveRejectModal(<?= $t_approval_id ?>)' class='btn btn-sm btn-primary'>Approve/Reject</a>
        <?php elseif($row->status == '1' || $row->status == '2'): ?>
        <?= $row->created_at ?>
        <?php endif; ?>
      </td>
    </tr>
  <?php endforeach;?>
	</tbody>
</table>

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
        <form method="post" action="<?= base_url('procurment/loi/toApprove/'.$data_id)?>" class="form-horizontal" id="approvalActionModalForm">
        	<!-- data_id -->
        	<input type="hidden" name="id" id="id" value="">
        	<input type="hidden" name="data_id" id="data_id" value="<?= $data_id?>">
        	<div class="form-group">
        		<label>Status</label>
        		<div class="col-sm-12">
        			<select class="form-control" name="status" id="status">
        				<option value="1">Approve</option>
        				<option value="2">Reject</option>
        			</select>
        		</div>
        	</div>
        	<div class="form-group">
        		<label>Deskripsi</label>
        		<div class="col-sm-12">
        			<textarea class="form-control" name="deskripsi"></textarea>
        		</div>
        	</div>
        	<div class="form-group">
        		<div class="col-sm-12">
        			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        			<button type="button" class="btn btn-primary" onclick="saveApprovalClick()">Save changes</button>
        		</div>
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
  var url = "<?=base_url('procurement/loi/approve')?>/" + data_id;

  $.ajax({
    type: 'POST',
    data: $("#approvalActionModalForm").serialize() + '&' + $('#letter_of_intent_form').serialize(),
    url: url,
    success:function(data){
      alert(data.message)

      if (data.type == 'success') {
        location.reload();
      }
    }
  })
}
</script>
