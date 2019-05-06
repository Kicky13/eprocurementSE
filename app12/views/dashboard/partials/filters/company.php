<span class="checkbox-list">
    <div id="heading-filter-company" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-company" aria-expanded="false" aria-controls="accordion-filter-company" class="h6  collapsed"><?= lang("Perusahaan","Company")?></a>
    </div>
    <div id="accordion-filter-company" role="tabpanel" aria-labelledby="heading-filter-company" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-company" value="0"></span>
                <a href="javascript:void(0)" id="select_all-company-toggle" onclick="select_all('company')">Select All</a>
            </span>
        </label>
        <div id="filter-content-company">
            <?php foreach ($this->m_dashboard->get_company() as $company) { ?>
                <label class="custom-control ">
                    <input type="checkbox" id="company" name="filter[company][]" value="<?= $company->ID_COMPANY ?>" data-text="<?= $company->DESCRIPTION ?>" onchange="is_filter_checked_all('company'), get_filter_department()">
                    <span class="checkbox-label"><?= $company->DESCRIPTION ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>