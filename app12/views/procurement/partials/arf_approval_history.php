<h6><i class="step-icon icon-directions"></i> History</h6>
<fieldset>
     <table id="approval-table" class="table" style="font-size: 12px;">
        <thead>
            <tr>
                <th width="200">ARF No</th>
                <th width="150">Transaction Date</th>
                <th>Description</th>
                <th>Note</th>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1 ?>
            <?php foreach ($approval as $row) { ?>
                <?php $bod_review_meeting = $this->m_arf_approval->find_detail($row->id, 'bod_review_meeting') ?>
                <tr id="approval-<?= $row->id ?>">
                    <td><?= $arf->doc_no ?></td>
                    <td><span data-m="approved_at"><?= dateToIndo($row->approved_at, false, true) ?></span></td>
                    <td>
                        <span data-m="status">
                            <?php if ($row->status == 1) { ?>
                                Approved <?=  'by '.$row->name ?>
                            <?php } elseif ($row->status == 2) { ?>
                                Reject <?=  'by '.$row->name ?>
                            <?php } else { ?>
                                <!--<span class="badge badge-secondary">Waiting Approval</span>-->
                            <?php } ?>
                            <?php 
                                if($bod_review_meeting and $row->status == 0)
                                {
                                    echo 'BOD Contract Meeting Required by '.$row->name;
                                }
                            ?>
                        </span>
                    </td>
                    <td><span data-m="note"><?= nl2br($row->note) ?></span></td>
                    <!-- <td class="text-right" style="white-space: nowrap;">
                        <span data-m="bod_review_metting">
                            <?php
                                if ($bod_review_meeting) {
                                    echo ($bod_review_meeting->value == 1) ? 'Required' : 'Not Required';
                                }
                            ?>
                        </span>
                    </td> -->
                </tr>
                <?php $no++ ?>
            <?php } ?>
        </tbody>
    </table>
</fieldset>