<div class="row">
	<div class="col-md-12">
		<a href="#" class="btn btn-info btn-sm" onclick="togglThisWODetail('detail-wo')">Detail WO</a>
		<a href="#" class="btn btn-info btn-sm" onclick="togglThisWODetail('task-instruction')">Task Instruction</a>
		<a href="#" class="btn btn-info btn-sm" onclick="togglThisWODetail('labor-list')">Labor List</a>
		<a href="#" class="btn btn-info btn-sm" onclick="togglThisWODetail('part-list')">Part List</a>
	</div>
</div>
<div class="row" style="margin-top: 10px">
	<div class="col-md-12 modal-collapse" id="detail-wo">
		<?php $this->load->view('cmms/equipment/detail-wo');?>
	</div>
	<div class="col-md-12 modal-collapse" id="task-instruction">
		<?php $this->load->view('cmms/equipment/task-instruction');?>
	</div>
	<div class="col-md-12 modal-collapse " id="part-list">
		<?php $this->load->view('cmms/equipment/part-list');?>
	</div>
	<div class="col-md-12 modal-collapse" id="labor-list">
		<?php $this->load->view('cmms/equipment/labor-list');?>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(".modal-collapse").hide()
		$('#detail-wo').show()
	})
	function togglThisWODetail(param) {
		$('.modal-collapse').hide()
		$('#'+param).show()
	}
</script>