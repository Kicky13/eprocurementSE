<div class="app-content content">
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-1">
              <h3 class="content-header-title"><?= lang("Buat Dokumen ITP", "ITP Preparation") ?></h3>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
              <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                      <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                      <li class="breadcrumb-item active"><?= lang("Buat Dokumen ITP", "ITP Preparation") ?></li>
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
                                <div class="col-md-6">
                                    <div class="card-header">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <div class="heading-elements">
                                            <h5 class="title pull-right">
                                                <!-- <button data-id="" id="approve" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Proses</i></button>
                                                <button data-id="" id="reject" data-toggle="modal" data-target="#modal_rej" class="btn btn-sm btn-danger" title="Update"><i class=""> Reject</i></button> -->
                                                <!-- <button aria-expanded="false" id="itp_doc" class="btn btn-sm btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Buat Dokumen ITP", "Create ITP Document") ?></button>
                                                <button aria-expanded="false" id="itp_progres" class="btn btn-sm btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Show ITP Document On Progress", "Show ITP Document On Progress") ?></button> -->
                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content collapse show list_progress">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center>Msr No</center></th>
                                                        <th><center><?= lang("Jabatan", "Position") ?></center></th>
                                                        <th><center><?= lang("ITP Note", "ITP Note") ?> </center></th>
                                                        <th><center>Status</center></th>
                                                        <th><center><?= lang("Aksi", "Action") ?></center></th>
                                                    </tr>
                                                </tfoot>

                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content collapse show itp_agrement">
                                <div class="card-body card-dashboard">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <table id="tbl1" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover table-no-wrap display" width="100%">
                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center><?= lang("No Persetujuan", "Agrement No") ?></center></th>
                                                        <th><center><?= lang("Subjek Kerja", "Subject Work") ?></center></th>
                                                        <th><center><?= lang("Contractor", "Contractor") ?></center></th>
                                                        <th><center><?= lang("Matauang", "Currency") ?></center></th>
                                                        <th><center><?= lang("Mulai Validasi", "Validity Start") ?></center></th>
                                                        <th><center><?= lang("Selesai Validasi", "Validity End") ?></center></th>
                                                        <th><center>Action</center></th>
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
            </section>
        </div>
    </div>
</div>

<div id="myModal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class=" modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1"><b>ITP Preparation</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
                <div class="modal-body">
                  <div class="row info-header">
                    <div class="col-md-6 ">
                      <div class="card-content">
                        <div class="card-body info-header-sub">
                          <table class="table table-responsive">
                            <tbody>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("Perusahaan", "Company"); ?></th>
                                <td> <span id="comp_htm"></span> </td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row">Contractor</th>
                                <td><input type="hidden" id="vendor" class="form-control" value="" readonly> <span id="contractor_htm"></span> </td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row">Agrement No</th>
                                <td colspan="5"><input type="hidden" id="agrm_no" class="form-control" value="" readonly> <span id="agreement_htm"></span></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <!-- row2 -->
                    <div class="col-md-6">
                      <div class="card-content">
                        <div class="card-body info-header-sub">
                          <br>
                          <div class="row">
                            <div class="col-md-6">

                              <div class="form-group row">
                                <label class="col-md-3 label-control" for="projectinput1">Departement</label>
                                <div class="col-md-9">
                                  <span id="dept_htm"></span>
                                </div>

                                <label class="col-md-3 label-control" for="projectinput1">Date</label>
                                <div class="col-md-9">
                                  <input type="text" name="date_itp" id="date_itp" class="form-control" value="" required> <span id=""></span>
                                </div>
                              </div>
                              <div class="form-group row">
                                <label class="col-md-3 label-control" for="projectinput1">ITP To</label>
                                <div class="col-md-9">
                                  <span id="itp_ke"></span>
                                </div>
                              </div>

                            </div>
                          </div>
                          <!-- <table class="table table-responsive">
                            <tbody>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("Departemen", "Departement"); ?></th>
                                <td> <span id="dept_htm"></span> </td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("Tanggal", "Date"); ?></th>
                                <td colspan="5"><input type="text" name="date_itp" id="date_itp" class="form-control" value="" required> <span id=""></span></td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("ITP to", "ITP to"); ?></th>
                                <td colspan="5"><span id="itp_ke"></span></td>
                              </tr>
                            </tbody>
                          </table> -->
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                      <div class="col-md-12">
                          <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->
                        <div class="app-content">
                            <div class="content-wrapper">
                                <div id="edit" class="wrapper wrapper-content animated fadeInRight white-bg">
                                  <form id="itp_form" action="#" class="steps-validation wizard-circle" enctype="multipart/form-data">
                                      <input type="hidden" id="id_vendor" name="id_vendor" value="">
                                      <h6><?= lang("Informasi", "Information"); ?></h6>
                                      <h6><?= lang("Attachment", "Attachment"); ?></h6>

                                      <fieldset id="bagian1" class="col-md-12" class="white-bg">
                                          <h2 class="m-b-md"><?= lang("Item Agreement :", "Item Agreement :"); ?></h2>
                                          <div class="row">
                                            <table id="tbl_msritem" class="table table-bordered table-striped table-responsive table-no-wrap" width="100%">
                                              <thead>
                                                <tr>
                                                  <th>No</th>
                                                  <th><?= lang("Deskripsi", "Description") ?></th>
                                                  <th class="text-center"><?= lang("Qty", "Qty") ?></th>
                                                  <th class="text-center"><?= lang("UOM", "UOM") ?></th>
                                                  <th class="text-right"><?= lang("Harga Satuan", "Unit Price") ?></th>
                                                  <th class="text-right" style="min-width: 150px;"><?= lang("Total", "Total") ?></th>
                                                  <th class="text-center"><?= lang("Pengeluaran Qty ITP", "ITP Qty Spending") ?></th>
                                                  <th class="text-right" style="min-width: 150px;"><?= lang("Pengeluaran Total ITP", "ITP Total Spending") ?></th>
                                                  <th class="text-center"><?= lang("Pengeluaran Qty Sebenarnya", "Actual Qty Spending") ?></th>
                                                  <th class="text-right" style="min-width: 150px;"><?= lang("Pengeluaran Total Sebenarnya", "Actual Total Spending") ?></th>
                                                  <th class="text-right" style="min-width: 150px;"><?= lang("Sisa", "Remaining") ?></th>
                                                  <th class="text-center"><?= lang("Sisa (%)", "Remaining (%)") ?></th>
                                                  <th class="text-center"><?= lang("Checklist", "Checklist") ?></th>
                                                </tr>
                                              </thead>
                                              <tbody id="get_item_selection">

                                              </tbody>
                                            </table>
                                          </div>

                                          <h2 class="m-b-md"><?= lang("Item issued ITP", "Item Issuance"); ?></h2>
                                          <div class="row">
                                            <input type="hidden" id="po_no" name="po_no" value="">
                                            <input type="hidden" id="itp_total" name="itp_total" value="">
                                            <table id="tbl_item_selected" class="table table-bordered table-striped table-responsive table-no-wrap" width="100%">
                                              <thead>
                                                <tr>
                                                  <th>No</th>
                                                  <th><?= lang("Deskripsi", "Description") ?></th>
                                                  <th class="text-center"><?= lang("Qty", "Qty") ?></th>
                                                  <th class="text-center"><?= lang("UOM", "UOM") ?></th>
                                                  <th class="text-right"><?= lang("Estimate ITP Ammount", "Estimate ITP Ammount") ?></th>
                                                  <th><?= lang("Catatan", "Note") ?></th>
                                                  <th><?= lang("Aksi", "Action") ?></th>
                                                </tr>
                                              </thead>
                                              <tbody id="item_selected">

                                              </tbody>
                                              <tfoot>
                                                <tr>
                                                  <td colspan="4" class="text-right">Total</td>
                                                  <td><input type="text" id="total_itp" class="form-control text-right input-numeric" readonly></td>
                                                  <td colspan="2"></td>
                                                </tr>
                                              </tfoot>
                                            </table>
                                            <div class="col-sm-12">
                                              <!-- <h2 class="m-b-md"><?= lang("Catatan :", "Note :"); ?></h2> -->
                                              <input type="hidden" class="form-control required" id="descTextarea" rows="3" name="note" placeholder="Write Note Here">
                                            </div>
                                          </div>
                                      </fieldset>
                                      <br>
                                      <fieldset id="bagian2" class="col-12">
                                          <h2 class="m-b"><?= lang("File Attachment", "File Attachment"); ?></h2>
                                          <!-- <div class="row">
                                            <table id="tbl_attch" class="table table-bordered table-striped table-responsive" width="100%">
                                              <thead>
                                                <tr>
                                                  <th>No</th>
                                                  <th><?= lang("Tipe", "Type") ?></th>
                                                  <th><?= lang("Nama File", "File Name") ?></th>
                                                  <th><?= lang("Uploaded At", "Uploaded At") ?></th>
                                                  <th><?= lang("Uploader", "Uploader") ?></th>
                                                  <th><?= lang("Aksi", "Action") ?></th>
                                                </tr>
                                              </thead>
                                              <tbody id="get_attch">

                                              </tbody>
                                            </table>
                                          </div> -->
                                          <br>
                                          <div class="form-group col-12 mb-2">
                                            <div data-repeater-list="repeater-list">
                                              <div data-repeater-item="" style="" id="file-repeater">
                                                <div class="row mb-1 ">
                                                  <div class="col-9 col-xl-10">
                                                    <label class="file center-block">
                                                      <input style="width: fit-content;" class="form-control" type="file" name="file_attch[]" id="file">
                                                      <span class="file-custom"></span>
                                                    </label>
                                                  </div>
                                                  <div class="col-2 col-xl-1">
                                                    <!-- <button type="button" data-repeater-delete="" class="btn btn-icon btn-danger mr-1 remove_attch"><i class="fa fa-times"></i></button> -->
                                                  </div>
                                                </div>
                                              </div>
                                            </div>
                                            <button type="button" data-repeater-create="" class="btn btn-primary add_attch">
                                              <i class="fa fa-plus"></i> Add new file
                                            </button>
                                        </div>
                                      </fieldset>

                                </div>
                            </div>
                        </div>
                        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->

                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="submit" class="btn btn-primary" id="save" disabled><?= lang('Proses', 'Process') ?></button>
                </div>
              </form>
        </div>
    </div>
</div>

<!--reject-->
<div id="modal_rej" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class=" modal-content" id="reject_mdl">
            <div class="modal-header">
                <?= lang("Tolak Data", "Reject Data") ?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
                <div class="form-horizontal">
                    <input style="display:none" name="id_vendor" class="id_vendor" hidden>
                    <input style="display:none" name="email" class="email" hidden>
                    <div class="form-group">
                        <div class="col-md-12">
                            <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
                            <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
                            <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note" required></textarea>
                            <input type="hidden" id="idnya" name="idnya" value="">
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-danger"><?= lang("Tolak Data", "Reject Data") ?></button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>

<script type="text/javascript">
var arr_chekclist = new Array();
  $(document).ready(function() {
    $('.input-numeric').number(true, 2);
    // $("#save").hide();
    $( "#date_itp" ).datetimepicker({format: 'YYYY-MM-DD'});
    $(".list_progress").hide();
    // $("#itp_list").hide();
    // $("#itp_doc").on('click', function(e) {
    //   // e.preventDefault();
    //   // $(this).hide();
    //   $(".list_progress").hide();
    //   $(".itp_agrement").show();
    // });
    //
    //
    // $("#itp_progres").on('click', function(e) {
    //   // e.preventDefault();
    //   // $(this).hide();
    //   $(".list_progress").show();
    //   $(".itp_agrement").hide();
    // });

    var form = $(".steps-validation").show();
    $(".number-tab-steps").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
		enableFinishButton: false,
		enablePagination: true,
		enableAllSteps: true,
        labels: {
            finish: 'Submit'
        },
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });


    // Show form
    var form = $(".steps-validation").show();

    $(".steps-validation").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
		titleTemplate: '#title#',
		enableFinishButton: false,
		enablePagination: true,
		enableAllSteps: true,
        labels: {
            finish: 'Submit'
        },
        onStepChanging: function (event, currentIndex, newIndex)
        {
            // Allways allow previous action even if the current form is not valid!
            if (currentIndex > newIndex)
            {
                return true;
            }
            // Forbid next action on "Warning" step if the user is to young
            if (newIndex === 3 && Number($("#age-2").val()) < 18)
            {
                return false;
            }
            // Needed in some cases if the user went back (clean up)
            if (currentIndex < newIndex)
            {
                // To remove error styles
                form.find(".body:eq(" + newIndex + ") label.error").remove();
                form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
            }
            form.validate().settings.ignore = ":disabled,:hidden";
            $("li a:contains(Submit)").hide();
            // $("#save").show();
            return form.valid();
        },
        onFinishing: function (event, currentIndex)
        {
            form.validate().settings.ignore = ":disabled";
            return form.valid();
        },
        onFinished: function (event, currentIndex)
        {
            alert("Submitted!");
        }
    });

	//hide next and previous button
	$('a[href="#next"]').hide();
	$('a[href="#previous"]').hide();

    // Initialize validation
    $(".steps-validation").validate({
        ignore: 'input[type=hidden]', // ignore hidden fields
        errorClass: 'danger',
        successClass: 'success',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        errorPlacement: function(error, element) {
            error.insertAfter(element);
        },
        rules: {
            email: {
                email: true
            }
        }
    });



    ////////////////////////////////////////////////////////////////// hole process /////////////////////////////////////////////////////////////////////////////
    $(document).on('show.bs.modal', '#myModal', function(e){
      var idnya = $(e.relatedTarget).data("id");
      var result;

      var speding = 0;

      while(arr_chekclist.length > 0) {
        arr_chekclist.pop();
      }

      $("#get_item_selection").find('tr').remove();
      $("#item_selected").find('tr').remove();
      $('.data-repeater').remove();
      document.getElementById("itp_form").reset();
      $("#po_no").val(idnya);
      $("#agrm_no").val(idnya);
      $("#agreement_htm").html(idnya);
      // alert(idnya);
      $.ajax({
        url: '<?= base_url('procurement/Itp_document/get_item_selection') ?>',
        type: 'POST',
        dataType: 'JSON',
        data: {idnya: idnya}
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        if (result == true) {
          var no = 0;
          var str = '';
          var total_value = [];
          var total_spending = [];
          var total_actual = [];
          var total_remaining = [];
          var sum = 0;
          var sum_sisa = 0;
          var item = res.item;
          $("#vendor").val(item[0].vendor)
          $("#contractor_htm").html(item[0].vendor)
          $("#comp_htm").html(item[0].dt_comp.company_desc)
          $("#id_vendor").val(item[0].id_vendor)
          $("#dept_htm").html(item[0].dt_comp.DEPARTMENT_DESC)
          $("#itp_ke").html(item[0].dt_comp.number_of)
          if (res.receipt != null) {
            $("#itp_total").val(res.receipt.itp_total);
          } else {
            $("#itp_total").val('');
          }
          $.each(item, function(index, el) {
            $(".checklist_item"+el.MATERIAL).prop("disabled", false);
            $(".checklist_item"+el.MATERIAL).css({"background-color": "#dddddd", "color": "black"});
            $(".checklist_item"+el.MATERIAL).find('i').toggleClass('fa-check fa-square-o');

            no++;

            var total_harga = el.priceunit*el.qty;
            var sisa = parseInt(total_harga)-parseInt(el.total_receipt);
            var sisa_persen = (sisa/total_harga) * 100;

            total_value.push(total_harga);
            total_spending.push(el.itp_total);
            total_actual.push(el.sr_total);
            total_remaining.push(sisa);

                str = '<tr>'+
                        '<td>'+no+'</td>'+
                        '<td>'+el.MATERIAL_NAME+'</td>'+
                        '<td><input style="width: fit-content;" class="form-control text-center" type="text" id="qty'+el.MATERIAL+'" value="'+el.qty+'" readonly/></td>'+
                        '<td>'+el.uom_desc+'</td>'+
                        '<td class="text-right">'+Localization.number(el.priceunit)+'</td>'+
                        '<td><input id="total_harga'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right input-numeric" type="text" value="'+total_harga+'" readonly /></td>'+
                        '<td><input id="qty_spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control tdspending text-center" type="text" value="'+el.itp_qty+'" readonly /></td>'+
                        '<td><input id="spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control tdspending text-right input-numeric" type="text" value="'+el.itp_total+'" readonly /></td>'+
                        '<td><input id="qty_actual_spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control tdspending text-center" type="text" value="'+el.sr_qty+'" readonly /></td>'+
                        '<td><input id="actual_spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control tdspending text-right input-numeric" type="text" value="'+el.sr_total+'" readonly /></td>'+
                        '<td><input id="sisa'+el.MATERIAL+'" style="width: fit-content;" class="form-control tdremaining text-right input-numeric" name="total_spending[]" type="text" value="'+sisa+'" readonly /><input id="sisa_ori'+el.MATERIAL+'" name="sisa_ori[]" type="hidden" value="'+el.sisa+'" /></td>'+
                        '<td><input id="persen_sisan'+el.MATERIAL+'" style="width: fit-content;" class="form-control tdremaining text-right" name="sisa_persen[]" type="text" value="'+Math.round(sisa_persen)+'%" readonly /></td>'+
                        '<td class="text-center"><button type="button" data-id="'+el.MATERIAL+'" onClick="get_id('+el.MATERIAL+', \''+el.id_itemtype+'\', \''+el.MATERIAL_NAME.allReplace({',': '', '"': '', '#': ''})+'\', '+el.qty+', \''+el.UOM1+'\', '+el.priceunit+', '+total_harga+', '+no+', '+el.itp_qty+', '+el.itp_total+', '+el.sr_qty+', '+el.sr_total+', '+sisa+')" class="btn btn-sm btn-default checklist_item'+el.MATERIAL+' btn-check"><i class="fa fa-square-o"></i></button></td>'+
                      '</tr>';
            $("#get_item_selection").append(str);
            /*var sisone_item = $("#total_spending"+el.MATERIAL).val(sisa)
            if (sisa <= 0 ) {
              $(".checklist_item"+el.MATERIAL).prop("disabled", true);
              $(".checklist_item"+el.MATERIAL).css({"background-color": "green", "color": "white"});
              $(".checklist_item"+el.MATERIAL).find('i').toggleClass('fa-square-o fa-check');
            }

            if (parseInt(total_spending.reduce(getSum, 0)) >= parseInt(total_value.reduce(getSum, 0))) {
              $(".btn-check").prop("disabled", true);
              $(".btn-check").css({"background-color": "green", "color": "white"});
              $(".btn-check").find('i').toggleClass('fa-square-o fa-check');
            }*/
          });

          var total_rem_persen = total_remaining.reduce(getSum, 0 )/ total_value.reduce(getSum, 0) * 100;

          var str2 = '<tr style="font-weight:bold;">'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9" class="text-right">TOTAL</td>'+
                        '<td bgcolor="white" class="text-right"><input type="hidden" id="total_actual" value="'+parseInt(total_value.reduce(getSum, 0))+'">'+Localization.number(total_value.reduce(getSum, 0))+'</td>'+
                        '<td>&nbsp;</td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control text-right input-numeric" type="text" id="total_spending" onChange="change_total()" value="'+total_spending.reduce(getSum, 0)+'" readonly><input type="hidden" id="total_spending_ori" value="'+total_spending.reduce(getSum, 0)+'" readonly></td>'+
                        '<td>&nbsp;</td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control text-right input-numeric" type="text" id="total_actual" onChange="change_total()" value="'+total_actual.reduce(getSum, 0)+'" readonly></td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control text-right input-numeric" type="text" id="total_remaining" onChange="change_total()" value="'+total_remaining.reduce(getSum, 0)+'" readonly></td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control text-right" type="text" id="" value="'+Math.round(total_rem_persen)+'%" readonly></td>'+
                        '<td>&nbsp;</td>'+
                      '</tr>';
          $("#get_item_selection").append(str2);
          $('.input-numeric').number(true, 2);
          //$("#total_remaining").val(sum_sisa);
          //$("#total_spending").val(sum);
        }

      });

      // $(document).on('change', '#qty2', function(e) {
      //   // e.preventDefault();
      //   /* Act on the event */
      //   var qty2 = $("#qty2").val();
      //   var spending2 = $("#spending2").val();
      //   var total_spending
      // });

      // show itp data
      // $.ajax({
      //   url: '<?=base_url('procurement/Itp_document/show_data_itp')?>',
      //   type: 'POST',
      //   dataType: 'html',
      //   data: {msr_no: idnya}
      // })
      // .done(function() {
      //   result = true;
      // })
      // .fail(function() {
      //   result = false;
      // })
      // .always(function(res) {
      //   if (result = true) {
      //     // console.log(res);
      //     $("#item_selected").html(res);
      //   }
      // });

    });

    $(document).on('click', '.add_attch', function(e) {
      // e.preventDefault();
      var str = '<div class="row mb-1 data-repeater">'+
        '<div class="col-9 col-xl-10">'+
          '<label class="file center-block">'+
            '<input style="width: fit-content;" class="form-control" type="file" name="file_attch[]" id="file">'+
            '<span class="file-custom"></span>'+
          '</label>'+
        '</div>'+
        '<div class="col-2 col-xl-1">'+
          '<button type="button" data-repeater-delete="" class="btn btn-icon btn-danger mr-1 remove_attch"><i class="fa fa-times"></i></button>'+
        '</div>'+
      '</div>';
      $("#file-repeater").append(str);
    });


    $(document).on('click', '.remove_attch', function(e) {
      // e.preventDefault();
      if (confirm('Are you sure you want to remove this item?')) {
      $(this).closest('.data-repeater').remove();
    }
    });


    $(document).on('click', '#remove_item', function(e) {
      // e.preventDefault();
      var itemid = $(e.relatedTarget).data("id");
      var itemid = $(this).data("id");
      arr_chekclist.pop(itemid);
      $(this).closest('tr').remove();
      // console.log(itemid);
      $(".checklist_item"+itemid).prop("disabled", false);
      $(".checklist_item"+itemid).css({"background-color": "#dddddd", "color": "black"});
      $(".checklist_item"+itemid).find('i').toggleClass('fa-check fa-square-o');

      if (arr_chekclist.length > 0) {
        $("#save").prop('disabled', false);
      } else {
        $("#save").prop('disabled', true);
      }
      count_total_itp();
    });


    $("#itp_form").submit(function(e){
      var total_remaining = toFloat($('#total_remaining').val());
      var total_itp = toFloat($('#total_itp').val());
      if (total_itp > total_remaining) {
        // alert('Total ITP more then remaining value');
        swal("Ooopss", 'Total ITP more then remaining value', "warning");

        return false;
      }
      e.preventDefault();
      var data = new FormData(this);
      data.append('date_itp', $("#date_itp").val());
      var resultx;
      console.log("------------------------------");
      console.log((parseInt($("#total_itp").val()) + parseInt($("#total_spending_ori").val())));

      console.log('Total Spending '+ parseInt($("#total_itp").val()));
      console.log(parseInt($("#total_actual").val()));
      var vv = $("#itp_total").val();

      if (vv == null && vv == '') {
        var itp_totalx = (parseInt($("#total_itp").val()) + parseInt($("#total_spending_ori").val()));
      } else {
        var itp_totalx = (parseInt($("#total_itp").val()) + parseInt(vv));
      }
      if (itp_totalx > parseInt($("#total_actual").val())) {
        swal("Ooopss", "Total ITP can't be more than Agreement, remaining value is "+( parseInt($("#total_actual").val()) - parseInt($("#total_itp").val()) ), "warning");
      } else {
        swal({
          title: "ITP Development",
          text: "Are you sure to proceed ?",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#3085d6",
          confirmButtonText: "Submit",
          closeOnConfirm: true
        },function () {
          var xmodalx = modal_start($("#myModal").find(".modal-content"));
          $.ajax({
            url: '<?= base_url('procurement/Itp_document/create_itp_document')?>',
            type: 'POST',
            dataType: 'JSON',
            data: data,
            cache: false,
            processData: false,
            contentType: false,
          })
          .done(function() {
            resultx = true;
          })
          .fail(function() {
            resultx = false;
          })
          .always(function(res) {
            if (resultx == true) {
              modal_stop(xmodalx);

              if (res.success == true) {
                setTimeout(function(){
                  swal({
                    title: "Done",
                    text: "Data is successfuly submited with No."+res.res_success.itp_no,
                    type: "success",
                    showCancelButton: false,
                    confirmButtonColor: "#3085d6",
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                  },function () {
                    window.location.href = "<?= base_url()?>/procurement/itp_document";
                  });
                },500)
              } else {
                swal("Ooopss", "Please check your input data!", "warning");
              }
              console.log(resultx);
            }
          });
        });

      }


    })

    ////////////////////////////////////////////////////////////////// hole process /////////////////////////////////////////////////////////////////////////////

    // show data
    $('#tbl1 tfoot th').each(function (i) {
      var title = $('#tbl1 thead th').eq($(this).index()).text();
      if ($(this).text() == 'No') {
        $(this).html('');
      } else if ($(this).text() == 'Action') {
        $(this).html('');
      } else {
        $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
      }

    });
    var table=$('#tbl1').DataTable({
        "ajax": {
            "url": "<?= base_url('procurement/Itp_document/datatable_po_remaining') ?>",
            "dataSrc": ""
        },
        "data": null,
        "searching": true,
        "paging": true,
        fixedColumns: {
            leftColumns: 0,
            rightColumns: 1
        },
        "columns": [
          {title: "<center>No</center>"},
          {title: "<center><?= lang("No Persetujuan", "Agrement No") ?></center>"},
          {title: "<center><?= lang("Subjek Kerja", "Subject Work") ?></center>"},
          {title: "<center><?= lang("Contractor", "Contractor") ?></center>"},
          {title: "<center><?= lang("Matauang", "Currency") ?></center>"},
          {title: "<center><?= lang("Mulai Validasi", "Validity Start") ?></center>"},
          {title: "<center><?= lang("Selesai Validasi", "Validity End") ?></center>"},
          {title: "<center>Action</center>"}
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
            {"className": "dt-center", "targets": [6]},
            {"className": "dt-center", "targets": [7]},
        ],
        scrollX : true
    });
    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });

    // show data
    // $('#tbl tfoot th').each(function (i) {
    //         var title = $('#tbl thead th').eq($(this).index()).text();
    //         $(this).html('<input type="text" placeholder="Search ' + title + '" data-index="' + i + '" />');
    // });
    // var table=$('#tbl').DataTable({
    //     "ajax": {
    //         "url": "<?= base_url('procurement/Itp_document/datatable_list_itp_on_progress') ?>",
    //         "dataSrc": ""
    //     },
    //     "data": null,
    //     "searching": true,
    //     "paging": true,
    //     "columns": [
    //       {title: "<center>No</center>"},
    //       {title: "<center><?= lang("No MSR", "MSR No") ?></center>"},
    //       {title: "<center><?= lang("ITP Note", "ITP Note") ?></center>"},
    //       {title: "<center><?= lang("Jabatan", "Position") ?></center>"},
    //       {title: "<center><?= lang("Status", "Status") ?></center>"},
    //       {title: "<center><?= lang("Aksi", "Action") ?></center>"}
    //     ],
    //     "columnDefs": [
    //         {"className": "dt-center", "targets": [0]},
    //         {"className": "dt-center", "targets": [1]},
    //         {"className": "dt-center", "targets": [2]},
    //         {"className": "dt-center", "targets": [3]},
    //         {"className": "dt-center", "targets": [4]},
    //         {"className": "dt-center", "targets": [5]},
    //     ]
    // });
    // $(table.table().container()).on('keyup', 'tfoot input', function () {
    //   table.column($(this).data('index')).search(this.value).draw();
    // });

  });

  function get_id(id, type, desc, qty, uom, unitprice, total_harga, no, itp_qty, itp_total, sr_qty, sr_total, remaining){
    // console.log(el);
    $(".checklist_item"+id).prop("disabled", true);
    $(".checklist_item"+id).css({"background-color": "green", "color": "white"});
    $(".checklist_item"+id).find('i').toggleClass('fa-square-o fa-check');

    var str = '<tr>'+
                '<td><input style="width: fit-content;" class="form-control" type="hidden" name="material_id[]" value="'+id+'" readonly />'+no+'</td>'+
                '<td><input style="width: fit-content;" class="form-control" type="hidden" name="price_unit[]" value="'+unitprice+'" readonly />'+desc+'</td>'+
                '<td><input style="width: fit-content;" class="form-control text-center" id="qty2'+id+'" type="text" name="item_qty[]" onKeyup="change('+id+', '+unitprice+', '+total_harga+', '+itp_qty+', '+itp_total+', '+sr_qty+', '+sr_total+', '+remaining+')" value="0" required /></td>'+
                '<td>'+uom+'</td>'+
                '<td><input style="width: fit-content;" class="form-control text-right input-numeric" id="spending2'+id+'" type="text" name="item_ammount[]" value="0" readonly required /></td>'+
                '<td><input type="text" class="form-control" name="remark[]" id="remark'+id+'" placeholder="Input some note"></td>'+
                '<td><button type="button" data-id="'+id+'" id="remove_item" class="btn btn-sm btn-danger">Remove</button></td>'+
              '</tr>';
    $("#item_selected").append(str);
    input_numberic('#spending2'+id, true);
    // validasi_angka('#spending2'+id);

    arr_chekclist.push(id);
    console.log(arr_chekclist);
    if (arr_chekclist.length > 0) {
      $("#save").prop('disabled', false);
    } else {
      $("#save").prop('disabled', true);
    }
    $('.input-numeric').number(true, 2);

  }

  function change(id, unitprice, total_harga, itp_qty, itp_total, sr_qty, sr_total, remaining) {
    var qty_hasil_estimasi =  parseInt(unitprice) * parseInt($("#qty2"+id).val()) ;
    $("#spending2"+id).val(qty_hasil_estimasi);
    count_total_itp();
  }

  function count_total_itp() {
    var total = 0;
    $.each($('[name="item_ammount[]"'), function(key, elem) {
      total += toFloat($(elem).val());
    });
    $('#total_itp').val(total);
  }

  /*function change(id, unitprice, total_hargax, pengeluaranx){
    // var qty1 = $("#qty"+id).val();
    // var qty2 = $("#qty2"+id).val();
    //
    // var ammount_itp = 0;
    // if (parseInt(qty2) > parseInt(qty1)) {
    //   qty2 = $("#qty2"+id).change().val(0);
    //   ammount_itp = 0;
    // } else {
    //   ammount_itp = parseInt(qty2)*parseInt(unitprice);
    // }
    //
    // console.log(ammount_itp);
    // var spending2 = $("#spending2"+id).val(ammount_itp);
    // var total_harga = $("#total_harga"+id).val();
    // var total_spending = total_harga-ammount_itp;
    //
    // // speding = ammount_itp;
    // var total_spending = $("#total_spending"+id).val(total_spending);
    // var spending = $("#spending"+id).val(ammount_itp);

    var spending2 = $("#spending2"+id).val();

    // hitungan by ammount itp
    // var qty_hasil_estimasi = ( parseInt(spending2) / parseInt($("#total_harga"+id).val()) * parseInt($("#qty"+id).val()) );
    // $("#qty2"+id).val(qty_hasil_estimasi);


    // hitungan by qty
    var qty_hasil_estimasi =  parseInt(unitprice) * parseInt($("#qty2"+id).val()) ;
    $("#spending2"+id).val(qty_hasil_estimasi);

    // var pengeluaran = $("#spending"+id).val();
    var total_pengeluaran = parseInt(pengeluaranx) + parseInt(spending2);
    var biayakeluar = $("#spending"+id).val(qty_hasil_estimasi);

    // var total_harga = $("#total_harga"+id).val();
    var sisa = parseInt(total_hargax) - parseInt($("#spending"+id).val());
    // console.log(parseInt(sisa));
    // console.log(sisa);
    $("#sisa"+id).val(sisa);

    var sum_spending = 0;
    var sum_remaining = 0;
    // iterate through each td based on class and add the values
    $(".tdspending").each(function() {

        var value = $(this).val();
        // add only if the value is number
        if(!isNaN(value) && value.length != 0) {
            sum_spending += parseFloat(value);
        }
    });
    $(".tdremaining").each(function() {

        var value = $(this).val();
        // add only if the value is number
        if(!isNaN(value) && value.length != 0) {
            sum_remaining += parseFloat(value);
        }
    });

    $("#total_spending").val(sum_spending);
    $("#total_remaining").val(sum_remaining);
    // iterate through each td based on class and add the values
  }*/

  function change_total(){
    // var total_spending = $("#total_spending").val();
    // var total_remaining = $("#total_remaining").val();

  }

  function getSum(total, num) {
    return total + Math.round(num);
  }

  function sum_array(input){
   if (toString.call(input) !== "[object Array]"){
     return false;
   } else {
     var total =  0;
     for(var i=0;i<input.length;i++)
       {
         if(isNaN(input[i])){
         continue;
          }
           total += Number(input[i]);
        }
      return total;
   }
  }

String.prototype.allReplace = function(obj) {
  var retStr = this;
  for (var x in obj) {
      retStr = retStr.replace(new RegExp(x, 'g'), obj[x]);
  }
  return retStr;
};
</script>
