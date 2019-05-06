<h6><i class="step-icon fa fa-calendar"></i> Schedule of Price</h6>
<fieldset>
    <div id="po-detail">
        <h4>Original</h4>
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
        <div class="row">
            <div class="col-md-6">
                <h4>Amendment</h4>
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
            <div class="col-md-3 text-right">
                <?= numIndo($arf->amount_po + $total ) ?>
            </div>
        </div>
    </div>
</fieldset>