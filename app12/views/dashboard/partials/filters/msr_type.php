<span class="checkbox-list">
    <div id="heading-filter-msr_type" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-msr_type" aria-expanded="false" aria-controls="accordion-filter-msr_type" class="h6  collapsed"><?= lang("Type MSR","MSR Type")?></a>
    </div>
    <div id="accordion-filter-msr_type" role="tabpanel" aria-labelledby="heading-filter-msr_type" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-type" value="0"></span>
                <a href="javascript:void(0)" id="select_all-type-toggle" onclick="select_all('type')">Select All</a>
            </span>
        </label>
        <div id="filter-content-type">
            <?php foreach ($this->m_dashboard->get_msr_type() as $type_msr) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[type][]" value="<?= $type_msr->ID_MSR ?>" data-text="<?= $type_msr->MSR_DESC ?>" onchange="is_filter_checked_all('type')">
                    <span class="checkbox-label"><?= $type_msr->MSR_DESC ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>