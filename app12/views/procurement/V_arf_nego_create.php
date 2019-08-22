<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= lang("Negotiation Amendment", "Negotiation Amendment") ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a></li>
                        <li class="breadcrumb-item active"><?= lang("Pengadaan", "Procurement") ?></li>
                        <li class="breadcrumb-item active"><?= lang("Negotiation Amendment", "Negotiation Amendment") ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body" id="t-content">
            <div class="card">
                <div class="card-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table class="table table-condensed">
                                    <tr>
                                        <td>Title</td>
                                        <td width="15">:</td>
                                        <td><?=$list->title?></td>
                                        <td>Company</td>
                                        <td width="15">:</td>
                                        <td><?=$list->company?></td>
                                        <td>Agreement Number</td>
                                        <td width="15">:</td>
                                        <td><?=$list->po_no?></td>
                                    </tr>
                                    <tr>
                                        <td>Supplier</td>
                                        <td width="15">:</td>
                                        <td><?=$list->vendor?></td>
                                        <td>Amendment Value</td>
                                        <td width="15">:</td>
                                        <td><?=numIndo($list->estimated_value)?></td>
                                        <td>Amendment Number</td>
                                        <td width="15">:</td>
                                        <td><?=$list->doc_no?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <form id="frm-create" method="post" enctype="multipart/form-data">
                          <input type="hidden" name="arf_response_id" value="<?= $arf_response_id ?>">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label class="col-md-3">Company/Letter No *</label>
                                        <div class="col-md-6">
                                            <input class="form-control" name="company_letter_no" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">Date *</label>
                                        <div class="col-md-6">
                                            <input class="form-control tanggal" name="tanggal" id="tanggal" required="">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">Supporting Document</label>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="supporting_document" id="supporting_document">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-3">Note</label>
                                        <div class="col-md-6">
                                            <textarea name="note" id="note" class="form-control"></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table class="table table-condensed table-striped">
                                            <thead>
                                                <tr>
                                                    <th class="text-center" width="15">No</th>
                                                    <th class="text-center">Description</th>
                                                    <th class="text-center">QTY</th>
                                                    <th class="text-center">UoM</th>
                                                    <th class="text-center">Currency</th>
                                                    <th class="text-center">Original/Latest</th>
                                                    <th class="text-center">Total</th>
                                                    <th class="text-center">Negotiated</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                $currency = $list->currency;
                                                $subtotal = 0;
                                                // echo "<pre>";
                                                // print_r($sop);
                                                foreach ($sop as $k=>$v) {
                                                    $price = $v->unit_price;
                                                    foreach ($latest_nego['arfNegoDetail'] as $ln) {
                                                        if($ln->arf_sop_id == $v->id)
                                                        {
                                                            $price = $ln->unit_price;
                                                        }
                                                    }
                                                    $qty = $v->qty1;
                                                    $uom = $v->uom1;
                                                    if($v->qty2 > 0)
                                                    {
                                                        $qty = "QTY 1 = $v->qty1 <br> QTY 2 = $v->qty2";
                                                        $uom = "UoM 1 = $v->uom2 <br> UoM 2 = $v->uom2";
                                                    }
                                                    $xQty = $v->qty2 > 0 ? $v->qty2 * $v->qty1 : $v->qty1;
                                                    $key = $k+1;
                                                    $total = $price * $xQty;
                                                    echo "<tr>
                                                    <td>$key</td>
                                                    <td>$v->item</td>
                                                    <td class='text-center'>$qty</td>
                                                    <td class='text-center'>$uom</td>
                                                    <td class='text-center'>$currency</td>
                                                    <td class='text-right'>".numIndo($price)."</td>
                                                    <td class='text-right'>".numIndo($total)."</td>
                                                    <td class='text-center'><input type='checkbox' name='nego[$v->id]' value='$v->id'></td>
                                                    </tr>";
                                                $subtotal += $price;
                                                }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                  <td colspan="4"></td>
                                                  <td class='text-center'>Total</td>
                                                  <td class='text-right'><?=numIndo($subtotal)?></td>
                                                  <td></td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 text-right">
                                    <!-- <button type="button" onclick="kirim()" class="btn btn-primary">Negotiation</button> -->
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/moment-with-locales.min.js"  type="text/javascript"></script>
<script src="<?= base_url() ?>ast11/app-assets/vendors/js/pickers/dateTime/bootstrap-datetimepicker.min.js"  type="text/javascript"></script>
<script type="text/javascript">
  $(function() {
    $('.tanggal').datetimepicker({
      format:'YYYY-MM-DD',
    });
  });
  $(document).ready(function(){
    /*$('.tanggal').datetimepicker({
      format:'YYYY-MM-DD',
    });*/
    $("#frm-create").submit(function(e){
      e.preventDefault();
      swalConfirm('Submit Confirmation', 'Are you sure to Submit Negotiation?', function() {
        var form = $("#frm-create")[0];
        var data = new FormData(form);
        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "<?=base_url('procurement/arf_nego/store')?>",
            data: data,
            processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend:function(){
              start($('#t-content'));
            },
            success: function (data) {
              console.log(data)
              stop($('#t-content'));
              var r = eval("("+data+")");
              if(r.status)
              {
                swal('Done',r.msg,'success')
                window.open("<?= base_url('procurement/arf_nego') ?>","_self");
              }
              else
              {
                swal('Ooopss',r.msg,'warning')
              }
            },
            error: function (e) {
              swal('<?= __('warning') ?>','Something went wrong!','warning')
              stop($('#t-content'));
            }
        });
      })
      return false;
    })
  })
    function kirim() {
        swalConfirm('Submit Confirmation', 'Are you sure to Submit Negotiation?', function() {
          $("#frm-create").submit(function(){
            var form = $("#frm-create")[0];
            var data = new FormData(form);
            $.ajax({
                type: "POST",
                enctype: 'multipart/form-data',
                url: "<?=base_url('procurement/arf_nego/store')?>",
                data: data,
                processData: false,
                contentType: false,
                cache: false,
                timeout: 600000,
                beforeSend:function(){
                  // start($('#t-content'));
                },
                success: function (data) {
                  console.log(data)
                  /*stop($('#t-content'));
                  var r = eval("("+data+")");
                  if(r.status)
                  {
                    swal('Done',r.msg,'success')
                    window.open("<?= base_url('procurement/arf_nego') ?>","_self");
                  }*/
                },
                error: function (e) {
                  swal('<?= __('warning') ?>','Something went wrong!','warning')
                  stop($('#t-content'));
                }
            });
          })
        })
    }
</script>