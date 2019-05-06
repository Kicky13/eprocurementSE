<span class="checkbox-list">
    <div id="heading-filter-subsidiary_account" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-subsidiary_account" aria-expanded="false" aria-controls="accordion-filter-subsidiary_account" class="h6  collapsed"><?= lang("Subsidiary Account","Subsidiary Account")?></a>
    </div>
    <div id="accordion-filter-subsidiary_account" role="tabpanel" aria-labelledby="heading-filter-subsidiary_account" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-subsidiary_account" value="0"></span>
                <a href="javascript:void(0)" id="select_all-subsidiary_account-toggle" onclick="select_all('subsidiary_account')">Select All</a>
            </span>
        </label>
        <div id="filter-content-subsidiary_account">
            <?php foreach ($this->m_dashboard->get_accsub() as $subsidiary_account) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[subsidiary_account][]" value="<?= $subsidiary_account->ID_ACCSUB ?>" data-text="<?= $subsidiary_account->ACCSUB_DESC ?>" onchange="is_filter_checked_all('subsidiary_account');">
                    <span class="checkbox-label"><?= $subsidiary_account->ID_ACCSUB ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>
