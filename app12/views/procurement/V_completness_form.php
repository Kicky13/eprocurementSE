<form class="form-horizontal" id="compleness-form">
	<input type="hidden" name="id" class="form-control" value="<?=$row->id?>">
	<div class="form-group">
		<label class="col-md-12">Performance Bond No</label>
		<div class="col-md-12">
			<input  name="no" id="no" class="form-control" required="" value="<?=$row->no?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12">Issuer</label>
		<div class="col-md-12">
			<input  name="issuer" id="issuer" class="form-control" required="" value="<?=$row->issuer?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12">Issued Date</label>
		<div class="col-md-12">
			<input  name="issued_date" id="issued_date" class="form-control tgl" required="" value="<?=$row->issued_date?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12">Value</label>
		<div class="col-md-12">
			<input  name="nilai" id="nilai" class="form-control" required="" value="<?=$row->value?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12">Currency</label>
		<div class="col-md-12">
			<select class="form-control" name="currency_id" id="currency_id">
				<?php 
					foreach ($this->db->get('m_currency')->result() as $cur) {
						$selected = $row->currency_id == $cur->ID ? "selected" : "";
						echo "<option value='$cur->ID' $selected>$cur->CURRENCY</option>";
					}
				?>
			</select>
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12">Effective Date</label>
		<div class="col-md-12">
			<input  name="effective_date" id="effective_date" class="form-control tgl" required="" value="<?=$row->effective_date?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12">Expired Date</label>
		<div class="col-md-12">
			<input name="expired_date" id="expired_date" class="form-control tgl" required="" value="<?=$row->expired_date?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12">Description</label>
		<div class="col-md-12">
			<input name="description" class="form-control" value="<?=$row->description?>">
		</div>
	</div>
	<div class="form-group">
		<label class="col-md-12">File</label>
		<div class="col-md-12">
			<input type="file" name="file" class="form-control">
			<?php if($row->file): ?>
				<a href="<?=base_url('upload/ARF/'.$row->file)?>" target="_blank" class="btn btn-sm btn-primary">Download</a>
			<?php endif;?>
		</div>
	</div>
	<div class="form-group">
		<div class="col-md-12">
			<button type="button" onclick="completnesStore()" class="btn btn-success pull-right">Update</button>
		</div>
	</div>
</form>
<script type="text/javascript">
	$(function() {
		$('.tgl').datepicker({
	        format: "yyyy-mm-dd"
	    });
		$('#nilai').number(true,2);
	})
</script>