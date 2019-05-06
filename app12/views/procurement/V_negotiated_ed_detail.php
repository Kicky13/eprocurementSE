<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-12 col-12 mb-2">
                <h3 class="content-header-title mb-0">Negotiation</h3>
            </div>
        </div>
        <div class="row info-header">
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 105px;">Company</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->company?></td>
                    </tr>
                    <tr>
                        <td style="width: 105px;">Department</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->department?></td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 105px;">MSR Number</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->msr_no?></td>
                    </tr>
                    <tr>
                        <td style="width: 105px;">MSR Value</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->currency?> <?=numIndo($ed->total_amount)?> (<small style="color:red"><i>Exclude VAT</i></small>)</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-4">
                <table class="table table-condensed">
                    <tr>
                        <td style="width: 105px;">ED Number</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->bled_no ?></td>
                    </tr>
                    <tr>
                        <td style="width: 105px;">Title</td>
                        <td class="no-padding-lr">:</td>
                        <td><?=$ed->subject?></td>
                    </tr>
                </table>
            </div>
        </div>
        <div class="content-body">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <?php $this->load->view('V_alert') ?>
                        <div class="form-group text-right">
                            <a href="javascript:void(0)" class="btn btn-danger" onclick="swalConfirm('Negotiation', 'Are you sure to proceed ?', '<?= base_url('procurement/negotiated_ed/close/'.$ed->msr_no) ?>')">Close All Negotiation</a>
                        </div>
                        <table class="table table-striped table-price">
                            <thead>
                                <tr>
                                    <td>Company Letter No</td>
                                    <td>Closing Date</td>
                                    <td class="text-center">Supporting Document</td>
                                    <td>Note</td>
                                    <td class="text-center">Requested At</td>
                                    <td class="text-center">Submited</td>
                                    <td class="text-center">Closed</td>
                                    <td class="text-right">Action</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($rs_negotiated as $r_negotiated) { ?>
                                    <tr>
                                        <td><?= $r_negotiated->company_letter_no ?></td>
                                        <td><?= dateToIndo($r_negotiated->closing_date, false, true) ?></td>
                                        <td class="text-center">
                                            <?php if ($r_negotiated->supporting_document) { ?>
                                                <a href="<?= base_url('upload/NEGOTIATION/'.$r_negotiated->supporting_document) ?>" class="btn btn-primary btn-sm" target="_blank">Download</a>
                                            <?php } ?>
                                        </td>
                                        <td>
                                            <?= nl2br($r_negotiated->note) ?>
                                        </td>
                                        <td class="text-center">
                                            <?= dateToIndo($r_negotiated->created_at, false, true) ?>
                                        </td>
                                        <td class="text-center">
                                            <a href="javascript:void(0)" onclick="detail_negotiation('<?= $r_negotiated->company_letter_no ?>')"><?= $r_negotiated->nego_responsed ?> / <?= $r_negotiated->nego_requested ?></a>
                                        </td>
                                        <td class="text-center">
                                            <?php if ($r_negotiated->closed == 1) { ?>
                                                <span class="text text-danger">Close</span>
                                            <?php } else { ?>
                                                <span class="text text-success">Open</span>
                                            <?php } ?>
                                        </td>
                                        <td class="text-right">
                                            <?php if ($r_negotiated->nego_responsed <> $r_negotiated->company_letter_no AND $r_negotiated->closed == 0) { ?>
                                                <a href="javascript:void(0)" class="btn btn-danger btn-sm" onclick="swalConfirm('Negotiation', 'Are you sure to proceed ?', '<?= base_url('procurement/negotiated_ed/close/'.$ed->msr_no.'/'.$r_negotiated->company_letter_no) ?>')">Close</a>
                                            <?php } ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="detail-nego-modal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Detail Negotiation</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(function() {
        $('#detail-nego-modal').on('hidden.bs.modal', function() {
            $('#detail-nego-modal .modal-body').html('');
        });
    });

    function detail_negotiation(company_letter_no) {
        $.ajax({
            url : '<?= base_url('procurement/negotiated_ed/detail_negotiation') ?>',
            type:'get',
            data : {company_letter_no:company_letter_no},
            success : function(response) {
                $('#detail-nego-modal .modal-body').html(response);
                $('#detail-nego-modal').modal('show');
            }
        });
    }
</script>