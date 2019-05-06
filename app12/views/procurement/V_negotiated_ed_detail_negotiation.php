<table class="table table-striped table-price">
    <thead>
        <tr>
            <th>Nama</th>
            <th>SLKA</th>
            <th>Email</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <?php foreach ($rs_detail_negotiation as $r_detail_negotiation) { ?>
        <tbody>
            <tr>
                <td><?= $r_detail_negotiation->NAMA ?></td>
                <td><?= $r_detail_negotiation->NO_SLKA ?></td>
                <td><?= $r_detail_negotiation->ID_VENDOR ?></td>
                <td class="text-center"><?= ($r_detail_negotiation->status == 1) ? '<a href="javascript:void(0)" class="btn btn-success btn-sm" onclick="detail_negotiation_submited(\''.$r_detail_negotiation->nego_id.'\')">Submited</a>' : 'Unresponsed' ?></td>
            </tr>
        </tbody>
    <?php } ?>
</table>

<script>
    $(function() {
        $('#detail-nego-modal').on('hidden.bs.modal', function() {
            $('#detail-nego-modal .modal-body').html('');
        });
    });

    function detail_negotiation_submited(nego_id) {
        $.ajax({
            url : '<?= base_url('procurement/negotiated_ed/detail_negotiation_submited') ?>/'+nego_id,
            success : function(response) {
                $('#detail-nego-modal .modal-body').html(response);
                $('#detail-nego-modal').modal('show');
            }
        });
    }
</script>