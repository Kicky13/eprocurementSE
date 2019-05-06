<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">Negotiation</h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                        <li class="breadcrumb-item">Negotiation</li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form id="form-negotiation" class="<?= ($negotiation->status == 0 && $negotiation->closed == 0) ? 'open-this' : '' ?>">
                            <table class="table" style="font-size: 12px; margin-left: -10px; margin-right: -10px;">
                                <tr>
                                    <td colspan="2" width="50%"><h4>Enquiry Document</h4></td>
                                    <td colspan="2" width="50%"><h4>Negotiation</h4></td>
                                </tr>
                                <tr>
                                    <td width="150px">Company</td>
                                    <td><?= $negotiation->company ?></td>
                                    <td width="150px">Company Letter No</td>
                                    <td><?= $negotiation->company_letter_no ?></td>
                                </tr>
                                <tr>
                                    <td>Enquiry No</td>
                                    <td><?= $negotiation->bled_no ?></td>
                                    <td>Closing Date</td>
                                    <td><?= dateToIndo($negotiation->closing_date, false, true) ?></td>
                                </tr>
                                <tr>
                                    <td>Subject</td>
                                    <td><?= $negotiation->subject ?></td>
                                    <td>Supporting Document</td>
                                    <td>
                                        <?= ($negotiation->supporting_document) ? '<a href="'.base_url('upload/NEGOTIATION/'.$negotiation->supporting_document).'" class="btn btn-info btn-sm" target="_blank">Download</a>' : 'No Document Uploaded' ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td>&nbsp;</td>
                                    <td>&nbsp;</td>
                                    <td>Note</td>
                                    <td>
                                        <?= nl2br($negotiation->note) ?>
                                    </td>
                                </tr>
                            </table>
                            <div class="form-group row">
                                <label class="col-md-2">Bid Letter No</label>
                                <div class="col-md-2">
                                    <input type="text" name="bid_letter_no" value="<?= $negotiation->bid_letter_no ?>" class="form-control">
                                </div>
                                <div class="col-md-2">
                                    <?php if ($negotiation->status == 0 && $negotiation->closed == 0) { ?>
                                        <input type="file" name="bid_letter_file" style="padding: 0px !important;">
                                    <?php } else { ?>
                                        <a href="<?= base_url('upload/NEGOTIATION/'.$negotiation->bid_letter_file) ?>" class="btn btn-info btn-sm">Download</a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">Local Content</label>
                                <div class="col-md-4">
                                    <select name="id_local_content_type" class="form-control">
                                        <option value="">Please Select</option>
                                        <?php foreach($this->mvn->get_tkdn_type() as $tkdn_type) { ?>
                                            <option value="<?= $tkdn_type->id ?>" <?= $tkdn_type->id == $negotiation->id_local_content_type ? 'selected' : '' ?>><?= $tkdn_type->name ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="offset-md-2 col-md-2">
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" name="local_content" value="<?= $negotiation->local_content ?>" id="local_content" class="form-control">
                                        </div>
                                        <div class="col-md-3 text-right">
                                            %
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <?php if ($negotiation->status == 0 && $negotiation->closed == 0) { ?>
                                        <input type="file" name="local_content_file" style="padding: 0px !important;">
                                    <?php } else { ?>
                                        <a href="<?= base_url('upload/NEGOTIATION/'.$negotiation->local_content_file) ?>" class="btn btn-info btn-sm">Download</a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">Note</label>
                                <div class="col-md-4">
                                    <textarea name="bid_note" id="bid_note" class="form-control"><?= $negotiation->bid_note ?></textarea>
                                </div>
                            </div>
                            <table id="negotiation-table" class="table table-striped table-no-wrap table-price" style="font-size: 12px">
                                 <thead>
                                    <tr>
                                        <th rowspan="2" style="line-height: 55px;">No</th>
                                        <!--<th>Item Type</th>-->
                                        <th rowspan="2" style="line-height: 55px;">Description</th>
                                        <th rowspan="2" class="text-center" style="line-height: 55px;">Qty</th>
                                        <th rowspan="2" class="text-center" style="line-height: 55px;">UoM</th>
                                        <th rowspan="2" class="text-center" style="line-height: 55px;">Qty 2</th>
                                        <th rowspan="2" class="text-center" style="line-height: 55px;">UoM 2</th>
                                        <th rowspan="2" class="text-center" style="line-height: 55px;">Currency</th>
                                        <!--<th class="text-right">Unit Price</th>
                                        <th class="text-right">Total EE Value</th>-->
                                        <th colspan="2" class="text-center">Original/Latest</th>
                                        <th colspan="2" class="text-center">Negotiated</th>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total</th>
                                        <th class="text-right">Unit Price</th>
                                        <th class="text-right">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no = 1 ?>
                                    <?php $subtotal = 0 ?>
                                    <?php $bid_subtotal = 0 ?>
                                    <?php $nego_subtotal = 0 ?>
                                    <?php foreach ($items->result() as $item) { ?>
                                        <tr data-id="<?= $item->id ?>">
                                            <td>
                                                <?= $no ?>
                                                <input type="hidden" name="negotiation[<?= $item->id ?>][sop_type]" value="<?= $item->sop_type ?>" class="form-control text-right">
                                            </td>
                                            <!--<td><?= $item->item_type ?></td>-->
                                            <td><?= $item->item ?></td>
                                            <td class="text-center">
                                                <?= $item->qty1 ?>
                                                <input type="hidden" name="negotiation[<?= $item->id ?>][qty1]" value="<?= $item->qty1 ?>" class="form-control text-right">
                                            </td>
                                            <td class="text-center"><?= $item->uom1 ?></td>
                                            <td class="text-center">
                                                <?= ($item->qty2 > 0) ? $item->qty2 : '-' ?>
                                                <input type="hidden" name="negotiation[<?= $item->id ?>][qty2]" value="<?= $item->qty2 ?>" class="form-control text-right">
                                            </td>
                                            <td class="text-center">
                                                <?= ($item->uom2) ? $item->uom2 : '-' ?>
                                            </td>
                                            <td class="text-center">
                                                <?= $negotiation->currency ?>
                                                <input type="hidden" name="negotiation[<?= $item->id ?>][id_currency]" value="<?= $item->id_currency ?>" class="form-control text-right">
                                                <input type="hidden" name="negotiation[<?= $item->id ?>][id_currency_base]" value="<?= $item->id_currency_base ?>" class="form-control text-right">
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
                                                <input type="hidden" name="negotiation[<?= $item->id ?>][bid_price]" value="<?= $item->latest_price ?>" class="form-control text-right" onkeyup="count_nego_total(<?= $item->id ?>)">
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
                                                <?php if ($negotiation->status == 0 && $negotiation->closed == 0) { ?>
                                                    <input type="text" name="negotiation[<?= $item->id ?>][nego_price]" value="<?= $item->negotiated_price ?>" class="form-control text-right" data-input-type="number-format" onkeyup="count_nego_total(<?= $item->id ?>)" <?= ($item->nego == 0) ? 'readonly' : '' ?>>
                                                <?php } else { ?>
                                                    <?= numIndo($item->negotiated_price) ?>
                                                <?php } ?>
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
                                        <!--<th class="text-right"><?= numIndo($subtotal) ?></th>-->
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
                        </form>
                    </div>
                </div>
            </div>
            <?php if ($negotiation->status == 0 && $negotiation->closed == 0) { ?>
                <div class="form-group text-right">
                    <!--<a href="<?= base_url('vn/info/greetings/negotiation') ?>" class="btn btn-secondary">Cancel</a>-->
                    <button type="button" id="btn-negotiation" class="btn btn-primary">Submit</button>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('[data-input-type="number-format"]').number(true, 2);
        $('#btn-negotiation').click(function() {
            $('#error-message').remove();
            swalConfirm('Negotiation', 'Are you sure to proceed ?', function() {
                var form = $('#form-negotiation')[0];
                var formData = new FormData(form);
                $.ajax({
                    url: '<?= base_url('vn/info/greetings/negotiation_submit/'.$negotiation->id) ?>',
                    type: 'post',
                    data: formData,
                    enctype:'multipart/form-data',
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            setTimeout(function() {
                                swalAlert('Done', 'Data is successfully submitted', '<?= base_url('vn/info/greetings') ?>');
                            }, swalDelay)
                        } else {
                            $('#form-negotiation').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                            $('html,body').animate({ scrollTop: 0 }, 'slow');
                        }
                    }
                });
            });
        });
        $('#local_content').keyup(function() {
            var value = toFloat($('#local_content').val());
            if (value > 100) {
                $('#local_content').val(100);
            }
            if (value < 0) {
                $('#local_content').val(0);
            }
        });
    });
    function count_nego_total(item) {
        var bid_price = toFloat($('[name="negotiation['+item+'][bid_price]').val());
        var nego_price = toFloat($('[name="negotiation['+item+'][nego_price]').val());
        if (nego_price < 0) {
            nego_price = 0;
            $('[name="negotiation['+item+'][nego_price]').val(0);
        }
        var qty1 = toFloat($('[name="negotiation['+item+'][qty1]').val());
        var sop_type = $('[name="negotiation['+item+'][sop_type]').val();
        var qty2 = toFloat($('[name="negotiation['+item+'][qty2]').val());
        var total = nego_price * qty1;
        if (qty2 > 0) {
            total *= qty2;
        }
        $('#negotiation-total_nego_price-'+item).html(Localization.number(total));
        count_nego_subtotal();
    }

    function count_nego_subtotal() {
        var subtotal = 0;
        $.each($('#negotiation-table tbody tr'), function(row, elem) {
            var item = $(elem).data('id');
            var bid_price = toFloat($('[name="negotiation['+item+'][bid_price]').val());
            var nego_price = toFloat($('[name="negotiation['+item+'][nego_price]').val());
            var qty1 = toFloat($('[name="negotiation['+item+'][qty1]').val());
            var sop_type = $('[name="negotiation['+item+'][sop_type]').val();
            var qty2 = toFloat($('[name="negotiation['+item+'][qty2]').val());
            var total = nego_price * qty1;
            if (qty2 > 0) {
                total *= qty2;
            }
            subtotal += total;
        });
        $('#negotiation-nego_subtotal').html(Localization.number(subtotal));
    }
</script>