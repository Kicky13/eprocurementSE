<h6><i class="step-icon icon-directions"></i> Approval</h6>
<fieldset>
    <div class="table-responsive">
        <table id="approval-table" class="table">
            <thead>
                <tr>
                    <th width="1px">No</th>
                    <th>Role</th>
                    <th>User</th>
                    <th>Approval Status</th>
                    <th>Transaction Date</th>
                    <th>Comment</th>
                    <th class="text-center">Action</th>
                    <th class="text-center">BOD Review Meeting</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1 ?>
                <?php
                    foreach ($approval as $row) {
                        if($row->role == 'USER') {

                        } else {
                ?>
                    <?php $bod_review_meeting = $this->m_arf_approval->find_detail($row->id, 'bod_review_meeting') ?>
                    <tr id="approval-<?= $row->id ?>">
                        <td><?= $no ?></td>
                        <td><?= $row->description == 'ARF APPROVAL (AAS)' ? 'AAS' : $row->role ?></td>
                        <td><?= $row->name ?></td>
                        <td>
                            <span data-m="status">
                                <?php if ($row->status == 1) { ?>
                                    Approved
                                <?php } elseif ($row->status == 2) { ?>
                                    Rejected
                                <?php } else { ?>
                                    <!--<span class="badge badge-secondary">Waiting Approval</span>-->
                                <?php } ?>
                            </span>
                        </td>
                        <td><span data-m="approved_at"><?= dateToIndo($row->approved_at, false, true) ?></span></td>
                        <td>
                            <span data-m="note"><?= nl2br($row->note) ?></span>
                            <!-- <?php if ($row->status <> 0) { ?>
                                by <?= $row->approver ?>
                            <?php } ?> -->
                        </td>
                        <td class="text-center">
                            <?php if ($allowed_approve) { ?>
                                <?php if (($row->status == 0 || $row->status == 2) && $row->auth) { ?>
                                    <?php if (!$bod_review_meeting) { ?>
                                        <button type="button" id="btn-approve-<?= $row->id ?>" class="btn btn-primary btn-sm" data-button-type="approve" onclick="approve('<?= $row->id ?>')">Approve/Reject</button>
                                        <?php if (in_array($row->id_user_role, $this->m_arf_approval->bod_staf_id)) { ?>
                                            <button type="button" id="btn-approval-save-<?= $row->id ?>" class="btn btn-success btn-sm" data-button-type="approval-save" onclick="approval_save('<?= $row->id ?>')">Save</button>
                                        <?php } ?>
                                    <?php } else { ?>
                                        <?php if (in_array($row->id_user_role, $this->m_arf_approval->bod_staf_id)) { ?>
                                            <button type="button" id="btn-approve-<?= $row->id ?>" class="btn btn-success btn-sm" data-button-type="approve" onclick="approve('<?= $row->id ?>')">Finished-Meeting Conducted</button>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        <td class="text-center" style="white-space: nowrap;">
                            <span data-m="bod_review_metting">
                                <?php if ($row->status == 0 && $row->auth && !$bod_review_meeting) { ?>
                                    <?php if (in_array($row->id_user_role, $this->m_arf_approval->bod_staf_id)) { ?>
                                        <?php if ($allowed_approve) { ?>
                                            <?php if (strpos($this->session->userdata('ROLES'), ','.$row->id_user_role.',') !== FALSE) { ?>
                                                <?= $this->form->radio('bod_review_meeting['.$row->id.']', 1, false, 'data-bod_review_metting="'.$row->id.'" onchange="bod_review_meeting(\''.$row->id.'\')"') ?> Required
                                                <?= $this->form->radio('bod_review_meeting['.$row->id.']', 0, true, 'data-bod_review_metting="'.$row->id.'" onchange="bod_review_meeting(\''.$row->id.'\')"') ?> Not Required
                                            <?php } ?>
                                        <?php } ?>
                                    <?php } ?>
                                <?php } else { ?>
                                    <?php
                                        if ($bod_review_meeting) {
                                            echo ($bod_review_meeting->value == 1) ? 'Required' : 'Not Required';
                                        }
                                    ?>
                                <?php } ?>
                            </span>
                        </td>
                    </tr>
                    <?php $no++ ?>
                    <?php } ?>
                <?php } ?>
            </tbody>
        </table>
    </div>
</fieldset>
<div class="modal fade" id="approve-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Approval</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <?= $this->form->hidden('approve_id', null, 'id="form-approve-id"') ?>
                <div class="form-group">
                    <label>Status</label>
                    <?= $this->form->select('approve_status', $this->m_arf_approval->approve_option(), null, 'id="form-approve-status" class="form-control"') ?>
                </div>
                <div class="form-group">
                    <label>Comment</label>
                    <?= $this->form->textarea('approve_description', null, 'id="form-approve-description" class="form-control"') ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="btn-approve" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="bod-review-meeting-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <input type="hidden" name="bod_review_meeting_id" id="bod-review-meeting-id" value="">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">BOD Review Meeting</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Comment</label>
                    <?= $this->form->textarea('bod_review_meeting_desc', null, 'id="bod_review_meeting_desc" class="form-control"') ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" id="bod-review-meeting-btn" class="btn btn-success">Submit</button>
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('procurement/partials/script_arf_approval') ?>