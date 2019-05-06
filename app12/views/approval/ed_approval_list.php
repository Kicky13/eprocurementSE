<?php 
  $no=1;
  $userLogin = user();
  foreach ($r as $s) : 
?>
  <tr>
    <td><?=$no++?></td>
    <td><?=$s->role_name?></td>
    <td><?=$s->nama?></td>
    <td><?=langApproval($s->status)['title']?></td>
    <td><?=$s->deskripsi?></td>
    <td>
      <?php if($s->created_by == $userLogin->ID_USER): ?>
        <a href="#" class="btn btn-sm btn-primary" onclick="approveRejectModal(<?=$s->id?>)">Approve/Rejecet</a>
      <?php else:?>
      <?php endif;?>
    </td>
  </tr>
<?php endforeach;?>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title" id="myModalLabel">Approval</h4>
      </div>
      <div class="modal-body">
        <form method="post" action="<?=base_url('ed/approve')?>" class="form-horizontal" id="frm">
          <!-- data_id -->
          <input type="hidden" name="id" id="id" value="">
          <input type="hidden" name="data_id" value="<?=$data_id?>">
          <input type="hidden" name="module_kode" value="msr_spa">
          <div class="form-group">
            <label>Status</label>
            <div class="col-sm-12">
              <select class="form-control" name="status" id="status">
                <option value="1">Approve</option>
                <option value="2">Reject</option>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label>Comments</label>
            <div class="col-sm-12">
              <textarea class="form-control" name="deskripsi" id="deskripsi"></textarea>
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-12">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" onclick="saveApprovalClick()" id="str-btn-ar">Approve</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  function approveRejectModal(idnya) {
        if (!validate_status_budget()) {
            return false
        } 

    $("#myModal").modal('show');
    $("#id").val(idnya);
  }
  function saveApprovalClick() {
    xStatus = parseInt($("#status").val());
    if(xStatus == 1)
    {
      /*approve*/ url = "<?=base_url('approval/ed/approve')?>";
    }
    else
    {
      url = "<?=base_url('approval/ed/reject')?>";
      if($("#deskripsi").val())
      {

      }
      else
      {
        alert('Deskripsi Harus Diisi')
        return false;
      }
    }
    $.ajax({
      type:'post',
      data:$("#frm").serialize(),
      url:url,
      beforeSend:function(){
        start($('#myModal'));
      },
      success:function(r){
        var a = eval("("+r+")");
        alert(a.msg);
        stop($('#myModal'));
        $("#myModal").modal('hide');
        if(a.status)
        {
          $.ajax({
            type:'post',
            url:"<?=base_url('approval/ed/get_ajax_list_ed')?>",
            data:{data_id:"<?=$data_id?>"},
            success:function(e)
            {
              $("#approval_list").html(e);
            }
          })
        }
        else
        {
          window.open("<?=base_url('home')?>","_self");
        }
      },
      error:function(){
        stop($('#myModal'));
      }
    })
  }
</script>