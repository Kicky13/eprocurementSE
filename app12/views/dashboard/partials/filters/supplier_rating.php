<span class="checkbox-list">
    <div id="heading-filter-supplier_rating" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-supplier_rating" aria-expanded="false" aria-controls="accordion-filter-supplier_rating" class="h6  collapsed"><?= lang("Supplier Rating","Supplier Rating")?></a>
    </div>
    <div id="accordion-filter-supplier_rating" role="tabpanel" aria-labelledby="heading-filter-supplier_rating" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-supplier_rating" value="0"></span>
                <a href="javascript:void(0)" id="select_all-supplier_rating-toggle" onclick="select_all('supplier_rating')">Select All</a>
            </span>
        </label>
        <div id="filter-content-supplier_rating">
            <?php foreach ($this->m_dashboard->get_supplier_rating() as $supplier_rating) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[supplier_rating][]" value="<?= $supplier_rating->id ?>" data-text="<?= $supplier_rating->description ?>" onchange="is_filter_checked_all('supplier_rating')">
                    <span class="checkbox-label"><?= $supplier_rating->description ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>