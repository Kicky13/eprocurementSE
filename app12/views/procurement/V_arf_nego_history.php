<h6><i class="step-icon fa fa-paperclip"></i> ARF Negotiation History</h6>
<fieldset>
	<div class="row">
		<div class="col-md-12">
			<?php
				foreach ($arfNegos as $arfNego) {
					$fill = "<a href='javascript:void(0)' class='btn btn-info btn-block' data-toggle='collapse' data-target='#nego-$arfNego->id'>Company Letter No : $arfNego->company_letter_no</a><br>";
					$fill .= "<div class='col-md-12 collapse show' id='nego-$arfNego->id' >";
					$fill .= "<div class='form-group row'>
						<label class='col-md-3'>Company Letter No</label>
						<div class='col-md-3'>$arfNego->company_letter_no</div>
						<label class='col-md-3'>Bid Letter No</label>
						<div class='col-md-3'>$arfNego->bid_letter_no</div>
					</div>
					<div class='form-group row'>
					<label class='col-md-3'>Supporting Document</label>
					<div class='col-md-3'>
						<a href='".base_url('upload/arf_nego')."/".$arfNego->supporting_document."' class='btn btn-sm btn-info' target='_blank'>Download</a>
					</div>
					<label class='col-md-3'>Bid Letter File</label>
					<div class='col-md-3'>
						<a href='".base_url('upload/arf_nego')."/".$arfNego->local_content_file."' class='btn btn-sm btn-info' target='_blank'>Download</a>
					</div>
					</div>
					<div class='form-group row'>
						<label class='col-md-3'>Note User</label>
						<div class='col-md-3'>$arfNego->note</div>
						<label class='col-md-3'>Note Vendor</label>
						<div class='col-md-3'>$arfNego->note_vendor</div>
					</div>";
					$fill .= "<table class='table table-condensed table-striped'>
					<tr><th>No</th><th>Description</th><th>QTY</th><th>UOM</th><th>Price</th><th>Total</th></tr>";
					$no=1;
					foreach ($arfNegoDetails as $arfNegoDetail) {
						if($arfNegoDetail->arf_response_id == $arfNego->arf_response_id)
						{
							$colorNego = '';
							if($arfNegoDetail->is_nego > 0)
							{
								$colorNego = "style='color:green'";
							}
							$subTotal = $arfNegoDetail->qty * $arfNegoDetail->unit_price;
							$fill .= "<tr><td>$no</td>";
							$fill .= "<td>$arfNegoDetail->item</td>";
							$fill .= "<td>$arfNegoDetail->qty</td>";
							$fill .= "<td>$arfNegoDetail->uom</td>";
							$fill .= "<td $colorNego>".numIndo($arfNegoDetail->unit_price)."</td>";
							$fill .= "<td $colorNego>".numIndo($subTotal)."</td></tr>";
							$no++;
						}
					}
					$fill .= "</table></div>";
					echo $fill;
				}
			?>
		</div>
	</div>
</fieldset>