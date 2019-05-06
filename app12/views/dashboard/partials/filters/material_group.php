<span class="checkbox-list">
    <div id="heading-filter-material_group" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-material_group" aria-expanded="false" aria-controls="accordion-filter-material_group" class="h6  collapsed"><?= lang("Material Group", "Material Group")?></a>
    </div>
    <div id="accordion-filter-material_group" role="tabpanel" aria-labelledby="heading-filter-material_group" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-material_group" value="0"></span>
                <a href="javascript:void(0)" id="select_all-material_grouptoggle" onclick="select_all('material_group)">Select All</a>
            </span>
        </label>
        <div id="filter-content-material_group">
            <?php foreach ($this->m_dashboard->get_material_group('GOODS') as $material_group) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[material_group[]" value="<?= $material_group->ID ?>" data-text="<?= $material_group->DESCRIPTION ?>" onchange="is_filter_checked_all('material_group')">
                    <span class="checkbox-label"><?= $material_group->DESCRIPTION ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>
