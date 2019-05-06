<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-12 col-12 mb-2">
                <h3 class="content-header-title mb-0">Negotiation</h3>
            </div>
        </div>
        <div class="row info-header">
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 105px;">Company</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->company?></td>
                    </tr>
                    <tr>
                        <td style="width: 105px;">Department</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->department?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 105px;">MSR Number</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->msr_no?></td>
                    </tr>
                    <tr>
                        <td style="width: 105px;">MSR Value</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->currency?> <?=numIndo($ed->total_amount)?> (<small style="color:red"><i>Exclude VAT</i></small>)</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 105px;">ED Number</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->bled_no ?></td>
                    </tr>
                    <tr>
                        <td style="width: 105px;">Title</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->subject?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <form id="form-negotiation">
                            <div class="form-group row">
                                <label class="col-md-2">Company Letter No</label>
                                <div class="col-md-4">
                                    <input type="text" name="company_letter_no" id="company_letter_no" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">Closing Date</label>
                                <div class="col-md-4">
                                    <input type="text" name="closing_date" id="closing_date" class="form-control">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">Supporting Document</label>
                                <input type="file" name="supporting_document" id="supporting_document">
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2">Note</label>
                                <div class="col-md-4">
                                    <textarea name="note" id="note" class="form-control"></textarea>
                                </div>
                            </div>
                            <br>
                            <div class="table-responsive">
                                <table class="table table-striped table-no-wrap table-price" style="font-size: 12px">
                                    <thead>
                                        <tr>
                                            <th rowspan="2" class="text-center" style="line-height: 50px;">No</th>
                                            <th rowspan="2" style="line-height: 50px;">Description</th>
                                            <th rowspan="2" class="text-center" style="line-height: 50px;">Qty</th>
                                            <th rowspan="2" class="text-center" style="line-height: 50px;">UoM</th>
                                            <th rowspan="2" class="text-center" style="line-height: 50px;">Qty 2</th>
                                            <th rowspan="2" class="text-center" style="line-height: 50px;">UoM 2</th>
                                            <th rowspan="2" class="text-center" style="line-height: 50px;">Currency</th>
                                            <!--<th rowspan="2" class="text-right" style="line-height: 50px;">Unit Price</th>
                                            <th rowspan="2" class="text-right" style="line-height: 50px;">Total EE Value</th>-->
                                            <?php foreach ($rs_bl as $r_bl) { ?>
                                                <th colspan="3" class="text-center"><?= $r_bl->NAMA ?></th>
                                            <?php } ?>
                                        </tr>
                                        <tr>
                                            <?php foreach ($rs_bl as $r_bl) { ?>
                                                <th class="text-right">Original</th>
                                                <th class="text-right">Negotiated</th>
                                                <th width="1px" style="padding: 0px !important;">
                                                    <?php if (isset($sop_bid[$r_bl->ID])) { ?>
                                                        <input type="checkbox" name="nego_bl[<?= $r_bl->ID ?>]" value="1" onchange="check_nego_bl('<?= $r_bl->ID ?>')">
                                                    <?php } ?>
                                                </th>
                                            <?php } ?>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1 ?>
                                        <?php $subtotal = array() ?>
                                        <?php $subtotal_nego = array() ?>
                                        <?php foreach ($rs_item as $r_item) { ?>
                                            <tr>
                                                <td><?= $no ?></td>
                                                <td><?= $r_item->item ?></td>
                                                <td class="text-center"><?= $r_item->qty1 ?></td>
                                                <td class="text-center"><?= $r_item->uom1 ?></td>
                                                <td class="text-center">
                                                    <?= $r_item->sop_type == 2 ? $r_item->qty2 : '-' ?>
                                                </td>
                                                <td class="text-center">
                                                    <?= $r_item->sop_type == 2 ? $r_item->uom2 : '-' ?>
                                                </td>
                                                <td class="text-center"><?= $ed->currency ?></td>
                                                <?php foreach ($rs_bl as $r_bl) { ?>
                                                    <td class="text-right">
                                                        <?php
                                                            $unit_price = @$sop_bid[$r_bl->ID][$r_item->id]->unit_price;
                                                            if ($unit_price) {
                                                                $total = $unit_price*$r_item->qty1;
                                                                if ($r_item->sop_type == 2) {
                                                                    $total *= $r_item->qty2;
                                                                }
                                                                if (isset($subtotal[$r_bl->ID])) {
                                                                    $subtotal[$r_bl->ID] += $total;
                                                                } else {
                                                                    $subtotal[$r_bl->ID] = $total;
                                                                }
                                                                echo numIndo($total);
                                                            }
                                                        ?>
                                                    </td>
                                                    <td class="text-right">
                                                        <?php
                                                            $priceunit = @$sop_bid[$r_bl->ID][$r_item->id]->nego_price;
                                                            if ($priceunit) {
                                                                $total = $priceunit*$r_item->qty1;
                                                                if ($r_item->sop_type == 2) {
                                                                    $total *= $r_item->qty2;
                                                                }
                                                                if (isset($subtotal_nego[$r_bl->ID])) {
                                                                    $subtotal_nego[$r_bl->ID] += $total;
                                                                } else {
                                                                    $subtotal_nego[$r_bl->ID] = $total;
                                                                }
                                                                echo numIndo($total);
                                                            }
                                                        ?>
                                                    </td>
                                                    <td style="padding: 10px 0px !important;">
                                                        <?php if (isset($sop_bid[$r_bl->ID][$r_item->id])) { ?>
                                                            <?php if ($sop_bid[$r_bl->ID][$r_item->id]->status === '0') { ?>
                                                                <!-- <i class="fa fa-check-square fa-fw"></i> -->
                                                            <?php } else { ?>
                                                                <input type="hidden" name="sop_bid[<?= $r_bl->ID ?>][<?= $r_item->id ?>][id_currency]" value="<?= @$sop_bid[$r_bl->ID][$r_item->id]->id_currency ?>">
                                                                <input type="hidden" name="sop_bid[<?= $r_bl->ID ?>][<?= $r_item->id ?>][id_currency_base]" value="<?= @$sop_bid[$r_bl->ID][$r_item->id]->id_currency_base ?>">
                                                                <input type="hidden" name="sop_bid[<?= $r_bl->ID ?>][<?= $r_item->id ?>][unit_price]" value="<?= @$sop_bid[$r_bl->ID][$r_item->id]->unit_price ?>">
                                                                <input type="hidden" name="sop_bid[<?= $r_bl->ID ?>][<?= $r_item->id ?>][unit_price_base]" value="<?= @$sop_bid[$r_bl->ID][$r_item->id]->unit_price_base ?>">
                                                                <input type="hidden" name="sop_bid[<?= $r_bl->ID ?>][<?= $r_item->id ?>][nego_price]" value="<?= @$sop_bid[$r_bl->ID][$r_item->id]->nego_price ?>">
                                                                <input type="hidden" name="sop_bid[<?= $r_bl->ID ?>][<?= $r_item->id ?>][nego_price_base]" value="<?= @$sop_bid[$r_bl->ID][$r_item->id]->nego_price_base ?>">
                                                                <input type="checkbox" name="nego[<?= $r_bl->ID ?>][<?= $r_item->id ?>]" value="1">
                                                            <?php } ?>
                                                        <?php } ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="7">Total</th>
                                            <?php foreach ($rs_bl as $r_bl) { ?>
                                                <th class="text-right">
                                                    <?= numIndo(@$subtotal[$r_bl->ID]) ?>
                                                </th>
                                                <th class="text-right">
                                                    <?= numIndo(@$subtotal_nego[$r_bl->ID]) ?>
                                                </th>
                                                <th></th>
                                            <?php } ?>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="form-group text-right">
                <!--<a href="<?= base_url('approval/approval/negotiation') ?>" class="btn btn-outline-secondary">Cancel</a>-->
                <button type="button" id="btn-negotiation" class="btn btn-primary">Negotiation</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#closing_date').datetimepicker({
            format:'YYYY-MM-DD HH:mm'
        });
        $('#btn-negotiation').click(function() {
            swalConfirm('Negotiation', 'Are you sure to proceed ?', function() {
                $('#error-message').remove();
                var form = $('#form-negotiation')[0];
                var formData = new FormData(form);
                $.ajax({
                    url: '<?= base_url('approval/approval/negotiation_request/'.$ed->msr_no) ?>',
                    type: 'post',
                    data: formData,
                    enctype:'multipart/form-data',
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            setTimeout(function() {
                                swalAlert('Done', 'Data is successfully submitted with No. '+$('#company_letter_no').val(), function() {
                                    document.location.reload();
                                });
                            }, swalDelay);
                        } else {
                            $('#form-negotiation').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                            $('html,body').animate({ scrollTop: 0 }, 'slow');
                        }
                    }
                });
            });
            return false;
        });
    });
    function check_nego_bl(vendor) {
        $('[name*="nego['+vendor+']"]').prop('checked', $('[name="nego_bl['+vendor+']"]').prop('checked'));
    }
</script>