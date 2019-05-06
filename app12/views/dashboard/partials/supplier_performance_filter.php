<div id="filter-dashboard" style="font-size: 12px !important;">
    <div class="form-group">
        <button type="submit" id="btn-process" class="col-md-12 btn btn-sm btn-success">Process</button>
    </div>
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Supplier Rating","Supplier Rating")?></label>
        <select class="select2 form-control m-b" id="rating" name="filter[rating][]" tabindex="2" style="width: 100%;" data-placeholder="Select All" multiple>            
            <?php foreach ($this->m_dashboard->get_supplier_rating() as $supplier_rating) { ?>
                <option value="<?= $supplier_rating->id ?>"><?= $supplier_rating->description ?></option>
            <?php } ?>
        </select>
    </div>    
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("Supplier Category","Supplier Category")?></label>
        <select class="select2 form-control m-b" id="classification" name="filter[classification][]" tabindex="2" style="width: 100%;" data-placeholder="Select All" multiple>            
            <?php foreach ($this->m_dashboard->get_supplier_classification() as $supplier_classification) { ?>
                <option value="<?= $supplier_classification->DESCRIPTION ?>"><?= $supplier_classification->DESCRIPTION ?></option>
            <?php } ?>
        </select>
    </div>    
    <div class="row form-group col-md-12">
        <label class="form-label"><?= lang("SLKA No","SLKA No")?></label>
        <select class="select2 form-control m-b" id="supplier" name="filter[supplier][]" tabindex="2" style="width: 100%;" data-placeholder="Select All" multiple>            
            <?php foreach ($this->m_dashboard->get_supplier() as $supplier) { ?>
                <option value="<?= $supplier->ID ?>"><?= $supplier->NO_SLKA.' - '.$supplier->NAMA ?></option>
            <?php } ?>
        </select>
    </div>    
</div>