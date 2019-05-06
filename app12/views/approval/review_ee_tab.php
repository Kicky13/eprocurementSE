<?php if($ed->ee_value > 0) : ?>
<h6><i class="step-icon fa fa-history"></i>EE Review</h6>
<fieldset>
  <div class="form-group row">
    <label class="col-md-3">Attachment</label>
    <div class="col-md-9">
      <a href="<?= base_url('upload/ee/'.$ed->ee_file) ?>" target="_blank" class="btn btn-danger btn-sm">Download</a>
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-3">Value EE</label>
    <div class="col-md-9">
      <input value="<?= numIndo($ed->ee_value) ?>" class="form-control" disabled="">
    </div>
  </div>
  <div class="form-group row">
    <label class="col-md-3">Description</label>
    <div class="col-md-9">
      <textarea class="form-control"><?= $ed->ee_desc ?></textarea>
    </div>
  </div>
</fieldset>
<?php endif;?>