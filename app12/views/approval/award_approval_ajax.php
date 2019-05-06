<?php 
  $listApprovalEd = $this->approval_lib->listApprovalAward($msr_no);
  $no = 1;
  $userLogin = user();
  foreach ($listApprovalEd->result() as $key => $value) {
    $approvalStr = '';
    $approvalDate = '';
    if($value->status == 0){
      $approvalStr = '';
      $approvalDate = '';
    }
    if($value->status == 1){
      $approvalStr = 'Approve';
      $approvalDate = $value->created_at;
    }
    if($value->status == 2){
      $approvalStr = 'Reject';
      $approvalDate = $value->created_at;
    }
    $approveLink = '';
    if($value->created_by == $userLogin->ID_USER and ($value->status == 0 or $value->status == 2))
    {
      $approveLink = "<a href='#' class='btn btn-primary btn-sm' onclick='apprejectmodal($value->id)'>Approve/Reject</a>";
    }
    $desc = '';
    if($value->status == 2 || $value->status == 1)
    {
      $desc = $value->deskripsi;
    }
    echo "<tr>
    <td>$no</td>
    <td>$value->role_name</td>
    <td>$value->user_nama</td>
    <td>$approvalStr</td>
    <td>$approvalDate</td>
    <td>$desc</td>
    <td>$approveLink</td>
    </tr>";
    $no++;
  }
?>