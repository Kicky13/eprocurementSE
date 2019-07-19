<ul class="nav nav-tabs">
	<li class="active"><a data-toggle="tab" href="#detail-wo">Detail WO</a></li>
	<li><a data-toggle="tab" href="#task-instruction">Task Instruction</a></li>
	<li><a data-toggle="tab" href="#labor-list">Labor List</a></li>
	<li><a data-toggle="tab" href="#part-list">Part List</a></li>
</ul>
<div class="tab-content">
	<div id="detail-wo"><?php $this->load->view('cmms/equipment/detail-wo');?></div>
	<div id="task-instruction"><?php $this->load->view('cmms/equipment/task-instruction');?></div>
	<div id="labor-list"><?php $this->load->view('cmms/equipment/labor-list');?></div>
	<div id="part-list"><?php $this->load->view('cmms/equipment/part-list');?></div>
</div>