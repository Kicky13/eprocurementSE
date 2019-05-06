<?php /* page specific */ ?>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/css/plugins/forms/wizard.css">
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/app-assets/vendors/css/pickers/pickadate/pickadate.css">
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
    <div class="row">
      <div class="col-md-4">
        <table class="table table-condensed">
          <tr>
            <td width="30%">Company</td>
            <td width="5%">:</td>
            <td width="65%"><?= $company->DESCRIPTION ?></td>
          </tr>
          <tr>
            <td>Contractor</td>
            <td>:</td>
            <td><?= $awarder->NAMA ?></td>
          </tr>
        </table>
      </div>
      <div class="col-md-4">
          <table class="table table-condensed">
            <tr>
              <td width="30%">MSR No.</td>
              <td width="5%">:</td>
              <td width="65%"><?= $loi->msr_no ?></td>
            </tr>
            <tr>
              <td>ED No.</td>
              <td>:</td>
              <td><?= $loi->rfq_no ?></td>
            </tr>
          </table>
        </div>
        <div class="col-md-4">
          <table class="table table-condensed">
            <tr>
              <td>Agreement No.</td>
              <td>:</td>
              <td><?= @$loi->po_no ?></td>
            </tr>
            <tr>
              <td>Agreement Value</td>
              <td>:</td>
              <td><?= display_money(numEng($loi->total_amount), @$opt_currency[$loi->id_currency]) ?> (excl. VAT)</td>
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
            <div class="row">
              <div class="col-md-12">
                <div class="card-header"> </div>
              </div>
            </div>

            <div class="card-content collapse show">
              <div class="card-body card-dashboard">
                <div class="row">
                  <div class="col-md-12">
                    <div id="letter_of_intent_form" class="steps-validation wizard-circle">
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
                                    Letter Number :
                                  </label>
                                  <input type="text" class="form-control" disabled="disabled" id="company_letter" name="company_letter" value="<?= $loi->company_letter ?>">
                                </div>
                              </div>
                            </div>

                            <div class="row">
                              <div class="col-md-12">
                                <div class="form-group">
                                  <label for="loi_date">
                                    Date :
                                  </label>
                                  <input class="form-control pickadate disabled" value="<?= @$loi->loi_date ?>" id="loi_date" name="loi_date" disabled="disabled">
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

                            <?php foreach($loi_attachment as $attachment): ?>
                            <?php
                            if (!isset($loi_attachment_type[$attachment->tipe])) {
                              continue;
                            }
                            ?>
                            <div class="row form-group">
                              <div class="col-md-6">
                                <label><?= $loi_attachment_type[$attachment->tipe] ?></label>
                              </div>
                              <div class="col-md-6">
                                <a href="<?= base_url($attachment->file_path.$attachment->file_name) ?>">
                                  <button type="button" class="btn btn-info btn-sm">
                                    <!-- <i class="icon-cloud-download"></i> -->
                                    Download
                                  </button>
                                </a>
                              </div>
                            </div>
                            <?php endforeach; ?>

                          </div>
                        </div>
                      </fieldset>

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


<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/pickadate/picker.date.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/tables/datatable/dataTables.select.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/forms/repeater/jquery.repeater.min.js"></script>

<script>
$(document).ready(function() {

$('#letter_of_intent_form').steps({
  headerTag: "h6",
  bodyTag: "fieldset",
  enableFinishButton: false,
  transitionEffect: "fade",
  titleTemplate: '<span class="step">#index#</span> #title#',
});

var loi_date = $('#loi_date').pickadate({
  format: 'd mmmm yyyy',
})

loi_date.pickadate('picker').set('select', new Date('<?= $loi->loi_date ?>'));

});
</script>
<?php /* vim: set fen foldmethod=indent ts=2 sw=2 tw=0 et autoindent :*/ ?>
