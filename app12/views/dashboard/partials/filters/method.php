<span class="checkbox-list">
    <div id="heading-filter-method" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-method" aria-expanded="false" aria-controls="accordion-filter-method" class="h6  collapsed"><?= lang("Metode Procurement","Procurement Method")?></a>
    </div>
    <div id="accordion-filter-method" role="tabpanel" aria-labelledby="heading-filter-method" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-method" value="0"></span>
                <a href="javascript:void(0)" id="select_all-method-toggle" onclick="select_all('method')">Select All</a>
            </span>
        </label>
        <div id="filter-content-method">
            <?php foreach ($this->m_dashboard->get_procurement_method() as $procurement_method) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[method][]" value="<?= $procurement_method->ID_PMETHOD ?>" data-text="<?= $procurement_method->PMETHOD_DESC ?>" onchange="is_filter_checked_all('method')">
                    <span class="checkbox-label"><?= $procurement_method->PMETHOD_DESC ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>