<h4>Negotiation</h4>
<table class="table table-price" style="font-size: 12px;">
    <tr>
        <td width="200px">Bid Letter No</td>
        <td>
            <?= $negotiation->bid_letter_no ?>
        </td>
        <td>
            <a href="<?= base_url('upload/NEGOTIATION/'.$negotiation->bid_letter_file) ?>" class="btn btn-info btn-sm" target="_blank">Download</a>
        </td>
    </tr>
    <tr>
        <td>Local Content</td>
        <td>
            <?= $negotiation->local_content_type ?> - <?= $negotiation->local_content ?> %
        </td>
        <td>
            <a href="<?= base_url('upload/NEGOTIATION/'.$negotiation->local_content_file) ?>"  class="btn btn-info btn-sm" target="_blank">Download</a>
        </td>
    </tr>
    <tr>
        <td>Note</td>
        <td colspan="2">
            <?= $negotiation->bid_note ?>
        </td>
    </tr>
</table>
<h4>List Item</h4>
<div style="max-width: 100%; overflow-x: auto;">
    <table id="negotiation-table" class="table table-striped table-no-wrap table-price" style="font-size: 12px">
        <thead>
        <tr>
            <th>No</th>
            <th>Description</th>
            <th class="text-center">Qty</th>
            <th class="text-center">UoM</th>
            <th class="text-center">Qty 2</th>
            <th class="text-center">UoM 2</th>
            <th class="text-center">Currency</th>
            <!--<th class="text-right">Unit Price</th>
            <th class="text-right">Total EE Value</th>-->
            <th class="text-right">Latest Value</th>
            <th class="text-right">Latest Total</th>
            <th class="text-right">Negotiated Value</th>
            <th class="text-right">Negotiated Total</th>
        </tr>
        </thead>
        <tbody>
            <?php $no = 1 ?>
            <?php $subtotal = 0 ?>
            <?php $bid_subtotal = 0 ?>
            <?php $nego_subtotal = 0 ?>
            <?php foreach ($items as $item) { ?>
            <tr data-id="<?= $item->id ?>" class="<?= ($item->nego == 1) ? 'text-success' : '' ?>">
                <td>
                    <?= $no ?>
                </td>
                <td><?= $item->item ?></td>
                <td class="text-center">
                    <?= $item->qty1 ?>
                </td>
                <td class="text-center"><?= $item->uom1 ?></td>
                <td class="text-center">
                    <?= $item->sop_type == 2 ? $item->qty2 : '-' ?>
                </td>
                <td class="text-center">
                    <?= $item->sop_type == 2 ? $item->uom2 : '-' ?>
                </td>
                <td class="text-center">
                    <?= $item->currency ?>
                </td>
                <!--<td class="text-right"><?= numIndo($item->priceunit) ?></td>
                <td class="text-right">
                    <?php
                        $total = $item->priceunit*$item->qty1;
                        if ($item->sop_type == 2) {
                            $total *= $item->qty2;
                        }
                        $subtotal += $total;
                    ?>
                    <?= numIndo($total) ?>
                </td>-->
                <td class="text-right">
                    <?= numIndo($item->latest_price) ?>
                </td>
                <td class="text-right">
                    <?php
                        $total = $item->latest_price*$item->qty1;
                        if ($item->sop_type == 2) {
                            $total *= $item->qty2;
                        }
                        $bid_subtotal += $total;
                    ?>
                    <?= numIndo($total) ?>
                </td>
                <td class="text-right">
                    <?= numIndo($item->negotiated_price) ?>
                </td>
                <td class="text-right">
                    <span id="negotiation-total_nego_price-<?= $item->id ?>">
                        <?php
                            $total = $item->negotiated_price*$item->qty1;
                            if ($item->sop_type == 2) {
                                $total *= $item->qty2;
                            }
                            $nego_subtotal += $total;
                        ?>
                        <?= numIndo($total) ?>
                    </span>
                </td>
            </tr>
            <?php $no++ ?>
        <?php } ?>
        </tbody>
        <tfoot>
            <tr>
                <th colspan="7">Total</th>
                <th></th>
                <th class="text-right"><?= numIndo($bid_subtotal) ?></th>
                <th></th>
                <th class="text-right">
                    <span id="negotiation-nego_subtotal">
                        <?= numIndo($nego_subtotal) ?>
                    </span>
                </th>
            </tr>
        </tfoot>
    </table>
</div>
<br>
<a href="javascript:void(0)" class="btn btn-info" onclick="detail_negotiation('<?= $negotiation->company_letter_no ?>')">View Other Negotiation</a>