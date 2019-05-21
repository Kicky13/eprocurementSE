<?php if(isset($arf->revision['value'])):?>

                    <?php
                        $total = 0;
                        foreach ($arf->item as $item) {
                            $qty = $item->qty2 > 0 ? $item->qty1*$item->qty2 : $item->qty1;
                            $response_qty = $item->response_qty1 > 0 ? $item->response_qty1*$item->response_qty2 : $item->response_qty1;
                            $uom = $item->uom2 ? $item->uom1.'/'.$item->uom2 : $item->uom1;
                            $price = $item->new_price > 0 ? $item->new_price : $item->response_unit_price;
                            $subTotalPrice = $price*$qty;      
                            $total += $subTotalPrice;

                    	} 
                    ?>
<?php else:?>
    <?php 
        $total = 0;
    ?>
<?php endif;?>
<h6><i class="step-icon fa fa-thumbs-up"></i> <?= isset($issued) ? ' Amendment Data' : 'Amendment Recommendation' ?></h6>
<fieldset>
    <?php if(isset($issued)): ?>
    <?php else:?>
    <div class="row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="form-group">
                <label>Analysis <small style="font-style: italic">(Technical justification and commercial impact for recommending the Amendment)</small></label>
                <?= $this->form->textarea('analysis', @$recom->analysis, 'class="form-control"') ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Negotiation</label><br>
                <?= $this->form->radio('nego', 0, @$recom->nego) ?> No
                <?= $this->form->radio('nego', 1, @$recom->nego) ?> Yes
            </div>
            <div class="form-group">
                <?= $this->form->textarea('nego_str', @$recom->nego_str, 'class="form-control" style="height:170px;"') ?>
            </div>
        </div>
    </div>
    <div class="row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="form-group">
                <label>Budget Analysis</label>
                <?= $this->form->textarea('budget_analysis', @$recom->budget_analysis, 'class="form-control"') ?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="row amendment_recommendation_tab">
        <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px;font-size: 17px">
            Agreement Data including this Amendment
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <label class="col-md-3">Original Agreement Value</label>
        <div class="col-md-3">
            <input class="form-control" disabled value="<?=numIndo($arf->amount_po)?>">
        </div>
        <label class="col-md-3">Additional Value</label>
        <div class="col-md-3">
          <?php 
            $stt = $total;
          ?>
            <input class="form-control" disabled value="<?=numIndo($total)?>">
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <label class="col-md-3">Latest Agreement Value</label>
        <div class="col-md-3">
            <input id="latest-agreement-value" class="form-control" disabled value="<?=numIndo($arf->amount_po_arf)?>">
        </div>
        <label class="col-md-3">New Agreement Value</label>
        <div class="col-md-3">
            <input class="form-control" id="new-agreement-value" disabled value="<?=numIndo($total+$arf->amount_po_arf)?>">
        </div>
    </div>
    <?php if(isset($issued)): ?>
    <?php else:?>
    <div class="form-group row amendment_recommendation_tab" style="margin-top:20px">
        <div class="col-md-6">
            BOD Approval for this Value Amendment Request is required
            <br>
            <input type="radio" name="bod_approval" value="0"
            <?php 
              if(@$recom->bod_approval == 0)
              {
                echo "checked=''";
              }
            ?>
            >
            <label style="bottom: 10px;position: relative;margin-right: 20px;">No</label>
            <input type="radio" name="bod_approval" value="1" 
            <?php 
              if(isset($recom))
              {
                if($recom->bod_approval == 1)
                {
                  echo "checked=''";
                }
              }
              else
              {
                echo "checked=''";
              }
            ?>
            >
            <label style="bottom: 10px;position: relative;">Yes, BOD Review Required</label>
        </div>
        <div class="col-md-6">
            Accumulative Amendment
            <br>
            <input type="radio" name="aa" value="0" 
            <?php 
              if(@$recom->aa == 0)
              {
                echo "checked=''";
              }
            ?>
            >
            <label style="bottom: 10px;position: relative;margin-right: 20px;">No</label>
            <input type="radio" name="aa" value="1" 
            <?php 
              if(isset($recom))
              {
                if($recom->aa == 1)
                {
                  echo "checked=''";
                }
              }
              else
              {
                echo "checked=''";
              }
            ?>
            >
            <label style="bottom: 10px;position: relative;">Yes, requires 1 level up for the Amendment signature as per AAS</label>
        </div>
    </div>
    <?php endif;?>
    <div class="form-group row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    Original Agreement Period
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                </div>
                <div class="col-md-1 text-center">
                    to
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($po->delivery_date,false,false)?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    Additional Time
                </div>
                <div class="col-md-3" style="font-weight: bold">
                    Up to
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?= $arfRevisionTime ?>">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    Latest Agreement Period
                    <!--
                    po_date
                     -->
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                </div>
                <div class="col-md-1 text-center">
                    to
                </div>
                <div class="col-md-3">
                    <!--
                        kondisi ammendment
                        max date di t_arf_detail_revision kolom tipe per doc_id
                     -->
                    <input class="form-control" disabled value="<?=dateToIndo($arf->amended_date,false,false)?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    New Agreement Period
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                </div>
                <div class="col-md-1 text-center">
                    to
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($newAgreementPeriodTo,false,false)?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px;font-size: 17px">
            Additional Documents
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">Original Expiry Date</div>
                <div class="col-md-4">Latest Expiry Date</div>
            </div>
            <div class="row">
                <div class="col-md-4">Performance Bond</div>
                <div class="col-md-4">
                    <input class="form-control" disabled value="<?= $performanceBondOriginalValue ?>">
                </div>
                <div class="col-md-4"><input class="form-control" disabled value="<?=$new_date_1?>" ></div>
            </div>
            <div class="row">
                <div class="col-md-4">Insurance</div>
                <div class="col-md-4">
                    <input class="form-control" disabled value="<?= $insuranceOriginalValue ?>">
                </div>
                <div class="col-md-4"><input class="form-control" disabled value="<?=$new_date_2?>"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">Extend</div>
                <div class="col-md-5">New Date</div>
                <div class="col-md-5">Remarks</div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <input type="checkbox" name="extend1" id="extend1" value="1" 
                    <?php
                        if($view)
                        {
                            echo $extend1 ? "disabled='' checked='checked'" : "";
                        }
                    ?>
                    >
                </div>
                <div class="col-md-5"><input class="form-control" disabled="" name="new_date_1" id="new_date_1" value="<?= $newDate1Now ?>" ></div>
                <div class="col-md-5"><input class="form-control" disabled="" name="remarks_1" id="remarks_1" value="<?= $remarks_1 ?>" ></div>
            </div>
            <div class="row">
                <div class="col-md-2">
                    <input type="checkbox" name="extend2" id="extend2" value="1"
                    <?php
                        if($view)
                        {
                            echo $extend2 ? "disabled='' checked='checked'" : "";
                        }
                    ?>
                    >
                </div>
                <div class="col-md-5"><input class="form-control" disabled="" name="new_date_2" id="new_date_2" value="<?= $newDate2Now ?>" ></div>
                <div class="col-md-5"><input class="form-control" disabled="" name="remarks_2" id="remarks_2" value="<?= $remarks_2 ?>" ></div>
            </div>
        </div>
    </div>
    <?php if(isset($issued)):?>
    <?php else:?>
    <div class="row">
        <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px;font-size: 17px;">
            Recommendation
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            Based on the above overall analysis, Team is recommending continuing the amendment process by signing the Amendment <b><?= substr($arf->doc_no, -5) ?></b> of this Agreement.
        </div>
    </div>
    <?php endif;?>
</fieldset>
<?php if(isset($arf->revision['value'])):?>
<h6><i class="step-icon fa fa-calendar"></i> SOP List Item</h6>
<fieldset>
    <div id="po-detail">
        <h4>Contract List Item</h4>
        <table width="100%" id="po_item-table" class="table table-bordered table-sm">
            <thead>
                <tr>
                    <th>Item Type</th>
                    <th>Description</th>
                    <th class="text-center">Qty</th>
                    <th class="text-center">UoM</th>
                    <th class="text-center">Item Modif</th>
                    <th class="text-center">Inventory Type</th>
                    <th class="text-center">Cost Center</th>
                    <th class="text-center">Acc Sub</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($po->item as $item) { ?>
                    <tr>
                        <td><?= $item->item_type ?></td>
                        <td><?= $item->material_desc ?></td>
                        <td class="text-center"><?= $item->qty ?></td>
                        <td class="text-center"><?= $item->uom ?></td>
                        <td class="text-center"><?= ($item->item_modification) ? '<i class="fa fa-check-square text-success"></i>' : '<i class=" fa fa-times text-danger"></i>' ?></td>
                        <td class="text-center"><?= $item->inventory_type ?></td>
                        <td class="text-center"><?= $item->id_costcenter ?> - <?= $item->costcenter ?></td>
                        <td class="text-center"><?= $item->id_account_subsidiary ?> - <?= $item->account_subsidiary ?></td>
                        <td class="text-right"><?= numIndo($item->unit_price) ?></td>
                        <td class="text-right"><?= numIndo($item->total_price) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <div class="form-group row">
            <label class="offset-md-6 col-md-3">Total</label>
            <div class="col-md-3 text-right">
                <?= numIndo($arf->amount_po) ?>
            </div>
        </div>
        <?php 
            $dataTotalSummary = 0;
            $latestAdditionalValue = 0;
            foreach ($findAllResult as $key=>$value) :
        ?>  
        <div class="row">
          <div class="col-md-6">
              <h4><?= $key ?></h4>
          </div>
        </div><br>
        <div class="table-responsive">
          <table id="arf_item-table" class="table table-bordered table-sm" style="font-size: 12px;">
              <thead>
                  <tr>
                      <th>Item Type</th>
                      <th>Description</th>
                      <th class="text-center">Qty</th>
                      <th class="text-center">UoM</th>
                      <th class="text-center">Item Modif</th>
                      <th class="text-center">Inventory Type</th>
                      <th class="text-center">Cost Center</th>
                      <th class="text-center">Acc Sub</th>
                      <th class="text-right">Unit Price</th>
                      <th class="text-right">Total</th>
                  </tr>
              </thead>
              <tbody>
                  <?php
                      $total = 0;
                      foreach ($value as $item) {
                          $qty = $item->qty2 > 0 ? $item->qty1*$item->qty2 : $item->qty1;
                          $response_qty = $item->response_qty1 > 0 ? $item->response_qty1*$item->response_qty2 : $item->response_qty1;
                          $uom = $item->uom2 ? $item->uom1.'/'.$item->uom2 : $item->uom1;
                          $price = $item->new_price > 0 ? $item->new_price : $item->response_unit_price;
                          $subTotalPrice = $price*$qty;      
                          $total += $subTotalPrice;
                  ?>
                      <tr id="arf_item-row-<?= $item->item_semic_no_value ?>" data-row-id="<?= $item->item_semic_no_value ?>">
                          <td><?= $item->item_type ?></td>
                          <td><?= $item->item ?></td>
                          <td class="text-center"><?= $qty ?></td>
                          <td class="text-center"><?= $uom ?></td>
                          <td class="text-center"><?= ($item->item_modification) ? '<i class="fa fa-check-square text-success"></i>' : '<i class=" fa fa-times text-danger"></i>' ?></td>
                          <td class="text-center"><?= $item->inventory_type ?></td>
                          <td class="text-center"><?= $item->id_costcenter ?> - <?= $item->costcenter_desc ?></td>
                          <td class="text-center"><?= $item->id_accsub ?> - <?= $item->accsub_desc ?></td>
                          <td class="text-right"><?= numIndo($price) ?></td>
                          <td class="text-right">
                              <?= numIndo($subTotalPrice) ?>
                          </td>
                      </tr>
                  <?php } ?>
              </tbody>
          </table>
        </div>
        <div class="form-group row">
          <label class="offset-md-6 col-md-3">Total</label>
          <div class="col-md-3 text-right">
              <?php 
                   echo numIndo($total); 
                          $latestAdditionalValue += $total;

              ?>
          </div>
        </div>
        <div class="form-group row hidden">
          <label class="offset-md-6 col-md-3">Total Summary</label>
          <div class="col-md-3 text-right amd-<?= $key ?>" data-total-summary="<?= $arf->amount_po + $total ?>">
              <?= numIndo($arf->amount_po + $total ) ?>
              <?php 
                $dataTotalSummary += $arf->amount_po + $total;
              ?>
          </div>
        </div>
        <?php endforeach;?>
        <div class="row">
            <div class="col-md-6">
                <h4><?= $arf->doc_no ?></h4>
            </div>
        </div><br>
        <div class="table-responsive">
            <table id="arf_item-table" class="table table-bordered table-sm" style="font-size: 12px;">
                <thead>
                    <tr>
                        <th>Item Type</th>
                        <th>Description</th>
                        <th class="text-center">Qty</th>
                        <th class="text-center">UoM</th>
                        <th class="text-center">Item Modif</th>
                        <th class="text-center">Inventory Type</th>
                        <th class="text-center">Cost Center</th>
                        <th class="text-center">Acc Sub</th>
                        <th class="text-right">Unit Price</th>
                        <th class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $total = 0;
                        foreach ($arf->item as $item) {
                            $qty = $item->qty2 > 0 ? $item->qty1*$item->qty2 : $item->qty1;
                            $response_qty = $item->response_qty1 > 0 ? $item->response_qty1*$item->response_qty2 : $item->response_qty1;
                            $uom = $item->uom2 ? $item->uom1.'/'.$item->uom2 : $item->uom1;
                            $price = $item->new_price > 0 ? $item->new_price : $item->response_unit_price;
                            $subTotalPrice = $price*$qty;      
                            $total += $subTotalPrice;
                    ?>
                        <tr id="arf_item-row-<?= $item->item_semic_no_value ?>" data-row-id="<?= $item->item_semic_no_value ?>">
                            <td><?= $item->item_type ?></td>
                            <td><?= $item->item ?></td>
                            <td class="text-center"><?= $qty ?></td>
                            <td class="text-center"><?= $uom ?></td>
                            <td class="text-center"><?= ($item->item_modification) ? '<i class="fa fa-check-square text-success"></i>' : '<i class=" fa fa-times text-danger"></i>' ?></td>
                            <td class="text-center"><?= $item->inventory_type ?></td>
                            <td class="text-center"><?= $item->id_costcenter ?> - <?= $item->costcenter_desc ?></td>
                            <td class="text-center"><?= $item->id_accsub ?> - <?= $item->accsub_desc ?></td>
                            <td class="text-right"><?= numIndo($price) ?></td>
                            <td class="text-right">
                                <?= numIndo($subTotalPrice) ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="form-group row">
            <label class="offset-md-6 col-md-3">Total</label>
            <div class="col-md-3 text-right">
                <?= numIndo($total) ?>
            </div>
        </div>
        <div class="form-group row">
            <label class="offset-md-6 col-md-3">Total Summary</label>
            <?php 
                $xTotal = count($findAllResult) > 0 ? $latestAdditionalValue + $arf->amount_po + $total : $dataTotalSummary + $total + $arf->amount_po;
              ?>
            <div class="col-md-3 text-right" id="all-amd-<?= $arf->doc_no ?>" data="<?= numIndo($xTotal) ?>">
              
                <?= numIndo($xTotal) ?>
            </div>
        </div>
    </div>
</fieldset>
<?php else:?>
    <?php 
        $total = 0;
    ?>
<?php endif;?>
<script type="text/javascript">
  $(document).ready(function(){
    const numberWithCommas = (x) => {
      return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
    function numberNormal(n='',separator='.') {
      n = n.replace(/\,/g, '');
      return n;
    }
    <?php if(isset($issued)): ?>
      var new_agreement = $("#all-amd-<?= $arf->doc_no ?>").attr('data')
      var latest_agreement_value = (toFloat(numberNormal(new_agreement)) - toFloat(<?= $stt ?>));
      $("#latest-agreement-value").val(Localization.number(latest_agreement_value))
      $("#new-agreement-value").val(new_agreement)
    <?php endif;?>
  })
</script>