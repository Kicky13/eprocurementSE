<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
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
                        <li class="breadcrumb-item active"><?= lang($title, $title) ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body" id="negobody">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 text-right">
                                <a href="#" onclick="closeAllNego()" class="btn btn-primary">Close All Negotiation</a>
                            </div>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <table class="table table-condensed table-striped">
                                        <thead>
                                            <tr>
                                                <th>Company Letter No</th>
                                                <th>Closing Date</th>
                                                <th>Supporting Document</th>
                                                <th>Note</th>
                                                <th>Request At</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                            $statusNego = [0=>'Unconfirmend',1=>'Confirmed',2=>'Close'];
                                            //print_r($list);
                                            /*<a href="#" data-toggle="modal" data-target="#modal-upload-administrative" class="btn btn-sm btn-primary">Upload </a>*/
                                            foreach ($list as $key => $value) {
                                                $status = $statusNego[$value->status];
                                                echo "<tr>
                                                <td>$value->company_letter_no</td>
                                                <td>".dateToIndo($value->tanggal)."</td>
                                                <td><a target='_blank' class='btn btn-sm btn-info' href='".base_url('upload/arf_nego/'.$value->supporting_document)."'>Download</a></td>
                                                <td>".nl2br($value->note)."</td>
                                                <td>".dateToIndo($value->created_at)."</td>
                                                <td>$status</td>
                                                <td><a href='#' data-toggle=\"modal\" data-target=\"#modal-detail-$value->id\" class='btn btn-info btn-sm'>Detail</a></td>
                                                </tr>";
                                                ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php foreach ($list as $key => $value) {?>
<div class="modal fade" id="modal-detail-<?=$value->id?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Detail Negotiation</h4>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label class="col-md-3">Bid Letter No</label>
                        <label class="col-md-6"><?= $value->bid_letter_no ?></label>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-3">Local Content</label>
                        <label class="col-md-6">
                        <?php 
                            $get_tkdn_type = $this->mvn->get_tkdn_type();
                            foreach ($get_tkdn_type as $tkdn) {
                                if($tkdn->id == $value->id_local_content_type)
                                {
                                    echo $tkdn->name.' '.$value->local_content.'% '."<a href='".base_url('upload/arf_nego/'.$value->local_content_file)."' class='btn btn-info btn-sm'>Download</a>";
                                }
                            }
                        ?>
                        </label>
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-condensed table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Description</th>
                                    <th>Qty</th>
                                    <th>UoM</th>
                                    <th>Currency</th>
                                    <th>Latest Value</th>
                                    <th>Latest Total</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php 
                                $detail = $this->m_arf_nego->detail($value->id)->result();
                                $no=1;
                                $total = 0;
                                foreach ($detail as $k=>$v) {
                                    $qty = $v->qty1;
                                    $uom = $v->uom1;
                                    $price = $v->new_price;
                                    if($v->qty2 > 0)
                                    {
                                      $qty = "QTY1 = ".$v->qty1."<br>QTY2 = ".$v->qty2;
                                      $uom = "UoM1 = ".$v->uom1."<br>UoM2 = ".$v->uom2;
                                      $price_ttl = $v->qty1*$v->qty2*$price;
                                      $total += $price_ttl;
                                    }
                                    else
                                    {
                                      $price_ttl = $v->qty1*$price;
                                      $total += $price_ttl;
                                    }
                                    echo "<tr>
                                    <td>$no</td>
                                    <td>$v->item</td>
                                    <td>$qty</td>
                                    <td>$uom</td>
                                    <td>$value->currency</td>
                                    <td class='text-right'>".numIndo($price)."</td>
                                    <td class='text-right'>".numIndo($price_ttl)."</td>
                                    </tr>";
                                    $no++;
                                }
                            ?>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td colspan="6" class="text-right"><b>Total</b></td>
                                    <td class="text-right"><?= numIndo($total) ?></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
      </div>
    </div>
    </div>
<?php }?>
<script type="text/javascript">
    function closeAllNego() {
        $.ajax({
            type:'post',
            data:{arf_response_id:"<?=$arf_response_id?>"},
            url:"<?= base_url('procurement/arf_nego/close_all_nego') ?>",
            beforeSend:function(){
                start($("#negobody"))
            },
            success:function(data){
                stop($("#negobody"))
                var r = eval("("+data+")");
                if(r.status)
                {
                  swal('Done',r.msg,'success')
                  window.open("<?= base_url('home') ?>","_self");
                }
                else
                {
                  swal('Ooopss',r.msg,'warning')
                }
            },
            error:function(){
                swal('<?= __('warning') ?>','Something went wrong!','warning')
                stop($('#configuration'));
            }
        })
    }
</script>