<?php 
  $msri = $this->approval_lib->msrItem($ed->msr_no);
  $msr = $this->db->where(['msr_no'=>$ed->msr_no])->get('t_msr')->row();
?>
<div class="app-content content">
  <div class="content-wrapper">
    <div class="content-header row">
      <div class="content-header-left col-md-6 col-12 mb-1">
         <h3 class="content-header-title"><?=isset($titleApp) ? $titleApp : '';?></h3>
      </div>
      <div class="content-header-right breadcrumbs-right breadcrumbs-top col-md-6 col-12">
        <div class="breadcrumb-wrapper col-12">
          <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="<?= base_url() ?>/home/">Home</a> </li>
          </ol>
        </div>
      </div>
    </div>
    <div class="content-body">
      <section id="icon-tabs">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-content collapse show">
                <div class="card-body">
                  <form action="<?=base_url('approval/approval/closingopening')?>" class="icons-tab-steps wizard-circle" id="frm-bled">
                    <!-- Step 1 -->
                    <h6><i class="step-icon fa fa-info"></i> Quotation</h6>
                    <?php $this->load->view('award/tab-quotation', ['ed'=>$ed, 't_bl'=>$t_bl])?>

                    <h6><i class="step-icon fa fa-th-list"></i>Evaluation</h6>
                    <?php $this->load->view('award/tab-evaluation', ['blDetails'=>$blDetails])?>
                    <!-- Step 2 -->
                    <h6><i class="step-icon fa fa-th-list"></i>Enquiry Data</h6>
                    <fieldset>
                      <?php $this->load->view('approval/tab_ed_view', ['ed'=>$ed, 'msr'=>$msr]); ?>
                    </fieldset>
                    <!-- Step 3 -->
                    <h6><i class="step-icon fa fa-download"></i>Attachment</h6>
                    <?php $this->load->view('award/tab-attachment', ['doc'=>$doc])?>
                    <!-- step 4 -->
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </div>
    <div class="content-footer text-right">
      <a href="#" class="btn btn-success" data-toggle='modal' data-target='#modal-frm-recomendation' >Award Recomendation </a>
    </div>
  </div>
</div>
<div class="modal fade" id="modal-frm-recomendation" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="myModalLabel">Award Recomendation (<?= $ed->packet == 1 ? 'Itemize':'Packet' ?>)</h4>
        </div>
        <div class="modal-body">
          <form method="post" action="<?=base_url('approval/award/recomendation')?>" class="form-horizontal" id="frm-recomendation">
            <input type="hidden" name="id" id="id" value="<?=$t_bl->bled_no?>">
            <input type="hidden" name="packet" id="packet" value="<?=$ed->packet?>">
            <div class="form-group row">
              <div class="table-responsive">
                <?php if($ed->packet == 1): ?>
                <table class="table table-condensed">
                    <thead>
                      <tr>
                        <th>Item Type</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Total EE Value</th>
                        <th>Select</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $no=1;
                        foreach ($msri->result() as $i) : 
                      ?>
                      <tr>
                        <td><?=$i->id_itemtype?></td>
                        <td><?=$i->qty?></td>
                        <td class="text-right"><?=numIndo($i->priceunit,0)?></td>
                        <td class="text-right"><?=numIndo($i->priceunit*$i->qty,0)?></td>
                        <td>
                          <!-- <input type="radio" name="oke"> -->
                        </td>
                      </tr>
                      <?php 
                        $ms = $this->approval_lib->penHeader($ed->msr_no)->result();
                        foreach ($ms as $bld):  
                      ?>
                      <tr>
                        <td colspan="4"><?=$bld->NAMA?></td>
                        <td><input type="radio" name="msr_item[<?=$i->line_item?>]" value="<?=$bld->vendor_id?>"></td>
                      </tr>
                        <?php endforeach;?>
                      <?php endforeach;?>
                    </tbody>
                </table>
                <?php else: ?>
                  <table class="table table-condensed">
                    <thead>
                      <tr>
                        <th>Vendor Name</th>
                        <th>Check</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php 
                        $ms = $this->approval_lib->penHeader($ed->msr_no)->result();
                        foreach ($ms as $bld):  
                      ?>
                      <tr>
                        <td><?=$bld->NAMA?></td>
                        <td><input required="" type="radio" name="vendor_id" value="<?=$bld->vendor_id?>"></td>
                      </tr>
                        <?php endforeach;?>
                    </tbody>
                  </table>
                <?php endif;?>
              </div>
            </div>
            <div class="form-group">
              <div class="col-sm-12">
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="formSubmitAjax('frm-recomendation')" class="btn btn-success">Yes Continue</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    function formSubmitAjax(frm) {
      var f = $("#"+frm).attr('action');
      $.ajax({
        type: "POST",
        url: f,
        data: $('#'+frm).serialize(),
        beforeSend:function(){
          start($('#modal-'+frm));
        },
        success: function (data) {
          alert(data);
          stop($('#modal-'+frm));
          $('#modal-'+frm).modal('hide');
        },
        error: function (e) {
          alert('Fail, Try Again');
          stop($('#modal-'+frm));
          $('#modal-'+frm).modal('hide');
        }
      })
    }
  </script>