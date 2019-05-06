<span class="checkbox-list">
    <div id="heading-filter-user" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-user" aria-expanded="false" aria-controls="accordion-filter-user" class="h6  collapsed"><?= lang("User","User")?></a>
    </div>
    <div id="accordion-filter-user" role="tabpanel" aria-labelledby="heading-filter-user" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-user" value="0">
                <a href="javascript:void(0)" id="select_all-usertoggle" onclick="select_all('user)">Select All</a>
            </span>
        </label>
        <div id="filter-content-user">
            <?php foreach ($this->m_dashboard->get_users() as $user) { ?>
                <label class="custom-control ">
                    <input type="checkbox" name="filter[user[]" value="<?= $user->ID_USER ?>" data-text="<?= $user->USERNAME . ' - ' . $user->NAME ?>" onchange="is_filter_checked_all('user')">
                    <span class="checkbox-label"><?= $user->USERNAME . ' - ' . $user->NAME ?></span>
                </label>
            <?php } ?>
        </div>
    </div>
</span>