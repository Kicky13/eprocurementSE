<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title">Clarification</h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content-body">
      <section id="configuration">
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="row">
              </div>
              <div class="card-content collapse show">
                <div class="card-body card-dashboard">
									<?php 
										$msr_no = str_replace('OQ', 'OR', $data_id);
										$getBld = $this->vendor_lib->getBld($msr_no);
										// echo $this->db->last_query();
									?>
									<div class="row" id="vnote">
										<div class="col-md-4">
											<div class="panel panel-default">
												<div class="panel-header">
													<h3 class="panel-title">Vendor LIST</h3>
												</div>
												<div class="panel-body">
													<div class="btn-group-vertical" role="group" aria-label="...">
													<?php 
														foreach ($getBld->result() as $bld): 
															// $getNoRead = $this->vendor_lib->getNoRead($bld->vendor_id);
													?>
									  					<button type="button" class="btn btn-default vendor_id" data-id="<?= $bld->vendor_id ?>"><?= $bld->NAMA ?></button>
									  				<?php endforeach;?>
													</div>
												</div>
											</div>
										</div>
										<div class="col-md-8">
											<div class="panel panel-default">
												<div class="panel-header">
													<h3 class="panel-title">MESSAGE</h3>
												</div>
												<div class="panel-body message-vendor">

												</div>
											</div>
											<div class="panel panel-default">
												<div class="panel-body">
													<form class="form-horizontal" id="form-attachment"  method="post" class="form-horizontal" enctype="multipart/form-data">
														<input type="hidden" name="vendor_id_flag" id="vendor_id_flag" value="0">
														<input type="hidden" name="data_id" value="<?=$data_id?>">
														<input type="hidden" name="module_kode" value="bidnote">
														<div class="form-group row">
															<label class="col-md-2">To</label>
															<div class="col-md-3">
																<select class="form-control" name="to" id="to">
																	<option value="0">--All--</option>
																	<?php foreach ($getBld->result() as $bld) {
																		echo "<option value='$bld->vendor_id'>$bld->NAMA</option>";
																	}
																	?>
																</select>
															</div>
														</div>
														<div class="form-group row">
															<div class="col-md-7">
																<input id="description" name="description" class="form-control desc-note" placeholder="Description Here">
															</div>
															<div class="col-md-3">
																<input type="file" name="file_path" class="form-control">
															</div>
															<div class="col-md-2">
																<a href="#" class="btn btn-primary" id="kirim-clarification" onclick="kirim()">Send</a>
															</div>
														</div>
													</form>
												</div>
											</div>
										</div>
										<script type="text/javascript">
											
										</script>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
	</div>
</div>
<script type="text/javascript">
	function kirim() {
		var form = $("#form-attachment")[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?=base_url('note/store_clarification')?>",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend:function(){
              start($('#vnote'));
            },
			success:function(q){
				$("#vnote-table").html(q);
				stop($('#vnote'));
			},
			error: function (e) {
              alert('Fail, Try Again');
              stop($('#vnote'));
            }
        });
		/*$.ajax({
			type:'post',
			data:{data_id:'<?=$data_id?>', module_kode: 'bidnote', description: $("#description").val(), to: $("#to").val(),vendor_id_flag:$("#vendor_id_flag").val()},
			url:"<?=base_url('note/store_clarification')?>",
			beforeSend:function(){
              start($('#vnote'));
            },
			success:function(q){
				$("#vnote-table").html(q);
				stop($('#vnote'));
			},
			error: function (e) {
              alert('Fail, Try Again');
              stop($('#vnote'));
            }
		});*/
	}
	$(document).ready(function(){
		$(".vendor_id").click(function(){
			var vendor_id = $(this).attr('data-id');
			$.ajax({
				url:"<?= base_url('note/clarification_admin') ?>",
				type:"post",
				data:{vendor_id:vendor_id,module_kode:"bidnote",data_id:"<?=$data_id?>"},
				beforeSend:function(){
	              start($('#vnote'));
	            },
				success:function(e){
					$(".message-vendor").html(e);
					$("#vendor_id_flag").val(vendor_id);
					stop($('#vnote'));
				}
			})
		})
	});
</script>