<h6><i class="step-icon fa fa-th-list"></i>Schedule Of Price</h6>
<fieldset>
  <div class="row">
    <div class="col-md-12">
       <label style="font-weight: bold;">MST List Item</label>
    </div>
    <div class="col-md-12">
      <table class="table table-condensed">
        <thead>
          <tr>
            <th>Item</th>
            <th class="text-center">Qty</th>
            <th class="text-center">UoM</th>
            <th class="text-center">Currency</th>
            <th class="text-right">Unit Price</th>
            <th class="text-right">Total Value</th>
          </tr>
        </thead>
        <tbody>
          <?php
            $no = 1;
            foreach ($tbmi2->result() as $tmbi) :
          ?>
            <tr>
              <td><?= $tmbi->description ?></td>
              <td class="text-center"><?= $tmbi->qty ?></td>
              <td class="text-center"><?= $tmbi->uom ?> - <?= $tmbi->uom_desc ?></td>
              <td><?= $msr->currency ?></td>
              <td class="text-right"><?= numIndo($tmbi->priceunit) ?></td>
              <td class="text-right"><?= numIndo($tmbi->qty*$tmbi->priceunit) ?></td>
            </tr>
          <?php endforeach;?>
        </tbody>
      </table>
    </div>
    <div class="col-md-12" style="margin-top: 10px">
      <label style="font-weight: bold;">SOP List Item</label>
      <div class="table-responsive">
        <table class="table table-no-wrap table-condensed sop_grid">

        </table>
      </div>
    </div>
  </div>
</fieldset>
<script type="text/javascript">
  $(document).ready(function(){
    $.ajax({
      data:{msr_no:"<?= $msr_no ?>",type:'view'},
      url:"<?= base_url('approval/approval/sop_grid') ?>",
      type:'post',
      success:function(q){
        $(".sop_grid").html(q);
      }
    });
  });
</script>