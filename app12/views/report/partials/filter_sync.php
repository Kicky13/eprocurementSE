<div style="margin-bottom: 20px">
    <div class="row">
        <div class="col-md-6">
            <div class="form-group">
                <label>Set Document</label>
                <select name="filter[doc_type]" id="filter-doc_type" class="form-control" data-placeholder="All Document" multiple>
                    <?php foreach ($this->m_report->get_sync_doc() as $r_sync_doc) { ?>
                        <option value="<?= $r_sync_doc->doc ?>"><?= $r_sync_doc->doc ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Set Status</label>
                <select name="filter[isclosed]" id="filter-isclosed" class="form-control" data-placeholder="All Document">                    
                    <option value="">All Status</option>                    
                    <option value="1">Finished</option>                    
                    <option value="0">Unfinished</option>                    
                </select>
            </div>
        </div>
        <div class="col-md-3">
            <label>Set Begin Date</label>
            <input type="text" name="filter[begin_date]" id="filter-begin_date" class="form-control">
        </div>
        <div class="col-md-3">
            <label>Set End Date</label>
            <input type="text" name="filter[end_date]" id="filter-end_date" class="form-control">
        </div>
        <div class="col-md-6">
            <label>&nbsp;</label>
            <button type="button" id="btn-filter" class="form-control btn btn-info btn-flat"><i class="fa fa-search-plus"></i> Filter</button>            
        </div>
    </div>
</div>