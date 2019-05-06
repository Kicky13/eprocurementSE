<span class="checkbox-list" >
    <div id="heading-filter-po_type" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-filter-po_type" aria-expanded="false" aria-controls="accordion-filter-po_type" class="h6  collapsed"><?= lang("Type Agreement","Agreement Type")?></a>
    </div>
    <div id="accordion-filter-po_type" role="tabpanel" aria-labelledby="heading-filter-po_type" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-type" value="0"></span>
                <a href="javascript:void(0)" id="select_all-type-toggle" onclick="select_all('type')">Select All</a>
            </span>
        </label>
        <div id="filter-content-type">
            <?php foreach ($this->m_dashboard->get_po_type() as $po_type) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[type][]" value="<?= $po_type->id ?>" data-text="<?= $po_type->description ?>">
                    <span class="checkbox-label"><?= $po_type->description ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>