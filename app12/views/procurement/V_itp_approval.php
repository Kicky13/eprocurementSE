
<div class="app-content content itp_approval">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Persetujuan ITP Document", "ITP Document Approval") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Persetujuan ITP Document", "ITP Approval") ?></li>
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
                                                        <th><center>Agrement No</center></th>
                                                        <th><center> No</center></th>
                                                        <th><center><?= lang("Jabatan", "Position") ?></center></th>
                                                        <th><center><?= lang("ITP Note", "ITP Note") ?></center></th>
                                                        <th><center>Status</center></th>
                                                        <th><center>Action</center></th>
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
                                                        <th><center><?= lang("Tipe", "Type") ?></center></th>
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
        <div class="modal-content">

              <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel1">ITP Approval</h4>
                <button type="button" class="close closemodal" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">×</span>
                </button>
              </div>
                <div class="modal-body">
                  <div class="row info-header">
                    <div class="col-md-6">
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
                          <table class="table table-responsive">
                            <tbody>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("Departemen", "Departement"); ?></th>
                                <td> <span id="dept_htm"></span> </td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("Tanggal", "Date"); ?></th>
                                <td colspan="5"><input type="text" name="date_itp" id="date_itp" class="form-control" value="" required> <span id=""></span>  </td>
                              </tr>
                              <tr>
                                <th class="text-nowrap" scope="row"><?= lang("ITP to", "ITP to"); ?></th>
                                <td colspan="5"><span id="itp_ke"></span></td>
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
                      <form id="itp_form" action="#" class="steps-validation wizard-circle" enctype="multipart/form-data">
                        <div class="card-content">
                          <div class="card-body">
                            <ul class="nav nav-tabs nav-top-border no-hover-bg">
                              <li class="nav-item">
                                <a class="nav-link active" id="base-tab11" data-toggle="tab" aria-controls="tab11"
                                href="#tab11" aria-expanded="true">Information</a>
                              </li>
                              <li class="nav-item">
                                <a class="nav-link" id="base-tab12" data-toggle="tab" aria-controls="tab12" href="#tab12"
                                aria-expanded="false">Attachment</a>
                              </li>
                            </ul>

                            <div class="tab-content px-1 pt-1">
                              <div role="tabpanel" class="tab-pane active" id="tab11" aria-expanded="true" aria-labelledby="base-tab11">
                              <input type="hidden" id="sequence" name="sequence" value="">
                              <input type="hidden" id="idx" name="idx" value="">
                              <input type="hidden" id="user_roles" name="user_roles" value="">
                              <input type="hidden" id="id_itp" name="id_itp" value="">
                              <input type="hidden" id="email_approve" name="email_approve" value="">
                              <input type="hidden" id="edit_content" name="edit_content" value="">
                              <input type="hidden" id="vendor_email" name="vendor_email" value="">
                              <input type="hidden" id="itp_total" name="itp_total" value="">
                              <input type="hidden" id="itp_number_to" name="itp_number_to" value="">

                              <h2 class="m-b-md"><?= lang("Item Selection :", "Item Selection :"); ?></h2>
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
                                      <th><?= lang("Checklist", "Checklist") ?></th>
                                    </tr>
                                  </thead>
                                  <tbody id="get_item_selection">

                                  </tbody>
                                </table>
                              </div>

                              <h2 class="m-b-md"><?= lang("Item Selected to ITP", "Item Selected to ITP"); ?></h2>
                              <div class="row">
                                <input type="hidden" id="msr_number" name="msr_number" value="">
                                <table id="tbl_item_selected" class="table table-bordered table-striped table-responsive" width="100%">
                                  <thead>
                                    <tr>
                                      <th>No</th>
                                      <th><?= lang("Deskripsi", "Description") ?></th>
                                      <th><?= lang("Qty", "Qty") ?></th>
                                      <th><?= lang("UOM", "UOM") ?></th>
                                      <th><?= lang("Estimate ITP Ammount", "Estimate ITP Ammount") ?></th>
                                      <th><?= lang("Catatan", "Note") ?></th>
                                      <th>Action</th>
                                    </tr>
                                  </thead>
                                  <tbody id="item_selected">

                                  </tbody>
                                </table>
                                <div class="col-sm-12">
                                  <!-- <h2 class="m-b-md"><?= lang("Catatan :", "Note :"); ?></h2> -->
                                  <input type="hidden" class="form-control" id="descTextarea" rows="3" name="note" placeholder="Write Note Here" readonly></input>
                                </div>
                              </div>
                              </div>
                              <div class="tab-pane" id="tab12" aria-labelledby="base-tab12">
                                  <h2 class="m-b"><?= lang("File Attachment", "File Attachment"); ?></h2>
                                  <div class="card-content">
                                    <div class="table-responsive">
                                      <table class="table table-xs">
                                        <thead>
                                          <th style="height: 50px;"><?= lang("Tipe", "Type") ?></th>
                                          <th style="height: 50px;"><?= lang("Nama File", "File Name") ?></th>
                                          <th style="height: 50px;"><?= lang("Uploaded At", "Uploaded At") ?></th>
                                          <th style="height: 50px;"><?= lang("Lihat File", "View File") ?></th>
                                          <th style="height: 50px;">Action</th>
                                        </thead>
                                        <tbody id="get_attch">

                                        </tbody>
                                      </table>
                                    </div>
                                  </div>

                                  <br>
                                  <div class="form-group col-12 mb-2 divupload">
                                    <div data-repeater-list="repeater-list">
                                      <div data-repeater-list="repeater-list">
                                        <div data-repeater-item="" style="" id="file-repeater">
                                          <div class="row mb-1 ">
                                            <div class="col-9 col-xl-10">
                                              <label class="file center-block">
                                                <input style="width: fit-content;" class="form-control" type="file" name="file_attch[]" id="file" disabled>
                                                <span class="file-custom"></span>
                                              </label>
                                            </div>
                                            <div class="col-2 col-xl-1">
                                              <!-- <button type="button" data-repeater-delete="" class="btn btn-icon btn-danger mr-1 remove_attch"><i class="fa fa-times"></i></button> -->
                                            </div>
                                          </div>
                                        </div>
                                      </div>
                                    </div>
                                    <button type="button" data-repeater-create="" class="btn btn-primary add_attch">
                                      <i class="fa fa-plus"></i> Add new file
                                    </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->

                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default closemodal" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" data-id="" data-code="" id="prosesreject" data-toggle="modal" data-target="#modal_rej" class="btn btn-danger" title="Reject"> Reject</button>
                    <button type="submit" class="btn btn-primary" id="save"><?= lang('Approve', 'Approve') ?></button>
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
                    <input type="hidden" name="id_rej" id="id_rej" value="">
                    <input type="hidden" name="id_itp_rej" id="id_itp_rej" value="">
                    <input type="hidden" name="user_roles_rej" id="user_roles_rej" value="">
                    <input type="hidden" name="email_approve_rej" id="email_approve_rej" value="">
                    <input type="hidden" name="edit_content_rej" id="edit_content_rej" value="">
                    <input type="hidden" name="email_reject_rej" id="email_reject_rej" value="">
                    <input type="hidden" name="sequence_rej" id="sequence_rej" value="">
                    <input type="hidden" name="status_approve_rej" id="status_approve_rej" value="">
                    <input type="hidden" name="reject_step_rej" id="reject_step_rej" value="">

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
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-danger"><?= lang("Tolak Data", "Reject") ?></button>
            </div>
        </form>
    </div>
</div>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.min.js"></script>
<!-- <script src="<?= base_url()?>ast11/app-assets/js/scripts/forms/wizard-steps.js" type="text/javascript"></script> -->

<script type="text/javascript">
var arr_chekclist = new Array();
  $(document).ready(function() {
    // $("#save").hide();
    $(".itp_agrement").hide();
    // $( "#date_itp" ).datepicker();

    var arr_file = new Array();

    ////////////////////////////////////////////////////////////////// hole process /////////////////////////////////////////////////////////////////////////////
    $(document).on('show.bs.modal', '#myModal', function(e){
      // e.preventDefault();
      //$('#myModal .modal-header').css("background", "#1c84c6");
      //$('#myModal .modal-header').css("color", "#fff");

      var xmodalx = modal_start($("#myModal").find(".modal-content"));

      while(arr_file.length > 0) {
          arr_file.pop();
      }

      var idnya = $(e.relatedTarget).data("id");
      var code = $(e.relatedTarget).data("code");
      $("#agrm_no").val(idnya);
      $("#agreement_htm").html(idnya);

      $("#prosesreject").attr('data-id', idnya);
      $("#prosesreject").attr('data-code', code);

      var result;
      var speding = 0;
      document.getElementById("itp_form").reset();

      $("#get_item_selection").find('tr').remove();
      $("#item_selected").find('tr').remove();
      $("#get_attch").find('tr').remove();
      $(".data-repeater").remove();
      $("#msr_number").val(idnya);

      var al = code.split("|");
      $("#sequence").val(al[6]);
      $("#idx").val(al[0]);
      $("#id_itp").val(al[1]);
      $("#user_roles").val(al[2]);
      $("#email_approve").val(al[3]);
      $("#edit_content").val(al[4]);

      // alert(idnya);
      $.ajax({
        url: '<?= base_url('procurement/Itp_approval/get_item_selection') ?>',
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
          $("#vendor").val(res[0].vendor)
          $("#contractor_htm").html(res[0].vendor)
          $("#comp_htm").html(res[0].dt_comp.company_desc)
          $("#id_vendor").val(res[0].id_vendor)
          $("#dept_htm").html(res[0].dt_comp.DEPARTMENT_DESC)
          $("#itp_total").val(res[0].receipt.itp_total);

          $.each(res, function(index, el) {
            $(".checklist_item"+el.MATERIAL).prop("disabled", true);
            $(".checklist_item"+el.MATERIAL).css({"background-color": "#dddddd", "color": "black"});
            no++;
            // hitung sisa persen per item
            var total_harga = el.priceunit*el.qty;
            var sisa = parseInt(total_harga)-parseInt(el.total);
            var sisa_persen = parseInt(100);
            if (sisa < total_harga) {
              var count_prc = (parseInt(el.sisa)/parseInt(total_harga) ) * 100;
              if (count_prc == 100) {
                sisa_persen = 0;
              } else {
                sisa_persen = count_prc;
              }
            }
            sum += parseInt(el.total);
            sum_sisa += parseInt(el.sisa);
            // console.log(sum);

            total_value.push(parseInt(total_harga));
            total_spending.push(el.total);
            total_remaining.push(sum);
            str = '<tr>'+
                    '<td>'+no+'</td>'+
                    '<td>'+el.MATERIAL_NAME+'</td>'+
                    '<td><input type="hidden" id="qty'+el.MATERIAL+'" value="'+el.qty+'" readonly/>'+el.qty+'</td>'+
                    '<td>'+el.uom_desc+'</td>'+
                    '<td>'+numeral(el.priceunit).format('0,0')+'</td>'+
                    '<td><input id="total_harga'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right" type="text" value="'+numeral(parseInt(total_harga)).format('0,0')+'" readonly /></td>'+
                    '<td><input id="spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right tdspending" type="text" value="'+numeral(el.total).format('0,0')+'" readonly /></td>'+
                    '<td><input id="actual_spending'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right tdspending" type="text" value="0" readonly /></td>'+
                    '<td><input id="sisa'+el.MATERIAL+'" style="width: fit-content;" class="form-control text-right tdremaining" name="total_spending[]" type="text" value="'+numeral(el.sisa).format('0,0')+'" readonly /></td>'+
                    '<td><input id="persen_sisan'+el.MATERIAL+'" style="width: fit-content;" class="form-control tdremaining" name="sisa_persen[]" type="text" value="'+Math.round(sisa_persen)+'%" readonly /></td>'+
                    '<td><button type="button" data-id="'+el.MATERIAL+'" onClick="get_id('+el.MATERIAL+', \''+el.id_itemtype+'\', \''+el.MATERIAL_NAME+'\', '+el.qty+', \''+el.UOM1+'\', '+el.priceunit+', '+total_harga+', '+no+', '+el.total+')" class="btn btn-sm btn-default checklist_item'+el.MATERIAL+'"><i class="fa fa-check"></i></button></td>'+
                  '</tr>';
        $("#get_item_selection").append(str);
            var sisone_item = $("#total_spending"+el.MATERIAL).val(sisa)
            // console.log(sisa);
            $(".checklist_item"+el.MATERIAL).prop("disabled", true);
            if (sisa == 0) {
              $(".checklist_item"+el.MATERIAL).prop("disabled", true);
              $(".checklist_item"+el.MATERIAL).css({"background-color": "#dddddd", "color": "black"});
            }
            setTimeout(function(){
              console.log("Open Input : "+al[4]);
              if (parseInt(al[4]) == 1) {
                $("#prosesreject").hide();
                $(".add_attch").prop('disabled', false);
                // $("#qty2"+el.MATERIAL).prop('readonly', false);
                $("#descTextarea").prop('readonly', false);
                $("#file").prop('disabled', false);
                $(".remove_item"+parseInt(el.MATERIAL)).prop('disabled', true);
                // $("#qty2"+parseInt(el.MATERIAL)).attr('readonly', false);
                // $("#remark"+parseInt(el.MATERIAL)).attr('readonly', false);
                $(".openform").prop('readonly', false)
                $("#date_itp").prop('disabled', false);
                $("#save").text('Re Submit');
                console.log("on");
              } else {
                console.log("off");
                $("#prosesreject").show();
                $(".add_attch").prop('disabled', true);
                // $("#qty2"+el.MATERIAL).prop('readonly', true);
                $("#descTextarea").prop('readonly', true);
                $("#file").prop('disabled', true);
                $(".remove_item"+parseInt(el.MATERIAL)).prop('disabled', true);
                // $("#qty2"+parseInt(el.MATERIAL)).prop('readonly', true);
                // $("#remark"+parseInt(el.MATERIAL)).prop('readonly', true);
                $(".openform").prop('readonly', true)
                $("#date_itp").prop('disabled', true);
                $("#save").text('Approve');

              }
              modal_stop(xmodalx)
            },1500);
          });

          // hitung sisa persen
          var total_rem_persen = parseInt(100);
          if (total_spending.reduce(getSum, 0) > 0) {
            var count = (total_spending.reduce(getSum, 0) / total_value.reduce(getSum, 0) ) * 100;
            if (count == 100) {
              total_rem_persen = 0;
            } else {
              total_rem_persen = count;
            }
          }
          var str2 = '<tr style="font-weight:bold;">'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9"></td>'+
                        '<td bgcolor="#f4f6f9">TOTAL</td>'+
                        '<td bgcolor="white" class="text-right"><input type="hidden" id="total_actual" name="total_actual" value="'+parseInt(total_value.reduce(getSum, 0))+'">'+numeral(total_value.reduce(getSum)).format('0,0')+'</td>'+
                        '<td bgcolor="white" class="text-right"><input style="width: fit-content;" class="form-control" type="hidden" id="total_spending" onChange="change_total()" value="'+numeral(total_spending.reduce(getSum, 0)).format('0,0')+'" readonly><input type="hidden" id="total_spending_ori" name="total_sebelumnya" value="'+total_spending.reduce(getSum, 0)+'" readonly>'+numeral(total_spending.reduce(getSum, 0)).format('0,0')+'</td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control text-right" type="text" id="total_actual_sisa" onChange="change_total()" value="0" readonly></td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control text-right" type="text" id="total_remaining" onChange="change_total()" value="'+numeral(sum_sisa).format('0,0')+'" readonly></td>'+
                        '<td bgcolor="white"><input style="width: fit-content;" class="form-control" type="text" id="" value="'+Math.round(total_rem_persen)+'%" readonly></td>'+
                      '</tr>';
          $("#get_item_selection").append(str2);
          // $("#total_remaining").val(sum_sisa);
          $("#total_spending").val(sum);
        }

      });

      $("#descTextarea").val("");
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
        .always(function(res) {
          if (result = true) {
            $("#descTextarea").val(res.itp.note);
            $("#date_itp").val(res.itp.dated);
            $("#itp_ke").html(res.itp.number_of)
            $("#itp_number_to").val(res.itp.number_of)

            var usrrep_str = '';
            var total_itemsel = [];

            var no = 0;
            $.each(res.itp_detail, function(index, el) {
              no++;
              var peng = $("#spending"+el.data_itp_detail.material_id).val();
              get_id(el.data_itp_detail.material_id, el.data_itp_detail.id_itemtype, el.data_itp_detail.MATERIAL_NAME, el.data_itp_detail.qty, el.data_itp_detail.uom, el.data_itp_detail.priceunit, el.data_itp_detail.total, no, peng, el.data_itp_detail.remark);
              // console.log(el.data_itp_detail.material_id);
              total_itemsel.push(parseInt(el.data_itp_detail.total));
              usrrep_str = '<tr style="font-weight:bold;">'+
                            '<td bgcolor="#f4f6f9"></td>'+
                            '<td bgcolor="#f4f6f9"></td>'+
                            '<td bgcolor="#f4f6f9"></td>'+
                            '<td bgcolor="#f4f6f9">TOTAL</td>'+
                            '<td class="text-right">'+numeral(total_itemsel.reduce(getSum)).format('0,0')+'</td>'+
                          '</tr>';
            });
            $("#item_selected").append(usrrep_str);

            $.each(res.itp_upload, function(indexx, dul) {
              if (dul.data_itp_upload.filename == '-') {
                var vfile = '';
              } else {
                var vfile = '<a href="<?= base_url('upload/ITP/')?>'+dul.data_itp_upload.filename+'" target="_blank"> View File</a>';
              }

              if (al[4] == 1) {
                var vrm_btn = '<button type="button" data-id="'+dul.data_itp_upload.filename+'" id="rm_file" class="btn btn-sm btn-danger btn-block">Remove</button>';
              } else {
                var vrm_btn = '-';
              }
              var get_attch = '<tr>'+
                          '<td>'+dul.data_itp_upload.type+'</td>'+
                          '<td>'+dul.data_itp_upload.filename+'</td>'+
                          '<td>'+dul.data_itp_upload.created_date+'</td>'+
                          '<td>'+vfile+'</td>'+
                          '<td> '+vrm_btn+' </td>'+
                        '</tr>';
              $("#get_attch").append(get_attch);
            });
          }

        });
      },1000);

    });

    $(document).on('click', '#remove_item', function(e) {
    // e.preventDefault();
    // var itemid = $(e.relatedTarget).data("id");
    var itemid = $(this).data("id");
    $(this).closest('tr').remove();
    // console.log(itemid);
    $(".checklist_item"+itemid).prop("disabled", true);
    $(".checklist_item"+itemid).css({"background-color": "#dddddd", "color": "black"});
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
          '<button type="button" data-repeater-delete="" class="btn btn-icon btn-danger mr-1 remove_attch"><i class="fa fa-times" disabled></i></button>'+
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

    $(document).on('click', '#rm_file', function(e) {
      // e.preventDefault();
      // arr_file.length = 0;

      var idnya = $(this).data("id");
      $(this).closest('tr').remove();

      arr_file.push(idnya);
      // console.log(arr_file);
    });

    $("#itp_form").submit(function(e){
      e.preventDefault();
      // console.log(parseInt($("#total_spending").val()));
      // console.log((parseInt($("#total_spending").val()) + parseInt($("#itp_total").val())) > parseInt($("#total_actual").val()));
      // if ((parseInt($("#total_spending").val()) + parseInt($("#itp_total").val())) > parseInt($("#total_actual").val())) {
      //   swal("Ooopss", "Total ITP can't be more than Agreement, remaining value is "+( parseInt($("#total_actual").val()) - parseInt($("#total_spending").val()) ), "warning");
      //
      // } else {
      //
      // }

      var xmodalx = modal_start($("#myModal").find(".modal-content"));

      var data = new FormData(this);
      for (var i = 0; i < arr_file.length; i++) {
        // formData.append('arr[]', arr[i]);
        data.append('rm_file[]', arr_file[i]);
      }

      data.append('date_itp', $("#date_itp").val());

      var resultx;
      $.ajax({
        url: '<?= base_url('procurement/Itp_approval/itp_doc_approval')?>',
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
          // console.log(res);
          // console.log(data);
          if (res.success == true) {
            swal({
              title: "Done",
              text: "Data is successfuly saved.",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: "#3085d6",
              confirmButtonText: "OK",
              closeOnConfirm: true
            },function () {
              window.location.href = "<?= base_url()?>/procurement/itp_approval";
            });
          } else {
            swal("Ooopss", "Total ITP can't be more than Agreement, Agreement value is "+( parseInt($("#total_actual").val()) ), "warning");
          }
        } else {
          modal_stop(xmodalx);
          // swal("warning", "Oppsss", "Something Wrong !");
          window.location.href = "<?= base_url()?>/procurement/itp_approval";
        }
      });

    })

    // reject //
    $(document).on('show.bs.modal', '#modal_rej', function(e) {
      $("#myModal").modal("toggle");
      document.getElementById("reject_mdl").reset();
      var idnya = $(e.relatedTarget).data("id");
      var code = $(e.relatedTarget).data("code");

      $('#modal_rej .modal-header').css("background", "#d9534f");
      $('#modal_rej .modal-header').css("color", "#fff");

      var al = code.split("|");

      $("#id_rej").val(al[0]);
      $("#id_itp_rej").val(al[1]);
      $("#user_roles_rej").val(al[2]);
      $("#email_approve_rej").val(al[3]);
      $("#edit_content_rej").val(al[4]);
      $("#email_reject_rej").val(al[5]);
      $("#sequence_rej").val(al[6]);
      $("#status_approve_rej").val(al[7]);
      $("#reject_step_rej").val(al[8]);
      console.log(al);

      $("#reject_mdl").submit(function(e) {
        e.preventDefault();
        var data = new FormData(this);
        var result;
        var xmodalx = modal_start($("#modal_rej").find(".modal-content"));

        $.ajax({
          url: '<?= base_url("procurement/Itp_approval/reject_itp_doc")?>',
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
                      confirmButtonText: "OK",
                      closeOnConfirm: false
                  },function () {
                    window.location.href = "<?= base_url()?>/procurement/itp_approval";
              });
            } else {
              window.location.href = "<?= base_url()?>/procurement/itp_approval";
            }
          }
        });
      });

    });
    // reject //
    ////////////////////////////////////////////////////////////////// hole process /////////////////////////////////////////////////////////////////////////////

    // show data
    $('#tbl tfoot th').each(function (i) {
        var title = $('#tbl thead th').eq($(this).index()).text();
        if ($(this).text() == 'No') {
          $(this).html('');
        } else if ($(this).text() == 'Action') {
          $(this).html('');
        } else {
          $(this).html('<input type="text" class="form-control" placeholder="Search ' + title + '" data-index="' + i + '" />');
        }
    });
    var table=$('#tbl').DataTable({
        "ajax": {
            "url": "<?= base_url('procurement/Itp_approval/datatable_list_itp_on_progress') ?>",
            "dataSrc": ""
        },
        "data": null,
        "searching": true,
        "paging": true,
        "columns": [
          {title: "<center>No</center>"},
          {title: "<center><?= lang("Agrement No", "Agrement No") ?></center>"},
          {title: "<center><?= lang("ITP Ke", "ITP To") ?></center>"},
          {title: "<center><?= lang("Agrement Title", "Agrement Title") ?></center>"},
          {title: "<center><?= lang("Jabatan", "Position") ?></center>"},
          {title: "<center><?= lang("Status", "Status") ?></center>"},
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
        ]
    });
    $(table.table().container()).on('keyup', 'tfoot input', function () {
      table.column($(this).data('index')).search(this.value).draw();
    });

  });

  function get_id(id, type, desc, qty, uom, unitprice, total_harga, no, pengeluaranx, remark){
    // console.log(el);
    setTimeout(function(){
      $(".checklist_item"+id).prop("disabled", true);
      $(".checklist_item"+id).css({"background-color": "#dddddd", "color": "black"});
    },1000);

    var str = '<tr>'+
                '<td><input style="width: fit-content;" class="form-control" type="hidden" name="material_id[]" value="'+id+'" readonly />'+no+'</td>'+
                '<td><input style="width: fit-content;" class="form-control" type="hidden" name="price_unit[]" value="'+unitprice+'" readonly />'+desc+'</td>'+
                '<td><input style="width: fit-content;" class="form-control openform" id="qty2'+id+'" type="text" name="item_qty[]" onKeyup="change('+id+', '+unitprice+', '+total_harga+', '+pengeluaranx+')" value="'+qty+'" readonly /></td>'+
                '<td>'+uom+'</td>'+
                '<td><input style="width: fit-content;" class="form-control text-right" id="spending2'+id+'" type="text" name="item_ammount[]" value="'+numeral(total_harga).format("0,0")+'" readonly required /></td>'+
                '<td><textarea class="form-control required openform" name="remark[]" id="remark'+id+'" rows="5" cols="140" placeholder="Input some note" readonly>'+remark+'</textarea></td>'+
                '<td><button type="button" data-id="'+id+'" id="remove_item" class="btn btn-sm btn-danger remove_item'+id+'" disabled>Remove</button></td>'+
              '</tr>';
    $("#item_selected").append(str);
    input_numberic('#spending2'+id, true);
  }

  function change(id, unitprice, total_hargax, pengeluaranx){
    var spending2 = $("#spending2"+id).val();

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
