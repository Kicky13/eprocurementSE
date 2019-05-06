<h6><i class="step-icon fa fa-thumbs-up"></i> <?= isset($issued) ? ' Amendment Data' : 'Amendment Recommendation' ?></h6>
<fieldset>
    <?php if(isset($issued)): ?>
    <?php else:?>
    <div class="row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="form-group">
                <label>Analysis <small style="font-style: italic">(Technical justification and commercial impact for recommending the Amendment)</small></label>
                <?= $this->form->textarea('analysis', @$recom->analysis, 'class="form-control"') ?>
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label>Negotiation</label><br>
                <?= $this->form->radio('nego', 0) ?> No
                <?= $this->form->radio('nego', 1) ?> Yes
            </div>
            <div class="form-group">
                <?= $this->form->textarea('nego_str', @$recom->nego_str, 'class="form-control" style="height:170px;"') ?>
            </div>
        </div>
    </div>
    <div class="row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="form-group">
                <label>Budget Analysis</label>
                <?= $this->form->textarea('budget_analysis', @$recom->budget_analysis, 'class="form-control"') ?>
            </div>
        </div>
    </div>
    <?php endif;?>
    <div class="row amendment_recommendation_tab">
        <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px">
            Agreement Data including this Amendment
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <label class="col-md-3">Original Agreement Value</label>
        <div class="col-md-3">
            <input class="form-control" disabled value="<?=numIndo($arf->amount_po)?>">
        </div>
        <label class="col-md-3">Additional Value</label>
        <div class="col-md-3">
            <input class="form-control" disabled value="<?=numIndo($total)?>">
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <label class="col-md-3">Latest Agreement Value</label>
        <div class="col-md-3">
            <input class="form-control" disabled value="<?=numIndo($arf->amount_po_arf)?>">
        </div>
        <label class="col-md-3">New Agreement Value</label>
        <div class="col-md-3">
            <input class="form-control" disabled value="<?=numIndo($total+$arf->amount_po_arf)?>">
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab" style="margin-top:20px">
        <div class="col-md-6">
            BOD Approval for this Value Amendment Request is required
            <br>
            <input type="radio" name="bod_approval" value="0">
            <label style="bottom: 10px;position: relative;margin-right: 20px;">No</label>
            <input type="radio" name="bod_approval" value="1" checked="">
            <label style="bottom: 10px;position: relative;">Yes, BOD Review Required</label>
        </div>
        <div class="col-md-6">
            Accumulative Amendment
            <br>
            <input type="radio" name="aa" value="0">
            <label style="bottom: 10px;position: relative;margin-right: 20px;">No</label>
            <input type="radio" name="aa" value="1" checked="">
            <label style="bottom: 10px;position: relative;">Yes, requires 1 level up for the Amendment signature as per AAS</label>
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    Original Agreement Period
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                </div>
                <div class="col-md-1 text-center">
                    to
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($po->delivery_date,false,false)?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-6">
                    Additional Time
                </div>
                <div class="col-md-3" style="font-weight: bold">
                    Up to
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($addTime,false,false)?>">
                </div>
            </div>
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    Latest Agreement Period
                    <!--
                    po_date
                     -->
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                </div>
                <div class="col-md-1 text-center">
                    to
                </div>
                <div class="col-md-3">
                    <!--
                        kondisi ammendment
                        max date di t_arf_detail_revision kolom tipe per doc_id
                     -->
                    <input class="form-control" disabled value="<?=dateToIndo($arf->amended_date,false,false)?>">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-5">
                    New Agreement Period
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($po->po_date,false,false)?>">
                </div>
                <div class="col-md-1 text-center">
                    to
                </div>
                <div class="col-md-3">
                    <input class="form-control" disabled value="<?=dateToIndo($newAgreementPeriodTo,false,false)?>">
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px">
            Additional Documents
        </div>
    </div>
    <div class="form-group row amendment_recommendation_tab">
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4">Original Expiry Date</div>
                <div class="col-md-4">Latest Expiry Date</div>
            </div>
            <div class="row">
                <div class="col-md-4">Performance Bond</div>
                <div class="col-md-4"><input class="form-control" disabled ></div>
                <div class="col-md-4"><input class="form-control" disabled value="<?=$new_date_1?>" ></div>
            </div>
            <div class="row">
                <div class="col-md-4">Insurance</div>
                <div class="col-md-4"><input class="form-control" disabled ></div>
                <div class="col-md-4"><input class="form-control" disabled value="<?=$new_date_2?>"></div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="row">
                <div class="col-md-2">Extend</div>
                <div class="col-md-5">New Date</div>
                <div class="col-md-5">Remarks</div>
            </div>
            <div class="row">
                <div class="col-md-2"><input type="checkbox" name="extend1" id="extend1" value="1"></div>
                <div class="col-md-5"><input class="form-control" disabled="" name="new_date_1" id="new_date_1" ></div>
                <div class="col-md-5"><input class="form-control" disabled="" name="remarks_1" id="remarks_1" ></div>
            </div>
            <div class="row">
                <div class="col-md-2"><input type="checkbox" name="extend2" id="extend2" value="1"></div>
                <div class="col-md-5"><input class="form-control" disabled="" name="new_date_2" id="new_date_2" ></div>
                <div class="col-md-5"><input class="form-control" disabled="" name="remarks_2" id="remarks_2" ></div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12" style="font-weight: bold;margin-bottom: 10px">
            Recommendation
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12">
            Based on the above overall analysis, Team is recommending continuing the amendment process by signing the Amendment <b>#6</b> of this Agreement.
        </div>
    </div>
</fieldset>