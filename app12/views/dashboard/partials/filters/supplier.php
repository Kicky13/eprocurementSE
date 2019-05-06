<span class="checkbox-list">
    <div id="heading-filter-supplier" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-supplier" aria-expanded="false" aria-controls="accordion-filter-supplier" class="h6  collapsed"><?= lang("Supplier","Supplier")?></a>
    </div>
    <div id="accordion-filter-supplier" role="tabpanel" aria-labelledby="heading-filter-supplier" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-supplier" value="0"></span>
                <a href="javascript:void(0)" id="select_all-supplier-toggle" onclick="select_all('supplier')">Select All</a>
            </span>
        </label>
        <div id="filter-content-supplier">
            <?php foreach ($this->m_dashboard->get_supplier() as $supplier) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[supplier][]" value="<?= $supplier->ID ?>" data-text="<?= $supplier->NO_SLKA .' - '.$supplier->NAMA ?>" onchange="is_filter_checked_all('supplier')">
                    <span class="checkbox-label"><?= $supplier->NO_SLKA.' - '.$supplier->NAMA ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>