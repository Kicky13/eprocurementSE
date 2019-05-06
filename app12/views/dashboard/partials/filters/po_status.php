<span class="checkbox-list" >
    <div id="heading-filter-po_status" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrap1" href="#accordion-filter-po_status" aria-expanded="false" aria-controls="accordion-filter-po_status" class="h6  collapsed"><?= lang("Status Agreement","Agreement Status")?></a>
    </div>
    <div id="accordion-filter-po_status" role="tabpanel" aria-labelledby="heading-filter-po_status" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-status" value="0"></span>
                <a href="javascript:void(0)" id="select_all-status-toggle" onclick="select_all('status')">Select All</a>
            </span>
        </label>
        <div id="filter-content-type">
            <?php foreach ($this->m_dashboard->get_po_status() as $po_status) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[status][]" value="<?= $po_status->id ?>" data-text="<?= $po_status->description ?>">
                    <span class="checkbox-label"><?= $po_status->description ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>