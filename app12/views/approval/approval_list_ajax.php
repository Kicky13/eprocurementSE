<?php 
	$userLogin = user();
	if($rows->num_rows() > 0): 
		$no = 1; 
		$urutan = []; 
		$s = [];
		foreach ($rows->result() as $row)
		{
			if($row->created_by == $userLogin->ID_USER)
			{
				$s[] = $row;
			}
		}

		foreach ($rows->result() as $row) : 
			$urutan[$row->urutan] = $row->status;
?>
		<tr>
			<td><?=$no++?></td>
			<td><?=$row->role_name?></td>
			<td>
				<?php 
					$user = user($row->created_by);
					echo $user->NAME;
				?>
			</td>
			<td><?=langApproval($row->status)['title']?></td>
			<td>
				<?php 
					if($row->status > 0)
					{
						echo dateToIndo($row->created_at);
					}
					else
					{
						echo "-";
					}
				?>
			</td>
			<td><?=$row->deskripsi?></td>
			<td>
				<?php
					if($row->created_by == $userLogin->ID_USER)
					{
						$t_approval_id = $row->t_approval_id;	
						$m_approval_id = $row->approval_id;	
						if($row->status == 0)
						{
							if($row->urutan == 1)
							{
								$str = "<a href='#' onclick='approveRejectModal($t_approval_id)' class='btn btn-sm btn-primary'>Approve/Reject </a>";
								echo $str;
							}
							else
							{
								$disabled = '';
								if(count($s) > 1)
								{
									foreach ($s as $key => $value) {
										if($value->urutan == $row->urutan)
										{
											#cekStatusSebelumnya
											$cekSebelumnya = $s[$key-1];
											$statusSebelumnya = $cekSebelumnya->status;
											$disabled = $statusSebelumnya == 1 ? "":"disabled";
										}
									}
								}
								$str = "<a href='#' onclick='approveRejectModal($t_approval_id)' class='btn btn-sm btn-primary $disabled'>Approve/Reject</a>";
								echo $str;
							}
						}
						/*if($row->urutan-1 == 0)
						{
							if($row->status <> 1)
							{
								echo "<a href='#' onclick='approveRejectModal($t_approval_id)' class='btn btn-sm btn-primary'>Approve/Reject</a>";
							}
						}
						elseif(@$urutan[$row->urutan-1] == 1 and @$urutan[$row->urutan-1] <> 2)
						{
							if($row->status <> 1)
							{
								echo "<a href='#' onclick='approveRejectModal($t_approval_id)' class='btn btn-sm btn-primary'>Approve/Reject</a>";
							}
						}*/
					}
				?>
			</td>
		</tr>
	<?php endforeach;?>
<?php else:?>
	<tr>
		<td colspan="5" align="center" class="text-center">Tiada data</td>
	</tr>
<?php endif;?>