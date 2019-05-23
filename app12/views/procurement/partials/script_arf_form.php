<script>
    var vat_percent = 10;
    var item_type_categories = <?= json_encode($item_type_categories) ?>;
    var po_item = [];
    var arf_item = [];
    var budget_item = {};
    var attachment_row = $('#attachment-table tbody tr').length;
    var exchange_rate_val = 0;
    <?php if(isset($arf_detail)): ?>
        arf_item = <?= json_encode($arf_detail) ?>;
    <?php endif; ?>
    $(function() {
          $('#add-item-description_of_unit').keyup(function(){
          // $('#msr_title').html($('#title').val());
          var s = $("#add-item-description_of_unit").val();
          var x = s.search('>')
          var y = s.search('<')
          var z = s.search('&')

          if(x == -1 && y == -1 && z == -1)
          {
            $('#msr_title').html(s)
            return true
          }
          else
          {
            var n = s.replace('<','')
            n = n.replace('>','')
            n = n.replace('&','')

            $("#add-item-description_of_unit").val(n)
          }
        })
        $("#wizard-arf").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '#title#',
            enableFinishButton: false,
            enablePagination: false,
            enableAllSteps: true,
            enableFinishButton: false,
            labels: {
                finish: 'Submit'
            },
            onStepChanging: function (event, currentIndex, newIndex) {
                if (newIndex != 0) {
                    if (!$('#po_id').val()) {
                        swal('<?= __('warning') ?>', 'You have to select po first', 'warning');
                        return false;
                    }
                    if (exchange_rate_val == 0) {
                        swal('<?= __('warning') ?>', 'Exchange rate from IDR to USD not maintained yet', 'warning');
                        return false;
                    }
                }
                return true;
            }
        });
        $('#po_total,#po_lastest_value,#po_spending_value,#po_latest_value,#po_spending_value,#po_remaining_value,#value_value,#estimated_new_value,#po_detail_total,#arf_detail_total,#po_arf_total,#add-item-est_unit_price,#add-item-est_total_price').number(true, 2);

        $('#time_value,#expected_commencement_date').datetimepicker({
            format : 'YYYY-MM-DD'
        });

        $('#add-item-semic_no').select2({
            dropdownParent: $('#add-item-modal'),
            placeholder: 'Please Select',
            minimumInputLength: 1,
            ajax: {
                url: "<?php echo base_url('procurement/procurement/po_item_json') ?>",
                dataType: 'json',
                cache: true,
                data: function(params) {
                    var query = {
                        q: params.term,
                        id_item_type: $('#add-item-id_item_type').val(),
                        id_item_type_category: $('#add-item-id_item_type_category').val()
                    }
                    return query
                },
                marker: function(marker) {
                    return marker;
                },
                processResults: function (data) {
                    var items = [];
                    if (data['data']) {
                        items = data['data'].map(function(row) {
                            return {
                                "id": row.code,
                                "text": row.code + ' - ' + row.name
                            }
                        });
                    }
                    return {
                        results: items
                    };
                }
            }
        });

        $('#value').click(function() {
            if ($('#value').prop('checked')) {
                $('#po-detail').show();
                count_total();
            } else {
                arf_item = [];
                $('#po-detail').hide();
            }
            active_amendment('value');
        });

        $('#time').click(function() {
            active_amendment('time');
        });
        $('#scope').click(function() {
            active_amendment('scope');
        });
        $('#other').click(function() {
            active_amendment('other');
        });

        $('#attachment-modal').on('hidden.bs.modal', function() {
            $('#attachment-modal-select_type').val('');
            $('#form-group-attachment_modal_type').hide();
            $('#attachment-modal-type').val('');
            $('#attachment-modal-file_name').val('');
            $('#attachment-modal-file').val('');
        });

        $('#btn-attachment').click(function() {
            $('#attachment-modal').modal('show');
        });

        $('#add-item-modal').on('hidden.bs.modal', function() {
            reset_add_item();
        });

        $('#btn-add-item').click(function() {
            $('#add-item-modal').modal('show');
        });

        $('#add-item-id_item_type').change(function() {
            get_item_type_categories();
            $('.add-item-label-semic_no').html('Semic No.');
            $('#add-item-semic_no').val('').change();
            $('#add-item-qty').val('');
            if (!$('#add-item-id_item_type').val()) {
                $('#add-item-uom').resetOptionLists();
                $('#add-item-uom').prop('disabled', true);
                $('#add-item-description_of_unit').val('').prop('disabled', true);
                $('#add-item-id_inventory_type').val('').change();
                $('#add-item-form-group-id_inventory_type').hide();
                $('#add_item-id_importation').val('');
                $('#add-item-form-group-id_importation').hide();
                $('#add_item-id_delivery_point').val('');
                $('#add-item-form-group-id_delivery_point').hide();
            } else if ($('#add-item-id_item_type').val() == 'SERVICE') {
                get_uom({
                   uom_type :  2
                });
                $('#add-item-description_of_unit').prop('disabled', false);
                $('#add-item-id_inventory_type').val('').change();
                $('#add-item-form-group-id_inventory_type').hide();
                $('#add-item-form-group-item_modification').show();
                $('#add-item-uom').prop('disabled', false);
                $('#add_item-id_importation').val('');
                $('#add-item-form-group-id_importation').hide();
                $('#add_item-id_delivery_point').val('');
                $('#add-item-form-group-id_delivery_point').hide();
            } else {
                $('#add-item-description_of_unit').val('').prop('disabled', true);
                $('#add-item-id_inventory_type').val('').change();
                $('#add-item-form-group-id_inventory_type').show();
                $('#add-item-form-group-item_modification').hide();
                $('#add-item-uom').resetOptionLists();
                $('#add-item-uom').prop('disabled', true);
                $('#add-item-form-group-id_importation').show();
                $('#add-item-form-group-id_delivery_point').show();
            }
        });

        $('#add-item-id_item_type_category').change(function() {
            $('#add-item-semic_no').val('').change();
            if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
                $('.add-item-label-semic_no').html('Semic No.');
                $('#add-item-description_of_unit').prop('disabled', true);
                $('#add-item-uom').resetOptionLists();
                $('#add-item-uom').prop('disabled', true);
            } else {
                if ($('#add-item-id_item_type_category').val()) {
                    $('.add-item-label-semic_no').html($('#add-item-id_item_type_category option:selected').text()+' Category');
                } else {
                    $('.add-item-label-semic_no').html('Semic No.');
                }
                if ($('#add-item-id_item_type').val() == 'SERVICE') {
                    $('#add-item-description_of_unit').prop('disabled', false);
                    $('#add-item-uom').prop('disabled', false);
                } else {
                    if ($('#add-item-id_item_type_category').val() == 'MATGROUP') {
                        get_uom({
                           uom_type :  1
                        });
                        $('#add-item-description_of_unit').prop('disabled', false);
                        $('#add-item-uom').prop('disabled', false);
                    } else {
                        $('#add-item-description_of_unit').val('').prop('disabled', true);
                        $('#add-item-uom').resetOptionLists();
                        $('#add-item-uom').prop('disabled', true);
                    }
                }
            }
        });

        $('#add-item-semic_no').change(function() {
            if ($('#add-item-semic_no').val()) {
                $.ajax({
                    url : '<?= base_url('procurement/procurement/po_item_json') ?>/'+$('#add-item-semic_no').val(),
                    data : {
                        id_item_type_category: $('#add-item-id_item_type_category').val(),
                        id_po : $('#id_po').val()
                    },
                    dataType : 'json',
                    success : function(response) {
                        if (response['data']) {
                            var data = response['data'];
                            $('#add-item-classification').val(data.GROUP_CLASSIFICATION + '. ' + data.CLASSIFICATION);
                            $('#add-item-category').val(data.GROUP_CATEGORY + '. '+data.CATEGORY);
                            if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
                                $('#add-item-description_of_unit').val(data.MATERIAL_NAME);
                                get_uom({
                                    semic_no : $('#add-item-semic_no').val()
                                }, data.UNIT_OF_ISSUE);
                            }
                        } else {
                            $('#add-item-classification').val('');
                            $('#add-item-category').val('');
                            if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
                                $('#add-item-uom').resetOptionLists();
                            }
                        }
                    }
                });
            } else {
                $('#add-item-classification').val('');
                $('#add-item-category').val('');
                if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
                    $('#add-item-uom').resetOptionLists();
                }
            }
        });

        $('#add-item-id_inventory_type').change(function() {
            $('#add-item-form-group-id_account_subsidiary').val('');
            if (!$('#add-item-id_item_type').val()) {
                $('#add-item-id_account_subsidiary').val('');
                $('#add-item-form-group-id_account_subsidiary').hide();
            } else if ($('#add-item-id_item_type').val() == 'GOODS') {
                if ($('#add-item-id_inventory_type').val() == 2 || $('#add-item-id_inventory_type').val() == 3) {
                    $('#add-item-form-group-id_account_subsidiary').show();
                } else {
                    $('#add-item-id_account_subsidiary').val('');
                    $('#add-item-form-group-id_account_subsidiary').hide();
                }
            } else {
                $('#add-item-form-group-id_account_subsidiary').show();
            }
        });

        $('#add-item-id_costcenter').change(function() {
            get_account_subsidiary({
                id_costcenter : $('#add-item-id_costcenter').val()
            });
        });

        $('#add-item-btn-add-item').click(function() {
            add_arf_item();
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
    });

    function active_amendment(type) {
        if ($('#'+type).prop('checked')) {
            $('#'+type+'_value').prop('disabled', false);
            $('#'+type+'_remark').prop('disabled', false);
            if (type == 'value') {
                $('#po-detail').show();
                count_total();
            }
        } else {
            $('#'+type+'_value').val('').prop('disabled', true);
            $('#'+type+'_remark').val('').prop('disabled', true);
            if (type == 'value') {
                arf_item = [];
                $('#po-detail').hide();
            }
        }
    }

    function check_reason(id) {
        if ($('[name="reason['+id+'][id]"]').prop('checked')) {
            $('[name="reason['+id+'][reason]"]').show();
        } else {
            $('[name="reason['+id+'][reason]"]').val('').hide();
        }
    }

    function browse(title, url) {
        $.ajax({
            url : url,
            success : function(response) {
                $('#browse-modal-title').html(title);
                $('#browse-modal-body').html(response);
                $('#browse-modal').modal('show');
            }
        });
    }

    function browse_po_selected(data) {
        po_item = [];
        arf_item = [];
        $('#po_item-table tbody').html('');
        $('#arf_item-table tbody').html('');
        $('#budget_item-table tbody').html('');
        $.ajax({
            url : '<?= base_url('procurement/arf/po') ?>/'+data.id,
            dataType : 'json',
            success : function(response) {
                if (response.data) {
                    $('#no_reference').val(response.data.po_no);
                    $('#po_id').val(response.data.id);
                    $('#po-title').html(response.data.title);
                    $('#id_currency').val(response.data.id_currency);
                    $('#currency').val(response.data.currency);
                    $('#id_currency_base').val(response.data.id_currency_base);
                    $('#currency_base').val(response.data.currency_base);
                    $('#po_title').val(response.data.title);
                    $('#po-requestor').html(response.data.requestor);
                    $('#po-department').html(response.data.department);
                    $('#po_id_vendor').val(response.data.id_vendor);
                    $('#po_vendor').val(response.data.vendor);
                    $('#po_id_company').val(response.data.id_company);
                    $('#po_company').val(response.data.company);
                    $('#po_date').val(response.data.po_date);
                    $('#po_total').val(response.data.total_amount);
                    // $('#po_latest_value').val(response.data.latest_value);
                    // $('#po_latest_value_ori').val(response.data.latest_value);
                    // $('#po_spending_value').val(response.data.spending_value);
                    $('#po_remaining_value').val(response.data.remaining_value);
                    $('#po_delivery_date').val(response.data.delivery_date);
                    $('#po_amended_date').val(response.data.prev_date);
                    $('.label-po_type').html(response.data.po_type);
                    if (response.data.po_type == 'PO') {
                        $('.label-po_vendor_type').html('Vendor');
                        $('.label-po_delivery_date').html('PO Delivery Date (take the longest if partial)');
                    } else {
                        $('.label-po_vendor_type').html('Contractor');
                        $('.label-po_delivery_date').html('SO/Contract (CO) Period');
                    }
                    $('[data-m="currency"]').html(response.data.currency);
                    $('[data-m="currency_base"]').html(response.data.currency_base);
                    if (response.data.currency == response.data.currency_base) {
                        $('#excl_total_equal_to').hide();
                        $('#vat_equal_to').hide();
                        $('#incl_total_equal_to').hide();
                    } else {
                        $('#excl_total_equal_to').show();
                        $('#vat_equal_to').show();
                        $('#incl_total_equal_to').show();
                    }
                    $('#add-item-est_unit_price_id_currency').val(response.data.id_currency);
                    $('#add-item-est_unit_price_currency').val(response.data.currency);
                    $('#add-item-est_total_price_id_currency').val(response.data.id_currency);
                    $('#add-item-est_total_price_currency').val(response.data.currency);
                    var html_po_item_table = '';
                    po_item = response.data.item;
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
                        id_company : response.data.id_company
                    });
                    count_total();
                    budget_table();
                    get_amd(response.data.po_no,response.data.total_amount);
                    // get_spending_value(response.data.po_no);
                } else {
                    swal('<?= __('warning') ?>', 'Can\'nt find agreement no.', 'warning');
                }
            }
        })
    }

    function get_item_type_categories() {
        var item_type = $('#add-item-id_item_type').val();
        var html_option = '<option value="">Please Select</option>';
        if (item_type_categories[item_type]) {
            $.each(item_type_categories[item_type], function(i, row) {
                html_option +='<option value="'+row.id+'">'+row.description+'</option>';
            });
        }
        $('#add-item-id_item_type_category').html(html_option);
    }

    function get_uom(params, selected) {
        $.ajax({
            url : '<?= base_url('procurement/procurement/uom_json') ?>',
            data : params,
            dataType : 'json',
            success : function(response) {
                var html_option = '<option value="">Please Select</option>';
                if (response.data) {
                    $.each(response.data, function(i, row) {
                        html_option +='<option value="'+row.MATERIAL_UOM+'">'+row.MATERIAL_UOM+' - '+row.DESCRIPTION+'</option>';
                    });
                }
                $('#add-item-uom').html(html_option);
                if (selected) {
                    $('#add-item-uom').val(selected);
                } else {
                    if ($('#add-item-uom').data('selected')) {
                        $('#add-item-uom').val($('#add-item-uom').data('selected'));
                    }
                }
            }
        });
    }

    function get_account_subsidiary(params, selected) {
        $.ajax({
            url : '<?= base_url('procurement/procurement/account_subsidiary_json') ?>',
            data : params,
            dataType : 'json',
            success : function(response) {
                var html_option = '<option value="">Please Select</option>';
                if (response.data) {
                    $.each(response.data, function(i, row) {
                        html_option +='<option value="'+row.ID_ACCSUB+'">'+row.ID_ACCSUB+' - '+row.ACCSUB_DESC+'</option>';
                    });
                }
                $('#add-item-id_account_subsidiary').html(html_option);
                $('#add-item-id_account_subsidiary').val(selected);
            }
        });
    }

    function get_costcenter(params, selected) {
        $.ajax({
            url : '<?= base_url('procurement/procurement/costcenter_json') ?>',
            data : params,
            dataType : 'json',
            success : function(response) {
                var html_option = '<option value="">Please Select</option>';
                if (response.data) {
                    $.each(response.data, function(i, row) {
                        html_option +='<option value="'+row.ID_COSTCENTER+'">'+row.ID_COSTCENTER+' - '+row.COSTCENTER_DESC+'</option>';
                    });
                }
                $('#add-item-id_costcenter').html(html_option);
                $('#add-item-id_costcenter').val(selected);
            }
        });
    }

    function reset_add_item() {
        $('#add-item-modal #error_message').remove();
        $('#add-item-id_item_type').val('');
        $('#add-item-id_item_type_category').resetOptionLists();
        $('#add-item-semic_no').val('').change();
        $('#add-item-description_of_unit').val('');
        $('#add-item-classification').val('');
        $('#add-item-category').val('');
        $('#add-item-id_inventory_type').val('');
        $('#add-item-form-group-id_inventory_type').hide();
        $('#add-item-form-group-item_modification').hide();
        $('#add-item-item_modification').prop('checked', false);
        $('#add-item-uom').resetOptionLists();
        $('#add-item-uom').prop('disabled', true);
        $('#add-item-qty').val('');
        $('#add-item-est_unit_price').val('');
        $('#add-item-est_total_price').val('');
        $('#add-item-id_costcenter').val('');
        $('#add-item-id_account_subsidiary').resetOptionLists();
        $('#add-item-form-group-id_account_subsidiary').hide();
        $('#add-item-id_importation').val('');
        $('#add-item-form-group-id_importation').hide();
        $('#add-item-id_delivery_point').val('');
        $('#add-item-form-group-id_delivery_point').hide();
    }

    /*function budget_table() {
        var budget_item = {};
        $.each(po_item, function(i, row) {
            budget_item[row.semic_no] = {
                semic_no : row.semic_no,
                material_desc : row.material_desc,
                qty : row.qty,
                uom : row.uom,
                unit_price : row.unit_price,
                total_price : row.total_price,
                budget_total : row.total_price,
                arf_qty : null,
                arf_uom : null,
                arf_unit_price : null,
                arf_total_price : null,
            };
        });
        $.each (arf_item, function(i, row) {
            if (budget_item[row.semic_no]) {
                budget_item[row.semic_no].arf_qty = row.qty,
                budget_item[row.semic_no].arf_uom = row.uom,
                budget_item[row.semic_no].arf_unit_price = row.unit_price,
                budget_item[row.semic_no].arf_total_price = row.total_price
                budget_item[row.semic_no].budget_total =  budget_item[row.semic_no].budget_total+row.total_price
            } else {
                budget_item[row.semic_no] = {
                    semic_no : row.semic_no,
                    material_desc : row.material_desc,
                    qty : null,
                    uom : null,
                    unit_price : null,
                    total_price : null,
                    arf_qty : row.qty,
                    arf_uom : row.uom,
                    arf_unit_price : row.unit_price,
                    arf_total_price : row.total_price,
                    budget_total : row.total_price
                }
            }
        });
        var html_budget_item_table = '';
        $.each(budget_item, function(i, row) {
            html_budget_item_table += '<tr>';
                html_budget_item_table += '<td>'+row.material_desc+'</td>';
                html_budget_item_table += '<td class="text-center">'+coalesce(row.qty, '0')+'</td>';
                html_budget_item_table += '<td class="text-center">'+coalesce(row.uom, '-')+'</td>';
                html_budget_item_table += '<td class="text-center">'+Localization.number(row.unit_price, '0')+'</td>';
                html_budget_item_table += '<td class="text-center">'+Localization.number(row.total_price, '0')+'</td>';
                html_budget_item_table += '<td class="text-center">'+coalesce(row.arf_qty, '0')+'</td>';
                html_budget_item_table += '<td class="text-center">'+coalesce(row.arf_uom, '-')+'</td>';
                html_budget_item_table += '<td class="text-center">'+Localization.number(row.arf_unit_price, '0')+'</td>';
                html_budget_item_table += '<td class="text-center">'+Localization.number(row.arf_total_price, '0')+'</td>';
                html_budget_item_table += '<td class="text-right">'+Localization.number(row.budget_total, '0')+'</td>';
            html_budget_item_table += '<tr>';
        });
        $('#budget_item-table tbody').html(html_budget_item_table);
    }*/

    function budget_table() {
        budget_item = {};
        $.each (arf_item, function(i, row) {
            if (!budget_item[row.id_costcenter]) {
                budget_item[row.id_costcenter] = {};
            }
            if (row.id_account_subsidiary) {
                id_account_subsidiary = row.id_account_subsidiary;
            } else {
                id_account_subsidiary = 0;
            }
            if (!budget_item[row.id_costcenter][id_account_subsidiary]) {
                budget_item[row.id_costcenter][id_account_subsidiary] = {
                    id_costcenter : row.id_costcenter,
                    costcenter : row.costcenter,
                    id_account_subsidiary : row.id_account_subsidiary,
                    account_subsidiary : row.account_subsidiary,
                    booking_amount : toFloat(row.total_price)
                }
            } else {
                budget_item[row.id_costcenter][id_account_subsidiary]['booking_amount'] += toFloat(row.total_price);
            }
        });

        $.ajax({
            url : '<?= base_url('procurement/arf/calculate_budget') ?>',
            type : 'post',
            dataType : 'json',
            data : {
                id_currency : $('#id_currency').val(),
                budget_item : budget_item
            },
            success : function(response) {
                budget_item = response.data.budget_item;
                var html_budget_item_table='';
                $.each(budget_item, function(i, costcenter) {
                    $.each(costcenter, function(j, row) {
                        if (row.amount) {
                            var budget_amount = row.amount;
                        } else {
                            var budget_amount = row.costcenter_amount;
                        }
                        /*if (row.booking_amount > budget_amount) {
                            var status = '<label class="badge badge-danger">Insufficient</label>';
                        } else {
                            var status = '<label class="badge badge-success">Sufficient</label>';
                        }*/
                        html_budget_item_table += '<tr>';
                            html_budget_item_table += '<td>'+row.costcenter+'</td>';
                            html_budget_item_table += '<td>'+row.account_subsidiary+'</td>';
                            html_budget_item_table += '<td class="text-center">'+row.currency+'</td>';
                            html_budget_item_table += '<td class="text-center">'+Localization.number(row.booking_amount, '0')+'</td>';
                            html_budget_item_table += '<td class="text-center">'+Localization.number(row.costcenter_amount, '0')+'</td>';
                            html_budget_item_table += '<td class="text-center">'+Localization.number(row.amount, '0')+'</td>';
                            html_budget_item_table += '<td class="text-center"></td>';
                        html_budget_item_table += '<tr>';
                    });
                    $('#budget_item-table tbody').html(html_budget_item_table);
                });
                exchange_rate_val = response.data.exchange_rate;
                var exchange_rate = accounting.formatMoney(1, { format: '%s %v', symbol:  response.data.currency}) + ' = ' + accounting.formatMoney(response.data.exchange_rate, { format: '%s %v', symbol: $('#currency').val() });
                $('#exchange-rate').html(exchange_rate);
                count_total();
            }
        });
    }

    $.fn.resetOptionLists = function(params) {
        var placeholder = 'Please Select';
        var placeholder_value = '';
        if (params) {
            if (params.placeholder) {
                placeholder = params.placeholder;
            }
            if (params.placeholder_value) {
                placeholder_value = params.placeholder_value;
            }
        }
        var html_select_option = '<option value="'+placeholder_value+'">'+placeholder+'</option>';
        $(this).html(html_select_option);
    }

    function add_item_count_total() {
        var qty = toFloat($('#add-item-qty').val());
        var price = toFloat($('#add-item-est_unit_price').val());
        var total = qty * price;
        $('#add-item-est_total_price').val(total);
    }

    function copy_po_item_to_arf_item(id) {
        $('#add-item-modal').modal('show');
        $('#add-item-id_item_type').val(po_item[id].id_item_type);
        get_item_type_categories();
        if ($('#add-item-id_item_type').val() == 'SERVICE') {
            get_uom({
               uom_type :  2
            }, po_item[id].uom);
            $('#add-item-form-group-id_inventory_type').hide();
            $('#add-item-form-group-item_modification').show();
            $('#add-item-uom').prop('disabled', false);
            $('#add-item-form-group-id_importation').hide();
            $('#add-item-form-group-id_delivery_point').hide();
        } else {
            $('#add-item-id_inventory_type').val('').change();
            $('#add-item-form-group-id_inventory_type').show();
            $('#add-item-form-group-item_modification').hide();
            $('#add-item-uom').resetOptionLists();
            $('#add-item-uom').prop('disabled', true);
            $('#add-item-form-group-id_importation').show();
            $('#add-item-form-group-id_delivery_point').show();
        }
        $('#add-item-id_item_type_category').val(po_item[id].id_item_type_category);
        if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
            $('.add-item-label-semic_no').html('Semic No.');
            $('#add-item-description_of_unit').prop('disabled', true);
            $('#add-item-uom').prop('disabled', true);
        } else {
            if ($('#add-item-id_item_type_category').val()) {
                $('.add-item-label-semic_no').html($('#add-item-id_item_type_category option:selected').text()+' Category');
            } else {
                $('.add-item-label-semic_no').html('Semic No.');
            }
            $('#add-item-description_of_unit').prop('disabled', false);
            if ($('#add-item-id_item_type_category').val() == 'MATGROUP') {
                get_uom({
                   uom_type :  1
                }, po_item[id].uom);
            }
        }
        if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
            var semic = po_item[id].semic_no+' - '+po_item[id].material_desc;
        } else {
            var semic = po_item[id].semic_no+' - '+po_item[id].category;
        }
        $('#add-item-semic_no').html('').select2({
            data : [
                {
                    id : po_item[id].semic_no,
                    text : semic
                }
            ],
            dropdownParent: $('#add-item-modal'),
            placeholder: 'Please Select',
            minimumInputLength: 1,
            ajax: {
                url: "<?php echo base_url('procurement/procurement/po_item_json') ?>",
                dataType: 'json',
                cache: true,
                data: function(params) {
                    var query = {
                        q: params.term,
                        id_item_type: $('#add-item-id_item_type').val(),
                        id_item_type_category: $('#add-item-id_item_type_category').val()
                    }
                    return query
                },
                marker: function(marker) {
                    return marker;
                },
                processResults: function (data) {
                    var items = [];
                    if (data['data']) {
                        items = data['data'].map(function(row) {
                            return {
                                "id": row.code,
                                "text": row.code + ' - ' + row.name
                            }
                        });
                    }
                    return {
                        results: items
                    };
                }
            }
        }).val(po_item[id].semic_no)
        .change();
        $('#add-item-description_of_unit').val(po_item[id].material_desc);
        $('#add-item-id_inventory_type').val(po_item[id].id_inventory_type).change();
        if (po_item[id].item_modification == 1) {
            $('#add-item-item_modification').prop('checked', true);
        } else {
            $('#add-item-item_modification').prop('checked', false);
        }
        $('#add-item-qty').val(po_item[id].qty);
        $('#add-item-uom').val(po_item[id].uom);
        $('#add-item-est_unit_price').val(po_item[id].unit_price);
        $('#add-item-est_total_price').val(po_item[id].total_price);
        $('#add-item-id_costcenter').val(po_item[id].id_costcenter);
        get_account_subsidiary({
            id_costcenter : $('#add-item-id_costcenter').val()
        }, po_item[id].id_account_subsidiary);
        $('#add-item-id_importation').val(po_item[id].id_importation);
        $('#add-item-id_delivery_point').val(po_item[id].id_delivery_point);
    }

    function add_arf_item() {
        $('#add-item-modal #error_message').remove();
        var errors = [];
        var id_item_type = $('#add-item-id_item_type').val();
        var item_type = $('#add-item-id_item_type option:selected').text();
        var id_item_type_category = $('#add-item-id_item_type_category').val();
        var item_type_category = $('#add-item-id_item_type_category option:selected').text();
        var semic_no = $('#add-item-semic_no').val();
        var description_of_unit = $('#add-item-description_of_unit').val();
        var category = $('#add-item-category').val();
        var classification = $('#add-item-classification').val();
        var id_inventory_type = $('#add-item-id_inventory_type').val();
        var inventory_type = $('#add-item-id_inventory_type option:selected').text();
        if($('#add-item-item_modification').is(":checked"))
        {
            item_modification = parseInt(1);
        }
        else
        {
            item_modification = parseInt(0);
        }
        var qty = $('#add-item-qty').val();
        var uom = $('#add-item-uom').val();
        var uom_desc = $('#add-item-uom option:selected').text().split(" - ")[1];
        var est_unit_price = $('#add-item-est_unit_price').val();
        var est_total_price = $('#add-item-est_total_price').val();
        var id_costcenter = $('#add-item-id_costcenter').val();

        $.each(arf_item, function(i, row) {
            if (row.semic_no == semic_no && row.material_desc.toLowerCase() == description_of_unit.toLowerCase()) {
                errors.push('Item already exist');
            }
        });

        if (id_costcenter) {
            var costcenter = $('#add-item-id_costcenter option:selected').text().split(" - ")[1];
        } else {
            var costcenter = '';
        }
        var id_account_subsidiary = $('#add-item-id_account_subsidiary').val();
        if (id_account_subsidiary) {
            var account_subsidiary = $('#add-item-id_account_subsidiary option:selected').text().split(" - ")[1];
        } else {
            var account_subsidiary = '';
        }
        var id_importation = $('#add-item-id_importation').val();
        var id_delivery_point = $('#add-item-id_delivery_point').val();

        if (!id_item_type) {
            errors.push('Item type is required');1
        }
        if (!id_item_type_category) {
            errors.push('Category is required');
        }
        if (!semic_no) {
            errors.push('Semic is required');
        }
        if (!description_of_unit) {
            errors.push('Description of Unit is required');
        }
        if (id_item_type == 'GOODS') {
            if (!id_inventory_type) {
                errors.push('Inventory type is required')
            }
            if (!id_importation) {
                errors.push('Importation Subsidiary is required');
            }
            if (!id_delivery_point) {
                errors.push('Delivery Point is required');
            }
            if (id_inventory_type != '1') {
                if (!id_account_subsidiary) {
                    errors.push('Account Subsidiary is required');
                }
            }
        }
        if (!qty) {
            errors.push('Qty is required');
        }
        if (!uom) {
            errors.push('UoM is required');
        }
        if (!est_unit_price) {
            errors.push('Est.Unit Price is required');
        }

        if (!id_costcenter) {
            errors.push('Costcenter is required');
        }

        if (arf_item[semic_no]) {
            errors.push('This semic already exist');
        }

        if (errors.length != 0) {
            var error_message = '';
            $.each(errors, function(i, e) {
                error_message +=e+'<br>';
            });
            $('#add-item-modal .modal-body').prepend('<div id="error_message" class="alert alert-danger">'+error_message+'</div>');
            return false;
        }
        arf_item.push({
            id_item_type : id_item_type,
            item_type : item_type,
            id_item_type_category : id_item_type_category,
            item_type_category : item_type_category,
            semic_no : semic_no,
            material_desc : description_of_unit,
            material_category : category,
            material_classification : classification,
            id_inventory_type : id_inventory_type,
            inventory_type : inventory_type,
            item_modification : item_modification,
            qty : qty,
            uom : uom,
            uom_desc : uom_desc,
            unit_price : est_unit_price,
            total_price : est_total_price,
            id_costcenter : id_costcenter,
            costcenter : costcenter,
            id_account_subsidiary : id_account_subsidiary,
            account_subsidiary : account_subsidiary,
            id_importation : id_importation,
            id_delivery_point : id_delivery_point
        });

        $('#add-item-modal').modal('hide');
        arf_table();
        budget_table();
        count_total();
    }

    function remove_arf_item(i) {
        /*swalConfirm('ARF', 'Are you sure to proceed ?', function() {
            delete arf_item[semic_no];
            arf_table();
            budget_table();
            count_total();
        });*/
        swalConfirm('ARF Preparation', '<?= __('confirm_delete') ?>', function() {
            arf_item.splice(i, 1);
            arf_table();
            budget_table();
            count_total();
        });
    }

    function arf_table() {
        var html_arf_item_table = '';
        $.each(arf_item, function(i, row) {
            html_arf_item_table += '<tr data-id="'+i+'" data-semic_no="'+row.semic_no+'">';
                html_arf_item_table += '<td>'+row.item_type+'</td>';
                html_arf_item_table += '<td>'+row.material_desc+'</td>';
                html_arf_item_table += '<td class="text-center">'+row.qty+'</td>';
                html_arf_item_table += '<td class="text-center">'+row.uom+' - '+row.uom_desc+'</td>';
                var item_modification_str = 'Yes';
                if(row.item_modification == 0)
                {
                    item_modification_str = 'No';
                }
                html_arf_item_table += '<td class="text-center">'+item_modification_str+'</td>';
                html_arf_item_table += '<td>'+coalesce(row.inventory_type, '-')+'</td>';
                html_arf_item_table += '<td>'+coalesce(row.costcenter, '-')+'</td>';
                html_arf_item_table += '<td>'+row.id_account_subsidiary+' - '+row.account_subsidiary+'</td>';
                html_arf_item_table += '<td class="text-right">'+Localization.number(row.unit_price)+'</td>';
                html_arf_item_table += '<td class="text-right">'+Localization.number((row.qty * row.unit_price))+'</td>';
                html_arf_item_table += '<td class="text-right"><button type="button" class="btn btn-danger btn-sm" onclick="remove_arf_item('+i+')">Delete</button></td>';
            html_arf_item_table += '</tr>';
        });
        $('#arf_item-table tbody').html(html_arf_item_table);
    }
    function count_total() {
        if ($('#value').prop('checked')) {
            var po_total = 0;
            var value = toFloat($('#value_value').val());
            var arf_total = toFloat($('#arf_detail_total').val());
            var total = 0;

            value -= arf_total;
            arf_total = 0;

            $.each(po_item, function(i, item) {
                po_total += toFloat(item.total_price);
            });
            $('#po_detail_total').val(po_total);

            $.each(arf_item, function(i, item) {
                arf_total += toFloat(item.qty * item.unit_price);
            });
            $('#arf_detail_total').val(arf_total);

            value += arf_total;
            $('#value_value').val(value);

            $('#arf_excl_vat').html(Localization.number(arf_total));
            $('#excl_total_equal_to_val').html(Localization.number((arf_total/exchange_rate_val)));
            var vat = vat_percent/100 * arf_total;
            $('#vat').html(Localization.number(vat));
            $('#vat_equal_to_val').html(Localization.number((vat/exchange_rate_val)));
            var arf_incl_vat = arf_total+vat;
            $('#arf_incl_vat').html(Localization.number(arf_incl_vat));
            $('#incl_total_equal_to_val').html(Localization.number((arf_incl_vat/exchange_rate_val)));
            total = po_total + arf_total;
            var amd_total = $("#amd_total").val();
            if(toFloat(amd_total) > 0)
            {
                total = arf_total + toFloat(amd_total);
                // alert(total);
            }
            $('#po_arf_total').val(total);
        }
        count_estimated_new_value();

    }

    function count_estimated_new_value() {
        var estimated_new_value = toFloat($('#po_total').val());
        var amd_total = $("#amd_total").val();
        if(toFloat(amd_total) > 0)
        {
            var estimated_new_value = toFloat(amd_total);
        }
        var value = toFloat($('#value_value').val());
        estimated_new_value += value;
        $('#estimated_new_value').val(estimated_new_value);
    }

    function attachment_upload() {
        $('#attachment-modal #error_message').remove();
        var formData = new FormData;
        formData.append('type', $('#attachment-modal-type').val());
        formData.append('file_name', $('#attachment-modal-file_name').val());
        formData.append('file', $('#attachment-modal-file')[0].files[0]);
        $.ajax({
            type:'POST',
            enctype:'multipart/form-data',
            data: formData,
            processData: false,
            contentType: false,
            dataType:'json',
            url : '<?= base_url('procurement/arf/attachment_upload') ?>',
            success : function(response) {
                if (response.success) {
                    add_attachment($('#attachment-modal-type').val(), $('#attachment-modal-file_name').val(), response.data.file_name, Localization.humanDatetime(new Date()), '<?= $_SESSION['NAME'] ?>')
                    $('#attachment-modal').modal('hide');
                } else {
                    $('#attachment-modal .modal-body').prepend('<div id="error_message" class="alert alert-danger">'+response.message+'</div>');
                }
            }
        });
    }

    function add_attachment(type, file_name, file, upload_at, upload_by) {
        var html_attachment_table = '<tr data-row-id="'+attachment_row+'">';
            html_attachment_table += '<td>';
                html_attachment_table += '<input type="hidden" name="attachment['+attachment_row+'][type]" value="'+type+'">'+type;
            html_attachment_table += '</td>';
            html_attachment_table += '<td>';
                html_attachment_table += '<input type="hidden" name="attachment['+attachment_row+'][file_name]" value="'+file_name+'"><input type="hidden" name="attachment['+attachment_row+'][file]" value="'+file+'"><a href="<?= base_url($document_path) ?>/'+file+'" target="_blank">'+file_name+'</a>';
            html_attachment_table += '</td>';
            html_attachment_table += '<td>'+upload_at+'</td>';
            html_attachment_table += '<td>'+upload_by+'</td>';
            html_attachment_table += '<td class="text-center"><button type="button" class="btn btn-danger btn-sm" onclick="remove_attachment(\''+attachment_row+'\')">Delete</button></td>';
        html_attachment_table += '</tr>';
        $('#attachment-table tbody').append(html_attachment_table);
        attachment_row++;
    }

    function remove_attachment(id) {
        swalConfirm('ARF Preparation', '<?= __('confirm_delete') ?>', function() {
            $('#attachment-table tbody [data-row-id="'+id+'"]').remove();
        });
    }
</script>

<script>
    $(function() {
        $('#validation-modal').on('hidden.bs.modal', function() {
            //$('#btn-save-draft').hide();
            $('#btn-submit').hide();
            $('#btn-resubmit').hide();
            $('[data-validation]').html('');
        });
    });

    function validate() {
        var errors = 0;
        var revision = 0;
        if ($('#po_id').val()) {
            $('[data-validation="po_id"]').html('<i class="fa fa-check text-success"></i>');
            $('[data-validation="header"]').html('<i class="fa fa-check text-success"></i>');
        } else {
            $('[data-validation="po_id"]').html('<i class="fa fa-times text-danger"></i>');
            $('[data-validation="header"]').html('<i class="fa fa-times text-danger"></i>');
            errors++;
        }

        if ((!$('#value').prop('checked') && !$('#time').prop('checked') && !$('#scope').prop('checked') && !$('#other').prop('checked')) || $('[name*="reason"]:checked').length == 0 || !$('#expected_commencement_date').val()) {
            $('[data-validation="detail"]').html('<i class="fa fa-times text-danger"></i>');
            errors++;
        } else {
            $('[data-validation="detail"]').html('<i class="fa fa-check text-success"></i>');
            revision = 1;
        }

        if ($('#value').prop('checked')) {
            $('[data-validation="value"]').html('<i class="fa fa-check text-success"></i>');
            if ($('#value_value').val() > 0) {
                $('[data-validation="value_value"]').html('<i class="fa fa-check text-success"></i>');
            } else {
                $('[data-validation="value_value"]').html('<i class="fa fa-times text-danger"></i>');
                $('[data-validation="detail"]').html('<i class="fa fa-times text-danger"></i>');
                errors++;
            }
        } else {
            if (revision == 1) {
                $('[data-validation="value"]').html('<i class="fa fa-check text-success"></i>');
            } else {
                $('[data-validation="value"]').html('<i class="fa fa-times text-danger"></i>');
            }
            $('[data-validation="value_value"]').html('<i class="fa fa-check text-success"></i>');
        }

        if ($('#time').prop('checked')) {
            $('[data-validation="time"]').html('<i class="fa fa-check text-success"></i>');
            if ($('#time_value').val()) {
                $('[data-validation="time_value"]').html('<i class="fa fa-check text-success"></i>');
            } else {
                $('[data-validation="time_value"]').html('<i class="fa fa-times text-danger"></i>');
                $('[data-validation="detail"]').html('<i class="fa fa-times text-danger"></i>');
                errors++;
            }
        } else {
            if (revision == 1) {
                $('[data-validation="time"]').html('<i class="fa fa-check text-success"></i>');
            } else {
                $('[data-validation="time"]').html('<i class="fa fa-times text-danger"></i>');
            }
            $('[data-validation="time_value"]').html('<span class="fa fa-check text-success"></span>');
        }

        if ($('#scope').prop('checked')) {
            $('[data-validation="scope"]').html('<span class="fa fa-check text-success"></span>');
            if ($('#scope_value').val()) {
                $('[data-validation="scope_value"]').html('<span class="fa fa-check text-success"></span>');
            } else {
                $('[data-validation="scope_value"]').html('<span class="fa fa-times text-danger"></span>');
                $('[data-validation="detail"]').html('<span class="fa fa-times text-danger"></span>');
                errors++;
            }
        } else {
            if (revision == 1) {
                $('[data-validation="scope"]').html('<i class="fa fa-check text-success"></i>');
            } else {
                $('[data-validation="scope"]').html('<i class="fa fa-times text-danger"></i>');
            }
            $('[data-validation="scope_value"]').html('<span class="fa fa-check text-success"></span>');
        }

        if ($('#other').prop('checked')) {
            $('[data-validation="other"]').html('<span class="fa fa-check text-success"></span>');
            if ($('#other_value').val()) {
                $('[data-validation="other_value"]').html('<span class="fa fa-check text-success"></span>');
            } else {
                $('[data-validation="other_value"]').html('<span class="fa fa-times text-danger"></span>');
                $('[data-validation="detail"]').html('<span class="fa fa-times text-danger"></span>');
                errors++;
            }
        } else {
            if (revision == 1) {
                $('[data-validation="other"]').html('<i class="fa fa-check text-success"></i>');
            } else {
                $('[data-validation="other"]').html('<i class="fa fa-times text-danger"></i>');
            }
            $('[data-validation="other_value"]').html('<span class="fa fa-check text-success"></span>');
        }

        if ($('[name*="reason"]:checked').length != 0) {
            $('[data-validation="reason"]').html('<span class="fa fa-check text-success"></span>');
        } else {
            $('[data-validation="reason"]').html('<span class="fa fa-times text-danger"></span>');
            errors++;
        }

        if ($('#expected_commencement_date').val()) {
            $('[data-validation="expected_commencement_date"]').html('<span class="fa fa-check text-success"></span>');
        } else {
            $('[data-validation="expected_commencement_date"]').html('<span class="fa fa-times text-danger"></span>');
            errors++;
        }

        $('[data-validation="budget"]').html('<span class="fa fa-check text-success"></span>');
        $('[data-validation="attachment"]').html('<span class="fa fa-check text-success"></span>');
        if ($('#value').prop('checked')) {
            var exist_attachment_value = 0;
            $.each($('#attachment-table tbody [data-row-id]'), function(i, elem) {
                var attachment_row = $(elem).data('row-id');
                if ($('[name="attachment['+attachment_row+'][type]"').val() == 'Owner Estimate') {
                    exist_attachment_value++;
                }
            });
            if (exist_attachment_value > 0) {
                $('[data-validation="attachment_value"]').html('<span class="fa fa-check text-success"></span>');
            } else {
                $('[data-validation="attachment_value"]').html('<span class="fa fa-times text-danger"></span>');
                $('[data-validation="attachment"]').html('<span class="fa fa-times text-danger"></span>');
                errors++;
            }
        } else {
            $('[data-validation="attachment_value"]').html('<span class="fa fa-check text-success"></span>');
        }

        if ($('#scope').prop('checked')) {
            var exist_attachment_scope = 0;
            $.each($('#attachment-table tbody [data-row-id]'), function(i, elem) {
                var attachment_row = $(elem).data('row-id');
                if ($('[name="attachment['+attachment_row+'][type]"').val() == 'Scope of Work/Supply') {
                    exist_attachment_scope++;
                }
            });
            if (exist_attachment_scope > 0) {
                $('[data-validation="attachment_scope"]').html('<span class="fa fa-check text-success"></span>');
            } else {
                $('[data-validation="attachment_scope"]').html('<span class="fa fa-times text-danger"></span>');
                $('[data-validation="attachment"]').html('<span class="fa fa-times text-danger"></span>');
                errors++;
            }
        } else {
            $('[data-validation="attachment_scope"]').html('<span class="fa fa-check text-success"></span>');
        }

        $('#validation-modal').modal('show');

        if (errors > 0) {
            return false;
        } else {
            return true;
        }
    }
    function get_spending_value(po_no) {
        $.ajax({
            type:'post',
            data:{po_no:po_no},
            url:"<?= base_url('procurement/browse/spending_value') ?>",
            success:function(e){
                var r = eval("("+e+")");
                if(r.status)
                {
                    var n = parseInt($("#po_latest_value_ori").val()) - parseInt(r.spending_value);
                    $('#po_spending_value').val(r.spending_value);
                    $('#po_remaining_value').val(n);
                }
                else
                {
                    $('#po_spending_value').val('0');
                    $("#po_remaining_value").val($("#po_latest_value").val());
                    swal('Fail','Cant Get Spending Value','warning')
                }
            },
            error:function(){
                    $('#po_spending_value').val('0');
                    $("#po_remaining_value").val($("#po_latest_value").val());
                swal('Fail','Cant Get Spending Value','warning')
            }
        })
    }
    function get_amd(po_no,total_amount){
      $.ajax({
        type:'post',
        data:{po_no:po_no,mode:'arf-preparation'},
        url:"<?= base_url('procurement/browse/get_amd') ?>",
        success:function(e){
          var r = eval("("+e+")");
          if(r.status)
          {
            $('.div-detail-amd').show();
            $("#dt-amd").html(r.dt);
            $("#amd_total").val(r.total);
            $('#po_latest_value_ori').val(r.total);
            $('#po_latest_value').val(r.total);
          }
          else
          {
            $('.div-detail-amd').hide();
            $("#dt-amd").html('');
            $("#amd_total").val(0);
            $('#po_latest_value_ori').val(total_amount);
            $('#po_latest_value').val(total_amount);
          }
          get_spending_value(po_no)
        },
        error:function(){
          $('.div-detail-amd').hide();
          $("#dt-amd").html('');
          $("#amd_total").val(0);
        }
      })
    }
    <?php 
      if(isset($is_edit)): 
        $amdNumber = substr($arf->doc_no, -5);
    ?>
    $(document).ready(function(){
      function get_amd(po_no,total_amount){
        $.ajax({
          type:'post',
          data:{po_no:po_no,mode:'arf-preparation'},
          url:"<?= base_url('procurement/browse/get_amd') ?>",
          success:function(e){
            var r = eval("("+e+")");
            if(r.status)
            {
              $('.div-detail-amd').show();
              $("#dt-amd").html(r.dt);
              $("#amd_total").val(r.total);
              /*$('#po_latest_value_ori').val(r.total);
              $('#po_latest_value').val(r.total);*/
              var po = '<?= $arf->amount_po ?>';
                var total = r.total;
                var jml = toFloat(po) + toFloat(total);
                var amdNumber = '<?= $amdNumber ?>';
                if(amdNumber == 'AMD01')
                {
                    finalTotal = jml;
                }
                else
                {
                    finalTotal = total;
                }
                $('#po_latest_value_ori, #po_latest_value').val(finalTotal);
            }
            get_spending_value(po_no)
          },
          error:function(){
            $('.div-detail-amd').hide();
            $("#dt-amd").html('');
            $("#amd_total").val(0);
          }
        })
      }
      get_amd('<?= $arf->po_no ?>', 0)
    })
    <?php endif;?>
</script>