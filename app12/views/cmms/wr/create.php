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
                  <form action="#" class="wizard-circle frm-bled" id="frm-bled" enctype="multipart/form-data">
                    <h6> <?= $title ?></h6>
                    <fieldset>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>Parent WO</label>
                            <input class="form-control" value="" id="parent_id" name="parent_id">
                          </div>
                          <div class="form-group">
                            <label>Equipment Number</label>
                            <input class="form-control" readonly="" id="eq_number" name="eq_number">
                            <small><a href="#" onclick="browseEquipmentPoup()">Click Here to Browse</a></small>
                          </div>
                          <div class="form-group">
                            <label>Equipment Description</label>
                            <input class="form-control" readonly="" id="eq_desc" name="eq_desc">
                          </div>
                          <div class="form-group">
                            <label>Equipment Class</label>
                            <input class="form-control" readonly="" id="eq_class" name="eq_class">
                          </div>
                          <div class="form-group">
                            <label>Equipment Type</label>
                            <input class="form-control" readonly="" id="eq_type" name="eq_type">
                          </div>
                          <div class="form-group">
                            <label>Location</label>
                            <input class="form-control" readonly="" id="location" name="location">
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group">
                            <label>WO Type</label>
                            <?= $optWoType ?>
                          </div>
                          <div class="form-group">
                            <label>WR Description</label>
                            <input class="form-control" id="wr_description" name="wr_description">
                            <small>&nbsp;</small>
                          </div>
                          <div class="form-group">
                            <label>Failure Description</label>
                            <?= $optFailureDescription ?>
                          </div>
                          <div class="form-group">
                            <label>Photo</label>
                            <input class="form-control" type="file" id="photo" name="photo">
                          </div>
                          <div class="form-group">
                            <label>Requested Finish Date</label>
                            <input class="form-control" readonly="" id="eq_type" name="eq_type">
                          </div>
                          <div class="form-group">
                            <label>Priority</label>
                            <?= $optPriority ?>
                          </div>
                        </div>
                      </div>
                    </fieldset>
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
  });
  function browseEquipmentPoup() {
    alert('Underconstruction')
  }
</script>