<div id="filter-dashboard" style="font-size: 12px !important;">
    <div class="form-group">
        <button type="submit" id="btn-process" class="col-md-12 btn btn-sm btn-success">Process</button>
    </div>
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Perusahaan","Company")?></label>
        <select class="select2 form-control m-b" id="company" name="filter[company][]" tabindex="2" style="width: 100%;" data-placeholder="Select All" multiple>            
            <?php foreach ($this->m_dashboard->get_company() as $company) { ?>
                <option value="<?= $company->ID_COMPANY ?>"><?= $company->DESCRIPTION ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Departemen","Department")?></label>
        <select class="select2 form-control m-b" id="department" name="filter[department][]" tabindex="2" style="width: 100%;" data-placeholder="Select All" multiple>            
            <?php foreach ($this->m_dashboard->get_department() as $department) { ?>
                <option value="<?= $department->ID_DEPARTMENT ?>"><?= $department->DEPARTMENT_DESC ?></option>
            <?php } ?>
        </select>        
    </div>
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Status Agreement","Agreement Status")?></label>
        <select class="select2 form-control m-b" id="status" name="filter[status][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_po_status() as $status_po) { ?>
                <option value="<?= $status_po->id ?>"><?= $status_po->description ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Type Agreement","Agreement Type")?></label>
        <select class="select2 form-control m-b" id="type" name="filter[type][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_po_type() as $type_po) { ?>
                <option value="<?= $type_po->id ?>"><?= $type_po->description ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Metode Procurement","Procurement Method")?></label>
        <select class="select2 form-control m-b" id="method" name="filter[method][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_procurement_method() as $procurement_method) { ?>
                <option value="<?= $procurement_method->ID_PMETHOD ?>"><?= $procurement_method->PMETHOD_DESC ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Procurement Specialist","Procurement Specialist")?></label>
        <select class="select2 form-control m-b" id="specialist" name="filter[specialist][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_procurement_specialist() as $procurement_specialist) { ?>
                <option value="<?= $procurement_specialist->ID_USER ?>"><?= $procurement_specialist->USERNAME ?> - <?= $procurement_specialist->NAME ?></option>
            <?php } ?>
        </select>
    </div>
    <!--<div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Kategori","Category")?></label>
        <select class="select2 form-control m-b" id="category" name="filter[category][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_material_group() as $material_group) { ?>
                <option value="<?= $material_group->ID ?>"><?= $material_group->DESCRIPTION ?></option>
            <?php } ?>
        </select>
    </div>-->
</div>

<script>
    $(function() {
        $("#filter-dashboard .select2").select2({
            dropdownCssClass: 'select2-dropdown-large select2-font-sm'
        });
        $('#company').change(function() {                       
            get_filter_department();
        });
    });

    function get_filter_department() {
        $.ajax({
            url: '<?= base_url('dashboard/filter/get_department') ?>',
            data: $('#company').serialize(),
            dataType: 'json',
            success: function(response) {
                $('#department').html('').select2({
                    data:response,
                    dropdownCssClass: 'select2-dropdown-large select2-font-sm'
                }).trigger('change');                
            }
        });        
    }
</script>