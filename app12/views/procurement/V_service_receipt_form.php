<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="row">
    <div class="col-md-4">
        <table class="table">
            <tbody>
                <tr>
                    <td width="35%">Company</td>
                    <td width="1px">:</td>
                    <td><?= $itp->company ?></td>
                </tr>
                <tr>
                    <td>Department</td>
                    <td>:</td>
                    <td><?= $itp->department ?></td>
                </tr>
                <tr>
                    <td>Agreement No</td>
                    <td>:</td>
                    <td><?= $itp->no_po ?></td>
                </tr>
                <tr>
                    <td>Vendor</td>
                    <td>:</td>
                    <td><?= $itp->vendor ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
        <table class="table">
            <tbody>
                <tr>
                    <td width="35%">ITP Date</td>
                    <td width="1px">:</td>
                    <td><?= dateToIndo($itp->dated) ?></td>
                </tr>
                <tr>
                    <td>ITP No</td>
                    <td>:</td>
                    <td><?= $itp->itp_no ?></td>
                </tr>
                <tr>
                    <td>ITP Creator</td>
                    <td>:</td>
                    <td><?= $itp->creator ?></td>
                </tr>
                <tr>
                    <td colspan="3">
                        Note
                        <p style="margin-top: 10px; font-size: 12px"><?= $itp->note ?></p>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="col-md-4">
         <table class="table">
            <tbody>
                <tr>
                    <td width="35%">Total</td>
                    <td width="1px">:</td>
                    <td class="text-right"><?= display_multi_currency_format($itp->total, $itp->currency, $itp->total_base, $itp->currency_base) ?></td>
                </tr>
                <tr>
                    <td>Total Receipt</td>
                    <td>:</td>
                    <td class="text-right">
                        <?= display_multi_currency_format($total_receipt->total_receipt, $itp->currency, exchange_rate_by_id($total_receipt->id_currency, $total_receipt->id_currency_base, $total_receipt->total_receipt), $itp->currency_base) ?>
                    </td>
                </tr>
                <tr>
                    <td>Remaining</td>
                    <td>:</td>
                    <td class="text-right">
                        <?= $this->form->hidden('remaning', ($itp->total - $total_receipt->total_receipt), 'id="remaining"') ?>
                        <?= display_multi_currency_format(($itp->total - $total_receipt->total_receipt), $itp->currency, ($itp->total_base - exchange_rate_by_id($total_receipt->id_currency, $total_receipt->id_currency_base, $total_receipt->total_receipt)), $itp->currency_base) ?>
                    </td>
                </tr>
                <tr>
                    <td>Remaining (%)</td>
                    <td>:</td>
                    <td>
                        <?= round((($itp->total - $total_receipt->total_receipt)/$itp->total) * 100, 2)  ?>%
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="card">
    <div class="card-content">
        <div class="card-body">
            <div class="icons-tab-steps wizard-circle open-this">
                <h6><i class="step-icon fa fa-info"></i> Service Receipt</h6>
                <fieldset>
                    <h2>Service Receipt</h2>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-7">
                                        <label>Service Receipt No</label>
                                        <?= $this->form->text('service_receipt_no', isset($service_receipt_no) ? $service_receipt_no : '', 'id="service_receipt_no" class="form-control" readonly') ?>
                                    </div>
                                    <div class="col-md-5">
                                        <label>Receipt Date</label>
                                        <?= $this->form->text('receipt_date', date('Y-m-d'), 'id="receipt_date" class="form-control"') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Note</label>
                                <?= $this->form->textarea('note', null, 'class="form-control" style="height:100px"') ?>
                            </div>
                        </div>
                    </div>
                    <h2>Item Selection</h2>
                    <table id="detail-item-table" class="table table-bordered table-no-wrap" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th class="text-center">No</th>
                                <th width="150px">Description</th>
                                <th>Qty</th>
                                <th>Unit Price</th>
                                <th>Total</th>
                                <th class="text-center">SR Qty Spending</th>
                                <th class="text-right">SR Total Spending</th>
                                <th class="text-center">Actual Qty Spending</th>
                                <th class="text-right">Actual Total Spending</th>
                                <th class="text-center">Remaining</th>
                                <th class="text-center">Remaining (%)</th>
                                <th width="75px" class="text-center">Qty Receipt</th>
                                <th width="100px" class="text-right">Total Receipt</th>
                                <th width="150px">Note</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = 1 ?>
                            <?php foreach ($itp->detail as $detail) { ?>
                                <tr data-detail-item-row="<?= $detail->id_itp ?>-<?= $detail->material_id ?>">
                                    <td class="text-center"><?= $no ?></td>
                                    <td><?= $detail->material ?></td>
                                    <td><?= $detail->qty ?></td>
                                    <td class="text-right">
                                        <?= numIndo($detail->priceunit) ?>
                                        <?= $this->form->hidden('item['.$detail->id_itp.']['.$detail->material_id.'][price]', $detail->priceunit, 'id="detail-item-row-price-'.$detail->id_itp.'-'.$detail->material_id.'"') ?>
                                    </td>
                                    <td class="text-right"><?= numIndo($detail->total) ?></td>
                                    <td class="text-center"><?= $detail->qty_spending ?></td>
                                    <td class="text-right"><?= numIndo($detail->total_spending) ?></td>
                                    <td class="text-center"><?= $detail->qty_actual ?></td>
                                    <td class="text-right"><?= numIndo($detail->total_actual) ?></td>
                                    <td class="text-right"><?= numIndo(($detail->total - $detail->total_spending)) ?></td>
                                    <td class="text-center">
                                        <?= (($detail->total - $detail->total_spending)/$detail->total) * 100 ?>
                                    </td>
                                    <td><?= $this->form->text('item['.$detail->id_itp.']['.$detail->material_id.'][qty]', null, 'id="detail-item-row-qty-'.$detail->id_itp.'-'.$detail->material_id.'" class="form-control text-center" value="0" style="padding:5px;" onfocus="onFocusDetailItemRow(\''.$detail->id_itp.'\', \''.$detail->material_id.'\')" onkeyup="countTotalRow(\''.$detail->id_itp.'\', \''.$detail->material_id.'\')"') ?></td>
                                    <td><?= $this->form->text('item['.$detail->id_itp.']['.$detail->material_id.'][total]', null, 'id="detail-item-row-total-'.$detail->id_itp.'-'.$detail->material_id.'" class="form-control text-right number" value ="0" style="padding:5px;" readonly') ?></td>
                                    <td><?= $this->form->text('item['.$detail->id_itp.']['.$detail->material_id.'][note]', null, 'id="detail-item-row-note-'.$detail->id_itp.'-'.$detail->material_id.'" class="form-control" style="padding:5px;" onkeyup="noteRow(\''.$detail->id_itp.'\', \''.$detail->material_id.'\')"') ?></td>
                                </tr>
                                <?php $no++ ?>
                            <?php } ?>
                        </tbody>
                    </table>
                    <br></br>
                    <div class="row">
                        <div class="offset-md-6 col-md-6">
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <td width="35%">Total Receipt</td>
                                        <td width="1px">:</td>
                                        <td class="text-right">
                                            <?= $itp->currency ?>
                                            <span id="subtotal-text"><?= numIndo($this->form->data('subtotal', 0)) ?></span>
                                            <?= $this->form->hidden('subtotal', 0, 'id="subtotal" class="form-control"') ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </fieldset>
                <h6><i class="step-icon fa fa-paperclip"></i> Attachment</h6>
                <fieldset>
                    <div class="form-group text-right">
                        <button type="button" id="btn-attachment" class="btn btn-primary">Upload File</button>
                    </div>
                    <table id="attachment-table" class="table" style="font-size: 12px;">
                        <thead>
                            <tr>
                                <th>Description</th>
                                <th>File</th>
                                <th>Upload At</th>
                                <th>Uploader</th>
                                <th class="text-right">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($itp->attachment)) { ?>
                                <?php $i = 1 ?>
                                <?php foreach ($itp->attachment as $attachment) { ?>
                                    <tr data-row-id="<?= $i ?>">
                                        <td>
                                            <input type="hidden" name="attachment[<?= $i ?>][description]" value="<?= $attachment->description ?>">
                                            <?= $attachment->description ?>
                                        </td>
                                        <td>
                                            <input type="hidden" name="attachment[<?= $i ?>][file]" value="<?= $attachment->file ?>"><a href="<?= base_url('upload/PROCUREMENT/SERVICE_RECEIPT/'.$attachment->file) ?>" target="_blank"><?= $attachment->file ?></a>
                                        </td>
                                        <td><?= dateToIndo($attachment->created_date, false, true) ?></td>
                                        <td><?= $attachment->creator ?></td>
                                        <td class="text-right">
                                            <button type="button" class="btn btn-danger btn-sm" onclick="remove_attachment('<?= $i ?>')"><i class="fa fa-trash"></i></button>
                                        </td>
                                    </tr>
                                    <?php $i++ ?>
                                <?php } ?>
                            <?php } ?>
                        </tbody>
                    </table>
                </fieldset>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="attachment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Attachment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Description</label>
                    <?= $this->form->text('attachment_description', null, 'id="form-attachment-description" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>File</label><br>
                    <?= $this->form->upload('attachment_file', null, 'id="form-attachment-file" style="padding:0px !important;"') ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-success" onclick="attachment_upload()">Upload</button>
            </div>
        </div>
    </div>
</div>

<script>
    var onFocusDetailItemRowIdItp;
    var onFocusDetailItemRowIdMaterial;
    var onFocusDetailItemRowQty;

    var attachment_row = $('#attachment-table tbody tr').length;

    $(function() {
        $('.number').number(true, 2);

        $(".icons-tab-steps").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '#title#',
            enableFinishButton: false,
            enablePagination: true,
            enableAllSteps: true,
            enableFinishButton: false,
            labels: {
                finish: 'Done'
            },
            onInit: function (event, current) {
                $('#detail-item-table').dataTable({
                    searching : false,
                    paging : false,
                    ordering : false,
                    info : false,
                    fixedColumns : {
                        leftColumns : 2,
                        rightColumns : 3
                    },
                    scrollX : true
                });
                $('#receipt_date').datepicker({
                    dateFormat: 'yy-mm-dd'
                });
                $('.number').number(true, 2);
                $('.actions > ul > li').attr('style', 'display:none');
            },
            onStepChanged: function (event, current, next) {
                $('.actions > ul > li').attr('style', 'display:none');
            }
        });

        $('#attachment-modal').on('hidden.bs.modal', function() {
            $('#form-attachment-description').val('');
            $('#form-attachment-file').val('');
        });

        $('#btn-attachment').click(function() {
            $('#attachment-modal').modal('show');
        });
    });

    function attachment_upload() {
        $('#attachment-modal #error_message').remove();
        var formData = new FormData;
        formData.append('description', $('#form-attachment-description').val());
        formData.append('file', $('#form-attachment-file')[0].files[0]);
        $.ajax({
            type:'POST',
            enctype:'multipart/form-data',
            data: formData,
            processData: false,
            contentType: false,
            dataType:'json',
            url : '<?= base_url('procurement/service_receipt/doc_upload') ?>',
            success : function(response) {
                if (response.success) {
                    add_attachment($('#form-attachment-description').val(), response.data.file_name, Localization.humanDatetime(new Date()), '<?= $_SESSION['NAME'] ?>')
                    $('#attachment-modal').modal('hide');
                } else {
                    $('#attachment-modal .modal-body').prepend('<div id="error_message" class="alert alert-danger">'+response.message+'</div>');
                }
            }
        });
    }

    function add_attachment(description, file_name, upload_at, upload_by) {
        var html_attachment_table = '<tr data-row-id="'+attachment_row+'">';
            html_attachment_table += '<td>';
                html_attachment_table += '<input type="hidden" name="attachment['+attachment_row+'][description]" value="'+description+'">'+description;
            html_attachment_table += '</td>';
            html_attachment_table += '<td>';
                html_attachment_table += '<input type="hidden" name="attachment['+attachment_row+'][file]" value="'+file_name+'"><a href="<?= base_url('upload/PROCUREMENT/SERVICE_RECEIPT') ?>/'+file_name+'" target="_blank">'+file_name+'</a>';
            html_attachment_table += '</td>'
            html_attachment_table += '<td>'+upload_at+'</td>';
            html_attachment_table += '<td>'+upload_by+'</td>';
            html_attachment_table += '<td class="text-right"><button type="button" class="btn btn-danger btn-sm" onclick="remove_attachment(\''+attachment_row+'\')"><i class="fa fa-trash"></i></button></td>';
        html_attachment_table += '</tr>';
        $('#attachment-table tbody').append(html_attachment_table);
        attachment_row++;
    }

    function remove_attachment(id) {
        $('#attachment-table tbody [data-row-id="'+id+'"]').remove();
    }

    function onFocusDetailItemRow(idItp, idMaterial) {
        onFocusDetailItemRowIdItp = idItp;
        onFocusDetailItemRowIdMaterial = idMaterial;
        onFocusDetailItemRowQty = toFloat($('.DTFC_Cloned #detail-item-row-qty-'+idItp+'-'+idMaterial).val());
    }

    function countTotalRow(idItp, idMaterial) {
        var price = toFloat($('#detail-item-row-price-'+idItp+'-'+idMaterial).val());
        var qty = toFloat($('.DTFC_Cloned #detail-item-row-qty-'+idItp+'-'+idMaterial).val());
        var total = price * qty;
        $('#detail-item-table #detail-item-row-qty-'+idItp+'-'+idMaterial).val(qty);
        $('#detail-item-table #detail-item-row-total-'+idItp+'-'+idMaterial).val(total);
        $('.DTFC_Cloned #detail-item-row-total-'+idItp+'-'+idMaterial).val(total);
        countTotal();
    }

    function countTotal() {
        var subtotal = 0;
        $.each($('#detail-item-table [data-detail-item-row]'), function(i, row) {
            var detailItemRow = $(row).data('detail-item-row');
            var parseDetailItemRow = detailItemRow.split('-');
            var idItp = parseDetailItemRow[0];
            var idMaterial = parseDetailItemRow[1];
            var total = toFloat($('#detail-item-table #detail-item-row-total-'+idItp+'-'+idMaterial).val());
            subtotal += total;
        });
        var remaining = toFloat($('#remaining').val());
        if (subtotal > remaining) {
            swal('Ooopss', 'Service Receipt more than remaining value', 'warning');
            $('.DTFC_Cloned #detail-item-row-qty-'+onFocusDetailItemRowIdItp+'-'+onFocusDetailItemRowIdMaterial).val(onFocusDetailItemRowQty);
            countTotalRow(onFocusDetailItemRowIdItp, onFocusDetailItemRowIdMaterial)
            return false;
        }
        $('#subtotal').val(subtotal);
        $('#subtotal-text').html(Localization.number(subtotal));
    }

    function noteRow(idItp, idMaterial) {
        var note = $('.DTFC_Cloned #detail-item-row-note-'+idItp+'-'+idMaterial).val();
        $('#detail-item-table #detail-item-row-note-'+idItp+'-'+idMaterial).val(note);
    }
</script>