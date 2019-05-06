<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<!-- <link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet"> -->
<link rel="stylesheet" href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css"/>
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Buat Permintaan Material", "Create Material Request") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Permintaan Material", "Material Request") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Buat Permintaan Material", "Create Material Request") ?></li>
                    </ol>
                </div>
            </div>
        </div>

        <!-- section tabel -->
        <div class="table_mreq" id="">
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
                                                  <button aria-expanded="false" id="add" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?= lang("Tambah", "Add") ?></button>
                                              </h5>
                                          </div>
                                      </div>
                                  </div>
                              </div>


                              <div class="card-content collapse show">
                                  <div class="card-body card-dashboard">
                                      <div class="row">
                                          <div class="col-md-12">
                                              <table id="tbl" class="table table-striped table-bordered table-fixed-column order-column dataex-lr-fixedcolumns table-hover display" width="100%">
                                                  <tfoot>
                                                      <tr>
                                                          <th><center>No</center></th>
                                                          <th><center>Req No</center></th>
                                                          <th><center>Req Date</center></th>
                                                          <th><center>Branch/Plant</center></th>
                                                          <th><center>Material Request Type</center></th>
                                                          <th><center>To Branch/Plant</center></th>
                                                          <th><center>Purpose of Request</center></th>
                                                          <th><center>Accounting Charge</center></th>
                                                          <th><center><?= lang("Status", "Status") ?></center></th>
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
        <!-- //section form -->

        <!-- section form -->
        <div class="form_mreq" id="">
          <form class="form form-horizontal mreq_form">
          <div class="row">
            <div class="col-md-12">
              <div class="card-header" style="background-color:#d3f7ef">
                  <div class="col-12 row">
                      <div class="col-8">
                          <h3 class="content-header-title mb-1"><?= lang("Permintaan Material", "Material Request") ?><span id="company"></span></h3>
                      </div>
                      <div class="col-sm-8">
                          <h5><?= $this->session->NAME; ?></h5>
                          <h5><?= $company->row()->DEPARTMENT_DESC; ?></h5>
                      </div>
                      <div class="col-sm-4">
                          <h5>Material Request No  : <strong><?= $req_no->row()->req_no; ?></strong></h5>
                          <h5>Request Date  : <strong><?= date("d M Y"); ?></strong></h5>
                      </div>
                      <input type="hidden" name="mr_no" value="<?= $req_no->row()->req_no; ?>">
                      <input type="hidden" name="comp_code" value="<?= $this->session->COMPANY ?>">
                      <input type="hidden" name="user" value="<?= $this->session->ID_USER; ?>">
                  </div>
                </div>
                <div class="card">
                    <div class="card-content collpase show">
                        <div class="card-body">

                                <div class="form-body">

                                    <h4 class="form-section"><i class="ft-mail"></i> <?= lang("Permintaan Material", "Material Request") ?></h4>

                                    <div class="row">
                                        <div class="col-md-6">

                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput5">Purpose of Request</label>
                                                <div class="col-md-9">
                                                    <textarea id="issue" rows="6" class="form-control border-primary" name="issue" placeholder="Issue for ICT" required></textarea>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                                <label class="col-md-3 label-control" for="userinput6">Material Request Type</label>
                                                <div class="col-md-9">
                                                  <select class="form-control mr_type" style="width:350px !important;" name="mr_type" required>
                                                    <option value=""> Select .. </option>
                                                    <?php
                                                    foreach ($mr_type->result_array() as $arr) { ?>
                                                      <option value="<?= $arr['id']?>"><?= $arr['description'] ?></option>
                                                    <?php } ?>
                                                  </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                          <div class="form-group row">
                                            <label class="col-md-3 label-control" for="userinput8">Accounting Charge</label>
                                            <div class="col-md-9">
                                              <select class="form-control dept" style="width:350px !important;" name="dept" required>
                                                <option value=""> Select .. </option>
                                                <?php
                                                foreach ($dept->result_array() as $arr) { ?>
                                                  <option value="<?= $arr['ID_DEPARTMENT']."|".$arr['DEPARTMENT_ABR'] ?>"><?= $arr['ID_DEPARTMENT']." - ".$arr['DEPARTMENT_ABR'] ?></option>
                                                <?php } ?>
                                              </select>
                                            </div>
                                          </div>

                                          <!-- to branch plant -->
                                          <div class="to_branch_plant_div">
                                            <div class="form-group row">
                                                <label class="col-md-3 label-control">From Branch/Plant</label>
                                                <div class="col-md-9">
                                                  <select class="form-control bp" style="width:350px !important;" name="bp" required>
                                                    <option value=""> Select .. </option>
                                                    <?php
                                                    foreach ($bp->result_array() as $arr) { ?>
                                                      <option value="<?= $arr['ID_BPLANT']?>"><?= $arr['BPLANT_ABR'] ?></option>
                                                    <?php } ?>
                                                  </select>
                                                </div>
                                            </div>

                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">To Branch/Plant</label>
                                              <div class="col-md-9">
                                                <select class="form-control to_branch_plant" style="width:350px !important;" name="to_branch_plant" >
                                                  <option value=""> Select .. </option>
                                                  <?php
                                                  foreach ($bp->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['ID_BPLANT']?>"><?= $arr['BPLANT_ABR'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>

                                          <!-- to company -->
                                          <div class="to_company_div">
                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">From Company</label>
                                              <div class="col-md-9">
                                                <select class="form-control from_company" style="width:350px !important;" name="from_company" >
                                                  <option value=""> Select .. </option>
                                                  <?php
                                                  foreach ($to_comp->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['ID_COMPANY'] ?>"><?= $arr['DESCRIPTION'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>

                                            <div class="form-group row">
                                              <label class="col-md-3 label-control" for="userinput8">To Company</label>
                                              <div class="col-md-9">
                                                <select class="form-control to_company" style="width:350px !important;" name="to_company" >
                                                  <option value=""> Select .. </option>
                                                  <?php
                                                  foreach ($to_comp->result_array() as $arr) { ?>
                                                    <option value="<?= $arr['ID_COMPANY'] ?>"><?= $arr['DESCRIPTION'] ?></option>
                                                  <?php } ?>
                                                </select>
                                              </div>
                                            </div>
                                          </div>


                                        </div>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                <table class="table table-bordered table-striped">
                                    <thead style="background-color:#d3f7ef">
                                        <tr>
                                            <th>SEMIC</th>
                                            <th><?= lang("Deskripsi", "Description"); ?></th>
                                            <th><?= lang("Matauang","Currency")?></th>
                                            <th>UOM</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Qty &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Unit Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; To Unit Cost &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th>Extended Ammount</th>
                                            <th>To Extended Ammount</th>
                                            <th>From Location</th>
                                            <th>To Location</th>
                                            <th>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Remark &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                            <th><?= lang("Aksi", "Action"); ?></th>
                                        </tr>
                                    </thead>
                                    <tbody id="item_mreq">
                                      <!-- <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th></th>
                                      <th>TOTAL</th>
                                      <th><input type="text" class="form-control" name="" id="total_ammount" readonly></th>
                                      <th></th> -->
                                    </tbody>
                                </table>
                            </div>
                                <div class="form-actions right">
                                  <button class="btn btn-success" type="button" id="add_mreq" data-toggle="modal" data-target="#modal_mreq" name="button"><i class="fa fa-plus"></i> <?= lang("Tambah Material", "Add Material")?></button>
                                  <button class="btn btn-primary" type="submit" id="" name="button"><?= lang("SImpan", "Save")?></button>
                                </div>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

      </div>
        <!-- //section form -->

    </div>
</div>

<!-- modalselect material & currency -->
<div id="modal_mreq" class="modal fade" data-backdrop="static" role="dialog">
    <div class="modal-dialog">
        <form class="modal-content" id="mreq_show">
            <div class="modal-header">
                <?= lang("Tambah Material", "Add Material")?>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="edit-title"></h4>
            </div>
            <div class="modal-body">
              <div class="row">
                <div class="col-md-6">
                  <div class="text-bold-600 font-medium-2"><?= lang("Pilih Material", "Select Material")?></div>
                  <select class="form-control select_material" style="width:450px !important;" name="select_material" required>
                    <option value=""> Select .. </option>
                    <?php
                    foreach ($material->result_array() as $arr) { ?>
                      <option value="<?= $arr['MATERIAL']?>"><?= $arr['MATERIAL_NAME']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <br>
              <div class="row">
                <div class="col-md-6">
                  <div class="text-bold-600 font-medium-2"><?= lang("Pilih Matauang", "Select Currency")?></div>
                  <select class="form-control select_currency" style="width:450px !important;" name="select_currency" required>
                    <option value=""> Select .. </option>
                    <?php
                    foreach ($currency->result_array() as $arr) { ?>
                      <option value="<?= $arr['ID']?>"><?= $arr['CURRENCY']?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>

            </div>
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal"><?= lang("Batal", "Cancel") ?></button>
                <button type="submit" class="btn btn-primary"><?= lang("Tambah Data", "Add Data") ?></button>
            </div>
        </form>
    </div>
</div>


<!-- modal approval -->
<div id="modal_approval" class="modal fade" data-backdrop="static" role="dialog">
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
                          <h1><b>Material Request</b></h1>

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
                                  <form id="itp_form_apprv" action="#" class="steps-validation wizard-circle" enctype="multipart/form-data">
                                      <h6><?= lang("Informasi", "Information"); ?></h6>
                                      <h6><?= lang("Catatan", "Note"); ?></h6>
                                      <h6><?= lang("History", "History"); ?></h6>

                                      <fieldset id="bagian1" class="col-md-12" class="white-bg">
                                        <h2 class="m-b-md"><?= lang("Informasi", "Information"); ?></h2>

                                      </fieldset>
                                      <br>
                                      <fieldset id="bagian2" class="col-12">
                                          <h2 class="m-b"><?= lang("Catatan", "Note"); ?></h2>

                                      </fieldset>

                                      <fieldset id="bagian3" class="col-12">
                                          <h2 class="m-b"><?= lang("History", "History"); ?></h2>

                                      </fieldset>

                                </div>
                            </div>
                        </div>
                        <!-- /////////////////////////////////////////////////////////////////////////////////////////////////// -->

                      </div>
                  </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="note" style="margin-right: 300px;"><i class="fa fa-desktop"></i> <?= lang('Catatan', 'Note') ?></button>
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal"><?= lang('Tutup', 'Close') ?></button>
                    <button type="button" class="btn btn-danger" id="reject"><?= lang('Tolak', 'Reject') ?></button>
                    <button type="button" class="btn btn-primary" id="approve"><?= lang('Setujui', 'Approve') ?></button>
                </div>
              </form>
        </div>
    </div>
</div>


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/css/lightbox.css">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.10.0/js/lightbox.js"></script>
<script src="<?= base_url()?>ast11/select2-master/dist/js/select2.min.js"></script>
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<script src="<?= base_url() ?>ast11/app-assets/js/core/app.min.js" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function() {
    // $(".form_mreq").hide();
    $(".table_mreq").hide();
    var dt_array = [];
    $("select").select2();
    $(".to_branch_plant_div").hide();
    $(".to_company_div").hide();
    $("#add").on('click', function(e) {
      // e.preventDefault();
      /* Act on the event */
      $(".table_mreq").hide();
      $(".form_mreq").show();
    });

    // wijard
    var form = $(".steps-validation").show();
    $(".number-tab-steps").steps({
        headerTag: "h6",
        bodyTag: "fieldset",
        transitionEffect: "fade",
        titleTemplate: '<span class="step">#index#</span> #title#',
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
        titleTemplate: '<span class="step">#index#</span> #title#',
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


    $(document).on('shown.bs.modal', '#modal_approval', function(e){
      var idnya = $(e.relatedTarget).data("id");
      alert(idnya)
    })

    $(document).on('shown.bs.modal', '#modal_mreq', function(e){
      $('.select_material').val("").select2();
      $('.select_currency').val("").select2();
    })

    // hardcode
    $(document).on('change', '.mr_type', function(e){
      var val = $(this).val();
      $('.bp').val("").select2();
      $('.to_branch_plant').val("").select2();
      $('.from_company').val("").select2();
      $('.to_company').val("").select2();
      if (val == 3) {
        $(".to_branch_plant_div").show();
        $(".bp").attr('required', true);
        $(".to_branch_plant").attr('required', true);

        $(".to_company_div").hide();
        $(".from_company").attr('required', false);
        $(".to_company").attr('required', false);
      } else if (val == 6) {
        $(".to_company_div").show();
        $(".from_company").attr('required', true);
        $(".to_company").attr('required', true);

        $(".to_branch_plant_div").hide();
        $(".bp").attr('required', false);
        $(".to_branch_plant").attr('required', false);
      } else {
        $(".to_branch_plant_div").hide();
        $(".bp").attr('required', false);
        $(".to_branch_plant").attr('required', false);

        $(".to_company_div").hide();
        $(".from_company").attr('required', false);
        $(".to_company").attr('required', false);
      }
      console.log(val);
    })

    $("#mreq_show").submit(function(e) {
      e.preventDefault();
      var data = $(this).serialize();
      // console.log(data);

      var result;
      $.ajax({
        url: '<?= base_url("material/Material_req/get_material")?>',
        type: 'POST',
        dataType: 'JSON',
        data: data
      })
      .done(function() {
        result = true;
      })
      .fail(function() {
        result = false;
      })
      .always(function(res) {
        if (result == true) {
          // console.log(dt_array.includes(res.MATERIAL));
          // console.log(dt_array);
          if (dt_array.includes(parseInt(res.MATERIAL)) == true) {
            swal ( "Oops" ,  "Material already selected" ,  "error" );
            $('.select_material').val("").select2();
          } else {
            var mr_type = $(".mr_type").val();
            var str_loc = '<option value="">Select Location</option>';
            $.each(res.get_location, function(index, el) {
              str_loc += '<option value="'+el.ID_LOCATION+'">'+el.LOCATION_DESC+'</option>';
            });
            var str = '<tr>'+
                        '<td><input class="form-control" type="hidden" name="semic[]" value="'+res.MATERIAL_CODE+'">'+res.MATERIAL_CODE+'</td>'+
                        '<td><input class="form-control" type="hidden" name="m_name[]" value="'+res.MATERIAL_NAME+'">'+res.MATERIAL_NAME+'</td>'+
                        '<td><input class="form-control" type="hidden" name="curr[]" value="'+res.CURRENCY+'">'+res.CURRENCY_NAME+'</td>'+
                        '<td><input class="form-control" type="hidden" name="uom[]" value="'+res.UOM1+'">'+res.UOM1+'</td>'+
                        '<td><input class="form-control" type="text" onKeyup="change('+res.MATERIAL+')" id="qty'+res.MATERIAL+'" name="qty[]" required></td>'+
                        '<td><input class="form-control" type="text" onKeyup="change('+res.MATERIAL+')" id="unit_price'+res.MATERIAL+'" name="unit_price[]" required></td>'+
                        '<td><input class="form-control" type="text" id="to_unit_cost'+res.MATERIAL+'" name="to_unit_cost[]" ></td>'+
                        '<td><input class="form-control" type="text" id="total'+res.MATERIAL+'" name="ammount[]" readonly></td>'+
                        '<td><input class="form-control" type="text" id="to_total'+res.MATERIAL+'" name="to_ammount[]"></td>'+
                        '<td><select class="form-control" id="from_loc'+res.MATERIAL+'" style="width:350px !important;" name="from_loc[]" required disabled>'+str_loc+'</select></td>'+
                        '<td><select class="form-control" id="to_loc'+res.MATERIAL+'" style="width:350px !important;" name="to_loc[]" required disabled>'+str_loc+'</select></td>'+
                        '<td><textarea id="remark'+res.MATERIAL+'" rows="3" class="form-control border-primary" name="remark[]" placeholder="Fill some note here" required></textarea></td>'+
                        '<td><button class="btn btn-danger rm_item" data-id="'+res.MATERIAL+'" type="button"> Remove</button></td>'+
                    '</tr>';
            $("#item_mreq").append(str);
            input_numberic('#unit_price'+res.MATERIAL, true);
            input_numberic('#qty'+res.MATERIAL, true);
            input_numberic('#to_unit_cost'+res.MATERIAL, true);
            input_numberic('#to_total'+res.MATERIAL, true);
            dt_array.push(parseInt(res.MATERIAL));
            console.log(mr_type);
            // hardcode
            if (mr_type == 3) {
              $("#from_loc"+res.MATERIAL).attr("disabled", false);
              $("#to_loc"+res.MATERIAL).attr("disabled", false);
              $("#from_loc"+res.MATERIAL).attr("required", true);
              $("#to_loc"+res.MATERIAL).attr("required", true);
            } else {
              $("#from_loc"+res.MATERIAL).attr("disabled", true);
              $("#to_loc"+res.MATERIAL).attr("disabled", true);
              $("#from_loc"+res.MATERIAL).attr("required", false);
              $("#to_loc"+res.MATERIAL).attr("required", false);
            }
            $('#modal_mreq').modal('hide');
            $('.select_material').val("").select2();
            $('.select_currency').val("").select2();

          }

        }
      });
    });

    $(document).on('click', '.rm_item', function(e) {
      // e.preventDefault();
      var idnya = $(this).data("id");
      // console.log(idnya);
      if (confirm('Are you sure you want to remove this item?')) {
        $(this).closest('tr').remove();
        // dt_array.indexOf();
        removeA(dt_array, idnya);
        // console.log(dt_array);
      }
    });

    $(".mreq_form").submit(function(e){
      e.preventDefault();
      var data = $(this).serialize();
      var resultx;
      console.log(data);
      $.ajax({
        url: '<?= base_url("material/Material_req/create_mr"); ?>',
        type: 'POST',
        dataType: 'JSON',
        data: data
      })
      .done(function() {
        resultx = true;
      })
      .fail(function() {
        resultx = false;
      })
      .always(function(res) {
        if (resultx == true) {
          if (res.success == true) {
            swal({
              title: "Done",
              text: "Material request successfuly created",
              type: "success",
              showCancelButton: false,
              confirmButtonColor: '#0072cf',
              confirmButtonText: 'Oke',
              closeOnConfirm: true,
              closeOnCancel: true
            },
            function(){
              window.location.href = "<?= base_url("material/material_req")?>";
            });
          }
        }
      });

    })

    $('#tbl tfoot th').each( function (i) {
        var title = $('#tbl thead th').eq( $(this).index() ).text();
        $(this).html( '<input type="text" placeholder="Search '+title+'" data-index="'+i+'" />' );
    });

    var table = $('#tbl').DataTable({
        ajax: {
            url: '<?= base_url('material/Material_req/datatable_mr') ?>',
            dataSrc: ''
        },
        scrollX: true,
        scrollY: '300px',
        scrollCollapse: true,
        paging: true,
        filter: true,
        info:false,
        fixedColumns: {
            leftColumns: 1,
            rightColumns: 1
        },
        columns: [
            {title: "<center>No</center>", "width": "20px"},
            {title: "<center><?= lang('Req No', 'Req No') ?></center>"},
            {title: "<center><?= lang('Tanggal', 'Req Date') ?></center>"},
            {title: "<center>Branch/Plant</center>"},
            {title: "<center>Material Request Type</center>"},
            {title: "<center>To Branch/Plant</center>"},
            {title: "<center>Purpose of Request</center>"},
            {title: "<center>Accounting Charge</center>"},
            {title: "<center><?= lang("Status", "Status") ?></center>", "width": "50px"},
            {title: "<center><?= lang("Aksi", "Action") ?></center>", "width": "50px"},
        ],
        "columnDefs": [
            {"className": "dt-right", "targets": [0]},
            {"className": "dt-center", "targets": [1]},
            {"className": "dt-center", "targets": [2]},
            {"className": "dt-center", "targets": [3]},
            {"className": "dt-center", "targets": [4]},
            {"className": "dt-center", "targets": [5]},
            {"className": "dt-center", "targets": [6]},
            {"className": "dt-center", "targets": [7]},
            {"className": "dt-center", "targets": [8]},
            {"className": "dt-center", "targets": [9]},
        ]
    });
    $(table.table().container()).on('keyup', 'tfoot input', function () {
        table.column( $(this).data('index') )
        .search( this.value )
        .draw();
    });

    // fungsi
    function removeA(dt_array) {
        var what, a = arguments, L = a.length, ax;
        while (L > 1 && dt_array.length) {
            what = a[--L];
            while ((ax= dt_array.indexOf(what)) !== -1) {
                dt_array.splice(ax, 1);
            }
        }
        return dt_array;
    }

    function getSum(total, num) {
      return total + Math.round(num);
    }

  });

  function change(id){
    var unit_price = $("#unit_price"+id).val();
    var qty = $("#qty"+id).val();

    var sum = parseInt(unit_price)*parseInt(qty);
    $("#total"+id).val(sum);
  }

</script>
