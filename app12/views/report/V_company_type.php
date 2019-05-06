<?php $this->load->view('report/partials/filter_script');
$url_type = '_'.strtolower($doc_type).'/'; ?>
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<div class="app-content content">
  <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-1">
              <h3 class="content-header-title"><?= lang("Report", "Report") ?></h3>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
              <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                      <li class="breadcrumb-item active"><?= lang("Laporan", "Report") ?></li>
                      <li class="breadcrumb-item active"><?= lang(strtoupper($doc_type)." - Company Type", strtoupper($doc_type)." - Company Type") ?></li>
                  </ol>
              </div>
          </div>
      </div>

      <!-- section tabel -->
      <div class="content-body">
        <section id="configuration">
          <div class="row">
              <div class="col-md-12">
                  <div class="card">
                      <div class="card-content collapse show">
                          <div class="card-body card-dashboard">

                          <form id="filter_laporan">
                            <div class="row">
                              <div class="col-xl-3 col-lg-12">
                                <fieldset>
                                  <h5>Set Company</h5>
                                  <div class="form-group">
                                    <select class="select2 form-control" multiple="multiple" required name="filter_company" id="filter_company">
                                    <?php foreach ($company->result_array() as $key => $val) { ?>
                                        <option value="<?= $val['ID_COMPANY']?>"> <?= $val['DESCRIPTION'].", "?> </option>
                                    <?php } ?>
                                     </select>
                                  </div>
                                </fieldset>
                              </div>
                              <div class="col-xl-3 col-lg-12">
                                <fieldset>
                                  <h5>Begin Date</h5>
                                  <div class="form-group">
                                    <input required type="text" name="filter_start_date" id="filter_start_date" class="datepicker form-control" value="">
                                  </div>
                                </fieldset>
                              </div>
                              <div class="col-xl-3 col-lg-12">
                                <fieldset>
                                  <h5>End Date</h5>
                                  <div class="form-group">
                                    <input required type="text" name="filter_end_date" id="filter_end_date" class="datepicker form-control" value="">
                                  </div>
                                </fieldset>
                              </div>
                              <div class="col-xl-3 col-lg-12">
                                <fieldset>
                                  <h5>&nbsp;</h5>
                                  <div class="form-group">
                                    <button type="submit" name="button" class="form-control btn btn-info btn-flat"> <i class="fa fa-search-plus"></i> Filter</button>
                                  </div>
                                </fieldset>
                              </div>
                            </div>
                          </form>
                          <input type="hidden" id="sum_base" value="0">
                          <div class="row">
                              <div class="col-md-12">
                                  <table id="tbl_laporan" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                    <thead>
                                      <tr>
                                        <th style="text-align: center;" rowspan="2">Index</th>
                                        <th style="text-align: center;" rowspan="2">Procurement value</th>
                                        <th style="text-align: center;" rowspan="2">Number Procurement Process</th>
                                        <th style="text-align: center;" colspan="2">Agreement Value</th>
                                        <th style="text-align: center;" rowspan="2">% Local Content</th>
                                        <th style="text-align: center;" rowspan="2">Action</th>
                                      </tr>
                                      <tr>
                                        <th style="text-align: center;">USD</th>
                                        <th style="text-align: center;">%</th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                  </table>
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



<!-- modal detail -->
<div id="modal_report_detail" class="modal fade" data-backdrop="static" role="dialog">
   <div class="modal-dialog modal-xl">
      <div class=" modal-content">
         <div class="modal-header">
            <h4 class="modal-title" id="myModalLabel1"></h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
            </button>
         </div>
         <div class="modal-body">
            <div class="row">
               <div class="col-md-12">
                  <div class="card-content">
                     <div class="card-body">
                        <h1><b>PROCUREMENT LIST - <?= strtoupper($doc_type) ?></b></h1>
                     </div>
                  </div>
               </div>
            </div>
            <div class="row">
               <div class="col-md-12">
                  <div class="app-content">
                    <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->
                   <div class="content-wrapper">
                     <div class="row">
                         <div class="col-md-12">
                           <form id="filter_laporan_detail">
                             <div class="row">
                               <div class="col-xl-3 col-lg-12">
                                 <fieldset>
                                   <h5>Set Company</h5>
                                   <div class="form-group">
                                     <select class="select2 form-control" multiple="multiple" required name="filter_company_detail[]" id="filter_company_detail">
                                     <?php foreach ($company->result_array() as $key => $val) { ?>
                                         <option value="<?= $val['ID_COMPANY']?>"> <?= $val['DESCRIPTION'].", "?> </option>
                                     <?php } ?>
                                      </select>
                                   </div>
                                 </fieldset>
                               </div>
                               <div class="col-xl-3 col-lg-12">
                                 <fieldset>
                                   <h5>Begin Date</h5>
                                   <div class="form-group">
                                     <input required type="text" name="filter_start_date_detail" id="filter_start_date_detail" class="datepicker form-control" value="">
                                   </div>
                                 </fieldset>
                               </div>
                               <div class="col-xl-3 col-lg-12">
                                 <fieldset>
                                   <h5>End Date</h5>
                                   <div class="form-group">
                                     <input required type="text" name="filter_end_date_detail" id="filter_end_date_detail" class="datepicker form-control" value="">
                                   </div>
                                 </fieldset>
                               </div>
                               <div class="col-xl-3 col-lg-12">
                                 <fieldset>
                                   <h5>&nbsp;</h5>
                                   <div class="form-group">
                                     <button type="submit" name="button" class="form-control btn btn-info btn-flat"> <i class="fa fa-search-plus"></i> Filter</button>
                                   </div>
                                 </fieldset>
                               </div>
                             </div>
                           </form>

                           <div class="table-responsive">
                             <table id="tbl_laporan_detail" class="table table-striped table-bordered order-column dataex-lr-fixedcolumns table-hover display" style="width: 50%;">
                               <thead>
                                 <tr>
                                   <th style="text-align: center;" rowspan="2">Index</th>
                                   <th style="text-align: center;" rowspan="2">Agreement Number</th>
                                   <th style="text-align: center;" rowspan="2">Agreement Subject</th>
                                   <th style="text-align: center;" rowspan="2">Commodity Type</th>
                                   <th style="text-align: center;" rowspan="2">Procurement Method</th>
                                   <th style="text-align: center;" rowspan="2">Procurement Location</th>
                                   <th style="text-align: center;" colspan="3">Vendor</th>
                                   <th style="text-align: center;" colspan="2">Agreement Period</th>
                                   <th style="text-align: center;" rowspan="2">EE (USD)</th>
                                   <th style="text-align: center;" colspan="4">Agreement Value</th>
                                   <th style="text-align: center;" rowspan="2">Cost Component Goods/Services (USD)</th>
                                   <th style="text-align: center;" rowspan="2">Local Content Commitment (%)</th>
                                 </tr>
                                 <tr>
                                   <th style="text-align: center;">Name</th>
                                   <th style="text-align: center;">Company Type</th>
                                   <th style="text-align: center;">Company Qualification</th>
                                   <th style="text-align: center;">Agreement Date</th>
                                   <th style="text-align: center;">Delivery Date / Expiry Date</th>
                                   <th style="text-align: center;">Currency</th>
                                   <th style="text-align: center;">Value</th>
                                   <th style="text-align: center;">Currency Rate to USD</th>
                                   <th style="text-align: center;">Value USD</th>
                                 </tr>
                               </thead>
                               <tbody>

                               </tbody>
                             </table>
                           </div>

                         </div>
                     </div>
                   </div>
                  <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->
                  </div>
                  <div class="modal-footer">
                     <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                  </div>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<!-- modal detail -->

<script type="text/javascript">
var url_type = '<?= $url_type ?>';
var proc_type = '<?= strtoupper($doc_type) ?>';
$(document).ready(function() {
  var dt_sumbase = [];
  $('select').select2({width: "100%", placeholder: "Please Select"});
  $( ".datepicker" ).pickadate();

  // $( ".datepicker_start_date" ).datepicker();

  $("#filter_laporan").on("submit", function(e){
  e.preventDefault();
  $('#tbl_laporan').DataTable().ajax.reload(null, false);

  })

  $("#tbl_laporan").DataTable({
    ordering: false,
    processing: true,
    serverSide: true,
    responsive: false,
    pageLength: 10,
    searching: false,
    paging: false,
    bDestroy: true,
    bJQueryUI: true,
    rowReorder: {
      selector: 'td:nth-child(2)'
    },
    ajax: {
      url: '<?= base_url('report/Company_type/send_datatable') ?>'+url_type,
      type:'POST',
      data: function(d){
        d.filter_start_date = $("#filter_start_date").val();
        d.filter_end_date = $("#filter_end_date").val();
        d.filter_company = $("#filter_company").val();
        dt_sumbase = [];
      },
      error: function(){
        $(".employee-grid-error").html("");
        $("#tbl_laporan").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data tidak ditemukan</th></tr></tbody>');
        $("#employee-grid_processing").css("display","none");
      },
      // success: function(res){
      //   console.log(res.sum_base);
      //   $("#sum_base").val(res.sum_base);
      // },
    },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
      if ( aData[1] == null)
      {
        console.log(aData);
        $('td', nRow).css('background-color', '#009688');
      }
    },
    "aoColumns": [
      {
        "mData": "0",
        "mRender": function ( data, type, row ) {
          return "<b>"+data+"</b>";
        }
      },
      {
        "mData": "1",
        "mRender": function ( data, type, row ) {
          return "<b>"+data+"</b>";
        }
      },
      {
        "mData": "2",
        "mRender": function ( data, type, row ) {
          return "<b>"+data+"</b>";
        }
      },
      {
        "mData": "3",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "4",
        "mRender": function ( data, type, row, full ) {
          var count_response = parseInt(full.settings.json.sum_base);
          var sum_base = (parseInt(data) / parseInt(count_response)) * 100;
          if (isNaN(sum_base) == true) {
            sum_base = 0;
          }
          return sum_base+"  %";
        }
      },
      {
        "mData": "5",
        "mRender": function ( data, type, row, full ) {
          var count_response = parseInt(full.settings.json.sum_base);
          var sum_base = (parseInt(data) / parseInt(count_response)) * 100;
          if (isNaN(sum_base) == true) {
            sum_base = 0;
          }
          return parseInt(sum_base)+"  %";
        }
      },
      {
        "mData": "6",
        "mRender": function ( data, type, row, full ) {
         var button_del = "";
         var button_detail = "";

         var splitdata = data.split("|");
         console.log(data);
           if (splitdata[1] == 0) {
             button_detail = " - ";
           } else {
             button_detail = '<button type="button" data-id="'+splitdata[0]+'" data-toggle="modal" data-target="#modal_report_detail" class="btn btn-sm btn-primary btn-flat" id="btn_detail" name="button">Detail</button>';
           }
           button_del = '<button type="button" data-id="'+splitdata[0]+'" data-toggle="modal" data-target="#modal_report_detail" class="btn btn-sm btn-primary btn-flat" id="btn_detail" name="button">Detail</button>';


         return "<p class='text-center'> "+button_detail+"</p>";
       }
      },

    ],
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excel',
        text: 'Excel',
        title: 'Excel_Export_Title',
        filename: 'Report Company Type ('+proc_type+')',
        exportOptions: {
          columns: [ 0, 1, 2, 3, 4 ]
        },
        customize: function (xlsx) {
          console.log(xlsx);
          var sheet = xlsx.xl.worksheets['sheet1.xml'];
          var downrows = 4;
          var clRow = $('row', sheet);
          //update Row
          clRow.each(function () {
              var attr = $(this).attr('r');
              var ind = parseInt(attr);
              ind = ind + downrows;
              $(this).attr("r",ind);
          });

          // Update  row > c
          $('row c ', sheet).each(function () {
              var attr = $(this).attr('r');
              var pre = attr.substring(0, 1);
              var ind = parseInt(attr.substring(1, attr.length));
              ind = ind + downrows;
              $(this).attr("r", pre + ind);
          });

          function Addrow(index,data) {
            msg='<row r="'+index+'">'
            for(i=0;i<data.length;i++){
                var key=data[i].k;
                var value=data[i].v;
                msg += '<c t="inlineStr" r="' + key + index + '" s="0">';
                msg += '<is>';
                msg +=  '<t>'+value+'</t>';
                msg+=  '</is>';
                msg+='</c>';
            }
            msg += '</row>';
            return msg;
        }

          //insert
          var r1 = Addrow(1, [{ k: 'A', v: 'Report Company Type ('+proc_type+')' }, { k: 'B', v: '' }, { k: 'C', v: '' },  ]);
          var r2 = Addrow(2, [{ k: 'A', v: '' }, { k: 'B', v: 'Company' }, { k: 'C', v: $("#filter_company option:selected").text() }, ]);
          var r3 = Addrow(3, [{ k: 'A', v: '' }, { k: 'B', v: 'Begin Date' },{ k: 'C', v: $("#filter_start_date").val() }, ]);
          var r4 = Addrow(4, [{ k: 'A', v: '' }, { k: 'B', v: 'End Date' },{ k: 'C', v: $("#filter_end_date").val() }, ]);
          var r5 = Addrow(5, [{ k: 'A', v: '' }, { k: 'B', v: '' },{ k: 'C', v: '' }, ]);

          sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2+ r3+ r4 + r5 + sheet.childNodes[0].childNodes[1].innerHTML;
        },
      },
      {
          text: 'PDF',
          extend: 'pdfHtml5',
          title : 'Report Company Type ('+proc_type+')',
          filename: 'Report Company Type ('+proc_type+')',
          exportOptions: {
            columns: [ 0, 1, 2, 3, 4 ]
          },
          customize: function (doc) {
              doc.pageMargins = [20,60,20,30];
              doc.defaultStyle.alignment = 'center';
              doc.defaultStyle.fontSize = 14;
              doc.styles.tableHeader.fontSize = 16;
              var rowCount = doc.content[1].table.body.length;
              for (i = 1; i < rowCount; i++) {
                  doc.content[1].table.body[i][2].alignment = 'center';
                  doc.content[1].table.body[i][3].alignment = 'center';
                  doc.content[1].table.body[i][4].alignment = 'center';
              };
              doc['header']=(function(page) {
                  var filter_company = $("#filter_company option:selected").text();
                  var filter_begin_date = $('#filter_start_date').val();
                  var filter_end_date = $('#filter_end_date').val();

                  headerText = [];
                  headerText.push('Company : '+filter_company);
                  if (filter_begin_date != '') {
                      headerText.push('Begin Date : '+filter_begin_date);
                  }
                  if (filter_end_date != '') {
                      headerText.push('End Date : '+filter_end_date);
                  }
                  headerText.push('Creation Date : '+ Localization.humanDatetime(new Date()));
                  if (page == 1) {
                      return {
                          columns : [
                              {
                                  alignment: 'left',
                                  text: headerText.join("\n"),
                                  margin: [20, 20]
                              }
                          ]
                      }
                  }
              });
          }
      },
    ]
  });

  $("#filter_laporan_detail").on("submit", function(ee){
    ee.preventDefault();
    $('#tbl_laporan_detail').DataTable().ajax.reload(null, false);
  })

  $(document).on('show.bs.modal', '#modal_report_detail', function(e) {

    var idnya = $(e.relatedTarget).data("id");
    get_detail(idnya);
    // $('#tbl_laporan_detail').DataTable().ajax.reload(null, false);
    console.log(idnya);

  });

} );

function get_detail(idnya){
  $("#tbl_laporan_detail").DataTable({
    ordering: false,
    processing: true,
    serverSide: true,
    responsive: false,
    pageLength: 10,
    searching: false,
    paging: true,
    bDestroy: true,
    bJQueryUI: true,
    scrollY: "300px",
    scrollX: true,
    scrollCollapse: true,
    fixedColumns:   {
      leftColumns: 2,
      rightColumns: 0
    },
    rowReorder: {
      selector: 'td:nth-child(2)'
    },
    ajax: {
      url: '<?= base_url('report/Company_type/send_datatable_detail') ?>'+url_type+idnya,
      type:'POST',
      data: function(d){
        d.filter_start_date_detail = $("#filter_start_date_detail").val();
        d.filter_end_date_detail = $("#filter_end_date_detail").val();
        d.filter_company_detail = $("#filter_company_detail").val();
      },
      error: function(){
          $(".employee-grid-error").html("");
          $("#tbl_laporan_detail").append('<tbody class="employee-grid-error"><tr><th colspan="3">Data tidak ditemukan</th></tr></tbody>');
          $("#employee-grid_processing").css("display","none");
        }
    },
    "fnRowCallback": function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
      if ( aData[1] == null)
      {
        $('td', nRow).css('background-color', '#009688');
      }
    },
    "aoColumns": [
      {
        "mData": "0",
        "mRender": function ( data, type, row ) {
          return "<b>"+data+"</b>";
        }
      },
      {
        "mData": "1",
        "mRender": function ( data, type, row ) {
          return "<b>"+data+"</b>";
        }
      },
      {
        "mData": "2",
        "mRender": function ( data, type, row ) {
          return "<b>"+data+"</b>";
        }
      },
      {
        "mData": "3",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "4",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "5",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "6",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "7",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "8",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "9",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "10",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "11",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "12",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "13",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "14",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "15",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "16",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
      {
        "mData": "17",
        "mRender": function ( data, type, row ) {
          return data;
        }
      },
    ],
    dom: 'Bfrtip',
    buttons: [
      {
        extend: 'excel',
        text: 'Excel',
        title: 'Excel_Export_Title',
        filename: 'Report Company Type ('+proc_type+') - Detail',
        // exportOptions: {
        //   columns: [ 0, 1, 2, 3, 4 ]
        // },
        customize: function (xlsx) {
          console.log(xlsx);
          var sheet = xlsx.xl.worksheets['sheet1.xml'];
          var downrows = 4;
          var clRow = $('row', sheet);
          //update Row
          clRow.each(function () {
              var attr = $(this).attr('r');
              var ind = parseInt(attr);
              ind = ind + downrows;
              $(this).attr("r",ind);
          });

          // Update  row > c
          $('row c ', sheet).each(function () {
              var attr = $(this).attr('r');
              var pre = attr.substring(0, 1);
              var ind = parseInt(attr.substring(1, attr.length));
              ind = ind + downrows;
              $(this).attr("r", pre + ind);
          });

          function Addrow(index,data) {
            msg='<row r="'+index+'">'
            for(i=0;i<data.length;i++){
                var key=data[i].k;
                var value=data[i].v;
                msg += '<c t="inlineStr" r="' + key + index + '" s="0">';
                msg += '<is>';
                msg +=  '<t>'+value+'</t>';
                msg+=  '</is>';
                msg+='</c>';
            }
            msg += '</row>';
            return msg;
        }

          //insert
          var r1 = Addrow(1, [{ k: 'A', v: 'Report Company Type ('+proc_type+') - Detail' }, { k: 'B', v: '' }, { k: 'C', v: '' },  ]);
          var r2 = Addrow(2, [{ k: 'A', v: '' }, { k: 'B', v: 'Company' }, { k: 'C', v: $("#filter_company_detail option:selected").text() }, ]);
          var r3 = Addrow(3, [{ k: 'A', v: '' }, { k: 'B', v: 'Begin Date' },{ k: 'C', v: $("#filter_start_date_detail").val() }, ]);
          var r4 = Addrow(4, [{ k: 'A', v: '' }, { k: 'B', v: 'End Date' },{ k: 'C', v: $("#filter_end_date_detail").val() }, ]);
          var r5 = Addrow(5, [{ k: 'A', v: '' }, { k: 'B', v: '' },{ k: 'C', v: '' }, ]);

          sheet.childNodes[0].childNodes[1].innerHTML = r1 + r2+ r3+ r4 + r5 + sheet.childNodes[0].childNodes[1].innerHTML;
        },
      },
      {
          text: 'PDF',
          extend: 'pdfHtml5',
          title : 'Report Company Type ('+proc_type+') - Detail',
          filename: 'Report Company Type ('+proc_type+') - Detail',
          orientation: 'landscape',
          pageSize: 'A4',
          exportOptions: {
            modifier: {
               page: 'current'
            }
         },
          customize: function (doc) {
              doc.defaultStyle.fontSize = 8;
              doc.styles.tableHeader.fontSize = 8;
              doc.defaultStyle.alignment = 'center'
              doc.pageMargins = [20,60,20,30];
              var rowCount = doc.content[1].table.body.length;
              for (i = 1; i < rowCount; i++) {
                  doc.content[1].table.body[i][2].alignment = 'center';
                  doc.content[1].table.body[i][3].alignment = 'center';
                  doc.content[1].table.body[i][4].alignment = 'center';
              };
              doc['header']=(function(page) {
                  var filter_company = $("#filter_company_detail option:selected").text();
                  var filter_begin_date = $('#filter_start_date_detail').val();
                  var filter_end_date = $('#filter_end_date_detail').val();

                  headerText = [];
                  headerText.push('Company : '+filter_company);
                  if (filter_begin_date != '') {
                      headerText.push('Begin Date : '+filter_begin_date);
                  }
                  if (filter_end_date != '') {
                      headerText.push('End Date : '+filter_end_date);
                  }
                  headerText.push('Creation Date : '+ Localization.humanDatetime(new Date()));
                  if (page == 1) {
                      return {
                          columns : [
                              {
                                  alignment: 'left',
                                  text: headerText.join("\n"),
                                  margin: [20, 20]
                              }
                          ]
                      }
                  }
              });
          }
      },
    ]
  });
}

function getSum(total, num) {
  return total + Math.round(num);
}
</script>
