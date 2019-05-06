<div style="margin-bottom: 20px">
    <div class="row">
        <div class="col-md-3">
            <div class="form-group">
                <label>Set Company</label>
                <select name="filter[company][]" id="filter-company" class="form-control" data-placeholder="All Company" multiple>
                    <?php foreach ($this->m_report->get_company() as $r_company) { ?>
                        <option value="<?= $r_company->ID_COMPANY ?>"><?= $r_company->DESCRIPTION ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label>Set Begin Date</label>
            <input type="text" name="filter[begin_date]" value="<?= date('Y-m-01') ?>" id="filter-begin_date" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Set End Date</label>
            <input type="text" name="filter[end_date]" value="<?= date('Y-m-d') ?>" id="filter-end_date" class="form-control">
        </div>
        <div class="col-md-3">
            <label>&nbsp;</label>
            <button type="button" id="btn-filter" class="form-control btn btn-info btn-flat"><i class="fa fa-search-plus"></i> Filter</button>            
        </div>
    </div>
</div>