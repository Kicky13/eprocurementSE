<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">

<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
      	<h3 class="content-header-title"><?= $title ?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content-body">
    	<section id="icon-tabs">
        <div class="row">
          <div class="col-12">
            <div class="card">
            	<div class="card-content collapse show">
                <div class="card-body card-scroll">
                  <form action="#" class="wizard-circle frm-bled" id="frm-bled">
                	<?php foreach (cmms_settings('eq-detail-tab')->get()->result() as $r) :?>
                	<h6> <?= $r->desc ?></h6>
                  <fieldset>
                    <div class="row">
                    	<?php $this->load->view($view.'/'.$r->desc1);?>
                    </div>
                  </fieldset>
                	<?php endforeach;?>
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
<script type="text/javascript">
	$(document).ready(function(){
		$("#frm-bled").steps({
      headerTag: "h6",
      bodyTag: "fieldset",
      transitionEffect: "fade",
      titleTemplate: '#title#',
      enableFinishButton: false,
      enablePagination: true,
      enableAllSteps: true,
      labels: {
          finish: 'Done'
      },
      onFinished: function (event, currentIndex) {
          // alert("Form submitted.");
      },
      onStepChanged: function (event, currentIndex, priorIndex) {

      }
    });
		//hide next and previous button
		$('a[href="#next"]').hide();
		$('a[href="#previous"]').hide();
	})
</script>