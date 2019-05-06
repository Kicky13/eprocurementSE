<?php /* page specific */ ?>


<link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet">
<!-- <link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet"> -->
<link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet">
<link href="<?= base_url() ?>ast11/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script>
<link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet">
<!-- <link href="//fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet"> -->
<?php /* page specific */ ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/pickadate/pickadate.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">


<!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/pickadate/pickadate.css"> -->
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css"> -->
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
      <h3 class="content-header-title"><?= lang("Letter of Intent", "Letter of Intent") ?></h3>
    </div>
    <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
      <div class="breadcrumb-wrapper col-12">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
          <li class="breadcrumb-item active"><?= lang("Procurement", "Procurement") ?></li>
          <li class="breadcrumb-item active"><?= lang("Letter of Intent ", "Letter of Intent") ?></li>
          <li class="breadcrumb-item active"><?= lang("To Issue", "To Issue") ?></li>
        </ol>
      </div>
    </div>
  </div>


  <div class="content-body">
    <div class="row info-header">
      <div class="col-md-6">
        <table class="table table-condensed">
          <tr>
            <td width="30%">Company</td>
            <td width="5%">:</td>
            <td width="65%"><?= $company->DESCRIPTION ?></td>
          </tr>
          <tr>
            <td>Awarder</td>
            <td>:</td>
            <td><?= $vendor->NAMA ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-6">
          <table class="table table-condensed">
            <tr>
              <td width="30%">MSR No.</td>
              <td width="5%">:</td>
              <td width="65%"><?= $loi->msr_no ?></td>
            </tr>
            <tr>
              <td>RFQ No.</td>
              <td>:</td>
              <td><?= $loi->rfq_no ?></td>
            </tr>
            <tr>
              <td>MSR Value</td>
              <td>:</td>
              <td><?= numEng(@$loi->total_amont ?: 0) ?> (excl. VAT)</td>
            </tr>
          </table>
        </div>
    </div>
    <section id="configuration">
      <div class="row">
        <div class="col-md-12">
          <?php if (isset($message) && !empty($message['message'])): ?>
            <div class="alert alert-dismissible alert-<?= $message['type'] ?>" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <?= $message['message'] ?>
            </div>
          <?php endif; ?>

          <?php if ($this->session->flashdata('message')): ?>
            <?php $message = $this->session->flashdata('message') ?>
            <div class="alert alert-dismissible alert-<?= $message['type'] ?>" role="alert">
              <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">×</span>
              </button>
              <?= $message['message'] ?>
            </div>
          <?php endif; ?>
        </div>
      </div>

      <div class="row">
        <div class="col-md-12">
          <div class="card"> 

            <div class="card-content collapse show">
              <div class="card-body card-dashboard card-scroll">
                <div class="row">
                  <div class="col-md-12">
                    <form id="letter_of_intent_form" method="POST" enctype="multipart/form-data" class="steps-validation wizard-circle">
                      <?php /* LoI Development */ ?>
                      <h6><i class="step-icon icon-info"></i> LOI Dev</h6>
                      <fieldset>
                        <div class="row">
                          <!-- left side -->
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="subject">
                                    Subject :
                                  </label>
                                  <textarea class="form-control required" disabled="disabled" id="title" name="title" rows="2" style="width: 100%"><?= $loi->title ?></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="company_letter">
                                    Company Letter :
                                  </label>
                                  <input type="text" disabled="disabled" class="form-control required" id="company_letter" name="company_letter" value="<?= $loi->company_letter ?>">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="loi_date">
                                    Date :
                                  </label>
                                  <input disabled="disabled" type="date" class="form-control required" value="<?= @$loi->loi_date ?>" id="loi_date" name="loi_date" disabled="disabled">
                                </div>
                              </div>
                            </div>
                          </div>

                          <!-- right side -->
                          <div class="col-md-6">
                            <div class="row">
                              <div class="col-md-12">
                                <h4>Attachments</h4>
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-md-6">
                                <label><?= @$this->M_loi_attachment->getTypes()[$this->M_loi_attachment::TYPE_SIGNED_LOI] ?></label>
                              </div>
                              <div class="col-md-6">
                                <input type="file" name="signed_loi" id="signed_loi" class="form-control required">
                              </div>
                            </div>

                            <?php foreach($loi_attachments as $attachment): ?>
                            <div class="row form-group">
                              <div class="col-md-6">
                                <label><?= $loi_attachment_type[$attachment->tipe] ?></label>
                              </div>
                              <div class="col-md-6">
                                <a href="<?= base_url().$attachment->file_path.$attachment->file_name ?>">
                                  <button type="button" class="btn btn-icon btn-sm">
                                    <i class="icon-cloud-download"></i>
                                  </button>
                                </a>
                              </div>
                            </div>
                            <?php endforeach; ?>

                          </div>
                        </div>
                      </fieldset>

                      <?php /* LOI Approval */ ?>
                      <?php if (@$loi->id): ?>
                      <h6><i class="step-icon icon-directions"></i>Approval</h6>
                      <fieldset>
                        <?php
                        $data_id = $loi->id;
                        $rows = $approval_list;
                        $this->load->view('procurement/V_loi_approval_section', compact('loi', 'data_id', 'rows', 'roles'));
                        ?>
                      </fieldset>
                      <?php endif; ?>

                    </form>
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


<script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script>        
<script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script>
<!--<script src="<?= base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script> 
<script src="<?= base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>     
<!-- <script src="<?= base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script>  -->
<script src="<?= base_url() ?>ast11/filter/scripts.js" type="text/javascript"></script> 
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/dataTables.select.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>

<!-- <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script> -->
<!-- <script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script> -->
<script>
$(document).ready(function() {

var form = $('#letter_of_intent_form');

$('#letter_of_intent_form').steps({
  headerTag: "h6",
  bodyTag: "fieldset",
  enableFinishButton: true,
  transitionEffect: "fade",
  titleTemplate: '#title#',
  enableFinishButton: false,
  enablePagination: true,
  enableAllSteps: true,
  labels: {
    finish: "Issue"
  },
  onStepChanging: function (event, currentIndex, newIndex)
  {
    // Allways allow previous action even if the current form is not valid!
    if (currentIndex > newIndex)
    {
      return true;
    }

    // Needed in some cases if the user went back (clean up)
    if (currentIndex < newIndex)
    {
      // To remove error styles
      form.find(".body:eq(" + newIndex + ") label.error").remove();
      form.find(".body:eq(" + newIndex + ") .error").removeClass("error");
    }

    form.validate().settings.ignore = ":disabled,:hidden";
    return form.valid();
  },
  onFinishing: function (event, currentIndex)
  {
    // form.validate().settings.ignore = ":disabled";
    if (!form.valid()) {
      return false;
    }
  
    return true; 
  },
  onFinished: function (event, currentIndex)
  {
    if (confirm("Are you sure want to submit?")) {
      $(form).submit();
    }
  }
});

//hide next and previous button
$('a[href="#next"]').hide();
$('a[href="#previous"]').hide();

$('#loi_date').pickadate({ format: 'd mmmm yyyy',
  formatSubmit: 'yyyy-mm-dd'
})
.pickadate('picker')
.set('select', new Date('<?= $loi->loi_date ?>'));
$("#loi_date").attr("disabled", true)

});
</script>
<?php /* vim: set fen foldmethod=indent ts=2 sw=2 tw=0 et autoindent :*/ ?>
