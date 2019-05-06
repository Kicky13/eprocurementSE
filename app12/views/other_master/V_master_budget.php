<?php
$opt_costcenter = array('' => 'Please select') + $opt_costcenter;
?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/switch.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/forms/toggle/switchery.min.css">

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
         <h3 class="content-header-title">Master Budget</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
            <li class="breadcrumb-item active"><?= lang("Master Budget", "Master Budget") ?></li>
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
                <form id="master_budget" action="<?= base_url('other_master/budget/save') ?>" method="POST">
                  <div class="form-group row">
                    <label class="col-md-2 col-form-label">Cost Center</label>
                    <div class="col-md-4">
                      <?= form_dropdown('costcenter_id', $opt_costcenter, set_value('costcenter_id'), 'class="form-control custom-select required" id="costcenter_id"') ?>
<!--
                      <select class="form-control custom-select" id="costcenter_id" name="costcenter_id" /> -->
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="costcenter_budget_amount" class="col-md-2 col-form-label">Budget Amount</label>
                    <div class="col-md-4">
                      <input class="form-control required" id="costcenter_budget_amount" name="costcenter_budget_amount">
                      <input type="hidden" name="costcenter_budget_amount_value" id="costcenter_budget_amount_value">
                    </div>
                    <div class="col col-md-4">
                      <label for="use_accsub">Maintain Acc. Subsidiary</label>
                      <input type="checkbox" id="use_accsub" name="use_accsub" class="switch" data-switch-always="true">
                    </div>
                  </div>

                  <div class="row">
                    <div class="col-md-12">
                      <div class="table-responsive">
                        <table id="budget_table" class="table table-condensed table-striped" width="100%">
                          <thead>
                            <tr>
                              <th data-name="id_accsub" data-data="id_accsub">Acc. Subsidiary</th>
                              <th data-name="ACCSUB_DESC" data-data="ACCSUB_DESC">Acc. Subsidiary Desc.</th>
                              <th data-name="CURRENCY" data-data="CURRENCY">Currency</th>
                              <th data-name="amount" data-data="amount">Budget</th>
                            </tr>
                          </thead>
                          <tbody>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="row" style="margin-top: 10px">
                    <div class="col-md-12">
                      <button id="save-btn" type="submit" class="btn btn-primary pull-right">Save</button>
                    </div>
                  </div>
                </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div>
</div>

<script src="<?= base_url('ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js') ?>" type="text/javascript"></script>
<script src="<?= base_url('ast11/app-assets/vendors/js/forms/toggle/bootstrap-checkbox.min.js') ?>" type="text/javascript"></script>
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
//  "scrollY"   : '50vh',
  "paging"    : false,
  "info"      : false,
  "searching" : true,
  "ordering"  : true,
  "processing": true,
  "deferLoading": true,
  "deferRender": true,
  "fixedHeader": true,
  "ajax" : {
    "url" : "<?= base_url('other_master/budget/dataBudget') ?>",
    "data" : function(d) {
      d.costcenter_id = $('#costcenter_id').val()
    }
  },
  "columnDefs": [
    // { "targets": [3,4,5,6,7], "createdCell": function(td, rowData, rowData, row, col) {
    //  $(td).text(accounting.format(rowData))
    //}},
    { "targets": [3],
      "render": function(data, type, row, meta) {
        if (type === 'display') {
          return '<input class="budget_amount" data-accsub_id="'+ row.id_accsub+'" value="'+ accounting.format(row.amount) +'">'
          + '<input id="accsub_budget-'+ row.id_accsub +'" name="accsub_budget['+ row.id_accsub+']" type="hidden" value="'+ row.amount +'">';
        } 

        return row.amount;
      }
    }
  ],
})
.on('xhr', function(e, settings, data) {
  if (data) {
    var costcenter_budget = data.costcenter_budget.amount ? data.costcenter_budget.amount : 0;
    $('#costcenter_budget_amount').val(accounting.format(costcenter_budget)).trigger('change');

    if (data.is_accsub_maintained) {
      $('#use_accsub').prop('checked', true)
    } else {
      $('#use_accsub').prop('checked', false)
    }

    $('#use_accsub').closest('.col').show()
  }
})

$('#costcenter_id').change(function(e) {
  $('#use_accsub').prop('checked', false);

  if ($(this).val() == '') {
    $('#use_accsub').closest('.col').hide()
    $('#budget_table').DataTable().clear().draw()
    $('#costcenter_budget_amount').val(accounting.format(0)).trigger('change');
  } else {
  //  $('#use_accsub').closest('.col').show()
    $('#budget_table').DataTable().ajax.reload().draw()
    $('#save-btn').show()
  }

  $('#budget_table').closest('.row').hide()
})

$('#use_accsub').checkboxpicker()
$('#use_accsub').on('change', function() {
  if ($(this).prop("checked")) {
    $('#budget_table').closest('.row').show();
    $('#costcenter_budget_amount').attr('readonly', true)
//    $('#budget_table').DataTable().ajax.reload().draw()
  } else {
    $('#budget_table').closest('.row').hide();
    $('#costcenter_budget_amount').attr('readonly', false)

    // reset amount to 0
    $('#budget_table').DataTable()
        .column(3)
        .nodes()
        .each(function(td) {
          $(td).find('input').val(accounting.format(0)) 
        })

    $('#costcenter_budget_amount').val(accounting.format(0)).trigger('change');
  }
})

/*
$('#save-btn').click(function(e) {
  $('#master_budget').submit()
})
*/

$('#budget_table').on('change', '.budget_amount', function() {
  var original_value = $(this).val()

  $(this).val(accounting.format(original_value))
  var costcenter_budget = $('#budget_table').DataTable()
        .column(3)
        .nodes()
        .reduce(function(accum, td) {
          return accum + accounting.parse($(td).find('input').val())
        }, 0)
  
    $('#costcenter_budget_amount').val(accounting.format(costcenter_budget)).trigger('change');

   // mirror the data
   $('#accsub_budget-' + $(this).data('accsub_id')).val(original_value)
})

$('#master_budget').submit(function(e) {

  var form = $(this)

  $('#save-btn').attr('disabled', true)

  $.ajax({
    url: this.action,
    method: "POST",
    data: form.serialize()
  })
  .done(function(data) {
    if (data.status == 'success') {
      $('#budget_table').DataTable().ajax.reload().draw()
      alert('Saved');
    }
  })
  .fail(function(error) {
    alert(error)     
  })
  .always(function() {
    $('#save-btn').attr('disabled', false)
  })


  e.preventDefault()
  return false
})


// initialize
if ($('#costcenter_id').val() == '') {
  $('#use_accsub').closest('.col').hide()
  $('#budget_table').DataTable().clear().draw()
  $('#costcenter_budget_amount').val(accounting.format(0)).trigger('change');
  $('#save-btn').hide();
} else {
  $('#use_accsub').closest('.col').show()
  $('#budget_table').DataTable().ajax.reload().draw()
}

$('#costcenter_budget_amount').change(function() {
  var original_value = $(this).val()
  $(this).val(accounting.format(original_value))

  $('#costcenter_budget_amount_value').val(accounting.parse(original_value));
})

$('#budget_table').closest('.row').hide()

})

</script>
