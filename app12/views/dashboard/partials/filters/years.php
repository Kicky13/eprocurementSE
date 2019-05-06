<span class="checkbox-list">
    <div id="heading-filter-years" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-years" aria-expanded="false" aria-controls="accordion-filter-years" class="h6  collapsed">Year</a>
    </div>
    <div id="accordion-filter-years" role="tabpanel" aria-labelledby="heading-filter-years" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-years" value="0"></span>
                <a href="javascript:void(0)" id="select_all-years-toggle" onclick="select_all('years')">Select All</a>
            </span>
        </label>
        <div id="filter-content-years">
            <?php for($i = date('Y'); $i>=2007; $i--) { ?>
                <label class="custom-control ">
                    <input type="checkbox" value="<?= $i ?>" name="filter[years][]" <?= ($i==date('Y')) ? 'checked' : '' ?> data-text="<?= $i ?>" onchange="is_filter_checked_all('years')">
                    <span class="checkbox-label"><?= $i ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>