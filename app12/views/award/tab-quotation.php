<?php 
  $msr_no = $ed->msr_no;
?>
<fieldset>
  <h3>Quotation Status</h3>
  <div class="col-md-12">
    <div class="table-responsive">
      <table class="table table-condensed table-striped">
        <tr>
          <td width="200">Invitation Date</td>
          <td>
            <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
              <?=dateToIndo($t_bl->created_at)?>    
            </label>
          </td>
        </tr>
        <tr>
          <td>Pre Bid Date Date</td>
          <td>
            <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px"><?=dateToIndo($ed->prebiddate, false, true)?>
            </label>
          </td>
        </tr>
        <tr>
          <td>Bid Validity</td>
          <td>
            <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
              <?=dateToIndo($ed->bid_validity, false, true)?>
            </label>
          </td>
        </tr>
        <tr>
          <td>Closing Date</td>
          <td>
            <label style="padding: 5px;border-radius: 8px;border: 1px solid #999;background: #aaa;width: 250px">
              <?=dateToIndo($ed->closing_date, false, true)?>
            </label>
          </td>
        </tr>
      </table>
    </div>
  </div>
  <div class="col-md-12">
    <div class="table-responsive">
      <table class="table table-condensed table-striped">
        <thead>
          <tr>
            <th rowspan="2" width="15">NO</th>
            <th rowspan="2">SLKA NO</th>
            <th rowspan="2">Bidder(s) Name</th>
            <th rowspan="2">Submission Date</th>
            <th rowspan="2">Status</th>
            <th colspan="3" class="text-center">Evaluation Status</th>
            <th rowspan="2">Awarded</th>
          </tr>
          <tr>
            <th>Administrative</th>
            <th>Tecnical</th>
            <th>Commercial</th>
          </tr>
        </thead>
        <tbody>
          <?php 
          $no=1;
          foreach ($blDetails->result() as $blDetail) {
            $t_sop_bid = $this->db->where(['vendor_id'=>$blDetail->vendor_id,'msr_no'=>$msr_no])->get('t_sop_bid');
            $numSop = $t_sop_bid->num_rows();
            $awarder = $blDetail->awarder == 0 ? 'Fail':'Award';
            $statusMsg = $blDetail->confirmed == 0 ? "Not Confirmed Yet" : "Confirmed";
            if($numSop > 0)
            {
              $statusMsg = 'Bid Proposal Submitted';
            }
            echo "<tr>
            <td>$no</td>
            <td>$blDetail->no_slka</td>
            <td>$blDetail->vendor_name</td>
            <td>".dateToIndo($blDetail->submission_date)."</td>
            <td>".$statusMsg." <a href='#' data-toggle='modal' data-target='#seequotation$blDetail->id' class='btn btn-sm btn-primary'>See Quotation</a></td>
            <td>".evaluationStatus($blDetail->administrative)."</td>
            <td>".evaluationStatus($blDetail->technical)."</td>
            <td>".evaluationStatus($blDetail->commercial)."</td>
            <td>".$awarder."</td>
            </tr>";
            $no++;
          }
          ?>
        </tbody>
      </table>
    </div>
  </div>
</fieldset>