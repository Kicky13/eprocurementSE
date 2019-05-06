<span class="checkbox-list">
    <div id="heading-filter-months" role="tab" class="card-header checkbox-item-list">
        <a data-toggle="collapse" data-parent="#accordionWrapFilter" href="#accordion-filter-months" aria-expanded="false" aria-controls="accordion-filter-months" class="h6  collapsed"><?= lang("Bulan","Months")?></a>
    </div>
    <div id="accordion-filter-months" role="tabpanel" aria-labelledby="heading-filter-months" class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
        <label class="custom-control ">
            <span class="checkbox-label">
                <input type="hidden" id="select_all-months" value="0"></span>
                <a href="javascript:void(0)" id="select_all-months-toggle" onclick="select_all('months')">Select All</a>
            </span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="01" name="filter[months][]" data-text="Jan" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Jan</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="02" name="filter[months][]" data-text="Feb" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Feb</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="03" name="filter[months][]" data-text="Mar" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Mar</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="04" name="filter[months][]" data-text="Apr" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Apr</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="05" name="filter[months][]" data-text="May" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">May</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="06" name="filter[months][]" data-text="Jun" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Jun</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="07" name="filter[months][]" data-text="Jul" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Jul</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="08" name="filter[months][]" data-text="Aug" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Aug</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="09" name="filter[months][]" data-text="Sep" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Sep</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="10" name="filter[months][]" data-text="Oct" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Oct</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="11" name="filter[months][]" data-text="Nov" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Nov</span>
        </label>
        <label class="custom-control">
            <input type="checkbox" value="12" name="filter[months][]" data-text="Dec" onchange="is_filter_checked_all('months')" checked>
            <span class="checkbox-label">Dec</span>
        </label>
    </div>
</span>