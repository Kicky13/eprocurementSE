<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">

<style>
body {
    font-family: "Open Sans", sans-serif;
    font-size: 14px;
    font-weight: normal;
}
</style>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Report Budget</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Report Budget", "Report Budget") ?></li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content-body">
      <section id="configuration">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="row">
              </div>
              <div class="card-content collapse show">
                <div class="card-body card-dashboard">
                  <div class="row">
                    <div class="col-md-12">
                      <h4>
                        Cost Center: <strong><?= @$costcenter->COSTCENTER_DESC ?></strong>
                      </h4>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <input type="hidden" class="form-control-plaintext" id="costcenter_id" name="costcenter_id" value="<?= $costcenter_id ?>">
                        <table id="budget_table" class="table table-condensed table-striped" width="100%">
                          <thead>
                            <tr>
                              <th data-name="accsub_id" data-data="accsub_id" rowspan="2">Acc. Subsidiary</th>
                              <th data-name="accsub_desc" data-data="accsub_desc"  rowspan="2">Acc. Subsidiary Desc.</th>
                              <th data-name="currency_desc" data-data="currency_desc"  rowspan="2">Currency</th>
                              <th colspan="5" style="text-align: center">Budget</th>
                            </tr>
                            <tr>
                              <th data-name="planned_budget" data-data="planned_budget">Planned</th>
                              <th data-name="booked_budget" data-data="booked_budget">Booked</th>
                              <th data-name="committed_budget" data-data="committed_budget">Committed</th>
                              <th data-name="actual_budget" data-data="actual_budget">Actual</th>
                              <th data-name="available_budget" data-data="available_budget">Available</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="3" style="text-align:right">Total:</th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                              <th></th>
                            </tr>
                          </tfoot>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url('ast11/assets/js/accounting.js/accounting.min.js') ?>"></script>
<script>

<?php /* TODO: where is the configuration ??? */ ?>
accounting.settings = {
  currency: {
    decimal : ".",  // decimal point separator
    thousand: ",",  // thousands separator
    precision : 2,   // decimal places
    format : "%s %v"
  },
  number: {
    precision : 2,  // default precision on numbers is 0
    thousand: ",",
    decimal : "."
  }
}

$(document).ready(function() {

$('#budget_table').DataTable({
  "scrollY"   : '50vh',
  "scrollCollapse": true,
  "paging"    : false,
  "info"      : false,
  "searching" : true,
  "ordering"  : true,
  "processing": true,
  "deferLoading": true,
  "fixedHeader": true,
  "ajax" : {
    "url" : "<?= base_url('report/budget/dataAccSubsidiary') ?>",
    "data" : function(d) {
      d.costcenter_id = $('#costcenter_id').val()
    }
  },
  "columnDefs": [
    // { "targets": [3,4,5,6,7], "createdCell": function(td, rowData, rowData, row, col) {
    //  $(td).text(accounting.format(rowData))
    //}},
    { "targets": [3,4,5,6,7], "render": $.fn.dataTable.render.number(
        accounting.settings.number.thousand,
        accounting.settings.number.decimal,
        accounting.settings.number.precision,
        '' )
    }
  ],
  "footerCallback": function(row, data, start, end, display) {
    var api = this.api(),
        data;

    // Remove the formatting to get integer data for summation
    var intVal = function(i) {
      return typeof i === 'string' ?
        i.replace(/[\$,]/g, '') * 1 :
          typeof i === 'number' ?
            i : 0;
    };

    // Total over all pages
    total_planned = api.column('planned_budget:name').data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

    total_booked = api.column('booked_budget:name').data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

    total_committed = api.column('committed_budget:name').data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

    total_actual = api.column('actual_budget:name').data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

    total_available = api.column('available_budget:name').data()
            .reduce(function(a, b) {
              return intVal(a) + intVal(b);
            }, 0);

    // Update footer
    $(api.column('planned_budget:name').footer()).html(
        accounting.format(total_planned)
    );
    $(api.column('booked_budget:name').footer()).html(
        accounting.format(total_booked)
    );
    $(api.column('committed_budget:name').footer()).html(
        accounting.format(total_committed)
    );
    $(api.column('actual_budget:name').footer()).html(
        accounting.format(total_actual)
    );
    $(api.column('available_budget:name').footer()).html(
        accounting.format(total_available)
    );
   }
});

});
</script>
