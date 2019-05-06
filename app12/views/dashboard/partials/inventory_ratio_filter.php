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
        <label class="form-label"><?= lang("Kategori","Category")?></label>
        <select class="select2 form-control m-b" id="category" name="filter[category][]" tabindex="2" style="width: 100%" data-placeholder="Select All" multiple>
            <?php foreach ($this->m_dashboard->get_material_group('GOODS') as $material_group) { ?>
                <option value="<?= $material_group->ID ?>"><?= $material_group->DESCRIPTION ?></option>
            <?php } ?>
        </select>
    </div>
</div>
