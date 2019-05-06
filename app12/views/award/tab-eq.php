<fieldset>
    <div class="row">
      <div class="col-md-6">
        <div class="form-group">
          <label for="proposalTitle2">Subject :</label>
          <input disabled="" class="form-control" name="subject" id="subject" value="<?=@$ed->subject?>">
        </div>
        <div class="form-group">
          <label for="emailAddress4">Pre Bid Date :</label>
          <input disabled="" class="form-control dp" id="prebiddate" name="prebiddate" value="<?=@$ed->prebiddate?>">
        </div>
        <div class="form-group">
          <label for="videoUrl2">Pre Bid Location :</label>
          <?=optLocation('prebid_loc', @$ed->prebid_loc, 'disabled')?>
        </div>
        <div class="form-group">
          <label for="emailAddress4">Pre Bid Address :</label>
          <textarea disabled="" class="form-control" id="prebid_address" name="prebid_address"> <?=@$ed->prebid_address?></textarea>
        </div>
        <div class="form-group">
          <label for="emailAddress4">Closing Date :</label>
          <input disabled="" class="form-control dp" id="closing_date" name="closing_date" value="<?=@$ed->closing_date?>">
        </div>
      </div>
      <div class="col-md-6">
        <div class="form-group">
          <label for="jobTitle3">Administration :</label>
          <input disabled="" class="form-control disabled" value="<?=@edOptData('adm',$ed->administration)?>">
        </div>
        <div class="form-group">
          <label for="jobTitle3">Technical Data :</label>
          <input disabled="" class="form-control disabled" value="<?=@edOptData('tech',$ed->technical_data)?>">
        </div>
        <div class="form-group">
          <label for="jobTitle3">Commercial Data :</label>
          <input disabled="" class="form-control disabled" value="<?=@edOptData('com',$ed->commercial_data)?>">
        </div>
        <div class="form-group">
          <label for="jobTitle3">Currency :</label>
          <?=optCurrency('currency', @$ed->currency, 'disabled')?>
        </div>
        <div class="form-group">
          <label for="jobTitle3">Bid Validty :</label>
          <input disabled=""  class="form-control dp" id="bid_validity" name="bid_validity" value="<?=@$ed->bid_validity?>">
        </div>
        <div class="form-group">
          <label for="jobTitle3">Bid Bond :</label>
          <select disabled="" class="form-control" name="bid_bond_type" id="bid_bond_type">
            <option value="1" <?=@$ed->bid_bond_type == 1 ? "selected":""?>>%</option>
            <option value="2" <?=@$ed->bid_bond_type == 2 ? "selected":""?>>Not Applicable</option>
          </select>
          <input disabled="" placeholder="Fill bid here" class="form-control" id="bid_bond"  name="bid_bond" value="<?=@$ed->bid_bond?>">
        </div>
        <div class="form-group">
          <label for="jobTitle3">Bid Bond Validty:</label>
          <input disabled=""  class="form-control dp" id="bid_bond_validity"  name="bid_bond_validity" value="<?=@$ed->bid_bond_validity?>">
        </div>
      </div>
    </div>
</fieldset>