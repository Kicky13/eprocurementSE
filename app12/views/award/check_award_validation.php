<?php 
	/*Validasi sebelum klik Award Recommendation
	1. Commercial Evaluation not yet evaluated
	2. Failed Bidder can not be selected
	3. Total value can not above MSR value
	4. Negotiation in progress
	5. Insufficient budget*/
?>
<table class="table table-condensed">
	<?php foreach ($lists as $key => $value) : ?>
	<tr>
		<td width="80%"><?=$key?></td>
		<td>
			<?=$value?>
			<?php 
				if($key == 'Total value can not above MSR value' and $value == 'x')
				{
					echo "<a onclick='reviewEEClick()' href='#' class='btn btn-sm btn-warning'>EE Review</a>";
				}
			?>
		</td>
	</tr>
	<?php endforeach;?>
</table>