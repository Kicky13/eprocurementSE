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
    <?php $this->load->view('procurement/V_all_amd')?>
</div>