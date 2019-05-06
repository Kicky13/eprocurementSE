<form method="post" enctype="multipart/form-data" action="<?= base_url('approval/award/review_ee_store') ?>" id="frm-review-ee">
	<input type="hidden" name="msr_no" value="<?=$msr_no?>">
	<div class="form-group row">
		<label class="col-md-3">Attachment</label>
		<div class="col-md-9">
			<input type="file" name="ee_file" class="form-control" required="">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3">Value EE</label>
		<div class="col-md-9">
			<input min="<?=$total?>" name="ee_value" id="ee_value" class="form-control" required="">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3">Currency</label>
		<div class="col-md-9">
			<input disabled="" class="form-control" value="<?= $currency->CURRENCY ?>">
		</div>
	</div>
	<div class="form-group row">
		<label class="col-md-3">Description</label>
		<div class="col-md-9">
			<textarea class="form-control" name="ee_desc" required=""></textarea>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-12">
			<button class="btn btn-primary">Submit</button>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(document).ready(function(){
		$('#ee_value').number(true, 2, bahasa.decimal_separator, bahasa.thousand_separator);
		$("#frm-review-ee").on('submit',function(){
			/*alert($("#ee_value").val())
			return false;*/
			if(parseInt($("#ee_value").val()) < parseInt("<?=$total?>"))
			{
				alert('Fail, EE Value must be over then <?=numIndo($total)?>')
				return false
			}
			$('#ee_value').replaceWith('<input class="form-control" id="ee_value"  name="ee_value" value='+$("#ee_value").val()+'>');
			return true
		})
	})
</script>