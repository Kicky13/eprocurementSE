<?php 
	$x = $this->vendor_lib->sop_get(['msr_item_id'=>$r->line_item])->result();
	$no = 1;
  
	foreach ($x as $key => $value) :
?>
	<tr>
    <td colspan="3"><?=$value->item?></td>
    <td>
      QTY 1 = <?=$value->qty1?>
      <?php $qty = $value->qty1;?>
      <?php if($value->qty2): ?>
      	<br>QTY 2 = <?=$value->qty2?>
      	<?php $qty += $value->qty2;?>
      <?php endif;?>
      <input type="hidden" id="qty_<?=$no?>" value="<?=$qty?>">
    </td>
    <td>
    	UOM 1 = <?=$value->uom1?>
    	<?php if($value->uom2): ?>
      	<br>UOM 2 = <?=$value->uom2?>
      <?php endif;?>
    </td>
    <td>
      <input type="number" name="unit_month[<?=$value->id?>]" class="form-control" style="width: 50% !important;float: left;" placeholder="Month" value="<?= @$tBidDetail->unit_month ?>">
      <input type="number" name="unit_week[<?=$value->id?>]" class="form-control" style="width: 50% !important" placeholder="Week" value="<?= @$tBidDetail->unit_week ?>">
    </td>
    <td>
      <input value="<?= $itemPrice ?>" type="number" class="form-control" name="unit_price[<?=$value->id?>]" required="" id="unit_price_<?=$no?>" onchange="unitPriceChange()">
    </td>
    <td id="sub_total_<?=$no?>">
      <?= numIndo($qty * $itemPrice, 0) ?>
    </td>
  </tr>
  <?php $no++;?>
<?php endforeach;?>