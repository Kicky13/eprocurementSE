<div class="col-md-12">
	<form id="form-vendor-items">
		<input type="hidden" name="vendor_id" value="<?=$vendor_id?>">
		<input type="hidden" name="msr_no" value="<?=$msr_no?>">
		<div class="table-responsive">
			<table class="table table-condensed">
				<thead>
					<tr>
						<th>Item Type</th>
						<th>Description</th>
						<th>Qty</th>
						<th>UoM</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
					<?php 
						foreach ($items->result() as $item): 
							$t_sop = $this->db->where(['msr_no'=>$msr_no, 'msr_item_id'=>$item->line_item])->get('t_sop');
					?>
					<tr bgcolor="#ccceee">
						<td><?=$item->id_itemtype?></td>
						<td><?=$item->description?></td>
						<td><?=$item->qty?></td>
						<td><?=$item->uom?></td>
						<td></td>
					</tr>
					<?php 
						foreach ($t_sop->result() as $sop) {
							echo "<tr>
								<td colspan='4'>$sop->item</td>
								<td>
									<input type='checkbox' name='chk[$sop->id]' value='$sop->id'>
								</td>
							</tr>";
						}
					?>
					<?php endforeach;?>
				</tbody>
			</table>
		</div>
	</form>
</div>
<div class="col-md-12 text-center">
	<a href="#" class="btn btn-success issued-nego">Issued Nego</a>
</div>
<script type="text/javascript">
  	$(document).ready(function(){
  		$(".issued-nego").click(function(){
  			var company_letter_no = $("#company_letter_no").val();
  			var closing_date = $("#closing_date").val();
  			var supporting_document = $("#supporting_document").val();

  			if(company_letter_no || closing_date || supporting_document)
  			{
  				$.ajax({
	  				type:'post',
	  				data:$("#form-vendor-items").serialize(),
	  				url:"<?=base_url('approval/approval/issued_nego')?>",
	  				beforeSend:function(){
		              start($('#modalNego'));
		            },
		            success: function (data) {
		            	alert(data);
		              	stop($('#modalNego'));
		            },
		            error: function (e) {
		              alert('Fail, Try Again');
		              stop($('#modalNego'));
		            }
	  			})
  			}
  			else
  			{
  				alert('Header Negotiation must be filled')
  			}
  		});
  	})
</script>