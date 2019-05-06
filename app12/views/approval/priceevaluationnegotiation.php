							<?php 
								$msrItem  = $this->vendor_lib->msrItem($ed->msr_no)->result();
							?>
							<div class="form-group row">
								<div class="table-responsive">
								  <table class="table tablep-condensed">
									<thead>
									  <tr bgcolor="#cccaaaa">
										<th style="width: 15px">NO</th>
										<th>ITEM TYPE</th>
										<th>DESC</th>
										<th>QTY</th>
										<th>Unit Of Measure</th>
										<th>Old Price</th>
										<th>Nego Price</th>
										<th>Sub Total</th>
									  </tr>
									</thead>
									<tbody>
									  <?php 
										$no=1;
										foreach ($msrItem as $r) :
										  $tBidDetail = $this->vendor_lib->tBidDetail(['bled_no'=>$bled_no, 'created_by'=>$vendor_id, 'msr_detail_id'=>$r->line_item])->row();
										  $itemPrice = @$tBidDetail->unit_price ? @$tBidDetail->unit_price : 0;
									  ?>
									  <tr bgcolor="#ccceee">
										<td><?=$no?></td>
										<td><?=$r->id_itemtype?></td>
										<td colspan="10"><?=$r->description?></td>
									  </tr>
										<?php 
										  $x = $this->vendor_lib->sop_get(['msr_item_id'=>$r->line_item])->result();
										  foreach ($x as $key => $value) :
											$tBidDetail = $this->db->where(['vendor_id'=>$vendor_id,'sop_id'=>$value->id])->get('t_sop_bid')->row();
											$itemPrice = @$tBidDetail->unit_price ? @$tBidDetail->unit_price : 0;
											$nego_price = $tBidDetail->nego_price;
										?>
										  <tr>
											<td colspan="2"><?=$value->item?></td>
											<td colspan="2">
											  QTY 1 = <?=$value->qty1?>
											  <?php $qty = $value->qty1;?>
											  <?php if($value->qty2): ?>
												<br>QTY 2 = <?=$value->qty2?>
												<?php $qty += $value->qty2;?>
											  <?php endif;?>
											  <input type="hidden" id="qty_<?=$no?>" value="<?=$qty?>" name="qty_[<?=$value->id?>]">
											</td>
											<td>
											  UOM 1 = <?=$value->uom1?>
											  <?php if($value->uom2): ?>
												<br>UOM 2 = <?=$value->uom2?>
											  <?php endif;?>
											</td>
											<td style="min-width: 150px;">
											  <?= numIndo($itemPrice) ?>
											</td>
											<td>
											  <input style="width: 140px" value="<?= $nego_price ?>" type="text" class="form-control" name="unit_price[<?=$value->id?>]" required="" id="unit_price_<?=$no?>" onchange="unitPriceChange()">
											</td>
											<td id="sub_total_<?=$no?>">
											  <?= numIndo($qty * $nego_price) ?>
											</td>
										  </tr>
										  <?php $no++;?>
										<?php endforeach;?>
									  <?php endforeach;?>
									</tbody>
								  </table>
								</div>
							  </div>
<script type="text/javascript">
function unitPriceChange() {
  var unitPrice = 0;
  for(i=1; i <= <?=$no-1?>; i++){
    if($("#unit_price_"+i).val() === '')
    {
      unit_price = parseInt(0);
    }
    else
    {
      unit_price = parseInt($("#unit_price_"+i).val());
    }
    subTotal  = parseInt(unit_price)*parseInt($("#qty_"+i).val());
    $("#sub_total_"+i).text(numberWithCommas(subTotal));
    unitPrice += subTotal;
  }
}
const numberWithCommas = (x) => {
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
}
</script>