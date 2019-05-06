<?php    
    $rs_note = $this->m_note->join('m_user', 'm_user.ID_USER = t_note.created_by')
    ->where('module_kode', $module_kode)
    ->where('data_id', $data_id)
    ->order_by('created_at', 'desc')
    ->get();
?>

<?php if (count($rs_note) <> 0) { ?>    
    <h2>Note</h2>
    <div style="max-height: 300px;overflow-y: auto;">
    <table class="table table-bordered">        
    <?php foreach ($rs_note as $r_note) { ?>
        <tr>
            <td>
                <p><?= $r_note->description ?></p>
                <small>Post by <?= $r_note->NAME ?> | <?= $r_note->created_at ?></small>
            </td>
        </tr>
    <?php } ?>
    </table>
    </div>
<?php } ?>