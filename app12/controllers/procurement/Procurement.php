<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

class Procurement extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_base');
    }

    public function msr_item_json($id) {
        $this->load->model('procurement/ed/m_ed_msr_item');
        $result = $this->m_ed_msr_item->where('line_item', $id)
        ->first();
        if ($result) {
            $response = array(
                'data' => $result
            );
        }
        echo json_encode($response);
    }

    public function po_item_json($semic_no = null) {
        $q = $this->input->get('q');
        $id_item_type = $this->input->get('id_item_type');
        $id_item_type_category = $this->input->get('id_item_type_category');
        $id_po = $this->input->get('id_po');
        if (!$semic_no) {
            if ($id_item_type_category == 'SEMIC') {
                $result = $this->db->select('m_material.MATERIAL as id, m_material.MATERIAL_CODE as code, m_material.MATERIAL_NAME as name')
                ->group_start()
                    ->like('MATERIAL_CODE', $q)
                    ->or_like('MATERIAL_NAME', $q)
                ->group_end()
                ->where('(SELECT COUNT(1) FROM t_approval_material WHERE material_id = m_material.MATERIAL and (status_approve = 0 OR status_approve = 2)) = ', 0)
                ->get('m_material')
                ->result();
            } elseif ($id_item_type_category == 'MATGROUP') {
                $result = $this->db->select('ID as id, DESCRIPTION as name, CONCAT_WS(\'.\', parent, material_group) as code')
                 ->group_start()
                    ->like('CONCAT_WS(\'.\', parent, material_group)', $q)
                    ->or_like('DESCRIPTION', $q)
                ->group_end()
                ->where('type', 'GOODS')
                ->where('CATEGORY', 'GROUP')
                ->get('m_material_group')
                ->result();
            } elseif ($id_item_type_category == 'SERVICE' || $id_item_type_category == 'CONSULTATION' || $id_item_type_category == 'WORKS') {
                if ($id_item_type_category == 'WORKS') {
                    $id_item_type_category = 'SERVICE';
                }
                $result = $this->db->select('ID as id, DESCRIPTION as name, CONCAT_WS(\'.\', parent, material_group) as code')
                 ->group_start()
                    ->like('CONCAT_WS(\'.\', parent, material_group)', $q)
                    ->or_like('DESCRIPTION', $q)
                ->group_end()
                ->where('type', $id_item_type_category)
                ->where('CATEGORY', 'GROUP')
                ->get('m_material_group')
                ->result();
            } else {
                $result = null;
            }
        } else {
            if ($id_item_type_category == 'SEMIC') {
                $result = $this->db->select('m_material.*, category.ID as ID_CATEGORY, category.MATERIAL_GROUP as GROUP_CATEGORY, category.DESCRIPTION as CATEGORY, clasification.ID as ID_CLASSIFICATION, clasification.MATERIAL_GROUP as GROUP_CLASSIFICATION, clasification.DESCRIPTION as CLASSIFICATION')
                ->where('MATERIAL_CODE', $semic_no)
                ->join('m_material_group category', 'category.TYPE = \'GOODS\' AND CAST(LEFT(MATERIAL_CODE, 2) AS SIGNED) = category.MATERIAL_GROUP')
                ->join('m_material_group clasification', 'clasification.TYPE = \'GOODS\' AND clasification.MATERIAL_GROUP = category.PARENT')
                ->get('m_material')
                ->row();
            } else {
                if ($id_item_type_category == 'MATGROUP') {
                    $type = 'GOODS';
                } elseif ($id_item_type_category == 'WORKS') {
                    $type = 'SERVICE';
                } else {
                    $type = $id_item_type_category;
                }
                $result = $this->db->select('category.ID as ID_CATEGORY, category.MATERIAL_GROUP as GROUP_CATEGORY, category.DESCRIPTION as CATEGORY, clasification.ID as ID_CLASSIFICATION, clasification.MATERIAL_GROUP as GROUP_CLASSIFICATION, clasification.DESCRIPTION as CLASSIFICATION')
                ->join('m_material_group clasification', 'clasification.TYPE = \''.$type.'\' AND clasification.MATERIAL_GROUP = category.PARENT')
                ->where('category.TYPE', $type)
                ->WHERE('category.MATERIAL_GROUP =  SUBSTRING_INDEX(SUBSTRING_INDEX(\''.$semic_no.'\',\'.\', 2), \'.\', -1)')
                ->get('m_material_group category')
                ->row();
            }
            if ($id_po) {
                $po_item = $this->db->where('id', $id_po)
                ->where('semic_no', $semic_no)
                ->get('t_purchase_order_detail')
                ->row();
                if ($po_item) {
                    $result->UNIT_PRICE = $po_item->unitprice;
                }
            }
        }
        $response = array();
        if ($result) {
            $response = array(
                'data' => $result
            );
        }
        echo json_encode($response);
    }

    public function uom_json() {
        if ($uom_type = $this->input->get('uom_type')) {
            $result = $this->db->where('UOM_TYPE', $uom_type)
            ->get('m_material_uom')
            ->result();
        } elseif ($semic_no = $this->input->get('semic_no')) {
            $material = $this->db->where('MATERIAL_CODE', $semic_no)
            ->get('m_material')
            ->row();
            if ($material) {
                $result = $this->db->where('MATERIAL_UOM', $material->UNIT_OF_ISSUE)
                ->get('m_material_uom')
                ->result();
            } else {
                $result = null;
            }
        } elseif ($material_id = $this->input->get('material_id')) {
            $material = $this->db->where('MATERIAL', $material_id)
            ->get('m_material')
            ->row();
            if ($material) {
                $result = $this->db->where('MATERIAL_UOM', $material->UNIT_OF_ISSUE)
                ->get('m_material_uom')
                ->result();
            } else {
                $result = null;
            }
        } else {
            $result = null;
        }
        $response = array();
        if ($result) {
            $response = array(
                'data' => $result
            );
        }
        echo json_encode($response);
    }

    public function account_subsidiary_json() {
        if ($id_costcenter = $this->input->get('id_costcenter')) {
            $result = $this->db->where('COSTCENTER', $id_costcenter)
            ->get('m_accsub')
            ->result();
        } else {
            $result = null;
        }
        $response = array();
        if ($result) {
            $response = array(
                'data' => $result
            );
        }
        echo json_encode($response);
    }

    public function costcenter_json() {
        $id_company = $this->input->get('id_company');
        $result = $this->db->where('ID_COMPANY', $id_company)
        ->get('m_costcenter')
        ->result();
        $response = array();
        if ($result) {
            $response = array(
                'data' => $result
            );
        }
        echo json_encode($response);
    }
}