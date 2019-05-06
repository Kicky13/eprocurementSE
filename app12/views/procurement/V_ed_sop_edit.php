<?php $this->load->view('procurement/partials/script') ?>
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
                        <td style="width: 105px;">MSR Value (Excl. VAT)</td>
                        <td class="no-padding-lr">:</td>
                        <td class="text-right"><?= $ed->currency_desc?> <?=numIndo($ed->total_amount)?></td>
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
                        <form id="form-sop">
                            <h3>MSR Item</h3>
                            <div class="form-group">
                                <table class="table table-striped table-no-wrap table-price" style="font-size: 12px">
                                    <thead>
                                         <tr>
                                            <th>Description</th>
                                            <th class="text-center">Qty</th>
                                            <th class="text-center">UoM</th>
                                            <th class="text-right">Unit Price</th>
                                            <th class="text-right">Total Price</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $no = 1 ?>
                                        <?php foreach ($ed->msr_item as $msr_item) { ?>
                                            <tr>
                                                <td><?= $msr_item->description ?></td>
                                                <td class="text-center"><?= $msr_item->qty ?></td>
                                                <td class="text-center"><?= $msr_item->uom ?></td>
                                                <td class="text-right"><?= numIndo($msr_item->priceunit) ?></td>
                                                <td class="text-right"><?= numIndo($msr_item->amount) ?></td>
                                                <td class="text-right">
                                                    <button type="button" class="btn btn-primary btn-sm" onclick="copy_msr_item_to_sop_item('<?= $msr_item->line_item ?>')">Add Item</button>
                                                </td>
                                            </tr>
                                            <?php $no++ ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h3>Schedule of Price</h3>
                                    </div>
                                    <div class="col-md-6 text-right ">
                                        <button type="button" id="btn-add-item" class="btn btn-primary">Add New Item</button>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="sop-item-table" class="table table-striped table-no-wrap table-price" style="font-size: 12px">
                                        <thead>
                                             <tr>
                                                <th>No</th>
                                                <th>MSR Item</th>
                                                <th>Description</th>
                                                <th class="text-center">Qty</th>
                                                <th class="text-center">UoM</th>
                                                <th class="text-center">Qty 2</th>
                                                <th class="text-center">UoM 2</th>
                                                <th class="text-center">Cost Center</th>
                                                <th class="text-center">Account Subsidiary</th>
                                                <th class="text-center">Inv Type</th>
                                                <th class="text-center">Item Modification</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php $no = 1 ?>
                                            <?php foreach ($ed->sop as $sop) { ?>
                                                <tr data-row-id="<?= $no ?>">
                                                    <td>
                                                        <?= $no ?>
                                                    </td>
                                                    <td>
                                                        <?= $sop->msr_item ?>
                                                        <?= $this->form->hidden('sop['.$no.'][id]', $sop->id) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][msr_item_id]', $sop->msr_item_id) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][msr_no]', $sop->msr_no) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][sop_type]', $sop->sop_type) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][item_material_id]', $sop->item_material_id) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][item_semic_no_value]', $sop->item_semic_no_value) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][item]', $sop->item) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][id_itemtype]', $sop->id_itemtype) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][id_itemtype_category]', $sop->id_itemtype_category) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][groupcat]', $sop->groupcat) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][groupcat_desc]', $sop->groupcat_desc) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][sub_groupcat]', $sop->sub_groupcat) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][sub_groupcat_desc]', $sop->sub_groupcat_desc) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][inv_type]', $sop->inv_type) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][item_modification]', $sop->item_modification) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][id_costcenter]', $sop->id_costcenter) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][costcenter_desc]', $sop->costcenter_desc) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][id_accsub]', $sop->id_accsub) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][accsub_desc]', $sop->accsub_desc) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][qty1]', $sop->qty1) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][uom1]', $sop->uom1) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][qty2]', $sop->qty2) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][uom2]', $sop->uom2) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][tax]', $sop->tax) ?>
                                                        <?= $this->form->hidden('sop['.$no.'][deleted]', 0) ?>
                                                    </td>
                                                    <td><?= $sop->item ?></td>
                                                    <td class="text-center"><?= $sop->qty1 ?></td>
                                                    <td class="text-center"><?= $sop->uom1 ?></td>
                                                    <td class="text-center">
                                                        <?= $sop->sop_type == 2 ? $sop->qty2 : '-' ?>
                                                    </td>
                                                    <td class="text-center">
                                                        <?= $sop->sop_type == 2 ? $sop->uom2 : '-' ?>
                                                    </td>
                                                    <td class="text-center"><?= $sop->costcenter_desc ?></td>
                                                    <td class="text-center"><?= $sop->accsub_desc ?></td>
                                                    <td class="text-center"><?= $sop->inv_type_desc ?></td>
                                                    <td class="text-center"><?= ($sop->item_modification) ? '<span class="fa fa-check text-success"></span>' : '<span class="fa fa-times text-danger"></span>' ?></td>
                                                    <td class="text-right">
                                                        <button type="button" class="btn btn-warning btn-sm" onclick="edit_sop_item('<?= $no ?>')">Edit</button>
                                                        <button type="button" class="btn btn-danger btn-sm" onclick="remove_sop_item('<?= $no ?>')">Delete</button>
                                                    </td>
                                                </tr>
                                                <?php $no++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-group text-right">
            <!--<a href="<?= base_url('approval/approval/negotiation') ?>" class="btn btn-outline-secondary">Cancel</a>-->
            <button type="button" id="btn-save-sop" class="btn btn-success">Submit SOP</button>
        </div>
    </div>
</div>

<div class="modal fade" id="add-item-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-form" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="add-item-modal-title" class="modal-title">Add New Item</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group row">
                            <label class="col-md-5">MSR Item</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_msr_item_id', lists($ed->msr_item, 'line_item', 'description', 'Please Select'), null, 'id="add-item-id_msr_item" class="form-control"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Item Type</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_item_type', lists($this->m_procurement->get_item_type(), 'ID_ITEMTYPE', 'ITEMTYPE_DESC', 'Please Select'), null, 'id="add-item-id_item_type" class="form-control" style="width:100%"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Category</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_item_type_category', array('' => 'Please Select'), null, 'id="add-item-id_item_type_category" class="form-control"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5"><span class="add-item-label-semic_no">Semic No.</span></label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_semic_no', array('' => 'Please Select'), null, 'id="add-item-semic_no" class="form-control" style="width:100%"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Description of Unit</label>
                            <div class="col-md-7">
                                <?= $this->form->textarea('add_item_description_of_unit', null, 'id="add-item-description_of_unit" class="form-control" style="height:100px;" disabled') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Classification</label>
                            <div class="col-md-7">
                                <?= $this->form->text('add_item_classification', null, 'id="add-item-classification" class="form-control" disabled') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Group/Category</label>
                            <div class="col-md-7">
                                <?= $this->form->text('add_item_category', null, 'id="add-item-category" class="form-control" disabled') ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div id="add-item-form-group-id_inventory_type" class="form-group row" style="display: none;">
                            <label class="col-md-5">Inventory Type</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_inventory_type', lists($this->m_procurement->get_msr_inventory_type(), 'id', 'description', 'Please Select'), null, 'id="add-item-id_inventory_type" class="form-control"') ?>
                            </div>
                        </div>
                        <div id="add-item-form-group-item_modification" class="form-group row" style="display: none;">
                            <label class="col-md-5">Item Modification</label>
                            <div class="col-md-7">
                                <?= $this->form->checkbox('add_item_item_modification', 1, false, 'id="add-item-item_modification"') ?>
                            </div>
                        </div>
                        <div id="add-item-form-group-sop_type" class="form-group row">
                            <label class="col-md-5">Qty Type</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_sop_type', array('1' => 'Type 1', '2' => 'Type 2'), $sop->sop_type, 'id="add-item-sop_type" class="form-control"') ?>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Qty/UoM</label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $this->form->text('add_item_qty', null, 'id="add-item-qty" class="form-control text-center" onkeyup="add_item_count_total()"') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $this->form->select('add_item_uom', array('' => 'Please Select'), null, 'id="add-item-uom" class="form-control" disabled') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Qty 2/UoM 2</label>
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-6">
                                        <?= $this->form->text('add_item_qty2', null, 'id="add-item-qty2" class="form-control text-center" onkeyup="add_item_count_total()" disabled') ?>
                                    </div>
                                    <div class="col-md-6">
                                        <?= $this->form->select('add_item_uom2', array('' => 'Please Select'), null, 'id="add-item-uom2" class="form-control" disabled') ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-5">Cost Center</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_costcenter', lists($this->db->where('ID_COMPANY', $ed->id_company)->get('m_costcenter')->result(), 'ID_COSTCENTER', function($model) {
                                    return $model->ID_COSTCENTER.' - '.$model->COSTCENTER_DESC;
                                }, 'Please Select'), null, 'id="add-item-id_costcenter" class="form-control"') ?>
                            </div>
                        </div>
                        <div id="add-item-form-group-id_account_subsidiary" class="form-group row" style="display: none;">
                            <label class="col-md-5">Account Subsidiary</label>
                            <div class="col-md-7">
                                <?= $this->form->select('add_item_id_account_subsidiary', array('' => 'Please Select'), null, 'id="add-item-id_account_subsidiary" class="form-control"') ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn grey btn-outline-secondary" data-dismiss="modal">Cancel</button>
              <button type="button" class="btn btn-primary" id="add-item-btn-add-item">Add</button>
              <button type="button" class="btn btn-primary" id="add-item-btn-update-item" style="display: none;">Update</button>
            </div>
        </div>
    </div>
</div>

<script>
    var item_type_categories = <?= json_encode($item_type_categories) ?>;
    var sop_row_id = $('#sop-item-table tr[data-row-id]').length;
    $(function() {
        $('#add-item-est_unit_price,#add-item-est_total_price').number(true, 2);
        $('#add-item-semic_no').select2({
            dropdownParent: $('#add-item-modal'),
            minimumInputLength: 1,
            ajax: {
                url: "<?php echo base_url('procurement/msr/findItem') ?>",
                dataType: 'json',
                cache: true,
                data: function(params) {
                    var query = {
                        query: params.term,
                        type: $('#add-item-id_item_type').val(),
                        itemtype_category: $('#add-item-id_item_type_category').val(),
                        id_company: '<?= $ed->id_company ?>'
                    }
                    return query
                },
                marker: function(marker) {
                    return marker;
                },
                processResults: function (data) {
                    var items = [];
                    if (data) {
                        items = data.map(function(row) {
                            return {
                                "id": row.id,
                                "text": row.semic_no + ' - ' + row.name
                            }
                        });
                    }
                    return {
                        results: items
                    };
                }
            }
        });

        $('#btn-attachment').click(function() {
            $('#attachment-modal').modal('show');
        });

        $('#add-item-modal').on('show.bs.modal', function() {
            if ($('#sop-item-table tbody tr[data-row-id]:not(.deleted)').length) {
                $('#add-item-sop_type').prop('disabled', true);
            } else {
                $('#add-item-sop_type').prop('disabled', false);
            }
            $('#add-item-sop_type').change();
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
            $('#add-item-sop_type').change();
            if (!$('#add-item-id_item_type').val()) {
                $('#add-item-uom').resetOptionLists();
                $('#add-item-uom').prop('disabled', true);
                $('#add-item-description_of_unit').val('').prop('disabled', true);
                $('#add-item-id_inventory_type').val('').change();
                $('#add-item-form-group-id_inventory_type').hide();
            } else if ($('#add-item-id_item_type').val() == 'SERVICE') {
                get_uom({
                   uom_type : 2
                });
                $('#add-item-description_of_unit').prop('disabled', false);
                $('#add-item-id_inventory_type').val('').change();
                $('#add-item-form-group-id_inventory_type').hide();
                $('#add-item-form-group-item_modification').show();
                $('#add-item-uom').prop('disabled', false);
            } else {
                $('#add-item-description_of_unit').val('').prop('disabled', true);
                $('#add-item-id_inventory_type').val('').change();
                $('#add-item-form-group-id_inventory_type').show()
                $('#add-item-item_modification').prop('checked', false);
                $('#add-item-form-group-item_modification').hide();
                $('#add-item-uom').resetOptionLists();
                $('#add-item-uom').prop('disabled', true);
            }
        });

        $('#add-item-id_item_type_category').change(function() {
            $('#add-item-semic_no').val('').change();
            if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
                $('.add-item-label-semic_no').html('Semic No.');
                $('#add-item-description_of_unit').val('').prop('disabled', true);
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
            $.ajax({
                url : '<?= base_url('procurement/msr/findItemAttributes') ?>',
                data : {
                    material_id: $('#add-item-semic_no').val(),
                    type: $('#add-item-id_item_type').val(),
                    itemtype_category: $('#add-item-id_item_type_category').val()
                },
                dataType : 'json',
                success : function(response) {
                    if (response != 0) {
                        var data = response;
                        $('#add-item-classification').val(data.group_code+'. '+data.group_name);
                        $('#add-item-category').val(data.subgroup_code+'. '+data.subgroup_name);
                        if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
                            var semic = $('#add-item-semic_no option:selected').text();
                            $('#add-item-description_of_unit').val(semic.split(' - ')[1]);
                            get_uom({
                                material_id : $('#add-item-semic_no').val()
                            }, data.uom_name);
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

        $('#add-item-sop_type').change(function() {
            if ($('#add-item-sop_type').val() == 1) {
                $('#add-item-qty2').val('').prop('disabled', true);
                $('#add-item-uom2').val('').prop('disabled', true);
            } else {
                if ($('#add-item-id_item_type').val() == 'SERVICE') {
                    $('#add-item-qty2').prop('disabled', false);
                    $('#add-item-uom2').prop('disabled', false);
                } else {
                    $('#add-item-qty2').val('').prop('disabled', true);
                    $('#add-item-uom2').val('').prop('disabled', true);
                }
            }
        });

        $('#add-item-id_costcenter').change(function() {
            get_account_subsidiary({
                id_costcenter : $('#add-item-id_costcenter').val()
            });
        });

        $('#add-item-btn-add-item').click(function() {
            add_sop_item();
        });

        $('#add-item-btn-update-item').click(function() {
            update_sop_item();
        });

        $('#btn-save-sop').click(function() {
            swalConfirm('Negotiation', '<?= __('confirm_submit') ?>', function() {
                $.ajax({
                    url : '<?= base_url('procurement/ed/sop_update/'.$ed->bled_no) ?>',
                    type : 'post',
                    data : $('#form-sop').serialize(),
                    dataType : 'json',
                    success : function(response) {
                        if (response.success) {
                            setTimeout(function() {
                                swalAlert('Done', 'Data is successfully submitted', function() {
                                    document.location.href = '<?= base_url('approval/approval/negotiation') ?>';
                                });
                            }, swalDelay);
                        } else {
                            setTimeout(function() {
                                swal('<?= __('warning') ?>', response.message, 'warning');
                            }, swalDelay);
                        }
                    }
                });
            });
        });
    });

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

    function get_uom(params, selected, selected2) {
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
                $('#add-item-uom2').html(html_option);
                if (selected) {
                    $('#add-item-uom').val(selected);
                } else {
                    if ($('#add-item-uom').data('selected')) {
                        $('#add-item-uom').val($('#add-item-uom').data('selected'));
                    } else {
                        $('#add-item-uom').val('');
                    }
                }

                if (selected2) {
                    $('#add-item-uom2').val(selected2);
                } else {
                    if ($('#add-item-uom2').data('selected')) {
                        $('#add-item-uom2').val($('#add-item-uom2').data('selected'));
                    } else {
                        $('#add-item-uom2').val('');
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
        var qty2 = toFloat($('#add-item-qty2').val());
        if (!qty2) {
            qty2 = 1;
        }
        var price = toFloat($('#add-item-est_unit_price').val());
        var total = qty * qty2 * price;
        $('#add-item-est_total_price').val(total);
    }

    function reset_add_item() {
        $('#add-item-modal-title').html('Add New Item');
        $('#add-item-modal #error_message').remove();
        $('#add-item-id_msr_item').val('');
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
        $('#add-item-uom2').resetOptionLists();
        $('#add-item-uom2').prop('disabled', true);
        $('#add-item-qty2').val('').prop('disabled', true);
        $('#add-item-sop_type').change();
        $('#add-item-est_unit_price').val('');
        $('#add-item-est_total_price').val('');
        $('#add-item-id_costcenter').val('');
        $('#add-item-id_account_subsidiary').resetOptionLists();
        $('#add-item-form-group-id_account_subsidiary').hide();
        $('#add-item-btn-add-item').show();
        $('#add-item-btn-update-item').data('row-id', 0);
        $('#add-item-btn-update-item').hide();
    }

    function copy_msr_item_to_sop_item(id) {
        $.ajax({
            url : '<?= base_url('procurement/procurement/msr_item_json') ?>/'+id,
            dataType : 'json',
            success : function(response) {
                var item = response.data;
                $('#add-item-id_msr_item').val(id);
                $('#add-item-id_item_type').val(item.id_itemtype);
                get_item_type_categories();
                if ($('#add-item-id_item_type').val() == 'SERVICE') {
                    get_uom({
                       uom_type : 2
                    }, item.uom);
                    $('#add-item-form-group-id_inventory_type').hide();
                    $('#add-item-form-group-item_modification').show();
                    $('#add-item-uom').prop('disabled', false);
                } else {
                    $('#add-item-form-group-id_inventory_type').show();
                    $('#add-item-form-group-item_modification').hide();
                    $('#add-item-uom').prop('disabled', true);
                }
                $('#add-item-id_item_type_category').val(item.id_itemtype_category);
                if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
                    $('.add-item-label-semic_no').html('Semic No.');
                    $('#add-item-description_of_unit').prop('disabled', true);
                } else {
                    if ($('#add-item-id_item_type_category').val()) {
                        $('.add-item-label-semic_no').html($('#add-item-id_item_type_category option:selected').text()+' Category');
                    } else {
                        $('.add-item-label-semic_no').html('Semic No.');
                    }
                    $('#add-item-description_of_unit').prop('disabled', false);
                    if ($('#add-item-id_item_type_category').val() == 'MATGROUP') {
                        get_uom({
                           uom_type : 1
                        }, item.uom);
                    }
                }
                if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
                    var semic = item.semic_no+' - '+item.description;
                } else {
                    var semic = item.semic_no+' - '+item.sub_groupcat_desc;
                }
                $('#add-item-semic_no').html('').select2({
                    data : [
                        {
                            id : item.material_id,
                            text : semic
                        }
                    ],
                    dropdownParent: $('#add-item-modal'),
                    minimumInputLength: 1,
                    ajax: {
                        url: "<?php echo base_url('procurement/msr/findItem') ?>",
                        dataType: 'json',
                        cache: true,
                        data: function(params) {
                            var query = {
                                query: params.term,
                                type: $('#add-item-id_item_type').val(),
                                itemtype_category: $('#add-item-id_item_type_category').val(),
                                id_company: '<?= $ed->id_company ?>'
                            }
                            return query
                        },
                        marker: function(marker) {
                            return marker;
                        },
                        processResults: function (data) {
                            var items = [];
                            if (data) {
                                items = data.map(function(row) {
                                    return {
                                        "id": row.id,
                                        "text": row.semic_no + ' - ' + row.name
                                    }
                                });
                            }
                            return {
                                results: items
                            };
                        }
                    }
                }).val(item.material_id)
                .change();
                $('#add-item-description_of_unit').val(item.description);
                $('#add-item-id_inventory_type').val(item.inv_type).change();
                $('#add-item-sop_type').change();
                $('#add-item-id_costcenter').val(item.id_costcenter);
                get_account_subsidiary({
                    id_costcenter : $('#add-item-id_costcenter').val()
                }, item.id_accsub);
                $('#add-item-modal').modal('show');
            }
        });
    }

    function edit_sop_item(id) {
        $('#add-item-btn-update-item').data('row-id', id);
        var msr_item_id = $('[name="sop['+id+'][msr_item_id]"]').val();
        var sop_type = $('[name="sop['+id+'][sop_type]"]').val();
        var item_material_id = $('[name="sop['+id+'][item_material_id]"]').val();
        var item_semic_no_value = $('[name="sop['+id+'][item_semic_no_value]"]').val();
        var item = $('[name="sop['+id+'][item]"]').val();
        var id_itemtype = $('[name="sop['+id+'][id_itemtype]"]').val();
        var id_itemtype_category = $('[name="sop['+id+'][id_itemtype_category]"]').val();
        var groupcat = $('[name="sop['+id+'][groupcat]"]').val();
        var groupcat_desc = $('[name="sop['+id+'][groupcat_desc]"]').val();
        var sub_groupcat = $('[name="sop['+id+'][sub_groupcat]"]').val();
        var sub_groupcat_desc = $('[name="sop['+id+'][sub_groupcat_desc]"]').val();
        var inv_type = $('[name="sop['+id+'][inv_type]"]').val();
        var item_modification = $('[name="sop['+id+'][item_modification]"]').val();
        var id_costcenter = $('[name="sop['+id+'][id_costcenter]"]').val();
        var costcenter_desc = $('[name="sop['+id+'][costcenter_desc]"]').val();
        var id_accsub = $('[name="sop['+id+'][id_accsub]"]').val();
        var accsub_desc = $('[name="sop['+id+'][accsub_desc]"]').val();
        var qty1 = $('[name="sop['+id+'][qty1]"]').val();
        var uom1 = $('[name="sop['+id+'][uom1]"]').val();
        var qty2 = $('[name="sop['+id+'][qty2]"]').val();
        var uom2 = $('[name="sop['+id+'][uom2]"]').val();
        $('#add-item-id_msr_item').val(msr_item_id);
        $('#add-item-id_item_type').val(id_itemtype);
        get_item_type_categories();
        if ($('#add-item-id_item_type').val() == 'SERVICE') {
            get_uom({
               uom_type : 2
            }, uom1, uom2);
            $('#add-item-form-group-id_inventory_type').hide();
            $('#add-item-form-group-item_modification').show();
            $('#add-item-uom').prop('disabled', false);
        } else {
            $('#add-item-form-group-id_inventory_type').show();
            $('#add-item-form-group-item_modification').hide();
            $('#add-item-uom').prop('disabled', true);
        }
        $('#add-item-id_item_type_category').val(id_itemtype_category);
        if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
            $('.add-item-label-semic_no').html('Semic No.');
            $('#add-item-description_of_unit').prop('disabled', true);
        } else {
            if ($('#add-item-id_item_type_category').val()) {
                $('.add-item-label-semic_no').html($('#add-item-id_item_type_category option:selected').text()+' Category');
            } else {
                $('.add-item-label-semic_no').html('Semic No.');
            }
            $('#add-item-description_of_unit').prop('disabled', false);
            if ($('#add-item-id_item_type_category').val() == 'MATGROUP') {
                get_uom({
                   uom_type : 1
                }, item.uom);
            }
        }
        if ($('#add-item-id_item_type_category').val() == 'SEMIC') {
            var semic = item_semic_no_value+' - '+item;
        } else {
            var semic = item_semic_no_value+' - '+sub_groupcat_desc;
        }
        $('#add-item-semic_no').html('').select2({
            data : [
                {
                    id : item_material_id,
                    text : semic
                }
            ],
            dropdownParent: $('#add-item-modal'),
            minimumInputLength: 1,
            ajax: {
                url: "<?php echo base_url('procurement/msr/findItem') ?>",
                dataType: 'json',
                cache: true,
                data: function(params) {
                    var query = {
                        query: params.term,
                        type: $('#add-item-id_item_type').val(),
                        itemtype_category: $('#add-item-id_item_type_category').val(),
                        id_company: '<?= $ed->id_company ?>'
                    }
                    return query
                },
                marker: function(marker) {
                    return marker;
                },
                processResults: function (data) {
                    var items = [];
                    if (data) {
                        items = data.map(function(row) {
                            return {
                                "id": row.id,
                                "text": row.semic_no + ' - ' + row.name
                            }
                        });
                    }
                    return {
                        results: items
                    };
                }
            }
        }).val(item_material_id)
        .change();
        $('#add-item-description_of_unit').val(item);
        $('#add-item-id_inventory_type').val(inv_type).change();
        $('#add-item-sop_type').change();
        $('#add-item-qty').val(qty1);
        $('#add-item-qty2').val(qty2);
        $('#add-item-id_costcenter').val(id_costcenter);
        get_account_subsidiary({
            id_costcenter : $('#add-item-id_costcenter').val()
        }, id_accsub);
        $('#add-item-modal-title').html('Update Item');
        $('#add-item-btn-add-item').hide();
        $('#add-item-btn-update-item').show();
        $('#add-item-modal').modal('show');
    }

    function add_sop_item() {
        $('#add-item-modal #error_message').remove();
        var errors = [];
        var id_msr_item = $('#add-item-id_msr_item').val();
        var msr_item = $('#add-item-id_msr_item option:selected').text();
        var id_item_type = $('#add-item-id_item_type').val();
        var item_type = $('#add-item-id_item_type option:selected').text();
        var id_item_type_category = $('#add-item-id_item_type_category').val();
        var item_type_category = $('#add-item-id_item_type_category option:selected').text();
        var material_id = $('#add-item-semic_no').val();
        if (material_id) {
            var semic_no = $('#add-item-semic_no option:selected').text().split(" - ")[0];
        } else {
            var semic_no = '';
        }
        var description_of_unit = $('#add-item-description_of_unit').val();
        var classification = $('#add-item-classification').val();
        if (classification) {
            var group_classification = $('#add-item-classification').val().split(". ")[0];
            var group_classification_desc = $('#add-item-classification').val().split(". ")[1];
        } else {
            var group_classification = '';
            var group_classification_desc = '';
        }
        var category = $('#add-item-category').val();
        if (category) {
            var group_category = $('#add-item-category').val().split(". ")[0];
            var group_category_desc = $('#add-item-category').val().split(". ")[1];
        } else {
            var group_category = '';
            var group_category_desc = '';
        }
        var id_inventory_type = $('#add-item-id_inventory_type').val();
        if (id_inventory_type) {
            var inventory_type = $('#add-item-id_inventory_type option:selected').text();
        } else {
            inventory_type = '';
        }
        var item_modification = $('#add-item-item_modification').prop('checked');
        var sop_type = $('#add-item-sop_type').val();
        var qty = $('#add-item-qty').val();
        var uom = $('#add-item-uom').val();
        var qty2 = $('#add-item-qty2').val();
        var uom2 = $('#add-item-uom2').val();
        var est_unit_price = $('#add-item-est_unit_price').val();
        var est_total_price = $('#add-item-est_total_price').val();
        var id_costcenter = $('#add-item-id_costcenter').val();
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

        if (!id_msr_item) {
            errors.push('MSR Item is required');1
        }

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

        if (qty2) {
            if (!uom2) {
                errors.push('UoM 2 is required');
            }
        }

        if (uom2) {
            if (!qty2) {
                errors.push('Qty 2 is required');
            }
        }
        /*if (!est_unit_price) {
            errors.push('Est.Unit Price is required');
        }*/

        if (!id_costcenter) {
            errors.push('Costcenter is required');
        }

        $.each($('#sop-item-table tr[data-row-id]:not(.deleted)'), function(key, row) {
            var row_id = $(row).data('row-id');
            if ($('[name="sop['+row_id+'][item_semic_no_value]"]').val() == semic_no && $('[name="sop['+row_id+'][item]"]').val().toLowerCase() == description_of_unit.toLowerCase()) {
                errors.push('This item already exist');
            }
        });

        if (errors.length != 0) {
            var error_message = '';
            $.each(errors, function(i, e) {
                error_message +=e+'<br>';
            });
            $('#add-item-modal .modal-body').prepend('<div id="error_message" class="alert alert-danger">'+error_message+'</div>');
            return false;
        }
        sop_row_id++;
        var rowHtml = '<tr data-row-id="'+sop_row_id+'">';
            	rowHtml += '<td>'+sop_row_id+'</td>';
		rowHtml += '<td>';
                rowHtml += msr_item;
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][msr_no]" value="<?= $ed->msr_no ?>" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][msr_item_id]" value="'+id_msr_item+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][sop_type]" value="'+sop_type+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][item_material_id]" value="'+material_id+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][item_semic_no_value]" value="'+semic_no+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][item]" value="'+description_of_unit+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id_itemtype]" value="'+id_item_type+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id_itemtype_category]" value="'+id_item_type_category+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][groupcat]" value="'+group_classification+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][groupcat_desc]" value="'+group_classification_desc+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][sub_groupcat]" value="'+group_category+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][sub_groupcat_desc]" value="'+group_category_desc+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][inv_type]" value="'+id_inventory_type+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][item_modification]" value="'+item_modification+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id_costcenter]" value="'+id_costcenter+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][costcenter_desc]" value="'+costcenter+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id_accsub]" value="'+id_account_subsidiary+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][accsub_desc]" value="'+account_subsidiary+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][qty1]" value="'+qty+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][uom1]" value="'+uom+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][qty2]" value="'+qty2+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][uom2]" value="'+uom2+'" />';
            rowHtml += '</td>';
            rowHtml += '<td>'+description_of_unit+'</td>';
            rowHtml += '<td class="text-center">'+qty+'</td>';
            rowHtml += '<td class="text-center">'+uom+'</td>';
            rowHtml += '<td class="text-center">';
                if (sop_type == 2 && qty2) {
                    rowHtml += qty2;
                }
            rowHtml += '</td>';
            rowHtml += '<td class="text-center">';
                if (sop_type == 2 && uom2) {
                    rowHtml += uom2;
                }
            rowHtml += '</td>'
            rowHtml += '<td class="text-center">'+costcenter+'</td>';
            rowHtml += '<td class="text-center">'+account_subsidiary+'</td>';
            rowHtml += '<td class="text-center">'+inventory_type+'</td>';
            rowHtml += '<td class="text-center">'+Localization.boolean(item_modification)+'</td>';
            rowHtml += '<td class="text-right">';
                rowHtml += '<button type="button" class="btn btn-warning btn-sm" onclick="edit_sop_item('+sop_row_id+')">Edit</button> ';
                rowHtml += '<button type="button" class="btn btn-danger btn-sm" onclick="remove_sop_item('+sop_row_id+')">Delete</button>';
            rowHtml += '</td>';
        rowHtml += '</tr>';
        $('#sop-item-table tbody').append(rowHtml);
        $('#add-item-modal').modal('hide');
    }

    function update_sop_item() {
        var sop_row_id = $('#add-item-btn-update-item').data('row-id');
        $('#add-item-modal #error_message').remove();
        var errors = [];
        var id = $('[name="sop['+sop_row_id+'][id]"]').val();
        var id_msr_item = $('#add-item-id_msr_item').val();
        var msr_item = $('#add-item-id_msr_item option:selected').text();
        var id_item_type = $('#add-item-id_item_type').val();
        var item_type = $('#add-item-id_item_type option:selected').text();
        var id_item_type_category = $('#add-item-id_item_type_category').val();
        var item_type_category = $('#add-item-id_item_type_category option:selected').text();
        var material_id = $('#add-item-semic_no').val();
        if (material_id) {
            var semic_no = $('#add-item-semic_no option:selected').text().split(" - ")[0];
        } else {
            var semic_no = '';
        }
        var description_of_unit = $('#add-item-description_of_unit').val();
        var classification = $('#add-item-classification').val();
        if (classification) {
            var group_classification = $('#add-item-classification').val().split(". ")[0];
            var group_classification_desc = $('#add-item-classification').val().split(". ")[1];
        } else {
            var group_classification = '';
            var group_classification_desc = '';
        }
        var category = $('#add-item-category').val();
        if (category) {
            var group_category = $('#add-item-category').val().split(". ")[0];
            var group_category_desc = $('#add-item-category').val().split(". ")[1];
        } else {
            var group_category = '';
            var group_category_desc = '';
        }
        var id_inventory_type = $('#add-item-id_inventory_type').val();
        if (id_inventory_type) {
            var inventory_type = $('#add-item-id_inventory_type option:selected').text();
        } else {
            inventory_type = '';
        }
        var item_modification = $('#add-item-item_modification').prop('checked');
        var sop_type = $('#add-item-sop_type').val();
        var qty = $('#add-item-qty').val();
        var uom = $('#add-item-uom').val();
        var qty2 = $('#add-item-qty2').val();
        var uom2 = $('#add-item-uom2').val();
        var est_unit_price = $('#add-item-est_unit_price').val();
        var est_total_price = $('#add-item-est_total_price').val();
        var id_costcenter = $('#add-item-id_costcenter').val();
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

        if (!id_msr_item) {
            errors.push('MSR Item is required');1
        }

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

        if (toFloat(qty2)) {
            if (!uom2) {
                errors.push('UoM 2 is required');
            }
        }

        if (uom2) {
            if (!toFloat(qty2)) {
                errors.push('Qty 2 is required');
            }
        }
        /*if (!est_unit_price) {
            errors.push('Est.Unit Price is required');
        }*/

        if (!id_costcenter) {
            errors.push('Costcenter is required');
        }

        $.each($('#sop-item-table tr[data-row-id]:not(.deleted)'), function(key, row) {
            var row_id = $(row).data('row-id');
            if (row_id != sop_row_id) {
                if ($('[name="sop['+row_id+'][item_semic_no_value]"]').val() == semic_no && $('[name="sop['+row_id+'][item]"]').val().toLowerCase() == description_of_unit.toLowerCase()) {
                    errors.push('This item already exist');
                }
            }
        });

        if (errors.length != 0) {
            var error_message = '';
            $.each(errors, function(i, e) {
                error_message +=e+'<br>';
            });
            $('#add-item-modal .modal-body').prepend('<div id="error_message" class="alert alert-danger">'+error_message+'</div>');
            return false;
        }
        var rowHtml = '<tr data-row-id="'+sop_row_id+'">';
            rowHtml += '<td>'+sop_row_id+'</td>';
	    rowHtml += '<td>';
                rowHtml += msr_item;
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id]" value="'+id+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][msr_no]" value="<?= $ed->msr_no ?>" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][msr_item_id]" value="'+id_msr_item+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][sop_type]" value="'+sop_type+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][item_material_id]" value="'+material_id+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][item_semic_no_value]" value="'+semic_no+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][item]" value="'+description_of_unit+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id_itemtype]" value="'+id_item_type+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id_itemtype_category]" value="'+id_item_type_category+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][groupcat]" value="'+group_classification+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][groupcat_desc]" value="'+group_classification_desc+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][sub_groupcat]" value="'+group_category+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][sub_groupcat_desc]" value="'+group_category_desc+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][inv_type]" value="'+id_inventory_type+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][item_modification]" value="'+item_modification+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id_costcenter]" value="'+id_costcenter+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][costcenter_desc]" value="'+costcenter+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][id_accsub]" value="'+id_account_subsidiary+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][accsub_desc]" value="'+account_subsidiary+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][qty1]" value="'+qty+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][uom1]" value="'+uom+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][qty2]" value="'+qty2+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][uom2]" value="'+uom2+'" />';
                rowHtml += '<input type="hidden" name="sop['+sop_row_id+'][deleted]" value="0" />';
            rowHtml += '</td>';
            rowHtml += '<td>'+description_of_unit+'</td>';
            rowHtml += '<td class="text-center">'+qty+'</td>';
            rowHtml += '<td class="text-center">'+uom+'</td>';
            rowHtml += '<td class="text-center">';
                if (sop_type == 2 && qty2) {
                    rowHtml += qty2;
                }
            rowHtml += '</td>';
            rowHtml += '<td class="text-center">';
                if (sop_type == 2 && uom2) {
                    rowHtml += uom2;
                }
            rowHtml += '</td>'
            rowHtml += '<td class="text-center">'+costcenter+'</td>';
            rowHtml += '<td class="text-center">'+account_subsidiary+'</td>';
            rowHtml += '<td class="text-center">'+inventory_type+'</td>';
            rowHtml += '<td class="text-center">'+Localization.boolean(item_modification)+'</td>';
            rowHtml += '<td class="text-right">';
                rowHtml += '<button type="button" class="btn btn-warning btn-sm" onclick="edit_sop_item('+sop_row_id+')">Edit</button> ';
                rowHtml += '<button type="button" class="btn btn-danger btn-sm" onclick="remove_sop_item('+sop_row_id+')">Remove</button>';
            rowHtml += '</td>';
        rowHtml += '</tr>';
        $('#sop-item-table tbody tr[data-row-id="'+sop_row_id+'"]').replaceWith(rowHtml);
        $('#add-item-modal').modal('hide');
    }

    function remove_sop_item(id) {
        swalConfirm('Negotiation', '<?= __('confirm_delete') ?>', function() {
            if ($('[name="sop['+id+'][id]"]').length) {
                $('[name="sop['+id+'][deleted]"]').val(1);
                $('#sop-item-table tbody tr[data-row-id="'+id+'"]').addClass('deleted').hide();
            } else {
                $('#sop-item-table tbody tr[data-row-id="'+id+'"]').remove();
            }
        });
    }
</script>
