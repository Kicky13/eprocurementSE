<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Ed extends CI_Controller {

    protected $menu;

    public function __construct() {
        parent::__construct();
        $this->load->library('form');
        $this->load->library('url_generator');
        $this->load->library('redirect');
        $this->load->model('vendor/M_vendor');
        $this->load->model('vendor/M_all_intern', 'mai');

        $this->load->model('m_base');
        $this->load->model('procurement/m_procurement');
        $this->load->model('procurement/m_nego');
        $this->load->model('procurement/ed/m_eq_data');
        $this->load->model('procurement/ed/m_bl_detail');
        $this->load->model('procurement/ed/m_ed_msr_item');
        $this->load->model('procurement/ed/m_sop');
        $this->load->model('procurement/ed/m_sop_bid');
        $this->load->model('procurement/ed/m_log_ed');

        $this->load->helper('data_builder');

        $this->mai->cek_session();
        $get_menu = $this->M_vendor->menu();
        $this->menu = array();
        foreach ($get_menu as $k => $v) {
            $this->menu[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
            $this->menu[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
            $this->menu[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
        }
    }

    public function sop_edit($ed_no) {
        $ed = $this->m_eq_data->view('ed')
        ->scope(array('procurement_specialist'))
        ->where('t_bl.bled_no', $ed_no)
        ->first_or_fail();
        $nego = $this->m_nego->where('msr_no', $ed->msr_no)
        ->where('closed', 0)
        ->first();
        if ($nego) {
            $this->redirect->with('error_message', 'You have to close all negotiation process')
            ->back();
        }
        $ed->msr_item = $this->m_ed_msr_item->where('t_msr_item.msr_no', $ed->msr_no)
        ->get();
        $ed->sop = $this->m_sop->view('sop')->where('t_sop.msr_no', $ed->msr_no)
        ->get();
        $rs_item_type_category = $this->m_procurement->get_item_type_category();
        $item_type_categories = array();
        foreach ($rs_item_type_category as $r_item_type_category) {
            $item_type_categories[$r_item_type_category->itemtype][] = $r_item_type_category;
        }
        $data['item_type_categories'] = $item_type_categories;
        $data['ed'] = $ed;
        $data['menu'] = $this->menu;
        $this->template->display('procurement/V_ed_sop_edit', $data);
    }

    public function sop_update($ed_no) {
        $post = $this->input->post();
        $ed = $this->m_eq_data->view('ed')
        ->scope(array('procurement_specialist'))
        ->where('t_bl.bled_no', $ed_no)
        ->first_or_fail();
        $this->m_log_ed->insert(array(
            'bled_no' => $ed_no,
            'description' => 'Changes SOP on negotiation phase'
        ));
        foreach ($post['sop'] as $sop) {
            if (isset($sop['id'])) {
                if ($sop['deleted'] == 1) {
                    $this->m_sop->delete($sop['id']);
                } else {
                    $this->m_sop->update($sop['id'], $sop);
                }
            } else {
                $sop = $this->m_sop->insert($sop);
                $rs_bl = $this->m_bl_detail->where('msr_no', $ed->msr_no)
                ->get();
                foreach ($rs_bl as $bl) {
                    $this->m_sop_bid->insert(array(
                        'sop_id' => $sop->id,
                        'msr_no' => $ed->msr_no,
                        'vendor_id' => $bl->vendor_id,
                        'id_currency' => $ed->currency,
                        'unit_price' => 0,
                        'id_currency_base' => $ed->currency_base
                    ));
                }
            }
        }

        $response = array(
            'success' => true,
            'message' => 'Successfully saved SOP'
        );
        echo json_encode($response);
    }
}