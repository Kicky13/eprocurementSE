<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title">Amendment No <?= $arf->doc_no ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                    <li class="breadcrumb-item">ARF Notification</li>
                  </ol>
                </div>
            </div>
        </div>
        <div class="row info-header">
            <div class="col-md-6">
                <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td width="35%">Title</td>
                            <td width="1px">:</td>
                            <td><?= $arf->title ?></td>
                        </tr>
                        <tr>
                            <td>Contractor / Vendor</td>
                            <td>:</td>
                            <td><?= $arf->vendor ?></td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>:</td>
                            <td><?= $arf->company ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="col-md-6">
                 <table class="table table-condensed">
                    <tbody>
                        <tr>
                            <td>Agreement Number</td>
                            <td>:</td>
                            <td><?= $arf->po_no ?></td>
                        </tr>
                        <tr>
                            <td>Amendment Number</td>
                            <td>:</td>
                            <td><?= substr($arf->doc_no, -5) ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <?= $this->form->open(null, 'id="form-response" class="open-this"') ?>
        <div class="content-body">
            <section id="configuration">
                <div class="content-body">
                    <section id="icon-tabs">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body">
                                    <div class="icons-tab-steps wizard-circl">
                                        <h6><i class="step-icon fa fa-info"></i> Amendment Notification</h6>
                                        <fieldset>
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="text-center">Type/Description<br><small>(thick one when applicable)</small></th>
                                                        <th style="vertical-align: top !important;">Remark</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td width="1px">
                                                            <?php if (isset($arf->revision[1])) { ?>
                                                                <i class="fa fa-check-square text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-square-o"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td>Value</td>
                                                        <td>
                                                            <?php if (isset($arf->revision[1])) { ?>
                                                                <!-- <?= $arf->currency ?> <?= numIndo(@$arf->revision[1]->value) ?> -->
                                                            <?php } ?>
                                                        </td>
                                                        <td><?= @$arf->revision[1]->remark ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="1px">
                                                            <?php if (isset($arf->revision[2])) { ?>
                                                                <i class="fa fa-check-square text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-square-o"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td>Time</td>
                                                        <td><?= dateToIndo(@$arf->revision[2]->value) ?></td>
                                                        <td><?= @$arf->revision[2]->remark ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="1px">
                                                            <?php if (isset($arf->revision[3])) { ?>
                                                                <i class="fa fa-check-square text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-square-o"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td>Scope</td>
                                                        <td><?= @$arf->revision[3]->value ?></td>
                                                        <td><?= @$arf->revision[3]->remark ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td width="1px">
                                                            <?php if (isset($arf->revision[4])) { ?>
                                                                <i class="fa fa-check-square text-success"></i>
                                                            <?php } else { ?>
                                                                <i class="fa fa-square-o"></i>
                                                            <?php } ?>
                                                        </td>
                                                        <td width="50px">Other</td>
                                                        <td><?= @$arf->revision[4]->value ?></td>
                                                        <td><?= @$arf->revision[4]->remark ?></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group row">
                                                        <label class="col-md-4">Contractor/Vendor to Response no Later then</label>
                                                        <div class="col-md-4">
                                                            <?= dateToIndo($arf->response_date, false, true) ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <ht>
                                            <table class="table" style="font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>File</th>
                                                        <th>Upload At</th>
                                                        <th>Uploader</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($arf->attachment as $attachment) { ?>
                                                        <tr>
                                                            <td><?= $attachment->file_name ?></td>
                                                            <td><a href="<?= base_url($attachment->file_path) ?>" target="_blank">Download</a></td>
                                                            <td><?= dateToIndo($attachment->create_date, false, true) ?></td>
                                                            <td><?= $attachment->creator ?></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </fieldset>
                                        <h6><i class="step-icon fa fa-exclamation"></i> Amendment Notification Response</h6>
                                        <fieldset>
                                            <h4>Amendment Notification Response</h4>
                                            <hr>
                                            <table class="table">
                                                <tr>
                                                    <td width="1px"><?= $this->form->radio('confirm', 1, null) ?></td>
                                                    <td>Confirm</td>
                                                </tr>
                                                <tr>
                                                    <td width="1px"><?= $this->form->radio('confirm', 2, null) ?></td>
                                                    <td>
                                                        Confirm With Note
                                                        <?= $this->form->textarea('note', null, 'class="form-control"') ?>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <?php 

                                                        if (isset($arf->revision[1]))
                                                        {   
                                                            $con = "";
                                                        }
                                                        else
                                                        {   
                                                            $con = "disabled=''";
                                                        }
                                                    ?>
                                                    <td width="1px"><?= $this->form->radio('confirm', 3, null, $con) ?></td>
                                                    <td>Quotation refer to schedule of price and attachment</td>
                                                </tr>
                                            </table>
                                            <h4>Attachment</h4>
                                            <hr>
                                            <div class="form-group text-right">
                                                <button type="button" id="btn-attachment" class="btn btn-primary">Upload File</button>
                                            </div>
                                            <table id="attachment-table" class="table" style="font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <th>File Name</th>
                                                        <th>File</th>
                                                        <th>Upload At</th>
                                                        <th>Uploader</th>
                                                        <th class="text-right">Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </fieldset>
                                        <h6><i class="step-icon fa fa-calendar"></i> Schedule of Price</h6>
                                        <fieldset>
                                            <div id="po-detail">
                                                <!-- <h4>Contract List Item</h4>
                                                <div class="table-responsive">
                                                    <table width="100%" id="po_item-table" class="table table-bordered table-sm table-sm table-no-wrap" style="font-size: 12px;">
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
                                                </div>
                                                <div class="form-group row">
                                                    <label class="offset-md-6 col-md-3">Total</label>
                                                    <div class="col-md-3 text-right">
                                                        <?= $this->form->hidden('po_total', $arf->amount_po, 'id="po-total"') ?>
                                                        <?= numIndo($arf->amount_po) ?>
                                                    </div>
                                                </div> -->
                                                <?= $this->form->hidden('po_total', 0, 'id="po-total"') ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <h4>ARF List Item</h4>
                                                    </div>
                                                </div><br>
                                                <div class="table-responsive">
                                                    <?php $total_amendment = 0 ?>
                                                    <table id="arf_item-table" class="table table-bordered table-sm table-no-wrap" style="font-size: 12px;">
                                                        <thead>
                                                            <tr>
                                                                <th>Item Type</th>
                                                                <th>Description</th>
                                                                <th class="text-center">Qty</th>
                                                                <th class="text-center">UoM</th>
                                                                <th class="text-center">Qty 2</th>
                                                                <th class="text-center">UoM 2</th>
                                                                <th class="text-center">Item Modif</th>
                                                                <th class="text-center">Inventory Type</th>
                                                                <th class="text-center">Cost Center</th>
                                                                <th class="text-center">Acc Sub</th>
                                                                <th class="text-right">Unit Price</th>
                                                                <th class="text-right">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php foreach ($arf->item as $item) { ?>
                                                                <tr id="arf_item-row-<?= $item->item_semic_no_value ?>" data-row-id="<?= $item->id ?>">
                                                                    <td><?= $item->item_type ?></td>
                                                                    <td><?= $item->item ?></td>
                                                                    <!--<td class="text-center"><?= $item->qty ?></td>-->
                                                                    <td class="text-center"><?= $this->form->text('arf_item['.$item->id.'][qty1]', $item->qty1, 'class="form-control text-center" style="width:75px" readonly') ?></td>
                                                                    <td class="text-center"><?= $item->uom1 ?></td>
                                                                    <td class="text-center">
                                                                        <?php if ($item->qty2) { ?>
                                                                            <?= $this->form->text('arf_item['.$item->id.'][qty2]', $item->qty2, 'class="form-control text-center" style="width:75px" readonly') ?>
                                                                        <?php } else { ?>
                                                                            -
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td class="text-center">
                                                                        <?= $item->uom2 ? $item->uom2 : '-' ?>
                                                                    </td>
                                                                    <td class="text-center"><?= ($item->item_modification) ? '<i class="fa fa-check-square text-success"></i>' : '<i class=" fa fa-times text-danger"></i>' ?></td>
                                                                    <td class="text-center"><?= $item->inventory_type ?></td>
                                                                    <td class="text-center"><?= $item->id_costcenter ?> - <?= $item->costcenter_desc ?></td>
                                                                    <td class="text-center"><?= $item->id_accsub ?> - <?= $item->accsub_desc ?></td>
                                                                    <!--<td class="text-right"><?= numIndo($item->unit_price) ?></td>-->
                                                                    <td class="text-right">
                                                                        <?php if ($item->po_item_id) { ?>
                                                                            <?= $this->form->text('arf_item['.$item->id.'][unit_price]', 0, 'class="form-control text-right" data-input-type="number-format" style="width:125px" onkeyup="count_total_row(\''.$item->id.'\')"  ') ?>
                                                                        <?php } else { ?>
                                                                            <?= $this->form->text('arf_item['.$item->id.'][unit_price]', 0, 'class="form-control text-right" data-input-type="number-format" style="width:125px" onkeyup="count_total_row(\''.$item->id.'\')"') ?>
                                                                        <?php } ?>
                                                                    </td>
                                                                    <td class="text-right">
                                                                        <?php
                                                                            $total = $item->unit_price * $item->qty1;
                                                                            if ($item->qty2) {
                                                                                $total *= $item->qty2;
                                                                            }

                                                                            $total = 0;
                                                                            
                                                                            $total_amendment += $total;
                                                                        ?>
                                                                        <?= $this->form->hidden('arf_item['.$item->id.'][total]', $total) ?>
                                                                        <span data-m="arf_item-<?= $item->id ?>-total"><!-- <?= numIndo($total) ?> --></span>
                                                                    </td>
                                                                </tr>
                                                            <?php } ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="offset-md-6 col-md-3">Total</label>
                                                    <div class="col-md-3 text-right">
                                                        <?= $this->form->hidden('total', $total_amendment, 'id="total"') ?>
                                                        <span data-m="total"><?= numIndo($total_amendment) ?></span>
                                                    </div>
                                                </div>
                                                <div class="form-group row">
                                                    <label class="offset-md-6 col-md-3">Total Summary</label>
                                                    <div class="col-md-3 text-right">
                                                        <?= $this->form->hidden('arf_po_total', ($total_amendment), 'id="arf-po-total"') ?>
                                                        <span data-m="arf-po-total"><?= numIndo($total_amendment) ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </section>
        </div>
        <button type="button" id="btn-submit" class="btn btn-success">Amendment Notification Response</button>
        <?= $this->form->close() ?>
    </div>
</div>

<div class="modal fade" id="attachment-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <!-- <label>Select Attachment Type</label>
                    <?= $this->form->select('attachment_modal_select_type', array('' => 'Pease Select')+$this->m_arf_attachment->enum('type'), null, 'id="attachment-modal-select_type" class="form-control"') ?> -->
                </div>
                <!-- <div id="form-group-attachment-modal-type" class="form-group" style="display: none;">
                    <?= $this->form->text('attachment_modal_type', null, 'id="attachment-modal-type" class="form-control"') ?>
                </div> -->
                <div class="form-group">
                    <label>File Name</label>
                    <input name="file_name" id="attachment-modal-file-name" class="form-control" required="">
                </div>
                <div class="form-group">
                    <label>Chose File</label>
                    <input type="file" name="attachment_modal_file" id="attachment-modal-file">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="attachment_upload()">Upload</button>
            </div>
        </div>
    </div>
</div>
<script>
    var attachment_row = $('#attachment-table tbody tr').length;
    $(function() {
        $(".icons-tab-steps").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '#title#',
            enableFinishButton: false,
            enablePagination: false,
            enableAllSteps: true,
            enableFinishButton: false,
            labels: {
                finish: 'Done'
            }
        });

        $('[data-input-type="number-format"]').number(true, 2);

        $('#attachment-modal').on('hidden.bs.modal', function() {
            $('#attachment-modal-select_type').val('');
            $('#attachment-modal-file').val('');
            $('#form-group-attachment_modal_type').hide();
            $('#attachment_modal_type').val();
        });

        $('#btn-attachment').click(function() {
            $('#attachment-modal').modal('show');
        });

        $('#attachment-modal-select_type').change(function() {
            if ($('#attachment-modal-select_type').val() == 'other') {
                $('#form-group-attachment-modal-type').show();
                $('#attachment-modal-type').val('');
            } else {
                $('#form-group-attachment-modal-type').hide();
                $('#attachment-modal-type').val($('#attachment-modal-select_type').val());
            }
        });

        $('#btn-submit').click(function() {
            var valConfirm = $("input[name='confirm']:checked"). val();
            if(valConfirm == '3')
            {
                var addAttachment = $(".add-attachment").length;
                if(parseInt(addAttachment) > 0)
                {
                    var answer = swalConfirm('Amendment Notification', 'Are you sure to proceed ?', function() {
                        $.ajax({
                            url : '<?= base_url('vn/info/arf_notification/submit/'.$arf->id) ?>',
                            type : 'post',
                            data : $('#form-response').serialize(),
                            dataType : 'json',
                            success : function(response) {
                                if (response.success) {
                                    setTimeout(function(){ swal('Done','Data is successfully submitted','success'); window.location.href = '<?=  base_url('vn/info/arf_notification') ?>'; }, 3000);
                                } else {
                                    setTimeout(function() {
                                        swal('Ooops', response.message, 'error');
                                    }, 3000);
                                }
                            }
                        });
                    });
                }
                else
                {
                    swal('Amendment Notification', 'Attachment Required', 'warning');
                }

            }
            else
            {
                var answer = swalConfirm('Amendment Notification', 'Are you sure to proceed ?', function() {
                    $.ajax({
                        url : '<?= base_url('vn/info/arf_notification/submit/'.$arf->id) ?>',
                        type : 'post',
                        data : $('#form-response').serialize(),
                        dataType : 'json',
                        success : function(response) {
                            if (response.success) {
                                setTimeout(function(){ swal('Done','Data is successfully submitted','success'); window.location.href = '<?=  base_url('vn/info/arf_notification') ?>'; }, 3000);
                            } else {
                                setTimeout(function() {
                                    swal('Ooops', response.message, 'error');
                                }, 3000);
                            }
                        }
                    });
                });   
            }
            /**/
        });
    });

    function count_total_row(id) {
        var qty = toFloat($('[name="arf_item['+id+'][qty1]"]').val());
        var qty2 = 1;
        if ($('[name="arf_item['+id+'][qty2]"]').length) {
            qty2 = toFloat($('[name="arf_item['+id+'][qty2]"]').val());
        }
        var unit_price = toFloat($('[name="arf_item['+id+'][unit_price]"]').val());
        var total = unit_price * qty * qty2;
        $('[name="arf_item['+id+'][total]"]').val(total);
        $('[data-m="arf_item-'+id+'-total"]').html(Localization.number(total));
        count_total();
    }

    function count_total() {
        var arf_total = 0;
        var po_total = toFloat($('#po-total').val());
        var arf_po_total = 0;
        $.each($('#arf_item-table tbody tr[data-row-id]'), function(key, elem) {
            var id = $(elem).data('row-id');
            var qty = toFloat($('[name="arf_item['+id+'][qty1]"]').val());
            var qty2 = 1;
            if ($('[name="arf_item['+id+'][qty2]"]').length) {
                qty2 = toFloat($('[name="arf_item['+id+'][qty2]"]').val());
            }
            var unit_price = toFloat($('[name="arf_item['+id+'][unit_price]"]').val());
            var total = unit_price * qty * qty2;
            arf_total += total;
        });
        $('#total').val(arf_total);
        $('[data-m="total"]').html(Localization.number(arf_total));
        arf_po_total = po_total + arf_total;
        $('#arf-po-total').val(arf_po_total);
        $('[data-m="arf-po-total"]').html(Localization.number(arf_po_total));
    }

    function attachment_upload() {
        $('#attachment-modal #error_message').remove();
        var formData = new FormData;
        formData.append('file_name', $('#attachment-modal-file-name').val());
        formData.append('file', $('#attachment-modal-file')[0].files[0]);
        $.ajax({
            type:'POST',
            enctype:'multipart/form-data',
            data: formData,
            processData: false,
            contentType: false,
            dataType:'json',
            url : '<?= base_url('vn/info/arf_notification/attachment_upload') ?>',
            success : function(response) {
                if (response.success) {
                    add_attachment(response.nama_file, response.data.file_name, Localization.humanDatetime(new Date()), '<?= $_SESSION['NAME'] ?>')
                    $('#attachment-modal').modal('hide');
                } else {
                    $('#attachment-modal .modal-body').prepend('<div id="error_message" class="alert alert-danger">'+response.message+'</div>');
                }
            }
        });
    }

    function add_attachment(type, file_name, upload_at, upload_by) {
        var html_attachment_table = '<tr class="add-attachment" data-row-id="'+attachment_row+'">';
            html_attachment_table += '<td>';
                html_attachment_table += '<input type="hidden" name="attachment['+attachment_row+'][nama_file]" value="'+type+'">'+type;
            html_attachment_table += '</td>';
            html_attachment_table += '<td>';
                html_attachment_table += '<input type="hidden" name="attachment['+attachment_row+'][file]" value="'+file_name+'"><a href="<?= base_url($document_path) ?>/'+file_name+'" target="_blank">'+file_name+'</a>';
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
</script>