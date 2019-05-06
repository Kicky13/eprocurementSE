<span class="checkbox-list">
    <div id="heading-filter-supplier_classification" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-supplier_classification" aria-expanded="false" aria-controls="accordion-filter-supplier_classification" class="h6  collapsed"><?= lang("Supplier Classification","Supplier Classification")?></a>
    </div>
    <div id="accordion-filter-supplier_classification" role="tabpanel" aria-labelledby="heading-filter-supplier_classification" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-supplier_classification" value="0"></span>
                <a href="javascript:void(0)" id="select_all-supplier_classification-toggle" onclick="select_all('supplier_classification')">Select All</a>
            </span>
        </label>
        <div id="filter-content-supplier_classification">
            <?php foreach ($this->m_dashboard->get_supplier_classification() as $supplier_classification) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[supplier_classification][]" value="<?= $supplier_classification->DESCRIPTION ?>" data-text="<?= $supplier_classification->DESCRIPTION ?>" onchange="is_filter_checked_all('supplier_classification')">
                    <span class="checkbox-label"><?= $supplier_classification->DESCRIPTION ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>