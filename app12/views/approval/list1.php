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