<span class="checkbox-list">
    <div id="heading-filter-msr_status" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-msr_status" aria-expanded="false" aria-controls="accordion-filter-msr_status" class="h6  collapsed"><?= lang("Status MSR","MSR Status")?></a>
    </div>
    <div id="accordion-filter-msr_status" role="tabpanel" aria-labelledby="heading-filter-msr_status" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-status" value="0"></span>
                <a href="javascript:void(0)" id="select_all-status-toggle" onclick="select_all('status')">Select All</a>
            </span>
        </label>
        <div id="filter-content-status">
            <?php foreach ($this->m_dashboard->get_msr_status() as $status_msr) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[status][]" value="<?= $status_msr->id ?>" data-text="<?= $status_msr->description ?>" onchange="is_filter_checked_all('status')">
                    <span class="checkbox-label"><?= $status_msr->description ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>