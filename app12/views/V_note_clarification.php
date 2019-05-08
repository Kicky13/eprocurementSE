<?php
	$s = $this->vendor_lib->note_clarification($data_id);
?>
<div class="row" id="vnote">
  <?php if (isset($allow_send) && $allow_send == true) { ?>
    <div class="col-md-12">
      <form enctype="multipart/form-data" id="frm-note-clarification" class="open-this">
        <input type="hidden" name="data_id" value="<?=$data_id?>">
        <input type="hidden" name="module_kode" value="<?=$module_kode?>">
        <div class="form-group">
				  <label>Description/Message</label>
          <textarea id="description" name="description" class="form-control desc-note" placeholder="Description/Message Here"></textarea>
        </div>
        <div class="form-group">
    			<label>Attachment</label>
    			<input type="file" name="file_path">
        </div>
    		<div class="form-group text-right">
    			<a href="#" style="margin-top:16px" class="btn btn-success" id="kirim-clarification" onclick="kirim()">Send</a>
    		</div>
      </form>
    </div>
  <?php } ?>
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
              $t_note_detail = $this->db->where(['note_id'=>$r->id])->get('t_note_detail');
						?>
						<br>
						<small><?=dateToIndo($r->created_at,false,true)?></small>
						<br>
						<?=$r->description?>
            <?php if($r->path): ?>
            <br><a target="_blank" href="<?=base_url('upload/CLARIFICATION/'.$r->path)?>" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Download</a>
            <?php endif;?>
            <?php if($t_note_detail->num_rows() > 0 ):?>
              <?php foreach ($t_note_detail->result() as $note_detail):?>
                <?php if($note_detail->path): ?>
                <a target="_blank" href="<?=base_url('upload/CLARIFICATION/'.$note_detail->path)?>" class="btn btn-sm btn-info"><i class="fa fa-download"></i> Download</a>
                <?php endif;?>
              <?php endforeach;?>
            <?php endif;?>
					</td>
				</tr>
				<?php } ?>
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	function kirim() {
    swalConfirm('Clarification', '<?= __('confirm_submit') ?>', function() {
      var form = $("#frm-note-clarification")[0];
      var data = new FormData(form);
      $.ajax({
        type: "POST",
        enctype: 'multipart/form-data',
        url: "<?=base_url('note/store_clarification_vendor')?>",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        timeout: 600000,
        beforeSend:function(){
          start($('#icon-tabs'));
        },
        success: function (data) {
          $("#vnote-table").html(data);
          stop($('#icon-tabs'));
          $("#myModal").modal('hide');
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#icon-tabs'));
          $("#myModal").modal('hide');
        }
      });
    });
		/*$.ajax({
			type:'post',
			data:{data_id:'<?=$data_id?>', module_kode: '<?=$module_kode?>', description: $("#description").val()},
			url:"<?=base_url('note/store_clarification_vendor')?>",
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
		});*/
	}
</script>