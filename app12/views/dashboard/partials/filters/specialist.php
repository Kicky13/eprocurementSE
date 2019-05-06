<span class="checkbox-list" >
    <div id="heading-filter-specialist" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-specialist" aria-expanded="false" aria-controls="accordion-filter-specialist" class="h6  collapsed"><?= lang("Procurement Specialist","Procurement Specialist")?></a>
    </div>
    <div id="accordion-filter-specialist" role="tabpanel" aria-labelledby="heading-filter-specialist" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-specialist" value="0"></span>
                <a href="javascript:void(0)" id="select_all-specialist-toggle" onclick="select_all('specialist')">Select All</a>
            </span>
        </label>
        <div id="filter-content-specialist">
            <?php foreach ($this->m_dashboard->get_procurement_specialist() as $procurement_specialist) { ?>
                <label class="custom-control ">
                    <input type="checkbox" id="specialist" name="filter[specialist][]" value="<?= $procurement_specialist->ID_USER ?>" data-text="<?= $procurement_specialist->NAME ?>">
                    <span class="checkbox-label"><?= $procurement_specialist->USERNAME ?> - <?= $procurement_specialist->NAME ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>