<?php 
	$s = $this->vendor_lib->note2($module_kode,$data_id);
	$getBld = $this->vendor_lib->getBld($data_id);
?>
<div class="row" id="vnote">
	<div class="col-md-12">
		<?php if(isset($ci->session->userdata('ACCESS'))): ?>
		<div class="row">
			<label class="col-md-2">To</label>
			<div class="col-md-3">
				<select class="form-control" name="to">
					<option value="0">--All--</option>
					<?php foreach ($getBld->result() as $bld) {
						echo "<option value='$bld->vendor_id'>$bld->NAMA</option>";
					}
					?>
				</select>
			</div>
		</div>
		<?php endif;?>
		<div class="row">
			<div class="col-md-10">
				<input id="description" name="description" class="form-control desc-note" placeholder="Description Here">
			</div>
			<div class="col-md-2">
				<a href="#" class="btn btn-primary" id="kirim-clarification" onclick="kirim()">Send</a>
			</div>
		</div>
	</div>
	<div class="col-md-12">
		<div class="table-responsive" style="margin-top: 20px">
			<table class="table table-condensed table-striped" id="vnote-table">
				<?php foreach ($s->result() as $r) { ?>
				<tr>
					<td>
						<?php
							$where = $r->author_type == 'm_vendor' ? ['ID'=>$r->created_by] : ['ID_USER'=>$r->created_by];
							$auhtor = $this->db->where($where)->get($r->author_type)->row();
							echo $r->author_type == 'm_vendor' ? $auhtor->NAMA : $auhtor->NAME;
						?>
						<br>
						<small><?=dateToIndo($r->created_at,false,true)?></small>
						<br>
						<?=$r->description?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function kirim() {
		$.ajax({
			type:'post',
			data:{data_id:'<?=$data_id?>', module_kode: '<?=$module_kode?>', description: $("#description").val()},
			url:"<?=base_url('note/store')?>",
			beforeSend:function(){
              start($('#vnote'));
            },
			success:function(q){
				$("#vnote-table").html(q);
				stop($('#vnote'));
			},
			error: function (e) {
              alert('Fail, Try Again');
              stop($('#vnote'));
            }
		});
	}
</script>