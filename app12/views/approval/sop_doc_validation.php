<?= $no = 1 ?>
<tr>
    <th colspan="3">Bidder List</th>
    <th class="text-center"></th>
</tr>
<tr>
    <td><?= $no ?></td>
    <?php foreach ($dataPm as $key => $value) {
        echo '<td>Procurement Method</td>';
        echo '<td>'.(($value == 'v') ? 'Required' : $value).'</td>';
        echo '<td class="text-center">'.(($value == 'v') ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>').'</td>';
    }?>
</tr>
<tr>
    <th colspan="3">Enquiry Data</th>
    <th class="text-center"></th>
</tr>
<?php
    foreach ($validEd as $key => $value) {
        $no++;
        $q = $p[$key] ? '<i class="fa fa-check text-success"></i>' :'<i class="fa fa-times text-danger"></i>';
        echo "<tr><td>$no</td><td>$value</td><td>Required</td><td class='text-center'>$q</td></tr>";
    }
?>
<?= $no++ ?>
<tr>
    <td><?= $no ?>
    <td>Pre Bid</td>
    <td>Required</td>
    <td class="text-center"><?= $p['prebid'] ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></td>
</tr>
<?= $no++ ?>
<tr>
    <td><?= $no ?>
    <td>Bid Bond</td>
    <td>Required</td>
    <td class="text-center"><?= $p['bidbond'] ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></td>
</tr>
<tr>
    <th colspan="3">Schedule Of Price</th>
    <th class="text-center"></th>
</tr>
<?= $no++ ?>
<tr>
    <td><?= $no ?>
    <td>Schedule Of Price</td>
    <td>All MSR Item required to be SOP</td>
    <td class="text-center"><?= $sop == $t_msr_item ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></td>
</tr>
<tr>
    <th colspan="3">Enquiry Document</th>
    <th class="text-center"></th>
</tr>
<?= $no++ ?>
<tr>
    <td><?= $no ?>
    <td>Document Instruction To Bid</td>
    <td>Required</td>
    <td class="text-center"><?= $attachment0 > 0 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></td>
</tr>
<?= $no++ ?>
<tr>
    <td><?= $no ?>
    <td>Form of PO/SO/Contract</td>
    <td>Required</td>
    <td class="text-center"><?= $attachment2 > 0 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></td>
</tr>
<?= $no++ ?>
<tr>
    <td><?= $no ?>
    <td>Exhibit</td>
    <td>Required</td>
    <td class="text-center"><?= $attachmentE > 0 ? '<i class="fa fa-check text-success"></i>' : '<i class="fa fa-times text-danger"></i>' ?></td>
</tr>