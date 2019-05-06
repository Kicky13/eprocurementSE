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
        <label class="form-label"><?= lang("Movement Type","Movement Type")?></label>
        <select class="select2 form-control m-b" id="movement_type" name="filter[movement_type][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_movement_types() as $movement_type) { ?>
                <option value="<?= $movement_type->id ?>"><?= $movement_type->description ?></option>
            <?php } ?>
        </select>
    </div> 
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Requestor","Requestor")?></label>
        <select class="select2 form-control m-b" id="requestor" name="filter[requestor][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_users() as $user) { ?>
                <option value="<?= $user->ID_USER ?>"><?= $user->USERNAME . ' - ' . $user->NAME ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Kategori","Category")?></label>
        <select class="select2 form-control m-b" id="category" name="filter[category][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_material_group('GOODS') as $material_group) { ?>
                <option value="<?= $material_group->ID ?>"><?= $material_group->DESCRIPTION ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<script>
    $(function() {
        $("#filter-dashboard .select2").select2({
            dropdownCssClass: 'select2-dropdown-large select2-font-sm'
        });
        $('#company').change(function() {                       
            get_filter_department();
        });
        $('#department').change(function() {
            get_filter_users();
        })
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
                get_filter_users();           
            }
        });        
    }

    function get_filter_users() {
        $.ajax({
            url: '<?= base_url('dashboard/filter/get_users') ?>',
            data: $('#company, #department').serialize(),
            dataType: 'json',
            success: function(response) {
                $('#requestor').html('').select2({
                    data:response,
                    dropdownCssClass: 'select2-dropdown-large select2-font-sm'
                }).trigger('change');
            }
        });
    }
</script>