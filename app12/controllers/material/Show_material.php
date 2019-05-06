<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Show_material extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('material/M_show_material')->model('vendor/M_vendor')->model('material/M_mregist_approval');
        $this->load->model('material/M_registration');
        $this->load->model('material/M_material_revision');
        $this->load->helper(array('string', 'text', 'array', 'permission'));
    }

    public function index() {

      $tamp = $this->M_mregist_approval->show();
      $get_menu = $this->M_vendor->menu();
      $get_uom = $this->M_mregist_approval->material_uom();
      $get_mgroup = $this->M_mregist_approval->material_group();
      $get_mindicator = $this->M_mregist_approval->material_indicator();
      $get_mstockclass = $this->M_mregist_approval->m_material_stock_class();
      $get_mavailable = $this->M_mregist_approval->m_material_availability();
      $get_mcritical = $this->M_mregist_approval->m_material_cricatility();
      $get_hazardous = $this->M_mregist_approval->m_hazardous();
      $get_gl_class = $this->M_mregist_approval->m_gl_class();
      $get_project_phase = $this->M_mregist_approval->m_project_phase();
      $get_line_type = $this->M_mregist_approval->m_line_type();
      $get_stocking_type = $this->M_mregist_approval->m_stocking_type();
      $get_stock_class = $this->M_mregist_approval->m_stock_class();
      $get_inventory_type = $this->M_mregist_approval->m_inventory_type();

      $data['total'] = count($tamp);
      $dt = array();
      $res_uom = array();
      $res_mgroup = array();
      $res_mindicator = array();
      $res_mstockclass = array();
      $res_mavailable = array();
      $res_mcritical = array();

      foreach ($get_mcritical as $arr) {
        $res_mcritical[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }
      foreach ($get_mavailable as $arr) {
        $res_mavailable[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mstockclass as $arr) {
        $res_mstockclass[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mindicator as $arr) {
        $res_mindicator[] = array(
          'id' => $arr['ID'],
          'desc_in' => $arr['DESCRIPTION_IND'],
          'desc_en' => $arr['DESCRIPTION_ENG'],
        );
      }

      foreach ($get_mgroup as $arr) {
        $res_mgroup[] = array(
          'id' => $arr['ID'],
          'material_group' => $arr['MATERIAL_GROUP'],
          'material_desc' => $arr['DESCRIPTION'],
          'type' => $arr['TYPE'],
        );
      }

      foreach ($get_uom as $arr) {
        $res_uom[] = array(
          'id' => $arr['ID'],
          'material_uom' => $arr['MATERIAL_UOM'],
          'uom_desc' => $arr['DESCRIPTION'],
        );
      }

      foreach ($get_menu as $k => $v) {
          $dt[$v->PARENT][$v->ID_MENU]['ICON'] = $v->ICON;
          $dt[$v->PARENT][$v->ID_MENU]['URL'] = $v->URL;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_IND'] = $v->DESKRIPSI_IND;
          $dt[$v->PARENT][$v->ID_MENU]['DESKRIPSI_ENG'] = $v->DESKRIPSI_ENG;
      }

      $data['material_criticaly'] = $res_mcritical;
      $data['material_avalable'] = $res_mavailable;
      $data['material_stackclass'] = $res_mstockclass;
      $data['material_uom'] = $res_uom;
      $data['material_group'] = $res_mgroup;
      $data['material_indicator'] = $res_mindicator;
      $data['hazardous'] = $get_hazardous;
      $data['gl_class'] = $get_gl_class;
      $data['project_phase'] = $get_project_phase;
      $data['line_type'] = $get_line_type;
      $data['stocking_type'] = $get_stocking_type;
      $data['stock_class'] = $get_stock_class;
      $data['inventory_type'] = $get_inventory_type;
      $data['menu'] = $dt;
      $this->template->display('material/V_show_material', $data);

    }

    public function output($return = array()) {
        header("Access-Control-Allow-Origin: *");
        header("Content-Type: application/json; charset=UTF-8");
        exit(json_encode($return));
    }

    public function show_material_uom(){
      $result = array();
      $data = $this->M_vendor->material_uom();
      foreach ($data as $val => $arr) {
        $result[] = array(
          'id' => $arr['ID'],
          'material_uom' => $arr['MATERIAL_UOM'],
        );
      }
      echo json_encode($result);
    }

    public function show() {
        $data = $this->M_show_material->show();
        $result = array();
        $no = 1;

        $can_edit = can_create_material_revision();

        if ($can_edit) {
            $open_revision = $this->M_material_revision->getUnEditableMaterial();
            $open_revision = array_pluck($open_revision, 'material');
        }

        foreach ($data as $arr) {
          // $str = '<center><button data-id="'.$arr['MATERIAL'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-primary" title="Update"><i class=""> Detail</i></button></center>';
          // $class = 'primary';

            $edit_btn = '';
            if ($can_edit) {
              $editable = !in_array($arr['MATERIAL'], $open_revision);

              $edit_btn = $editable ?
                  '<a href="'.base_url('material/revision_material/create/'.$arr['MATERIAL']).'" data-role="button" class="btn btn-sm btn-warning">Edit</a>' :
                  '<a href="#" data-role="button" class="btn btn-sm btn-warning disabled" aria-disabled="true" disabled>Edit</a>';
            }

            $str = $edit_btn.'
                <button data-id="'.$arr['MATERIAL'].'" data-status="'.$arr['s_status'].'" id="prosesreq" data-toggle="modal" data-target="#myModal" class="btn btn-sm btn-info" title="Detail">Detail</button>';
          $class = 'success';
          //a.MANUFACTURER_DESCRIPTION,a.UNIT_OF_ISSUE,a.GL_CLASS,a.LINE_TYPE,a.STOCKING_TYPE,a.STOCK_CLASS,a.INVENTORY_TYPE,a.PROJECT_PHASE,a.AVAILABILITY,a.CRITICALITY
          $result[] = array(
            0 => ' '.$no.' ',
            1 => ' '.$arr['MATERIAL_CODE'].' ',
            2 => ' '.$arr['MATERIAL_NAME'].' ',
            3 => ' '.$arr['desc_group'].' ',
            4 => ' '.$arr['SEARCH_TEXT'].' ',
            5 => ' '.$arr['PART_NO'].' ',
            6 => ' '.$arr['MANUFACTURER_DESCRIPTION'].' ',
            7 => ' '.$arr['UNIT_OF_ISSUE'].' ',
            8 => ' '.$arr['UOM'].' ',
            9 => ' '.$arr['GL_CLASS'].' ',
            10 => ' '.$arr['LINE_TYPE'].' ',
            11 => ' '.$arr['STOCKING_TYPE'].' ',
            12 => ' '.$arr['STOCK_CLASS'].' ',
            13 => ' '.$arr['INVENTORY_TYPE'].' ',
            14 => ' '.$arr['PROJECT_PHASE'].' ',
            15 => ' '.$arr['AVAILABILITY'].' ',
            16 => ' '.$arr['CRITICALITY'].' ',
            /*6 => '<center><span class="badge badge badge-pill badge-'.$class.'">'.$arr['status_ind'].'</span></center>',*/
            17 => $str
          );
          $no++;
        }
        echo json_encode($result);
    }
}
