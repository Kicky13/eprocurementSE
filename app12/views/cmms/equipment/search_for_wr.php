<?php foreach ($results as $r) {
	$eqno = $r['EQ_NO'];
	$btnAdd = "<a href='#' class='btn btn-sm btn-primary' onclick=\"selectEquipmentForWr('$eqno')\">Select</a>";
	echo "<tr>
		<td id='eqno-$r[EQ_NO]'>$r[EQ_NO]</td>
		<td id='eqdesc-$r[EQ_NO]'>$r[EQ_DESC]</td>
		<td id='eqclass-$r[EQ_NO]'>$r[EQ_CLASS]</td>
		<td id='eqtype-$r[EQ_NO]'>$r[EQ_TYPE]</td>
		<td class='hidden' id='eqlocation-$r[EQ_NO]'>$r[EQ_LOCATION]</td>
		<td>$btnAdd</td>
	</tr>";
}?>