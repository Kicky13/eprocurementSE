<?php $this->load->view('procurement/partials/script');?>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang($title, $title) ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("ARF Notification", "ARF Notification") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <div class="row info-header">
                <div class="col-md-4">
                    <table class="table table-condensed">
                        <tr>
                            <td width="30%">Title</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="head_title"></span> <?= $arf->po_title ?></strong></td>
                        </tr>
                        <tr>
                            <td width="30%">Vendor</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="head_vendor"></span> <?= $arf->vendor ?></strong></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table table-condensed">
                        <tr>
                            <td width="30%">Requestor</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="head_rqstr"></span> <?= $arf->requestor ?></strong></td>
                        </tr>
                        <tr>
                            <td width="30%">Company</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="head_comp"></span> <?= $arf->company ?></strong></td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-4">
                    <table class="table table-condensed">
                        <tr>
                            <td width="30%">Agreement No</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="head_agrmnt"></span> <?= $po_no ?></strong></td>
                        </tr>
                        <tr>
                            <td width="30%">Amendment No</td>
                            <td class="no-padding-lr">:</td>
                            <td><strong><span id="head_amend"></span> <?= $amdNumber = substr($arf->doc_no, -5); ?></strong></td>
                        </tr>
                    </table>
                </div>
            </div>
            <div class="card">
                <div class="card-content">
                    <div class="card-body card-dashboard card-scroll">
                        <form id="wizard-arf" class="wizard-circle">
                            <h6><i class="step-icon icon-info"></i> Amendment Notification</h6>
                            <fieldset>
                                <table class="table table-condensed table-bordered">
                                    <thead>
                                        <tr>
                                            <th colspan="3" class="text-center">Type/Description<br><small>(thick one when applicable)</small></th>
                                            <th style="vertical-align: top !important;">Remark</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td width="1px">
                                                <?php if (isset($arf->revision['value'])) { ?>
                                                    <i class="fa fa-check-square text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-square-o"></i>
                                                <?php } ?>
                                            </td>
                                            <td>Value</td>
                                            <td>
                                                <?php if (isset($arf->revision['value'])) { ?>
                                                    <?= $arf->currency ?> <span><?= numIndo($arf->estimated_value_new) ?></span>
                                                <?php } ?>
                                            </td>
                                            <td><?= @$arf->revision['value']->remark ?></td>
                                        </tr>
                                        <tr>
                                            <td width="1px">
                                                <?php if (isset($arf->revision['time'])) { ?>
                                                    <i class="fa fa-check-square text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-square-o"></i>
                                                <?php } ?>
                                            </td>
                                            <td>Time</td>
                                            <td><?= dateToIndo(@$arf->revision['time']->value) ?></td>
                                            <td><?= @$arf->revision['time']->remark ?></td>
                                        </tr>
                                        <tr>
                                            <td width="1px">
                                                <?php if (isset($arf->revision['scope'])) { ?>
                                                    <i class="fa fa-check-square text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-square-o"></i>
                                                <?php } ?>
                                            </td>
                                            <td>Scope</td>
                                            <td><?= @$arf->revision['scope']->value ?></td>
                                            <td><?= @$arf->revision['scope']->remark ?></td>
                                        </tr>
                                        <tr>
                                            <td width="1px">
                                                <?php if (isset($arf->revision['other'])) { ?>
                                                    <i class="fa fa-check-square text-success"></i>
                                                <?php } else { ?>
                                                    <i class="fa fa-square-o"></i>
                                                <?php } ?>
                                            </td>
                                            <td width="50px">Other</td>
                                            <td><?= @$arf->revision['other']->value ?></td>
                                            <td><?= @$arf->revision['other']->remark ?></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>Uploaded Date</th>
                                            <th>Uploaded By</th>
                                            <th>Download</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        $notifUpload = $this->db->select('t_arf_notification_upload.*,m_user.NAME user_name')
                                        ->join('m_user','m_user.ID_USER=t_arf_notification_upload.create_by','left')
                                        ->join('t_arf_notification','t_arf_notification.id=t_arf_notification_upload.doc_id','left')
                                        ->where(['t_arf_notification_upload.po_no'=>$po_no, 't_arf_notification.doc_no' => $arf->doc_no])->get('t_arf_notification_upload');
                                        
                                        foreach ($notifUpload->result() as $notif) :
                                            $fileName = $notif->file_name;
                                            $createdDate = dateToIndo($notif->create_date);
                                            $createdBy = $notif->user_name;
                                            $filePath = $notif->file_path;
                                    ?>
                                        <tr>
                                            <td><?= $fileName ?></td>
                                            <td><?= $createdDate ?></td>
                                            <td><?= $createdBy ?></td>
                                            <td><a target="_blank" class="btn btn-sm btn-info" href="<?= base_url() ?><?= $filePath ?>">Download</a></td>
                                        </tr>
                                    <?php endforeach;?>
                                    </tbody>
                                </table>
                            </fieldset>
                        </form>
                    </div>
                    <div class="card-footer">
                      
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $("#wizard-arf").steps({
            headerTag: "h6",
            bodyTag: "fieldset",
            transitionEffect: "fade",
            titleTemplate: '#title#',
            enableFinishButton: false,
            enablePagination: false,
            enableAllSteps: true,
            enableFinishButton: false
        });
    });
  
</script>