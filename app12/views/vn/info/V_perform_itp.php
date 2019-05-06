<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content V_perform_itp">
    <div class="content-wrapper">
      <div class="content-header row">
          <div class="content-header-left col-md-6 col-12 mb-1">
              <h3 class="content-header-title"><?= lang("ITP Acceptance", "ITP Acceptance") ?></h3>
          </div>
          <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
              <div class="breadcrumb-wrapper col-12">
                  <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="<?= base_url() ?>vn/info/greetings">Home</a></li>
                      <li class="breadcrumb-item active"><?= lang("ITP Document", "ITP") ?></li>
                      <li class="breadcrumb-item active"><?= lang("ITP Acceptance", "ITP Acceptance") ?></li>
                  </ol>
              </div>
          </div>
      </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="row ">
                                <div class="col-md-6">
                                    <div class="card-header">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card-header">
                                        <div class="heading-elements">
                                            <h5 class="title pull-right">

                                            </h5>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-content collapse show list_progress">
                                <div class="card-body card-dashboard">
                                    <div class="row ">
                                        <div class="col-md-12">
                                            <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center>Msr No</center></th>
                                                        <th><center><?= lang("Jabatan", "Position") ?></center></th>
                                                        <th><center><?= lang("PO Title", "PO Title") ?></center></th>
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
                                            <table id="tbl1" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                <tfoot>
                                                    <tr>
                                                        <th><center>No</center></th>
                                                        <th><center><?= lang("No Persetujuan", "Agrement No") ?></center></th>
                                                        <th><center><?= lang("PO", "PO") ?></center></th>
                                                        <th><center><?= lang("Contractor", "Contractor") ?></center></th>
                                                        <th><center><?= lang("Date", "Date") ?></center></th>
                                                        <th><center><?= lang("Aksi", "Action") ?></center></th>
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

<input type="hidden" name="reject_itp" class="reject_itp" value="">
<div id="myModal" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog modal-xl">
        <div class=" modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1"><b>ITP Development</b></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
                <div class="modal-body">
                  <div class="row info-header">
                    <div class="col-md-6">
                      <div class="card-content">
                        <div class="card-body">
                          <table class="table table-responsive">
                            <tbody>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("Perusahaan", "Company"); ?></th>
                                <td><?= $this->session->NAME; ?></td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row">Contractor Contact</th>
                                <td><code><?= $this->session->ID_VENDOR; ?></code></td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row">No ITP</th>
                                <td colspan="5" id="itp_no"></td>
                              </tr>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                    <!-- row2 -->
                    <div class="col-md-6">
                      <div class="card-content">
                        <div class="card-body">
                    <!--  <h1><b>&nbsp;</b></h1>  -->
                          <table class="table table-responsive">
                            <tbody>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("Agrement No", "Agrement No"); ?></th>
                                <td> <span id="nopo_htm"></span> </td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("Tanggal", "Date"); ?></th>
                                <td colspan="5"><input type="date" name="date_itp" id="date_itp" class="form-control" value="" required> <span id=""></span></td>
                              </tr>
                            </tbody>
                          </table>
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
                                      <h6><?= lang("Informasi", "Information"); ?></h6>
                                      <h6><?= lang("Attachment", "Attachment"); ?></h6>

                                      <fieldset id="bagian1" class="col-md-12" class="white-bg">
                                          <h2 class="m-b-md"><?= lang("ITP Agreement :", "ITP Agreement :"); ?></h2>
                                          <div class="row">
                                            <table id="tbl_msritem" class="table table-bordered table-striped table-responsive" width="100%">
                                              <thead>
                                                <tr>
                                                  <th>No</th>
                                                  <th><?= lang("Deskripsi", "Description") ?></th>
                                                  <th><?= lang("Qty", "Qty") ?></th>
                                                  <th><?= lang("UOM", "UOM") ?></th>
                                                  <th><?= lang("Harga Satuan", "Unit Price") ?></th>
                                                  <th><?= lang("Total", "Total") ?></th>
                                                  <th><?= lang("Pengeluaran ITP", "ITP Spending") ?></th>
                                                  <th><?= lang("Pengeluaran Sebenarnya", "Actual Spending") ?></th>
                                                  <th><?= lang("Sisa", "Remaining") ?></th>
                                                  <th><?= lang("Sisa (%)", "Remaining (%)") ?></th>
                                                </tr>
                                              </thead>
                                              <tbody id="itp_user_rep">

                                              </tbody>
                                            </table>
                                          </div>

                                          <h2 class="m-b-md"><?= lang("ITP Selection :", "ITP Selection :"); ?></h2>
                                          <div class="row">
                                            <table id="tbl_msritem" class="table table-bordered table-striped table-responsive" width="100%">
                                              <thead>
                                                <tr>
                                                  <th>No</th>
                                                  <th><?= lang("No ITP Doc", "No ITP Doc") ?></th>
                                                  <th><?= lang("Deskripsi", "Description") ?></th>
                                                  <th><?= lang("Qty", "Qty") ?></th>
                                                  <th><?= lang("UOM", "UOM") ?></th>
                                                  <th><?= lang("Harga Satuan", "Unit Price") ?></th>
                                                  <th><?= lang("Total", "Total") ?></th>
                                                  <th><?= lang("Pengeluaran", "Spending") ?></th>
                                                  <th><?= lang("Sisa", "Remaining") ?></th>
                                                  <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= lang("Remark", "Remark") ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                  <th><?= lang("Checklist", "Checklist") ?></th>
                                                </tr>
                                              </thead>
                                              <tbody id="get_item_selection">

                                              </tbody>
                                            </table>
                                          </div>

                                          <div class="itp_detail">
                                            <h2 class="m-b-md"><?= lang("Item to perform ITP", "Item to perform ITP"); ?></h2>
                                            <div class="row">
                                              <input type="hidden" id="msr_number" name="msr_number" value="">
                                              <input type="hidden" id="id_itp" name="id_itp" value="">
                                              <table id="tbl_item_selected" class="table table-bordered table-striped table-responsive" width="100%">
                                                <thead>
                                                  <tr>
                                                    <th>No</th>
                                                    <th><?= lang("No ITP Doc", "No ITP Doc") ?></th>
                                                    <th><?= lang("Deskripsi", "Description") ?></th>
                                                    <th><?= lang("Qty", "Qty") ?></th>
                                                    <th><?= lang("UOM", "UOM") ?></th>
                                                    <th><?= lang("Estimate ITP Ammount", "Estimate ITP Ammount") ?></th>
                                                    <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?= lang("Remark", "Remark") ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                                    <th><?= lang("Aksi", "Action") ?></th>
                                                  </tr>
                                                </thead>
                                                <tbody id="item_selected">

                                                </tbody>
                                              </table>
                                              <div class="col-sm-12">
                                                <!-- <h2 class="m-b-md"><?= lang("Catatan :", "Note :"); ?></h2>
                                                <textarea class="form-control" id="descTextarea" rows="3" name="note" placeholder="Write Note Here"></textarea> -->
                                                <input type="hidden" id="descTextarea" name="note">
                                              </div>
                                            </div>
                                          </div>
                                      </fieldset>
                                      <br>
                                      <fieldset id="bagian2" class="col-12">
                                          <h2 class="m-b"><?= lang("File Attachment User Representative", "File Attachment User Representative"); ?></h2>
                                          <div class="card-content">
                                            <div class="table-responsive">
                                              <table class="table table-xs">
                                                <thead>
                                                  <th style="height: 50px;"><?= lang("Tipe", "Type") ?></th>
                                                  <th style="height: 50px;"><?= lang("Nama File", "File Name") ?></th>
                                                  <th style="height: 50px;"><?= lang("Uploaded At", "Uploaded At") ?></th>
                                                  <th style="height: 50px;"><?= lang("Lihat File", "View File") ?></th>
                                                  <th style="height: 50px;"><?= lang("Aksi", "Action") ?></th>
                                                </thead>
                                                <tbody id="get_attch_usrep">

                                                </tbody>
                                              </table>
                                            </div>
                                          </div>
                                          <!-- <div class="row">
                                            <table id="tbl_attch" class="table table-bordered table-striped table-responsive" width="100%">
                                              <thead>
                                                <tr>
                                                  <th style="height: 50px;"><?= lang("Tipe", "Type") ?></th>
                                                  <th style="height: 50px;"><?= lang("Nama File", "File Name") ?></th>
                                                  <th style="height: 50px;"><?= lang("Uploaded At", "Uploaded At") ?></th>
                                                  <th style="height: 50px;"><?= lang("Lihat File", "View File") ?></th>
                                                  <th style="height: 50px;"><?= lang("Aksi", "Action") ?></th>
                                                </tr>
                                              </thead>
                                              <tbody id="get_attch_usrep">

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
                    <button type="submit" class="btn btn-primary savebtn" id="save"><?= lang('Proses', 'Process') ?></button>
                    <button type="button" class="btn btn-primary" id="accept"><?= lang('Setujui', 'Accept') ?></button>
                    <button type="button" data-toggle="modal" id="btnrej" data-target="#modal_rej" class="btn btn-danger btn-reject" title="Reject"><i class=""> Reject</i></button>
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
          <input type="hidden" name="id_itp_rej" id="id_itp_rej" value="">

          <div class="form-group">
            <div class="col-md-12">
              <label class="control-label" for="field-1"><?= lang("Catatan", "Note") ?></label>
              <label id="label_kirim" class="control-label" for="field-1" style="color:rgb(217, 83, 79)">*</label>
              <textarea placeholder="Isi komentar anda" class="form-control" rows="5" id="note" name="note" required></textarea>
            </div>
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn btn-default reject_data_close" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
        <button type="submit" class="btn btn-danger reject_data"><?= lang("Tolak Data", "Reject Data") ?></button>
      </div>
    </form>
  </div>
</div>
<!--reject-->
<!--
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script> -->
<!-- <script src="<?= base_url()?>ast11/app-assets/js/scripts/forms/wizard-steps.js" type="text/javascript"></script> -->

<script type="text/javascript">
var arr_chekclist = new Array();
  $(document).ready(function() {
    // $("#save").hide();

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
		enableFinishButton: false,
		transitionEffect: "fade",
		titleTemplate: '#title#',
		enablePagination: true,
		enableAllSteps: true,
        labels: {
            finish: 'Submit'
        },
        onFinished: function (event, currentIndex) {
            alert("Form submitted.");
        }
    });

	//hide next and previous button
	$('a[href="#next"]').hide();
	$('a[href="#previous"]').hide();

    // Show form
    var form = $(".steps-validation").show();

    $(".steps-validation").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
		enableFinishButton: false,
		transitionEffect: "fade",
		titleTemplate: '#title#',
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
      var no_po = $(e.relatedTarget).data("po");
      var is_vendor_acc = $(e.relatedTarget).data("vendoracc");
      console.log(no_po);
      var result;

      var speding = 0;
      $("#msr_number").attr('disabled', false);
      $("#id_itp").attr('disabled', false);
      $("#descTextarea").attr('disabled', false);
      $("#file").attr('disabled', false);
      $("#id_vendor").attr('disabled', false);
      $("#email").attr('disabled', false);
      $("#note").attr('disabled', false);
      $("#idnya").attr('disabled', false);

      // $(".savebtn").show();
      // $("#accept").show();
      // $(".btn-reject").hide();
      $(".reject_itp").val(idnya);

      // console.log(idnya);

      $(".savebtn").hide();
      $(".btn-reject").hide();

      if (is_vendor_acc == 1) {
        $("#accept").hide();
        $(".itp_detail").hide();
        $(".add_attch").attr('disabled', true);
        $("#file").hide();
        $(".add_attch").hide();
        $("#date_itp").attr('disabled', false);
      } else {
        $("#accept").show();
        $(".itp_detail").hide();
        $(".add_attch").attr('disabled', true);
        $("#file").hide();
        $(".add_attch").hide();
        $("#date_itp").attr('disabled', false);
      }
      while(arr_chekclist.length > 0) {
        arr_chekclist.pop();
      }
      $("#itp_user_rep").find('tr').remove();
      $("#get_item_selection").find('tr').remove();
      $("#item_selected").find('tr').remove();
      $("#get_attch_usrep").find('tr').remove();
      $('.data-repeater').remove();
      document.getElementById("itp_form").reset();
      $("#msr_number").val(idnya);
      $("#id_itp").val(idnya);

      // itp user representatif yg keseluruhan (dari PO)
      $.ajax({
        url: '<?= base_url('vn/info/Perform_itp/get_item_selection_userrep')?>',
        type: 'POST',
        dataType: 'JSON',
        data: {idnya: no_po}
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        if (result == true) {
          var usrrep_no = 0;
          var usrrep_str = '';
          var usr_reptotal_spending = [];
          var usrep_sum = 0;
          var usrep_sum_sisa = 0;
          $.each(res, function(index, el) {
            usrrep_no++;

            // hitung sisa persen per item
            var usrep_total_harga = el.priceunit*el.qty;
            var usrep_sisa = parseInt(usrep_total_harga)-parseInt(el.total);
            var usrep_sisa_persen = parseInt(100);
            if (usrep_sisa < usrep_total_harga) {
              var count_prc = (parseInt(el.sisa)/parseInt(usrep_total_harga) ) * 100;
              if (count_prc >= 100) {
                usrep_sisa_persen = 0;
              } else {
                usrep_sisa_persen = count_prc;
              }
            }

            usrep_sum += parseInt(el.total);
            usrep_sum_sisa += parseInt(el.sisa);
            usrrep_str = '<tr>'+
                    '<td>'+usrrep_no+'</td>'+
                    '<td>'+el.MATERIAL_NAME+'</td>'+
                    '<td><input type="hidden" id="usrep_qty'+el.MATERIAL+'" value="'+el.qty+'" />'+el.qty+'</td>'+
                    '<td>'+el.uom_desc+'</td>'+
                    '<td>'+numeral(el.priceunit).format('0,0')+'</td>'+
                    '<td><input id="usrep_total_harga'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right" type="text" value="'+numeral(usrep_total_harga).format('0,0')+'" readonly /></td>'+
                    '<td><input id="usrep_spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right" type="text" value="'+numeral(el.total).format('0,0')+'" readonly /></td>'+
                    '<td><input id="usrep_actual_spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right" type="text" value="0" readonly /></td>'+
                    '<td><input id="usrep_sisa'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right" name="usr_reptotal_spending[]" type="text" value="'+el.sisa+'" readonly /></td>'+
                    '<td><input id="usrep_persen_sisan'+el.MATERIAL+'" style="width: fit-content;" class="form-control" name="usrep_sisa_persen[]" type="text" value="'+Math.round(usrep_sisa_persen)+'%" readonly /></td>'+
                  '</tr>';
            $("#itp_user_rep").append(usrrep_str);
          });
        }
      });



      // itp user representatif yg telah dibuat
      $.ajax({
        url: '<?= base_url('vn/info/Perform_itp/get_item_selection') ?>',
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
          var total_remaining = [];
          var sum = 0;
          var sum_sisa = 0;
          $("#itp_no").html(res[0].itp_no)
          $("#nopo_htm").html(res[0].no_po);
          $.each(res, function(index, el) {
            $(".checklist_item"+el.MATERIAL).prop("disabled", false);
            $(".checklist_item"+el.MATERIAL).css({"background-color": "#dddddd", "color": "black"});
            $(".checklist_item"+el.MATERIAL).find('i').toggleClass('fa-square-o fa-check');
            // $(".savebtn").show();
            no++;
            var total_harga = el.priceunit*el.qty;

            var sisa = parseInt(total_harga)-parseInt(el.total);
            sum += parseInt(el.total);
            sum_sisa += parseInt(el.sisa);
            // console.log(sisa);

            total_value.push(parseInt(el.priceunit));
            total_spending.push(el.total);
            total_remaining.push(sum);
                str = '<tr>'+
                        '<td>'+no+'</td>'+
                        '<td>'+el.id_itemtype+'</td>'+
                        '<td>'+el.MATERIAL_NAME+'</td>'+
                        '<td><input type="hidden" id="qty'+el.MATERIAL+'" value="'+el.qty+'" />'+el.qty+'</td>'+
                        '<td>'+el.UOM1+'</td>'+
                        '<td>'+numeral(el.priceunit).format('0,0')+'</td>'+
                        '<td><input id="total_harga'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right" type="text" value="'+numeral(parseInt(total_harga)).format('0,0')+'" readonly /></td>'+
                        '<td><input id="spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right tdspending" type="text" value="'+numeral(parseInt(el.total)).format('0,0')+'" readonly /></td>'+
                        '<td><input id="sisa'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right tdremaining" name="total_spending[]" type="text" value="'+parseInt(el.sisa)+'" readonly /></td>'+
                        '<td><textarea name="remark[]" id="remark'+el.MATERIAL+'" class="form-control border-primary" rows="3" cols="30" placeholder="Input some note" disabled>'+el.remark+'</textarea></td>'+
                        '<td><button type="button" data-id="'+el.MATERIAL+'" onClick="get_id('+el.MATERIAL+', \''+el.id_itemtype+'\', \''+el.MATERIAL_NAME+'\', '+el.qty+', \''+el.UOM1+'\', '+el.priceunit+', '+total_harga+', '+no+', '+el.total+')" class="btn btn-sm btn-default checklist_item'+el.MATERIAL+'"><i class="fa fa-square-o"></i></button></td>'+
                      '</tr>';
            $("#get_item_selection").append(str);
            var sisone_item = $("#total_spending"+el.MATERIAL).val(sisa)
            // console.log(sisa);
            if (sisa == 0) {
              setTimeout(function(){
                $(".checklist_item"+el.MATERIAL).prop("disabled", true);
                $(".checklist_item"+el.MATERIAL).css({"background-color": "green", "color": "white"});
                $(".checklist_item"+el.MATERIAL).find('i').toggleClass('fa-square-o fa-check');
                // $(".savebtn").hide();
              },100);
            }

          });

          $(".itp_detail").hide();
          $("#file").hide();
          $(".add_attch").hide();
          // $(".savebtn").hide();
          // $("#accept").show();
          // $(".btn-reject").show();
          $("#date_itp").attr('disabled', true);
          // show itp data
          setTimeout(function(){
            $.ajax({
              url: '<?=base_url('procurement/Itp_approval/show_data_itp')?>',
              type: 'POST',
              dataType: 'json',
              data: {msr_no: $("#id_itp").val()}
            })
            .done(function() {
              result = true;
            })
            .fail(function() {
              result = false;
            })
            .always(function(res2) {
              if (result = true) {
                // $("#descTextarea").val(res.itp.note);
                $("#date_itp").val(res2.itp.dated);

                var no = 0;
                $.each(res2.itp_detail, function(index, el) {
                  $(".checklist_item"+el.data_itp_detail.material_id).prop("disabled", true);
                  no++;
                  var peng = $("#spending"+el.data_itp_detail.material_id).val();
                  // get_id(el.data_itp_detail.material_id, el.data_itp_detail.id_itemtype, el.data_itp_detail.MATERIAL_NAME, el.data_itp_detail.qty, el.data_itp_detail.uom, el.data_itp_detail.priceunit, el.data_itp_detail.total, no, peng, el.data_itp_detail.remark);
                  // console.log(el.data_itp_detail.material_id);
                });
                $.each(res2.itp_upload, function(indexx, dul) {
                  if (dul.data_itp_upload.filename == '-') {
                    var vfile = '';
                  } else {
                    var vfile = '<a href="<?= base_url('upload/ITP/')?>'+dul.data_itp_upload.filename+'" target="_blank"> View File</a>';
                  }

                  var vrm_btn = '-';
                  var get_attch = '<tr>'+
                              '<td>'+dul.data_itp_upload.type+'</td>'+
                              '<td>'+dul.data_itp_upload.filename+'</td>'+
                              '<td>'+dul.data_itp_upload.created_date+'</td>'+
                              '<td>'+vfile+'</td>'+
                              '<td> '+vrm_btn+' </td>'+
                            '</tr>';
                  $("#get_attch_usrep").append(get_attch);
                });
              }
            });
          },1000);

          var str2 = '<tr style="font-weight:bold;">'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9">TOTAL</td>'+
                        '<td bgcolor="white"><input type="hidden" id="total_actual" value="'+parseInt(total_value.reduce(getSum, 0))+'">'+numeral(total_value.reduce(getSum)).format('0,0')+'</td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control text-right" type="text" id="total_spending" onChange="change_total()" value="'+numeral(total_spending.reduce(getSum)).format('0,0')+'" readonly></td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control" type="hidden" id="total_remaining" onChange="change_total()" value="'+total_remaining.reduce(getSum)+'" readonly></td>'+
                        '<td bgcolor="white"></td>'+
                      '</tr>';
          $("#get_item_selection").append(str2);

          $("#total_remaining").val(sum_sisa);
          $("#total_spending").val(numeral(sum).format('0,0'));
        }

      });

    });
    // --------------------------------------------------------------------------------------- itp user representatif -----------------------------------------------------

    // --------------------------------------------------------------------------------------- itp user representatif -----------------------------------------------------


    // reject //
    $(document).on('show.bs.modal', '#modal_rej', function(e) {
      $('#myModal').modal('hide');
      document.getElementById("reject_mdl").reset();
      $('#modal_rej .modal-header').css("background", "#d9534f");
      $('#modal_rej .modal-header').css("color", "#fff");

      // var idnya = $(e.relatedTarget).data("id");
      var idnya = $(".reject_itp").val();
      console.log(idnya);


      $("#id_itp_rej").attr('disabled', false);
      $("#note").attr('disabled', false);
      $(".reject_data_close").attr('disabled', false);
      $(".reject_data").attr('disabled', false);
      $("#id_itp_rej").val(idnya);

      $("#reject_mdl").submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        var result;
        var xmodalx = modal_start($("#modal_rej").find(".modal-content"));

        $.ajax({
          url: '<?= base_url("vn/info/Perform_itp/reject_itp_doc")?>',
          type: 'POST',
          dataType: 'JSON',
          data: data,
          cache: false,
          processData: false,
          contentType: false,
        })
        .done(function() {
          result = true;
        })
        .fail(function() {
          result = false;
        })
        .always(function(res) {
          if (result = true) {
            if (res = true) {
              modal_stop(xmodalx);
              swal({
                      title: "Done",
                      text: "ITP Document Rejected",
                      type: "success",
                      showCancelButton: false,
                      confirmButtonColor: "#3085d6",
                      confirmButtonText: "Oke",
                      closeOnConfirm: true
                  },function () {
                    window.location.href = "<?= base_url()?>/vn/info/perform_itp";
              });
            } else {
              window.location.href = "<?= base_url()?>/vn/info/perform_itp";
            }
          }
        });
      });

    });
    // reject //


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
    $(".checklist_item"+itemid).find('i').toggleClass('fa-square-o fa-check');
    if (arr_chekclist.length > 0) {
      $("#save").prop('disabled', false);
    } else {
      $("#save").prop('disabled', true);
    }

    });


    $("#itp_form").submit(function(e){
      e.preventDefault();
      var data = new FormData(this);
      var resultx;
      data.append('date_itp', $("#date_itp").val());
      // console.log(data);
      if (parseInt($("#total_spending").val()) > parseInt($("#total_actual").val())) {
        swal("Ooopss", "Total ITP can't be more than Agreement, remaining value is "+( parseInt($("#total_actual").val()) - parseInt($("#total_spending").val()) ), "warning");
      } else {
        $.ajax({
          url: '<?= base_url('vn/info/Perform_itp/create_itp_document')?>',
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
            if (res == true) {
              swal({
                title: "Done",
                text: "Data is successfuly saved.",
                type: "success",
                showCancelButton: false,
                confirmButtonColor: "#3085d6",
                confirmButtonText: "Oke",
                closeOnConfirm: true
              },function () {
                window.location.href = "<?= base_url()?>/vn/info/perform_itp";
              });
            } else {
              swal("Ooopss", "Please check your input data!", "warning");
            }
            // console.log(res);
          }
        });

      }

    })


    $(document).on('click', '#accept', function(e) {
      // e.preventDefault();
      // var id_itp = $(this).data("id");
      var id_itp = $(".reject_itp").val();
      // console.log(id_itp);
      swal({
        title: "Are you sure?",
        text: "You will accept this ITP Document !",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: '#0072cf',
        confirmButtonText: 'Accept',
        closeOnConfirm: true,
        closeOnCancel: true
      },
      function(){
        var result;
        $.ajax({
          url: '<?= base_url('vn/info/Perform_itp/accept_document_itp')?>',
          type: 'post',
          dataType: 'json',
          data: {id_itp: id_itp}
        })
        .done(function() {
          result = true;
        })
        .fail(function() {
          result = false;
        })
        .always(function(res) {
          if (result = true) {
            if (res == true) {
              setTimeout(function(){
                swal({
                  title: "ITP Accepted",
                  text: "ITP No "+$("#itp_no").text()+' will be processed',
                  type: "success",
                  showCancelButton: false,
                  confirmButtonColor: '#0072cf',
                  confirmButtonText: 'Oke',
                  closeOnConfirm: true,
                  closeOnCancel: false
                },
                function(){
                  window.location.href = "<?= base_url()?>/vn/info/perform_itp";
                });
              },300)
            } else {
              window.location.href = "<?= base_url()?>/vn/info/perform_itp";
            }

          } else {
            window.location.href = "<?= base_url()?>/vn/info/perform_itp";
          }
        });

      });

    });
    ////////////////////////////////////////////////////////////////// hole process /////////////////////////////////////////////////////////////////////////////




    // show data
    $('#tbl1 tfoot th').each(function (i) {
            var title = $('#tbl1 thead th').eq($(this).index()).text();
            $(this).html('<input type="text" placeholder="Search ' + title + '" data-index="' + i + '" />');
    });
    var table=$('#tbl1').DataTable({
        "ajax": {
            "url": "<?= base_url('vn/info/Perform_itp/datatable_itpuser_remaining') ?>",
            "dataSrc": ""
        },
        "data": null,
        "searching": true,
        "paging": true,
        "columns": [
          {title: "<center>No</center>"},
          {title: "<center><?= lang("No Persetujuan", "Agrement No") ?></center>"},
          {title: "<center><?= lang("ITP No", "ITP No") ?></center>"},
          {title: "<center><?= lang("Contractor", "Contractor") ?></center>"},
          {title: "<center><?= lang("Status", "Status") ?></center>"},
          {title: "<center><?= lang("Tgl Dokumen Dibuat", "Date Created Document") ?></center>"},
          {title: "<center><?= lang("Aksi", "Action") ?></center>"}
        ],
        "columnDefs": [
            {"className": "dt-center", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
            {"className": "dt-center", "targets": [6]},
        ]
    });
    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });

    // show data


  });

  function get_id(id, type, desc, qty, uom, unitprice, total_harga, no, pengeluaranx){
    // console.log(el);
    $(".checklist_item"+id).prop("disabled", true);
    $(".checklist_item"+id).css({"background-color": "green", "color": "white"});
    $(".checklist_item"+id).find('i').toggleClass('fa-square-o fa-check');

    var str = '<tr>'+
                '<td><input style="width: fit-content;" class="form-control" type="hidden" name="material_id[]" value="'+id+'" readonly />'+no+'</td>'+
                '<td><input style="width: fit-content;" class="form-control" type="hidden" name="item_type[]" value="'+type+'" readonly />'+type+'</td>'+
                '<td><input style="width: fit-content;" class="form-control" type="hidden" name="price_unit[]" value="'+unitprice+'" readonly />'+desc+'</td>'+
                '<td><input style="width: fit-content;" class="form-control" id="qty2'+id+'" type="text" name="item_qty[]" onKeyup="change('+id+', '+unitprice+', '+total_harga+', '+pengeluaranx+')" value="0" required /></td>'+
                '<td>'+uom+'</td>'+
                '<td><input style="width: fit-content;" class="form-control" id="spending2'+id+'" type="text" name="item_ammount[]" value="0" onChange="change('+id+', '+total_harga+')" readonly /></td>'+
                '<td><textarea name="remark[]" class="form-control border-primary" id="remark'+id+'" rows="3" cols="30" placeholder="Input some note"></textarea></td>'+
                '<td><button type="button" data-id="'+id+'" id="remove_item" class="btn btn-sm btn-danger">Remove</button></td>'+
              '</tr>';
    $("#item_selected").append(str);
    input_numberic('#spending2'+id, true);

    arr_chekclist.push(id);
    // console.log(arr_chekclist);
    if (arr_chekclist.length > 0) {
      $("#save").prop('disabled', false);
    } else {
      $("#save").prop('disabled', true);
    }

  }

  function change(id, unitprice, total_hargax, pengeluaranx){
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
  }

  function change_total(){
    // var total_spending = $("#total_spending").val();
    // var total_remaining = $("#total_remaining").val();

  }

  function getSum(total, num) {
    return total + Math.round(num);
  }
</script>
