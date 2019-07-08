<?php /* page specific */
$display_total_amount = display_multi_line_currency_format(
  numEng($bl->total_amount),
  $currency->CURRENCY,
  numEng($bl->total_amount_base),
  $base_currency->CURRENCY
);
?>


<!-- <link href="<?= base_url() ?>ast11/css/plugins/sweetalert/sweetalert.css" rel="stylesheet"> -->
<!-- <link href="<?= base_url() ?>ast11/select2-master/dist/css/select2.min.css" rel="stylesheet"> -->
<!-- <link href="<?= base_url() ?>ast11/select2/select2.css" rel="stylesheet"> -->
<!-- <link href="<?= base_url() ?>ast11/tagsinput/css/bootstrap-tagsinput.css" rel="stylesheet" type="text/css" media="screen"/> -->
<!-- <link href="<?= base_url() ?>ast11/css/plugins/touchspin/jquery.bootstrap-touchspin.min.css" rel="stylesheet"> -->
<!-- <link href="<?= base_url() ?>ast11/css/plugins/iCheck/custom.css" rel="stylesheet"> -->
<!-- <link href="<?= base_url() ?>ast11/multi-select/css/multi-select.css" rel="stylesheet" type="text/css" media="screen"/> -->
<!-- <script type="text/javascript" src="<?= base_url() ?>ast11/ckeditor/ckeditor.js"></script> -->
<!-- <link href="<?= base_url() ?>ast11/css/plugins/summernote/summernote.css" rel="stylesheet"> -->
<!-- <link href="//fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i" rel="stylesheet"> -->
<?php /* page specific */ ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/pickadate/pickadate.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/tables/datatable/jquery.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">


<!-- <link rel="styleshgreementeet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css"> -->
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
        </ol>
      </div>
    </div>
  </div>


  <div class="content-body">
    <div class="row info-header">
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
            <td width="30%">Company</td>
            <td width="10">:</td>
            <td><?= $bl->company_desc ?></td>
          </tr>
          <tr>
            <td>Contractor</td>
            <td width="10">:</td>
            <td><?= $awarder->NAMA ?>
            </td>
          </tr>
        </table>
      </div>
      <div class="col-md-4">
          <table class="table table-condensed">
            <tr>
              <td width="30%">MSR No.</td>
              <td width="5%">:</td>
              <td width="65%"><?= $bl->msr_no ?></td>
            </tr>
            <tr>
              <td>ED No.</td>
              <td>:</td>
              <td><?= $bl->bled_no ?></td>
            </tr>
          </table>
        </div>
        <div class="col-md-4">
          <table class="table table-condensed">
            <tr>
              <!-- <td width="30%">Agreement No.</td>
              <td width="5%">:</td>
              <td width="65%"><?= @$bl->po_no ? $bl->po_no : str_replace('OR', 'OS', $bl->msr_no); ?></td> -->
            </tr>
            <tr>
              <td>Agreement Value  (Excl. VAT)</td>
              <td>:</td>
              <td class="text-right"><?= $display_total_amount ?></td>
            </tr>
          </table>

        </div>
    </div>
    <section id="configuration">
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-content collapse show">
              <div class="card-body card-dashboard card-scroll">
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
                    <form id="letter_of_intent_form" method="POST" enctype="multipart/form-data" class="steps-validation wizard-circle">
                    <!-- <form id="letter_of_intent_form" method="POST" class="steps-validation wizard-circle"> -->
                      <input type="hidden" name="bl_detail_id" value="<?= $bl_detail_id ?>">
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
                                  <textarea class="form-control required" id="title" name="title" rows="2" style="width: 100%"><?= set_value('title') ?></textarea>
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="company_letter">
                                    Letter Number :
                                  </label>
                                  <input type="text" class="form-control required" id="company_letter" name="company_letter" value="<?=set_value('company_letter') ?>">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="loi_date">
                                    Date :
                                  </label>
                                  <input type="date" class="form-control pickadate required" data-value="<?= set_value('loi_date') ?>" id="loi_date" name="loi_date">
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
                                <label>LOI</label>
                              </div>
                              <div class="col-md-6">
                                <input type="file" name="draft_of_loi" id="draft_of_loi" required">
                              </div>
                            </div>

                            <!-- <div class="row form-group">
                              <div class="col-md-6">
                                <label>ITP Form</label>
                              </div>
                              <div class="col-md-6">
                                <input type="file" name="itp_form" id="itp_form" required">
                              </div>
                            </div>

                            <div class="row form-group">
                              <div class="col-md-6">
                                <label>Performance Bond</label>
                              </div>
                              <div class="col-md-6">
                                <input type="file" name="performance_bond" id="performance_bond" required">
                              </div>
                            </div> -->

                          </div>
                        </div>
                      </fieldset>

                    </form>
                  </div>
                </div>

				<!--<div class="row" id="required-warning" hidden>
					<div class="col-md-12">
						<div id="item-table-alert" class="alert alert-warning" role="alert" style="">Please fill out all the required fields (*)</div>
					</div>
			   </div>-->

              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
</div>


<!-- <script src="<?= base_url() ?>ast11/js/plugins/iCheck/icheck.min.js"></script> -->
<!-- <script src="<?= base_url() ?>ast11/js/plugins/touchspin/jquery.bootstrap-touchspin.min.js"></script> -->
<!--<script src="<?= base_url() ?>ast11/tagsinput/js/bootstrap-tagsinput.min.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>ast11/select2-master/dist/js/select2.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/filter/perfect-scrollbar.min.js" type="text/javascript"></script>
<!-- <script src="<?= base_url() ?>ast11/filter/select2.min.js" type="text/javascript"></script>  -->
<!-- <script src="<?= base_url() ?>ast11/filter/scripts.js" type="text/javascript"></script>  -->
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/dataTables.select.min.js" type="text/javascript"></script>
<!-- <script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script> -->
<script>
$(document).ready(function() {


var form = $('#letter_of_intent_form');

$('#letter_of_intent_form').steps({
  headerTag: "h6",
  bodyTag: "fieldset",
  transitionEffect: "fade",
  titleTemplate: '#title#',
  enablePagination: true,
  enableAllSteps: true,
  labels: {

    finish: 'Submit'
  },
  onFinishing: function (event, currentIndex)
  {
	//show single required warning
    form.validate().settings.ignore = ":disabled,:hidden";
	if (form.valid()){
		$('#required-warning').attr('hidden', 'hidden');
	}
	else {
    swal('<?= __('warning') ?>', 'Please fill out all the required fields (*)', 'warning');
		$('#required-warning').removeAttr('hidden');
	}

    form.validate().settings.ignore = ":disabled";
    if (!form.valid()) {
      return false;
    }


    return true;


  },
  onFinished: function (event, currentIndex)
  {
    /*if (confirm("Are you sure want to submit?")) {
      $(form).submit();
    }*/
    swalConfirm('LOI', '<?= __('confirm_submit') ?>', function() {
      $(form).submit();
    });
  }
});

//hide next and previous button
$('a[href="#next"]').hide();
$('a[href="#previous"]').hide();


var loi_date = $('#loi_date').pickadate({
  format: 'd mmmm yyyy',
  formatSubmit: 'yyyy-mm-dd'
})
.pickadate('picker').set('select', new Date);

});
</script>
<?php /* vim: set fen foldmethod=indent ts=2 sw=2 tw=0 et autoindent :*/ ?>
