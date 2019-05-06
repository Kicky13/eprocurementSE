<?php $this->load->view('procurement/partials/script') ?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Edit ARF", "Edit ARF") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Edit ARF", "Edit ARF") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <?= $this->form->open(null, 'id="form-arf" enctype="multipart/form-data"') ?>
                <?php $this->load->view('procurement/V_arf_form') ?>
                <div class="form-group text-right">
                    <button type="button" id="btn-save-draft" class="btn btn-primary" style="display: none;">Save Draft</button>
                    <button type="button" id="btn-validate-submit" class="btn btn-success" style="display: none;">Submit</button>
                    <?php if (isset($allowed_approve)) { ?>
                        <?php if ($allowed_approve->sequence == 1) { ?>
                            <button type="button" id="btn-validate-resubmit" class="btn btn-success">Resubmit</button>
                        <?php } else { ?>
                            <?php if ($allowed_approve->edit_content == 1) { ?>
                                <button type="button" id="btn-validate-update-approve" class="btn btn-success">Update & Approve</button>
                            <?php } ?>
                        <?php } ?>
                    <?php } ?>
                </div>
            <?= $this->form->close() ?>
        </div>
    </div>
</div>

<?php $this->load->view('procurement/partials/script_arf_form') ?>

<script>
    $(function() {
        /*$('#btn-validate-save-draft').click(function() {
            $('.card-body #error-message').remove();
            if (validate()) {
                $('#btn-save-draft').show();
            }
        });*/

        $('#btn-validate-submit').click(function() {
            $('.card-body #error-message').remove();
            if (validate()) {
                $('#btn-submit').show();
            }
        });

        $('#btn-save-draft').click(function() {
            var data = $('#form-arf').serialize();
            $.ajax({
                url : '<?= base_url('procurement/arf/update/'.$arf->id) ?>',
                type : 'post',
                data : data+'&'+$.param({item : arf_item}),
                dataType : 'json',
                success : function(response) {
                    if (response.success) {
                        setTimeout(function() {
                            swalAlert('<?= __('success') ?>', '<?=  __('success_submit') ?>', '<?= base_url('procurement/arf/edit/'.$arf->id) ?>');
                        }, swalDelay);
                    } else {
                        $('.card-body').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                        $('#validation-modal').modal('hide');
                    }
                }
            })
        });

        $('#btn-submit').click(function() {
            swalConfirm('ARF Preparation', '<?= __('confirm_submit') ?>', function() {
                var data = $('#form-arf').serialize();
                $.ajax({
                    url : '<?= base_url('procurement/arf/update/'.$arf->id) ?>',
                    type : 'post',
                    data : data+'&'+$.param({item : arf_item})+'&submit=1',
                    dataType : 'json',
                    success : function(response) {
                        if (response.success) {
                            document.location.href = '<?= base_url('home') ?>';
                        } else {
                            $('.card-body').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                            $('#validation-modal').modal('hide');
                        }
                    }
                })
            });
        });
    });

    $(function() {
        $('#browse-reference').remove();
        $.ajax({
            url : '<?= base_url('procurement/arf/find_json/'.$arf->id) ?>',
            dataType : 'json',
            success : function(response) {
                if (response.data.po) {
                    var po = response.data.po;
                    $('#no_reference').val(po.po_no);
                    $('#po_id').val(po.id);
                    $('#po-title').html(po.title);
                    $('#id_currency').val(po.id_currency);
                    $('#currency').val(po.currency);
                    $('#id_currency_base').val(po.id_currency_base);
                    $('#currency_base').val(po.currency_base);
                    $('#po_title').val(po.title);
                    $('#po-requestor').html(po.requestor);
                    $('#po-department').html(po.department);
                    $('#po_id_vendor').val(po.id_vendor);
                    $('#po_vendor').val(po.vendor);
                    $('#po_id_company').val(po.id_company);
                    $('#po_company').val(po.company);
                    $('#po_date').val(po.po_date);
                    $('#po_total').val(po.total_amount);
                    $('#po_latest_value').val(po.latest_value);
                    $('#po_spending_value').val(po.spending_value);
                    $('#po_remaining_value').val(po.remaining_value);
                    $('#po_delivery_date').val(po.delivery_date);
                    $('#po_amended_date').val(po.prev_date);
                    $('.label-po_type').html(po.po_type);
                    if (po.po_type == 'PO') {
                        $('.label-po_vendor_type').html('Vendor');
                        $('.label-po_delivery_date').html('PO Delivery Date (take the longest if partial)');
                    } else {
                        $('.label-po_vendor_type').html('Contractor');
                        $('.label-po_delivery_date').html('SO/Contract (CO) Period');
                    }
                    $('[data-m="currency"]').html(po.currency);
                    $('[data-m="currency_base"]').html(po.currency_base);
                    if (po.currency == po.currency_base) {
                        $('#excl_total_equal_to').hide();
                        $('#vat_equal_to').hide();
                        $('#incl_total_equal_to').hide();
                    } else {
                        $('#excl_total_equal_to').show();
                        $('#vat_equal_to').show();
                        $('#incl_total_equal_to').show();
                    }
                    $('#add-item-est_unit_price_id_currency').val(po.id_currency);
                    $('#add-item-est_unit_price_currency').val(po.currency);
                    $('#add-item-est_total_price_id_currency').val(po.id_currency);
                    $('#add-item-est_total_price_currency').val(po.currency);
                    var html_po_item_table = '';
                    po_item = po.item;
                    $.each(po_item, function(i, row) {
                        html_po_item_table += '<tr data-id="'+i+'" data-semic_no="'+row.semic_no+'">';
                            html_po_item_table += '<td>'+row.item_type+'</td>';
                            html_po_item_table += '<td>'+row.material_desc+'</td>';
                            html_po_item_table += '<td class="text-center">'+row.qty+'</td>';
                            html_po_item_table += '<td class="text-center">'+row.uom+' - '+row.uom_desc+'</td>';
                            html_po_item_table += '<td class="text-center">'+Localization.boolean(row.item_modification, 'Yes', 'No')+'</td>';
                            html_po_item_table += '<td>'+coalesce(row.inventory_type, '-')+'</td>';
                            html_po_item_table += '<td>'+coalesce(row.costcenter, '-')+'</td>';
                            html_po_item_table += '<td>'+coalesce(row.id_account_subsidiary)+' - '+coalesce(row.account_subsidiary)+'</td>';
                            html_po_item_table += '<td class="text-right">'+Localization.number(row.unit_price)+'</td>';
                            html_po_item_table += '<td class="text-right">'+Localization.number(row.total_price)+'</td>';
                            html_po_item_table += '<td class="text-right"><button type="button" class="btn btn-primary btn-sm" onclick="copy_po_item_to_arf_item(\''+i+'\')">Copy</button></td>';
                        html_po_item_table += '</tr>';
                    });
                    $('#po_item-table tbody').html(html_po_item_table);
                    get_costcenter({
                        id_company : po.id_company
                    });
                }

                if (response.data.arf) {
                    var arf = response.data.arf;
                    $.each (arf.item, function(i, item) {
                        arf_item[i] = item;
                    });
                    $.each(arf.revision, function(i, revision) {
                        $('#'+revision.type).prop('checked', true);
                        active_amendment(revision.type);
                        $('#'+revision.type+'_value').val(revision.value);
                        $('#'+revision.type+'_remark').val(revision.remark);
                    });
                    $.each(arf.reason, function(i, reason) {
                        $('[name="reason['+reason.reason_id+'][id]"]').prop('checked', true);
                        check_reason(reason.reason_id);
                        $('[name="reason['+reason.reason_id+'][reason]"]').val(reason.description);
                    });
                    $('#expected_commencement_date').val(arf.expected_commencement_date);
                    if (arf.review_bod == 1) {
                        $('#review_bod').prop('checked', true);
                    } else {
                        $('#review_bod').prop('checked', false);
                    }
                    $.each(arf.attachment, function(i, attachment) {
                        add_attachment(attachment.type, attachment.file_name, attachment.file, Localization.humanDatetime(attachment.created_at), attachment.creator)
                    });
                    if (arf.status == 'draft') {
                        $('#btn-save-draft').show();
                        $('#btn-validate-submit').show();
                    }
                }

                arf_table();
                count_total();
                budget_table();
            }
        });
    });
</script>

<?php if (isset($allowed_approve)) { ?>
    <script>
        $(function() {
            $('#validation-modal').on('hidden.bs.modal', function() {
                $('#submit_note').val('');
                $('#submit_note').hide();
            });

            $('#btn-validate-resubmit').click(function() {
                $('.card-body #error-message').remove();
                if (validate()) {
                    $('#btn-resubmit').show();
                }
            });

            $('#btn-resubmit').click(function() {
                swalConfirm('ARF Preparation', '<?= __('confirm_submit') ?>', function() {
                    var data = $('#form-arf').serialize();
                    $.ajax({
                        url : '<?= base_url('procurement/arf/update/'.$arf->id) ?>',
                        type : 'post',
                        data : data+'&'+$.param({item : arf_item})+'&submit_note='+$('#submit_note').val(),
                        dataType : 'json',
                        success : function(response) {
                            if (response.success) {
                                document.location.href = '<?= base_url('home') ?>';
                            } else {
                                $('.card-body').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                                $('#validation-modal').modal('hide');
                            }
                        }
                    });
                });
            });

            $('#btn-validate-update-approve').click(function() {
                $('.card-body #error-message').remove();
                if (validate()) {
                    $('#submit_note').show();
                    $('#btn-update-approve').show();
                }
            });

            $('#btn-update-approve').click(function() {
                swalConfirm('ARF Preparation', '<?= __('confirm_submit') ?>', function() {
                    var data = $('#form-arf').serialize();
                    $.ajax({
                        url : '<?= base_url('procurement/arf/update/'.$arf->id) ?>',
                        type : 'post',
                        data : data+'&'+$.param({item : arf_item})+'&submit_note='+$('#submit_note').val(),
                        dataType : 'json',
                        success : function(response) {
                            if (response.success) {
                                $('#btn-approve-<?= $allowed_approve->id ?>').remove();
                                $('#btn-approval-save-<?= $allowed_approve->id ?>').remove();
                                $('[data-m="status"]', $('#approval-<?= $allowed_approve->id ?>')).html(' <span class="badge badge-success">Approved</span>');
                                $('[data-m="note"]', $('#approval-<?= $allowed_approve->id ?>')).html($('#submit_note').val().replace(/(\r\n|\n\r|\r|\n)/g, "<br>"));
                                $('[data-m="approved_at"]', $('#approval-<?= $allowed_approve->id ?>')).html(Localization.humanDatetime(new Date()));
                                $('#btn-validate-update-approve').remove();
                                if ($('[data-button-type="approve"]').length == 0) {
                                    <?php if ($allowed_approve->id_user_role == $this->m_arf_approval->scm_performance_support_id) { ?>
                                        document.location.href = '<?=  base_url('procurement/arf/verification') ?>';
                                    <?php } else { ?>
                                        document.location.href = '<?=  base_url('procurement/arf/approval') ?>';
                                    <?php } ?>
                                }
                            } else {
                                $('.card-body').prepend('<div id="error-message" class="alert alert-danger">'+response.message+'</div>');
                            }
                            $('#validation-modal').modal('hide');
                        }
                    });
                });
            });

            $('[name="bod_review_meeting[<?= $allowed_approve->id ?>]"]').change(function() {
                if ($('[name="bod_review_meeting[<?= $allowed_approve->id ?>]"]:checked').val() == 1) {
                    $('#btn-validate-update-approve').hide();
                } else {
                    $('#btn-validate-update-approve').show();
                }
            });
        });
    </script>
<?php } ?>