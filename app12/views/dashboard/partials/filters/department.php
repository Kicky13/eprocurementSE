<span class="checkbox-list">
    <div id="heading-filter-department" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-department" aria-expanded="false" aria-controls="accordion-filter-department" class="h6  collapsed"><?= lang("Departemen","Department")?></a>
    </div>
    <div id="accordion-filter-department" role="tabpanel" aria-labelledby="heading-filter-department" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-department" value="0"></span>
                <a href="javascript:void(0)" id="select_all-department-toggle" onclick="select_all('department')">Select All</a>
            </span>
        </label>
        <div id="filter-content-department">
            <?php foreach ($this->m_dashboard->get_department() as $department) { ?>
                <label class="custom-control ">
                    <input type="checkbox" id="department" name="filter[department][]" value="<?= $department->ID_DEPARTMENT ?>" data-text="<?= $department->DEPARTMENT_DESC ?>" onchange="is_filter_checked_all('department'), get_filter_costcenter()">
                    <span class="checkbox-label"><?= $department->DEPARTMENT_DESC ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>
