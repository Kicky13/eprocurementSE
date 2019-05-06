<span class="checkbox-list">
    <div id="heading-filter-momvement_type" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-momvement_type" aria-expanded="false" aria-controls="accordion-filter-momvement_type" class="h6  collapsed"><?= lang("Movement Type","Movement Type")?></a>
    </div>
    <div id="accordion-filter-momvement_type" role="tabpanel" aria-labelledby="heading-filter-momvement_type" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-momvement_type" value="0"></span>
                <a href="javascript:void(0)" id="select_all-momvement_type-toggle" onclick="select_all('momvement_type')">Select All</a>
            </span>
        </label>
        <div id="filter-content-momvement_type">
            <?php foreach ($this->m_dashboard->get_movement_types() as $movement_type) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[momvement_type][]" value="<?= $movement_type->id ?>" data-text="<?= $movement_type->description ?>" onchange="is_filter_checked_all('momvement_type')">
                    <span class="checkbox-label"><?= $movement_type->description ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>