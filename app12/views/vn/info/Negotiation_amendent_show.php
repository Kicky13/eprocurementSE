<link rel="stylesheet" type="text/css" href="<?= base_url() ?>ast11/css/custom/custom.css">
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="content-header-left col-md-6 col-12 mb-1">
                <h3 class="content-header-title"><?= $title ?></h3>
            </div>
            <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
                <div class="breadcrumb-wrapper col-12">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="<?= base_url('vn/info/greetings') ?>">Home</a></li>
                        <li class="breadcrumb-item"><?= $title ?></li>
                    </ol>
                </div>
            </div>
        </div>
        <div class="content-body">
            <section id="configuration">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-content collapse show">
                                <div class="card-body card-dashboard">
                                    <form id="frm" method="post" enctype="multipart/form-data" class="open-this">
                                      <input type="hidden" name="arf_nego_id" value="<?=$model->nego_id?>">
                                        <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-4">Company Letter No</label>
                                                <div class="col-md-8">
                                                  <?= $model->company_letter_no ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Closing Date</label>
                                                <div class="col-md-8">
                                                  <?= dateToIndo($model->nego_date) ?>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Supporting Document</label>
                                                <div class="col-md-8">
                                                    <a href="<?= base_url('upload/arf_nego/'.$model->supporting_document) ?>" target="_blank" class="btn btn-sm btn-info">Download</a>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-4">Note</label>
                                                <div class="col-md-6">
                                                    <?= nl2br($model->note_nego) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group row">
                                                <label class="col-md-3">Bid Letter No</label>
                                                <div class="col-md-9">
                                                    <input class="form-control" value="<?= $model->bid_letter_no ?>" name="bid_letter_no" required="">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3">Local Content</label>
                                                <div class="col-md-3">
                                                    <select name="id_local_content_type" class="form-control">
                                                        <?php 
                                                          foreach($this->mvn->get_tkdn_type() as $tkdn_type) { 
                                                            $selected = $tkdn_type->id == $model->id_local_content_type ? "selected" : "";
                                                        ?>
                                                            <option <?= $selected ?> value="<?= $tkdn_type->id ?>"><?= $tkdn_type->name ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="input-group">
                                                        <input name="local_content" id="local_content" class="form-control" required="" value="<?= $model->local_content ?>" aria-describedby="basic-addon2">
                                                        <span class="input-group-addon" id="basic-addon2">%</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3">&nbsp;</label>
                                                <div class="col-md-9">
                                                    <input type="file" name="local_content_file">
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-md-3">Note</label>
                                                <div class="col-md-9">
                                                    <textarea name="note" class="form-control"><?= $model->note_vendor ?></textarea>
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
                                                                <th colspan="5">&nbsp;</th>
                                                                <th colspan="2" class="text-center">Original</th>
                                                                <th colspan="2" class="text-center">Negotiated</th>
                                                            </tr>
                                                            <tr>
                                                                <th>No</th>
                                                                <th>Description</th>
                                                                <th>QTY</th>
                                                                <th>UoM</th>
                                                                <th>Currency</th>
                                                                <th>Unit Price</th>
                                                                <th>Total</th>
                                                                <th width="15%">Unit Price</th>
                                                                <th width="15%">Unit Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php 
                                                            $no=1;
                                                            $currency = $model->currency;
                                                            $totalOriginal = 0;
                                                            foreach ($detail as $key => $value) {
                                                                $qty = $value->qty1;
                                                                $uom = $value->uom1;
                                                                $old_price = $value->unit_price;
                                                                $total_old_price = $qty*$old_price;
                                                                $newPrice = '';
                                                                
                                                                $totalNewPrice = "<label class='form-control' style='background:#ccc;padding:0.3rem 1rem' id='subtotal_$value->nego_detail_id'>&nbsp;</label>";
                                                                if($value->qty2 > 0)
                                                                {
                                                                  $qty = "QTY1 = ".$value->qty1."<br>QTY2 = ".$value->qty2;
                                                                  $uom = "UoM1 = ".$value->uom1."<br>UoM2 = ".$value->uom2;
                                                                  $total_old_price = ($value->qty1*$value->qty2)*$old_price;
                                                                  $totalOriginal += $total_old_price;
                                                                  $qtynum = $value->qty1*$value->qty2;
                                                                }
                                                                else
                                                                {
                                                                  $totalOriginal += $total_old_price;
                                                                  $qtynum = $value->qty1;
                                                                }
                                                                if($value->is_nego > 0)
                                                                {
                                                                    $newPrice = "<input class='form-control just-number' name='new_price[$value->nego_detail_id]' id='new_price_$value->nego_detail_id' onchange=\"new_price_change('$value->nego_detail_id','$qtynum')\">";
                                                                }
                                                                echo "<tr><td>$no</td><td>$value->item</td><td>$qty</td><td>$uom</td><td>$currency</td><td>".numIndo($old_price)."</td><td>".numIndo($total_old_price)."</td><td>$newPrice</td><td>$totalNewPrice</td></tr>";
                                                                $no++;
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                          <tr>
                                                            <td colspan="5"></td>
                                                            <td>Total</td>
                                                            <td><?= numIndo($totalOriginal) ?></td>
                                                            <td></td>
                                                            <td id="total_sum"></td>
                                                          </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-12 text-right">
                                                <button class="btn btn-primary" type="submit">Response</button>
                                            </div>
                                        </div>
                                    </form>
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
    $(document).ready(function(){
        $('.just-number').number(true, 2, bahasa.thousand_separator, bahasa.decimal_separator);
        $("#frm").submit(function(e){
            e.preventDefault();
            swalConfirm('Submit Confirmation', 'Are you sure to Response Negotiation?', function() {
              var form = $("#frm")[0];
              var data = new FormData(form);
              $.ajax({
                  type: "POST",
                  enctype: 'multipart/form-data',
                  url: "<?=base_url('vn/info/negotiation_amendment/store')?>",
                  data: data,
                  processData: false,
                  contentType: false,
                  cache: false,
                  timeout: 600000,
                  beforeSend:function(){
                    start($('#configuration'));
                  },
                  success: function (data) {
                    console.log(data)
                    stop($('#configuration'));
                    var r = eval("("+data+")");
                    if(r.status)
                    {
                      swal('Done',r.msg,'success')
                      window.open("<?= base_url('vn/info/greetings') ?>","_self");
                    }
                    else
                    {
                      swal('Ooopss',r.msg,'warning')
                    }
                  },
                  error: function (e) {
                    swal('<?= __('warning') ?>','Something went wrong!','warning')
                    stop($('#configuration'));
                  }
              });
            })
            return false;
        })
    })
    function new_price_change(param,qty){
        var price = $("#new_price_"+param).val();
        console.log(price);
        // var res = price.replace(/\./g, "");

        var result = parseInt(qty)*parseInt(price)
        $("#subtotal_"+param).text(numberWithCommas(result))
        total_sum()
      }
      const numberWithCommas = (x) => {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      }
      function total_sum() {
        var total_sum = 0;
        $("[id^=subtotal_]").each(function(){
          var nilai = $(this).text();
          console.log($(this).attr('id'))
          var res = nilai.replace(/\./g, "");
          total_sum += parseInt(res);
        })
        $("#total_sum").text(numberWithCommas(total_sum))
      }
</script>