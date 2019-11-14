<?php 
    /*insert to t_msr*/
    $this->load->model('material/M_group', 'material_group');

    $user = user();
    $department = $this->db->where('ID_DEPARTMENT',$user->ID_DEPARTMENT)->get('m_department')->row();
    $t_msr_draft['id_currency_base'] = 3;
    $t_msr_draft['create_by'] = $this->session->userdata('ID_USER');
    $t_msr_draft['create_on'] = date("Y-m-d H:i:s");
    $t_msr_draft['id_department'] = $user->ID_DEPARTMENT;
    $t_msr_draft['department_desc'] = $department->DEPARTMENT_DESC;
    
    $this->db->insert('t_msr_draft', $t_msr_draft);
    $insert_id = $this->db->insert_id();

    $contents = $this->cart->contents();
    foreach ($contents as $r) {
        $amount = $r['price'] * $r['qty'];
        $material = $this->db->where('MATERIAL_CODE', $r['name'])->get('m_material')->row();
        $uom = $material->UOM;
        $uom_id = @$this->db->where('MATERIAL_UOM',$uom)->get('m_material_uom')->row()->ID;
        $t_msr_item_draft['t_msr_draft_id'] = $insert_id;
        $t_msr_item_draft['id_itemtype'] = 'GOODS';
        $t_msr_item_draft['id_itemtype_category'] = 'SEMIC';
        $t_msr_item_draft['material_id'] = $material['MATERIAL'];
        $t_msr_item_draft['semic_no'] = $r['name'];
        $t_msr_item_draft['description'] = $material['MATERIAL_NAME'];
        /*procurement/msr/findItemAttributes?material_id=10000002&type=GOODS&itemtype_category=SEMIC*/
        /*{"type":"GOODS","group_name":"DRILLING AND PRODUCTION (KLASIFKASI)","group_code":"A","subgroup_name":"CASING, TUBING AND ACCESSORIES","subgroup_code":"4","uom_description":"Meters","uom_name":"MT","uom_id":"85","qty_onhand":"","qty_ordered":""}*/
        $material_id = $material['MATERIAL'];
        $type = 'GOODS';
        if ($material_id && $type) {
            if ($result = $this->material_group->findByMaterialAndType($material_id, $type)) {
                $result = $result[0];
                $t_msr_item_draft['groupcat'] = $result['group_code'];
                $t_msr_item_draft['groupcat_desc'] = $result['group_name'];
                $t_msr_item_draft['sub_groupcat'] = $result['subgroup_code'];
                $t_msr_item_draft['sub_groupcat_desc'] = $result['subgroup_name'];
            }
        }
        $t_msr_item_draft['qty'] = $r['qty'];
        $t_msr_item_draft['uom_id'] = $uom_id;
        $t_msr_item_draft['uom'] = $uom;
        $t_msr_item_draft['priceunit'] = $r['price'];
        $t_msr_item_draft['priceunit_base'] = $r['price'];
        $t_msr_item_draft['id_importation'] = 'L';
        $t_msr_item_draft['importation_desc'] = 'Local';
        $t_msr_item_draft['id_dpoint'] = '10101';
        $t_msr_item_draft['dpoint_desc'] = 'Muara Laboh';
        $t_msr_item_draft['id_bplant'] = '10101';
        $t_msr_item_draft['id_costcenter'] = '101032210';
        $t_msr_item_draft['costcenter_desc'] = 'Maintenance';
        $t_msr_item_draft['amount'] = $amount;
        $t_msr_item_draft['amount_base'] = $amount;
        $t_msr_item_draft['inv_type'] = 1;
        $this->db->insert('t_msr_item_draft', $t_msr_item_draft);
    }
?>
<input type="hidden" name="draft_id">
<input type="hidden" name="msr_no">
<input type="hidden" name="company">
<input type="hidden" name="plocation">
<input type="hidden" name="required_date">
<input type="hidden" name="lead_time">
<input type="hidden" name="title">
<input type="hidden" name="pmethod">
<input type="hidden" name="procure_processing_time">
<input type="hidden" name="msr_type" value="MSR01">
<input type="hidden" name="cost_center" value="101034010">
<input type="hidden" name="cost_center_slc2" value="101032210">
<input type="hidden" name="currency" value="3">
<input type="hidden" name="delivery_point">
<input type="hidden" name="importation">
<input type="hidden" name="delivery_term">
<input type="hidden" name="freight">
<input type="hidden" name="requestfor">
<input type="hidden" name="inspection">
<input type="hidden" name="scope_of_work">
<input type="hidden" name="location">
<input type="hidden" name="items-summary">
<?php foreach ($this->cart->contents() as $r) : 
    $qty_required_value = $r->qty;
    $total_value = $unit_price_value * $qty_required_value;
    $material_id = 
?>
<input type="hidden" name="items[<?= $r['rowid'] ?>]">
<input type="hidden" name="items[<?= $r['rowid'] ?>][item_type_value]" value="GOODS">
<input type="hidden" name="items[<?= $r['rowid'] ?>][item_type_name]" value="Goods">
<input type="hidden" name="items[<?= $r['rowid'] ?>][itemtype_category_value]" value="SEMIC">
<input type="hidden" name="items[<?= $r['rowid'] ?>][itemtype_category_name]" value="SEMIC NO">
<input type="hidden" name="items[<?= $r['rowid'] ?>][material_id]" value="<?=$material_id?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][semic_no_value]" value="<?=$r['name']?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][semic_no_name]" value="<?=$semic_no_name?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][group_value]" value="<?=$group_value?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][group_name]" value="<?=$group_name?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][subgroup_value]" value="<?=$subgroup_value?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][subgroup_name]" value="<?=$subgroup_name?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][qty_required_value]" value="<?=$qty_required_value?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][qty_onhand_value]" value="<?=$qty_onhand_value?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][qty_ordered_value]" value="<?=$qty_ordered_value?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][uom_name]" value="<?=$uom_name?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][uom_value]" value="<?=$uom_value?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][uom_description]" value="<?=$uom_description?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][unit_price_value]" value="<?=$unit_price_value?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][total_value]" value="<?=$total_value?>">
<input type="hidden" name="items[<?= $r['rowid'] ?>][currency_value]" value="3">
<input type="hidden" name="items[<?= $r['rowid'] ?>][currency_name]" value="USD">
<input type="hidden" name="items[<?= $r['rowid'] ?>][importation_value]" value="I">
<input type="hidden" name="items[<?= $r['rowid'] ?>][importation_name]" value="Import">
<input type="hidden" name="items[<?= $r['rowid'] ?>][delivery_point_value]" value="10101">
<input type="hidden" name="items[<?= $r['rowid'] ?>][delivery_point_name]" value="Muara Laboh">
<input type="hidden" name="items[<?= $r['rowid'] ?>][cost_center_value]" value="101032210">
<input type="hidden" name="items[<?= $r['rowid'] ?>][cost_center_name]" value="Maintenance">
<input type="hidden" name="items[<?= $r['rowid'] ?>][account_subsidiary_value]" value="">
<input type="hidden" name="items[<?= $r['rowid'] ?>][account_subsidiary_name]" value="">
<input type="hidden" name="items[<?= $r['rowid'] ?>][inv_type_value]" value="1">
<input type="hidden" name="items[<?= $r['rowid'] ?>][inv_type_name]" value="Inventory">
<input type="hidden" name="items[<?= $r['rowid'] ?>][item_modification_value]" value="0">
[importation_value] => I
                    [importation_name] => Import
                    [delivery_point_value] => 10101
                    [delivery_point_name] => Muara Laboh
                    [cost_center_value] => 101032210
                    [cost_center_name] => Maintenance
                    [account_subsidiary_value] => 
                    [account_subsidiary_name] => 
                    [inv_type_value] => 1
                    [inv_type_name] => Inventory
                    [item_modification_value] => 0
<?php endforeach;?>
<?php 
Array
(
    [draft_id] => 
    [msr_no] => 
    [company] => 10103
    [plocation] => PG01
    [required_date] => 2019-10-17
    [lead_time] => 1
    [title] => s
    [pmethod] => DA
    [procure_processing_time] => 30
    [msr_type] => MSR01
    [blanket] => 1
    [cost_center] => 101034010
    [cost_center_slc2] => 101032210
    [currency] => 3
    [delivery_point] => 
    [importation] => 
    [delivery_term] => 
    [freight] => 
    [requestfor] => 
    [inspection] => 
    [scope_of_work] => 
    [location] => 
    [items-summary] => 
    [items] => Array
        (
            [1571189155613] => Array
                (
                    [item_type_value] => GOODS
                    [item_type_name] => Goods
                    [itemtype_category_value] => SEMIC
                    [itemtype_category_name] => SEMIC NO
                    [material_id] => 10000001
                    [semic_no_value] => 87.05.95.100.1
                    [semic_no_name] => FUEL HIGH SPEED DIESEL SOLAR
                    [group_value] => J
                    [group_name] => PAINTS, OILS, CHEMICAL  AND LABORATORY
                    [subgroup_value] => 87
                    [subgroup_name] => OILS AND OIL PRODUCTS.
                    [qty_required_value] => 1
                    [qty_onhand_value] => 0
                    [qty_ordered_value] => 0
                    [uom_name] => LT
                    [uom_value] => 72
                    [uom_description] => Liters
                    [unit_price_value] => 1
                    [total_value] => 1
                    [currency_value] => 3
                    [currency_name] => USD
                    [importation_value] => I
                    [importation_name] => Import
                    [delivery_point_value] => 10101
                    [delivery_point_name] => Muara Laboh
                    [cost_center_value] => 101032210
                    [cost_center_name] => Maintenance
                    [account_subsidiary_value] => 
                    [account_subsidiary_name] => 
                    [inv_type_value] => 1
                    [inv_type_name] => Inventory
                    [item_modification_value] => 0
                )

        )

    [submit-second-aas-approver-id] => 
)