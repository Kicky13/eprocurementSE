<div id="filter-container" style="width: 240px;">
    <div id="accordionWrapFilter" role="tablist" aria-multiselectable="true">
        <div class="card collapse-icon panel mb-0 box-shadow-0 border-0">
            <div class="card-header border-bottom-lighten-2 " style="padding-bottom: 0px;">
                <h4 class="card-title">Filter</h4>
            </div>
            <div role="tab" class="card-header">
                <button type="submit" id="btn-process" class="col-md-12 btn btn-sm btn-success" style="margin-bottom:10px;" disabled>Process</button>
                <button type="submit" id="btn-clear-filter" class="col-md-12 btn btn-sm btn-primary" onclick="clear_filter(['company', 'department', 'costcenter', 'subsidiary_account', 'status', 'type','method', 'specialist', 'years', 'months'])">Clear Selection</button>
            </div>
            <?php if (isset($filters)) { ?>
                <?php foreach($filters as $filter) { ?>
                    <?php $this->load->view('dashboard/partials/filters/'.$filter) ?>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
</div>