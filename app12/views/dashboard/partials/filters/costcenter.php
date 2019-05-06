<span class="checkbox-list">
    <div id="heading-filter-costcenter" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-costcenter" aria-expanded="false" aria-controls="accordion-filter-costcenter" class="h6  collapsed"><?= lang("Costcenter","Costcenter")?></a>
    </div>
    <div id="accordion-filter-costcenter" role="tabpanel" aria-labelledby="heading-filter-costcenter" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-costcenter" value="0"></span>
                <a href="javascript:void(0)" id="select_all-costcenter-toggle" onclick="select_all('costcenter')">Select All</a>
            </span>
        </label>
        <div id="filter-content-costcenter">
            <?php foreach ($this->m_dashboard->get_costcenter() as $costcenter) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[costcenter][]" value="<?= $costcenter->ID_COSTCENTER ?>" data-text="<?= $costcenter->COSTCENTER_DESC ?>" onchange="is_filter_checked_all('costcenter');">
                    <span class="checkbox-label"><?= $costcenter->ID_COSTCENTER ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>
