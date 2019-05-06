<?php if ($arf->extend1) { ?>
<div class="form-group row">
    <div class="col-md-6">
        <h4>Performance Bond</h4>
    </div>
</div>
<table id="document-table-1" class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Performance Bond No</th>
            <th class="text-center">Issuer</th>
            <th class="text-center">Issued Date</th>
            <th class="text-center">Value</th>
            <th class="text-center">Curr</th>
            <th class="text-center">Effective Date</th>
            <th class="text-center">Expired Date</th>
            <th>Description</th>
            <th width="100px" class="text-right"></th>
        </tr>
    </thead>
    <tbody>
      <?php $no = 1 ?>
      <?php foreach ($arf->performance_bond as $doc) { ?>
          <tr>
              <td><?= $no ?></td>
              <td><?= $doc->no ?></td>
              <td class="text-center"><?= $doc->issuer ?></td>
              <td class="text-center"><?= dateToIndo($doc->issued_date) ?></td>
              <td class="text-center"><?= numIndo($doc->value) ?></td>
              <td class="text-center"><?= $doc->currency ?></td>
              <td class="text-center"><?= dateToIndo($doc->effective_date) ?></td>
              <td class="text-center"><?= dateToIndo($doc->expired_date) ?></td>
              <td><?= $doc->description ?></td>
              <td class="text-right"><a href="<?= base_url($document_path.'/'.$doc->file) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
          </tr>
          <?php $no++ ?>
      <?php } ?>
    </tbody>
</table>
<?php } ?>
<?php if ($arf->extend2) { ?>
<div class="form-group row">
    <div class="col-md-6">
        <h4>Insurance</h4>
    </div>
</div>
<table id="document-table-2" class="table table-bordered">
    <thead>
        <tr>
            <th>No.</th>
            <th>Insurance No</th>
            <th class="text-center">Issuer</th>
            <th class="text-center">Issued Date</th>
            <th class="text-center">Value</th>
            <th class="text-center">Curr</th>
            <th class="text-center">Effective Date</th>
            <th class="text-center">Expired Date</th>
            <th>Description</th>
            <th width="100px" class="text-right"></th>
        </tr>
    </thead>
    <tbody>
        <?php $no = 1 ?>
        <?php foreach ($arf->Insurance as $doc) { ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $doc->no ?></td>
                <td class="text-center"><?= $doc->issuer ?></td>
                <td class="text-center"><?= dateToIndo($doc->issued_date) ?></td>
                <td class="text-center"><?= numIndo($doc->value) ?></td>
                <td class="text-center"><?= $doc->currency ?></td>
                <td class="text-center"><?= dateToIndo($doc->effective_date) ?></td>
                <td class="text-center"><?= dateToIndo($doc->expired_date) ?></td>
                <td><?= $doc->description ?></td>
                <td class="text-right"><a href="<?= base_url($document_path.'/'.$doc->file) ?>" target="_blank" class="btn btn-info btn-sm"><i class="fa fa-download"></i></a></td>
            </tr>
            <?php $no++ ?>
        <?php } ?>
    </tbody>
</table>
<?php } ?>