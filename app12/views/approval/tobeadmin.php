<?php
$t_assignment = $this->db->where(['msr_no' => $msr_no])->get('t_assignment')->row();
?>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>
<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script src="<?= base_url('ast11') ?>/app-assets/vendors/js/pickers/pickadate/picker.js"
        type="text/javascript"></script>
<script src="<?= base_url('ast11') ?>/app-assets/vendors/js/pickers/pickadate/picker.date.js"
        type="text/javascript"></script>
<script src="<?= base_url('ast11') ?>/app-assets/vendors/js/pickers/daterange/daterangepicker.js"
        type="text/javascript"></script>

<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-12 col-12 mb-2">
                <h3 class="content-header-title mb-0">EVALUATION</h3>
            </div>
        </div>
        <div class="row info-header">
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 150px;">Company</td>
                        <td class="no-padding-lr">:</td>
                        <td><?= $msr->company_name ?></td>
                    </tr>
                    <tr>
                        <td style="width: 150px;">Department</td>
                        <td class="no-padding-lr">:</td>
                        <td><?= $msr->department_desc ?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 150px;">MSR Number</td>
                        <td class="no-padding-lr">:</td>
                        <td><?= $msr_no ?></td>
                    </tr>
                    <tr>
                        <td style="width: 150px;">MSR Value (Excl. VAT)</td>
                        <td class="no-padding-lr">:</td>
                        <td class="text-right">
                            <?= $msr->currency ?> <?= numIndo($msr->total_amount) ?>
                            <?= equal_to($msr) ?>
                        </td>
                    </tr>
                    <?php if ($ed->ee_value > 0): ?>
                        <tr>
                            <td style="width: 150px;">Rev. MSR Value</td>
                            <td class="no-padding-lr">:</td>
                            <td>
                                <?php
                                $edc = $this->db->where(['ID' => $ed->currency])->get('m_currency')->row();
                                echo $edc->CURRENCY;
                                ?>
                                <?= numIndo($ed->ee_value) ?>
                            </td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 105px;">ED Number</td>
                        <td class="no-padding-lr">:</td>
                        <td><?= str_replace('OR', 'OQ', $msr_no) ?></td>
                    </tr>
                    <tr>
                        <td style="width: 105px;">Title</td>
                        <td class="no-padding-lr">:</td>
                        <td><?= $ed->subject ?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="content-body">
            <!-- Form wizard with icon tabs section start -->
            <section id="icon-tabs">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <!-- <div class="card-header">
                  <h4 class="card-title">Please Verify MSR <?= $msr_no ?></h4>
                </div> -->
                            <div class="card-content collapse show">
                                <div class="card-body card-scroll">
                                    <form action="<?= base_url('approval/approval/closingopening') ?>"
                                          class="wizard-circle" id="frm-bled">
                                        <input type="hidden" name="msr_no" id="msr_no" value="<?= $msr_no ?>">
                                        <!-- Step 1 -->
                                        <h6><i class="step-icon fa fa-info"></i> Quotation</h6>
                                        <fieldset>
                                            <h3>Quotation Status</h3>
                                            <?php $this->load->view('approval/quotation_view', ['ed' => $ed]); ?>
                                        </fieldset>
                                        <!-- Step Administartive -->
                                        <?php
                                        $disAdm = 'disabled';
                                        if (in_array(28, $roles)) {
                                            $disAdm = '';
                                        }
                                        ?>
                                        <h6><i class="step-icon fa fa-th-list"></i>Evaluation</h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <nav>
                                                        <div class="nav nav-tabs sub-tabs" id="nav-tab" role="tablist">
                                                            <a class="nav-item nav-link active" id="nav-home-tab"
                                                               data-toggle="tab" href="#nav-administrative" role="tab"
                                                               aria-controls="nav-home" aria-selected="true">Administrative</a>
                                                            <a class="nav-item nav-link" id="nav-profile-tab"
                                                               data-toggle="tab" href="#nav-technical" role="tab"
                                                               aria-controls="nav-profile" aria-selected="false">Technical</a>
                                                            <a class="nav-item nav-link" id="nav-contact-tab"
                                                               data-toggle="tab" href="#nav-commercial" role="tab"
                                                               aria-controls="nav-contact" aria-selected="false">Commercial</a>
                                                        </div>
                                                    </nav>
                                                    <div class="tab-content" id="nav-tabContent">
                                                        <div class="tab-pane fade show active" id="nav-administrative"
                                                             role="tabpanel" aria-labelledby="nav-administrative-tab">
                                                            <div class="col-md-12 text-center">
                                                                <?php
                                                                $btndis = '';
                                                                $btndis2 = true;
                                                                $disAdm = 'hidden';
                                                                if (in_array(bled, $roles)) {
                                                                    $disAdm = '';
                                                                }
                                                                if (isset($approved_administration)):
                                                                    $btndis = $approved_administration->administrative == 3 || $approved_administration->administrative == 1 ? '' : 'disabled';
                                                                    // $btndis2 = $approved_administration->administrative == 3 || $approved_administration->administrative == 1  || $approved_administration->administrative == 4 ? false:true;
                                                                    $btnApprovalAdmin = $approved_administration->administrative == 3 ? "hidden" : "";
                                                                    $adminAttachment = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                                                                    ?>
                                                                    <!-- <a href="<?= base_url('upload/evaluation/' . @$adminAttachment->file_path) ?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a> -->
                                                                <?php else: ?>
                                                                    <!-- <a href="#" data-toggle="modal" data-target="#modal-upload-administrative" class="btn btn-sm btn-primary <?= $disAdm ?>">Upload</a> -->
                                                                <?php endif; ?>
                                                                <?php
                                                                if (($ed->administrative == 0 or $ed->administrative == 2) and $this->session->userdata('ID_USER') == $t_assignment->user_id) {
                                                                    $btndis2 = true;
                                                                } else {
                                                                    $btndis2 = false;
                                                                }

                                                                ?>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <div class="table-responsive">
                                                                    <table class="table table-condensed table-striped table-row-border">
                                                                        <thead>
                                                                        <tr>
                                                                            <th width="1">No</th>
                                                                            <th>SLKA No</th>
                                                                            <th>Bidder(s) Name</th>
                                                                            <?php if ($btndis2): ?>
                                                                                <th class="text-center">Action</th>
                                                                            <?php endif; ?>
                                                                            <th class="text-center">Result</th>
                                                                            <th>Remark</th>
                                                                            <th class="text-center">
<!--                                                                                --><?php
//                                                                                if (($ed->administrative == 0 or $ed->administrative == 2) and $this->session->userdata('ID_USER') == $t_assignment->user_id):
//                                                                                    ?>
<!--                                                                                    <a href="#" data-toggle="modal"-->
<!--                                                                                       data-target="#modal-upload-administrative"-->
<!--                                                                                       class="btn btn-sm btn-primary">Upload </a>-->
<!--                                                                                    <a id="file_upload_name" href="#"-->
<!--                                                                                       target="_blank"> </a>-->
<!--                                                                                --><?php
//                                                                                else:
//                                                                                    $adminAttachment = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
//                                                                                    if (@$adminAttachment->file_path):
//                                                                                        ?>
<!--                                                                                        <a href="--><?//= base_url('upload/evaluation/' . @$adminAttachment->file_path) ?><!--"-->
<!--                                                                                           target="_blank"-->
<!--                                                                                           class="btn btn-sm btn-primary">See-->
<!--                                                                                            Attachment</a>-->
<!--                                                                                    --><?php //endif; ?>
<!--                                                                                --><?php //endif; ?>
                                                                            </th>
                                                                        </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                        <?php
                                                                        $no = 1;
                                                                        foreach ($blDetails->result() as $blDetail) {
                                                                            if ($blDetail->confirmed == 1) {
                                                                                echo "<tr>
											<td>$no</td>
											<td>";
                                                                                if (strpos($this->session->userdata('ROLES'), ',28,') !== FALSE) {
                                                                                    echo "<a href='" . base_url('vendor/registered_supplier') . "?id=$blDetail->vendor_id' target='_blank'>";
                                                                                }
                                                                                echo $blDetail->no_slka;
                                                                                if (strpos($this->session->userdata('ROLES'), ',28,') !== FALSE) {
                                                                                    echo "</a>";
                                                                                }
                                                                                echo "</td>
											<td>$blDetail->vendor_name</td>";
                                                                                if ($btndis2) {
                                                                                    echo "<td class='text-center'>
												<a href='#' onclick=\"adm('$blDetail->bl_detail_id',1,'pass')\" class='btn btn-sm btn-success'><i class='fa fa-check'></i></a>
												<a href='#' onclick=\"adm('$blDetail->bl_detail_id',2,'check')\" class='btn btn-sm btn-danger'><i class='fa fa-stop'></i></a>
											  </td>";
                                                                                }
                                                                                echo "<td class='text-center' id='adm-result-$blDetail->bl_detail_id'>" . evaluationStatus($blDetail->administrative) . "</td>
											<td id='adm-remark-$blDetail->bl_detail_id'>$blDetail->desc_administrative</td>
											<td></td>
											</tr>";
                                                                                $no++;
                                                                            }
                                                                        }
                                                                        ?>
                                                                        <tr>
                                                                            <th width="1"></th>
                                                                            <th></th>
                                                                            <th></th>
                                                                            <?php if ($btndis2): ?>
                                                                                <th class="text-center"></th>
                                                                            <?php endif; ?>
                                                                            <th class="text-center"></th>
                                                                            <th></th>
                                                                            <th class="text-center">
                                                                                <?php
                                                                                if (($ed->administrative == 0 or $ed->administrative == 2) and $this->session->userdata('ID_USER') == $t_assignment->user_id):
                                                                                    ?>
                                                                                    <a href="#" data-toggle="modal"
                                                                                       data-target="#modal-upload-administrative"
                                                                                       class="btn btn-sm btn-primary">Upload </a>
                                                                                    <a id="file_upload_name" href="#"
                                                                                       target="_blank"> </a>
                                                                                <?php
                                                                                else:
                                                                                    $adminAttachment = $this->M_approval->seeAttachment('eva-administrative', $msr_no)->row();
                                                                                    if (@$adminAttachment->file_path):
                                                                                        ?>
                                                                                        <a href="<?= base_url('upload/evaluation/' . @$adminAttachment->file_path) ?>"
                                                                                           target="_blank"
                                                                                           class="btn btn-sm btn-primary">See
                                                                                            Attachment</a>
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                            </th>
                                                                        </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-technical" role="tabpanel"
                                                             aria-labelledby="nav-technical-tab">
                                                            <div class="row">
                                                                <div class="col-md-12 text-center">
                                                                    <?php
                                                                    $btndisTech = '';
                                                                    if ($ed->technical == 0 and $msr->create_by == $this->session->userdata('ID_USER')) {
                                                                        $btndis2Tech = true;
                                                                    } else {
                                                                        $btndis2Tech = false;
                                                                    }
                                                                    $disTech = 'hidden';
                                                                    if (in_array(26, $roles)) {
                                                                        $disTech = '';
                                                                    }
                                                                    if (isset($approved_technical)) {
                                                                        $btndisTech = $approved_technical->technical == 3 || $approved_technical->technical == 1 ? '' : 'disabled';
                                                                        // $btndis2Tech = $approved_technical->technical == 3 || $approved_technical->technical == 1  || $approved_technical->technical == 4 ? false:true;
                                                                        $btnApprovalTech = $approved_technical->technical == 3 ? "hidden" : "";
                                                                    } else {

                                                                    }
                                                                    ?>
                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="table-responsive">
                                                                        <table class="table table-condensed table-striped table-row-border">
                                                                            <thead>
                                                                            <tr>
                                                                                <th width="1">No</th>
                                                                                <th>SLKA No</th>
                                                                                <th>Bidder(s) Name</th>
                                                                                <?php if ($btndis2Tech and $this->session->userdata('evaluation_step') == 'technicalevaluation'): ?>
                                                                                    <?php if ($ed->commercial_data == 2): ?>
                                                                                        <th class="text-center">
                                                                                            Scoring
                                                                                        </th>
                                                                                    <?php else: ?>
                                                                                        <th class="text-center">Action
                                                                                        </th>
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                                <th class="text-center">Result</th>
                                                                                <th>Remark</th>
                                                                                <th>
<!--                                                                                    --><?php
//                                                                                    if ($ed->technical == 0 and $msr->create_by == $this->session->userdata('ID_USER')):
//                                                                                        ?>
<!--                                                                                        <a href="#" data-toggle="modal"-->
<!--                                                                                           data-target="#modal-upload-technical"-->
<!--                                                                                           class="btn btn-sm btn-primary --><?//= $disTech ?><!--">Upload</a>-->
<!--                                                                                        <a id="file_upload_name_tech"-->
<!--                                                                                           href="#"-->
<!--                                                                                           target="_blank"> </a>-->
<!--                                                                                    --><?php
//                                                                                    else:
//                                                                                        $techAttachment = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
//                                                                                        if (@$techAttachment->file_path):
//                                                                                            ?>
<!--                                                                                            <a href="--><?//= base_url('upload/evaluation/' . @$techAttachment->file_path) ?><!--"-->
<!--                                                                                               target="_blank"-->
<!--                                                                                               class="btn btn-sm btn-primary">See-->
<!--                                                                                                Attachment</a>-->
<!--                                                                                        --><?php //endif; ?>
<!--                                                                                    --><?php //endif; ?>
                                                                                </th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            $no = 1;
                                                                            foreach ($blDetails->result() as $blDetail) {
                                                                                if ($blDetail->confirmed == 1) {
                                                                                    echo "<tr>
											  <td>$no</td>
											  <td>$blDetail->no_slka</td>
											  <td>$blDetail->vendor_name</td>";
                                                                                    if ($btndis2Tech and $this->session->userdata('evaluation_step') == 'technicalevaluation') {
                                                                                        if ($ed->commercial_data == 2) {
                                                                                            echo "<td class='text-center'><input type='number' onchange=\"scoringChange('tech-$no','$blDetail->bl_detail_id')\" id='tech-$no' class='form-control text-center attachment' min='0' max='100' value='$blDetail->scoring'></td>";
                                                                                        } else {
                                                                                            echo "<td class='text-center'>
													<a href='#' onclick=\"tech('$blDetail->bl_detail_id',1,'pass')\" class='btn btn-sm btn-success $disTech'><i class='fa fa-check'></i></a>
													<a href='#' onclick=\"tech('$blDetail->bl_detail_id',2,'check')\" class='btn btn-sm btn-danger $disTech'><i class='fa fa-stop'></i></a>
												  </td>";
                                                                                        }
                                                                                    }
                                                                                    if ($ed->commercial_data == 2) {
                                                                                        echo "<td id='tech-$no-result' class='text-center'>" . ($blDetail->scoring) . "</td>";
                                                                                    } else {
                                                                                        echo "<td id='tech-result-$blDetail->bl_detail_id' class='text-center'>" . evaluationStatus($blDetail->technical) . "</td>";
                                                                                    }
                                                                                    echo "<td id='tech-remark-$blDetail->bl_detail_id'>$blDetail->desc_technical</td>
											  <td></td>
											  </tr>";
                                                                                    $no++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <th width="1"></th>
                                                                                <th></th>
                                                                                <th></th>
                                                                                <?php if ($btndis2Tech and $this->session->userdata('evaluation_step') == 'technicalevaluation'): ?>
                                                                                    <?php if ($ed->commercial_data == 2): ?>
                                                                                        <th class="text-center"></th>
                                                                                    <?php else: ?>
                                                                                        <th class="text-center"></th>
                                                                                    <?php endif; ?>
                                                                                <?php endif; ?>
                                                                                <th class="text-center"></th>
                                                                                <th></th>
                                                                                <th>
                                                                                    <?php
                                                                                    if ($ed->technical == 0 and $msr->create_by == $this->session->userdata('ID_USER')):
                                                                                        ?>
                                                                                        <a href="#" data-toggle="modal"
                                                                                           data-target="#modal-upload-technical"
                                                                                           class="btn btn-sm btn-primary <?= $disTech ?>">Upload</a>
                                                                                        <a id="file_upload_name_tech"
                                                                                           href="#"
                                                                                           target="_blank"> </a>
                                                                                    <?php
                                                                                    else:
                                                                                        $techAttachment = $this->M_approval->seeAttachment('eva-technical', $msr_no)->row();
                                                                                        if (@$techAttachment->file_path):
                                                                                            ?>
                                                                                            <a href="<?= base_url('upload/evaluation/' . @$techAttachment->file_path) ?>"
                                                                                               target="_blank"
                                                                                               class="btn btn-sm btn-primary">See
                                                                                                Attachment</a>
                                                                                        <?php endif; ?>
                                                                                    <?php endif; ?>
                                                                                </th>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade" id="nav-commercial" role="tabpanel"
                                                             aria-labelledby="nav-commercial-tab">
                                                            <div class="row">
                                                                <div class="col-md-12 text-center">
                                                                    <?php
                                                                    $btndisCom = '';
                                                                    $btndisCom2 = true;
                                                                    $disCom = 'hidden';
                                                                    if (in_array(bled, $roles) and $ed->technical == 5 and $ed->administrative == 5 and $this->session->userdata('ID_USER') == $t_assignment->user_id) {
                                                                        $disCom = '';
                                                                    }
                                                                    if (isset($approved_commercial)):
                                                                        $btndisCom = $approved_commercial->commercial == 3 || $approved_commercial->commercial == 1 ? '' : 'disabled';
                                                                        // $btndisCom2 = $approved_commercial->commercial == 3 || $approved_commercial->commercial == 1  || $approved_commercial->commercial == 4 ? false:true;
                                                                        $btnApprovalCom = $approved_commercial->commercial == 3 ? "hidden" : "";
                                                                        ?>
                                                                        <!-- <a href="<?= base_url('upload/evaluation/' . $commercialAttachment->file_path) ?>" target="_blank" class="btn btn-sm btn-primary">See Attachment</a> -->
                                                                    <?php else: ?>
                                                                        <!-- <a href="#" data-toggle="modal" data-target="#modal-upload-commercial" class="btn btn-sm btn-primary <?= $disCom ?>">Upload</a> -->
                                                                    <?php endif; ?>

                                                                </div>
                                                                <div class="col-md-12">
                                                                    <div class="table-responsive"
                                                                         style="margin-bottom: 15px;">
                                                                        <table class="table table-condensed table-striped table-row-border">
                                                                            <thead>
                                                                            <tr>
                                                                                <th width="1">No</th>
                                                                                <th>SLKA No</th>
                                                                                <th>Bidder(s) Name</th>
                                                                                <?php if ($disCom): ?>
                                                                                <?php else: ?>
                                                                                    <th class="text-center">Action</th>
                                                                                <?php endif; ?>
                                                                                <th class="text-center">Result</th>
                                                                                <th>Remark</th>
                                                                                <th class="text-right">Original Value
                                                                                </th>
                                                                                <th class="text-right">Latest Value</th>
                                                                                <th>
<!--                                                                                    --><?php
//                                                                                    if ($ed->commercial == 0 and $ed->administrative == 5 and $ed->technical == 5 and $this->session->userdata('ID_USER') == $t_assignment->user_id):
//                                                                                        ?>
<!--                                                                                        <a href="#" data-toggle="modal"-->
<!--                                                                                           data-target="#modal-upload-commercial"-->
<!--                                                                                           class="btn btn-sm btn-primary --><?//= $disCom ?><!--">Upload</a>-->
<!--                                                                                        <a id="file_upload_name_com"-->
<!--                                                                                           href="#"-->
<!--                                                                                           target="_blank"> </a>-->
<!--                                                                                    --><?php
//                                                                                    else:
//                                                                                        $commercialAttachment = $this->M_approval->seeAttachment('eva-commercial', $msr_no)->row();
//                                                                                        if (@$commercialAttachment->file_path):
//                                                                                            ?>
<!--                                                                                            <a href="--><?//= base_url('upload/evaluation/' . @$commercialAttachment->file_path) ?><!--"-->
<!--                                                                                               target="_blank"-->
<!--                                                                                               class="btn btn-sm btn-primary">See-->
<!--                                                                                                Attachment</a>-->
<!--                                                                                        --><?php //endif; ?>
<!--                                                                                    --><?php //endif; ?>
                                                                                </th>
                                                                            </tr>
                                                                            </thead>
                                                                            <tbody>
                                                                            <?php
                                                                            $no = 1;
                                                                            foreach ($blDetails->result() as $blDetail) {
                                                                                if ($blDetail->confirmed == 1) {
                                                                                    echo "<tr>
    											<td>$no</td>
    											<td>$blDetail->no_slka</td>
    											<td>$blDetail->vendor_name</td>";
                                                                                    if ($disCom) {
                                                                                    } else {
                                                                                        echo "<td class='text-center'>
    												<a href='#' onclick=\"commercial('$blDetail->bl_detail_id',1,'pass')\" class='btn btn-sm btn-success $disCom' title='Pass'><i class='fa fa-check'></i></a>
    												<a href='#' onclick=\"commercial('$blDetail->bl_detail_id',2,'check')\" class='btn btn-sm btn-danger $disCom' title='Check'><i class='fa fa-stop'></i></a>
    											  </td>";
                                                                                    }

                                                                                    $sop_bid = $this->db->select('*')
                                                                                        ->join('t_sop', 't_sop_bid.sop_id=t_sop.id', 'left')
                                                                                        ->where(['t_sop.msr_no' => $msr_no, 'vendor_id' => $blDetail->vendor_id])
                                                                                        ->get('t_sop_bid')->result();

                                                                                    $oriVal = 0;
                                                                                    $latVal = 0;
                                                                                    foreach ($sop_bid as $r) {
                                                                                        if ($r->qty2 > 0) {
                                                                                            $oriVal += $r->qty1 * $r->qty2 * $r->unit_price;
                                                                                            $latVal += $r->qty1 * $r->qty2 * $r->nego_price;
                                                                                        } else {
                                                                                            $oriVal += $r->qty1 * $r->unit_price;
                                                                                            $latVal += $r->qty1 * $r->nego_price;
                                                                                        }
                                                                                    }
                                                                                    echo "<td id='com-result-$blDetail->bl_detail_id' class='text-center'>" . evaluationStatus($blDetail->commercial) . "</td>
                                                <td id='com-remark-$blDetail->bl_detail_id'>$blDetail->desc_commercial</td>";
                                                                                    echo "<td class='text-right'>" . numIndo($oriVal) . "</td>";
                                                                                    echo "<td class='text-right'>" . numIndo($latVal > 0 ? $latVal : $oriVal) . "</td>
                                                <td></td>
                                                </tr>";

                                                                                    $no++;
                                                                                }
                                                                            }
                                                                            ?>
                                                                            <tr>
                                                                                <th width="1"> </th>
                                                                                <th> </th>
                                                                                <th> </th>
                                                                                <?php if ($disCom): ?>
                                                                                <?php else: ?>
                                                                                    <th class="text-center"> </th>
                                                                                <?php endif; ?>
                                                                                <th class="text-center"> </th>
                                                                                <th> </th>
                                                                                <th class="text-right">
                                                                                </th>
                                                                                <th class="text-right"> </th>
                                                                                <th>
                                                                                    <?php
                                                                                    if ($ed->commercial == 0 and $ed->administrative == 5 and $ed->technical == 5 and $this->session->userdata('ID_USER') == $t_assignment->user_id):
                                                                                        ?>
                                                                                        <a href="#" data-toggle="modal"
                                                                                           data-target="#modal-upload-commercial"
                                                                                           class="btn btn-sm btn-primary <?= $disCom ?>">Upload</a>
                                                                                        <a id="file_upload_name_com"
                                                                                           href="#"
                                                                                           target="_blank"> </a>
                                                                                    <?php
                                                                                    else:
                                                                                        $commercialAttachment = $this->M_approval->seeAttachment('eva-commercial', $msr_no)->row();
                                                                                        if (@$commercialAttachment->file_path):
                                                                                            ?>
                                                                                            <a href="<?= base_url('upload/evaluation/' . @$commercialAttachment->file_path) ?>"
                                                                                               target="_blank"
                                                                                               class="btn btn-sm btn-primary">See
                                                                                                Attachment</a>
                                                                                        <?php endif; ?>
                                                                                    <?php endif; ?>
                                                                                </th>
                                                                            </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <nav>
                                                                        <div class="nav nav-tabs sub-tabs" id="nav-tab"
                                                                             role="tablist">
                                                                            <a class="nav-item nav-link active"
                                                                               id="nav-original-value-tab"
                                                                               data-toggle="tab"
                                                                               href="#tab-original-value" role="tab"
                                                                               aria-controls="nav-home"
                                                                               aria-selected="true">Original Value</a>
                                                                            <a class="nav-item nav-link"
                                                                               id="nav-latest-value-tab"
                                                                               data-toggle="tab"
                                                                               href="#tab-latest-value" role="tab"
                                                                               aria-controls="nav-profile"
                                                                               aria-selected="false">Latest Value</a>
                                                                            <a class="nav-item nav-link"
                                                                               id="nav-recommendation-tab"
                                                                               data-toggle="tab"
                                                                               href="#tab-recommendation" role="tab"
                                                                               aria-controls="nav-contact"
                                                                               aria-selected="false">Recommendation</a>
                                                                        </div>
                                                                    </nav>
                                                                    <div class="tab-content" id="nav-tabContent">
                                                                        <div class="tab-pane fade show active"
                                                                             id="tab-original-value" role="tabpanel"
                                                                             aria-labelledby="original-value-tab"
                                                                             style="padding: 15px 0px;">
                                                                            <?php $this->load->view('approval/priceevaluationnegotiation-new', ['ed' => $ed]); ?>
                                                                        </div>
                                                                        <div class="tab-pane fade show"
                                                                             id="tab-latest-value" role="tabpanel"
                                                                             aria-labelledby="latest-value-tab"
                                                                             style="padding: 15px 0px;">
                                                                            <?php $this->load->view('approval/priceevaluationnegotiation-new', ['ed' => $ed, 'nego' => true]); ?>
                                                                        </div>
                                                                        <div class="tab-pane fade show"
                                                                             id="tab-recommendation" role="tabpanel"
                                                                             aria-labelledby="recommendation-tab"
                                                                             style="padding: 15px 0px;">
                                                                            <?php $this->load->view('approval/perform-award-recomendation', ['ed' => $ed]); ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                        </fieldset>

                                        <!-- Step 2 -->
                                        <h6><i class="step-icon fa fa-th-list"></i>Enquiry Data</h6>
                                        <fieldset>
                                            <?php $this->load->view('approval/tab_ed_view', ['ed' => $ed, 'msr' => $msr]); ?>
                                        </fieldset>
                                        <!-- Step 3 -->
                                        <h6><i class="step-icon fa fa-download"></i>Enquiry Document</h6>
                                        <fieldset>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="table-responsive">
                                                        <table class="table table-condensed table-row-border">
                                                            <thead>
                                                            <tr>
                                                                <th>Type</th>
                                                                <th>Filename</th>
                                                                <th>Uploaded Date</th>
                                                                <th>Uploaded By</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <?php foreach ($doc as $key => $value) {
                                                                echo "<tr>
                                      <td>" . biduploadtype($value->tipe, true) . "</td>
                                      <td><a href='" . base_url('userfiles/temp/' . $value->file_path) . "' target='_blank'>" . $value->file_name . "</a></td>
                                      <td>" . dateToIndo($value->created_at, false, true) . "</td>
                                      <td>" . user($value->created_by)->NAME . "</td>
                                    </tr>";
                                                            } ?>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </fieldset>
                                        <h6><i class="step-icon fa fa-history"></i>History</h6>
                                        <fieldset>
                                            <div class="table-responsive ">
                                                <table class="table table-row-border">
                                                    <thead>
                                                    <tr>
                                                        <th width="1">No</th>
                                                        <th>User</th>
                                                        <th>Description</th>
                                                        <th>Transaction Date</th>
                                                        <th>Comment</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody id="result-approval">
                                                    <?php
                                                    $no = 1;
                                                    $log_history = $this->db->where(['data_id' => $msr_no])->where_in('module_kode', ['technical evaluation', 'admin evaluation'])->get('log_history');
                                                    foreach ($log_history->result() as $r) {
                                                        echo "<tr>
                                  <td>$no</td>
                                  <td>" . user($r->created_by)->NAME . "</td>
                                  <td>" . $r->description . "</td>
                                  <td>" . dateToIndo($r->created_at, false, true) . "</td>
                                  <td>" . $r->keterangan . "</td>
                                  </tr>";
                                                        $no++;
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </fieldset>
                                        <?php $this->load->view('approval/review_ee_tab'); ?>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- Form wizard with icon tabs section end -->
        </div>
        <!-- footer  -->
        <div class="content-footer" style="margin-bottom: 2em;margin-top: 0px">
            <?php
            /*seng di assign*/
            $t_assignment = $this->db->where(['msr_no' => $msr_no])->get('t_assignment')->row();
            if ($this->session->userdata('ID_USER') == $t_assignment->user_id and ($ed->administrative == 0 or $ed->administrative == 2)):
                ?>
                <a href="#" class="btn btn-success pull-right" onclick="myModalEvaluationClick('administrative')">Administration</a>

            <?php endif; ?>
            <?php
            /*get assign_sp/prochead*/
            $t_approval = $this->db->where(['data_id' => $msr_no, 'm_approval_id' => 8])->get('t_approval')->row();
            // echo $t_approval->created_by.'-'.$this->session->userdata('ID_USER').'-'.$ed->administrative;
            if ($this->session->userdata('ID_USER') == $t_approval->created_by and ($ed->administrative == 1 or $ed->administrative == 0) and $this->session->userdata('evaluation_step') == 'evaluationtobeapproved'):
                ?>
                <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modalApprovalAdm'>Approval
                    Administration</a>
            <?php endif; ?>

            <?php if ($msr->create_by == $this->session->userdata('ID_USER') and $ed->technical == 0 and $this->session->userdata('evaluation_step') == 'technicalevaluation'): ?>
                <a href="#" class="btn btn-success pull-right"
                   onclick="myModalEvaluationClick('technical')">Technical</a>
            <?php endif; ?>
            <?php
            /*get user manager*/
            $t_approval = $this->db->where(['data_id' => $msr_no, 'm_approval_id' => 1])->get('t_approval')->row();
            if ($this->session->userdata('ID_USER') == $t_approval->created_by and ($ed->technical == 1 or $ed->technical == 0) and $this->session->userdata('evaluation_step') == 'technicalapproval'):
                ?>
                <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modalApprovalTech'>Approval
                    Technical</a>
            <?php endif; ?>

            <?php
            if (isset($commercial)):
                if ($btndisCom == ''):
                    $rejectInfo = $this->db->where(['data_id' => $msr_no, 'status' => 2])->get('t_approval');
                    ?>
                    <a href="#"
                       class="btn btn-success pull-right <?= $ed->commercial == 0 || $ed->commercial == 0 ? '' : 'hidden' ?>"
                       onclick="awardRecomendationClick()"> Award Recomendation</a>
                    <?php if ($rejectInfo->num_rows() > 0): ?>
                    <a href="#" class="btn btn-danger" data-toggle='modal' data-target='#reject-info'>Reject info</a>
                    <div class="modal fade" id="reject-info" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Reject Information</h4>
                                </div>
                                <div class="modal-body">
                                    <?php
                                    $rejectInfo = $rejectInfo->row();
                                    $user = user($rejectInfo->created_by);
                                    ?>
                                    <p><b>Rejected by <?= $user->NAME ?></b></p>
                                    <p><?= nl2br($rejectInfo->deskripsi) ?></p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <?php else: ?>
                    <a href="#" class="btn btn-success <?= $btnApprovalCom ?>" data-toggle='modal'
                       data-target='#modalApprovalCom'>Approval Commercial</a>
                <?php endif; ?>
            <?php endif; ?>
            <?php
            if ($ed->commercial == 3):
                ?>
                <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modalAckCom'>Acknowledge
                    Commercial</a>
            <?php endif; ?>

            <?php
            if ($msr->create_by == $this->session->userdata('ID_USER') and $ed->administrative == 3 and $this->session->userdata('evaluation_step') == 'admack'):
                ?>
                <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modalAckAdm'>Acknowledge
                    Administrative</a>
            <?php endif; ?>

            <?php
            $t_approval = $this->db->where(['data_id' => $msr_no, 'm_approval_id' => 1])->get('t_approval')->row();
            if ($this->session->userdata('ID_USER') == $t_approval->created_by and $ed->administrative == 4 and $this->session->userdata('evaluation_step') == 'admack'):
                ?>
                <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modalAckAdm'>Acknowledge
                    Administrative</a>
            <?php endif; ?>

            <?php
            /*seng di assign*/
            $t_assignment = $this->db->where(['msr_no' => $msr_no])->get('t_assignment')->row();
            if ($this->session->userdata('ID_USER') == $t_assignment->user_id and $ed->technical == 3 and $this->session->userdata('evaluation_step') == 'techack'):
                ?>
                <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modalAckTech'>Acknowledge
                    Technical</a>
            <?php endif; ?>

            <?php
            /*ack tech fase proc head*/
            $t_approval = $this->db->where(['data_id' => $msr_no, 'm_approval_id' => 8])->get('t_approval')->row();
            if ($this->session->userdata('ID_USER') == $t_approval->created_by and $ed->technical == 4 and $this->session->userdata('evaluation_step') == 'techack'):
                ?>
                <a href="#" class="btn btn-success pull-right" data-toggle='modal' data-target='#modalAckTech'>Acknowledge
                    Technical</a>
            <?php endif; ?>

            <?php //if($ed->administrative == 5 and $ed->commercial == 1 and $ed->technical == 5):?>
            <?php //$this->load->view('approval/modalnego', ['ed'=>$ed]);?>
            <?php //endif;?>

        </div>
    </div>
</div>

<!-- myModalEvaluation -->
<div class="modal fade" id="modalApprovalTech" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Approval Technical Evaluation</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/approvalevaluation') ?>"
                      class="form-horizontal" id="frm-approval-technical-evaluation">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <input type="hidden" name="approval_ed" value="technical" class="not-disabled">
                    <input type="hidden" name="module_kode" value="technical evaluation" class="not-disabled">
                    <input type="hidden" name="description" value="Approval Technical Evaluation" class="not-disabled">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control status" name="technical" id="technical_approval">
                            <option value="3">Approve</option>
                            <option value="0">Reject</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="deskripsi" id="deskripsi_approvaltechnical" class="form-control not-disabled"
                                  placeholder="Comment Here"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" onclick="approvalTechEvaSubmit()" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function approvalTechEvaSubmit() {
        xStatus = parseInt($("#technical_approval").val());
        if (xStatus == 3) {
            $("#frm-approval-technical-evaluation").submit()
        }
        else {
            if ($("#deskripsi_approvaltechnical").val()) {

            }
            else {
                swal('<?= __('warning') ?>', 'Comments shall be filled in', 'warning')
                return false;
            }
            $("#frm-approval-technical-evaluation").submit()
        }
    }
</script>
<div class="modal fade" id="modalApprovalAdm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Approval Administration Evaluation</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/approvalevaluation') ?>"
                      id="frm-approval-administration-evaluation">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <input type="hidden" name="approval_ed" value="administrative" class="not-disabled">
                    <div class="form-group">
                        <label>Status</label>
                        <select class="form-control status" name="administrative" id="administrative_approval">
                            <option value="3">Approve</option>
                            <option value="0">Reject</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Comments</label>
                        <textarea name="deskripsi" id="deskripsi_approvaladministrative"
                                  class="form-control not-disabled" placeholder="Comment Here"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" onclick="approvalAdminEvaSubmit()">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function approvalAdminEvaSubmit() {
        swalConfirm('<?= __('warning') ?>', '<?= __('confirm_submit') ?>', function () {
            xStatus = parseInt($("#administrative_approval").val());
            if (xStatus == 3) {
                $("#frm-approval-administration-evaluation").submit()
            }
            else {
                if ($("#deskripsi_approvaladministrative").val()) {

                }
                else {
                    setTimeout(function () {
                        swal('<?= __('warning') ?>', 'The Comment field is required', 'warning');
                    }, swalDelay);
                    return false;
                }
                $("#frm-approval-administration-evaluation").submit()
            }
        });
    }
</script>
<div class="modal fade" id="modalApprovalCom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Approval Commercial Evaluation</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/approvalevaluation') ?>"
                      class="form-horizontal">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <div class="form-group row">
                        <label class="col-sm-3">
                            Choose One
                        </label>
                        <div class="col-sm-9">
                            <select class="form-control status" name="commercial">
                                <option value="3">Approve</option>
                                <option value="0">Reject</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Bid Opening</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/savebidopening') ?>/<?= $ed->id ?>"
                      class="form-horizontal" id="mydfr ">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Are You Sure to Bid Opening ?
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalEvaluation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Administration Evaluation</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/administrationevaluation') ?>"
                      class="form-horizontal" id="mydfr ">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <input type="hidden" name="administrative" id="administrative" value="1">
                    <div class="form-group">
                        <label>Are You Sure to Finish Administration Evaluation ?</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control not-disabled"
                                  placeholder="Comment Here"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalEvaluationTechnical" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Technical Evaluation</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/technicalevaluation') ?>"
                      class="form-horizontal" id="mydfr ">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <input type="hidden" name="technical" id="technical" value="1">
                    <input type="hidden" name="description" class="not-disabled" value="Technical Evaluation">
                    <div class="form-group">
                        <label>Are You Sure to Finish Technical Evaluation ?</label>
                        <textarea name="deskripsi" id="deskripsi" class="form-control not-disabled"
                                  placeholder="Comment Here"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success btn-primary">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="myModalEvaluationCommercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Award Recommendation</h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="post"
                      action="<?= base_url('approval/award/recomendation') ?>" class="form-horizontal" id="frmcomeva">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <input type="hidden" class="msr_no" name="msr_no" value="<?= $msr_no ?>">
                    <input type="hidden" name="commercial" id="commercial" value="1">
                    <input type="hidden" name="award" id="award" value="1">
                    <div class="form-group award-popup">

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- modalAckAdm -->
<div class="modal fade" id="modalAckAdm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Administrative Acknowledge Evaluation</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/administrationevaluation') ?>"
                      class="form-horizontal">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <input type="hidden" name="description" class="not-disabled"
                           value="Acknowledge Administration Evaluation">
                    <input type="hidden" name="administrative" id="administrative"
                           value="<?= $ed->administrative == 3 ? 4 : 5 ?>">
                    <div class="form-group">
                        <label>Are You Sure to Acknowledge Administration Evaluation ?</label>
                        <textarea name="deskripsi" class="form-control not-disabled"
                                  placeholder="Comment Here"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modalAckTech -->
<div class="modal fade" id="modalAckTech" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">TECHNICAL EVALUATION ACKNOWLEDGEMENT</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/technicalevaluation') ?>"
                      class="form-horizontal">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <input type="hidden" name="description" class="not-disabled"
                           value="Acknowledge Technical Evaluation">
                    <input type="hidden" name="technical" id="technical" value="<?= $ed->technical == 3 ? 4 : 5 ?>">
                    <div class="form-group">
                        Are you Sure to Technical Evaluation Acknowledgement?
                    </div>
                    <div class="form-group">
                        <textarea name="deskripsi" class="form-control not-disabled"
                                  placeholder="Comment Here"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- modalAckCom -->
<div class="modal fade" id="modalAckCom" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Commercial Acknowledge Evaluation</h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/technicalevaluation') ?>"
                      class="form-horizontal">
                    <input type="hidden" name="ed_id" id="ed_id" value="<?= $ed->id ?>">
                    <input type="hidden" name="commercial" id="commercial" value="4">
                    <div class="form-group">
                        <div class="col-sm-12">
                            Are you Sure to Acknowledge Commercial Evaluation?
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-pass-adm" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="adm-confirm"></h4>
            </div>
            <div class="modal-body">
                <form method="post" action="<?= base_url('approval/approval/administrative') ?>" id="frmadm">
                    <input type="hidden" name="bl_detail_id" id="bl_detail_id">
                    <input type="hidden" name="administrative" id="administrative">
                    <div class="form-group">
                        <label id="body-adm-confirm"></label>
                        <textarea class="form-control" rows="3" name="desc_administrative" id="desc_administrative"
                                  placeholder="Add note optional"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" onclick="admClick()" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-pass-commercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="commercial-confirm"></h4>
            </div>
            <div class="modal-body">
                <div id="body-commercial-confirm"></div>
                <form method="post" action="<?= base_url('approval/approval/commercial') ?>" id="frmtech">
                    <input type="hidden" name="commercial" id="commercial">
                    <div class="form-group row">
                        <div class="col-md-12">
                            <textarea class="form-control desc-note" rows="3" name="desc_commercial"
                                      id="desc_commercial" placeholder="Add note optional"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" onclick="commercialClick()" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-pass-tech" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="tech-confirm"></h4>
            </div>
            <div class="modal-body">
                <div id="body-adm-confirm"></div>
                <form method="post" action="<?= base_url('approval/approval/administrative') ?>" id="frmtech">
                    <input type="hidden" name="technical" id="technical">
                    <div class="form-group">
                        <textarea class="form-control desc-note" rows="3" name="desc_technical" id="desc_technical"
                                  placeholder="Add note optional"></textarea>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" onclick="techClick()" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-upload-commercial" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Upload</h4>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" id="frmcommercial" enctype="multipart/form-data">
                    <input type="hidden" name="data_id" value="<?= $msr_no ?>" class="data_id">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="file" name="upload" required="" class="attachment desc-note"
                                   id="file_commercial">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-12 text-right">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                            <button type="button" onclick="evaluationupload('commercial')" class="btn btn-primary">
                                Upload
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-upload-administrative" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Upload</h4>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" id="frmadministrative" enctype="multipart/form-data">
                    <input type="hidden" name="data_id" value="<?= $msr_no ?>" class="data_id">
                    <div class="form-group">
                        <input type="file" name="upload" required="" class="attachment desc-note"
                               id="file_administration">
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" onclick="evaluationupload('administrative')" class="btn btn-success">
                            Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="modal-upload-technical" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel">Upload</h4>
            </div>
            <div class="modal-body">
                <form method="post" class="form-horizontal" id="frmtechnical" enctype="multipart/form-data">
                    <input type="hidden" name="data_id" value="<?= $msr_no ?>" class="data_id">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <input type="file" name="upload" required="" class="attachment desc-note" id="file_tech">
                        </div>
                    </div>
                    <div class="form-group text-right">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                        <button type="button" onclick="evaluationupload('technical')" class="btn btn-success">Upload
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="document_expired-modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title-title"><?= lang("Document Expired", "Document Expired") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="document_expired-modal-body" class="modal-body" style="max-height: 400px; overflow-y: auto;">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div id="modal-award-validation" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title-title"
                    id="title-award-validation"><?= lang("Validation Award", "Award Validation") ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div id="modal-award-validation-data" class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#frm-bled input,#frm-bled select,#frm-bled textarea").attr('disabled', 'disabled');
        $("#ed_id,#desc_administrative,#administrative,#bl_detail_id,.attachment,.data_id,#desc_technical,#technical,.status,.desc-note,#commercial,.recomendation,#award_choice,#msr_no,.msr_no,#award,.not-disabled").removeAttr('disabled');
        // $("#kirim-clarification").removeAttr('class');
        // $("#kirim-clarification").attr('class','btn btn-primary disabled');
        if (!($('.modal.in').length)) {
            $('.modal-dialog').css({
                top: 0,
                left: 0
            });
        }
        $('.modal-dialog').draggable({
            handle: ".modal-header"
        });
        //form step
        $("#frm-bled").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '#title#',
            enableFinishButton: false,
            enablePagination: true,
            enableAllSteps: true,
            labels: {
                finish: 'Done'
            },
            onFinished: function (event, currentIndex) {
                // alert("Form submitted.");
            }
        });
        $("#administrative_approval").change(function () {
            if ($(this).val() == '0') {
                $("#deskripsi_approvaladministrative").attr('required', '')
            }
            else {
                $("#deskripsi_approvaladministrative").removeAttr('required')
            }
        })
        $("#technical_approval").change(function () {
            if ($(this).val() == '0') {
                $("#deskripsi_approvaltechnical").attr('required', '')
            }
            else {
                $("#deskripsi_approvaltechnical").removeAttr('required')
            }
        })
        //hide next and previous button
        $('a[href="#next"]').hide();
        $('a[href="#previous"]').hide();

    });
    $("input,select,textarea").attr('disabled', 'disabled');

    function adm(bl_detail_id, administrative, type) {
        if (type == 'pass') {
            $("#adm-confirm").html('Pass Evaluation Confirmation');
            $("#body-adm-confirm").html('Are You Sure to Pass ?');
        }
        else {
            $("#adm-confirm").html('Fail Evaluation Confirmation');
            $("#body-adm-confirm").html('Are You Sure to Fail ?');
        }
        $("#bl_detail_id").val(bl_detail_id);
        $("#administrative").val(administrative);
        $("#modal-pass-adm").modal('show');
    }

    function admClick() {
        var blDetailId = $('#bl_detail_id').val();
        $.ajax({
            type: 'post',
            data: {
                id: blDetailId,
                administrative: $('#administrative').val(),
                desc_administrative: $('#desc_administrative').val()
            },
            url: "<?=base_url('approval/approval/administrative')?>",
            beforeSend: function () {
                start($('#icon-tabs'));
            },
            success: function (data) {
                var r = eval("(" + data + ")");
                $("#modal-pass-adm").modal('hide');
                $("#adm-result-" + blDetailId).html(r.msg);
                $("#adm-remark-" + blDetailId).html(r.remark);
                stop($('#icon-tabs'));
            },
            error: function (e) {
                alert('Fail, Try Again');
                stop($('#icon-tabs'));
            }
        })
    }

    function evaluationupload(type) {
        var form = $('#frm' + type)[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?=base_url('approval/approval/evaluationupload')?>/" + type,
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            success: function (data) {
                var x = eval("(" + data + ")");

                if (type == 'administrative') {
                    var filename = $('#file_administration').val().split('\\').pop();
                    $("#file_upload_name").text(filename);
                    $("#file_upload_name").attr("href", "<?=base_url('upload/evaluation/')?>" + "/" + x.filename);
                } else if (type == 'technical') {

                    var filename = $('#file_tech').val().split('\\').pop();
                    // alert(filename);
                    $("#file_upload_name_tech").text(filename);
                    $("#file_upload_name_tech").attr("href", "<?=base_url('upload/evaluation/')?>" + "/" + x.filename);
                } else if (type == 'commercial') {
                    var filename = $('#file_commercial').val().split('\\').pop();
                    // alert(filename);
                    $("#file_upload_name_com").text(filename);
                    $("#file_upload_name_com").attr("href", "<?=base_url('upload/evaluation/')?>" + "/" + x.filename);
                }

                swal('Done', x.msg, 'success');
                $("#modal-upload-" + type).modal('hide');
            },
            error: function (e) {
                swal('<?= __('warning') ?>', 'Something went wrong!', 'warning')
            }
        });
    }

    function tech(bl_detail_id, technical, type) {
        if (type == 'pass') {
            $("#tech-confirm").html('Pass Evaluation Confirmation');
            $("#body-tech-confirm").html('Are You Sure to Pass?');
        }
        else {
            $("#tech-confirm").html('Fail Evaluation Confirmation');
            $("#body-tech-confirm").html('Are You Sure to Fail?');
        }
        $("#bl_detail_id").val(bl_detail_id);
        $("#technical").val(technical);
        $("#modal-pass-tech").modal('show');
    }

    function commercial(bl_detail_id, technical, type) {
        if (type == 'pass') {
            $("#commercial-confirm").html('Pass Evaluation Confirmation');
            $("#body-commercial-confirm").html('Are You Sure to Pass?');
        }
        else {
            $("#commercial-confirm").html('Fail Evaluation Confirmation');
            $("#body-commercial-confirm").html('Are You Sure to Fail?');
        }
        $("#desc_commercial").val("");
        $("#bl_detail_id").val(bl_detail_id);
        $("#commercial").val(technical);
        $("#modal-pass-commercial").modal('show');
    }

    function techClick() {
        var blDetailId = $('#bl_detail_id').val();
        $.ajax({
            type: 'post',
            data: {
                id: $('#bl_detail_id').val(),
                technical: $('#technical').val(),
                desc_technical: $('#desc_technical').val()
            },
            url: "<?=base_url('approval/approval/administrative')?>",
            beforeSend: function () {
                start($('#icon-tabs'));
            },
            error: function (e) {
                alert('Fail, Try Again');
                stop($('#icon-tabs'));
            },
            success: function (data) {
                var r = eval("(" + data + ")");
                $("#modal-pass-tech").modal('hide');
                $("#tech-result-" + blDetailId).html(r.msg);
                $("#tech-remark-" + blDetailId).html(r.remark);
                stop($('#icon-tabs'));
            }
        })
    }

    function commercialClick() {
        var blDetailId = $('#bl_detail_id').val();
        $.ajax({
            type: 'post',
            data: {
                id: $('#bl_detail_id').val(),
                commercial: $('#commercial').val(),
                desc_commercial: $('#desc_commercial').val()
            },
            url: "<?=base_url('approval/approval/administrative')?>",
            beforeSend: function () {
                start($('#icon-tabs'));
            },
            error: function (e) {
                alert('Fail, Try Again');
                stop($('#icon-tabs'));
            },
            success: function (data) {
                var r = eval("(" + data + ")");
                $("#modal-pass-commercial").modal('hide');
                $("#com-result-" + blDetailId).html(r.msg);
                $(".com-result-" + blDetailId).html(r.msg);
                $("#com-remark-" + blDetailId).html(r.remark);
                stop($('#icon-tabs'));
            }
        })

        /*$.ajax({
          type:'post',
          data:{id:$('#bl_detail_id').val(),commercial:$('#commercial').val(),desc_commercial:$('#desc_commercial').val()},
          url:"<?=base_url('approval/approval/administrative')?>",
        success:function(e){
          alert(e);
          $("#modal-pass-tech").modal('hide');
        },
        errorr:function(e){
          alert('Update error, try again');
        }
      })*/
    }

    function scoringChange(elementId, blDetailId) {
        var n = $("#" + elementId).val();
        $.ajax({
            type: 'post',
            data: {n: n, bl_detail_id: blDetailId},
            url: "<?=base_url('approval/approval/scoring')?>",
            beforeSend: function () {
                start($('#icon-tabs'));
            },
            success: function (data) {
                $("#" + elementId + "-result").html(data);
                stop($('#icon-tabs'));
            },
            error: function (e) {
                alert('Fail, Try Again');
                stop($('#icon-tabs'));
            }
        })
    }

    const numberWithCommas = (x) => {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    function awardRecomendationClick() {
        $(".recomendation").removeAttr("disabled");
        $.ajax({
            url: "<?= base_url('approval/award/check_award_validation') ?>",
            data: $("#frm-bled").serialize() + "&lowest_price_val=" + $("#lowest_price_val").val(),
            type: 'post',
            success: function (e) {
                var r = eval("(" + e + ")");
                if (r.status) {
                    $("#myModalEvaluationCommercial").modal('show')
                }
                else {
                    $("#modal-award-validation-data").html(r.html)
                    $("#title-award-validation").html("Award Validation")
                    $("#modal-award-validation").modal('show')
                }
                // $(".recomendation").attr("disabled","");
            }
        })
    }

    function reviewEEClick() {
        var lowest_price_val = $("#lowest_price_val").val()
        $.ajax({
            type: 'POST',
            url: "<?=base_url('approval/award/review_ee')?>",
            data: {msr_no: "<?=$msr_no?>", lowest_price_val: lowest_price_val},
            success: function (e) {
                $("#title-award-validation").html("EE Review")
                $("#modal-award-validation-data").html(e)
            }
        })
        // $("#modal-award-validation").modal('hide')
        // $("#modal-award-ee").modal('show')
    }

    function document_expired(id) {
        $.ajax({
            url: '<?= base_url('vendor/registered_supplier/document_expired') ?>/' + id,
            success: function (response) {
                $('#document_expired-modal-body').html(response);
                $('#document_expired-modal').modal('show');
            }
        })
    }

    $(function () {
        $('#document_expired-modal').on('hidden.bs.modal', function () {
            $('#document_expired-modal-body').html('');
        });
    });

    function myModalEvaluationClick(param) {
        $.ajax({
            type: 'post',
            url: "<?=base_url('approval/approval/evaluation_checker')?>",
            data: {field: param, msr_no: "<?=$msr_no?>"},
            beforeSend: function () {
                //start($('#icon-tabs'));
            },
            success: function (q) {
                var r = eval("(" + q + ")");
                if (r.status) {
                    if (param == 'technical') {
                        $("#myModalEvaluationTechnical").modal('show')
                    }
                    else {
                        $("#myModalEvaluation").modal('show')
                    }
                }
                else {
                    swal('<?= __('warning') ?>', r.msg, 'warning')
                }
                //stop($('#icon-tabs'));
            },
            error: function (e) {
                swal('<?=  __('warning') ?>', 'Something went wrong!', 'warning')
                stop($('#icon-tabs'));
            }
        })
    }
</script>